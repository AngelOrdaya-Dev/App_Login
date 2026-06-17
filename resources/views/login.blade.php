<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Iniciar Sesión | Premier Academy</title>
    <meta name="description" content="Accede a tu cuenta en Premier Academy - El sistema académico más avanzado.">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700;800;900&family=Plus+Jakarta+Sans:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ff0000">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/Logo.jpeg">
    <link rel="icon" type="image/jpeg" href="/Logo.jpeg">
    <link rel="shortcut icon" href="/Logo.jpeg" type="image/x-icon">
    <style>
        :root {
            --red: #ff2d2d;
            --red-dark: #cc0000;
            --red-glow: rgba(255, 45, 45, 0.5);
            --red-soft: rgba(255, 45, 45, 0.12);
            --bg: #050508;
            --surface: rgba(255, 255, 255, 0.04);
            --surface-hover: rgba(255, 255, 255, 0.07);
            --border: rgba(255, 255, 255, 0.08);
            --border-focus: rgba(255, 45, 45, 0.6);
            --text: #ffffff;
            --muted: #888899;
            --ease: cubic-bezier(0.4, 0, 0.2, 1);
        }

        *, *::before, *::after {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
        }

        html, body {
            height: 100%;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background: var(--bg);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            overflow: hidden;
            position: relative;
        }

        /* ── Animated Background ── */
        .bg-scene {
            position: fixed;
            inset: 0;
            z-index: 0;
            overflow: hidden;
        }

        .orb {
            position: absolute;
            border-radius: 50%;
            filter: blur(80px);
            opacity: 0;
            animation: orbFloat 8s ease-in-out infinite;
        }

        .orb-1 {
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255, 30, 30, 0.35) 0%, transparent 70%);
            top: -200px;
            left: -150px;
            animation-delay: 0s;
            animation-duration: 10s;
        }

        .orb-2 {
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(180, 0, 0, 0.25) 0%, transparent 70%);
            bottom: -150px;
            right: -100px;
            animation-delay: -4s;
            animation-duration: 12s;
        }

        .orb-3 {
            width: 350px;
            height: 350px;
            background: radial-gradient(circle, rgba(255, 80, 80, 0.18) 0%, transparent 70%);
            top: 50%;
            left: 60%;
            animation-delay: -2s;
            animation-duration: 9s;
        }

        @keyframes orbFloat {
            0%   { opacity: 0.6; transform: translate(0, 0) scale(1); }
            33%  { opacity: 0.8; transform: translate(30px, -20px) scale(1.05); }
            66%  { opacity: 0.5; transform: translate(-20px, 30px) scale(0.95); }
            100% { opacity: 0.6; transform: translate(0, 0) scale(1); }
        }

        /* Mesh grid overlay */
        .bg-grid {
            position: fixed;
            inset: 0;
            z-index: 0;
            background-image:
                linear-gradient(rgba(255,255,255,0.018) 1px, transparent 1px),
                linear-gradient(90deg, rgba(255,255,255,0.018) 1px, transparent 1px);
            background-size: 60px 60px;
        }

        /* ── Layout ── */
        .login-wrapper {
            position: relative;
            z-index: 10;
            width: 100%;
            max-width: 460px;
            padding: 1.5rem;
            animation: slideUp 0.6s var(--ease) both;
        }

        @keyframes slideUp {
            from { opacity: 0; transform: translateY(32px); }
            to   { opacity: 1; transform: translateY(0); }
        }

        /* ── Card ── */
        .card {
            background: rgba(10, 10, 16, 0.85);
            border: 1px solid rgba(255, 255, 255, 0.09);
            border-radius: 28px;
            padding: 2.8rem 2.6rem 2.4rem;
            backdrop-filter: blur(40px) saturate(180%);
            -webkit-backdrop-filter: blur(40px) saturate(180%);
            box-shadow:
                0 0 0 1px rgba(255, 45, 45, 0.06),
                0 40px 80px rgba(0, 0, 0, 0.7),
                inset 0 1px 0 rgba(255, 255, 255, 0.06);
            position: relative;
            overflow: hidden;
        }

        /* subtle top shine */
        .card::before {
            content: '';
            position: absolute;
            top: 0; left: 10%; right: 10%;
            height: 1px;
            background: linear-gradient(90deg, transparent, rgba(255,45,45,0.5), transparent);
        }

        /* ── Brand Header ── */
        .brand {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 0.8rem;
            margin-bottom: 2.2rem;
            text-align: center;
        }

        .brand-icon {
            width: 72px;
            height: 72px;
            border-radius: 22px;
            background: linear-gradient(135deg, #ff2d2d 0%, #8b0000 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.9rem;
            color: #fff;
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.12),
                0 0 30px rgba(255, 45, 45, 0.45),
                0 16px 32px rgba(0,0,0,0.4);
            position: relative;
            animation: iconPop 0.7s var(--ease) 0.2s both;
        }

        @keyframes iconPop {
            from { opacity: 0; transform: scale(0.7); }
            to   { opacity: 1; transform: scale(1); }
        }

        .brand-icon::after {
            content: '';
            position: absolute;
            inset: -1px;
            border-radius: inherit;
            background: linear-gradient(135deg, rgba(255,255,255,0.18), transparent 60%);
        }

        .brand-name {
            font-family: 'Outfit', sans-serif;
            font-size: 1.65rem;
            font-weight: 800;
            letter-spacing: 0.5px;
            color: #fff;
            line-height: 1;
        }

        .brand-sub {
            font-size: 0.78rem;
            color: var(--red);
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
        }

        .brand-tagline {
            font-size: 0.88rem;
            color: var(--muted);
            margin-top: 2px;
        }

        /* ── Error Alert ── */
        .alert-error {
            background: rgba(255, 45, 45, 0.1);
            border: 1px solid rgba(255, 45, 45, 0.35);
            border-radius: 14px;
            padding: 0.9rem 1.1rem;
            color: #ff7070;
            font-size: 0.875rem;
            font-weight: 600;
            margin-bottom: 1.6rem;
            display: flex;
            align-items: flex-start;
            gap: 0.7rem;
            animation: shakeX 0.4s var(--ease);
        }

        @keyframes shakeX {
            0%,100% { transform: translateX(0); }
            25%      { transform: translateX(-6px); }
            75%      { transform: translateX(6px); }
        }

        .alert-error ul { list-style: none; padding: 0; margin: 0; }
        .alert-error li + li { margin-top: 4px; }

        /* ── Form ── */
        .form-group {
            margin-bottom: 1.3rem;
        }

        label {
            display: block;
            font-size: 0.72rem;
            font-weight: 700;
            color: var(--muted);
            margin-bottom: 0.55rem;
            text-transform: uppercase;
            letter-spacing: 1.2px;
            transition: color 0.2s;
        }

        .input-wrap {
            position: relative;
        }

        .input-icon {
            position: absolute;
            left: 1rem;
            top: 50%;
            transform: translateY(-50%);
            color: var(--muted);
            font-size: 0.9rem;
            transition: color 0.25s;
            pointer-events: none;
        }

        input[type="email"],
        input[type="password"],
        input[type="text"] {
            width: 100%;
            padding: 0.95rem 1.1rem 0.95rem 2.8rem;
            background: rgba(255, 255, 255, 0.04);
            border: 1.5px solid rgba(255, 255, 255, 0.1);
            border-radius: 14px;
            color: var(--text);
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-size: 0.95rem;
            outline: none;
            transition: border-color 0.25s, background 0.25s, box-shadow 0.25s;
        }

        input:focus {
            border-color: var(--border-focus);
            background: rgba(255, 45, 45, 0.05);
            box-shadow: 0 0 0 3px rgba(255, 45, 45, 0.12), 0 4px 16px rgba(0,0,0,0.2);
        }

        input:focus + .input-ring { opacity: 1; }

        .form-group:focus-within label { color: var(--red); }
        .form-group:focus-within .input-icon { color: var(--red); }

        input::placeholder { color: rgba(255,255,255,0.2); }

        /* Password toggle */
        .pw-toggle {
            position: absolute;
            right: 1rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            color: var(--muted);
            cursor: pointer;
            padding: 4px;
            font-size: 0.85rem;
            transition: color 0.2s;
        }
        .pw-toggle:hover { color: var(--text); }

        /* ── Submit Button ── */
        .btn-submit {
            width: 100%;
            padding: 1.05rem;
            background: linear-gradient(135deg, #ff2d2d 0%, #cc1010 50%, #e02020 100%);
            border: none;
            border-radius: 14px;
            color: #fff;
            font-family: 'Outfit', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            cursor: pointer;
            position: relative;
            overflow: hidden;
            transition: transform 0.2s var(--ease), box-shadow 0.2s var(--ease);
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.12),
                0 8px 24px rgba(255, 45, 45, 0.45),
                0 2px 6px rgba(0,0,0,0.4);
            margin-top: 0.4rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }

        .btn-submit::before {
            content: '';
            position: absolute;
            top: 0; left: -100%;
            width: 100%; height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.18), transparent);
            transition: left 0.55s ease;
        }

        .btn-submit:hover::before { left: 100%; }

        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow:
                0 0 0 1px rgba(255,255,255,0.16),
                0 14px 32px rgba(255, 45, 45, 0.6),
                0 4px 10px rgba(0,0,0,0.5);
        }

        .btn-submit:active {
            transform: translateY(0);
            box-shadow: 0 4px 12px rgba(255, 45, 45, 0.35);
        }

        /* ── Divider ── */
        .divider {
            display: flex;
            align-items: center;
            gap: 1rem;
            margin: 1.6rem 0;
            color: rgba(255,255,255,0.2);
            font-size: 0.72rem;
            font-weight: 700;
            letter-spacing: 1.5px;
            text-transform: uppercase;
        }

        .divider::before,
        .divider::after {
            content: '';
            flex: 1;
            height: 1px;
            background: rgba(255,255,255,0.07);
        }

        /* ── Social Buttons ── */
        .social-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 10px;
            margin-bottom: 1.6rem;
        }

        .btn-social {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 7px;
            padding: 0.8rem 0.5rem;
            border-radius: 14px;
            font-size: 0.8rem;
            font-weight: 700;
            text-decoration: none;
            border: 1.5px solid var(--border);
            background: var(--surface);
            color: var(--text);
            transition: all 0.25s var(--ease);
            letter-spacing: 0.3px;
            white-space: nowrap;
        }

        .btn-social img {
            width: 18px;
            height: 18px;
            flex-shrink: 0;
        }

        .btn-social:hover {
            background: var(--surface-hover);
            transform: translateY(-2px);
        }

        .btn-social.google:hover  { border-color: rgba(234,67,53,0.5); box-shadow: 0 6px 20px rgba(234,67,53,0.2); }
        .btn-social.facebook:hover{ border-color: rgba(24,119,242,0.5); box-shadow: 0 6px 20px rgba(24,119,242,0.2); }
        .btn-social.github:hover  { border-color: rgba(255,255,255,0.3); box-shadow: 0 6px 20px rgba(255,255,255,0.08); }

        /* ── Footer Link ── */
        .footer-text {
            text-align: center;
            font-size: 0.87rem;
            color: var(--muted);
        }

        .footer-text a {
            color: var(--red);
            text-decoration: none;
            font-weight: 700;
            transition: opacity 0.2s;
        }

        .footer-text a:hover { opacity: 0.75; }

        /* ── Back Link ── */
        .back-link {
            display: flex;
            align-items: center;
            gap: 7px;
            font-size: 0.8rem;
            font-weight: 600;
            color: var(--muted);
            text-decoration: none;
            transition: color 0.2s;
            margin-bottom: 1.5rem;
            width: fit-content;
        }

        .back-link:hover { color: var(--text); }
        .back-link i { font-size: 0.75rem; }

        /* ── Responsive ── */
        @media (max-width: 480px) {
            .card { padding: 2.2rem 1.6rem 2rem; border-radius: 22px; }
            .social-grid { grid-template-columns: 1fr; }
            .btn-social { justify-content: center; }
        }
    </style>
