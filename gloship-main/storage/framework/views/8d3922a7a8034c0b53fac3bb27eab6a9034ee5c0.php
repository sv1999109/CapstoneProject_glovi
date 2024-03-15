<?php $__env->startSection('content'); ?>
    <?php echo $__env->make(get_theme_dir('layouts.partials.page-heading-empty'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <div id="tracking-page" class="features_page">
        <div class="container">

            <?php if(isset($track)): ?>
                <div class="tracking-detail-section mb-5 mt-5">

                    <div class="card">

                        <?php if($track->status == 0 || $track->status == 14): ?>
                            <div class="card-body">
                                <div class="alert alert-<?php echo e(get_status_color($track->status, 'shipments')); ?> alert-dismissible fade show"
                                    role="alert">

                                    <strong><?php echo app('translator')->get('messages.Shipment_Status'); ?>:</strong>
                                    <?php echo e(get_status('shipments', $track->status)); ?>.
                                    <blockquote> <?php echo e(get_status('shipment-notes', $track->status)); ?></blockquote>
                                </div>
                            </div>
                        <?php else: ?>
                            <div class="card-body">
                                <h3 class="card-title text-muted text-center">

                                    <?php echo e(get_status('shipments', $track->status)); ?>


                                    
                                    <?php if($track->status == 5 || $track->status == 6 || $track->status == 7): ?>
                                        
                                        <?php if($track->status == 6 || $track->status == 7): ?>
                                            at
                                            <?php echo e($track->current_location); ?>

                                        <?php endif; ?>
                                       

                                        
                                    <?php endif; ?>
                                </h3>

                                <h5 class="card-subtitle text-muted text-center text-sm">
                                    <small>
                                        <i>
                                            <?php echo app('translator')->get('messages.Last_Updated_On'); ?>
                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->updated_at),'format' => 'l jS \of F Y h:i:s A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?> UTC(
                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => Carbon\Carbon::parse($track->updated_at),'format' => 'p'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>)
                                        </i>
                                    </small>
                                </h5>
                                <div class="row mt-5">
                                    <div class="col-md-10" style="float: none; margin:auto">
                                        <ul class="cbp_track">

                                            
                                            <?php if($track->status != 10): ?>
                                                <li class="shipment-item">
                                                    <?php if($track->delivery_date): ?>
                                                        <time class="cbp_tmtime">
                                                            <span>
                                                                <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->delivery_date),'format' => 'j M, Y'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                            </span>

                                                            <?php if($track->status != 13): ?>
                                                                <span><?php echo app('translator')->get('messages.Estimated'); ?></span>
                                                            <?php endif; ?>
                                                        </time>
                                                    <?php endif; ?>
                                                    <div class="cbp_tmicon"> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel empty">
                                                        <h2><strong> <?php echo e(get_status('shipments', '13')); ?></strong></h2>
                                                        <?php if($track->status == 13): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status == 9): ?>
                                                <li class="shipment-item bg-error">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->updated_at),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                        </span>
                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->diffForHumans()); ?></span>
                                                    </time>
                                                    <div class="cbp_tmicon text-bg-danger"> <i class="fa fa-times"></i>
                                                    </div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> <?php echo e(get_status('shipments', $track->status)); ?></strong>
                                                        </h2>
                                                        <?php if($track->status == 9): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>

                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status != 10 && $track->status != 11 && $track->delivery_type == 2): ?>
                                                <li
                                                    class="shipment-item <?php if($track->status >= 8): ?> bg-passed <?php endif; ?>">

                                                    <div class="cbp_tmicon"> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> <?php echo e(get_status('shipments', '8')); ?></strong></h2>
                                                        <?php if($track->status == 8): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status == 11): ?>
                                                <li
                                                    class="shipment-item <?php if($track->status >= 8): ?> bg-passed <?php endif; ?>">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->updated_at),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                        </span>
                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->diffForHumans()); ?></span>
                                                    </time>

                                                    <div class="cbp_tmicon"> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> <?php echo e(get_status('shipments', $track->status)); ?></strong>
                                                        </h2>
                                                        <?php if($track->status == 11): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status == 5 || $track->status == 6 || $track->status == 7): ?>
                                                <li class="shipment-item bg-passed">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->updated_at),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                        </span>
                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->diffForHumans()); ?></span>
                                                    </time>
                                                    <div class="cbp_tmicon "> <i class="fa fa-map-marker-alt"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2>
                                                            <strong>
                                                                <?php echo e(get_status('shipments', $track->status)); ?>

                                                                
                                                                <?php if($track->status == 6 || $track->status == 7): ?>
                                                                    at
                                                                <?php endif; ?>
                                                                

                                                                <?php echo e($track->current_location); ?>

                                                            </strong>
                                                        </h2>
                                                        <blockquote><?php echo e(get_content_locale($track->note)); ?></blockquote>

                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status != 10): ?>
                                                <li
                                                    class="shipment-item  <?php if($track->status >= 4 && $track->status != 10): ?> bg-passed <?php endif; ?>">
                                                    <?php if($track->shipped_date): ?>
                                                        <time class="cbp_tmtime">
                                                            <?php if($track->status >= 4): ?>
                                                                <span>
                                                                    <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse(
                                                                        $track->shipped_date,
                                                                    ),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                                </span>
                                                                <span><?php echo e(\Carbon\Carbon::parse($track->shipped_date)->diffForHumans()); ?></span>
                                                            <?php endif; ?>
                                                        </time>
                                                    <?php endif; ?>

                                                    <div class="cbp_tmicon "> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> <?php echo e(get_status('shipments', '4')); ?></strong></h2>
                                                        <?php if($track->status == 4): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php elseif($track->status >= 4): ?>
                                                            <?php echo e(__('Your parcel has been shipped')); ?>

                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status == 3): ?>
                                                <li class="shipment-item bg-passed">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->updated_at),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                        </span>
                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->diffForHumans()); ?></span>
                                                    </time>
                                                    <div class="cbp_tmicon "> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> <?php echo e(get_status('shipments', $track->status)); ?></strong>
                                                        </h2>
                                                        <?php if($track->status == 3): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>

                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status == 2): ?>
                                                <li class="shipment-item bg-passed">
                                                    <time class="cbp_tmtime">

                                                        <span>
                                                            <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->updated_at),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                        </span>
                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->diffForHumans()); ?></span>
                                                    </time>
                                                    <div class="cbp_tmicon "> <i class="fa fa-check"></i></div>
                                                    <div class="cbp_tmlabel">
                                                        
                                                        </h2>
                                                        <?php if($track->status == 2): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>

                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            
                                            <?php if($track->status == 10): ?>
                                                <li class="shipment-item bg-error">
                                                    <time class="cbp_tmtime">

                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->format('H:i A')); ?></span>
                                                        <span><?php echo e(\Carbon\Carbon::parse($track->updated_at)->diffForHumans()); ?></span>
                                                    </time>
                                                    <div class="cbp_tmicon text-bg-danger"> <i class="fa fa-times"></i>
                                                    </div>
                                                    <div class="cbp_tmlabel">
                                                        <h2><strong> <?php echo e(get_status('shipments', $track->status)); ?></strong>
                                                        </h2>
                                                        <?php if($track->status == 10): ?>
                                                            <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                            </blockquote>
                                                        <?php endif; ?>

                                                    </div>
                                                </li>
                                            <?php endif; ?>
                                            

                                            <li class="shipment-item bg-passed">
                                                <time class="cbp_tmtime">
                                                    <span>
                                                        <?php if (isset($component)) { $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01 = $component; } ?>
