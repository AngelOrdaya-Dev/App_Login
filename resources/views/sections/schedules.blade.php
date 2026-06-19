@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header schedule-topbar">
        <div>
            <h3 class="panel-title"><i class="fas fa-calendar-alt"></i> Horario Semanal</h3>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-top:4px;">
                @if(Auth::user()->isAdmin()) Programación académica completa
                @elseif(Auth::user()->isTeacher()) Tus clases asignadas esta semana
                @else Tus clases según tu carrera
                @endif
            </p>
        </div>
        <div class="schedule-topbar-actions">
            <div id="view-switcher" class="view-switcher-wrap">
                <button class="view-btn" id="btn-week" onclick="switchView('timeGridWeek', this)">
                    <i class="fas fa-table"></i> <span>Semana</span>
                </button>
                <button class="view-btn" id="btn-list" onclick="switchView('listWeek', this)">
                    <i class="fas fa-list"></i> <span>Lista</span>
                </button>
            </div>
            @if(Auth::user()->isAdmin())
            <button type="button" onclick="openModal('scheduleModal')" class="btn-premium-logout schedule-new-btn">
                <i class="fas fa-plus"></i> <span class="btn-text-full">Nuevo Horario</span><span class="btn-text-short">Nuevo</span>
            </button>
            @endif
        </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(46,204,113,0.1); color:#2ecc71; padding:1rem; border-radius:12px; margin-bottom:1.5rem; border:1px solid rgba(46,204,113,0.3);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif
    @if(session('error'))
    <div style="background:rgba(231,76,60,0.1); color:#e74c3c; padding:1rem; border-radius:12px; margin-bottom:1.5rem; border:1px solid rgba(231,76,60,0.3);">
        <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
    </div>
    @endif

    {{-- FullCalendar Container --}}
    <div id="calendar-container" style="min-height: 600px;">
        <div id="calendar"></div>
    </div>
</div>

{{-- Event Detail Modal --}}
<div id="eventDetailModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.85); backdrop-filter:blur(8px); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:var(--bg-surface); border:1px solid var(--border-light); border-radius:24px; padding:2.5rem; width:100%; max-width:420px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); position: relative;">
        <div style="position: absolute; top: -20px; left: 50%; transform: translateX(-50%); background: var(--accent-red); width: 50px; height: 50px; border-radius: 50%; display: flex; align-items: center; justify-content: center; border: 4px solid var(--bg-surface); box-shadow: 0 0 20px rgba(255,0,0,0.4);">
            <i class="fas fa-book-open" style="color: #fff;"></i>
        </div>
        <div style="text-align: center; margin-top: 1.5rem;">
            <h3 id="eventTitle" style="font-family: var(--font-display); font-size: 1.2rem; margin-bottom: 1.5rem; color: var(--text-main);"></h3>
        </div>
        <div id="eventDetails" style="display: flex; flex-direction: column; gap: 12px; margin-bottom: 1.5rem;"></div>
        <div style="display: flex; justify-content: center; gap: 10px;">
            @if(Auth::user()->isTeacher() || Auth::user()->isAdmin())
            <a id="attendanceLink" href="#" class="btn-premium-logout" style="width: auto; padding: 10px 20px; font-size: 0.85rem; border-radius: 12px;">
                <i class="fas fa-clipboard-check"></i> Lista de Asistencia
            </a>
            @endif
            @if(Auth::user()->isAdmin())
            <form id="deleteScheduleForm" method="POST" onsubmit="return confirm('¿Eliminar este horario?')">
                @csrf @method('DELETE')
                <button type="submit" style="padding: 10px 20px; font-size: 0.85rem; background: rgba(231,76,60,0.1); color: #e74c3c; border: 1px solid rgba(231,76,60,0.3); border-radius: 12px; cursor: pointer; font-weight: 600;">
                    <i class="fas fa-trash-alt"></i>
                </button>
            </form>
            @endif
            <button type="button" onclick="closeModal('eventDetailModal')" style="padding: 10px 20px; font-size: 0.85rem; background: rgba(255,255,255,0.05); color: var(--text-muted); border: 1px solid var(--border-light); border-radius: 12px; cursor: pointer; font-weight: 600;">
                Cerrar
            </button>
        </div>
    </div>
</div>

