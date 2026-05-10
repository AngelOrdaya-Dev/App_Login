@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="margin-bottom: 2rem;">
        <h3 class="panel-title"><i class="fas fa-chalkboard"></i> Mis Cursos Asignados</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Gestiona tus clases, alumnos y calificaciones desde aquí.</p>
    </div>

    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 2rem;">
        @forelse($courses as $course)
        <div class="stat-card" style="display: flex; flex-direction: column; justify-content: space-between; min-height: 220px; border: 1px solid var(--border-light); background: rgba(255,255,255,0.02);">
            <div>
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                    <div style="width: 50px; height: 50px; background: var(--accent-red-faded); border-radius: 12px; display: flex; align-items: center; justify-content: center; color: var(--accent-red); font-size: 1.5rem;">
                        <i class="fas fa-book"></i>
                    </div>
                    <span class="menu-badge" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71;">Activo</span>
                </div>
                <h4 style="font-family: var(--font-display); font-size: 1.2rem; margin-bottom: 0.5rem;">{{ $course->name }}</h4>
                <p style="color: var(--text-muted); font-size: 0.85rem;"><i class="fas fa-graduation-cap"></i> {{ $course->career->name }}</p>
            </div>
            
            <div style="margin-top: 1.5rem; padding-top: 1.5rem; border-top: 1px solid var(--border-light); display: flex; justify-content: space-between; align-items: center;">
                <div style="display: flex; align-items: center; gap: 8px; color: var(--text-muted); font-size: 0.85rem;">
                    <i class="fas fa-users"></i>
                    <span>{{ $course->career->users()->where('role', 'student')->count() }} Alumnos</span>
                </div>
                <a href="{{ route('grades') }}" class="action-btn" title="Gestionar Notas" style="width: 35px; height: 35px; border-radius: 8px; display: flex; align-items: center; justify-content: center; background: var(--bg-surface); border: 1px solid var(--border-light); color: var(--text-main); transition: all 0.3s;">
                    <i class="fas fa-chevron-right"></i>
                </a>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: rgba(255,255,255,0.01); border-radius: 20px; border: 2px dashed var(--border-light);">
            <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem; display: block;"></i>
            <p style="color: var(--text-muted);">No tienes cursos asignados todavía.</p>
            <p style="font-size: 0.8rem; color: var(--text-muted); margin-top: 0.5rem;">Contacta con el administrador para la asignación de materias.</p>
        </div>
        @endforelse
    </div>
</div>
@endsection
