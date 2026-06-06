@extends('layouts.app')

@section('title', $news->getTranslation('title', app()->getLocale()) . ' — BonImplant')
@section('meta_description', strip_tags($news->getTranslation('short_description', app()->getLocale())))

@section('content')

<div class="container-site" style="padding-top:4rem; padding-bottom:6rem;">

    {{-- Back link --}}
    <a href="{{ route('home') }}#news"
       style="display:inline-flex; align-items:center; gap:0.5rem; font-size:0.8rem; color:rgba(255,255,255,0.4); text-decoration:none; margin-bottom:2rem; transition:color 0.2s;"
       onmouseover="this.style.color='var(--color-primary)'"
       onmouseout="this.style.color='rgba(255,255,255,0.4)'">
        <svg width="14" height="14" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M10.5 19.5L3 12m0 0l7.5-7.5M3 12h18"/>
        </svg>
        {{ __('messages.nav_news') }}
    </a>

    {{-- Two-column layout: image left, content right --}}
    <div style="display:grid; grid-template-columns:40% 1fr; gap:4rem; align-items:start;">

        {{-- Left: Main image --}}
        <div>
            <img src="{{ $news->getMainImageUrl() }}"
                 alt="{{ $news->getTranslation('title', app()->getLocale()) }}"
                 style="width:100%; border-radius:0.25rem; display:block;"
                 onerror="this.style.background='#0a1f30'; this.style.aspectRatio='16/9'">

            {{-- Gallery if exists --}}
            @if($gallery->count())
                <div style="display:flex; gap:0.5rem; flex-wrap:wrap; margin-top:0.75rem;">
                    @foreach($gallery as $media)
                        <img src="{{ $media->getUrl('thumb') }}"
                             alt="Gallery"
                             style="width:80px; height:60px; object-fit:cover; border-radius:0.2rem; cursor:pointer; opacity:0.7; transition:opacity 0.2s;"
                             onmouseover="this.style.opacity='1'"
                             onmouseout="this.style.opacity='0.7'"
                             onclick="document.getElementById('news-main-img').src='{{ $media->getUrl() }}'">
                    @endforeach
                </div>
            @endif
        </div>

        {{-- Right: Title + Full description --}}
        <div>
            {{-- Date --}}
            @if($news->published_at)
                <p style="font-size:0.75rem; color:rgba(255,255,255,0.35); letter-spacing:0.08em; margin-bottom:1rem;">
                    {{ $news->published_at->format('d.m.Y') }}
                </p>
            @endif

            <h1 style="font-size:clamp(1.25rem, 3vw, 2rem); font-weight:800; color:white; line-height:1.2; margin-bottom:2rem;">
                {{ $news->getTranslation('title', app()->getLocale()) }}
            </h1>

            <div class="prose-dark">
                {!! $news->getTranslation('description', app()->getLocale()) !!}
            </div>
        </div>
    </div>
</div>

@endsection
