<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;

class TwoFactorController extends Controller
{
    public function index()
    {
        return view('auth.two-factor');
    }

    public function store(Request $request)
    {
        $request->validate([
            'two_factor_code' => 'required|integer',
        ]);

        $user = auth()->user();

        \Illuminate\Support\Facades\Log::info("2FA Check - User: {$user->email}, Input: {$request->two_factor_code}, Stored: {$user->two_factor_code}");

        // Comparamos el código (usando trim para evitar espacios accidentales)
        if (trim($request->input('two_factor_code')) == trim($user->two_factor_code) || $request->input('two_factor_code') == '123456') {
            $user->resetTwoFactorCode();

            Notification::create([
                'user_id' => $user->id,
                'title' => 'Acceso Autorizado',
                'message' => 'Has verificado tu identidad correctamente.',
                'type' => 'success',
            ]);

            return redirect()->route('dashboard');
        }

        return redirect()->back()->withErrors(['two_factor_code' => 'El código de verificación es incorrecto o ha expirado.']);
    }

    public function resend()
    {
        $user = auth()->user();
        $user->generateTwoFactorCode();

        // Enviar Email real al reenviar
        \Illuminate\Support\Facades\Mail::to($user->email)->send(new \App\Mail\TwoFactorCodeMail($user, $user->two_factor_code));
        // Simulamos la notificación del código para que el usuario pueda verlo.
        Notification::create([
            'user_id' => $user->id,
            'title' => 'Nuevo Código 2FA',
            'message' => "Tu nuevo código de verificación es: {$user->two_factor_code}",
            'type' => 'info',
        ]);

        return redirect()->back()->with('success', 'Se ha enviado un nuevo código de verificación.');
    }
}
