<section class="calculate pt-100 bottom-b clrbg-before">
    <div class="theme-containerx container pyy-5">
        
        <div class="row">
            <div class="col-lg-6 text-center">
                <img src="<?php echo e(asset('assets/img/Courier-Man.png')); ?>" alt="" class="wow slideInLeft"
                    data-wow-offset="50" data-wow-delay=".20s" />
            </div>
            <div class="col-lg-6">
                <div class="pad-10"></div>
                <h2 class="section-title pb-10 wow fadeInUp" data-wow-offset="50" data-wow-delay=".20s"> <span
                        class="text-blue">calculate</span> your cost </h2>
                <p class="fs-16 wow fadeInUp" data-wow-offset="50" data-wow-delay=".25s"><?php echo app('translator')->get('messages.GET_A_QUOTE_Subtitle'); ?></p>
                <div class="calculate-form" id="package_info">
                    <form method="post" action="<?php echo e(route('shipping.rates')); ?>">
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="is_guest_rates" value="1">
                        <input type="hidden" value="<?php echo e(old('total_weight', 1.0)); ?>" class="total_weight"
                            name="total_weight" />
                        <input type="hidden" value="<?php echo e(old('total_qty', 1)); ?>" name="total_qty" />
                        <input type="hidden" name="service_provider" value="<?php echo e(get_config('api_provider')); ?>">
                        <div id="package_col" data-repeater-list="packages">
                            <div class="r-p" data-repeater-item>

                                <input placeholder="<?php echo app('translator')->get('messages.Description'); ?>" type="hidden"
                                    value="<?php echo e(old('package_description', 'Package')); ?>" name="package_description" />

                                <div class="form-group row wow fadeInUp mb-3" data-wow-offset="50"
                                    data-wow-delay=".20s">
                                    <div class="col-sm-3"> <label class="title-2"> <?php echo app('translator')->get('messages.Height_CM'); ?>: </label></div>
                                    <div class="col-sm-9"> <input type="number" name="height" placeholder=""
                                            min="1" value="<?php echo e(old('height', '')); ?>" required
                                            class="form-control"> </div>
                                </div>

                                <div class="form-group row wow fadeInUp mb-3" data-wow-offset="50"
                                    data-wow-delay=".20s">
                                    <div class="col-sm-3"> <label class="title-2"> <?php echo app('translator')->get('messages.Width_CM'); ?>: </label></div>
                                    <div class="col-sm-9"> <input type="number" name="width" placeholder=""
                                            min="1" value="<?php echo e(old('width', '')); ?>" required class="form-control">
                                    </div>
                                </div>
                                <div class="form-group row wow fadeInUp mb-3" data-wow-offset="50"
                                    data-wow-delay=".20s">
                                    <div class="col-sm-3"> <label class="title-2"> <?php echo app('translator')->get('messages.Length_CM'); ?>: </label></div>
                                    <div class="col-sm-9"> <input type="number" name="length" placeholder=""
                                            min="1" value="<?php echo e(old('length', '')); ?>" required
                                            class="form-control"> </div>
                                </div>

                                <div class="form-group row wow fadeInUp mb-3" data-wow-offset="50"
                                    data-wow-delay=".20s">
                                    <div class="col-sm-3"> <label class="title-2"> <?php echo app('translator')->get('messages.Weight_Kg'); ?>: </label></div>
                                    <div class="col-sm-9"> <input type="number" name="weight" placeholder=""
                                            min="1" value="<?php echo e(old('weight', '')); ?>"
                                            onchange="Calculate_Total_Weight()" required class="form-control weights">
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="pickup" class="mt-5">
                            <div class="form-group row wow fadeInUp mb-2" data-wow-offset="50" data-wow-delay=".20s">
                                <div class="col-sm-3"> <label class="title-2">
                                        <?php echo e(trans_choice('messages.Pickup', 1)); ?>

                                        <?php echo e(trans_choice('messages.Location', 1)); ?> : </label></div>
                                <div class="col-sm-9 d-flex">
                                    <div class="col-6 col-md-6 no-pad">
                                        <select
                                            class="form-select form-control from fw-600 <?php $__errorArgs = ['pickup_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="sel_country" name="pickup_country" required>
                                            <option value=""><?php echo e(trans_choice('messages.From', 1)); ?></option>
                                            <?php $__currentLoopData = DB::table('countries')->where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>">
                                                    <?php echo e($item->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-6 no-pad">

                                        <select id="sel_state" name="pickup_state"
                                            class="form-select form-control to fw-600 <?php $__errorArgs = ['pickup_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            required>
                                        </select>

                                    </div>
                                </div>
                            </div>
                            <div class="form-group row wow fadeInUp mb-2" data-wow-offset="50" data-wow-delay=".20s">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 d-flex">

                                    <div class="col-12">
                                        <select id="sel_city" name="pickup_city"
                                            class="form-select form-control  fw-600 <?php $__errorArgs = ['pickup_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            required>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row wow fadeInUp mb-2x" data-wow-offset="50" data-wow-delay=".20s">
                                <div class="col-sm-3"> <label class="title-2"> </label></div>
                                <div class="col-sm-9 d-flex">

                                    <div class="col-sm-6 no-pad">
                                        <input type="text" name="pickup_address" class="form-control from fw-600"
                                            placeholder="<?php echo e(trans_choice('messages.Address', 1)); ?>" required>
                                    </div>
                                    <div class="col-sm-6 no-pad">

                                        <input type="text" name="pickup_postal" class="form-control to fw-600"
                                            placeholder="<?php echo app('translator')->get('messages.Postal'); ?>" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div id="destination" class="mt-5">
                            <div class="form-group row wow fadeInUp mb-2" data-wow-offset="50" data-wow-delay=".20s">
                                <div class="col-sm-3"> <label class="title-2">
                                        <?php echo e(trans_choice('messages.Destination', 1)); ?>

                                        : </label></div>
                                <div class="col-sm-9 d-flex">

                                    <div class="col-6 col-md-6 no-pad">
                                        <select
                                            class="form-select form-control from fw-600 <?php $__errorArgs = ['destination_country'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            id="sel_country2" name="destination_country" required>
                                            <option value=""><?php echo e(trans_choice('messages.To', 1)); ?></option>
                                            <?php $__currentLoopData = DB::table('countries')->where('status', 1)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $item): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                <option value="<?php echo e($item->id); ?>">
                                                    <?php echo e($item->name); ?>

                                                </option>
                                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        </select>
                                    </div>
                                    <div class="col-6 col-md-6 no-pad">

                                        <select id="sel_state2" name="destination_state"
                                            class="form-select form-control to fw-600 <?php $__errorArgs = ['destination_state'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            required>
                                        </select>

                                    </div>

                                </div>

                            </div>
                            <div class="form-group row wow fadeInUp mb-2" data-wow-offset="50" data-wow-delay=".20s">
                                <div class="col-sm-3"></div>
                                <div class="col-sm-9 d-flex">

                                    <div class="col-12">
                                        <select id="sel_city2" name="destination_city"
                                            class="form-select form-control  fw-600 <?php $__errorArgs = ['destination_city'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>"
                                            required>
                                        </select>
                                    </div>

                                </div>
                            </div>
                            <div class="form-group row wow fadeInUp mb-3" data-wow-offset="50" data-wow-delay=".20s">
                                <div class="col-sm-3"> <label class="title-2"> </label></div>
                                <div class="col-sm-9 d-flex">

                                    <div class="col-sm-6 no-pad">
                                        <input type="text" name="destination_address"
                                            class="form-control from fw-600"
                                            placeholder="<?php echo e(trans_choice('messages.Address', 1)); ?>" required>
                                    </div>
                                    <div class="col-sm-6 no-pad">

                                        <input type="text" name="destination_postal"
                                            class="form-control to fw-600" placeholder="<?php echo app('translator')->get('messages.Postal'); ?>" required>

                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="form-group text-center text-lg-end mt-3 mb-5 row" data-wow-offset="50"
                            data-wow-delay=".20s">
                            <div class="col-12">
                                <button class="btn btn-blue btn-block w-50"><span class="bi bi-search me-2"></span>
                                    <?php echo e(trans_choice('messages.Get_Quote', 1)); ?></button>
                            </div>
                        </div>
                    </form>
                </div>
                <div class="pt-80 hidden-lg"></div>
            </div>
        </div>
    </div>
