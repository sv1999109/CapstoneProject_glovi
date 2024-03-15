<?php
    $pages = \App\Models\Post::where('post_type', 'service')
        ->limit(9)
        ->orderByDesc('id')
        ->get();
?>
<!-- ========== Start Services Section ========== -->
<div class="service-section bg-main2 pe-50  wow fadeInUp">
    <div class="container pt-5 pb-5">
        <div class="section-title position-relative text-center mx-auto pb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 600px;">
            <h2 class="mb-3 h-title"><?php echo nl2br(get_content_locale(get_contents('home_service_title'))); ?></h2>
        </div>


        <div class="row text-center justify-content-center">
            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $post_type = $post->post_type;
                    $post_title = get_content_locale($post->post_title);
                    $post_content = get_content_locale($post->post_excerpt);
                    $post_excerpt = $post->post_excerpt;
                    $post_status = $post->post_status;
                    $post_img = $post->post_img;
                    $post_slug = $post->post_slug;
                    $post_id = $post->id;
                ?>
                <a class="col-lg-3 mb-3 me-2 o-service-box shared-border-color"
                    href="<?php echo e(route('page', ['slug' => $post_slug])); ?>">
                    <i class="oic f fa fa-check-circle"></i>
                    <span class="content-color"><?php echo e($post_title); ?></span>
                    <i class="oic s fa fa-check- content-color"></i>


                </a>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

            <div class="mt-4">
                <a class="btn btn-blue" href="<?php echo e(route('pages', ['slug' => 'service'])); ?>">
                   <span class="me-2"> <?php echo nl2br(get_content_locale(get_contents('home_service_desc'))); ?></span> <i
                    class="fa fa-arrow-circle-right"></i>
                </a>
            </div>
        </div>

    </div>

</div>
<!-- ========== End Services Section ========== -->

<?php $__env->startPush('css'); ?>
    <style>
        * {
    box-sizing: border-box;
  }
  .service-section a, .service-section i, .service-section span {
    margin: 0;
  }
  .service-section a {
    margin: 0px 10px;
  }

  .service-section i, span {
    border-style: initial;
    border-width: 0;
  }

  
        .o-service-box {
            background-color: #fff;
            border-style: solid;
            border-width: 1px;
            display: inline-block;
            padding: 20px 30px 0;
            text-align: center;
            -webkit-box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }

        .shared-border-color {
            border-color: #f0f0f0;
        }

        .o-service-box>i {
            display: inline-block;
            font-size: 44px;
            transition: all 200ms linear;
            width: 100%;
        }

        .o-service-box>span {
            display: inherit !important;
            font-size: 115%;
            font-weight: 700 !important;
            padding: 20px 0 0;
            transition: all 200ms linear;
        }

        [class*=" oic-"]::before {
            -webkit-font-smoothing: antialiased;
            font-family: ozythemes;
            line-height: 1;
            speak: none;
        }

        .oic-up-open-mini::before {
            content: "";
        }

        .oic-flaticon5-truck::before {
            content: "";
        }

        .o-service-box>i.s {
            font-size: 64px;
        }

        /* .service-section a:not(.ms-btn):not(.vc_btn3) {
            color: #34ccff;
        } */

        .o-service-box {
            text-decoration: none !important;
        }

        .service-section a:visited {
            text-decoration: underline !important;
        }

        .content-color {
            color: #000;
        }

        [class*=" oic-"]::before {
            font-variant: normal !important;
            font-weight: 400 !important;
            text-transform: none !important;
        }

        .o-service-box:hover {
            background-color: var(--color-primary) !important;
        }

        .o-service-box:hover>* {
            color: #fff !important;
        }
    </style>
<?php $__env->stopPush(); ?>



<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/sections/services.blade.php ENDPATH**/ ?>