<?php $__env->startSection('content'); ?>
<?php echo $__env->make(get_theme_dir('layouts.partials.page-heading-empty'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 600px;">
                <h1 class="mb-3"><?php echo app('translator')->get('messages.Contact_Title'); ?></h1>
                <p class="mb-1"><?php echo app('translator')->get('messages.Contact_Subtitle'); ?></p>
            </div>
            <div class="row g-5">
                <div class="col-lg-7 col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">


                        
                        <?php if(isset($errors) && count($errors) > 0): ?>
                            <div class="alert alert-danger" role="alert">
                                <ul class="list-unstyled mb-0">
                                    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li><?php echo e($error); ?></li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </div>
                        <?php endif; ?>
                        <?php if(Session::has('message')): ?>
                            <div class="alert alert-success" role="alert">
                                <?php echo e(Session::get('message')); ?>

                            </div>
                        <?php endif; ?>
                        <?php if(Session::has('message') != true): ?>
                            <form method="post">
                                <?php echo method_field('POST'); ?>
                                <?php echo csrf_field(); ?>
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                            <label for="name"><?php echo e(trans_choice('messages.Name', 1)); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                            <label for="email"><?php echo e(trans_choice('messages.Email', 1)); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                required>
                                            <label for="subject"><?php echo e(trans_choice('messages.Subject', 1)); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="message" name="message" style="height: 150px" required></textarea>
                                            <label for="message"><?php echo e(trans_choice('messages.Message', 1)); ?></label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3"
                                            type="submit"><?php echo e(trans_choice('messages.Submit', 1)); ?></button>
                                    </div>
                                </div>
                            </form>
                        <?php endif; ?>

                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="section-title position-relative mx-auto mb-4 pb-4">
                        <h3 class="fw-bold mb-0"><?php echo e(trans_choice('messages.Customer_Support', 1)); ?></h3>
                    </div>
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
    <!-- Contact End -->
<?php $__env->stopSection(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/contents/contact.blade.php ENDPATH**/ ?>