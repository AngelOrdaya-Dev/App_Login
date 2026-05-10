<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        body { font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f4f4f4; margin: 0; padding: 0; }
        .container { max-width: 600px; margin: 20px auto; background-color: #ffffff; border-radius: 12px; overflow: hidden; box-shadow: 0 4px 15px rgba(0,0,0,0.1); }
        .header { background-color: #080808; padding: 30px; text-align: center; border-bottom: 3px solid #ff3e3e; }
        .header h1 { color: #ffffff; margin: 0; font-size: 24px; letter-spacing: 2px; }
        .content { padding: 40px; color: #333333; line-height: 1.6; }
        .footer { background-color: #f9f9f9; padding: 20px; text-align: center; font-size: 12px; color: #777777; border-top: 1px solid #eeeeee; }
        .button { display: inline-block; padding: 12px 30px; background-color: #ff3e3e; color: #ffffff !important; text-decoration: none; border-radius: 6px; font-weight: bold; margin-top: 20px; }
        .highlight { color: #ff3e3e; font-weight: bold; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>PREMIER ACADEMY</h1>
        </div>
        <div class="content">
            @yield('content')
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} Panel Premier Academy. Todos los derechos reservados.<br>
            Este es un correo automático, por favor no respondas a este mensaje.
        </div>
    </div>
</body>
</html>
