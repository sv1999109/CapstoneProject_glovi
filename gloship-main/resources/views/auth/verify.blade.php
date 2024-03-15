@extends('auth.layouts.app')
@section('content')
    <div class="auth-content">
        <h2 class="auth-titleX mb-5 mt-4">{{ trans_choice('messages.Verification', 1) }}</h2>
        @include('auth.layouts.partials.messages')

        {{-- Response --}}
        @if (Session::has('message'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('message') }}
            </div>
        @endif

        {{-- form --}}
        @if (!Session::has('verified'))
            @if (isset($errors))
                <form action="{{ route('user.verify.resend') }}" method="POST">
                    @csrf
                    <div class="form-group form-floating mb-3">
                        <input type="email" class="form-control" name="email" value="{{ old('email') }}"
                            placeholder="name@example.com" required="required" autofocus>
                        <label for="floatingEmail">@lang('messages.Email')</label>
                        @if ($errors->has('email'))
                            <span class="text-danger text-left">{{ $errors->first('email') }}</span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button type="submit"
                            class="btn btn-primary d-grid w-100">@lang('messages.Resend_Link')</button>
                    </div>
                </form>
            @endif
        @endif


        {{-- //form --}}

    </div>
@endsection
