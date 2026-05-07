<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Premium | Académico</title>
    <!-- Google Fonts: Inter & Outfit for premium look -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600&family=Outfit:wght@400;600;700;800;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <!-- Meta referrer for Google Avatar images -->
    <meta name="referrer" content="no-referrer">
    
    <style>
        /* CSS Variables for Premium Theme */
        :root {
            --bg-base: #050505;
            --bg-surface: #0f0f11;
            --bg-surface-hover: #16161a;
            --bg-card: #121214;
            --accent-red: #f00;
            --accent-red-glow: rgba(255, 0, 0, 0.4);
            --accent-red-faded: rgba(255, 0, 0, 0.1);
            --text-main: #ffffff;
            --text-muted: #8a8a93;
            --border-color: #222226;
            --border-light: rgba(255, 255, 255, 0.05);
            --border-red: rgba(255, 0, 0, 0.3);
            
            --font-display: 'Outfit', sans-serif;
            --font-body: 'Inter', sans-serif;
            
            --transition-smooth: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: var(--font-body);
            background-color: var(--bg-base);
            color: var(--text-main);
            display: flex;
            min-height: 100vh;
            overflow-x: hidden;
            -webkit-font-smoothing: antialiased;
        }

        /* ===== SIDEBAR ===== */
        .sidebar {
            width: 280px;
            background: var(--bg-surface);
            border-right: 1px solid var(--border-color);
            display: flex;
            flex-direction: column;
            position: fixed;
            height: 100vh;
            z-index: 100;
            box-shadow: 5px 0 30px rgba(0, 0, 0, 0.5);
        }
        
        .sidebar-brand {
            height: 90px;
            display: flex;
            align-items: center;
            padding: 0 2rem;
            gap: 15px;
            border-bottom: 1px solid var(--border-color);
            background: linear-gradient(180deg, rgba(255,0,0,0.05) 0%, transparent 100%);
        }
        
        .brand-icon {
            width: 45px;
            height: 45px;
            border-radius: 12px;
            background: var(--accent-red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: #fff;
            box-shadow: 0 0 20px var(--accent-red-glow);
        }
        
        .brand-text {
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.1rem;
            line-height: 1.2;
            letter-spacing: 0.5px;
        }
        
        .sidebar-menu {
            flex: 1;
            padding: 2rem 1rem;
            overflow-y: auto;
        }
        
        .menu-section {
            font-size: 0.7rem;
            text-transform: uppercase;
            letter-spacing: 2px;
            color: var(--text-muted);
            font-weight: 600;
            margin: 1.5rem 0 0.8rem 1rem;
        }
        
        .menu-item {
            display: flex;
            align-items: center;
            gap: 15px;
            padding: 0.9rem 1rem;
            color: var(--text-muted);
            text-decoration: none;
            border-radius: 12px;
            font-weight: 500;
            transition: var(--transition-smooth);
            margin-bottom: 0.3rem;
            position: relative;
            overflow: hidden;
        }
        
        .menu-item i {
            font-size: 1.1rem;
            width: 22px;
            text-align: center;
            transition: var(--transition-smooth);
        }
        
        .menu-item:hover {
            color: var(--text-main);
            background: var(--bg-surface-hover);
        }
        
        .menu-item.active {
            color: var(--text-main);
            background: var(--bg-surface-hover);
            border: 1px solid var(--border-red);
            box-shadow: inset 0 0 20px var(--accent-red-faded);
        }
        
        .menu-item.active i {
            color: var(--accent-red);
            text-shadow: 0 0 10px var(--accent-red-glow);
        }
        
        .menu-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 50%;
            transform: translateY(-50%);
            height: 60%;
            width: 4px;
            background: var(--accent-red);
            border-radius: 0 4px 4px 0;
            box-shadow: 0 0 10px var(--accent-red);
        }

        .menu-badge {
            margin-left: auto;
            background: var(--accent-red);
            color: #fff;
            font-size: 0.7rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 20px;
            box-shadow: 0 0 10px var(--accent-red-glow);
        }

        .sidebar-footer {
            padding: 1.5rem;
            border-top: 1px solid var(--border-color);
        }

        /* ===== MAIN LAYOUT ===== */
        .main-container {
            margin-left: 280px;
            flex: 1;
            display: flex;
            flex-direction: column;
            position: relative;
        }
        
        /* Subtle Background Glow */
        .main-container::before {
            content: '';
            position: absolute;
            top: -200px;
            right: -200px;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(255,0,0,0.05) 0%, transparent 70%);
            border-radius: 50%;
            z-index: -1;
            pointer-events: none;
        }

        /* ===== HEADER ===== */
        .header {
            height: 90px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 3rem;
            background: rgba(5, 5, 5, 0.8);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--border-light);
            position: sticky;
            top: 0;
            z-index: 50;
        }
        
        .header-title h2 {
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1.4rem;
            letter-spacing: 0.5px;
        }
        
        .header-title span {
            color: var(--accent-red);
        }

        .header-actions {
            display: flex;
            align-items: center;
            gap: 2rem;
        }

        .search-bar {
            display: flex;
            align-items: center;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 100px;
            padding: 0.6rem 1.5rem;
            gap: 12px;
            width: 250px;
            transition: var(--transition-smooth);
        }
        
        .search-bar:focus-within {
            border-color: var(--accent-red);
            box-shadow: 0 0 15px var(--accent-red-faded);
            width: 280px;
        }
        
        .search-bar i {
            color: var(--text-muted);
            font-size: 0.9rem;
        }
        
        .search-bar input {
            border: none;
            background: transparent;
            color: var(--text-main);
            outline: none;
            width: 100%;
            font-family: var(--font-body);
            font-size: 0.9rem;
        }

        .action-btn {
            position: relative;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            width: 45px;
            height: 45px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: var(--text-muted);
            font-size: 1.1rem;
            cursor: pointer;
            transition: var(--transition-smooth);
        }
        
        .action-btn:hover {
            color: var(--text-main);
            border-color: var(--border-red);
            box-shadow: 0 0 15px var(--accent-red-faded);
        }
        
        .action-btn .badge {
            position: absolute;
            top: 0;
            right: 0;
            background: var(--accent-red);
            width: 10px;
            height: 10px;
            border-radius: 50%;
            border: 2px solid var(--bg-base);
            box-shadow: 0 0 8px var(--accent-red);
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            padding: 0.4rem 1.2rem 0.4rem 0.4rem;
            border-radius: 100px;
            transition: var(--transition-smooth);
            cursor: pointer;
        }
        
        .user-profile:hover {
            border-color: var(--border-red);
            background: var(--bg-surface-hover);
        }

        .avatar {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            object-fit: cover;
            border: 2px solid transparent;
            transition: var(--transition-smooth);
        }
        
        .user-profile:hover .avatar {
            border-color: var(--accent-red);
        }

        .avatar-fallback {
            width: 38px;
            height: 38px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff0000, #800000);
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: var(--font-display);
            font-weight: 800;
            font-size: 1.1rem;
            color: #fff;
        }

        .user-info {
            display: flex;
            flex-direction: column;
        }

        .user-info .name {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
        }

        .user-info .role {
            font-size: 0.7rem;
            color: var(--text-muted);
        }

        /* ===== CONTENT AREA ===== */
        .content {
            padding: 3rem;
            flex: 1;
            display: flex;
            flex-direction: column;
            gap: 2.5rem;
        }

        /* Hero Card */
        .hero-card {
            background: linear-gradient(120deg, #16161a 0%, #0a0a0c 100%);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 3rem;
            position: relative;
            overflow: hidden;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 20px 40px rgba(0,0,0,0.4);
        }
        
        .hero-card::before {
            content: '';
            position: absolute;
            top: 0;
            right: 0;
            width: 40%;
            height: 100%;
            background: radial-gradient(circle at 100% 50%, rgba(255,0,0,0.15) 0%, transparent 70%);
            pointer-events: none;
        }

        .hero-content h1 {
            font-family: var(--font-display);
            font-size: 2.5rem;
            font-weight: 800;
            margin-bottom: 0.5rem;
            line-height: 1.2;
        }
        
        .hero-content h1 span {
            color: var(--accent-red);
            text-shadow: 0 0 20px var(--accent-red-glow);
        }
        
        .hero-content p {
            color: var(--text-muted);
            font-size: 1.1rem;
            max-width: 600px;
        }

        .hero-date {
            background: rgba(255,255,255,0.03);
            border: 1px solid var(--border-light);
            padding: 1rem 1.5rem;
            border-radius: 16px;
            backdrop-filter: blur(10px);
            display: flex;
            align-items: center;
            gap: 15px;
            z-index: 1;
        }
        
        .hero-date i {
            font-size: 1.5rem;
            color: var(--accent-red);
        }
        
        .hero-date-text {
            display: flex;
            flex-direction: column;
        }
        
        .hero-date-text strong {
            font-family: var(--font-display);
            font-size: 1.1rem;
            letter-spacing: 0.5px;
        }
        
        .hero-date-text span {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        /* Stats Grid */
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(4, 1fr);
            gap: 1.5rem;
        }

        .stat-card {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 20px;
            padding: 1.8rem;
            display: flex;
            flex-direction: column;
            gap: 1.5rem;
            transition: var(--transition-smooth);
            position: relative;
            overflow: hidden;
        }

        .stat-card::after {
            content: '';
            position: absolute;
            bottom: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--accent-red);
            transform: scaleX(0);
            transform-origin: left;
            transition: transform 0.4s cubic-bezier(0.25, 0.8, 0.25, 1);
        }

        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--border-red);
            box-shadow: 0 15px 35px rgba(0,0,0,0.4), 0 0 20px rgba(255,0,0,0.05);
        }
        
        .stat-card:hover::after {
            transform: scaleX(1);
        }

        .stat-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
        }

        .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 14px;
            background: linear-gradient(135deg, rgba(255,0,0,0.15), rgba(255,0,0,0.02));
            border: 1px solid var(--border-red);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.4rem;
            color: var(--accent-red);
            box-shadow: inset 0 0 15px rgba(255,0,0,0.1);
        }

        .stat-trend {
            display: flex;
            align-items: center;
            gap: 5px;
            font-size: 0.8rem;
            font-weight: 600;
            padding: 4px 10px;
            border-radius: 20px;
            background: rgba(39, 174, 96, 0.1);
            color: #2ecc71;
        }

        .stat-body {
            display: flex;
            flex-direction: column;
            gap: 5px;
        }

        .stat-label {
            font-size: 0.85rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 500;
        }

        .stat-value {
            font-family: var(--font-display);
            font-size: 2.2rem;
            font-weight: 800;
            line-height: 1;
        }

        /* Complex Grid Section */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        .panel {
            background: var(--bg-card);
            border: 1px solid var(--border-color);
            border-radius: 24px;
            padding: 2rem;
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
        }

        .panel-title {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 10px;
        }
        
        .panel-title i {
            color: var(--accent-red);
            text-shadow: 0 0 10px var(--accent-red-glow);
        }

        /* Profile Details Panel */
        .profile-details {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }

        .detail-row {
            display: flex;
            align-items: center;
            padding: 1.2rem;
            background: rgba(255,255,255,0.02);
            border: 1px solid var(--border-light);
            border-radius: 16px;
            transition: var(--transition-smooth);
        }

        .detail-row:hover {
            background: rgba(255,255,255,0.04);
            border-color: rgba(255,255,255,0.1);
            transform: translateX(5px);
        }

        .detail-icon {
            width: 40px;
            height: 40px;
            border-radius: 12px;
            background: rgba(255,255,255,0.05);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.1rem;
            color: var(--text-muted);
            margin-right: 15px;
        }

        .detail-content {
            flex: 1;
        }

        .detail-label {
            font-size: 0.75rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .detail-value {
            font-weight: 600;
            font-size: 1rem;
            color: var(--text-main);
        }

        .status-badge {
            padding: 6px 14px;
            border-radius: 100px;
            font-size: 0.8rem;
            font-weight: 700;
            background: rgba(39, 174, 96, 0.1);
            color: #2ecc71;
            border: 1px solid rgba(39, 174, 96, 0.3);
            display: flex;
            align-items: center;
            gap: 6px;
        }
        
        .status-badge::before {
            content: '';
            width: 6px;
            height: 6px;
            border-radius: 50%;
            background: #2ecc71;
            box-shadow: 0 0 8px #2ecc71;
        }

        /* Chart Panel */
        .chart-container {
            display: flex;
            flex-direction: column;
            align-items: center;
            gap: 2rem;
        }

        .chart-graphic {
            position: relative;
            width: 220px;
            height: 220px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .chart-graphic svg {
            transform: rotate(-90deg);
            filter: drop-shadow(0 0 10px rgba(0,0,0,0.5));
        }

        .chart-center {
            position: absolute;
            display: flex;
            flex-direction: column;
            align-items: center;
            text-align: center;
        }
        
        .chart-center-val {
            font-family: var(--font-display);
            font-size: 2rem;
            font-weight: 800;
        }
        
        .chart-center-lbl {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
        }

        .chart-legend {
            width: 100%;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .legend-item {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 10px 15px;
            background: rgba(255,255,255,0.02);
            border-radius: 10px;
        }

        .legend-left {
            display: flex;
            align-items: center;
            gap: 10px;
            font-size: 0.9rem;
            font-weight: 500;
        }

        .legend-dot {
            width: 12px;
            height: 12px;
            border-radius: 4px;
        }

        .legend-val {
            font-weight: 700;
            font-family: var(--font-display);
        }

        /* Logout Button Styles */
        .btn-logout-form {
            width: 100%;
            margin-top: 1rem;
        }
        
        .btn-premium-logout {
            width: 100%;
            background: linear-gradient(135deg, var(--accent-red), #990000);
            color: #fff;
            border: none;
            padding: 1rem;
            border-radius: 14px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 1rem;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 10px 25px var(--accent-red-faded);
        }
        
        .btn-premium-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255,0,0,0.3);
            background: linear-gradient(135deg, #ff1a1a, #cc0000);
        }

        /* Footer */
        .footer {
            padding: 2rem 3rem;
            border-top: 1px solid var(--border-color);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.85rem;
            color: var(--text-muted);
        }
        
        .footer a {
            color: var(--text-main);
            text-decoration: none;
            font-weight: 600;
            transition: color 0.2s;
        }
        
        .footer a:hover {
            color: var(--accent-red);
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 8px;
            font-family: var(--font-display);
            font-weight: 800;
            color: var(--text-main);
        }
        
        .footer-logo i {
            color: var(--accent-red);
        }

        /* Dropdowns */
        .dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 300px;
            box-shadow: 0 10px 30px rgba(0,0,0,0.5);
            opacity: 0;
            visibility: hidden;
            transform: translateY(10px);
            transition: var(--transition-smooth);
            z-index: 1000;
            margin-top: 10px;
        }

        .dropdown.show {
            opacity: 1;
            visibility: visible;
            transform: translateY(0);
        }

        .dropdown-header {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid var(--border-light);
            font-weight: 600;
            font-size: 0.9rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .dropdown-header span.count {
            background: var(--accent-red);
            color: #fff;
            padding: 2px 8px;
            border-radius: 10px;
            font-size: 0.7rem;
        }

        .dropdown-item {
            padding: 1rem 1.2rem;
            border-bottom: 1px solid var(--border-light);
            display: flex;
            gap: 12px;
            transition: background 0.2s;
            cursor: pointer;
        }

        .dropdown-item:hover {
            background: var(--bg-surface-hover);
        }

        .dropdown-item:last-child {
            border-bottom: none;
        }

        .dropdown-item-icon {
            width: 36px;
            height: 36px;
            border-radius: 50%;
            background: rgba(255,0,0,0.1);
            color: var(--accent-red);
            display: flex;
            align-items: center;
            justify-content: center;
            flex-shrink: 0;
        }

        .dropdown-item-content {
            flex: 1;
        }

        .dropdown-item-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--text-main);
            margin-bottom: 4px;
        }

        .dropdown-item-text {
            font-size: 0.75rem;
            color: var(--text-muted);
            line-height: 1.3;
        }
        
        .action-btn-container {
            position: relative;
        }

        @media (max-width: 1200px) {
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
            .dashboard-grid { grid-template-columns: 1fr; }
        }
        
        @media (max-width: 900px) {
            .sidebar { 
                transform: translateX(-100%);
                transition: transform 0.3s cubic-bezier(0.4, 0, 0.2, 1);
                z-index: 999;
            }
            .sidebar.open { transform: translateX(0); }
            .main-container { margin-left: 0; }
            .mobile-toggle { display: flex !important; }
            .search-bar { display: none; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .header { padding: 1rem; }
            .content { padding: 1rem; }
            .hero-card { padding: 2rem 1.5rem; }
            .hero-date { flex-direction: column; gap: 0.5rem; text-align: right; font-size: 0.8rem; }
        }

        .mobile-overlay {
            display: none;
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.6);
            backdrop-filter: blur(3px);
            z-index: 998;
        }
        .mobile-overlay.open { display: block; }
    </style>
</head>
<body>

    <div class="mobile-overlay" id="mobileOverlay"></div>

    <!-- ===== SIDEBAR ===== -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <div class="brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="brand-text">
                MATRICULA<br><span style="color:var(--accent-red);font-weight:400;font-size:0.8rem;letter-spacing:2px">PREMIUM</span>
            </div>
        </div>

        <div class="sidebar-menu">
            <div class="menu-section">Principal</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all"></i>
                <span>Dashboard</span>
            </a>
            <a href="{{ route('students') }}" class="menu-item {{ request()->routeIs('students') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Estudiantes</span>
                <span class="menu-badge">{{ \App\Models\User::count() }}</span>
            </a>
            <a href="{{ route('classrooms') }}" class="menu-item {{ request()->routeIs('classrooms') ? 'active' : '' }}">
                <i class="fas fa-laptop-house"></i>
                <span>Aulas</span>
            </a>

            <div class="menu-section">Gestión Académica</div>
            <a href="{{ route('careers') }}" class="menu-item {{ request()->routeIs('careers') ? 'active' : '' }}">
                <i class="fas fa-book-open"></i>
                <span>Carreras</span>
            </a>
            <a href="{{ route('enrollments') }}" class="menu-item {{ request()->routeIs('enrollments') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i>
                <span>Inscripciones</span>
            </a>
            <a href="{{ route('payments') }}" class="menu-item {{ request()->routeIs('payments') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Pagos</span>
            </a>

            <div class="menu-section">Sistema</div>
            <a href="{{ route('settings') }}" class="menu-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i>
                <span>Configuración</span>
            </a>
        </div>

        <div class="sidebar-footer">
            <form action="{{ route('logout') }}" method="POST" class="btn-logout-form">
                @csrf
                <button type="submit" class="btn-premium-logout">
                    <i class="fas fa-power-off"></i> Cerrar Sesión
                </button>
            </form>
        </div>
    </aside>

    <!-- ===== MAIN CONTENT ===== -->
    <div class="main-container">
        
        <!-- Header -->
        <header class="header">
            <div class="header-title">
                <h2>Panel <span>General</span></h2>
            </div>
            
            <div class="header-actions">
                <div class="mobile-toggle" id="mobileToggle" style="display: none; cursor: pointer; font-size: 1.5rem; color: var(--text-main); margin-right: 1.5rem;">
                    <i class="fas fa-bars"></i>
                </div>
                
                <div class="search-bar">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar en el panel..." id="sidebarSearch">
                </div>
                
                <div class="action-btn-container">
                    <div class="action-btn" id="notifBtn">
                        <i class="far fa-bell"></i>
                        @if($unread_notifications_count > 0)
                        <span class="badge" style="background: var(--accent-red); position: absolute; top: -5px; right: -5px; min-width: 18px; height: 18px; border-radius: 50%; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; border: 2px solid var(--bg-surface);">{{ $unread_notifications_count }}</span>
                        @endif
                    </div>
                    
                    <!-- Notification Dropdown -->
                    <div class="dropdown" id="notifDropdown">
                        <div class="dropdown-header">
                            Notificaciones <span class="count">{{ $unread_notifications_count }} Nuevas</span>
                        </div>
                        @forelse($global_notifications as $notif)
                        <div class="dropdown-item">
                            <div class="dropdown-item-icon">
                                @if($notif->type == 'success') <i class="fas fa-check-circle" style="color: #2ecc71;"></i>
                                @elseif($notif->type == 'warning') <i class="fas fa-exclamation-triangle" style="color: #f39c12;"></i>
                                @else <i class="fas fa-info-circle"></i> @endif
                            </div>
                            <div class="dropdown-item-content">
                                <div class="dropdown-item-title">{{ $notif->title }}</div>
                                <div class="dropdown-item-text">{{ $notif->message }}</div>
                            </div>
                        </div>
                        @empty
                        <div class="dropdown-item" style="justify-content: center; color: var(--text-muted); font-size: 0.8rem;">
                            No tienes notificaciones nuevas
                        </div>
                        @endforelse
                    </div>
                </div>
                
                <div class="user-profile">
                    @if(Auth::user()->avatar)
                        <!-- referrerpolicy added to fix Google Avatar loading issues -->
                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="avatar" referrerpolicy="no-referrer" crossorigin="anonymous">
                    @else
                        <div class="avatar-fallback">
                            {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                        </div>
                    @endif
                    <div class="user-info">
                        <span class="name">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        <span class="role">Estudiante</span>
                    </div>
                </div>
            </div>
        </header>

        <!-- Content Area -->
        <main class="content">
            @yield('content')
        </main>

        <!-- Footer -->
        <footer class="footer">
            <div class="footer-logo">
                <i class="fas fa-graduation-cap"></i> PANEL PREMIER
            </div>
            <div class="footer-copy">
                &copy; 2026 Diseñado y Desarrollado por <a href="#">Angel Ordaya</a>. Todos los derechos reservados.
            </div>
        </footer>
        
    </div>

    <!-- JavaScript for Interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            // Notification Dropdown Toggle
            const notifBtn = document.getElementById('notifBtn');
            const notifDropdown = document.getElementById('notifDropdown');
            
            notifBtn.addEventListener('click', function(e) {
                e.stopPropagation();
                notifDropdown.classList.toggle('show');
            });
            
            // Close dropdowns when clicking outside
            document.addEventListener('click', function(e) {
                if (!notifDropdown.contains(e.target) && !notifBtn.contains(e.target)) {
                    notifDropdown.classList.remove('show');
                }
            });

            // Search Filter Functionality
            const searchInput = document.getElementById('searchInput');
            const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');
            
            searchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                
                menuItems.forEach(item => {
                    const text = item.querySelector('span').textContent.toLowerCase();
                    if (text.includes(searchTerm)) {
                        item.style.display = 'flex';
                    } else {
                        item.style.display = 'none';
                    }
                });
                
                // Hide section headers if all items below are hidden
                const sections = document.querySelectorAll('.menu-section');
                sections.forEach(section => {
                    let hasVisibleItems = false;
                    let nextElem = section.nextElementSibling;
                    
                    while (nextElem && !nextElem.classList.contains('menu-section')) {
                        if (nextElem.style.display !== 'none') {
                            hasVisibleItems = true;
                            break;
                        }
                        nextElem = nextElem.nextElementSibling;
                    }
                    
                    if (hasVisibleItems) {
                        section.style.display = 'block';
                    } else {
                        section.style.display = 'none';
                    }
                });
            });
            
            // Add click effect to menu items
            menuItems.forEach(item => {
                item.addEventListener('click', function() {
                    menuItems.forEach(i => i.classList.remove('active'));
                    this.classList.add('active');
                });
            });
        });

        // ===== MOBILE SIDEBAR TOGGLE =====
        const mobileToggle = document.getElementById('mobileToggle');
        const mobileOverlay = document.getElementById('mobileOverlay');
        const sidebar = document.querySelector('.sidebar');

        if (mobileToggle) {
            mobileToggle.addEventListener('click', function () {
                sidebar.classList.toggle('open');
                mobileOverlay.classList.toggle('open');
            });
        }
        if (mobileOverlay) {
            mobileOverlay.addEventListener('click', function () {
                sidebar.classList.remove('open');
                mobileOverlay.classList.remove('open');
            });
        }

        // Fix search input ID (updated from searchInput to sidebarSearch)
        const sidebarSearchInput = document.getElementById('sidebarSearch');
        if (sidebarSearchInput) {
            sidebarSearchInput.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();
                menuItems.forEach(item => {
                    const text = item.querySelector('span').textContent.toLowerCase();
                    item.style.display = text.includes(searchTerm) ? 'flex' : 'none';
                });
            });
        }
    </script>
</body>
</html>
