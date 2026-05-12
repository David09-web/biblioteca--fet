@extends('layouts.app')

@section('title', 'Gestión de Libros - Biblioteca')

@section('content')
<nav class="navbar">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-book-bookmark" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        <h2 style="margin: 0; color: var(--primary-color);">Biblioteca <span style="color: var(--text-main); font-weight: 300;">Admin</span></h2>
    </div>
    <a href="{{ route('dashboard') }}" class="btn-premium" style="background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1rem; font-size: 0.85rem; gap: 0.5rem;">
        <i class="fa-solid fa-arrow-left"></i> Volver al Inicio
    </a>
</nav>

<div class="container animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Catálogo de Libros</h1>
        <a href="{{ route('books.create') }}" class="btn-premium btn-primary" style="gap: 0.5rem;">
            <i class="fa-solid fa-plus-circle"></i> Añadir Libro
        </a>
    </div>

    @if(session('success'))
        <div style="background: var(--success-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif

    <div class="dashboard-card" style="background: white; border-radius: var(--radius); padding: 0; box-shadow: var(--shadow); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F3F4F6; border-bottom: 1px solid var(--border-color); text-align: left;">
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Título</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Autor</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">ISBN</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Copias (Disp/Total)</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @forelse($books as $book)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem; font-weight: 500; color: var(--text-main);">{{ $book->title }}</td>
                    <td style="padding: 1rem; color: var(--text-muted);">{{ $book->author }}</td>
                    <td style="padding: 1rem; color: var(--text-muted); font-family: monospace;">{{ $book->isbn }}</td>
                    <td style="padding: 1rem;">
                        <span style="background: {{ $book->available_copies > 0 ? '#DEF7EC' : '#FDE8E8' }}; color: {{ $book->available_copies > 0 ? '#03543F' : '#9B1C1C' }}; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.875rem; font-weight: 500;">
                            {{ $book->available_copies }} / {{ $book->total_copies }}
                        </span>
                    </td>
                    <td style="padding: 1rem; display: flex; gap: 0.75rem;">
                        <a href="{{ route('books.edit', $book) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.3rem;">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </a>
                        <form action="{{ route('books.destroy', $book) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este libro?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: var(--error-color); background: none; border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                <i class="fa-solid fa-trash-can"></i> Eliminar
                            </button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" style="padding: 2rem; text-align: center; color: var(--text-muted);">No hay libros registrados en el catálogo.</td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
