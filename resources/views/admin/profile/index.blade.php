@extends('admin.layout')
@section('title', 'Pengaturan Profil')
@section('page_title', 'Pengaturan Profil')

@section('content')
<div class="admin-form-card">
    @if(session('success'))
    <div class="alert-success">{{ session('success') }}</div>
    @endif

    {{-- Profil Info --}}
    <div class="profile-section">
        <h3 class="section-title">📋 Informasi Profil</h3>
        <form action="{{ route('admin.profile.update') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="name">Nama Lengkap</label>
                <input type="text" id="name" name="name" value="{{ old('name', auth()->user()->name) }}" required class="admin-input">
                @error('name')
                <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" id="email" name="email" value="{{ old('email', auth()->user()->email) }}" required class="admin-input">
                @error('email')
                <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Simpan Perubahan</button>
            </div>
        </form>
    </div>

    {{-- Password --}}
    <div class="profile-section">
        <h3 class="section-title">🔐 Ubah Password</h3>
        <form action="{{ route('admin.profile.password') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="current_password">Password Saat Ini</label>
                <input type="password" id="current_password" name="current_password" required class="admin-input" placeholder="Masukkan password saat ini">
                @error('current_password')
                <span class="form-error">{{ $message }}</span>
                @enderror
            </div>
            <div class="form-row-admin">
                <div class="form-group">
                    <label for="password">Password Baru</label>
                    <input type="password" id="password" name="password" required class="admin-input" placeholder="Minimal 8 karakter">
                    @error('password')
                    <span class="form-error">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password_confirmation">Konfirmasi Password</label>
                    <input type="password" id="password_confirmation" name="password_confirmation" required class="admin-input" placeholder="Ulangi password baru">
                </div>
            </div>
            <div class="form-actions">
                <button type="submit" class="btn btn-primary">🔐 Ubah Password</button>
            </div>
        </form>
    </div>
</div>

<style>
.profile-section {
    margin-bottom: 32px;
    padding-bottom: 24px;
    border-bottom: 1px solid rgba(200, 149, 108, 0.1);
}
.profile-section:last-child {
    margin-bottom: 0;
    padding-bottom: 0;
    border-bottom: none;
}
.section-title {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    color: var(--cream);
    margin-bottom: 20px;
}
</style>
@endsection