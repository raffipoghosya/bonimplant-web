<header class="site-header">
    {{-- Logo --}}
    <a href="{{ route('home') }}" class="header-logo">
        @include('components.logo')
    </a>

    {{-- Navigation --}}
    <nav class="header-nav" role="navigation" aria-label="Main navigation">
        <a href="{{ route('home') }}#about"
           class="nav-link {{ request()->is('/') ? '' : '' }}">
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

    {{-- Right section: Contact + Language switcher --}}
    <div class="header-right">
        <a href="{{ route('home') }}#contact" class="nav-link" style="border-left: 1px solid rgba(255,255,255,0.08);">
            {{ __('messages.nav_contact') }}
        </a>

        {{-- Language Switcher --}}
        @foreach(['hy' => __('messages.lang_hy'), 'ru' => __('messages.lang_ru'), 'en' => __('messages.lang_en')] as $locale => $label)
            <form method="GET" action="{{ route('locale.switch', $locale) }}" style="display:inline;">
                @csrf
                <button type="submit"
                    class="lang-btn {{ app()->getLocale() === $locale ? 'active' : '' }}">
                    {{ $label }}
                </button>
            </form>
        @endforeach
    </div>
</header>
