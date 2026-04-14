@extends('layouts.app')

@section('title', 'Añadir Libro - Biblioteca')

@section('content')
<div class="dashboard-header" style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca Admin</h2>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('books.index') }}" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Volver al Catálogo</a>
    </div>
</div>

<div class="auth-container" style="align-items: flex-start; padding-top: 3rem;">
    <div class="auth-card" style="max-width: 600px;">
        <div class="auth-header">
            <h1>Añadir Nuevo Libro</h1>
            <p>Ingresa los detalles del ejemplar para el catálogo</p>
        </div>

        <form method="POST" action="{{ route('books.store') }}">
            @csrf

            <div class="form-group">
                <label for="title" class="form-label">Título del Libro</label>
                <input id="title" type="text" class="form-control" name="title" value="{{ old('title') }}" required autofocus>
                @error('title')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="author" class="form-label">Autor</label>
                <input id="author" type="text" class="form-control" name="author" value="{{ old('author') }}" required>
                @error('author')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="editorial" class="form-label">Editorial (Opcional)</label>
                <input id="editorial" type="text" class="form-control" name="editorial" value="{{ old('editorial') }}">
                @error('editorial')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="isbn" class="form-label">ISBN</label>
                <input id="isbn" type="text" class="form-control" name="isbn" value="{{ old('isbn') }}" required>
                @error('isbn')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div style="display: flex; gap: 1rem;">
                <div class="form-group" style="flex: 1;">
                    <label for="total_copies" class="form-label">Total Copias</label>
                    <input id="total_copies" type="number" min="1" class="form-control" name="total_copies" value="{{ old('total_copies', 1) }}" required>
                    @error('total_copies')<div class="error-message">{{ $message }}</div>@enderror
                </div>

                <div class="form-group" style="flex: 1;">
                    <label for="available_copies" class="form-label">Copias Disponibles</label>
                    <input id="available_copies" type="number" min="0" class="form-control" name="available_copies" value="{{ old('available_copies', 1) }}" required>
                    @error('available_copies')<div class="error-message">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn-primary">
                    Guardar Libro
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
