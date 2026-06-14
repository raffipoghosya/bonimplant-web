@extends('layouts.app')

@section('title', $product->getTranslation('title', app()->getLocale()) . ' — BonImplant')

@section('content')

<div style="display:flex; min-height:calc(100vh - 72px);"
     x-data="{
         openCategory: true,
         openBodyParts: true,
     }">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" style="width:240px; flex-shrink:0; padding:1.25rem 1rem; overflow-y:auto;">

        {{-- Search --}}
        <form method="GET" action="{{ route('products.index') }}" style="position:relative; margin-bottom:1rem;">
            <svg style="position:absolute; left:0.625rem; top:50%; transform:translateY(-50%); width:14px; height:14px; color:var(--color-primary); opacity:0.5;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
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
        <div style="margin-top:0.25rem;">
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
                    @include('components.skeleton-body', ['skeletonParts' => $skeletonParts])
                </div>
                <div style="margin-top:0.25rem;">
                    @foreach($bodyParts as $bodyPart)
                        <label class="sidebar-checkbox-item">
                            <input type="checkbox"
                                   onchange="window.location.href='{{ route('products.index', ['body_part' => $bodyPart->id]) }}'"
                                   {{ $product->bodyParts->contains($bodyPart->id) ? 'checked' : '' }}>
                            {{ $bodyPart->getTranslation('name', app()->getLocale()) }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="product-detail-main" x-data="{ activeImg: '{{ $product->getPrimaryImageUrl() }}' }">

        {{-- Page header --}}
        <h1 class="product-detail-page-title">
            {{ __('messages.product_detail_title') }}
        </h1>

        {{-- Gallery: main image left + thumbnails right --}}
        <div class="product-detail-gallery">
            <img :src="activeImg"
                 alt="{{ $product->getTranslation('title', app()->getLocale()) }}"
                 class="product-gallery-main">

            @if($gallery->count() > 0)
                <div class="product-gallery-thumbs-wrap">
                    <button class="product-gallery-nav" onclick="scrollThumbs(-1)">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M15.75 19.5l-7.5-7.5 7.5-7.5"/>
                        </svg>
                    </button>

                    <div id="thumb-strip" class="product-gallery-thumbs">
                        <img src="{{ $product->getPrimaryThumbUrl() }}"
                             class="product-gallery-thumb active"
                             @click="activeImg = '{{ $product->getPrimaryImageUrl() }}'"
                             alt="Primary">

                        @foreach($gallery as $media)
                            <img src="{{ $media->getUrl('thumb') }}"
                                 class="product-gallery-thumb"
                                 @click="activeImg = '{{ $media->getUrl('large') }}'"
                                 alt="Gallery image">
                        @endforeach
                    </div>

                    <button class="product-gallery-nav" onclick="scrollThumbs(1)">
                        <svg width="12" height="12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                            <path stroke-linecap="round" d="M8.25 4.5l7.5 7.5-7.5 7.5"/>
                        </svg>
                    </button>
                </div>
            @endif
        </div>

        {{-- Product info below gallery --}}
        <div class="product-detail-info">
            <h2 class="product-detail-title">
                {{ $product->getTranslation('title', app()->getLocale()) }}
            </h2>

            <div class="product-detail-desc">
                {!! $product->getTranslation('description', app()->getLocale()) !!}
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function scrollThumbs(dir) {
    const strip = document.getElementById('thumb-strip');
    if (strip) strip.scrollLeft += dir * 120;
}
</script>
@endpush
