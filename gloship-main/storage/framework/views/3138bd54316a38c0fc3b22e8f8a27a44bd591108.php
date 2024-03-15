<header class="site-header sticky-header">

    <div class="overlay"></div>
    <nav class="navbar navbar-expand-lg fixed-top">
        <div class="container">
            <a class="navbar-brand w-20 logo" href="<?php echo e(route('home')); ?>">
                <?php if(get_theme_config('site_logo_main') == 'enabled'): ?>
                <img class="logo-main" src="<?php echo e(asset(get_contents_admin('logo_main', '', 'all'))); ?>" alt="<?php echo e(get_content_locale(get_config('site_name'))); ?>">
                <img class="logo-light"  src="<?php echo e(asset(get_contents_admin('logo_dashboard', '', 'all'))); ?>?xx" alt="<?php echo e(get_content_locale(get_config('site_name'))); ?>">
                <?php else: ?>
                    <?php echo e(get_content_locale(get_config('site_name'))); ?>

                <?php endif; ?>
            </a>
            <button class="navbar-toggler p-0" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
                aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="bi bi-justify-right"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">



                <ul class="navbar-nav py-lg-3 ms-auto">

                    <?php if(get_theme_config('menu_item_service') == 'enabled'): ?>
                    <li class="nav-item">
                        <a href="<?php echo e(route('pages', ['slug' => 'service'])); ?>"
                            class="nav-link <?php echo e(menu_active('services')); ?>"><?php echo e(trans_choice('messages.Service', 2)); ?>

                        </a>
                    </li>
                <?php endif; ?>

                
                    <?php if(get_theme_config('menu_item_about') != 'enabled'): ?>
                        <li class="nav-item <?php echo e(route('page', ['slug' => 'about'])); ?>">
                            <a href="<?php echo e(route('page', ['slug' => 'about'])); ?>"
                                class="nav-link <?php echo e(menu_active('about')); ?> "><?php echo app('translator')->get('messages.About_Us'); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if(get_theme_config('menu_item_contact') == 'enabled'): ?>
                        <li class="nav-item <?php echo e(menu_active('contact')); ?>">
                            <a href="<?php echo e(route('contact')); ?>"
                                class="nav-link <?php echo e(menu_active('contact')); ?>"><?php echo app('translator')->get('messages.Help'); ?></a>
                        </li>
                    <?php endif; ?>

                    

                    <?php if(get_theme_config('menu_item_faq') != 'enabled'): ?>
                        <li class="nav-item me-3 active">
                            <a href="<?php echo e(route('quote')); ?>"
                                class="nav-link active"><?php echo e(trans_choice('messages.Get_Quote', 2)); ?></a>
                        </li>
                    <?php endif; ?>

                    <?php if(get_theme_config('menu_item_login') == 'enabled'): ?>
                        <?php if(auth()->guard()->check()): ?>
                        
                            
                        <li class="nav-item"> <a href="<?php echo e(route('dashboard.index')); ?>" 
                            class="nav-btn btn btn-primary"><?php echo app('translator')->get('messages.Dashboard'); ?></a></li>
                            
                        <?php endif; ?>
                        <?php if(auth()->guard()->guest()): ?>
                        <li class="nav-item"> <a href="<?php echo e(route('login')); ?>"
                            class="nav-link "><?php echo app('translator')->get('messages.Login'); ?></a></li>
                        <li class="nav-item"> <a href="<?php echo e(route('login')); ?>"
                        class="nav-btn btn btn-primary"><?php echo app('translator')->get('messages.Create_Account'); ?></a></li>
                        <?php endif; ?>
                    <?php endif; ?>
                    
                </ul>

            </div>
        </div>
    </nav>
</header>


<header class="site-header" role="banner" style="display: none">

    <div class="e-nav" style="padding-left:20px; display: none; ">
        <div class="container xrow">
            <div class="row">
                <div class="col-sm-6">
                    <?php if(get_theme_config('menu_item_phone') == 'enabled'): ?>
                        <a href="tel:<?php echo e(get_config('site_phone')); ?>" class="email-top">
                            <span class="phone-top">
                                <ion-icon name="call-outline"></ion-icon>
                                <?php echo e(get_config('site_phone')); ?>

                            </span>
                        </a>
                    <?php endif; ?>
                    <?php if(get_theme_config('menu_item_email') == 'enabled'): ?>
                        <span class="divider"></span>
                        <a href="mail:<?php echo e(get_config('site_email_support')); ?>" class="email-top">
                            <ion-icon name="mail-outline"></ion-icon>
                            <?php echo e(get_config('site_email_support')); ?>

                        </a>
                    <?php endif; ?>
                </div>
                <div class="col-sm-6 btns">
                    <?php if(get_theme_config('menu_item_login') == 'enabled'): ?>
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

                    <?php if(get_theme_config('menu_item_language') == 'enabled'): ?>
                        <a href="#" class="button white dropdown-toggle" href="#" id="dropdownId"
                            data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <span
                                class="fi fi-<?php echo e(locale_to_country(LaravelLocalization::getCurrentLocale())); ?>"></span>
                            <?php echo e(LaravelLocalization::getCurrentLocaleName()); ?>

                        </a>
                        <ul>
                            <li class="nav-item dropdown lang-switcher">
                                <div class="dropdown-menu" aria-labelledby="dropdownId">
                                    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $url = url(LaravelLocalization::getLocalizedURL($localeCode, null, [], true));
                                        ?>
                                        <a class="dropdown-item" rel="alternate" hreflang="<?php echo e($localeCode); ?>"
                                            href="<?php echo e($url); ?>">
                                            <?php echo e($properties['native']); ?>

                                        </a>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </div>
                            </li>
                        </ul>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>

    
    <?php echo $__env->make(get_theme_dir('layouts.partials.nav'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

</header>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/layouts/partials/header.blade.php ENDPATH**/ ?>