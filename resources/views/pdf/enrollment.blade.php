<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Ficha de Matrícula - {{ $enrollment->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .header { text-align: center; border-bottom: 2px solid #f00; padding-bottom: 10px; margin-bottom: 30px; }
        .header h1 { margin: 0; color: #f00; font-size: 24px; text-transform: uppercase; }
        .header p { margin: 5px 0; color: #666; font-size: 14px; }
        .section-title { background: #f4f4f4; padding: 8px 15px; font-weight: bold; margin-bottom: 15px; border-left: 5px solid #f00; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 20px; }
        table td { padding: 8px; vertical-align: top; }
        .label { font-weight: bold; color: #555; width: 30%; }
        .footer { position: fixed; bottom: 0; width: 100%; text-align: center; font-size: 10px; color: #999; border-top: 1px solid #eee; padding-top: 10px; }
        .status-badge { display: inline-block; padding: 5px 15px; border-radius: 20px; font-weight: bold; font-size: 12px; }
        .approved { background: #dff0d8; color: #3c763d; }
        .pending { background: #fcf8e3; color: #8a6d3b; }
    </style>
</head>
<body>
    <div class="header">
        <h1>Constancia de Inscripción</h1>
        <p>Institución Educativa Premium | Sistema de Matrícula Digital</p>
        <p>Fecha de Emisión: {{ date('d/m/Y H:i') }}</p>
    </div>

    <div class="section-title">Datos del Estudiante</div>
    <table>
        <tr>
            <td class="label">Nombre Completo:</td>
            <td>{{ $enrollment->user->name }}</td>
        </tr>
        <tr>
            <td class="label">Correo Electrónico:</td>
            <td>{{ $enrollment->user->email }}</td>
        </tr>
        <tr>
            <td class="label">Código de Usuario:</td>
            <td>#USR-{{ str_pad($enrollment->user->id, 4, '0', STR_PAD_LEFT) }}</td>
        </tr>
    </table>

    <div class="section-title">Detalles Académicos</div>
    <table>
        <tr>
            <td class="label">Carrera:</td>
            <td>{{ $enrollment->career->name }}</td>
        </tr>
        <tr>
            <td class="label">Tipo de Trámite:</td>
            <td>{{ ucfirst($enrollment->type) }}</td>
        </tr>
        <tr>
            <td class="label">Estado de Solicitud:</td>
            <td>
                <span class="status-badge {{ $enrollment->status }}">
                    {{ strtoupper($enrollment->status) }}
                </span>
            </td>
        </tr>
        <tr>
            <td class="label">Nro. de Solicitud:</td>
            <td>INS-{{ str_pad($enrollment->id, 5, '0', STR_PAD_LEFT) }}</td>
        </tr>
    </table>

    <div style="margin-top: 50px; text-align: center;">
        <div style="width: 200px; border-top: 1px solid #333; margin: 0 auto;"></div>
        <p style="font-size: 12px;">Sello Digital de la Institución</p>
        <p style="font-size: 10px; color: #999;">Esta es una copia digital oficial. Verifique su autenticidad mediante el código QR de seguridad.</p>
    </div>

    <div class="footer">
        © {{ date('Y') }} App_Login Premium. Todos los derechos reservados.
    </div>
</body>
</html>
