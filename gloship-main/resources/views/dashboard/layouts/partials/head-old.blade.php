<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __(@$page_title) }} -
        {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}</title>

    <!-- Fontawesome Icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font Stylesheet -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link
        href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap"
        rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    {{-- <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/css/bootstrap.css"> --}}
    <link rel="stylesheet"
        href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/bootstrap-icons/bootstrap-icons.css">

    <!-- Vendors Stylesheet -->
    <link rel="stylesheet"
        href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/perfect-scrollbar/perfect-scrollbar.css">

    <!-- Template Stylesheet -->
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/css/app.css?v1.1">
    {{-- <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/css/app-dark.css"> --}}

    <!-- Favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/img/favicon.png') }}" type="image/x-icon">

    {{--  toastify --}}
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/toastify/toastify.css">

    {{-- flagicon --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@6.6.6/css/flag-icons.min.css" />

    <!-- Ionicons  -->
    <script type="module" src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.esm.js"></script>
    <script nomodule src="https://unpkg.com/ionicons@5.5.2/dist/ionicons/ionicons.js"></script>

    {{-- CSS Plugins --}}
    <link rel="stylesheet" href="{{ asset(get_theme_dir('plugins')) }}/lazyload/lazyload.css" type="text/css"
        media="all">

    <style>
        :root {
            --color-primary: #ff6912;
            --color-primary-2: #0060ff;
            --color-primary-light: #6B4BF6;
            --color-primary-dark: #4B2F8D;
            --color-primary-main: #865ce2;
            --color-primary-main-2: #ede7fb;
            --color-primary-selected: #1f1b19;
            --color-primary-selected2: #d70900;
            --color-white: #FFFFFF;
            --color-black: #000000;
            --color-blue: #0060ff;
            --color-green: #4BF681;
            --bg-green: #f0fbf5;
            --color-yellow: #F6814B;
            --color-red: #f6544b;
            --color-link: #0060ff;
            --transition: all ease .5s;
            --container-width: 1200px;
        }

        .sidebar-wrapper .menu .sidebar-item.active>.sidebar-link {
            background-color: var(--color-blue);
            color: #814BF6 !important;
        }

        .sidebar-wrapper .menu .sidebar-link {
            font-size: 0.800rem;
            padding: 0.7rem 1rem;
        }

        .sidebar-wrapper .menu .sidebar-link {
            border-radius: 6px;
            line-height: 16px;
            /* padding: 0 24px; */
            width: 100%;
            border: none;
            /* font-size: 14px; */
            /* border-radius: 6px; */
            font-weight: 600;
            display: inline-flex;
            /* align-items: center;
    justify-content: center; */
            /* color: #fff; */
            min-height: 48px;
            transition: all .2s ease-in-out;
            position: relative;
            cursor: pointer;
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

        .btn.btn-main {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .btn.btn-success {
            background: var(--color-primary);
            color: var(--color-white);
        }

        .btn-outline-primary {
            background-color: #ede7fb !important;
            color: var(--color-primary) !important;
        }

        #main #main-content {
            padding-top: 1rem;
            padding-left: 1rem;
            padding-right: 1rem;
            padding-bottom: 2rem;
        }

        .sidebar-logo {
            width: 130px !important;
            height: 50px !important;
        }

        .dropdown-menu-end {
            right: 0 !important;
            left: auto !important;
        }

        @media screen and (min-width:769px) {
            .no-desktop {
                display: none !important
            }
        }

        @media screen and (max-width:769px) {
            .no-phone {
                display: none !important
            }
        }

        .small-card {
            float: none;
            max-width: 700px;
            margin: auto;
        }

        .select2.select2-container .select2-selection {
            width: 100% !important;
            height: 37px !important;
            border: 1px solid #dce7f1;
            outline: none !important;
            transition: all .15s ease-in-out;
        }

        .card.add-shipment .card-body {
            padding: 1rem !important;
        }

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

        .table-nowrap td,
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
        }

        .modal-dialog {
            overflow-y: initial !important;
        }

        .fontawesome-icons {
            text-align: center;
        }

        article dl {
            background-color: rgba(0, 0, 0, .02);
            padding: 20px;
        }

        .fontawesome-icons .the-icon svg {
            font-size: 24px;
        }

        .sidebar-wrapper {
            background-color: #ffffff !important;
        }

        html[data-bs-theme="dark"] .sidebar-wrapper {
            background: #151521 !important;
        }

        .sidebar-link:hover {
            background-color: var(--color-primary-2) !important;
            color: #ffffff !important;
        }

        .page-item.active .page-link {
            z-index: 3;
            color: #fff;
            background-color: var(--color-primary-2);
            border-color: var(--color-primary-2);
        }

        .navbar-light .navbar-toggler,
        .navbar-toggler-icon {
            color: var(--color-primary-2) !important;
        }

        .float-right {
            float: right;
        }

        .card {
            border-radius: 1px;
        }

        .cardx {
            border: none;
            margin-bottom: 24px;
            -webkit-box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }

        .avatar-xs {
            height: 2.3rem;
            width: 2.3rem;
        }

        /* body {
            background-color: #eef1f5;
        } */
        .card {
            box-shadow: 0 7px 14px 0 rgba(65, 69, 88, 0.1), 0 3px 6px 0 rgba(0, 0, 0, 0.07);
        }

        body {
            background-color: #edf2f9;
        }

        .sidebar-link {
            /* font-family: "Montserrat-SemiBold"; */
            font-style: normal;
            font-weight: 600;
            font-size: 15px;
            line-height: 110.8%;
            /* color: #FFFFFF !important; */
            height: 40px;
        }

        /* .sidebar-wrapper .menu*/
        .sidebar-link .icon {
            color: var(--color-primary-2) !important;
            font-size: 20px;
            line-height: 1em;
        }

        .sidebar-link:hover .icon {
            color: #ffffff !important;
        }

        .sidebar-wrapper .active .icon {
            color: #ffffff !important;
        }

        header .bg-light {
            background: #ffffff !important;
        }

        .bg-primary {
            background: var(--color-primary-2);
        }

        .text-primary {
            color: var(--color-primary-2) !important;
        }

        .text-main {
            color: #7367F0 !important;
        }

        .bg-main {
            color: #ffffff !important;
            background: #7367F0;
        }

        .bg-default {
            color: #f8f8f8;
        }

        .modal .modal-header {
            color: #000;
            background-color: #F8F8F8;
            border-bottom: none;
            border-bottom-left-radius: 0;
            border-bottom-right-radius: 0;
        }

        .modal .modal-header .close {
            padding: 0.2rem 0.62rem;
            box-shadow: 0 5px 20px 0 rgb(34 41 47 / 10%);
            border-radius: 0.357rem;
            background: #FFFFFF;
            opacity: 1;
            -webkit-transition: all 0.23s ease 0.1s;
            transition: all 0.23s ease 0.1s;
            position: relative;
            -webkit-transform: translate(8px, -2px);
            -ms-transform: translate(8px, -2px);
            transform: translate(8px, -2px);
        }

        a {
            color: var(--color-link);
            text-decoration: none;
            background-color: transparent;
        }

        h1,
        h2,
        h3,
        h4,
        h5,
        h6,
        .h1,
        .h2,
        .h3,
        .h4,
        .h5,
        .h6 {
            font-family: inherit;
            color: #5E5873;
            font-weight: 500;
            line-height: 1.2;
            margin-bottom: 0.5rem;
        }

        .navbar {
            height: 70px;
        }

        .nav-pills .nav-link.active,
        .nav-pills .show>.nav-link {
            color: #fff;
            background-color: var(--color-primary-2) !important;
        }

        .nav-pills .nav-link.active {
            box-shadow: 0 2px 10px rgb(70 240 176 / 50%);
        }

        .site-header {
            padding-top: 1rem;
            padding-right: 1rem;
            padding-left: 1rem;
            padding-bottom: 2rem;
        }

        .site-header .navbar {
            border-radius: 1px;
            border: none;
            background-color: transparent;
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }

        html[data-bs-theme="dark"] .site-header .navbar {
            background: #151521 !important;
        }

        html[data-bs-theme="dark"] .list-table tr {
            border: 2px solid #000;
        }

        html[data-bs-theme="dark"] .select2-container--default .select2-selection--single,
        html[data-bs-theme="dark"] .select2-dropdown {
            background: #151521 !important;
        }

        html[data-bs-theme="dark"] .box-item-notification,
        html[data-bs-theme="dark"] .box-item {
            color: #fff !important;
        }

        html[data-bs-theme=dark] .modal .modal-header {
            background: #151521;
            color: #ffffff;
        }

        .dropdown-toggle:after {
            display: none;
        }

        .sidebar-footer {
            bottom: 0;
            position: absolute;
        }

        .notification-item {
            max-height: 25rem;
        }

        .ns {
            overflow-anchor: none;
            overflow: hidden !important;
            touch-action: auto;
        }

        @media (max-width: 767px) {
            .navbar-top .show .dropdown-menu {
                right: 0;
                left: 0 !important;
                float: none;
                width: auto !important;
                margin-top: 0;
                overflow: hidden;
            }
        }

        @media (max-width: 767px) {
            .navbar-top .dropdown-menu {
                position: absolute;
            }
        }

        .notification-item {
            border-bottom: 1px solid #eef1f5;
        }

        .notification-icon {
            border-radius: 50%;
            color: #fff;
            height: 40px;
            text-align: center;
            vertical-align: middle;
            width: 40px;
        }

        .icon-2x {
            font-size: 24px;
            line-height: 1em;
        }

        /* .card-tool a {
            display: inline;
        } */
        .btn-primary,
        .bg-success {
            background-color: var(--color-primary-2);
            color: #fff;
        }

        .bg-success {
            background-color: var(--color-primary) !important;
        }

        .btn-secondary {
            background-color: #0052f2;
            color: #fff;
        }

        .text-blue {
            text-decoration: underline;
            color: #0052f2;
        }

        .text-default {
            text-decoration: underline;
            color: var(--color-primary-2);
        }

        /* .progress {
            width: 250px;
            height: 250px !important;
            float: left;
            line-height: 250px;
            background: none;
            margin: 20px;
            box-shadow: none;
            position: relative;
        }

        .progress:after {
            content: "";
            width: 100%;
            height: 100%;
            border-radius: 50%;
            border: 12px solid #fff;
            position: absolute;
            top: 0;
            left: 0;
        }

        .progress>span {
            width: 50%;
            height: 100%;
            overflow: hidden;
            position: absolute;
            top: 0;
            z-index: 1;
        }

        .progress .progress-left {
            left: 0;
        }

        .progress .progress-bar {
            width: 100%;
            height: 100%;
            background: none;
            border-width: 12px;
            border-style: solid;
            position: absolute;
            top: 0;
        }

        .progress .progress-left .progress-bar {
            left: 100%;
            border-top-right-radius: 80px;
            border-bottom-right-radius: 80px;
            border-left: 0;
            -webkit-transform-origin: center left;
            transform-origin: center left;
        }

        .progress .progress-right {
            right: 0;
        }

        .progress .progress-right .progress-bar {
            left: -100%;
            border-top-left-radius: 80px;
            border-bottom-left-radius: 80px;
            border-right: 0;
            -webkit-transform-origin: center right;
            transform-origin: center right;
            animation: loading-1 1.8s linear forwards;
        }

        .progress .progress-value {
            width: 90%;
            height: 90%;
            border-radius: 50%;
            background: #000;
            font-size: 24px;
            color: #fff;
            line-height: 135px;
            text-align: center;
            position: absolute;
            top: 5%;
            left: 5%;
        }

        .progress.blue .progress-bar {
            border-color: #049dff;
        }

        .progress.blue .progress-left .progress-bar {
            animation: loading-2 1.5s linear forwards 1.8s;
        }

        .progress.yellow .progress-bar {
            border-color: #fdba04;
        }

        .progress.yellow .progress-right .progress-bar {
            animation: loading-3 1.8s linear forwards;
        }

        .progress.yellow .progress-left .progress-bar {
            animation: none;
        }

        @keyframes loading-1 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(180deg);
                transform: rotate(180deg);
            }
        }

        @keyframes loading-2 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(144deg);
                transform: rotate(144deg);
            }
        }

        @keyframes loading-3 {
            0% {
                -webkit-transform: rotate(0deg);
                transform: rotate(0deg);
            }

            100% {
                -webkit-transform: rotate(135deg);
                transform: rotate(135deg);
            }
        } */
        .required::after {
            content: " *";
            color: red
        }

        .optional::after {
            content: " ({{ __('messages.Optional') }})";
            color: grey
        }

        .bbcode::after {
            content: " ({{ __('messages.BBCode_Supported') }})";
            color: grey
        }

        .sidebar-wrapper .sidebar-header {
            padding: 1rem 2rem 0rem;
        }

        .navbar .user-menu img {
            width: 32px;
            height: 32px;
        }

        .sidebar-wrapper .menu .sidebar-item {
            margin-top: .1rem !important;
        }

        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        input[type=number] {
            -webkit-appearance: none;
            margin: 0;
        }

        .box-item {
            margin-bottom: 0;
        }

        .box-item {
            position: relative;
            display: flex;
            align-items: center;
            width: 100%;
            padding: 1.5rem 1.5rem;
            font-size: 1rem;
            color: #1F2937;
            text-align: left;
            background-color: rgba(0, 0, 0, 0);
            border: 0.0625rem solid #E5E7EB;
            border-radius: 0;
            overflow-anchor: none;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease;
        }

        .box-item-notification {
            position: relative;
            align-items: center;
            width: 100%;
            padding: 1.5rem 1.5rem;
            font-size: 1rem;
            color: #1F2937;
            text-align: left;
            background-color: rgba(0, 0, 0, 0);
            border: 0.0625rem solid #E5E7EB;
            border-radius: 0;
            overflow-anchor: none;
            transition: color 0.15s ease-in-out, background-color 0.15s ease-in-out, border-color 0.15s ease-in-out, box-shadow 0.15s ease-in-out, border-radius 0.15s ease;
        }
    </style>
    {{-- select2 --}}
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    @stack('css')
</head>