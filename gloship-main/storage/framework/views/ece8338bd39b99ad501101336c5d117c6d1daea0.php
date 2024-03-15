<section class="blurry-bg">
    <div class="bg-overlay py-5">
        <div class="container">
            <div class="row text-center">
                <div class="col-md-12">
                    <h2 class="text-light mb-3">Get the best
                        shipping rates today</h2>
                </div>
                <div class="col-md-12 mt-3">
                    <a href="<?php echo e(route('register')); ?>" class="btn btn-white mb-3">Start shipping now</a>
                </div>
            </div>
        </div>
    </div>
    </section>
    
 <!-- starts footer -->
 <footer class="footer-section">
    <div class="top-section">

        <div class="container-fluid">
            <div class="row py-5">
        
                <?php if(get_theme_config('footer_section_tracking') == 'enabled'): ?>
                <div class="col-md-6 col-lg-3 ps-lg-5">
                    <div class="footer-box">
                        <h4 class="footer-heading font-bold"><?php echo app('translator')->get('messages.Track_Shipment'); ?></h4>
                        <div class="search py-5">
                            <form method="get" id="searchform" class="searchform" action="<?php echo e(route('tracking')); ?>" role="search"
                                data-hs-cf-bound="true">
                                <div class="mb-3">
                                    <input type="text" name="code" class="form-control" placeholder="<?php echo app('translator')->get('messages.Tracking_Number_Input'); ?>">
                                </div>
                                <button class="btn btn-primary w-100" type="submit">
                                    <i class="bi bi-search me-2"></i>
                                    <span class="me-2"> <?php echo app('translator')->get('messages.Track'); ?></span>
                                   
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
                <?php endif; ?>
    
                <div class="col-md-6 col-lg-3 ps-lg-5">
                    <div class="footer-box">
                        <h4 class="footer-heading font-bold">Pages</h4>
                        <div>
                            <ul>
                                <?php
                                    $list = get_contents_list();
                                ?>
        
                                <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <?php
                                        $trans_val = ucfirst($item);
                                    ?>
                                    <?php if($item != 'page'): ?>
                                        <li>
                                            <a class="me-2"
                                                href="<?php echo e(route('pages', ['slug' => $item])); ?>"><?php echo e(trans_choice("messages.$trans_val", 2)); ?></a>
                                        </li>
                                    <?php endif; ?>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    
                            </ul>
                        </div>
                        
                    </div>
                </div>
    
                <div class="col-md-6 col-lg-3 ps-lg-5">
                    <div class="footer-box">
                        <h4 class="footer-heading font-bold"><?php echo e(trans_choice('messages.Service', 2)); ?></h4>
                        <div>
                            <ul>
                     
                     <?php $__currentLoopData = \App\Models\Post::whereRaw("post_type = 'service' AND post_status = '1'")->limit(5)->orderByDesc('created_at')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <li>
                             <a href="<?php echo e(route('page', ['slug' => $post->post_slug])); ?>">
                                 <?php echo e(get_content_locale($post->post_title)); ?>

                             </a>
                         </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                     <li>
                        <a href="<?php echo e(route('pages', ['slug' => 'service'])); ?>">
                            <?php echo e(trans_choice('messages.More', 1)); ?>

                        </a>
                    </li>
                 </ul>
                        </div>
                        
                    </div>
                </div>
    
                <div class="col-md-6 col-lg-3 ps-lg-5">
                    <div class="footer-box">
                        <h4 class="footer-heading font-bold">Contact Us</h4>
                        <ul>
                            <li>
                                <span class="bi bi-box-arrow-up-right me-2"></span>
                                <span><a href="<?php echo e(route('contact')); ?>" class=""><?php echo app('translator')->get('messages.Contact_Us'); ?></a></span>
                            </li>
                            <li>
                                <i class="bi bi-phone me-2"></i>
                                <span><?php echo e(get_config('site_phone')); ?></span>
                            </li>
                            <li>
                                <i class="bi bi-envelope me-2"></i>
                                <span><?php echo e(get_config('site_email_support')); ?></span>
                            </li>
                            <li>
                                <span class="bi bi-geo-alt me-2"></span>
                                <span><?php echo e(get_config('site_head_office')); ?></span>
                            </li>
                        </ul>
                    </div>
                    <div class="social-links mb-3 ">
                        <?php if(!get_config('facebook_link')): ?>
                            <a href="<?php echo e(get_config('facebook_link')); ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="footer-social-icon">
                                    <path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"></path>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!get_config('instagram_link')): ?>
                            <a href="<?php echo e(get_config('instagram_link')); ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="footer-social-icon">
                                    <rect x="2" y="2" width="20" height="20" rx="5"
                                        ry="5"></rect>
                                    <path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"></path>
                                    <line x1="17.5" y1="6.5" x2="17.51" y2="6.5"></line>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!get_config('youtube_link')): ?>
                            <a href="<?php echo e(get_config('youtube_link')); ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round" class="footer-social-icon">
                                    <path
                                        d="M22.54 6.42a2.78 2.78 0 0 0-1.94-2C18.88 4 12 4 12 4s-6.88 0-8.6.46a2.78 2.78 0 0 0-1.94 2A29 29 0 0 0 1 11.75a29 29 0 0 0 .46 5.33A2.78 2.78 0 0 0 3.4 19c1.72.46 8.6.46 8.6.46s6.88 0 8.6-.46a2.78 2.78 0 0 0 1.94-2 29 29 0 0 0 .46-5.25 29 29 0 0 0-.46-5.33z">
                                    </path>
                                    <polygon points="9.75 15.02 15.5 11.75 9.75 8.48 9.75 15.02"></polygon>
                                </svg>
                            </a>
                        <?php endif; ?>
                        <?php if(!get_config('twitter_link')): ?>
                            <a href="<?php echo e(get_config('twitter_link')); ?>" target="_blank">
                                <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20"
                                    viewBox="0 0 24 24" fill="currentColor" stroke="currentColor" stroke-width="1"
                                    stroke-linecap="round" stroke-linejoin="round" class="footer-social-icon">
                                    <path
                                        d="M23 3a10.9 10.9 0 0 1-3.14 1.53 4.48 4.48 0 0 0-7.86 3v1A10.66 10.66 0 0 1 3 4s-4 9 5 13a11.64 11.64 0 0 1-7 2c9 5 20 0 20-11.5a4.5 4.5 0 0 0-.08-.83A7.72 7.72 0 0 0 23 3z">
                                    </path>
                                </svg>
                            </a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

      
    </div>

    <div class="copyright-section">
        <div class="footer-copyright">
            <div class="container mt-3">
                <div class="row">
                    <div class="col-md-6 text-center text-md-start mb-3 mb-md-0">
                        <p class="text-muted"><?php echo e(get_content_locale(get_config('site_copyright'))); ?></p>
                    </div>
                    <div class="col-md-6 text-center text-md-end pb-3">
                      
                       <div class="mb-3">
                        <ul>
                            <li class="lang-switcher-nav nav-item py-lg-2 dropdown">
                                <a href="#" data-bs-toggle="dropdown" aria-expanded="false" class="rounded" style="border: 1px solid; padding: 5px 10px;">
                                    <span class="lang-img fi fi-<?php echo e(locale_to_country(LaravelLocalization::getCurrentLocale())); ?>"></span> <?php echo e((LaravelLocalization::getCurrentLocaleName())); ?>

                                </a>
                                <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="dropdownMenuButton">
                                    <?php $__currentLoopData = LaravelLocalization::getSupportedLocales(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $localeCode => $properties): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <?php
                                            $url = url(LaravelLocalization::getLocalizedURL($localeCode, null, [], true));
                                            
                                        ?>
                                        <li class="lang-switcher">
                        
                                            <a class="dropdown-item" rel="alternate" hreflang="<?php echo e($localeCode); ?>"
                                                href="<?php echo e($url); ?>">
                                                <span class="lang-img fi fi-<?php echo e(locale_to_country( $localeCode )); ?>"></span><?php echo e($properties['native']); ?>

                                            </a>
                        
                                        </li>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </ul>
                            </li>
                        </ul>
                       </div>
                          <div class="bm-links">
        
                                <?php $__currentLoopData = \App\Models\Post::whereRaw("post_type = 'page' AND post_status = '1'")->limit(6)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                   
                                        <a href="<?php echo e(route('page', ['slug' => $post->post_slug])); ?>">
                                            <?php echo e(get_content_locale($post->post_title)); ?>

                                        </a>
                                  
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </div>
                       
                    </div>
                </div>
            </div>
        </div> 
    </div>
