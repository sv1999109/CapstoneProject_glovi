@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    $states = DB::table('states')
        ->where('country_id', $area->country_id)
        ->distinct()
        ->get();
    $cities = DB::table('cities')
        ->where('state_id', $area->state_id)
        ->distinct()
        ->get();
    
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="card">
        <form id="area_edit_form" data-action="{{ route('dashboard.area.update', ['id' => $area->id]) }}" class="form"
            method="post">
            @csrf
            @method('POST')
            <div class="card-header">
                <h5 class="card-title">
                    @lang('messages.Edit') {{ trans_choice('messages.Covered_Area', 1) }} : {{ $area->name }}
                </h5>
            </div>
            <div class="card-body">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                                <select class="form-select form-search" id="sel_country" name="country" required>
                                    @foreach ($countries as $item)
                                        <option value="{{ __($item->id) }}"
                                            {{ old('country') == $item->id ? 'selected' : '' }}
                                            @if ($item->id == $area->country_id) selected @endif>{{ $item->name }}</option>
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
                                            @if ($item->id == $area->state_id) selected @endif>{{ __($item->name) }}</option>
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
                                <label class="form-label required">@lang('messages.City_Region')</label>
                                <select id="sel_city" name="city"
                                    class="form-select @error('city') is-invalid @enderror" required>
                                    <option value="">@lang('messages.Select_City')</option>
                                    @foreach ($cities as $item)
                                        <option value="{{ __($item->id) }}"
                                            {{ old('city') == $item->id ? 'selected' : '' }}
                                            @if ($item->id == $area->city_id) selected @endif>{{ __($item->name) }}
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
                                <label for="name" class="form-label required">{{ trans_choice('messages.Area', 1) }}</label>
                                <input type="text" name="name" value="{{ $area->name }}"
                                    class="form-control @error('name') is-invalid @enderror" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group mb-3">
                                <label for="status" class="form-label">@lang('messages.Status')</label>
                                <select name="status" class="form-select">
                                    <option value="1" @if ($area->status == 1) selected @endif>
                                        {{ get_status('', '1') }}</option>
                                    <option value="2" @if ($area->status == 2) selected @endif>
                                        {{ get_status('', '2') }}</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card-footer  d-flex justify-content-end py-6 px-9">
                <a href="{{ route('dashboard.areas') }}"
                    class="btn btn-light btn-active-light-primary me-2">@lang('messages.Back')</a>

                <button type="submit" class="btn btn-success ml-1" ddata-bs-dismiss="card">
                    <span class="save">@lang('messages.Save')</span>
                </button>
            </div>
        </form>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {

            //start: save user data script
            $('#area_edit_form').submit(function(e) {
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

                var area = $('input[name="name"]').val();
                var city = $('input[name="city"]').val();
                var country = $('select[name="country"]').val();
                var state = $('select[name="state"]').val();
                var status = $('select[name="status"]').val();
                //validate input field
                if (area != '' && city != '' && state != '' && country != '' && status != '') {

                    $.ajax({
                        type: "POST",
                        url: "{{ route('dashboard.area.update', ['id' => $area->id]) }}",
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
            //end: save  data script
        });


    </script>
@endpush
