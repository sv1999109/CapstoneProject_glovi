<?php if(Session::has('modal_open')): ?>
    <script>
        $(document).ready(function() {
            $("#<?php echo e(Session::get('modal_open')); ?>").modal('show');
            $(body).apend('<div class="modal-backdrop fade show"></div>');
        });
    </script>
<?php endif; ?>
<?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/modal.blade.php ENDPATH**/ ?>