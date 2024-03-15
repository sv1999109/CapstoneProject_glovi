<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> {{ $page_title }} |
        {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}</title>

    <!-- Icon Font Stylesheet -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    {{-- Bootstrap Style Sheet --}}
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets')) }}/bootstrap/css/bootstrap.min.css" type="text/css">
    <link rel="stylesheet"
        href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/bootstrap-icons/font/bootstrap-icons.css">

    {{-- Site Style Sheet --}}
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets')) }}/css/theme.css?v1" type="text/css" media="all">

    {{-- Google Font --}}
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins%3A600%2C400&amp;ver=6.0.3" type="text/css"
        media="all">

    {{-- CSS Plugins --}}
    
    <link rel="stylesheet" href="{{ asset(get_theme_dir('plugins')) }}/lazyload/lazyload.css" type="text/css"
        media="all">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets')) }}/css/animate.css" type="text/css" media="all">
    <link rel="stylesheet" type="text/css" href="{{ asset(get_theme_dir('plugins')) }}/slick/slick.css">
    <link rel="stylesheet" type="text/css" href="{{ asset(get_theme_dir('plugins')) }}/slick/slick-theme.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset(get_theme_dir('plugins')) }}/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset(get_theme_dir('plugins')) }}/owlcarousel/owl.carousel.min.css">
    <link rel="stylesheet" type="text/css"
        href="{{ asset(get_theme_dir('plugins')) }}/owlcarousel/owl.theme.default.min.css">

    {{-- flagicon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />

    @php
        $primary_color = '#2c8b11';
        $secondary_color = '#ffffff';
        $custom_css = '';
        if (get_theme_config('styling_primary_color') == 'enabled') {
            $primary_color = get_contents_admin('styling_primary_color_code', '', 'all');
        }
        if (get_theme_config('styling_secondary_color') == 'enabled') {
            $secondary_color = get_contents_admin('styling_secondary_color_code', '', 'all');
        }
        if (get_theme_config('custom_css') == 'enabled') {
            $custom_css = get_contents_admin('custom_css_code', '', 'all');
        }
    @endphp

    <style>
        @import url('https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap');

        :root {
            --color-primary: #ff6912;
            --color-primary-2: #d21006;
            --color-primary-light: #6B4BF6;
            --color-primary-dark: #4B2F8D;
            --color-primary-main: #865ce2;
            --color-primary-main-2: #ede7fb;
            --color-primary-selected: #ff6912;
            --color-primary-selected2: #d70900;
            --color-white: #FFFFFF;
            --color-black: #000000;
            --color-blue: #0060ff;
            --color-green: #4BF681;
            --bg-green: #f0fbf5;
            --color-yellow: #F6814B;
            --color-red: #f6544b;
            --color-link: #0060ff;
            --color-bg-main: #FFFFFF;
            --color-bg-secondary: #edf2f9;
            --color-bg-box: #f8faff;
            --color-bg-box-2: #e4eefa;
            --bg-footer: #FFFFFF;
            --color-bg-header: #f8faff;
            --color-bg-header-2: #FFFFFF;
            --transition: all ease .5s;
            --container-width: 1200px;
        }
        body {
            overflow-x: hidden;
        }
        img {
    max-width: 100%;
}

        footer {
            background: #101b24;
            color: #000000;
        }

        /* footer */
        .footer-copyright {
            padding: 10px 20px;
            text-align: center;
            font-size: 14px;
        }

        .footer-heading {
            text-decoration: underline;
            color: #ffffff;
            font-size: 20px;
            margin-bottom: 10px;
        }

        footer a:hover,
        footer a:focus {
            color: var(--color-primary-selected) !important;
        }

        .footer-box ul {
            list-style: none;
            padding: 0;
            margin-bottom: 20px;
        }

        .footer-box li {
            padding: 5px 0;
            line-height: 1.6;
        }

        .bm-links {
            display: flex !important;
        }

        .bm-links a {
            color: #333;
            margin-right: 10px;
            padding-right: 10px;
        }

        .footer-box li:before {
            content: "\f285";
            margin-right: 10px;
            position: relative;
            color: var(--color-primary);
            font-display: block;
            font-family: "bootstrap-icons";
        }

        .social-links a {
            padding: 8px;
        }

        footer .top-section {
            background: #101b24;
            /* background-position: 0px 110px, right 0 bottom 0; */
            background-repeat: no-repeat;
        }

        footer .top-section {
            color: white;
            padding-top: 1.6rem;
            background-color: #101b24;
        }

        footer .copyright-section {
            background-color: #000;
        }

        footer a {
            color: #b3b3b3;
            text-decoration: none;
        }

        footer a:hover {
            color: var(--color-blue) !important;
        }

        ul,
        li {
            list-style: none;
            padding: 0px;
            margin: 0px;
        }

        .bg-main2 {
            background: var(--color-bg-secondary);
        }

        .btn {
            line-height: 16px;
            padding: 0 24px;
            border: none;
            font-size: 14px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            min-height: 48px;
            transition: all .2s ease-in-out;
            position: relative;
            cursor: pointer;
        }

        .btn.btn-primary {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .btn.btn-blue {
            background: var(--color-blue);
            color: var(--color-white);
        }

        .btn.btn-white {
            background: var(--color-white);
            color: var(--color-black);
        }

        .text-main {
            color: var(--color-primary);
        }

        .pe-100 {
            padding: 100px 0;
        }

        .pe-50 {
            padding: 50px 0;
        }

        .form-control {
            min-height: 44px;
            border-radius: 10px;
        }

        .blurry-bg {
            background-color: transparent;
            background-image: linear-gradient(100deg, #003bff 0%, #99caff 85%);
        }

        .hero-section {
            padding-top: 150px;
        }

        .hero-section {
            color: #FFFFFF;
            position: relative;
            padding: 96px 0 80px;
            background: linear-gradient(0deg, #99caff, #99caff .01%, #003bff);
            /* background: linear-gradient(0deg, #99caff, #99caff .01%, #003bff); */
        }

        .fixed-header {
            z-index: 9999;
            opacity: 1;
            visibility: visible;
        }

        .sticky-header {
            position: sticky;
            top: 0px;
            width: 100%;
            padding: 0px 0px;
            z-index: 1000;
            background: #ffffff;
            -webkit-box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.05);
        }

        header {
            background-color: var(--color-bg-header);
            padding: 20px;
        }

        .overlay {
            width: 100%;
            height: 100%;
            position: fixed;
            top: 0;
            left: 0;
            background: rgba(0, 0, 0, 0.7);
            visibility: hidden;
            opacity: 0;
            -webkit-transition: all ease 0.3s;
            -moz-transition: all ease 0.3s;
            transition: all ease 0.3s;
            z-index: 99;
        }

        .navbar {
            padding: 9px 17px;
            background: none;
            -webkit-transition: 0.4s;
            transition: 0.4s;
        }

        .navbar.active {
            background: #ffffff;
            height: 70px;
            z-index: 999999999;
            box-shadow: 0 5px 53px -7px rgba(0, 0, 0, 0.2);
            /* box-shadow: 0 0 20px rgba(0, 0, 0, 0.1); */
            border-bottom: 1px solid rgba(65, 57, 134, 0.5);
        }
        .navbar .logo-light {
            display: none;
        }

        .nav-link {
            color: var(--color-black);
        }

        .active .nav-link {
            color: #000;
        }

        .navbar-nav .nav-link.active,
        .navbar-nav .show>.nav-link {
            color: var(--color-primary-selected);
        }

        .site-header .logo img {
            width: auto;
            max-height: 35px;
        }

        .site-header .navbar-toggler {
            color: var(--color-link);
            border: none;
        }

        .text-blue {
            color: #0061ff;
        }

        .text-red {
            color: #d70006;
        }

        h1,
        h2 {
            font-family: 'Poppins', sans-serif;
            margin-top: 0px;
            font-weight: 700;
            font-style: normal;
            text-transform: normal;
        }

        .section-titlex {
            font-size: 30px;
            line-height: 36px;
            margin-bottom: 0;
        }

        body {
            font-family: 'Poppins', sans-serif;
            background: #edf2f9;
            line-height: 1.5em;
            font-size: 0.850rem;
            color: #4a4a4a;
            font-weight: 400;
            -webkit-font-smoothing: antialiased;
            /* font-family: 'Montserrat', Arial, sans-serif; */
            line-height: 1.5em;
            margin: 0;
            padding: 0;
        }

        html,
        body {
            padding: 0;
            margin: 0;
        }

        #app-layout {
            display: flex;
            min-height: 100vh;
            flex-direction: column;
            justify-content: center;
        }

        #app-layout .site-content {
            flex-grow: 1;
        }

        .post-block {
            align-items: flex-start;
            background-color: #fff;
            border-radius: 20px;
            border: 1px solid var(--color-blue);
            display: flex;
            flex: 0 0 auto;
            flex-direction: column;
            font-size: 16px;
            justify-content: space-between;
            line-height: 1.1875;
            max-width: 403px;
            padding: 20px;
            /* margin: 10px; */
        }

        .post-block__image {
            border-top-left-radius: 15px;
            border-top-right-radius: 15px;
            height: 218px;
            margin-bottom: 30px;
            object-fit: cover;
            width: 397px;
            overflow: hidden;
        }

        .post-block__date {
            color: #7f7f7f;
            margin-bottom: 20px;
        }

        .post-block__heading {
            font-size: 24px;
            font-weight: 700;
            line-height: 1.20833;
            margin-bottom: 20px;
            margin-top: 0;
        }

        .post-block__heading a {
            color: #000000 !important;
        }

        .post-block__body {
            color: #777;
            margin-bottom: 53px;
            width: 100%;
        }

        .post-block__image2 {
            border-bottom-left-radius: 15px;
            border-bottom-right-radius: 15px;
            height: 218px;
            /* margin-bottom: 30px; */
            object-fit: cover;
            width: 397px;
            overflow: hidden;
        }

        @media screen and (max-width: 991px) {
            .post-block__image {
                height: 189px;
                width: 100%;
                overflow: hidden;
            }

            .post-block {
                max-width: 350px;
            }
        }

        @media screen and (max-width: 478px) {
            .post-block {
                max-width: none;
                width: 100%;
            }

            .post-block__heading {
                font-size: 20px;
            }
        }

        .nav-link {
            flex: 0 1 1px;
            white-space: nowrap;
            font-size: 16px;
            line-height: 24px;
            /* padding: 25px 16px; */
            color: #141415;
            border-radius: 4px;
            transition: all .1s linear;
            font-weight: 600;
        }

        @media (max-width: 991px) {
            .navbar {
                padding: 5px;
                background: var(--color-bg-header);
            }

            .nav-link {
                color: #000 !important;
            }

            .pe-100 {
                padding: 50px 0;
            }

            .pe-50 {
                padding: 20px 0;
            }
        }

        .bg-passed .cbp_tmicon {
            background-color: var(--color-primary) !important;
            color: #ffffff;
        }

        .shipment-item h2 strong {
            color: #666;
        }

        .bg-passed h2 strong {
            color: #000000 !important;
        }

        .bg-error .cbp_tmicon {
            background-color: red !important;
            color: #ffffff;
        }

        .bg-error h2 strong {
            color: red !important;
        }

        @media (min-width: 768px) {
            .hero {
                min-height: calc(100vh - 475px);
            }
        }

        @media (min-width: 576px) {
            .styles_content__DtkNU {
                min-height: calc(100vh - 435px);
            }
        }

        .box-shadow {
            box-shadow: 0 3px 20px -6px rgba(0, 0, 0, 0.2);
        }

        .form-control,
        .input-group-addon,
        .bootstrap-select .btn {
            background-color: #ffffff;
            border-color: #e7e8ec;
            border-radius: 3px;
            color: #c7c7c7;
            font-size: 14px;
            height: 46px;
            padding: 10px 20px;
            font-weight: 300;
            text-transform: uppercase;
        }

        .tracking-section .form-control {
            height: 50px;
            text-transform: none;
        }


       

        /* end */
        /* add Custom CSS */
        {!! $custom_css !!}
    </style>
    @stack('css')

</head>
