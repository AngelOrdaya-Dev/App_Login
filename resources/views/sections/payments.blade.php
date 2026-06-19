@extends('layouts.admin')

@section('content')
<div class="panel" style="background: var(--bg-surface);">
    <div class="panel-header" style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem; margin-bottom: 2rem;">
        @if(Auth::user()->isAdmin())
            <h3 class="panel-title"><i class="fas fa-university"></i> Recaudación y Finanzas Globales</h3>
        @else
            <h3 class="panel-title"><i class="fas fa-wallet"></i> Estado de Cuenta y Pagos</h3>
        @endif
    </div>
    
    <div class="dashboard-grid" style="gap: 2rem;">
        
        @if(Auth::user()->isAdmin())
            <!-- Admin Financial Overview -->
            <div style="background: var(--bg-card); border: 1px solid #2ecc71; border-radius: 20px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 30px rgba(46,204,113,0.05); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(46,204,113,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <h4 style="color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Total Recaudado</h4>
                <div style="font-family: var(--font-display); font-size: clamp(2rem, 8vw, 3.5rem); font-weight: 800; color: #2ecc71; line-height: 1; margin-bottom: 0.5rem;">
                    ${{ number_format(\App\Models\Payment::where('status', 'paid')->sum('amount'), 2) }}
                </div>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Consolidado de todos los pagos aprobados</p>
            </div>

            <div style="background: var(--bg-card); border: 1px solid #f1c40f; border-radius: 20px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 30px rgba(241,196,15,0.05); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(241,196,15,0.1) 0%, transparent 70%); border-radius: 50%;"></div>
                <h4 style="color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Cuentas por Cobrar</h4>
                <div style="font-family: var(--font-display); font-size: clamp(2rem, 8vw, 3.5rem); font-weight: 800; color: #f1c40f; line-height: 1; margin-bottom: 0.5rem;">
                    ${{ number_format(\App\Models\Payment::where('status', 'pending')->sum('amount'), 2) }}
                </div>
                <p style="color: var(--text-muted); font-size: 0.85rem;">Total de pagos en espera de confirmación</p>
            </div>
        @else
            <!-- Student Balance Card -->
            <div style="background: var(--bg-card); border: 1px solid var(--border-red); border-radius: 20px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 30px rgba(255,0,0,0.05); position: relative; overflow: hidden;">
                <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,0,0,0.2) 0%, transparent 70%); border-radius: 50%;"></div>
                
                <h4 style="color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Deuda Total Pendiente</h4>
                <div style="font-family: var(--font-display); font-size: clamp(2rem, 8vw, 3.5rem); font-weight: 800; color: var(--text-main); line-height: 1; margin-bottom: 0.5rem;">${{ number_format($balance, 2) }}</div>
                
                @if($balance == 0)
                    <p style="color: #2ecc71; font-size: 0.85rem; font-weight: 600; margin-bottom: 2rem;"><i class="fas fa-check-circle"></i> Estás al día con tus pagos</p>
                @else
                    <p style="color: #f1c40f; font-size: 0.85rem; font-weight: 600; margin-bottom: 2rem;"><i class="fas fa-exclamation-triangle"></i> Tienes pagos pendientes</p>
                    <button type="button" class="btn-premium-logout" style="background: var(--accent-red); margin-bottom: 1rem; width: 100%;" onclick="openModal('paymentSelectionModal')">
                        <i class="fas fa-credit-card"></i> PAGAR AHORA
                    </button>
                @endif
                
                <button class="btn-premium-logout" id="btnShowHistory" style="background: var(--bg-card); box-shadow: none; border: 1px solid var(--border-color); color: var(--text-main); width: 100%;" onclick="toggleHistory()">
                    <i class="fas fa-file-invoice-dollar"></i> Ver Historial de Recibos
                </button>
            </div>
            
            <!-- Payment Selection Modal -->
            <div id="paymentSelectionModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.85); backdrop-filter: blur(10px); z-index: 10000; align-items: center; justify-content: center; padding: 1.5rem;">
                <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 30px; width: 100%; max-width: 600px; padding: 2.5rem; box-shadow: 0 40px 100px rgba(0,0,0,0.6);">
                    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2.5rem;">
                        <h3 style="font-family: 'Outfit', sans-serif; font-size: 1.6rem;"><i class="fas fa-shield-alt" style="color: #2ecc71;"></i> Pago Seguro</h3>
                        <button onclick="closeModal('paymentSelectionModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.5rem;">&times;</button>
                    </div>

                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
                        <!-- PayPal Option -->
                        <div style="text-align: center;">
                            <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-light); padding: 1.5rem; border-radius: 20px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <i class="fab fa-paypal" style="font-size: 3rem; color: #003087; margin-bottom: 1rem;"></i>
                                    <h4 style="margin-bottom: 10px;">PayPal</h4>
                                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.5rem;">Pago automático e instantáneo con tarjeta de crédito.</p>
                                </div>
                                <div id="paypal-button-container"></div>
                            </div>
                        </div>

                        <!-- Yape/Plin Option -->
                        <div style="text-align: center;">
                            <div style="background: rgba(255,255,255,0.03); border: 1px solid var(--border-light); padding: 1.5rem; border-radius: 20px; height: 100%; display: flex; flex-direction: column; justify-content: space-between;">
                                <div>
                                    <i class="fas fa-qrcode" style="font-size: 3rem; color: #00d1b2; margin-bottom: 1rem;"></i>
                                    <h4 style="margin-bottom: 10px;">Yape / Plin</h4>
                                    <p style="font-size: 0.8rem; color: var(--text-muted); margin-bottom: 1.5rem;">Escanea el QR y sube tu comprobante para validación manual.</p>
                                </div>
                                <button type="button" onclick="closeModal('paymentSelectionModal'); openModal('qrModal')" class="btn-premium-logout" style="background: #00d1b2; width: 100%; font-size: 0.85rem;">VER QR DE PAGO</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- QR Payment Modal -->
            <div id="qrModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.9); z-index: 10001; align-items: center; justify-content: center; padding: 1.5rem;">
                <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 30px; width: 100%; max-width: 450px; padding: 2rem; text-align: center;">
                    <div style="display: flex; justify-content: flex-end; margin-bottom: 1rem;">
                        <button onclick="closeModal('qrModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.5rem;">&times;</button>
                    </div>
                    <h4 style="margin-bottom: 1.5rem;">Escanea para Pagar</h4>
                    <img src="https://api.qrserver.com/v1/create-qr-code/?size=250x250&data=YAPE-ADMIN-PREMIER" alt="QR Yape" style="border-radius: 20px; margin-bottom: 1.5rem; border: 10px solid #fff;">
                    
                    <form action="#" method="POST" enctype="multipart/form-data" onsubmit="event.preventDefault(); alert('Comprobante subido. Esperando validación.'); closeModal('qrModal');">
                        <div style="display: flex; flex-direction: column; gap: 15px;">
                            <label style="font-size: 0.8rem; color: var(--text-muted); text-align: left;">Sube tu captura de pantalla:</label>
                            <input type="file" required style="background: var(--bg-base); padding: 10px; border-radius: 10px; color: #fff; font-size: 0.8rem;">
                            <button type="submit" class="btn-premium-logout" style="background: #00d1b2; width: 100%;">ENVIAR COMPROBANTE</button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Payment History (Existing) -->
            <div id="paymentHistory" style="display: none; margin-top: 2rem;">
                <h4 style="font-family: var(--font-display); font-size: 1.1rem; margin-bottom: 1rem;">Historial Reciente</h4>
                <div style="background: rgba(255,255,255,0.02); border-radius: 12px; padding: 1rem; border: 1px solid var(--border-light); max-height: 300px; overflow-y: auto;">
                    @forelse($payments as $payment)
                        <div style="display: flex; justify-content: space-between; align-items: center; padding: 12px; border-bottom: 1px solid var(--border-light); flex-wrap: wrap; gap: 10px;">
                            <div>
                                <div style="font-weight: 600; font-size: 0.9rem;">{{ $payment->description }}</div>
                                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $payment->created_at->format('d/m/Y') }}</div>
                            </div>
                            <div style="text-align: right; display: flex; flex-direction: column; align-items: flex-end; gap: 5px;">
                                <div style="font-weight: 700; font-family: var(--font-display);">${{ number_format($payment->amount, 2) }}</div>
                                <div style="display: flex; align-items: center; gap: 8px;">
                                    <a href="{{ route('payments.pdf', $payment->id) }}" class="action-btn" title="Descargar Recibo PDF" style="width: 28px; height: 28px; font-size: 0.7rem; background: rgba(255,255,255,0.05);">
                                        <i class="fas fa-download"></i>
                                    </a>
                                    <span style="font-size: 0.65rem; padding: 2px 8px; border-radius: 10px; background: {{ $payment->status == 'paid' ? 'rgba(46, 204, 113, 0.2)' : ($payment->status == 'pending' ? 'rgba(241, 196, 15, 0.2)' : 'rgba(231, 76, 60, 0.2)') }}; color: {{ $payment->status == 'paid' ? '#2ecc71' : ($payment->status == 'pending' ? '#f1c40f' : '#e74c3c') }};">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div style="text-align: center; padding: 20px; color: var(--text-muted); font-size: 0.9rem;">No hay registros de pago.</div>
                    @endforelse
                </div>
            </div>
        @endif
    </div>

    @if(Auth::user()->isAdmin())
        <!-- Full Payment List for Admin (Visible by default) -->
        <div style="margin-top: 3rem;">
            <h4 style="font-family: var(--font-display); font-size: 1.2rem; margin-bottom: 1.5rem;"><i class="fas fa-list-ul"></i> Registro Detallado</h4>
            <div class="table-responsive" style="background: rgba(255,255,255,0.02); border-radius: 16px; border: 1px solid var(--border-light); overflow-x: auto;">
                <table style="width: 100%; min-width: 800px; border-collapse: collapse; font-size: 0.85rem;">
                    <thead style="background: rgba(255,255,255,0.03); text-align: left;">
                        <tr>
                            <th style="padding: 1.2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Estudiante</th>
                            <th style="padding: 1.2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Descripción</th>
                            <th style="padding: 1.2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Monto</th>
                            <th style="padding: 1.2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Estado</th>
                            <th style="padding: 1.2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Fecha</th>
                            <th style="padding: 1.2rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Acciones</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($payments as $payment)
                            <tr style="border-bottom: 1px solid var(--border-light); transition: all 0.2s;">
                                <td style="padding: 1.2rem;"><strong>{{ $payment->user->name }}</strong></td>
                                <td style="padding: 1.2rem; color: var(--text-muted);">{{ $payment->description }}</td>
                                <td style="padding: 1.2rem; font-weight: 700; color: var(--text-main);">${{ number_format($payment->amount, 2) }}</td>
                                <td style="padding: 1.2rem;">
                                    <span style="font-size: 0.65rem; padding: 4px 10px; border-radius: 20px; background: {{ $payment->status == 'paid' ? 'rgba(46, 204, 113, 0.1)' : 'rgba(241, 196, 15, 0.1)' }}; color: {{ $payment->status == 'paid' ? '#2ecc71' : '#f1c40f' }}; font-weight: 700;">
                                        {{ strtoupper($payment->status) }}
                                    </span>
                                </td>
                                <td style="padding: 1.2rem; color: var(--text-muted);">{{ $payment->created_at->format('d/m/Y') }}</td>
                                <td style="padding: 1.2rem; display: flex; gap: 8px;">
                                    <a href="{{ route('payments.pdf', $payment->id) }}" class="action-btn" title="Descargar Recibo"><i class="fas fa-file-pdf"></i></a>
                                    @if($payment->status == 'pending')
                                        <form action="{{ route('payments.approve', $payment->id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" class="action-btn" title="Confirmar Pago" style="background: rgba(46, 204, 113, 0.1); color: #2ecc71; border: 1px solid rgba(46, 204, 113, 0.2);">
                                                <i class="fas fa-check"></i>
                                            </button>
                                        </form>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" style="padding: 3rem; text-align: center; color: var(--text-muted);">
                                    <i class="fas fa-file-invoice" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3; display: block;"></i>
                                    <p style="font-size: 1rem; margin: 0;">No hay pagos registrados en el sistema por el momento.</p>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>

