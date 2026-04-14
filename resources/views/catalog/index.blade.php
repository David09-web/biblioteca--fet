@extends('layouts.app')

@section('title', 'Catálogo de Libros - Biblioteca')

@section('content')
<div style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca Universitaria</h2>
    <a href="{{ route('login') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.875rem;">🔐 Acceso Admin</a>
</div>

<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem; animation: fadeIn 0.4s ease-out;">
    <div style="margin-bottom: 2rem;">
        <h1 style="color: var(--text-main); margin: 0;">Catálogo de Libros</h1>
        <p style="color: var(--text-muted); margin: 0.25rem 0 0;">Selecciona un libro y completa el formulario para solicitar tu préstamo.</p>
    </div>

    @if(session('success'))
        <div style="background: var(--success-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div style="background: var(--error-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('error') }}
        </div>
    @endif

    <div class="dashboard-card" style="background: white; border-radius: var(--radius); padding: 0; box-shadow: var(--shadow); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F3F4F6; border-bottom: 1px solid var(--border-color); text-align: left;">
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Título</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Autor</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Editorial</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Disponibilidad</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Acción</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr style="border-bottom: 1px solid var(--border-color); transition: background 0.15s;"
                    onmouseover="this.style.background='#F9FAFB'" onmouseout="this.style.background=''">
                    <td style="padding: 1rem; font-weight: 600; color: var(--text-main);">{{ $book->title }}</td>
                    <td style="padding: 1rem; color: var(--text-muted);">{{ $book->author }}</td>
                    <td style="padding: 1rem; color: var(--text-muted);">{{ $book->editorial ?? '—' }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $book->available_copies > 0 ? '#DEF7EC' : '#FDE8E8' }};
                                     color: {{ $book->available_copies > 0 ? '#03543F' : '#9B1C1C' }};
                                     padding: 0.25rem 0.65rem; border-radius: 999px; font-size: 0.8rem; font-weight: 600;">
                            {{ $book->available_copies > 0 ? $book->available_copies . ' disponible(s)' : 'Agotado' }}
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        @if($book->available_copies > 0)
                            <a href="{{ route('catalog.request', $book) }}"
                               class="btn-primary"
                               style="padding: 0.5rem 1rem; font-size: 0.875rem; width: auto; display: inline-block; text-decoration: none;">
                                Solicitar
                            </a>
                        @else
                            <button disabled style="background: #D1D5DB; color: #6B7280; border: none; padding: 0.5rem 1rem; border-radius: 8px; cursor: not-allowed; font-size: 0.875rem;">No disponible</button>
                        @endif
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: var(--text-muted);">No hay libros en el catálogo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
