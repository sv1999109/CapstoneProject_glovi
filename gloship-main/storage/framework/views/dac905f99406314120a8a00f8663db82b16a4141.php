<?php $__env->startSection('content'); ?>
    <div>
        
        <h3 class="mb-1"><?php echo app('translator')->get('messages.Welcome_to'); ?>  <a href="<?php echo e(route('home')); ?>"><?php echo e(get_content_locale(get_config('site_name'))); ?></a>! 👋</h3>
        <p class="mb-4"><?php echo app('translator')->get('messages.Sign_To'); ?></p>
        <?php echo $__env->make('auth.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

        
        <?php if(Session::has('message')): ?>
            <div class="alert alert-success" role="alert">
                <?php echo e(Session::get('message')); ?>

            </div>
        <?php endif; ?>

        
        <form method="post" action="<?php echo e(route('login.perform')); ?>">
            
            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />

            
            <div class="form-group  mb-4">
                <input id="username" name="username" value="<?php echo e(old('username')); ?>" type="text" class="form-control"
                    placeholder="<?php echo app('translator')->get('messages.Username'); ?>" required>

            </div>
            
           
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  <a href="<?php echo e(route('forget.password.get')); ?>"><small><?php echo app('translator')->get('messages.Password_Forgot'); ?></small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                    <input id="password" name="password" type="password" class="form-control" placeholder="<?php echo app('translator')->get('messages.Password'); ?>">
                </div>
            </div>
            

            <div class="mb-3">
                <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" name="remember" value="true" id="remember_me">
                    <label class="form-check-label " for="remember_me">
                        <?php echo app('translator')->get('messages.Keep_Me_Logged'); ?>
                    </label>
                </div>
            </div>
            
            <button type="submit" class="btn btn-primary d-grid w-100"><?php echo app('translator')->get('messages.Login'); ?></button>
        </form>
        

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-actions'); ?>
    <p class="text-center mt-3">
        <?php echo app('translator')->get('messages.Dont_Have_An_Account'); ?>
        <a href="<?php echo e(route('register')); ?>" class="font--bold">
            <?php echo app('translator')->get('messages.Register'); ?>
        </a>
    </p>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('auth.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/auth/login.blade.php ENDPATH**/ ?>