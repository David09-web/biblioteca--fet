@extends('layouts.app')

@section('title', 'Editar Usuario - Biblioteca')

@section('content')
<div class="dashboard-header" style="background: white; padding: 1rem 2rem; box-shadow: 0 1px 3px rgba(0,0,0,0.1); display: flex; justify-content: space-between; align-items: center;">
    <h2 style="color: var(--primary-color); font-weight: 700; margin: 0;">📚 Biblioteca Admin</h2>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <a href="{{ route('users.index') }}" style="color: var(--text-main); text-decoration: none; font-weight: 500;">Volver a Usuarios</a>
    </div>
</div>

<div class="auth-container" style="align-items: flex-start; padding-top: 3rem;">
    <div class="auth-card" style="max-width: 500px;">
        <div class="auth-header">
            <h1>Editar Usuario</h1>
            <p>Modifica los datos y nivel de acceso</p>
        </div>

        <form method="POST" action="{{ route('users.update', $user) }}">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="name" class="form-label">Nombre Completo</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name', $user->name) }}" required autofocus>
                @error('name')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email', $user->email) }}" required>
                @error('email')<div class="error-message">{{ $message }}</div>@enderror
            </div>
            
            <div class="form-group">
                <label for="role" class="form-label">Rol del Sistema</label>
                <select id="role" name="role" class="form-control" required style="background-color: #F9FAFB; appearance: auto;" {{ auth()->id() === $user->id ? 'disabled' : '' }}>
                    <option value="student" {{ old('role', $user->role) == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="teacher" {{ old('role', $user->role) == 'teacher' ? 'selected' : '' }}>Docente</option>
                    <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Bibliotecario (Admin)</option>
                </select>
                @if(auth()->id() === $user->id)
                    <input type="hidden" name="role" value="{{ $user->role }}">
                    <small style="color: var(--text-muted); display: block; margin-top: 0.25rem;">No puedes modificar tu propio rol.</small>
                @endif
                @error('role')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña (opcional)</label>
                <input id="password" type="password" class="form-control" name="password" placeholder="Déjalo en blanco para mantener la actual">
                @error('password')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn-primary">Actualizar Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection
