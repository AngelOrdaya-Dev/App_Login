@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
        <h3 class="panel-title"><i class="fas fa-sliders-h"></i> Configuración del Sistema</h3>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    <div style="display: flex; gap: 3rem;">
        <!-- Settings Sidebar -->
        <div style="width: 250px; display: flex; flex-direction: column; gap: 0.5rem;">
            <div style="padding: 1rem; border-radius: 12px; background: var(--bg-surface-hover); border-left: 3px solid var(--accent-red); color: var(--text-main); font-weight: 600; cursor: pointer;">
                <i class="fas fa-user-cog" style="width: 25px;"></i> Perfil
            </div>
            <div style="padding: 1rem; border-radius: 12px; color: var(--text-muted); cursor: pointer; transition: 0.2s;" onclick="alert('Configuración de Notificaciones próximamente')">
                <i class="fas fa-bell" style="width: 25px;"></i> Notificaciones
            </div>
            <div style="padding: 1rem; border-radius: 12px; color: var(--text-muted); cursor: pointer; transition: 0.2s;" onclick="alert('Ajustes de Seguridad próximamente')">
                <i class="fas fa-shield-alt" style="width: 25px;"></i> Seguridad
            </div>
            <div style="padding: 1rem; border-radius: 12px; color: var(--text-muted); cursor: pointer; transition: 0.2s;" onclick="alert('Ajustes de Apariencia próximamente')">
                <i class="fas fa-paint-brush" style="width: 25px;"></i> Apariencia
            </div>
        </div>
        
        <!-- Settings Content -->
        <div style="flex: 1;">
            <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data" id="profileForm">
                @csrf
                <h4 style="font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 1.5rem;">Información del Perfil</h4>
                
                <div style="display: flex; gap: 2rem; align-items: flex-start; margin-bottom: 2.5rem;">
                    <div style="position: relative;">
                        @if(Auth::user()->avatar)
                            <img src="{{ Auth::user()->avatar }}" alt="Avatar" id="avatarPreview" style="width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--bg-card); box-shadow: 0 0 0 2px var(--accent-red); object-fit: cover;" referrerpolicy="no-referrer" crossorigin="anonymous">
                        @else
                            <div id="avatarFallback" style="width: 100px; height: 100px; border-radius: 50%; background: linear-gradient(135deg, #ff0000, #800000); display: flex; align-items: center; justify-content: center; font-size: 2.5rem; font-weight: bold; color: white;">
                                {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                            </div>
                        @endif
                        <input type="file" name="avatar" id="avatarInput" style="display: none;" accept="image/*">
                        <div style="position: absolute; bottom: 0; right: 0; width: 30px; height: 30px; border-radius: 50%; background: var(--bg-surface); border: 1px solid var(--border-light); display: flex; align-items: center; justify-content: center; color: var(--text-main); cursor: pointer;" onclick="document.getElementById('avatarInput').click()">
                            <i class="fas fa-camera" style="font-size: 0.8rem;"></i>
                        </div>
                    </div>
                    <div>
                        <h5 style="font-size: 1.1rem; margin-bottom: 5px;">{{ Auth::user()->name }}</h5>
                        <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 15px;">Administrador de cuenta y preferencias personales.</p>
                        <div style="display: flex; gap: 10px; align-items: center;">
                            <button type="button" onclick="document.getElementById('avatarInput').click()" style="background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 8px 15px; border-radius: 8px; font-size: 0.8rem; cursor: pointer; transition: 0.2s;">Cambiar Foto</button>
                            
                            @if(Auth::user()->avatar)
                            <button type="button" onclick="document.getElementById('deleteAvatarForm').submit()" style="background: transparent; color: var(--accent-red); border: none; padding: 6px 15px; font-size: 0.8rem; cursor: pointer; font-weight: 600;">Eliminar</button>
                            @endif
                        </div>
                    </div>
                </div>
                
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Nombre Completo</label>
                        <input type="text" name="name" value="{{ Auth::user()->name }}" style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--accent-red)'" onblur="this.style.borderColor='var(--border-color)'">
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Correo Electrónico</label>
                        <input type="email" value="{{ Auth::user()->email }}" style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-muted); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); cursor: not-allowed;" readonly>
                    </div>
                </div>
                
                <div style="margin-top: 2.5rem; text-align: right;">
                    <button type="submit" class="btn-premium-logout" style="width: auto; padding: 0.8rem 2.5rem; display: inline-flex;">Guardar Cambios</button>
                </div>
            </form>

            <form id="deleteAvatarForm" action="{{ route('profile.avatar.delete') }}" method="POST" style="display: none;">
                @csrf
            </form>
        </div>
    </div>
</div>

<script>
    document.getElementById('avatarInput').onchange = function(evt) {
        const [file] = this.files;
        if (file) {
            const preview = document.getElementById('avatarPreview');
            const fallback = document.getElementById('avatarFallback');
            
            if (preview) {
                preview.src = URL.createObjectURL(file);
            } else if (fallback) {
                // Si no hay preview (manual login sin foto), crear una img temporalmente o simplemente confiar en el upload
                const newImg = document.createElement('img');
                newImg.id = 'avatarPreview';
                newImg.style = "width: 100px; height: 100px; border-radius: 50%; border: 3px solid var(--bg-card); box-shadow: 0 0 0 2px var(--accent-red); object-fit: cover;";
                newImg.src = URL.createObjectURL(file);
                fallback.parentNode.replaceChild(newImg, fallback);
            }
        }
    }
</script>
@endsection
