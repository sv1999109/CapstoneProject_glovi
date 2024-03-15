<?php
    //settings
    $user_lang = LaravelLocalization::getCurrentLocale();
    $user = Auth()->user();
    $role = Auth()->user()->role;
    $owner = Auth()->user()->id;
    $branch = Auth()->user()->branch;
    $limit = 10;
    //customers
    if ($role == 1) {
        $total_shipments = DB::table('shipments')
            ->whereRaw("owner_id = '$owner'")
            ->count();
        $pending_shipments = DB::table('shipments')
            ->whereRaw("status = 0 AND owner_id = '$owner'")
            ->count();
        $shipped_shipments = DB::table('shipments')
            ->whereRaw("status = 4 AND owner_id = '$owner'")
            ->count();
        $delivered_shipments = DB::table('shipments')
            ->whereRaw("status = 13 AND owner_id = '$owner'")
            ->count();
    }

    //Delivery Agents
    if ($role == 2) {
        $total_shipments = DB::table('shipments')
            ->whereRaw("delivery_agent = '$owner'")
            ->count();
        $outfordelivery_shipments = DB::table('shipments')
            ->whereRaw("status = 8 AND delivery_agent = '$owner'")
            ->count();
        $delivered_shipments = DB::table('shipments')
            ->whereRaw("status = 13 AND delivery_agent = '$owner'")
            ->count();
    }

    //staffs
    if ($role == 3) {
        $total_shipments = DB::table('shipments')
            ->whereRaw("from_branch = '$branch' OR to_branch = '$branch'")
            ->count();
        $pending_shipments = DB::table('shipments')
            ->whereRaw("status = 0 AND from_branch = '$branch' OR status = 3  AND to_branch = '$branch'")
            ->count();
        $shipped_shipments = DB::table('shipments')
            ->whereRaw("status = 4 AND from_branch = '$branch' OR status = 4  AND to_branch = '$branch'")
            ->count();
        $delivered_shipments = DB::table('shipments')
            ->whereRaw("status = 13 AND from_branch = '$branch' OR status = 13  AND to_branch = '$branch'")
            ->count();
    }

    //moderators/admins
    if ($role >= 4) {
        $total_shipments = App\Models\Shipment::count();
        $pending_shipments = App\Models\Shipment::where('status', '0')->count();
        $shipped_shipments = App\Models\Shipment::where('status', '4')->count();
        $delivered_shipments = App\Models\Shipment::where('status', '13')->count();
    }

    //Annoucement
    $bbcode = new ChrisKonnertz\BBCode\BBCode();
    $site_announcement = $bbcode->render(strip_tags(get_content_locale(get_config('site_announcement'), $user_lang)));
?>

