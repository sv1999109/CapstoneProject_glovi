<?php
    $form_add = '';
?>

<?php $__env->startSection('content'); ?>
    <div class="mb-3">
        <div class="card-header">
            <div class="card-title m-0">
                <h3 class="fw-bolder m-0"><?php echo e(__('messages.Create_New_Shipment')); ?></h3>
            </div>
        </div>
    </div>

        <form action="<?php echo e(route('dashboard.shipments.getcost')); ?>" id="shipment_create_formxx" class="form" method="post" enctype="multipart/form-data">
            <?php echo method_field('POST'); ?>
            <?php echo $__env->make(get_theme_dir('shipment.forms.create', 'dashboard'), [
                'FormType' => 'create',
                'FormAdd' => $form_add,
            ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

            <div class="card-footer d-flex justify-content-end px-9 py-6 mb-3">
                <a href="<?php echo e(route('dashboard.shipments')); ?>" class="btn btn-light btn-active-light-primary me-2"><?php echo app('translator')->get('messages.Discard'); ?></a>
                <button type="submit" class="btn btn-primary me-2">
                    <?php echo app('translator')->get('messages.Proceed'); ?>
                    <i class="fa fa-chevron-circle-right"></i>
                </button>                
            </div>

        </form>

<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .fade:not(.show) {
            display: none;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    
    <?php echo $__env->make(get_theme_dir('shipment.scripts', 'dashboard'), [
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<?php $__env->stopPush(); ?>


<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/create.blade.php ENDPATH**/ ?>