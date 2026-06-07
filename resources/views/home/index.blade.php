@extends('layouts.app')

@section('title', 'BonImplant — ' . __('messages.hero_title_1'))
@section('meta_description', __('messages.hero_subtitle'))

@section('content')

{{-- ============================================================
     SECTION 1: HERO
     ============================================================ --}}
<section class="hero-section" id="hero">
    <div style="width:100%; display:flex; align-items:flex-start; position:relative; z-index:2; padding-left:76px; padding-top:120px;">
        <div class="hero-content animate-fade-in-up">
            <h1 class="heading-hero" style="color:white; margin-bottom:0.25rem; text-transform:uppercase;">
                {{ __('messages.hero_title_1') }}
            </h1>
            <h1 class="heading-hero" style="color:var(--color-primary); margin-bottom:0.25rem; text-transform:uppercase;">
                {{ __('messages.hero_title_2') }}
            </h1>
            <h1 class="heading-hero" style="color:white; margin-bottom:2rem; text-transform:uppercase;">
                {{ __('messages.hero_title_3') }}
            </h1>
            <p style="font-size:0.95rem; color:rgba(255,255,255,0.6); max-width:420px; line-height:1.7; margin-bottom:2.5rem;">
                {{ __('messages.hero_subtitle') }}
            </p>
            <div style="display:flex; gap:1rem; flex-wrap:wrap;">
                <a href="{{ route('products.index') }}" class="hero-btn hero-btn-primary">
                    {{ __('messages.hero_btn_products') }}
                </a>
                <a href="#contact" class="hero-btn">
                    {{ __('messages.hero_btn_contact') }}
                </a>
            </div>
        </div>
    </div>

    {{-- Hero image: bone/implant 3D render --}}
    <div class="hero-image-wrapper">
        <img src="{{ asset('images/herologo.png') }}"
             alt="Bone Implant"
             onerror="this.parentElement.style.background='linear-gradient(135deg, #0a1f30 0%, #001326 100%)'">
        {{-- Gradient overlay on left side to blend with dark --}}
        <div style="position:absolute; inset:0; background:linear-gradient(to right, var(--color-dark) 5%, transparent 45%);"></div>
    </div>

    {{-- Subtle grid overlay --}}
    <div style="position:absolute; inset:0; background-image:radial-gradient(rgba(74,194,188,0.04) 1px, transparent 1px); background-size:32px 32px; pointer-events:none;"></div>
</section>


{{-- ============================================================
     SECTION 2: ABOUT US
     ============================================================ --}}
<section class="about-section section-pad" id="about">
    <div style="display:grid; grid-template-columns:1fr 1fr; min-height:600px;">

        {{-- Left: Image --}}
        <div class="about-image-col">
            @if($aboutUs->getFirstMediaUrl('image'))
                <img src="{{ $aboutUs->getImageUrl() }}"
                     alt="{{ $aboutUs->getTranslation('title', app()->getLocale()) }}"
                     style="width:100%; height:100%; object-fit:cover;">
            @else
                {{-- Static design image from public/images --}}
                <img src="{{ asset('images/abouteuslogi.png') }}"
                     alt="Bone Implants"
                     style="width:100%; height:100%; object-fit:cover; object-position:center;">
            @endif
        </div>

        {{-- Right: Text + Stats --}}
        <div style="display:flex; flex-direction:column; justify-content:center; padding:4rem 4rem 3rem;">

            <p style="font-size:0.8rem; font-weight:800; letter-spacing:0.2em; text-transform:uppercase; color:var(--color-primary); margin-bottom:0.75rem;">
                {{ $aboutUs->getTranslation('title', app()->getLocale()) }}
            </p>

            <h2 class="heading-section" style="color:var(--color-dark); margin-bottom:1.75rem;">
                {{ $aboutUs->getTranslation('subtitle', app()->getLocale()) }}
            </h2>

            <div class="prose-light" style="margin-bottom:3rem;">
                {!! $aboutUs->getTranslation('description', app()->getLocale()) !!}
            </div>

            {{-- Stats row --}}
            <div style="display:flex; border-top:1px solid rgba(74,194,188,0.3);">
                <div class="stat-item">
                    <div class="stat-value">{{ $aboutUs->stat1_value }}</div>
                    <div class="stat-label">{{ $aboutUs->getTranslation('stat1_label', app()->getLocale()) }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $aboutUs->stat2_value }}</div>
                    <div class="stat-label">{{ $aboutUs->getTranslation('stat2_label', app()->getLocale()) }}</div>
                </div>
                <div class="stat-item">
                    <div class="stat-value">{{ $aboutUs->stat3_value }}</div>
                    <div class="stat-label">{{ $aboutUs->getTranslation('stat3_label', app()->getLocale()) }}</div>
                </div>
            </div>
        </div>
    </div>
