@extends('layouts.guest')

@section('content')
<div class="login-card" style="max-width: 400px;">
    <div class="login-header">
        <div class="brand">
            <i class="fas fa-shield-halved"></i>
            <span>Verificación de Seguridad</span>
        </div>
        <p>Hemos enviado un código de verificación a tu cuenta. Por favor, ingrésalo para continuar.</p>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); border: 1px solid #2ecc71; color: #2ecc71; padding: 10px; border-radius: 8px; margin-bottom: 1rem; font-size: 0.85rem;">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <form action="{{ route('verify.store') }}" method="POST">
        @csrf
        <div class="input-group">
            <label for="two_factor_code">Código de 6 dígitos</label>
            <div class="input-wrapper">
                <i class="fas fa-key"></i>
                <input type="text" name="two_factor_code" id="two_factor_code" placeholder="000000" maxlength="6" required autofocus autocomplete="one-time-code">
            </div>
            @error('two_factor_code')
                <span class="error-msg" style="color: var(--accent-red); font-size: 0.8rem; margin-top: 5px; display: block;">{{ $message }}</span>
            @enderror
        </div>

        <button type="submit" class="btn-login" style="margin-top: 1rem;">
            Verificar Identidad
        </button>
    </form>

    <div style="text-align: center; margin-top: 2rem;">
        <p style="color: var(--text-muted); font-size: 0.9rem;">¿No recibiste el código?</p>
        <a href="{{ route('verify.resend') }}" style="color: var(--accent-red); text-decoration: none; font-weight: 600; font-size: 0.9rem; transition: 0.3s;" onmouseover="this.style.opacity='0.8'" onmouseout="this.style.opacity='1'">
            <i class="fas fa-rotate-right"></i> Solicitar un nuevo código
        </a>
    </div>

    <div style="margin-top: 2rem; border-top: 1px solid var(--border-color); padding-top: 1.5rem; text-align: center;">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 0.85rem;">
                Cancelar y Cerrar Sesión
            </button>
        </form>
    </div>
</div>

<style>
    .login-card {
        background: var(--bg-surface);
        border: 1px solid var(--border-light);
        padding: 3rem;
        border-radius: 30px;
        box-shadow: 0 20px 50px rgba(0,0,0,0.5);
        backdrop-filter: blur(10px);
        animation: slideUp 0.6s cubic-bezier(0.23, 1, 0.32, 1);
    }
    @keyframes slideUp {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
@endsection
