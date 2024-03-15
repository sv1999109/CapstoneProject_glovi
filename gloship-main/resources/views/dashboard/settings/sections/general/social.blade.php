{{-- Socials Media Settings --}}
<div class="tab-pane fade  @if ($type == 'social') show active @endif" id="social">
    <div class="card-header mb-3">

        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ __('messages.Social') }} {{ __('messages.Info') }}</h3>
        </div>
    </div>
    <hr class="divider">

    <div class="card">
        <div class="card-body">
            <div class="form-group row">
                <div class="col-md-6">
                    {{-- telegram link link Input --}}
                    @php
                       $telegram_link = get_config('telegram_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">Telegram </label>
                        <input type="text" name="telegram_link"
                            value="{{ old('telegram_link', isset($telegram_link) ? $telegram_link : '') }}"
                            class="form-control @error('telegram_link') is-invalid @enderror" placeholder="">
                        @error('telegram_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <div class="col-md-6">
                    {{-- telegram link link Input --}}
                    @php
                       $instagram_link = get_config('instagram_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">Instagram</label>
                        <input type="text" name="instagram_link"
                            value="{{ old('site_phone', isset($instagram_link) ? $instagram_link : '') }}"
                            class="form-control @error('instagram_link') is-invalid @enderror" placeholder="">
                        @error('instagram_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <!-- .col -->
            </div>
            <!-- .row -->
            <div class="form-group row">
                <div class="col-md-6">
                    {{-- telegram link link Input --}}
                    @php
                       $facebook_link = get_config('facebook_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">Facebook </label>
                        <input type="text" name="facebook_link"
                            value="{{ old('facebook_link', isset($facebook_link) ? $facebook_link : '') }}"
                            class="form-control @error('facebook_link') is-invalid @enderror" placeholder="">
                        @error('facebook_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <!-- .col -->
                <div class="col-md-6">
                    {{-- telegram link link Input --}}
                    @php
                       $twitter_link = get_config('twitter_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">Twitter</label>
                        <input type="text" name="twitter_link"
                            value="{{ old('twitter_link', isset($twitter_link) ? $twitter_link : '') }}"
                            class="form-control @error('twitter_link') is-invalid @enderror" placeholder="">
                        @error('twitter_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <!-- .col -->

            </div>
            <div class="form-group row">
                <div class="col-md-6">
                    
                    {{-- youtube link Input --}}
                    @php
                       $youtube_link = get_config('youtube_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">Youtube </label>
                        <input type="text" name="youtube_link"
                            value="{{ old('youtube_link', isset($youtube_link) ? $youtube_link : '') }}"
                            class="form-control @error('youtube_link') is-invalid @enderror" placeholder="">
                        @error('youtube_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <!-- .col -->
                <div class="col-md-6">
                    {{-- whatsapp link Input --}}
                    @php
                       $whatsapp_link = get_config('whatsapp_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">Whatsapp</label>
                        <input type="text" name="whatsapp_link"
                            value="{{ old('whatsapp_link', isset($whatsapp_link) ? $whatsapp_link : '') }}"
                            class="form-control @error('whatsapp_link') is-invalid @enderror" placeholder="">
                        @error('whatsapp_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <!-- .col -->
                <div class="col-md-6">
                    {{-- whatsapp link Input --}}
                    @php
                       $linkedin_link = get_config('linkedin_link');
                    @endphp
                    <div class="input-item input-with-label">
                        <label class="input-item-label">LinkedIn</label>
                        <input type="text" name="linkedin_link"
                            value="{{ old('whatsapp_link', isset($linkedin_link) ? $linkedin_link : '') }}"
                            class="form-control @error('whatsapp_link') is-invalid @enderror" placeholder="">
                        @error('linkedin_link')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                    <!-- .input-item -->
                </div>
                <!-- .col -->

            </div>
            <!-- .row -->
        </div>
    </div>


</div>
