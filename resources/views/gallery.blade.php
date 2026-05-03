@extends('layouts.app')
@section('title', 'Gallery - Warkop KPK')
@section('meta_description', 'Gallery momen seru di Warkop KPK - Bukber, Nobar, Live Music, dan masih banyak lagi!')

@section('extra_css')
<style>
/* ============================================
   GALLERY PAGE - Dark Theme Match
   ============================================ */
.gallery-page {
    padding: 120px 0 80px;
    min-height: 100vh;
    background: var(--bg-dark);
}

.gallery-header {
    text-align: center;
    margin-bottom: 50px;
    padding: 0 20px;
}

.gallery-header .section-badge {
    display: inline-block;
    padding: 6px 16px;
    background: rgba(200,149,108,.1);
    border: 1px solid rgba(200,149,108,.2);
    border-radius: 50px;
    font-size: .8rem;
    color: var(--gold);
    margin-bottom: 16px;
}

.gallery-header h1 {
    font-family: var(--font-heading);
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--cream);
    margin-bottom: 15px;
}

.gallery-header p {
    font-size: 1rem;
    color: var(--text-secondary);
    max-width: 600px;
    margin: 0 auto;
}

/* Filter Tabs */
.gallery-filters {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 10px;
    margin-bottom: 50px;
    padding: 0 20px;
}

.filter-btn {
    display: inline-flex;
    align-items: center;
    gap: 6px;
    padding: 8px 18px;
    border-radius: 50px;
    background: var(--bg-card);
    color: var(--text-secondary);
    font-size: .85rem;
    font-weight: 500;
    border: 1px solid rgba(200,149,108,.15);
    cursor: pointer;
    transition: var(--transition);
    text-decoration: none;
}

.filter-btn:hover {
    border-color: var(--gold);
    color: var(--cream);
    background: rgba(200,149,108,.08);
    transform: translateY(-2px);
}

.filter-btn.active {
    background: var(--gradient);
    color: var(--brown-900);
    border-color: transparent;
    font-weight: 600;
}

/* Gallery Container */
.gallery-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 20px;
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(320px, 1fr));
    gap: 28px;
}

/* Gallery Card */
.gallery-card {
    background: var(--bg-card);
    border-radius: var(--radius-lg);
    overflow: hidden;
    border: 1px solid rgba(200,149,108,.08);
    transition: var(--transition);
    cursor: pointer;
}

.gallery-card:hover {
    transform: translateY(-6px);
    border-color: rgba(200,149,108,.25);
    box-shadow: var(--shadow-lg);
}

.gallery-card-image {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: var(--brown-900);
}

.gallery-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease, opacity .4s ease;
    opacity: 0; /* Start with invisible */
}

/* Fade in when loaded */
.gallery-card-image img.loaded {
    opacity: 1;
}

.gallery-card:hover .gallery-card-image img {
    transform: scale(1.08);
}

.gallery-card-image .no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 3rem;
    opacity: 0.2;
}

.gallery-card-category {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 5px 12px;
    border-radius: 50px;
    font-size: .75rem;
    font-weight: 600;
    color: white;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.15);
}

.gallery-card-photo-count {
    position: absolute;
    bottom: 12px;
    right: 12px;
    padding: 5px 10px;
    border-radius: 50px;
    font-size: .75rem;
    color: white;
    background: rgba(0,0,0,.6);
    backdrop-filter: blur(10px);
}

.gallery-card-content {
    padding: 20px;
}

.gallery-card-title {
    font-family: var(--font-heading);
    font-size: 1.15rem;
    color: var(--cream);
    margin-bottom: 8px;
    line-height: 1.3;
}

.gallery-card-date {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .82rem;
    color: var(--gold);
    margin-bottom: 10px;
}

.gallery-card-desc {
    font-size: .88rem;
    color: var(--text-secondary);
    line-height: 1.6;
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* Empty State */
.gallery-empty {
    text-align: center;
    padding: 80px 20px;
    grid-column: 1 / -1;
}

.gallery-empty-icon {
    font-size: 4rem;
    margin-bottom: 20px;
    opacity: 0.3;
}

.gallery-empty h3 {
    font-family: var(--font-heading);
    font-size: 1.5rem;
    color: var(--cream);
    margin-bottom: 10px;
}

.gallery-empty p {
    color: var(--text-secondary);
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.97);
    z-index: 1000;
    align-items: center;
    justify-content: center;
}

.lightbox.active {
    display: flex;
}

.lightbox-content {
    position: relative;
    max-width: 90vw;
    max-height: 90vh;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
}

