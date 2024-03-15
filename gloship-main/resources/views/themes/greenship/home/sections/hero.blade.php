<!-- ========== Start hero Section ========== -->
<div id="hero-section" class="hero-section">
    <div class="hero-wrapper call-to-action-below h-100">
        <div class="hero-vector"><img src="{{ asset('assets/img/hero-vector.svg') }}" alt="hero vector">
        </div>
        <div class="container">
            <div class="row mt-4 mb-5  hero-center">
                <div class="col-lg-12 call-to-action-invite">
                    <h1 class="typed-result text-bold text-capitalize"></h1>
                    <h1 class="text-bold text-capitalize typed-text" style="display: none">
                        {{ get_content_locale(get_contents('home_hero_title')) }},, {!! nl2br(get_content_locale(get_contents('home_hero_desc'))) !!}</h1>

                </div>
                <div class="col-lg-12 call-to-action-button mt-5">
                    <form action="{{ route('tracking') }}">
                        <div class="card border-primary justify-content-center text-center tracking-section">

                            <div class="card-body px-lg-4 ">
                              
                                <div class="form-group mb-3">
                                    <input style=" border-radius: 8px; font-size: 12px;" type="text" name="code"
                                        class="form-control form-control-lg text-center box-shadow"
                                        placeholder="@lang('messages.Tracking_Number_Input')" required>

                                </div>

                            </div>
                        </div>

                        <div class="mt-3">
                            <button class="btn btn-blue btn-block w-100"><span class="me-3">@lang('messages.Track')
                                </span><i class="fa fa-chevron-circle-right"></i></button>
                        </div>
                    </form>

                </div>

            </div>
            <div class="row styles-pills mt-4 hero-center">

                <div class="hero-below-div mb-2 col-md-4">
                    <div class="hero-span"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check"
                            class="svg-inline--fa fa-check hero-span-svg" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor"
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z">
                            </path>
                        </svg>Easy ordering</div>
                </div>
                <div class="hero-below-div mb-2 col-md-4">
                    <div class="hero-span"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check"
                            class="svg-inline--fa fa-check hero-span-svg" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor"
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z">
                            </path>
                        </svg>Multiple carriers</div>
                </div>
                <div class="hero-below-div mb-2 col-md-4">
                    <div class="hero-span"><svg aria-hidden="true" focusable="false" data-prefix="fas" data-icon="check"
                            class="svg-inline--fa fa-check hero-span-svg" role="img"
                            xmlns="http://www.w3.org/2000/svg" viewBox="0 0 448 512">
                            <path fill="currentColor"
                                d="M438.6 105.4c12.5 12.5 12.5 32.8 0 45.3l-256 256c-12.5 12.5-32.8 12.5-45.3 0l-128-128c-12.5-12.5-12.5-32.8 0-45.3s32.8-12.5 45.3 0L160 338.7 393.4 105.4c12.5-12.5 32.8-12.5 45.3 0z">
                            </path>
                        </svg>Secure payment</div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- ========== End hero Section ========== -->

@push('css')
    <style>
        @media (min-width: 991px) {
            .hero-wrapper {
                padding: 60px 0;
            }
        }
        .navbar .logo-main {
            display: none;
        }
       .navbar.active .logo-main {
            display: block;
        }

        .navbar .logo-light {
            display: block;
        }

        .navbar.active .logo-light {
            display: none;
        }

        .navbar {
            height: 70px;
            z-index: 999999999;
            border-bottom: 0px solid rgba(65, 57, 134, 0.5);
        }

        .nav-link {
            color: #fff;
        }

        @media (max-width: 991px) {
            .navbar {
                height: auto;
            }
            .navbar .logo-light {
            display: none !important;
        }
        }

        .hero-vector {
            position: absolute;
            right: 24px;
            top: 120px;
            z-index: 1;
        }

        .hero-center {
            position: relative;
            width: 70%;
            text-align: center;
            z-index: 2;
            margin: 60px auto auto;
        }

        .tracking-section {
            box-shadow: 0 2px 4px #17468033;
        }

        @media (min-width: 768px) {
            .styles_banner__Kkg1h .styles-pills {
                margin-top: 60px;
                display: flex;
                margin-bottom: 35px;
            }
        }

        .styles_banner__Kkg1h .styles-pills {
            margin-top: 44px;
            display: none;
            justify-content: center;
        }

        
        .hero-span {
            padding: 4px 16px 4px 12px;
            color: #fff;
            border-radius: 24px;
            background: #0061ffbf;
            display: inline-block;
            font-size: 16px;
            font-weight: 600;
            line-height: 150%;
        }

        svg:not(:host).svg-inline--fa,
        svg:not(:root).svg-inline--fa {
            overflow: visible;
            box-sizing: initial;
        }

        .hero-span .hero-span-svg {
            margin-right: 8px;
            color: #00d18a;
        }

        .svg-inline--fa {
            display: var(--fa-display, inline-block);
            height: 1em;
            overflow: visible;
            vertical-align: -0.125em;
        }

        @media (max-width: 767px) {
            .hero-center {
                width: 90%;
                margin: 40px auto auto;
            }
        }
    </style>
@endpush
