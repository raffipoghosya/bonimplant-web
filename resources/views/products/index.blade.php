@extends('layouts.app')

@section('title', __('messages.products_page_title') . ' — BonImplant')

@section('content')

<div style="display:flex; min-height:calc(100vh - 72px);"
     x-data="{
         openCategory: true,
         openBodyParts: true,
         openBrand: false,
         activeZone: '{{ request('zone') }}',
         handleZone(zone) {
             this.activeZone = this.activeZone === zone ? null : zone;
             const url = new URL(window.location.href);
             if (this.activeZone) {
                 url.searchParams.set('zone', this.activeZone);
             } else {
                 url.searchParams.delete('zone');
             }
             window.location.href = url.toString();
         }
     }"
     @zone-clicked.window="handleZone($event.detail)">

    {{-- ===== SIDEBAR ===== --}}
    <aside class="sidebar" style="width:240px; flex-shrink:0; padding:1.25rem 1rem; overflow-y:auto;">

        {{-- Search --}}
        <form method="GET" action="{{ route('products.index') }}" style="position:relative; margin-bottom:1rem;">
            <svg style="position:absolute; left:0.625rem; top:50%; transform:translateY(-50%); width:14px; height:14px; color:rgba(255,255,255,0.35);" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 0z"/>
            </svg>
            <input type="text" name="search"
                   value="{{ request('search') }}"
                   placeholder="{{ __('messages.sidebar_search') }}"
                   class="sidebar-search">
            @if(request('category'))
                <input type="hidden" name="category" value="{{ request('category') }}">
            @endif
        </form>

        {{-- Active filter chips --}}
        @if(request('category') || request('body_part') || request('zone'))
            <div style="display:flex; flex-wrap:wrap; gap:0.35rem; margin-bottom:1rem;">
                @if($selectedCategory)
                    <a href="{{ route('products.index', array_merge(request()->except(['category']), [])) }}"
                       class="active-filter-chip">
                        {{ $selectedCategory->getTranslation('name', app()->getLocale()) }} ×
                    </a>
                @endif
                @if($selectedBodyPart)
                    <a href="{{ route('products.index', array_merge(request()->except(['body_part']), [])) }}"
                       class="active-filter-chip">
                        {{ $selectedBodyPart->getTranslation('name', app()->getLocale()) }} ×
                    </a>
                @endif
            </div>
        @endif

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
                               onchange="window.location.href='{{ route('products.index', array_merge(request()->all(), ['category' => $category->id])) }}'"
                               {{ request('category') == $category->id ? 'checked' : '' }}>
                        {{ $category->getTranslation('name', app()->getLocale()) }}
                    </label>

                    {{-- Sub-categories --}}
                    @foreach($category->children as $child)
                        <label class="sidebar-checkbox-item" style="padding-left:1.25rem;">
                            <input type="checkbox"
                                   onchange="window.location.href='{{ route('products.index', array_merge(request()->all(), ['category' => $child->id])) }}'"
                                   {{ request('category') == $child->id ? 'checked' : '' }}>
                            {{ $child->getTranslation('name', app()->getLocale()) }}
                        </label>
                    @endforeach
                @endforeach
            </div>
        </div>

        {{-- Body Parts Accordion with Skeleton --}}
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
                {{-- Interactive Skeleton --}}
                <div style="padding:1rem 0;">
                    @include('components.skeleton-body', ['activeZone' => request('zone')])
                </div>

                {{-- Body Part checkboxes --}}
                <div style="margin-top:0.5rem;">
                    @foreach($bodyParts as $bodyPart)
                        <label class="sidebar-checkbox-item">
                            <input type="checkbox"
                                   onchange="window.location.href='{{ route('products.index', array_merge(request()->all(), ['body_part' => $bodyPart->id])) }}'"
                                   {{ request('body_part') == $bodyPart->id ? 'checked' : '' }}>
                            {{ $bodyPart->getTranslation('name', app()->getLocale()) }}
                        </label>
                    @endforeach
                </div>
            </div>
        </div>

    </aside>

    {{-- ===== MAIN CONTENT ===== --}}
    <div class="products-main" style="flex:1; padding:2rem 2.5rem; overflow-y:auto;">

        {{-- Page heading --}}
        <h1 class="heading-section" style="color:white; text-align:center; margin-bottom:2.5rem; font-size:2rem;">
            {{ __('messages.products_page_title') }}
        </h1>

        {{-- Category cards grid --}}
        @if(!request('category') && !request('body_part'))
            <div style="display:grid; grid-template-columns:repeat(3, 1fr); gap:1rem; margin-bottom:2.5rem;">
                @foreach($categories as $cat)
                    <a href="{{ route('products.index', ['category' => $cat->id]) }}"
                       class="product-category-card {{ request('category') == $cat->id ? 'active' : '' }}">
                        @if($cat->icon_svg)
                            <div style="margin-bottom:0.75rem; display:flex; justify-content:center;">
                                <div style="width:60px; height:60px; color:rgba(255,255,255,0.8);">{!! $cat->icon_svg !!}</div>
                            </div>
                        @endif
                        <div class="product-category-card-name">
                            {{ $cat->getTranslation('name', app()->getLocale()) }}
                        </div>
                    </a>
                @endforeach
            </div>
            <div style="border-top:1px solid rgba(255,255,255,0.06); margin-bottom:2rem;"></div>
        @endif

        {{-- Products grid --}}
        @if($products->count())
            <div style="display:grid; grid-template-columns:repeat(auto-fill, minmax(180px, 1fr)); gap:1rem;">
                @foreach($products as $product)
                    <a href="{{ route('products.show', $product->slug) }}" class="product-grid-card">
                        <img src="{{ $product->getPrimaryThumbUrl() }}"
                             alt="{{ $product->getTranslation('title', app()->getLocale()) }}"
                             onerror="this.style.background='#1a3348'; this.src=''">
                        <div class="product-grid-card-body">
                            <div class="product-grid-card-name">
                                {{ $product->getTranslation('title', app()->getLocale()) }}
                            </div>
                            @if($product->category)
                                <div class="product-grid-card-cat">
                                    {{ $product->category->getTranslation('name', app()->getLocale()) }}
                                </div>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @else
            <div style="text-align:center; padding:4rem 0; color:rgba(255,255,255,0.35);">
                <svg style="width:48px; height:48px; margin:0 auto 1rem; display:block;" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1">
                    <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 15.803a7.5 7.5 0 0 0 10.607 0Z"/>
                </svg>
                <p>{{ __('No products found.') }}</p>
            </div>
        @endif
    </div>
</div>

@endsection
