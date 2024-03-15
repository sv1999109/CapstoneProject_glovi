@php
    $bbcode = new ChrisKonnertz\BBCode\BBCode();
    $instruction = $bbcode->render(strip_tags(get_content_locale(get_data_db('payment_methods', 'id', $shipment->payment_method, 'instruction'))));
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="payment-page">
        {{-- Response --}}
        @if (Session::has('error'))
            <div class="card small-card text-center">
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                    {{ Session::get('error') }}
                </div>
            </div>
        @endif

        @if (Session::has('success'))
            <div class="card small-card text-center">
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif

        @if ($shipment->payment_status == '1')
            <div class="card small-card text-center">

                <div class="card-header">
                    <h2 class="card-title text-uppercase">{{ $page_title }}</h2>
                    <hr>
                </div>
                <div class="card-body">
                    <span class="fa fa-check-circle text-success" style="font-size: 50px"></span>
                    <h6 class="mt-5">@lang('messages.Paid')</h6>
                </div>
            </div>
        @else
            <div class="row m-0">
                <div class="col-md-7 col-12">
                    <div class="row">
                        <div class="col-12 mb-4">
                            <div class="row box-right">
                                <div class="col-md-8 ps-0 ">
                                    <p class="ps-3 textmuted fw-bold h6 mb-0">{{ trans_choice('messages.Invoice', 1) }}</p>
                                    <p class="h1 fw-bold d-flex">
                                        <span class="textmuted pe-1 h6 align-text-top mt-1">#</span>
                                        {{ $shipment->invoice_id }}
                                    </p>
                                    <p class="ms-3 px-2 bg-green">@lang('messages.Invoice_Generated')
                                        {{ \Illuminate\Support\Carbon::parse($shipment->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d H:i:s') }}
                                    </p>
                                </div>
                                <div class="col-md-4">
                                    <p class="p-blue"> <span
                                            class="fas fa-circle pe-2"></span>{{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}
                                    </p>
                                    <p class="fw-bold mb-3">
                                        {{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}
                                    </p>
                                    <p class="p-blue"><span class="fas fa-circle pe-2"></span>@lang('messages.Payment_Type')</p>
                                    <p class="fw-bold">
                                        {{ $shipment->payment_type == '1' ? __('messages.PrePaid') : __('messages.PostPaid') }}
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 px-0 mb-4">
                            <div class="box-right">
                                <div class="d-flex pb-2">
                                    <p class="fw-bold h7">
                                        <span class="textmuted">@lang('messages.Payment_Instruction')</span>
                                    </p>
                                </div>
                                <div class="bg-blue p-2">
                                    <p class="h8 textmuted">
                                        {!! $instruction !!}
                                    </p>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-md-5 col-12 ps-md-5 p-0 ">
                    <div class="box-left p-3  mb-5">
                        <p class="h7 fw-bold mb-3">@lang('messages.Pay_This_Invoice_Via')
                            {{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}
                        </p>
                        <p class="textmuted h8 mb-2">{{ __('messages.Currency_Conversion_Note') }}</p>

                        <div class="form desktop-buttons">
                            <a href="{{ route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id]) }}"
                                class="btn btn-primary d-block h8 text-uppercase">
                                @lang('messages.Pay')
                                {{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}
                                <span class="ms-3 fas fa-arrow-right"></span>
                            </a>
                            @can('do_staff')
                                <a href="{{ route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id]) }}"
                                    class="btn btn-warning d-block h8 text-uppercase mt-2" data-bs-toggle="modal"
                                    data-bs-target="#paid-{{ $shipment->id }}" href="#">
                                    @lang('messages.Mark_Paid') <i class="fa fa-check-circle"></i>
                                </a>
                            @endcan

                            <div class="row">
                                <p class="p-blue h8 fw-bold mt-3 text-center text-uppercase">
                                    <a href="#" data-bs-toggle="modal"
                                        data-bs-target="#paymet_methods">@lang('messages.More_Payment_Method')</a>
                                </p>
                            </div>
                        </div>

                        <div class="form mobile-buttons">
                            <a href="{{ route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id]) }}"
                                class="btn btn-primary d-block h8 text-uppercase">
                                @lang('messages.Pay')
                                {{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}
                                <span class="ms-3 fas fa-arrow-right"></span>
                            </a>
                            @can('do_staff')
                                <a href="{{ route('dashboard.shipments.invoice.payment.process', ['id' => $shipment->invoice_id]) }}"
                                    class="btn btn-warning d-block h8 text-uppercase mt-2" data-bs-toggle="modal"
                                    data-bs-target="#paid-{{ $shipment->id }}" href="#">
                                    @lang('messages.Mark_Paid') <i class="fa fa-check-circle"></i>
                                </a>
                            @endcan

                            <div class="row">
                                <p class="p-blue h8 fw-bold mt-3 text-center text-uppercase"><a href="#"
                                        data-bs-toggle="modal" data-bs-target="#paymet_methods">@lang('messages.More_Payment_Method')</a></p>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <!-- Modal Body -->
    <!-- if you want to close by clicking outside the modal, delete the last endpoint:data-bs-backdrop and data-bs-keyboard -->
    <div class="modal fade" id="paymet_methods" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false"
        role="dialog" aria-labelledby="paymet_methods" aria-hidden="true">
        <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="paymet_methods">{{ trans_choice('messages.Payment_Method', 2) }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body box">
                    @foreach (DB::table('payment_methods')->orderBy('name', 'asc')->where('status', 1)->get() as $pay)
                        <a
                            href="{{ route('dashboard.shipments.status', ['id' => $shipment->id, 'payment_method' => $pay->id]) }}">
                            <div class="box-item">{{ __('messages.' . $pay->name) }}</div>
                        </a>
                    @endforeach
                </div>

            </div>
        </div>
    </div>
    {{-- modal --}}
    @include(get_theme_dir('shipment.modal', 'dashboard'), [
        'id' => $shipment->id,
        'code' => $shipment->code,
        'shipment' => $shipment,
    ])
    {{-- //modal --}}
@endsection
@push('css')
    <style>
        .mobile-buttons {
            background-color: #fff;
            bottom: 0;
            left: 0;
            padding: 10px;
            position: fixed;
            text-align: center;
            width: 100%;
            z-index: 10;
        }

        @media screen and (min-width: 991px) {
            .mobile-buttons {
                display: none;
            }
        }

        @media screen and (max-width: 768px) {
            .desktop-buttons {
                display: none;
            }
        }

        .pay-btnx {
            position: relative;
            bottom: fixed;
        }

        /* @import url('https://fonts.googleapis.com/css2?family=Poppins&display=swap'); */

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            /* font-family: 'Poppins', sans-serif */
        }

        p {
            margin: 0
        }


        .box-right {
            padding: 30px 25px;
            background-color: white;
            border-radius: 15px
        }

        .box-left {
            padding: 20px 20px;
            background-color: white;
            border-radius: 15px
        }

        html[data-bs-theme="dark"] .box-right,
        html[data-bs-theme="dark"] .box-left,
        html[data-bs-theme="dark"] .bg-blue {
            background: #1e1e2d !important;
        }

        .textmuted {
            color: #7a7a7a
        }

        .bg-green {
            background-color: #d4f8f2;
            color: #06e67a;
            padding: 3px 0;
            display: inline;
            border-radius: 25px;
            font-size: 11px
        }

        .p-blue {
            font-size: 14px;
            color: #1976d2
        }

        .fas.fa-circle {
            font-size: 12px
        }

        .p-org {
            font-size: 14px;
            color: #fbc02d
        }

        .h7 {
            font-size: 15px
        }

        .h8 {
            font-size: 12px
        }

        .h9 {
            font-size: 10px
        }

        .bg-blue {
            background-color: #dfe9fc9c;
            border-radius: 5px
        }

        .form-control {
            box-shadow: none !important
        }

        .card input::placeholder {
            font-size: 14px
        }

        ::placeholder {
            font-size: 14px
        }

        input.card {
            position: relative
        }

        .far.fa-credit-card {
            position: absolute;
            top: 10px;
            padding: 0 15px
        }

        .fas,
        .far {
            cursor: pointer
        }

        .cursor {
            cursor: pointer
        }

        .btn.btn-primary {
            box-shadow: none;
            height: 40px;
            padding: 11px
        }

        .bg.btn.btn-primary {
            background-color: transparent;
            border: none;
            color: #1976d2
        }

        .bg.btn.btn-primary:hover {
            color: #539ee9
        }

        @media(max-width:320px) {
            .h8 {
                font-size: 11px
            }

            .h7 {
                font-size: 13px
            }

            ::placeholder {
                font-size: 10px
            }
        }
    </style>
@endpush
