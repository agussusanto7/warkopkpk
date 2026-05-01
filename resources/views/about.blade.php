@extends('layouts.app')

@section('title', 'Tentang Kami - Warkop KPK')
@section('meta_description', 'Kenali lebih dekat Warkop KPK — Kedai Penikmat Kopi. Cerita kami, filosofi kopi, dan tim barista handal yang siap menyajikan kopi terbaik untuk Anda.')

@section('content')

{{-- Page Header --}}
<section class="page-header">
    <div class="page-header-bg" style="background-image: url('{{ $aboutHeaderImage ?? asset('images/barista.png') }}')"></div>
    <div class="page-header-overlay"></div>
    <div class="page-header-content">
        <span class="section-badge animate-fade-up">📖 Cerita Kami</span>
        <h1 class="page-title animate-fade-up delay-1">Tentang <span class="text-gradient">Warkop KPK</span></h1>
        <p class="page-subtitle animate-fade-up delay-2">Perjalanan kami dalam menghadirkan kopi terbaik Nusantara</p>
    </div>
</section>

{{-- Story Section --}}
<section class="about-story">
    <div class="container">
        <div class="story-grid">
            <div class="story-content animate-on-scroll">
                <span class="section-badge">Cerita Kami</span>
                <h2 class="section-title">Dari <span class="text-gradient">Passion</span> Menjadi <span class="text-gradient">Realita</span></h2>
                <p>Warkop KPK — Kedai Penikmat Kopi — lahir dari sebuah mimpi sederhana: menyajikan secangkir kopi terbaik dengan harga yang terjangkau untuk semua kalangan.</p>
                <p>Berawal dari kecintaan mendalam terhadap kopi Indonesia, kami memulai perjalanan ini dengan satu tujuan — membawa pengalaman ngopi premium yang biasanya hanya bisa dinikmati di kafe-kafe mahal, ke dalam suasana warkop yang hangat dan bersahabat.</p>
                <p>Setiap biji kopi yang kami gunakan dipilih langsung dari para petani di berbagai penjuru Nusantara: dari dataran tinggi Toraja, pegunungan Gayo, hingga lereng Kintamani. Kami percaya, kopi terbaik dimulai dari sumbernya.</p>
            </div>
            <div class="story-image animate-on-scroll">
                <img src="{{ $aboutStoryImage ?? asset('images/hero-coffee.png') }}" alt="Interior Warkop KPK" loading="lazy">
            </div>
        </div>
    </div>
</section>

{{-- Values Section --}}
<section class="about-values">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-badge">Nilai Kami</span>
            <h2 class="section-title">Apa yang Membuat Kami <span class="text-gradient">Berbeda</span></h2>
        </div>
        <div class="values-grid">
            <div class="value-card animate-on-scroll">
                <div class="value-number">01</div>
                <div class="value-icon">🌱</div>
                <h3>Kualitas Tanpa Kompromi</h3>
                <p>Kami tidak pernah berkompromi soal kualitas. Dari pemilihan biji, proses roasting, hingga penyajian — semuanya dilakukan dengan standar tertinggi.</p>
            </div>
            <div class="value-card animate-on-scroll">
                <div class="value-number">02</div>
                <div class="value-icon">🤝</div>
                <h3>Mendukung Petani Lokal</h3>
                <p>Kami bermitra langsung dengan petani kopi Indonesia, memastikan mereka mendapat harga yang adil dan berkelanjutan.</p>
            </div>
            <div class="value-card animate-on-scroll">
                <div class="value-number">03</div>
                <div class="value-icon">💫</div>
                <h3>Pengalaman, Bukan Sekadar Minuman</h3>
                <p>Setiap kunjungan ke Warkop KPK adalah pengalaman. Dari aroma kopi yang menyambut, hingga obrolan hangat dengan barista kami.</p>
            </div>
            <div class="value-card animate-on-scroll">
                <div class="value-number">04</div>
                <div class="value-icon">🏡</div>
                <h3>Rumah Kedua Anda</h3>
                <p>Kami mendesain Warkop KPK sebagai tempat yang senyaman rumah sendiri. WiFi kencang, colokan tersedia, dan suasana yang mendukung produktivitas.</p>
            </div>
        </div>
    </div>
</section>

{{-- Timeline Section --}}
<section class="about-timeline">
    <div class="container">
        <div class="section-header animate-on-scroll">
            <span class="section-badge">Perjalanan</span>
            <h2 class="section-title">Milestone <span class="text-gradient">Kami</span></h2>
        </div>
        <div class="timeline">
            @forelse($milestones as $milestone)
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">{{ $milestone->year }}</span>
                    <h3>{{ $milestone->title }}</h3>
                    <p>{{ $milestone->description }}</p>
                </div>
            </div>
            @empty
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">2021</span>
                    <h3>Awal Mula</h3>
                    <p>Warkop KPK dibuka pertama kali sebagai kedai kopi kecil dengan hanya 5 menu dan 3 meja.</p>
                </div>
            </div>
            <div class="timeline-item animate-on-scroll">
                <div class="timeline-dot"></div>
                <div class="timeline-content">
                    <span class="timeline-year">2022</span>
                    <h3>Ekspansi Menu</h3>
                    <p>Menambah menu makanan dan non-kopi. Tim barista bertambah menjadi 5 orang bersertifikat.</p>
                </div>
            </div>
            @endforelse
        </div>
    </div>
</section>

{{-- CTA --}}
<section class="cta-section">
    <div class="container">
        <div class="cta-content animate-on-scroll">
            <h2>Ingin <span class="text-gradient">Berkunjung</span>?</h2>
            <p>Kami selalu siap menyambut Anda dengan secangkir kopi terbaik.</p>
            <div class="cta-buttons">
                <a href="{{ route('contact') }}" class="btn btn-primary">
                    <span>Lihat Lokasi</span>
                </a>
                <a href="{{ route('menu') }}" class="btn btn-outline">Lihat Menu</a>
            </div>
        </div>
    </div>
</section>

@endsection
