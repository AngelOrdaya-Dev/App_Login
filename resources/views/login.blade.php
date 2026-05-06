<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: #000;
            background-image: 
                radial-gradient(circle at 0% 0%, rgba(255, 0, 0, 0.12) 0%, transparent 50%),
                radial-gradient(circle at 100% 100%, rgba(255, 0, 0, 0.08) 0%, transparent 50%);
            padding: 1.5rem;
            color: #fff;
        }
        .card {
            width: 100%;
            max-width: 400px;
            background: #111;
            border: 1px solid rgba(255, 255, 255, 0.05);
            border-radius: 16px;
            padding: 3rem 2.5rem;
            box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8);
            animation: fadeIn 0.4s ease-out;
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .card-header {
            text-align: center;
            margin-bottom: 2.5rem;
        }
        .header-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
        h1 { font-size: 1.8rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: -0.5px; }
        .card-header p { color: #888; font-size: 0.95rem; font-weight: 400; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-size: 0.75rem; font-weight: 900; color: #ff0000; margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 1px; }
        input { width: 100%; padding: 1rem 1.2rem; background: #1a1a1a; border: 2px solid #222; border-radius: 12px; color: #fff; font-family: inherit; font-size: 1rem; transition: all 0.2s; outline: none; }
        input:focus { border-color: #ff0000; background: #222; }
        button[type="submit"] { width: 100%; padding: 1.2rem; background-color: #ff0000; border: none; border-radius: 12px; color: #fff; font-size: 1.1rem; font-weight: 900; cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 1px; box-shadow: 0 15px 30px rgba(255, 0, 0, 0.3); margin-bottom: 1rem; }
        button[type="submit"]:hover { background-color: #e60000; transform: translateY(-2px); box-shadow: 0 20px 40px rgba(255, 0, 0, 0.4); }
        .btn-google { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 1.2rem; background-color: #fff; border: none; border-radius: 12px; color: #000; text-decoration: none; font-size: 1.1rem; font-weight: 900; cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 1px; }
        .btn-google:hover { background-color: #f2f2f2; transform: translateY(-2px); box-shadow: 0 20px 40px rgba(255, 255, 255, 0.1); }
        .btn-google img { width: 20px; height: 20px; }
        .divider { display: flex; align-items: center; text-align: center; margin: 1.5rem 0; color: #666; font-size: 0.8rem; text-transform: uppercase; font-weight: 700; letter-spacing: 1px; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #222; }
        .divider::before { margin-right: .5em; }
        .divider::after { margin-left: .5em; }
        .footer-text { text-align: center; margin-top: 2rem; font-size: 0.9rem; color: #444; }
        .footer-text a { color: #888; text-decoration: none; font-weight: 700; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <span class="header-icon">🎓</span>
        <h1>Iniciar Sesión</h1>
        <p>Accede a tu cuenta de estudiante</p>
    </div>
    @if(session('error'))
        <div style="background: #ff0000; border-radius: 8px; padding: 1rem; color: #fff; font-size: 0.95rem; margin-bottom: 2rem; font-weight: 700; text-align: center;">{{ session('error') }}</div>
    @endif
    <form action="{{ url('/login') }}" method="POST">
        @csrf
        <div class="form-group"><label>Dirección de Correo</label><input type="email" name="email" placeholder="ejemplo@universidad.edu" required></div>
        <div class="form-group"><label>Contraseña</label><input type="password" name="password" placeholder="Tu contraseña" required></div>
        <button type="submit">Entrar</button>
    </form>
    <div class="divider">Ingresar con red social</div>
    <a href="{{ route('login.google') }}" class="btn-google"><img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">Google</a>
    <p class="footer-text">¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a></p>
</div>
</body>
</html>
