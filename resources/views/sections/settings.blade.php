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
    
    <div class="settings-layout">
        <!-- Settings Sidebar -->
        <div class="settings-sidebar">
            <div id="tab-profile" class="settings-tab active-tab" onclick="switchTab('profile')" style="padding: 1rem; border-radius: 12px; background: var(--bg-surface-hover); border-left: 3px solid var(--accent-red); color: var(--text-main); font-weight: 600; cursor: pointer; transition: 0.2s;">
                <i class="fas fa-user-cog" style="width: 25px;"></i> Perfil
            </div>
            <div id="tab-notifications" class="settings-tab" onclick="switchTab('notifications')" style="padding: 1rem; border-radius: 12px; border-left: 3px solid transparent; color: var(--text-muted); cursor: pointer; transition: 0.2s;">
                <i class="fas fa-bell" style="width: 25px;"></i> Notificaciones
            </div>
            <div id="tab-security" class="settings-tab" onclick="switchTab('security')" style="padding: 1rem; border-radius: 12px; border-left: 3px solid transparent; color: var(--text-muted); cursor: pointer; transition: 0.2s;">
                <i class="fas fa-shield-alt" style="width: 25px;"></i> Seguridad
            </div>
            <div id="tab-appearance" class="settings-tab" onclick="switchTab('appearance')" style="padding: 1rem; border-radius: 12px; border-left: 3px solid transparent; color: var(--text-muted); cursor: pointer; transition: 0.2s;">
                <i class="fas fa-paint-brush" style="width: 25px;"></i> Apariencia
            </div>
        </div>
        
        <!-- Settings Content -->
        <div style="flex: 1; position: relative;">
            
            <!-- PROFILE CONTENT -->
            <div id="content-profile" class="settings-content">
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
                    
                    <div class="profile-grid">
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

            <!-- NOTIFICATIONS CONTENT -->
            <div id="content-notifications" class="settings-content" style="display: none;">
                <form action="{{ route('notifications.settings') }}" method="POST">
                    @csrf
                    <h4 style="font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 0.5rem;">Centro de Notificaciones</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Controla cómo y cuándo recibes alertas sobre la actividad de tu cuenta y el sistema.</p>
                    
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1.5rem; border-radius: 16px; margin-bottom: 1.5rem; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; margin-bottom: 5px; color: var(--text-main);">Actividad de la Cuenta</h5>
                            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Recibe notificaciones cuando tu perfil es actualizado, cambian tus roles, o hay una nueva matrícula.</p>
                        </div>
                        <label style="position: relative; display: inline-block; width: 50px; height: 26px;">
                            <input type="checkbox" name="notifications_enabled" {{ Auth::user()->notifications_enabled ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0; pointer-events: none;">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div style="margin-top: 2.5rem; text-align: right;">
                        <button type="submit" class="btn-premium-logout" style="width: auto; padding: 0.8rem 2.5rem; display: inline-flex;">Actualizar Preferencias</button>
                    </div>
                </form>
            </div>

            <!-- SECURITY CONTENT -->
            <div id="content-security" class="settings-content" style="display: none;">
                <form action="{{ route('profile.security') }}" method="POST">
                    @csrf
                    <h4 style="font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 0.5rem;">Autenticación de Dos Pasos</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 1.5rem;">Añade una capa extra de seguridad a tu cuenta requiriendo un código enviado a tu correo al iniciar sesión.</p>
                    
                    <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1.5rem; border-radius: 16px; margin-bottom: 2.5rem; display: flex; align-items: center; justify-content: space-between;">
                        <div>
                            <h5 style="font-size: 1rem; font-weight: 600; margin-bottom: 5px; color: var(--text-main);">Activar Verificación (2FA)</h5>
                            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Se enviará un código único a <strong>{{ Auth::user()->email }}</strong> cada vez que ingreses.</p>
                        </div>
                        <label style="position: relative; display: inline-block; width: 50px; height: 26px;">
                            <input type="checkbox" name="two_factor_enabled" {{ Auth::user()->two_factor_enabled ? 'checked' : '' }} style="opacity: 0; width: 0; height: 0; pointer-events: none;">
                            <span class="toggle-slider"></span>
                        </label>
                    </div>

                    <div style="margin-bottom: 3rem; text-align: right;">
                        <button type="submit" class="btn-premium-logout" style="width: auto; padding: 0.8rem 2.5rem; display: inline-flex;">Actualizar Seguridad</button>
                    </div>
                </form>

                <hr style="border: 0; border-top: 1px solid var(--border-light); margin-bottom: 2.5rem;">

                <form action="{{ route('profile.password') }}" method="POST">
                    @csrf
                    <h4 style="font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 0.5rem;">Cambiar Contraseña</h4>
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Protege tu cuenta actualizando tu contraseña periódicamente.</p>
                    
                    <div style="display: flex; flex-direction: column; gap: 1.5rem; max-width: 500px;">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Contraseña Actual</label>
                            <input type="password" name="current_password" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--accent-red)'" onblur="this.style.borderColor='var(--border-color)'">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Nueva Contraseña</label>
                            <input type="password" name="password" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--accent-red)'" onblur="this.style.borderColor='var(--border-color)'">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Confirmar Nueva Contraseña</label>
                            <input type="password" name="password_confirmation" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); transition: border-color 0.2s;" onfocus="this.style.borderColor='var(--accent-red)'" onblur="this.style.borderColor='var(--border-color)'">
                        </div>
                    </div>

                    <div style="margin-top: 2.5rem; text-align: right;">
                        <button type="submit" class="btn-premium-logout" style="width: auto; padding: 0.8rem 2.5rem; display: inline-flex;">Actualizar Contraseña</button>
                    </div>
                </form>
            </div>

            <!-- APPEARANCE CONTENT -->
            <div id="content-appearance" class="settings-content" style="display: none;">
                <h4 style="font-family: var(--font-display); font-size: 1.3rem; margin-bottom: 0.5rem;">Apariencia del Sistema</h4>
                <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem;">Personaliza los colores y el estilo visual de tu panel de control.</p>
                
                <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap: 1.5rem;">
                    <!-- Color Themes -->
                    <div class="theme-card active" data-color="#ff0000" onclick="setTheme(this, '#ff0000')" style="background: var(--bg-surface); border: 2px solid var(--accent-red); padding: 1.5rem; border-radius: 16px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; right: 0; width: 40px; height: 40px; background: #ff0000; clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                        <h5 style="margin: 0; font-size: 1.1rem; color: var(--text-main);">Rojo Vibrante</h5>
                        <p style="margin: 5px 0 0; font-size: 0.8rem; color: var(--text-muted);">Estilo por defecto (App Login)</p>
                    </div>
                    
                    <div class="theme-card" data-color="#3498db" onclick="setTheme(this, '#3498db')" style="background: var(--bg-surface); border: 2px solid var(--border-light); padding: 1.5rem; border-radius: 16px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; right: 0; width: 40px; height: 40px; background: #3498db; clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                        <h5 style="margin: 0; font-size: 1.1rem; color: var(--text-main);">Azul Océano</h5>
                        <p style="margin: 5px 0 0; font-size: 0.8rem; color: var(--text-muted);">Elegancia y calma</p>
                    </div>

                    <div class="theme-card" data-color="#9b59b6" onclick="setTheme(this, '#9b59b6')" style="background: var(--bg-surface); border: 2px solid var(--border-light); padding: 1.5rem; border-radius: 16px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; right: 0; width: 40px; height: 40px; background: #9b59b6; clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                        <h5 style="margin: 0; font-size: 1.1rem; color: var(--text-main);">Púrpura Royal</h5>
                        <p style="margin: 5px 0 0; font-size: 0.8rem; color: var(--text-muted);">Creatividad premium</p>
                    </div>

                    <div class="theme-card" data-color="#f1c40f" onclick="setTheme(this, '#f1c40f')" style="background: var(--bg-surface); border: 2px solid var(--border-light); padding: 1.5rem; border-radius: 16px; cursor: pointer; transition: 0.3s; position: relative; overflow: hidden;">
                        <div style="position: absolute; top: 0; right: 0; width: 40px; height: 40px; background: #f1c40f; clip-path: polygon(100% 0, 0 0, 100% 100%);"></div>
                        <h5 style="margin: 0; font-size: 1.1rem; color: var(--text-main);">Oro Elite</h5>
                        <p style="margin: 5px 0 0; font-size: 0.8rem; color: var(--text-muted);">Lujo y prestigio</p>
                    </div>
                </div>

                <div style="margin-top: 3rem; padding: 1.5rem; background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px dashed var(--border-light);">
                    <p style="color: var(--text-muted); font-size: 0.9rem; text-align: center; margin: 0;">Los cambios de apariencia se aplican instantáneamente en tu navegador.</p>
                </div>
            </div>
            
        </div>
    </div>
