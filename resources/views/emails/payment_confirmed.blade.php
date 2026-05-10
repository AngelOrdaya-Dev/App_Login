@extends('emails.layout')

@section('content')
    <h2>Confirmación de Pago Recibida</h2>
    <p>Hola <span class="highlight">{{ $user->name }}</span>,</p>
    <p>Te informamos que tu pago ha sido <span class="highlight">Aprobado</span> exitosamente por nuestro departamento administrativo.</p>
    <p><strong>Detalles de la transacción:</strong></p>
    <ul>
        <li>Concepto: Pago de Matrícula / Pensión</li>
        <li>Estado: Validado</li>
        <li>Fecha de validación: {{ now()->format('d/m/Y') }}</li>
    </ul>
    <p>Ya puedes descargar tu comprobante oficial en formato PDF desde la sección de pagos en tu dashboard.</p>
    <a href="{{ url('/pagos') }}" class="button">Ver mis Pagos</a>
    <p style="margin-top: 30px;">Gracias por tu puntualidad.</p>
@endsection
