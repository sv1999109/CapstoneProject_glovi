<?php $__env->startSection('content'); ?>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="card-title">
                        <h4 class="card-label text-uppercase"><?php echo e(trans_choice('messages.Transaction', 2)); ?></h4>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table" id="table1">
                            <thead>
                                <tr class="text-uppercase">
                                    <th><?php echo e(trans_choice('messages.Reference', 1)); ?></th>
                                    <th><?php echo e(trans_choice('messages.Invoice', 1)); ?></th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                        <th><?php echo e(trans_choice('messages.Customer', 1)); ?></th>
                                    <?php endif; ?>
                                    <th><?php echo app('translator')->get('messages.Amount'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Status'); ?></th>
                                    <th><?php echo e(trans_choice('messages.Payment_Method', 1)); ?></th>
                                    <th><?php echo app('translator')->get('messages.Date'); ?></th>
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
                ajax: "<?php echo e(route('dashboard.transactions.datatable', ['type' => 'all', 'id' => 'all'])); ?>",
                columns: [{
                        data: 'payment_id',
                        name: 'payment_id'
                    },
                    {
                        data: 'invoice_id',
                        name: 'invoice_id'
                    },
                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                        {
                            data: 'owner_id',
                            name: 'owner_id'
                        },
                    <?php endif; ?> 
                    {
                        data: 'amount',
                        name: 'amount'
                    },
                    {
                        data: 'payment_status',
                        name: 'payment_status'
                    },
                    {
                        data: 'gateway',
                        name: 'gateway'
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

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/transactions/list.blade.php ENDPATH**/ ?>