<?php
    
    if (isset($shipment)) {
        //fetch shipment logs
        $logs = App\Models\ShipmentLog::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    
        //fetch packages
    
        $packages = App\Models\Packages::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    
        // shipping service
        $provider = App\Models\ShipmentProviders::where('shipment_id', $shipment->code)->first();
    }
    
    $user_lang = LaravelLocalization::getCurrentLocale();
?>

<?php $__env->startSection('content'); ?>
    
    <div class="row mt-3">
        <div class="col-lg-12">
            <div class="alert alert-<?php echo e(get_status_color($shipment->status, 'shipments')); ?> alert-dismissible fade show text-center" role="alert">
                <?php echo e(get_status('shipment-notes', $shipment->status)); ?>

                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        </div>
    </div>
    <div class="s-view mb-5 mb-xl-10">
        <div class="card">
            <div class="card-header">
                <div class="card-title m-0">
                    <h3 class="fw-bolder m-0">
                        <?php echo e(trans_choice('messages.Shipment', 1)); ?> : <?php echo e($shipment->code); ?>

                        <small>
                            <span class="text-muted"><?php echo app('translator')->get('messages.By'); ?></span>

                            <a href="<?php echo e(route('dashboard.users.view', ['id' => $shipment->owner_id])); ?>">
                                <span
                                    class='btn btn-sm btn-secondary m-1'><?php echo e(get_user('username', $shipment->owner_id)); ?></span>
                            </a>
                        </small>
                    </h3>
                </div>

                
                <div class="card-tool mt-2">
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                        
                        
                    <?php endif; ?>
                    <?php if($shipment->payment_status == 0): ?>
                        
                        
                    <?php endif; ?>
                    <?php if($shipment->status != 0): ?>
                        
                        <a target="_blank" class="btn btn-sm btn-outline-warning m-1"
                            href="<?php echo e(route('tracking', ['code' => $shipment->code])); ?>"><i class="fa fa-arrow-right"></i>
                            <?php echo app('translator')->get('messages.Track'); ?>
                        </a>
                    <?php endif; ?>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                        
                        <a class="btn btn-sm btn-outline-primary m-1"
                            href="<?php echo e(route('dashboard.shipments.edit', ['id' => $shipment->id])); ?>"><i class="fa fa-edit"></i>
                            <?php echo app('translator')->get('messages.Edit'); ?>
                        </a>
                    <?php endif; ?>

                    <?php if($shipment->disabled == '0'): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_moderator')): ?>
                            
                            <a class="btn btn-sm btn-outline-primary m-1"
                                href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'disable'])); ?>"><i
                                    class="fa fa-minus"></i>
                                <?php echo app('translator')->get('messages.Disable_Edit'); ?>
                            </a>
                        <?php endif; ?>
                    <?php elseif($shipment->disabled == '1'): ?>
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_moderator')): ?>
                            
                            <a class="btn btn-sm btn-outline-primary m-1"
                                href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'status' => 'enable'])); ?>"><i
                                    class="fa fa-minus"></i>
                                <?php echo app('translator')->get('messages.Enable_Edit'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    
                    <a target="_blank" class="btn btn-sm btn-outline-success m-1"
                        href="<?php echo e(route('dashboard.shipments.invoice', ['id' => $shipment->invoice_id])); ?>"><i
                            class="fa fa-print"></i> <?php echo app('translator')->get('messages.Print_Invoice'); ?>
                    </a>
                    <a target="_blank" class="btn btn-sm btn-outline-success m-1"
                        href="<?php echo e(route('dashboard.shipments.invoice.label', ['id' => $shipment->invoice_id])); ?>"><i
                            class="fa fa-print"></i> <?php echo app('translator')->get('messages.Print_Label'); ?>
                    </a>

                    <?php if($shipment->status < 3): ?>
                        
                        
                    <?php endif; ?>

                    <?php if($shipment->status < 4): ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_agent')): ?>
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#shipped-<?php echo e($shipment->id); ?>" href="#"><i class="fa fa-check"></i>
                                <?php echo app('translator')->get('messages.Mark_Shipped'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($shipment->status < 8): ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_agent')): ?>
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#out-for-delivery-<?php echo e($shipment->id); ?>" href="#"><i
                                    class="fa fa-check"></i>
                                <?php echo app('translator')->get('messages.Mark_Out_For_Delivery'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if($shipment->status < 10): ?>
                        
                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_agent')): ?>
                            <a class="btn btn-sm btn-primary m-1" data-bs-toggle="modal"
                                data-bs-target="#delivered-<?php echo e($shipment->id); ?>" href="#"><i class="fa fa-check"></i>
                                <?php echo app('translator')->get('messages.Mark_Delivered'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>

                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_moderator')): ?>
                        
                        <a class="btn btn-sm btn-outline-danger m-1" data-bs-toggle="modal"
                            data-bs-target="#cancel-<?php echo e($shipment->id); ?>" href="#">
                            <i class="fa fa-times"></i> <?php echo app('translator')->get('messages.Cancel_Shipment'); ?>
                        </a>
                        
                        <a class="btn btn-sm btn-outline-danger m-1" data-bs-toggle="modal"
                            data-bs-target="#delete-<?php echo e($shipment->id); ?>" href="#">
                            <i class="fa fa-trash"></i> <?php echo app('translator')->get('messages.Delete'); ?>
                        </a>
                    <?php endif; ?>
                </div>
                

            </div>
        </div>

        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <h3 class="float-left"><b
                                class="text-success text-uppercase"><?php echo e(trans_choice('messages.Invoice', 1)); ?></b>
                            <span>#<?php echo e($shipment->invoice_id); ?></span>
                        </h3>
                    </div>
                </div>
                <hr>
                <div class="row mt-4">
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Collection_Type'); ?></strong></h6>
                            <p class="text-muted">
                                <?php echo e($shipment->collection_type == '1' ? __('messages.Drop_off_at_Branch') : __('messages.Home_Pick_Up')); ?>

                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Delivery_Type'); ?></strong></h6>
                            <p class="text-muted">
                                <?php echo e($shipment->delivery_type == '1' ? __('messages.Pick_Up_at_Branch') : __('messages.Home_Delivery')); ?>

                            </p>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Shipment_Status'); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_status('shipments', $shipment->status)); ?></p>
                        </div>
                    </div>

                </div>
                <div class="row">

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Invoice_Status'); ?></strong></h6>
                            <p class="text-muted">
                                <?php echo e($shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid')); ?></p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Payment_Type'); ?></strong></h6>
                            <p class="text-muted">
                                <?php echo e($shipment->payment_type == '1' ? __('messages.PrePaid') : __('messages.PostPaid')); ?>

                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-12">
                        <div class="float-left">
                            <h6><strong><?php echo e(trans_choice('messages.Payment_Method', 1)); ?></strong></h6>
                            <p class="text-muted">
                                <?php echo e(__('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name'))); ?>

                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Sending_Branch'); ?></strong></h6>
                            <?php if($shipment->from_branch == ''): ?>
                                <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                    
                                    - <a
                                        href="<?php echo e(url('dashboard/shipments/edit/' . $shipment->id . '#from_branch')); ?>"><?php echo app('translator')->get('messages.Assign_Branch'); ?></a>
                                <?php endif; ?>
                            <?php else: ?>
                                <?php echo e(get_data_db('branches', 'id', $shipment->from_branch, 'name')); ?>

                            <?php endif; ?>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <?php if($shipment->delivery_type == '1'): ?>
                                <h6><strong><?php echo app('translator')->get('messages.Receiving_Branch'); ?></strong></h6>
                                <p class="text-muted">
                                    <?php if($shipment->to_branch == ''): ?>
                                        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                            <a
                                                href="<?php echo e(url('dashboard/shipments/edit/' . $shipment->id . '#to_branch')); ?>"><?php echo app('translator')->get('messages.Assign_Branch'); ?></a>
                                        <?php endif; ?>
                                    <?php else: ?>
                                        <?php echo e(get_data_db('branches', 'id', $shipment->to_branch, 'name')); ?>

                                    <?php endif; ?>

                                </p>
                            <?php else: ?>
                                <h6><strong><?php echo app('translator')->get('messages.Destination'); ?></strong></h6>
                                <p class="text-muted">
                                    <?php echo e($shipment->receiver_address); ?>,
                                    <?php echo e(get_name($shipment->to_area, 'areas')); ?>,
                                    <?php echo e(get_name($shipment->receiver_city, 'cities')); ?>,
                                    <br>
                                    <?php echo e(get_name($shipment->receiver_state, 'states')); ?>,
                                    <?php echo e(get_name($shipment->receiver_country, 'countries')); ?>

                                </p>
                            <?php endif; ?>

                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Origin'); ?></strong>
                            </h6>
                            <p class="text-muted">
                                <?php echo e(get_dataBy_id($shipment->sender_state, 'states', 'name') . '-' . get_dataBy_id($shipment->sender_country, 'countries', 'name')); ?>

                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Destination'); ?></strong>
                            </h6>
                            <p class="text-muted">
                                <?php echo e(get_dataBy_id($shipment->receiver_state, 'states', 'name') . '-' . get_dataBy_id($shipment->receiver_country, 'countries', 'name')); ?>

                            </p>
                        </div>
                    </div>

                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Shipping_Date'); ?></strong>
                            </h6>
                            <p class="text-muted">
                                <?php if($shipment->shipped_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($shipment->shipped_date)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>
                            </p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6><strong><?php echo app('translator')->get('messages.Delivery_Date'); ?> (<small class="text-muted"><?php echo app('translator')->get('messages.Estimated'); ?></small>)</strong>
                            </h6>
                            <p class="text-muted">
                                <?php if($shipment->delivery_date): ?>
                                    <?php echo e(\Carbon\Carbon::parse($shipment->delivery_date)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d')); ?>

                                <?php else: ?>
                                    -
                                <?php endif; ?>

                            </p>
                        </div>
                    </div>
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_agent')): ?>
                        <div class="col-md-4 col-6">
                            <div class="float-left">
                                <h6><strong><?php echo e(trans_choice('messages.Delivery_Agent', 1)); ?></strong></h6>
                                <p class="text-muted">
                                    <?php if($shipment->delivery_agent): ?>
                                        <a href="<?php echo e(route('dashboard.users.view', ['id' => $shipment->delivery_agent])); ?>">
                                            <span> <?php echo e(get_user('firstname', $shipment->delivery_agent)); ?>

                                                <?php echo e(get_user('lastname', $shipment->delivery_agent)); ?> -
                                                <?php echo e(get_user('username', $shipment->delivery_agent)); ?></span>
                                        </a>
                                    <?php else: ?>
                                        <a href="<?php echo e(route('dashboard.shipments.agent.list', ['id' => $shipment->id])); ?>">
                                            <span><?php echo app('translator')->get('messages.Assign_Agent'); ?></span>
                                        </a>
                                    <?php endif; ?>


                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="float-left">
                                <h6><strong><?php echo app('translator')->get('messages.Submitted'); ?></strong></h6>
                                <p class="text-muted">
                                    <?php echo e(\Carbon\Carbon::parse($shipment->created_at)->setTimezone(\Helpers::getUserTimeZone())); ?>

                                    <?php echo app('translator')->get('messages.By'); ?> <?php echo e(get_user('username', $shipment->created_by)); ?>

                                </p>
                            </div>
                        </div>
                        <div class="col-md-4 col-6">
                            <div class="float-left">
                                <h6><strong><?php echo app('translator')->get('messages.Last_Updated_On'); ?></strong></h6>
                                <p class="text-muted">
                                    <?php echo e(\Carbon\Carbon::parse($shipment->updated_at)->setTimezone(\Helpers::getUserTimeZone())->diffForHumans()); ?>

                                    <?php echo app('translator')->get('messages.By'); ?> <?php echo e(get_user('username', $shipment->last_updated_by)); ?>

                                </p>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
        </div>

        
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h3 class="col-md-12 text-left text-uppercase"><b class="text-success"><?php echo app('translator')->get('messages.Sender_Info'); ?></b></h3>
                    <hr>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Name')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->sender_name); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Phone')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->sender_phone); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Email')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->sender_email); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.Address', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->sender_address); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.Area', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_name($shipment->from_area, 'areas')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.City', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_name($shipment->sender_city, 'cities')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.State', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_name($shipment->sender_state, 'states')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.Country', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(country_name($shipment->sender_country)); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Postal')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->postal_sender); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h3 class="col-md-12 text-left text-uppercase"><b class="text-success"><?php echo app('translator')->get('messages.Receiver_Info'); ?></b></h3>
                    <hr>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Name')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->receiver_name); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Phone')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->receiver_phone); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Email')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->receiver_email); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.Address', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->receiver_address); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.Area', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_name($shipment->to_area, 'areas')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.City', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_name($shipment->receiver_city, 'cities')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.State', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(get_name($shipment->receiver_state, 'states')); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(trans_choice('messages.Country', 1)); ?></strong></h6>
                            <p class="text-muted"><?php echo e(country_name($shipment->receiver_country)); ?></p>
                        </div>
                    </div>
                    <div class="col-md-4 col-6">
                        <div class="float-left">
                            <h6 class="fw-bold fs-6"><strong><?php echo e(__('messages.Postal')); ?></strong></h6>
                            <p class="text-muted"><?php echo e($shipment->postal_receiver); ?></p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-md-12 text-left text-uppercase">
                        <b class="text-success"><?php echo e(trans_choice('messages.Package', 2)); ?>

                            (<?php echo e(App\Models\Packages::where('shipment_id', $shipment->code)->count()); ?>)
                        </b>
                    </h4>
                    <hr>
                    <div class="col-md-12">
                        <div class="table-responsive">
                            <table class="table table-bordered mt-2">
                                <thead>
                                    <tr>
                                        <th style="width: 50%" class="pl-0 font-weight-bold text-muted text-uppercase">
                                            <?php echo app('translator')->get('messages.Description'); ?></th>
                                        <th class="text-right  text-muted text-uppercase"><?php echo app('translator')->get('messages.Length_CM'); ?></th>
                                        <th class="text-right  text-muted text-uppercase"><?php echo app('translator')->get('messages.Width_CM'); ?></th>
                                        <th class="text-right  text-muted text-uppercase"><?php echo app('translator')->get('messages.Height_CM'); ?></th>

                                        <th class="text-right  text-muted text-uppercase"><?php echo app('translator')->get('messages.Weight_Kg'); ?></th>
                                        <th class="pr-0 text-right  text-muted text-uppercase"><?php echo app('translator')->get('messages.Quantity'); ?></th>
                                        
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr class="font-weight-boldest">
                                            <td style="width: 50%"><strong> <?php echo e($package->description); ?></strong></td>
                                            <td> <?php echo e($package->length); ?></td>
                                            <td> <?php echo e($package->width); ?></td>
                                            <td> <?php echo e($package->height); ?></td>
                                            <td> <?php echo e($package->weight); ?></td>
                                            <td> <?php echo e($package->qty); ?></td>
                                            
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                            <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
                                <tr>
                                    <th style="vertical-align: top;padding: 10px;"><?php echo e(__('messages.Subtotal')); ?></th>
                                    <td style="vertical-align: top;padding: 10px;">
                                        <b>
                                            <?php echo e(get_money($shipment->subtotal, $shipment->currency, 'full', 'localize')); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: top;padding: 10px;"><?php echo e(__('messages.Tax')); ?></th>
                                    <td style="vertical-align: top;padding: 10px;">
                                        <b>+<?php echo e(get_money($shipment->tax, $shipment->currency, 'full', 'localize')); ?></b>
                                    </td>
                                </tr>
                                <tr>
                                    <th style="vertical-align: top;padding: 10px;"><?php echo e(__('messages.Discount')); ?></th>
                                    <td style="vertical-align: top;padding: 10px;">
                                        <b>-<?php echo e(get_money($shipment->discount, $shipment->currency, 'full', 'localize')); ?></b>
                                    </td>
                                </tr>

                                <tr>
                                    <th style="vertical-align: top; padding: 10px;"><?php echo e(__('messages.Total')); ?></th>
                                    <td style="vertical-align: top; padding: 10px;">
                                        <b><?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?></b>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        
        <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
            <?php if($provider): ?>
                <div class="card mt-3 mb-3">
                    <div class="card-body">
                        <div class="row">
                            <h4 class="col-md-12 text-left text-uppercase">
                                <b class="text-success"><?php echo e(trans_choice('messages.Shipping_Provider', 1)); ?> </b>
                            </h4>
                            <hr>
                            <div class="col-md-12">
                                <div class="table-responsive">
                                    <?php
                                        
                                    ?>
                                    <table class="hm-p table" style="width: 100%; margin-top: 30px">
                                        <tr>
                                            <th style="vertical-align: top;padding: 10px;"><?php echo e(__('messages.Provider')); ?></th>
                                            <td style="vertical-align: top;padding: 10px;">
                                                <?php if($provider->provider == 1): ?>
                                                    <?php echo e(get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale())); ?>

                                                <?php endif; ?>
                                                <?php if($provider->provider == 2): ?>
                                                    Eurosender
                                                <?php endif; ?>
                                                <?php if($provider->provider == 3): ?>
                                                    Shippo
                                                <?php endif; ?>
                                            </td>
                                        </tr>

                                        <tr>
                                            <th style="vertical-align: top;padding: 10px;">
                                                <?php echo e(trans_choice('messages.Service', 1)); ?></th>
                                            <td style="vertical-align: top;padding: 10px;">
                                                <b>This shipment is handle by <?php echo e($provider->name); ?> -
                                                    <?php echo e($provider->service_name); ?></b>
                                            </td>
                                        </tr>

                                        <?php if($provider->provider == 2 || $provider->provider == 3): ?>
                                            <tr>
                                                <th style="vertical-align: top;padding: 10px;">
                                                    <?php echo e(trans_choice('messages.Tracking_Number', 1)); ?></th>
                                                <td style="vertical-align: top;padding: 10px;">

                                                    <?php if($provider->tracking_number != ''): ?>
                                                        <?php echo e($provider->tracking_number); ?>

                                                    <?php else: ?>
                                                        <?php echo app('translator')->get('messages.Approve_Shipment_First'); ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>

                                            <tr>
                                                <th style="vertical-align: top;padding: 10px;">
                                                    <?php echo e(trans_choice('messages.Status', 1)); ?></th>
                                                <td style="vertical-align: top;padding: 10px;">

                                                    <?php if($provider->tracking_status != ''): ?>
                                                        <?php echo e($provider->tracking_status); ?>

                                                        <?php if($provider->tracking_url_provider != ''): ?>
                                                        <a href="<?php echo e($provider->tracking_url_provider); ?>" target="_blank"><?php echo app('translator')->get('messages.Track'); ?></a>
                                                    
                                                    <?php endif; ?>
                                                    <?php else: ?>
                                                        <?php echo app('translator')->get('messages.Approve_Shipment_First'); ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        
                                        
                                            <tr>
                                                <th style="vertical-align: top;padding: 10px;">
                                                    <?php echo e(trans_choice('messages.Label', 1)); ?></th>
                                                <td style="vertical-align: top;padding: 10px;">

                                                    <?php if($provider->label != ''): ?>
                                                        <a href="<?php echo e($provider->label); ?>" target="_blank"><?php echo app('translator')->get('messages.View'); ?></a>
                                                    <?php else: ?>
                                                        <?php echo app('translator')->get('messages.Approve_Shipment_First'); ?>
                                                    <?php endif; ?>
                                                </td>
                                            </tr>
                                        <?php endif; ?>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>

        <?php endif; ?>

        
        <div class="card mt-3 mb-3">
            <div class="card-body">
                <div class="row">
                    <h4 class="col-md-12 text-left text-uppercase"><b class="text-success"><?php echo app('translator')->get('messages.Shipment_Logs'); ?></b></h4>
                    <hr>
                    <div class="col-md-12">

                        <table class="table table-condensed">
                            <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($log->created_at->diffForHumans()); ?></td>
                                    <td><?php echo e(get_status('shipment-notes', $log->note)); ?>

                                    </td>
                                </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
    

    
    <?php echo $__env->make(get_theme_dir('shipment.modal', 'dashboard'), [
        'id' => $shipment->id,
        'code' => $shipment->code,
        'shipment' => $shipment,
        'logs' => $logs,
        'packages' => $packages,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/view.blade.php ENDPATH**/ ?>