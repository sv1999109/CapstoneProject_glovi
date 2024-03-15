@php
    //default form settings
    $firstname = Auth()->user()->firstname;
    $lastname = Auth()->user()->lastname;
    $phone = Auth()->user()->phone;
    $email = Auth()->user()->email;
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    
    $role = Auth()->user()->role;
    $user_id = Auth()->user()->id;
    //staffs
    if ($role >= 1) {
        $clients = DB::table('users')
            ->where('role', 1)
            ->orderBy('firstname', 'asc')
            ->get();
       
    }
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @lang('messages.Add_Address')
                    </h3>
                </div>
                <hr class="divider">
                <form id="address_create_form" data-action="{{ route('dashboard.address.create') }}" class="form" method="post">

                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="row">
                            @if (isset($user))
                                <div class="col-md-6">

                                    <div class="form-group mb-3">
                                        <label class="form-label required">{{ trans_choice('messages.Customer', 1) }}</label>

                                        <select readonly class="form-select" id="client" name="client">
                                        </select>
                                        @error('client')
                                            <div class="invalid-feedback">
                                                {{ $message }}
                                            </div>
                                        @enderror
                                    </div>
                                </div>
                            @else
                                @if ($role > 1)
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label required">{{ trans_choice('messages.Customer', 1) }}</label>

                                            <select class="form-select form-search" id="sel_client" name="client" required>
                                                <option value="">@lang('messages.Select')</option>

                                            </select>
                                            @error('client')
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror
                                        </div>
                                    </div>
                                @endif
                            @endif
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label
                                        class="form-label required">@lang('messages.Address_Type')</label>

                                    <select class="form-control" id="address_type" name="address_type">
                                        <option value="1" {{ old('address_type') == 1 ? 'selected' : '' }}>
                                            @lang('messages.Sender')</option>
                                        <option value="2" {{ old('address_type') == 2 ? 'selected' : '' }}>
                                            @lang('messages.Recipient')</option>

                                    </select>
                                    @error('address_type')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <hr>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>

                                    <select class="form-control" id="sel_country" name="country" required>
                                        <option value="">@lang('messages.Select_Country')</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ $item->id }}">{{ $item->name }}
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
                                    <label class="form-label required">@lang('messages.State_Province')</label>
                                    <select id="sel_state" name="state"
                                        class="form-select @error('state') is-invalid @enderror" required>
                                        <option value="">@lang('messages.Select_State')</option>

                                    </select>
                                    @error('state')
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
                                    <label class="form-label optional">@lang('messages.City_Region')</label>
                                    <select id="sel_city" name="city"
                                        class="form-select @error('city') is-invalid @enderror">
                                        <option value="">@lang('messages.Select_City')</option>
                                    </select>
                                    @error('city')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label optional">{{ trans_choice('messages.Area', 1) }}</label>
                                    <select id="sel_area" name="area"
                                        class="form-select @error('area') is-invalid @enderror">
                                        <option value="">@lang('messages.Select_Area')</option>
                                    </select>
                                    @error('area')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="divider">
                        <div class="form-group mb-3">
                            <label for="address" class="form-label required">@lang('messages.Delivery_Address')</label>
                            <input type="text" name="address" value="{{ old('address', '') }}"
                                class="form-control @error('address') is-invalid @enderror" required>
                            @error('address')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="firstname" class="form-label required">@lang('messages.FirstName')</label>
                                    <input type="text" name="firstname" value="{{ old('firstname', $firstname) }}"
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
                                    <input type="text" name="lastname" value="{{ old('lastname', $lastname) }}"
                                        class="form-control @error('lastname') is-invalid @enderror" required>
                                    @error('lastname')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label required">@lang('messages.Phone')</label>
                                        <div>
                                            <input id="telephone" type="tel" class="form-control" value="{{ old('phone', $phone) }}" required>
                                            <input type="hidden" value="{{ old('phone', $phone) }}" name="phone" id="phone_number"
                                                value="">
                                        </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label required">@lang('messages.Email')</label>
                                    <input type="text" name="email" value="{{ old('email', $email) }}"
                                        class="form-control @error('email') is-invalid @enderror" required>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="postal" class="form-label required">@lang('messages.Postal')</label>
                                    <input type="text" name="postal" value="{{ old('postal', '') }}"
                                        class="form-control @error('postal') is-invalid @enderror" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer  d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('dashboard.address') }}"
                            class="btn btn-light btn-active-light-primary me-2 text-uppercase">@lang('messages.Cancel')</a>
                        <button type="submit" class="btn btn-success ml-1 text-uppercase">
                            <span class="add">@lang('messages.Add')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('css')
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
        //select form helper
        $(document).ready(function() {

            $("#sel_client").select2({
                language: '{{LaravelLocalization::getCurrentLocale()}}',
                ajax: {
                    url: "{{ route('dashboard.users.search') }}",
                    dataType: 'json',
                    delay: 250,
                    data: function(params) {
                        var query = {
                            q: params.term,
                            //type: 'public'
                        }
                        return query;
                    },

                    processResults: function(data) {
                        return {
                            results: $.map(data, function(item) {
                                return {
                                    text: item.firstname + ' ' + item.lastname +' - ' + item.username,
                                    id: item.id
                                }
                            })
                        };
                    },
                    cache: true
                },
                minimumInputLength: 3,
                allowClear: true
            }).on('change', function(e) {
                //
            });
        });
    </script>
    <script>
        $(document).ready(function() {

            //start: create data script
            $('#address_create_form').submit(function(e) {
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
                var address = $('input[name="address"]').val();
                var address_type = $('input[name="address_type"]').val();
                var phone = $('input[name="phone"]').val();
                var country = $('select[name="country"]').val();
                var state = $('select[name="state"]').val();
                //validate input field
                if (firstname != '' && lastname != '' && address != '' && phone != '' && country !=
                    '' && state != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.address.create') }}",
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
            //end: create data script
        });
    </script>
@endpush
