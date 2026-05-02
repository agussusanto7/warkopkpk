@extends('admin.layout')
@section('title', 'Edit Momen Gallery')
@section('page_title', '✏️ Edit Momen')

@section('content')

{{-- Standalone Delete Photo Form (harus di luar form utama) --}}
<form id="deletePhotoForm" method="POST" action="" style="display:none;">
    @csrf
    @method('DELETE')
    <input type="hidden" name="photo_path" id="deletePhotoPath">
</form>

<div class="admin-card">
    <div class="card-header">
        <h3>Edit Momen: {{ $gallery->title }}</h3>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm" style="background:#6b7280;">← Kembali</a>
    </div>

    <form action="{{ route('admin.gallery.update', $gallery) }}" method="POST" enctype="multipart/form-data" style="padding:30px;" id="editForm">
        @csrf
        @method('PUT')

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

            {{-- Title --}}
            <div style="grid-column:1/-1;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Judul Momen *</label>
                <input type="text" name="title" value="{{ old('title', $gallery->title) }}" required maxlength="200"
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;"
                       onfocus="this.style.borderColor='#c49a6c'"
                       onblur="this.style.borderColor='#e5e7eb'">
            </div>

            {{-- Category --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Kategori *</label>
                <select name="category_id" required
                        style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;background:white;">
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id', $gallery->category_id) == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            {{-- Event Date --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Tanggal Momen *</label>
                <input type="date" name="event_date" value="{{ old('event_date', $gallery->event_date->format('Y-m-d')) }}" required
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;">
            </div>

            {{-- Description --}}
            <div style="grid-column:1/-1;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Deskripsi</label>
                <textarea name="description" rows="4" maxlength="1000"
                          style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;resize:vertical;font-family:inherit;">{{ old('description', $gallery->description) }}</textarea>
                <div style="font-size:0.8rem;color:#6b7280;margin-top:4px;text-align:right;">
                    <span id="descCount">{{ strlen($gallery->description ?? '') }}</span>/1000 karakter
                </div>
            </div>

            {{-- Cover Image --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Foto Cover</label>
                <div id="coverPreview"
                     style="border:3px dashed #e5e7eb;border-radius:16px;padding:20px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafafa;"
                     onclick="document.getElementById('coverInput').click()">
                    @if($gallery->cover_image_url)
                        <img src="{{ $gallery->cover_image_url }}" id="coverImg"
                             style="max-height:200px;border-radius:12px;">
                        <div id="coverPlaceholder" style="display:none;">
                            <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">📷</div>
                            <p style="color:#6b7280;font-size:0.9rem;">Klik untuk ganti cover</p>
                        </div>
                    @else
                        <img src="" id="coverImg" style="max-height:200px;border-radius:12px;display:none;">
                        <div id="coverPlaceholder">
                            <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">📷</div>
                            <p style="color:#6b7280;font-size:0.9rem;">Klik untuk upload cover</p>
                        </div>
                    @endif
                </div>
                <input type="file" id="coverInput" name="cover_image" accept="image/*" style="display:none;"
                       onchange="previewCover(this)">
            </div>

            {{-- Photos --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">
                    Tambah Foto Baru — <small style="color:#6b7280;">{{ $gallery->photo_count }} foto saat ini</small>
                </label>
                <div id="photoDropZone"
                     style="border:3px dashed #e5e7eb;border-radius:16px;padding:40px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafafa;"
                     onclick="document.getElementById('photoInput').click()">
                    <div id="photoPlaceholder">
                        <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">📸</div>
                        <p style="color:#6b7288;font-size:0.9rem;">Klik atau drag & drop untuk tambah foto baru<br><small style="color:#9ca3af;">Foto lama akan <strong style="color:#059669;">TETAP tersimpan</strong></small></p>
                    </div>
                    <div id="photoPreviewGrid" style="display:none;gap:10px;flex-wrap:wrap;margin-top:15px;"></div>
                </div>
                <input type="file" id="photoInput" name="photos[]" accept="image/*" multiple style="display:none;"
                       onchange="previewPhotos(this)">
                <div style="margin-top:12px;display:flex;align-items:center;gap:10px;">
                    <input type="checkbox" id="replacePhotos" name="replace_photos" value="1" style="width:18px;height:18px;cursor:pointer;">
                    <label for="replacePhotos" style="font-size:0.88rem;color:#6b7280;cursor:pointer;">
                        ☑️ <strong>Hapus semua foto lama & ganti dengan yang baru</strong>
                    </label>
                </div>
            </div>

            {{-- Existing Photos Preview --}}
            @if($gallery->photo_count > 0)
            <div style="grid-column:1/-1;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">
                    Foto Saat Ini ({{ $gallery->photo_count }}) — klik ✕ untuk hapus
                </label>
                <div style="display:flex;gap:10px;flex-wrap:wrap;" id="photoGrid">
                    @foreach($gallery->photos as $photo)
                        <div style="position:relative;display:inline-block;" class="photo-item">
                            <img src="{{ asset('storage/' . ltrim($photo, '/')) }}"
                                 style="width:100px;height:75px;object-fit:cover;border-radius:10px;border:2px solid #e5e7eb;"
                                 onerror="this.src='data:image/svg+xml,%3Csvg xmlns=%22http://www.w3.org/2000/svg%22 width=%22100%22 height=%2275%22%3E%3Crect fill=%22%23374151%22 width=%22100%22 height=%2275%22/%3E%3Ctext x=%2250%25%22 y=%2250%25%22 text-anchor=%22middle%22 dy=%22.3em%22 fill=%22%239ca3af%22%3E📷%3C/text%3E%3C/svg%3E'">
                            <button type="button" onclick="deletePhoto('{{ route('admin.gallery.removePhoto', $gallery) }}', '{{ addslashes($photo) }}')"
                                    style="position:absolute;top:-8px;right:-8px;background:#ef4444;color:white;border:none;width:24px;height:24px;border-radius:50%;cursor:pointer;font-size:12px;display:flex;align-items:center;justify-content:center;"
                                    title="Hapus foto">✕</button>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>

        {{-- Published Toggle --}}
        <div style="margin-top:30px;padding-top:24px;border-top:2px solid #f3f4f6;display:flex;align-items:center;gap:16px;">
            <label style="display:flex;align-items:center;gap:12px;cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', $gallery->is_published) ? 'checked' : '' }}
                       style="width:22px;height:22px;cursor:pointer;">
                <div>
                    <span style="font-weight:600;color:#374151;">Published</span>
                    <div style="font-size:0.85rem;color:#6b7280;margin-top:2px;">Centang untuk tampil di website</div>
                </div>
            </label>
        </div>

        {{-- Submit Buttons --}}
        <div style="margin-top:30px;display:flex;justify-content:flex-end;gap:12px;">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm" style="background:#e5e7eb;color:#374151;padding:14px 28px;border-radius:12px;font-weight:600;">Batal</a>
            <button type="submit" id="submitBtn" style="background:linear-gradient(135deg,#c49a6c,#a67c52);color:white;padding:14px 32px;border-radius:12px;font-weight:600;border:none;cursor:pointer;font-size:1rem;">
                💾 Simpan Perubahan
            </button>
        </div>
    </form>
</div>
@endsection

@section('extra_js')
<script>
// Cover Image Preview
function previewCover(input) {
    if (input.files && input.files[0]) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('coverImg').src = e.target.result;
            document.getElementById('coverImg').style.display = 'block';
            document.getElementById('coverPlaceholder').style.display = 'none';
        };
        reader.readAsDataURL(input.files[0]);
    }
}

// Multiple Photos Preview
function previewPhotos(input) {
    const grid = document.getElementById('photoPreviewGrid');
    const placeholder = document.getElementById('photoPlaceholder');
    if (input.files && input.files.length > 0) {
        placeholder.style.display = 'none';
        grid.style.display = 'flex';
        Array.from(input.files).forEach((file) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = 'position:relative;width:80px;height:80px;';
                div.innerHTML = '<img src="' + e.target.result + '" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">';
                grid.appendChild(div);
            };
            reader.readAsDataURL(file);
        });
    }
}

// Description Character Counter
document.querySelector('textarea[name="description"]').addEventListener('input', function() {
    document.getElementById('descCount').textContent = this.value.length;
});

// Delete photo via AJAX
function deletePhoto(actionUrl, photoPath) {
    if (!confirm('Hapus foto ini?')) return;

    const form = document.getElementById('deletePhotoForm');
    form.action = actionUrl;
    document.getElementById('deletePhotoPath').value = photoPath;
    form.submit();
}

// Submit button click tracking
document.getElementById('submitBtn').addEventListener('click', function() {
    this.innerHTML = '⏳ Menyimpan...';
    this.disabled = true;
    document.getElementById('editForm').submit();
});
</script>
@endsection