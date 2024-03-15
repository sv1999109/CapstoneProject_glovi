@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();

    // fetch active branches
    $branches = \App\Models\Branches::where('status', 1)
        ->orderBy('id', 'asc')
        ->get();

    $role = Auth()->user()->role;
    $user_id = Auth()->user()->id;
    $address_sender = [];
    $address_recipient = [];

    if (isset($user->id)) {
        $address_sender = DB::table('addresses')
            ->whereRaw("address_type = '1' AND owner_id = '$user->id'")
            ->orderBy('firstname', 'asc')
            ->get();
        $address_recipient = DB::table('addresses')
            ->whereRaw("address_type = '2' AND owner_id = '$user->id'")
            ->orderBy('firstname', 'asc')
            ->get();
    }

    //user is customer
    if ($role == 1) {
        $address_sender = DB::table('addresses')
            ->whereRaw("address_type = '1' AND owner_id = '$user_id'")
            ->orderBy('firstname', 'asc')
            ->get();
        $address_recipient = DB::table('addresses')
            ->whereRaw("address_type = '2' AND owner_id = '$user_id'")
            ->orderBy('firstname', 'asc')
            ->get();
    }

    
   

   
    $collection_type = isset($_REQUEST['pickup']);
@endphp
@csrf

{{-- .card --}}
<div class="add-shipment">
    <input type="hidden" name="service_provider" value="{{ get_config('api_provider') }}">
    <input class="form-check-input" type="hidden" name="collection_type" value="2">
    <input class="form-check-input" type="hidden" name="delivery_type" value="1">
    <div class="row">
        <div class="col-lg-12">
            <div class="card ">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-body">

                            <div class="form-label">{{ trans_choice('messages.Customer', 1) }}</div>

                            @if ($role == 1)
                                <input type="hidden" id="sel_client" name="client" value="{{ $user->id }}">
                                <input type="text" class="form-control" id="sel_client" disabled
                                    value="{{ $user->firstname }} {{ $user->lastname }} ({{ $user->username }})">
                            @else
                                <select class="form-search form-select" id="sel_client" name="client">
                                    @if (isset($user))
                                        <option value="{{ $user->id }}">{{ $user->firstname }} {{ $user->lastname }}
                                            ({{ $user->username }})</option>
                                    @endif
                                </select>
                            @endif
                            @error('client')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                    <div class="col-lg-6">

                        <div class="card-body">

                            <div class="form-group mb-3">
                                <label class="form-label required">@lang('messages.Pickup')</label>
                                <div class="row">
                                    <div class="col-10">
                                        <select class="form-select form-search" id="sel_sender_address"
                                            name="sender_info" required>
                                            <option value="">@lang('messages.Select_Address')</option>
                                            @foreach ($address_sender as $address)
                                                <option value="{{ $address->id }}">{{ $address->firstname }} -
                                                    {{ $address->address }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                    <div class="col-2">
                                        <a id="sender_add_link" data-bs-toggle="modal" data-bs-target="#locationModal"
                                            href="#" class="btn"><i class="bi bi-plus-circle-dotted"></i></a>
                                    </div>
                                </div>

                            </div>

                        </div>

                    </div>
                </div>
            </div>

        </div>

    </div>
    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">@lang('messages.Recipient')</h5>
                </div>
                <div class="card-body">

                    <div class="row gy-3" id="recipient_box">

                        @foreach ($address_recipient as $address)
                            <div class="col-lg-4 col-sm-6 recipient_box">
                                <div class="form-check card-radio rounded-bottom-0">
                                    <input value="{{ $address->id }}" id="shippingAddress{{ $address->id }}" name="receiver_info" type="radio"
                                        class="form-check-input" checked="">
                                    <label class="form-check-label" for="shippingAddress{{ $address->id }}">
                                        <span
                                            class="mb-3 fw-semibold d-block text-muted text-uppercase">@lang('messages.To')</span>

                                        <span class="fs-md mb-2 d-block fw-medium">{{ $address->firstname }} -
                                            {{ $address->lastname }}</span>
                                        <span
                                            class="text-muted fw-normal text-wrap mb-1 d-block">{{ $address->address }},
                                            {{ get_name($address->city, 'cities') }},
                                            {{ get_name($address->state, 'states') }} {{ $address->postal }},
                                            {{ country_code($address->country) }}</span>
                                        <span class="text-muted fw-normal d-block">@lang('messages.Phone').
                                            {{ $address->phone }}</span>
                                    </label>
                                </div>

                            </div>
                        @endforeach
                        <div id="recipient_add" class="col-lg-4 col-sm-6">
                            <a href="#!" id="recipient_add_link"
                                class="card bg-light bg-opacity-25 border border-light-subtle shadow-none h-100 text-center">
                                <div class="card-body d-flex justify-content-center align-items-center">
                                    <div>
                                        <div class="fs-4xl mb-2"><i class="bi bi-plus-circle-dotted"></i></div>
                                        <div class="fw-medium fs-md text-primary-emphasis stretched-link"
                                            data-bs-toggle="modal" data-bs-target="#locationModal">@lang('messages.Add_Address')
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>

                    </div>

                </div>
            </div>
        </div>
    </div>

    <!-- Package Info -->
    <div class="row" id="package_info">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('messages.Package_Info')</h6>
                </div>
                <div class="card-body" id="package_col" data-repeater-list="packages">
                    <div class="row" data-repeater-item>
                        <div class="col-md-3  mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Description')</label>
                                <input placeholder="@lang('messages.Description')" type="text"
                                    value="{{ old('package_description', 'Small Box') }}"
                                    class="form-control @error('package_description') is-invalid @enderror"
                                    name="package_description" required />
                                @error('package_description')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Length_CM')</label>
                                <input placeholder="@lang('messages.Length')" type="number" min="1"
                                    value="{{ old('length', 15.0) }}" class="form-control" name="length"
                                    required />
                                @error('length')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Width_CM')</label>
                                <input placeholder="@lang('messages.Width')" type="number" min="1"
                                    value="{{ old('width', 15.0) }}" class="form-control" name="width" required />
                                @error('width')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Height_CM')</label>
                                <input placeholder="@lang('messages.Height')" type="number" min="1"
                                    value="{{ old('height', 15.0) }}" class="form-control" name="height"
                                    required />
                                @error('height')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Weight_Kg')</label>
                                <input placeholder="@lang('messages.Weight')" type="number" {{-- min="0.5" step="any" --}}
                                    value="{{ old('weight', 1.0) }}" min="0.5" step="any"
                                    class="form-control weights @error('total_weight') is-invalid @enderror"
                                    name="weight" onchange="Calculate_Total_Weight()" required />
                                @error('weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Quantity')</label>
                                <input placeholder="@lang('messages.Quantity')" type="number" min="1"
                                    value="{{ old('qty', '1') }}"
                                    class="form-control qty @error('qty') is-invalid @enderror" name="qty"
                                    onchange="Calculate_Total_Qty()" required />

                                @error('qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="form-group">
                                <label class="form-label required">@lang('messages.Declared_Value')</label>
                                <div class="input-group mb-3">
                                    <span
                                        class="input-group-text">{{ get_money('0', get_currency('code'), 'only_symbol', 'localize') }}</span>
                                    <input placeholder="@lang('messages.Declared_Value')" type="number"
                                        value="{{ old('value', '') }}" min="1"
                                        class="form-control @error('value') is-invalid @enderror" name="value"
                                        required />
                                    @error('value')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>
                        <div class="col-3">
                            <a href="javascript:;" data-repeater-delete="" class=" pt-5 float-end">
                                <i class="bi bi-x-lg align-baseline text-danger me-1"></i>
                            </a>
                        </div>

                    </div>
                </div>
                <div class="card-body">

                    <div class="row" id="package_total">
                        <div class="col-12 col-lg-5 d-flex justify-content-end fw-bold"></div>
                        <div class="col-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text">@lang('messages.Total_Weight_Kg')</span>
                                <input readonly type="number" min="0.5" step="any" value="{{ old('total_weight', 1.0) }}"
                                    class="form-control total_weight @error('total_weight') is-invalid @enderror"
                                    name="total_weight" required />
                                @error('total_weight')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                        <div class="col-6 col-lg-3">
                            <div class="input-group mb-3">
                                <span class="input-group-text">@lang('messages.Total_Qty')</span>
                                <input readonly type="number" min="1" value="{{ old('total_qty', 1.0) }}"
                                    class="form-control total_qty @error('total_qty') is-invalid @enderror"
                                    name="total_qty" required />
                                @error('total_qty')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>

                    <a href="javascript:;" data-repeater-create="" id="Xadd_package" class="btn btn-sm btn-primary">
                        <i class="bi bi-plus-circle-dotted"></i> @lang('messages.Add_Package')
                    </a>
                </div>
            </div>
        </div>
    </div>
    <!--// Package Info -->

    <!-- Shipment Info -->
    <div class="row">
        <div class="col-lg-12">

            <div class="card">
                <div class="card-header">
                    <h6 class="card-title mb-0">@lang('messages.Shipment_Info')</h6>
                </div>
                <div class="row card-body">
                    {{-- Tracking Number --}}
                    <label class="col-12 col-form-label fw-bold">@lang('messages.Tracking_Number')</label>
                    @if (get_config('tracking_prefix') == 'enabled')
                        <div class="col-3">
                            <div class="input-group mb-3">
                                <input name="tracking_code_prefix"
                                    value="{{ old('tracking_code_prefix', get_config('default_tracking_prefix')) }}"
                                    type="text" class="form-control" placeholder="@lang('messages.Prefix')"
                                    maxlength="5" @if (Auth()->user()->role < 2) disabled @endif>
                                @error('tracking_code_prefix')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                                <span class="input-group-text" id="basic-addon2">-</span>
                            </div>
                        </div>
                    @endif
                    <div class="col-9">
                        <div class="form-group">
                            <input name="tracking_code_number"
                                value="{{ old('tracking_code_number', generate_tracking_no()) }}" type="text"
                                class="form-control" readonly>
                        </div>
                    </div>
                    {{-- Payment Types --}}
                    <input type="hidden" name="payment_type" value="1">
                    {{-- <div class="col-md-4 mt-4">
                        <div class="form-group mb-3">
                            <label class="form-label required">@lang('messages.Payment_Type')</label>
                            <select class="form-select @error('payment_type') is-invalid @enderror" id="payment_type"
                                name="payment_type" required>
                                @php
                                    $payment_type = get_config('payment_type');
                                @endphp
                                <option value="1" {{ old('payment_type') == '1' ? 'selected' : '' }}
                                    {{ $payment_type == 1 ? 'selected' : '' }}>
                                    @lang('messages.PrePaid')</option>
                                <option value="2" {{ old('payment_type') == '2' ? 'selected' : '' }}
                                    {{ $payment_type == 2 ? 'selected' : '' }}>
                                    @lang('messages.PostPaid')</option>
                            </select>
                            @error('payment_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div> --}}
                    
                    {{-- Payment Methods --}}
                    <div class="col-md-12 ">
                        <h6>{{ trans_choice('messages.Payment_Method', 1) }}</h6>
                        <div class="row g-4">
                            
                           @php
                            $payment_method = get_config('payment_method');
                           @endphp
                            @foreach (DB::table('payment_methods')->orderBy('name', 'asc')->where('status', 1)->get() as $pay)
                            <div class="col-lg-4 mb-0" id="pay{{$pay->id}}">
                                <div class="form-check card-radio">
                                    <input id="pay-i-{{$pay->id}}" name="payment_method" type="radio" class="form-check-input" value="{{ $pay->id }}"   {{ $payment_method == $pay->id ? 'checked' : '' }}>
                                    <label class="form-check-label d-flex gap-2 align-items-center" for="pay-i-{{$pay->id}}">
                                        
                                        <span class="flex-grow-1">
                                            <span
                                                class="fs-md fw-medium mb-1 text-wrap d-block">
                                                {{ __('messages.' . $pay->name) }}
                                        </span>
                                        </span>
                                       
                                    </label>
                                </div>
                            </div>
                            @error('payment_method')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                            @endforeach
                        </div>
                       
                    </div>

                    
                </div>
            </div>

        </div>

    </div>
</div>
<!--// Shipment Info -->

@push('modal')
    <div id="locationModal" class="modal fade zoomIn locationModal" tabindex="-1" aria-labelledby="locationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <form id="address_create_form" data-action="{{ route('dashboard.address.create') }}"
                    class="form needs-validation" novalidate method="post">
                    @csrf
                    <div class="modal-header">
                        <h5 class="modal-title" id="locationModalLabel">@lang('messages.Add_Address')</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <input type="hidden" value="2" id="address_type" name="address_type">
                        @if (isset($user))
                            <input type="hidden" id="client_id" name="client" value="{{ $user->id }}">
                        @else
                            <input type="hidden" id="client_id" name="client" required>
                        @endif

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-group mb-3">
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
                                    <select id="sel_area" name="area"
                                        class="form-select form-search @error('area') is-invalid @enderror">
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
                        <div class="form-group mb-3">
                            <label for="address" class="form-label required">@lang('messages.Delivery_Address')</label>
                            <div class="row">
                                <div class="col-md-6">
                                    <input placeholder="Enter house or apartment no" type="text" name="house_no" value="{{ old('house_no', '') }}"
                                        class="form-control @error('house_no') is-invalid @enderror" required>
                                    @error('house_no')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input placeholder="Enter street address" type="text" name="address" value="{{ old('address', '') }}"
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
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="phone" class="form-label required">@lang('messages.Phone')</label>
                                    <div>
                                        <input id="telephone" type="tel" class="form-control"
                                            value="{{ old('phone', '') }}" required>
                                        <input type="hidden" value="{{ old('phone', '') }}" name="phone"
                                            id="phone_number" value="">
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label for="email" class="form-label required">@lang('messages.Email')</label>
                                    <input type="text" name="email" value="{{ old('email', '') }}"
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
                    <div class="modal-footer">
                        <button type="button" class="btn btn-ghost-danger" data-bs-dismiss="modal"><i
                                class="bi bi-x-lg align-baseline me-1"></i> Close</button>
                        <button type="submit" class="btn btn-primary">@lang('messages.Save')</button>
                    </div>
                </form>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endpush

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
    <script src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/js/pages/form-validation.init.js"></script>
    <script type='text/javascript'>
        //select form helper
        $(document).ready(function() {
            $('#sel_country').select2(
            {
                width: "100%",
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_state').select2(
            {
                width: "100%",
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_city').select2(
            {
                width: "100%",
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_area').select2(
            {
                width: "100%",
                dropdownParent: $('.locationModal')
            }
        );
        $('#sel_branch').select2(
            {
                width: "100%",
                dropdownParent: $('.locationModal')
            }
        );
        $('.form-search').select2(
            {
                width: "100%",
                dropdownParent: $('.locationModal')
            }
        );
            var s_search = $('#sel_client').val();

            @if ($role > 1)
                $("#sel_client").select2({
                    width: "100%",
                    language: '{{ LaravelLocalization::getCurrentLocale() }}',
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
                                        text: item.firstname + ' ' + item.lastname + ' - ' +
                                            item
                                            .username,
                                        id: item.id
                                    }
                                })
                            };
                        },
                        cache: true
                    },
                    minimumInputLength: 3,
                    //placeholder: search,
                    allowClear: true
                }).on('change', function(e) {
                    //
                });
            @endif

            //Branches
            $('#sel_client').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                // $('#sel_branch_1').find('option').not(':first').remove();
                // $('#sel_branch_2').find('option').not(':first').remove();
                // AJAX request
                //Sender 
                $.ajax({
                    url: '{{ url('dashboard/address/getaddress/1') }}/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_sender_address').find('option').not(':first').remove();
                        var len = 0;
                        if (response['data'] != null) {
                            len = response['data'].length;
                        }
                        // Read data and create <option >
                        for (var i = 0; i < len; i++) {

                            var id = response['data'][i].id;
                            var name = response['data'][i].firstname + ' ' + response['data'][i]
                                .lastname + ' - ' + response['data'][i].address;

                            var option = "<option value='" + id + "'>" + name +
                                "</option>";
                            if (response['data'][i].id != 0) {
                                $("#sel_sender_address").append(option);
                            } else {
                                $('#sel_sender_address').find('option').not(':first').remove();
                            }
                        }
                    }
                });

                //Recipients
                // empty Recipients
                $('.recipient_box').remove();
                $.ajax({
                    url: '{{ url('dashboard/address/getaddress/3') }}/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(data) {
                        if (data.result == 'success') { 
                            $(data.address_data).insertBefore('#recipient_add');
                        }
                    }
                });
            });

        });
    </script>

    <script>
        $(document).ready(function() {

            $('#sel_client').change(function() {

                var client_id = $(this).val();
                $('#client_id').val(client_id);

            });

            $('#sender_add_link').click(function() {

                $('#address_type').val('1');

            });
            $('#recipient_add_link').click(function() {

                $('#address_type').val('2');

            });


            //start: create data script
            $('#address_create_form').submit(function(e) {
                e.preventDefault();

                $form = $(this);
                const isValidForm = document.getElementById('address_create_form');
                var client_id = $('#client_id').val();
                if (client_id == '') {
                    Toastify({
                        text: "{{ __('messages.Select_Sender') }}",
                        duration: 10000,
                        close: true,
                        gravity: "top",
                        position: "center",
                        backgroundColor: "red",
                    }).showToast();
                }

                if (isValidForm.checkValidity() && client_id) {
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
                        url: "{{ route('dashboard.address.create') }}",
                        data: $form.serialize(),
                        dataType: 'json',
                        success: function(data) {

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
                            if (data.result == 'success') {
                                if (data.address_type == '1') {
                                    $('#sel_sender_address').append(data.address_data);
                                 }
                                 else {
                                    $(data.address_data).insertBefore('#recipient_add');

                                 }
                               
                                $('#address_create_form')[0].reset();
                                $('#locationModal').modal('hide');

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


                            } else {

                                Toastify({
                                    text: data.messages,
                                    duration: 10000,
                                    close: true,
                                    gravity: "top",
                                    position: "center",
                                    backgroundColor: "red",
                                }).showToast();


                            }


                            // var len = 0;
                            // if (response['data'] != null) {
                            //     len = response['data'].length;
                            // }

                            // if (len > 0) {

                            //     // Read data and create <option >
                            //     for (var i = 0; i < len; i++) {

                            //         var id = response['data'][i].id;
                            //         var name = response['data'][i].name;

                            //         var div = '<div class="col-lg-4 col-sm-6 recipient_box">
                            //     <div class="form-check card-radio rounded-bottom-0">
                            //         <input id="shippingAddress'+ id + '" name="shippingAddress"
                            //             type="radio" class="form-check-input" checked="">
                            //         <label class="form-check-label" for="shippingAddress'+ id +'">
                            //             <span
                            //                 class="mb-3 fw-semibold d-block text-muted text-uppercase">@lang('messages.To')</span>

                            //             <span class="fs-md mb-2 d-block fw-medium">'+ firstname +' -
                            //                '+lastname +'</span>
                            //             <span
                            //                 class="text-muted fw-normal text-wrap mb-1 d-block">'+ address +',
                            //                 '+ city +',
                            //                 '+ state +' '+ postal +',
                            //                 '+ country +'</span>
                            //             <span class="text-muted fw-normal d-block">@lang('messages.Phone').
                            //                 '+ phone +'</span>
                            //         </label>
                            //     </div>

                            // </div>';

                            //      $(div).insertAfter('#recipient_box div:last');
                            // }

                            //}

                        },
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

                }

            });
            //end: create data script
        });
    </script>
@endpush
