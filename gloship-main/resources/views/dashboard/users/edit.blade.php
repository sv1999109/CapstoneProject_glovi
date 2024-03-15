@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    
    $branch = DB::table('branches')
        ->where('country', $user->country)
        ->get();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div id="profile" class="profile">
        <div class="row mt-4">
            <div class="col-md-3 mb-2 mb-md-0">
                {{-- Navtabs --}}
                <h6>{{ $user->firstname }} {{ trans_choice('messages.Profile', 1) }} </h6>
                <ul class="nav nav-pills flex-column nav-left">
                    <li class="nav-item" role="presentation">

                        <a class="nav-link active" id="pill-details" data-bs-toggle="pill" href="#details"
                            aria-controls="settings-details-tab" aria-labelledby="settings-details-tab" role="tab"
                            aria-expanded="true">
                            <i class="fa fa-info-circle font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('messages.Details') }}</span>
                        </a>

                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pill-alerts" data-bs-toggle="pill" href="#alerts" aria-expanded="false">
                            <i class="fa fa-bell font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('messages.Alert_Notifications') }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pill-password" data-bs-toggle="pill" href="#password" aria-expanded="false">
                            <i class="fa fa-lock font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('messages.Password') }}</span>
                        </a>
                    </li>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link" id="pill-avatar" data-bs-toggle="pill" href="#avatar" aria-expanded="false">
                            <i class="fa fa-user font-medium-3 mr-1"></i>
                            <span class="font-weight-bold">{{ __('messages.Avatar') }}</span>
                        </a>
                    </li>

                </ul>
                {{-- // Navtabs --}}
            </div>
            <div class="col-md-9">
                <div class="form-body-section">
                    <div class="tab-content" id="setting-pill-profile">

                        {{-- Details Panel --}}
                        <div role="tabpanel" class="tab-pane fade show active" id="details"
                            aria-labelledby="settings-details-tab">
                            <form id="user_detail_form"
                                data-action="{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'details']) }}"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="card-header mb-3">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">{{ __('messages.Update') }} {{ __('messages.Details') }}
                                        </h3>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="userid" class="form-label">@lang('messages.ID')</label>
                                                    <input type="text" name="userid" value="{{ $user->id }}"
                                                        class="form-control @error('userid') is-invalid @enderror" disabled>
                                                    @error('userid')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="username" class="form-label">@lang('messages.Username')</label>
                                                    <input type="text" name="username" value="{{ $user->username }}"
                                                        class="form-control @error('username') is-invalid @enderror"
                                                        @if (Auth()->user()->role > 3) @else
                                                        disabled @endif>
                                                    @error('username')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                           
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="firstname" class="form-label">@lang('messages.FirstName')</label>
                                                    <input type="text" name="firstname"
                                                        value="{{ old('firstname', isset($user) ? $user->firstname : '') }}"
                                                        class="form-control @error('firstname') is-invalid @enderror"
                                                        required>
                                                    @error('firstname')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="lastname" class="form-label">@lang('messages.LastName')</label>
                                                    <input type="text" name="lastname"
                                                        value="{{ old('lastname', isset($user) ? $user->lastname : '') }}"
                                                        class="form-control @error('lastname') is-invalid @enderror"
                                                        required>
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
                                                    <label for="email" class="form-label">@lang('messages.Email')</label>
                                                    <input type="text" name="email"
                                                        value="{{ old('email', isset($user) ? $user->email : '') }}"
                                                        class="form-control @error('email') is-invalid @enderror"
                                                        @if (Auth()->user()->role > 3) @else
                                                        disabled @endif>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="phone"
                                                        class="form-label mb-1">@lang('messages.Phone')</label>
                                                    <div>
                                                        <input id="telephone" type="tel"
                                                            value="{{ old('phone', isset($user) ? $user->phone : '') }}"
                                                            class="form-control" required>
                                                        <input type="hidden" name="phone" id="phone_number"
                                                            value="{{ old('phone', isset($user) ? $user->phone : '') }}">
                                                    </div>
                                                </div>
                                            </div>
                                          
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="timezone" class="form-label">@lang('messages.Timezone')</label>
                                                    <select class="form-control form-search" name="timezone"
                                                        id="timezone">
                                                        @foreach (Helpers::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                                                            <option value="{{ $timezone }}"
                                                                {{ $timezone === old('timezone', $user->timezone) ? 'selected' : '' }}>
                                                                {{ $timezone_gmt_diff }}
                                                            </option>
                                                        @endforeach
                                                    </select>
                                                    @error('timezone')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror

                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="username"
                                                        class="form-label">{{ trans_choice('messages.Country', 1) }}</label>
                                                    <select class="form-select form-search" id="sel_country"
                                                        name="country"
                                                        @if (Auth()->user()->role > 3) @else
                                                        disabled @endif>

                                                        @foreach ($countries as $item)
                                                            <option value="{{ __($item->id) }}"
                                                                {{ old('country') == $item->id ? 'selected' : '' }}
                                                                @if ($item->id == $user->country) selected @endif>
                                                                {{ $item->name }}</option>
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
                                                <div class="form-group">
                                                    <label class="orm-label">{{ __('messages.Default_Language') }}</label>
                                                    <select name="language" class="form-control form-search">
                                                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                                            <option value="{{ $localeCode }}"
                                                                @if ($user->language == $localeCode) selected @endif>
                                                                {{ $properties['native'] }}</option>
                                                        @endforeach
                                                    </select>

                                                    @error('language')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <label for="currency"
                                                        class="form-label">{{ trans_choice('messages.Currency', 1) }}</label>
                                                    <input type="text" name="currency" value="{{ $user->currency }}"
                                                        class="form-control @error('currency') is-invalid @enderror"
                                                        disabled>
                                                    @error('currency')
                                                        <div class="invalid-feedback">
                                                            {{ $message }}
                                                        </div>
                                                    @enderror
                                                </div>
                                            </div>
                                            @can('do_moderator')
                                                <div class="col-md-6">
                                                    <div class="form-group mb-3">
                                                        <label
                                                            class="form-label optional @error('branch') is-invalid @enderror">{{ trans_choice('messages.Branch', 1) }}</label>
                                                        <select id="sel_branch" class="form-select form-search"
                                                            name="branch">
                                                            <option value="">@lang('messages.Select_Branch')</option>
                                                            @foreach ($branch as $item)
                                                                <option value="{{ __($item->id) }}"
                                                                    {{ $user->branch == $item->id ? 'selected' : '' }}>
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
                                                        <label for="status" class="form-label">@lang('messages.Status')</label>
                                                        <select name="status" class="form-select form-search">
                                                            <option value="1" {{ $user->status == 1 ? 'selected' : '' }}>
                                                                {{ get_status('users', '1') }}</option>
                                                            <option value="2" {{ $user->status == 2 ? 'selected' : '' }}>
                                                                {{ get_status('users', '2') }}</option>

                                                        </select>
                                                        @error('status')
                                                            <div class="invalid-feedback">
                                                                {{ $message }}
                                                            </div>
                                                        @enderror
                                                    </div>
                                                </div>
                                            @endcan
                                        </div>
                                    </div>
                                    {{-- Submit  --}}
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <a href="{{ url()->previous() }}"
                                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>
                                        <button type="submit" class="btn btn-success"
                                            id="save_user_detail_btn">@lang('messages.Save_Change')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- // Details --}}

                        {{-- Notifications Panel --}}
                        <div role="tabpanel" class="tab-pane fade" id="alerts" aria-labelledby="settings-alerts-tab">
                            <form action="{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'notice']) }}"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="card-header mb-3">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">{{ __('messages.Update') }}
                                            {{ __('messages.Alert_Notifications') }}</h3>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <p class="fw-bolder">@lang('messages.Alert_Notifications')</p>
                                        <div class="box">
                                            @if (get_config('shipment_notification') == 'enabled')
                                                <div class="box-item-notification">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <i class="bi bi-bell bi-sub fs-4 text-gray-600"></i>
                                                            {{ trans_choice('messages.Shipment', 1) }}
                                                        </div>
                                                        <div class="col-4">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="shipment_notification"
                                                                    @if ($user->shipment_notification == 1) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="shipment_notification"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (get_config('invoice_notification') == 'enabled')
                                                <div class="box-item-notification">
                                                    <div class="row">
                                                        <div class="col-8">
                                                            <i class="bi bi-bell bi-sub fs-4 text-gray-600"></i>
                                                            {{ trans_choice('messages.Invoice', 1) }}
                                                            <br>
                                                        </div>
                                                        <div class="col-4 text-right">
                                                            <div class="form-check form-switch">
                                                                <input class="form-check-input" type="checkbox"
                                                                    id="invoice_notification"
                                                                    @if ($user->invoice_notification == 1) checked @endif>
                                                                <label class="form-check-label"
                                                                    for="invoice_notification"></label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="card">
                                    <div class="card-body">
                                        <p class="fw-bolder">@lang('messages.Notifications_Settings')</p>
                                        <div class="box">
                                            @if (get_config('email_notification') == 'enabled')
                                                <div class="box-item">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="email_notification"
                                                            @if ($user->email_notification == 1) checked @endif>
                                                        <label class="form-check-label"
                                                            for="email_notification">@lang('messages.Email_Alert')</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (get_config('sms_notification') == 'enabled')
                                                <div class="box-item">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="sms_notification"
                                                            @if ($user->sms_notification == 1) checked @endif>
                                                        <label class="form-check-label"
                                                            for="sms_notification">@lang('messages.SMS_Alert')</label>
                                                    </div>
                                                </div>
                                            @endif
                                            @if (get_config('site_notification') == 'enabled')
                                                <div class="box-item">
                                                    <div class="form-check form-switch">
                                                        <input class="form-check-input" type="checkbox"
                                                            id="site_notification"
                                                            @if ($user->site_notification == 1) checked @endif>
                                                        <label class="form-check-label"
                                                            for="site_notification">@lang('messages.Insite_Alert')
                                                        </label>
                                                    </div>
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- // Notifications --}}

                        {{-- Password Panel --}}
                        <div role="tabpanel" class="tab-pane fade" id="password" aria-labelledby="settings-detail-tab">
                            <form id="user_password_form"
                                data-action="{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'password']) }}"
                                method="post">
                                @csrf
                                @method('POST')
                                <div class="card-header mb-3">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">{{ __('messages.Update') }} @lang('messages.Password')</h3>
                                    </div>
                                </div>
                                
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">

                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <div class="form-group form-floating mb-3">
                                                        <input type="password" class="form-control" name="old_password"
                                                            value="" placeholder="Password">
                                                        <label for="floatingPassword">@lang('messages.Old_Password')</label>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr>
                                            <div class="col-md-6">
                                                <div class="form-group mb-3">
                                                    <div class="form-group form-floating mb-3">
                                                        <input type="password" class="form-control" name="password"
                                                            value="{{ old('password') }}" placeholder="Password"
                                                            required="required">
                                                        <label for="floatingPassword">@lang('messages.Password')</label>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-floating mb-3">
                                                    <input type="password" class="form-control"
                                                        name="password_confirmation"
                                                        value="{{ old('password_confirmation') }}"
                                                        placeholder="@lang('messages.Confirm_Password')" required="required">
                                                    <label for="floatingConfirmPassword">@lang('messages.Confirm_Password')</label>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Submit  --}}
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                                        <a href="{{ url()->previous() }}"
                                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>
                                        <button type="submit" class="btn btn-success"
                                            id="save_user_password_btn">@lang('messages.Save_Change')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        {{-- // Contacts Panel --}}

                        {{-- Avatar Panel --}}
                        <div role="tabpanel" class="tab-pane fade" id="avatar" aria-labelledby="settings-detail-tab">
                            <form id="avatar_form"
                                data-action="{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'avatar']) }}"
                                method="post" enctype="multipart/form-data">
                                @csrf
                                @method('POST')
                                <div class="card-header mb-3">
                                    <div class="card-title m-0">
                                        <h3 class="fw-bolder m-0">@lang('messages.Update') {{ __('messages.Avatar') }}</h3>
                                    </div>
                                </div>
                               
                                <div class="card">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-4 text-center">
                                                @if ($user->avatar)
                                                    <div id="avatar-up"
                                                        class="avatar  avatar-xlx me-3 bg-rgba-primary m-0 me-50">
                                                        <img src="{{ asset($user->avatar) }}" class="avatar-lg rounded-circle p-1 img-thumbnail" alt=""
                                                            srcset="">
                                                    </div>
                                                @else
                                                <div class="avatar-lg xrounded-circle p-1 img-thumbnail">
                                                    <span class="avatar-sm">
                                                        <span class="avatar-title bg-light rounded text-body fs-4">
                                                            <i class="bi bi-person"></i>
                                                        </span>
                                                    </span>
                                                </div>
                                                @endif
                                            </div>
                                            <div class="col-md-8 mt-4">
                                                <fieldset>
                                                    <div class="input-group">
                                                        <input name="avatar" type="file" class="form-control"
                                                            id="post_img" accept="image/*" required />
                                                    </div>
                                                </fieldset>
                                                
                                            </div>
                                        </div>
                                    </div>
                                    {{-- Submit  --}}
                                    <div class="card-footer d-flex justify-content-end py-6 px-9">

                                        <a href="{{ url()->previous() }}"
                                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>
                                        <button type="submit" class="btn btn-success"
                                            id="save_avatar">@lang('messages.Save')</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('css')
    <link rel="stylesheet"
        href="{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/intlTelInput/css/intlTelInput.css">
    <style>
        .profile .avatar.avatar-xlx img {
            width: 100px;
            height: 100px;
        }

        .fade:not(.show) {
            opacity: 0;
            display: none;
        }

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
            initialCountry: "{{ country_code($user->country) != '' ? country_code($user->country) : 'auto' }}",

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

            //start: save details script
            $('#user_detail_form').submit(function(e) {
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
                var timezone = $('select[name="timezone"]').val();
                var language = $('select[name="language"]').val();
                //validate input field
                if (firstname != '' && lastname != '' && timezone != '' && language != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'details']) }}",
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
            //end: save details script

            //start: save password script
            $('#user_password_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                var old_password = $('input[name="old_password"]').val();
                var password = $('input[name="password"]').val();
                var password_confirmation = $('input[name="password_confirmation"]').val();

                //validate input fields 
                if (password != password_confirmation) {
                    Toastify({
                        text: "{{ __('messages.Wrong_Password_Match') }}",
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                } else if (password != '') {
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

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'password']) }}",
                        data: $form.serialize(),
                        success: save_data,
                        dataType: 'json',
                        error: error_data
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
            //end: save details script

            //start: avatar script
            $("#post_img").change(function() {
                $('#avatar-up').html("");
               
                var post_file = document.getElementById("post_img").files.length;
                for (var i = 0; i < post_file; i++) {
                    $('#avatar-up').append("<img src='" + URL.createObjectURL(event.target.files[i]) +
                        "'>");
                   
                }
            });

            //start: save data script
            $('#avatar_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                var formData = new FormData(this);
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

                var bar = $('#bar');
                var percent = $('#percent');
                $.ajax({
                    // beforeSend: function() {
                    //     document.getElementById("progress_div").style.display = "block";
                    //     var percentVal = '0%';
                    //     bar.width(percentVal)
                    //     percent.html(percentVal);
                    // },
                    // uploadProgress: function(event, position, total, percentComplete) {
                    //     var percentVal = percentComplete + '%';
                    //     bar.width(percentVal)
                    //     percent.html(percentVal);
                    // },
                    type: "POST",
                    url: "{{ route('dashboard.users.update', ['id' => $user->id, 'type' => 'avatar']) }}",
                    data: formData,
                    success: function(data) {
                        // var percentVal = '100%';
                        // bar.width(percentVal)
                        // percent.html(percentVal);
                        $('#post_img').val("");
                    },
                    complete: function(xhr) {
                        //$('#progress_div').hide();
                        var json_data = $.trim(xhr.responseText);
                        var data = $.parseJSON(json_data);
                        if (data.result == 'success') {

                            //success
                            $('#progress_div').hide();
                            $('.avatar').html("<img class='js--lazyload' src='" + data.avatar_url +
                                "' data--lazyload='" + data.avatar_url +
                                "'>");
                            Toastify({
                                text: '<span class="fa fa-check-circle"></span> ' +
                                    data.messages,
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
                                    text: '<span class="fa fa-times-circle"></span> ' +
                                        data.messages[i],
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

                    },
                    cache: false,
                    contentType: false,
                    processData: false,
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

            });
            //end: save data script
            //end: avatar script
        });
    </script>


    {{-- Notifications script --}}
    <script>
        $(document).ready(function() {
            $("input[id='email_notification']").click(function() {
                var tValue = $("input[id='email_notification']:checked").length > 0;
                if (tValue) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 1, 'type' => 'email']) }}"
                    }).done(function(data) {});
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 0, 'type' => 'email']) }}"
                    }).done(function(data) {});
                }
            });
            $("input[id='sms_notification']").click(function() {
                var tValue = $("input[id='sms_notification']:checked").length > 0;
                if (tValue) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 1, 'type' => 'sms']) }}"
                    }).done(function(data) {});
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 0, 'type' => 'sms']) }}"
                    }).done(function(data) {});
                }
            });
            $("input[id='site_notification']").click(function() {
                var tValue = $("input[id='site_notification']:checked").length > 0;
                if (tValue) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 1, 'type' => 'site']) }}"
                    }).done(function(data) {});
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 0, 'type' => 'site']) }}"
                    }).done(function(data) {});
                }
            });
            $("input[id='shipment_notification']").click(function() {
                var tValue = $("input[id='shipment_notification']:checked").length > 0;
                if (tValue) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 1, 'type' => 'shipment']) }}"
                    }).done(function(data) {});
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 0, 'type' => 'shipment']) }}"
                    }).done(function(data) {});
                }
            });
            $("input[id='invoice_notification']").click(function() {
                var tValue = $("input[id='invoice_notification']:checked").length > 0;
                if (tValue) {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 1, 'type' => 'invoice']) }}"
                    }).done(function(data) {});
                } else {
                    $.ajax({
                        type: "GET",
                        url: "{{ route('dashboard.users.update.notice', ['id' => $user->id, 'value' => 0, 'type' => 'invoice']) }}"
                    }).done(function(data) {});
                }
            });

        });
    </script>
    {{-- / --}}
@endpush
