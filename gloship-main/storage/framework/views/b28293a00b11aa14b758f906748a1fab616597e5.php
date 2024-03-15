<?php
    $payment_method = DB::table('payment_methods')
        ->orderBy('id', 'asc')
        ->get();
?>

<?php $__env->startSection('content'); ?>
    <div class="card-header mb-3">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0"><?php echo e(trans_choice('messages.Payment_Method', 2)); ?></h3>
        </div>
    </div>
    
    <?php $__currentLoopData = $payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <?php
            $payment_settings = json_decode(
                DB::table('payment_methods')
                    ->where('id', $pay->id)
                    ->value('fields'),
                true,
            );
        ?>
        <div class="card">
            <form id="form_<?php echo e($pay->name); ?>" data-action="<?php echo e(route('dashboard.payment.update', ['id' => $pay->id])); ?>"
                method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('POST'); ?>
                <input name="type" type="hidden" value="<?php echo e(strtolower($pay->name)); ?>">
                <div class="card-body ">
                    <div class="form-group row">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch">
                                <input name="status" class="form-check-input" type="checkbox" value="1"
                                    id="section_<?php echo e($pay->name); ?>" <?php if($pay->status == '1'): ?> checked <?php endif; ?>>
                                <label class="form-check-label" for="section_<?php echo e($pay->name); ?>">
                                    <?php echo e(__('messages.' . $pay->name)); ?>

                                </label>
                            </div>
                        </div>
                    </div>
                    <div class="section_<?php echo e($pay->name); ?>">
                        <div class="form-group row">
                            <label class="col-sm-4 text-left control-label col-form-label"><?php echo e(trans_choice('messages.Currency', 1)); ?></label>
                            <div class="col-sm-8">
                                <select name="currency" id="currency" class="form-select">
                                    <?php $__currentLoopData = DB::table('exchange_rates')->where('status', 1)->orderBy('id', 'asc')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($item->code); ?>"
                                            <?php if($item->code == $pay->currency): ?> selected <?php endif; ?>><?php echo e($item->code); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 text-left control-label col-form-label"><?php echo e(trans_choice('messages.Mode', 1)); ?></label>
                            <div class="col-sm-8">
                                <select name="test_mode" id="test_mode" class="form-select">
                                   
                                <option value="true" <?php if($pay->test_mode == 'true'): ?> selected <?php endif; ?>><?php echo e(__('messages.Test')); ?></option>
                                <option value="false" <?php if($pay->test_mode == 'false'): ?> selected <?php endif; ?>><?php echo e(__('messages.Live')); ?></option>
                                </select>
                            </div>
                        </div>
                        <?php $__currentLoopData = $payment_settings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <?php if($key != ''): ?>
                                <?php if($key == ''): ?>
                                <?php else: ?>
                                    <div class="form-group row">
                                        <label
                                            class="col-sm-4 text-left control-label col-form-label"><?php echo e(__('messages.' .$key)); ?></label>
                                        <div class="col-sm-8">
                                            <input type="text" name="<?php echo e($key); ?>" class="form-control form-control-lg"
                                                id="<?php echo e($key); ?>" value="<?php echo e($item); ?>">
                                        </div>
                                    </div>
                                <?php endif; ?>
                            <?php endif; ?>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        
                        <div class="form-group row">
                            <label
                                class="col-sm-4 text-left control-label col-form-label"><?php echo app('translator')->get('messages.Payment_Instruction'); ?></label>
                            <div class="col-sm-8">
                                
                                <ul class="nav nav-tabs" id="notemyTab" role="tablist">

                                    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="nav-item" role="presentation">

                                            <button class="nav-link <?php if($localeCode == LaravelLocalization::getCurrentLocale()): ?> active <?php endif; ?>"
                                                id="<?php echo e($pay->name); ?>-<?php echo e($localeCode); ?>-tab-a" data-bs-toggle="tab"
                                                data-bs-target="#<?php echo e($pay->name); ?>-<?php echo e($localeCode); ?>-tab"
                                                type="button" role="tab"
                                                aria-controls="<?php echo e($pay->name); ?>-<?php echo e($localeCode); ?>-tab"
                                                aria-selected="true"><?php echo e($properties['native']); ?></button>

                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                                <div class="tab-content" id="notemyTab">
                                    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $note_current = get_content_locale($pay->instruction, $localeCode);
                                        ?>
                                        <div class="tab-pane fade  <?php if($localeCode == LaravelLocalization::getCurrentLocale()): ?> show active <?php endif; ?>"
                                            id="<?php echo e($pay->name); ?>-<?php echo e($localeCode); ?>-tab" role="tabpanel"
                                            aria-labelledby="<?php echo e($pay->name); ?>-<?php echo e($localeCode); ?>-tab" tabindex="0">

                                            <textarea id="note_<?php echo e($pay->name); ?>" rows="5" placeholder="<?php echo e(__('Payment Instructions')); ?>"
                                                name="instruction[<?php echo e($localeCode); ?>]" class="form-control"><?php echo e($note_current); ?></textarea>
                                        </div>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </div>
                        </div>
                        

                    </div>
                </div>
                
                <div class="card-footer d-flex justify-content-end py-6 px-9">
                    <a href="<?php echo e(url()->previous()); ?>"
                        class="btn btn-light btn-active-light-primary me-2"><?php echo app('translator')->get('messages.Cancel'); ?></a>
                    <button onsubmit="save_payment_data()" type="submit" class="btn btn-success"
                        id="btn_<?php echo e($pay->name); ?>"><?php echo app('translator')->get('messages.Save_Change'); ?></button>
                </div>
            </form>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    
    <script>
        $(document).ready(function() {

            <?php $__currentLoopData = $payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $("input[id='section_<?php echo e($pay->name); ?>']").click(function() {
                    var EValue = $("input[id='section_<?php echo e($pay->name); ?>']:checked").length > 0;
                    if (EValue) {
                        $('.section_<?php echo e($pay->name); ?> input').attr('disabled', false);
                        $('.section_<?php echo e($pay->name); ?> textarea').attr('disabled', false);
                        $('.section_<?php echo e($pay->name); ?> select').attr('disabled', false);
                    } else {
                        $('.section_<?php echo e($pay->name); ?> input').attr('disabled', true);
                        $('.section_<?php echo e($pay->name); ?> textarea').attr('disabled', true);
                        $('.section_<?php echo e($pay->name); ?> select').attr('disabled', true);
                    }
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

        });
    </script>
    

    <script>
        $(document).ready(function() {
            <?php $__currentLoopData = $payment_method; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                $('#form_<?php echo e($pay->name); ?>').submit(function(e) {
                    e.preventDefault();

                    $form = $(this);
                    //show some response on the button
                    $('button[type="submit"]', $form).each(function() {
                        $btn = $(this);
                        $btn.prop('type', 'button');
                        $btn.prop('orig_label', $btn.text());
                        $btn.prop('disabled', true);
                        $btn.html(
                            ' <span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                        );
                    });

                    $.ajax({
                        type: "POST",
                        url: "<?php echo e(route('dashboard.payment.update', ['id' => $pay->id])); ?>",
                        data: $form.serialize(),
                        success: save_data,
                        dataType: 'json',
                        error: function() {
                            Toastify({
                                text: "<?php echo e(__('messages.Unable_To_Process')); ?>",
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "center",
                                backgroundColor: "red",
                            }).showToast();
                            //reverse the response on the button
                            $('button[type="button"]', $form).each(function() {
                                $btn = $(this);
                                label = $btn.prop('orig_label');
                                if (label) {
                                    $btn.prop('type', 'submit');
                                    $btn.text(label);
                                    $btn.prop('orig_label', '');
                                    $btn.prop('disabled', false);
                                }
                            });
                        }
                    });
                });
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        });

    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/settings/payment.blade.php ENDPATH**/ ?>