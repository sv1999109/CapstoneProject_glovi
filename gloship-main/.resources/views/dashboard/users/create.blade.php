@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    
    $branch = DB::table('branches')
        ->where('country', Session::get('country'))
        ->get();
    $role = Auth()->user()->role;
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card">
        <div class="card-header">
            <h3 class="card-title">
                @lang('messages.Add_User')
            </h3>

        </div>
        <hr class="divider">

        <form id="user_create_form" data-action="{{ route('dashboard.users.create') }}" class="form" method="post">
            @csrf
            @method('POST')
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label
                                class="form-label required @error('country') is-invalid @enderror">{{ trans_choice('messages.Country', 1) }}</label>
                            <select class="form-select form-search" id="sel_country2" name="country" required>
                                <option value="">@lang('messages.Select_Country')</option>
                                @foreach (DB::table('countries')->where('status', 1)->get() as $item)
                                    <option value="{{ __($item->id) }}" {{ old('country') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('country')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label
                                class="form-label optional @error('branch') is-invalid @enderror">{{ trans_choice('messages.Branch', 1) }}</label>
                            <select id="sel_branch" class="form-select form-search" name="branch">
                                <option value="">@lang('messages.Select_Branch')</option>
                                @foreach ($branch as $item)
                                    <option value="{{ __($item->id) }}" {{ old('branch') == $item->id ? 'selected' : '' }}>
                                        {{ $item->name }}
                                    </option>
                                @endforeach
                            </select>
                            @error('branch')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label required">@lang('messages.User_Type')</label>
                            <select required id="sel_role" name="role"
                                class="form-select form-search @error('role') is-invalid @enderror" required>
                                @can('do_staff')
                                    <option value="1">{{ trans_choice('messages.Customer', 1) }}</option>
                                    <option value="2">{{ trans_choice('messages.Delivery_Agent', 1) }}</option>
                                @endcan

                                @can('do_moderator')
                                    <option value="3">{{ trans_choice('messages.Staff', 1) }}</option>
                                @endcan

                                @can('do_admin')
                                    <option value="4">{{ trans_choice('messages.Moderator', 1) }}</option>
                                    <option value="5">@lang('messages.Admin')</option>
                                @endcan
                            </select>
                            @error('role')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="username" class="form-label required">@lang('messages.Username')</label>
                            <input type="text" name="username" value="{{ old('username', '') }}"
                                class="form-control @error('username') is-invalid @enderror" required>
                            @error('username')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="firstname" class="form-label required">@lang('messages.FirstName')</label>
                            <input type="text" name="firstname" value="{{ old('firstname', '') }}"
                                class="form-control @error('firstname') is-invalid @enderror" required>
                            @error('firstname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="lastname" class="form-label required">@lang('messages.LastName')</label>
                            <input type="text" name="lastname" value="{{ old('lastname', '') }}"
                                class="form-control @error('lastname') is-invalid @enderror" required>
                            @error('lastname')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="email" class="form-label required">@lang('messages.Email')</label>
                            <input type="text" name="email" value="{{ old('email', '') }}"
                                class="form-control @error('email') is-invalid @enderror" required>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="phone" class="form-label required">@lang('messages.Phone')</label>
                            <div>
                                <input id="telephone" type="tel" class="form-control" required>
                                <input type="hidden" name="phone" id="phone_number"
                                    value="">
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label for="password" class="form-label required">@lang('messages.Login_Password')</label>
                            <input type="text" name="password" value="{{ old('password', '') }}"
                                class="form-control @error('password') is-invalid @enderror" required>
                        </div>
                    </div>
                </div>
                <div class="col-md-12">
                    <h6>@lang('messages.User_Role_Permission')</h6>
                    @can('do_staff')
                        <div><b>{{ trans_choice('messages.Customer', 1) }}:</b> @lang('messages.User_Customer_Permission')
                        </div>
                        <div><b>{{ trans_choice('messages.Delivery_Agent', 1) }}:</b> @lang('messages.User_Agent_Permission')</div>
                    @endcan

                    @can('do_moderator')
                        <div><b>{{ trans_choice('messages.Staff', 1) }}:</b> @lang('messages.User_Staff_Permission') </div>
                    @endcan

                    @can('do_admin')
                        <div><b>{{ trans_choice('messages.Moderator', 1) }}:</b> @lang('messages.User_Moderator_Permission') </b>
                        </div>
                        <div><b>@lang('messages.Admin'):</b> @lang('messages.User_Admin_Permission') </div>
                    @endcan
                </div>
            </div>

            <div class="card-footer  d-flex justify-content-end py-6 px-9">
                <a href="{{ url()->previous() }}"
                    class="btn btn-light btn-active-light-primary me-2 text-uppercase">@lang('messages.Cancel')</a>
                <button type="submit" class="btn btn-success ml-1 text-uppercase">
                    <span class="add">@lang('messages.Add')</span>
                </button>
            </div>
        </form>
    </div>
@endsection
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
    <link rel="stylesheet"
        href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/intlTelInput/css/intlTelInput.css">
    <style>

        .iti {
            width: 100%;
        }
    </style>
@endpush
@push('scripts')
    <script src="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/intlTelInput/js/intlTelInput.js"></script>
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
            initialCountry: "{{ country_code(Auth()->user()->country) != '' ? country_code(Auth()->user()->country) : 'auto' }}",

            nationalMode: true,
            separateDialCode: true,
            utilsScript: "{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/intlTelInput/js/utils.js",
        });
        input.addEventListener('blur', function() {
            $('#phone_number').val(intl_telephone.getNumber());
        });
    </script>
    
    <script type='text/javascript'>
        //Countries, States, Cities, Areas form helper
        $(document).ready(function() {
            $('#sel_country2').select2();
            //Branches
            $('#sel_country2').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                $('#sel_branch').find('option').not(':first').remove()
                // AJAX request 
                $.ajax({
                    url: '{{ url('dashboard/address/getbranch') }}/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_branch').find('option').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var name = response['data'][i].name;

                            var option = "<option value='" + id + "'>" + name +
                                "</option>";

                            $("#sel_branch").append(option);
                        }
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            //start: save user data script
            $('#user_create_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                //show some response on the button
                $('button[type="submit"]', $form).each(function() {
                    $btn = $(this);
                    $btn.prop('type', 'button');
                    $btn.prop('orig_label', $btn.text());
                    $btn.prop('disabled', true);
                    $btn.html(
                        ' <span class="spinner-grow spinner-grow-md mr-05" role="status" aria-hidden="true"></span>'
                    );
                });

                var firstname = $('input[name="firstname"]').val();
                var lastname = $('input[name="lastname"]').val();
                var username = $('input[name="username"]').val();
                var password = $('input[name="password"]').val();
                var phone = $('input[name="phone"]').val();
                var country = $('select[name="country"]').val();
                var user_type = $('select[name="role"]').val();
                //validate input field
                if (firstname != '' && lastname != '' && username != '' && password != '' && user_type !=
                    '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.users.create') }}",
                        data: $form.serialize(),
                        success: create_data,
                        dataType: 'json',
                        error: function() {
                            Toastify({
                                text: "{{ __('messages.Unable_To_Process') }}",
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
                    });
                } else {
                    //some required fields are empty 
                    Toastify({
                        text: "{{ __('messages.Fill_Required_Field_First') }}",
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
            });
            //end: save user data script
        });
    </script>
@endpush
