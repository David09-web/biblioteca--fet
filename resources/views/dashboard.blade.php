@extends('layouts.app')

@section('title', 'Panel de Control - Biblioteca')

@section('content')
<div class="dashboard-header" style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca</h2>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <span style="font-weight: 500;">Hola, {{ auth()->user()->name }} ({{ ucfirst(auth()->user()->role) }})</span>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" style="background: transparent; border: 1px solid var(--border-color); padding: 0.5rem 1rem; border-radius: 6px; cursor: pointer; color: var(--text-main); font-weight: 500; transition: all 0.2s;">
                Cerrar Sesión
            </button>
        </form>
    </div>
</div>

<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem; animation: fadeIn 0.4s ease-out;">

    @php
        $overdueLoans = \App\Models\Loan::where('status', 'active')->where('due_date', '<', now());
        if(auth()->user()->role !== 'admin') {
            $overdueLoans->where('user_id', auth()->id());
        }
        $overdueCount = $overdueLoans->count();
    @endphp

    @if($overdueCount > 0)
    <div style="background-color: #FEF2F2; border-left: 4px solid var(--error-color); padding: 1rem 1.5rem; border-radius: 4px; margin-bottom: 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.05); display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h3 style="color: #9B1C1C; margin: 0 0 0.25rem 0; font-size: 1rem;">⚠️ Aviso Importante</h3>
            <p style="color: #7F1D1D; margin: 0; font-size: 0.9rem;">
                @if(auth()->user()->role === 'admin')
                    Existen <strong>{{ $overdueCount }}</strong> préstamos vencidos en el sistema que requieren atención.
                @else
                    Tienes <strong>{{ $overdueCount }}</strong> libro(s) con fecha de devolución vencida. Por favor, devuélvelos lo antes posible en la biblioteca.
                @endif
            </p>
        </div>
        <a href="{{ route('loans.index') }}" style="color: var(--error-color); font-weight: 600; font-size: 0.9rem; text-decoration: underline;">Revisar Préstamos</a>
    </div>
    @endif

    <div class="dashboard-card" style="background: white; border-radius: var(--radius); padding: 2rem; box-shadow: var(--shadow);">
        <h1 style="margin-bottom: 1rem; color: var(--text-main);">Bienvenido al Panel de Control</h1>
        <p style="color: var(--text-muted); line-height: 1.6;">
            @if(auth()->user()->role === 'admin')
                Esta es la vista de <strong>Administrador/Bibliotecario</strong>. Aquí podrás gestionar los libros del catálogo, aprobar préstamos y administrar a los usuarios.
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <a href="{{ route('books.index') }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; text-align: center;">Gestionar Libros</a>
                    <a href="{{ route('users.index') }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; background-color: var(--text-main); text-align: center;">Gestionar Usuarios</a>
                    <a href="{{ route('loans.index') }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; background-color: var(--success-color); text-align: center;">Ver Préstamos</a>
                    <a href="{{ route('reports.index') }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; background-color: #6B7280; text-align: center;">Reportes</a>
                </div>
            @else
                Esta es la vista de <strong>Estudiante</strong>. Aquí podrás consultar la disponibilidad de libros y verificar tus préstamos activos.
                <div style="margin-top: 1.5rem; display: flex; gap: 1rem;">
                    <a href="{{ route('catalog.index') }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; text-align: center;">Consultar Catálogo</a>
                    <a href="{{ route('loans.index') }}" class="btn-primary" style="text-decoration: none; display: inline-block; width: auto; background-color: var(--success-color); text-align: center;">Mis Préstamos</a>
                </div>
            @endif
        </p>
    </div>
</div>
@endsection
