@extends('layouts.app')

@section('title', 'Reportes del Sistema - Biblioteca')

@section('content')
<nav class="navbar">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-chart-line" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        <h2 style="margin: 0; color: var(--primary-color);">Reportes <span style="color: var(--text-main); font-weight: 300;">Estadísticos</span></h2>
    </div>
    <div style="display: flex; gap: 1rem; align-items: center;">
        <button onclick="window.print()" class="btn-premium btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem; gap: 0.5rem;">
            <i class="fa-solid fa-print"></i> Imprimir
        </button>
        <a href="{{ route('dashboard') }}" class="btn-premium" style="background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1rem; font-size: 0.85rem; gap: 0.5rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver
        </a>
    </div>
</nav>

<div class="container animate-fade print-container">
    <header style="margin-bottom: 3rem; text-align: center; border-bottom: 1px solid var(--border-color); padding-bottom: 2rem;">
        <h1 style="margin-bottom: 0.5rem; font-weight: 800;">Estado del Sistema</h1>
        <p style="color: var(--text-muted);">Corte informativo generado el {{ now()->format('d/m/Y H:i') }}</p>
    </header>


    <!-- Stats Grid -->
    <div class="stats-grid">
        
        <div class="stat-card" style="border-top: 4px solid var(--primary-color);">
            <div class="stat-icon" style="background: var(--primary-light); color: var(--primary-color);">
                <i class="fa-solid fa-boxes-stacked"></i>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Inventario</div>
                <div style="font-size: 1.75rem; font-weight: 800;">{{ $totalBooks }}</div>
                <div style="font-size: 0.75rem; color: var(--success-color);">{{ $availableBooks }} Disp.</div>
            </div>
        </div>

        <div class="stat-card" style="border-top: 4px solid #4338ca;">
            <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;">
                <i class="fa-solid fa-user-group"></i>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Comunidad</div>
                <div style="font-size: 1.75rem; font-weight: 800;">{{ $totalUsers }}</div>
                <div style="font-size: 0.75rem; color: var(--text-muted);">{{ $totalStudents }} Est. / {{ $totalTeachers }} Doc.</div>
            </div>
        </div>

        <div class="stat-card" style="border-top: 4px solid {{ count($overdueLoans) > 0 ? 'var(--error-color)' : 'var(--success-color)' }};">
            <div class="stat-icon" style="background: {{ count($overdueLoans) > 0 ? '#fee2e2' : '#dcfce7' }}; color: {{ count($overdueLoans) > 0 ? 'var(--error-color)' : 'var(--success-color)' }};">
                <i class="fa-solid {{ count($overdueLoans) > 0 ? 'fa-triangle-exclamation' : 'fa-circle-check' }}"></i>
            </div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Préstamos Activos</div>
                <div style="font-size: 1.75rem; font-weight: 800;">{{ $activeLoans }}</div>
                <div style="font-size: 0.75rem; color: {{ count($overdueLoans) > 0 ? 'var(--error-color)' : 'var(--success-color)' }}; font-weight: 700;">
                    {{ count($overdueLoans) }} Vencidos
                </div>
            </div>
        </div>

    </div>


    <!-- Overdue Table -->
    @if(count($overdueLoans) > 0)
    <div style="margin-bottom: 2rem;">
        <h2 style="color: var(--error-color); margin-bottom: 1rem; border-bottom: 1px solid #FCA5A5; padding-bottom: 0.5rem;">Detalle de Préstamos Vencidos</h2>
        <div class="dashboard-card" style="background: white; border-radius: var(--radius); padding: 0; box-shadow: var(--shadow); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr style="background: #FEF2F2; border-bottom: 1px solid #FCA5A5; text-align: left;">
                        <th style="padding: 1rem; color: #9B1C1C; font-size: 0.875rem;">Libro</th>
                        <th style="padding: 1rem; color: #9B1C1C; font-size: 0.875rem;">Usuario (Rol)</th>
                        <th style="padding: 1rem; color: #9B1C1C; font-size: 0.875rem;">Fecha Salida</th>
                        <th style="padding: 1rem; color: #9B1C1C; font-size: 0.875rem;">Fecha Límite</th>
                        <th style="padding: 1rem; color: #9B1C1C; font-size: 0.875rem;">Días Retraso</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overdueLoans as $loan)
                    <tr style="border-bottom: 1px solid var(--border-color);">
                        <td style="padding: 1rem; font-weight: 500; color: var(--text-main);">{{ $loan->book->title ?? 'N/A' }}</td>
                        <td style="padding: 1rem; color: var(--text-muted);">{{ $loan->user->name ?? 'N/A' }} ({{ $loan->user->role ?? '' }})</td>
                        <td style="padding: 1rem; color: var(--text-muted);">{{ $loan->checkout_date->format('d/m/Y') }}</td>
                        <td style="padding: 1rem; color: var(--error-color); font-weight: 500;">{{ $loan->due_date->format('d/m/Y') }}</td>
                        <td style="padding: 1rem; color: var(--error-color); font-weight: 700;">{{ floor(now()->diffInDays($loan->due_date)) }} días</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    @endif
    
    <div class="print-only" style="display: none; margin-top: 3rem; text-align: center; color: var(--text-muted); border-top: 1px solid var(--border-color); padding-top: 1rem;">
        Documento oficial interno. Biblioteca Universitaria.
    </div>
</div>

<style>
    @media print {
        body { background: white; }
        .dashboard-header, .btn-primary { display: none !important; }
        .dashboard-card, .print-container > div { box-shadow: none !important; border: 1px solid #ddd; }
        .print-only { display: block !important; }
        @page { margin: 1cm; }
    }
</style>
@endsection
