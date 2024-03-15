{{-- Languages Settings --}}
<div>
    <div class="card-header mb-3">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('messages.Languages_Settings') }}</h3>
        </div>
    </div>
    <hr class="divider">
    <div class="card">
        <div class="card-body">
            {{-- Language Input --}}
            @php
                $default_language = get_config('set_locale');
            @endphp

            <div class="form-group row">
                <label class="col-sm-3 text-left control-label col-form-label required">{{ __('messages.Default_Language') }}</label>
                <div class="col-sm-9">

                    <select name="code" class="form-select @error('set_locale') is-invalid @enderror">
                        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                        <option value="{{ $localeCode }}" @if ($default_language == $localeCode)
                            selected
                        @endif>{{ $properties['native'] }}</option> 
                        @endforeach
                    </select>
                    
                </div>
            </div>
            {{--// Language Input --}}
        </div>
        <div class="card-footer d-flex justify-content-end py-6 px-9">
            <button type="submit" class="btn btn-success">@lang('messages.Save_Change')</button>
        </div>
    </div>
</div>
