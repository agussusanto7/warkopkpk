@extends('layouts.app')

@section('title', 'Warkop KPK - Kedai Penikmat Kopi')
@section('meta_description', 'Warkop KPK — Kedai Penikmat Kopi. Nikmati kopi premium pilihan dari berbagai penjuru Nusantara dengan suasana yang nyaman dan hangat.')

@section('content')

{{-- Hero Section --}}
<section class="hero" id="hero">
    <div class="hero-overlay"></div>
    <div class="hero-bg" style="background-image: url('{{ $heroImage ?? asset('images/hero-coffee.png') }}')"></div>
    <div class="hero-particles" id="heroParticles"></div>
    <div class="hero-content">
        <span class="hero-badge animate-fade-up">☕ Kedai Penikmat Kopi</span>
        <h1 class="hero-title animate-fade-up delay-1">
            Nikmati <span class="text-gradient">Kopi Terbaik</span><br>
            di Warkop KPK
        </h1>
        <p class="hero-subtitle animate-fade-up delay-2">
            Racikan premium dari biji kopi pilihan Nusantara, disajikan dengan penuh cinta oleh barista berpengalaman kami.
        </p>
        <div class="hero-buttons animate-fade-up delay-3">
            <a href="{{ route('menu') }}" class="btn btn-primary">
                <span>Lihat Menu</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline">Hubungi Kami</a>
        </div>
        <div class="hero-stats animate-fade-up delay-4">
            <div class="stat">
                <span class="stat-number" data-count="{{ $stats['cups'] }}">0</span><span class="stat-suffix">+</span>
                <span class="stat-label">Cup Terjual</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-number" data-count="{{ $stats['menu'] }}">0</span><span class="stat-suffix">+</span>
                <span class="stat-label">Menu Pilihan</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-number" data-count="{{ explode('.', $stats['rating'])[0] }}">0</span><span class="stat-suffix">.{{ explode('.', $stats['rating'])[1] ?? '0' }}★</span>
                <span class="stat-label">Rating</span>
            </div>
        </div>
    </div>
    <div class="hero-scroll">
        <span>Scroll</span>
        <div class="scroll-indicator"></div>
    </div>
</section>

{{-- Features Section --}}
<section class="features" id="features">
    <div class="container">
        <div class="features-grid">
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">🫘</div>
                <h3>Biji Pilihan</h3>
                <p>Biji kopi terbaik dari Toraja, Gayo, Kintamani, dan berbagai daerah penghasil kopi premium Indonesia.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">👨‍🍳</div>
                <h3>Barista Handal</h3>
                <p>Tim barista bersertifikat dengan pengalaman bertahun-tahun meracik kopi dengan penuh dedikasi.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">🏠</div>
                <h3>Suasana Nyaman</h3>
                <p>Interior hangat dengan desain industrial-rustic, cocok untuk bekerja, meeting, atau sekadar bersantai.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <div class="feature-icon">💰</div>
                <h3>Harga Bersahabat</h3>
                <p>Kualitas premium dengan harga yang ramah di kantong. Nikmat tanpa bikin dompet menjerit.</p>
            </div>
        </div>
    </div>
</section>

{{-- Menu Highlights Section --}}
<section class="menu-highlights" id="menuHighlights">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-badge">Menu Favorit</span>
            <h2 class="section-title">Yang Paling <span class="text-gradient">Digemari</span></h2>
            <p class="section-subtitle">Pilihan menu terlaris yang selalu menjadi favorit pelanggan setia kami</p>
        </div>
        <div class="favorite-grid">
            @foreach($menuHighlights as $item)
            <div class="favorite-card animate-on-scroll">
                <div class="favorite-img">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" loading="lazy">
                </div>
                <div class="favorite-info">
                    <h3>{{ $item['name'] }}</h3>
                    <span class="favorite-price">Rp {{ $item['price'] }}</span>
                </div>
            </div>
            @endforeach
        </div>
        <div class="section-cta animate-on-scroll">
            <a href="{{ route('menu') }}" class="btn btn-primary">
                <span>Lihat Semua Menu</span>
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- About Preview Section --}}
<section class="about-preview" id="aboutPreview">
    <div class="container">
        <div class="about-preview-grid">
            <div class="about-preview-image animate-on-scroll">
                <img src="{{ $baristaImage ?? asset('images/barista.png') }}" alt="Barista Warkop KPK" loading="lazy">
                <div class="experience-badge">
                    <span class="exp-number">5+</span>
                    <span class="exp-text">Tahun Pengalaman</span>
                </div>
            </div>
            <div class="about-preview-content animate-on-scroll">
                <span class="section-badge">Tentang Kami</span>
                <h2 class="section-title">Cerita di Balik <span class="text-gradient">Secangkir Kopi</span></h2>
                <p>Warkop KPK lahir dari kecintaan mendalam terhadap kopi Indonesia. Kami percaya bahwa secangkir kopi bukan sekadar minuman, melainkan sebuah pengalaman yang menghubungkan cerita, budaya, dan kebersamaan.</p>
                <p>Setiap biji kopi yang kami sajikan dipilih langsung dari petani-petani terbaik di Indonesia, diolah dengan metode terkini, dan disajikan dengan sepenuh hati oleh barista-barista handal kami.</p>
                <div class="about-features">
                    <div class="about-feature">
                        <span class="check-icon">✓</span>
                        <span>Single Origin Nusantara</span>
                    </div>
                    <div class="about-feature">
                        <span class="check-icon">✓</span>
                        <span>Fresh Roasted Weekly</span>
                    </div>
                    <div class="about-feature">
                        <span class="check-icon">✓</span>
                        <span>Barista Bersertifikat</span>
                    </div>
                    <div class="about-feature">
                        <span class="check-icon">✓</span>
                        <span>WiFi Gratis</span>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary">
                    <span>Selengkapnya</span>
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
                </a>
            </div>
        </div>
    </div>
</section>

{{-- Testimonials Section --}}
<section class="testimonials" id="testimonials">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-badge">Testimoni</span>
            <h2 class="section-title">Kata Mereka Tentang <span class="text-gradient">Kami</span></h2>
            <p class="section-subtitle">Apa kata pelanggan setia kami tentang pengalaman mereka di Warkop KPK</p>
        </div>
        <div class="testimonials-grid">
            @foreach($testimonials as $testimonial)
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-stars">
                    @for($i = 0; $i < $testimonial['rating']; $i++)
                        <span class="star">★</span>
                    @endfor
                    @for($i = $testimonial['rating']; $i < 5; $i++)
                        <span class="star empty">★</span>
                    @endfor
                </div>
                <p class="testimonial-text">"{{ $testimonial['text'] }}"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">{{ substr($testimonial['name'], 0, 1) }}</div>
                    <div class="author-info">
                        <span class="author-name">{{ $testimonial['name'] }}</span>
                        <span class="author-label">Pelanggan Setia</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="cta-section" id="ctaSection">
    <div class="container">
        <div class="cta-content animate-on-scroll">
            <h2>Siap Menikmati <span class="text-gradient">Kopi Terbaik</span>?</h2>
            <p>Kunjungi Warkop KPK sekarang atau pesan melalui WhatsApp untuk pengalaman kopi yang tak terlupakan.</p>
            <div class="cta-buttons">
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Halo%20Warkop%20KPK!" class="btn btn-primary" target="_blank">
                    <span>Chat WhatsApp</span>
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline">Lihat Lokasi</a>
            </div>
        </div>
    </div>
</section>

@endsection
