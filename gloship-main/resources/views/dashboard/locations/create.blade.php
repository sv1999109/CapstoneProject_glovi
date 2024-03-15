@php
    $countries = DB::table('countries')
        ->where('status', 1)
        ->get();
    
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="row">
        <div class="col-md-12x">
            <div class="card">
                <div class="card-header mb-3">
                    <h5 class="card-title">{{ $page_title }}</h5>
                </div>

                <form id="create_form" data-action="{{ route('dashboard.location.create', ['type' => $type]) }}" class="form" method="post">
                    @csrf
                    @method('POST')
                    <div class="card-body">
                        <div class="col-md-12">

                            @if ($type == 'country')
                                <div class="col-md-6" style="float: none; margin: auto;">
                                    <div class="form-group mb-3">
                                        <label for="name" class="form-label required">@lang('messages.Name')</label>
                                        <input type="text" name="name" value="{{ old('name', '') }}"
                                            class="form-control @error('name') is-invalid @enderror" required>
                                    </div>

                                    <div class="form-group mb-3">
                                        <label for="iso2"
                                            class="form-label text-uppercase required">@lang('iso2')</label>
                                        <input type="text" name="iso2" value="{{ old('iso2', '') }}" maxlength="2"
                                            class="form-control @error('iso2') is-invalid @enderror" required>
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="iso3"
                                            class="form-label text-uppercase optional">@lang('iso3')</label>
                                        <input type="text" name="iso3" value="{{ old('iso3', '') }}" maxlength="3"
                                            class="form-control @error('iso3') is-invalid @enderror">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="phone_code"
                                            class="form-label text-uppercase optional">@lang('messages.Phone_Code')</label>
                                        <input type="number" name="phone_code" value="{{ old('phone_code', '') }}"
                                            class="form-control @error('phone_code') is-invalid @enderror">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="region" class="form-label optional">@lang('messages.Region')</label>
                                        <input type="text" name="region" value="{{ old('region', '') }}" maxlength="3"
                                            class="form-control @error('region') is-invalid @enderror">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="subregion" class="form-label optional">@lang('messages.Subregion')</label>
                                        <input type="text" name="subregion" value="{{ old('subregion', '') }}"
                                            maxlength="3" class="form-control @error('subregion') is-invalid @enderror">
                                    </div>
                                    <div class="form-group mb-3">
                                        <label for="status" class="form-label">@lang('messages.Status')</label>
                                        <select name="status" class="form-select">
                                            <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                                                {{ get_status('', '1') }}</option>
                                            <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>
                                                {{ get_status('', '2') }}</option>
                                        </select>
                                    </div>
                                </div>
                            @endif

                            @if ($type == 'state' || $type == 'city')
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>

                                            <select class="form-select form-search" id="sel_country" name="country">
                                                <option value="">@lang('messages.Select_Country')</option>
                                                @foreach ($countries as $item)
                                                    <option value="{{ __($item->id) }}"
                                                        {{ old('country') == $item->id ? 'selected' : '' }}>
                                                        {{ $item->name }}
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

                                    @if ($type == 'state')
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label required">{{ trans_choice('messages.State', 1) }}
                                                    @lang('messages.Name')</label>
                                                <input type="text" name="name" value="{{ old('name', '') }}"
                                                    class="form-control @error('name') is-invalid @enderror" required>
                                            </div>
                                        </div>
                                    @endif

                                    @if ($type == 'city')
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
                                    @endif

                                </div>
                                <div class="row">
                                    @if ($type == 'city')
                                        <div class="col-md-6">
                                            <div class="form-group mb-3">
                                                <label for="name" class="form-label required">{{ trans_choice('messages.City', 1) }}
                                                    @lang('messages.Name')</label>
                                                <input type="text" name="name" value="{{ old('name', '') }}"
                                                    class="form-control @error('name') is-invalid @enderror" required>
                                            </div>
                                        </div>
                                    @endif

                                    <div class="col-md-6">
                                        <div class="form-group mb-3">
                                            <label for="native" class="form-label">@lang('messages.Status')</label>
                                            <select name="status" class="form-select">
                                                <option value="1" {{ old('status') == 1 ? 'selected' : '' }}>
                                                    {{ get_status('', '1') }}</option>
                                                <option value="2" {{ old('status') == 2 ? 'selected' : '' }}>
                                                    {{ get_status('', '2') }}</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                    <div class="card-footer  d-flex justify-content-end py-6 px-9">
                        <a href="{{ url()->previous() }}"
                            class="btn btn-light btn-active-light-primary me-2">@lang('messages.Back')</a>

                        <button type="submit" class="btn btn-primary ml-1">
                            <span class="save">@lang('messages.Save')</span>
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {

            //start: create data script
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

                $.ajax({
                    type: "POST",
                    url: "{{ route('dashboard.location.create', ['type' => $type]) }}",
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

            });
            //end: create data script
        });
    </script>
@endpush
