@extends('layouts.app')

@section('title', 'Warkop KPK - Kedai Penikmat Kopi')
@section('meta_description', 'Warkop KPK — Kedai Penikmat Kopi. Nikmati kopi premium pilihan dari berbagai penjuru Nusantara dengan suasana yang nyaman dan hangat.')

@section('content')

{{-- Hero Section --}}
<section class="hero" id="hero">
    <div class="hero-overlay"></div>
    <div class="hero-bg" style="background-image: url('{{ $heroImage ?? asset('images/hero-coffee.png') }}')"></div>
    <div class="hero-content">
        <span class="hero-badge animate-fade-up">
            <svg width="14" height="14" viewBox="0 0 24 24" fill="currentColor"><path d="M18.5 3H6C4.34315 3 3 4.34315 3 6V18C3 19.6569 4.34315 21 6 21H18.5C20.1569 21 21.5 19.6569 21.5 18V6C21.5 4.34315 20.1569 3 18.5 3ZM12 18C9.23858 18 7 15.7614 7 13C7 10.2386 9.23858 8 12 8C14.7614 8 17 10.2386 17 13C17 15.7614 14.7614 18 12 18Z"/></svg>
            Kedai Penikmat Kopi
        </span>
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
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
            </a>
            <a href="{{ route('contact') }}" class="btn btn-outline">Hubungi Kami</a>
        </div>
        <div class="hero-stats animate-fade-up delay-4">
            <div class="stat">
                <span class="stat-number" data-count="{{ $stats['cups'] ?? 15000 }}">0</span><span class="stat-suffix">+</span>
                <span class="stat-label">Cup Terjual</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-number" data-count="{{ $stats['menu'] ?? 25 }}">0</span><span class="stat-suffix">+</span>
                <span class="stat-label">Menu Pilihan</span>
            </div>
            <div class="stat-divider"></div>
            <div class="stat">
                <span class="stat-number" data-count="{{ explode('.', ($stats['rating'] ?? '4.8'))[0] }}">0</span><span class="stat-suffix">.{{ explode('.', ($stats['rating'] ?? '4.8'))[1] ?? '8' }}★</span>
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
        <div class="section-header animate-on-scroll">
            <span class="section-badge">Keunggulan Kami</span>
            <h2 class="section-title">Kenapa Harus <span class="text-gradient">Warkop KPK</span></h2>
            <p class="section-subtitle">Semua yang kami lakukan berpusat pada satu tujuan — menghadirkan pengalaman ngopi terbaik untuk Anda.</p>
        </div>
        <div class="features-grid">
            <div class="feature-card animate-on-scroll">
                <span class="feature-icon">☕</span>
                <h3>Biji Pilihan</h3>
                <p>Biji kopi terbaik dari Toraja, Gayo, Kintamani, dan berbagai daerah penghasil kopi premium Indonesia.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <span class="feature-icon">👨‍🍳</span>
                <h3>Barista Handal</h3>
                <p>Tim barista bersertifikat dengan pengalaman bertahun-tahun meracik kopi dengan penuh dedikasi.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <span class="feature-icon">🏠</span>
                <h3>Suasana Nyaman</h3>
                <p>Interior hangat dengan desain modern, cocok untuk bekerja, meeting, atau sekadar bersantai.</p>
            </div>
            <div class="feature-card animate-on-scroll">
                <span class="feature-icon">💰</span>
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
            @forelse($menuHighlights as $item)
            <div class="favorite-card animate-on-scroll">
                <div class="favorite-img">
                    <img src="{{ asset($item['image']) }}" alt="{{ $item['name'] }}" loading="lazy">
                </div>
                <div class="favorite-info">
                    <h3>{{ $item['name'] }}</h3>
                    <span class="favorite-price">Rp {{ number_format($item['price'], 0, ',', '.') }}</span>
                </div>
            </div>
            @empty
            <div class="favorite-card animate-on-scroll">
                <div class="favorite-img">
                    <img src="{{ asset('images/coffee-latte.png') }}" alt="Cappuccino" loading="lazy">
                </div>
                <div class="favorite-info">
                    <h3>Cappuccino</h3>
                    <span class="favorite-price">Rp 25.000</span>
                </div>
            </div>
            <div class="favorite-card animate-on-scroll">
                <div class="favorite-img">
                    <img src="{{ asset('images/coffee-latte.png') }}" alt="Latte" loading="lazy">
                </div>
                <div class="favorite-info">
                    <h3>Coffee Latte</h3>
                    <span class="favorite-price">Rp 22.000</span>
                </div>
            </div>
            <div class="favorite-card animate-on-scroll">
                <div class="favorite-img">
                    <img src="{{ asset('images/coffee-latte.png') }}" alt="Espresso" loading="lazy">
                </div>
                <div class="favorite-info">
                    <h3>Espresso</h3>
                    <span class="favorite-price">Rp 18.000</span>
                </div>
            </div>
            <div class="favorite-card animate-on-scroll">
                <div class="favorite-img">
                    <img src="{{ asset('images/coffee-latte.png') }}" alt="Americano" loading="lazy">
                </div>
                <div class="favorite-info">
                    <h3>Americano</h3>
                    <span class="favorite-price">Rp 20.000</span>
                </div>
            </div>
            @endforelse
        </div>
        <div class="section-cta animate-on-scroll">
            <a href="{{ route('menu') }}" class="btn btn-primary" style="background:linear-gradient(135deg,#B8892E,#D4A94A);color:#fff">
                <span>Lihat Semua Menu</span>
                <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
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
                        <span class="check-icon">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span>Single Origin Nusantara</span>
                    </div>
                    <div class="about-feature">
                        <span class="check-icon">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span>Fresh Roasted Weekly</span>
                    </div>
                    <div class="about-feature">
                        <span class="check-icon">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span>Barista Bersertifikat</span>
                    </div>
                    <div class="about-feature">
                        <span class="check-icon">
                            <svg width="10" height="10" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                        </span>
                        <span>WiFi Gratis</span>
                    </div>
                </div>
                <a href="{{ route('about') }}" class="btn btn-primary" style="background:linear-gradient(135deg,#B8892E,#D4A94A);color:#fff">
                    <span>Selengkapnya</span>
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14M12 5l7 7-7 7"/></svg>
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
            @forelse($testimonials as $testimonial)
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
            @empty
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <p class="testimonial-text">"Tempatnya nyaman banget, kopi nya juga enak! Harga terjangkau untuk kualitas seperti ini. Pasti balik lagi!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">A</div>
                    <div class="author-info">
                        <span class="author-name">Andi Pratama</span>
                        <span class="author-label">Pelanggan Setia</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span>
                </div>
                <p class="testimonial-text">"Barista nya ramah dan kualitas kopinya konsisten. Favorite spot buat kerja2 sambil ngopi. WiFi juga kenceng!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">S</div>
                    <div class="author-info">
                        <span class="author-name">Sari Dewi</span>
                        <span class="author-label">Pelanggan Setia</span>
                    </div>
                </div>
            </div>
            <div class="testimonial-card animate-on-scroll">
                <div class="testimonial-stars">
                    <span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star">★</span><span class="star empty">★</span>
                </div>
                <p class="testimonial-text">"Latte art nya cantik, suasana juga cozy. Cocok banget buat nongkrong sama temen. Recommended!"</p>
                <div class="testimonial-author">
                    <div class="author-avatar">R</div>
                    <div class="author-info">
                        <span class="author-name">Rudi Hermawan</span>
                        <span class="author-label">Pelanggan Setia</span>
                    </div>
                </div>
            </div>
            @endforelse
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
                <a href="https://wa.me/{{ $siteSettings['whatsapp'] }}?text=Halo%20Warkop%20KPK!" class="btn btn-primary" target="_blank" style="background:linear-gradient(135deg,#25D366,#128C7E);box-shadow:0 2px 10px rgba(37,211,102,.3)">
                    <svg width="18" height="18" viewBox="0 0 24 24" fill="currentColor"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                    <span>Chat WhatsApp</span>
                </a>
                <a href="{{ route('contact') }}" class="btn btn-outline">Lihat Lokasi</a>
            </div>
        </div>
    </div>
</section>

@endsection