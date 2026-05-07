@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h3 class="panel-title"><i class="fas fa-book-open"></i> Carreras Disponibles</h3>
        <button onclick="openModal('careerModal')" class="btn-premium-logout" style="width: auto; padding: 8px 20px; font-size: 0.85rem;">
            <i class="fas fa-plus"></i> Agregar Carrera
        </button>
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    @if(session('error'))
        <div style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(231, 76, 60, 0.3);">
            <i class="fas fa-exclamation-circle"></i> {{ session('error') }}
        </div>
    @endif
    
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        @foreach($careers as $career)
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); border-radius: 16px; padding: 1.5rem; display: flex; align-items: center; transition: var(--transition-smooth); position: relative;">
            
            <div style="width: 60px; height: 60px; border-radius: 14px; background: linear-gradient(135deg, rgba(255,0,0,0.1), rgba(255,0,0,0.02)); border: 1px solid rgba(255,0,0,0.2); display: flex; align-items: center; justify-content: center; font-size: 1.8rem; color: var(--accent-red); margin-right: 20px;">
                <i class="fas fa-graduation-cap"></i>
            </div>
            
            <div style="flex: 1;">
                <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; margin-bottom: 5px;">Código: CAR-{{ str_pad($career->id, 3, '0', STR_PAD_LEFT) }}</div>
                <h4 style="font-family: var(--font-display); font-size: 1.2rem; color: var(--text-main);">{{ $career->name }}</h4>
            </div>
            
            <div style="text-align: right; display: flex; align-items: center; gap: 20px;">
                <div style="text-align: right;">
                    <span style="display: block; font-size: 1.5rem; font-weight: bold; color: var(--text-main); font-family: var(--font-display);">
                        {{ $career->users_count }}
                    </span>
                    <span style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase;">Estudiantes</span>
                </div>
                
                <form action="{{ route('careers.destroy', $career->id) }}" method="POST" onsubmit="return confirm('¿Eliminar esta carrera?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" style="background: rgba(231, 76, 60, 0.1); border: 1px solid rgba(231, 76, 60, 0.2); color: #e74c3c; width: 35px; height: 35px; border-radius: 8px; cursor: pointer; transition: 0.2s;" title="Eliminar">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                </form>
            </div>
        </div>
        @endforeach
    </div>
</div>

<!-- Modal Agregar Carrera -->
<div id="careerModal" style="display: {{ $errors->any() ? 'flex' : 'none' }}; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); width: 450px; border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-plus-circle" style="color: var(--accent-red);"></i> Nueva Carrera</h3>
            <button onclick="closeModal('careerModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form action="{{ route('careers.store') }}" method="POST">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Nombre de la Carrera</label>
                    <input type="text" name="name" value="{{ old('name') }}" placeholder="Ej: Ingeniería de Sistemas" required
                        style="background: var(--bg-base); border: 1px solid {{ $errors->has('name') ? 'var(--accent-red)' : 'var(--border-color)' }}; color: var(--text-main); padding: 12px 15px; border-radius: 10px; outline: none; font-family: var(--font-body); transition: border-color 0.2s;"
                        onfocus="this.style.borderColor='var(--accent-red)'" onblur="this.style.borderColor='var(--border-color)'">
                    @error('name') <span style="color: var(--accent-red); font-size: 0.75rem;">{{ $message }}</span> @enderror
                </div>
                
                <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
                    <button type="button" onclick="closeModal('careerModal')" style="flex: 1; background: rgba(255,255,255,0.05); color: var(--text-main); border: 1px solid var(--border-light); padding: 12px; border-radius: 12px; cursor: pointer; font-weight: 600;">Cancelar</button>
                    <button type="submit" class="btn-premium-logout" style="flex: 1; width: auto; padding: 12px; border-radius: 12px;">Crear Carrera</button>
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
