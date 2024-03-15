<!DOCTYPE html>
<html lang="<?php echo e(LaravelLocalization::getCurrentLocale()); ?>">


<?php echo $__env->make(get_theme_dir('layouts.partials.head'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>


<body>
   
    
    <div id="app-layout">

        
        <?php echo $__env->make(get_theme_dir('layouts.partials.header'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        

        
        <?php echo $__env->yieldContent('content'); ?>
        

        
        <?php echo $__env->make(get_theme_dir('layouts.partials.footer'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        


       
    </div>
     <!-- ========== Start preloader ========== -->
    <div id="preloader">

        <div class="small1">
            <div class="small ball smallball1"></div>
            <div class="small ball smallball2"></div>
            <div class="small ball smallball3"></div>
            <div class="small ball smallball4"></div>
        </div>


        <div class="small2">
            <div class="small ball smallball5"></div>
            <div class="small ball smallball6"></div>
            <div class="small ball smallball7"></div>
            <div class="small ball smallball8"></div>
        </div>

        <div class="bigcon">
            <div class="big ball"></div>
        </div>
    </div>
    
    <!-- ==========  End preloader ========== -->
     
     <?php echo $__env->make(get_theme_dir('layouts.partials.scripts'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
     
</body>

</html>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/layouts/app.blade.php ENDPATH**/ ?>