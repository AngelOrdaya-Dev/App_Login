@extends('layouts.admin')

@section('content')

            
            <!-- Hero Card -->
            <div class="hero-card">
                <div class="hero-content">
                    @if(Auth::user()->isAdmin())
                        <h1>Centro de Control <br><span>Administrativo</span>.</h1>
                        <p>Gestión global del ecosistema académico. Supervisa inscripciones, finanzas y registros en tiempo real.</p>
                    @else
                        <h1>Bienvenido de vuelta,<br><span>{{ explode(' ', Auth::user()->name)[0] }}</span>.</h1>
                        <p>Tu panel de control académico está listo. Revisa tu progreso, cursos y estado de matrícula en tiempo real.</p>
                    @endif
                </div>
                <div class="hero-date">
                    <i class="far fa-calendar-check"></i>
                    <div class="hero-date-text">
                        <strong>{{ \Carbon\Carbon::now()->locale('es')->isoFormat('dddd, D MMM') }}</strong>
                        <span>Ciclo Académico 2026</span>
                    </div>
                </div>
            </div>
            
            @if(Auth::user()->isStudent() && !Auth::user()->career_id)
            <!-- Career Selection Prompt (Social Login) -->
            <div class="career-prompt-panel panel">
                <div class="career-prompt-container">
                    <div class="career-prompt-info">
                        <div class="career-prompt-icon">
                            <i class="fas fa-graduation-cap"></i>
                        </div>
                        <div class="career-prompt-text">
                            <h3>¡Completa tu Perfil!</h3>
                            <p>Para acceder a todas las funciones, por favor selecciona tu carrera profesional.</p>
                        </div>
                    </div>
                    <form action="{{ route('profile.update.career') }}" method="POST" class="career-prompt-form">
                        @csrf
                        <select name="career_id" required>
                            <option value="">Selecciona una carrera...</option>
                            @foreach($careers as $career)
                                <option value="{{ $career->id }}">{{ $career->name }}</option>
                            @endforeach
                        </select>
                        <button type="submit" class="btn-premium-logout">Asignar Carrera</button>
                    </form>
                </div>
            </div>
            <style>
                .career-prompt-panel {
                    background: linear-gradient(135deg, rgba(255,0,0,0.1), transparent); 
                    border: 1px solid var(--accent-red); 
                    margin-bottom: 2rem; 
                    animation: pulse-border 2s infinite;
                    padding: 0 !important;
                }
                .career-prompt-container {
                    display: flex; 
                    align-items: center; 
                    justify-content: space-between; 
                    gap: 1.5rem; 
                    padding: 1.5rem; 
                    flex-wrap: wrap;
                }
                .career-prompt-info {
                    display: flex; 
                    align-items: center; 
                    gap: 1.2rem; 
                    min-width: 200px;
                    flex: 1;
                }
                .career-prompt-icon {
                    width: 50px; 
                    height: 50px; 
                    border-radius: 50%; 
                    background: var(--accent-red); 
                    display: flex; 
                    align-items: center; 
                    justify-content: center; 
                    color: white; 
                    font-size: 1.2rem; 
                    flex-shrink: 0;
                    box-shadow: 0 0 15px var(--accent-red-glow);
                }
                .career-prompt-text h3 { margin: 0; font-size: 1.1rem; font-family: var(--font-display); }
                .career-prompt-text p { margin: 5px 0 0; color: var(--text-muted); font-size: 0.85rem; }
                
                .career-prompt-form {
                    display: flex; 
                    gap: 10px; 
                    align-items: center; 
                    flex-wrap: wrap; 
                    flex: 2; 
                    justify-content: flex-end;
                }
                .career-prompt-form select {
                    background: var(--bg-surface); 
                    border: 1px solid var(--border-color); 
                    color: var(--text-main); 
                    padding: 10px 15px; 
                    border-radius: 12px; 
                    outline: none; 
                    font-size: 0.9rem; 
                    flex: 1;
                    min-width: 200px;
                }
                .career-prompt-form button { width: auto; padding: 10px 20px; font-size: 0.85rem; white-space: nowrap; }

                @media (max-width: 768px) {
                    .career-prompt-container { flex-direction: column; align-items: flex-start; }
                    .career-prompt-form { width: 100%; justify-content: flex-start; }
                    .career-prompt-form select { width: 100%; }
                    .career-prompt-form button { width: 100%; }
                }

                @keyframes pulse-border {
                    0% { border-color: rgba(255,0,0,0.4); }
                    50% { border-color: rgba(255,0,0,1); }
                    100% { border-color: rgba(255,0,0,0.4); }
                }
            </style>
            @endif

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
                        <div class="stat-icon" style="color: #3498db; border-color: rgba(52, 152, 219, 0.3); background: linear-gradient(135deg, rgba(52, 152, 219, 0.15), rgba(52, 152, 219, 0.02));"><i class="fas fa-chalkboard-teacher"></i></div>
                        <div class="stat-trend"><i class="fas fa-arrow-trend-up"></i> {{ $totalTeachers }}</div>
                    </div>
                    <div class="stat-body">
                        <span class="stat-label">Docentes Activos</span>
                        <span class="stat-value">{{ $totalTeachers }}</span>
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
                        <span class="stat-value">{{ \App\Models\User::where(function($q){ $q->where('role', 'student')->orWhereNull('role'); })->whereNotNull('career_id')->count() }}</span>
                    </div>
                </div>
            </div>

            <!-- Complex Grid -->
            <div class="dashboard-grid main-dashboard-grid">
                
                <div class="dashboard-col">
                    @if(Auth::user()->isAdmin())
                        <!-- Admin Quick Insights -->
                        <div class="panel" style="height: fit-content;">
                            <div class="panel-header">
                                <h3 class="panel-title"><i class="fas fa-microchip"></i> Acciones del Sistema</h3>
                            </div>
                            <div class="profile-details" style="padding: 1.5rem;">
                                <div style="display: flex; flex-direction: column; gap: 1rem;">
                                    <a href="{{ route('students') }}" class="btn-premium-logout" style="width: 100%; text-align: left; background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); color: var(--text-main); box-shadow: none;">
                                        <i class="fas fa-user-plus"></i> Gestionar Estudiantes
                                    </a>
                                    <a href="{{ route('careers') }}" class="btn-premium-logout" style="width: 100%; text-align: left; background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); color: var(--text-main); box-shadow: none;">
                                        <i class="fas fa-graduation-cap"></i> Configurar Carreras
                                    </a>
                                    <a href="{{ route('export.students') }}" class="btn-premium-logout" style="width: 100%; text-align: left; background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); color: var(--text-main); box-shadow: none;">
                                        <i class="fas fa-file-export"></i> Exportar Base de Datos
                                    </a>
                                </div>
                            </div>
                        </div>

                        <!-- System Status Widget -->
                        <div class="panel status-widget-container status-success">
                            <i class="fas fa-server widget-bg-icon"></i>
                            <div class="widget-icon-circle">
                                <i class="fas fa-shield-check"></i>
                            </div>
                            <h3 class="widget-title">Sistema Operativo</h3>
                            <p class="widget-description">Todos los servicios están funcionando correctamente. No se reportan incidencias críticas.</p>
                        </div>
                    @else
                        <!-- Student Info Panel -->
                        <div class="panel" style="height: fit-content;">
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
                                        <div class="status-badge" style="background: rgba(255, 255, 255, 0.05); color: #fff; border-color: rgba(255, 255, 255, 0.1);">
                                            @if(Auth::user()->google_id)
                                                <i class="fab fa-google" style="color: #4285F4; margin-right: 5px;"></i> Google
                                            @elseif(Auth::user()->facebook_id)
                                                <i class="fab fa-facebook" style="color: #1877F2; margin-right: 5px;"></i> Facebook
                                            @elseif(Auth::user()->github_id)
                                                <i class="fab fa-github" style="color: #fff; margin-right: 5px;"></i> GitHub
                                            @else
                                                <i class="fas fa-id-card" style="color: var(--accent-red); margin-right: 5px;"></i> Formulario
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Payment Status Widget -->
                        @php
                            $pendingWidgetBalance = \App\Models\Payment::where('user_id', Auth::id())->where('status', 'pending')->sum('amount');
                        @endphp
                        <div class="panel status-widget-container {{ $pendingWidgetBalance == 0 ? 'status-success' : 'status-pending' }}">
                            <i class="{{ $pendingWidgetBalance == 0 ? 'fas fa-smile-beam' : 'fas fa-frown' }} widget-bg-icon"></i>
                            <div class="widget-icon-circle">
                                <i class="{{ $pendingWidgetBalance == 0 ? 'fas fa-smile-beam' : 'fas fa-frown' }}"></i>
                            </div>
                            <h3 class="widget-title">
                                {{ $pendingWidgetBalance == 0 ? '¡Todo al día!' : 'Atención Requerida' }}
                            </h3>
                            <p class="widget-description">
                                {{ $pendingWidgetBalance == 0 
                                    ? 'No tienes deudas pendientes. ¡Sigue así con tu excelente responsabilidad financiera!' 
                                    : 'Tienes pagos pendientes en tu cuenta. Por favor, regulariza tu situación lo antes posible.' 
                                }}
                            </p>
                        </div>
                    @endif
                </div>
                
                <div class="dashboard-col">
                    <!-- Chart Panel: Registros Mensuales -->
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-chart-line"></i> Actividad de Registros</h3>
                        </div>
                        <div style="padding: 1.5rem; height: 350px;">
                            <canvas id="monthlyRegistrationsChart"></canvas>
                        </div>
                    </div>

                    <!-- Chart Panel: Estudiantes por Carrera -->
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-chart-bar"></i> Distribución por Carrera</h3>
                        </div>
                        <div style="padding: 1.5rem; height: 400px;">
                            <canvas id="careerDistributionChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Conditional Grid Section -->
            <div class="dashboard-grid quick-actions-grid">
                @if(Auth::user()->isAdmin())
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-users"></i> Registro Rápido</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center; justify-content: center; padding: 2.5rem 0; text-align: center;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; border: 2px dashed var(--accent-red); display: flex; align-items: center; justify-content: center; color: var(--accent-red); font-size: 1.8rem; margin-bottom: 1rem;">
                                <i class="fas fa-user-plus"></i>
                            </div>
                            <h4 style="font-family: var(--font-display);">Nuevo Estudiante</h4>
                            <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 250px;">Registra manualmente a un nuevo alumno en el sistema.</p>
                            <a href="{{ route('students') }}" class="btn-premium-logout" style="width: auto; padding: 10px 30px; margin-top: 1rem;">
                                <i class="fas fa-plus"></i> Ir a Estudiantes
                            </a>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-clock-rotate-left"></i> Actividad del Sistema</h3>
                        </div>
                        <div style="padding: 1.5rem;">
                            @php
                                $recentUsers = \App\Models\User::latest()->take(4)->get();
                            @endphp
                            <div style="display: flex; flex-direction: column; gap: 1rem;">
                                @foreach($recentUsers as $u)
                                    <div style="display: flex; align-items: center; gap: 12px; padding-bottom: 10px; border-bottom: 1px solid var(--border-light);">
                                        <div style="width: 40px; height: 40px; border-radius: 50%; background: var(--bg-card); display: flex; align-items: center; justify-content: center; font-size: 0.9rem; font-weight: 700; color: var(--accent-red); border: 1px solid var(--border-light);">
                                            {{ strtoupper(substr($u->name, 0, 1)) }}
                                        </div>
                                        <div>
                                            <div style="font-size: 0.85rem; font-weight: 600;">{{ $u->name }}</div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $u->created_at->diffForHumans() }}</div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-file-csv"></i> Reportes Rápidos</h3>
                        </div>
                        <div style="padding: 2.2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; height: calc(100% - 60px);">
                            <div style="font-size: 3rem; color: #2ecc71; margin-bottom: 1rem;"><i class="fas fa-file-excel"></i></div>
                            <h4 style="font-family: var(--font-display); margin-bottom: 0.5rem;">Exportación Lista</h4>
                            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem;">Descarga el consolidado de alumnos y aulas en formato CSV.</p>
                            <div style="display: flex; gap: 10px;">
                                <a href="{{ route('export.students') }}" class="btn-premium-logout" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-main); padding: 10px 15px; font-size: 0.75rem;">Estudiantes</a>
                                <a href="{{ route('export.classrooms') }}" class="btn-premium-logout" style="background: transparent; border: 1px solid var(--border-color); color: var(--text-main); padding: 10px 15px; font-size: 0.75rem;">Aulas</a>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-plus-circle"></i> Nueva Inscripción</h3>
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 1rem; align-items: center; justify-content: center; padding: 2.5rem 0; text-align: center;">
                            <div style="width: 70px; height: 70px; border-radius: 50%; border: 2px dashed var(--accent-red); display: flex; align-items: center; justify-content: center; color: var(--accent-red); font-size: 1.8rem; margin-bottom: 1rem;">
                                <i class="fas fa-file-invoice"></i>
                            </div>
                            <h4 style="font-family: var(--font-display);">Aperturar Proceso</h4>
                            <p style="color: var(--text-muted); font-size: 0.85rem; max-width: 250px;">Inicia un nuevo proceso de admisión o matrícula regular.</p>
                            <button class="btn-premium-logout" style="width: auto; padding: 10px 30px; margin-top: 1rem;" onclick="openModal('enrollmentModal')">
                                <i class="fas fa-play"></i> Iniciar Trámite
                            </button>
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-history"></i> Historial Reciente</h3>
                        </div>
                        <div style="padding: 2.2rem; text-align: center; color: var(--text-muted);">
                            @php
                                $recentEnrollments = \App\Models\Enrollment::where('user_id', Auth::id())->latest()->take(3)->get();
                            @endphp
                            @if($recentEnrollments->count() > 0)
                                <div style="display: flex; flex-direction: column; gap: 1rem; text-align: left;">
                                    @foreach($recentEnrollments as $enrollment)
                                        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1rem; border-radius: 12px; display: flex; justify-content: space-between; align-items: center;">
                                            <div>
                                                <div style="font-weight: 600; font-size: 0.9rem;">{{ ucfirst($enrollment->type) }}</div>
                                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $enrollment->created_at->format('d/m/Y') }}</div>
                                            </div>
                                            <span class="status-badge" style="font-size: 0.65rem; background: {{ $enrollment->status == 'approved' ? 'rgba(46, 204, 113, 0.2)' : 'rgba(241, 196, 15, 0.2)' }}; color: {{ $enrollment->status == 'approved' ? '#2ecc71' : '#f1c40f' }};">
                                                {{ strtoupper($enrollment->status) }}
                                            </span>
                                        </div>
                                    @endforeach
                                </div>
                            @else
                                <i class="fas fa-folder-open" style="font-size: 3rem; opacity: 0.15; margin-bottom: 1rem;"></i>
                                <p style="font-size: 0.9rem;">No hay trámites registrados en tu historial.</p>
                            @endif
                        </div>
                    </div>

                    <div class="panel">
                        <div class="panel-header">
                            <h3 class="panel-title"><i class="fas fa-wallet"></i> Estado Financiero</h3>
                        </div>
                        <div style="padding: 2.2rem; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center; height: calc(100% - 60px);">
                            @php
                                $pendingBalance = \App\Models\Payment::where('user_id', Auth::id())->where('status', 'pending')->sum('amount');
                            @endphp
                            <div style="font-family: var(--font-display); font-size: 3rem; font-weight: 800; color: var(--text-main); line-height: 1; margin-bottom: 0.5rem;">
                                ${{ number_format($pendingBalance, 2) }}
                            </div>
                            <p style="color: var(--text-muted); font-size: 0.85rem; margin-bottom: 1.5rem; text-transform: uppercase; letter-spacing: 1px;">Saldo Pendiente</p>
                            
                            <button class="btn-premium-logout" style="width: auto; padding: 10px 25px; background: transparent; border: 1px solid var(--border-color); color: var(--text-main); box-shadow: none;" onclick="window.location.href='{{ route('payments') }}'">
                                <i class="fas fa-arrow-right"></i> Ir a Pagos
                            </button>
                        </div>
                    </div>
                @endif
            </div>

            <!-- Enrollment Modal (Shared) -->
            <div id="enrollmentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(8px); z-index: 9999; align-items: center; justify-content: center;">
                <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 28px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.7); animation: modalIn 0.4s cubic-bezier(0.23, 1, 0.32, 1);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
                        <h3 style="font-family: var(--font-display); font-size: 1.3rem;"><i class="fas fa-file-signature" style="color: var(--accent-red);"></i> Nueva Solicitud</h3>
                        <button onclick="closeModal('enrollmentModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
                    </div>
                    
                    <form action="{{ route('enrollments.store') }}" method="POST">
                        @csrf
                        <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Tipo de Trámite</label>
                                <select name="type" required class="modal-input" style="width: 100% !important; box-sizing: border-box !important;">
                                    <option value="regular">Matrícula Regular</option>
                                    <option value="traslado">Traslado Externo</option>
                                    <option value="reingreso">Reingreso Académico</option>
                                </select>
                            </div>
                            <div style="display: flex; flex-direction: column; gap: 8px;">
                                <label style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px; font-weight: 600;">Carrera</label>
                                <select name="career_id" required class="modal-input" style="width: 100% !important; box-sizing: border-box !important;">
                                    @foreach($careers as $career)
                                        <option value="{{ $career->id }}" {{ Auth::user()->career_id == $career->id ? 'selected' : '' }}>{{ $career->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <button type="submit" class="btn-premium-logout" style="width: 100%; padding: 14px; margin-top: 1rem; border-radius: 12px;">Confirmar Solicitud</button>
                        </div>
                    </form>
                </div>
            </div>

            <style>
                .main-dashboard-grid { gap: 2rem; margin-top: 0; }
                .quick-actions-grid { margin-top: 2rem; gap: 2rem; }
                .dashboard-col { display: flex; flex-direction: column; gap: 2rem; }

                @media (max-width: 900px) {
                    .main-dashboard-grid, .quick-actions-grid { gap: 1.5rem; }
                    .dashboard-col { gap: 1.5rem; }
                }

                @media (max-width: 600px) {
                    .main-dashboard-grid, .quick-actions-grid { gap: 1rem; }
                    .dashboard-col { gap: 1rem; }
                    
                    .hero-card { margin-bottom: 0.5rem; padding: 1rem !important; }
                    .panel { padding: 1.2rem !important; }
                    .panel-header { padding: 1rem 1.2rem !important; }
                    .detail-row { padding: 0.8rem; }
                }

                @media (max-width: 400px) {
                    .content { padding: 0.8rem; gap: 0.8rem; }
                    .panel { padding: 1rem !important; }
                    .panel-title { font-size: 0.9rem; }
                    .hero-content h1 { font-size: 1.4rem; }
                    .hero-date-text strong { font-size: 0.8rem; }
                }

                @keyframes modalIn {
                    from { opacity: 0; transform: scale(0.9) translateY(20px); }
                    to { opacity: 1; transform: scale(1) translateY(0); }
                }

                .status-widget-container {
                    flex: 1; 
                    display: flex; 
                    flex-direction: column; 
                    justify-content: center; 
                    align-items: center; 
                    text-align: center; 
                    padding: 3rem 2rem;
                    position: relative; 
                    overflow: hidden; 
                    min-height: 250px;
                }
                .status-success {
                    background: linear-gradient(135deg, rgba(46, 204, 113, 0.08), rgba(46, 204, 113, 0.01));
                    border: 1px solid rgba(46, 204, 113, 0.2);
                }
                .status-pending {
                    background: linear-gradient(135deg, rgba(231, 76, 60, 0.08), rgba(231, 76, 60, 0.01));
                    border: 1px solid rgba(231, 76, 60, 0.2);
                }
                .widget-bg-icon {
                    position: absolute; 
                    font-size: 12rem; 
                    bottom: -30px; 
                    right: -30px; 
                    transform: rotate(-15deg); 
                    pointer-events: none;
                    opacity: 0.05;
                }
                .status-success .widget-bg-icon { color: #2ecc71; }
                .status-pending .widget-bg-icon { color: #e74c3c; }

                .widget-icon-circle {
                    width: 80px; height: 80px; 
                    border-radius: 50%; 
                    display: flex; justify-content: center; align-items: center; 
                    font-size: 2.5rem; margin-bottom: 1.5rem; 
                    z-index: 1; 
                    border: 1px solid transparent;
                }
                .status-success .widget-icon-circle {
                    background: rgba(46, 204, 113, 0.15);
                    color: #2ecc71;
                    box-shadow: 0 0 25px rgba(46, 204, 113, 0.3);
                    border-color: rgba(46, 204, 113, 0.4);
                }
                .status-pending .widget-icon-circle {
                    background: rgba(231, 76, 60, 0.15);
                    color: #e74c3c;
                    box-shadow: 0 0 25px rgba(231, 76, 60, 0.3);
                    border-color: rgba(231, 76, 60, 0.4);
                }
                .widget-title {
                    font-family: var(--font-display); 
                    font-size: 1.6rem; 
                    margin-bottom: 0.8rem; 
                    z-index: 1; 
                    color: var(--text-main); 
                    font-weight: 800;
                }
                .widget-description {
                    color: var(--text-muted); 
                    font-size: 0.95rem; 
                    line-height: 1.6; 
                    z-index: 1; 
                    max-width: 85%;
                }

                @media (max-width: 600px) {
                    .status-widget-container { padding: 2rem 1.5rem; min-height: 200px; }
                    .widget-icon-circle { width: 60px; height: 60px; font-size: 1.8rem; margin-bottom: 1rem; }
                    .widget-title { font-size: 1.3rem; }
                    .widget-description { font-size: 0.85rem; max-width: 100%; }
                    .widget-bg-icon { font-size: 8rem; }
                }
            </style>


            <script>
                document.addEventListener('DOMContentLoaded', function() {
                    const ctxMonthly = document.getElementById('monthlyRegistrationsChart').getContext('2d');
                    const ctxCareer = document.getElementById('careerDistributionChart').getContext('2d');
                    let monthlyChart, careerChart;

                    function getThemeColors() {
                        const isLight = document.body.classList.contains('light-mode');
                        return {
                            text: isLight ? '#111111' : 'rgba(255, 255, 255, 0.7)',
                            grid: isLight ? 'rgba(0, 0, 0, 0.05)' : 'rgba(255, 255, 255, 0.05)',
                            accent: '#ff0000',
                            bars: isLight 
                                ? ['#ff0000', '#2a2a2e', '#44444a', '#800000', '#666666']
                                : ['#ff0000', '#ffffff', '#44444a', '#800000', '#d1d1d1']
                        };
                    }

                        function initCharts() {
                            const colors = getThemeColors();
                            const isMobile = window.innerWidth < 768;
                            
                            if (monthlyChart) monthlyChart.destroy();
                            if (careerChart) careerChart.destroy();

                            // 1. Monthly Chart
                            monthlyChart = new Chart(ctxMonthly, {
                                type: 'line',
                                data: {
                                    labels: @json($monthlyStats['labels']),
                                    datasets: [{
                                        label: 'Nuevos Alumnos',
                                        data: @json($monthlyStats['data']),
                                        borderColor: colors.accent,
                                        backgroundColor: 'rgba(255, 0, 0, 0.1)',
                                        borderWidth: 3,
                                        fill: true,
                                        tension: 0.4,
                                        pointBackgroundColor: colors.accent,
                                        pointBorderColor: '#fff',
                                        pointHoverRadius: 6
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    plugins: { legend: { display: false } },
                                    scales: {
                                        y: {
                                            beginAtZero: true,
                                            grid: { color: colors.grid },
                                            ticks: { color: colors.text, font: { size: isMobile ? 9 : 11 } }
                                        },
                                        x: {
                                            grid: { display: false },
                                            ticks: { color: colors.text, font: { size: isMobile ? 9 : 11 } }
                                        }
                                    }
                                }
                            });

                            // 2. Career Chart - Premium Doughnut Style
                            careerChart = new Chart(ctxCareer, {
                                type: 'doughnut',
                                data: {
                                    labels: @json($careerStats['labels']),
                                    datasets: [{
                                        data: @json($careerStats['data']),
                                        backgroundColor: [
                                            '#ff0000', '#2d2d2d', '#4a4a4a', '#8a8a8a', 
                                            '#ff3333', '#1a1a1a', '#5c5c5c', '#9e9e9e',
                                            '#cc0000', '#3d3d3d', '#6e6e6e', '#bdbdbd'
                                        ],
                                        borderWidth: 2,
                                        borderColor: colors.bgSurface,
                                        hoverOffset: 15
                                    }]
                                },
                                options: {
                                    responsive: true,
                                    maintainAspectRatio: false,
                                    cutout: '75%',
                                    plugins: { 
                                        legend: { 
                                            display: !isMobile,
                                            position: 'right',
                                            labels: {
                                                color: colors.text,
                                                font: { family: 'Outfit', size: 11, weight: '600' },
                                                padding: 20,
                                                usePointStyle: true,
                                                pointStyle: 'circle'
                                            }
                                        },
                                        tooltip: {
                                            backgroundColor: 'rgba(0,0,0,0.9)',
                                            titleFont: { family: 'Outfit', size: 14, weight: 'bold' },
                                            bodyFont: { family: 'Inter', size: 13 },
                                            padding: 15,
                                            cornerRadius: 12,
                                            displayColors: true,
                                            borderColor: 'rgba(255,0,0,0.3)',
                                            borderWidth: 1
                                        }
                                    }
                                }
                            });
                        }

                    initCharts();
                    window.addEventListener('themeChanged', initCharts);
                    window.addEventListener('resize', initCharts);
                });
            </script>
@endsection
