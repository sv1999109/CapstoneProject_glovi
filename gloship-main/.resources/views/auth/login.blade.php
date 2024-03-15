@extends('auth.layouts.app')
@section('content')
    <div>
        
        <h3 class="mb-1">@lang('messages.Welcome_to')  <a href="{{ route('home') }}">{{ get_content_locale(get_config('site_name')) }}</a>! 👋</h3>
        <p class="mb-4">@lang('messages.Sign_To')</p>
        @include('auth.layouts.partials.messages')

        {{-- Response --}}
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif

        {{-- form --}}
        <form method="post" action="{{ route('login.perform') }}">
            {{-- csrf --}}
            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

            {{-- input email --}}
            <div class="form-group  mb-4">
                <input id="username" name="username" value="{{ old('username') }}" type="text" class="form-control"
                    placeholder="@lang('messages.Username')" required>

            </div>
            {{-- input password --}}
           
            <div class="mb-3 form-password-toggle">
                <div class="d-flex justify-content-between">
                  <label class="form-label" for="password">Password</label>
                  <a href="{{ route('forget.password.get') }}"><small>@lang('messages.Password_Forgot')</small>
                  </a>
                </div>
                <div class="input-group input-group-merge">
                    <input id="password" name="password" type="password" class="form-control" placeholder="@lang('messages.Password')">
                </div>
            </div>
            {{-- input Keep me logged in --}}

            <div class="mb-3">
                <div class="form-check form-check-lg d-flex align-items-end">
                    <input class="form-check-input me-2" type="checkbox" name="remember" value="true" id="remember_me">
                    <label class="form-check-label " for="remember_me">
                        @lang('messages.Keep_Me_Logged')
                    </label>
                </div>
            </div>
            {{-- submit button --}}
            <button type="submit" class="btn btn-primary d-grid w-100">@lang('messages.Login')</button>
        </form>
        {{-- //form --}}

    </div>
@endsection

@section('content-actions')
    <p class="text-center mt-3">
        @lang('messages.Dont_Have_An_Account')
        <a href="{{ route('register') }}" class="font--bold">
            @lang('messages.Register')
        </a>
    </p>
@endsection
