@extends('layouts.admin')

@section('content')
<div class="hero-card" style="margin-bottom: 2rem;">
    <div class="hero-content">
        <h1>Centro de <br><span>Inscripciones</span></h1>
        @if(Auth::user()->isAdmin())
            <p>Panel de control administrativo para la supervisión y aprobación de procesos de matrícula y solicitudes académicas.</p>
        @else
            <p>Gestiona tus procesos de matrícula, solicitudes de traslado y aperturas de nuevos ciclos académicos.</p>
        @endif
    </div>
    <div style="font-size: 6rem; color: rgba(255,0,0,0.1); position: absolute; right: 5%; top: 50%; transform: translateY(-50%); pointer-events: none;">
        <i class="fas fa-file-signature"></i>
    </div>
</div>

<div class="dashboard-grid" style="{{ Auth::user()->isAdmin() ? 'display: block;' : '' }}">
    @if(Auth::user()->isStudent())
    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title"><i class="fas fa-plus-circle"></i> Nueva Inscripción</h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center; justify-content: center; padding: 2rem 0; text-align: center;">
            <div style="width: 80px; height: 80px; border-radius: 50%; background: rgba(255,0,0,0.1); border: 1px dashed var(--accent-red); display: flex; align-items: center; justify-content: center; font-size: 2rem; color: var(--accent-red); margin-bottom: 1rem;">
                <i class="fas fa-file-contract"></i>
            </div>
            <h4 style="font-size: 1.2rem; font-family: var(--font-display);">Aperturar Proceso</h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 80%;">Inicia un nuevo proceso de admisión o matrícula regular para estudiantes nuevos.</p>
            <button class="btn-premium-logout" id="btnStartProcess" style="width: auto; padding: 0.8rem 2.5rem; margin-top: 1rem;" onclick="openModal('enrollmentModal')">
                <i class="fas fa-play"></i> Iniciar Trámite
            </button>
        </div>
    </div>
    @endif

    @if(Auth::user()->isAdmin())
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <h3 style="font-family: var(--font-display); font-size: 1.3rem;"><i class="fas fa-list-ul" style="color: var(--accent-red);"></i> Todas las Solicitudes</h3>
        <button class="btn-premium-logout" style="width: auto; padding: 10px 20px; font-size: 0.8rem;" onclick="openModal('enrollmentModal')">
            <i class="fas fa-plus"></i> Inscripción Manual
        </button>
    </div>
    @endif

    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title"><i class="fas fa-history"></i> {{ Auth::user()->isAdmin() ? 'Registro General' : 'Mi Historial Reciente' }}</h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1rem; max-height: 600px; overflow-y: auto;">
            @forelse($enrollments as $enrollment)
                <div style="padding: 1.2rem; border-left: 4px solid {{ $enrollment->status == 'approved' ? '#2ecc71' : ($enrollment->status == 'pending' ? '#f39c12' : '#e74c3c') }}; background: rgba(255,255,255,0.02); border-radius: 0 16px 16px 0; transition: var(--transition-smooth); position: relative;">
                    <div style="display: flex; justify-content: space-between; align-items: flex-start; flex-wrap: wrap; gap: 1rem;">
                        <div>
                            <div style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 5px;">{{ $enrollment->created_at->diffForHumans() }}</div>
                            <div style="font-weight: 700; font-family: var(--font-display); font-size: 1.05rem;">{{ ucfirst($enrollment->type) }} - {{ $enrollment->career->name }}</div>
                            <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 4px;">Solicitud #INS-{{ str_pad($enrollment->id, 5, '0', STR_PAD_LEFT) }}</div>
                            @if(Auth::user()->isAdmin())
                                <div style="font-size: 0.85rem; margin-top: 8px; color: var(--text-main);">Estudiante: <strong>{{ $enrollment->user->name }}</strong></div>
                            @endif
                        </div>
                        <div style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                            <span style="font-size: 0.7rem; font-weight: 800; text-transform: uppercase; padding: 4px 10px; border-radius: 20px; background: {{ $enrollment->status == 'approved' ? 'rgba(46, 204, 113, 0.1)' : ($enrollment->status == 'pending' ? 'rgba(243, 156, 18, 0.1)' : 'rgba(231, 76, 60, 0.1)') }}; color: {{ $enrollment->status == 'approved' ? '#2ecc71' : ($enrollment->status == 'pending' ? '#f39c12' : '#e74c3c') }};">
                                {{ $enrollment->status }}
                            </span>
                            <a href="{{ route('enrollments.pdf', $enrollment->id) }}" class="action-btn" title="Descargar Ficha PDF" style="width: 32px; height: 32px; font-size: 0.8rem;">
                                <i class="fas fa-file-pdf"></i>
                            </a>
                        </div>
                    </div>
                </div>
            @empty
                <div style="text-align: center; padding: 3rem; color: var(--text-muted);">
                    <i class="fas fa-folder-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>No hay trámites registrados.</p>
                </div>
            @endforelse
        </div>
    </div>
</div>

<!-- Modal Nueva Inscripción (Shared) -->
<div id="enrollmentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5); max-width: 500px; width: 90%;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-file-signature" style="color: var(--accent-red);"></i> {{ Auth::user()->isAdmin() ? 'Inscripción Manual' : 'Solicitud de Inscripción' }}</h3>
            <button onclick="closeModal('enrollmentModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('enrollments.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Tipo de Trámite</label>
                    <select name="type" required class="modal-input" style="width: 100% !important; box-sizing: border-box !important;">
                        <option value="">Seleccione una opción...</option>
                        <option value="regular">Matrícula Regular</option>
                        <option value="traslado">Traslado Externo</option>
                        <option value="reingreso">Reingreso Académico</option>
                    </select>
                </div>
                @if(Auth::user()->isAdmin())
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Estudiante</label>
                    <select name="user_id" required class="modal-input" style="width: 100% !important; box-sizing: border-box !important;">
                        @foreach(\App\Models\User::where('role', '!=', 'admin')->get() as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>
                @endif
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Carrera Destino</label>
                    <select name="career_id" required class="modal-input" style="width: 100% !important; box-sizing: border-box !important;">
                        @foreach(\App\Models\Career::all() as $c)
                            <option value="{{ $c->id }}" {{ Auth::user()->career_id == $c->id ? 'selected' : '' }}>{{ $c->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="background: rgba(255,255,255,0.02); border: 1px dashed var(--border-light); padding: 1rem; border-radius: 12px; font-size: 0.8rem; color: var(--text-muted);">
                    <i class="fas fa-info-circle"></i> Al confirmar, se generará el registro y la orden de pago correspondiente.
                </div>
                <button type="submit" class="btn-premium-logout" style="width: 100%; padding: 12px; margin-top: 0.5rem;">{{ Auth::user()->isAdmin() ? 'Registrar Inscripción' : 'Confirmar y Enviar Solicitud' }}</button>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { 
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'flex'; 
    }
    function closeModal(id) { 
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none'; 
    }
</script>
@endsection
