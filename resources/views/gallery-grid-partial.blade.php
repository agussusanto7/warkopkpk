{{-- Gallery Grid Partial (untuk AJAX loading) --}}
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

{{-- Pagination (di-load bersamaan) --}}
@if($galleries->hasPages())
    <div class="gallery-pagination" style="grid-column: 1 / -1;">
        {{ $galleries->links() }}
    </div>
@endif
