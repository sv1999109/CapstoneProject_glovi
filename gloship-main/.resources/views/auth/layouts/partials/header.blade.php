<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __($page_title) }} -
        {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}</title>

    <!-- Fontawesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <!-- Google Font Stylesheet -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">
<!-- Core CSS -->

   
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/themes-extra/core.css">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/themes-extra/theme-default.css">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/themes-extra/auth.css">
    <link rel="stylesheet"
        href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/bootstrap-icons/bootstrap-icons.css">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset(get_theme_dir('assets_dashboard')) }}/images/favicon.svg"
        type="image/x-icon">

    {{--  toastify --}}
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/toastify/toastify.css">

    {{-- flagicon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />

    
    @stack('css')
    <!--<style>
        body {
           /* background: url(http://localhost/projects/ecourier-clb/assets/img/supercharge-shipping.svg) no-repeat,  linear-gradient(90deg, #eadef7, #eadef7);
           background-size: cover; */
        }

        #auth {
            height: 100vh;
            overflow-x: hidden
        }

        #auth #auth-right {
            height: 100%;
            background: url(http://localhost/projects/ecourier-clb/assets/img/supercharge-shipping.svg) no-repeat;
           background-size: cover;
            /* , linear-gradient(90deg, #eadef7, #eadef7) */
        }

        #auth #auth-left {
            padding: 5rem 8rem
        }

        #auth #auth-left .auth-title {
            font-size: 4rem;
            margin-bottom: 1rem
        }

        #auth #auth-left .auth-subtitle {
            font-size: 1.7rem;
            line-height: 2.5rem;
            color: #a8aebb
        }

        #auth #auth-left .auth-logo {
            margin-bottom: 2rem
        }

        #auth #auth-left .auth-logo img {
            height: 50px
        }

        @media screen and (max-width:767px) {
            #auth #auth-left {
                padding: 2rem
            }
        }
    </style> -->
</head>
