<section class="contact-wrap pad-120">
    <span class="bg-text wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"> Contact </span>
    <div class="theme-container container">
        <div class="row">
            <div class="col-md-6 col-sm-8">
                <div class="title-wrap">
                    <h2 class="section-title wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;"><?php echo e(trans_choice('messages.Customer_Support', 1)); ?></h2>
                    <p class="wow fadeInLeft" data-wow-offset="50" data-wow-delay=".20s"
                        style="visibility: visible; animation-delay: 0.2s; animation-name: fadeInLeft;">Get in touch
                        with us easily</p>
                </div>
                <div class="contact wow fadeInUp" data-wow-delay="0.5s">
                
                  <?php if(get_config('site_head_office')): ?>
                     <div class="card mb-3">
                      <p class="py-3 px-3"><i
                          class="fa fa-map-marker-alt  fa-2x text-primary me-3"></i><?php echo e(get_config('site_head_office')); ?></p>
                     </div>
                  <?php endif; ?>
                  <?php if(get_config('site_phone')): ?>

                  <div class="card mb-3">
                      <p class="py-3 px-3"><i class="fa fa-phone-alt  fa-2x text-primary me-3"></i><?php echo e(get_config('site_phone')); ?>

                      </p>
                    </div>
                  <?php endif; ?>
                  <?php if(get_config('site_email_support')): ?>
                  <div class="card mb-3">
                      <p class="py-3 px-3">
                          <span class=""><i
                              class="bi bi-envelope me-3 text-primary fa-2x"></i></span> 
                          <span class=" float-center"><?php echo e(get_config('site_email_support')); ?></span> 
                      </p>
                  </div>
                  <?php endif; ?>
                  <?php if(get_config('live_chat_embed')): ?>
                      <div class="card rounded text-center px-4 mt-4">
                          <h3 class="fw-bold mb-4"><?php echo e(trans_choice('messages.Need_Any_Help', 1)); ?></h3>
                          <a class="btn btn-primary py-3 px-5" href="<?php echo e(get_config('live_chat_embed')); ?>"
                              target="_blank"><?php echo e(trans_choice('messages.Let_Chat', 1)); ?></a>
                      </div>
                  <?php endif; ?>
              </div>
            </div>
        </div>
    </div>
</section>
<?php $__env->startPush('css'); ?>
    <style>
        .contact-wrap {
            background-image: url(<?php echo e(asset('assets/img/MAP.png')); ?>);
            background-position: right center;
            background-repeat: no-repeat;
            position: relative;
        }

        .pad-120 {
            padding-bottom: 120px;
            padding-top: 120px;
        }

        @media (max-width: 767px) {
            .pad-120 {
                padding-bottom: 60px;
                padding-top: 60px;
            }
        }

        .contact-detail {
            margin: 35px 0 0;
        }

        .font-2,
        .font2-title1,
        .title-1,
        .title-2,
        .title-3,
        .btn-1,
        .btn-round,
        .theme-countdown {
            font-family: 'Poppins', sans-serif;
            font-weight: 600;
        }

        .title-2,
        .widget-title-2 {
            font-size: 14px;
        }

        .contact-wrap ul,
        .contact-wrap ol {
            padding-left: 0;
            list-style: none;
            margin-bottom: 20px;
        }

        .contact-detail>li {
            padding-top: 17px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/sections/custom.blade.php ENDPATH**/ ?>