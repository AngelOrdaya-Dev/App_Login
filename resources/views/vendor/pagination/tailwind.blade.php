@if ($paginator->hasPages())
<nav style="display:flex; align-items:center; justify-content:space-between; gap:1rem; flex-wrap:wrap; margin-top:1rem;">
    <p style="font-size:0.8rem; color:var(--text-muted,#888); margin:0;">
        Mostrando <strong style="color:var(--text-main,#fff);">{{ $paginator->firstItem() }}</strong>
        a <strong style="color:var(--text-main,#fff);">{{ $paginator->lastItem() }}</strong>
        de <strong style="color:var(--text-main,#fff);">{{ $paginator->total() }}</strong> registros
    </p>

    <div style="display:flex; align-items:center; gap:6px;">

        {{-- Previous --}}
        @if ($paginator->onFirstPage())
            <span style="padding:8px 16px; border-radius:10px; font-size:0.82rem; font-weight:600;
                         background:rgba(255,255,255,0.03); color:rgba(255,255,255,0.2);
                         border:1px solid rgba(255,255,255,0.05); cursor:not-allowed; user-select:none;">
                <i class="fas fa-chevron-left" style="font-size:0.75rem;"></i>
            </span>
        @else
            <a href="{{ $paginator->previousPageUrl() }}"
               style="padding:8px 16px; border-radius:10px; font-size:0.82rem; font-weight:600;
                      background:rgba(255,255,255,0.04); color:var(--text-main,#fff);
                      border:1px solid rgba(255,255,255,0.1); text-decoration:none;
                      transition:all 0.2s ease; display:inline-flex; align-items:center; gap:6px;"
               onmouseover="this.style.borderColor='var(--accent-red,#ff3e3e)'; this.style.color='var(--accent-red,#ff3e3e)';"
               onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='var(--text-main,#fff)';">
                <i class="fas fa-chevron-left" style="font-size:0.75rem;"></i> Anterior
            </a>
        @endif

        {{-- Page Numbers --}}
        @foreach ($elements as $element)
            @if (is_string($element))
                <span style="padding:8px 12px; color:rgba(255,255,255,0.3); font-size:0.82rem;">{{ $element }}</span>
            @endif
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <span style="padding:8px 14px; border-radius:10px; font-size:0.82rem; font-weight:700;
                                     background:var(--accent-red,#ff3e3e); color:#fff;
                                     border:1px solid var(--accent-red,#ff3e3e); min-width:38px; text-align:center;">
                            {{ $page }}
                        </span>
                    @else
                        <a href="{{ $url }}"
                           style="padding:8px 14px; border-radius:10px; font-size:0.82rem; font-weight:600;
                                  background:rgba(255,255,255,0.04); color:var(--text-main,#fff);
                                  border:1px solid rgba(255,255,255,0.1); text-decoration:none; min-width:38px;
                                  text-align:center; transition:all 0.2s ease; display:inline-block;"
                           onmouseover="this.style.borderColor='var(--accent-red,#ff3e3e)'; this.style.color='var(--accent-red,#ff3e3e)';"
                           onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='var(--text-main,#fff)';">
                            {{ $page }}
                        </a>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next --}}
        @if ($paginator->hasMorePages())
            <a href="{{ $paginator->nextPageUrl() }}"
               style="padding:8px 16px; border-radius:10px; font-size:0.82rem; font-weight:600;
                      background:rgba(255,255,255,0.04); color:var(--text-main,#fff);
                      border:1px solid rgba(255,255,255,0.1); text-decoration:none;
                      transition:all 0.2s ease; display:inline-flex; align-items:center; gap:6px;"
               onmouseover="this.style.borderColor='var(--accent-red,#ff3e3e)'; this.style.color='var(--accent-red,#ff3e3e)';"
               onmouseout="this.style.borderColor='rgba(255,255,255,0.1)'; this.style.color='var(--text-main,#fff)';">
                Siguiente <i class="fas fa-chevron-right" style="font-size:0.75rem;"></i>
            </a>
        @else
            <span style="padding:8px 16px; border-radius:10px; font-size:0.82rem; font-weight:600;
                         background:rgba(255,255,255,0.03); color:rgba(255,255,255,0.2);
                         border:1px solid rgba(255,255,255,0.05); cursor:not-allowed; user-select:none;
                         display:inline-flex; align-items:center; gap:6px;">
                Siguiente <i class="fas fa-chevron-right" style="font-size:0.75rem;"></i>
            </span>
        @endif

    </div>
</nav>
@endif
