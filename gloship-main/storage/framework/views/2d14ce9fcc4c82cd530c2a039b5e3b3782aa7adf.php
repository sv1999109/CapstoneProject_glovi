<?php
    $pages = \App\Models\Post::where('post_type', 'blog')
        ->limit(6)
        ->orderByDesc('created_at')
        ->get();
?>

<section class="blog bg-white pb-5">
    <div class="container">


        <div class="mb-4 pt-5">

            <div class="d-flex">
                <div class="flex-grow-1">
                    <h1 class="text-uppercase text-left"><?php echo nl2br(get_content_locale(get_contents('home_news_title'))); ?></h1>
                    <h6 class="align-items-end text-muted"><?php echo nl2br(get_content_locale(get_contents('home_news_desc'))); ?></h6>

                </div>
                <div class="flex-grow-0">
                    <div class="d-flex">
                        <a href="<?php echo e(route('pages', ['slug' => 'blog'])); ?>" target="_self" class="generic-button"><span
                                class="me-2">VIEW ALL</span><i class="fa fa-arrow-circle-right">&nbsp;</i></a>
                    </div>
                </div>
            </div>
        </div>

        <div class="row gap-4x blog-slider">

            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
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
                ?>
                <div class="col-lg-4 mb-3">
                    <div class="post-block ">

                        <?php if($post_img): ?>
                            <a href="<?php echo e(route('blog.post', ['slug' => $post_slug])); ?>" class="pic">

                                <img width="691" height="350" alt="<?php echo e($post_title); ?>"
                                    class="post-block__image js--lazyload" data-lazyload="<?php echo e(asset($post_img)); ?>"
                                    src="<?php echo e(asset($post_img)); ?>">
                            </a>
                        <?php endif; ?>

                        
                        <h3 class="post-block__heading">
                            <a href="<?php echo e(route('blog.post', ['slug' => $post_slug])); ?>"><?php echo e($post_title); ?></a>
                        </h3>

                        <div class="post-block__body">
                            <p><?php echo $contents; ?></p>
                        </div> <a href="<?php echo e(route('blog.post', ['slug' => $post_slug])); ?>"
                            class="main-btn light-btn text-uppercase">
                            <?php echo e(trans_choice('messages.Continue_Reading', 1)); ?>

                        </a>

                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>

</section>
<?php $__env->startPush('scripts'); ?>
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
<?php $__env->stopPush(); ?>

<?php $__env->startPush('css'); ?>
    <style>
       .post-block {
           height: 320px;
           margin:  5px !important;
       }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/sections/blog.blade.php ENDPATH**/ ?>