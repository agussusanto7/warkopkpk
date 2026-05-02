@extends('admin.layout')
@section('title', 'Tambah Momen Gallery')
@section('page_title', '➕ Tambah Momen Baru')

@section('content')
<div class="admin-card">
    <div class="card-header">
        <h3>Tambah Momen Baru</h3>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm" style="background:#6b7280;">← Kembali</a>
    </div>

    <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" style="padding:30px;">
        @csrf

        <div style="display:grid;grid-template-columns:1fr 1fr;gap:24px;">

            {{-- Title --}}
            <div style="grid-column:1/-1;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Judul Momen *</label>
                <input type="text" name="title" value="{{ old('title') }}" required maxlength="200"
                       placeholder="Contoh: Bukber Spesial Ramadan 2026"
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;transition:border-color 0.3s;"
                       onfocus="this.style.borderColor='#c49a6c'"
                       onblur="this.style.borderColor='#e5e7eb'">
                @error('title')
                    <span style="color:#ef4444;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Category --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Kategori *</label>
                <select name="category_id" required
                        style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;background:white;">
                    <option value="">-- Pilih Kategori --</option>
                    @foreach($categories as $cat)
                        <option value="{{ $cat->id }}" {{ old('category_id') == $cat->id ? 'selected' : '' }}>
                            {{ $cat->icon }} {{ $cat->name }}
                        </option>
                    @endforeach
                </select>
                @error('category_id')
                    <span style="color:#ef4444;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Event Date --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Tanggal Momen *</label>
                <input type="date" name="event_date" value="{{ old('event_date', date('Y-m-d')) }}" required
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;">
                @error('event_date')
                    <span style="color:#ef4444;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Description --}}
            <div style="grid-column:1/-1;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Deskripsi</label>
                <textarea name="description" rows="4" maxlength="1000"
                          placeholder="Ceritakan momen seru ini... (opsional)"
                          style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;resize:vertical;font-family:inherit;">{{ old('description') }}</textarea>
                <div style="font-size:0.8rem;color:#6b7280;margin-top:4px;text-align:right;"><span id="descCount">0</span>/1000 karakter</div>
                @error('description')
                    <span style="color:#ef4444;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Cover Image --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Foto Cover</label>
                <div id="coverPreview" onclick="document.getElementById('coverInput').click()"
                     style="border:3px dashed #e5e7eb;border-radius:16px;padding:40px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafafa;">
                    <div id="coverPlaceholder">
                        <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">📷</div>
                        <p style="color:#6b7280;font-size:0.9rem;">Klik untuk upload cover<br><small style="color:#9ca3af;">JPG/PNG, Max 5MB</small></p>
                    </div>
                    <img id="coverImg" src="" style="max-height:200px;border-radius:12px;display:none;">
                </div>
                <input type="file" id="coverInput" name="cover_image" accept="image/*" style="display:none;"
                       onchange="previewCover(this)">
                @error('cover_image')
                    <span style="color:#ef4444;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

            {{-- Photos --}}
            <div>
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Gallery Foto (Multiple)</label>
                <div id="photoDropZone"
                     style="border:3px dashed #e5e7eb;border-radius:16px;padding:40px;text-align:center;cursor:pointer;transition:all 0.3s;background:#fafafa;"
                     onclick="document.getElementById('photoInput').click()">
                    <div id="photoPlaceholder">
                        <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">📸</div>
                        <p style="color:#6b7288;font-size:0.9rem;">Klik atau drag & drop untuk upload foto<br><small style="color:#9ca3af;">Unlimited foto — JPG/PNG/WebP</small></p>
                    </div>
                    <div id="photoPreviewGrid" style="display:none;gap:10px;flex-wrap:wrap;margin-top:15px;"></div>
                </div>
                <input type="file" id="photoInput" name="photos[]" accept="image/*" multiple style="display:none;"
                       onchange="previewPhotos(this)">
                @error('photos')
                    <span style="color:#ef4444;font-size:0.85rem;margin-top:4px;display:block;">{{ $message }}</span>
                @enderror
            </div>

        </div>

        {{-- Published Toggle --}}
        <div style="margin-top:30px;padding-top:24px;border-top:2px solid #f3f4f6;display:flex;align-items:center;gap:16px;">
            <label style="display:flex;align-items:center;gap:12px;cursor:pointer;">
                <input type="checkbox" name="is_published" value="1" {{ old('is_published', true) ? 'checked' : '' }}
                       style="width:22px;height:22px;cursor:pointer;">
                <div>
                    <span style="font-weight:600;color:#374151;">Publikasi Sekarang</span>
                    <div style="font-size:0.85rem;color:#6b7280;margin-top:2px;">Centang untuk langsung tampil di website</div>
                </div>
            </label>
        </div>

        {{-- Submit Buttons --}}
        <div style="margin-top:30px;display:flex;justify-content:flex-end;gap:12px;">
            <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm" style="background:#e5e7eb;color:#374151;padding:14px 28px;border-radius:12px;font-weight:600;">Batal</a>
            <button type="submit" class="btn btn-sm" style="background:linear-gradient(135deg,#c49a6c,#a67c52);color:white;padding:14px 32px;border-radius:12px;font-weight:600;border:none;cursor:pointer;font-size:1rem;">
                💾 Simpan Momen
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

        Array.from(input.files).forEach((file, index) => {
            const reader = new FileReader();
            reader.onload = function(e) {
                const div = document.createElement('div');
                div.style.cssText = 'position:relative;width:80px;height:80px;';
                div.innerHTML = `
                    <img src="${e.target.result}" style="width:100%;height:100%;object-fit:cover;border-radius:10px;">
                    <span style="position:absolute;top:-8px;right:-8px;background:#ef4444;color:white;width:22px;height:22px;border-radius:50%;display:flex;align-items:center;justify-content:center;font-size:12px;cursor:pointer;" onclick="this.parentElement.remove()">✕</span>
                `;
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
</script>
@endsection