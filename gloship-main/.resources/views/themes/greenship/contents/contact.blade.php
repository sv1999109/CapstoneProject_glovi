@extends(get_theme_dir('layouts.app'))
@section('content')
@include(get_theme_dir('layouts.partials.page-heading-empty'))
    <!-- Contact Start -->
    <div class="container-xxl py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 600px;">
                <h1 class="mb-3">@lang('messages.Contact_Title')</h1>
                <p class="mb-1">@lang('messages.Contact_Subtitle')</p>
            </div>
            <div class="row g-5">
                <div class="col-lg-7 col-md-6">
                    <div class="wow fadeInUp" data-wow-delay="0.2s">


                        {{-- Response --}}
                        @if (isset($errors) && count($errors) > 0)
                            <div class="alert alert-danger" role="alert">
                                <ul class="list-unstyled mb-0">
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (Session::has('message'))
                            <div class="alert alert-success" role="alert">
                                {{ Session::get('message') }}
                            </div>
                        @endif
                        @if (Session::has('message') != true)
                            <form method="post">
                                @method('POST')
                                @csrf
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="name" name="name"
                                                required>
                                            <label for="name">{{ trans_choice('messages.Name', 1) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-floating">
                                            <input type="email" class="form-control" id="email" name="email"
                                                required>
                                            <label for="email">{{ trans_choice('messages.Email', 1) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <input type="text" class="form-control" id="subject" name="subject"
                                                required>
                                            <label for="subject">{{ trans_choice('messages.Subject', 1) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="form-floating">
                                            <textarea class="form-control" id="message" name="message" style="height: 150px" required></textarea>
                                            <label for="message">{{ trans_choice('messages.Message', 1) }}</label>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-primary w-100 py-3"
                                            type="submit">{{ trans_choice('messages.Submit', 1) }}</button>
                                    </div>
                                </div>
                            </form>
                        @endif

                    </div>
                </div>
                <div class="col-lg-5 col-md-6 wow fadeInUp" data-wow-delay="0.5s">
                    <div class="section-title position-relative mx-auto mb-4 pb-4">
                        <h3 class="fw-bold mb-0">{{ trans_choice('messages.Customer_Support', 1) }}</h3>
                    </div>
                    @if (get_config('site_head_office'))
                       <div class="card mb-3">
                        <p class="py-3 px-3"><i
                            class="fa fa-map-marker-alt  fa-2x text-primary me-3"></i>{{ get_config('site_head_office') }}</p>
                       </div>
                    @endif
                    @if (get_config('site_phone'))

                    <div class="card mb-3">
                        <p class="py-3 px-3"><i class="fa fa-phone-alt  fa-2x text-primary me-3"></i>{{ get_config('site_phone') }}
                        </p>
                      </div>
                    @endif
                    @if (get_config('site_email_support'))
                    <div class="card mb-3">
                        <p class="py-3 px-3">
                            <span class=""><i
                                class="bi bi-envelope me-3 text-primary fa-2x"></i></span> 
                            <span class=" float-center">{{ get_config('site_email_support') }}</span> 
                        </p>
                    </div>
                    @endif
                    @if (get_config('live_chat_embed'))
                        <div class="card rounded text-center px-4 mt-4">
                            <h3 class="fw-bold mb-4">{{ trans_choice('messages.Need_Any_Help', 1) }}</h3>
                            <a class="btn btn-primary py-3 px-5" href="{{ get_config('live_chat_embed') }}"
                                target="_blank">{{ trans_choice('messages.Let_Chat', 1) }}</a>
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Contact End -->
@endsection
