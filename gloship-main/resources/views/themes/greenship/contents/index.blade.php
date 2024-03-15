@extends(get_theme_dir('layouts.app'))
@section('content')
    <div class="site-content">
        <div id="posts" class="">
            <div class="container">
                <div class="row">

                    <div class="col-md-8">
                        <div class="col-md-12">
                            <h2 class="mb-4 text-center">{{ $page_title }}</h2>
                        </div>
                        <div class="row secondary">
                            @foreach ($posts as $post)
                                @php
                                    $post_type = $post->post_type;
                                    $post_title = get_content_locale($post->post_title);
                                    $post_content = get_content_locale($post->post_content);
                                    $contents = Str::limit(strip_tags($post_content), 150, '...');
                                    $post_excerpt = $post->post_excerpt;
                                    $post_status = $post->post_status;
                                    $post_img = $post->post_img;
                                    $post_slug = $post->post_slug;
                                @endphp
                                <div class="col-sm-6">
                                    <div
                                        class="post">
                                        @if ($post_img)
                                            <a href="{{ route('blog.post', ['slug' => $post_slug]) }}" class="pic">

                                                <img width="691" height="350" alt="{{ $post_title }}"
                                                    decoding="async" loading="lazy"
                                                    class="attachment-featured-post js--lazyload"
                                                    src="{{ asset($post_img) }}" data-lazyload="{{ asset($post_img) }}" style="height: 220px">
                                            </a>
                                        @endif

                                        <h3 class="title">
                                            <a
                                                href="{{ route('blog.post', ['slug' => $post_slug]) }}">{{ $post_title }}</a>
                                        </h3>
                                        <p>{!! $contents !!}</p>
                                    </div>
                                </div>
                            @endforeach
                           @if (!isset($post->id))
                               <p><h6 class="text-center">@lang('messages.No_Record_Found')</h6></p>
                           @endif

                        </div>

                        {!! $posts->links() !!}
                    </div>
                    @include(get_theme_dir('contents.sidebar'), [
                        'post_type' => isset($post_type) ? $post_type : 'blog'
                    ])
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        body {
            background: #FFFFFF;
        }

        *,
        ::after,
        ol {
            box-sizing: border-box;
        }

        img,
        label {
            max-width: 100%;
        }

        img {
            border-style: initial;
            border-width: 0;
            height: auto;
            vertical-align: middle;
        }

        aside {
            display: block;
        }

        a {
            background-color: transparent;
            color: #337ab7;
            text-decoration: none;
        }

        select {
            font-size: inherit;
            font-weight: inherit;
            text-transform: none;
        }

        input,
        select {
            line-height: inherit;
            margin: 0;
        }


        h2,
        h3,
        h4,
        input,
        select {
            font-family: inherit;
        }

        h2,
        h3,
        select {
            color: inherit;
        }

        h2 {
            line-height: 1.1;
        }

        p {
            margin: 0 0 10px;
        }

        ol {
            margin-bottom: 10px;
            margin-top: 0;
        }

        label {
            display: inline-block;
            font-weight: 700;
        }

        :focus {
            outline: 0;
        }

        .button {
            -webkit-font-smoothing: antialiased;
            background-color: #2c8b11;
            border-style: initial;
            border-width: 0;
            display: inline-block;
            font-size: 17px;
            font-weight: 700;
            transition: all .2s linear;
            vertical-align: middle;
            zoom: 1;
        }

        @media (min-width: 1200px) {
            .container {
                width: 1080px;
            }
        }


        .clear {
            clear: both;
        }

        .screen-reader-text {
            left: -9999px;
        }

        .container {
            margin-left: auto;
            margin-right: auto;
            padding-left: 15px;
            padding-right: 15px;
        }

        @media (min-width: 768px) {
            .container {
                width: 750px;
            }
        }

        @media (min-width: 992px) {
            .container {
                width: 970px;
            }
        }

        @media (min-width: 1200px) {
            .container {
                width: 1170px;
            }
        }

        .row {
            margin-left: -15px;
            margin-right: -15px;
        }

        .col-md-4 {
            min-height: 1px;
            padding-right: 15px;
            position: relative;
        }

        .col-md-8,
        .col-sm-6 {
            min-height: 1px;
            padding-left: 15px;
            padding-right: 15px;
            position: relative;
        }

        @media (min-width: 768px) {
            .col-sm-6 {
                float: left;
                width: 50%;
            }
        }

        @media (min-width: 992px) {

            .col-md-4,
            .col-md-8 {
                float: left;
            }

            .col-md-8 {
                width: 66.6667%;
            }

            .col-md-4 {
                width: 33.3333%;
            }
        }

        .pagination .active>.page-link,
        .page-link.active {

            background: #2B8B10 !important;
        }

        .page-link {
            color: #2B8B10;
        }
    </style>
@endpush
