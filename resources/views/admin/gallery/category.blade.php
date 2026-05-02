@extends('admin.layout')
@section('title', 'Kelola Kategori Gallery')
@section('page_title', '🏷️ Kelola Kategori Gallery')

@section('content')
<div style="display:grid;grid-template-columns:1fr 1fr;gap:30px;">

    {{-- Add Category Form --}}
    <div class="admin-card">
        <div class="card-header">
            <h3>➕ Tambah Kategori Baru</h3>
        </div>
        <form action="{{ route('admin.gallery.category.store') }}" method="POST" style="padding:30px;">
            @csrf
            <div style="margin-bottom:20px;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Nama Kategori *</label>
                <input type="text" name="name" value="{{ old('name') }}" required maxlength="100"
                       placeholder="Contoh: Workshop Kopi"
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;"
                       onfocus="this.style.borderColor='#c49a6c'"
                       onblur="this.style.borderColor='#e5e7eb'">
            </div>
            <div style="display:grid;grid-template-columns:1fr 1fr;gap:16px;margin-bottom:20px;">
                <div>
                    <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Icon (Emoji)</label>
                    <input type="text" name="icon" value="{{ old('icon', '📷') }}" maxlength="50"
                       placeholder="📷"
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;text-align:center;font-size:1.5rem;">
                </div>
                <div>
                    <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Warna (Hex)</label>
                    <div style="display:flex;align-items:center;gap:10px;">
                        <input type="color" name="color" value="{{ old('color', '#6b7280') }}"
                               style="width:50px;height:50px;border:2px solid #e5e7eb;border-radius:12px;cursor:pointer;padding:4px;">
                        <input type="text" name="color_text" id="colorText" value="{{ old('color', '#6b7280') }}"
                               placeholder="#6b7280" maxlength="20"
                               style="flex:1;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.9rem;"
                               oninput="document.querySelector('input[name=color]').value = this.value">
                    </div>
                </div>
            </div>
            <div style="margin-bottom:20px;">
                <label style="display:block;font-weight:600;margin-bottom:8px;color:#374151;">Urutan</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', 0) }}" min="0"
                       placeholder="0"
                       style="width:100%;padding:12px 16px;border:2px solid #e5e7eb;border-radius:12px;font-size:0.95rem;">
            </div>
            <button type="submit" class="btn btn-sm"
                    style="width:100%;background:linear-gradient(135deg,#10b981,#059669);color:white;padding:14px;border-radius:12px;font-weight:600;border:none;cursor:pointer;">
                ✅ Simpan Kategori
            </button>
        </form>
    </div>

    {{-- Categories List --}}
    <div class="admin-card">
        <div class="card-header">
            <h3>Daftar Kategori</h3>
            <span style="font-size:0.85rem;color:#6b7280;">{{ $categories->count() }} kategori</span>
        </div>
        <div style="padding:20px;">
            @forelse($categories as $cat)
                <div style="padding:16px;border:2px solid #e5e7eb;border-radius:14px;margin-bottom:16px;transition:all 0.3s;"
                     id="category-{{ $cat->id }}">
                    <div style="display:flex;align-items:center;justify-content:space-between;margin-bottom:12px;">
                        <div style="display:flex;align-items:center;gap:12px;">
                            <div style="width:48px;height:48px;border-radius:12px;background:{{ $cat->color }}20;display:flex;align-items:center;justify-content:center;font-size:1.5rem;">
                                {{ $cat->icon }}
                            </div>
                            <div>
                                <strong style="font-size:1rem;color:#1f2937;">{{ $cat->name }}</strong>
                                <div style="font-size:0.8rem;color:#9ca3af;">{{ $cat->slug }}</div>
                            </div>
                        </div>
                        <div style="display:flex;align-items:center;gap:8px;">
                            <span style="width:12px;height:12px;border-radius:50%;background:{{ $cat->color }};"
                                  title="{{ $cat->color }}"></span>
                            <span class="badge" style="background:{{ $cat->color }}20;color:{{ $cat->color }};">
                                {{ $cat->galleries_count ?? $cat->galleries->count() }} momen
                            </span>
                        </div>
                    </div>

                    {{-- Edit Form (toggle) --}}
                    <div id="editForm-{{ $cat->id }}" style="display:none;padding-top:16px;border-top:1px solid #f3f4f6;">
                        <form action="{{ route('admin.gallery.category.update', $cat) }}" method="POST"
                              style="display:grid;grid-template-columns:1fr auto auto;gap:10px;align-items:end;">
                            @csrf
                            @method('PUT')
                            <input type="text" name="name" value="{{ $cat->name }}" required
                                   style="padding:8px 12px;border:2px solid #e5e7eb;border-radius:8px;font-size:0.9rem;">
                            <input type="text" name="icon" value="{{ $cat->icon }}" maxlength="50"
                                   style="padding:8px 12px;border:2px solid #e5e7eb;border-radius:8px;font-size:1.2rem;width:60px;text-align:center;">
                            <input type="color" name="color" value="{{ $cat->color }}"
                                   style="padding:4px;border:2px solid #e5e7eb;border-radius:8px;width:45px;cursor:pointer;">
                            <input type="number" name="sort_order" value="{{ $cat->sort_order }}" min="0"
                                   style="padding:8px 12px;border:2px solid #e5e7eb;border-radius:8px;font-size:0.9rem;width:80px;">
                            <div style="display:flex;gap:6px;">
                                <button type="submit" class="btn btn-sm" style="background:#10b981;color:white;padding:8px 14px;border-radius:8px;">💾</button>
                                <label style="display:flex;align-items:center;gap:4px;font-size:0.85rem;cursor:pointer;white-space:nowrap;">
                                    <input type="checkbox" name="is_active" value="1" {{ $cat->is_active ? 'checked' : '' }}
                                           style="width:16px;height:16px;">
                                    Aktif
                                </label>
                            </div>
                        </form>
                    </div>

                    {{-- Action Buttons --}}
                    <div style="display:flex;gap:8px;margin-top:12px;">
                        <button onclick="toggleEdit({{ $cat->id }})"
                                class="btn btn-sm" style="background:#3b82f6;color:white;padding:8px 14px;border-radius:8px;flex:1;">
                            ✏️ Edit
                        </button>
                        <form action="{{ route('admin.gallery.category.destroy', $cat) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus kategori &quot;{{ $cat->name }}&quot;? Semua momen di kategori ini juga akan ikut terhapus!')"
                              style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm" style="background:#ef4444;color:white;padding:8px 14px;border-radius:8px;">
                                🗑️
                            </button>
                        </form>
                    </div>
                </div>
            @empty
                <div style="text-align:center;padding:40px;color:#9ca3af;">
                    <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">🏷️</div>
                    <p>Belum ada kategori. Tambahkan yang pertama!</p>
                </div>
            @endforelse
        </div>
    </div>