<?php $__env->startSection('content'); ?>
    <?php if($site_announcement != ''): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="alert alert-light-warning" role="alert">
                    <ion-icon name="mic-outline" style="font-size: 20px"></ion-icon> <span><?php echo $site_announcement; ?></span>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if($role != 2): ?>
        <div class="row">
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-pattern">
                    <div class="card-body">

                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column h-100">
                                    <p class="fs-md text-muted mb-3"><?php echo e(trans_choice('messages.Shipment', 2)); ?></p>
                                    <h3 class="mb-0 mt-auto">
                                        <span class="counter-value" data-target="<?php echo e($total_shipments); ?>">0</span>
                                        <?php if(preg_match('/-/i', $percentageIncreaseThisMonth)): ?>
                                            <small class="text-danger fs-xs mb-0 ms-1"><i class="bi bi-arrow-down me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonth)), 2)); ?>%
                                            </small>
                                        <?php else: ?>
                                            <small class="text-success fs-xs mb-0 ms-1"><i class="bi bi-arrow-up me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonth)), 2)); ?>%
                                            </small>
                                        <?php endif; ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="stat1" data-colors='["--tb-primary"]' dir="ltr">
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column h-100">
                                    <p class="fs-md text-muted mb-3"><?php echo e(trans_choice('messages.Pending', 1)); ?></p>
                                    <h3 class="mb-0 mt-auto">
                                        <span class="counter-value" data-target="<?php echo e($pending_shipments); ?>">0</span>
                                        <?php if(preg_match('/-/i', $percentageIncreaseThisMonthP)): ?>
                                            <small class="text-danger fs-xs mb-0 ms-1"><i class="bi bi-arrow-down me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonthP)), 2)); ?>%
                                            </small>
                                        <?php else: ?>
                                            <small class="text-success fs-xs mb-0 ms-1"><i class="bi bi-arrow-up me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonthP)), 2)); ?>%
                                            </small>
                                        <?php endif; ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="stat2" data-colors='["--tb-warning"]' dir="ltr">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column h-100">
                                    <p class="fs-md text-muted mb-3"><?php echo e(trans_choice('messages.Shipped', 1)); ?></p>
                                    <h3 class="mb-0 mt-auto">
                                        <span class="counter-value" data-target="<?php echo e($shipped_shipments); ?>">0</span>
                                        <?php if(preg_match('/-/i', $percentageIncreaseThisMonthS)): ?>
                                            <small class="text-danger fs-xs mb-0 ms-1"><i class="bi bi-arrow-down me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonthS)), 2)); ?>%
                                            </small>
                                        <?php else: ?>
                                            <small class="text-success fs-xs mb-0 ms-1"><i class="bi bi-arrow-up me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonthS)), 2)); ?>%
                                            </small>
                                        <?php endif; ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="stat3" data-colors='["--tb-success"]' dir="ltr">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xxl-3 col-md-6">
                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="d-flex">
                            <div class="flex-grow-1">
                                <div class="d-flex flex-column h-100">
                                    <p class="fs-md text-muted mb-3"><?php echo e(trans_choice('messages.Delivered', 1)); ?></p>
                                    <h3 class="mb-0 mt-auto">
                                        <span class="counter-value" data-target="<?php echo e($delivered_shipments); ?>">0</span>
                                        <?php if(preg_match('/-/i', $percentageIncreaseThisMonthD)): ?>
                                            <small class="text-danger fs-xs mb-0 ms-1"><i class="bi bi-arrow-down me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonthD)), 2)); ?>%
                                            </small>
                                        <?php else: ?>
                                            <small class="text-success fs-xs mb-0 ms-1"><i class="bi bi-arrow-up me-1"></i>
                                                <?php echo e(number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $percentageIncreaseThisMonthD)), 2)); ?>%
                                            </small>
                                        <?php endif; ?>

                                    </h3>
                                </div>
                            </div>
                            <div class="flex-shrink-0">
                                <div id="stat4" data-colors='["--tb-success"]' dir="ltr">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    <?php else: ?>
        <div class="row">
            <div class="col-xl-4 col-md-4">

                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="float-right">
                            <ion-icon style="font-size: 40px" class="text-primary h4 ml-3" name="folder-open-outline">
                            </ion-icon>
                        </div>
                        <h5 class="font-size-20 mt-0 pt-1"><?php echo e($total_shipments); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(trans_choice('messages.Total_Shipment', 1)); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="float-right">
                            <ion-icon style="font-size: 40px" class="text-primary h4 ml-3" name="paper-plane-outline">
                            </ion-icon>
                        </div>
                        <h5 class="font-size-20 mt-0 pt-1"><?php echo e($outfordelivery_shipments); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(trans_choice('messages.Out_for_Delivery', 1)); ?></p>
                    </div>
                </div>
            </div>
            <div class="col-xl-4 col-md-4">
                <div class="card bg-pattern">
                    <div class="card-body">
                        <div class="float-right" style="float: right">
                            <ion-icon style="font-size: 40px" class="text-primary h4 ml-3" name="checkmark-circle-outline">
                            </ion-icon>
                        </div>
                        <h5 class="font-size-20 mt-0 pt-1"><?php echo e($delivered_shipments); ?></h5>
                        <p class="text-muted mb-0"><?php echo e(trans_choice('messages.Delivered', 1)); ?></p>
                    </div>
                </div>
            </div>
        </div>
    <?php endif; ?>

    
    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_admin')): ?>
        <div class="row">
            <div class="col-md-12">
                <div class="card card-height-100">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo e(trans_choice('messages.Last_7_Day', 1)); ?></h4>
                        
                    </div>
                    
                    <div class="card-body">
                        <?php echo $chart1->renderHtml(); ?>

                    </div>
                </div>
            </div>
            
        </div>
        <div class="row mt-5">
            <div class="col-xl-9">
                <!-- card -->
                <div class="card">
                    <div class="card-header align-items-center d-flex">
                        <h4 class="card-title mb-0 flex-grow-1"><?php echo e(trans_choice('messages.Summary', 1)); ?></h4>
                        <div class="flex-shrink-0">
                            <a href="" class="btn btn-subtle-primary btn-sm">
                                Add Shipment
                            </a>
                        </div>
                    </div><!-- end card header -->

                    <!-- card body -->
                    <div class="card-body">

                        <div class="row">
                            <div class="col-lg-8">
                                <div xstyle="height: 340px">
                                    <?php echo $chart2->renderHtml(); ?>

                                </div>
                                
                            </div>
                            <div class="col-lg-4">
                                <div class="mb-4">
                                    <h6 class="text-muted mb-3 fw-medium fs-xs text-uppercase"><?php echo e(trans_choice('messages.Top_Country', 1)); ?> (<?php echo app('translator')->get('messages.Destination'); ?>)</h6>
                                    <h3><span class="counter-value" data-target="<?php echo e(App\Models\Shipment::count()); ?>"></span> <small
                                            class="text-muted fw-normal fs-sm"><?php echo e(trans_choice('messages.Shipment', 2)); ?></small></h3>
                                </div>
                                <div>
                                    <ul class="list-unstyled vstack gap-2">
                                        <?php $__currentLoopData = App\Models\Shipment::select('receiver_country')->groupBy('receiver_country')->orderByRaw('COUNT(*) DESC')->take(10)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <li class="p-2 rounded">
                                            <i
                                                class="ri-checkbox-blank-circle-fill text-primary align-bottom me-1"></i>
                                                <?php echo e(get_name($item->receiver_country, 'countries')); ?> <span class="float-end"> <?php echo e(App\Models\Shipment::where('receiver_country', $item->receiver_country)->count()); ?></span>
                                        </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- end card body -->
                </div>
                <!-- end card -->
            </div>
            <div class="col-md-3">
                <div class="card card-height-100" style="">
                    <div class="card-header">
                        <h4><?php echo e(trans_choice('messages.Top_Country', 1)); ?> <small
                                class="text-muted">(<?php echo app('translator')->get('messages.Origin'); ?>)</small></h4>
                    </div>
                    <div class="card-body">

                        <ul class="list-group list-group-flush border-dashed mb-0">

                            <?php $__currentLoopData = App\Models\Shipment::select('sender_country')->groupBy('sender_country')->orderByRaw('COUNT(*) DESC')->take(10)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="list-group-item d-flex align-items-center">
                                    <div class="flex-shrink-0">
                                        <span style="font-size:25px;"
                                            class="rounded fi fi-<?php echo e(locale_to_country(country_code($item->sender_country))); ?>"></span>
                                    </div>
                                    <div class="flex-grow-1 ms-3">
                                        <h6 class="font-size-14 mb-1"><?php echo e(get_name($item->sender_country, 'countries')); ?></h6>

                                    </div>
                                    <div class="flex-shrink-0 text-end">
                                        <h6 class="font-size-14 mb-1">
                                            <?php echo e(App\Models\Shipment::where('sender_country', $item->sender_country)->count()); ?>

                                        </h6>

                                    </div>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>

                    </div>
                </div>
            </div>
           
        </div>
    <?php endif; ?>
    <?php if($role < 5): ?>
    <div class="row mt-5">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4 class="card-label text-uppercase"><?php echo app('translator')->get('messages.Shipment_List'); ?></h4>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-hover nowrap" id="table1">
                            <thead>
                                <tr class="text-uppercase">
                                    <th><?php echo app('translator')->get('messages.Tracking_Number'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Status'); ?></th>
                                    <th><?php echo app('translator')->get('messages.Shipping_Cost'); ?></th>
                                    <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_staff')): ?>
                                        <th><?php echo e(trans_choice('messages.Customer', 1)); ?></th>
                                    <?php endif; ?>
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
        </div>
    </div>
    <?php endif; ?>
    <!-- end row -->
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <link href="<?php echo e(asset(get_theme_dir('plugins'))); ?>/datatables/dataTables.bootstrap5.min.css" rel="stylesheet">
    <style>
        .dataTables_filter label::after {
            /* display: none; */
            content: "";
            /* visibility: hidden; */
        }

      
    </style>
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
                ajax: "<?php echo e(route('dashboard.shipments.datatable', ['type' => 'all', 'id' => 'all'])); ?>",
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
   <?php if (app(\Illuminate\Contracts\Auth\Access\Gate::class)->check('do_moderator')): ?>
   <?php echo $chart1->renderChartJsLibrary(); ?>

   <?php echo $chart1->renderJs(); ?>

   <?php echo $chart2->renderJs(); ?>

   <?php endif; ?>

    
    <!-- apexcharts -->
    <script src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/assets/libs/apexcharts/apexcharts.min.js"></script>
    <script>
        function getChartColorsArray(e) {
            var t = document.getElementById(e);
            if (t) {
                t = t.dataset.colors;
                if (t)
                    return JSON.parse(t).map((e) => {
                        var t = e.replace(/\s/g, "");
                        return t.includes(",") ?
                            2 === (e = e.split(",")).length ?
                            `rgba(${getComputedStyle(
                              document.documentElement
                          ).getPropertyValue(e[0])}, ${e[1]})` :
                            t :
                            getComputedStyle(
                                document.documentElement
                            ).getPropertyValue(t) || t;
                    });
                console.warn("data-colors attribute not found on: " + e);
            }
        }
        var pieChart,
            propertySaleChart = "",
            propertyRentChart = "",
            visitorsChart = "",
            residencyChart = "",
            totalRevenueChart = "",
            totalIncomeChart = "",
            propertySale2Chart = "",
            propetryRentChart = "",
            chartRadialbarMultipleChart = "",
            areachartmini6Chart = "",
            areachartmini7Chart = "",
            areachartmini8Chart = "",
            areachartmini9Chart = "";
        areachartmini9Chart = "";

        function loadCharts() {
            (t = getChartColorsArray("stat1")) &&
            ((e = {
                    series: [<?php echo e($percentageIncreaseThisMonth); ?>],
                    chart: {
                        width: 110,
                        height: 110,
                        type: "radialBar",
                        sparkline: {
                            enabled: !0
                        },
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: "50%"
                            },
                            track: {
                                margin: 0,
                                background: t,
                                opacity: 0.2
                            },
                            dataLabels: {
                                show: !1
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -15,
                            bottom: -15
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    labels: ["Cricket"],
                    colors: t,
                }),
                "" != propertySaleChart && propertySaleChart.destroy(),
                (propertySaleChart = new ApexCharts(
                    document.querySelector("#stat1"),
                    e
                )).render()),
            (t = getChartColorsArray("stat2")) &&
            ((e = {
                    series: [<?php echo e($percentageIncreaseThisMonthP); ?>],
                    chart: {
                        width: 110,
                        height: 110,
                        type: "radialBar",
                        sparkline: {
                            enabled: !0
                        },
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: "50%"
                            },
                            track: {
                                margin: 0,
                                background: t,
                                opacity: 0.2
                            },
                            dataLabels: {
                                show: !1
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -15,
                            bottom: -15
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    labels: ["Cricket"],
                    colors: t,
                }),
                "" != propertyRentChart && propertyRentChart.destroy(),
                (propertyRentChart = new ApexCharts(
                    document.querySelector("#stat2"),
                    e
                )).render()),
            (t = getChartColorsArray("stat3")) &&
            ((e = {
                    series: [<?php echo e($percentageIncreaseThisMonthS); ?>],
                    chart: {
                        width: 110,
                        height: 110,
                        type: "radialBar",
                        sparkline: {
                            enabled: !0
                        },
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: "50%"
                            },
                            track: {
                                margin: 0,
                                background: t,
                                opacity: 0.2
                            },
                            dataLabels: {
                                show: !1
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -15,
                            bottom: -15
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    labels: ["Cricket"],
                    colors: t,
                }),
                "" != visitorsChart && visitorsChart.destroy(),
                (visitorsChart = new ApexCharts(
                    document.querySelector("#stat3"),
                    e
                )).render()),
            (t = getChartColorsArray("stat4")) &&
            ((e = {
                    series: [<?php echo e($percentageIncreaseThisMonthD); ?>],
                    chart: {
                        width: 110,
                        height: 110,
                        type: "radialBar",
                        sparkline: {
                            enabled: !0
                        },
                    },
                    plotOptions: {
                        radialBar: {
                            hollow: {
                                margin: 0,
                                size: "50%"
                            },
                            track: {
                                margin: 0,
                                background: t,
                                opacity: 0.2
                            },
                            dataLabels: {
                                show: !1
                            },
                        },
                    },
                    grid: {
                        padding: {
                            top: -15,
                            bottom: -15
                        }
                    },
                    stroke: {
                        lineCap: "round"
                    },
                    labels: ["Cricket"],
                    colors: t,
                }),
                "" != residencyChart && residencyChart.destroy(),
                (residencyChart = new ApexCharts(
                    document.querySelector("#stat4"),
                    e
                )).render());
        }
        window.addEventListener("resize", function() {
                pieChart.resize(),
                    setTimeout(() => {
                        loadCharts();
                    }, 0);
            }),
            loadCharts();
        var options = {
                valueNames: [
                    "propert_id",
                    "propert_type",
                    "propert_name",
                    "address",
                    "agent_name",
                    "price",
                    "status",
                ],
            },
            propertyList = new List("propertyList", options).on(
                "updated",
                function(e) {
                    0 == e.matchingItems.length ?
                        (document.getElementsByClassName(
                            "noresult"
                        )[0].style.display = "block") :
                        (document.getElementsByClassName(
                            "noresult"
                        )[0].style.display = "none"),
                        0 < e.matchingItems.length ?
                        (document.getElementsByClassName(
                            "noresult"
                        )[0].style.display = "none") :
                        (document.getElementsByClassName(
                            "noresult"
                        )[0].style.display = "block");
                }
            ),
            sorttableDropdown = document.querySelectorAll(".sortble-dropdown");
        sorttableDropdown &&
            sorttableDropdown.forEach(function(r) {
                r.querySelectorAll(".dropdown-menu .dropdown-item").forEach(function(
                    t
                ) {
                    t.addEventListener("click", function() {
                        var e = t.innerHTML;
                        r.querySelector(".dropdown-title").innerHTML = e;
                    });
                });
            });
    </script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/dashboard.blade.php ENDPATH**/ ?>