@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
        <h3 class="panel-title"><i class="fas fa-video"></i> Salón de Clases Virtuales</h3>
    </div>

    <div class="virtual-classes-grid">
        <!-- Course Selection Sidebar -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); border-radius: 20px; padding: 1.5rem;">
            <h5 style="color: var(--text-main); margin-bottom: 1.5rem; font-size: 0.9rem; text-transform: uppercase; letter-spacing: 1px;">Mis Cursos Activos</h5>
            
            <div style="display: flex; flex-direction: column; gap: 10px;">
                @foreach($courses as $course)
                <div style="display: flex; gap: 10px; align-items: center;">
                    <div class="course-room-card" onclick="startClass('{{ str_replace(' ', '-', $course->name) }}-{{ $course->id }}', '{{ $course->name }}')" style="flex: 1; padding: 1rem; background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 12px; cursor: pointer; transition: 0.2s;">
                        <div style="font-weight: 600; color: var(--text-main); font-size: 0.95rem; margin-bottom: 5px;">{{ $course->name }}</div>
                        <div style="font-size: 0.75rem; color: var(--text-muted);">
                            <span class="status-indicator" style="display: inline-block; width: 8px; height: 8px; border-radius: 50%; background: #2ecc71; margin-right: 5px;"></span> Disponible ahora
                        </div>
                    </div>
                    <a href="{{ route('forum.show', $course->id) }}" class="btn-premium-logout" style="padding: 10px; border-radius: 12px; width: 45px; height: 45px; display: flex; align-items: center; justify-content: center; flex-shrink: 0;" title="Foro de Dudas">
                        <i class="fas fa-comments"></i>
                    </a>
                </div>
                @endforeach
            </div>

            <div style="margin-top: 2rem; padding: 1rem; background: rgba(255,0,0,0.05); border: 1px dashed var(--accent-red); border-radius: 12px;">
                <p style="font-size: 0.75rem; color: var(--text-muted); margin: 0; line-height: 1.4;">
                    <i class="fas fa-info-circle" style="color: var(--accent-red);"></i> Selecciona un curso para ingresar al aula virtual. Asegúrate de permitir el uso de tu cámara y micrófono.
                </p>
            </div>
        </div>

        <!-- Video Conference Area -->
        <div id="jitsi-container" style="background: #000; border: 1px solid var(--border-light); border-radius: 20px; overflow: hidden; display: flex; align-items: center; justify-content: center; position: relative;">
            <div id="jitsi-placeholder" style="text-align: center;">
                <i class="fas fa-video-slash" style="font-size: 4rem; color: #222; margin-bottom: 1.5rem;"></i>
                <h4 style="color: #444;">Sin clase activa</h4>
                <p style="color: #333; font-size: 0.9rem;">Selecciona un curso de la izquierda para comenzar</p>
            </div>
            <div id="meet" style="width: 100%; height: 100%; display: none;"></div>
        </div>
    </div>
</div>

<style>
    .virtual-classes-grid {
        display: grid;
        grid-template-columns: 300px 1fr;
        gap: 2rem;
        min-height: 600px;
    }

    @media (max-width: 900px) {
        .virtual-classes-grid {
            grid-template-columns: 1fr;
            min-height: auto;
        }
        #jitsi-container {
            height: 400px;
        }
    }

    .course-room-card:hover {
        border-color: var(--accent-red) !important;
        background: var(--bg-surface-hover) !important;
        transform: translateX(5px);
    }
    .course-room-card.active {
        border-color: var(--accent-red) !important;
        background: rgba(255,0,0,0.05) !important;
        box-shadow: 0 0 15px rgba(255,0,0,0.1);
    }
</style>

<!-- Jitsi External API -->
<script src="https://meet.jit.si/external_api.js"></script>

<script>
    let api = null;

    function startClass(roomName, displayName) {
        // UI Updates
        document.getElementById('jitsi-placeholder').style.display = 'none';
        document.getElementById('meet').style.display = 'block';
        
        document.querySelectorAll('.course-room-card').forEach(card => card.classList.remove('active'));
        event.currentTarget.classList.add('active');

        // Cleanup existing meeting
        if (api) {
            api.dispose();
        }

        const domain = "meet.jit.si";
        const options = {
            roomName: "PremierAcademy-" + roomName,
            width: "100%",
            height: "100%",
            parentNode: document.querySelector('#meet'),
            userInfo: {
                displayName: "{{ Auth::user()->name }}"
            },
            configOverwrite: {
                startWithAudioMuted: true,
                startWithVideoMuted: true,
                prejoinPageEnabled: false,
                disableDeepLinking: true
            },
            interfaceConfigOverwrite: {
                TOOLBAR_BUTTONS: [
                    'microphone', 'camera', 'closedcaptions', 'desktop', 'fullscreen',
                    'fodeviceselection', 'hangup', 'profile', 'chat', 'recording',
                    'livestreaming', 'etherpad', 'sharedvideo', 'settings', 'raisehand',
                    'videoquality', 'filmstrip', 'invite', 'feedback', 'stats', 'shortcuts',
                    'tileview', 'videobackgroundblur', 'download', 'help', 'mute-everyone',
                    'security'
                ],
            }
        };
        api = new JitsiMeetExternalAPI(domain, options);
    }
</script>
@endsection
