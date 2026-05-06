<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Estudiante</title>
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700;900&display=swap" rel="stylesheet">
    <style>
        *, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
        body { font-family: 'Roboto', sans-serif; min-height: 100vh; display: flex; align-items: center; justify-content: center; background-color: #000; background-image: radial-gradient(circle at 0% 0%, rgba(255, 0, 0, 0.12) 0%, transparent 50%), radial-gradient(circle at 100% 100%, rgba(255, 0, 0, 0.08) 0%, transparent 50%); padding: 1.5rem; color: #fff; }
        .card { width: 100%; max-width: 440px; background: #111; border: 1px solid rgba(255, 255, 255, 0.05); border-radius: 16px; padding: 3rem 2.5rem; box-shadow: 0 40px 100px rgba(0, 0, 0, 0.8); animation: fadeIn 0.4s ease-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(20px); } to { opacity: 1; transform: translateY(0); } }
        .card-header { text-align: center; margin-bottom: 2.5rem; }
        .header-icon { font-size: 3rem; margin-bottom: 1rem; display: block; }
        h1 { font-size: 1.8rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem; text-transform: uppercase; letter-spacing: -0.5px; }
        .card-header p { color: #888; font-size: 0.95rem; font-weight: 400; }
        .success-alert { background: #ff0000; border-radius: 8px; padding: 1rem; color: #fff; font-size: 0.95rem; margin-bottom: 2rem; font-weight: 700; text-align: center; }
        .form-group { margin-bottom: 1.5rem; }
        label { display: block; font-size: 0.75rem; font-weight: 900; color: #ff0000; margin-bottom: 0.6rem; text-transform: uppercase; letter-spacing: 1px; }
        input, select { width: 100%; padding: 1rem 1.2rem; background: #1a1a1a; border: 2px solid #222; border-radius: 12px; color: #fff; font-family: inherit; font-size: 1rem; transition: all 0.2s; outline: none; }
        input:focus, select:focus { border-color: #ff0000; background: #222; }
        .form-row { display: grid; grid-template-columns: 1fr 1fr; gap: 1.2rem; }
        .checkbox-group { display: flex; align-items: flex-start; gap: 0.8rem; margin: 2rem 0; cursor: pointer; font-size: 0.85rem; color: #666; }
        .checkbox-group input { accent-color: #ff0000; width: 18px; height: 18px; }
        button { width: 100%; padding: 1.2rem; background-color: #ff0000; border: none; border-radius: 12px; color: #fff; font-size: 1.1rem; font-weight: 900; cursor: pointer; transition: all 0.2s; text-transform: uppercase; letter-spacing: 1px; }
        button:hover { background-color: #e60000; transform: translateY(-2px); }
        .btn-google { display: flex; align-items: center; justify-content: center; gap: 10px; width: 100%; padding: 1.2rem; background-color: #fff; border: none; border-radius: 12px; color: #000; text-decoration: none; font-size: 1.1rem; font-weight: 900; }
        .divider { display: flex; align-items: center; text-align: center; margin: 1.5rem 0; color: #666; font-size: 0.8rem; text-transform: uppercase; }
        .divider::before, .divider::after { content: ''; flex: 1; border-bottom: 1px solid #222; }
    </style>
</head>
<body>
<div class="card">
    <div class="card-header">
        <span class="header-icon">🎓</span>
        <h1>Registro Académico</h1>
        <p>Sistema de Inscripción Estudiantil</p>
    </div>
    @if(session('success'))
        <div class="success-alert">{{ session('success') }}</div>
    @endif
    <form action="{{ url('/register') }}" method="POST">
        @csrf
        <div class="form-group"><label>Nombre Completo</label><input type="text" name="name" required></div>
        <div class="form-group"><label>Dirección de Correo</label><input type="email" name="email" required></div>
        <div class="form-row">
            <div class="form-group"><label>Contraseña</label><input type="password" name="password" required></div>
            <div class="form-group"><label>Validar</label><input type="password" name="password_confirmation" required></div>
        </div>
        <div class="form-group">
            <label>Carrera Solicitada</label>
            <select name="career_id" required>
                <option value="" disabled selected>Selecciona una opción...</option>
                @foreach($careers as $career)
                    <option value="{{ $career->id }}">{{ $career->name }}</option>
                @endforeach
            </select>
        </div>
        <label class="checkbox-group"><input type="checkbox" name="terms_accepted" required><span>Acepto los términos y condiciones.</span></label>
        <button type="submit">Registrar Estudiante</button>
        <div class="divider">O Regístrate rápido con</div>
        <a href="{{ route('login.google') }}" class="btn-google"><img src="https://upload.wikimedia.org/wikipedia/commons/c/c1/Google_%22G%22_logo.svg" alt="Google" width="20"> Google</a>
    </form>
</div>
</body>
</html>
