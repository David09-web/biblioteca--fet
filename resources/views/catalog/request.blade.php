@extends('layouts.app')

@section('title', 'Solicitar Préstamo - Biblioteca')

@section('content')
<style>
    .form-card {
        background: white;
        border-radius: 16px;
        padding: 2.5rem;
        box-shadow: 0 4px 24px rgba(0,0,0,0.08);
        max-width: 560px;
        width: 100%;
        animation: fadeIn 0.4s ease-out;
    }
    .form-group { margin-bottom: 1.25rem; }
    .form-label {
        display: block;
        font-size: 0.875rem;
        font-weight: 600;
        color: var(--text-main);
        margin-bottom: 0.4rem;
    }
    .form-input {
        width: 100%;
        padding: 0.65rem 0.9rem;
        border: 1.5px solid #E5E7EB;
        border-radius: 10px;
        font-size: 0.95rem;
        color: var(--text-main);
        transition: border-color 0.2s, box-shadow 0.2s;
        box-sizing: border-box;
        background: #FAFAFA;
        font-family: inherit;
    }
    .form-input:focus {
        outline: none;
        border-color: var(--primary-color);
        box-shadow: 0 0 0 3px rgba(99,102,241,0.12);
        background: white;
    }
    .input-icon-wrap { position: relative; }
    .input-icon {
        position: absolute;
        left: 0.75rem;
        top: 50%;
        transform: translateY(-50%);
        font-size: 1rem;
        pointer-events: none;
    }
    .input-icon + .form-input { padding-left: 2.25rem; }

    /* Upload zone */
    .upload-zone {
        border: 2px dashed #C7D2FE;
        border-radius: 12px;
        padding: 1.5rem;
        text-align: center;
        cursor: pointer;
        transition: border-color 0.2s, background 0.2s;
        background: #F5F7FF;
        position: relative;
    }
    .upload-zone:hover { border-color: var(--primary-color); background: #EEF2FF; }
    .upload-zone input[type="file"] {
        position: absolute;
        inset: 0;
        opacity: 0;
        cursor: pointer;
        width: 100%;
        height: 100%;
    }
    .upload-preview {
        display: none;
        margin-top: 0.75rem;
        border-radius: 10px;
        overflow: hidden;
        max-height: 180px;
        border: 1.5px solid #E5E7EB;
    }
    .upload-preview img { width: 100%; object-fit: cover; max-height: 180px; display: block; }
    .book-pill {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        background: #EEF2FF;
        color: var(--primary-color);
        padding: 0.4rem 0.9rem;
        border-radius: 999px;
        font-size: 0.875rem;
        font-weight: 600;
        margin-bottom: 1.75rem;
    }
    .error-msg { color: #DC2626; font-size: 0.8rem; margin-top: 0.3rem; }
</style>

<div style="min-height: 100vh; background: linear-gradient(135deg, #EEF2FF 0%, #F0FDF4 100%); display: flex; flex-direction: column; align-items: center; padding: 2.5rem 1rem;">

    {{-- Header --}}
    <div style="width: 100%; max-width: 560px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <a href="{{ route('catalog.index') }}" class="btn-premium" style="background: white; border: 1px solid var(--border-color); color: var(--text-main); padding: 0.5rem 1.25rem; font-size: 0.85rem; gap: 0.5rem; box-shadow: var(--shadow-sm); text-decoration: none;">
            <i class="fa-solid fa-chevron-left"></i> Volver al Catálogo
        </a>
        <div style="display: flex; align-items: center; gap: 0.5rem; color: var(--text-muted); font-size: 0.85rem; font-weight: 500;">
            <i class="fa-solid fa-graduation-cap"></i> Biblioteca Universitaria
        </div>
    </div>

    <div class="form-card">
        {{-- Título --}}
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #6366F1, #8B5CF6); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.4rem; color: white; margin: 0 auto 0.75rem;">
                <i class="fa-solid fa-clipboard-list"></i>
            </div>
            <h1 style="font-size: 1.4rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.3rem;">Solicitar Préstamo</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Completa tus datos para reservar el libro</p>
        </div>

        {{-- Libro seleccionado --}}
        <div class="book-pill">
            <i class="fa-solid fa-book-bookmark"></i> {{ $book->title }} — {{ $book->author }}
        </div>

        {{-- Errores --}}
        @if($errors->any())
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px; padding: 0.9rem 1rem; margin-bottom: 1.25rem;">
                <ul style="margin: 0; padding-left: 1.2rem; color: #DC2626; font-size: 0.875rem;">
                    @foreach($errors->all() as $error)
                        <li><i class="fa-solid fa-circle-xmark" style="margin-right: 0.4rem;"></i>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('catalog.store', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nombre --}}
            <div class="form-group">
                <label class="form-label" for="student_name" style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-user" style="color: var(--primary-color);"></i> Nombre completo
                </label>
                <div class="input-icon-wrap">
                    <input type="text" id="student_name" name="student_name"
                           class="form-input" value="{{ old('student_name') }}"
                           placeholder="Ej: María García López"
                           required>
                </div>
                @error('student_name')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Número de identificación --}}
            <div class="form-group">
                <label class="form-label" for="id_number" style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-id-card" style="color: var(--primary-color);"></i> Número de identificación
                </label>
                <input type="text" id="id_number" name="id_number"
                       class="form-input" value="{{ old('id_number') }}"
                       placeholder="Ej: 2024-00123"
                       required>
                @error('id_number')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Teléfono --}}
            <div class="form-group">
                <label class="form-label" for="phone" style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-mobile-screen-button" style="color: var(--primary-color);"></i> Número de teléfono
                </label>
                <input type="tel" id="phone" name="phone"
                       class="form-input" value="{{ old('phone') }}"
                       placeholder="Ej: +504 9999-9999"
                       required>
                @error('phone')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Foto de carnet --}}
            <div class="form-group">
                <label class="form-label" style="display: flex; align-items: center; gap: 0.5rem;">
                    <i class="fa-solid fa-camera" style="color: var(--primary-color);"></i> Foto del carnet estudiantil
                </label>
                <div class="upload-zone" id="uploadZone">
                    <input type="file" id="carnet_photo" name="carnet_photo"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           onchange="previewCarnet(this)" required>
                    <div id="uploadPrompt">
                        <div style="font-size: 1.5rem; color: #6366f1; margin-bottom: 0.6rem;">
                            <i class="fa-solid fa-cloud-arrow-up"></i>
                        </div>
                        <p style="font-weight: 600; color: var(--primary-color); margin: 0 0 0.2rem;">Haz clic o arrastra tu foto aquí</p>
                        <p style="color: var(--text-muted); font-size: 0.8rem; margin: 0;">JPG, PNG o WEBP · Máx. 4 MB</p>
                    </div>
                </div>
                <div class="upload-preview" id="previewBox">
                    <img id="previewImg" src="" alt="Vista previa del carnet">
                </div>
                @error('carnet_photo')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Aviso --}}
            <div style="background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: #92400E; display: flex; align-items: center; gap: 0.75rem;">
                <i class="fa-solid fa-hourglass-half"></i>
                <span>El préstamo tiene una duración de <strong>7 minutos</strong>. Acércate a la biblioteca para retirar el libro.</span>
            </div>

            <button type="submit" class="btn-premium btn-primary" style="width: 100%; padding: 1rem; font-size: 1rem; letter-spacing: 0.01em; gap: 0.5rem; border: none;">
                <i class="fa-solid fa-circle-check"></i> Confirmar Solicitud
            </button>
        </form>
    </div>
</div>

<script>
function previewCarnet(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = e => {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('previewBox').style.display = 'block';
            document.getElementById('uploadPrompt').innerHTML =
                '<p style="color:var(--primary-color);font-weight:600;margin:0;">✔ Imagen cargada correctamente</p><p style="color:var(--text-muted);font-size:0.8rem;margin:0.2rem 0 0;">' + input.files[0].name + '</p>';
        };
        reader.readAsDataURL(input.files[0]);
    }
}
</script>
@endsection
