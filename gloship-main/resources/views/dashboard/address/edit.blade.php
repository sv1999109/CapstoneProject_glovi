@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->distinct()
        ->get();
    $states = DB::table('states')
        ->where('country_id', $address->country)
        ->distinct()
        ->get();
    $cities = DB::table('cities')
        ->where('state_id', $address->state)
        ->distinct()
        ->get();
    $areas = DB::table('areas')
        ->where('city_id', $address->city)
        ->distinct()
        ->get();
    
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        @lang('messages.Edit') {{ trans_choice('messages.Address', 1) }} : {{ $address->address }}
                    </h3>

                </div>
                <hr class="divider">

                <form id="address_save_form" action="{{ route('dashboard.address.update', ['id' => $address->id]) }}"
                    class="form" method="post">

                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label required">{{ trans_choice('messages.Customer', 1) }}</label>

                                    <select disabled class="form-control" id="client" name="client">
                                        <option value="{{ $address->owner_id }}">
                                            {{ get_user('firstname', $address->owner_id) }}
                                            {{ get_user('lastname', $address->owner_id) }}
                                            ({{ get_user('username', $address->owner_id) }})</option>

                                    </select>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label
                                        class="form-label @error('address_type') is-invalid @enderror">@lang('messages.Address_Type')</label>

                                    <select class="form-control" id="address_type" name="address_type">
                                        <option value="1" {{ old('address_type') == 1 ? 'selected' : '' }}
                                            @if ($address->address_type == 1) selected @endif>@lang('messages.Sender')</option>
                                        <option value="2" {{ old('address_type') == 2 ? 'selected' : '' }}
                                            @if ($address->address_type == 2) selected @endif>@lang('messages.Recipient')</option>

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
                                    <select class="form-select form-search" id="sel_country" name="country">

                                        @foreach ($countries as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('country') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $address->country) selected @endif>
                                                {{ country_name($item->id) }}</option>
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
                                        @foreach ($states as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('state') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $address->state) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
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
                                        @foreach ($cities as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('city') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $address->city) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
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
                                    <select id="sel_area" name="area" class="form-select optional">
                                        <option value="">@lang('messages.Select_Area')</option>
                                        @foreach ($areas as $item)
                                            <option value="{{ get_data_db('areas', 'name', $item->name, 'id') }}"
                                                {{ old('area') == $item->name ? 'selected' : '' }}
                                                @if ($item->name == get_data_db('areas', 'id', $address->area, 'name')) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
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

                            <div class="row">
                                <div class="col-md-6">
                                    <input placeholder="Enter house or apartment no" type="text" name="house_no" value="{{ old('house_no', isset($address) ? $address->house_no : '') }}"
                                        class="form-control @error('house_no') is-invalid @enderror" required>
                                    @error('house_no')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input placeholder="Enter street address" type="text" name="address" value="{{ old('address', isset($address) ? $address->address : '') }}"
                                        class="form-control @error('address') is-invalid @enderror" required>
                                    @error('address')
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
                                    <input type="text" name="firstname"
                                        value="{{ old('firstname', isset($address) ? $address->firstname : '') }}"
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
                                    <input type="text" name="lastname"
                                        value="{{ old('lastname', isset($address) ? $address->lastname : '') }}"
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
                                    <label for="phone" class="form-label required">@lang('messages.Phone')</label>
                                    <div>
                                        <input id="telephone" type="tel"
                                            value="{{ $address->phone }}"
                                            class="form-control" required>
                                        <input type="hidden" name="phone" id="phone_number"
                                            value="{{ $address->phone }}">
                                    </div>

                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label required">@lang('messages.Email')</label>
                                    <input type="email" name="email"
                                        value="{{ old('email', isset($address) ? $address->email : '') }}"
                                        class="form-control @error('email') is-invalid @enderror" required>

                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label required">@lang('messages.Postal')</label>
                                    <input type="text" name="postal"
                                        value="{{ old('postal', isset($address) ? $address->postal : '') }}"
                                        class="form-control @error('postal') is-invalid @enderror">

                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer  d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('dashboard.address') }}"
                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Back')</a>

                        <button type="submit" class="btn btn-success ml-1">

                            <span class="add">@lang('messages.Save')</span>
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
            initialCountry: "{{ country_code($address->country) != '' ? country_code($address->country) : 'auto' }}",

            nationalMode: true,
            separateDialCode: true,
            utilsScript: "{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/intlTelInput/js/utils.js",
        });
        input.addEventListener('blur', function() {
            $('#phone_number').val(intl_telephone.getNumber());
        });
    </script>
    <script>
        $(document).ready(function() {

            //start: save data script
            $('#address_save_form').submit(function(e) {
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
                    '' && state !=
                    '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.address.update', ['id' => $address->id]) }}",
                        data: $form.serialize(),
                        success: save_data,
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
            //end: save data script
        });
    </script>
@endpush
