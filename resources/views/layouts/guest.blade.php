<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Autenticación' }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        :root {
            --accent-red: #ff0000;
            --bg-base: #000000;
            --bg-surface: #111111;
            --border-color: #222222;
            --text-main: #ffffff;
            --text-muted: #888888;
        }

        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--bg-base);
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(255, 0, 0, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(255, 0, 0, 0.08) 0%, transparent 50%);
            color: var(--text-main);
            padding: 20px;
        }

        .login-card {
            background-color: var(--bg-surface);
            width: 100%;
            max-width: 450px;
            padding: 40px;
            border-radius: 12px;
            border: 1px solid var(--border-color);
            box-shadow: 0 15px 35px rgba(0,0,0,0.5);
        }

        .login-header { text-align: center; margin-bottom: 30px; }
        .brand { display: flex; align-items: center; justify-content: center; gap: 10px; font-weight: 900; font-size: 1.5rem; margin-bottom: 10px; }
        .brand i { color: var(--accent-red); }
        .login-header p { color: var(--text-muted); font-size: 0.9rem; }

        .input-group { margin-bottom: 20px; }
        .input-group label { display: block; margin-bottom: 8px; font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px; color: var(--text-muted); }
        .input-wrapper { position: relative; }
        .input-wrapper i { position: absolute; left: 15px; top: 50%; transform: translateY(-50%); color: var(--text-muted); }
        .input-wrapper input { width: 100%; background: #000; border: 1px solid var(--border-color); padding: 12px 12px 12px 45px; border-radius: 6px; color: #fff; outline: none; transition: 0.3s; }
        .input-wrapper input:focus { border-color: var(--accent-red); box-shadow: 0 0 10px rgba(255,0,0,0.1); }

        .btn-login { width: 100%; background: var(--accent-red); color: #fff; border: none; padding: 14px; border-radius: 6px; font-weight: 700; cursor: pointer; transition: 0.3s; }
        .btn-login:hover { background: #cc0000; transform: translateY(-2px); }
    </style>
</head>
<body>
    @yield('content')
</body>
</html>
