@extends('layouts.app')

@section('title', 'Catálogo de Libros - Biblioteca')

@section('content')
<nav class="navbar">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-book-bookmark" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        <h2 style="margin: 0; color: var(--primary-color);">Biblioteca <span style="color: var(--text-main); font-weight: 300;">Universitaria</span></h2>
    </div>
    <a href="{{ route('login') }}" class="btn-premium" style="color: var(--text-muted); font-size: 0.9rem; gap: 0.5rem;">
        <i class="fa-solid fa-lock" style="font-size: 0.8rem;"></i> Acceso Administrativo
    </a>
</nav>

<div class="container animate-fade">
    <div class="catalog-layout">
        <!-- Sidebar Categorías -->
        <aside class="category-sidebar">
            <h2 class="sidebar-title">Categorías</h2>
            <ul class="category-list">
                <li>
                    <a href="{{ route('catalog.index') }}" class="category-item {{ !request('category') ? 'active' : '' }}">
                        <i class="fa-solid fa-layer-group"></i> Todos los Libros
                    </a>
                </li>
                @foreach($categories as $category)
                <li>
                    <a href="{{ route('catalog.index', ['category' => $category->id]) }}" 
                       class="category-item {{ request('category') == $category->id ? 'active' : '' }}">
                        <i class="fa-solid fa-book-bookmark"></i>
                        <span class="category-code">{{ $category->code }}</span> {{ $category->name }}
                    </a>
                </li>
                @endforeach
            </ul>
        </aside>

        <!-- Main Content -->
        <main class="catalog-main">
            <header style="margin-bottom: 2rem; text-align: left;">
                <h1 style="margin-bottom: 0.5rem;">Catálogo de Libros</h1>
                <p style="color: var(--text-muted); max-width: 600px;">
                    Explora nuestra colección académica por categorías.
                </p>
            </header>

            @if(session('success') || session('error'))
                <div style="margin-bottom: 2rem; padding: 1rem 1.25rem; border-radius: var(--radius-md); text-align: center; display: flex; align-items: center; justify-content: center; gap: 0.75rem;
                            background: {{ session('success') ? 'var(--primary-light)' : '#fee2e2' }}; 
                            color: {{ session('success') ? 'var(--primary-dark)' : 'var(--error-color)' }};">
                    <i class="fa-solid {{ session('success') ? 'fa-circle-check' : 'fa-circle-exclamation' }}"></i>
                    {{ session('success') ?? session('error') }}
                </div>
            @endif

            <div class="book-grid">
                @forelse($books as $book)
                <div class="book-card">
                    <div class="book-cover">
                        <i class="fa-solid fa-book-open" style="color: var(--primary-color); opacity: 0.4; font-size: 5rem;"></i>
                        <span class="book-badge" style="background: {{ $book->available_copies > 0 ? 'var(--primary-light)' : '#fee2e2' }}; 
                                                       color: {{ $book->available_copies > 0 ? 'var(--primary-dark)' : 'var(--error-color)' }};">
                            {{ $book->available_copies > 0 ? $book->available_copies . ' Disp.' : 'Agotado' }}
                        </span>
                        @if($book->category)
                        <span class="category-badge">{{ $book->category->code }}</span>
                        @endif
                    </div>
                    <div class="book-info">
                        <h3 class="book-title">{{ $book->title }}</h3>
                        <p class="book-author"><i class="fa-solid fa-user-pen" style="font-size: 0.8rem; margin-right: 0.5rem;"></i>{{ $book->author }}</p>
                        
                        <div style="margin-top: auto; padding-top: 1.5rem; border-top: 1px solid var(--border-color); display: flex; align-items: center; justify-content: space-between;">
                            <span style="font-size: 0.85rem; color: var(--text-muted); display: flex; align-items: center; gap: 0.4rem;">
                                <i class="fa-solid fa-building-columns"></i> {{ $book->editorial ?? 'Editorial Gral.' }}
                            </span>
                            @if($book->available_copies > 0)
                                <a href="{{ route('catalog.request', $book) }}" class="btn-premium btn-primary" style="padding: 0.5rem 1rem; font-size: 0.85rem;">
                                    Solicitar
                                </a>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div style="grid-column: 1 / -1; text-align: center; padding: 4rem; background: white; border-radius: var(--radius-lg); border: 2px dashed var(--border-color); color: var(--text-muted);">
                    <i class="fa-solid fa-box-open" style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.3;"></i>
                    <p>No se encontraron libros en esta categoría.</p>
                </div>
                @endforelse
            </div>
        </main>
    </div>
</div>


@endsection
