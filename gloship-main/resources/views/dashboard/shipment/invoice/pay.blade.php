@php
    $bbcode = new ChrisKonnertz\BBCode\BBCode();
    $instruction = $bbcode->render(strip_tags(get_content_locale(get_data_db('payment_methods', 'id', $shipment->payment_method, 'instruction'))));
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="payment-page">
        {{-- Response --}}
        @if (Session::has('error'))
            <div class="card small-card text-center col-md-6 mx-auto mt-5">
                <div class="card-body">
                    <p><span class="fa fa-times-circle text-danger" style="font-size: 50px"></span></p>
                    <div class="alert alert-danger alert-dismissible fade show mt-5" role="alert">
                        <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                        {{ Session::get('error') }}
                    </div>
                </div>
                
            </div>
        {{-- @endif

        @if (Session::has('success'))
            <div class="card small-card text-center">
                <div class="alert alert-success" role="alert">
                    {{ Session::get('success') }}
                </div>
            </div>
        @endif --}}

        @elseif ($shipment->payment_status == '1')
            <div class="card small-card text-center col-md-6 mx-auto mt-5">

                <div class="card-header">
                    <h2 class="card-title text-uppercase text-muted">{{ $page_title }}</h2>
                    <hr>
                </div>
                {{-- <div class="card-body">
                    <span class="fa fa-check-circle text-success" style="font-size: 50px"></span>
                    <h6 class="mt-5">@lang('messages.Paid')</h6>
                </div> --}}
                <div class="mt-4 mb-5">
                    <p><span class="fa fa-check-circle text-success" style="font-size: 50px"></span></p>

                    <h4 class="mb-3 mt-4">Payment Received</h4>
                    
                    <p class="text-muted mb-4 mt-3"> Your order has been completed.</p>
                    <div class="hstack gap-3 justify-content-center">
                        <a target="_blank" href="{{ route('dashboard.shipments.invoice', ['id' => $shipment->invoice_id]) }}" class="btn btn-light">View Invoice</a>
                        <a href="{{ route('dashboard.shipments.view', ['id' => $shipment->code]) }}" class="btn btn-success">View shipment</a>
                    </div>
                </div>
            </div>
        @else
        <div class="modal fade bs-example-modal-center" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Oops !</h4>
                        <p class="text-muted mb-4"> </p>
                       
                            <div class="alert alert-warning" role="alert">
                              This invoice has expired. 
                            </div>
                        
                        <div class="hstack gap-2 justify-content-center mt-3">
                            <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Back to Dashboard</a>
                            <a href="{{ route('contact') }}" class="btn btn-light">Contact Support</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
        @endif
    </div>

    
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $(".bs-example-modal-center").modal('show');
            $(body).apend('<div class="modal-backdrop fade show"></div>');
        });
    </script>
@endpush

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
