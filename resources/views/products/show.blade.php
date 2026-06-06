@extends('layouts.app')

@section('title', $product->getTranslation('title', app()->getLocale()) . ' — BonImplant')

@section('content')

<div style="display:flex; min-height:calc(100vh - 72px);">

    {{-- ===== SIDEBAR (same as products index) ===== --}}
    <aside class="sidebar" style="width:240px; flex-shrink:0; padding:1.25rem 1rem; overflow-y:auto;"
           x-data="{ openCategory: true, openBodyParts: true }">

        {{-- Search --}}
        <form method="GET" action="{{ route('products.index') }}" style="position:relative; margin-bottom:1rem;">
            <svg style="position:absolute; left:0.625rem; top:50%; transform:translateY(-50%); width:14px; height:14px; color:rgba(255,255,255,0.35);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 0z"/>
            </svg>
            <input type="text" name="search" placeholder="{{ __('messages.sidebar_search') }}" class="sidebar-search">
        </form>

        {{-- Category Accordion --}}
        <div>
            <div class="sidebar-section-title" @click="openCategory = !openCategory">
                <span>{{ __('messages.sidebar_category') }}</span>
                <svg :class="openCategory ? 'rotate-180' : ''"
                     style="width:14px; height:14px; transition:transform 0.2s;"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </div>
            <div x-show="openCategory" x-collapse style="padding:0.5rem 0;">
                @foreach($categories as $category)
                    <label class="sidebar-checkbox-item">
                        <input type="checkbox"
                               onchange="window.location.href='{{ route('products.index', ['category' => $category->id]) }}'">
                        {{ $category->getTranslation('name', app()->getLocale()) }}
                    </label>
                    @foreach($category->children as $child)
                        <label class="sidebar-checkbox-item" style="padding-left:1.25rem;">
                            <input type="checkbox"
                                   onchange="window.location.href='{{ route('products.index', ['category' => $child->id]) }}'">
                            {{ $child->getTranslation('name', app()->getLocale()) }}
                        </label>
                    @endforeach
                @endforeach
            </div>
        </div>

        {{-- Body Parts Accordion --}}
        <div style="margin-top:0.5rem;">
            <div class="sidebar-section-title" @click="openBodyParts = !openBodyParts">
                <span>{{ __('messages.sidebar_body_parts') }}</span>
                <svg :class="openBodyParts ? 'rotate-180' : ''"
                     style="width:14px; height:14px; transition:transform 0.2s;"
                     fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5"/>
                </svg>
            </div>
            <div x-show="openBodyParts" x-collapse>
                <div style="padding:1rem 0;">
                    @include('components.skeleton-body', ['activeZone' => $product->bodyPart?->skeleton_zone])
                </div>
                @foreach($bodyParts as $bodyPart)
                    <label class="sidebar-checkbox-item">
                        <input type="checkbox"
                               onchange="window.location.href='{{ route('products.index', ['body_part' => $bodyPart->id]) }}'"
                               {{ $product->body_part_id == $bodyPart->id ? 'checked' : '' }}>
                        {{ $bodyPart->getTranslation('name', app()->getLocale()) }}
                    </label>
                @endforeach
            </div>
        </div>

    </aside>

    {{-- ===== MAIN PRODUCT DETAIL ===== --}}
    <div class="products-main" style="flex:1; padding:2.5rem 3rem; overflow-y:auto;">

        <h1 class="heading-section" style="color:white; text-align:center; font-size:1.75rem; margin-bottom:2rem;">
            {{ __('messages.product_detail_title') }}
        </h1>

        {{-- Gallery --}}
        <div x-data="{ activeImg: '{{ $product->getPrimaryImageUrl() }}' }"
             style="margin-bottom:2.5rem;">

            <div style="display:flex; gap:1.5rem; align-items:flex-start; flex-wrap:wrap;">

                {{-- Main Image --}}
                <div style="flex:1; min-width:280px;">
                    <img :src="activeImg"
                         alt="{{ $product->getTranslation('title', app()->getLocale()) }}"
                         class="product-gallery-main"
                         onerror="this.style.background='#0a1f30'">
                </div>

                {{-- Thumbnail strip --}}
                @if($gallery->count() > 0)
                    <div style="display:flex; flex-direction:column; gap:0.5rem; align-items:center;">
                        {{-- Prev arrow --}}
                        <button onclick="scrollThumbs(-1)" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:50%; width:32px; height:32px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:white;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" d="M19.5 15.75l-7.5-7.5-7.5 7.5"/>
                            </svg>
                        </button>

                        <div id="thumb-strip" style="overflow:hidden; max-height:250px; display:flex; flex-direction:column; gap:0.5rem;">
                            {{-- Primary image thumb --}}
                            <img src="{{ $product->getPrimaryThumbUrl() }}"
                                 class="product-gallery-thumb active"
                                 @click="activeImg = '{{ $product->getPrimaryImageUrl() }}'"
                                 alt="Primary">

                            {{-- Gallery thumbs --}}
                            @foreach($gallery as $media)
                                <img src="{{ $media->getUrl('thumb') }}"
                                     class="product-gallery-thumb"
                                     @click="activeImg = '{{ $media->getUrl('large') }}'"
                                     alt="Gallery image">
                            @endforeach
                        </div>

                        {{-- Next arrow --}}
                        <button onclick="scrollThumbs(1)" style="background:rgba(255,255,255,0.1); border:1px solid rgba(255,255,255,0.15); border-radius:50%; width:32px; height:32px; cursor:pointer; display:flex; align-items:center; justify-content:center; color:white;">
                            <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                                <path stroke-linecap="round" d="M4.5 8.25l7.5 7.5 7.5-7.5"/>
                            </svg>
                        </button>
                    </div>
                @endif
            </div>
        </div>

        {{-- Product info --}}
        <h2 class="heading-section" style="font-size:1.5rem; color:white; margin-bottom:1rem;">
            {{ $product->getTranslation('title', app()->getLocale()) }}
        </h2>

        @if($product->category)
            <p style="font-size:0.75rem; color:var(--color-primary); font-weight:700; letter-spacing:0.1em; text-transform:uppercase; margin-bottom:1.5rem;">
                {{ $product->category->getTranslation('name', app()->getLocale()) }}
                @if($product->bodyPart)
                    · {{ $product->bodyPart->getTranslation('name', app()->getLocale()) }}
                @endif
            </p>
        @endif

        <div class="prose-dark">
            {!! $product->getTranslation('description', app()->getLocale()) !!}
        </div>

        <div style="margin-top:2rem; display:flex; gap:1rem;">
            <a href="{{ route('products.index') }}" style="font-size:0.8rem; color:rgba(255,255,255,0.4); text-decoration:none; display:flex; align-items:center; gap:0.35rem;">
                <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
                </svg>
                {{ __('Back to products') }}
            </a>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function scrollThumbs(dir) {
    const strip = document.getElementById('thumb-strip');
    if (strip) strip.scrollTop += dir * 90;
}
</script>
@endpush
