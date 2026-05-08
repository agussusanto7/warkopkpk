@extends('layouts.app')
@section('title', 'Gallery - Warkop KPK')
@section('meta_description', 'Gallery momen seru di Warkop KPK - Bukber, Nobar, Live Music, dan masih banyak lagi!')

@section('extra_css')
<style>
/* ============================================
   GALLERY PAGE - Modern Light Theme
   ============================================ */
.gallery-page {
    padding: 120px 0 80px;
    min-height: 100vh;
    background: var(--bg-primary);
}

.gallery-header {
    text-align: center;
    margin-bottom: 50px;
    padding: 0 20px;
}

.gallery-header h1 {
    font-family: var(--font-heading);
    font-size: clamp(2rem, 5vw, 3rem);
    font-weight: 700;
    color: var(--brown-900);
    margin-bottom: 14px;
}

.gallery-header p {
    font-size: 1rem;
    color: var(--text-secondary);
    max-width: 580px;
    margin: 0 auto;
    line-height: 1.7;
}

/* Gallery Filter Tabs */
.gallery-filters {
    display: flex;
    justify-content: center;
    flex-wrap: wrap;
    gap: 8px;
    margin-bottom: 40px;
    padding: 0 4px;
}

/* Filter Buttons */
.gallery-filters .filter-btn,
.gallery-page .filter-btn {
    padding: 8px 18px;
    border: 1.5px solid var(--border);
    background: transparent;
    color: var(--text-secondary);
    border-radius: var(--radius-full);
    cursor: pointer;
    font-size: .85rem;
    font-weight: 500;
    font-family: var(--font-body);
    transition: var(--transition);
}
.gallery-filters .filter-btn:hover,
.gallery-page .filter-btn:hover {
    border-color: var(--gold);
    color: var(--gold);
}
.gallery-filters .filter-btn.active,
.gallery-page .filter-btn.active {
    background: linear-gradient(135deg, var(--gold), var(--gold-light));
    color: #fff;
    border-color: transparent;
    font-weight: 600;
    box-shadow: 0 2px 10px rgba(184,137,46,.25);
}

/* Gallery Container */
.gallery-container {
    max-width: 1200px;
    margin: 0 auto;
    padding: 0 24px;
}

/* Gallery Grid */
.gallery-grid {
    display: grid;
    grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
    gap: 24px;
}

/* Gallery Card */
.gallery-card {
    background: var(--bg-card);
    border-radius: var(--radius);
    overflow: hidden;
    border: 1px solid var(--border-light);
    transition: var(--transition);
    cursor: pointer;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    box-shadow: var(--shadow-sm);
}

.gallery-card:hover {
    transform: translateY(-6px);
    border-color: rgba(184,137,46,.2);
    box-shadow: var(--shadow-lg);
}

.gallery-card:active {
    transform: scale(0.98);
}

.gallery-card-image {
    position: relative;
    aspect-ratio: 4/3;
    overflow: hidden;
    background: var(--brown-100);
}

.gallery-card-image img {
    width: 100%;
    height: 100%;
    object-fit: cover;
    transition: transform .5s ease, opacity .4s ease;
    opacity: 0;
}

.gallery-card-image img.loaded {
    opacity: 1;
}

.gallery-card:hover .gallery-card-image img {
    transform: scale(1.06);
}

.gallery-card-image .no-image {
    width: 100%;
    height: 100%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2.5rem;
    opacity: 0.15;
}

.gallery-card-category {
    position: absolute;
    top: 12px;
    left: 12px;
    padding: 5px 12px;
    border-radius: var(--radius-full);
    font-size: .72rem;
    font-weight: 600;
    color: #fff;
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255,255,255,.2);
}

.gallery-card-photo-count {
    position: absolute;
    bottom: 12px;
    right: 12px;
    padding: 4px 10px;
    border-radius: var(--radius-full);
    font-size: .72rem;
    color: #fff;
    background: rgba(0,0,0,.55);
    backdrop-filter: blur(8px);
    display: flex;
    align-items: center;
    gap: 4px;
}

.gallery-card-content {
    padding: 18px 20px;
}

.gallery-card-title {
    font-family: var(--font-heading);
    font-size: 1.1rem;
    color: var(--brown-800);
    margin-bottom: 6px;
    line-height: 1.3;
}

