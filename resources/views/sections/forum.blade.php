@extends('layouts.admin')

@section('content')

{{-- Ocultar sidebar/footer en móvil para esta pantalla fullscreen --}}
<style>
    /* FORO: Layout fullscreen estilo app en móvil */
    .forum-page-wrap {
        display: flex;
        flex-direction: column;
        height: calc(100dvh - 70px); /* restar header */
        background: var(--bg-surface);
        border-radius: 20px;
        overflow: hidden;
        border: 1px solid var(--border-light);
    }

    /* ---- HEADER ---- */
    .forum-header {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 1rem 1.25rem;
        border-bottom: 1px solid var(--border-light);
        background: rgba(0,0,0,0.25);
        flex-shrink: 0;
    }
    .forum-back-btn {
        flex-shrink: 0;
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: rgba(255,255,255,0.05);
        border: 1px solid var(--border-light);
        display: flex;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        text-decoration: none;
        transition: 0.2s;
    }
    .forum-back-btn:hover { background: rgba(255,255,255,0.1); color: var(--text-main); }
    .forum-header-info { flex: 1; min-width: 0; }
    .forum-header-info h3 {
        margin: 0;
        font-family: var(--font-display);
        font-size: 1rem;
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: flex;
        align-items: center;
        gap: 8px;
    }
    .forum-header-info span {
        font-size: 0.75rem;
        color: var(--text-muted);
        display: block;
        margin-top: 2px;
    }
    .forum-participants-badge {
        flex-shrink: 0;
        background: rgba(46,204,113,0.12);
        color: #2ecc71;
        padding: 5px 10px;
        border-radius: 20px;
        font-size: 0.7rem;
        font-weight: 700;
        border: 1px solid rgba(46,204,113,0.3);
        white-space: nowrap;
        display: flex;
        align-items: center;
        gap: 5px;
    }

    /* ---- MESSAGES ---- */
    .forum-messages {
        flex: 1;
        padding: 1.25rem;
        overflow-y: auto;
        display: flex;
        flex-direction: column;
        gap: 1.2rem;
        background: var(--bg-surface);
        -webkit-overflow-scrolling: touch;
    }
    .forum-messages::-webkit-scrollbar { width: 4px; }
    .forum-messages::-webkit-scrollbar-thumb { background: rgba(255,255,255,0.08); border-radius: 10px; }

    /* ---- MESSAGE BUBBLES ---- */
    .message-wrapper { display: flex; gap: 10px; max-width: 85%; }
    .message-wrapper.message-mine { align-self: flex-end; flex-direction: row-reverse; }
    .message-wrapper.message-other { align-self: flex-start; }
    .message-avatar img,
    .message-avatar .avatar-placeholder {
        width: 34px;
        height: 34px;
        border-radius: 50%;
        object-fit: cover;
        flex-shrink: 0;
    }
    .message-avatar .avatar-placeholder {
        display: flex;
        align-items: center;
        justify-content: center;
        font-weight: 700;
        font-size: 0.85rem;
    }
    .message-content { display: flex; flex-direction: column; }
    .message-wrapper.message-mine .message-content { align-items: flex-end; }
    .message-wrapper.message-other .message-content { align-items: flex-start; }
    .message-meta {
        font-size: 0.7rem;
        color: var(--text-muted);
        margin-bottom: 4px;
        display: flex;
        align-items: center;
        gap: 6px;
        flex-wrap: wrap;
    }
    .message-bubble {
        padding: 10px 14px;
        border-radius: 18px;
        font-size: 0.9rem;
        line-height: 1.5;
        box-shadow: 0 3px 10px rgba(0,0,0,0.12);
        word-break: break-word;
    }
    .bubble-mine {
        background: var(--accent-red);
        color: #fff;
        border-top-right-radius: 4px;
    }
    .bubble-other {
        background: rgba(255,255,255,0.06);
        color: var(--text-main);
        border-top-left-radius: 4px;
        border: 1px solid var(--border-light);
    }

    /* ---- INPUT AREA ---- */
    .forum-input {
        flex-shrink: 0;
        padding: 0.9rem 1rem;
        border-top: none;
        background: var(--bg-card);
    }
    .forum-input-form {
        display: flex;
        gap: 10px;
        align-items: flex-end;
    }
    .forum-input-form textarea {
        flex: 1;
        background: rgba(255,255,255,0.04);
        border: 1px solid var(--border-color);
        border-radius: 20px;
        padding: 10px 16px;
        color: var(--text-main);
        font-family: var(--font-body);
        font-size: 0.9rem;
        resize: none;
        outline: none;
        transition: 0.2s;
        max-height: 100px;
        line-height: 1.4;
    }
    .forum-input-form textarea:focus {
        border-color: var(--accent-red);
        background: rgba(255,255,255,0.06);
    }
    .forum-send-btn {
        flex-shrink: 0;
        width: 44px;
        height: 44px;
        border-radius: 50%;
        background: var(--accent-red);
        border: none;
        color: #fff;
        font-size: 1rem;
        cursor: pointer;
        display: flex;
        align-items: center;
        justify-content: center;
        box-shadow: 0 4px 15px rgba(255,0,0,0.35);
        transition: 0.2s;
    }
    .forum-send-btn:hover { transform: scale(1.08); box-shadow: 0 6px 20px rgba(255,0,0,0.5); }

    /* ---- EMPTY STATE ---- */
    .forum-empty {
        flex: 1;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: var(--text-muted);
        text-align: center;
        padding: 2rem;
        gap: 1rem;
    }
    .forum-empty i { font-size: 3.5rem; opacity: 0.15; }
    .forum-empty p { font-size: 0.9rem; max-width: 260px; line-height: 1.5; }

    /* ---- RESPONSIVE ---- */
    @media (max-width: 600px) {
        .forum-page-wrap { height: calc(100dvh - 60px); border-radius: 16px; }
        .forum-header { padding: 0.85rem 1rem; }
        .forum-messages { padding: 1rem; gap: 1rem; }
        .message-wrapper { max-width: 92%; }
        .forum-input { padding: 0.75rem; }
    }
