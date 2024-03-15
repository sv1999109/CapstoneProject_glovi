<?php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();

    // fetch active branches
    $branches = \App\Models\Branches::where('status', 1)
        ->orderBy('id', 'asc')
        ->get();

    $role = Auth()->user()->role;
    $user_id = Auth()->user()->id;
    $address_sender = [];
    $address_recipient = [];

    if (isset($user->id)) {
        $address_sender = DB::table('addresses')
            ->whereRaw("address_type = '1' AND owner_id = '$user->id'")
            ->orderBy('firstname', 'asc')
            ->get();
        $address_recipient = DB::table('addresses')
            ->whereRaw("address_type = '2' AND owner_id = '$user->id'")
            ->orderBy('firstname', 'asc')
            ->get();
    }

    //user is customer
    if ($role == 1) {
        $address_sender = DB::table('addresses')
            ->whereRaw("address_type = '1' AND owner_id = '$user_id'")
            ->orderBy('firstname', 'asc')
            ->get();
        $address_recipient = DB::table('addresses')
            ->whereRaw("address_type = '2' AND owner_id = '$user_id'")
            ->orderBy('firstname', 'asc')
            ->get();
    }

    
   

   
    $collection_type = isset($_REQUEST['pickup']);
?>
<?php echo csrf_field(); ?>


