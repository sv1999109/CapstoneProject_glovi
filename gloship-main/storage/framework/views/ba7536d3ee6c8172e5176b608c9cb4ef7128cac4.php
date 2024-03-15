<?php $__env->startSection('content'); ?>
    <div class="site-content">

        
        <?php if(get_theme_config('section_home_hero') == 'enabled'): ?>
            <?php echo $__env->make(get_theme_dir('home.sections.hero'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        
        <?php echo $__env->make(get_theme_dir('home.sections.feature'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php if(get_theme_config('section_home_partner') == 'enabled'): ?>
            <?php echo $__env->make(get_theme_dir('home.sections.partners'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

        <?php echo $__env->make(get_theme_dir('home.sections.custom-2'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php if(get_theme_config('section_home_service') == 'enabled'): ?>
            <?php echo $__env->make(get_theme_dir('home.sections.services'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

       
        <?php echo $__env->make(get_theme_dir('home.sections.quote'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        <?php if(get_theme_config('section_home_faq') == 'enabled'): ?>
            <?php echo $__env->make(get_theme_dir('home.sections.faqs'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

        
        <?php if(get_theme_config('section_home_counter') == 'enabled'): ?>
            <?php echo $__env->make(get_theme_dir('home.sections.counter'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

        
        <?php if(get_theme_config('section_home_blog') == 'enabled'): ?>
            <?php echo $__env->make(get_theme_dir('home.sections.blog'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php endif; ?>
        

        <?php echo $__env->make(get_theme_dir('home.sections.custom'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/index.blade.php ENDPATH**/ ?>