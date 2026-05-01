@extends('layouts.app')

@section('title', 'Kontak - Warkop KPK')
@section('meta_description', 'Hubungi Warkop KPK. Temukan lokasi kami, jam operasional, dan kirim pesan langsung. Kami siap melayani Anda!')

@section('content')

{{-- Page Header --}}
<section class="page-header page-header-sm">
    <div class="page-header-bg" style="background-image: url('{{ $contactHeaderImage ?? asset('images/hero-coffee.png') }}')"></div>
    <div class="page-header-overlay"></div>
    <div class="page-header-content">
        <span class="section-badge animate-fade-up">📞 Hubungi Kami</span>
        <h1 class="page-title animate-fade-up delay-1">Kontak <span class="text-gradient">Kami</span></h1>
        <p class="page-subtitle animate-fade-up delay-2">Kami senang mendengar dari Anda</p>
    </div>
</section>

{{-- Contact Section --}}
<section class="contact-section">
    <div class="container">
        <div class="contact-grid">
            {{-- Contact Info --}}
            <div class="contact-info animate-on-scroll">
                <h2 class="section-title">Temukan <span class="text-gradient">Kami</span></h2>
                <p>Jangan ragu untuk menghubungi kami kapan saja. Kami siap membantu Anda!</p>

                <div class="info-cards">
                    <div class="info-card">
                        <div class="info-icon">📍</div>
                        <div>
                            <h4>Alamat</h4>
                            <p>{!! nl2br(e($contactInfo['address'])) !!}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">📞</div>
                        <div>
                            <h4>Telepon</h4>
                            <p>{{ $contactInfo['phone'] }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">✉️</div>
                        <div>
                            <h4>Email</h4>
                            <p>{{ $contactInfo['email'] }}</p>
                        </div>
                    </div>
                    <div class="info-card">
                        <div class="info-icon">🕐</div>
                        <div>
                            <h4>Jam Buka</h4>
                            <p>{!! nl2br(e($contactInfo['jam_buka'])) !!}</p>
                        </div>
                    </div>
                </div>

                {{-- Map --}}
                @if($contactInfo['maps_url'])
                <div class="map-container">
                    <iframe
                        src="{{ $contactInfo['maps_url'] }}"
                        width="100%"
                        height="250"
                        style="border:0; border-radius: 12px;"
                        allowfullscreen=""
                        loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade">
                    </iframe>
                </div>
                @endif
            </div>

            {{-- Contact Form --}}
            <div class="contact-form-wrapper animate-on-scroll">
                <div class="form-card">
                    <h2 class="section-title">Kirim <span class="text-gradient">Pesan</span></h2>
                    <p>Punya pertanyaan, saran, atau ingin reservasi? Isi form di bawah ini.</p>

                    @if(session('success'))
                    <div class="alert alert-success">
                        <span class="alert-icon">✅</span>
                        {{ session('success') }}
                    </div>
                    @endif

                    <form action="{{ route('contact.store') }}" method="POST" id="contactForm">
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama Lengkap *</label>
                            <input type="text" id="name" name="name" value="{{ old('name') }}" required placeholder="Masukkan nama Anda">
                            @error('name')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label for="email">Email *</label>
                                <input type="email" id="email" name="email" value="{{ old('email') }}" required placeholder="email@example.com">
                                @error('email')
                                <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                            <div class="form-group">
                                <label for="phone">No. Telepon</label>
                                <input type="tel" id="phone" name="phone" value="{{ old('phone') }}" placeholder="08xx-xxxx-xxxx">
                                @error('phone')
                                <span class="form-error">{{ $message }}</span>
                                @enderror
                            </div>
                        </div>

                        <div class="form-group">
                            <label for="message">Pesan *</label>
                            <textarea id="message" name="message" rows="5" required placeholder="Tulis pesan Anda di sini...">{{ old('message') }}</textarea>
                            @error('message')
                            <span class="form-error">{{ $message }}</span>
                            @enderror
                        </div>

                        <button type="submit" class="btn btn-primary btn-full" id="submitBtn">
                            <span>Kirim Pesan</span>
                            <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M22 2L11 13M22 2l-7 20-4-9-9-4 20-7z"/></svg>
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</section>

@endsection
