@extends('admin.layout')
@section('title', 'Kelola Menu')
@section('page_title', 'Kelola Menu')

@section('content')
<div class="admin-toolbar">
    <div class="toolbar-filters">
        <a href="{{ route('admin.menu.index') }}" class="filter-pill {{ !request('category') && !request('filter') ? 'active' : '' }}">Semua</a>
        <a href="{{ route('admin.menu.index', ['filter' => 'favorite']) }}" class="filter-pill {{ request('filter') == 'favorite' ? 'active' : '' }}">⭐ Favorit</a>
        <a href="{{ route('admin.menu.index', ['category' => 'kopi']) }}" class="filter-pill {{ request('category') == 'kopi' ? 'active' : '' }}">☕ Kopi</a>
        <a href="{{ route('admin.menu.index', ['category' => 'non-kopi']) }}" class="filter-pill {{ request('category') == 'non-kopi' ? 'active' : '' }}">🍵 Non-Kopi</a>
        <a href="{{ route('admin.menu.index', ['category' => 'makanan']) }}" class="filter-pill {{ request('category') == 'makanan' ? 'active' : '' }}">🍽️ Makanan</a>
        <a href="{{ route('admin.menu.index', ['category' => 'snack']) }}" class="filter-pill {{ request('category') == 'snack' ? 'active' : '' }}">🍟 Snack</a>
    </div>
    <a href="{{ route('admin.menu.create') }}" class="btn btn-primary">+ Tambah Menu</a>
</div>

<div class="admin-card">
    <table class="admin-table">
        <thead>
            <tr>
                <th>Foto</th>
                <th>Nama</th>
                <th>Deskripsi</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse($menuItems as $i => $item)
            <tr>
                <td>
                    @if($item->image)
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}" style="width:50px;height:50px;object-fit:cover;border-radius:8px">
                    @else
                    <div style="width:50px;height:50px;background:rgba(200,149,108,.15);border-radius:8px;display:flex;align-items:center;justify-content:center;font-size:1.5rem">{{ $item->category_icon }}</div>
                    @endif
                </td>
                <td>
                    <strong>{{ $item->name }}</strong>
                    @if($item->notes)
                    <br><small style="color:var(--gold)">{{ $item->notes }}</small>
                    @endif
                </td>
                <td class="desc-cell">{{ Str::limit($item->description, 40) }}</td>
                <td><span class="badge">{{ $item->category_icon }} {{ ucfirst($item->category) }}</span></td>
                <td>Rp {{ $item->formatted_price }}</td>
                <td>
                    @if($item->is_favorite)
                    <span class="status-badge available" title="Menu Favorit">⭐</span>
                    @endif
                    @if($item->is_available)
                    <span class="status-badge available">Tersedia</span>
                    @else
                    <span class="status-badge unavailable">Habis</span>
                    @endif
                </td>
                <td class="actions-cell">
                    <a href="{{ route('admin.menu.edit', $item) }}" class="action-btn edit" title="Edit">✏️</a>
                    <form action="{{ route('admin.menu.destroy', $item) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin ingin menghapus menu {{ $item->name }}?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="action-btn delete" title="Hapus">🗑️</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="7" style="text-align:center;padding:40px;color:#a89585">Belum ada menu. <a href="{{ route('admin.menu.create') }}" style="color:#C8956C">Tambah menu baru</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