.lightbox-close {
    position: absolute;
    top: 15px;
    right: 25px;
    font-size: 2rem;
    color: rgba(255,255,255,.7);
    cursor: pointer;
    z-index: 1001;
    background: rgba(255,255,255,.1);
    border: none;
    width: 44px;
    height: 44px;
    border-radius: 50%;
    transition: var(--transition);
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-close:hover {
    background: rgba(255,255,255,.2);
    color: white;
    transform: rotate(90deg);
}

.lightbox-nav {
    position: absolute;
    top: 50%;
    transform: translateY(-50%);
    background: rgba(255,255,255,.1);
    border: 1px solid rgba(255,255,255,.15);
    color: white;
    font-size: 1.5rem;
    padding: 16px 12px;
    cursor: pointer;
    border-radius: 12px;
    transition: var(--transition);
    z-index: 1001;
}

.lightbox-nav:hover {
    background: rgba(200,149,108,.3);
    border-color: var(--gold);
}

.lightbox-prev { left: 16px; }
.lightbox-next { right: 16px; }

.lightbox-info {
    position: absolute;
    bottom: 0;
    left: 0;
    right: 0;
    padding: 30px;
    background: linear-gradient(transparent, rgba(0,0,0,.85));
    color: white;
    text-align: center;
    border-radius: 0 0 12px 12px;
}

.lightbox-title {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    margin-bottom: 5px;
}

.lightbox-counter {
    font-size: .85rem;
    color: var(--gold);
}

/* Pagination */
.gallery-pagination {
    display: flex;
    justify-content: center;
    margin-top: 60px;
    padding: 0 20px;
}

.gallery-pagination .pagination {
    display: flex;
    gap: 6px;
    align-items: center;
    flex-wrap: wrap;
    justify-content: center;
}

.gallery-pagination .page-item {
    list-style: none;
}

.gallery-pagination .page-link {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 42px;
    height: 42px;
    padding: 0 12px;
    border-radius: 10px;
    background: var(--bg-card);
    color: var(--text-secondary);
    font-weight: 500;
    text-decoration: none;
    transition: var(--transition);
    border: 1px solid rgba(200,149,108,.12);
    font-size: .9rem;
}

.gallery-pagination .page-link:hover {
    background: rgba(200,149,108,.15);
    color: var(--cream);
    border-color: var(--gold);
}

.gallery-pagination .page-item.active .page-link {
    background: var(--gradient);
    color: var(--brown-900);
    border-color: transparent;
    font-weight: 700;
}

.gallery-pagination .page-item.disabled .page-link {
    opacity: .4;
    pointer-events: none;
}

/* ============================================
   RESPONSIVE
   ============================================ */
@media (max-width: 768px) {
    .gallery-page {
        padding: 100px 0 60px;
    }

    .gallery-header h1 {
        font-size: 1.8rem;
    }

    .gallery-grid {
        grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
        gap: 20px;
    }

    .gallery-filters {
        gap: 8px;
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
        -webkit-overflow-scrolling: touch;
    }

    .filter-btn {
        flex-shrink: 0;
        padding: 7px 14px;
        font-size: .82rem;
    }

    .lightbox-prev { left: 8px; }
    .lightbox-next { right: 8px; }
    .lightbox-nav { padding: 12px 8px; font-size: 1.1rem; }
}

@media (max-width: 480px) {
    .gallery-grid {
        grid-template-columns: 1fr;
    }
}
</style>
@endsection

@section('content')
<section class="gallery-page">
    <div class="gallery-container">
        <div class="gallery-header">
            <span class="section-badge">📷 Gallery</span>
            <h1>Momen Seru di Warkop KPK</h1>
            <p>Kumpulan dokumentasi momen-momen kebersamaan — dari bukber, nobar, live music, sampai outing bareng!</p>
        </div>

        {{-- Filter Tabs --}}
        <div class="gallery-filters">
            <a href="{{ route('gallery') }}"
               class="filter-btn {{ !request()->has('category') || request()->get('category') == 'all' ? 'active' : '' }}">
                📷 Semua Momen
            </a>
            @foreach($categories as $cat)
                <a href="{{ route('gallery') }}?category={{ $cat->slug }}"
                   class="filter-btn {{ request()->get('category') == $cat->slug ? 'active' : '' }}"
                   style="{{ request()->get('category') == $cat->slug ? '' : 'border-color: ' . $cat->color . '40;' }}">
                    {{ $cat->icon }} {{ $cat->name }}
                </a>
            @endforeach
        </div>

        {{-- Gallery Grid --}}
        <div class="gallery-grid" id="galleryGrid">
            @forelse($galleries as $gallery)
                @php
                    $photoUrls = $gallery->photo_urls;
                    // If no gallery photos, use cover as fallback
                    if (empty($photoUrls) && $gallery->cover_image_url) {
                        $photoUrls = [$gallery->cover_image_url];
                    }
                    $thumbnailUrls = $gallery->thumbnail_urls;
                    // Fallback thumbnail to original if empty
                    if (empty($thumbnailUrls) && $gallery->cover_thumbnail_url) {
                        $thumbnailUrls = [$gallery->cover_thumbnail_url];
                    }
                    // Grid pakai thumbnail, lightbox pakai foto asli
                    $gridImage = !empty($thumbnailUrls) ? $thumbnailUrls[0] : ($gallery->cover_thumbnail_url ?? $gallery->cover_image_url);
                    $encodedPhotos = json_encode($photoUrls, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                    $encodedThumbs = json_encode($thumbnailUrls, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
                @endphp
                <div class="gallery-card"
                     data-photos="{{ $encodedPhotos }}"
                     data-cover="{{ $gallery->cover_image_url ?? '' }}"
                     data-title="{{ addslashes($gallery->title) }}"
                     data-thumbnails="{{ $encodedThumbs }}"
                     onclick="openLightbox(this)">
                    <div class="gallery-card-image">
                        @if($gridImage)
                            <img src="{{ $gridImage }}"
                                 alt="{{ $gallery->title }}"
                                 loading="lazy"
                                 class="lazy-thumb"
                                 onload="this.classList.add('loaded')"
                                 onerror="this.classList.add('loaded')">
                        @else
                            <div class="no-image">📷</div>
                        @endif
                        <span class="gallery-card-category"
                              style="background-color: {{ $gallery->category->color }}cc;">
                            {{ $gallery->category->icon }} {{ $gallery->category->name }}
                        </span>
                        @if($gallery->photo_count > 0)
                            <span class="gallery-card-photo-count">📷 {{ $gallery->photo_count }}</span>
                        @endif
                    </div>
                    <div class="gallery-card-content">
                        <h3 class="gallery-card-title">{{ $gallery->title }}</h3>
                        <div class="gallery-card-date">
                            📅 {{ $gallery->formatted_date }}
                        </div>
                        @if($gallery->description)
                            <p class="gallery-card-desc">{{ $gallery->description }}</p>
                        @endif
                    </div>
                </div>
            @empty
                <div class="gallery-empty">
                    <div class="gallery-empty-icon">📷</div>
                    <h3>Belum Ada Momen</h3>
                    <p>Yuk, tambahkan momen seru di warkop melalui admin panel!</p>
                </div>
            @endforelse
        </div>

        {{-- Pagination --}}
        @if($galleries->hasPages())
            <div class="gallery-pagination">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</section>

{{-- Lightbox Modal --}}
<div class="lightbox" id="lightbox" onclick="handleLightboxClick(event)">
    <button class="lightbox-close" onclick="closeLightbox()">✕</button>
    <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)">◀</button>
    <div class="lightbox-content">
        <img id="lightboxImage" src="" alt="">
    </div>
    <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)">▶</button>
    <div class="lightbox-info" id="lightboxInfo" style="display:none;">
        <div class="lightbox-title" id="lightboxTitle"></div>
        <div class="lightbox-counter" id="lightboxCounter"></div>
    </div>
</div>
@endsection

@section('extra_js')
<script>
let currentPhotos = [];
let currentIndex = 0;

function openLightbox(card) {
    const photosData = card.getAttribute('data-photos');
    let parsedPhotos = [];
    try {
        parsedPhotos = photosData ? JSON.parse(photosData) : [];
    } catch (e) {
        parsedPhotos = [];
    }

    // Fallback: use cover image if no photos
    if (parsedPhotos.length === 0) {
        const coverUrl = card.getAttribute('data-cover');
        if (coverUrl) {
            parsedPhotos = [coverUrl];
        }
    }

    currentPhotos = parsedPhotos;
    const title = card.getAttribute('data-title') || '';

    const lightbox = document.getElementById('lightbox');
    const img = document.getElementById('lightboxImage');
    const titleEl = document.getElementById('lightboxTitle');
    const counter = document.getElementById('lightboxCounter');
    const info = document.getElementById('lightboxInfo');

    if (currentPhotos.length > 0) {
        currentIndex = 0;
        img.onerror = function() {
            // If photo fails to load, try next or show placeholder
            if (currentIndex < currentPhotos.length - 1) {
                currentIndex++;
                img.src = currentPhotos[currentIndex];
            } else {
                img.src = '';
            }
        };
        img.src = currentPhotos[currentIndex];
        counter.textContent = currentPhotos.length > 1 ? (currentIndex + 1) + ' / ' + currentPhotos.length : '';
        info.style.display = 'block';
    } else if (card.querySelector('.gallery-card-image img')) {
        img.src = card.querySelector('.gallery-card-image img').src;
        info.style.display = 'none';
    }

    titleEl.textContent = title;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
    // reset
    setTimeout(() => {
        document.getElementById('lightboxImage').src = '';
    }, 300);
}

function navigateLightbox(direction) {
    if (currentPhotos.length <= 1) return;
    currentIndex = (currentIndex + direction + currentPhotos.length) % currentPhotos.length;
    document.getElementById('lightboxImage').src = currentPhotos[currentIndex];
    document.getElementById('lightboxCounter').textContent = (currentIndex + 1) + ' / ' + currentPhotos.length;
}

function handleLightboxClick(e) {
    if (e.target === document.getElementById('lightbox')) closeLightbox();
}

// Keyboard navigation
document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') navigateLightbox(-1);
    if (e.key === 'ArrowRight') navigateLightbox(1);
});
</script>
@endsection