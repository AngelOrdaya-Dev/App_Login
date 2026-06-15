@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 1rem; margin-bottom: 2rem;">
        <h3 class="panel-title"><i class="fas fa-edit"></i> Gestión de Calificaciones</h3>
        <button type="button" class="btn-premium-logout" style="width: auto; padding: 8px 20px;" onclick="openModal('addGradeModal')">
            <i class="fas fa-plus"></i> Ingresar Nota
        </button>
    </div>

    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-light); text-align: left;">
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Estudiante</th>
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Curso</th>
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Nota</th>
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($grades as $grade)
                    <tr style="border-bottom: 1px solid var(--border-light);">
                        <td style="padding: 15px;">
                            <div style="font-weight: 600;">{{ $grade->user->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $grade->user->email }}</div>
                        </td>
                        <td style="padding: 15px;">{{ $grade->course->name }}</td>
                        <td style="padding: 15px;">
                            <span style="font-weight: 800; color: {{ $grade->grade >= 11 ? '#2ecc71' : '#e74c3c' }};">
                                {{ number_format($grade->grade, 1) }}
                            </span>
                        </td>
                        <td style="padding: 15px; display: flex; gap: 10px;">
                            <button class="action-btn" title="Editar" 
                                    onclick="editGrade({{ $grade->id }}, '{{ $grade->user->name }}', '{{ $grade->course->name }}', {{ $grade->grade }})">
                                <i class="fas fa-pen-to-square"></i>
                            </button>
                            <form action="{{ route('grades.destroy', $grade->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar esta calificación?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="action-btn" title="Eliminar" style="color: #e74c3c; border-color: rgba(231, 76, 60, 0.2);">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Ingresar Nota -->
<div id="addGradeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-plus-circle" style="color: var(--accent-red);"></i> Ingresar Calificación</h3>
            <button onclick="closeModal('addGradeModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('grades.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Estudiante</label>
                    <select name="user_id" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 10px;">
                        @foreach($students as $student)
                            <option value="{{ $student->id }}">{{ $student->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Curso</label>
                    <select name="course_id" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 10px;">
                        @foreach($courses as $course)
                            <option value="{{ $course->id }}">{{ $course->name }} ({{ $course->career->name }})</option>
                        @endforeach
                    </select>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Calificación (0-20)</label>
                    <input type="number" name="grade" step="0.1" min="0" max="20" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 10px;">
                </div>
                <button type="submit" class="btn-premium-logout" style="width: 100%; padding: 12px;">Registrar Calificación</button>
            </div>
        </form>
    </div>
</div>

<!-- Modal Editar Nota -->
<div id="editGradeModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-edit" style="color: var(--accent-red);"></i> Editar Calificación</h3>
            <button onclick="closeModal('editGradeModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer;"><i class="fas fa-times"></i></button>
        </div>
        
        <form id="editGradeForm" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Estudiante</label>
                    <input type="text" id="edit_student_name" readonly style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-muted); padding: 12px; border-radius: 10px; cursor: not-allowed;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Curso</label>
                    <input type="text" id="edit_course_name" readonly style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-muted); padding: 12px; border-radius: 10px; cursor: not-allowed;">
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Nueva Calificación (0-20)</label>
                    <input type="number" name="grade" id="edit_grade_value" step="0.1" min="0" max="20" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 10px;">
                </div>
                <button type="submit" class="btn-premium-logout" style="width: 100%; padding: 12px;">Actualizar Calificación</button>
            </div>
        </form>
    </div>
</div>

<script>
    function editGrade(id, studentName, courseName, grade) {
        const form = document.getElementById('editGradeForm');
        form.action = `/notas/${id}`;
        document.getElementById('edit_student_name').value = studentName;
        document.getElementById('edit_course_name').value = courseName;
        document.getElementById('edit_grade_value').value = grade;
        openModal('editGradeModal');
    }
</script>
@endsection
