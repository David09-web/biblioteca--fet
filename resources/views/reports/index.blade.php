@extends('layouts.app')

@section('title', 'Reportes del Sistema - Biblioteca')

@section('content')
<div class="dashboard-header" style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca Admin</h2>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <button onclick="window.print()" class="btn-primary" style="padding: 0.5rem 1rem; width: auto; font-size: 0.875rem;">Imprimir Reporte</button>
        <a href="{{ route('dashboard') }}" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Volver al Inicio</a>
    </div>
</div>

<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem; animation: fadeIn 0.4s ease-out;" class="print-container">
    <div style="margin-bottom: 2rem; border-bottom: 2px solid var(--border-color); padding-bottom: 1rem;">
        <h1 style="color: var(--text-main); margin-bottom: 0.5rem;">Reporte Estadístico del Sistema</h1>
        <p style="color: var(--text-muted);">Generado el {{ now()->format('d/m/Y H:i') }}</p>
    </div>

    <!-- Stats Grid -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2.5rem;">
        
        <div style="background: white; padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--primary-color);">
            <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Inventario de Libros</h3>
            <div style="font-size: 2rem; font-weight: 700; color: var(--text-main);">{{ $totalBooks }}</div>
            <div style="color: var(--success-color); font-size: 0.875rem; font-weight: 500; margin-top: 0.5rem;">{{ $availableBooks }} Disponibles</div>
            <div style="color: var(--error-color); font-size: 0.875rem; font-weight: 500;">{{ $borrowedBooks }} Prestados</div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid var(--success-color);">
            <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Usuarios Registrados</h3>
            <div style="font-size: 2rem; font-weight: 700; color: var(--text-main);">{{ $totalUsers }}</div>
            <div style="color: var(--text-muted); font-size: 0.875rem; margin-top: 0.5rem;">{{ $totalStudents }} Estudiantes</div>
            <div style="color: var(--text-muted); font-size: 0.875rem;">{{ $totalTeachers }} Docentes</div>
        </div>

        <div style="background: white; padding: 1.5rem; border-radius: var(--radius); box-shadow: var(--shadow); border-left: 4px solid {{ count($overdueLoans) > 0 ? 'var(--error-color)' : '#F59E0B' }};">
            <h3 style="color: var(--text-muted); font-size: 0.875rem; text-transform: uppercase; letter-spacing: 0.05em; margin-bottom: 0.5rem;">Préstamos Activos</h3>
            <div style="font-size: 2rem; font-weight: 700; color: var(--text-main);">{{ $activeLoans }}</div>
            @if(count($overdueLoans) > 0)
                <div style="color: var(--error-color); font-size: 0.875rem; font-weight: 600; margin-top: 0.5rem;">⚠️ {{ count($overdueLoans) }} Vencidos</div>
            @else
                <div style="color: var(--success-color); font-size: 0.875rem; font-weight: 500; margin-top: 0.5rem;">✓ 0 Vencidos</div>
            @endif
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
