@extends('auth.layouts.app')
@section('content')

    <div class="auth-content">
        
        <h3 class="mb-1">@lang('messages.Welcome_to')  <a href="{{ route('home') }}">{{ get_content_locale(get_config('site_name')) }}</a>! 👋</h3>
        <p class="mb-4">@lang('messages.Signup_To')</p>
            @include('auth.layouts.partials.messages')
        
        {{-- form --}}
        <form method="post" action="{{ route('register.perform') }}" class="py-4">

            <input type="hidden" name="_token" value="{{ csrf_token() }}" />
            <div class="row g-3">

                <div class="col-12 xp-3">
                    <div class="form-group form-floating mb-3">
                        <input type="text" class="form-control" name="username" value="{{ old('username') }}" placeholder="@lang('messages.Username')" required="required" autofocus>
                        <label for="floatingUsername">@lang('messages.Username')</label>
                        @if ($errors->has('username'))
                            <span class="text-danger text-left">{{ $errors->first('username') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
                        <label for="floatingEmail">@lang('messages.Email')</label>
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>
                    <div class="form-group form-floating mb-3">
                        <input type="tel" id="telephone" class="form-control" value="{{ old('phone') }}" required="required" placeholder="@lang('messages.Phone')">

                        <input type="hidden" id="phone_number" name="phone" value="{{ old('phone', '') }}">
                        @if ($errors->has('phone'))
                            <span class="text-danger text-left">{{ $errors->first('phone') }}</span>
                        @endif
                    </div>
                    <div class="row mb-3">
                    <div class="col-md-6">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control" name="firstname" value="{{ old('firstname') }}" placeholder="@lang('messages.FirstName')" required="required" autofocus>
                        <label for="floatingName">@lang('messages.FirstName')</label>
                        @if ($errors->has('firstname'))
                            <span class="text-danger text-left">{{ $errors->first('firstname') }}</span>
                        @endif
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group form-floating">
                        <input type="text" class="form-control" name="lastname" value="{{ old('lastname') }}" placeholder="@lang('messages.LastName')" required="required" autofocus>
                        <label for="floatingName">@lang('messages.LastName') </label>
                        @if ($errors->has('lastname'))
                            <span class="text-danger text-left">{{ $errors->first('lastname') }}</span>
                        @endif
                    </div>
                    </div>
                    </div>
                    <div class="form-group form-floating mb-3">
                       
                        <select class="form-select form-search" id="sel_country" name="country">
                            <option value="">@lang('messages.Select_Country')</option>
                            @foreach (DB::table('countries')->where('status', 1) ->get() as $item)
                                <option value="{{ __($item->id) }}"
                                    {{ old('country') == $item->id ? 'selected' : '' }}>{{ $item->name }}
                                </option>
                            @endforeach
                        </select>
                        <label
                        class="form-label required">{{ trans_choice('messages.Country', 1) }}</label>
                        @error('country')
                            <div class="invalid-feedback">
                                {{ $message }}
                            </div>
                        @enderror
                    </div>
                   
                    <div class="form-group form-floating mb-3">
                        <input type="password" class="form-control" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                        <label for="floatingPassword">@lang('messages.Password')</label>
                        @if ($errors->has('password'))
                            <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                        @endif
                    </div>

                    <div class="form-group form-floating mb-3">
                        <input type="password" class="form-control" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="@lang('messages.Confirm_Password')" required="required">
                        <label for="floatingConfirmPassword">@lang('messages.Confirm_Password')</label>
                        @if ($errors->has('password_confirmation'))
                            <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                        @endif
                    </div>
                </div>
                

                <div class="col-12">
                    <button class="btn btn-primary w-100 py-3" type="submit">@lang('messages.Register')</button>
                </div>
            </div>
        </form>
        {{-- //form --}}

    </div>
@endsection

@section('content-actions')
    <p class="text-center">
        @lang('messages.Already_Have_Account')
        <a href="{{ route('login') }}" class="font--bold">
            @lang('messages.Login')
        </a>
    </p>
@endsection

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
<script src="https://code.jquery.com/jquery-3.6.1.min.js"
    integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
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
            initialCountry: "auto",

            nationalMode: true,
            separateDialCode: true,
            utilsScript: "{{ asset(get_theme_dir('assets_dashboard')) }}/vendors/intlTelInput/js/utils.js",
        });
        input.addEventListener('blur', function() {
            $('#phone_number').val(intl_telephone.getNumber());
        });
    </script>
@endpush

