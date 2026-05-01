@extends('admin.layout')
@section('title', 'Kelola Foto')
@section('page_title', 'Kelola Foto Website')

@section('content')
<div class="admin-toolbar">
    <p style="color:var(--text-secondary);font-size:.9rem">Kelola foto/gambar background yang tampil di website. Klik <strong style="color:var(--cream)">"Aktifkan"</strong> untuk mengganti foto yang aktif di setiap section.</p>
    <a href="{{ route('admin.images.create') }}" class="btn btn-primary">+ Upload Foto Baru</a>
</div>

@foreach($sections as $key => $label)
@php $sectionImages = $images->where('section_key', $key); @endphp
<div class="admin-card" style="margin-bottom:24px">
    <div class="card-header">
        <h3>🖼️ {{ $label }}</h3>
        <span class="badge">{{ $sectionImages->count() }} foto</span>
    </div>
    <div class="image-grid">
        @forelse($sectionImages as $img)
        <div class="image-card {{ $img->is_active ? 'active' : '' }}">
            <div class="image-preview">
                <img src="{{ asset('storage/' . $img->image_path) }}" alt="{{ $img->title }}">
                @if($img->is_active)
                <span class="active-badge">✓ AKTIF</span>
                @endif
            </div>
            <div class="image-info">
                <span class="image-title">{{ $img->title }}</span>
                <span class="image-date">{{ $img->created_at->format('d M Y') }}</span>
            </div>
            <div class="image-actions">
                @if(!$img->is_active)
                <form action="{{ route('admin.images.activate', $img) }}" method="POST" style="display:inline">
                    @csrf
                    <button type="submit" class="btn btn-sm btn-primary">Aktifkan</button>
                </form>
                @else
                <span class="btn btn-sm" style="opacity:.5;cursor:default">Sedang Aktif</span>
                @endif
                <form action="{{ route('admin.images.destroy', $img) }}" method="POST" style="display:inline" onsubmit="return confirm('Yakin hapus foto ini?')">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-sm btn-danger">🗑️</button>
                </form>
            </div>
        </div>
        @empty
        <div class="empty-section">
            <p>Belum ada foto untuk section ini. <a href="{{ route('admin.images.create') }}" style="color:var(--gold)">Upload sekarang</a></p>
        </div>
        @endforelse
    </div>
</div>
@endforeach
@endsection
