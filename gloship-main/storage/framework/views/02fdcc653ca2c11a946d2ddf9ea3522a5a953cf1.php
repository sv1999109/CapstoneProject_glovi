<?php
    $pages = \App\Models\Post::where('post_type', 'partner')
        ->limit(12)
        ->orderByDesc('created_at')
        ->get();
?>
<!-- ========== Start partner Section ========== -->
<div class="bg-main2 wow slideInRight py-5" data-wow-delay="0.1s" id="partnerNetworkLayout">
    <div class="container">
        <div class="align-items-center">
            <div class="text-center">
                
                <div class="layouts--header section-title">
                   <h2 class="p-head"> <span class=""><?php echo nl2br(get_content_locale(get_contents('home_partner_title'))); ?></span></h2>
                    <div class="layouts--sub-headline mt-20 font-20 text-muted"><?php echo nl2br(get_content_locale(get_contents('home_partner_desc'))); ?></div>
                    <div class="mt-20 d-none d-sm-block">
                        <a class="link link--blue-underline"
                            href="<?php echo e(route('pages', ['slug' => 'partner'])); ?>"><?php echo e(get_content_locale(get_contents('home_partner_btn'))); ?></a>
                    </div>
                </div>
            </div>

            <div class="mt-3">
                <div class="partners owl-carousel owl-theme">
                    <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $post_title = $post->post_img;
                            $post_img = $post->post_img;
                            $post_slug = $post->post_slug;
                            $post_id = $post->id;
                        ?>


                        <a href="<?php echo e(route('page', ['slug' => $post_slug])); ?>" class="partner-block">
                            <?php if($post_img): ?>
                                <img src="<?php echo e(asset($post_img)); ?>" alt="<?php echo e($post_title); ?>" class="image-partners justify-content-center">
                            <?php endif; ?>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
            </div>
          
        </div>
    </div>
</div>
<!-- ========== End partner Section ========== -->

<style>
    .p-head {
    font-weight: 600;
    font-size: 20px;
    line-height: 120%;
    color: #5b6271;
    text-align: center;
    margin-top: 40px;
}
    .parrner-section .partners {
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        justify-content: space-between;
    }
    .partners {
        margin: 0 auto;
        display: flex;
        flex-wrap: wrap;
        flex; gap:20px;
        justify-content: center;
    }

    .image-partners {
        /* width: 100px; */
        height: 70px;
        align-items: center;
    }
    .partner-block {
    position: relative;
    overflow: hidden;
    text-align: center;
    background-color: #f9f9f9;
    padding: 40px 20px;
    border-right: 1px solid #ebebeb;
}
</style>
<?php $__env->startPush('scripts'); ?>
    <script>
        $(document).ready(function() {

            $('.partnersx').owlCarousel({
                loop: true,
                margin: 30,
                nav: false,
                dots: false,
                autoplay: true,
                smartSpeed: 1000,
                autoplayHoverPause: true,
                navText: [
                    "<i class='bi bi-arrow-left-circle'></i>",
                    "<i class='bi bi-arrow-right-circle'></i>",
                ],
                responsive: {
                    0: {
                        items: 1,
                    },
                    576: {
                        items: 2,
                    },
                    768: {
                        items: 2,
                    },
                    992: {
                        items: 2,
                    },
                    1200: {
                        items: 5,
                    },
                },
            });
            $('.partners').slick({
                
                autoplay: true,
                speed: 2000,
                dots: false,
                arrows: false,
                slidesToShow: 5,
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
                        breakpoint: 600,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    },
                    {
                        breakpoint: 480,
                        settings: {
                            slidesToShow: 2,
                            slidesToScroll: 2
                        }
                    }
                ]
            });
           
        
        });
    </script>
<?php $__env->stopPush(); ?>

<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/sections/partners.blade.php ENDPATH**/ ?>