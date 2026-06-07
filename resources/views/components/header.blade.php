{{--
    Header Component
    - Logo from public/images/logo.png
    - Nav links with active state
    - Alpine.js language switcher dropdown (shows only OTHER locales)
--}}
@php
    $currentLocale = app()->getLocale();
    $allLocales = [
        'hy' => 'ՀԱՅ',
        'ru' => 'РУС',
        'en' => 'ENG',
    ];
    $otherLocales = array_filter($allLocales, fn($code) => $code !== $currentLocale, ARRAY_FILTER_USE_KEY);
    $currentLabel = $allLocales[$currentLocale] ?? strtoupper($currentLocale);
@endphp

<header class="site-header">

    {{-- Logo --}}
    <a href="{{ route('home') }}" class="header-logo">
        <img src="{{ asset('images/logo.png') }}"
             alt="BonImplant"
             style="height:48px; width:auto; display:block;"
             onerror="this.style.display='none'; this.nextElementSibling.style.display='block'">
        {{-- SVG fallback if image missing --}}
        <span style="display:none;">@include('components.logo')</span>
    </a>

    {{-- Navigation --}}
    <nav class="header-nav" role="navigation" aria-label="Main navigation">
        <a href="{{ route('home') }}#about"
           class="nav-link">
            {{ __('messages.nav_about') }}
        </a>
        <a href="{{ route('products.index') }}"
           class="nav-link {{ request()->routeIs('products.*') ? 'active' : '' }}">
            {{ __('messages.nav_products') }}
        </a>
        <a href="{{ route('home') }}#news"
           class="nav-link">
            {{ __('messages.nav_news') }}
        </a>
    </nav>

    {{-- Right section: Contact + Language switcher dropdown --}}
    <div class="header-right">

        {{-- Contact link --}}
        <a href="{{ route('home') }}#contact"
           class="nav-link"
           style="border-left: 1px solid rgba(255,255,255,0.08);">
            {{ __('messages.nav_contact') }}
        </a>

        {{-- Language Switcher Dropdown (Alpine.js) --}}
        <div class="lang-switcher" x-data="{ open: false }" @click.outside="open = false">

            {{-- Active language button --}}
            <button
                type="button"
                class="lang-btn lang-btn-active"
                @click="open = !open"
                :aria-expanded="open"
                aria-haspopup="true"
                id="lang-menu-btn">
                {{ $currentLabel }}
                <svg style="width:10px; height:10px; margin-left:4px; transition: transform 0.2s;"
                     :style="open ? 'transform:rotate(180deg)' : ''"
                     viewBox="0 0 10 6" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M1 1L5 5L9 1" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
                </svg>
            </button>

            {{-- Dropdown: only OTHER locales --}}
            <div class="lang-dropdown"
                 x-show="open"
                 x-transition:enter="transition ease-out duration-150"
                 x-transition:enter-start="opacity-0 scale-95"
                 x-transition:enter-end="opacity-100 scale-100"
                 x-transition:leave="transition ease-in duration-100"
                 x-transition:leave-start="opacity-100 scale-100"
                 x-transition:leave-end="opacity-0 scale-95"
                 x-cloak>
                @foreach($otherLocales as $locale => $label)
                    <form method="GET" action="{{ route('locale.switch', $locale) }}">
                        @csrf
                        <button type="submit" class="lang-dropdown-item">
                            {{ $label }}
                        </button>
                    </form>
                @endforeach
            </div>
        </div>
    </div>

</header>
