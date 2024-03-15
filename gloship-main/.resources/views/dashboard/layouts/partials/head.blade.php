<head>

    <meta charset="utf-8">
    <title>{{ __(@$page_title) }} -
        {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="{{ get_content_locale(get_config('site_tagline')) }}" name="description">
    <meta content="Endycode.online" name="author">
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    <!-- Fonts css load -->
    <link rel="preconnect" href="https://fonts.googleapis.com/">
    <link rel="preconnect" href="https://fonts.gstatic.com/" crossorigin>
    <link id="fontsLink"
        href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&amp;display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="//fonts.googleapis.com/css?family=Poppins%3A600%2C400&amp;ver=6.0.3" type="text/css"
        media="all">
    <!-- Fontawesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- jsvectormap css -->
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/libs/jsvectormap/css/jsvectormap.min.css"
        rel="stylesheet" type="text/css">

    <!--Swiper slider css-->
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/libs/swiper/swiper-bundle.min.css"
        rel="stylesheet" type="text/css">

    <!-- Layout config Js -->
    <script src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/css/bootstrap.min.css" rel="stylesheet"
        type="text/css">
    <!-- Icons Css -->
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/css/icons.min.css" rel="stylesheet"
        type="text/css">
    <!-- App Css-->
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/css/app.min.css" rel="stylesheet" type="text/css">
    <!-- custom Css-->
    <link href="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/css/custom.min.css" rel="stylesheet"
        type="text/css">

    <!-- new -->
    {{-- flagicon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />

    <style>
        table:not(.table-sm) thead th {
            border-bottom: none;
            background-color: #eef1f5;
            color: #666;
            padding-top: 15px;
            padding-bottom: 15px;
        }

        .list-table {
            border-collapse: separate;
            border-spacing: 0 12px
        }

        .list-table tr {
            background-color: #fff
        }

        /* .table-nowrap td,
        .table-nowrap th {
            white-space: nowrap;
        }

        .table-borderless>:not(caption)>*>* {
            border-bottom-width: 0;
        }

        .table>:not(caption)>*>* {
            padding: 0.75rem 0.75rem;
            background-color: var(--bs-table-bg);
            border-bottom-width: 1px;
            box-shadow: inset 0 0 0 9999px var(--bs-table-accent-bg);
        } */
        .select2.select2-container .select2-selection {
            width: 100% !important;
            padding: 5px;
            height: 38px !important;
            border: 1px solid #dce7f1;
            outline: none !important;
            transition: all .15s ease-in-out;
        }

        .bg-main {
            background: #126cc0;
        }

        .fade:not(.show) {
            display: none;
        }

        body {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
            line-height: 1.4em;
            font-size: 0.8125rem;
            color: #4a4a4a;
            font-weight: 400;
        }

        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            font-family: 'Poppins', -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
        }

        .navbar-menu .navbar-nav .nav-link {
            padding: 0.5rem 1rem;
        }
    </style>

    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @stack('css')

</head>
