<?php if(Session::has('error')): ?>
    <script>
        Toastify({
            text: '<span class="fa fa-times-circle"></span> ' + "<?php echo e(Session::get('error')); ?>",
            duration: 10000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "red",
        }).showToast();
    </script>
<?php endif; ?>

<?php if(Session::has('errors')): ?>
    <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $message): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
        <script>
            Toastify({
                text: '<span class="fa fa-times-circle"></span> ' + "<?php echo e($message); ?>",
                duration: 10000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "red",
            }).showToast();
        </script>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
<?php endif; ?>

<script>
    /**
     * Save new data.
     * 
     * @param data
     * @return data
     */
    function save_data(data) {

        if (data.result == 'success') {

            //success
            Toastify({
                text: '<span class="fa fa-check-circle"></span> ' + data.messages,
                duration: 10000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "#4fbe87",
            }).showToast();

            //reverse the response on the button
            $('button[type="button"]', $form).each(function() {
                $btn = $(this);
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            });

        } else if (data.result == 'errors') {

            $.each(data.messages, function(i, item) {
                Toastify({
                    text: '<span class="fa fa-times-circle"></span> ' + data.messages[i],
                    duration: 10000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "red",
                }).showToast();
            });

            //reverse the response on the button
            $('button[type="button"]', $form).each(function() {
                $btn = $(this);
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            });
        } else {

            Toastify({
                text: data.messages,
                duration: 10000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "red",
            }).showToast();

            //reverse the response on the button
            $('button[type="button"]', $form).each(function() {
                $btn = $(this);
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            });
        }

    }

    /**
     * create new data.
     * 
     * @param data
     * @return data
     */
    function create_data(data) {

        if (data.result == 'success') {

            //success
            //redirect page
            $(location).attr('href', data.redirect_url);

            //reverse the response on the button
            $('button[type="button"]', $form).each(function() {
                $btn = $(this);
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            });

        } else if (data.result == 'errors') {

            $.each(data.messages, function(i, item) {
                Toastify({
                    text: data.messages[i],
                    duration: 10000,
                    close: true,
                    gravity: "top",
                    position: "center",
                    backgroundColor: "red",
                }).showToast();
            });

            //reverse the response on the button
            $('button[type="button"]', $form).each(function() {
                $btn = $(this);
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            });
        } else {

            Toastify({
                text: data.messages,
                duration: 10000,
                close: true,
                gravity: "top",
                position: "center",
                backgroundColor: "red",
            }).showToast();

            //reverse the response on the button
            $('button[type="button"]', $form).each(function() {
                $btn = $(this);
                label = $btn.prop('orig_label');
                if (label) {
                    $btn.prop('type', 'submit');
                    $btn.text(label);
                    $btn.prop('orig_label', '');
                    $btn.prop('disabled', false);
                }
            });
        }

    }

    /**
     * Error data.
     * 
     * @param data
     * @return data
     */
    function error_data(data) {

        Toastify({
            text: "<?php echo e(__('messages.Unable_To_Process')); ?>",
            duration: 10000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "red",
        }).showToast();
        //reverse the response on the button
        $('button[type="button"]', $form).each(function() {
            $btn = $(this);
            label = $btn.prop('orig_label');
            if (label) {
                $btn.prop('type', 'submit');
                $btn.text(label);
                $btn.prop('orig_label', '');
                $btn.prop('disabled', false);
            }
        });
    }
</script>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/toast.blade.php ENDPATH**/ ?>