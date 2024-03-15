<?php
    $payment_settings = json_decode(
                DB::table('payment_methods')
                    ->where('id', 4)
                    ->value('fields'),
                true
            );
?>

<?php $__env->startSection('content'); ?>
    <div class="payment-page">
        <div class="card small-card">
            <?php if(Session::has('error')): ?>
                <div class="alert alert-danger"> <?php echo e(Session::get('error')); ?></div>
            <?php endif; ?>

                <div class="card">
                    <div class="card-body">
                        <div class="card-text">
                            <form action="<?php echo e(route('dashboard.shipments.invoice.payment.process', ['id' => $id])); ?>" method="post" id="payment-form">
                                <?php echo csrf_field(); ?>
                                <div>
                                    <label>Name on Card</label>
                                    <input id="cardholder-name" class="form-control mb-4" type="text">
                                    <!-- placeholder for Elements -->
                                    <div id="card-element" class="form-control form-control-lg"></div>

                                    <!-- Used to display form errors -->
                                    <div id="card-errors" role="alert"></div>
                                </div>

                                <div class="d-flex flex-row mt-4 justify-content-end align-items-center">
                                    <button id="card-button" class="btn btn-primary btn-block">
                                        <?php echo app('translator')->get('messages.Pay'); ?>
                                    </button>
                                </div>
                                <input type="hidden" name="paymentMethodId" id="paymentMethodId">
                            </form>
                        </div>
                    </div>
                </div>
                <div class="text-center">
                    <img class="pt-4" style="width: 120px; height: auto" src="<?php echo e(asset(get_theme_dir('assets_dashboard'))); ?>/images/stripe.webp" alt="Powered by Stripe">
                </div>

        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
    <script src='https://js.stripe.com/v3/' type='text/javascript'></script>

    <script>

        var style = {
            base: {
                color: '#32325d',
                lineHeight: '1.8rem'
            }
        };

        var stripe = Stripe('<?php echo e($payment_settings['Public_Key']); ?>');

        var elements = stripe.elements();
        var cardElement = elements.create('card', {style: style});
        cardElement.mount('#card-element');

        var cardholderName = document.getElementById('cardholder-name');
        var cardButton = document.getElementById('card-button');
        var paymentMethodIdField = document.getElementById('paymentMethodId');
        var myForm = document.getElementById('payment-form');

        cardButton.addEventListener('click', function(ev) {
            ev.preventDefault();
            cardButton.disabled = true;

            stripe.createPaymentMethod('card', cardElement, {
                billing_details: {name: cardholderName.value }
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
<?php $__env->stopPush(); ?>
<?php echo $__env->make(get_theme_dir('layouts.app', 'dashboard'), \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /home/ansabook/glovi.ansabooks.com/resources/views/dashboard/shipment/invoice/stripe.blade.php ENDPATH**/ ?>