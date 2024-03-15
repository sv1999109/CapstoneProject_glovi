{{-- Basic Info Panel --}}
<div role="tabpanel" class="tab-pane fade  @if ($type == 'general') show active @endif" id="general"
    aria-labelledby="settings-general-tab">
    <div class="card-header mb-3">

        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('messages.Basic_Info') }}</h3>
        </div>
    </div>
    <hr class="divider">
    {{-- locale switch for basic info settings tab --}}
    <ul class="nav nav-tabs" id="langTab" role="tablist">

        @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
            <li class="nav-item" role="presentation">

                <button class="nav-link @if ($localeCode == LaravelLocalization::getCurrentLocale()) active @endif" id="{{ $localeCode }}-tab-a"
                    data-bs-toggle="tab" data-bs-target="#{{ $localeCode }}-tab" type="button" role="tab"
                    aria-controls="{{ $localeCode }}-tab" aria-selected="true">{{ $properties['native'] }}</button>

            </li>
        @endforeach
    </ul>
    {{-- // locale switch for basic info settings tab --}}
    {{-- .card --}}
    <div class="card">
        <div class="card-body">

            @foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties)
                <div class="tab-pane fade @if ($localeCode == LaravelLocalization::getCurrentLocale()) show active @endif"
                    id="{{ $localeCode }}-tab" role="tabpanel" aria-labelledby="{{ $localeCode }}-tab"
                    tabindex="0">

                    {{-- Site Name Input --}}
                    @php
                        $site_name = get_content_locale(get_config('site_name'), $localeCode);
                        $old_value = old("site_name[$localeCode]", isset($site_name) ? $site_name : '');
                    @endphp
                    <div class="form-group row mb-3">
                        <label
                            class="col-sm-3 text-left control-label col-form-label required">{{ __('messages.Site_Name') }}</label>
                        <div class="col-sm-9 input-item input-with-label">
                            <div class="input-group mb-3">
                                <button class="btn btn-light" type="button"
                                    aria-expanded="false">{{ $localeCode }}</button>
                                <input type="text" name="site_name[{{ $localeCode }}]"
                                    value="<?= old("site_name[$localeCode]", isset($site_name) ? $site_name : '' ) ?>"
                                class="form-control @error("site_name[$localeCode]")
                                is-invalid
                            @enderror"
                            placeholder="">
                            @error("site_name[$localeCode]")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                </div>

                {{-- Tagline Input --}}
                @php
                    $site_tagline = get_content_locale(get_config('site_tagline'), $localeCode);
                @endphp
                <div class="form-group row mb-3">
                    <label
                        class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Tagline') }}</label>
                    <div class="col-sm-9 input-item input-with-label">

                        <div class="input-group mb-3">
                            <button class="btn btn-light" type="button"
                                aria-expanded="false">{{ $localeCode }}</button>
                            <input type="text" name="site_tagline[{{ $localeCode }}]"
                                value="{{ old("site_tagline[$localeCode]", isset($site_tagline) ? $site_tagline : '') }}"
                                class="form-control @error("site_tagline[$localeCode]") is-invalid @enderror"
                                placeholder="">
                            @error("site_tagline[$localeCode]")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Site Description Input --}}
                @php
                    $site_description = get_content_locale(get_config('site_description'), $localeCode);
                @endphp
                <div class="form-group row">
                    <label
                        class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Site_Description') }}</label>
                    <div class="col-sm-9 input-item input-with-label">
                        <div class="input-group mb-3">
                            <button class="btn btn-light" type="button"
                                aria-expanded="false">{{ $localeCode }}</button>
                            <textarea name="site_description[{{ $localeCode }}]"
                                class="form-control @error('site_description') is-invalid @enderror">{{ old("site_description[$localeCode]", isset($site_description) ? $site_description : '') }}</textarea>
                            @error("site_description[$localeCode]")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>

                {{-- Annoucement Input --}}
                @php
                    $site_announcement = get_content_locale(get_config('site_announcement'), $localeCode);
                @endphp
                <div class="form-group row">
                    <label
                        class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Annoucement') }}</label>
                    <div class="col-sm-9 input-item input-with-label">
                        <div class="bbcode"></div>
                        <div class="input-group mb-3">
                            <button class="btn btn-light" type="button"
                                aria-expanded="false">{{ $localeCode }}</button>
                            <textarea name="site_announcement[{{ $localeCode }}]"
                                class="form-control @error("site_announcement[$localeCode]") is-invalid @enderror">{{ old("site_announcement[$localeCode]", isset($site_announcement) ? $site_announcement : '') }}</textarea>
                            @error("site_announcement[$localeCode]")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror

                        </div>
                    </div>
                </div>

                {{-- Copyright Note Input --}}
                @php
                    $site_copyright = get_content_locale(get_config('site_copyright'), $localeCode);
                @endphp
                <div class="form-group row">
                    <label
                        class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Copyright_Note') }}</label>
                    <div class="col-sm-9 input-item input-with-label">
                        <div class="input-group mb-3">
                            <button class="btn btn-light" type="button"
                                aria-expanded="false">{{ $localeCode }}</button>
                            <textarea name="site_copyright[{{ $localeCode }}]" class="form-control">{{ old("site_copyright[$localeCode]", isset($site_copyright) ? $site_copyright : '') }}</textarea>
                            @error("site_copyright[$localeCode]")
                                <div class="invalid-feedback">
                                    {{ $message }}
                                </div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>
        @endforeach

        <div class="form-group row mb-3">
            <label
                class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Default_Timezone') }}</label>
            <div class="col-sm-9 input-item input-with-label">
                <div class="form-group mb-3">
                    <select class="form-control form-search" name="timezone" id="timezone">
                        @foreach (Helpers::getTimeZoneList() as $timezone => $timezone_gmt_diff)
                            <option value="{{ $timezone }}"
                                {{ $timezone === old('timezone', get_config('timezone'), 'name') ? 'selected' : '' }}>
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
        </div>
    </div>
</div>
{{-- // .card --}}
</div>
{{-- // Basic Info --}}
