@extends('emails.layout')

@section('content')
    <h2>¡Bienvenido a la Excelencia Académica!</h2>
    <p>Hola <span class="highlight">{{ $user->name }}</span>,</p>
    <p>Es un placer darte la bienvenida oficial a <strong>Premier Academy</strong>. Tu cuenta ha sido creada exitosamente y ya puedes acceder a todas nuestras herramientas digitales.</p>
    <p>En tu panel podrás encontrar:</p>
    <ul>
        <li>Tus horarios actualizados.</li>
        <li>Control de notas y asistencias.</li>
        <li>Gestión de pagos y trámites.</li>
    </ul>
    <p>Estamos comprometidos con tu éxito profesional. Haz clic en el botón de abajo para comenzar tu viaje:</p>
    <a href="{{ url('/login') }}" class="button">Iniciar Sesión</a>
    <p style="margin-top: 30px;">¡Muchos éxitos en este ciclo académico!</p>
@endsection