<div class="add-shipment">
    <input type="hidden" name="service_provider" value="<?php echo e(get_config('api_provider')); ?>">
    <input class="form-check-input" type="hidden" name="collection_type" value="2">
    <input class="form-check-input" type="hidden" name="delivery_type" value="1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body">

                            <div class="form-label"><?php echo e(trans_choice('messages.Customer', 1)); ?></div>

                            <?php if($role == 1): ?>
                                <input type="hidden" id="sel_client" name="client" value="<?php echo e($user->id); ?>">
                                <input type="text" class="form-control" id="sel_client" disabled
                                    value="<?php echo e($user->firstname); ?> <?php echo e($user->lastname); ?> (<?php echo e($user->username); ?>)">
                            <?php else: ?>
                                <select class="form-search form-select" id="sel_client" name="client">
                                    <?php if(isset($user)): ?>
                                        <option value="<?php echo e($user->id); ?>"><?php echo e($user->firstname); ?> <?php echo e($user->lastname); ?>

                                            (<?php echo e($user->username); ?>)</option>
                                    <?php endif; ?>
                                </select>
                            <?php endif; ?>
                            <?php $__errorArgs = ['client'];
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
                    <div class="col-lg-6">

                        <div class="card-body">

                            <div class="form-group mb-3">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Pickup'); ?></label>
                                <div class="row">
                                    <div class="col-10">
                                        <select class="form-select form-search" id="sel_sender_address"
                                            name="sender_info" required>
                                            <option value=""><?php echo app('translator')->get('messages.Select_Address'); ?></option>
                                            <?php $__currentLoopData = $address_sender; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($address->id); ?>"><?php echo e($address->firstname); ?> -
                                                    <?php echo e($address->address); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <a id="sender_add_link" data-bs-toggle="modal" data-bs-target="#locationModal"
                                            href="#" class="btn"><i class="bi bi-plus-circle-dotted"></i></a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title"><?php echo app('translator')->get('messages.Recipient'); ?></h5>
                </div>
                <div class="card-body">

                    <div class="row gy-3" id="recipient_box">

                        <?php $__currentLoopData = $address_recipient; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $address): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 col-sm-6 recipient_box">
                                <div class="form-check card-radio rounded-bottom-0">
                                    <input value="<?php echo e($address->id); ?>" id="shippingAddress<?php echo e($address->id); ?>" name="receiver_info" type="radio"
                                        class="form-check-input" checked="">
                                    <label class="form-check-label" for="shippingAddress<?php echo e($address->id); ?>">
                                        <span
                                            class="mb-3 fw-semibold d-block text-muted text-uppercase"><?php echo app('translator')->get('messages.To'); ?></span>

                                        <span class="fs-md mb-2 d-block fw-medium"><?php echo e($address->firstname); ?> -
                                            <?php echo e($address->lastname); ?></span>
                                        <span
                                            class="text-muted fw-normal text-wrap mb-1 d-block"><?php echo e($address->address); ?>,
                                            <?php echo e(get_name($address->city, 'cities')); ?>,
                                            <?php echo e(get_name($address->state, 'states')); ?> <?php echo e($address->postal); ?>,
                                            <?php echo e(country_code($address->country)); ?></span>
                                        <span class="text-muted fw-normal d-block"><?php echo app('translator')->get('messages.Phone'); ?>.
                                            <?php echo e($address->phone); ?></span>
                                    </label>
                                </div>

                            </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <div id="recipient_add" class="col-lg-4 col-sm-6">
                            <a href="#!" id="recipient_add_link"
                                class="card bg-light bg-opacity-25 border border-light-subtle shadow-none h-100 text-center">
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <div>
                                        <div class="fs-4xl mb-2"><i class="bi bi-plus-circle-dotted"></i></div>
                                        <div class="fw-medium fs-md text-primary-emphasis stretched-link"
                                            data-bs-toggle="modal" data-bs-target="#locationModal"><?php echo app('translator')->get('messages.Add_Address'); ?>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Package Info -->
    <div class="row" id="package_info">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0"><?php echo app('translator')->get('messages.Package_Info'); ?></h6>
                </div>
                <div class="card-body" id="package_col" data-repeater-list="packages">
                    <div class="row" data-repeater-item>
                        <div class="col-md-3  mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Description'); ?></label>
                                <input placeholder="<?php echo app('translator')->get('messages.Description'); ?>" type="text"
                                    value="<?php echo e(old('package_description', 'Small Box')); ?>"
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
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Length_CM'); ?></label>
                                <input placeholder="<?php echo app('translator')->get('messages.Length'); ?>" type="number" min="1"
                                    value="<?php echo e(old('length', 15.0)); ?>" class="form-control" name="length"
                                    required />
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
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Width_CM'); ?></label>
                                <input placeholder="<?php echo app('translator')->get('messages.Width'); ?>" type="number" min="1"
                                    value="<?php echo e(old('width', 15.0)); ?>" class="form-control" name="width" required />
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
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Height_CM'); ?></label>
                                <input placeholder="<?php echo app('translator')->get('messages.Height'); ?>" type="number" min="1"
                                    value="<?php echo e(old('height', 15.0)); ?>" class="form-control" name="height"
                                    required />
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
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Weight_Kg'); ?></label>
                                <input placeholder="<?php echo app('translator')->get('messages.Weight'); ?>" type="number" 
                                    value="<?php echo e(old('weight', 1.0)); ?>" min="0.5" step="any"
                                    class="form-control weights <?php $__errorArgs = ['total_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="weight" onchange="Calculate_Total_Weight()" required />
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

                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Quantity'); ?></label>
                                <input placeholder="<?php echo app('translator')->get('messages.Quantity'); ?>" type="number" min="1"
                                    value="<?php echo e(old('qty', '1')); ?>"
                                    class="form-control qty <?php $__errorArgs = ['qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="qty"
                                    onchange="Calculate_Total_Qty()" required />

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

                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required"><?php echo app('translator')->get('messages.Declared_Value'); ?></label>
                                <div class="input-group mb-3">
                                    <span
                                        class="input-group-text"><?php echo e(get_money('0', get_currency('code'), 'only_symbol', 'localize')); ?></span>
                                    <input placeholder="<?php echo app('translator')->get('messages.Declared_Value'); ?>" type="number"
                                        value="<?php echo e(old('value', '')); ?>" min="1"
                                        class="form-control <?php $__errorArgs = ['value'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" name="value"
                                        required />
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
                        <div class="col-3">
                            <a href="javascript:;" data-repeater-delete="" class=" pt-5 float-end">
                                <i class="bi bi-x-lg align-baseline text-danger me-1"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row" id="package_total">
                        <div class="col-12 col-lg-5 d-flex justify-content-end fw-bold"></div>
                        <div class="col-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><?php echo app('translator')->get('messages.Total_Weight_Kg'); ?></span>
                                <input readonly type="number" min="0.5" step="any" value="<?php echo e(old('total_weight', 1.0)); ?>"
                                    class="form-control total_weight <?php $__errorArgs = ['total_weight'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="total_weight" required />
                                <?php $__errorArgs = ['total_weight'];
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
                        <div class="col-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text"><?php echo app('translator')->get('messages.Total_Qty'); ?></span>
                                <input readonly type="number" min="1" value="<?php echo e(old('total_qty', 1.0)); ?>"
                                    class="form-control total_qty <?php $__errorArgs = ['total_qty'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                    name="total_qty" required />
                                <?php $__errorArgs = ['total_qty'];
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

                    <a href="javascript:;" data-repeater-create="" id="Xadd_package" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle-dotted"></i> <?php echo app('translator')->get('messages.Add_Package'); ?>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--// Package Info -->

    <!-- Shipment Info -->
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0"><?php echo app('translator')->get('messages.Shipment_Info'); ?></h6>
                </div>
                <div class="row card-body">
                    
                    <label class="col-12 col-form-label fw-bold"><?php echo app('translator')->get('messages.Tracking_Number'); ?></label>
                    <?php if(get_config('tracking_prefix') == 'enabled'): ?>
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <input name="tracking_code_prefix"
                                    value="<?php echo e(old('tracking_code_prefix', get_config('default_tracking_prefix'))); ?>"
                                    type="text" class="form-control" placeholder="<?php echo app('translator')->get('messages.Prefix'); ?>"
                                    maxlength="5" <?php if(Auth()->user()->role < 2): ?> disabled <?php endif; ?>>
                                <?php $__errorArgs = ['tracking_code_prefix'];
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
                                <span class="input-group-text" id="basic-addon2">-</span>
                            </div>
                        </div>
                    <?php endif; ?>
                    <div class="col-9">
                        <div class="form-group">
                            <input name="tracking_code_number"
                                value="<?php echo e(old('tracking_code_number', generate_tracking_no())); ?>" type="text"
                                class="form-control" readonly>
                        </div>
                    </div>
                    
                    <div class="col-md-4 mt-4">
                        <div class="form-group mb-3">
                            <label class="form-label required"><?php echo app('translator')->get('messages.Payment_Type'); ?></label>
                            <select class="form-select <?php $__errorArgs = ['payment_type'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="payment_type"
                                name="payment_type" required>
                                <?php
                                    $payment_type = get_config('payment_type');
                                ?>
                                <option value="1" <?php echo e(old('payment_type') == '1' ? 'selected' : ''); ?>

                                    <?php echo e($payment_type == 1 ? 'selected' : ''); ?>>
                                    <?php echo app('translator')->get('messages.PrePaid'); ?></option>
                                <option value="2" <?php echo e(old('payment_type') == '2' ? 'selected' : ''); ?>

                                    <?php echo e($payment_type == 2 ? 'selected' : ''); ?>>
                                    <?php echo app('translator')->get('messages.PostPaid'); ?></option>
                            </select>
                            <?php $__errorArgs = ['payment_type'];
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
                    
                    <div class="col-md-12 ">
                        <h6><?php echo e(trans_choice('messages.Payment_Method', 1)); ?></h6>
                        <div class="row g-4">
                            
                           <?php
                            $payment_method = get_config('payment_method');
                           ?>
                            <?php $__currentLoopData = DB::table('payment_methods')->orderBy('name', 'asc')->where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="col-lg-4 mb-0" id="pay<?php echo e($pay->id); ?>">
                                <div class="form-check card-radio">
                                    <input id="pay-i-<?php echo e($pay->id); ?>" name="payment_method" type="radio" class="form-check-input" value="<?php echo e($pay->id); ?>"   <?php echo e($payment_method == $pay->id ? 'checked' : ''); ?>>
                                    <label class="form-check-label d-flex gap-2 align-items-center" for="pay-i-<?php echo e($pay->id); ?>">
                                        
                                        <span class="flex-grow-1">
                                            <span
                                                class="fs-md fw-medium mb-1 text-wrap d-block">
                                                <?php echo e(__('messages.' . $pay->name)); ?>

                                        </span>
                                        </span>
                                       
                                    </label>
                                </div>
                            </div>
                            <?php $__errorArgs = ['payment_method'];
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
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                       
                    </div>

                    
                </div>
            </div>

        </div>

    </div>
