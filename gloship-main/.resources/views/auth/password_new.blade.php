@extends('auth.layouts.app')
@section('content')
    <div class="auth-content">
        <h2 class="auth-titleX mb-5">@lang('messages.New_Password')</h2>
        @include('auth.layouts.partials.messages')

        {{-- Response --}}
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif
        
        {{-- form --}}
        <form action="{{ route('reset.password.post') }}" method="POST">
            @csrf
            <input type="hidden" name="token" value="{{ $token }}">
            <div class="form-group form-floating mb-3">
                <input type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{ old('email') }}" placeholder="name@example.com" required="required" autofocus>
                <label for="floatingEmail">@lang('messages.Email')</label>
                @if ($errors->has('email'))
                    <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input type="password" class="form-control @error('password') is-invalid @enderror" name="password" value="{{ old('password') }}" placeholder="Password" required="required">
                <label for="floatingPassword">@lang('messages.Password')</label>
                @if ($errors->has('password'))
                    <span class="text-danger text-left">{{ $errors->first('password') }}</span>
                @endif
            </div>

            <div class="form-group form-floating mb-3">
                <input type="password" class="form-control @error('password_confirmation') is-invalid @enderror" name="password_confirmation" value="{{ old('password_confirmation') }}" placeholder="@lang('messages.Confirm_Password')" required="required">
                <label for="floatingConfirmPassword">@lang('messages.Confirm_Password')</label>
                @if ($errors->has('password_confirmation'))
                    <span class="text-danger text-left">{{ $errors->first('password_confirmation') }}</span>
                @endif
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary d-grid w-100">
                   @lang('messages.Update')
                </button>
            </div>
        </form>
        {{-- //form --}}
        <p class="text-gray-600 mt-5">
            @lang('messages.Or')
            <a href="{{ route('login') }}" class="font--bold">
                @lang('messages.Login')
            </a>
        </p>

    </div>
@endsection
