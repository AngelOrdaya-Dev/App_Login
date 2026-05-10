@extends('emails.layout')

@section('content')
    <h2>Verificación de Seguridad</h2>
    <p>Hola <span class="highlight">{{ $user->name }}</span>,</p>
    <p>Has solicitado acceder a tu cuenta. Por favor, utiliza el siguiente código de verificación para completar el proceso de inicio de sesión:</p>
    <div style="background-color: #f4f4f4; padding: 20px; text-align: center; border-radius: 8px; margin: 20px 0;">
        <span style="font-size: 32px; font-weight: 800; letter-spacing: 10px; color: #ff3e3e;">{{ $code }}</span>
    </div>
    <p>Este código expirará en <span class="highlight">10 minutos</span>. Si no has intentado iniciar sesión, por favor ignora este mensaje y asegura tu cuenta.</p>
    <p style="margin-top: 30px;">Seguridad Premier Academy.</p>
@endsection
