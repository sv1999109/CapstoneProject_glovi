<!doctype html>
<html lang="<?php echo e(LaravelLocalization::getCurrentLocale()); ?>" data-layout="vertical" data-sidebar="dark" data-sidebar-size="lg" data-preloader="true" data-theme="material" data-topbar="light" data-bs-theme="light" data-layout-width="fluid" data-sidebar-image="none" data-layout-position="fixed" data-layout-style="default">

<?php echo $__env->make(get_theme_dir('layouts.partials.head', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<body>
    <div id="layout-wrapper">
        <?php echo $__env->make(get_theme_dir('layouts.partials.sidebar', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php echo $__env->make(get_theme_dir('layouts.partials.header', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="main-content">

            <div class="page-content">
                <div class="container-fluid">
                    <!-- container -->
                    <div class="container">
                        <?php echo $__env->yieldContent('content'); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

     <!--start back-to-top-->
     <button class="btn btn-dark btn-icon" id="back-to-top">
        <i class="bi bi-caret-up fs-3xl"></i>
    </button>
    <!--end back-to-top-->

    <!--preloader-->
    <div id="preloader">
        <div id="status">
            <div class="spinner-border text-primary avatar-sm" role="status">
                <span class="visually-hidden">Loading...</span>
            </div>
        </div>
    </div>

    
    <?php echo $__env->make(get_theme_dir('layouts.partials.scripts', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    <?php echo $__env->yieldPushContent('modal'); ?>
    <?php echo $__env->yieldPushContent('scripts'); ?>

    
    <?php if(isset($errors)): ?>
        <?php echo $__env->make(get_theme_dir('toast', 'dashboard'), ['errors' => $errors], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <?php endif; ?>
    
    <?php echo $__env->make(get_theme_dir('flash', 'dashboard'), [], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    
    <?php echo $__env->make(get_theme_dir('modal', 'dashboard'), [], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
</body>

</html>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/layouts/app.blade.php ENDPATH**/ ?>