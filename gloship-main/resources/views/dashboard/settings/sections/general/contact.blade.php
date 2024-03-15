{{-- Contacts Settings --}}
<div role="tabpanel" class="tab-pane fade  @if ($type == 'contacts') show active @endif" id="contacts" aria-labelledby="settings-contacts-tab">
    <div class="card-header mb-3">
        <div class="card-title m-0">
            <h3 class="fw-bolder m-0">{{ trans_choice('messages.Contact', 2) }} {{ __('messages.Info') }}</h3>
        </div>
    </div>
    <hr class="divider">
    <div class="card">
        <div class="card-body">
            {{-- Support Email Input --}}
            @php
                $site_email_support = get_config('site_email_support');
            @endphp
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Support_Email') }}</label>
                <div class="col-sm-9">
                    <input type="email" name="site_email_support" value="{{ old('site_email_support', isset($site_email_support) ?  $site_email_support : '') }}"
                        class="form-control @error('site_email_support') is-invalid @enderror"
                        placeholder="">
                </div>
            </div>

            {{-- Site Phone Input --}}
            @php
                $site_phone = get_config('site_phone');
            @endphp
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-left control-label col-form-label">{{ __('messages.Customer_Help_Line') }}</label>
                <div class="col-sm-9">
                    <input type="text" id="telephone" value="{{ old('site_phone', isset($site_phone) ?   $site_phone : '') }}" class="form-control @error('site_phone') is-invalid @enderror" placeholder="">

                    <input type="hidden" id="phone_number" name="site_phone" value="{{ old('site_phone', isset($site_phone) ?   $site_phone : '') }}">
                </div>
            </div>

            {{-- Head Office Address Input --}}
            @php
                $site_head_office = get_config('site_head_office');
            @endphp
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-left control-label col-form-label">{{__('messages.Head_Office_Address')}}</label>
                <div class="col-sm-9">
                    <input type="text" name="site_head_office" value="{{ old('site_head_office', isset($site_head_office) ?   $site_head_office : '') }}"
                        class="form-control @error('site_head_office') is-invalid @enderror">
                </div>
            </div>

            {{-- Live chat Input --}}
            <div class="form-group row mb-3">
                <label class="col-sm-3 text-left control-label col-form-label">{{__("messages.Livechat")}} (URL) </label>
                <div class="col-sm-9">
                    <input type="url" name="live_chat_embed" value="{{ get_config('live_chat_embed') }}"
                        class="form-control">
                </div>
            </div>

        </div>
    </div>
</div>
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
@endpush
