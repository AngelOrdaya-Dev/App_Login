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

        return $driver->redirect();
    }

    public function handleProviderCallback(Request $request, $provider)
    {
        $code = $request->input('code');
        
        // Si hay un código, verificar si ya se está procesando o se procesó en el último segundo
        if ($code) {
            $cacheKey = 'oauth_code_' . md5($code);
            if (\Cache::has($cacheKey)) {
                // Si ya se procesó, esperar un momento y redirigir al dashboard si ya inició sesión
                usleep(500000); // Esperar 0.5 segundos
                if (Auth::check()) {
                    return redirect()->route('dashboard');
                }
                // Si no se inició sesión en la paralela, buscar al usuario que corresponda al código de la sesión
                $userId = \Cache::get($cacheKey);
                if ($userId && $user = User::find($userId)) {
                    Auth::login($user);
                    return redirect()->route('dashboard');
                }
            }
        }

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
                $updateData = [
                    $providerIdField => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ];
                // Si es el correo del dueño de la app, garantizar rol admin
                $ownerEmail = env('APP_OWNER_EMAIL', 'xdangel755@gmail.com');
                if ($user->email === $ownerEmail && $user->role !== 'admin') {
                    $updateData['role'] = 'admin';
                }
                $user->update($updateData);
            } else {
                // Crear nuevo usuario
                $ownerEmail = env('APP_OWNER_EMAIL', 'xdangel755@gmail.com');
                $role = ($socialUser->getEmail() === $ownerEmail) ? 'admin' : null;
                $user = User::create([
                    'name' => $socialUser->getName() ?? $socialUser->getNickname() ?? 'Usuario',
                    'email' => $socialUser->getEmail(),
                    $providerIdField => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                    'password' => null,
                    'career_id' => null,
                    'terms_accepted' => true,
                    'role' => $role,
                ]);
            }

            Auth::login($user);

            // Guardar en caché que este código ya autenticó con éxito a este usuario por 10 segundos
            if ($code) {
                \Cache::put($cacheKey, $user->id, 10);
            }

            return redirect()->route('dashboard')->with('success', 'Bienvenido ' . $user->name . '.');
            
        } catch (\Exception $e) {
            \Log::error("Social Auth Error ($provider): " . $e->getMessage());

            // Si el código ya fue utilizado, pero ya estamos autenticados en el backend por la petición paralela
            if (Auth::check()) {
                return redirect()->route('dashboard');
            }

            // Si es un error de código usado, comprobar si logramos rescatar al usuario desde la caché en este microsegundo
            if ($code) {
                $userId = \Cache::get('oauth_code_' . md5($code));
                if ($userId && $user = User::find($userId)) {
                    Auth::login($user);
                    return redirect()->route('dashboard');
                }
            }

            $errorMessage = $e->getMessage() ?: 'No se pudo obtener información del proveedor. Intenta nuevamente.';
            return redirect('/login')->with('error', "Error al autenticarse con " . ucfirst($provider) . ": " . $errorMessage);
        }
    }
}
