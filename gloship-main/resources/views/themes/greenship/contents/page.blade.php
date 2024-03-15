@extends(get_theme_dir('layouts.app'))
@section('content')
@include(get_theme_dir('layouts.partials.page-heading'))
    <div class="site-content">
        <div id="posts" class="">
            <div class="container">
                <div class="row">

                    <div class="col-md-12 py-lg-5 px-lg-5">
                       
                        <div class="row secondary @if ($page == 'faq') accordion wow slideInLeft @endif mb-4">
                            @foreach ($pages as $post)
                                @php
                                    $post_type = $post->post_type;
                                    $post_title = get_content_locale($post->post_title);
                                    $post_content = get_content_locale($post->post_content);
                                    $contents = Str::limit(strip_tags($post_content), 150, '...');
                                    //$post_excerpt = $post->post_excerpt;
                                    $post_excerpt = get_content_locale($post->post_excerpt);
                                    $post_excerpt = Str::limit(strip_tags($post_excerpt), 150, '...');
                                    $post_status = $post->post_status;
                                    $post_img = $post->post_img;
                                    $post_slug = $post->post_slug;
                                    $post_id = $post->id;
                                    $url = '<a href="' . route('page', ['slug' => $post_slug]) . '" class="">' . trans_choice('messages.Continue_Reading', 1) . '</a>';
                                @endphp

                                {{-- page template --}}
                                @if ($post_type == 'service')
                                    <div class="col-md-6 mt-3 mb-3 wow fadeInUp" data-wow-delay="0.3s">
                                        <div class="card  p-3" style="box-sizing: border-box;">
                                            <div class="mt-3 text-center">
                                                @if ($post_img)
                                                    <a href="{{ route('page', ['slug' => $post_slug]) }}" class="pic">

                                                        <img width="691" height="350" alt="{{ $post_title }}"
                                                            class="attachment-featured-post js--lazyload"
                                                            data-lazyload="{{ asset($post_img) }}"
                                                            src="{{ asset($post_img) }}" style="height: 220px">
                                                    </a>
                                                @endif
                                                <a href="{{ route('page', ['slug' => $post_slug]) }}" class="">
                                                    <h3 class="mt-3 text-truncate s-title">{{ $post_title }}</h3>
                                                    <div class="text justify-content mt-3 s-text text-dark mb-3">{!! Str::limit(strip_tags($post_excerpt), 150, '...') !!}
                                                    </div>

                                                    <span class="btn btn-primary"> <i class="fa fa-arrow-right"></i></span>
                                                   
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                @elseif ($post_type == 'faq')
                                    <div class="col-md-6">
                                        <div class="accordion-item mb-3">
                                            <h2 class="accordion-header s-title text-primary" id="a{{ $post_id }}">
                                                <button class="accordion-button collapsed" type="button"
                                                    data-bs-toggle="collapse" data-bs-target="#faq-{{ $post_id }}"
                                                    aria-expanded="true" aria-controls="a-{{ $post_id }}">
                                                    <ion-icon name="help-circle-outline" class="me-2"
                                                        style="font-size: 25px">
                                                    </ion-icon>
                                                    {{ $post_title }}
                                                </button>
                                            </h2>
                                            <div id="faq-{{ $post_id }}" class="accordion-collapse collapse"
                                                aria-labelledby="a-{{ $post_id }}"
                                                data-bs-parent="#accordionFlushExample">
                                                <div class="accordion-body">
                                                    {!! Str::limit(strip_tags(nl2br($post_content)), 500, "... $url") !!}
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <br class="clear">
                                @elseif ($post_type == 'partner')
                                    <div class="partner-logo-circle sal-animate col-lg-3 mb-3" data-sal="fade" data-sal-duration="1000"
                                        data-sal-easing="ease">
                                        <a href="{{ route('page', ['slug' => $post_slug]) }}">
                                            @if ($post_img)
                                                <img data-lazyload="{{ asset($post_img) }}" src="{{ asset($post_img) }}"
                                                    alt="{{ $post_title }}" class="img-fluid partner-color xjs--lazyload"
                                                    width="80" height="80">
                                            @endif
                                        </a>
                                    </div>
                                @else
                                    <div class="col-lg-4 mb-3">
                                        <div class="post-block ">
                                            <div>

                                                @if ($post_img)
                                                    <a href="{{ route('blog.post', ['slug' => $post_slug]) }}" class="pic">
                        
                                                        <img width="691" height="350" alt="{{ $post_title }}"
                                                            class="post-block__image js--lazyload" data-lazyload="{{ asset($post_img) }}"
                                                            src="{{ asset($post_img) }}">
                                                    </a>
                                                @endif
                        
                                                <div class="post-block__date">
                                                   {{ Carbon\Carbon::parse($post->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d')}}
                                                </div>
                                                <h3 class="post-block__heading">
                                                    <a href="{{ route('blog.post', ['slug' => $post_slug]) }}">{{ $post_title }}</a>
                                                </h3>
                        
                                                <div class="post-block__body">
                                                    <p>{!! $contents !!}</p>
                                                </div> <a href="{{ route('blog.post', ['slug' => $post_slug]) }}"
                                                    class="main-btn light-btn text-uppercase">
                                                    {{ trans_choice('messages.Continue_Reading', 1) }}
                                                </a>
                        
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endforeach

                            @if (!isset($post->id))
                                <p>
                                <h6 class="text-center">@lang('messages.No_Record_Found')</h6>
                                </p>
                            @endif
                        </div>
                        {!! $pages->links() !!}
                    </div>
                    {{-- @include(get_theme_dir('contents.sidebar'), [
                        'post_type' => $page,
                    ]) --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        .post-block {
           /* gap: 50px; */
           gap: 20;
            margin-left:  2px !important;
        }
        .partner-color {
            width: auto;
            height: 180px;
        }
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
            /* color: #337ab7; */
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
            background-color: #var(--color-primary);
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

            background: var(--color-primary) !important;
        }

        .page-link {
            color: var(--color-primary);
        }
    </style>
@endpush
