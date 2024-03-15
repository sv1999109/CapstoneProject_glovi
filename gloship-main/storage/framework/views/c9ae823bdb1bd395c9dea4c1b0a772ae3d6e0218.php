<?php
    //settings
    $user_lang = LaravelLocalization::getCurrentLocale();
    $user = Auth()->user();
    $role = Auth()->user()->role;
    $owner = Auth()->user()->id;
?>

<div class="vertical-overlay"></div>
<header id="page-topbar">
    <div class="layout-width">
        <div class="navbar-header">
            <div class="d-flex">
                <!-- LOGO -->
                <div class="navbar-brand-box horizontal-logo">
                    <a href="index.html" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/assets//images/logo-sm.png"
                                alt="" height="22">
                        </span>
                        <span class="logo-lg">
                            <img src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/assets//images/logo-dark.png"
                                alt="" height="22">
                        </span>
                    </a>

                    
                </div>

                <button type="button"
                    class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger shadow-none"
                    id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                </button>

            </div>

            <div class="d-flex align-items-center">

                <div class="dropdown ms-1 topbar-head-dropdown header-item">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span style="height: 20px;"
                                class="rounded fi fi-<?php echo e(locale_to_country(LaravelLocalization::getCurrentLocale())); ?>"></span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <?php
                            $url = url(LaravelLocalization::getLocalizedURL($localeCode, null, [], true));
                            
                        ?>
                         <!-- item-->
                         <a href="javascript:void(0);" class="dropdown-item notify-item language py-2" rel="alternate" hreflang="<?php echo e($localeCode); ?>"
                         href="<?php echo e($url); ?>">
                         <span style="height: 18px;"
                         class="me-2 rounded fi fi-<?php echo e(locale_to_country($localeCode)); ?>"></span>
                         <?php echo e($properties['native']); ?>

                         </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                      

                    </div>
                </div>

                <div class="ms-1 header-item d-none d-sm-flex">
                    <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                        data-toggle="fullscreen">
                        <i class='bi bi-arrows-fullscreen fs-lg'></i>
                    </button>
                </div>

                
                <?php if(get_config('site_notification') == 'enabled'): ?>
                    <?php
                        $userid = Auth()->user()->id;
                        $count_notice = DB::table('messages')
                            ->where('userid', Auth()->user()->id)
                            ->count();
                        $count_notice_unread = DB::table('messages')
                            ->whereRaw("status = 0 AND userid = ' $userid'")
                            ->count();
                    ?>
                    <div class="dropdown topbar-head-dropdown ms-1 header-item" id="notificationDropdown">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-dark rounded-circle"
                            id="page-header-notifications-dropdown" data-bs-toggle="dropdown"
                            data-bs-auto-close="outside" aria-haspopup="true" aria-expanded="false">
                            <i class='bi bi-bell fs-2xl'></i>
                            <span
                                class="position-absolute topbar-badge fs-3xs translate-middle badge rounded-pill bg-danger"><span
                                    class="notification-badge"
                                    id="notice_count"><?php echo e($count_notice_unread); ?></span><span
                                    class="visually-hidden">unread
                                    messages</span></span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                            aria-labelledby="page-header-notifications-dropdown">

                            <div class="dropdown-head rounded-top">
                                <div class="p-3 border-bottom border-bottom-dashed">
                                    <div class="row align-items-center">
                                        <div class="col">
                                            <h6 class="mb-0 fs-lg fw-semibold">
                                                <?php echo e(trans_choice('messages.Notification', 2)); ?> <span
                                                    class="badge bg-danger-subtle text-danger fs-sm notification-badge"
                                                    id="notice_count"><?php echo e($count_notice_unread); ?></span></h6>
                                            <p class="fs-md text-muted mt-1 mb-0">You have <span
                                                    class="fw-semibold notification-unread"
                                                    id="notice_count"><?php echo e($count_notice_unread); ?></span> unread
                                                messages
                                            </p>
                                        </div>

                                    </div>
                                </div>

                            </div>

                            <div class="py-2 ps-2" id="notificationItemsTabContent">
                                <div data-simplebar style="max-height: 300px;" class="pe-2">
                                    <div id="notices"></div>
                                    <?php if($count_notice > 0): ?>

                                        <?php $__currentLoopData = DB::table('messages')->select('id', 'subject', 'url', 'push', 'created_at')->where('userid', Auth()->user()->id)->limit(5)->orderByDesc('created_at')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $notice): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <?php
                                                if ($notice->push == 0) {
                                                    \App\Models\Messages::where('id', $notice->id)->update([
                                                        'push' => 1,
                                                    ]);
                                                }
                                            ?>
                                            <div
                                                class="text-reset notification-item d-block dropdown-item position-relative unread-message">
                                                <div class="d-flex">
                                                    <div class="avatar-xs me-3 flex-shrink-0">
                                                        <span
                                                            class="avatar-title bg-info-subtle text-info rounded-circle fs-lg">
                                                            <i class="bx bx-badge-check"></i>
                                                        </span>
                                                    </div>
                                                    <div class="flex-grow-1">
                                                        <a href="<?php echo e(route('dashboard.users.notification.view', ['id' => $notice->id])); ?>"
                                                            class="stretched-link">
                                                            <h6 class="mt-0 fs-md mb-2 lh-base">
                                                                <?php echo e(Str::limit(get_content_locale($notice->subject), 50, '...')); ?>

                                                            </h6>
                                                        </a>
                                                        <p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
                                                            <span><i class="mdi mdi-clock-outline"></i>
                                                                <?php echo e(\Carbon\Carbon::parse($notice->created_at)->diffForHumans()); ?></span>
                                                        </p>
                                                    </div>

                                                </div>
                                            </div>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                                        <h6
                                            class="text-overflow text-muted fs-sm my-2 text-uppercase notification-title">
                                            <a
                                                href="<?php echo e(route('dashboard.users.notification')); ?>"><?php echo app('translator')->get('messages.See_All_Notification'); ?></a>
                                        </h6>

                                    <?php endif; ?>

                                </div>

                            </div>
                        </div>
                    </div>
                <?php endif; ?>

                <div class="dropdown ms-sm-3 header-item topbar-user">
                    <button type="button" class="btn shadow-none" id="page-header-user-dropdown"
                        data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <?php if(Auth()->user()->avatar): ?>
                                <img class="rounded-circle header-profile-user"
                                    src="<?php echo e(asset(Auth()->user()->avatar)); ?>" alt="Avatar">
                            <?php else: ?>
                                <span class="rounded-circle header-profile-user">
                                    <span class="avatar-title bg-light rounded text-body fs-4">
                                        <i class="bi bi-person"></i>
                                    </span>
                                </span>
                            <?php endif; ?>
                            <span class="text-start ms-xl-2">
                                <span
                                    class="d-none d-xl-inline-block ms-1 fw-medium user-name-text"><?php echo e(Auth()->user()->firstname); ?>

                                    <?php echo e(Auth()->user()->lastname); ?></span>
                                <span class="d-none d-xl-block ms-1 fs-sm user-name-sub-text"><?php
                                    if ($role == 5) {
                                        echo trans_choice('messages.Admin', 1) . ' <span class="fa fa-check-circle text-warning"></span>';
                                    }
                                    if ($role == 4) {
                                        echo trans_choice('messages.Moderator', 1) . ' <span class="fa fa-check-circle text-primary"></span>';
                                    }
                                    if ($role == 3) {
                                        echo trans_choice('messages.Staff', 1);
                                    }
                                    if ($role == 2) {
                                        echo trans_choice('messages.Delivery_Agent', 1);
                                    }
                                    if ($role == 1) {
                                        echo trans_choice('messages.Customer', 1);
                                    }
                                ?></span>
                            </span>
                        </span>
                    </button>
                    <div class="dropdown-menu dropdown-menu-end">
                        <!-- item-->
                        <h6 class="dropdown-header"><?php echo app('translator')->get('messages.Hi'); ?>, <?php echo e(Auth()->user()->firstname); ?></h6>
                        <a class="dropdown-item"
                            href="<?php echo e(route('dashboard.users.view', ['id' => Auth()->user()->id])); ?>"><i
                                class="mdi mdi-account-circle text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle"><?php echo app('translator')->get('messages.My_Profile'); ?></span></a>
                        <a class="dropdown-item" href="<?php echo e(route('dashboard.users.notification')); ?>"><i
                                class="mdi mdi-message-text-outline text-muted fs-lg align-middle me-1"></i>
                            <span class="align-middle"><?php echo e(trans_choice('messages.Notification', 2)); ?></span></a>

                        <a class="dropdown-item" target="_blank" href="<?php echo e(route('contact')); ?>"><i
                                class="mdi mdi-lifebuoy text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle">Help</span></a>
                        <div class="dropdown-divider"></div>

                        <a class="dropdown-item"
                            href="<?php echo e(route('dashboard.users.edit', ['id' => Auth()->user()->id])); ?>"><span
                                class="badge bg-success-subtle text-success mt-1 float-end">New</span><i
                                class="mdi mdi-cog-outline text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle"> <?php echo e(trans_choice('messages.Setting', 2)); ?></span></a>

                        <a class="dropdown-item" href="<?php echo e(route('logout')); ?>"><i
                                class="mdi mdi-logout text-muted fs-lg align-middle me-1"></i> <span
                                class="align-middle" data-key="t-logout"> <?php echo app('translator')->get('messages.Logout'); ?></span></a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/layouts/partials/header.blade.php ENDPATH**/ ?>