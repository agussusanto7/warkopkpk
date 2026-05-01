@extends('layouts.app')

@section('title', 'Menu - Warkop KPK')
@section('meta_description', 'Lihat menu lengkap Warkop KPK. Kopi premium, minuman non-kopi, makanan lezat, dan snack pilihan dengan harga bersahabat.')

@section('content')

{{-- Page Header --}}
<section class="page-header">
    <div class="page-header-bg" style="background-image: url('{{ $menuHeaderImage ?? asset('images/hero-coffee.png') }}')"></div>
    <div class="page-header-overlay"></div>
    <div class="page-header-content">
        <span class="section-badge animate-fade-up">☕ Menu Kami</span>
        <h1 class="page-title animate-fade-up delay-1">Menu <span class="text-gradient">Warkop KPK</span></h1>
        <p class="page-subtitle animate-fade-up delay-2">Pilihan menu yang disiapkan dengan bahan terbaik dan penuh cinta</p>
    </div>
</section>

{{-- Menu Filter --}}
<section class="menu-page" id="menuPage">
    <div class="container">
        <div class="menu-filter animate-on-scroll">
            <button class="filter-btn active" data-filter="all">Semua</button>
            @foreach($categories as $key => $category)
            <button class="filter-btn" data-filter="{{ $key }}">{{ $category['icon'] }} {{ $category['title'] }}</button>
            @endforeach
        </div>

        {{-- Menu Categories --}}
        @foreach($categories as $key => $category)
        <div class="menu-category" data-category="{{ $key }}">
            <div class="category-header animate-on-scroll">
                <span class="category-icon">{{ $category['icon'] }}</span>
                <h2 class="category-title">{{ $category['title'] }}</h2>
                <div class="category-line"></div>
            </div>
            <div class="menu-items-grid">
                @foreach($category['items'] as $item)
                <div class="menu-item-card animate-on-scroll">
                    @if($item['image'] !== 'images/coffee-latte.png')
                    <div class="menu-item-image">
                        <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" loading="lazy">
                    </div>
                    @endif
                    <div class="menu-item-info">
                        <h3 class="menu-item-name">{{ $item['name'] }}</h3>
                        <p class="menu-item-desc">{{ $item['desc'] }}</p>
                        @if($item['notes'])
                        <p class="menu-item-notes">{{ $item['notes'] }}</p>
                        @endif
                    </div>
                    <div class="menu-item-price">
                        <span class="price-currency">Rp</span>
                        <span class="price-amount">{{ $item['price'] }}</span>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        @endforeach

        {{-- Note --}}
        <div class="menu-note animate-on-scroll">
            <p>💡 <strong>Catatan:</strong> Harga dapat berubah sewaktu-waktu. Untuk menu terbaru, silakan hubungi kami via WhatsApp.</p>
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content animate-on-scroll">
            <h2>Ingin <span class="text-gradient">Pesan Sekarang</span>?</h2>
            <p>Hubungi kami via WhatsApp untuk pemesanan delivery atau takeaway.</p>
            <div class="cta-buttons">
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Halo%20Warkop%20KPK!%20Saya%20ingin%20memesan..." class="btn btn-primary" target="_blank">
                    <span>Pesan via WhatsApp</span>
                </a>
            </div>
        </div>
    </div>
</section>

@endsection

@section('extra_js')
<script>
    // Menu filter functionality
    document.querySelectorAll('.filter-btn').forEach(btn => {
        btn.addEventListener('click', () => {
            document.querySelectorAll('.filter-btn').forEach(b => b.classList.remove('active'));
            btn.classList.add('active');

            const filter = btn.dataset.filter;
            document.querySelectorAll('.menu-category').forEach(cat => {
                if (filter === 'all' || cat.dataset.category === filter) {
                    cat.style.display = 'block';
                    cat.style.animation = 'fadeInUp 0.5s ease forwards';
                } else {
                    cat.style.display = 'none';
                }
            });
        });
    });
</script>
@endsection
