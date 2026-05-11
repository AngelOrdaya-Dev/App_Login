@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title"><i class="fas fa-chalkboard-teacher"></i> Gestión de Docentes</h3>
        <div class="panel-header-actions">
            <button onclick="openModal('teacherModal')" class="btn-premium-logout">
                <i class="fas fa-user-plus"></i> Registrar Docente
            </button>
        </div>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif
    
    <div class="table-responsive" style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 16px;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--border-light);">
                <tr>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">ID</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Nombre</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Correo</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Cursos Asignados</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($teachers as $teacher)
                <tr style="border-bottom: 1px solid var(--border-light); transition: var(--transition-smooth);">
                    <td style="padding: 1.2rem; color: var(--text-main); font-weight: 600;">DOC-{{ str_pad($loop->iteration, 3, '0', STR_PAD_LEFT) }}</td>
                    <td style="padding: 1.2rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            @if($teacher->avatar)
                                <img src="{{ $teacher->avatar }}" alt="Avatar" style="width: 30px; height: 30px; border-radius: 50%;">
                            @else
                                <div style="width: 30px; height: 30px; border-radius: 50%; background: linear-gradient(135deg, #3498db, #2980b9); display: flex; align-items: center; justify-content: center; font-size: 0.8rem; font-weight: bold; color: white;">
                                    {{ strtoupper(substr($teacher->name, 0, 1)) }}
                                </div>
                            @endif
                            <span>{{ $teacher->name }}</span>
                        </div>
                    </td>
                    <td style="padding: 1.2rem; color: var(--text-muted);">{{ $teacher->email }}</td>
                    <td style="padding: 1.2rem;">
                        <span class="menu-badge" style="background: rgba(52, 152, 219, 0.1); color: #3498db; border: 1px solid rgba(52, 152, 219, 0.2);">
                            {{ $teacher->taughtCourses->count() }} Cursos
                        </span>
                    </td>
                    <td style="padding: 1.2rem;">
                        <form action="{{ route('teachers.destroy', $teacher->id) }}" method="POST" onsubmit="return confirm('¿Estás seguro de eliminar a este docente?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="background: transparent; border: none; color: #e74c3c; cursor: pointer; font-size: 1rem;" title="Eliminar">
                                <i class="fas fa-trash-alt"></i>
                            </button>
                        </form>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    
    <div style="margin-top: 2rem;">
        {{ $teachers->links() }}
    </div>
</div>

<!-- Modal Registrar Docente -->
<div id="teacherModal" style="display: {{ $errors->any() ? 'flex' : 'none' }}; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem; width: 100%; max-width: 500px; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-user-plus" style="color: var(--accent-red);"></i> Registrar Docente</h3>
            <button onclick="closeModal('teacherModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('teachers.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label class="modal-label">Nombre Completo</label>
                    <input type="text" name="name" class="modal-input" placeholder="Ej: Dr. Ricardo Palma" required>
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label class="modal-label">Correo Electrónico</label>
                    <input type="email" name="email" class="modal-input" placeholder="docente@universidad.edu.pe" required>
                </div>
                
                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <button type="button" onclick="closeModal('teacherModal')" class="btn-secondary" style="flex: 1; padding: 12px; border-radius: 12px; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn-premium-logout" style="flex: 1; width: auto; padding: 12px; border-radius: 12px;">Registrar</button>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
    function openModal(id) { document.getElementById(id).style.display = 'flex'; }
    function closeModal(id) { document.getElementById(id).style.display = 'none'; }
</script>
@endsection
