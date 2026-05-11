@extends('layouts.admin')

@section('content')
<div class="panel">
    <div class="panel-header" style="border-bottom: 1px solid var(--border-light); padding-bottom: 1rem;">
        <h3 class="panel-title"><i class="fas fa-chart-pie"></i> Dashboard Financiero</h3>
        <div style="font-size: 0.75rem; color: var(--text-muted); font-weight: 600; text-transform: uppercase; letter-spacing: 1px;">
            <i class="fas fa-sync-alt"></i> {{ now()->format('d/m/Y H:i') }}
        </div>
    </div>

    <!-- Quick Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        <div style="background: linear-gradient(135deg, rgba(46, 204, 113, 0.1), rgba(46, 204, 113, 0.05)); border: 1px solid rgba(46, 204, 113, 0.2); padding: 1.5rem; border-radius: 16px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; color: rgba(46, 204, 113, 0.1); transform: rotate(-15deg);">
                <i class="fas fa-hand-holding-usd"></i>
            </div>
            <p style="color: #2ecc71; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Recaudación Total</p>
            <h4 style="font-size: 1.8rem; font-weight: 900; margin: 0; color: var(--text-main);">S/ {{ number_format($stats['total_revenue'], 2) }}</h4>
        </div>

        <div style="background: linear-gradient(135deg, rgba(231, 76, 60, 0.1), rgba(231, 76, 60, 0.05)); border: 1px solid rgba(231, 76, 60, 0.2); padding: 1.5rem; border-radius: 16px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; color: rgba(231, 76, 60, 0.1); transform: rotate(-15deg);">
                <i class="fas fa-clock"></i>
            </div>
            <p style="color: #e74c3c; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Cobros Pendientes</p>
            <h4 style="font-size: 1.8rem; font-weight: 900; margin: 0; color: var(--text-main);">{{ $stats['pending_payments'] }}</h4>
        </div>

        <div style="background: linear-gradient(135deg, rgba(52, 152, 219, 0.1), rgba(52, 152, 219, 0.05)); border: 1px solid rgba(52, 152, 219, 0.2); padding: 1.5rem; border-radius: 16px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; color: rgba(52, 152, 219, 0.1); transform: rotate(-15deg);">
                <i class="fas fa-user-graduate"></i>
            </div>
            <p style="color: #3498db; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Alumnos Registrados</p>
            <h4 style="font-size: 1.8rem; font-weight: 900; margin: 0; color: var(--text-main);">{{ $stats['total_students'] }}</h4>
        </div>

        <div style="background: linear-gradient(135deg, rgba(155, 89, 182, 0.1), rgba(155, 89, 182, 0.05)); border: 1px solid rgba(155, 89, 182, 0.2); padding: 1.5rem; border-radius: 16px; position: relative; overflow: hidden;">
            <div style="position: absolute; right: -10px; bottom: -10px; font-size: 5rem; color: rgba(155, 89, 182, 0.1); transform: rotate(-15deg);">
                <i class="fas fa-file-signature"></i>
            </div>
            <p style="color: #9b59b6; font-size: 0.8rem; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 10px;">Matrículas Aprobadas</p>
            <h4 style="font-size: 1.8rem; font-weight: 900; margin: 0; color: var(--text-main);">{{ $stats['active_enrollments'] }}</h4>
        </div>
    </div>

    <!-- Charts Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
        <!-- Monthly Revenue Chart -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1.2rem; border-radius: 20px;">
            <h5 style="margin-bottom: 1.2rem; color: var(--text-main); font-size: 0.9rem;"><i class="fas fa-chart-line" style="color: #2ecc71;"></i> Ingresos Mensuales</h5>
            <div style="height: 250px; width: 100%; position: relative;">
                <canvas id="revenueChart"></canvas>
            </div>
        </div>

        <!-- Career Distribution Chart -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1.2rem; border-radius: 20px;">
            <h5 style="margin-bottom: 1.2rem; color: var(--text-main); font-size: 0.9rem;"><i class="fas fa-users" style="color: #3498db;"></i> Alumnos por Carrera</h5>
            <div style="height: 250px; width: 100%; position: relative;">
                <canvas id="careerChart"></canvas>
            </div>
        </div>

        <!-- Payment Status Chart -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1.2rem; border-radius: 20px;">
            <h5 style="margin-bottom: 1.2rem; color: var(--text-main); font-size: 0.9rem;"><i class="fas fa-receipt" style="color: #f1c40f;"></i> Estado de Pagos</h5>
            <div style="height: 250px; width: 100%; position: relative;">
                <canvas id="statusChart"></canvas>
            </div>
        </div>

        <!-- Growth Info -->
        <div style="background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); padding: 1.5rem; border-radius: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center; text-align: center;">
            <div style="background: rgba(255,0,0,0.1); width: 80px; height: 80px; border-radius: 50%; display: flex; align-items: center; justify-content: center; margin-bottom: 1.5rem;">
                <i class="fas fa-rocket" style="font-size: 2rem; color: var(--accent-red);"></i>
            </div>
            <h4 style="color: var(--text-main); margin-bottom: 10px;">Rendimiento del Sistema</h4>
            <p style="color: var(--text-muted); font-size: 0.9rem; max-width: 300px;">El sistema está procesando datos en tiempo real. Todos los indicadores financieros reflejan transacciones validadas por administración.</p>
            <button onclick="window.print()" style="margin-top: 1.5rem; background: var(--bg-surface-hover); border: 1px solid var(--border-light); color: var(--text-main); padding: 10px 20px; border-radius: 8px; cursor: pointer; font-size: 0.85rem; font-weight: 600;">
                <i class="fas fa-download"></i> Descargar Reporte PDF
            </button>
        </div>
    </div>
