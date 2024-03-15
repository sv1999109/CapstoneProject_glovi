{{-- Navbar --}}
<nav class="navbar normal navbar-expand-lg navbar-light navbar-default mega">
    <div class="container">
        <a href="{{ route('home') }}" class="navbar-brand xp-0">
            @if (get_theme_config('site_logo_main') == 'enabled')
                <img class="logo-main" src="{{ asset(get_contents_admin('logo_main', '', 'all')) }}" alt="{{ get_content_locale(get_config('site_name')) }}">
                <img class="logo-light"  src="{{ asset(get_contents_admin('logo_dashboard', '', 'all')) }}" alt="{{ get_content_locale(get_config('site_name')) }}" style="display: none">
            @else
                {{ get_content_locale(get_config('site_name')) }}
            @endif
        </a>
        <span class="no-desktop lang ms-auto py-0 pr-4" style="padding-right: 15px">
            <a class="dropdown-toggle" href="#" id="langId" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span class="fi fi-{{ locale_to_country(LaravelLocalization::getCurrentLocale()) }}"></span>

            </a>
            <div class="nav-item dropdown lang-switcher">
                <div class="dropdown-menu" aria-labelledby="langId">
                    @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <a class="dropdown-item" rel="alternate" hreflang="{{ $localeCode }}"
                            href="{{ LaravelLocalization::getLocalizedURL($localeCode, null, [], true) }}">
                            {{ $properties['native'] }}
                        </a>
                    @endforeach
                </div>
            </div>
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse pt-4" id="menu">
            <ul class="navbar-nav ms-auto py-0">
                @if (get_theme_config('menu_item_phone') == 'enabled')
                    <li class="nav-item mobile-phone no-desktop">
                        <a class="nav-link" href="tel:{{ get_config('site_phone') }}">
                            <ion-icon name="call-outline"></ion-icon> {{ get_config('site_phone') }}
                        </a>
                    </li>
                @endif

                @if (get_theme_config('menu_item_service') == 'enabled')
                    <li class="nav-item">
                        <a href="{{ route('pages', ['slug' => 'service']) }}"
                            class="nav-link {{ menu_active('services') }}">{{ trans_choice('messages.Our_Service', 2) }}
                        </a>
                    </li>
                @endif

                @if (get_theme_config('menu_item_contact') == 'enabled')
                    <li class="nav-item">
                        <a href="{{ route('contact') }}"
                            class="nav-link {{ menu_active('contact') }}">@lang('messages.Contact_Us')</a>
                    </li>
                @endif
                @if (get_theme_config('menu_item_tracking') == 'enabled')
                    <li class="nav-item">
                        <a href="{{ route('tracking') }}"
                            class="nav-link button bg-black {{ menu_active('tracking') }}">@lang('messages.Track_Shipment') </a>
                    </li>
                @endif

                @if (get_theme_config('menu_item_login') == 'enabled')
                <li class="nav-item mt-2 mb-2 no-desktop">
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
                </li>
            </ul>
        </div>
    </div>
</nav>
