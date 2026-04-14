@extends('layouts.app')

@section('title', 'Gestión de Usuarios - Biblioteca')

@section('content')
<div class="dashboard-header" style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca Admin</h2>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('dashboard') }}" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Volver al Inicio</a>
    </div>
</div>

<div style="max-width: 1200px; margin: 2rem auto; padding: 0 1rem; animation: fadeIn 0.4s ease-out;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <h1 style="color: var(--text-main);">Gestión de Usuarios</h1>
        <a href="{{ route('users.create') }}" class="btn-primary" style="text-decoration: none; width: auto; display: inline-block;">+ Añadir Usuario</a>
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
                    <td style="padding: 1rem; display: flex; gap: 0.5rem;">
                        <a href="{{ route('users.edit', $user) }}" style="color: var(--primary-color); text-decoration: none; font-weight: 500;">Editar</a>
                        @if(auth()->id() !== $user->id)
                        <form action="{{ route('users.destroy', $user) }}" method="POST" onsubmit="return confirm('¿Seguro que deseas eliminar este usuario?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" style="color: var(--error-color); background: none; border: none; font-weight: 500; cursor: pointer;">Eliminar</button>
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