</section>


{{-- ============================================================
     SECTION 3: PRODUCTS PREVIEW
     ============================================================ --}}
<section class="products-section section-pad" id="products">
    <div class="container-site">
        <h2 class="heading-section" style="color:var(--color-dark); text-align:center; margin-bottom:4rem;">
            {{ __('messages.products_section') }}
        </h2>

        <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1.5rem; max-width:900px; margin:0 auto;">

            {{-- Orthopedics card --}}
            @php
                $orthoCat = $categories->where('type', 'orthopedics')->first();
                $traumaCat = $categories->where('type', 'traumatology')->first();
                $instrCat  = $categories->where('type', 'instruments')->first();
            @endphp

            <a href="{{ route('products.index', ['category' => $orthoCat?->id]) }}"
               class="product-card product-card-teal">
                <div class="product-card-icon">
                    <img src="{{ asset('images/orthopedist.png') }}"
                         alt="Orthopedics"
                         style="width:140px; height:140px; object-fit:contain;"
                         onerror="this.style.display='none'">
                </div>
                <div class="product-card-name">
                    {{ $orthoCat ? $orthoCat->getTranslation('name', app()->getLocale()) : __('messages.cat_orthopedics') }}
                </div>
            </a>

            <a href="{{ route('products.index', ['category' => $traumaCat?->id]) }}"
               class="product-card product-card-dark">
                <div class="product-card-icon">
                    <img src="{{ asset('images/harmology.png') }}"
                         alt="Traumatology"
                         style="width:140px; height:140px; object-fit:contain;"
                         onerror="this.style.display='none'">
                </div>
                <div class="product-card-name">
                    {{ $traumaCat ? $traumaCat->getTranslation('name', app()->getLocale()) : __('messages.cat_traumatology') }}
                </div>
            </a>

            <a href="{{ route('products.index', ['category' => $instrCat?->id]) }}"
               class="product-card product-card-dark">
                <div class="product-card-icon">
                    <img src="{{ asset('images/tools.png') }}"
                         alt="Instruments"
                         style="width:140px; height:140px; object-fit:contain;"
                         onerror="this.style.display='none'">
                </div>
                <div class="product-card-name">
                    {{ $instrCat ? $instrCat->getTranslation('name', app()->getLocale()) : __('messages.cat_instruments') }}
                </div>
            </a>
        </div>
    </div>
</section>


{{-- ============================================================
     SECTION 4: NEWS SLIDER
     ============================================================ --}}
<section class="news-section section-pad" id="news">
    <div class="container-site">
        {{-- Header row --}}
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:2.5rem;">
            <h2 class="heading-section" style="color:var(--color-primary);">
                {{ __('messages.news_section') }}
            </h2>
            <div style="display:flex; gap:0.75rem;" id="news-nav">
                <button class="slider-btn" id="news-prev" aria-label="Previous">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M15 18l-6-6 6-6"/>
                    </svg>
                </button>
                <button class="slider-btn" id="news-next" aria-label="Next">
                    <svg width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2">
                        <path d="M9 18l6-6-6-6"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Slider track --}}
        <div class="news-slider-track" id="news-slider">
            @forelse($news as $item)
                <a href="{{ route('news.show', $item->slug) }}" class="news-card" style="text-decoration:none;">
                    <img class="news-card-img"
                         src="{{ $item->getMainImageUrl() }}"
                         alt="{{ $item->getTranslation('title', app()->getLocale()) }}"
                         onerror="this.style.background='linear-gradient(135deg, #e8f0f2, #d0e4e8)'">
                    <div class="news-card-body">
                        <h3 class="news-card-title">
                            {{ $item->getTranslation('title', app()->getLocale()) }}
                        </h3>
                        <p class="news-card-desc">
                            {{ strip_tags($item->getTranslation('short_description', app()->getLocale())) }}
                        </p>
                    </div>
                </a>
            @empty
                <p style="color:rgba(255,255,255,0.4); font-size:0.9rem;">{{ __('No news yet.') }}</p>
            @endforelse
        </div>

        {{-- Progress bar --}}
        <div style="margin-top:1.5rem; display:grid; grid-template-columns:1fr 1fr; gap:1rem;">
            <div class="slider-progress-bar">
                <div class="slider-progress-fill" id="news-progress" style="width:33%"></div>
            </div>
            <div class="slider-progress-bar"></div>
        </div>
    </div>
