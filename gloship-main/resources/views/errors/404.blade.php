<html lang="{{ LaravelLocalization::getCurrentLocale() }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($message) ? $message: __('404') }} - {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}</title>
    <link
    href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;500;600;700&family=Open+Sans:wght@400;500;600;700&display=swap"
    rel="stylesheet">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/css/bootstrap.css">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/bootstrap-icons/bootstrap-icons.css">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/css/app.css">
    <link rel="stylesheet" href="{{ asset(get_theme_dir('assets_dashboard')) }}/css/pages/error.css">
</head>

<body>
    <div id="error">

        <div class="error-page container">
            <div class="col-md-8 col-12 offset-md-2">
                <div class="text-center">
                    <h1 class="error-title">@lang('messages.Error_Not_Find')</h1>
                    <p class="fs-5 text-gray-600">
                        {{ isset($message) ? $message: __('messages.Error_Not_Find_Msg') }}
                    </p>
                    <a href="{{ url()->previous() }}" class="btn btn-lg btn-primary mt-3">@lang('messages.Back')</a>
                </div>
            </div>
        </div>


    </div>


</body>

</html>
