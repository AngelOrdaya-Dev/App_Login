@extends('layouts.admin')

@section('content')
<div class="panel">
    <div style="display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; flex-wrap:wrap; gap:1rem;">
        <div>
            <h3 class="panel-title"><i class="fas fa-clipboard-check"></i> Control de Asistencia</h3>
            <p style="color:var(--text-muted); font-size:0.85rem; margin-top:4px;">
                <strong style="color:var(--text-main);">{{ $course->name }}</strong>
                · {{ $course->career->name ?? '' }}
            </p>
        </div>
        <div style="display:flex; align-items:center; gap:12px; flex-wrap:wrap;">
            <input type="date" id="attendanceDate" value="{{ $today }}"
                style="background:rgba(255,255,255,0.05); border:1px solid var(--border-light); color:var(--text-main); padding:8px 14px; border-radius:10px; font-size:0.85rem; outline:none;"
                onchange="window.location.href='{{ route('attendance.form', $course->id) }}?date='+this.value">
            <a href="{{ route('teacher.courses') }}" style="color:var(--text-muted); font-size:0.85rem; text-decoration:none; display:flex; align-items:center; gap:6px;">
                <i class="fas fa-arrow-left"></i> Volver
            </a>
        </div>
    </div>

    @if(session('success'))
    <div style="background:rgba(46,204,113,0.1); color:#2ecc71; padding:1rem; border-radius:12px; margin-bottom:1.5rem; border:1px solid rgba(46,204,113,0.3);">
        <i class="fas fa-check-circle"></i> {{ session('success') }}
    </div>
    @endif

    {{-- Summary pills --}}
    <div style="display:flex; gap:1rem; margin-bottom:2rem; flex-wrap:wrap;">
        <div style="background:rgba(46,204,113,0.1); border:1px solid rgba(46,204,113,0.2); border-radius:10px; padding:0.6rem 1rem; font-size:0.8rem; display:flex; align-items:center; gap:6px; color:#2ecc71;">
            <i class="fas fa-user-check"></i> <span id="countPresente">0</span> Presentes
        </div>
        <div style="background:rgba(231,76,60,0.1); border:1px solid rgba(231,76,60,0.2); border-radius:10px; padding:0.6rem 1rem; font-size:0.8rem; display:flex; align-items:center; gap:6px; color:#e74c3c;">
            <i class="fas fa-user-times"></i> <span id="countAusente">0</span> Ausentes
        </div>
        <div style="background:rgba(241,196,15,0.1); border:1px solid rgba(241,196,15,0.2); border-radius:10px; padding:0.6rem 1rem; font-size:0.8rem; display:flex; align-items:center; gap:6px; color:#f1c40f;">
            <i class="fas fa-user-clock"></i> <span id="countTardanza">0</span> Tardanzas
        </div>
    </div>

    <form action="{{ route('attendance.save', $course->id) }}" method="POST">
        @csrf
        <input type="hidden" name="date" value="{{ $today }}">

        <div class="table-responsive" style="background:var(--bg-surface); border:1px solid var(--border-color); border-radius:16px; overflow:hidden;">
            <table style="width:100%; border-collapse:collapse; text-align:left;">
                <thead style="background:rgba(255,255,255,0.03); border-bottom:1px solid var(--border-light);">
                    <tr>
                        <th style="padding:1rem 1.2rem; color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:1px;">#</th>
                        <th style="padding:1rem 1.2rem; color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:1px;">Estudiante</th>
                        <th style="padding:1rem 1.2rem; color:var(--text-muted); font-size:0.78rem; text-transform:uppercase; letter-spacing:1px;">Estado</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($students as $i => $student)
                    @php $currentStatus = $existing[$student->id] ?? 'presente'; @endphp
                    <tr class="att-row" data-status="{{ $currentStatus }}" style="border-bottom:1px solid var(--border-light); transition:background 0.2s;">
                        <td style="padding:1rem 1.2rem; color:var(--text-muted); font-size:0.85rem;">{{ $i + 1 }}</td>
                        <td style="padding:1rem 1.2rem;">
                            <div style="display:flex; align-items:center; gap:10px;">
                                @if($student->avatar)
                                    <img src="{{ $student->avatar }}" style="width:32px; height:32px; border-radius:50%; object-fit:cover;" referrerpolicy="no-referrer">
                                @else
                                    <div style="width:32px; height:32px; border-radius:50%; background:linear-gradient(135deg,#e74c3c,#800000); display:flex; align-items:center; justify-content:center; font-weight:700; font-size:0.8rem; color:#fff; flex-shrink:0;">
                                        {{ strtoupper(substr($student->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <div style="font-weight:600;">{{ $student->name }}</div>
                                    <div style="font-size:0.75rem; color:var(--text-muted);">{{ $student->email }}</div>
                                </div>
                            </div>
                        </td>
                        <td style="padding:1rem 1.2rem;">
                            <div style="display:flex; gap:8px; flex-wrap:wrap;">
                                @foreach(['presente' => ['#2ecc71','fa-user-check'], 'ausente' => ['#e74c3c','fa-user-times'], 'tardanza' => ['#f1c40f','fa-user-clock']] as $status => [$color, $icon])
                                <label style="cursor:pointer;">
                                    <input type="radio" name="status[{{ $student->id }}]" value="{{ $status }}"
                                        {{ $currentStatus === $status ? 'checked' : '' }}
                                        class="att-radio" data-status="{{ $status }}"
                                        style="display:none;">
                                    <span class="att-pill att-{{ $status }} {{ $currentStatus === $status ? 'att-active' : '' }}"
                                        style="display:inline-flex; align-items:center; gap:5px; padding:5px 12px; border-radius:20px; font-size:0.75rem; font-weight:600; border:1px solid rgba(255,255,255,0.08); transition:all 0.2s; user-select:none;
                                        {{ $currentStatus === $status ? "background:rgba({$color},0.15); color:{$color}; border-color:{$color};" : 'color:var(--text-muted);' }}">
                                        <i class="fas {{ $icon }}"></i> {{ ucfirst($status) }}
                                    </span>
                                </label>
                                @endforeach
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="3" style="text-align:center; padding:3rem; color:var(--text-muted);">
                            <i class="fas fa-users-slash" style="font-size:2rem; display:block; margin-bottom:0.5rem; opacity:0.4;"></i>
                            No hay alumnos inscritos en esta carrera aún.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if($students->count() > 0)
        <div style="margin-top:1.5rem; display:flex; justify-content:flex-end; gap:1rem;">
            <button type="submit" class="btn-premium-logout" style="width:auto; padding:10px 28px; border-radius:12px;">
                <i class="fas fa-save"></i> Guardar Asistencia
            </button>
        </div>
        @endif
    </form>
</div>

<style>
    .att-row:hover { background: rgba(255,255,255,0.02); }
    .att-pill { cursor:pointer; }
    .att-pill:hover { opacity:0.85; transform:scale(1.03); }
</style>

<script>
document.addEventListener('DOMContentLoaded', function () {
    function updateCounts() {
        let counts = { presente: 0, ausente: 0, tardanza: 0 };
        document.querySelectorAll('.att-radio:checked').forEach(r => counts[r.dataset.status]++);
        document.getElementById('countPresente').textContent = counts.presente;
        document.getElementById('countAusente').textContent = counts.ausente;
        document.getElementById('countTardanza').textContent = counts.tardanza;
    }

    document.querySelectorAll('.att-radio').forEach(radio => {
        radio.addEventListener('change', function () {
            // Update pill styles in the same row
            const row = this.closest('tr');
            row.querySelectorAll('.att-pill').forEach(p => {
                p.style.background = '';
                p.style.color = 'var(--text-muted)';
                p.style.borderColor = 'rgba(255,255,255,0.08)';
            });
            const active = row.querySelector(`input[value="${this.value}"] + .att-pill`) || this.nextElementSibling;
            const colors = { presente: '#2ecc71', ausente: '#e74c3c', tardanza: '#f1c40f' };
            const c = colors[this.value];
            if (active) {
                active.style.background = `rgba(${c.replace('#','')},0.15)`;
                active.style.color = c;
                active.style.borderColor = c;
            }
            updateCounts();
        });
    });

    updateCounts();
});
</script>
@endsection