</footer>

<?php $__env->startPush('css'); ?>
    <style>
       .bm-links u {
           display: flex;
           
        }
    </style>
<?php $__env->stopPush(); ?>

 <footer id="footer" class="content-info" style="display: none">
     <div class="content d-flex wrapper justify-content-between flex-wrap mb-5">
          
         
         <?php if(get_theme_config('footer_section_tracking') == 'enabled'): ?>
             <div class="footer--column">
                 <div class="col-title mb-3"><?php echo app('translator')->get('messages.Track_Shipment'); ?></div>
                 <div class="search">
                     <form method="get" id="searchform" class="searchform" action="<?php echo e(route('tracking')); ?>" role="search"
                         data-hs-cf-bound="true">
                         <div class="mb-3">
                             <input type="text" name="code" class="form-control" placeholder="<?php echo app('translator')->get('messages.Code'); ?>">
                         </div>
                         <button class="btn btn-primary w-100" type="submit">
                             <?php echo app('translator')->get('messages.Track'); ?>
                             <i class="fa fa-arrow-circle-right"></i>
                         </button>
                     </form>
                 </div>
             </div>
         <?php endif; ?>

         
         <?php if(get_theme_config('footer_section_service') == 'enabled'): ?>
             <div class="footer--column">
                 <div class="col-title"><?php echo e(trans_choice('messages.Service', 2)); ?></div>
                 <ul>
                     <li>
                         <a href="<?php echo e(route('pages', ['slug' => 'service'])); ?>">
                             <?php echo e(trans_choice('messages.Service', 2)); ?>

                         </a>
                     </li>
                     <?php $__currentLoopData = \App\Models\Post::whereRaw("post_type = 'service' AND post_status = '1'")->limit(10)->orderByDesc('created_at')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <li>
                             <a href="<?php echo e(route('page', ['slug' => $post->post_slug])); ?>">
                                 <?php echo e(get_content_locale($post->post_title)); ?>

                             </a>
                         </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </ul>
             </div>
         <?php endif; ?>

         
         <?php if(get_theme_config('footer_section_link') == 'enabled'): ?>
             <div class="footer--column">
                 <div class="col-title"> <?php echo e(trans_choice('messages.Link', 2)); ?> </div>
                 <ul>
                     <?php
                         $list = get_contents_list();
                     ?>

                     <?php $__currentLoopData = $list; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $key => $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <?php
                             $trans_val = ucfirst($item);
                         ?>

                         <li>
                             <a href="<?php echo e(route('pages', ['slug' => $item])); ?>"><?php echo e(trans_choice("messages.$trans_val", 2)); ?></a>
                         </li>

                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                     <?php $__currentLoopData = \App\Models\Post::whereRaw("post_type = 'page' AND post_status = '1'")->limit(6)->orderByDesc('created_at')->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $post): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                         <li>
                             <a href="<?php echo e(route('page', ['slug' => $post->post_slug])); ?>">
                                 <?php echo e(get_content_locale($post->post_title)); ?>

                             </a>
                         </li>
                     <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                 </ul>
             </div>
         <?php endif; ?>

         
         <?php if(get_theme_config('footer_section_contact') == 'enabled'): ?>
             <div class="footer--column">
                 <div class="col-title"><?php echo e(trans_choice('messages.Contact', 2)); ?></div>
                 <ul>
                     <li><a href="<?php echo e(route('contact')); ?>"><?php echo e(trans_choice('messages.Contact_Us', 1)); ?></a></li>

                     <?php if(get_config('twitter_link')): ?>
                         <li>
                             <a href="https://twitter.com/<?php echo e(get_config('twitter_link')); ?>" target="_blank"
                                 rel="noopener">Twitter</a>
                         </li>
                     <?php endif; ?>

                     <?php if(get_config('facebook_link')): ?>
                         <li>
                             <a href="https://facebook.com/<?php echo e(get_config('facebook_link')); ?>" target="_blank"
                                 rel="noopener">Facebook</a>
                         </li>
                     <?php endif; ?>

                     <?php if(get_config('instagram_link')): ?>
                         <li>
                             <a href="https://instagram.com/<?php echo e(get_config('instagram_link')); ?>" target="_blank"
                                 rel="noopener">Instagram</a>
                         </li>
                     <?php endif; ?>

                     <?php if(get_config('youtube_link')): ?>
                         <li>
                             <a href="https://youtube.com/<?php echo e(get_config('youtube_link')); ?>" target="_blank"
                                 rel="noopener">Youtube</a>
                         </li>
                     <?php endif; ?>

                     <?php if(get_config('linkedin_link')): ?>
                         <li>
                             <a href="https://linkedin.com/company/<?php echo e(get_config('linkedin_link')); ?>" target="_blank"
                                 rel="noopener">LinkedIn</a>
                         </li>
                     <?php endif; ?>

                 </ul>
             </div>
         <?php endif; ?>
     </div>

     <?php if(get_theme_config('footer_section_copyright') == 'enabled'): ?>
         <section id="copyright">
             <div class="text-center">
                 <div class="copyright text-muted"><?php echo e(get_content_locale(get_config('site_copyright'))); ?></a>
                 </div>
             </div>
         </section>
     <?php endif; ?>
 </footer>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/layouts/partials/footer.blade.php ENDPATH**/ ?>