</section>
<?php $__env->startPush('css'); ?>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <style>
        .select2.select2-container .select2-selection {
            width: 100% !important;
            padding: 5px;
            height: 46px !important;
            border: 1px solid #dce7f1;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .pb-10 {
            padding-bottom: 10px;
        }
    </style>
<?php $__env->stopPush(); ?>
<?php $__env->startPush('scripts'); ?>
    
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
        integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type='text/javascript'>
        //Countries, States, Cities, Areas form helper
        $(document).ready(function() {

            //Countries, States, Cities, Areas form helper
            $('#sel_country').select2();
            $('#sel_state').select2();
            $('#sel_city').select2();
            $('#sel_area').select2();
            $('#sel_branch').select2();
            $('.form-search').select2();

            //States
            $('#sel_country').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                $('#sel_state').find('option').remove();
                $('#sel_state').attr('disabled', true);
                $('#sel_city').find('option').not(':first').remove()
                // AJAX request 
                $.ajax({
                    url: '<?php echo e(url('address/getstates')); ?>/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_state').find('option').not(':first').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name +
                                    "</option>";

                                $("#sel_state").append(option);
                            }
                            //enable select after search is complete
                            $('#sel_state').attr('disabled', false);
                        }

                    }
                });
            });

            // Cities
            $('#sel_state').change(function() {


                var id = $(this).val();

                // Empty the dropdown
                $('#sel_city').find('option').not(':first').remove()
                $('#sel_city').attr('disabled', true);

                // AJAX request 
                $.ajax({
                    url: '<?php echo e(url('address/getcity')); ?>/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_city').find('option').not(':first').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name +
                                    "</option>";

                                $("#sel_city").append(option);
                            }
                            //enable select after search is complete
                            $('#sel_city').attr('disabled', false);
                        }

                    }
                });
            });
            $('#sel_country2').select2();
            $('#sel_state2').select2();
            $('#sel_city2').select2();


            // fetch states
            $('#sel_country2').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                $('#sel_state2').find('option').not(':first').remove();
                $('#sel_state2').attr('disabled', true);
                $('#sel_city2').find('option').not(':first').remove();
                // AJAX request 
                $.ajax({
                    url: '<?php echo e(url('address/getstates')); ?>/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_state2').find('option').not(':first').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name +
                                    "</option>";

                                $("#sel_state2").append(option);
                            }

                            $('#sel_state2').attr('disabled', false);
                        }

                    }
                });
            });

            // fetch cities
            $('#sel_state2').change(function() {


                var id = $(this).val();

                // Empty the dropdown
                $('#sel_city2').find('option').not(':first').remove();
                $('#sel_city2').attr('disabled', true);

                // AJAX request 
                $.ajax({
                    url: '<?php echo e(url('address/getcity')); ?>/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_city2').find('option').not(':first').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }

                        if (len > 0) {
                            // Read data and create <option >
                            for (var i = 0; i < len; i++) {

                                var id = response['data'][i].id;
                                var name = response['data'][i].name;

                                var option = "<option value='" + id + "'>" + name +
                                    "</option>";

                                $("#sel_city2").append(option);
                            }

                            $('#sel_city2').attr('disabled', false);
                        }

                    }
                });
            });


        });
    </script>
    <script type='text/javascript' id="custom-js">
        $(document).ready(function() {

            //package form Repeater

            $('#package_info').repeater({
                initEmpty: false,


                show: function() {
                    $(this).slideDown();
                    Calculate_Total_Weight();
                    Calculate_Total_Qty();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                isFirstItemUndeletable: true
            });
        });

        function Calculate_Total_Weight() {
            //get element class
            var element_class = $('.weights');
            //set weight to 0
            var sum_weight = 0;
            //map elements
            element_class.map(function() {
                //sum all the .weight values
                sum_weight += parseFloat($(this).val());
            }).get();

            //update total weight value
            $('.total_weight').val(sum_weight);
            $('.total_weight_element').html(sum_weight);
        }

        function Calculate_Total_Qty() {
            //get element class
            var element_class = $('.qty');
            //set weight to 0
            var sum_qty = 0;
            //map elements
            element_class.map(function() {
                //sum all the .weight values
                sum_qty += parseFloat($(this).val());
            }).get();

            //update total weight value
            $('.total_qty').val(sum_qty);
        }
    </script>
<?php $__env->stopPush(); ?>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/themes/greenship/home/sections/quote.blade.php ENDPATH**/ ?>