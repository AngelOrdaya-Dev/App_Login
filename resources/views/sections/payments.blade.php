@extends('layouts.admin')

@section('content')
<div class="panel" style="background: linear-gradient(145deg, #1a1a1f 0%, #0f0f11 100%);">
    <div class="panel-header" style="border-bottom: 1px solid var(--border-light); padding-bottom: 1.5rem; margin-bottom: 2rem;">
        <h3 class="panel-title"><i class="fas fa-wallet"></i> Estado de Cuenta y Pagos</h3>
    </div>
    
    <div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
        
        <!-- Balance Card -->
        <div style="background: var(--bg-card); border: 1px solid var(--border-red); border-radius: 20px; padding: 2.5rem; text-align: center; box-shadow: 0 10px 30px rgba(255,0,0,0.05); position: relative; overflow: hidden;">
            <div style="position: absolute; top: -50px; left: -50px; width: 150px; height: 150px; background: radial-gradient(circle, rgba(255,0,0,0.2) 0%, transparent 70%); border-radius: 50%;"></div>
            
            <h4 style="color: var(--text-muted); font-size: 0.9rem; text-transform: uppercase; letter-spacing: 2px; margin-bottom: 1rem;">Deuda Total Pendiente</h4>
            <div style="font-family: var(--font-display); font-size: 3.5rem; font-weight: 800; color: var(--text-main); line-height: 1; margin-bottom: 0.5rem;">$0<span style="font-size: 1.5rem; color: var(--text-muted);">.00</span></div>
            <p style="color: #2ecc71; font-size: 0.85rem; font-weight: 600; margin-bottom: 2rem;"><i class="fas fa-check-circle"></i> Estás al día con tus pagos</p>
            
            <button class="btn-premium-logout" id="btnShowHistory" style="background: #2a2a2e; box-shadow: none; border: 1px solid var(--border-color); color: var(--text-main);" onclick="toggleHistory()">
                <i class="fas fa-file-invoice-dollar"></i> Ver Historial de Recibos
            </button>
        </div>
        
        <!-- Payment Methods -->
        <div>
            <div id="paymentHistory" style="display: none; margin-bottom: 2rem;">
                <h4 style="font-family: var(--font-display); font-size: 1.1rem; margin-bottom: 1rem;">Historial Reciente</h4>
                <div style="background: rgba(255,255,255,0.02); border-radius: 12px; padding: 1rem; border: 1px solid var(--border-light);">
                    <div style="display: flex; justify-content: space-between; padding: 10px; border-bottom: 1px solid var(--border-light);">
                        <span>Matrícula 2026-I</span>
                        <span style="font-weight: 600;">$0.00 (Beca)</span>
                    </div>
                    <div style="display: flex; justify-content: space-between; padding: 10px;">
                        <span>Derecho de Carnet</span>
                        <span style="font-weight: 600;">$15.00 (Pagado)</span>
                    </div>
                </div>
            </div>

            <h4 style="font-family: var(--font-display); font-size: 1.1rem; margin-bottom: 1.5rem;">Métodos de Pago Vinculados</h4>
            
            <div style="display: flex; flex-direction: column; gap: 1rem;">
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; background: rgba(255,255,255,0.02); border: 1px solid var(--border-light); border-radius: 16px;">
                    <div style="display: flex; align-items: center; gap: 15px;">
                        <div style="font-size: 2rem; color: #fff;"><i class="fab fa-cc-visa"></i></div>
                        <div>
                            <div style="font-weight: 600; font-family: var(--font-display);">Visa terminada en **** 4242</div>
                            <div style="font-size: 0.8rem; color: var(--text-muted);">Expira 12/28</div>
                        </div>
                    </div>
                    <span style="padding: 4px 10px; border-radius: 20px; font-size: 0.7rem; font-weight: bold; background: rgba(255,255,255,0.1); border: 1px solid rgba(255,255,255,0.2);">Principal</span>
                </div>
                
                <div style="display: flex; justify-content: space-between; align-items: center; padding: 1.5rem; border: 1px dashed var(--border-color); border-radius: 16px; cursor: pointer; transition: var(--transition-smooth);" onclick="alert('Funcionalidad de agregar tarjeta próximamente')">
                    <div style="display: flex; align-items: center; gap: 15px; color: var(--text-muted);">
                        <i class="fas fa-plus"></i> Agregar nuevo método de pago
                    </div>
                </div>
            </div>
        </div>
        
    </div>
</div>

<script>
    function toggleHistory() {
        const history = document.getElementById('paymentHistory');
        const btn = document.getElementById('btnShowHistory');
        if (history.style.display === 'none') {
            history.style.display = 'block';
            btn.innerHTML = '<i class="fas fa-times"></i> Ocultar Historial';
        } else {
            history.style.display = 'none';
            btn.innerHTML = '<i class="fas fa-file-invoice-dollar"></i> Ver Historial de Recibos';
        }
    }
</script>
@endsection