<?php $component = App\View\Components\DateTimeZone::resolve(['date' => \Carbon\Carbon::parse($track->created_at),'format' => 'H:i A'] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? (array) $attributes->getIterator() : [])); ?>
<?php $component->withName('date-time-zone'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag && $constructor = (new ReflectionClass(App\View\Components\DateTimeZone::class))->getConstructor()): ?>
<?php $attributes = $attributes->except(collect($constructor->getParameters())->map->getName()->all()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
<?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01)): ?>
<?php $component = $__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01; ?>
<?php unset($__componentOriginalf7d25492024fc89fdc0e0f145f77a2cc6a91fc01); ?>
<?php endif; ?>
                                                    </span>
                                                    <span><?php echo e(\Carbon\Carbon::parse($track->created_at)->diffForHumans()); ?></span>
                                                </time>
                                                <div class="cbp_tmicon "><i class="fa fa-check"></i></div>
                                                <div class="cbp_tmlabel">
                                                    <time class="no-desktop text-muted text-sm float-right"
                                                        datetime="2017-11-03T13:22">
                                                        <span><?php echo e($track->created_at->diffForHumans()); ?></span>
                                                    </time>
                                                    <h2><strong> <?php echo e(get_status('shipments', '1')); ?></strong></h2>
                                                    <?php if($track->status == 1): ?>
                                                        <blockquote><?php echo e(get_status('shipment-notes', $track->status)); ?>

                                                        </blockquote>
                                                    <?php else: ?>
                                                        <?php echo e(__('Your label has been created')); ?>

                                                    <?php endif; ?>
                                                </div>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="col-md-12">
                                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link active" id="fact-tab" data-bs-toggle="tab"
                                                    data-bs-target="#fact-tab-pane" type="button" role="tab"
                                                    aria-controls="fact-tab-pane"
                                                    aria-selected="true"><?php echo app('translator')->get('messages.Shipment_Fact'); ?></button>
                                            </li>
                                            <li class="nav-item" role="presentation">
                                                <button class="nav-link" id="profile-tab" data-bs-toggle="tab"
                                                    data-bs-target="#logs-tab-pane" type="button" role="tab"
                                                    aria-controls="logs-tab-pane"
                                                    aria-selected="false"><?php echo app('translator')->get('messages.Shipment_Logs'); ?></button>
                                            </li>
                                        </ul>
                                        <div class="tab-content" id="myTabContent">
                                            <div class="tab-pane fade show active" id="fact-tab-pane" role="tabpanel"
                                                aria-labelledby="fact-tab" tabindex="0">
                                                <div class="table-responsive mt-5">

                                                    <table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th
                                                                    class="pl-0 font-weight-bold text-muted text-uppercase">
                                                                    <?php echo app('translator')->get('messages.Origin'); ?></th>
                                                                <th class="text-right text-muted text-uppercase">
                                                                    <?php echo app('translator')->get('messages.Destination'); ?></th>
                                                                <th class="pr-0 text-right text-muted text-uppercase">
                                                                    <?php echo app('translator')->get('messages.Tracking_Number'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <tr class="font-weight-boldest">
                                                                <td> <?php echo e(get_name($track->sender_state, 'states')); ?>,
                                                                    <?php echo e(get_name($track->sender_country, 'countries')); ?>

                                                                </td>
                                                                <td> <?php echo e(get_name($track->receiver_state, 'states')); ?>,
                                                                    <?php echo e(get_name($track->receiver_country, 'countries')); ?>

                                                                </td>
                                                                <td> <?php echo e($track->code); ?></td>
                                                            </tr>
                                                        </tbody>
                                                    </table>

                                                    <table class="table table-bordered mt-5">
                                                        <thead>
                                                            <tr>
                                                                <th style="width: 59%"
                                                                    class="pl-0 font-weight-bold text-muted text-uppercase">
                                                                    <?php echo e(trans_choice('messages.Item', 2)); ?></th>
                                                                <th class="text-right  text-muted text-uppercase">
                                                                    <?php echo app('translator')->get('messages.Weight_Kg'); ?></th>
                                                                <th class="pr-0 text-right  text-muted text-uppercase">
                                                                    <?php echo app('translator')->get('messages.Quantity'); ?></th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            <?php $__currentLoopData = $packages; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $package): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                                <tr class="font-weight-boldest">
                                                                    <td style="width: 59%"><strong>
                                                                            <?php echo e($package->description); ?></strong></td>
                                                                    <td> <?php echo e($package->weight); ?></td>
                                                                    <td> <?php echo e($package->qty); ?></td>
                                                                </tr>
                                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                        </tbody>
                                                    </table>

                                                </div>
                                            </div>
                                            <div class="tab-pane fade" id="logs-tab-pane" role="tabpanel"
                                                aria-labelledby="logs-tab" tabindex="0">

                                                <div class="col-md-10 mt-5" style="float: none; margin:auto">
                                                    <ul class="cbp_track">

                                                        <?php $__currentLoopData = $logs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $log): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                            <?php if($log->note != ''): ?>
                                                                <li class="shipment-item bg-passed">
                                                                    <time class="cbp_tmtime">
                                                                        <span><?php echo e($log->created_at->diffForHumans()); ?></span>
                                                                    </time>
                                                                    <div class="cbp_tmicon bg-passed"><i
                                                                            class="fa fa-comment"></i>
                                                                    </div>
                                                                    <div class="cbp_tmlabel">
                                                                        <time
                                                                            class="no-desktop text-muted text-sm float-right"
                                                                            datetime="2017-11-03T13:22">
                                                                            <span><?php echo e($log->created_at->diffForHumans()); ?></span>
                                                                        </time>

                                                                        <blockquote>
                                                                            <?php echo e(get_status('shipment-notes', $log->note)); ?>

                                                                        </blockquote>
                                                                    </div>
                                                                </li>
                                                            <?php endif; ?>
                                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                    </ul>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            <?php else: ?>
                <div class="card mb-5" style="max-width: 800px; float: none; margin: auto;">
                    <div class="row header top text-center mt-2 p-5 card-body">
                        <div class="col-md-12">
                            <h1 class="mb-3 h-title"><?php echo app('translator')->get('messages.Shipment_Tracking'); ?></h1>

                            <?php if(isset($error)): ?>
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                    <strong><?php echo app('translator')->get('messages.Error_Occured'); ?></strong> <?php echo e($error); ?>

                                </div>
                            <?php endif; ?>'

                            <h3 style="font-size: 20px; line-height: 1.5; color:#333333"><?php echo app('translator')->get('messages.Track_Shipment_Subtitle'); ?></h3>
                        </div>

                        <form class="form" action="" method="GET">
                            <div class="mb-3">
                                <input type="text" placeholder="<?php echo e(__('messages.Tracking_Number_Input')); ?>"
                                    class="form-control track-input input-rounded" name="code">
                            </div>
                            <div class="mb-3">
                                <button type="submit" class="btn btn-primary w-100"><span class="bi bi-search me-2"></span> <?php echo app('translator')->get('messages.Track'); ?></button>
                            </div>
                        </form>

                    </div>
                </div>
            <?php endif; ?>

        </div>
    </div>
