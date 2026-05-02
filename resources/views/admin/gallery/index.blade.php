@extends('admin.layout')
@section('title', 'Kelola Gallery')
@section('page_title', '📷 Kelola Gallery')

@section('content')
{{-- Stats Summary --}}
<div class="admin-stats" style="display:grid;grid-template-columns:repeat(auto-fit,minmax(150px,1fr));gap:16px;margin-bottom:30px;">
    <div class="stat-card" style="background:linear-gradient(135deg,#667eea,#764ba2);color:white;">
        <div class="stat-card-icon">📷</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ \App\Models\Gallery::count() }}</span>
            <span class="stat-card-label">Total Momen</span>
        </div>
    </div>
    <div class="stat-card" style="background:linear-gradient(135deg,#f093fb,#f5576c);color:white;">
        <div class="stat-card-icon">✅</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ \App\Models\Gallery::where('is_published', true)->count() }}</span>
            <span class="stat-card-label">Published</span>
        </div>
    </div>
    <div class="stat-card" style="background:linear-gradient(135deg,#4facfe,#00f2fe);color:white;">
        <div class="stat-card-icon">📂</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ \App\Models\GalleryCategory::count() }}</span>
            <span class="stat-card-label">Kategori</span>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">
        <h3>Daftar Momen Gallery</h3>
        <div style="display:flex;gap:12px;align-items:center;">
            <a href="{{ route('admin.gallery.categories') }}" class="btn btn-sm" style="background:#6b7280;">
                🏷️ Kelola Kategori
            </a>
            <a href="{{ route('admin.gallery.create') }}" class="btn btn-sm">
                ➕ Tambah Momen
            </a>
        </div>
    </div>

    {{-- Filter & Search --}}
    <form method="GET" action="{{ route('admin.gallery.index') }}" style="padding:20px;border-bottom:1px solid #eee;display:flex;gap:12px;flex-wrap:wrap;align-items:center;">
        <input type="text" name="search" placeholder="🔍 Cari judul momen..." value="{{ request('search') }}"
               style="flex:1;min-width:200px;padding:10px 14px;border:2px solid #e5e7eb;border-radius:10px;font-size:0.9rem;">

        <select name="category" style="padding:10px 14px;border:2px solid #e5e7eb;border-radius:10px;font-size:0.9rem;min-width:160px;">
            <option value="all">Semua Kategori</option>
            @foreach($categories as $cat)
                <option value="{{ $cat->slug }}" {{ request('category') == $cat->slug ? 'selected' : '' }}>
                    {{ $cat->icon }} {{ $cat->name }}
                </option>
            @endforeach
        </select>

        <button type="submit" class="btn btn-sm">Filter</button>
        <a href="{{ route('admin.gallery.index') }}" class="btn btn-sm" style="background:#e5e7eb;color:#374151;">Reset</a>
    </form>

    <table class="admin-table">
        <thead>
            <tr>
                <th style="width:80px;">Foto</th>
                <th>Judul Momen</th>
                <th>Kategori</th>
                <th>Tanggal</th>
                <th>Foto</th>
                <th>Status</th>
                <th style="width:180px;">Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($galleries as $gallery)
            <tr>
                <td>
                    @if($gallery->cover_image_url)
                        <img src="{{ $gallery->cover_image_url }}"
                             alt="{{ $gallery->title }}"
                             style="width:70px;height:50px;object-fit:cover;border-radius:8px;">
                    @else
                        <div style="width:70px;height:50px;background:#f3f4f6;border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem;opacity:0.3;">📷</div>
                    @endif
                </td>
                <td>
                    <strong>{{ $gallery->title }}</strong>
                    @if($gallery->description)
                        <div style="font-size:0.8rem;color:#6b7280;margin-top:4px;max-width:250px;white-space:nowrap;overflow:hidden;text-overflow:ellipsis;">
                            {{ $gallery->description }}
                        </div>
                    @endif
                </td>
                <td>
                    <span class="badge" style="background:{{ $gallery->category->color }}20;color:{{ $gallery->category->color }};border:1px solid {{ $gallery->category->color }}40;">
                        {{ $gallery->category->icon }} {{ $gallery->category->name }}
                    </span>
                </td>
                <td style="white-space:nowrap;font-size:0.85rem;color:#6b7280;">📅 {{ $gallery->formatted_date }}</td>
                <td>
                    <span style="font-size:0.85rem;">📷 {{ $gallery->photo_count }} foto</span>
                </td>
                <td>
                    <form action="{{ route('admin.gallery.toggle', $gallery) }}" method="POST" style="display:inline;">
                        @csrf
                        @method('PATCH')
                        <button type="submit" style="background:none;border:none;cursor:pointer;padding:0;">
                            @if($gallery->is_published)
                                <span class="status-badge available">✅ Published</span>
                            @else
                                <span class="status-badge unavailable">⏳ Draft</span>
                            @endif
                        </button>
                    </form>
                </td>
                <td>
                    <div style="display:flex;gap:8px;">
                        <a href="{{ route('admin.gallery.edit', $gallery) }}" class="btn-icon" title="Edit" style="background:#3b82f6;color:white;padding:8px 12px;border-radius:8px;font-size:0.85rem;">✏️ Edit</a>
                        <form action="{{ route('admin.gallery.destroy', $gallery) }}" method="POST" onsubmit="return confirm('Yakin hapus momen ini?')" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn-icon" title="Hapus" style="background:#ef4444;color:white;padding:8px 12px;border-radius:8px;font-size:0.85rem;">🗑️</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:50px;color:#9ca3af;">
                    <div style="font-size:3rem;margin-bottom:10px;opacity:0.5;">📷</div>
                    <p>Belum ada momen gallery. <a href="{{ route('admin.gallery.create') }}" style="color:#3b82f6;">Tambah yang pertama!</a></p>
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>

    @if($galleries->hasPages())
    <div style="padding:20px;border-top:1px solid #eee;">
        {{ $galleries->withQueryString()->links() }}
    </div>
    @endif
</div>
@endsection