</head>

<body>
    <!-- Animated Background -->
    <div class="bg-scene">
        <div class="orb orb-1"></div>
        <div class="orb orb-2"></div>
        <div class="orb orb-3"></div>
    </div>
    <div class="bg-grid"></div>

    <div class="login-wrapper">
        <a href="{{ url('/') }}" class="back-link">
            <i class="fas fa-chevron-left"></i> Volver al inicio
        </a>

        <div class="card">
            <!-- Brand -->
            <div class="brand">
                <div class="brand-icon">
                    <i class="fas fa-graduation-cap"></i>
                </div>
                <div>
                    <div class="brand-name">PREMIER</div>
                    <div class="brand-sub">Academy</div>
                </div>
                <p class="brand-tagline">Bienvenido de vuelta — accede a tu cuenta</p>
            </div>

            <!-- Error Messages -->
            @if($errors->any())
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-top:2px; flex-shrink:0;"></i>
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif
            @if(session('error'))
            <div class="alert-error">
                <i class="fas fa-exclamation-circle" style="margin-top:2px; flex-shrink:0;"></i>
                <span>{{ session('error') }}</span>
            </div>
            @endif

            <!-- Login Form -->
            <form action="{{ url('/login') }}" method="POST" id="login-form">
                @csrf

                <div class="form-group">
                    <label for="email">Correo Electrónico</label>
                    <div class="input-wrap">
                        <i class="fas fa-envelope input-icon"></i>
                        <input
                            type="email"
                            id="email"
                            name="email"
                            placeholder="ejemplo@correo.com"
                            value="{{ old('email') }}"
                            required
                            autocomplete="email"
                        >
                    </div>
                </div>

                <div class="form-group">
                    <label for="password">Contraseña</label>
                    <div class="input-wrap">
                        <i class="fas fa-lock input-icon"></i>
                        <input
                            type="password"
                            id="password"
                            name="password"
                            placeholder="••••••••••••"
                            required
                            autocomplete="current-password"
                        >
                        <button type="button" class="pw-toggle" id="pw-toggle" aria-label="Mostrar contraseña">
                            <i class="fas fa-eye" id="pw-icon"></i>
                        </button>
                    </div>
                </div>

                <button type="submit" class="btn-submit" id="btn-submit">
                    <i class="fas fa-sign-in-alt"></i>
                    Iniciar Sesión
                </button>
            </form>

            <!-- Divider -->
            <div class="divider">o continúa con</div>

            <!-- Social Logins -->
            <div class="social-grid">
                <a href="{{ route('social.redirect', 'google') }}" class="btn-social google">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google">
                    Google
                </a>
                <a href="{{ route('social.redirect', 'facebook') }}" class="btn-social facebook">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/b/b8/2021_Facebook_icon.svg" alt="Facebook">
                    Facebook
                </a>
                <a href="{{ route('social.redirect', 'github') }}" class="btn-social github">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/9/91/Octicons-mark-github.svg" alt="GitHub" style="filter:invert(1);">
                    GitHub
                </a>
            </div>

            <!-- Register Link -->
            <p class="footer-text">
                ¿No tienes cuenta? <a href="{{ route('register') }}">Regístrate aquí</a>
            </p>
        </div>
    </div>

    <!-- PWA -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }

        // Password toggle
        const pwToggle = document.getElementById('pw-toggle');
        const pwInput  = document.getElementById('password');
        const pwIcon   = document.getElementById('pw-icon');
        if (pwToggle) {
            pwToggle.addEventListener('click', () => {
                const isHidden = pwInput.type === 'password';
                pwInput.type = isHidden ? 'text' : 'password';
                pwIcon.className = isHidden ? 'fas fa-eye-slash' : 'fas fa-eye';
            });
        }

        // Button loading state
        const form = document.getElementById('login-form');
        const btn  = document.getElementById('btn-submit');
        if (form && btn) {
            form.addEventListener('submit', () => {
                btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Verificando...';
                btn.style.opacity = '0.85';
                btn.disabled = true;
            });
        }
    </script>
</body>
</html>