</div>
<!--// Shipment Info -->

<?php $__env->startPush('modal'); ?>
    <div id="locationModal" class="modal fade zoomIn locationModal" tabindex="-1" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="address_create_form" data-action="<?php echo e(route('dashboard.address.create')); ?>"
                    class="form needs-validation" novalidate method="post">
                    <?php echo csrf_field(); ?>
                    <div class="modal-header">
                        <h5 class="modal-title" id="locationModalLabel"><?php echo app('translator')->get('messages.Add_Address'); ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" value="2" id="address_type" name="address_type">
                        <?php if(isset($user)): ?>
                            <input type="hidden" id="client_id" name="client" value="<?php echo e($user->id); ?>">
                        <?php else: ?>
                            <input type="hidden" id="client_id" name="client" required>
                        <?php endif; ?>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <select class="form-control" id="sel_country" name="country" required>
                                        <option value=""><?php echo app('translator')->get('messages.Select_Country'); ?></option>
                                        <?php $__currentLoopData = $countries; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($item->id); ?>"><?php echo e($item->name); ?>

                                            </option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                    <?php $__errorArgs = ['country'];
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
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <select id="sel_state" name="state"
                                        class="form-select <?php $__errorArgs = ['state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                        <option value=""><?php echo app('translator')->get('messages.Select_State'); ?></option>

                                    </select>
                                    <?php $__errorArgs = ['state'];
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <select id="sel_city" name="city"
                                        class="form-select <?php $__errorArgs = ['city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value=""><?php echo app('translator')->get('messages.Select_City'); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['city'];
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
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <select id="sel_area" name="area"
                                        class="form-select form-search <?php $__errorArgs = ['area'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>">
                                        <option value=""><?php echo app('translator')->get('messages.Select_Area'); ?></option>
                                    </select>
                                    <?php $__errorArgs = ['area'];
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
                        <div class="form-group mb-3">
                            <label for="address" class="form-label required"><?php echo app('translator')->get('messages.Delivery_Address'); ?></label>
                            <textarea name="address" id="address" rows="2" class="form-control <?php $__errorArgs = ['address'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                required><?php echo e(old('address', '')); ?></textarea>

                            <?php $__errorArgs = ['address'];
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
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="firstname" class="form-label required"><?php echo app('translator')->get('messages.FirstName'); ?></label>
                                    <input type="text" name="firstname" value="<?php echo e(old('firstname', '')); ?>"
                                        class="form-control <?php $__errorArgs = ['firstname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['firstname'];
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
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="lastname" class="form-label required"><?php echo app('translator')->get('messages.LastName'); ?></label>
                                    <input type="text" name="lastname" value="<?php echo e(old('lastname', '')); ?>"
                                        class="form-control <?php $__errorArgs = ['lastname'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                    <?php $__errorArgs = ['lastname'];
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
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label required"><?php echo app('translator')->get('messages.Phone'); ?></label>
                                    <div>
                                        <input id="telephone" type="tel" class="form-control"
                                            value="<?php echo e(old('phone', '')); ?>" required>
                                        <input type="hidden" value="<?php echo e(old('phone', '')); ?>" name="phone"
                                            id="phone_number" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label required"><?php echo app('translator')->get('messages.Email'); ?></label>
                                    <input type="text" name="email" value="<?php echo e(old('email', '')); ?>"
                                        class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="postal" class="form-label required"><?php echo app('translator')->get('messages.Postal'); ?></label>
                                    <input type="text" name="postal" value="<?php echo e(old('postal', '')); ?>"
                                        class="form-control <?php $__errorArgs = ['postal'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" required>
                                </div>
                            </div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                                class="bi bi-x-lg align-baseline me-1"></i> Close</button>
                        <button type="submit" class="btn btn-primary"><?php echo app('translator')->get('messages.Save'); ?></button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('css'); ?>
    <link rel="stylesheet"
        href="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/vendors/intlTelInput/css/intlTelInput.css">
    <style>
        .iti {
            width: 100%;
        }
    </style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/vendors/intlTelInput/js/intlTelInput.js"></script>
    <script>
       
        // phone number
        var input = document.querySelector("#telephone");
        var intl_telephone = window.intlTelInput(input, {

            geoIpLookup: function(callback) {
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            initialCountry: "<?php echo e(country_code(Auth()->user()->country) != '' ? country_code(Auth()->user()->country) : 'auto'); ?>",

            nationalMode: true,
            separateDialCode: true,
            utilsScript: "<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/vendors/intlTelInput/js/utils.js",
        });
        input.addEventListener('blur', function() {
            $('#phone_number').val(intl_telephone.getNumber());
        });
    </script>
    <script src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/assets/js/pages/form-validation.init.js"></script>
    <script type='text/javascript'>
        //select form helper
        $(document).ready(function() {
            $('#sel_country').select2(
            {
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_state').select2(
            {
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_city').select2(
            {
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_area').select2(
            {
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_branch').select2(
            {
                dropdownParent: $('.locationModal')
            }
        );
        $('.form-search').select2(
            {
                dropdownParent: $('.locationModal')
            }
        );
            var s_search = $('#sel_client').val();

            <?php if($role > 1): ?>
                $("#sel_client").select2({
                    language: '<?php echo e(LaravelLocalization::getCurrentLocale()); ?>',
                    ajax: {
                        url: "<?php echo e(route('dashboard.users.search')); ?>",
                        dataType: 'json',
                        delay: 250,
                        data: function(params) {
                            var query = {
                                q: params.term,
                                //type: 'public'
                            }
                            return query;
                        },

                        processResults: function(data) {
                            return {
                                results: $.map(data, function(item) {
                                    return {
                                        text: item.firstname + ' ' + item.lastname + ' - ' +
                                            item
                                            .username,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 3,
                    //placeholder: search,
                    allowClear: true
                }).on('change', function(e) {
                    //
                });
            <?php endif; ?>

            //Branches
            $('#sel_client').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                // $('#sel_branch_1').find('option').not(':first').remove();
                // $('#sel_branch_2').find('option').not(':first').remove();
                // AJAX request
                //Sender 
                $.ajax({
                    url: '<?php echo e(url('dashboard/address/getaddress/1')); ?>/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_sender_address').find('option').not(':first').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var name = response['data'][i].firstname + ' ' + response['data'][i]
                                .lastname + ' - ' + response['data'][i].address;

                            var option = "<option value='" + id + "'>" + name +
                                "</option>";
                            if (response['data'][i].id != 0) {
                                $("#sel_sender_address").append(option);
                            } else {
                                $('#sel_sender_address').find('option').not(':first').remove();
                            }
                        }
                    }
                });

                //Recipients
                // empty Recipients
                $('.recipient_box').remove();
                $.ajax({
                    url: '<?php echo e(url('dashboard/address/getaddress/3')); ?>/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == 'success') { 
                            $(data.address_data).insertBefore('#recipient_add');
                        }
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $('#sel_client').change(function() {

                var client_id = $(this).val();
                $('#client_id').val(client_id);

            });

            $('#sender_add_link').click(function() {

                $('#address_type').val('1');

            });
            $('#recipient_add_link').click(function() {

                $('#address_type').val('2');

            });


            //start: create data script
            $('#address_create_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                const isValidForm = document.getElementById('address_create_form');
                var client_id = $('#client_id').val();
                if (client_id == '') {
                    Toastify({
                        text: "<?php echo e(__('messages.Select_Sender')); ?>",
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                }

                if (isValidForm.checkValidity() && client_id) {
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
                        url: "<?php echo e(route('dashboard.address.create')); ?>",
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function(data) {

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
                            if (data.result == 'success') {
                                if (data.address_type == '1') {
                                    $('#sel_sender_address').append(data.address_data);
                                 }
                                 else {
                                    $(data.address_data).insertBefore('#recipient_add');

                                 }
                               
                                $('#address_create_form')[0].reset();
                                $('#locationModal').modal('hide');

                            } else if (data.result == 'errors') {

                                $.each(data.messages, function(i, item) {
                                    Toastify({
                                        text: '<span class="fa fa-times-circle"></span> ' +
                                            data.messages[i],
                                        duration: 10000,
                                        close: true,
                                        gravity: "top",
                                        position: "center",
                                        backgroundColor: "red",
                                    }).showToast();
                                });


                            } else {

                                Toastify({
                                    text: data.messages,
                                    duration: 10000,
                                    close: true,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "red",
                                }).showToast();


                            }


                            // var len = 0;
                            // if (response['data'] != null) {
                            //     len = response['data'].length;
                            // }

                            // if (len > 0) {

                            //     // Read data and create <option >
                            //     for (var i = 0; i < len; i++) {

                            //         var id = response['data'][i].id;
                            //         var name = response['data'][i].name;

                            //         var div = '<div class="col-lg-4 col-sm-6 recipient_box">
                            //     <div class="form-check card-radio rounded-bottom-0">
                            //         <input id="shippingAddress'+ id + '" name="shippingAddress"
                            //             type="radio" class="form-check-input" checked="">
                            //         <label class="form-check-label" for="shippingAddress'+ id +'">
                            //             <span
                            //                 class="mb-3 fw-semibold d-block text-muted text-uppercase"><?php echo app('translator')->get('messages.To'); ?></span>

                            //             <span class="fs-md mb-2 d-block fw-medium">'+ firstname +' -
                            //                '+lastname +'</span>
                            //             <span
                            //                 class="text-muted fw-normal text-wrap mb-1 d-block">'+ address +',
                            //                 '+ city +',
                            //                 '+ state +' '+ postal +',
                            //                 '+ country +'</span>
                            //             <span class="text-muted fw-normal d-block"><?php echo app('translator')->get('messages.Phone'); ?>.
                            //                 '+ phone +'</span>
                            //         </label>
                            //     </div>

                            // </div>';

                            //      $(div).insertAfter('#recipient_box div:last');
                            // }

                            //}

                        },
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

                }

            });
            //end: create data script
        });
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/forms/create.blade.php ENDPATH**/ ?>