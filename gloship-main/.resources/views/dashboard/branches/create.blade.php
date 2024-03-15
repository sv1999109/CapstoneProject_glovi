@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    $staffs = '';
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">
                        {{ $page_title }}
                    </h3>
                </div>
                <hr class="divider">
                <form id="branch_create_form" data-action="{{ route('dashboard.branch.create') }}" class="form"
                    method="post">
                    <div class="card-body">
                        @csrf
                        @method('POST')
                        <div class="row">
                            <div class="col-md-6 form-group mb-3">
                                <label for="country" class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                                @if (Session::has('country'))
                                    <select required class="form-control" name="country">
                                        @foreach ($countries as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('country') == $item->id ? 'selected' : '' }}
                                                @if (Session::get('country') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select required class="form-select required" id="sel_country" name="country">
                                        <option value="">@lang('messages.Select_Country')</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('country') == $item->id ? 'selected' : '' }}
                                                @if (Session::get('country') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @endif
                                @error('country')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label class="form-label required">@lang('messages.State_Province')</label>
                                @if (Session::has('state'))
                                    @php
                                        $states = DB::table('states')
                                            ->where('country_id', Session::get('country'))
                                            ->get();
                                    @endphp
                                    <select required id="sel_state" class="form-select" name="state">
                                        @foreach ($states as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('state') == $item->id ? 'selected' : '' }}
                                                @if (Session::get('state') == $item->id) selected @endif>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select required id="sel_state" name="state" class="form-select required" required>
                                        <option value="">@lang('messages.Select_State')</option>
                                    </select>
                                @endif
                                @error('state')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                            <div class="col-md-6 form-group mb-3">
                                <label for="city" class="form-label optional">@lang('messages.City_Region')</label>
                                @if (Session::has('state'))
                                    @php
                                        $cities = DB::table('cities')
                                            ->where('state_id', Session::get('state'))
                                            ->get();
                                    @endphp
                                    <select required id="sel_city" class="form-select" name="city">
                                        <option value="">@lang('messages.Select_City')</option>
                                        @foreach ($cities as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('city') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                @else
                                    <select id="sel_city" name="city"
                                        class="form-select @error('state') is-invalid @enderror" required>
                                        <option value="">@lang('messages.Select_City')</option>
                                    </select>
                                @endif
                                @error('city')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror

                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="address" class="form-label required">{{ trans_choice('messages.Address', 1) }}/{{ trans_choice('messages.Location', 1) }}</label>
                                <input type="text" name="address" value="{{ old('address', '') }}"
                                    class="form-control @error('address') is-invalid @enderror" required>
                                @error('address')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="name" class="form-label required">@lang('messages.Name')</label>
                                <input type="text" name="name" value="{{ old('name', '') }}"
                                    class="form-control" required>
                                @error('name')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="phone" class="form-label required">@lang('messages.Customer_Help_Line')</label>
                                <div>
                                    <input id="telephone" type="tel" class="form-control">
                                    <input type="hidden" name="phone" id="phone_number"
                                        value="">
                                </div>

                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="code" class="form-label required">@lang('messages.Support_Email')</label>
                                <input type="email" name="email" value="{{ old('email', '') }}"
                                    class="form-control" required>

                            </div>

                            <div class="col-md-6 form-group mb-3">
                                <label for="native" class="form-label">@lang('messages.Status')</label>
                                <select name="status" class="form-select required">
                                    <option value="1">{{ get_status('', '1') }}</option>
                                    <option value="2">{{ get_status('', '2') }}</option>
                                </select>
                                @error('status')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="card-footer d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('dashboard.branches') }}"
                            class="btn btn-light btn-active-light-primary me-2 text-uppercase">
                            @lang('messages.Cancel')
                        </a>
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

    <script>
        $(document).ready(function() {

            //start: create data script
            $('#branch_create_form').submit(function(e) {
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

                var name = $('input[name="name"]').val();
                var email = $('input[name="email"]').val();
                var phone = $('input[name="phone"]').val();
                var country = $('select[name="country"]').val();
                var state = $('select[name="state"]').val();
                //validate input field
                if (name !='' && email !='' && phone != '' && country !='' && state !='') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.branch.create') }}",
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
