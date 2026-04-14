@extends('layouts.app')

@section('title', 'Registro de Préstamos - Biblioteca')

@section('content')
<div style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca</h2>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <span style="font-weight: 500;">{{ auth()->user()->name }}</span>
        <a href="{{ route('dashboard') }}" style="color: var(--text-main); text-decoration: none; font-weight: 500; margin-left: 1rem;">Volver al Inicio</a>
    </div>
</div>

<div style="max-width: 1300px; margin: 2rem auto; padding: 0 1rem; animation: fadeIn 0.4s ease-out;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="color: var(--text-main); margin: 0;">Registro Histórico de Préstamos</h1>
        <span style="color: var(--text-muted); font-size: 0.875rem;">Administración</span>
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
                            <span style="width:48px;height:48px;background:#F3F4F6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.3rem;">🪪</span>
                        @endif
                    </td>

                    {{-- Estudiante --}}
                    <td style="padding: 0.75rem 1rem; font-weight: 600; color: var(--text-main);">
                        {{ $loan->student_name ?? '—' }}
                    </td>

                    {{-- Teléfono --}}
                    <td style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.9rem;">
                        {{ $loan->phone ?? '—' }}
                    </td>

                    {{-- ID --}}
                    <td style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.9rem; font-family: monospace;">
                        {{ $loan->id_number ?? '—' }}
                    </td>

                    {{-- Libro --}}
                    <td style="padding: 0.75rem 1rem; font-weight: 500; color: var(--text-main);">
                        {{ $loan->book->title ?? 'Eliminado' }}
                    </td>

                    {{-- Fechas --}}
                    <td style="padding: 0.75rem 1rem; color: var(--text-muted); font-size: 0.85rem;">
                        <div>📤 {{ $loan->checkout_date->format('d/m/Y') }}</div>
                        <div style="color: {{ $loan->due_date->isPast() && $loan->status === 'active' ? 'var(--error-color)' : 'inherit' }}">
                            ⏰ {{ $loan->due_date->format('d/m/Y') }}
                        </div>
                    </td>

                    {{-- Estado --}}
                    <td style="padding: 0.75rem 1rem;">
                        @if($loan->status === 'active')
                            @if($loan->due_date->isPast())
                                <span style="background:#FDE8E8;color:#9B1C1C;padding:0.25rem 0.6rem;border-radius:999px;font-size:0.8rem;font-weight:600;">Vencido</span>
                            @else
                                <span style="background:#E1EFFE;color:#1E429F;padding:0.25rem 0.6rem;border-radius:999px;font-size:0.8rem;font-weight:600;">Activo</span>
                            @endif
                        @else
                            <span style="background:#DEF7EC;color:#03543F;padding:0.25rem 0.6rem;border-radius:999px;font-size:0.8rem;font-weight:600;">
                                Devuelto ({{ $loan->return_date->format('d/m') }})
                            </span>
                        @endif
                    </td>

                    {{-- Acción --}}
                    <td style="padding: 0.75rem 1rem;">
                        @if($loan->status === 'active')
                            <form action="{{ route('loans.return', $loan) }}" method="POST" style="margin: 0;">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn-primary"
                                        style="padding:0.4rem 0.75rem;font-size:0.78rem;width:auto;background-color:var(--success-color);"
                                        onclick="return confirm('¿Registrar la devolución de este libro?')">
                                    ✔ Devuelto
                                </button>
                            </form>
                        @else
                            <span style="color:var(--text-muted);font-size:0.875rem;">Finalizado</span>
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
