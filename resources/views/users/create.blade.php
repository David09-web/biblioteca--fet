@extends('layouts.app')

@section('title', 'Añadir Usuario - Biblioteca')

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
            <h1>Crear Nuevo Usuario</h1>
            <p>Añade cuentas para estudiantes, docentes o bibliotecarios</p>
        </div>

        <form method="POST" action="{{ route('users.store') }}">
            @csrf

            <div class="form-group">
                <label for="name" class="form-label">Nombre Completo</label>
                <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>
                @error('name')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required>
                @error('email')<div class="error-message">{{ $message }}</div>@enderror
            </div>
            
            <div class="form-group">
                <label for="role" class="form-label">Rol del Sistema</label>
                <select id="role" name="role" class="form-control" required style="background-color: #F9FAFB; appearance: auto;">
                    <option value="student" {{ old('role') == 'student' ? 'selected' : '' }}>Estudiante</option>
                    <option value="teacher" {{ old('role') == 'teacher' ? 'selected' : '' }}>Docente</option>
                    <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Bibliotecario (Admin)</option>
                </select>
                @error('role')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required>
                @error('password')<div class="error-message">{{ $message }}</div>@enderror
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn-primary">Registrar Usuario</button>
            </div>
        </form>
    </div>
</div>
@endsection
