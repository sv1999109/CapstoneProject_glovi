<!-- JAVASCRIPT -->
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>

<script src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/libs/bootstrap/js/bootstrap.bundle.min.js"></script>
<script src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/libs/simplebar/simplebar.min.js"></script>
<script src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/js/plugins.js"></script>


<!-- App js -->
<script src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/js/app.js"></script>
<script src="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/toastify/toastify.js"></script>

 {{-- JS Plugins --}}

 <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script
    src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/i18n/{{ LaravelLocalization::getCurrentLocale() }}.js">
</script>
<script type='text/javascript'>
   
    $(document).ready(function() {

        // load  notifications
        @if (get_config('site_notification') == 'enabled')
            setInterval(function() {
                $.ajax({
                    url: "{{ route('dashboard.users.notify') }}",
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        var notice_data = response;
                        if (notice_data.notice_count != '' && notice_data.notices != '') {
                            $('#notice_count').html(notice_data.notice_count);
                            $('#notices').html(notice_data.notices);
                            $('#no_notice').html('');

                            //success
                            Toastify({
                                text: '<span class="bi bi-bell"></span> {{ __('messages.New_Notification') }}',
                                duration: 10000,
                                close: true,
                                gravity: "top",
                                position: "right",
                                backgroundColor: "#4fbe87",
                            }).showToast();
                        }
                    }
                })
            }, 30000);
        @endif


        //Countries, States, Cities, Areas form helper
        $('#sel_country').select2(
            {
                width: "100%",
               
            }
        );
        $('#sel_state').select2(
            {
                width: "100%",
               
            }
        );
        $('#sel_city').select2(
            {
                width: "100%",
               
            }
        );
        $('#sel_area').select2(
            {
                width: "100%",
               
            }
        );
        $('#sel_branch').select2(
            {
                width: "100%",
            }
        );
        $('.form-search').select2(
            {
                width: "100%",
            }
        );

        //States
        $('#sel_country').change(function() {
            var id = $(this).val();
            // Empty the dropdown
            $('#sel_state').find('option').not(':first').remove();
            $('#sel_state').attr('disabled', true);
            $('#sel_city').find('option').not(':first').remove()
            // AJAX request 
            $.ajax({
                url: '{{ url('dashboard/address/getstates') }}/' + id,
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
                url: '{{ url('dashboard/address/getcity') }}/' + id,
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

        //Areas
        $('#sel_city').change(function() {
            var id = $(this).val();

            // Empty the dropdown
            $('#sel_area').find('option').not(':first').remove();
            $('#sel_area').attr('disabled', true);

            // AJAX request 
            $.ajax({
                url: '{{ url('dashboard/address/getarea') }}/' + id,
                type: 'get',
                dataType: 'json',
                success: function(response) {
                    $('#sel_area').find('option').not(':first').remove();
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

                            $("#sel_area").append(option);
                        }

                         //enable select after search is complete
                        $('#sel_area').attr('disabled', false);
                    }

                }
            });
        });

    });
</script>
<script>
    function json_locale(data) {

        var json_data = $.parseJSON(data);
        var locale = "{{ app()->getLocale() }}";
        return json_data[locale];
    }
</script>
