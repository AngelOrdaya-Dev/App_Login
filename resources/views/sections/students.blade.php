@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title"><i class="fas fa-users"></i> Gestión de Estudiantes</h3>
        <div class="panel-header-actions">
            <form action="{{ route('students') }}" method="GET" style="position: relative; flex: 2; min-width: 180px; display: flex;">
                <i class="fas fa-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: var(--text-muted); font-size: 0.8rem;"></i>
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Buscar estudiante..." style="background: rgba(255,255,255,0.05); border: 1px solid var(--border-light); color: var(--text-main); padding: 8px 15px 8px 35px; border-radius: 8px; font-size: 0.8rem; outline: none; width: 100%;">
                <button type="submit" style="display:none;"></button>
            </form>
            <a href="{{ route('export.students') }}" style="background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 8px 15px; border-radius: 8px; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; justify-content: center; gap: 8px; text-decoration: none; min-width: 100px;">
                <i class="fas fa-file-csv"></i> Exportar
            </a>
            <button type="button" onclick="openModal('studentModal')" class="btn-premium-logout" style="padding: 8px 15px; font-size: 0.8rem;">
                <i class="fas fa-user-plus"></i> Registrar
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    <div class="table-responsive" style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 16px;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;" id="studentsTable">
            <thead style="background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--border-light);">
                <tr>
                    <th style="padding: 1.2rem 1rem; text-align: left; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">CÓDIGO</th>
                    <th style="padding: 1.2rem 1rem; text-align: left; font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">ESTUDIANTE</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Correo</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Carrera</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($students as $student)
                <tr style="border-bottom: 1px solid var(--border-light); transition: var(--transition-smooth);" class="student-row">
                <td style="padding: 1.2rem 1rem; color: var(--text-main); font-weight: 600; font-family: var(--font-display);">
                    EST-{{ str_pad(($students->currentPage() - 1) * $students->perPage() + $loop->iteration, 3, '0', STR_PAD_LEFT) }}
                </td>
                    <td style="padding: 1rem 1.2rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($student->avatar)
                                <img src="{{ $student->avatar }}" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%;" referrerpolicy="no-referrer" crossorigin="anonymous">
                            @else
                                <div style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #ff0000, #800000); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; color: white;">
                                    {{ strtoupper(substr($student->name, 0, 1)) }}
                                </div>
                            @endif
                            <span class="student-name">{{ $student->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 1rem 1.2rem; color: var(--text-muted);">{{ $student->email }}</td>
                    <td style="padding: 1rem 1.2rem;">{{ $student->career ? $student->career->name : 'No Asignada' }}</td>
                    <td style="padding: 1rem 1.2rem;">
                        <div style="display: flex; gap: 10px;">
                            <button type="button" onclick="openEditModal({{ $student->id }}, '{{ addslashes($student->name) }}', '{{ addslashes($student->email) }}', '{{ $student->career_id }}')" style="background: transparent; border: none; color: #3498db; cursor: pointer; font-size: 1rem;" title="Editar">
                                <i class="fas fa-edit"></i>
                            </button>
                            <form action="{{ route('students.destroy', $student->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este estudiante?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" style="background: transparent; border: none; color: #e74c3c; cursor: pointer; font-size: 1rem;" title="Eliminar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $students->links() }}
    </div>
</div>

<!-- Modal Registrar Estudiante -->
<div id="studentModal" style="display: {{ $errors->any() ? 'flex' : 'none' }}; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-user-plus" style="color: var(--accent-red);"></i> Registrar Estudiante</h3>
            <button onclick="closeModal('studentModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('students.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Nombre Completo</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Juan Pérez" required style="background: var(--bg-base); border: 1px solid {{ $errors->has('name') ? 'var(--accent-red)' : 'var(--border-color)' }}; color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body);">
                    @error('name') <span style="color: var(--accent-red); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Correo Electrónico</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="ejemplo@correo.com" required style="background: var(--bg-base); border: 1px solid {{ $errors->has('email') ? 'var(--accent-red)' : 'var(--border-color)' }}; color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body);">
                    @error('email') <span style="color: var(--accent-red); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Carrera Profesional</label>
                    <select name="career_id" required style="background: var(--bg-base); border: 1px solid {{ $errors->has('career_id') ? 'var(--accent-red)' : 'var(--border-color)' }}; color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); appearance: none;">
                        <option value="" disabled selected>Selecciona una carrera</option>
                        @foreach($careers as $career)
                            <option value="{{ $career->id }}" {{ old('career_id') == $career->id ? 'selected' : '' }}>{{ $career->name }}</option>
                        @endforeach
                    </select>
                    @error('career_id') <span style="color: var(--accent-red); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                
                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <button type="button" onclick="closeModal('studentModal')" style="flex: 1; background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 12px; border-radius: 12px; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn-premium-logout" style="flex: 1; width: auto; padding: 12px; border-radius: 12px;">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<div id="editStudentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-user-edit" style="color: var(--accent-red);"></i> Editar Estudiante</h3>
            <button onclick="closeModal('editStudentModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form id="editStudentForm" method="POST">
            @csrf
            @method('PUT')
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Nombre Completo</label>
                    <input type="text" name="name" id="edit_name" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body);">
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Correo Electrónico</label>
                    <input type="email" name="email" id="edit_email" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body);">
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Carrera Profesional</label>
                    <select name="career_id" id="edit_career_id" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); appearance: none;">
                        <option value="" disabled>Selecciona una carrera</option>
                        @foreach($careers as $career)
                            <option value="{{ $career->id }}">{{ $career->name }}</option>
                        @endforeach
                    </select>
                </div>
                
                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <button type="button" onclick="closeModal('editStudentModal')" style="flex: 1; background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 12px; border-radius: 12px; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn-premium-logout" style="flex: 1; width: auto; padding: 12px; border-radius: 12px;">Guardar Cambios</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) {
        document.getElementById(id).style.display = 'flex';
    }
    function closeModal(id) {
        document.getElementById(id).style.display = 'none';
    }
    
    function openEditModal(id, name, email, career_id) {
        document.getElementById('edit_name').value = name;
        document.getElementById('edit_email').value = email;
        document.getElementById('edit_career_id').value = career_id || '';
        document.getElementById('editStudentForm').action = '/estudiantes/' + id;
        openModal('editStudentModal');
    }
</script>
@endsection
