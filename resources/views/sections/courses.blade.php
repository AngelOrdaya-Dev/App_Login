@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
        <h3 class="panel-title"><i class="fas fa-chalkboard"></i> Gestión de Cursos y Docentes</h3>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="background: rgba(255,255,255,0.02); border-radius: 20px; border: 1px solid var(--border-light); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead style="background: rgba(255,255,255,0.03); text-align: left;">
                <tr>
                    <th style="padding: 1.5rem;">Nombre del Curso</th>
                    <th style="padding: 1.5rem;">Carrera</th>
                    <th style="padding: 1.5rem;">Créditos</th>
                    <th style="padding: 1.5rem;">Docente Asignado</th>
                    <th style="padding: 1.5rem;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($courses as $course)
                <tr style="border-bottom: 1px solid var(--border-light);">
                    <td style="padding: 1.5rem;">
                        <div style="font-weight: 700; color: var(--text-main);">{{ $course->name }}</div>
                        <div style="font-size: 0.7rem; color: var(--text-muted); font-weight: 600;">CUR-{{ str_pad($course->id, 3, '0', STR_PAD_LEFT) }}</div>
                    </td>
                    <td style="padding: 1.5rem; color: var(--text-muted);">{{ $course->career->name ?? 'N/A' }}</td>
                    <td style="padding: 1.5rem;">
                        <span style="background: rgba(255,0,0,0.15); color: var(--accent-red); padding: 5px 12px; border-radius: 6px; font-weight: 800; font-size: 0.7rem; white-space: nowrap; border: 1px solid rgba(255,0,0,0.25); display: inline-block;">
                            {{ $course->credits }} CRED.
                        </span>
                    </td>
                    <td style="padding: 1.5rem;">
                        @if($course->teacher)
                            <div style="display: flex; align-items: center; gap: 10px;">
                                <div style="width: 32px; height: 32px; border-radius: 50%; background: var(--accent-red); display: flex; align-items: center; justify-content: center; font-weight: 900; font-size: 0.7rem; color: #fff;">
                                    {{ strtoupper(substr($course->teacher->name, 0, 1)) }}
                                </div>
                                <div style="font-size: 0.9rem; color: var(--text-main);">{{ $course->teacher->name }}</div>
                            </div>
                        @else
                            <span style="color: #e74c3c; font-size: 0.85rem; font-style: italic;"><i class="fas fa-exclamation-circle"></i> Sin docente asignado</span>
                        @endif
                    </td>
                    <td style="padding: 1.5rem;">
                        <form action="{{ route('courses.assign', $course->id) }}" method="POST" style="display: flex; gap: 10px; align-items: center;">
                            @csrf
                            <select name="teacher_id" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 8px; border-radius: 10px; font-size: 0.85rem; outline: none;">
                                <option value="">Seleccionar Docente...</option>
                                @foreach($teachers as $teacher)
                                    <option value="{{ $teacher->id }}" {{ $course->teacher_id == $teacher->id ? 'selected' : '' }}>
                                        {{ $teacher->name }}
                                    </option>
                                @endforeach
                            </select>
                            <button type="submit" class="btn-premium-logout" style="width: auto; padding: 8px 15px; font-size: 0.8rem;">
                                <i class="fas fa-user-plus"></i> Asignar
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <!-- Info Card -->
    <div style="margin-top: 2rem; background: rgba(52, 152, 219, 0.05); border: 1px solid rgba(52, 152, 219, 0.2); padding: 1.5rem; border-radius: 20px; display: flex; align-items: center; gap: 1.5rem;">
        <div style="width: 50px; height: 50px; border-radius: 15px; background: rgba(52, 152, 219, 0.2); display: flex; align-items: center; justify-content: center; color: #3498db; font-size: 1.5rem;">
            <i class="fas fa-info-circle"></i>
        </div>
        <div>
            <h5 style="color: var(--text-main); margin-bottom: 5px;">Ayuda de Administración</h5>
            <p style="color: var(--text-muted); font-size: 0.85rem; margin: 0;">Aquí puedes vincular a tus docentes con sus respectivos cursos. Una vez asignados, los docentes podrán ver estos cursos en su salón virtual y gestionar las notas de los alumnos matriculados.</p>
        </div>
    </div>
</div>
@endsection