</style>

<div class="forum-page-wrap">

    {{-- HEADER --}}
    <div class="forum-header">
        <a href="{{ route('virtual.classes') }}" class="forum-back-btn" title="Volver">
            <i class="fas fa-arrow-left" style="font-size: 0.9rem;"></i>
        </a>

        <div class="forum-header-info">
            <h3>
                <i class="fas fa-comments" style="color: var(--accent-red); font-size: 0.95rem; flex-shrink: 0;"></i>
                {{ $course->name }}
            </h3>
            <span>Espacio de dudas y discusión general</span>
        </div>

        <div class="forum-participants-badge">
            <i class="fas fa-users"></i>
            {{ $posts->unique('user_id')->count() }}
            <span class="d-none-xs">Partic.</span>
        </div>
    </div>

    {{-- MESSAGES --}}
    <div class="forum-messages" id="forumMessages">
        @forelse($posts as $post)
            @php
                $isMe    = $post->user_id === Auth::id();
                $isTeacher = $post->user->role === 'teacher';
                $isAdmin   = $post->user->role === 'admin';
            @endphp

            <div class="message-wrapper {{ $isMe ? 'message-mine' : 'message-other' }}">
                {{-- Avatar --}}
                <div class="message-avatar">
                    @if($post->user->avatar)
                        <img src="{{ $post->user->avatar }}"
                             style="border: 2px solid {{ $isMe ? 'var(--accent-red)' : 'var(--border-light)' }};"
                             referrerpolicy="no-referrer">
                    @else
                        <div class="avatar-placeholder"
                             style="background: {{ $isMe ? 'var(--accent-red)' : 'var(--bg-card)' }}; border: 2px solid var(--border-light); color: {{ $isMe ? '#fff' : 'var(--text-muted)' }};">
                            {{ strtoupper(substr($post->user->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Contenido --}}
                <div class="message-content">
                    <div class="message-meta">
                        @if(!$isMe)
                            <strong style="color: var(--text-main);">{{ $post->user->name }}</strong>
                            @if($isTeacher)
                                <span style="background:rgba(52,152,219,0.2);color:#3498db;padding:1px 6px;border-radius:4px;font-size:0.62rem;font-weight:700;">DOCENTE</span>
                            @endif
                            @if($isAdmin)
                                <span style="background:rgba(231,76,60,0.2);color:#e74c3c;padding:1px 6px;border-radius:4px;font-size:0.62rem;font-weight:700;">ADMIN</span>
                            @endif
                            &bull;
                        @endif
                        <span>{{ $post->created_at->format('d M, H:i') }}</span>
                    </div>
                    <div class="message-bubble {{ $isMe ? 'bubble-mine' : 'bubble-other' }}">
                        {{ $post->message }}
                    </div>
                </div>
            </div>
        @empty
            <div class="forum-empty">
                <i class="fas fa-comments"></i>
                <p>No hay mensajes en este foro aún.<br>¡Sé el primero en participar!</p>
            </div>
        @endforelse
    </div>

    {{-- INPUT --}}
    <div class="forum-input">
        <form action="{{ route('forum.store', $course->id) }}" method="POST" class="forum-input-form">
            @csrf
            <textarea name="message"
                      rows="1"
                      placeholder="Deja tu mensaje"
                      required
                      id="forumTextarea"
                      onInput="autoResize(this)"></textarea>
            <button type="submit" class="forum-send-btn" title="Enviar">
                <i class="fas fa-paper-plane"></i>
            </button>
        </form>
    </div>
</div>

<script>
    // Auto-scroll al último mensaje
    const msgs = document.getElementById('forumMessages');
    msgs.scrollTop = msgs.scrollHeight;

    // Auto-resize del textarea
    function autoResize(el) {
        el.style.height = 'auto';
        el.style.height = Math.min(el.scrollHeight, 100) + 'px';
    }

    // Enter para enviar (Shift+Enter = nueva línea)
    document.getElementById('forumTextarea').addEventListener('keydown', function(e) {
        if (e.key === 'Enter' && !e.shiftKey) {
            e.preventDefault();
            this.closest('form').submit();
        }
    });
</script>
@endsection
