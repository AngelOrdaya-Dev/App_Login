@extends('layouts.admin')

@section('content')
<div class="hero-card" style="margin-bottom: 2rem; background: linear-gradient(135deg, #1a1a1f 0%, #050505 100%);">
    <div class="hero-content">
        <h1>Mi Historial <br><span>Académico</span></h1>
        <p>Revisa tus calificaciones por curso, créditos acumulados y promedio ponderado actual.</p>
    </div>
    <div class="hero-date" style="background: rgba(255,255,255,0.05); border: 1px solid rgba(255,255,255,0.1);">
        <div style="text-align: right;">
            <div style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase;">Promedio General</div>
            <div style="font-size: 2.5rem; font-weight: 800; color: var(--accent-red); font-family: var(--font-display);">{{ number_format($gpa, 2) }}</div>
        </div>
    </div>
</div>

<div class="panel">
    <div class="panel-header">
        <h3 class="panel-title"><i class="fas fa-star"></i> Mis Calificaciones</h3>
    </div>
    
    <div class="table-responsive">
        <table style="width: 100%; border-collapse: collapse; margin-top: 1rem;">
            <thead>
                <tr style="border-bottom: 2px solid var(--border-light); text-align: left;">
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Curso</th>
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Créditos</th>
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Nota Final</th>
                    <th style="padding: 15px; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase;">Estado</th>
                </tr>
            </thead>
            <tbody>
                @forelse($grades as $grade)
                    <tr style="border-bottom: 1px solid var(--border-light); transition: background 0.3s;">
                        <td style="padding: 15px;">
                            <div style="font-weight: 600;">{{ $grade->course->name }}</div>
                            <div style="font-size: 0.75rem; color: var(--text-muted);">Ciclo 2026-I</div>
                        </td>
                        <td style="padding: 15px;">{{ $grade->course->credits }}</td>
                        <td style="padding: 15px;">
                            <span style="font-size: 1.1rem; font-weight: 800; font-family: var(--font-display); color: {{ $grade->grade >= 11 ? '#2ecc71' : '#e74c3c' }};">
                                {{ number_format($grade->grade, 1) }}
                            </span>
                        </td>
                        <td style="padding: 15px;">
                            <span style="padding: 4px 12px; border-radius: 20px; font-size: 0.7rem; font-weight: 800; text-transform: uppercase; background: {{ $grade->status == 'pass' ? 'rgba(46, 204, 113, 0.1)' : 'rgba(231, 76, 60, 0.1)' }}; color: {{ $grade->status == 'pass' ? '#2ecc71' : '#e74c3c' }}; border: 1px solid {{ $grade->status == 'pass' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(231, 76, 60, 0.2)' }};">
                                {{ $grade->status == 'pass' ? 'Aprobado' : 'Desaprobado' }}
                            </span>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                            <i class="fas fa-graduation-cap" style="font-size: 3rem; opacity: 0.1; margin-bottom: 1rem;"></i>
                            <p>Aún no tienes calificaciones registradas en este ciclo.</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