.gallery-card-date {
    display: flex;
    align-items: center;
    gap: 5px;
    font-size: .8rem;
    color: var(--gold);
    margin-bottom: 8px;
    font-weight: 500;
}

.gallery-card-desc {
    font-size: .85rem;
    color: var(--text-muted);
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
    font-size: 3.5rem;
    margin-bottom: 18px;
    opacity: 0.2;
}

.gallery-empty h3 {
    font-family: var(--font-heading);
    font-size: 1.4rem;
    color: var(--brown-800);
    margin-bottom: 10px;
}

.gallery-empty p {
    color: var(--text-muted);
    font-size: .9rem;
}

/* Lightbox */
.lightbox {
    display: none;
    position: fixed;
    inset: 0;
    background: rgba(0,0,0,.95);
    z-index: 2000;
    align-items: center;
    justify-content: center;
}

.lightbox.active {
    display: flex;
}

.lightbox-content {
    position: relative;
    max-width: 95vw;
    max-height: 95vh;
    display: flex;
    align-items: center;
    justify-content: center;
}

.lightbox-content img {
    max-width: 100%;
    max-height: 85vh;
    object-fit: contain;
    border-radius: 12px;
    box-shadow: 0 20px 60px rgba(0,0,0,.5);
    transition: opacity .3s ease;
}

.lightbox-content img.loading {
    opacity: 0.3;
}

.lightbox-content img.loaded {
    opacity: 1;
}

.lightbox-close {
    position: absolute;
    top: 15px;
    right: 25px;
    font-size: 1.5rem;
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
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    line-height: 1;
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
    font-size: 1.4rem;
    padding: 16px 14px;
    cursor: pointer;
    border-radius: 12px;
    transition: var(--transition);
    z-index: 1001;
    -webkit-tap-highlight-color: transparent;
    touch-action: manipulation;
    user-select: none;
    line-height: 1;
}

.lightbox-nav:hover {
    background: rgba(184,137,46,.35);
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
    font-size: .82rem;
    color: var(--gold-light);
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
    border-radius: var(--radius-sm);
    background: var(--bg-card);
    color: var(--text-secondary);
    font-weight: 500;
    text-decoration: none;
    transition: var(--transition);
    border: 1px solid var(--border-light);
    font-size: .9rem;
}

.gallery-pagination .page-link:hover {
    background: rgba(184,137,46,.1);
    color: var(--brown-800);
    border-color: rgba(184,137,46,.2);
}

.gallery-pagination .page-item.active .page-link {
    background: linear-gradient(135deg,var(--gold),var(--gold-light));
    color: #fff;
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
    .gallery-page { padding: 100px 0 60px; }
    .gallery-header h1 { font-size: 1.8rem; }
    .gallery-grid { grid-template-columns: 1fr 1fr; gap: 16px; }
    .gallery-filters {
        gap: 8px;
        justify-content: flex-start;
        overflow-x: auto;
        flex-wrap: nowrap;
        padding-bottom: 10px;
        -webkit-overflow-scrolling: touch;
        scrollbar-width: none;
    }
    .gallery-filters::-webkit-scrollbar { display: none; }
    .filter-btn { flex-shrink: 0; padding: 7px 14px; font-size: .82rem; }
    .lightbox-prev { left: 8px; }
    .lightbox-next { right: 8px; }
    .lightbox-nav { padding: 12px 8px; font-size: 1.1rem; }
}

@media (max-width: 480px) {
    .gallery-grid { grid-template-columns: 1fr; gap: 14px; }
    .gallery-card-content { padding: 14px 16px; }
}
.gallery-filters .filter-btn { flex-shrink: 0 }
</style>
@endsection

