@extends('admin.layout')
@section('title', 'Tambah Menu')
@section('page_title', 'Tambah Menu Baru')

@section('content')
<div class="admin-card admin-form-card">
    <form action="{{ route('admin.menu.store') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @include('admin.menu._form')
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Simpan Menu</button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-admin">Batal</a>
        </div>
    </form>
</div>
@endsection
