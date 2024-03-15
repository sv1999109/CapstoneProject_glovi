<?php
    $bbcode = new ChrisKonnertz\BBCode\BBCode();
    $instruction = $bbcode->render(strip_tags(get_content_locale(get_data_db('payment_methods', 'id', $shipment->payment_method, 'instruction'))));
?>

<?php $__env->startSection('content'); ?>
    <div class="payment-page">
        
        <?php if(Session::has('error')): ?>
            <div class="card small-card text-center">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    <?php echo e(Session::get('error')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if(Session::has('success')): ?>
            <div class="card small-card text-center">
                <div class="alert alert-success" role="alert">
                    <?php echo e(Session::get('success')); ?>

                </div>
            </div>
        <?php endif; ?>

        <?php if($shipment->payment_status == '1'): ?>
            <div class="card small-card text-center">

                <div class="card-header">
                    <h2 class="card-title text-uppercase"><?php echo e($page_title); ?></h2>
                    <hr>
                </div>
                <div class="card-body">
                    <span class="fa fa-check-circle text-success" style="font-size: 50px"></span>
                    <h6 class="mt-5"><?php echo app('translator')->get('messages.Paid'); ?></h6>
                </div>
            </div>
        <?php else: ?>
            <div class="row m-0">
                <div class="col-md-7 col-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row box-right">
                                <div class="col-md-8 ps-0 ">
                                    <p class="ps-3 textmuted fw-bold h6 mb-0"><?php echo e(trans_choice('messages.Invoice', 1)); ?></p>
                                    <p class="h1 fw-bold d-flex">
                                        <span class="textmuted pe-1 h6 align-text-top mt-1">#</span>
                                        <?php echo e($shipment->invoice_id); ?>

                                    </p>
                                    <p class="ms-3 px-2 bg-green"><?php echo app('translator')->get('messages.Invoice_Generated'); ?>
                                        <?php echo e(\Illuminate\Support\Carbon::parse($shipment->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d H:i:s')); ?>

                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="p-blue"> <span
                                            class="fas fa-circle pe-2"></span><?php echo e($shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid')); ?>

                                    </p>
                                    <p class="fw-bold mb-3">
                                        <?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?>

                                    </p>
                                    <p class="p-blue"><span class="fas fa-circle pe-2"></span><?php echo app('translator')->get('messages.Payment_Type'); ?></p>
                                    <p class="fw-bold">
                                        <?php echo e($shipment->payment_type == '1' ? __('messages.PrePaid') : __('messages.PostPaid')); ?>

                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 px-0 mb-4">
                            <div class="box-right">
                                <div class="d-flex pb-2">
                                    <p class="fw-bold h7">
                                        <span class="textmuted"><?php echo app('translator')->get('messages.Payment_Instruction'); ?></span>
                                    </p>
                                </div>
                                <div class="bg-blue p-2">
                                    <p class="h8 textmuted">
                                        <?php echo $instruction; ?>

                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 col-12 ps-md-5 p-0 ">
                    <div class="box-left p-3  mb-5">
                        <p class="h7 fw-bold mb-3"><?php echo app('translator')->get('messages.Pay_This_Invoice_Via'); ?>
                            <?php echo e(__('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name'))); ?>

                        </p>
                        <p class="textmuted h8 mb-2"><?php echo e(__('messages.Currency_Conversion_Note')); ?></p>

                        <div class="form desktop-buttons">
                            <a href="<?php echo e(route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id])); ?>"
                                class="btn btn-primary d-block h8 text-uppercase">
                                <?php echo app('translator')->get('messages.Pay'); ?>
                                <?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?>

                                <span class="ms-3 fas fa-arrow-right"></span>
                            </a>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                <a href="<?php echo e(route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id])); ?>"
                                    class="btn btn-warning d-block h8 text-uppercase mt-2" data-bs-toggle="modal"
                                    data-bs-target="#paid-<?php echo e($shipment->id); ?>" href="#">
                                    <?php echo app('translator')->get('messages.Mark_Paid'); ?> <i class="fa fa-check-circle"></i>
                                </a>
                            <?php endif; ?>

                            <div class="row">
                                <p class="p-blue h8 fw-bold mt-3 text-center text-uppercase">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#paymet_methods"><?php echo app('translator')->get('messages.More_Payment_Method'); ?></a>
                                </p>
                            </div>
                        </div>

                        <div class="form mobile-buttons">
                            <a href="<?php echo e(route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id])); ?>"
                                class="btn btn-primary d-block h8 text-uppercase">
                                <?php echo app('translator')->get('messages.Pay'); ?>
                                <?php echo e(get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize')); ?>

                                <span class="ms-3 fas fa-arrow-right"></span>
                            </a>
                            <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                <a href="<?php echo e(route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id])); ?>"
                                    class="btn btn-warning d-block h8 text-uppercase mt-2" data-bs-toggle="modal"
                                    data-bs-target="#paid-<?php echo e($shipment->id); ?>" href="#">
                                    <?php echo app('translator')->get('messages.Mark_Paid'); ?> <i class="fa fa-check-circle"></i>
                                </a>
                            <?php endif; ?>

                            <div class="row">
                                <p class="p-blue h8 fw-bold mt-3 text-center text-uppercase"><a href="#"
                                        data-bs-toggle="modal" data-bs-target="#paymet_methods"><?php echo app('translator')->get('messages.More_Payment_Method'); ?></a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="paymet_methods" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="paymet_methods" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymet_methods"><?php echo e(trans_choice('messages.Payment_Method', 2)); ?></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body box">
                    <?php $__currentLoopData = DB::table('payment_methods')->orderBy('name', 'asc')->where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pay): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a
                            href="<?php echo e(route('dashboard.shipments.status', ['id' => $shipment->id, 'payment_method' => $pay->id])); ?>">
                            <div class="box-item"><?php echo e(__('messages.' . $pay->name)); ?></div>
                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>

            </div>
        </div>
    </div>
    
    <?php echo $__env->make(get_theme_dir('shipment.modal', 'dashboard'), [
        'id' => $shipment->id,
        'code' => $shipment->code,
        'shipment' => $shipment,
    ], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        .mobile-buttons {
            background-color: #fff;
            bottom: 0;
            left: 0;
            padding: 10px;
            position: fixed;
            text-align: center;
            width: 100%;
            z-index: 10;
        }

        @media screen and (min-width: 991px) {
            .mobile-buttons {
                display: none;
            }
        }

        @media screen and (max-width: 768px) {
            .desktop-buttons {
                display: none;
            }
        }

        .pay-btnx {
            position: relative;
            bottom: fixed;
        }

        /* @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap'); */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: 'Poppins', sans-serif */
        }

        p {
            margin: 0
        }


        .box-right {
            padding: 30px 25px;
            background-color: white;
            border-radius: 15px
        }

        .box-left {
            padding: 20px 20px;
            background-color: white;
            border-radius: 15px
        }

        html[data-bs-theme="dark"] .box-right,
        html[data-bs-theme="dark"] .box-left,
        html[data-bs-theme="dark"] .bg-blue {
            background: #1e1e2d !important;
        }

        .textmuted {
            color: #7a7a7a
        }

        .bg-green {
            background-color: #d4f8f2;
            color: #06e67a;
            padding: 3px 0;
            display: inline;
            border-radius: 25px;
            font-size: 11px
        }

        .p-blue {
            font-size: 14px;
            color: #1976d2
        }

        .fas.fa-circle {
            font-size: 12px
        }

        .p-org {
            font-size: 14px;
            color: #fbc02d
        }

        .h7 {
            font-size: 15px
        }

        .h8 {
            font-size: 12px
        }

        .h9 {
            font-size: 10px
        }

        .bg-blue {
            background-color: #dfe9fc9c;
            border-radius: 5px
        }

        .form-control {
            box-shadow: none !important
        }

        .card input::placeholder {
            font-size: 14px
        }

        ::placeholder {
            font-size: 14px
        }

        input.card {
            position: relative
        }

        .far.fa-credit-card {
            position: absolute;
            top: 10px;
            padding: 0 15px
        }

        .fas,
        .far {
            cursor: pointer
        }

        .cursor {
            cursor: pointer
        }

        .btn.btn-primary {
            box-shadow: none;
            height: 40px;
            padding: 11px
        }

        .bg.btn.btn-primary {
            background-color: transparent;
            border: none;
            color: #1976d2
        }

        .bg.btn.btn-primary:hover {
            color: #539ee9
        }

        @media(max-width:320px) {
            .h8 {
                font-size: 11px
            }

            .h7 {
                font-size: 13px
            }

            ::placeholder {
                font-size: 10px
            }
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/invoice/pay.blade.php ENDPATH**/ ?>