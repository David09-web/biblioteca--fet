@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Biblioteca')

@section('content')
<nav class="navbar">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <i class="fa-solid fa-users-gear" style="font-size: 1.5rem; color: var(--primary-color);"></i>
        <h2 style="margin: 0; color: var(--primary-color);">Gestión <span style="color: var(--text-main); font-weight: 300;">de Usuarios</span></h2>
    </div>
    <a href="{{ route('dashboard') }}" class="btn-premium" style="background: var(--bg-main); border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1rem; font-size: 0.85rem; gap: 0.5rem; box-shadow: var(--shadow-sm);">
        <i class="fa-solid fa-house"></i> Volver al Inicio
    </a>
</nav>

<div class="container animate-fade">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="margin: 0;">Usuarios del Sistema</h1>
        <a href="{{ route('users.create') }}" class="btn-premium btn-primary" style="gap: 0.5rem;">
            <i class="fa-solid fa-user-plus"></i> Añadir Usuario
        </a>
    </div>

    @if(session('success'))
        <div style="background: var(--success-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ session('success') }}
        </div>
    @endif
    @if($errors->any())
        <div style="background: var(--error-color); color: white; padding: 1rem; border-radius: 8px; margin-bottom: 1.5rem;">
            {{ $errors->first() }}
        </div>
    @endif

    <div class="dashboard-card" style="background: white; border-radius: var(--radius); padding: 0; box-shadow: var(--shadow); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse;">
            <thead>
                <tr style="background: #F3F4F6; border-bottom: 1px solid var(--border-color); text-align: left;">
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Nombre</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Correo</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Rol</th>
                    <th style="padding: 1rem; color: var(--text-muted); font-size: 0.875rem;">Acciones</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr style="border-bottom: 1px solid var(--border-color);">
                    <td style="padding: 1rem; font-weight: 500; color: var(--text-main);">
                        {{ $user->name }}
                        @if(auth()->id() === $user->id) <span style="font-size: 0.75rem; background: #E5E7EB; padding: 0.15rem 0.4rem; border-radius: 4px; margin-left: 0.5rem;">Tú</span> @endif
                    </td>
                    <td style="padding: 1rem; color: var(--text-muted);">{{ $user->email }}</td>
                    <td style="padding: 1rem;">
                        @if($user->role === 'admin')
                            <span style="background: #E0E7FF; color: #3730A3; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.875rem; font-weight: 500;">Bibliotecario</span>
                        @elseif($user->role === 'student')
                            <span style="background: #DEF7EC; color: #03543F; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.875rem; font-weight: 500;">Estudiante</span>
                        @else
                            <span style="background: #FEF3C7; color: #92400E; padding: 0.25rem 0.5rem; border-radius: 999px; font-size: 0.875rem; font-weight: 500;">Docente</span>
                        @endif
                    </td>
                    <td style="padding: 1rem; display: flex; gap: 0.75rem;">
                        <a href="{{ route('users.edit', $user) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 600; display: flex; align-items: center; gap: 0.3rem;">
                            <i class="fa-solid fa-pen-to-square"></i> Editar
                        </a>
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');" style="margin: 0;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: var(--error-color); background: none; border: none; font-weight: 600; cursor: pointer; display: flex; align-items: center; gap: 0.3rem;">
                                <i class="fa-solid fa-trash-can"></i> Eliminar
                            </button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection
