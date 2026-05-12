@extends('layouts.app')

@section('title', 'Panel de Control - Biblioteca')

@section('content')
<nav class="navbar">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-book-bookmark" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        <h2 style="margin: 0; color: var(--primary-color);">Biblioteca <span style="color: var(--text-main); font-weight: 300;">Admin</span></h2>
    </div>
    <div style="display: flex; align-items: center; gap: 1.5rem;">
        <div style="text-align: right; line-height: 1;">
            <div style="font-weight: 700; font-size: 0.9rem;">{{ auth()->user()->name }}</div>
            <div style="font-size: 0.75rem; color: var(--text-muted); text-transform: uppercase; letter-spacing: 0.05em; margin-top: 0.2rem;">{{ auth()->user()->role }}</div>
        </div>
        <form method="POST" action="{{ route('logout') }}" style="margin: 0;">
            @csrf
            <button type="submit" class="btn-premium" style="background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1rem; font-size: 0.85rem; gap: 0.5rem;">
                <i class="fa-solid fa-right-from-bracket"></i> Salir
            </button>
        </form>
    </div>
</nav>

<div class="container animate-fade">
    <div style="margin-bottom: 3rem;">
        <h1 style="margin-bottom: 0.5rem;">Panel de Control</h1>
        <p style="color: var(--text-muted);">Bienvenido de nuevo. Aquí tienes un resumen del estado actual de la biblioteca.</p>
    </div>

    @php
        $overdueCount = \App\Models\Loan::where('status', 'active')->where('due_date', '<', now())->count();
        $totalBooks = \App\Models\Book::sum('total_copies');
        $activeLoans = \App\Models\Loan::where('status', 'active')->count();
        $totalUsers = \App\Models\User::count();
    @endphp

    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon" style="background: var(--primary-light); color: var(--primary-color);"><i class="fa-solid fa-book"></i></div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Total Libros</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $totalBooks }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #e0e7ff; color: #4338ca;"><i class="fa-solid fa-users"></i></div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Usuarios</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $totalUsers }}</div>
            </div>
        </div>
        <div class="stat-card">
            <div class="stat-icon" style="background: #dcfce7; color: #15803d;"><i class="fa-solid fa-hand-holding-heart"></i></div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Préstamos Activos</div>
                <div style="font-size: 1.5rem; font-weight: 800;">{{ $activeLoans }}</div>
            </div>
        </div>
        <div class="stat-card" style="{{ $overdueCount > 0 ? 'border-color: #fca5a5; background: #fffcfc;' : '' }}">
            <div class="stat-icon" style="background: #fee2e2; color: #b91c1c;"><i class="fa-solid fa-clock-rotate-left"></i></div>
            <div>
                <div style="font-size: 0.85rem; color: var(--text-muted); font-weight: 600;">Vencidos</div>
                <div style="font-size: 1.5rem; font-weight: 800; color: {{ $overdueCount > 0 ? '#b91c1c' : 'inherit' }}">{{ $overdueCount }}</div>
            </div>
        </div>
    </div>


    <div style="background: white; border-radius: var(--radius-lg); padding: 2.5rem; border: 1px solid var(--border-color); box-shadow: var(--shadow-sm);">
        <h2 style="margin-bottom: 2rem; display: flex; align-items: center; gap: 0.75rem; font-size: 1.25rem;">
            <i class="fa-solid fa-bolt-lightning" style="color: #eab308;"></i> Acciones Rápidas
        </h2>
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.25rem;">
            @if(auth()->user()->role === 'admin')
                <a href="{{ route('books.index') }}" class="btn-premium btn-primary" style="gap: 0.6rem;">
                    <i class="fa-solid fa-box-archive"></i> Gestionar Libros
                </a>
                <a href="{{ route('users.index') }}" class="btn-premium" style="background: #1e293b; color: white; gap: 0.6rem;">
                    <i class="fa-solid fa-users-gear"></i> Usuarios
                </a>
                <a href="{{ route('loans.index') }}" class="btn-premium" style="background: #10b981; color: white; gap: 0.6rem;">
                    <i class="fa-solid fa-file-invoice"></i> Préstamos
                </a>
                <a href="{{ route('reports.index') }}" class="btn-premium" style="background: #6366f1; color: white; gap: 0.6rem;">
                    <i class="fa-solid fa-chart-pie"></i> Reportes
                </a>
            @else
                <a href="{{ route('catalog.index') }}" class="btn-premium btn-primary" style="gap: 0.6rem;">
                    <i class="fa-solid fa-layer-group"></i> Consultar Catálogo
                </a>
                <a href="{{ route('loans.index') }}" class="btn-premium" style="background: #10b981; color: white; gap: 0.6rem;">
                    <i class="fa-solid fa-clock-rotate-left"></i> Mis Préstamos
                </a>
            @endif
        </div>
    </div>
</div>

@endsection
