@extends('layouts.admin')

@section('content')
<div class="hero-card" style="margin-bottom: 2rem;">
    <div class="hero-content">
        <h1>Centro de <br><span>Inscripciones</span></h1>
        <p>Gestiona los procesos de matrícula, solicitudes de traslado y aperturas de nuevos ciclos académicos.</p>
    </div>
    <div style="font-size: 6rem; color: rgba(255,0,0,0.1); position: absolute; right: 5%; top: 50%; transform: translateY(-50%); pointer-events: none;">
        <i class="fas fa-file-signature"></i>
    </div>
</div>

<div class="dashboard-grid" style="grid-template-columns: 1fr 1fr;">
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
            <button class="btn-premium-logout" id="btnStartProcess" style="width: auto; padding: 0.8rem 2rem; margin-top: 1rem;" onclick="startEnrollment()">
                <i class="fas fa-play"></i> Iniciar Trámite
            </button>
        </div>
    </div>

    <script>
        function startEnrollment() {
            const btn = document.getElementById('btnStartProcess');
            const originalText = btn.innerHTML;
            btn.disabled = true;
            btn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Procesando...';
            
            setTimeout(() => {
                alert('¡Proceso de Inscripción iniciado con éxito! Se ha generado tu número de solicitud: INS-2026-8941');
                btn.disabled = false;
                btn.innerHTML = originalText;
            }, 1500);
        }
    </script>

    <div class="panel">
        <div class="panel-header">
            <h3 class="panel-title"><i class="fas fa-history"></i> Historial Reciente</h3>
        </div>
        <div style="display: flex; flex-direction: column; gap: 1rem;">
            <!-- Placeholder items -->
            <div style="padding: 1rem; border-left: 3px solid var(--accent-red); background: rgba(255,255,255,0.02); border-radius: 0 10px 10px 0;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px;">Hace 2 horas</div>
                <div style="font-weight: 600;">Matrícula Regular - Ciclo 2026-I</div>
                <div style="font-size: 0.85rem; color: #2ecc71; margin-top: 5px;">Completado</div>
            </div>
            <div style="padding: 1rem; border-left: 3px solid #f39c12; background: rgba(255,255,255,0.02); border-radius: 0 10px 10px 0;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px;">Ayer</div>
                <div style="font-weight: 600;">Traslado Externo - Ing. Sistemas</div>
                <div style="font-size: 0.85rem; color: #f39c12; margin-top: 5px;">En Revisión</div>
            </div>
            <div style="padding: 1rem; border-left: 3px solid var(--text-muted); background: rgba(255,255,255,0.02); border-radius: 0 10px 10px 0;">
                <div style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 5px;">Hace 3 días</div>
                <div style="font-weight: 600;">Reserva de Matrícula</div>
                <div style="font-size: 0.85rem; color: var(--text-muted); margin-top: 5px;">Pendiente de Pago</div>
            </div>
        </div>
    </div>
</div>
@endsection
