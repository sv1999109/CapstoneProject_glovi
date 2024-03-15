<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header mb-5x">
                    <div class="row align-items-center g-2">
                        <div class="col-lg-3 me-auto">
                            <h6 class="card-title mb-0"><?php echo e(__('messages.Shipment_List')); ?></h6>
                        </div><!--end col-->
                        <div class="col-xl-3 col-md-3 col-md-auto">
                            
                                <form action="" method="get" class="float-rightx">
                                    <select class="form-control form-select" data-id="status" name="s" onchange="this.form.submit();">
                                        <?php
                                            $statuses = array_flip(get_status('shipments', 'status', 'all'));
                                        ?>
                                        <option value=""><?php echo app('translator')->get('messages.All'); ?></option>
                                        <?php $__currentLoopData = $statuses; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $status): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <option value="<?php echo e($status); ?>" <?php echo e(($s == $status) ? 'selected' : ''); ?>>
                                                <?php echo e(get_status('shipments', $status)); ?></option>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </select>
                                </form>
                            
                        </div><!--end col-->
                        
                    </div><!--end row-->
                </div>
                <div class="card-body mt-3">
                    <div class="table-responsive list-shipment">
                        <table class="table" id="table1">
                            <thead>
                                <tr class="text-uppercase">
                                    <th><?php echo app('translator')->get('messages.Tracking_Number'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Status'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Shipping_Cost'); ?></th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                        <th><?php echo e(trans_choice('messages.Customer', 1)); ?></th>
                                    <?php endif; ?>
                                    <th><?php echo app('translator')->get('messages.Sender'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Receiver'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Origin'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Destination'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Created'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Action'); ?></th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <!--end::Card-->
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset(get_theme_dir('plugins'))); ?>/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
   
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src="<?php echo e(asset(get_theme_dir('plugins'))); ?>/datatables/jquery.dataTables.min.js"></script>
    <script src="<?php echo e(asset(get_theme_dir('plugins'))); ?>/datatables/dataTables.bootstrap5.min.js"></script>
    <script type="text/javascript">
        $(function() {

            var table = $('.table').DataTable({
                language: {
                    url: "<?php echo e(asset(get_theme_dir('plugins'))); ?>/datatables/<?php echo e(LaravelLocalization::getCurrentLocale()); ?>.json"
                },
                processing: true,
                serverSide: true,
                ajax: "<?php echo e(route('dashboard.shipments.datatable', ['type' => 'all', 'id' => 'all', 's' => $s])); ?>",
                columns: [{
                        data: 'code',
                        name: 'code'
                    },
                    {
                        data: 'status',
                        name: 'status'
                    },
                    {
                        data: 'shipping_cost',
                        name: 'shipping_cost'
                    },
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                    {
                        data: 'owner_id',
                        name: 'owner_id'
                    },
                    <?php endif; ?>
                    {
                        data: 'sender_name',
                        name: 'sender_name'
                    },
                    {
                        data: 'receiver_name',
                        name: 'receiver_name'
                    },
                    {
                        data: 'sender_country',
                        name: 'sender_country'
                    },
                    {
                        data: 'receiver_country',
                        name: 'receiver_country'
                    },
                    {
                        data: 'created_at',
                        name: 'created_at'
                    },
                    {
                        data: 'action',
                        name: 'action',
                        orderable: true,
                        searchable: true
                    },
                ]
            });

        });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/list.blade.php ENDPATH**/ ?>