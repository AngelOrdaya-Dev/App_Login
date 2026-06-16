@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap:wrap; gap:1.5rem;">
        <div>
            <h3 class="panel-title"><i class="fas fa-calendar-alt"></i> Horario Semanal</h3>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-top:4px;">
                @if(Auth::user()->isAdmin()) Programación académica completa
                @elseif(Auth::user()->isTeacher()) Tus clases asignadas esta semana
                @else Tus clases según tu carrera
                @endif
            </p>
        </div>
        @if(Auth::user()->isAdmin())
        <button type="button" onclick="openModal('scheduleModal')" class="btn-premium-logout" style="width:auto; padding:8px 20px; font-size:0.85rem;">
            <i class="fas fa-plus"></i> Nuevo Horario
        </button>
        @endif
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

    {{-- Semana Grid --}}
    <div style="display:grid; grid-template-columns: repeat(auto-fill, minmax(200px, 1fr)); gap:1.5rem;">
        @php
            $days = [1=>'Lunes',2=>'Martes',3=>'Miércoles',4=>'Jueves',5=>'Viernes',6=>'Sábado'];
            $dayColors = [
                1 => 'rgba(231,76,60,0.12)',
                2 => 'rgba(52,152,219,0.12)',
                3 => 'rgba(46,204,113,0.12)',
                4 => 'rgba(241,196,15,0.12)',
                5 => 'rgba(155,89,182,0.12)',
                6 => 'rgba(230,126,34,0.12)',
            ];
        @endphp

        @foreach($days as $dayNum => $dayName)
        <div style="background:var(--bg-surface); border:1px solid var(--border-light); border-radius:16px; overflow:hidden;">
            <div style="background:{{ $dayColors[$dayNum] }}; padding:0.9rem 1.2rem; border-bottom:1px solid var(--border-light); display:flex; align-items:center; gap:8px;">
                <i class="fas fa-calendar-day" style="color:var(--accent-red); font-size:0.9rem;"></i>
                <span style="font-weight:700; font-size:0.9rem; font-family:var(--font-display);">{{ $dayName }}</span>
                <span style="margin-left:auto; font-size:0.7rem; background:rgba(255,255,255,0.07); padding:2px 8px; border-radius:20px; color:var(--text-muted);">
                    {{ $grid[$dayNum]->count() }} clase(s)
                </span>
            </div>

            <div style="padding:0.8rem; display:flex; flex-direction:column; gap:0.7rem; min-height:120px;">
                @forelse($grid[$dayNum] as $slot)
                <div style="background:rgba(255,255,255,0.03); border:1px solid var(--border-light); border-radius:10px; padding:0.8rem; position:relative;">
                    <div style="font-size:0.75rem; color:var(--accent-red); font-weight:700; margin-bottom:4px;">
                        <i class="fas fa-clock"></i>
                        {{ \Carbon\Carbon::parse($slot->start_time)->format('H:i') }} – {{ \Carbon\Carbon::parse($slot->end_time)->format('H:i') }}
                    </div>
                    <div style="font-size:0.85rem; font-weight:600; color:var(--text-main);">{{ $slot->course->name }}</div>
                    <div style="font-size:0.75rem; color:var(--text-muted); margin-top:3px;">
                        <i class="fas fa-door-open"></i> {{ $slot->classroom->name }}
                        @if($slot->course->teacher)
                        · <i class="fas fa-user-tie"></i> <strong>{{ $slot->course->teacher->name }}</strong>
                        @endif
                    </div>

                    {{-- Docente: botón de asistencia --}}
                    @if(Auth::user()->isTeacher() || Auth::user()->isAdmin())
                    <a href="{{ route('attendance.form', $slot->course_id) }}"
                       style="position:absolute; top:8px; right:8px; font-size:0.7rem; background:rgba(46,204,113,0.15); color:#2ecc71; border:1px solid rgba(46,204,113,0.3); padding:3px 8px; border-radius:8px; text-decoration:none; display:flex; align-items:center; gap:4px;">
                        <i class="fas fa-clipboard-check"></i> Lista
                    </a>
                    @endif

                    @if(Auth::user()->isAdmin())
                    <form action="{{ route('schedules.destroy', $slot->id) }}" method="POST" style="position:absolute; bottom:6px; right:8px;" onsubmit="return confirm('¿Eliminar este horario?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background:transparent; border:none; color:#e74c3c; cursor:pointer; font-size:0.8rem;"><i class="fas fa-trash-alt"></i></button>
                    </form>
                    @endif
                </div>
                @empty
                <div style="text-align:center; color:var(--text-muted); font-size:0.8rem; padding:1rem 0; opacity:0.5;">Sin clases</div>
                @endforelse
            </div>
        </div>
        @endforeach
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

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
</script>
@endsection