</section>


{{-- ============================================================
     SECTION 5: CONTACT FORM
     ============================================================ --}}
<section class="contact-section section-pad" id="contact">
    <div class="container-site" style="max-width:900px;">
        <h2 class="heading-section" style="color:var(--color-primary); margin-bottom:3rem;">
            {{ __('messages.contact_section') }}
        </h2>

        @if(session('success'))
            <div style="background:rgba(74,194,188,0.15); border:1px solid var(--color-primary); border-radius:0.375rem; padding:1rem 1.25rem; margin-bottom:1.5rem; color:var(--color-primary); font-size:0.9rem;">
                ✓ {{ session('success') }}
            </div>
        @endif

        <form method="POST" action="{{ route('contact.store') }}">
            @csrf
            <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.25rem; margin-bottom:1.25rem;">
                <div>
                    <label class="contact-label" for="contact-name">{{ __('messages.contact_name') }}</label>
                    <input type="text" id="contact-name" name="name" class="contact-input"
                           value="{{ old('name') }}" required>
                    @error('name')
                        <p style="color:#f87171; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p>
                    @enderror
                </div>
                <div>
                    <label class="contact-label" for="contact-phone">{{ __('messages.contact_phone') }}</label>
                    <input type="tel" id="contact-phone" name="phone" class="contact-input"
                           value="{{ old('phone') }}">
                </div>
            </div>

            <div style="margin-bottom:1.25rem;">
                <label class="contact-label" for="contact-email">{{ __('messages.contact_email') }}</label>
                <input type="email" id="contact-email" name="email" class="contact-input"
                       value="{{ old('email') }}">
            </div>

            <div style="margin-bottom:2rem;">
                <label class="contact-label" for="contact-message">{{ __('messages.contact_message') }}</label>
                <textarea id="contact-message" name="message" class="contact-input"
                          rows="6" required>{{ old('message') }}</textarea>
                @error('message')
                    <p style="color:#f87171; font-size:0.75rem; margin-top:0.25rem;">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit" class="contact-btn" id="contact-submit">
                {{ __('messages.contact_send') }}
            </button>
        </form>
    </div>
</section>

@endsection

@push('scripts')
<script>
(function() {
    const slider  = document.getElementById('news-slider');
    const btnPrev = document.getElementById('news-prev');
    const btnNext = document.getElementById('news-next');
    const progress = document.getElementById('news-progress');

    if (!slider) return;

    const cardWidth = () => slider.querySelector('.news-card')?.offsetWidth + 20 || 320;
    const maxScroll  = () => slider.scrollWidth - slider.clientWidth;

    const updateProgress = () => {
        const pct = maxScroll() > 0 ? (slider.scrollLeft / maxScroll()) * 100 : 0;
        if (progress) progress.style.width = Math.min(100, Math.max(5, pct)) + '%';
    };

    btnNext?.addEventListener('click', () => {
        slider.scrollBy({ left: cardWidth(), behavior: 'smooth' });
    });
    btnPrev?.addEventListener('click', () => {
        slider.scrollBy({ left: -cardWidth(), behavior: 'smooth' });
    });
    slider.addEventListener('scroll', updateProgress);

    // Drag to scroll
    let isDragging = false, startX = 0, scrollLeft = 0;
    slider.addEventListener('mousedown', e => {
        isDragging = true;
        slider.classList.add('dragging');
        startX = e.pageX - slider.offsetLeft;
        scrollLeft = slider.scrollLeft;
    });
    document.addEventListener('mouseup', () => {
        isDragging = false;
        slider.classList.remove('dragging');
    });
    slider.addEventListener('mousemove', e => {
        if (!isDragging) return;
        e.preventDefault();
        const x = e.pageX - slider.offsetLeft;
        slider.scrollLeft = scrollLeft - (x - startX);
    });

    updateProgress();
})();
</script>
@endpush
