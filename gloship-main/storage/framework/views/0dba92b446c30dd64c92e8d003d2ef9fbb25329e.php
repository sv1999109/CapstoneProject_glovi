<?php
    $user_lang = LaravelLocalization::getCurrentLocale();
    $customer = '<a href="' . route('dashboard.users.view', ['id' => $shipment->owner_id]) . '"> <span class="btn btn-sm btn-secondary m-1">' . get_user('username', $shipment->owner_id) . '</span> </a>';

    $sender_info = $shipment->sender_name . ': ';
    $sender_info .= $shipment->sender_address . ',';
    $sender_info .= '<br>';
    $sender_info .= get_name($shipment->from_area, 'areas') . ' ';
    $sender_info .= get_name($shipment->sender_city, 'cities');
    $sender_info .= ' - ';
    $sender_info .= get_name($shipment->sender_state, 'states') . ', ';
    $sender_info .= get_name($shipment->sender_country, 'countries');

    $receiver_info = $shipment->receiver_name . ': ';
    $receiver_info .= $shipment->receiver_address . ',';
    $receiver_info .= '<br>';
    $receiver_info .= get_name($shipment->from_area, 'areas') . ' ';
    $receiver_info .= get_name($shipment->receiver_city, 'cities');
    $receiver_info .= '- ';
    $receiver_info .= get_name($shipment->receiver_state, 'states') . ', ';
    $receiver_info .= get_name($shipment->receiver_country, 'countries');
                       
?>

