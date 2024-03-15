<?php
    $pages = \App\Models\Post::where('post_type', 'faq')
        ->limit(4)
        ->orderByDesc('created_at')
        ->get();
?>
<!-- ========== Start faqs Section ========== -->
<div class="faqs bg-white wow fadeInUp">
    <div class="container pe-50 pt-5">
        <div class="section-title position-relative text-center mx-auto pb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s"
            style="max-width: 600px;">
            <h2 class="mb-3"><?php echo nl2br(get_content_locale(get_contents('home_faq_title'))); ?></h2>
            <p class="mb-1"><?php echo nl2br(get_contents('home_faq_desc')); ?></p>
        </div>
        <div class="row secondary accordion wow slideInLeft pb-5" data-wow-delay="0.1s" id="accordionFlushExample">

            <?php $__currentLoopData = $pages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <?php
                    $post_type = $post->post_type;
                    $post_title = get_content_locale($post->post_title);
                    $post_content = get_content_locale($post->post_content);
                    $post_excerpt = $post->post_excerpt;
                    $post_status = $post->post_status;
                    $post_img = $post->post_img;
                    $post_slug = $post->post_slug;
                    $post_id = $post->id;
                    $url = '<a href="' . route('page', ['slug' => $post_slug]) . '" class="continue_reading">' . trans_choice('messages.Continue_Reading', 1) . '</a>';
                ?>
                <div class="col-md-6">
                    <div class="accordion-item mb-3">
                        <h2 class="accordion-header s-title text-primary" id="a<?php echo e($post_id); ?>">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#faq-<?php echo e($post_id); ?>" aria-expanded="true"
                                aria-controls="a-<?php echo e($post_id); ?>">
                                <ion-icon name="help-circle-outline" class="me-2" style="font-size: 25px">
                                </ion-icon>
                                <?php echo e($post_title); ?>

                            </button>
                        </h2>
                        <div id="faq-<?php echo e($post_id); ?>" class="accordion-collapse collapse"
                            aria-labelledby="a-<?php echo e($post_id); ?>" data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">
                                <?php echo Str::limit(strip_tags(nl2br($post_content)), 500, "... $url"); ?>

                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>

        <div class="section-title position-relative text-center mx-auto pb-5 pb-4" data-wow-delay="0.1s"
        style="max-width: 600px;">
        <a href="<?php echo e(route('pages', ['slug' => 'faq'])); ?>"><span class="fa fa-arrow-right me-2"></span> More Question &amp; Answer</a>
       
    </div>
    </div>

</div>
<!-- ========== End faqs Section ========== -->


<style>
    .accordion-item {
    border: none;
    -webkit-box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    box-shadow: 0 0 10px 0 rgba(0, 0, 0, 0.1);
    border-top-left-radius: 10px;
    border-top-right-radius: 10px;
    border-bottom-left-radius: 10px;
    border-bottom-right-radius: 10px;
    padding: 10px;
}
</style>
  
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/sections/faqs.blade.php ENDPATH**/ ?>