<!-- Modal Agregar Tarjeta (Solo para Estudiantes) -->
@if(!Auth::user()->isAdmin())
<div id="addCardModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div style="background: var(--bg-surface); border: 1px solid var(--border-light); border-radius: 24px; padding: 2.5rem; box-shadow: 0 25px 50px -12px rgba(0,0,0,0.5);">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
            <h3 style="font-family: var(--font-display); font-size: 1.4rem;"><i class="fas fa-credit-card" style="color: var(--accent-red);"></i> Vincular Tarjeta</h3>
            <button onclick="closeModal('addCardModal')" style="background: transparent; border: none; color: var(--text-muted); cursor: pointer; font-size: 1.2rem;"><i class="fas fa-times"></i></button>
        </div>
        
        <form onsubmit="event.preventDefault(); alert('Tarjeta vinculada exitosamente (Simulación)'); closeModal('addCardModal');">
                <div style="display: flex; flex-direction: column; gap: 1.5rem;">
                    <div style="display: flex; flex-direction: column; gap: 8px;">
                        <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Número de Tarjeta</label>
                        <input type="text" class="modal-input" placeholder="**** **** **** ****" required style="width: 100% !important; box-sizing: border-box !important;">
                    </div>
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">Expira</label>
                            <input type="text" class="modal-input" placeholder="MM/YY" required style="width: 100% !important; box-sizing: border-box !important;">
                        </div>
                        <div style="display: flex; flex-direction: column; gap: 8px;">
                            <label style="font-size: 0.8rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 1px;">CVC</label>
                            <input type="password" class="modal-input" placeholder="***" required style="width: 100% !important; box-sizing: border-box !important;">
                        </div>
                    </div>
                    <button type="submit" class="btn-premium-logout" style="width: 100%; padding: 12px; margin-top: 1rem;">Vincular Método de Pago</button>
                </div>
        </form>
    </div>
