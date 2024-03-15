@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card">
        <div class="card-header">
            <h5 class="card-title">@lang('messages.Add_New') @lang('messages.Shipping_Cost')</h5>
        </div>
        <hr class="divider">
        <form id="create_form" data-action="" class="form" method="post">
            @csrf
            @method('POST')
            <div class="card-body">
                <div class="row mb-3">
                    {{-- Shipping Origin --}}
                    <h5 class="col-md-12">@lang('messages.Shipping_Origin')</h5>
                    <div class="col-md-6">
                        <div class="form-group mb-3">
                            <label class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                            <select class="form-control @error('origin_country') is-invalid @enderror" id="sel_country"
                                name="origin_country" required>
                                <option value="">@lang('messages.Select_Country')</option>
                                @foreach ($countries as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}
                                    </option>
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
                                    <option value="{{ $item->id }}">{{ $item->name }}
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
                    <div class="col-md-3">
                        <div class="form-group mb-3">
                            <label class="form-label required">@lang('messages.State_Province')</label>
                            <select id="sel_state2" name="destination_state"
                                class="form-select @error('destination_state') is-invalid @enderror" required>
                                <option value="">@lang('messages.Select_State')</option>

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
                            <label class="form-label">@lang('messages.City_Region')</label>
                            <select id="sel_city2" name="destination_city"
                                class="form-select @error('destination_city') is-invalid @enderror">
                                <option value="">@lang('messages.Select_City')</option>
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
                <div style="margin: auto; float:none; max-width: 900px;">
                    <div class="row">
                        <h5 class="mb-2 required">@lang('messages.Weight') @lang('messages.Range')</h5>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">@lang('messages.From')</span>
                                    <input type="number" name="weight_from" value="1" class="form-control">
                                    <span class="input-group-text">@lang('messages.KG')</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-6 mb-3">
                            <div class="form-group">
                                <div class="input-group mb-3">
                                    <span class="input-group-text">@lang('messages.To')</span>
                                    <input type="number" name="weight_to" value="5" class="form-control" required>
                                    <span class="input-group-text">@lang('messages.KG')</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <h5 class="mb-2 required">@lang('messages.Shipping_Cost')</h5>
                    <div class="form-group row">
                        <div class="col-sm-6">
                            @php
                                $defualt_cost = get_money(get_config('default_shipping_cost'), get_config('default_shipping_cost_currency'), 'input', 'localize');
                            @endphp
                            <div class="input-group mb-3">
                                <span class="input-group-text">{{ get_money('0', get_config('default_shipping_cost_currency'), 'only_symbol', 'localize') }}</span>
                                <input type="text" name="amount" class="form-control"
                                    value="{{ old('amount', $defualt_cost) }}" min="0.01" step="any" required>
                                <span
                                    class="input-group-text">{{ get_money('0', get_config('default_shipping_cost_currency'), 'only_code', 'localize') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer  d-flex justify-content-end py-6 px-9">
                <a href="{{ route('dashboard.shipments.cost') }}"
                    class="btn btn-light btn-active-light-primary me-2">@lang('messages.Cancel')</a>
                <button type="submit" class="btn btn-success ml-1">
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
            $('#create_form').submit(function(e) {
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
                        url: "",
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
            //end: save data script
        });
    </script>
@endpush
