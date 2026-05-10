@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
        <h3 class="panel-title"><i class="fas fa-chalkboard"></i> Gestión de Aulas</h3>
        <div style="display: flex; gap: 10px; flex-wrap: wrap;">
            <a href="{{ route('export.classrooms') }}" style="background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 8px 15px; border-radius: 8px; font-size: 0.8rem; cursor: pointer; display: flex; align-items: center; gap: 8px; text-decoration: none;">
                <i class="fas fa-file-csv"></i> Exportar
            </a>
            <button onclick="openModal('classroomModal')" class="btn-premium-logout" style="width: auto; padding: 8px 20px; font-size: 0.85rem;">
                <i class="fas fa-plus"></i> Agregar Aula
            </button>
        </div>
    </div>
    
    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @foreach($classrooms as $classroom)
        <div class="stat-card" style="padding: 1.5rem; position: relative;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                <div style="width: 45px; height: 45px; border-radius: 12px; background: rgba(255,0,0,0.1); border: 1px solid rgba(255,0,0,0.2); display: flex; align-items: center; justify-content: center; color: var(--accent-red); font-size: 1.2rem;">
                    <i class="fas fa-door-open"></i>
                </div>
                <div style="display: flex; gap: 8px;">
                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; background: {{ $classroom->is_active ? 'rgba(46, 204, 113, 0.1)' : 'rgba(255,255,255,0.05)' }}; color: {{ $classroom->is_active ? '#2ecc71' : 'var(--text-muted)' }}; border: 1px solid {{ $classroom->is_active ? 'rgba(46, 204, 113, 0.3)' : 'var(--border-light)' }};">
                        {{ $classroom->is_active ? 'Disponible' : 'Ocupada' }}
                    </span>
                    <form action="{{ route('classrooms.destroy', $classroom->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta aula?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" style="background: transparent; border: none; color: #e74c3c; cursor: pointer; font-size: 0.8rem; padding: 4px;"><i class="fas fa-trash"></i></button>
                    </form>
                </div>
            </div>
            <h4 style="font-family: var(--font-display); font-size: 1.2rem; margin-bottom: 5px;">{{ $classroom->name }}</h4>
            <div style="color: var(--text-muted); font-size: 0.9rem; display: flex; align-items: center; gap: 8px;">
                <i class="fas fa-users" style="font-size: 0.8rem;"></i> Capacidad: {{ $classroom->capacity }} alumnos
            </div>
            
            <div style="margin-top: 1.5rem; padding-top: 1rem; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
                <span style="font-size: 0.75rem; color: var(--text-muted);">CÓDIGO: CL-{{ str_pad($classroom->id, 3, '0', STR_PAD_LEFT) }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Agregar Aula -->
<div id="classroomModal" style="display: {{ $errors->any() ? 'flex' : 'none' }}; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.3rem;"><i class="fas fa-plus-circle" style="color: var(--accent-red);"></i> Nueva Aula</h3>
            <button onclick="closeModal('classroomModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('classrooms.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Nombre del Aula</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Aula Magna A-101" required style="background: var(--bg-base); border: 1px solid {{ $errors->has('name') ? 'var(--accent-red)' : 'var(--border-color)' }}; color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body);">
                    @error('name') <span style="color: var(--accent-red); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Capacidad de Alumnos</label>
                    <input type="number" name="capacity" value="{{ old('capacity') }}" placeholder="Ej: 40" required style="background: var(--bg-base); border: 1px solid {{ $errors->has('capacity') ? 'var(--accent-red)' : 'var(--border-color)' }}; color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body);">
                    @error('capacity') <span style="color: var(--accent-red); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                
                <div style="margin-top: 1rem; display: flex; gap: 1rem;">
                    <button type="button" onclick="closeModal('classroomModal')" style="flex: 1; background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 12px; border-radius: 12px; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn-premium-logout" style="flex: 1; width: auto; padding: 12px; border-radius: 12px;">Crear Aula</button>
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
</script>
@endsection