<?php $__env->stopSection(); ?>
<?php $__env->startPush('css'); ?>
    <style>
        .cbp_track,
        .cbp_track>li {
            position: relative
        }

        .button,
        .button-outline {
            vertical-align: middle;
            zoom: 1;
            -webkit-transition: .2s linear;
            -moz-transition: .2s linear;
            -ms-transition: .2s linear;
            -o-transition: .2s linear
        }

        .button,
        .button-clear,
        .button-outline {
            display: inline-block;
            -webkit-font-smoothing: antialiased
        }

        .button,
        .button-clear,
        .button-outline,
        .cbp_track>li .cbp_tmicon,
        .navbar.normal {
            -webkit-font-smoothing: antialiased
        }

        #blogpost h6 a,
        .button-clear,
        .button-clear:hover,
        .button-outline:hover,
        .button:hover,
        .call-to-action-below-alt a:hover,
        .cbp_track>li .cbp_tmlabel h2 a:hover {
            text-decoration: none
        }

        .cbp_track {
            margin: 0;
            padding: 0;
            list-style: none
        }

        .cbp_track:before {
            content: '';
            position: absolute;
            top: 0;
            bottom: 0;
            width: 3px;
            background: var(--color-primary);
            left: 20%;
            margin-left: -6px
        }

        .cbp_track>li:first-child .cbp_tmtime span.large {
            color: #444;
            font-size: 17px !important;
            font-weight: 700
        }

        .cbp_track>li:first-child .cbp_tmicon {
            color: #fff
        }

        .cbp_track>li:nth-child(odd) .cbp_tmtime span:last-child {
            color: #444;
            font-size: 13px
        }

        .cbp_track>li:nth-child(odd) .cbp_tmlabel {
            background: #f0f1f3
        }

        .cbp_track>li:nth-child(odd) .cbp_tmlabel:after {
            border-right-color: #f0f1f3
        }

        .cbp_track>li .empty span {
            color: #777
        }

        .cbp_track>li .cbp_tmtime {
            display: block;
            width: 23%;
            padding-right: 70px;
            position: absolute
        }

        .cbp_track>li .cbp_tmtime span {
            display: block;
            text-align: right
        }

        .cbp_track>li .cbp_tmtime span:first-child {
            font-size: 15px;
            color: #3d4c5a;
            font-weight: 700
        }

        .cbp_track>li .cbp_tmtime span:last-child {
            font-size: 14px;
            color: #444
        }

        .cbp_track>li .cbp_tmlabel {
            margin: 0 0 15px 25%;
            background: #f0f1f3;
            padding: 1.2em;
            position: relative;
            border-radius: 5px
        }

        .cbp_track>li .cbp_tmlabel:after {
            right: 100%;
            border: 10px solid transparent;
            content: " ";
            height: 0;
            width: 0;
            position: absolute;
            pointer-events: none;
            border-right-color: #f0f1f3;
            top: 10px
        }

        .cbp_track>li .cbp_tmlabel blockquote {
            font-size: 16px
        }

        .cbp_track>li .cbp_tmlabel .map-checkin {
            border: 5px solid rgba(235, 235, 235, .2);
            -moz-box-shadow: 0 0 0 1px #ebebeb;
            -webkit-box-shadow: 0 0 0 1px #ebebeb;
            box-shadow: 0 0 0 1px #ebebeb;
            background: #fff !important
        }

        .cbp_track>li .cbp_tmlabel h2 {
            margin: 0;
            padding: 0 0 10px;
            line-height: 26px;
            font-size: 16px;
            font-weight: 400
        }

        .cbp_track>li .cbp_tmlabel h2 a,
        .cbp_track>li .cbp_tmlabel h2 span {
            font-size: 15px
        }

        .cbp_track>li .cbp_tmlabel p {
            color: #444
        }

        .cbp_track>li .cbp_tmicon {
            width: 40px;
            height: 40px;
            speak: none;
            font-style: normal;
            font-weight: 400;
            font-variant: normal;
            text-transform: none;
            font-size: 1.4em;
            line-height: 40px;
            position: absolute;
            color: #fff;
            background: #f5f5f6;
            border-radius: 50%;
            box-shadow: 0 0 0 5px var(--color-primary);
            text-align: center;
            left: 20%;
            top: 0;
            margin: 0 0 0 -25px
        }

        @media screen and (max-width: 992px) and (min-width:768px) {
            .cbp_track>li .cbp_tmtime {
                padding-right: 60px
            }
        }

        @media screen and (max-width: 65.375em) {
            .cbp_track>li .cbp_tmtime span:last-child {
                font-size: 12px
            }
        }

        @media screen and (max-width: 47.2em) {

            .cbp_track:before,
            .cbp_track>li .cbp_tmicon {
                left: 5%
            }

            .cbp_track>li .cbp_tmlabel {
                margin: 0 0 15px 15%
            }

            .cbp_track>li .cbp_tmtime {
                display: none
            }
        }

        :focus,
        a:focus,
        button:focus {
            outline: 0
        }

        .button {
            padding: 20px 40px;
            font-weight: 700;
            font-size: 17px;
            color: #fff !important;
            border: 0;
            background-color: var(--color-primary);
            transition: .2s linear
        }

        .button:hover {
            background-color: var(--color-primary);
        }

        .button:hover .arw,
        .call-to-action-button a:hover .arw {
            position: relative;
            left: 1px
        }

        .button:active {
            box-shadow: inset 0 3px 3px rgba(0, 0, 0, .29)
        }

        .button.button-small {
            padding: 10px 33px;
            border: 1px solid #68a2ee;
            font-size: 14px;
            font-weight: 500
        }

        .button.outline {
            border: 3px solid #fff
        }

        .blue-band .button.outline {
            background: #274f95
        }

        .blue-band.separator {
            padding-top: 25px !important;
            padding-bottom: 25px !important
        }

        .button.outline:hover {
            border-color: #43b22f
        }

        .blue-band .button.outline:hover {
            border-color: #2d5cae;
            background: #2d5cae
        }

        .button.transparent {
            background: 0 0
        }

        .button.transparent:hover {
            background: #36c
        }

        .button-outline {
            color: #fff;
            padding: 18px 40px;
            border: 2px solid #fff;
            border-radius: 0;
            font-size: 16px;
            font-weight: 400;
            background: rgba(0, 0, 0, .15);
            text-shadow: 1px 1px 1px rgba(0, 0, 0, .1);
            transition: .2s linear
        }

        .bg-passed .cbp_tmicon {
            background-color: var(--color-primary) !important;
            color: #ffffff;
        }

        .shipment-item h2 strong {
            color: #666;
        }

        .bg-passed h2 strong {
            color: #000000 !important;
        }

        .bg-error .cbp_tmicon {
            background-color: red !important;
            color: #ffffff;
        }

        .bg-error h2 strong {
            color: red !important;
        }

        .card {
            border-radius: 1px;
        }
            
        
        .card {
            border: none;
            margin-bottom: 24px;
            -webkit-box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }
    </style>
<?php $__env->stopPush(); ?>

<?php echo $__env->make(get_theme_dir('layouts.app'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/contents/tracking.blade.php ENDPATH**/ ?>