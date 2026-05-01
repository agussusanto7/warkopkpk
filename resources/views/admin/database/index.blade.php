@extends('admin.layout')
@section('title', 'Database')
@section('page_title', '📊 Database Browser')

@section('content')
<div class="admin-card">
    <h3 style="margin-bottom:24px;color:var(--cream)">📊 Kelola Data Database</h3>
    <p style="color:var(--text-muted);margin-bottom:24px">Pilih tabel untuk melihat isi data dan struktur kolomnya.</p>

    <div style="display:grid;grid-template-columns:repeat(auto-fill,minmax(250px,1fr));gap:16px">
        @foreach($tables as $table)
        <div style="background:var(--bg-card);border:1px solid rgba(200,149,108,.1);border-radius:12px;padding:24px;transition:var(--transition)">
            <div style="display:flex;align-items:center;gap:12px;margin-bottom:12px">
                <span style="font-size:2rem">{{ substr($table['label'], 0, 2) }}</span>
                <div>
                    <h4 style="color:var(--cream);margin:0">{{ substr($table['label'], 3) }}</h4>
                    <code style="font-size:.75rem;color:var(--text-muted)">{{ $table['name'] }}</code>
                </div>
            </div>
            <div style="display:flex;justify-content:space-between;align-items:center">
                <span class="badge">{{ $table['count'] }} data</span>
                @if($table['route'])
                <a href="{{ route($table['route']) }}" class="btn btn-sm btn-primary">Lihat Data</a>
                @else
                <span style="color:var(--text-muted);font-size:.8rem">Segera hadir</span>
                @endif
            </div>
        </div>
        @endforeach
    </div>
</div>

<div class="admin-card" style="margin-top:24px">
    <h4 style="color:var(--cream);margin-bottom:16px">📋 Struktur Tabel: menu_items</h4>
    <table class="admin-table">
        <thead>
            <tr>
                <th>#</th>
                <th>Nama Kolom</th>
                <th>Tipe Data</th>
                <th>Label</th>
            </tr>
        </thead>
        <tbody>
            <tr><td>1</td><td><code>id</code></td><td><span class="badge">bigint</span></td><td>ID</td></tr>
            <tr><td>2</td><td><code>name</code></td><td><span class="badge">varchar(255)</span></td><td>Nama Menu</td></tr>
            <tr><td>3</td><td><code>description</code></td><td><span class="badge">text</span></td><td>Deskripsi</td></tr>
            <tr><td>4</td><td><code>notes</code></td><td><span class="badge">text</span></td><td>Catatan</td></tr>
            <tr><td>5</td><td><code>price</code></td><td><span class="badge">decimal(10,0)</span></td><td>Harga</td></tr>
            <tr><td>6</td><td><code>category</code></td><td><span class="badge">varchar(255)</span></td><td>Kategori</td></tr>
            <tr><td>7</td><td><code>category_icon</code></td><td><span class="badge">varchar(255)</span></td><td>Icon</td></tr>
            <tr><td>8</td><td><code>image</code></td><td><span class="badge">varchar(255)</span></td><td>Foto</td></tr>
            <tr><td>9</td><td><code>is_available</code></td><td><span class="badge">boolean</span></td><td>Tersedia</td></tr>
            <tr><td>10</td><td><code>sort_order</code></td><td><span class="badge">int</span></td><td>Urutan</td></tr>
            <tr><td>11</td><td><code>created_at</code></td><td><span class="badge">timestamp</span></td><td>Dibuat</td></tr>
            <tr><td>12</td><td><code>updated_at</code></td><td><span class="badge">timestamp</span></td><td>Diupdate</td></tr>
        </tbody>
    </table>
</div>
@endsection