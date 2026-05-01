@extends('admin.layout')
@section('title', 'Dashboard')
@section('page_title', 'Dashboard')

@section('content')
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-card-icon">📋</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ $totalMenus }}</span>
            <span class="stat-card-label">Total Menu</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon">☕</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ $totalKopi }}</span>
            <span class="stat-card-label">Menu Kopi</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon">🍵</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ $totalNonKopi }}</span>
            <span class="stat-card-label">Non-Kopi</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon">🍽️</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ $totalMakanan }}</span>
            <span class="stat-card-label">Makanan</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-card-icon">🍟</div>
        <div class="stat-card-info">
            <span class="stat-card-number">{{ $totalSnack }}</span>
            <span class="stat-card-label">Snack</span>
        </div>
    </div>
</div>

<div class="admin-card">
    <div class="card-header">
        <h3>Menu Terbaru</h3>
        <a href="{{ route('admin.menu.index') }}" class="btn btn-sm">Lihat Semua →</a>
    </div>
    <table class="admin-table">
        <thead>
            <tr>
                <th>Nama</th>
                <th>Kategori</th>
                <th>Harga</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach($recentMenus as $item)
            <tr>
                <td><strong>{{ $item->name }}</strong></td>
                <td><span class="badge">{{ $item->category_icon }} {{ ucfirst($item->category) }}</span></td>
                <td>Rp {{ $item->formatted_price }}</td>
                <td>
                    @if($item->is_available)
                    <span class="status-badge available">Tersedia</span>
                    @else
                    <span class="status-badge unavailable">Habis</span>
                    @endif
                </td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
