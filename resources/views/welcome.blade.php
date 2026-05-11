<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Educación de Élite | Panel Premier</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;800&family=Plus+Jakarta+Sans:wght@300;400;600;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link rel="icon" type="image/jpeg" href="/Logo.jpeg">
    <link rel="shortcut icon" href="/Logo.jpeg" type="image/x-icon">
    <style>
        :root {
            --accent-red: #ff3e3e;
            --accent-red-glow: rgba(255, 62, 62, 0.5);
            --bg-dark: #080808;
            --bg-card: #121214;
            --text-main: #ffffff;
            --text-muted: #a0a0a0;
            --border-light: rgba(255, 255, 255, 0.08);
            --transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: var(--bg-dark);
            color: var(--text-main);
            overflow-x: hidden;
            line-height: 1.6;
        }

        h1, h2, h3 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
        }

        /* Navbar */
        nav {
            position: fixed;
            top: 0;
            width: 100%;
            padding: 1.5rem 5%;
            display: flex;
            justify-content: space-between;
            align-items: center;
            z-index: 1000;
            background: rgba(8, 8, 8, 0.8);
            backdrop-filter: blur(20px);
            border-bottom: var(--border-light);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 12px;
            text-decoration: none;
            color: white;
        }

        .logo i {
            font-size: 1.8rem;
            color: var(--accent-red);
            filter: drop-shadow(0 0 10px var(--accent-red-glow));
        }

        .logo-text span:first-child {
            font-weight: 800;
            font-size: 1.4rem;
            letter-spacing: 1px;
        }

        .logo-text span:last-child {
            display: block;
            font-size: 0.7rem;
            color: var(--accent-red);
            font-weight: 700;
            letter-spacing: 3px;
            margin-top: -5px;
        }

        .nav-links {
            display: flex;
            gap: 2.5rem;
            align-items: center;
        }

        .nav-links a {
            text-decoration: none;
            color: var(--text-muted);
            font-weight: 600;
            font-size: 0.95rem;
            transition: var(--transition);
        }

        .nav-links a:hover {
            color: white;
        }

        .btn-login {
            background: white;
            color: black;
            padding: 10px 25px;
            border-radius: 50px;
            font-weight: 700;
            text-decoration: none;
            transition: var(--transition);
            border: 2px solid white;
        }

        .btn-login:hover {
            background: transparent;
            color: white;
            box-shadow: 0 0 20px rgba(255, 255, 255, 0.2);
        }

        /* Hero Section */
        .hero {
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            padding: 0 5%;
            overflow: hidden;
            background: url('/hero_education_premium_1778355360150.png') no-repeat center center/cover;
        }

        .hero::after {
            content: '';
            position: absolute;
            inset: 0;
            background: radial-gradient(circle at center, rgba(8, 8, 8, 0.4) 0%, rgba(8, 8, 8, 0.95) 100%);
            z-index: 1;
        }

        .hero-content {
            position: relative;
            z-index: 2;
            text-align: center;
            max-width: 900px;
        }

        .badge-premium {
            display: inline-flex;
            align-items: center;
            gap: 8px;
            background: rgba(255, 62, 62, 0.1);
            color: var(--accent-red);
            padding: 8px 16px;
            border-radius: 50px;
            font-weight: 700;
            font-size: 0.8rem;
            letter-spacing: 2px;
            text-transform: uppercase;
            border: 1px solid rgba(255, 62, 62, 0.2);
            margin-bottom: 2rem;
            animation: fadeInUp 0.8s ease-out;
        }

        .hero-title {
            font-size: clamp(3rem, 8vw, 5.5rem);
            line-height: 1;
            margin-bottom: 1.5rem;
            background: linear-gradient(to bottom, #fff 40%, #888 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: fadeInUp 1s ease-out 0.2s backwards;
        }

        .hero-desc {
            font-size: 1.2rem;
            color: var(--text-muted);
            max-width: 600px;
            margin: 0 auto 3rem;
            animation: fadeInUp 1s ease-out 0.4s backwards;
        }

        .hero-btns {
            display: flex;
            gap: 20px;
            justify-content: center;
            animation: fadeInUp 1s ease-out 0.6s backwards;
        }

        .btn-primary {
            background: var(--accent-red);
            color: white;
            padding: 16px 35px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 10px;
            transition: var(--transition);
            box-shadow: 0 10px 30px rgba(255, 62, 62, 0.3);
        }

        .btn-primary:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 40px rgba(255, 62, 62, 0.5);
        }

        .btn-outline {
            background: transparent;
            color: white;
            padding: 16px 35px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            border: 1px solid var(--border-light);
            transition: var(--transition);
        }

        .btn-outline:hover {
            background: rgba(255, 255, 255, 0.05);
            border-color: white;
        }

        /* Features Section */
        .section {
            padding: 100px 5%;
        }

        .section-header {
            text-align: center;
            margin-bottom: 80px;
        }

        .section-tag {
            color: var(--accent-red);
            font-weight: 700;
            letter-spacing: 3px;
            text-transform: uppercase;
            font-size: 0.8rem;
            display: block;
            margin-bottom: 1rem;
        }

        .section-title {
            font-size: 3rem;
            margin-bottom: 1.5rem;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 30px;
        }

        .feature-card {
            background: var(--bg-card);
            border: 1px solid var(--border-light);
            padding: 40px;
            border-radius: 24px;
            transition: var(--transition);
            position: relative;
            overflow: hidden;
        }

        .feature-card:hover {
            border-color: var(--accent-red);
            transform: translateY(-10px);
        }

        .feature-icon {
            width: 60px;
            height: 60px;
            background: rgba(255, 62, 62, 0.1);
            border-radius: 16px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--accent-red);
            font-size: 1.8rem;
            margin-bottom: 1.5rem;
        }

        .feature-title {
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .feature-desc {
            color: var(--text-muted);
            font-size: 0.95rem;
        }

        /* Stats Section */
        .stats {
            background: #000;
            padding: 80px 5%;
            border-top: var(--border-light);
            border-bottom: var(--border-light);
        }

        .stats-container {
            max-width: 1200px;
            margin: 0 auto;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 40px;
            text-align: center;
        }

        .stat-item h3 {
            font-size: 3.5rem;
            color: white;
            margin-bottom: 0.5rem;
        }

        .stat-item p {
            color: var(--accent-red);
            font-weight: 700;
            text-transform: uppercase;
            letter-spacing: 2px;
            font-size: 0.75rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Footer */
        footer {
            padding: 80px 5% 40px;
            border-top: var(--border-light);
        }

        .footer-content {
            display: grid;
            grid-template-columns: 2fr 1fr 1fr 1fr;
            gap: 60px;
            margin-bottom: 60px;
        }

        .footer-logo-desc p {
            color: var(--text-muted);
            margin-top: 1.5rem;
            max-width: 300px;
        }

        .footer-links h4 {
            margin-bottom: 1.5rem;
            font-size: 1.1rem;
        }

        .footer-links ul {
            list-style: none;
        }

        .footer-links ul li {
            margin-bottom: 12px;
        }

        .footer-links ul li a {
            text-decoration: none;
            color: var(--text-muted);
            transition: var(--transition);
        }

        .footer-links ul li a:hover {
            color: white;
            padding-left: 5px;
        }

        .copyright {
            padding-top: 40px;
            border-top: var(--border-light);
            text-align: center;
            color: var(--text-muted);
            font-size: 0.85rem;
        }

        @media (max-width: 768px) {
            .nav-links { display: none; }
            .hero-title { font-size: 3.5rem; }
            .footer-content { grid-template-columns: 1fr 1fr; }
        }
    </style>
</head>
<body>

    <nav>
        <a href="#" class="logo">
            <i class="fas fa-graduation-cap"></i>
            <div class="logo-text">
                <span>PREMIER</span>
                <span>ACADEMY</span>
            </div>
        </a>
        <div class="nav-links">
            <a href="#inicio">Inicio</a>
            <a href="#caracteristicas">Características</a>
            <a href="#institucion">Institución</a>
            @auth
                <a href="{{ route('dashboard') }}" class="btn-login">Dashboard</a>
            @else
                <a href="{{ route('login') }}" class="btn-login">Iniciar Sesión</a>
            @endauth
        </div>
    </nav>

    <section class="hero" id="inicio">
        <div class="hero-content">
            <div class="badge-premium">
                <i class="fas fa-star"></i> Sistema Académico de Última Generación
            </div>
            <h1 class="hero-title">Forjando el Futuro de la Educación</h1>
            <p class="hero-desc">Gestiona tu carrera, notas y horarios con la plataforma más avanzada y elegante del sector educativo.</p>
            <div class="hero-btns">
                <a href="{{ route('register') }}" class="btn-primary">
                    Comenzar Ahora <i class="fas fa-arrow-right"></i>
                </a>
            </div>
        </div>
    </section>

    <div class="stats">
        <div class="stats-container">
            <div class="stat-item">
                <h3>+{{ \App\Models\User::where('role', 'student')->orWhereNull('role')->count() }}</h3>
                <p>Estudiantes Activos</p>
            </div>
            <div class="stat-item">
                <h3>+{{ \App\Models\Career::count() }}</h3>
                <p>Carreras Profesionales</p>
            </div>
            <div class="stat-item">
                <h3>+{{ \App\Models\Course::count() }}</h3>
                <p>Cursos Registrados</p>
            </div>
            <div class="stat-item">
                <h3>100%</h3>
                <p>Digitalizado</p>
            </div>
        </div>
    </div>

    <section class="section" id="caracteristicas">
        <div class="section-header">
            <span class="section-tag">Innovación Académica</span>
            <h2 class="section-title">Todo lo que necesitas</h2>
        </div>

        <div class="features-grid">
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-user-shield"></i></div>
                <h3 class="feature-title">Seguridad Avanzada</h3>
                <p class="feature-desc">Autenticación de dos factores y gestión de roles dinámica para proteger tus datos académicos.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-calendar-alt"></i></div>
                <h3 class="feature-title">Horarios Inteligentes</h3>
                <p class="feature-desc">Programación semanal sin conflictos y acceso en tiempo real a tus sesiones de clase.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-file-invoice-dollar"></i></div>
                <h3 class="feature-title">Gestión de Pagos</h3>
                <p class="feature-desc">Control total de tus pensiones y matriculaciones con reportes detallados en PDF.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chart-line"></i></div>
                <h3 class="feature-title">Control de Notas</h3>
                <p class="feature-desc">Visualiza tu progreso académico con gráficas y promedios actualizados al instante.</p>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                <h3 class="feature-title">Portal Docente</h3>
                <h3 class="feature-desc">Herramientas exclusivas para profesores: control de asistencia y gestión de aula virtual.</h3>
            </div>
            <div class="feature-card">
                <div class="feature-icon"><i class="fas fa-mobile-alt"></i></div>
                <h3 class="feature-title">Multi-dispositivo</h3>
                <p class="feature-desc">Accede a tu información desde cualquier lugar con una interfaz 100% responsive.</p>
            </div>
        </div>
    </section>

    <footer>
        <div class="footer-content">
            <div class="footer-logo-desc">
                <a href="#" class="logo">
                    <i class="fas fa-graduation-cap"></i>
                    <div class="logo-text">
                        <span>PREMIER</span>
                        <span>ACADEMY</span>
                    </div>
                </a>
                <p>Líderes en tecnología educativa, proporcionando herramientas modernas para el éxito de nuestros estudiantes.</p>
            </div>
            <div class="footer-links">
                <h4>Plataforma</h4>
                <ul>
                    <li><a href="#">Horarios</a></li>
                    <li><a href="#">Carreras</a></li>
                    <li><a href="#">Matrícula</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Soporte</h4>
                <ul>
                    <li><a href="#">Centro de Ayuda</a></li>
                    <li><a href="#">Contacto</a></li>
                    <li><a href="#">Términos</a></li>
                </ul>
            </div>
            <div class="footer-links">
                <h4>Social</h4>
                <ul>
                    <li><a href="#">Facebook</a></li>
                    <li><a href="#">Instagram</a></li>
                    <li><a href="#">LinkedIn</a></li>
                </ul>
            </div>
        </div>
        <div class="copyright">
            &copy; {{ date('Y') }} Panel Premier Academy. Todos los derechos reservados.
        </div>
    </footer>

</body>
</html>
