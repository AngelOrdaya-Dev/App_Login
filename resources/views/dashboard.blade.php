<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard - Panel de Control</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body {
            font-family: 'Roboto', sans-serif;
            min-height: 100vh;
            background-color: #000;
            background-image: 
                radial-gradient(circle at 10% 10%, rgba(255, 0, 0, 0.1) 0%, transparent 40%),
                radial-gradient(circle at 90% 90%, rgba(255, 0, 0, 0.05) 0%, transparent 40%);
            color: #fff;
            padding: 2rem;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 3rem;
            padding-bottom: 1.5rem;
            border-bottom: 1px solid #222;
        }
        .logo {
            font-weight: 900;
            font-size: 1.5rem;
            color: #ff0000;
            letter-spacing: -1px;
            text-transform: uppercase;
        }
        .user-nav {
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }
        .welcome-msg {
            color: #888;
            font-size: 0.9rem;
        }
        .logout-btn {
            background: #222;
            color: #fff;
            padding: 0.6rem 1.2rem;
            border-radius: 8px;
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 700;
            transition: all 0.2s;
            border: 1px solid #333;
        }
        .logout-btn:hover {
            background: #ff0000;
            border-color: #ff0000;
        }
        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(280px, 1fr));
            gap: 2rem;
        }
        .stat-card {
            background: #111;
            padding: 2.5rem;
            border-radius: 16px;
            border: 1px solid #222;
            transition: transform 0.2s;
        }
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: #ff0000;
        }
        .stat-card h3 {
            color: #ff0000;
            font-size: 0.75rem;
            font-weight: 900;
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 1rem;
        }
        .stat-card p {
            font-size: 2rem;
            font-weight: 900;
        }
        .success-banner {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid #ff0000;
            padding: 1rem 1.5rem;
            border-radius: 12px;
            color: #fff;
            margin-bottom: 2rem;
            font-weight: 500;
        }
    </style>
</head>
<body>

<div class="container">
    @if(session('success'))
        <div class="success-banner">
            {{ session('success') }}
        </div>
    @endif

    <header>
        <div class="logo">Academia Dashboard</div>
        <div class="user-nav">
            <span class="welcome-msg">Estudiante: <strong>{{ Auth::user()->name }}</strong></span>
            <a href="{{ route('login') }}" class="logout-btn">Cerrar Sesión</a>
        </div>
    </header>

    <div class="grid">
        <div class="stat-card">
            <h3>Estado Académico</h3>
            <p>Activo</p>
        </div>
        <div class="stat-card">
            <h3>Carrera</h3>
            <p>{{ Auth::user()->career ? Auth::user()->career->name : 'N/A' }}</p>
        </div>
        <div class="stat-card">
            <h3>Créditos</h3>
            <p>120</p>
        </div>
    </div>
</div>

</body>
</html>
