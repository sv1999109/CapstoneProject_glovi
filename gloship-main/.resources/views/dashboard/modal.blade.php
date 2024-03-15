@if (Session::has('modal_open'))
    <script>
        $(document).ready(function() {
            $("#{{ Session::get('modal_open') }}").modal('show');
            $(body).apend('<div class="modal-backdrop fade show"></div>');
        });
    </script>
@endif
