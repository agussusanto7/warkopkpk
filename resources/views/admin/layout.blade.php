<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=5">
    <title>@yield('title', 'Admin') - Warkop KPK</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('favicon.svg') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('favicon.ico') }}">
    @php
        $unreadCount = \App\Models\FeedbackPelanggan::where('is_read', false)->count();
    @endphp
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/admin.css') }}">
</head>
<body>
    {{-- Mobile Overlay --}}
    <div class="sidebar-overlay" id="sidebarOverlay"></div>

    {{-- Sidebar --}}
    <aside class="sidebar" id="sidebar">
        <div class="sidebar-header">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-logo">
                <span class="logo-icon">☕</span>
                <span class="logo-name">Warkop KPK</span>
            </a>
            <button class="sidebar-close" id="sidebarClose">✕</button>
        </div>
        <nav class="sidebar-nav">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <span class="link-icon">📊</span> Dashboard
            </a>
            <a href="{{ route('admin.menu.index') }}" class="sidebar-link {{ request()->routeIs('admin.menu.index') ? 'active' : '' }}">
                <span class="link-icon">📋</span> Kelola Menu
            </a>
            <a href="{{ route('admin.menu.create') }}" class="sidebar-link {{ request()->routeIs('admin.menu.create') ? 'active' : '' }}">
                <span class="link-icon">➕</span> Tambah Menu
            </a>
            <a href="{{ route('admin.images.index') }}" class="sidebar-link {{ request()->routeIs('admin.images.*') ? 'active' : '' }}">
                <span class="link-icon">🖼️</span> Kelola Foto
            </a>
            <a href="{{ route('admin.feedback.index') }}" class="sidebar-link {{ request()->routeIs('admin.feedback.*') ? 'active' : '' }}">
                <span class="link-icon">📬</span> Feedback
                @if($unreadCount > 0)
                <span class="nav-badge">{{ $unreadCount }}</span>
                @endif
            </a>
            <a href="{{ route('admin.profile.index') }}" class="sidebar-link {{ request()->routeIs('admin.profile.*') ? 'active' : '' }}">
                <span class="link-icon">👤</span> Profil
            </a>
            <a href="{{ route('admin.milestones.index') }}" class="sidebar-link {{ request()->routeIs('admin.milestones.*') ? 'active' : '' }}">
                <span class="link-icon">📅</span> Milestone
            </a>
            <div class="sidebar-divider"></div>
            <a href="{{ route('home') }}" class="sidebar-link" target="_blank">
                <span class="link-icon">🌐</span> Lihat Website
            </a>
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button type="submit" class="sidebar-link logout-btn">
                    <span class="link-icon">🚪</span> Logout
                </button>
            </form>
        </nav>
        <div class="sidebar-footer">
            <div class="user-info">
                <div class="user-avatar">{{ substr(Auth::user()->name, 0, 1) }}</div>
                <div>
                    <span class="user-name">{{ Auth::user()->name }}</span>
                    <span class="user-email">{{ Auth::user()->email }}</span>
                </div>
            </div>
        </div>
    </aside>

    {{-- Main Content --}}
    <div class="admin-main">
        <header class="admin-header">
            <button class="sidebar-toggle" id="sidebarToggle" aria-label="Buka menu">
                <span class="hamburger-icon">☰</span>
            </button>
            <h2>@yield('page_title', 'Dashboard')</h2>
        </header>
        <div class="admin-content">
            @if(session('success'))
            <div class="alert-success-admin">✅ {{ session('success') }}</div>
            @endif
            @yield('content')
        </div>
    </div>

    <script>
        const sidebarToggle = document.getElementById('sidebarToggle');
        const sidebarClose = document.getElementById('sidebarClose');
        const sidebar = document.getElementById('sidebar');
        const overlay = document.getElementById('sidebarOverlay');

        function openSidebar() {
            sidebar.classList.add('open');
            overlay.classList.add('active');
            document.body.style.overflow = 'hidden';
        }

        function closeSidebar() {
            sidebar.classList.remove('open');
            overlay.classList.remove('active');
            document.body.style.overflow = '';
        }

        if (sidebarToggle) {
            sidebarToggle.addEventListener('click', openSidebar);
        }
        if (sidebarClose) {
            sidebarClose.addEventListener('click', closeSidebar);
        }
        if (overlay) {
            overlay.addEventListener('click', closeSidebar);
        }

        // Close on escape key
        document.addEventListener('keydown', (e) => {
            if (e.key === 'Escape' && sidebar.classList.contains('open')) {
                closeSidebar();
            }
        });
    </script>
    @yield('extra_js')
</body>
</html>