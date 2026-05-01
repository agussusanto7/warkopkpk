@php $item = $menuItem ?? null; @endphp

<div class="form-group">
    <label for="name">Nama Menu *</label>
    <input type="text" id="name" name="name" value="{{ old('name', $item?->name) }}" required placeholder="Contoh: Kopi Susu KPK" class="admin-input">
    @error('name') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="description">Deskripsi</label>
    <input type="text" id="description" name="description" value="{{ old('description', $item?->description) }}" placeholder="Deskripsi singkat menu" class="admin-input">
    @error('description') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="notes">Catatan</label>
    <input type="text" id="notes" name="notes" value="{{ old('notes', $item?->notes) }}" placeholder="Catatan tambahan (misal: Level manis, topping, dll)" class="admin-input">
    @error('notes') <span class="form-error">{{ $message }}</span> @enderror
</div>

<div class="form-group">
    <label for="image">Foto Menu <small style="color:var(--text-muted)">(JPG, PNG, WebP, max 2MB)</small></label>
    <input type="file" id="image" name="image" accept="image/jpeg,image/png,image/webp" class="admin-input" onchange="previewImage(event)">
    @error('image') <span class="form-error">{{ $message }}</span> @enderror
    @if($item?->image)
    <div style="margin-top:10px;display:flex;align-items:center;gap:12px">
        <img src="{{ asset('storage/' . $item->image) }}" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid rgba(200,149,108,.2)">
        <div>
            <span style="color:var(--text-muted);font-size:.85rem">Foto saat ini</span>
            <button type="button" onclick="confirmDeleteImage({{ $item->id }})" class="btn btn-danger btn-sm" style="display:block;margin-top:6px">
                🗑️ Hapus Foto
            </button>
        </div>
    </div>
    @endif
    <div id="imagePreview" style="margin-top:12px;display:none">
        <img id="previewImg" style="max-width:200px;max-height:150px;border-radius:8px;border:1px solid rgba(200,149,108,.2)">
    </div>
</div>

<div class="form-row-admin">
    <div class="form-group">
        <label for="price">Harga (Rp) *</label>
        <input type="number" id="price" name="price" value="{{ old('price', $item?->price) }}" required min="0" placeholder="15000" class="admin-input">
        @error('price') <span class="form-error">{{ $message }}</span> @enderror
    </div>
    <div class="form-group">
        <label for="category">Kategori *</label>
        <select id="category" name="category" required class="admin-input">
            <option value="">Pilih Kategori</option>
            <option value="kopi" {{ old('category', $item?->category) == 'kopi' ? 'selected' : '' }}>☕ Kopi</option>
            <option value="non-kopi" {{ old('category', $item?->category) == 'non-kopi' ? 'selected' : '' }}>🍵 Non-Kopi</option>
            <option value="makanan" {{ old('category', $item?->category) == 'makanan' ? 'selected' : '' }}>🍽️ Makanan</option>
            <option value="snack" {{ old('category', $item?->category) == 'snack' ? 'selected' : '' }}>🍟 Snack</option>
        </select>
        @error('category') <span class="form-error">{{ $message }}</span> @enderror
    </div>
</div>

<div class="form-row-admin">
    <div class="form-group">
        <label for="sort_order">Urutan</label>
        <input type="number" id="sort_order" name="sort_order" value="{{ old('sort_order', $item?->sort_order ?? 0) }}" min="0" class="admin-input">
    </div>
    <div class="form-group">
        <label class="checkbox-label">
            <input type="checkbox" name="is_available" value="1" {{ old('is_available', $item?->is_available ?? true) ? 'checked' : '' }}>
            <span>Menu Tersedia</span>
        </label>
    </div>
</div>

<div class="form-group">
    <label class="checkbox-label">
        <input type="checkbox" name="is_favorite" value="1" {{ old('is_favorite', $item?->is_favorite ?? false) ? 'checked' : '' }}>
        <span>⭐ Tampilkan di Home</span>
    </label>
    <small style="color:var(--text-muted);display:block;margin-top:4px">Menu favorit akan muncul di bagian "Yang Paling Digemari" di halaman utama</small>
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

function confirmDeleteImage(menuId) {
    if (confirm('Yakin ingin menghapus foto menu ini?')) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '/admin/menu/' + menuId + '/image';
        document.body.appendChild(form);

        // Create CSRF token input
        const csrfInput = document.createElement('input');
        csrfInput.type = 'hidden';
        csrfInput.name = '_token';
        csrfInput.value = '{{ csrf_token() }}';
        form.appendChild(csrfInput);

        // Create method input
        const methodInput = document.createElement('input');
        methodInput.type = 'hidden';
        methodInput.name = '_method';
        methodInput.value = 'DELETE';
        form.appendChild(methodInput);

        form.submit();
    }
}
</script>