@section('content')
<section class="gallery-page">
    <div class="gallery-container">
        <div class="gallery-header">
            <span class="section-badge">Gallery</span>
            <h1>Momen Seru di <span class="text-gradient">Warkop KPK</span></h1>
            <p>Kumpulan dokumentasi momen-momen kebersamaan — dari bukber, nobar, live music, sampai outing bareng!</p>
        </div>

        {{-- Filter Tabs (server-side rendered for reliability) --}}
        <div class="gallery-filters" id="galleryFilters">
            <button class="filter-btn active" data-filter="all" onclick="loadGallery(null, null)">📷 Semua</button>
            @forelse($categories as $cat)
                <button class="filter-btn" data-filter="{{ $cat->slug }}"
                    style="border-color: {{ $cat->color }}60;"
                    onclick="loadGallery('{{ $cat->slug }}', null)">
                    {{ $cat->icon }} {{ $cat->name }}
                </button>
            @empty
            @endforelse
        </div>

        {{-- Loading Indicator --}}
        <div id="galleryLoader" style="display:none;text-align:center;padding:40px;">
            <div style="display:inline-block;width:40px;height:40px;border:4px solid rgba(184,137,46,.15);border-top-color:var(--gold);border-radius:50%;animation:spin 1s linear infinite;"></div>
            <p style="color:var(--text-muted);margin-top:15px;font-size:.9rem;">Memuat gallery...</p>
        </div>

        {{-- Gallery Grid (AJAX loaded) --}}
        <div class="gallery-grid" id="galleryGrid">
            @forelse($galleries as $gallery)
                @php
                    $photoUrls = $gallery->photo_urls;
                    if (empty($photoUrls) && $gallery->cover_image_url) {
                        $photoUrls = [$gallery->cover_image_url];
                    }
                    $thumbnailUrls = $gallery->thumbnail_urls;
                    if (empty($thumbnailUrls) && $gallery->cover_thumbnail_url) {
                        $thumbnailUrls = [$gallery->cover_thumbnail_url];
                    }
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
                              style="background-color: {{ $gallery->category->color }}dd;">
                            {{ $gallery->category->icon }} {{ $gallery->category->name }}
                        </span>
                        @if($gallery->photo_count > 0)
                            <span class="gallery-card-photo-count">
                                <svg width="10" height="10" viewBox="0 0 24 24" fill="currentColor"><path d="M14.5 4h-5L7 7H4a2 2 0 00-2 2v9a2 2 0 002 2h16a2 2 0 002-2V9a2 2 0 00-2-2h-3l-1.5-3z"/></svg>
                                {{ $gallery->photo_count }}
                            </span>
                        @endif
                    </div>
                    <div class="gallery-card-content">
                        <h3 class="gallery-card-title">{{ $gallery->title }}</h3>
                        <div class="gallery-card-date">
                            <svg width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><rect x="3" y="4" width="18" height="18" rx="2" ry="2"/><line x1="16" y1="2" x2="16" y2="6"/><line x1="8" y1="2" x2="8" y2="6"/><line x1="3" y1="10" x2="21" y2="10"/></svg>
                            {{ $gallery->formatted_date }}
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

        @if($galleries->hasPages())
            <div class="gallery-pagination" id="galleryPagination">
                {{ $galleries->links() }}
            </div>
        @endif
    </div>
</section>

{{-- Lightbox Modal --}}
<div class="lightbox" id="lightbox" onclick="handleLightboxClick(event)">
    <button class="lightbox-close" onclick="closeLightbox()">✕</button>
    <button class="lightbox-nav lightbox-prev" onclick="navigateLightbox(-1)">‹</button>
    <div class="lightbox-content">
        <img id="lightboxImage" src="" alt="">
        <div id="lightboxLoader" style="display:none;position:absolute;top:50%;left:50%;transform:translate(-50%,-50%);z-index:10;">
            <div style="width:40px;height:40px;border:3px solid rgba(255,255,255,.15);border-top-color:#fff;border-radius:50%;animation:lightboxSpin .8s linear infinite;"></div>
        </div>
    </div>
    <button class="lightbox-nav lightbox-next" onclick="navigateLightbox(1)">›</button>
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

function showLightboxLoader(show) {
    const loader = document.getElementById('lightboxLoader');
    const img = document.getElementById('lightboxImage');
    if (show) {
        loader.style.display = 'block';
        img.classList.remove('loaded');
        img.classList.add('loading');
    } else {
        loader.style.display = 'none';
        img.classList.remove('loading');
        img.classList.add('loaded');
    }
}

