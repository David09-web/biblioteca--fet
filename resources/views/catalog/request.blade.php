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
    <div style="width: 100%; max-width: 560px; display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
        <a href="{{ route('catalog.index') }}" style="color: var(--text-muted); text-decoration: none; font-size: 0.9rem; display: flex; align-items: center; gap: 0.35rem;">
            ← Volver al catálogo
        </a>
        <span style="font-size: 0.8rem; color: var(--text-muted);">Biblioteca Universitaria</span>
    </div>

    <div class="form-card">
        {{-- Título --}}
        <div style="text-align: center; margin-bottom: 2rem;">
            <div style="width: 56px; height: 56px; background: linear-gradient(135deg, #6366F1, #8B5CF6); border-radius: 16px; display: flex; align-items: center; justify-content: center; font-size: 1.6rem; margin: 0 auto 0.75rem;">📋</div>
            <h1 style="font-size: 1.4rem; font-weight: 700; color: var(--text-main); margin: 0 0 0.3rem;">Solicitar Préstamo</h1>
            <p style="color: var(--text-muted); font-size: 0.9rem; margin: 0;">Completa tus datos para reservar el libro</p>
        </div>

        {{-- Libro seleccionado --}}
        <div class="book-pill">
            📚 {{ $book->title }} — {{ $book->author }}
        </div>

        {{-- Errores --}}
        @if($errors->any())
            <div style="background: #FEF2F2; border: 1px solid #FECACA; border-radius: 10px; padding: 0.9rem 1rem; margin-bottom: 1.25rem;">
                <ul style="margin: 0; padding-left: 1.2rem; color: #DC2626; font-size: 0.875rem;">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('catalog.store', $book) }}" method="POST" enctype="multipart/form-data">
            @csrf

            {{-- Nombre --}}
            <div class="form-group">
                <label class="form-label" for="student_name">👤 Nombre completo</label>
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
                <label class="form-label" for="id_number">🪪 Número de identificación</label>
                <input type="text" id="id_number" name="id_number"
                       class="form-input" value="{{ old('id_number') }}"
                       placeholder="Ej: 2024-00123"
                       required>
                @error('id_number')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Teléfono --}}
            <div class="form-group">
                <label class="form-label" for="phone">📲 Número de teléfono <span style="color:var(--text-muted);font-weight:400;">(para reporte de devolución)</span></label>
                <input type="tel" id="phone" name="phone"
                       class="form-input" value="{{ old('phone') }}"
                       placeholder="Ej: +504 9999-9999"
                       required>
                @error('phone')<p class="error-msg">{{ $message }}</p>@enderror
            </div>

            {{-- Foto de carnet --}}
            <div class="form-group">
                <label class="form-label">📷 Foto del carnet estudiantil</label>
                <div class="upload-zone" id="uploadZone">
                    <input type="file" id="carnet_photo" name="carnet_photo"
                           accept="image/jpg,image/jpeg,image/png,image/webp"
                           onchange="previewCarnet(this)" required>
                    <div id="uploadPrompt">
                        <div style="font-size: 2rem; margin-bottom: 0.4rem;">🪪</div>
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
            <div style="background: #FFFBEB; border: 1px solid #FDE68A; border-radius: 10px; padding: 0.75rem 1rem; margin-bottom: 1.5rem; font-size: 0.85rem; color: #92400E;">
                ⏳ El préstamo tiene una duración de <strong>7 minutos</strong>. Acércate a la biblioteca para retirar el libro.
            </div>

            <button type="submit" class="btn-primary" style="width: 100%; padding: 0.85rem; font-size: 1rem; letter-spacing: 0.01em;">
                ✅ Confirmar Solicitud
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
