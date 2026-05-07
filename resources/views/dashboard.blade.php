@extends('layouts.admin')

@section('content')

            
            <!-- Hero Card -->
            <div class="hero-card">
                <div class="hero-content">
                    <h1>Bienvenido de vuelta,<br><span>{{ explode(' ', Auth::user()->name)[0] }}</span>.</h1>
                    <p>Tu panel de control académico está listo. Revisa tu progreso, cursos y estado de matrícula en tiempo real.</p>
                </div>
                <div class="hero-date">
                    <i class="far fa-calendar-check"></i>
                    <div class="hero-date-text">
                        <strong>{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D MMM') }}</strong>
                        <span>Ciclo Académico 2026</span>
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="stats-grid">
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon"><i class="fas fa-user-graduate"></i></div>
                        <div class="stat-trend"><i class="fas fa-arrow-trend-up"></i> 12%</div>
                    </div>
                    <div class="stat-body">
                        <span class="stat-label">Total Estudiantes</span>
                        <span class="stat-value">{{ $totalStudents }}</span>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="stat-trend"><i class="fas fa-arrow-trend-up"></i> 3%</div>
                    </div>
                    <div class="stat-body">
                        <span class="stat-label">Aulas Activas</span>
                        <span class="stat-value">{{ $activeClassrooms }}</span>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon"><i class="fas fa-swatchbook"></i></div>
                        <div class="stat-trend"><i class="fas fa-arrow-trend-up"></i> 8%</div>
                    </div>
                    <div class="stat-body">
                        <span class="stat-label">Carreras Disp.</span>
                        <span class="stat-value">{{ $totalCareers }}</span>
                    </div>
                </div>
                
                <div class="stat-card">
                    <div class="stat-header">
                        <div class="stat-icon" style="color: #2ecc71; border-color: rgba(46, 204, 113, 0.3); background: linear-gradient(135deg, rgba(46, 204, 113, 0.15), rgba(46, 204, 113, 0.02)); box-shadow: inset 0 0 15px rgba(46, 204, 113, 0.1);"><i class="fas fa-check-circle"></i></div>
                        <div class="stat-trend"><i class="fas fa-arrow-trend-up"></i> 5%</div>
                    </div>
                    <div class="stat-body">
                        <span class="stat-label">Matrículas Aprobadas</span>
                        <span class="stat-value">{{ \App\Models\User::whereNotNull('career_id')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Complex Grid -->
            <div class="dashboard-grid">
                
                <!-- Student Info Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h3 class="panel-title"><i class="fas fa-address-card"></i> Expediente del Estudiante</h3>
                    </div>
                    
                    <div class="profile-details">
                        <div style="display: flex; justify-content: center; margin-bottom: 2rem; position: relative;">
                            @if(Auth::user()->avatar)
                                <img src="{{ Auth::user()->avatar }}" alt="Avatar" style="width: 120px; height: 120px; border-radius: 50%; border: 4px solid var(--bg-card); box-shadow: 0 0 0 2px var(--accent-red); object-fit: cover;" referrerpolicy="no-referrer">
                            @else
                                <div style="width: 120px; height: 120px; border-radius: 50%; background: linear-gradient(135deg, #ff0000, #800000); display: flex; align-items: center; justify-content: center; font-size: 3rem; font-weight: bold; color: white;">
                                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-icon"><i class="far fa-user"></i></div>
                            <div class="detail-content">
                                <div class="detail-label">Nombre Completo</div>
                                <div class="detail-value">{{ Auth::user()->name }}</div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-icon"><i class="far fa-envelope"></i></div>
                            <div class="detail-content">
                                <div class="detail-label">Correo Electrónico</div>
                                <div class="detail-value">{{ Auth::user()->email }}</div>
                            </div>
                        </div>
                        
                        <div class="detail-row">
                            <div class="detail-icon"><i class="fas fa-graduation-cap"></i></div>
                            <div class="detail-content">
                                <div class="detail-label">Carrera Profesional</div>
                                <div class="detail-value" style="color: var(--accent-red);">{{ Auth::user()->career ? Auth::user()->career->name : 'No asignada' }}</div>
                            </div>
                        </div>
                        
                        <div class="detail-row" style="background: transparent; border: none; padding: 0.5rem 0 0 0;">
                            <div class="detail-content" style="display: flex; gap: 1rem;">
                                <div class="status-badge">Matrícula Activa</div>
                                <div class="status-badge" style="background: rgba(52, 152, 219, 0.1); color: #3498db; border-color: rgba(52, 152, 219, 0.3);">
                                    <i class="fab fa-google"></i> Registrado vía {{ Auth::user()->google_id ? 'Google' : 'Formulario' }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <!-- Chart Panel -->
                <div class="panel">
                    <div class="panel-header">
                        <h3 class="panel-title"><i class="fas fa-chart-donut"></i> Estado General</h3>
                    </div>
                    
                    <div class="chart-container">
                        <div class="chart-graphic">
                            @php
                                $circumference = 471.2;
                                $dashArray = ($enrolledPercentage / 100) * $circumference;
                                $dashOffset = $circumference - $dashArray;
                            @endphp
                            <svg viewBox="0 0 180 180" width="180" height="180">
                                <!-- Background circle -->
                                <circle cx="90" cy="90" r="75" fill="none" stroke="var(--border-color)" stroke-width="12"/>
                                <!-- Red segment (Active dynamic) -->
                                <circle cx="90" cy="90" r="75" fill="none" stroke="var(--accent-red)" stroke-width="12" 
                                    stroke-dasharray="{{ $dashArray }} {{ $circumference }}" 
                                    stroke-linecap="round" style="filter: drop-shadow(0 0 8px rgba(255,0,0,0.5));"/>
                                <!-- Dark segment -->
                                <circle cx="90" cy="90" r="75" fill="none" stroke="#2a2a2e" stroke-width="12" 
                                    stroke-dasharray="{{ $dashOffset }} {{ $circumference }}" 
                                    stroke-dashoffset="-{{ $dashArray }}" stroke-linecap="round"/>
                            </svg>
                            <div class="chart-center">
                                <span class="chart-center-val">{{ $enrolledPercentage }}%</span>
                                <span class="chart-center-lbl">Inscritos</span>
                            </div>
                        </div>
                        
                        <div class="chart-legend">
                            <div class="legend-item">
                                <div class="legend-left">
                                    <span class="legend-dot" style="background: var(--accent-red); box-shadow: 0 0 8px var(--accent-red);"></span>
                                    Estudiantes Inscritos
                                </div>
                                <span class="legend-val">{{ $enrolledPercentage }}%</span>
                            </div>
                            <div class="legend-item">
                                <div class="legend-left">
                                    <span class="legend-dot" style="background: #2a2a2e;"></span>
                                    Sin Carrera Asignada
                                </div>
                                <span class="legend-val">{{ 100 - $enrolledPercentage }}%</span>
                            </div>
                        </div>
                    </div>
                </div>
                
            </div>
            
        
@endsection
