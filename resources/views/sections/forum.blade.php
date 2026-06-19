@extends('layouts.admin')

@section('content')
<div class="panel" style="display: flex; flex-direction: column; height: 80vh; max-height: 800px; padding: 0; overflow: hidden;">
    <!-- Forum Header -->
    <div class="forum-header" style="padding: 1.5rem 2rem; border-bottom: 1px solid var(--border-light); background: rgba(0,0,0,0.2); display: flex; justify-content: space-between; align-items: center;">
        <div style="display: flex; align-items: center; gap: 15px;">
            <a href="{{ route('virtual.classes') }}" class="btn-back" style="color: var(--text-muted); font-size: 1.2rem; transition: 0.2s;">
                <i class="fas fa-arrow-left"></i>
            </a>
            <div>
                <h3 style="margin: 0; font-family: var(--font-display); font-size: 1.2rem;"><i class="fas fa-comments" style="color: var(--accent-red);"></i> Foro: {{ $course->name }}</h3>
                <span style="font-size: 0.8rem; color: var(--text-muted);">Espacio de dudas y discusión general</span>
            </div>
        </div>
        <div>
            <span class="badge" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; padding: 5px 10px; border-radius: 20px; font-size: 0.75rem; border: 1px solid rgba(46,204,113,0.3);">
                <i class="fas fa-users"></i> {{ $posts->unique('user_id')->count() }} Participantes
            </span>
        </div>
    </div>

    <!-- Messages Area -->
    <div class="forum-messages" id="forumMessages" style="flex: 1; padding: 2rem; overflow-y: auto; display: flex; flex-direction: column; gap: 1.5rem; background: var(--bg-surface);">
        @forelse($posts as $post)
            @php
                $isMe = $post->user_id === Auth::id();
                $isTeacher = $post->user->role === 'teacher';
                $isAdmin = $post->user->role === 'admin';
            @endphp
            
            <div class="message-wrapper {{ $isMe ? 'message-mine' : 'message-other' }}" style="display: flex; gap: 12px; max-width: 80%; align-self: {{ $isMe ? 'flex-end' : 'flex-start' }}; flex-direction: {{ $isMe ? 'row-reverse' : 'row' }};">
                <div class="message-avatar">
                    @if($post->user->avatar)
                        <img src="{{ $post->user->avatar }}" style="width: 40px; height: 40px; border-radius: 50%; object-fit: cover; border: 2px solid {{ $isMe ? 'var(--accent-red)' : 'var(--border-light)' }};" referrerpolicy="no-referrer">
                    @else
                        <div style="width: 40px; height: 40px; border-radius: 50%; background: {{ $isMe ? 'var(--accent-red)' : 'var(--bg-card)' }}; display: flex; align-items: center; justify-content: center; font-weight: bold; border: 2px solid var(--border-light);">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>
                
                <div class="message-content" style="display: flex; flex-direction: column; align-items: {{ $isMe ? 'flex-end' : 'flex-start' }};">
                    <div class="message-meta" style="font-size: 0.75rem; color: var(--text-muted); margin-bottom: 5px; display: flex; align-items: center; gap: 8px;">
                        @if(!$isMe)
                            <strong style="color: var(--text-main);">{{ $post->user->name }}</strong>
                            @if($isTeacher) <span style="background: rgba(52, 152, 219, 0.2); color: #3498db; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem;">DOCENTE</span> @endif
                            @if($isAdmin) <span style="background: rgba(231, 76, 60, 0.2); color: #e74c3c; padding: 2px 6px; border-radius: 4px; font-size: 0.65rem;">ADMIN</span> @endif
                            <span>&bull;</span>
                        @endif
                        <span>{{ $post->created_at->format('d M, H:i') }}</span>
                    </div>
                    
                    <div class="message-bubble" style="background: {{ $isMe ? 'var(--accent-red)' : 'rgba(255,255,255,0.05)' }}; color: {{ $isMe ? '#fff' : 'var(--text-main)' }}; padding: 12px 18px; border-radius: 18px; {{ $isMe ? 'border-top-right-radius: 4px;' : 'border-top-left-radius: 4px;' }} box-shadow: 0 5px 15px rgba(0,0,0,0.1); font-size: 0.95rem; line-height: 1.5;">
                        {{ $post->message }}
                    </div>
                </div>
            </div>
        @empty
            <div style="flex: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; color: var(--text-muted); opacity: 0.6;">
                <i class="fas fa-comments" style="font-size: 4rem; margin-bottom: 1rem;"></i>
                <p>No hay mensajes en este foro aún. ¡Sé el primero en participar!</p>
            </div>
        @endforelse
    </div>

    <!-- Input Area -->
    <div class="forum-input" style="padding: 1.5rem 2rem; border-top: 1px solid var(--border-light); background: var(--bg-card);">
        <form action="{{ route('forum.store', $course->id) }}" method="POST" style="display: flex; gap: 15px; align-items: flex-end;">
            @csrf
            <div style="flex: 1; position: relative;">
                <textarea name="message" rows="2" placeholder="Escribe tu mensaje o duda aquí..." required style="width: 100%; background: rgba(255,255,255,0.03); border: 1px solid var(--border-color); border-radius: 16px; padding: 12px 20px; color: var(--text-main); font-family: var(--font-body); resize: none; outline: none; transition: 0.2s;"></textarea>
            </div>
            <button type="submit" class="btn-premium-logout" style="height: 50px; width: 50px; border-radius: 50%; padding: 0; display: flex; align-items: center; justify-content: center;">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<style>
    .btn-back:hover { color: var(--text-main) !important; transform: translateX(-3px); }
    textarea:focus { border-color: var(--accent-red) !important; background: rgba(255,255,255,0.05) !important; box-shadow: 0 0 10px var(--accent-red-faded); }
    .forum-messages::-webkit-scrollbar { width: 6px; }
    .forum-messages::-webkit-scrollbar-track { background: transparent; }
    .forum-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.1); border-radius: 10px; }
</style>

<script>
    // Auto-scroll to bottom
    const messagesContainer = document.getElementById('forumMessages');
    messagesContainer.scrollTop = messagesContainer.scrollHeight;
</script>
@endsection
