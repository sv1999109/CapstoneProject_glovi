@php
    $post_type = $post->post_type;
    $post_title = get_content_locale($post->post_title);
    $post_content = get_content_locale($post->post_content);
    $post_excerpt = $post->post_excerpt;
    $post_status = $post->post_status;
    $post_img = $post->post_img;
    $post_slug = $post->post_slug;
    $post_category = DB::table('post_category')
        ->where('post_id', $post->id)
        ->distinct('category_id')
        ->get();
   
    $user = \App\Models\User::where('id', $post->post_author)->first();
    $author_name = $user->firstname . ' ' . $user->lastname;
    if ($user->avatar) {
        $avatar = '<img class="avatar photo" src="' . asset($user->avatar) . '" alt="" srcset="">';
    } else {
        $avatar_char1 = substr($user->firstname, 0, 1);
        $avatar = '<img class="avatar photo" src="' . $user->avatar . '" alt="" srcset="">';
    }
    $created_at = \Carbon\Carbon::parse($post->created_at)->setTimezone(\Helpers::getUserTimeZone());
@endphp
@extends(get_theme_dir('layouts.app'))
@section('content')
@include(get_theme_dir('layouts.partials.page-heading-empty'))
    <div class="site-content bg-main2">
        <div id="posts" class="post-page">
            <div class="container mb-5">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card bg-white px-5 py-5">
                        <h1 class="title">{{ $post_title }}</h1>
                        @if ($post_type == 'blog')
                        <div class="d-flex">
                           <div>
                            {!! $avatar !!}
                           </div>
                            <div class="author">
                                @lang('messages.By') {{ $author_name }}<br>
                                {{ $created_at }}
                                @can('do_moderator')
                                    <br>
                                    <a href="{{ route('dashboard.posts.edit', ['id' => $post->id]) }}">@lang('messages.Edit')</a>
                                @endcan
                            </div>
                        </div>
                            
                        @endif
                        @if ($post_img)
                            <div class="js--lazyload">
                                <img width="691" height="350" alt="{{ $post_title }}" 
                                class="post-img js--lazyload" src="{{ asset($post_img) }}" data-lazyload="{{ asset($post_img) }}">
                            </div>
                            
                        @endif

                        <div class="content">
                            {!! $post_content !!}
                            @if ($post_type == 'blog')
                                @foreach ($post_category as $item)
                                    <a href="{{ route('blog', ['cat' => $item->category_id]) }}" class="btn btn-sm btn-secondary">
                                        {{ get_content_locale(get_name($item->category_id, 'categories'), LaravelLocalization::getCurrentLocale()) }}
                                    </a>
                                @endforeach
                            @else
                                <br>
                                @can('do_moderator')
                                    <br>
                                    <a href="{{ route('dashboard.posts.edit', ['id' => $post->id]) }}">@lang('messages.Edit')</a>
                                @endcan
                            @endif

                        </div>
                       </div>
                    </div>
                    {{-- @include(get_theme_dir('contents.sidebar'), [
                        'post_type' => $post_type,
                    ]) --}}
                </div>
            </div>
        </div>
    </div>
@endsection
@push('css')
    <style>
        

        .avatar {
            border-radius: 100px;
            float: left;
            width: 56px;
        }

        .author {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            margin-left: 8px;
            padding-top: 4px;
            position: relative;
        }


        .author-img {
            border-style: initial;
            border-width: 0;
            height: auto;
            max-width: 100%;
            vertical-align: middle;
        }

        .post-img {
            border-style: initial;
            border-width: 0;
            height: auto;
            max-width: 100%;
            vertical-align: middle;
        }



        h4 {
            color: inherit;
        }

        h1,
        h2,
        h4,
        h6 {
            font-family: inherit;
        }

        h2,
        h6 {
            line-height: 1.1;
        }

        h1 {
            color: inherit;
        }

        p {
            margin: 0 0 10px;
        }



        .lazyload {
            opacity: 0;
        }

        .lazyloaded {
            opacity: 1;
            transition: opacity 400ms 0ms;
        }

        .screen-reader-text {
            left: -9999px;
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
            .col-md-8 {
                float: left;
                width: 66.6667%;
            }
        }

        :focus {
            outline: 0;
        }

        .screen-reader-text {
            border-style: initial;
            border-width: 0;
            clip: rect(1px, 1px, 1px, 1px);
            clip-path: inset(50%);
            height: 1px;
            margin: -1px;
            overflow: hidden;
            padding: 0;
            width: 1px;
        }



        .post .avatar {
            border-radius: 100px;
            float: left;
            width: 56px;
        }

        .screen-reader-text:focus {
            background-color: #ddd;
            clip-path: none;
            color: #444;
            display: block;
            font-size: 1em;
            height: auto;
            left: 5px;
            line-height: normal;
            padding: 15px 23px 14px;
            text-decoration: none;
            top: 5px;
            width: auto;
            z-index: 100000;
        }

        .content {
            color: #777;
            font-size: 18px;
            line-height: 1.7;
        }

        .content {
            clear: both;
        }

        .content h2 {
            color: #000;
            font-size: 28px;
            font-weight: 700;
            margin: 40px 0 24px;
        }

        .post .title {
            font-size: 42px;
            font-weight: 900;
            line-height: 1.3;
            margin: 0 0 30px;
        }

        .post .author {
            color: #666;
            font-size: 16px;
            margin-bottom: 30px;
            margin-left: 80px;
            padding-top: 4px;
            position: relative;
        }

        .other-posts {
            margin: 30px 0 !important;
        }

        .screen-reader-text {
            overflow-wrap: normal !important;
        }

        .screen-reader-text:focus {
            clip: auto !important;
        }
    </style>
@endpush
