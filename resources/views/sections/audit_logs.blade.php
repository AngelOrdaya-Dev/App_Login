@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="margin-bottom: 2rem;">
        <h3 class="panel-title"><i class="fas fa-history"></i> Registro de Auditoría</h3>
        <p style="color: var(--text-muted); font-size: 0.9rem; margin-top: 0.5rem;">Historial detallado de todas las acciones críticas realizadas en la plataforma.</p>
    </div>

    <div class="table-responsive" style="background: var(--bg-surface); border: 1px solid var(--border-color); border-radius: 16px; overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; text-align: left;">
            <thead style="background: rgba(255,255,255,0.02); border-bottom: 1px solid var(--border-light);">
                <tr>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Fecha y Hora</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Usuario</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Acción</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Descripción</th>
                    <th style="padding: 1.2rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 1px;">Dirección IP</th>
                </tr>
            </thead>
            <tbody>
                @foreach($logs as $log)
                <tr style="border-bottom: 1px solid var(--border-light); transition: var(--transition-smooth);">
                    <td style="padding: 1.2rem; color: var(--text-muted); font-size: 0.85rem;">
                        <i class="far fa-clock"></i> {{ $log->created_at->format('d/m/Y H:i:s') }}
                    </td>
                    <td style="padding: 1.2rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 30px; height: 30px; border-radius: 50%; background: rgba(255,255,255,0.05); display: flex; align-items: center; justify-content: center; font-size: 0.8rem;">
                                <i class="fas fa-user"></i>
                            </div>
                            <span style="font-weight: 600;">{{ $log->user->name ?? 'Sistema' }}</span>
                        </div>
                    </td>
                    <td style="padding: 1.2rem;">
                        @php
                            $actionColor = match(true) {
                                str_contains(strtolower($log->action), 'registro') => '#2ecc71',
                                str_contains(strtolower($log->action), 'elimin') => '#e74c3c',
                                str_contains(strtolower($log->action), 'actualiz') => '#f1c40f',
                                default => '#3498db'
                            };
                        @endphp
                        <span style="background: {{ $actionColor }}15; color: {{ $actionColor }}; padding: 5px 14px; border-radius: 6px; font-size: 0.7rem; font-weight: 800; border: 1px solid {{ $actionColor }}40; white-space: nowrap; text-transform: uppercase; letter-spacing: 0.5px; display: inline-block;">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td style="padding: 1.2rem; font-size: 0.85rem; color: var(--text-main);">{{ $log->description }}</td>
                    <td style="padding: 1.2rem; color: var(--text-muted); font-family: monospace; font-size: 0.85rem;">
                        {{ $log->ip_address }}
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    <div style="margin-top: 2rem;">
        {{ $logs->links() }}
    </div>
</div>
@endsection
