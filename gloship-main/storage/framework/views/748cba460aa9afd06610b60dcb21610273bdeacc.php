<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                
                <div class="card-header">
                    
                    <h4 class="card-title"><?php echo e(trans_choice('messages.Invoice_List', 2)); ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr class="text-uppercase">
                                    <th><?php echo app('translator')->get('ID'); ?></th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                        <th><?php echo e(trans_choice('messages.Customer', 1)); ?></th>
                                        <th><?php echo e(trans_choice('messages.Email', 1)); ?></th>
                                    <?php endif; ?>
                                    <th><?php echo app('translator')->get('messages.Amount'); ?></th>
                                    <th><?php echo e(trans_choice('messages.Status', 1)); ?></th>
                                    
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
    </head>
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
                ajax: "<?php echo e(route('dashboard.shipments.invoices.datatable', ['type' => 'all', 'id' => 'all'])); ?>",
                columns: [{
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                        {
                            data: 'owner_id',
                            name: 'owner_id'
                        },
                        {
                            data: 'sender_email',
                            name: 'sender_email'
                        },
                    <?php endif; ?> 
                    {
                        data: 'shipping_cost',
                        name: 'shipping_cost'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    // {
                    //     data: 'code',
                    //     name: 'code'
                    // },
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

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/invoice/list.blade.php ENDPATH**/ ?>