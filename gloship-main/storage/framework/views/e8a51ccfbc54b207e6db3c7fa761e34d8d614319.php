<?php $__env->startSection('content'); ?>

    <div class="auth-content">
        
        <h3 class="mb-1"><?php echo app('translator')->get('messages.Welcome_to'); ?>  <a href="<?php echo e(route('home')); ?>"><?php echo e(get_content_locale(get_config('site_name'))); ?></a>! 👋</h3>
        <p class="mb-4"><?php echo app('translator')->get('messages.Signup_To'); ?></p>
            <?php echo $__env->make('auth.layouts.partials.messages', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        
        
        <form method="post" action="<?php echo e(route('register.perform')); ?>" class="py-4">

            <input type="hidden" name="_token" value="<?php echo e(csrf_token()); ?>" />
            <div class="row g-3">

                <div class="col-12 xp-3">
                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" name="username" value="<?php echo e(old('username')); ?>" placeholder="<?php echo app('translator')->get('messages.Username'); ?>" required="required" autofocus>
                        <label for="floatingUsername"><?php echo app('translator')->get('messages.Username'); ?></label>
                        <?php if($errors->has('username')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('username')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="email" class="form-control" name="email" value="<?php echo e(old('email')); ?>" placeholder="name@example.com" required="required" autofocus>
                        <label for="floatingEmail"><?php echo app('translator')->get('messages.Email'); ?></label>
                        <?php if($errors->has('email')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('email')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="tel" id="telephone" class="form-control" value="<?php echo e(old('phone')); ?>" required="required" placeholder="<?php echo app('translator')->get('messages.Phone'); ?>">

                        <input type="hidden" id="phone_number" name="phone" value="<?php echo e(old('phone', '')); ?>">
                        <?php if($errors->has('phone')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('phone')); ?></span>
                        <?php endif; ?>
                    </div>
                    <div class="row mb-3">
                    <div class="col-md-6">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control" name="firstname" value="<?php echo e(old('firstname')); ?>" placeholder="<?php echo app('translator')->get('messages.FirstName'); ?>" required="required" autofocus>
                        <label for="floatingName"><?php echo app('translator')->get('messages.FirstName'); ?></label>
                        <?php if($errors->has('firstname')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('firstname')); ?></span>
                        <?php endif; ?>
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control" name="lastname" value="<?php echo e(old('lastname')); ?>" placeholder="<?php echo app('translator')->get('messages.LastName'); ?>" required="required" autofocus>
                        <label for="floatingName"><?php echo app('translator')->get('messages.LastName'); ?> </label>
                        <?php if($errors->has('lastname')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('lastname')); ?></span>
                        <?php endif; ?>
                    </div>
                    </div>
                    </div>
                    <div class="form-group form-floating mb-3">
                       
                        <select class="form-select form-search" id="sel_country" name="country">
                            <option value=""><?php echo app('translator')->get('messages.Select_Country'); ?></option>
                            <?php $__currentLoopData = DB::table('countries')->where('status', 1) ->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <option value="<?php echo e(__($item->id)); ?>"
                                    <?php echo e(old('country') == $item->id ? 'selected' : ''); ?>><?php echo e($item->name); ?>

                                </option>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </select>
                        <label
                        class="form-label required"><?php echo e(trans_choice('messages.Country', 1)); ?></label>
                        <?php $__errorArgs = ['country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback">
                                <?php echo e($message); ?>

                            </div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>
                   
                    <div class="form-group form-floating mb-3">
                        <input type="password" class="form-control" name="password" value="<?php echo e(old('password')); ?>" placeholder="Password" required="required">
                        <label for="floatingPassword"><?php echo app('translator')->get('messages.Password'); ?></label>
                        <?php if($errors->has('password')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('password')); ?></span>
                        <?php endif; ?>
                    </div>

                    <div class="form-group form-floating mb-3">
                        <input type="password" class="form-control" name="password_confirmation" value="<?php echo e(old('password_confirmation')); ?>" placeholder="<?php echo app('translator')->get('messages.Confirm_Password'); ?>" required="required">
                        <label for="floatingConfirmPassword"><?php echo app('translator')->get('messages.Confirm_Password'); ?></label>
                        <?php if($errors->has('password_confirmation')): ?>
                            <span class="text-danger text-left"><?php echo e($errors->first('password_confirmation')); ?></span>
                        <?php endif; ?>
                    </div>
                </div>
                

                <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" type="submit"><?php echo app('translator')->get('messages.Register'); ?></button>
                </div>
            </div>
        </form>
        

    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('content-actions'); ?>
    <p class="text-center">
        <?php echo app('translator')->get('messages.Already_Have_Account'); ?>
        <a href="<?php echo e(route('login')); ?>" class="font--bold">
            <?php echo app('translator')->get('messages.Login'); ?>
        </a>
    </p>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('css'); ?>
     <link rel="stylesheet"
        href="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/vendors/intlTelInput/css/intlTelInput.css">
    <style>
        .iti {
            width: 100%;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/vendors/intlTelInput/js/intlTelInput.js"></script>
    <script>
        // phone number
        var input = document.querySelector("#telephone");
        var intl_telephone = window.intlTelInput(input, {

            geoIpLookup: function(callback) {
                $.get("https://ipinfo.io", function() {}, "jsonp").always(function(resp) {
                    var countryCode = (resp && resp.country) ? resp.country : "";
                    callback(countryCode);
                });
            },
            initialCountry: "auto",

            nationalMode: true,
            separateDialCode: true,
            utilsScript: "<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/vendors/intlTelInput/js/utils.js",
        });
        input.addEventListener('blur', function() {
            $('#phone_number').val(intl_telephone.getNumber());
        });
    </script>
<?php $__env->stopPush(); ?>


<?php echo $__env->make('auth.layouts.app', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/auth/register.blade.php ENDPATH**/ ?>