@extends('admin.layout')
@section('title', 'Edit Menu')
@section('page_title', 'Edit Menu: ' . $menuItem->name)

@section('content')
<div class="admin-card admin-form-card">
    <form action="{{ route('admin.menu.update', $menuItem) }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @include('admin.menu._form', ['menuItem' => $menuItem])
        <div class="form-actions">
            <button type="submit" class="btn btn-primary">💾 Update Menu</button>
            <a href="{{ route('admin.menu.index') }}" class="btn btn-outline-admin">Batal</a>
        </div>
    </form>
</div>
@endsection
