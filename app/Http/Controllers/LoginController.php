<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('login');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            if ($user->two_factor_enabled) {
                $user->generateTwoFactorCode();
                return redirect()->route('verify.index');
            }

            $request->session()->regenerate();
            return redirect()->intended('dashboard')->with('success', 'Bienvenido nuevamente.');
        }

        return back()->withErrors([
            'email' => 'Las credenciales proporcionadas no coinciden con nuestros registros.',
        ])->onlyInput('email');
    }

    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/');
    }

    public function redirectToProvider($provider)
    {
        /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
        $driver = Socialite::driver($provider);
        
        // Usar stateless para evitar errores de sesión/state en entornos como ngrok/móvil
        if (method_exists($driver, 'stateless')) {
            $driver->stateless();
        }

        if ($provider === 'facebook') {
            return $driver->with(['auth_type' => 'reauthenticate'])->redirect();
        }
        return $driver->redirect();
    }

    public function handleProviderCallback($provider)
    {
        try {
            /** @var \Laravel\Socialite\Two\AbstractProvider $driver */
            $driver = Socialite::driver($provider);
            
            if (method_exists($driver, 'stateless')) {
                $driver->stateless();
            }

            $socialUser = $driver->user();
            $providerIdField = $provider . '_id';

            // Buscar usuario por el ID del proveedor o por email
            $user = User::where($providerIdField, $socialUser->getId())
                        ->orWhere('email', $socialUser->getEmail())
                        ->first();

            if ($user) {
                // Actualizar datos existentes
                $user->update([
                    $providerIdField => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);
            } else {
                // Crear nuevo usuario
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuario',
                    'email' => $socialUser->getEmail(),
                    $providerIdField => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'password' => null,
                    'career_id' => null,
                    'terms_accepted' => true
                ]);
            }

            Auth::login($user);

            return redirect()->route('dashboard')->with('success', 'Bienvenido ' . $user->name . '.');
            
        } catch (\Exception $e) {
            \Log::error("Social Auth Error ($provider): " . $e->getMessage());
            $errorMessage = $e->getMessage() ?: 'No se pudo obtener información del proveedor. Intenta nuevamente.';
            return redirect('/login')->with('error', "Error al autenticarse con " . ucfirst($provider) . ": " . $errorMessage);
        }
    }
}
