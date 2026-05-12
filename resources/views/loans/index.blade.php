@extends('layouts.app')

@section('title', 'Registro de Préstamos - Biblioteca')

@section('content')
<nav class="navbar">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-clock-rotate-left" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        <h2 style="margin: 0; color: var(--primary-color);">Historial <span style="color: var(--text-main); font-weight: 300;">de Préstamos</span></h2>
    </div>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <div style="text-align: right; line-height: 1; margin-right: 0.5rem;">
            <div style="font-weight: 700; font-size: 0.9rem;">{{ auth()->user()->name }}</div>
        </div>
        <a href="{{ route('dashboard') }}" class="btn-premium" style="background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1rem; font-size: 0.85rem; gap: 0.5rem;">
            <i class="fa-solid fa-arrow-left"></i> Volver al Inicio
        </a>
    </div>
</nav>

<div class="container animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Registro Histórico</h1>
        <span style="background: var(--primary-light); color: var(--primary-color); padding: 0.4rem 0.8rem; border-radius: 999px; font-size: 0.75rem; font-weight: 700; text-transform: uppercase;">
            <i class="fa-solid fa-shield-halved" style="margin-right: 0.3rem;"></i> Administración
        </span>
    </div>

    @if(session('success'))
        <div style="background: var(--success-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">{{ session('success') }}</div>
    @endif
    @if(session('error'))
        <div style="background: var(--error-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">{{ session('error') }}</div>
    @endif

    <div class="dashboard-card" style="background: white; border-radius: var(--radius); padding: 0; box-shadow: var(--shadow); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F3F4F6; border-bottom: 1px solid var(--border-color); text-align: left;">
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Carnet</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Estudiante</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Teléfono</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">No. ID</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Libro</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Fechas</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Estado</th>
                    <th style="padding: 0.875rem 1rem; color: var(--text-muted); font-size: 0.8rem; text-transform: uppercase; letter-spacing: 0.05em;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($loans as $loan)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.15s;"
                    onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background=''">

                    {{-- Miniatura carnet --}}
                    <td style="padding: 0.75rem 1rem;">
                        @if($loan->carnet_photo_path)
                            <a href="{{ asset('storage/' . $loan->carnet_photo_path) }}" target="_blank" title="Ver carnet completo">
                                <img src="{{ asset('storage/' . $loan->carnet_photo_path) }}"
                                     alt="Carnet de {{ $loan->student_name }}"
                                     style="width: 48px; height: 48px; object-fit: cover; border-radius: 8px; border: 2px solid #E5E7EB; transition: transform 0.2s;"
                                     onmouseover="this.style.transform='scale(1.1)'" onmouseout="this.style.transform='scale(1)'">
                            </a>
                        @else
                            <div style="width:48px;height:48px;background:#F3F4F6;border-radius:8px;display:flex;align-items:center;justify-content:center;color:var(--text-muted);">
                                <i class="fa-solid fa-id-card" style="font-size: 1.25rem;"></i>
                            </div>
                        @endif
                    </td>

                    {{-- Estudiante --}}
                    <td style="padding: 0.75rem 1rem; font-weight: 600; color: var(--text-main);">
                        {{ $loan->student_name ?? '—' }}
                    </td>

                    {{-- Teléfono --}}
                    <td style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.9rem;">
                        <i class="fa-solid fa-phone" style="font-size: 0.75rem; margin-right: 0.3rem; opacity: 0.5;"></i> {{ $loan->phone ?? '—' }}
                    </td>

                    {{-- ID --}}
                    <td style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.9rem; font-family: monospace;">
                        {{ $loan->id_number ?? '—' }}
                    </td>

                    {{-- Libro --}}
                    <td style="padding: 0.75rem 1rem; font-weight: 500; color: var(--text-main);">
                        <i class="fa-solid fa-book" style="font-size: 0.8rem; margin-right: 0.4rem; color: var(--primary-color); opacity: 0.6;"></i> {{ $loan->book->title ?? 'Eliminado' }}
                    </td>

                    {{-- Fechas --}}
                    <td style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.85rem;">
                        <div style="margin-bottom: 0.2rem;"><i class="fa-solid fa-arrow-up-from-bracket" style="width: 14px;"></i> {{ $loan->checkout_date->format('d/m/Y') }}</div>
                        <div style="color: {{ $loan->due_date->isPast() && $loan->status === 'active' ? 'var(--error-color)' : 'inherit' }}; font-weight: {{ $loan->due_date->isPast() && $loan->status === 'active' ? '600' : 'normal' }}">
                            <i class="fa-solid fa-clock" style="width: 14px;"></i> {{ $loan->due_date->format('d/m/Y') }}
                        </div>
                    </td>

                    {{-- Estado --}}
                    <td style="padding: 0.75rem 1rem;">
                        @if($loan->status === 'active')
                            @if($loan->due_date->isPast())
                                <span style="background:#FDE8E8;color:#9B1C1C;padding:0.35rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;gap:0.4rem;">
                                    <i class="fa-solid fa-circle-exclamation"></i> Vencido
                                </span>
                            @else
                                <span style="background:#E1EFFE;color:#1E429F;padding:0.35rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;gap:0.4rem;">
                                    <i class="fa-solid fa-spinner fa-spin-fast"></i> Activo
                                </span>
                            @endif
                        @else
                            <span style="background:#DEF7EC;color:#03543F;padding:0.35rem 0.75rem;border-radius:999px;font-size:0.75rem;font-weight:700;display:inline-flex;align-items:center;gap:0.4rem;">
                                <i class="fa-solid fa-circle-check"></i> Devuelto
                            </span>
                        @endif
                    </td>

                    {{-- Acción --}}
                    <td style="padding: 0.75rem 1rem;">
                        @if($loan->status === 'active')
                            <form action="{{ route('loans.return', $loan) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-premium"
                                        style="padding:0.5rem 0.8rem;font-size:0.8rem;width:auto;background-color:var(--success-color);color:white;gap:0.4rem;"
                                        onclick="return confirm('¿Registrar la devolución de este libro?')">
                                    <i class="fa-solid fa-check"></i> Devuelto
                                </button>
                            </form>
                        @else
                            <span style="color:var(--text-muted);font-size:0.85rem;display:flex;align-items:center;gap:0.4rem;">
                                <i class="fa-solid fa-check-double"></i> Finalizado
                            </span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="8" style="padding: 2rem; text-align: center; color: var(--text-muted);">No hay préstamos registrados.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
