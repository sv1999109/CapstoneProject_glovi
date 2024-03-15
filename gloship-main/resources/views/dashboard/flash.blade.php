@if (Session::has('form_response'))
    <script>
        Toastify({
            text: '<span class="fa fa-check-circle"></span> '+  "{{ Session::get('form_response') }}",
            duration: 10000,
            close: true,
            gravity: "top",
            position: "center",
            backgroundColor: "#4fbe87",
        }).showToast();
    </script>
@endif
