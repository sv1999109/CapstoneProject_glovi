@php
    $payment_settings = json_decode(
        DB::table('payment_methods')
            ->where('id', 4)
            ->value('fields'),
        true,
    );
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="payment-page  col-md-6 mx-auto mt-5">
        <div class="row">
            <div class="col-6">
                <div class="page-title-box">
                    <h4 class="mb-sm-0">Checkout</h4>
                </div>
            </div>
            <div class="col-6">
                <div class="text-end">
                    <a id="CancelOrder"> Cancel Order</a>
                </div>
            </div>
        </div>

        <div class="card small-card mt-4">

            @if (Session::has('error'))
                <div class="alert alert-danger"> {{ Session::get('error') }}</div>
            @endif

            <div class="card p-4">
                <div class="card-body">

                    <div class="card-text ">
                        <div class="row">
                            <div class="col-md-6">
                                <h3>Pay:
                                    {{ get_money($transaction->shipping_cost, $transaction->currency, 'symbol', 'localize') }}
                                </h3>
                            </div>
                            <div class="col-md-6">
                                <div class="text-end">
                                    <span class="text-muted">Order ID: {{ $id }}<br> 1x
                                        {{ trans_choice('messages.Package', 1) }}</span>
                                </div>
                            </div>
                        </div>

                        <div class="text-center">
                            <span class="text-muted" id="timer"></span>
                        </div>
                        <hr>
                        <form action="{{ route('dashboard.shipments.invoice.payment.process', ['id' => $id]) }}"
                            method="post" id="payment-form">
                            @csrf
                            <div class="text-end">
                                <div class="d-flex justify-content-end align-items-center gap-3">
                                    <img src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/images/mastercard.png"
                                        alt="" height="20">
                                    <img src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/images/visa.png"
                                        alt="" height="20">
                                    <img src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/images/amex.png"
                                        alt="" height="20">

                                </div>
                            </div>
                            <div class="mt-4">
                                <label>Name on Card</label>
                                <input id="cardholder-name" class="form-control mb-4" type="text">
                                <!-- placeholder for Elements -->
                                <div id="card-element" class="form-control form-control-lg"></div>

                                <!-- Used to display form errors -->
                                <div id="card-errors" role="alert"></div>
                            </div>

                            <div class="d-flex flex-row mt-4 justify-content-end align-items-center">
                                <button id="card-button" class="btn btn-primary btn-block w-100"
                                    onclick="needToConfirm = false;">
                                    @lang('messages.Pay')
                                </button>
                            </div>
                            <input type="hidden" name="paymentMethodId" id="paymentMethodId">
                        </form>
                    </div>
                </div>
            </div>
            <div class="text-center">
                <img class="pt-4" style="width: 120px; height: auto"
                    src="{{ asset(get_theme_dir('assets_dashboard')) }}/assets/images/stripe.webp" alt="Powered by Stripe">
            </div>

        </div>
    </div>
    <div class="modal fade bs-example-modal-center" data-bs-backdrop="static" tabindex="-1" role="dialog"
        aria-labelledby="mySmallModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body text-center p-5">
                    <i class="bi bi-exclamation-triangle text-warning display-5"></i>
                    <div class="mt-4">
                        <h4 class="mb-3">Order Canceled!</h4>
                        <p class="text-muted mb-4"> Your order has been canceled.</p>
                        <div class="hstack gap-2 justify-content-center">
                            <a href="{{ route('contact') }}" class="btn btn-light" onclick="needToConfirm = false;">Contact Support</a>
                            <a href="{{ route('dashboard.shipments.create') }}" class="btn btn-success" onclick="needToConfirm = false;">New order</a>
                        </div>
                    </div>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div>
@endsection

@push('scripts')
    <script src='https://js.stripe.com/v3/' type='text/javascript'></script>

    <script>
        var style = {
            base: {
                color: '#32325d',
                lineHeight: '1.8rem'
            }
        };

        var stripe = Stripe('{{ $payment_settings['Public_Key'] }}');

        var elements = stripe.elements();
        var cardElement = elements.create('card', {
            style: style
        });
        cardElement.mount('#card-element');

        var cardholderName = document.getElementById('cardholder-name');
        var cardButton = document.getElementById('card-button');
        var paymentMethodIdField = document.getElementById('paymentMethodId');
        var myForm = document.getElementById('payment-form');

        cardButton.addEventListener('click', function(ev) {
            ev.preventDefault();
            cardButton.disabled = true;

            stripe.createPaymentMethod('card', cardElement, {
                billing_details: {
                    name: cardholderName.value
                }
            }).then(function(result) {

                if (result.error) {
                    cardButton.disabled = false;
                    alert(result.error.message);
                } else {
                    paymentMethodIdField.value = result.paymentMethod.id;
                    myForm.submit();
                }
            });
        });
    </script>
    <script>
        function setTimer() {
            let minutes = 30;
            let seconds = 0;
            let timerElement = document.getElementById("timer");

            let timerId = setInterval(() => {
                seconds--;

                if (seconds === -1) {
                    minutes--;
                    seconds = 59;
                }

                timerElement.textContent =
                    `${minutes}:${seconds.toString().padStart(2, '0')}`; // Format for m:s

                if (minutes === 0 && seconds === 0) {
                    clearInterval(timerId);
                    displayCancellationPopup();

                }
            }, 1000); // Interval of 1000 milliseconds (1 second)
        }

        function displayCancellationPopup() {
            // Create a visually appealing popup using JavaScript's alert or confirm, or a custom HTML element
            $(document).ready(function() {
                $.ajax({
                    type: "GET",
                    url: "{{ route('dashboard.shipments.orders.status', ['id' => $id, 'status' => 2]) }}"
                }).done(function(data) {

                });
                $(".bs-example-modal-center").modal('show');
                $(body).apend('<div class="modal-backdrop fade show"></div>');
            });
        }



        setTimer();
        var needToConfirm = true;
        window.onbeforeunload = confirmExit;

        function confirmExit() {
            if (needToConfirm)
                return "@lang('messages.Changes_Unsaved')";
        }
        $(document).ready(function() {
            $(window)
            $("a[id='CancelOrder']").click(function() {
                displayCancellationPopup();
            });
        });
    </script>
@endpush
