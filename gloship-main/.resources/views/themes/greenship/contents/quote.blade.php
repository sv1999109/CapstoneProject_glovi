@extends(get_theme_dir('layouts.app'))
@section('content')
    @include(get_theme_dir('layouts.partials.page-heading-empty'))
    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container ">
            <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 600px;">
                <h1 class="mb-3">@lang('messages.GET_A_QUOTE')</h1>
                <p class="mb-1">@lang('messages.GET_A_QUOTE_Subtitle')</p>
            </div>
            <div class="row g-5">
                <div class="col-lg-12">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">

                        {{-- Response --}}
                        @if (isset($errors) && count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @if (Session::has('message') != true)
                            <form method="post" action="{{ route('shipping.rates') }}">
                                @method('POST')
                                @csrf
                                <input type="hidden" name="is_guest_rates" value="1">
                                <input type="hidden" value="{{ old('total_weight', 1.0) }}" class="total_weight"
                                    name="total_weight" />
                                <input type="hidden" value="{{ old('total_qty', 1) }}" name="total_qty" />
                                <input type="hidden" name="service_provider" value="{{ get_config('api_provider') }}">

                                <div class="row" id="package_info">
                                    <div class="col-md-12">
                                        <fieldset class="form__itemx" data-main="true">
                                            <div class="h3 form__title">{{ trans_choice('messages.Package_Detail', 2) }}</div>

                                            <div class="card box-shadow" id="package_col" data-repeater-list="packages">

                                                <div class="row card-body"  data-repeater-item>
                                                    <input placeholder="@lang('messages.Description')" type="hidden"
                                                    value="{{ old('package_description', 'Package') }}"
                                                    name="package_description" /> 
                                                    <div class="col-sm-2 no-pad mb-3">
                                                        <label for="">@lang('messages.Length_CM')</label>
                                                        <input type="number" name="length" placeholder="20"
                                                        min="1"
                                                        value="{{ old('length', 20) }}" required class="form-control  fw-600">
                                                    </div>
                                                    <div class="col-sm-2 no-pad mb-3">
                                                        <label for="">@lang('messages.Width_CM')</label>
                                                        <input type="number" name="width" placeholder="20"
                                                        min="1" 
                                                        value="{{ old('width', 20) }}" required class="form-control  fw-600">
                                                    </div>
                                                    <div class="col-sm-2 no-pad mb-3">
                                                        <label for="">@lang('messages.Height_CM')</label>
                                                        <input type="number" name="height" placeholder="50"  min="1" 
                                                        value="{{ old('height', 20) }}" required class="form-control  fw-600">
                                                    </div>
                                                    <div class="col-sm-2 no-pad mb-3">
                                                        <label for="">@lang('messages.Weight_Kg')</label>
                                                        <input type="number" name="weight"
                                                        placeholder="1" 
                                                        min="1"
                                                        value="{{ old('weight', 1.0) }}"
                                                        onchange="Calculate_Total_Weight()" required class="form-control weights fw-600">
                                                    </div>
                                                    <div class="col-sm-2 no-pad mb-3">
                                                        <label for="">@lang('messages.Quantity')</label>
                                                        <input type="number"  name="qty" placeholder="@lang('messages.Quantity')" min="1" max="100"
                                                        value="{{ old('qty', '1') }}"
                                                         onchange="Calculate_Total_Qty()" required class="form-control qty fw-600">
                                                    </div>
                                                    <div class="col-sm-2 no-pad mb-3">
                                                        <label for="">@lang('messages.Declared_Value') ({{ get_currency('code') }})</label>
                                                        <input type="number" min="1" step="any" name="value" placeholder="0.00" class="form-control  fw-600" value="{{ old('value', '') }}" required>
                                                    </div>
                                                   
                                                   
                                                </div>       

                                            </div>

                                            <div class="form__add mt-3 mb-4">

                                                <a href="javascript:;" data-repeater-create="" id="Xadd_package"
                                                    class="btn btn-sm btn-blue">
                                                    <div>
                                                        <span>+ADD</span>
                                                        <span>Another Item</span>
                                                    </div>
                                                </a>
                                                <div class="form__total">
                                                    <span>Total shipment weight:</span>
                                                    <strong data-total-weight=""><span
                                                            class="total_weight_element">{{ old('weight', 1.0) }}</span></strong>
                                                </div>
                                            </div>

                                        </fieldset>
                                    </div>
                                </div>

                                <div class="card box-shadow mt-5">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6" style="border-right: 1px solid #eee">
                                                <div class="h3 form__title">Pickup location</div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label
                                                                class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                                                            <select
                                                                class="form-control @error('pickup_country') is-invalid @enderror"
                                                                id="sel_country" name="pickup_country" required>
                                                                <option value="">@lang('messages.Select')</option>
                                                                @foreach (DB::table('countries')->where('status', 1)->get() as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('pickup_country')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label required">@lang('messages.State_Province')</label>
                                                            <select id="sel_state" name="pickup_state"
                                                                class="form-control form-select @error('pickup_state') is-invalid @enderror"
                                                                required>
                                                                <option value="">@lang('messages.Select')</option>

                                                            </select>
                                                            @error('pickup_state')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">@lang('messages.City_Region')</label>
                                                            <select id="sel_city" name="pickup_city"
                                                                class="form-control form-select @error('pickup_city') is-invalid @enderror">
                                                                <option value="">@lang('messages.Select')</option>
                                                            </select>
                                                            @error('pickup_city')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="address"
                                                                class="form-label required">{{ trans_choice('messages.Address', 1) }}</label>
                                                            <input type="text" name="pickup_address" placeholder="123 street"
                                                                value="{{ old('pickup_address', '') }}"
                                                                class="form-control @error('address') is-invalid @enderror"
                                                                required>
                                                            @error('pickup_address')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="postal"
                                                                class="form-label required">@lang('messages.Postal')</label>
                                                            <input type="text" name="pickup_postal"
                                                            placeholder="123456"
                                                                value="{{ old('pickup_postal', '') }}"
                                                                class="form-control @error('pickup_postal') is-invalid @enderror"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="h3 form__title">Delivery location</div>
                                                <div class="row">
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label
                                                                class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                                                            <select
                                                                class="form-control @error('destination_country') is-invalid @enderror"
                                                                id="sel_country2" name="destination_country" required>
                                                                <option value="">@lang('messages.Select')</option>
                                                                @foreach (DB::table('countries')->where('status', 1)->get() as $item)
                                                                    <option value="{{ $item->id }}">
                                                                        {{ $item->name }}
                                                                    </option>
                                                                @endforeach
                                                            </select>
                                                            @error('destination_country')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label required">@lang('messages.State_Province')</label>
                                                            <select id="sel_state2" name="destination_state"
                                                                class="form-control form-select @error('destination_state') is-invalid @enderror"
                                                                required>
                                                                <option value="">@lang('messages.Select')</option>

                                                            </select>
                                                            @error('destination_state')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-lg-4">
                                                        <div class="form-group mb-3">
                                                            <label class="form-label">@lang('messages.City_Region')</label>
                                                            <select id="sel_city2" name="destination_city"
                                                                class="form-control form-select @error('destination_city') is-invalid @enderror">
                                                                <option value="">@lang('messages.Select')</option>
                                                            </select>
                                                            @error('destination_city')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="address"
                                                                class="form-label required">{{ trans_choice('messages.Address', 1) }}</label>
                                                            <input type="text" name="destination_address"
                                                            placeholder="123 address 2"
                                                                value="{{ old('destination_address', '') }}"
                                                                class="form-control @error('destination_address') is-invalid @enderror"
                                                                required>
                                                            @error('destination_address')
                                                                <div class="invalid-feedback">
                                                                    {{ $message }}
                                                                </div>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="col-md-6">
                                                        <div class="form-group mb-3">
                                                            <label for="postal"
                                                                class="form-label required">@lang('messages.Postal')</label>
                                                            <input type="text" name="destination_postal" placeholder="12345"
                                                                value="{{ old('destination_postal', '') }}"
                                                                class="form-control @error('destination_postal') is-invalid @enderror"
                                                                required>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mx-auto text-center mt-5 mb-5">
                                    <button class="btn btn-primary btn-block w-50"
                                        type="submit"><span class="bi bi-search me-2"></span> {{ trans_choice('messages.Get_Quote', 1) }}</button>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>

            </div>
            <div class="row mt-5">
                <div class="col-lg-12 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="section-title position-relative mx-auto mb-3 pb-5">
                        <h3 class="fw-bold mb-0">{{ trans_choice('messages.Customer_Support', 1) }}</h3>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    @if (get_config('site_head_office'))
                        <div class="card mb-3">
                            <p class="py-3 px-3"><i
                                    class="fa fa-map-marker-alt  fa-2x text-primary me-3"></i>{{ get_config('site_head_office') }}
                            </p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    @if (get_config('site_phone'))
                        <div class="card mb-3">
                            <p class="py-3 px-3"><i
                                    class="fa fa-phone-alt  fa-2x text-primary me-3"></i>{{ get_config('site_phone') }}
                            </p>
                        </div>
                    @endif
                </div>
                <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    @if (get_config('site_email_support'))
                        <div class="card mb-3">
                            <p class="py-3 px-3">
                                <span class=""><i class="bi bi-envelope me-3 text-primary fa-2x"></i></span>
                                <span class=" float-center">{{ get_config('site_email_support') }}</span>
                            </p>
                        </div>
                    @endif
                </div>

            </div>
        </div>
    </div>
    </div>
    <!-- Contact End -->
@endsection

@push('scripts')
    {{-- require jquery repeater --}}
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.repeater/1.2.1/jquery.repeater.min.js"
        integrity="sha512-foIijUdV0fR0Zew7vmw98E6mOWd9gkGWQBWaoA1EOFAx+pY+N8FmmtIYAVj64R98KeD2wzZh1aHK0JSpKmRH8w=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script type='text/javascript'>
        //Countries, States, Cities, Areas form helper
        $(document).ready(function() {

            //Countries, States, Cities, Areas form helper
            $('#sel_country').select2();
            $('#sel_state').select2();
            $('#sel_city').select2();
            $('#sel_area').select2();
            $('#sel_branch').select2();
            $('.form-search').select2();

            //States
            $('#sel_country').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                $('#sel_state').find('option').not(':first').remove();
                $('#sel_state').attr('disabled', true);
                $('#sel_city').find('option').not(':first').remove()
                // AJAX request 
                $.ajax({
                    url: '{{ url('address/getstates') }}/' + id,
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
                    url: '{{ url('address/getcity') }}/' + id,
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
            $('#sel_country2').select2();
            $('#sel_state2').select2();
            $('#sel_city2').select2();


            // fetch states
            $('#sel_country2').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                $('#sel_state2').find('option').not(':first').remove();
                $('#sel_state2').attr('disabled', true);
                $('#sel_city2').find('option').not(':first').remove();
                // AJAX request 
                $.ajax({
                    url: '{{ url('address/getstates') }}/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_state2').find('option').not(':first').remove();
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

                                $("#sel_state2").append(option);
                            }

                            $('#sel_state2').attr('disabled', false);
                        }

                    }
                });
            });

            // fetch cities
            $('#sel_state2').change(function() {


                var id = $(this).val();

                // Empty the dropdown
                $('#sel_city2').find('option').not(':first').remove();
                $('#sel_city2').attr('disabled', true);

                // AJAX request 
                $.ajax({
                    url: '{{ url('address/getcity') }}/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_city2').find('option').not(':first').remove();
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

                                $("#sel_city2").append(option);
                            }

                            $('#sel_city2').attr('disabled', false);
                        }

                    }
                });
            });


        });
    </script>
    <script type='text/javascript' id="custom-js">
        $(document).ready(function() {

            //package form Repeater

            $('#package_info').repeater({
                initEmpty: false,


                show: function() {
                    $(this).slideDown();
                    Calculate_Total_Weight();
                    Calculate_Total_Qty();
                },

                hide: function(deleteElement) {
                    $(this).slideUp(deleteElement);
                },

                isFirstItemUndeletable: true
            });
        });

        function Calculate_Total_Weight() {
            //get element class
            var element_class = $('.weights');
            //set weight to 0
            var sum_weight = 0;
            //map elements
            element_class.map(function() {
                //sum all the .weight values
                sum_weight += parseFloat($(this).val());
            }).get();

            //update total weight value
            $('.total_weight').val(sum_weight);
            $('.total_weight_element').html(sum_weight);
        }

        function Calculate_Total_Qty() {
            //get element class
            var element_class = $('.qty');
            //set weight to 0
            var sum_qty = 0;
            //map elements
            element_class.map(function() {
                //sum all the .weight values
                sum_qty += parseFloat($(this).val());
            }).get();

            //update total weight value
            $('.total_qty').val(sum_qty);
        }
    </script>
@endpush
@push('css')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
        <style>
        .form__add {
            -webkit-box-align: center;
            -webkit-box-pack: justify;
            align-items: center;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
        }
        .select2.select2-container .select2-selection {
            padding: 5px;
            width: 100% !important;
            height: 46px !important;
            border: 1px solid #dce7f1;
            outline: none !important;
            transition: all .15s ease-in-out;
        }
        .card {
            border-radius: 1px;
        }
            
        
        .card {
            border: none;
            margin-bottom: 24px;
            -webkit-box-shadow: 0 0 13px 0 rgba(236, 236, 241, .44);
            box-shadow: 0 4px 24px 0 rgb(34 41 47 / 10%);
        }
        </style>
@endpush

