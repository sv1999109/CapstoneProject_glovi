@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    //get origin data
    $origin_states = DB::table('states')
        ->where('country_id', $model->origin_country)
        ->get();
    
    //get destination data
    $destination_states = DB::table('states')
        ->where('country_id', $model->destination_country)
        ->get();
    $destination_cities = DB::table('cities')
        ->where('state_id', $model->destination_state)
        ->get();
    $destination_areas = DB::table('areas')
        ->where('city_id', $model->destination_city)
        ->get();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">
                <div class="card-header">
                    <h5 class="card-title">
                        @lang('messages.Update') @lang('messages.Shipping_Cost') #{{ $model->id }}
                    </h5>
                </div>
                <hr class="divider">

                <form id="save_form" data-action="{{ route('dashboard.shipments.cost.update', ['id' => $model->id]) }}" class="form"
                    method="post">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="row mb-3">
                            {{-- Shipping Origin --}}
                            <h5 class="col-md-12">@lang('messages.Shipping_Origin')</h5>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                                    <select class="form-control @error('origin_country') is-invalid @enderror"
                                        id="sel_country" name="origin_country" required>
                                        <option value="">@lang('messages.Select_Country')</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('origin_country') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $model->origin_country) selected @endif>
                                                {{ country_name($item->id) }}</option>
                                        @endforeach
                                    </select>
                                    @error('origin_country')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group mb-3">
                                    <label class="form-label required">@lang('messages.State_Province')</label>
                                    <select id="sel_state" name="origin_state"
                                        class=" form-select @error('origin_state') is-invalid @enderror" required>
                                        <option value="">@lang('messages.Select_State')</option>
                                        @foreach ($origin_states as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('origin_state') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $model->origin_state) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach

                                    </select>
                                    @error('origin_state')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="ml-4 text-center">
                                <span class="fa fa-arrows-alt-v"></span>
                                <hr>
                            </div>

                            {{-- Shipping Destination --}}
                            <h5 class="col-md-12">@lang('messages.Shipping_Destination')</h5>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                                    <select class="form-control @error('destination_country') is-invalid @enderror"
                                        id="sel_country2" name="destination_country" required>
                                        <option value="">@lang('messages.Select_Country')</option>
                                        @foreach ($countries as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('destination_country') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $model->destination_country) selected @endif>
                                                {{ country_name($item->id) }}</option>
                                        @endforeach
                                    </select>
                                    @error('destination_country')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label required">@lang('messages.State_Province')</label>
                                    <select id="sel_state2" name="destination_state"
                                        class=" form-select @error('destination_state') is-invalid @enderror" required>
                                        <option value="">@lang('messages.Select_State')</option>
                                        @foreach ($destination_states as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('destination_state') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $model->destination_state) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('destination_state')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label required">@lang('messages.City_Region')</label>
                                    <select id="sel_city2" name="destination_city"
                                        class="form-select @error('destination_city') is-invalid @enderror">
                                        <option value="">@lang('messages.Select_City')</option>
                                        @foreach ($destination_cities as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('destination_city') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $model->destination_city) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('destination_city')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="form-group mb-3">
                                    <label class="form-label">{{ trans_choice('messages.Area', 1) }}</label>
                                    <select id="sel_area2" name="destination_area"
                                        class="form-select @error('destination_area') is-invalid @enderror">
                                        <option value="">@lang('messages.Select_Area')</option>
                                        @foreach ($destination_areas as $item)
                                            <option value="{{ __($item->id) }}"
                                                {{ old('destination_area') == $item->id ? 'selected' : '' }}
                                                @if ($item->id == $model->destination_area) selected @endif>{{ __($item->name) }}
                                            </option>
                                        @endforeach
                                    </select>
                                    @error('destination_area')
                                        <div class="invalid-feedback">
                                            {{ $message }}
                                        </div>
                                    @enderror
                                </div>
                            </div>
                        </div>

                        <hr class="divider mb-5">
                        <div data-style="margin: auto; float:none; max-width: 900px;">
                            <div class="row">
                                <h5 class="mb-2 required">@lang('messages.Weight') @lang('messages.Range')</h5>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">@lang('messages.From')</span>
                                            <input type="number" name="weight_from"
                                                value="{{ old('weight_from', isset($model) ? $model->weight_from : '') }}"
                                                class="form-control" required>
                                            <span class="input-group-text">@lang('messages.KG')</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group">
                                        <div class="input-group mb-3">
                                            <span class="input-group-text">@lang('messages.To')</span>
                                            <input type="number" name="weight_to"
                                                value="{{ old('weight_to', isset($model) ? $model->weight_to : '') }}"
                                                class="form-control" required>
                                            <span class="input-group-text">@lang('messages.KG')</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h5 class="mb-2 required">@lang('messages.Shipping_Cost')</h5>
                                    <div class="form-group row">
                                        <div class="col-sm-12">
                                            <div class="input-group mb-3">
                                                <span
                                                    class="input-group-text">{{ get_money('0', $model->currency, 'only_symbol', 'localize') }}</span>
                                                <input type="number" name="amount" class="form-control"
                                                    value="{{ old('amount', isset($model) ? get_money($model->amount, $model->currency, 'input', 'localize') : '') }}"
                                                    min="1" step="any" required>
                                                <span
                                                    class="input-group-text">{{ get_money('0', $model->currency, 'only_code', 'localize') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <div class="form-group mb-3">
                                        <h5 class="mb-2 required">@lang('messages.Status')</h5>
                                        <select name="status" class="form-select">
                                            <option value="1" @if ($model->status == 1) selected @endif>
                                                {{ get_status('', '1') }}</option>
                                            <option value="2" @if ($model->status == 2) selected @endif>
                                                {{ get_status('', '2') }}</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-footer  d-flex justify-content-end py-6 px-9">
                        <a href="{{ route('dashboard.shipments.cost') }}"
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
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet"
        href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" />
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    <script type='text/javascript'>
        //Countries, States, Cities, Areas form helper
        $(document).ready(function() {
            $('#sel_country2').select2();
            $('#sel_state2').select2();
            $('#sel_city2').select2();
            $('#sel_area2').select2();

            // fetch states
            $('#sel_country2').change(function() {
                var id = $(this).val();
                // Empty the dropdown
                $('#sel_state2').find('option').not(':first').remove();
                $('#sel_state2').attr('disabled', true);
                $('#sel_city2').find('option').not(':first').remove();
                // AJAX request 
                $.ajax({
                    url: '{{ url('dashboard/address/getstates') }}/' + id,
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
                    url: '{{ url('dashboard/address/getcity') }}/' + id,
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

            // fetch areas
            $('#sel_city2').change(function() {
                var id = $(this).val();

                // Empty the dropdown
                $('#sel_area2').find('option').not(':first').remove();
                $('#sel_area2').attr('disabled', true);

                // AJAX request 
                $.ajax({
                    url: '{{ url('dashboard/address/getarea') }}/' + id,
                    type: 'get',
                    dataType: 'json',
                    success: function(response) {
                        $('#sel_area2').find('option').not(':first').remove();
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

                                $("#sel_area2").append(option);
                            }

                            $('#sel_area2').attr('disabled', false);
                        }

                    }
                });
            });


        });
    </script>

    <script>
        $(document).ready(function() {

            //start: save data script
            $('#save_form').submit(function(e) {
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

                var origin_country = $('select[name="origin_country"]').val();
                var origin_state = $('select[name="origin_state"]').val();
                var destination_country = $('select[name="destination_country"]').val();
                var destination_state = $('select[name="destination_state"]').val();
                var weight_from = $('input[name="weight_from"]').val();
                var weight_to = $('input[name="weight_to"]').val();
                var amount = $('input[name="amount"]').val();
                //validate input field
                if (origin_country != '' && origin_state != '' && destination_country != '' &&
                    destination_state != '' && weight_from != '' && weight_to != '' && amount != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.shipments.cost.update', ['id' => $model->id]) }}",
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
