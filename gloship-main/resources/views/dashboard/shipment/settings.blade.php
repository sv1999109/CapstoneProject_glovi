@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <form id="form_edit" data-action="{{ route('dashboard.shipments.settings.update') }}" method="post">
        @csrf
        @method('POST')
        <div class="card">
            <div class="card-header">
                <h4 class="fw-bolder"> @lang('messages.Shipment_Settings') </h4>
            </div>
            <div class="card-body">
                {{--  tracking settings --}}
                <div id="tracking">
                    <h6 class="fw-bolder"> @lang('messages.Tracking') </h6>
                    <div class="form-group row">
                        <label class="col-sm-4">{{ __('messages.Tracking_Number_Prefix') }}</label>
                        <div class="col-sm-8">
                            <input type="text" minlength="2" maxlength="5" name="default_tracking_prefix"
                                value="{{ old('default_tracking_prefix', get_config('default_tracking_prefix')) }}"
                                class="form-control @error('default_tracking_prefix') is-invalid @enderror">
                            @error('default_tracking_prefix')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch">
                                <input name="tracking_prefix" class="form-check-input" type="checkbox" value="enabled"
                                    id="tracking_prefix" @if (get_config('tracking_prefix') == 'enabled') checked @endif>
                                <label class="form-check-label" for="tracking_prefix">@lang('messages.Enable')
                                    @lang('messages.Prefix')</label>
                            </div>
                            @error('tracking_prefix')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                </div>
                {{-- / tracking settings --}}

                {{-- Additional cost  settings --}}
                <div id="additional_cost">
                    <h6 class="fw-bolder"> @lang('messages.Additional_Cost') </h6>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4">{{ __('messages.Type') }}</label>
                        <div class="col-sm-8">
                            <select name="additional_cost_type" id="additional_cost_type"
                                class="form-select form-searchx @error('additional_cost_type') is-invalid @enderror">
                                <option value="fixed" @if (get_config('additional_cost_type') == 'fixed') selected @endif>
                                    @lang('messages.Fixed')</option>
                                <option value="percent" @if (get_config('additional_cost_type') == 'percent') selected @endif>
                                    @lang('messages.Percentage') (%)</option>
                            </select>
                            @error('additional_cost_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4" id="additional_cost_type_label">
                            @if (get_config('additional_cost_type') == 'percent')
                                @lang('messages.Percentage')
                            @else
                                @lang('messages.Amount')
                            @endif
                        </label>
                        <div class="col-sm-8">
                            @php
                                $defualt_additional_cost = get_money(get_config('additional_cost_amount'), get_config('additional_cost_currency'), 'input', 'localize');
                                if (get_config('additional_cost_type') == 'percent') {
                                    $defualt_additional_cost = get_config('additional_cost_amount');
                                }
                                $additional_cost_type = get_config('additional_cost_type');

                            @endphp
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="before_additional_cost_type_val">
                                    @if ($additional_cost_type == 'percent')
                                        %
                                    @else
                                        {{ get_currency('symbol') }}
                                    @endif
                                </span>
                                <input type="text" min="0.00" step="any" name="additional_cost_amount"
                                    value="{{ old('additional_cost_amount', $defualt_additional_cost) }}"
                                    class="form-control @error('additional_cost_amount') is-invalid @enderror">
                                <span class="input-group-text" id="additional_cost_type_val">
                                    @if ($additional_cost_type == 'percent')
                                        {{ __('messages.Percent') }}
                                    @else
                                        {{ get_currency('code') }}
                                    @endif
                                </span>
                                @error('additional_cost_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch">
                                <input name="additional_cost" class="form-check-input" type="checkbox" value="enabled"
                                    id="additional_cost" @if (get_config('additional_cost') == 'enabled') checked @endif>
                                <label class="form-check-label" for="additional_cost"> @lang('messages.Enable')
                                    @lang('messages.Additional_Cost')</label>
                            </div>
                            @error('additional_cost')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                </div>
                {{-- / Additional cost settings --}}

                {{-- Tax settings --}}
                <div id="tax">
                    <h6 class="fw-bolder"> @lang('messages.Tax') </h6>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4">{{ __('messages.Type') }}</label>
                        <div class="col-sm-8">
                            <select name="tax_type" id="tax_type"
                                class="form-select form-searchx @error('tax_type') is-invalid @enderror">
                                <option value="fixed" @if (get_config('tax_type') == 'fixed') selected @endif>
                                    @lang('messages.Fixed')</option>
                                <option value="percent" @if (get_config('tax_type') == 'percent') selected @endif>
                                    @lang('messages.Percentage') (%)</option>
                            </select>
                            @error('tax_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4" id="tax_type_label">
                            @if (get_config('tax_type') == 'percent')
                                @lang('messages.Percentage')
                            @else
                                @lang('messages.Amount')
                            @endif
                        </label>
                        <div class="col-sm-8">
                            @php
                                $defualt_tax = get_money(get_config('tax_amount'), get_config('tax_currency'), 'input', 'localize');
                                if (get_config('tax_type') == 'percent') {
                                    $defualt_tax = get_config('tax_amount');
                                }
                                $tax_type = get_config('tax_type');
                                //$tax_amount = get_money(get_config('tax_amount'), get_currency('code'), 'input', 'localize');
                            @endphp
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="before_tax_type_val">
                                    @if ($tax_type == 'percent')
                                        %
                                    @else
                                        {{ get_currency('symbol') }}
                                    @endif
                                </span>
                                <input type="text" min="0.00" step="any" name="tax_amount"
                                    value="{{ old('tax_amount', $defualt_tax) }}"
                                    class="form-control @error('tax_amount') is-invalid @enderror">
                                <span class="input-group-text" id="tax_type_val">
                                    @if ($tax_type == 'percent')
                                        {{ __('messages.Percent') }}
                                    @else
                                        {{ get_currency('code') }}
                                    @endif
                                </span>
                                @error('tax_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch">
                                <input name="tax" class="form-check-input" type="checkbox" value="enabled"
                                    id="tax" @if (get_config('tax') == 'enabled') checked @endif>
                                <label class="form-check-label" for="tax"> @lang('messages.Enable')
                                    @lang('messages.Tax')</label>
                            </div>
                            @error('tax')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                </div>
                {{-- / Tax settings --}}

                {{-- Discount settings --}}
                <div id="discount">
                    <h6 class="fw-bolder"> @lang('messages.Discount') </h6>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4">{{ __('messages.Type') }}</label>
                        <div class="col-sm-8">
                            <select name="discount_type" id="discount_type"
                                class="form-select form-searchx @error('discount_type') is-invalid @enderror">
                                <option value="fixed" @if (get_config('discount_type') == 'fixed') selected @endif>
                                    @lang('messages.Fixed')</option>
                                <option value="percent" @if (get_config('discount_type') == 'percent') selected @endif>
                                    @lang('messages.Percentage') (%)</option>
                            </select>
                            @error('discount_type')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4" id="discount_type_label">
                            @if (get_config('discount_type') == 'percent')
                                @lang('messages.Percentage')
                            @else
                                @lang('messages.Amount')
                            @endif
                        </label>
                        <div class="col-sm-8">
                            @php
                                $defualt_discount = get_money(get_config('discount_amount'), get_config('discount_currency'), 'input', 'localize');
                                if (get_config('discount_type') == 'percent') {
                                    $defualt_discount = get_config('discount_amount');
                                }
                                $discount_type = get_config('discount_type');
                                //$discount_amount = get_money(get_config('discount_amount'), get_currency('code'), 'input', 'localize');
                            @endphp
                            <div class="input-group mb-3">
                                <span class="input-group-text" id="before_discount_type_val">
                                    @if ($discount_type == 'percent')
                                        %
                                    @else
                                        {{ get_currency('symbol') }}
                                    @endif
                                </span>
                                <input type="text" min="0.00" step="any" name="discount_amount"
                                    value="{{ old('discount_amount', $defualt_discount) }}"
                                    class="form-control @error('discount_amount') is-invalid @enderror">
                                <span class="input-group-text" id="discount_type_val">
                                    @if ($discount_type == 'percent')
                                        {{ __('messages.Percent') }}
                                    @else
                                        {{ get_currency('code') }}
                                    @endif
                                </span>
                                @error('discount_amount')
                                    <div class="invalid-feedback">
                                        {{ $message }}
                                    </div>
                                @enderror
                            </div>
                        </div>
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4"></label>
                        <div class="col-sm-8">
                            <div class="form-check form-switch">
                                <input name="discount" class="form-check-input" type="checkbox" value="enabled"
                                    id="discount" @if (get_config('discount') == 'enabled') checked @endif>
                                <label class="form-check-label" for="discount"> @lang('messages.Enable')
                                    @lang('messages.Discount')</label>
                            </div>
                            @error('discount')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <hr>
                </div>
                {{-- / Discount settings --}}

                {{-- / other settings --}}
                <div class="mt-3" id="other">
                    <div class="form-group row mb-3">
                        <label class="col-sm-4">@lang('messages.Default_Shipping_Provider')</label>
                        <div class="col-sm-8">
                            <select class="form-select form-searchx @error('api_provider') is-invalid @enderror"
                                id="api_provider" name="api_provider">
                                @php
                                    $api_provider = get_config('api_provider');
                                @endphp
                                <option value="1" {{ old('api_provider') == '1' ? 'selected' : '' }}
                                    {{ $api_provider == 1 ? 'selected' : '' }}>
                                    {{ get_content_locale(get_config('site_name'), LaravelLocalization::getCurrentLocale()) }}
                                </option>
                                <option value="2" {{ old('api_provider') == '2' ? 'selected' : '' }}
                                    {{ $api_provider == 2 ? 'selected' : '' }}>
                                    Eurosender</option>
                                <option value="3" {{ old('api_provider') == '3' ? 'selected' : '' }}
                                    {{ $api_provider == 3 ? 'selected' : '' }}>
                                    Shippo</option>
                            </select>
                            @error('api_provider')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>

                    </div>
                    <div class="form-group row mt-2 mb-3">

                        <label class="col-sm-4">@lang('Shippo API key')</label>
                        <div class="col-sm-8">
                            <input type="text" name="shippo_key" id="shippo_key" class="form-control"
                                value="{{ get_config('shippo_key') }}">
                            @error('shippo_key')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-2 mb-3">

                        <label class="col-sm-4">@lang('Shippo API Mode')</label>
                        <div class="col-sm-8">
                            <select class="form-select form-searchx @error('shippo_mode') is-invalid @enderror"
                                id="shippo_mode" name="shippo_mode">
                                @php
                                    $shippo_mode = get_config('shippo_mode');
                                @endphp
                                 <option value="false"
                                 {{ $shippo_mode == 'false' ? 'selected' : '' }}>
                                 Live</option>
                                <option value="true" 
                                    {{ $shippo_mode == 'true' ? 'selected' : '' }}>
                                    Test</option>
                               
                            </select>
                           
                        </div>
                    </div>

                    <div class="form-group row mt-2 mb-3">

                        <label class="col-sm-4">@lang('Eurosender API key')</label>
                        <div class="col-sm-8">
                            <input type="text" name="eurosender_key" id="eurosender_key" class="form-control"
                                value="{{ get_config('eurosender_key') }}">
                            @error('eurosender_key')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-2 mb-3" id="main_estimated_days" style="display: none">

                        <label class="col-sm-4">@lang('messages.Estimated_Delivery_Days')</label>
                        <div class="col-sm-8">
                            <input type="number" name="main_estimated_days" id="in_main_estimated_days"
                                class="form-control" value="{{ get_config('main_estimated_days') }}">
                            @error('main_estimated_days')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                    <div class="form-group row mt-2 mb-3">

                        <label class="col-sm-4">@lang('Wise API key')</label>
                        <div class="col-sm-8">
                            <input type="text" name="xrate_key" id="xrate_key" class="form-control"
                                value="{{ get_config('xrate_key') }}">
                            @error('xrate_key')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>


                    <div class="form-group row mb-3">
                        <label class="col-sm-4">@lang('messages.Default') @lang('messages.Payment_Type')</label>
                        <div class="col-sm-8">
                            <select class="form-select form-searchx @error('payment_type') is-invalid @enderror"
                                id="payment_type" name="payment_type">
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
                    </div>
                    <div class="form-group row mb-3">
                        <label class="col-sm-4">@lang('messages.Default')
                            {{ trans_choice('messages.Payment_Method', 1) }}</label>
                        <div class="col-sm-8">
                            <select class="form-select form-searchx @error('payment_method') is-invalid @enderror"
                                name="payment_method">
                                @php
                                    $payment_method = get_config('payment_method');
                                @endphp
                                {{-- Fetch Payment Methods --}}
                                @foreach (DB::table('payment_methods')->orderBy('name', 'asc')->where('status', 1)->get() as $pay)
                                    <option value="{{ $pay->id }}"
                                        {{ $payment_method == $pay->id ? 'selected' : '' }}>
                                        {{ __('messages.' . get_data_db('payment_methods', 'id', $pay->id, 'name')) }}
                                    </option>
                                @endforeach
                            </select>
                            @error('payment_method')
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>

                    <div class="form-group row mt-4 mb-3">
                        <label
                            class="col-sm-4 text-left control-label col-form-label">{{ __('messages.Shipment_Terms') }}</label>
                        <div class="col-sm-8">
                            <ul class="nav nav-tabs" id="langTab" role="tablist">

                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <li class="nav-item" role="presentation">

                                        <button class="nav-link @if ($localeCode == LaravelLocalization::getCurrentLocale()) active @endif"
                                            id="{{ $localeCode }}-tab-a" data-bs-toggle="tab"
                                            data-bs-target="#{{ $localeCode }}-tab" type="button" role="tab"
                                            aria-controls="{{ $localeCode }}-tab"
                                            aria-selected="true">{{ $properties['native'] }}</button>
                                    </li>
                                @endforeach
                            </ul>

                            <div class="tab-contents">
                                @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                                    <div class="tab-pane fade @if ($localeCode == LaravelLocalization::getCurrentLocale()) show active @endif"
                                        id="{{ $localeCode }}-tab" role="tabpanel"
                                        aria-labelledby="{{ $localeCode }}-tab" tabindex="0">
                                        <div class="input-group mb-3">
                                            <button class="btn btn-light" type="button"
                                                aria-expanded="false">{{ $localeCode }}</button>

                                            @php
                                                $shipment_terms = get_content_locale(get_config('shipment_terms'), $localeCode);
                                            @endphp
                                            <textarea rows="5" name="shipment_terms[{{ $localeCode }}]"
                                                class="form-control @error("shipment_terms[$localeCode]") is-invalid @enderror">{{ old("shipment_terms[$localeCode]", isset($shipment_terms) ? $shipment_terms : '') }}</textarea>
                                            @error("shipment_terms[$localeCode]")
                                                <div class="invalid-feedback">
                                                    {{ $message }}
                                                </div>
                                            @enderror

                                        </div>
                                    </div>
                                @endforeach
                            </div>

                        </div>
                    </div>
                </div>
                {{-- / other settings --}}

            </div>
            <div class="card-footer d-flex justify-content-end py-6 px-9">
                <button type="submit" class="btn btn-primary">@lang('messages.Save_Change')</button>
            </div>
        </div>

    </form>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            //Addtional Cost script
            $('#additional_cost_type').change(function() {
                var additional_cost_type = $(this).val();
                if (additional_cost_type == 'percent') {
                    $('#additional_cost_type_val').html("{{ __('messages.Percent') }}");
                    $('#before_additional_cost_type_val').html('%');
                    $('#additional_cost_type_label').html("{{ __('messages.Percentage') }}");
                } else {
                    $('#additional_cost_type_val').html("{{ get_currency('code') }}");
                    $('#before_additional_cost_type_val').html("{{ get_currency('symbol') }}");
                    $('#additional_cost_type_label').html("{{ __('messages.Amount') }}");
                }
            });

            //Tax script
            $('#tax_type').change(function() {
                var tax_type = $(this).val();
                if (tax_type == 'percent') {
                    $('#tax_type_val').html("{{ __('messages.Percent') }}");
                    $('#before_tax_type_val').html('%');
                    $('#tax_type_label').html("{{ __('messages.Percentage') }}");
                } else {
                    $('#tax_type_val').html("{{ get_currency('code') }}");
                    $('#before_tax_type_val').html("{{ get_currency('symbol') }}");
                    $('#tax_type_label').html("{{ __('messages.Amount') }}");
                }
            });

            //Discount script
            $('#discount_type').change(function() {
                var discount_type = $(this).val();
                if (discount_type == 'percent') {
                    $('#discount_type_val').html("{{ __('messages.Percent') }}");
                    $('#before_discount_type_val').html('%');
                    $('#discount_type_label').html("{{ __('messages.Percentage') }}");
                } else {
                    $('#discount_type_val').html("{{ get_currency('code') }}");
                    $('#before_discount_type_val').html("{{ get_currency('symbol') }}");
                    $('#discount_type_label').html("{{ __('messages.Amount') }}");
                }
            });

            $('#api_provider').change(function() {
                var api_provider = $(this).val();
                if (api_provider == '1') {
                    $('#main_estimated_days').show();
                } else {
                    $('#main_estimated_days').hide();
                }
            });

            //start: save script
            $('#form_edit').submit(function(e) {
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

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.shipments.settings.update') }}",
                    data: $form.serialize(),
                    success: save_data,
                    dataType: 'json',
                    error: error_data
                });

            });
            //end: save  data script

        });
    </script>
@endpush
