@extends('layouts.app')

@section('title', 'Ingreso - Biblioteca')

@section('content')
<div class="auth-container">
    <div class="auth-card">
        <div class="auth-header">
            <h1>📚 Biblioteca</h1>
            <p>Ingresa tus credenciales para continuar</p>
        </div>

        <form method="POST" action="{{ route('login') }}">
            @csrf

            <div class="form-group">
                <label for="email" class="form-label">Correo Electrónico</label>
                <input id="email" type="email" class="form-control" name="email" value="{{ old('email') }}" required autofocus placeholder="tu@correo.edu">
                @error('email')
                    <div class="error-message">{{ $message }}</div>
                @enderror
            </div>

            <div class="form-group">
                <label for="password" class="form-label">Contraseña</label>
                <input id="password" type="password" class="form-control" name="password" required placeholder="••••••••">
            </div>

            <div class="form-group mt-4">
                <button type="submit" class="btn-primary">
                    Iniciar Sesión
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
