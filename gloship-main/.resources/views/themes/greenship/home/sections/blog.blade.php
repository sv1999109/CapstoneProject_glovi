@php
    $pages = \App\Models\Post::where('post_type', 'blog')
        ->limit(6)
        ->orderByDesc('created_at')
        ->get();
@endphp

<section class="blog bg-white pb-5">
    <div class="container">


        <div class="mb-4 pt-5">

            <div class="d-flex">
                <div class="flex-grow-1">
                    <h1 class="text-uppercase text-left">{!! nl2br(get_content_locale(get_contents('home_news_title'))) !!}</h1>
                    <h6 class="align-items-end text-muted">{!! nl2br(get_content_locale(get_contents('home_news_desc'))) !!}</h6>

                </div>
                <div class="flex-grow-0">
                    <div class="d-flex">
                        <a href="{{ route('pages', ['slug' => 'blog']) }}" target="_self" class="generic-button"><span
                                class="me-2">VIEW ALL</span><i class="fa fa-arrow-circle-right">&nbsp;</i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gap-4x blog-slider">

            @foreach ($pages as $post)
                @php
                    $post_type = $post->post_type;
                    $post_title = get_content_locale($post->post_title);
                    $post_content = get_content_locale($post->post_content);
                    $contents = Str::limit(strip_tags($post_content), 200, '...');
                    $post_excerpt = $post->post_excerpt;
                    $post_status = $post->post_status;
                    $post_img = $post->post_img;
                    $post_slug = $post->post_slug;
                    $post_id = $post->id;
                    $url = '<a href="' . route('page', ['slug' => $post_slug]) . '" class="">' . trans_choice('messages.Continue_Reading', 1) . '</a>';
                    $created_at = \Carbon\Carbon::parse($post->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d');
                @endphp
                <div class="col-lg-4 mb-3">
                    <div class="post-block ">

                        @if ($post_img)
                            <a href="{{ route('blog.post', ['slug' => $post_slug]) }}" class="pic">

                                <img width="691" height="350" alt="{{ $post_title }}"
                                    class="post-block__image js--lazyload" data-lazyload="{{ asset($post_img) }}"
                                    src="{{ asset($post_img) }}">
                            </a>
                        @endif

                        {{-- <div class="post-block__date">
                            {{ Carbon\Carbon::parse($post->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d')}}
                        </div> --}}
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
            @endforeach
        </div>
    </div>

</section>
@push('scripts')
    <script>
        $(document).ready(function() {

            $('.blog-slider').slick({

                autoplay: true,
                speed: 2000,
                dots: false,
                arrows: false,
                slidesToShow: 3,
                responsive: [{
                        breakpoint: 1024,
                        settings: {
                            slidesToShow: 3,
                            slidesToScroll: 3,
                            infinite: true,
                            dots: false
                        }
                    },
                    {
                        breakpoint: 900,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 1,
                            slidesToScroll: 1
                        }
                    }
                ]
            });
            $('#blog-prev-arrow').click(function() {
                $('.blog-slider').slick('slickPrev');
            });

            $('#blog-next-arrow').click(function() {
                $('.blog-slider').slick('slickNext');
            });

        });
    </script>
@endpush

@push('css')
    <style>
       .post-block {
           height: 320px;
           margin:  5px !important;
       }
    </style>
@endpush
