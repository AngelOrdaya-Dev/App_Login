<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Recibo de Pago - {{ $payment->id }}</title>
    <style>
        body { font-family: 'Helvetica', sans-serif; color: #333; line-height: 1.6; }
        .receipt-box { max-width: 800px; margin: auto; padding: 30px; border: 1px solid #eee; box-shadow: 0 0 10px rgba(0, 0, 0, 0.15); font-size: 16px; }
        .header { display: table; width: 100%; border-bottom: 2px solid #333; padding-bottom: 10px; }
        .header-logo { display: table-cell; vertical-align: middle; }
        .header-info { display: table-cell; text-align: right; vertical-align: middle; }
        .title { color: #f00; font-weight: bold; font-size: 28px; }
        .details { margin: 30px 0; }
        .details table { width: 100%; text-align: left; }
        .details table th { background: #eee; padding: 10px; }
        .details table td { padding: 10px; border-bottom: 1px solid #eee; }
        .total { margin-top: 30px; text-align: right; }
        .total span { font-size: 24px; font-weight: bold; color: #f00; }
        .footer { margin-top: 50px; text-align: center; color: #999; font-size: 12px; }
    </style>
</head>
<body>
    <div class="receipt-box">
        <div class="header">
            <div class="header-logo">
                <span class="title">RECIBO DE PAGO</span><br>
                <span>App_Login Premium</span>
            </div>
            <div class="header-info">
                <strong>Recibo #:</strong> {{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}<br>
                <strong>Fecha:</strong> {{ $payment->created_at->format('d/m/Y') }}<br>
                <strong>Estado:</strong> {{ strtoupper($payment->status) }}
            </div>
        </div>

        <div class="details">
            <table>
                <tr>
                    <th>Estudiante</th>
                    <td>{{ $payment->user->name }}</td>
                </tr>
                <tr>
                    <th>Email</th>
                    <td>{{ $payment->user->email }}</td>
                </tr>
            </table>

            <table style="margin-top: 20px;">
                <tr style="background: #f9f9f9;">
                    <th>Descripción del Concepto</th>
                    <th style="text-align: right;">Monto</th>
                </tr>
                <tr>
                    <td>{{ $payment->description }}</td>
                    <td style="text-align: right;">${{ number_format($payment->amount, 2) }}</td>
                </tr>
            </table>
        </div>

        <div class="total">
            <p>Total Pagado:</p>
            <span>${{ number_format($payment->amount, 2) }}</span>
        </div>

        <div class="footer">
            <p>Gracias por tu pago. Si tienes alguna duda, contacta a soporte@premium.edu</p>
            <p>Este documento es un comprobante válido de transacción electrónica.</p>
        </div>
    </div>
</body>
</html>
