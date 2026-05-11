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
    
    <!-- PWA -->
    <link rel="manifest" href="/manifest.json">
    <meta name="theme-color" content="#ff0000">
    <meta name="mobile-web-app-capable" content="yes">
    <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent">
    <link rel="apple-touch-icon" href="/icons/icon-192x192.png">
    <link rel="icon" type="image/jpeg" href="/Logo.jpeg">
    <link rel="shortcut icon" href="/Logo.jpeg" type="image/x-icon">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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

        body.light-mode {
            --bg-base: #f0f2f5;
            --bg-surface: #ffffff;
            --bg-surface-hover: #eef1f5;
            --bg-card: #ffffff;
            --text-main: #111111;
            --text-muted: #555555;
            --border-color: #d1d9e6;
            --border-light: rgba(0, 0, 0, 0.08);
            --border-red: rgba(255, 0, 0, 0.25);
        }

        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        html, body {
            overflow-x: hidden;
            max-width: 100%;
        }

        body {
            font-family: var(--font-body);
            background-color: var(--bg-base);
            color: var(--text-main);
            display: block;
            min-height: 100vh;
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
        
        .sidebar-menu::-webkit-scrollbar {
            width: 5px;
        }
        
        .sidebar-menu::-webkit-scrollbar-track {
            background: transparent;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb {
            background: rgba(255, 255, 255, 0.1);
            border-radius: 10px;
        }
        
        .sidebar-menu::-webkit-scrollbar-thumb:hover {
            background: rgba(255, 0, 0, 0.3);
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
            padding-bottom: 3.5rem;
            border-top: 1px solid var(--border-color);
        }

        /* ===== MAIN LAYOUT ===== */
        .main-container {
            margin-left: 280px;
            display: flex;
            flex-direction: column;
            position: relative;
            min-height: 100vh;
            max-width: calc(100% - 280px);
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
            gap: 1.5rem; /* Reduced from 2rem */
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

        input::placeholder, select::placeholder {
            color: var(--text-muted);
            opacity: 0.6;
        }

        /* Generic modal input styles */
        .modal-input {
            width: 100% !important;
            box-sizing: border-box !important;
            background: rgba(255, 255, 255, 0.02) !important;
            border: 1px solid var(--border-color) !important;
            color: var(--text-main) !important;
            padding: 12px 15px !important;
            border-radius: 12px !important;
            outline: none !important;
            font-family: var(--font-body) !important;
            transition: var(--transition-smooth);
        }

        body.light-mode .modal-input {
            background: transparent !important;
            border: 1px solid var(--border-color) !important;
        }

        .modal-input:focus {
            border-color: var(--accent-red) !important;
            box-shadow: 0 0 10px var(--accent-red-faded);
        }

        .modal-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 1px;
            font-weight: 600;
        }

        /* Fix for select options in dark mode */
        select.modal-input option {
            background-color: #121214; /* Matches var(--bg-card) */
            color: #fff;
            padding: 10px;
        }

        /* Ensure browser uses dark color scheme for native elements like datepickers and selects */
        :root { color-scheme: dark; }
        body.light-mode { color-scheme: light; }

        /* Responsive Utils */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
            margin-bottom: 1rem;
        }

        .table-responsive table {
            min-width: 800px;
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
            color: #ffffff; /* Blanco puro para legibilidad máxima */
        }
        
        .hero-content h1 span {
            color: var(--accent-red);
            text-shadow: 0 0 25px rgba(255, 0, 0, 0.5);
        }
        
        .hero-content p {
            color: rgba(255, 255, 255, 0.75); /* Gris muy claro/blanco traslúcido */
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
            color: #ffffff !important; /* Forzar blanco para visibilidad */
        }
        
        .hero-date-text span {
            font-size: 0.8rem;
            color: rgba(255,255,255,0.6) !important;
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

        /* Tables Responsive */
        .table-responsive {
            width: 100%;
            overflow-x: auto;
            -webkit-overflow-scrolling: touch;
        }
        
        .table-responsive table {
            width: 100%;
            min-width: 600px;
            border-collapse: collapse;
        }

        .table-responsive th, 
        .table-responsive td {
            white-space: nowrap;
        }

        /* Complex Grid Section */
        .dashboard-grid {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 1.5rem;
        }

        .panel {
            background: var(--bg-surface);
            border-radius: 24px;
            padding: 2rem;
            border: 1px solid var(--border-light);
            box-shadow: var(--shadow-sm);
        }

        .panel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            gap: 1rem;
            flex-wrap: wrap;
        }

        .panel-title {
            font-family: var(--font-display);
            font-size: 1.2rem;
            font-weight: 700;
            display: flex;
            align-items: center;
            gap: 12px;
            min-width: max-content;
        }
        
        .panel-title i {
            color: var(--accent-red);
            text-shadow: 0 0 10px var(--accent-red-glow);
            flex-shrink: 0;
        }

        .panel-header-actions {
            display: flex;
            gap: 10px;
            align-items: center;
            flex-wrap: wrap;
        }

        @media (max-width: 768px) {
            .panel {
                padding: 1.25rem;
                border-radius: 16px;
            }
            .panel-title {
                font-size: 1rem !important;
                white-space: normal;
                line-height: 1.4;
            }
            .panel-header {
                gap: 0.8rem !important;
            }
            .panel-header {
                flex-direction: column;
                align-items: flex-start;
                gap: 1.2rem;
            }
            .panel-header-actions {
                width: 100%;
                justify-content: flex-start;
            }
            .panel-header-actions > * {
                flex: 1;
                min-width: 120px;
            }
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
            display: inline-flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, var(--accent-red), #990000);
            color: #fff;
            border: none;
            padding: 0.8rem 1.5rem;
            border-radius: 12px;
            font-family: var(--font-display);
            font-weight: 700;
            font-size: 0.9rem;
            gap: 10px;
            cursor: pointer;
            transition: var(--transition-smooth);
            box-shadow: 0 8px 20px var(--accent-red-faded);
            text-decoration: none;
            white-space: nowrap;
        }
        
        .btn-premium-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 15px 30px rgba(255,0,0,0.3);
            background: linear-gradient(135deg, #ff1a1a, #cc0000);
        }

        /* Footer */
        .footer {
            padding: 1.25rem 4rem;
            border-top: 1px solid rgba(255, 255, 255, 0.05);
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.75rem;
            color: #888;
            background: #000;
            margin-top: auto;
        }
        
        .footer-copy {
            letter-spacing: 0.2px;
        }
        
        .footer-copy strong {
            color: #fff;
            font-weight: 700;
        }
        
        .footer-logo {
            display: flex;
            align-items: center;
            gap: 12px;
            font-family: var(--font-display);
            font-weight: 900;
            color: #fff;
            text-transform: uppercase;
            letter-spacing: 1px;
            font-size: 0.9rem;
        }
        
        .footer-logo i {
            color: #ff0000;
            font-size: 1.1rem;
        }

        /* Dropdowns */
        .notifications-dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            width: 320px;
            background: var(--bg-surface);
            border: 1px solid var(--border-light);
            border-radius: 20px;
            margin-top: 15px;
            box-shadow: 0 20px 50px rgba(0,0,0,0.5);
            display: none;
            z-index: 1000;
            overflow: hidden;
            animation: slideDown 0.3s ease;
        }

        @media (max-width: 480px) {
            .notifications-dropdown {
                width: 280px;
                right: -50px;
            }
        }
        .dropdown {
            position: absolute;
            top: 100%;
            right: 0;
            background: var(--bg-surface);
            border: 1px solid var(--border-color);
            border-radius: 12px;
            width: 300px;
            max-width: calc(100vw - 30px); /* Responsive width */
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
            .main-container { 
                margin-left: 0; 
                max-width: 100%;
            }
            .mobile-toggle { display: flex !important; }
            .search-bar { display: none; }
            .header { padding: 0 1.5rem; }
        }

        @media (max-width: 600px) {
            .stats-grid { grid-template-columns: 1fr; }
            .header { 
                padding: 0.6rem 0.8rem; /* Further reduced padding */
                gap: 5px;
            }
            .header-actions {
                gap: 0.5rem; /* Drastically reduced gap on mobile */
            }
            .header-title h2 { font-size: 0.8rem !important; letter-spacing: 0; } /* Smaller title */
            .header-title i { font-size: 1rem !important; }
            .mobile-toggle { margin-right: 0.2rem !important; font-size: 1.2rem !important; }
            
            .user-info { display: none; }
            .user-profile { 
                padding: 0.2rem; 
                gap: 0;
            }
            .avatar, .avatar-fallback { width: 30px; height: 30px; font-size: 0.8rem; }
            .action-btn { width: 32px; height: 32px; font-size: 0.8rem; margin-right: 0.2rem !important; }

            .content { padding: 1rem; gap: 1.2rem; }
            .hero-card { 
                padding: 1.2rem; 
                flex-direction: column;
                text-align: center;
                gap: 1rem;
            }
            .hero-content h1 { font-size: 1.6rem; }
            .hero-content p { font-size: 0.85rem; }
            .hero-date { 
                width: 100%;
                justify-content: center;
                padding: 0.6rem;
            }
            .hero-date i { font-size: 1.2rem; }
            .hero-date-text strong { font-size: 0.9rem; }
            
            .footer {
                flex-direction: column;
                gap: 0.8rem;
                text-align: center;
                padding: 1.5rem 1rem;
            }
            
            /* Global Modal Responsiveness */
            div[id*="Modal"] > div {
                width: 92% !important;
                padding: 1.2rem !important;
                margin: 5px !important;
            }

            .dropdown {
                width: calc(100vw - 20px);
                right: -10px;
            }
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
        <a href="{{ route('dashboard') }}" class="sidebar-brand" style="text-decoration: none; display: flex; align-items: center; gap: 15px;">
            <div class="brand-icon">
                <i class="fas fa-graduation-cap"></i>
            </div>
            <div class="brand-text">
                <div style="line-height: 1.1;">
                    <span style="font-size: 1.1rem; font-weight: 900; color: #fff; letter-spacing: 0.5px;">PREMIER</span><br>
                    <span style="color: var(--accent-red); font-weight: 700; font-size: 0.8rem; letter-spacing: 2.5px;">ACADEMY</span>
                </div>
            </div>
        </a>

        <div class="sidebar-menu">
            <div class="menu-section">Principal</div>
            <a href="{{ route('dashboard') }}" class="menu-item {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-border-all"></i>
                <span>Dashboard</span>
            </a>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('students') }}" class="menu-item {{ request()->routeIs('students') ? 'active' : '' }}">
                <i class="fas fa-users"></i>
                <span>Estudiantes</span>
                <span class="menu-badge">{{ \App\Models\User::where(function($q){ $q->where('role', 'student')->orWhereNull('role'); })->count() }}</span>
            </a>
            <a href="{{ route('teachers') }}" class="menu-item {{ request()->routeIs('teachers') ? 'active' : '' }}">
                <i class="fas fa-chalkboard-teacher"></i>
                <span>Docentes</span>
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
            @elseif(Auth::user()->isTeacher())
            <div class="menu-section">Aula Virtual</div>
            <a href="{{ route('teacher.courses') }}" class="menu-item {{ request()->routeIs('teacher.courses') ? 'active' : '' }}">
                <i class="fas fa-chalkboard"></i>
                <span>Mis Cursos</span>
            </a>
            <a href="{{ route('grades') }}" class="menu-item {{ request()->routeIs('grades') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>Calificaciones</span>
            </a>
            @endif

            @if(!Auth::user()->isTeacher())
            <div class="menu-section">Trámites</div>
            <a href="{{ route('enrollments') }}" class="menu-item {{ request()->routeIs('enrollments') ? 'active' : '' }}">
                <i class="fas fa-file-signature"></i>
                <span>Inscripciones</span>
            </a>
            <a href="{{ route('payments') }}" class="menu-item {{ request()->routeIs('payments') ? 'active' : '' }}">
                <i class="fas fa-wallet"></i>
                <span>Pagos</span>
            </a>
            <a href="{{ route('grades') }}" class="menu-item {{ request()->routeIs('grades') ? 'active' : '' }}">
                <i class="fas fa-star"></i>
                <span>Notas</span>
            </a>
            @endif

            <a href="{{ route('schedules') }}" class="menu-item {{ request()->routeIs('schedules','attendance.*') ? 'active' : '' }}">
                <i class="fas fa-calendar-week"></i>
                <span>Horarios</span>
            </a>
            <a href="{{ route('library.index') }}" class="menu-item {{ request()->routeIs('library.index') ? 'active' : '' }}">
                <i class="fas fa-book-reader"></i>
                <span>Biblioteca</span>
            </a>
            <a href="{{ route('virtual.classes') }}" class="menu-item {{ request()->routeIs('virtual.classes') ? 'active' : '' }}">
                <i class="fas fa-video"></i>
                <span>Clases Virtuales</span>
            </a>

            <div class="menu-section">Sistema</div>
            <a href="{{ route('settings') }}" class="menu-item {{ request()->routeIs('settings') ? 'active' : '' }}">
                <i class="fas fa-sliders-h"></i>
                <span>Configuración</span>
            </a>
            @if(Auth::user()->isAdmin())
            <a href="{{ route('audit.logs') }}" class="menu-item {{ request()->routeIs('audit.logs') ? 'active' : '' }}">
                <i class="fas fa-history"></i>
                <span>Auditoría</span>
            </a>
            <a href="{{ route('reports.index') }}" class="menu-item {{ request()->routeIs('reports.index') ? 'active' : '' }}">
                <i class="fas fa-chart-line"></i>
                <span>Reportes</span>
            </a>
            <a href="{{ route('courses.index') }}" class="menu-item {{ request()->routeIs('courses.index') ? 'active' : '' }}">
                <i class="fas fa-chalkboard"></i>
                <span>Cursos</span>
            </a>
            @endif
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
                <a href="{{ route('dashboard') }}" style="display: flex; align-items: center; gap: 12px; margin-left: 0.5rem; text-decoration: none;">
                    <i class="fas fa-graduation-cap" style="color: var(--accent-red); font-size: 1.4rem; filter: drop-shadow(0 0 8px rgba(255, 0, 0, 0.4));"></i>
                    <h2 style="margin: 0; font-weight: 900; text-transform: uppercase; font-size: 1.15rem; letter-spacing: 0.5px; color: #fff;">PREMIER <span style="color: var(--accent-red);">ACADEMY</span></h2>
                </a>
            </div>
            
            <div class="header-actions">
                <div class="mobile-toggle" id="mobileToggle" style="display: none; cursor: pointer; font-size: 1.5rem; color: var(--text-main); margin-right: 1.5rem;">
                    <i class="fas fa-bars"></i>
                </div>
                
                <button class="action-btn" id="theme-toggle" title="Cambiar Modo" style="margin-right: 1rem; border: none; background: transparent; cursor: pointer;">
                    <i class="fas fa-moon" id="theme-icon"></i>
                </button>

                @if(Auth::user()->isAdmin())
                <div class="search-bar" style="position: relative;">
                    <i class="fas fa-search"></i>
                    <input type="text" placeholder="Buscar Estudiantes o Carreras..." id="globalSearchInput" autocomplete="off">
                    
                    <!-- Search Results Dropdown -->
                    <div class="dropdown" id="searchDropdown" style="width: 350px; right: auto; left: 0; max-height: 400px; overflow-y: auto;">
                        <div class="dropdown-header" style="display: none;" id="searchHeader">Resultados de Búsqueda</div>
                        <div id="searchResults">
                            <div class="dropdown-item" style="justify-content: center; color: var(--text-muted); font-size: 0.8rem;">Escribe para buscar...</div>
                        </div>
                    </div>
                </div>
                @endif
                
                <div class="action-btn-container">
                    <div class="action-btn" id="notifBtn">
                        <i class="far fa-bell"></i>
                        @if($unread_notifications_count > 0)
                        <span class="badge" id="notifBadge" style="background: var(--accent-red); position: absolute; top: -5px; right: -5px; min-width: 18px; height: 18px; border-radius: 50%; font-size: 0.65rem; display: flex; align-items: center; justify-content: center; border: 2px solid var(--bg-surface);">{{ $unread_notifications_count }}</span>
                        @endif
                    </div>
                    
                    <!-- Notification Dropdown -->
                    <div class="dropdown" id="notifDropdown">
                        <div class="dropdown-header">
                            Notificaciones <span class="count" id="notifCountText">{{ $unread_notifications_count }} Nuevas</span>
                        </div>
                        <div id="notificationsList">
                            @forelse($global_notifications as $notif)
                            <div class="dropdown-item notif-item" id="notif-{{ $notif->id }}" style="position: relative; padding-right: 2.5rem;">
                                <div class="dropdown-item-icon">
                                    @if($notif->type == 'success') <i class="fas fa-check-circle" style="color: #2ecc71;"></i>
                                    @elseif($notif->type == 'warning') <i class="fas fa-exclamation-triangle" style="color: #f39c12;"></i>
                                    @else <i class="fas fa-info-circle"></i> @endif
                                </div>
                                <div class="dropdown-item-content">
                                    <div class="dropdown-item-title">
                                        {{ $notif->title }}
                                        @if(!$notif->user_id)
                                            <span style="font-size: 0.55rem; background: var(--accent-red); color: #fff; padding: 1px 5px; border-radius: 4px; margin-left: 5px; font-weight: 800; vertical-align: middle;">SISTEMA</span>
                                        @endif
                                    </div>
                                    <div class="dropdown-item-text">{{ $notif->message }}</div>
                                </div>
                                <button type="button" class="dismiss-notif" data-id="{{ $notif->id }}" style="position: absolute; right: 15px; top: 50%; transform: translateY(-50%); background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.1rem; transition: color 0.2s;">
                                    <i class="fas fa-times"></i>
                                </button>
                            </div>
                            @empty
                            <div class="dropdown-item empty-notif" style="justify-content: center; color: var(--text-muted); font-size: 0.8rem;">
                                No tienes notificaciones nuevas
                            </div>
                            @endforelse
                        </div>
                    </div>
                </div>
                
                <div class="user-profile" onclick="window.location.href='{{ route('settings') }}'">
                    @if(Auth::user()->avatar)
                        <img src="{{ Auth::user()->avatar }}" alt="Avatar" class="avatar" referrerpolicy="no-referrer">
                    @else
                        <div class="avatar-fallback">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</div>
                    @endif
                    <div class="user-info">
                        <span class="name">{{ explode(' ', Auth::user()->name)[0] }}</span>
                        <span class="role">{{ ucfirst(Auth::user()->role) }}</span>
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
                <i class="fas fa-graduation-cap"></i>
                <span>PREMIER ACADEMY</span>
            </div>
            <div class="footer-copy">
                &copy; 2026 Diseñado y Desarrollado por <strong>Angel Ordaya</strong>. Todos los derechos reservados.
            </div>
        </footer>
        
    </div>

    <!-- JavaScript for Interactivity -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            
            /* Theme Toggle Logic - Forced Dark Mode for Stability */
            const themeToggle = document.getElementById('theme-toggle');
            if (themeToggle) themeToggle.style.display = 'none'; // Ocultar por ahora para evitar clics accidentales
            
            // Garantizar que siempre inicie en modo oscuro
            document.body.classList.remove('light-mode');
            localStorage.setItem('theme-mode', 'dark');

            // Auto-scroll sidebar to active item
            const activeItem = document.querySelector('.menu-item.active');
            if (activeItem) {
                activeItem.scrollIntoView({ behavior: 'auto', block: 'center' });
            }
            
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

            // GLOBAL SEARCH FUNCTIONALITY (AJAX) - Using DOM API for TrustedHTML compatibility
            const searchInput = document.getElementById('globalSearchInput');
            const searchDropdown = document.getElementById('searchDropdown');
            const searchResults = document.getElementById('searchResults');
            const searchHeader = document.getElementById('searchHeader');
            
            let searchTimeout;
            
            function clearElement(el) {
                while (el.firstChild) el.removeChild(el.firstChild);
            }
            
            function createSearchItem(iconClass, title, subtitle, avatarUrl) {
                const item = document.createElement('div');
                item.className = 'dropdown-item';
                
                const iconWrap = document.createElement('div');
                iconWrap.className = 'dropdown-item-icon';
                
                if (avatarUrl) {
                    iconWrap.style.background = 'transparent';
                    const img = document.createElement('img');
                    img.src = avatarUrl;
                    img.referrerPolicy = 'no-referrer';
                    img.style.cssText = 'width:100%;height:100%;border-radius:50%;object-fit:cover;';
                    iconWrap.appendChild(img);
                } else {
                    const icon = document.createElement('i');
                    icon.className = iconClass;
                    if (!avatarUrl && iconClass.includes('user-circle')) {
                        icon.style.fontSize = '30px';
                        iconWrap.style.background = 'transparent';
                    }
                    iconWrap.appendChild(icon);
                }
                
                const content = document.createElement('div');
                content.className = 'dropdown-item-content';
                
                const titleEl = document.createElement('div');
                titleEl.className = 'dropdown-item-title';
                titleEl.textContent = title;
                content.appendChild(titleEl);
                
                if (subtitle) {
                    const subEl = document.createElement('div');
                    subEl.className = 'dropdown-item-text';
                    subEl.textContent = subtitle;
                    content.appendChild(subEl);
                }
                
                item.appendChild(iconWrap);
                item.appendChild(content);
                return item;
            }
            
            function createSectionLabel(text) {
                const label = document.createElement('div');
                label.style.cssText = 'padding:5px 15px;font-size:0.7rem;color:var(--text-muted);text-transform:uppercase;font-weight:600;margin-top:5px;';
                label.textContent = text;
                return label;
            }
            
            function createStatusMessage(text) {
                const msg = document.createElement('div');
                msg.className = 'dropdown-item';
                msg.style.cssText = 'justify-content:center;color:var(--text-muted);font-size:0.8rem;';
                msg.textContent = text;
                return msg;
            }
            
            if(searchInput) {
                searchInput.addEventListener('input', function(e) {
                    const query = e.target.value.trim();
                    
                    clearTimeout(searchTimeout);
                    
                    if (query.length === 0) {
                        searchDropdown.classList.remove('show');
                        return;
                    }
                    
                    searchDropdown.classList.add('show');
                    clearElement(searchResults);
                    
                    const loadingMsg = document.createElement('div');
                    loadingMsg.className = 'dropdown-item';
                    loadingMsg.style.cssText = 'justify-content:center;color:var(--text-muted);font-size:0.8rem;';
                    loadingMsg.textContent = 'Buscando...';
                    const spinner = document.createElement('i');
                    spinner.className = 'fas fa-spinner fa-spin';
                    spinner.style.marginLeft = '5px';
                    loadingMsg.appendChild(spinner);
                    searchResults.appendChild(loadingMsg);
                    
                    searchTimeout = setTimeout(() => {
                        fetch(`{{ route('search.global') }}?q=${encodeURIComponent(query)}`)
                            .then(response => response.json())
                            .then(data => {
                                clearElement(searchResults);
                                searchHeader.style.display = 'flex';
                                
                                let hasResults = false;
                                
                                // Render Students
                                if (data.students && data.students.length > 0) {
                                    hasResults = true;
                                    searchResults.appendChild(createSectionLabel('Estudiantes'));
                                    data.students.forEach(student => {
                                        searchResults.appendChild(
                                            createSearchItem(
                                                'fas fa-user-graduate',
                                                student.name,
                                                student.email,
                                                student.avatar || null
                                            )
                                        );
                                    });
                                }

                                // Render Teachers
                                if (data.teachers && data.teachers.length > 0) {
                                    hasResults = true;
                                    searchResults.appendChild(createSectionLabel('Docentes'));
                                    data.teachers.forEach(teacher => {
                                        searchResults.appendChild(
                                            createSearchItem(
                                                'fas fa-chalkboard-teacher',
                                                teacher.name,
                                                teacher.email,
                                                teacher.avatar || null
                                            )
                                        );
                                    });
                                }
                                
                                // Render Careers
                                if (data.careers && data.careers.length > 0) {
                                    hasResults = true;
                                    searchResults.appendChild(createSectionLabel('Carreras'));
                                    data.careers.forEach(career => {
                                        searchResults.appendChild(
                                            createSearchItem('fas fa-book-open', career.name, null, null)
                                        );
                                    });
                                }
                                
                                if (!hasResults) {
                                    searchResults.appendChild(createStatusMessage('No se encontraron resultados'));
                                }
                            });
                    }, 300);
                });
                
                // Hide search on click outside
                document.addEventListener('click', function(e) {
                    if (!searchDropdown.contains(e.target) && e.target !== searchInput) {
                        searchDropdown.classList.remove('show');
                    }
                });
                
                // Show search if there's text on focus
                searchInput.addEventListener('focus', function() {
                    if (this.value.trim().length > 0) {
                        searchDropdown.classList.add('show');
                    }
                });
            }

            // NOTIFICATIONS DISMISS FUNCTIONALITY (AJAX)
            document.querySelectorAll('.dismiss-notif').forEach(btn => {
                btn.addEventListener('click', function(e) {
                    e.stopPropagation(); // Evitar cerrar el dropdown general
                    const id = this.getAttribute('data-id');
                    const item = document.getElementById('notif-' + id);
                    
                    item.style.transition = 'all 0.3s';
                    item.style.opacity = '0';
                    item.style.transform = 'translateX(20px)';
                    
                    fetch(`/notificaciones/${id}/leer`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        setTimeout(() => {
                            item.remove();
                            
                            // Update counts
                            const badge = document.getElementById('notifBadge');
                            const countText = document.getElementById('notifCountText');
                            
                            if (badge) {
                                if (data.unread_count > 0) {
                                    badge.textContent = data.unread_count;
                                } else {
                                    badge.remove();
                                }
                            }
                            
                            if (countText) {
                                countText.textContent = `${data.unread_count} Nuevas`;
                            }
                            
                            // Check if list is empty
                            if (document.querySelectorAll('.notif-item').length === 0) {
                                const notifList = document.getElementById('notificationsList');
                                clearElement(notifList);
                                const emptyMsg = document.createElement('div');
                                emptyMsg.className = 'dropdown-item empty-notif';
                                emptyMsg.style.cssText = 'justify-content:center;color:var(--text-muted);font-size:0.8rem;';
                                emptyMsg.textContent = 'No tienes notificaciones nuevas';
                                notifList.appendChild(emptyMsg);
                            }
                        }, 300);
                    });
                });
            });
            
            // Add click effect to menu items
            const menuItems = document.querySelectorAll('.sidebar-menu .menu-item');
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

        // ===== MODAL FUNCTIONS =====
        function openModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = 'flex';
                document.body.style.overflow = 'hidden';
            }
        }

        function closeModal(id) {
            const modal = document.getElementById(id);
            if (modal) {
                modal.style.display = 'none';
                document.body.style.overflow = 'auto';
            }
        }
    </script>
    <!-- PWA Registration -->
    <script>
        if ('serviceWorker' in navigator) {
            window.addEventListener('load', () => {
                navigator.serviceWorker.register('/sw.js');
            });
        }
    </script>
</body>
</html>