function openLightbox(card) {
    const photosData = card.getAttribute('data-photos');
    let parsedPhotos = [];
    try {
        parsedPhotos = photosData ? JSON.parse(photosData) : [];
    } catch (e) { parsedPhotos = []; }

    if (parsedPhotos.length === 0) {
        const coverUrl = card.getAttribute('data-cover');
        if (coverUrl) parsedPhotos = [coverUrl];
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
        showLightboxLoader(true);
        img.onload = function() { showLightboxLoader(false); };
        img.onerror = function() {
            showLightboxLoader(false);
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
        showLightboxLoader(false);
        info.style.display = 'none';
    }

    titleEl.textContent = title;
    lightbox.classList.add('active');
    document.body.style.overflow = 'hidden';
}

function closeLightbox() {
    document.getElementById('lightbox').classList.remove('active');
    document.body.style.overflow = '';
    showLightboxLoader(false);
    setTimeout(() => {
        document.getElementById('lightboxImage').src = '';
    }, 300);
}

function navigateLightbox(direction) {
    if (currentPhotos.length <= 1) return;
    showLightboxLoader(true);
    currentIndex = (currentIndex + direction + currentPhotos.length) % currentPhotos.length;
    const img = document.getElementById('lightboxImage');
    img.onload = function() {
        showLightboxLoader(false);
        document.getElementById('lightboxCounter').textContent = (currentIndex + 1) + ' / ' + currentPhotos.length;
    };
    img.onerror = function() { showLightboxLoader(false); };
    img.src = currentPhotos[currentIndex];
    document.getElementById('lightboxCounter').textContent = (currentIndex + 1) + ' / ' + currentPhotos.length;
}

function handleLightboxClick(e) {
    if (e.target === document.getElementById('lightbox')) closeLightbox();
}

document.addEventListener('keydown', function(e) {
    const lightbox = document.getElementById('lightbox');
    if (!lightbox.classList.contains('active')) return;
    if (e.key === 'Escape') closeLightbox();
    if (e.key === 'ArrowLeft') navigateLightbox(-1);
    if (e.key === 'ArrowRight') navigateLightbox(1);
});

const lightboxStyle = document.createElement('style');
lightboxStyle.textContent = `
    @keyframes lightboxSpin {
        0% { transform: translate(-50%, -50%) rotate(0deg); }
        100% { transform: translate(-50%, -50%) rotate(360deg); }
    }
    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
`;
document.head.appendChild(lightboxStyle);

let currentCategory = null;
let isLoading = false;

function initGallery() {
    // Filters sudah dirender server-side via Blade, tidak perlu fetch dari API
}

initGallery();

function loadGallery(category, page) {
    if (isLoading) return;
    isLoading = true;
    currentCategory = category;

    // Update active filter button using data-filter attribute
    document.querySelectorAll('.gallery-filters .filter-btn').forEach(function(btn) {
        var btnFilter = btn.getAttribute('data-filter');
        if ((category === null || category === 'all') && btnFilter === 'all') {
            btn.classList.add('active');
        } else if (btnFilter === category) {
            btn.classList.add('active');
        } else {
            btn.classList.remove('active');
        }
    });

    var loader = document.getElementById('galleryLoader');
    var grid = document.getElementById('galleryGrid');
    var pagination = document.getElementById('galleryPagination');

    loader.style.display = 'block';
    grid.style.opacity = '0.5';
    grid.style.pointerEvents = 'none';

    var url = '/api/gallery';
    var params = [];
    if (category) params.push('category=' + category);
    if (page) params.push('page=' + page);
    if (params.length > 0) url += '?' + params.join('&');

    fetch(url)
    .then(function(response) { return response.json(); })
    .then(function(data) {
        grid.innerHTML = data.html;
        grid.style.opacity = '1';
        grid.style.pointerEvents = 'auto';
        loader.style.display = 'none';

        if (data.hasMore && pagination) {
            pagination.style.display = 'flex';
        }

        grid.querySelectorAll('img').forEach(function(img) {
            img.addEventListener('load', function() { img.classList.add('loaded'); });
            img.addEventListener('error', function() { img.classList.add('loaded'); });
        });

        isLoading = false;
    })
    .catch(function(error) {
        console.error('Error loading gallery:', error);
        loader.style.display = 'none';
        grid.style.opacity = '1';
        grid.style.pointerEvents = 'auto';
        isLoading = false;
    });
}

document.addEventListener('click', function(e) {
    var paginationLink = e.target.closest('.gallery-pagination a');
    if (paginationLink && document.getElementById('galleryGrid')) {
        e.preventDefault();
        var url = paginationLink.getAttribute('href');
        var urlObj = new URL(url, window.location.origin);
        var page = urlObj.searchParams.get('page');
        loadGallery(currentCategory, page);
    }
});
</script>
@endsection