{{-- Modal Nuevo Horario (solo Admin) --}}
@if(Auth::user()->isAdmin())
<div id="scheduleModal" style="display:none; position:fixed; top:0; left:0; width:100%; height:100%; background:rgba(0,0,0,0.8); backdrop-filter:blur(5px); z-index:9999; align-items:center; justify-content:center;">
    <div style="background:var(--bg-surface); border:1px solid var(--border-light); border-radius:24px; padding:2.5rem; width:100%; max-width:520px; box-shadow:0 25px 50px -12px rgba(0,0,0,0.5); max-height:90vh; overflow-y:auto;">
        <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem;">
            <h3 style="font-family:var(--font-display); font-size:1.3rem;"><i class="fas fa-calendar-plus" style="color:var(--accent-red);"></i> Nuevo Horario</h3>
            <button onclick="closeModal('scheduleModal')" style="background:transparent; border:none; color:var(--text-muted); cursor:pointer; font-size:1.2rem;"><i class="fas fa-times"></i></button>
        </div>

        <form action="{{ route('schedules.store') }}" method="POST">
            @csrf
            <div style="display:flex; flex-direction:column; gap:1.2rem;">
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label class="modal-label">Curso</label>
                    <select name="course_id" class="modal-input" required>
                        <option value="" disabled selected>Selecciona un curso...</option>
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">
                                {{ $course->name }} - [{{ $course->teacher->name ?? 'Sin Docente' }}]
                            </option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label class="modal-label">Aula</label>
                    <select name="classroom_id" class="modal-input" required>
                        <option value="" disabled selected>Selecciona un aula...</option>
                        @foreach($classrooms as $room)
                            <option value="{{ $room->id }}">{{ $room->name }} (Cap. {{ $room->capacity }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:flex; flex-direction:column; gap:6px;">
                    <label class="modal-label">Día de la Semana</label>
                    <select name="day_of_week" class="modal-input" required>
                        <option value="" disabled selected>Selecciona un día...</option>
                        @foreach(\App\Models\Schedule::DAYS as $num => $name)
                            <option value="{{ $num }}">{{ $name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label class="modal-label">Hora Inicio</label>
                        <input type="time" name="start_time" class="modal-input" required>
                    </div>
                    <div style="display:flex; flex-direction:column; gap:6px;">
                        <label class="modal-label">Hora Fin</label>
                        <input type="time" name="end_time" class="modal-input" required>
                    </div>
                </div>

                <div style="margin-top:0.5rem; display:flex; gap:1rem;">
                    <button type="button" onclick="closeModal('scheduleModal')" style="flex:1; background:rgba(255,255,255,0.05); color:var(--text-main); border:1px solid var(--border-light); padding:12px; border-radius:12px; cursor:pointer; font-weight:600;">Cancelar</button>
                    <button type="submit" class="btn-premium-logout" style="flex:1; width:auto; padding:12px; border-radius:12px;">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endif

<style>
    /* ---- Topbar ---- */
    .schedule-topbar {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
        flex-wrap: wrap;
        gap: 1rem;
    }
    .schedule-topbar-actions {
        display: flex;
        gap: 10px;
        align-items: center;
        flex-wrap: wrap;
    }
    .view-switcher-wrap {
        display: flex;
        background: var(--bg-card);
        border: 1px solid var(--border-light);
        border-radius: 12px;
        padding: 4px;
        gap: 4px;
    }
    .view-btn {
        background: transparent;
        border: none;
        color: var(--text-muted);
        font-size: 0.8rem;
        padding: 6px 12px;
        border-radius: 8px;
        cursor: pointer;
        font-weight: 600;
        transition: 0.2s;
        display: flex;
        align-items: center;
        gap: 6px;
        white-space: nowrap;
    }
    .view-btn.active {
        background: var(--accent-red);
        color: #fff;
        box-shadow: 0 3px 10px rgba(255,0,0,0.3);
    }
    .view-btn:hover:not(.active) { color: var(--text-main); background: rgba(255,255,255,0.05); }
    .btn-text-short { display: none; }

    /* ---- FullCalendar Dark Override ---- */
    #calendar {
        --fc-border-color: var(--border-light);
        --fc-page-bg-color: transparent;
        --fc-neutral-bg-color: rgba(255,255,255,0.03);
        --fc-list-event-hover-bg-color: rgba(255,0,0,0.05);
        --fc-today-bg-color: rgba(255, 0, 0, 0.04);
        --fc-now-indicator-color: var(--accent-red);
        --fc-event-border-color: transparent;
    }
    .fc .fc-toolbar { flex-wrap: wrap; gap: 8px; }
    .fc .fc-toolbar-title { font-family: var(--font-display); font-size: 1rem; color: var(--text-main); }
    .fc .fc-button { background: rgba(255,255,255,0.05) !important; border: 1px solid var(--border-light) !important; color: var(--text-main) !important; font-size: 0.78rem !important; padding: 5px 10px !important; }
    .fc .fc-button:hover { background: rgba(255,255,255,0.1) !important; }
    .fc .fc-button-primary:not(:disabled).fc-button-active { background: var(--accent-red) !important; border-color: var(--accent-red) !important; }
    .fc .fc-col-header-cell-cushion { color: var(--text-muted); font-size: 0.72rem; text-transform: uppercase; letter-spacing: 0.5px; font-weight: 700; text-decoration: none; }
    .fc .fc-timegrid-slot-label-cushion { color: var(--text-muted); font-size: 0.7rem; }
    .fc .fc-event { border-radius: 6px !important; border: none !important; padding: 2px 5px; font-size: 0.72rem; font-weight: 700; cursor: pointer; line-height: 1.3; }
    .fc .fc-event:hover { filter: brightness(1.15); }
    .fc .fc-list-event { background: transparent; }
    .fc .fc-list-event-title a { color: var(--text-main); text-decoration: none; font-weight: 600; font-size: 0.9rem; }
    .fc .fc-list-event-time { color: var(--text-muted); font-size: 0.8rem; }
    .fc .fc-list-day-cushion { background: rgba(255,255,255,0.03); color: var(--accent-red); font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; }
    .fc .fc-list-empty { background: transparent; color: var(--text-muted); padding: 3rem; text-align: center; }
    .fc .fc-scrollgrid-section > * { border-color: var(--border-light) !important; }
    .fc td, .fc th { border-color: var(--border-light) !important; }

    /* ---- Event Detail Modal ---- */
    .event-detail-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 15px;
        background: rgba(255,255,255,0.02);
        border: 1px solid var(--border-light);
        border-radius: 12px;
    }
    .event-detail-row i { color: var(--accent-red); width: 18px; text-align: center; }
    .event-detail-row span { font-size: 0.9rem; color: var(--text-main); }

    /* ---- MÓVIL ---- */
    @media (max-width: 640px) {
        .schedule-topbar { margin-bottom: 1rem; }
        .view-btn span { display: none; } /* Sólo icono en móvil */
        .view-btn { padding: 6px 10px; }
        .btn-text-full { display: none; }
        .btn-text-short { display: inline; }
        .schedule-new-btn { padding: 8px 14px !important; font-size: 0.8rem !important; }
        .fc .fc-toolbar-title { font-size: 0.9rem; }
        .fc .fc-button { font-size: 0.72rem !important; padding: 4px 8px !important; }
        .fc .fc-list-event-title a { font-size: 0.85rem; }
        .fc .fc-list-event-time { font-size: 0.75rem; }
    }
</style>

<!-- FullCalendar CDN -->
<link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.11/index.global.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@6.1.11/locales/es.global.min.js"></script>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }

    let calendarInstance = null;

    function switchView(viewName, btn) {
        if (calendarInstance) calendarInstance.changeView(viewName);
        document.querySelectorAll('.view-btn').forEach(b => b.classList.remove('active'));
        btn.classList.add('active');
    }

    document.addEventListener('DOMContentLoaded', function() {
        const isMobile = window.innerWidth < 640;
        const calendarEl = document.getElementById('calendar');

        // En móvil: activar botón de lista por defecto
        if (isMobile) {
            document.getElementById('btn-list').classList.add('active');
        } else {
            document.getElementById('btn-week').classList.add('active');
        }

        calendarInstance = new FullCalendar.Calendar(calendarEl, {
            initialView: isMobile ? 'listWeek' : 'timeGridWeek',
            locale: 'es',
            headerToolbar: {
                left: 'prev,next today',
                center: 'title',
                right: ''
            },
            allDaySlot: false,
            nowIndicator: true,
            slotMinTime: '07:00:00',
            slotMaxTime: '22:00:00',
            height: 'auto',
            expandRows: true,
            weekends: true,
            businessHours: {
                daysOfWeek: [1, 2, 3, 4, 5, 6],
                startTime: '07:00',
                endTime: '22:00',
            },
            events: @json($calendarEvents),
            eventClick: function(info) {
                const event = info.event;
                const props = event.extendedProps;

                document.getElementById('eventTitle').textContent = event.title;

                const detailsHtml = `
                    <div class="event-detail-row">
                        <i class="fas fa-clock"></i>
                        <span>${event.startStr.split('T')[1] ? new Date(event.start).toLocaleTimeString('es', {hour:'2-digit',minute:'2-digit'}) : ''} – ${event.endStr ? new Date(event.end).toLocaleTimeString('es', {hour:'2-digit',minute:'2-digit'}) : ''}</span>
                    </div>
                    <div class="event-detail-row">
                        <i class="fas fa-door-open"></i>
                        <span>${props.classroom}</span>
                    </div>
                    <div class="event-detail-row">
                        <i class="fas fa-user-tie"></i>
                        <span>${props.teacher}</span>
                    </div>
                `;
                document.getElementById('eventDetails').innerHTML = detailsHtml;

                const attLink = document.getElementById('attendanceLink');
                if (attLink) {
                    attLink.href = '/asistencia/' + props.course_id;
                }

                const deleteForm = document.getElementById('deleteScheduleForm');
                if (deleteForm) {
                    deleteForm.action = '/horarios/' + props.schedule_id;
                }

                openModal('eventDetailModal');
            },
            eventDidMount: function(info) {
                info.el.style.boxShadow = '0 3px 10px rgba(255,0,0,0.3)';
            }
        });

        calendarInstance.render();
    });
</script>
@endsection