</div>

<style>
    .settings-layout {
        display: flex;
        gap: 3rem;
    }
    .settings-sidebar {
        width: 250px;
        display: flex;
        flex-direction: column;
        gap: 0.5rem;
    }
    .profile-grid {
        display: grid;
        grid-template-columns: 1fr 1fr;
        gap: 1.5rem;
    }

    @media (max-width: 900px) {
        .settings-layout {
            flex-direction: column;
            gap: 2rem;
        }
        .settings-sidebar {
            width: 100%;
            flex-direction: row;
            overflow-x: auto;
            padding-bottom: 10px;
            -webkit-overflow-scrolling: touch;
        }
        .settings-tab {
            white-space: nowrap;
            padding: 0.8rem 1.2rem !important;
            border-left: none !important;
            border-bottom: 3px solid transparent;
        }
        .active-tab {
            border-bottom-color: var(--accent-red) !important;
        }
    }

    @media (max-width: 600px) {
        .profile-grid {
            grid-template-columns: 1fr;
        }
        .settings-content h4 {
            font-size: 1.1rem !important;
        }
    }
    .toggle-slider {
        position: absolute; cursor: pointer; top: 0; left: 0; right: 0; bottom: 0;
        background-color: var(--bg-base); border: 2px solid var(--border-color);
        transition: .4s; border-radius: 34px;
    }
    .toggle-slider:before {
        position: absolute; content: ""; height: 16px; width: 16px;
        left: 3px; bottom: 3px; background-color: var(--text-muted);
        transition: .4s; border-radius: 50%;
    }
    input:checked + .toggle-slider {
        background-color: rgba(255, 0, 0, 0.2);
        border-color: var(--accent-red);
    }
    input:checked + .toggle-slider:before {
        transform: translateX(24px);
        background-color: var(--accent-red);
        box-shadow: 0 0 10px var(--accent-red);
    }
