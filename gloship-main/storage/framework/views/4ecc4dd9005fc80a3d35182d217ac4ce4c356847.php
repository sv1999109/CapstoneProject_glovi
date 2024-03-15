
<nav class="navbar normal navbar-expand-lg navbar-light navbar-default mega">
    <div class="container">
        <a href="<?php echo e(route('home')); ?>" class="navbar-brand xp-0">
            <?php if(get_theme_config('site_logo_main') == 'enabled'): ?>
                <img class="logo-main" src="<?php echo e(asset(get_contents_admin('logo_main', '', 'all'))); ?>" alt="<?php echo e(get_content_locale(get_config('site_name'))); ?>">
                <img class="logo-light"  src="<?php echo e(asset(get_contents_admin('logo_dashboard', '', 'all'))); ?>" alt="<?php echo e(get_content_locale(get_config('site_name'))); ?>" style="display: none">
            <?php else: ?>
                <?php echo e(get_content_locale(get_config('site_name'))); ?>

            <?php endif; ?>
        </a>
        <span class="no-desktop lang ms-auto py-0 pr-4" style="padding-right: 15px">
            <a class="dropdown-toggle" href="#" id="langId" data-bs-toggle="dropdown" aria-haspopup="true"
                aria-expanded="false">
                <span class="fi fi-<?php echo e(locale_to_country(LaravelLocalization::getCurrentLocale())); ?>"></span>

            </a>
            <div class="nav-item dropdown lang-switcher">
                <div class="dropdown-menu" aria-labelledby="langId">
                    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <a class="dropdown-item" rel="alternate" hreflang="<?php echo e($localeCode); ?>"
                            href="<?php echo e(LaravelLocalization::getLocalizedURL($localeCode, null, [], true)); ?>">
                            <?php echo e($properties['native']); ?>

                        </a>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </div>
            </div>
        </span>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#menu">
            <span class="fa fa-bars"></span>
        </button>
        <div class="collapse navbar-collapse pt-4" id="menu">
            <ul class="navbar-nav ms-auto py-0">
                <?php if(get_theme_config('menu_item_phone') == 'enabled'): ?>
                    <li class="nav-item mobile-phone no-desktop">
                        <a class="nav-link" href="tel:<?php echo e(get_config('site_phone')); ?>">
                            <ion-icon name="call-outline"></ion-icon> <?php echo e(get_config('site_phone')); ?>

                        </a>
                    </li>
                <?php endif; ?>

                <?php if(get_theme_config('menu_item_service') == 'enabled'): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('pages', ['slug' => 'service'])); ?>"
                            class="nav-link <?php echo e(menu_active('services')); ?>"><?php echo e(trans_choice('messages.Our_Service', 2)); ?>

                        </a>
                    </li>
                <?php endif; ?>

                <?php if(get_theme_config('menu_item_contact') == 'enabled'): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('contact')); ?>"
                            class="nav-link <?php echo e(menu_active('contact')); ?>"><?php echo app('translator')->get('messages.Contact_Us'); ?></a>
                    </li>
                <?php endif; ?>
                <?php if(get_theme_config('menu_item_tracking') == 'enabled'): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('tracking')); ?>"
                            class="nav-link button bg-black <?php echo e(menu_active('tracking')); ?>"><?php echo app('translator')->get('messages.Track_Shipment'); ?> </a>
                    </li>
                <?php endif; ?>

                <?php if(get_theme_config('menu_item_login') == 'enabled'): ?>
                <li class="nav-item mt-2 mb-2 no-desktop">
                        <?php if(auth()->guard()->check()): ?>
                            <a href="<?php echo e(route('dashboard.index')); ?>" class="button">
                                <?php echo app('translator')->get('messages.Dashboard'); ?>
                            </a>
                        <?php endif; ?>
                        <?php if(auth()->guard()->guest()): ?>
                            <a href="<?php echo e(route('login')); ?>" class="button">
                                <?php echo app('translator')->get('messages.Login'); ?>
                            </a>
                        <?php endif; ?>
                    <?php endif; ?>
                </li>
            </ul>
        </div>
    </div>
</nav>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/layouts/partials/nav.blade.php ENDPATH**/ ?>