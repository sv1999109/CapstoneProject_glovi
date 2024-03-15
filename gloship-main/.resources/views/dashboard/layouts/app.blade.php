<!doctype html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="true" data-theme="material" data-topbar="light" data-bs-theme="light" data-layout-width="fluid" data-sidebar-image="none" data-layout-position="fixed" data-layout-style="default">
{{-- include head tags --}}
@include(get_theme_dir('layouts.partials.head', 'dashboard'))

<body>
    <div id="layout-wrapper">
        @include(get_theme_dir('layouts.partials.sidebar', 'dashboard'))

        {{-- include header layout --}}
        @include(get_theme_dir('layouts.partials.header', 'dashboard'))
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <!-- container -->
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!--start back-to-top-->
     <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    {{-- include script tags --}}
    @include(get_theme_dir('layouts.partials.scripts', 'dashboard'))

    @stack('modal')
    @stack('scripts')

    {{-- display error response with toastify --}}
    @if (isset($errors))
        @include(get_theme_dir('toast', 'dashboard'), ['errors' => $errors])
    @endif
    {{-- display flash response with toastify --}}
    @include(get_theme_dir('flash', 'dashboard'), [])

    {{--  display  modal flash --}}
    @include(get_theme_dir('modal', 'dashboard'), [])
    
</body>

</html>