</style>

<script>
    function switchTab(tabId) {
        // Ocultar contenidos
        document.querySelectorAll('.settings-content').forEach(el => el.style.display = 'none');
        // Mostrar contenido activo
        document.getElementById('content-' + tabId).style.display = 'block';
        
        // Resetear estilos de tabs
        document.querySelectorAll('.settings-tab').forEach(el => {
            el.style.background = 'transparent';
            el.style.borderLeftColor = 'transparent';
            el.style.color = 'var(--text-muted)';
            el.style.fontWeight = 'normal';
        });
        
        // Aplicar estilos a tab activa
        const activeTab = document.getElementById('tab-' + tabId);
        activeTab.style.background = 'var(--bg-surface-hover)';
        activeTab.style.borderLeftColor = 'var(--accent-red)';
        activeTab.style.color = 'var(--text-main)';
        activeTab.style.fontWeight = '600';
    }

    function setTheme(card, color) {
        // Update CSS Variables
        document.documentElement.style.setProperty('--accent-red', color);
        
        // Update Theme Cards UI
        document.querySelectorAll('.theme-card').forEach(c => {
            c.style.borderColor = 'var(--border-light)';
            c.classList.remove('active');
        });
        
        card.style.borderColor = color;
        card.classList.add('active');
        
        // Save to localStorage
        localStorage.setItem('app_theme_color', color);
        
        // Update accents in specific elements if needed
        const notificationBadge = document.getElementById('notifBadge');
        if (notificationBadge) notificationBadge.style.background = color;
    }

    // Load theme on startup
    document.addEventListener('DOMContentLoaded', () => {
        const savedColor = localStorage.getItem('app_theme_color');
        if (savedColor) {
            document.documentElement.style.setProperty('--accent-red', savedColor);
            // Update UI card highlight
            document.querySelectorAll('.theme-card').forEach(card => {
                if (card.getAttribute('data-color') === savedColor) {
                    card.style.borderColor = savedColor;
                    card.classList.add('active');
                } else {
                    card.classList.remove('active');
                    card.style.borderColor = 'var(--border-light)';
                }
            });
        }
    });
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
