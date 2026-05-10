@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="margin-bottom: 2rem; border-bottom: 1px solid var(--border-light); padding-bottom: 1rem; display: flex; justify-content: space-between; align-items: center;">
        <h3 class="panel-title"><i class="fas fa-books"></i> Biblioteca Digital</h3>
        
        @if(Auth::user()->isAdmin() || Auth::user()->isTeacher())
        <button onclick="document.getElementById('uploadModal').style.display='flex'" class="btn-premium-logout" style="width: auto; padding: 10px 20px; display: inline-flex;">
            <i class="fas fa-cloud-upload-alt"></i> Subir Material
        </button>
        @endif
    </div>

    @if(session('success'))
        <div style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 1rem; border-radius: 12px; margin-bottom: 1.5rem; border: 1px solid rgba(46, 204, 113, 0.3);">
            <i class="fas fa-check-circle"></i> {{ session('success') }}
        </div>
    @endif

    <!-- Materials Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(280px, 1fr)); gap: 1.5rem;">
        @forelse($materials as $material)
        <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 20px; overflow: hidden; transition: 0.3s;" onmouseover="this.style.transform='translateY(-5px)'; this.style.borderColor='var(--accent-red)'" onmouseout="this.style.transform='none'; this.style.borderColor='var(--border-light)'">
            <div style="padding: 1.5rem;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1rem;">
                    <div style="width: 45px; height: 45px; border-radius: 12px; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 1.2rem; color: var(--accent-red);">
                        @if(str_contains($material->file_path, '.pdf')) <i class="fas fa-file-pdf"></i>
                        @elseif(str_contains($material->file_path, '.doc')) <i class="fas fa-file-word"></i>
                        @elseif(str_contains($material->file_path, '.ppt')) <i class="fas fa-file-powerpoint"></i>
                        @else <i class="fas fa-file-alt"></i> @endif
                    </div>
                    <span style="font-size: 0.7rem; background: rgba(255,0,0,0.1); color: var(--accent-red); padding: 4px 10px; border-radius: 20px; text-transform: uppercase; font-weight: 700;">{{ $material->type }}</span>
                </div>
                
                <h4 style="font-size: 1.1rem; color: var(--text-main); margin-bottom: 5px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">{{ $material->title }}</h4>
                <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1rem;">Curso: {{ $material->course->name }}</p>
                
                <div style="display: flex; align-items: center; gap: 8px; margin-bottom: 1.5rem; font-size: 0.8rem; color: var(--text-muted);">
                    <i class="fas fa-user-circle"></i> Por: {{ $material->user->name }}
                </div>

                <div style="display: flex; gap: 10px;">
                    <a href="{{ $material->file_path }}" target="_blank" class="btn-premium-logout" style="width: 100%; padding: 8px; font-size: 0.85rem; text-decoration: none; display: flex; justify-content: center; align-items: center;">
                        <i class="fas fa-download"></i> Descargar
                    </a>
                    
                    @if(Auth::user()->isAdmin() || Auth::id() === $material->user_id)
                    <form action="{{ route('library.destroy', $material) }}" method="POST" onsubmit="return confirm('¿Eliminar este material?')">
                        @csrf @method('DELETE')
                        <button type="submit" style="background: rgba(231, 76, 60, 0.1); color: #e74c3c; border: 1px solid rgba(231, 76, 60, 0.2); padding: 8px 12px; border-radius: 10px; cursor: pointer; transition: 0.2s;">
                            <i class="fas fa-trash-alt"></i>
                        </button>
                    </form>
                    @endif
                </div>
            </div>
        </div>
        @empty
        <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: rgba(255,255,255,0.01); border-radius: 20px; border: 1px dashed var(--border-light);">
            <i class="fas fa-folder-open" style="font-size: 3rem; color: var(--text-muted); margin-bottom: 1rem;"></i>
            <h5 style="color: var(--text-main);">No hay materiales disponibles</h5>
            <p style="color: var(--text-muted);">Los docentes aún no han subido documentos para tus cursos.</p>
        </div>
        @endforelse
    </div>
</div>

<!-- Upload Modal -->
<div id="uploadModal" style="display: none; position: fixed; inset: 0; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 1000; align-items: center; justify-content: center; padding: 1rem;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); width: 100%; max-width: 500px; border-radius: 24px; padding: 2rem; box-shadow: 0 25px 50px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="color: var(--text-main); margin: 0;"><i class="fas fa-file-upload" style="color: var(--accent-red);"></i> Subir Nuevo Material</h3>
            <button onclick="document.getElementById('uploadModal').style.display='none'" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.5rem;">&times;</button>
        </div>

        <form action="{{ route('library.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Título del Documento</label>
                    <input type="text" name="title" required placeholder="Ej: Sílabo del curso, Guía de práctica..." style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 12px; outline: none;">
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Tipo</label>
                        <select name="type" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 12px; outline: none;">
                            <option value="Sílaba">Sílaba</option>
                            <option value="Guía">Guía de Estudio</option>
                            <option value="Material">Material de Clase</option>
                            <option value="Otro">Otro</option>
                        </select>
                    </div>
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Curso</label>
                        <select name="course_id" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 12px; border-radius: 12px; outline: none;">
                            @foreach($courses as $course)
                                <option value="{{ $course->id }}">{{ $course->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>

                <div style="display: flex; flex-direction: column; gap: 8px;">
                    <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Archivo (PDF, Word, PPT)</label>
                    <input type="file" name="file" required style="background: var(--bg-base); border: 1px solid var(--border-color); color: var(--text-main); padding: 10px; border-radius: 12px; font-size: 0.85rem;">
                    <span style="font-size: 0.7rem; color: var(--text-muted);">Máximo 10MB</span>
                </div>

                <button type="submit" class="btn-premium-logout" style="margin-top: 1rem; padding: 15px;">
                    <i class="fas fa-check-circle"></i> Publicar Documento
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
