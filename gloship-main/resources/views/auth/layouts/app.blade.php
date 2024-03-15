<!DOCTYPE html>
<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

{{-- include head tags --}}
@include(get_theme_dir('layouts.partials.header', 'auth'))

<body>
    <!-- Content -->

    <div class="authentication-wrapper authentication-cover authentication-bg">
      <div class="authentication-inner row">
        <!-- /Left Text -->
        <div class="d-none d-lg-flex col-lg-7 p-0">
          <div class="auth-cover-bg auth-cover-bg-color d-flex justify-content-center align-items-center">
            <img
              src="{{ asset('assets/img/supercharge-shipping.svg') }}"
              alt="auth-login-cover"
              class="img-fluid my-5 auth-illustration"
              data-app-light-img="{{ asset('assets/img/supercharge-shipping.svg') }}"
              data-app-dark-img="{{ asset('assets/img/supercharge-shipping.svg') }}" />

            <img
              src="{{ asset('assets/img/bg-shape-image-light.png') }}"
              alt="auth-login-cover"
              class="platform-bg"
              data-app-light-img="{{ asset('assets/img/bg-shape-image-light.png') }}"
              data-app-dark-img="{{ asset('assets/img/bg-shape-image-light.png') }}" />
          </div>
        </div>
        <!-- /Left Text -->

       
        <div class="d-flex col-12 col-lg-5 align-items-center p-sm-5 p-4">
          <div class="w-px-400 mx-auto">
            
            <!-- /Logo -->
            @yield('content')

            @yield('content-actions')

            
          </div>
        </div>
        
      </div>
    </div>

    <!-- / Content -->

    <!-- Core JS -->
    @stack('scripts')
  </body>

</html>
