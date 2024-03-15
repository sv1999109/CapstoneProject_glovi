<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

{{--  head start from here --}}
@include(get_theme_dir('layouts.partials.head'))
{{--  head end here --}}

<body>
    <!-- ========== Start preloader ========== -->
    <div id="preloader">

        <div class="small1">
            <div class="small ball smallball1"></div>
            <div class="small ball smallball2"></div>
            <div class="small ball smallball3"></div>
            <div class="small ball smallball4"></div>
        </div>


        <div class="small2">
            <div class="small ball smallball5"></div>
            <div class="small ball smallball6"></div>
            <div class="small ball smallball7"></div>
            <div class="small ball smallball8"></div>
        </div>

        <div class="bigcon">
            <div class="big ball"></div>
        </div>
    </div>
    
    <!-- ==========  End preloader ========== -->
    
    <div id="app-layout">

        {{--  header start from here --}}
        @include(get_theme_dir('layouts.partials.header'))
        {{-- header end here --}}

        {{-- start content start from here --}}
        @yield('content')
        {{-- content end here --}}

        {{-- begin footer --}}
        @include(get_theme_dir('layouts.partials.footer'))
        {{-- footer end here --}}


       
    </div>
     {{--  scripts start from here --}}
     @include(get_theme_dir('layouts.partials.scripts'))
     {{-- scripts end here --}}
</body>

</html>