</div>

<div style="margin-top:30px;padding:20px;background:#fef3c7;border-radius:16px;border:2px solid #fcd34d;">
    <h4 style="margin-bottom:10px;">💡 Tips Kategori</h4>
    <ul style="margin:0;padding-left:20px;color:#92400e;font-size:0.9rem;line-height:1.8;">
        <li>Kategori <strong>Buka Bersama, Nobar Bola, Live Music, Outing & Trip</strong> sudah dibuat otomatis saat migrasi berjalan.</li>
        <li>Drag & drop icon untuk pilih emoji yang cocok sebagai penanda kategori.</li>
        <li>Warna akan terlihat di badge kategori di halaman gallery website.</li>
        <li>Menghapus kategori akan ikut menghapus semua momen gallery di dalamnya.</li>
    </ul>
</div>
@endsection

@section('extra_js')
<script>
function toggleEdit(id) {
    const form = document.getElementById('editForm-' + id);
    form.style.display = form.style.display === 'none' ? 'block' : 'none';
}

// Sync color picker with text input
document.querySelectorAll('input[type="color"]').forEach(picker => {
    picker.addEventListener('input', function() {
        const textInput = this.closest('div').querySelector('input[type="text"]');
        if (textInput) textInput.value = this.value;
    });
});
</script>
@endsection