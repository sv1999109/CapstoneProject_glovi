@extends(get_theme_dir('layouts.app'))
@section('content')
    <div class="site-content">

        {{-- start hero section --}}
        @if (get_theme_config('section_home_hero') == 'enabled')
            @include(get_theme_dir('home.sections.hero'))
        @endif
        {{-- // hero section end --}}
        @include(get_theme_dir('home.sections.feature'))
        {{-- carriers start --}}
        @if (get_theme_config('section_home_partner') == 'enabled')
            @include(get_theme_dir('home.sections.partners'))
        @endif
        {{-- //carriers section end --}}

        @include(get_theme_dir('home.sections.custom-2'))

        {{-- start services section --}}
        @if (get_theme_config('section_home_service') == 'enabled')
            @include(get_theme_dir('home.sections.services'))
        @endif
        {{-- // start section end --}}

       
        @include(get_theme_dir('home.sections.quote'))
        {{-- faqs section --}}
        @if (get_theme_config('section_home_faq') == 'enabled')
            @include(get_theme_dir('home.sections.faqs'))
        @endif
        {{-- //faqs section end --}}

        {{-- start counter section --}}
        @if (get_theme_config('section_home_counter') == 'enabled')
            @include(get_theme_dir('home.sections.counter'))
        @endif
        {{-- //counter section end --}}

        {{-- blog section --}}
        @if (get_theme_config('section_home_blog') == 'enabled')
            @include(get_theme_dir('home.sections.blog'))
        @endif
        {{-- // blog section end --}}

        @include(get_theme_dir('home.sections.custom'))

    </div>
@endsection
