@extends('admin.layout')
@section('title', 'Upload Foto')
@section('page_title', 'Upload Foto Baru')

@section('content')
<div class="admin-card" style="max-width:600px">
    <form action="{{ route('admin.images.store') }}" method="POST" enctype="multipart/form-data" style="padding:24px">
        @csrf
        <div class="form-group">
            <label for="section_key">Section Website *</label>
            <select id="section_key" name="section_key" required class="admin-input">
                <option value="">Pilih section...</option>
                @foreach($sections as $key => $label)
                <option value="{{ $key }}" {{ old('section_key') == $key ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
            @error('section_key') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="title">Judul / Nama Foto *</label>
            <input type="text" id="title" name="title" value="{{ old('title') }}" required placeholder="Contoh: Hero Coffee Shop" class="admin-input">
            @error('title') <span class="form-error">{{ $message }}</span> @enderror
        </div>

        <div class="form-group">
            <label for="image">Pilih Gambar * <small style="color:var(--text-muted)">(JPG, PNG, WebP, max 5MB)</small></label>
            <input type="file" id="image" name="image" required accept="image/jpeg,image/png,image/webp" class="admin-input" onchange="previewImage(event)">
            @error('image') <span class="form-error">{{ $message }}</span> @enderror
            <div id="imagePreview" style="margin-top:12px;display:none">
                <img id="previewImg" style="max-width:100%;max-height:300px;border-radius:8px;border:1px solid rgba(200,149,108,.2)">
            </div>
        </div>

        <div class="form-group">
            <label class="checkbox-label" style="padding-top:0">
                <input type="checkbox" name="is_active" value="1" checked>
                <span>Langsung aktifkan (foto sebelumnya di section ini akan dinonaktifkan)</span>
            </label>
        </div>

        <div class="form-actions">
            <button type="submit" class="btn btn-primary">📤 Upload Foto</button>
            <a href="{{ route('admin.images.index') }}" class="btn btn-outline-admin">Batal</a>
        </div>
    </form>
</div>

<script>
function previewImage(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    }
}
</script>
@endsection