</div>

<!-- Chart.js Library -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Colors from our theme
        const accentColor = getComputedStyle(document.documentElement).getPropertyValue('--accent-red').trim() || '#ff0000';
        
        // 1. Monthly Revenue Chart
        const revenueCtx = document.getElementById('revenueChart').getContext('2d');
        new Chart(revenueCtx, {
            type: 'line',
            data: {
                labels: {!! json_encode($monthlyRevenue->pluck('month')) !!},
                datasets: [{
                    label: 'Recaudación',
                    data: {!! json_encode($monthlyRevenue->pluck('total')) !!},
                    borderColor: '#2ecc71',
                    backgroundColor: 'rgba(46, 204, 113, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointRadius: 5,
                    pointBackgroundColor: '#2ecc71'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888', font: { size: 10 } } },
                    x: { 
                        grid: { display: false }, 
                        ticks: { 
                            color: '#888', 
                            font: { size: 9 },
                            maxRotation: 0,
                            autoSkip: true,
                            callback: function(value) {
                                let label = this.getLabelForValue(value);
                                if (label.length > 8) return label.substring(0, 8) + '...';
                                return label;
                            }
                        } 
                    }
                }
            }
        });

        // 2. Career Distribution Chart
        const careerCtx = document.getElementById('careerChart').getContext('2d');
        new Chart(careerCtx, {
            type: 'bar',
            data: {
                labels: {!! json_encode($studentsByCareer->pluck('name')) !!},
                datasets: [{
                    label: 'Alumnos',
                    data: {!! json_encode($studentsByCareer->pluck('users_count')) !!},
                    backgroundColor: [
                        'rgba(52, 152, 219, 0.7)',
                        'rgba(155, 89, 182, 0.7)',
                        'rgba(241, 196, 15, 0.7)',
                        'rgba(230, 126, 34, 0.7)'
                    ],
                    borderRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, grid: { color: 'rgba(255,255,255,0.05)' }, ticks: { color: '#888', font: { size: 10 } } },
                    x: { 
                        grid: { display: false }, 
                        ticks: { 
                            color: '#888', 
                            font: { size: 9 },
                            maxRotation: 0,
                            autoSkip: true,
                            callback: function(value) {
                                let label = this.getLabelForValue(value);
                                if (label.length > 8) return label.substring(0, 8) + '...';
                                return label;
                            }
                        } 
                    }
                }
            }
        });

        // 3. Payment Status Chart
        const statusCtx = document.getElementById('statusChart').getContext('2d');
        new Chart(statusCtx, {
            type: 'doughnut',
            data: {
                labels: {!! json_encode($paymentStatus->pluck('status')->map(fn($s) => ucfirst($s))) !!},
                datasets: [{
                    data: {!! json_encode($paymentStatus->pluck('count')) !!},
                    backgroundColor: ['#2ecc71', '#f1c40f', '#e74c3c'],
                    borderWidth: 0,
                    hoverOffset: 10
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: { position: 'bottom', labels: { color: '#888', usePointStyle: true, padding: 20 } }
                },
                cutout: '70%'
            }
        });
    });
</script>
@endsection