<?php if(isset($packages)): ?>
    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <div class="modal fade text-left" id="package-edit-<?php echo e($package->id); ?>" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="<?php echo e(url('/dashboard/shipments/updatepackage/' . $package->id)); ?>" class="form"
                        method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel110">
                                <?php echo app('translator')->get('messages.Edit'); ?> #<?php echo e($package->id); ?>

                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6 required"><?php echo app('translator')->get('messages.Description'); ?></label>
                                    <input placeholder="<?php echo app('translator')->get('messages.Description'); ?>" type="text"
                                        value="<?php echo e(old('package_description', $package->description)); ?>"
                                        class="form-control <?php $__errorArgs = ['package_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="package_description" required />
                                    <?php $__errorArgs = ['package_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6"><?php echo app('translator')->get('messages.Length_CM'); ?></label>
                                    <input placeholder="<?php echo app('translator')->get('messages.Length'); ?>" type="number" 
                                        value="<?php echo e(old('length', $package->length)); ?>"
                                        class="form-control  <?php $__errorArgs = ['legth'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="length" required />
                                    <?php $__errorArgs = ['length'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6"><?php echo app('translator')->get('messages.Weight_Kg'); ?></label>
                                    <input placeholder="<?php echo app('translator')->get('messages.Width'); ?>" type="number" 
                                        value="<?php echo e(old('width', $package->width)); ?>"
                                        class="form-control width <?php $__errorArgs = ['width'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="width" required />
                                    <?php $__errorArgs = ['width'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6"><?php echo app('translator')->get('messages.Height_CM'); ?></label>
                                    <input placeholder="<?php echo app('translator')->get('messages.Height'); ?>" type="number" 
                                        value="<?php echo e(old('height', $package->weight)); ?>"
                                        class="form-control <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="height" required />
                                    <?php $__errorArgs = ['height'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>



                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6"><?php echo app('translator')->get('messages.Weight_Kg'); ?></label>
                                    <input placeholder="<?php echo app('translator')->get('messages.Weight'); ?>" type="number" 
                                        value="<?php echo e(old('weight', $package->weight)); ?>"
                                        class="form-control weights <?php $__errorArgs = ['total_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                        name="weight" required />
                                    <?php $__errorArgs = ['weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6"><?php echo app('translator')->get('messages.Quantity'); ?></label>
                                    <input placeholder="<?php echo app('translator')->get('messages.Quantity'); ?>" type="number" min="1"
                                        value="<?php echo e(old('qty', $package->qty)); ?>"
                                        class="form-control <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="qty"
                                        required />
                                    <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                        <div class="invalid-feedback">
                                            <?php echo e($message); ?>

                                        </div>
                                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label fw-bold fs-6"><?php echo app('translator')->get('messages.Declared_Value'); ?></label>
                                    <div class="input-group mb-3">
                                        <span
                                            class="input-group-text"><?php echo e(get_money('0', $shipment->currency, 'only_symbol', 'localize')); ?></span>
                                        <input placeholder="<?php echo app('translator')->get('messages.Declared_Value'); ?>" type="number" 
                                            value="<?php echo e(old('value', get_money($package->value, $shipment->currency, 'input', 'localize'))); ?>"
                                            class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            name="value" required />
                                        <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                            <div class="invalid-feedback">
                                                <?php echo e($message); ?>

                                            </div>
                                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                                    </div>
                                </div>
                            </div>
                            

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg align-baseline me-1 "></i>
                                <span class="d"><?php echo app('translator')->get('messages.Close'); ?></span>
                            </button>

                            <button type="submit" class="btn btn-primary ml-1" ddata-bs-dismiss="modal">
                                <i class="bx bx-check "></i>
                                <span class="d"><?php echo app('translator')->get('messages.Save'); ?> </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade text-left" id="package-delete-<?php echo e($package->id); ?>" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel110">
                            <?php echo app('translator')->get('messages.Perform_Action'); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo app('translator')->get('messages.Delete'); ?> <?php echo e(__($package->description)); ?>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg align-baseline me-1"></i>
                            <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                        </button>


                        <a class="btn btn-primary ml-1"
                            href="<?php echo e(url('/dashboard/shipments/deletepackage/' . $package->id)); ?>">
                            <?php echo app('translator')->get('messages.Yes'); ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if(isset($logs)): ?>
    <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        
        <div class="modal fade text-left" id="log-edit-<?php echo e($log->id); ?>" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">
                    <form action="<?php echo e(url('/dashboard/shipments/updatelog/' . $log->id)); ?>" class="form"
                        method="post">
                        <?php echo csrf_field(); ?>
                        <?php echo method_field('POST'); ?>
                        <div class="modal-header">
                            <h5 class="modal-title" id="myModalLabel110">
                                <?php echo app('translator')->get('messages.Edit'); ?>
                            </h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                                
                            </button>
                        </div>
                        <div class="modal-body">
                            <div class="col-md-12">
                                <label class="col-form-label fw-bold fs-6"><?php echo e(__('Note')); ?></label>

                                <select class="form-select <?php $__errorArgs = ['status'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="edit_log"
                                    name="edit_log">
                                    <?php
                                        $statuses = array_flip(note_helper());
                                    ?>
                                    <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($status); ?>"
                                            <?php echo e($status == $log->note ? 'selected' : ''); ?>>
                                            <?php echo e(get_status('shipment-notes', $status)); ?></option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                </select>
                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                                <i class="bi bi-x-lg align-baseline me-1 "></i>
                                <span class="d"><?php echo app('translator')->get('messages.Close'); ?></span>
                            </button>

                            <button type="submit" class="btn btn-primary ml-1" ddata-bs-dismiss="modal">
                                <i class="bx bx-check "></i>
                                <span class="d"><?php echo app('translator')->get('messages.Save'); ?> </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="modal fade text-left" id="log-delete-<?php echo e($log->id); ?>" tabindex="-1"
            aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
            <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
                <div class="modal-content">

                    <div class="modal-header">
                        <h5 class="modal-title" id="myModalLabel110">
                            <?php echo app('translator')->get('messages.Perform_Action'); ?>
                        </h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                            
                        </button>
                    </div>
                    <div class="modal-body">
                        <?php echo app('translator')->get('messages.Delete'); ?> <?php echo e(get_status('shipment-notes', $log->note)); ?>


                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                            <i class="bi bi-x-lg align-baseline me-1"></i>
                            <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                        </button>


                        <a class="btn btn-primary ml-1"
                            href="<?php echo e(url('/dashboard/shipments/deletelog/' . $log->id)); ?>">
                            <?php echo app('translator')->get('messages.Yes'); ?>
                        </a>
                    </div>

                </div>
            </div>
        </div>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>


<?php if(isset($id)): ?>
    
    <div class="modal fade text-left" id="approve-<?php echo e($id); ?>" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="approvemodal">
                        <?php echo app('translator')->get('messages.Approve'); ?> <?php echo e(trans_choice('messages.Shipment', 1)); ?>: <?php echo e($code); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>
                        <?php echo app('translator')->get('messages.Shipping_Cost'); ?>:
                        <strong><?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?></strong>
                        <hr>
                        <?php echo e(trans_choice('messages.Payment_Method', 1)); ?>:
                        <strong><?php echo e(__('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name'))); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Payment_Type'); ?>:
                        <strong><?php echo e($shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid')); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Invoice_Status'); ?>:
                        <strong><?php echo e($shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid')); ?></strong>
                        <hr>
                    </p>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                    <p>
                        <?php echo $sender_info; ?> 
                    </p>
                    <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                    <p>
                        <?php echo $receiver_info; ?> 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'approve'])); ?>">
                        <?php echo app('translator')->get('messages.Yes'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade text-left" id="paid-<?php echo e($id); ?>" tabindex="-1" aria-labelledby="approvemodal"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="paidmodal">
                        <?php echo e(trans_choice('messages.Invoice', 1)); ?>: #<?php echo e($shipment->invoice_id); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>
                        <?php echo app('translator')->get('messages.Shipping_Cost'); ?>:
                        <strong><?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?></strong>
                        <hr>
                        <?php echo e(trans_choice('messages.Payment_Method', 1)); ?>:
                        <strong><?php echo e(__('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name'))); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Payment_Type'); ?>:
                        <strong><?php echo e($shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid')); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Invoice_Status'); ?>:
                        <strong><?php echo e($shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid')); ?></strong>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'paid'])); ?>">
                        <?php echo app('translator')->get('messages.Mark_Paid'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

     
     <div class="modal fade text-left" id="ready-for-shipment-<?php echo e($id); ?>" tabindex="-1"
     aria-labelledby="approvemodal" aria-modal="true" role="dialog">
     <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
         <div class="modal-content">

             <div class="modal-header">
                 <h5 class="modal-title" id="ready-for-shipment-modal">
                     <?php echo e(trans_choice('messages.Mark_Ready_For_Shipment', 1)); ?>: #<?php echo e($shipment->code); ?>

                 </h5>
                 <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                     
                 </button>
             </div>
             <div class="modal-body">
                 <p>
                     <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                     <hr>
                 </p>

                 <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                 <p>
                     <?php echo $sender_info; ?> 
                 </p>
                 <hr>
                 <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                 <p>
                     <?php echo $receiver_info; ?> 
                 </p>
             </div>
             <div class="modal-footer">
                 <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                     <i class="bi bi-x-lg align-baseline me-1"></i>
                     <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                 </button>
                 <a class="btn btn-primary ml-1"
                     href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 3])); ?>">
                     <?php echo app('translator')->get('messages.Mark_Ready_For_Shipment'); ?>
                 </a>
             </div>

         </div>
     </div>
 </div>

    
    <div class="modal fade text-left" id="shipped-<?php echo e($id); ?>" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="shipped-modal">
                        <?php echo e(trans_choice('messages.Mark_Shipped', 1)); ?>: #<?php echo e($shipment->code); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>
                    </p>

                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                    <p>
                        <?php echo $sender_info; ?> 
                    </p>
                    <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                    <p>
                        <?php echo $receiver_info; ?> 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 4])); ?>">
                        <?php echo app('translator')->get('messages.Mark_Shipped'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade text-left" id="out-for-delivery-<?php echo e($id); ?>" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="out-for-delivery-modal">
                        <?php echo e(trans_choice('messages.Mark_Out_For_Delivery', 1)); ?>: #<?php echo e($shipment->code); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                    <p> 

                        <?php echo $sender_info; ?> 

                    </p>
                    <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                    <p>
                        <?php echo $receiver_info; ?> 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 8])); ?>">
                        <?php echo app('translator')->get('messages.Mark_Out_For_Delivery'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade text-left" id="delivered-<?php echo e($id); ?>" tabindex="-1"
        aria-labelledby="approvemodal" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="delivered-modal">
                        <?php echo e(trans_choice('messages.Mark_Delivered', 1)); ?>: #<?php echo e($shipment->code); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>

                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                    <p>
                        <?php echo $sender_info; ?> 

                    </p>
                    <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                    <p>
                        <?php echo $receiver_info; ?> 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 13])); ?>">
                        <?php echo app('translator')->get('messages.Mark_Out_For_Delivery'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

    
    <div class="modal fade text-left" id="cancel-<?php echo e($id); ?>" tabindex="-1" aria-labelledby="cancelmodal"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="cancel-modal">
                        <?php echo e(trans_choice('messages.Cancel_Shipment', 1)); ?>: #<?php echo e($shipment->code); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>
                        <?php echo app('translator')->get('messages.Shipping_Cost'); ?>:
                        <strong><?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?></strong>
                        <hr>
                        <?php echo e(trans_choice('messages.Payment_Method', 1)); ?>:
                        <strong><?php echo e(__('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name'))); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Payment_Type'); ?>:
                        <strong><?php echo e($shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid')); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Invoice_Status'); ?>:
                        <strong><?php echo e($shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid')); ?></strong>
                        <hr>
                    </p>
                    <p>

                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                    <p>
                        <?php echo $sender_info; ?> 

                    </p>
                    <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                    <p>
                        <?php echo $receiver_info; ?> 
                    </p>
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 10])); ?>">
                        <?php echo app('translator')->get('messages.Cancel_Shipment'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

    

    <div class="modal fade text-left" id="reject-<?php echo e($id); ?>" tabindex="-1" aria-labelledby="rejectmodal"
        aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="rejectmodal">
                        <?php echo app('translator')->get('messages.Reject'); ?> <?php echo e(trans_choice('messages.Shipment', 1)); ?>: <?php echo e($code); ?>

                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <p>
                        <?php echo e(trans_choice('messages.Customer', 1)); ?>: <?php echo $customer; ?>

                        <hr>
                        <?php echo app('translator')->get('messages.Shipping_Cost'); ?>:
                        <strong><?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?></strong>
                        <hr>
                        <?php echo e(trans_choice('messages.Payment_Method', 1)); ?>:
                        <strong><?php echo e(__('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name'))); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Payment_Type'); ?>:
                        <strong><?php echo e($shipment->payment_type == '1' ? __('messages.PostPaid') : __('messages.PrePaid')); ?></strong>
                        <hr>
                        <?php echo app('translator')->get('messages.Invoice_Status'); ?>:
                        <strong><?php echo e($shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid')); ?></strong>
                        <hr>
                    </p>
                    <p>
    
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Sender'); ?>:</h4>
                    <p>
                        <?php echo $sender_info; ?> 
    
                    </p>
                    <hr>
                    <h4 style="margin: 0"><?php echo app('translator')->get('messages.Recipient'); ?>:</h4>
                    <p>
                        <?php echo $receiver_info; ?> 
                    </p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>
                    <a class="btn btn-primary ml-1"
                        href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'reject'])); ?>">
                        <?php echo app('translator')->get('messages.Reject'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>

    

    <div class="modal fade text-left" id="delete-<?php echo e($id); ?>" tabindex="-1"
        aria-labelledby="myModalLabel110" aria-modal="true" role="dialog">
        <div class="modal-dialog modal-dialog-centered modal-dialog-scrollable" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="myModalLabel110">
                        <?php echo app('translator')->get('messages.Perform_Action'); ?>
                    </h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close">
                        
                    </button>
                </div>
                <div class="modal-body">
                    <?php echo app('translator')->get('messages.Delete'); ?> <?php echo e(trans_choice('messages.Shipment', 1)); ?>:
                    <strong><?php echo e($code); ?></strong>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal">
                        <i class="bi bi-x-lg align-baseline me-1"></i>
                        <span class=""><?php echo app('translator')->get('messages.Cancel'); ?> </span>
                    </button>


                    <a class="btn btn-primary ml-1" href="<?php echo e(route('dashboard.shipments.delete', ['id' => $id])); ?>">
                        <?php echo app('translator')->get('messages.Yes'); ?>
                    </a>
                </div>

            </div>
        </div>
    </div>
<?php endif; ?>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/modal.blade.php ENDPATH**/ ?>