</div>
@endif

<!-- PayPal SDK -->
<script src="https://www.paypal.com/sdk/js?client-id=sb&currency=USD"></script>

<script>
    // Initialize PayPal Buttons
    if (document.getElementById('paypal-button-container')) {
        paypal.Buttons({
            createOrder: function(data, actions) {
                return actions.order.create({
                    purchase_units: [{
                        amount: {
                            value: '{{ $balance }}'
                        },
                        description: 'Pago de Pensiones - Premier Academy'
                    }]
                });
            },
            onApprove: function(data, actions) {
                return actions.order.capture().then(function(details) {
                    alert('Pago completado por ' + details.payer.name.given_name + '!');
                    // Aquí podrías hacer una petición AJAX para registrar el pago en tu DB automáticamente
                    location.reload();
                });
            }
        }).render('#paypal-button-container');
    }

    function openModal(id) { 
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'flex'; 
    }
    function closeModal(id) { 
        const modal = document.getElementById(id);
        if (modal) modal.style.display = 'none'; 
    }

    function toggleHistory() {
        const history = document.getElementById('paymentHistory');
        const btn = document.getElementById('btnShowHistory');
        if (history) {
            if (history.style.display === 'none') {
                history.style.display = 'block';
                if (btn) btn.innerHTML = '<i class="fas fa-times"></i> Ocultar Historial';
            } else {
                history.style.display = 'none';
                if (btn) btn.innerHTML = '<i class="fas fa-file-invoice-dollar"></i> Ver Historial de Recibos';
            }
        }
    }
</script>
@endsection
