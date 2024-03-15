<header class="site-header sticky-header">

    <div class="overlay"></div>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand w-20 logo" href="{{ route('home') }}">
                @if (get_theme_config('site_logo_main') == 'enabled')
                <img class="logo-main" src="{{ asset(get_contents_admin('logo_main', '', 'all')) }}" alt="{{ get_content_locale(get_config('site_name')) }}">
                <img class="logo-light"  src="{{ asset(get_contents_admin('logo_dashboard', '', 'all')) }}?xx" alt="{{ get_content_locale(get_config('site_name')) }}">
                @else
                    {{ get_content_locale(get_config('site_name')) }}
                @endif
            </a>
            <button class="navbar-toggler p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="bi bi-justify-right"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">



                <ul class="navbar-nav py-lg-3 ms-auto">

                    @if (get_theme_config('menu_item_service') == 'enabled')
                    <li class="nav-item">
                        <a href="{{ route('pages', ['slug' => 'service']) }}"
                            class="nav-link {{ menu_active('services') }}">{{ trans_choice('messages.Service', 2) }}
                        </a>
                    </li>
                @endif

                
                    @if (get_theme_config('menu_item_about') != 'enabled')
                        <li class="nav-item {{ route('page', ['slug' => 'about']) }}">
                            <a href="{{ route('page', ['slug' => 'about']) }}"
                                class="nav-link {{ menu_active('about') }} ">@lang('messages.About_Us')</a>
                        </li>
                    @endif

                    @if (get_theme_config('menu_item_contact') == 'enabled')
                        <li class="nav-item {{ menu_active('contact') }}">
                            <a href="{{ route('contact') }}"
                                class="nav-link {{ menu_active('contact') }}">@lang('messages.Help')</a>
                        </li>
                    @endif

                    {{-- @if (get_theme_config('menu_item_faq') != 'enabled')
                        <li class="nav-item me-3 {{ menu_active('pages', ['slug' => 'faq']) }}">
                            <a href="{{ route('pages', ['slug' => 'faq']) }}"
                                class="nav-link {{ menu_active('faq') }}">{{ trans_choice('messages.Faq', 2) }}</a>
                        </li>
                    @endif --}}

                    @if (get_theme_config('menu_item_faq') != 'enabled')
                        <li class="nav-item me-3 active">
                            <a href="{{ route('quote') }}"
                                class="nav-link active">{{ trans_choice('messages.Get_Quote', 2) }}</a>
                        </li>
                    @endif

                    @if (get_theme_config('menu_item_login') == 'enabled')
                        @auth
                        {{-- <li class="nav-item me-2"> <a href="{{ route('dashboard.index') }}" 
                            class="nav-btn btn btn-light text-main"><span class="bi bi-plus"></span> @lang('messages.Add_Shipment')</a></li> --}}
                            
                        <li class="nav-item"> <a href="{{ route('dashboard.index') }}" 
                            class="nav-btn btn btn-primary">@lang('messages.Dashboard')</a></li>
                            
                        @endauth
                        @guest
                        <li class="nav-item"> <a href="{{ route('login') }}"
                            class="nav-link ">@lang('messages.Login')</a></li>
                        <li class="nav-item"> <a href="{{ route('login') }}"
                        class="nav-btn btn btn-primary">@lang('messages.Create_Account')</a></li>
                        @endguest
                    @endif
                    
                </ul>

            </div>
        </div>
    </nav>
</header>


<header class="site-header" role="banner" style="display: none">

    <div class="e-nav" style="padding-left:20px; display: none; ">
        <div class="container xrow">
            <div class="row">
                <div class="col-sm-6">
                    @if (get_theme_config('menu_item_phone') == 'enabled')
                        <a href="tel:{{ get_config('site_phone') }}" class="email-top">
                            <span class="phone-top">
                                <ion-icon name="call-outline"></ion-icon>
                                {{ get_config('site_phone') }}
                            </span>
                        </a>
                    @endif
                    @if (get_theme_config('menu_item_email') == 'enabled')
                        <span class="divider"></span>
                        <a href="mail:{{ get_config('site_email_support') }}" class="email-top">
                            <ion-icon name="mail-outline"></ion-icon>
                            {{ get_config('site_email_support') }}
                        </a>
                    @endif
                </div>
                <div class="col-sm-6 btns">
                    @if (get_theme_config('menu_item_login') == 'enabled')
                        @auth
                            <a href="{{ route('dashboard.index') }}" class="button">
                                @lang('messages.Dashboard')
                            </a>
                        @endauth
                        @guest
                            <a href="{{ route('login') }}" class="button">
                                @lang('messages.Login')
                            </a>
                        @endguest
                    @endif

                    @if (get_theme_config('menu_item_language') == 'enabled')
                        <a href="#" class="button white dropdown-toggle" href="#" id="dropdownId"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span
                                class="fi fi-{{ locale_to_country(LaravelLocalization::getCurrentLocale()) }}"></span>
                            {{ LaravelLocalization::getCurrentLocaleName() }}
                        </a>
                        <ul>
                            <li class="nav-item dropdown lang-switcher">
                                <div class="dropdown-menu" aria-labelledby="dropdownId">
                                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                        @php
                                            $url = url(LaravelLocalization::getLocalizedURL($localeCode, null, [], true));
                                        @endphp
                                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                                            href="{{ $url }}">
                                            {{ $properties['native'] }}
                                        </a>
                                    @endforeach
                                </div>
                            </li>
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- Include Navbar --}}
    @include(get_theme_dir('layouts.partials.nav'))

</header>
