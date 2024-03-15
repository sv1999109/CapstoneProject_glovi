@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    
    <div class="card px-3 mt-4">
        <div class="row g-5">
            <div class="col-lg-7 card-body border-end">
                
                <h4 class="mt-2 mb-4">Shipping Method</h4>
                @php
                    $data = json_decode($response, true);
                    // print_r($data);
                    // exit;
                    $provider = $data['options']['provider'];
    
                    $collection_type = $data['options']['collection_type'];
                    $delivery_type = $data['options']['delivery_type'];
                    $sender_info = $data['options']['sender_info'];
                    $receiver_info = $data['options']['receiver_info'];
                    $sender_branch = $data['options']['sender_branch'];
                    $receiver_branch = $data['options']['receiver_branch'];
                    $total_weight = $data['options']['total_weight'];
                    $total_qty = $data['options']['total_qty'];
                    $packages = $data['packages'];
                    $tracking_code_prefix = $data['options']['tracking_code_prefix'];
                    $tracking_code_number = $data['options']['tracking_code_number'];
                    $client = $data['options']['client'];
                    $payment_method = $data['options']['payment_method'];
    
                    // Rates are stored in the `rates` array inside the shipment object
                    $rates = $data['rates'];
                    if ($provider == 3) {
                        $rates = $shipping_rates;
                        // debug
                        // print_r($rates);
                    }
                    $count_rates = 0;
                @endphp
    
                @foreach ($rates as $rate)
                    @php
                        $count_rates++;
    
                        // rates settings
                        $currency = $rate['currency'];
                        $cost = $rate['amount'];
                        $cost = convert_currency(get_config('currency_code'), $currency, $cost);
                        if (get_config('additional_cost') == 'enabled') {
                            if (get_config('additional_cost_type') == 'fixed') {
                                $additional_cost = convert_currency(get_config('additional_cost_currency'), $currency, get_config('additional_cost_amount'));
                                $cost = $cost + $additional_cost;
                            }
    
                            if (get_config('additional_cost_type') == 'percent') {
                                // $additional_cost = $cost % get_config('additional_cost_amount');
                                $additional_cost = (get_config('additional_cost_amount') / 100) * $cost;
                                $cost = $cost + $additional_cost;
                            }
                        }
    
                        $subtotal = $cost;
    
                        //calculate tax
                        $tax = 0;
                        if (get_config('tax') == 'enabled') {
                            if (get_config('tax_type') == 'fixed') {
                                $tax = convert_currency(get_config('tax_currency'), $currency, get_config('tax_amount'));
                                $cost = $cost + $tax;
                            }
    
                            if (get_config('tax_type') == 'percent') {
                                $tax = (get_config('tax_amount')  / 100) * $cost;
                                $cost = $cost + $tax;
                            }
                        }
    
                        //calculate discount
                        $discount = 0;
                        if (get_config('discount') == 'enabled') {
                            if (get_config('discount_type') == 'fixed') {
                                $discount = convert_currency(get_config('discount_currency'), $currency, get_config('discount_amount'));
                                $cost = $cost - $discount;
                            }
    
                            if (get_config('discount_type') == 'percent') {
                                $discount = (get_config('discount_amount')  / 100) * $cost;
                                $cost = $cost - $discount;
                            }
                        }
    
                        // set sessions to retrive order details
                        session([
                            'shipment_order' => $rate['object_id'],
                            'object_subtotal_' . $rate['object_id'] . '' => $subtotal,
                            'object_currency_' . $rate['object_id'] . '' => $currency,
                            'object_discount_' . $rate['object_id'] . '' => $discount,
                            'object_tax_' . $rate['object_id'] . '' => $tax,
                            'object_total_' . $rate['object_id'] . '' => $cost,
                            'object_duration_' . $rate['object_id'] . '' => $rate['estimated_days'],
                        ]);
                        // echo  session("object_subtotal_".$rate['object_id'] ."");
                        // echo  session("object_currency_".$rate['object_id'] ."");
                        // echo  session("object_discount_".$rate['object_id'] ."");
                        // echo  session("object_tax_".$rate['object_id'] ."");
                        // echo  session("object_total_".$rate['object_id'] ."");
    
                        // monetary value
                        $subtotal_full = get_money($subtotal, $currency, 'symbol', 'localize');
                        $discount_full = get_money($discount, $currency, 'symbol', 'localize');
                        $tax_full = get_money($tax, $currency, 'symbol', 'localize');
                        $total_full = get_money($cost, $currency, 'symbol', 'localize');
    
                        // selected values
                        if ($count_rates == 1) {
                            $subtotal_1 = get_money($subtotal, $currency, 'symbol', 'localize');
                            $discount_1 = get_money($discount, $currency, 'symbol', 'localize');
                            $tax_1 = get_money($tax, $currency, 'symbol', 'localize');
                            $total_1 = get_money($cost, $currency, 'symbol', 'localize');
                        }
    
                    @endphp
    
                    <div class="row g-4">
    
                        <div class="col-lg-12 mb-3" id="pricing-{{ $rate['object_id'] }}">
                            <input type="hidden" id="object_id_{{ $rate['object_id'] }}"
                            value="{{ $rate['object_id'] }}">
                        <input type="hidden" id="token_{{ $rate['object_id'] }}"
                            value="{{ $rate['servicelevel']['token'] }}">
                        <input type="hidden" id="provider_{{ $rate['object_id'] }}" value="{{ $rate['provider'] }}">
    
                        <input type="hidden" id="name_{{ $rate['object_id'] }}"
                            value="{{ $rate['servicelevel']['name'] }}">
                        <input type="hidden" id="subtotal_{{ $rate['object_id'] }}" value="{{ $subtotal_full }}">
                        <input type="hidden" id="tax_{{ $rate['object_id'] }}" value="{{ $tax_full }}">
                        <input type="hidden" id="discount_{{ $rate['object_id'] }}" value="{{ $discount_full }}">
    
                        <input type="hidden" id="total_{{ $rate['object_id'] }}" value="{{ $total_full }}">
                            <div class="form-check card-radio">
                                <input onclick="select_rate('{{ $rate['object_id'] }}');" type="radio" name="shipping"
                                id="select-{{ $rate['object_id'] }}" value="{{ $rate['object_id'] }}"
                                @if ($count_rates == 1) checked @endif class="form-check-input">
                                <label class="form-check-label d-flex gap-2 align-items-center" for="select-{{ $rate['object_id'] }}">
                                    <span class="avatar-sm">
                                        <span class="avatar-title bg-light rounded text-body fs-4">
                                            <i class="bi bi-airplane"></i>
                                        </span>
                                    </span>
                                    <span class="flex-grow-1">
                                        <span
                                            class="fs-md fw-medium mb-1 text-wrap d-block @if ($provider != '3') text-capitalize @endif">{{ shipping_plan_name($rate['provider']) }}
                                            @if ($rate['provider'] != 'Eurosender')
                                                -
                                            @endif
                                            {{ shipping_plan_name($rate['servicelevel']['name']) }}</span>
                                        @if ($rate['estimated_days'])
                                            <span
                                                class="text-muted fw-normal text-wrap d-block">{{ trans_choice('messages.Delivery_In', $rate['estimated_days'], ['day' => $rate['estimated_days']]) }}</span>
                                        @endif
    
                                    </span>
                                    
                                    <span
                                        class="fs-3xl float-end mt-2 text-wrap d-block fw-semibold">{{ $subtotal_full }}</span>
                                </label>
                            </div>
                        </div>
                    </div>
    
                    
                @endforeach
            </div>
            <div class="col-lg-5 card-body">
                <div class="pricing-cardx " id="order-summary">
                    
                        <h4 class="mt-2 mb-4">Order Summary</h4>
                    
                    <div class="">
                        <div class="row bg-lighter p-4">
                            <div class="col-md-6">
                                <h6>Pick-up </h6>
                                <p>
                                    {!! get_address($sender_info, 'full') !!}
                                </p>
                            </div>
                            <div class="col-md-6">
                                <h6>{{ trans_choice('messages.Delivery', 1) }} </h6>
                                <p>
                                    {!! get_address($receiver_info, 'full') !!}
                                </p>
                            </div>
    
                           
    
                        </div>
                        <div class="border-top border-dashed">
                            <h6 class="mt-3">Shipping options</h6>
                            <table class="table table-borderless align-middle mb-0" style="width: 100%;">
                                <tr>
                                    <td colspan="2"><span class="font-bold text-muted text-capitalize"
                                            id="tableName">{{ shipping_plan_name($rates[0]['servicelevel']['name']) }}</span>
                                    </td>
                                    <td class="text-end">
                                        <b>-</b>
                                    </td>
                                </tr>
                                <tr>
                                    <th colspan="2"> <span class="text-muted">{{ count($packages['packages']) }}x
                                        {{ trans_choice('messages.Package', 1) }}</span></th>
                                    <td class="text-end">
                                        <span class="fw-semibold"> {{ $total_weight }} @lang('messages.KG')</span>
                                    </td>
                                </tr>
                            </table>
    
                        </div>
                        <div class="mt-4">
                            <h6 class="card-subtitle">Estimated cost</h6>
                            <div class="table-responsive">
                                <table class="table table-borderless align-middle mb-0" style="width: 100%">
                                    <tr>
                                        <th colspan="2"><span class="text-muted">{{ __('messages.Subtotal') }}</span></th>
                                        <td class="text-end">
        
                                            <span id="tableSubtotal" class="fw-semibold text-end">{{ $subtotal_1 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="text-muted">{{ __('messages.Tax') }}</span></td>
                                        <td class="text-end"><span class="text-end"> +<span
                                                    id="tableTax" class="font-bold">{{ $tax_1 }}</span></span>
        
                                        </td>
                                    </tr>
                                    <tr>
                                        <td colspan="2"><span class="text-muted">{{ __('messages.Discount') }}</span></td>
                                        <td class="text-end">
                                            <span class="text-end"> -<span id="tableDiscount"
                                                    class="font-bold">{{ $discount_1 }}</span></span>
        
                                        </td>
                                    </tr>
        
                                    <tr class="border-top border-dashed">
                                        <th colspan="2">{{ __('messages.Total') }}</th>
                                        <td class="text-end">
                                            <h4 id="tableTotal" class="fw-semibold text-end">{{ $total_1 }}</h4>
                                        </td>
                                    </tr>

                                    <tr class="border-top border-dashed">
                                        <td colspan="2">{{ trans_choice('messages.Payment_Method', 1) }}</td>
                                        <td class="text-end">
                                            <h5 id="tableTotal" class="fw-semibold text-end">{{ DB::table('payment_methods')->where('id', $payment_method)->value('name') }}</h5>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <form action="{{ route('dashboard.shipments.create') }}" method="post">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="client" value="{{ $client }}">
                    <input type="hidden" name="tracking_code_prefix" value="{{ $tracking_code_prefix }}">
                    <input type="hidden" name="tracking_code_number" value="{{ $tracking_code_number }}">
    
                    <input type="hidden" id="in_object_id" name="object_id" value="{{ $rates[0]['object_id'] }}">
                    <input type="hidden" id="in_token" name="token" value="{{ $rates[0]['servicelevel']['token'] }}">
                    <input type="hidden" id="in_service_provider" name="service_provider" value="{{ $provider }}">
                    <input type="hidden" id="in_provider" name="provider" value="{{ $rates[0]['provider'] }}">
                    <input type="hidden" id="in_service_name" name="service_name"
                        value="{{ $rates[0]['servicelevel']['name'] }}">
                    <input type="hidden" name="sender_info" value="{{ $sender_info }}">
                    <input type="hidden" name="receiver_info" value="{{ $receiver_info }}">
                    <input type="hidden" name="collection_type" value="{{ $collection_type }}">
                    <input type="hidden" name="delivery_type" value="{{ $delivery_type }}">
                    <input type="hidden" name="sender_branch" value="{{ $sender_branch }}">
                    <input type="hidden" name="receiver_branch" value="{{ $receiver_branch }}">
                    <input type="hidden" name="payment_method" value="{{ $payment_method }}">
    
                    @foreach ($packages['packages'] as $key => $package)
                        <input type="hidden" name="packages[{{ $key }}][package_description]"
                            value="{{ $package['package_description'] }}">
                        <input type="hidden" name="packages[{{ $key }}][length]"
                            value="{{ $package['length'] }}">
                        <input type="hidden" name="packages[{{ $key }}][width]" value="{{ $package['width'] }}">
                        <input type="hidden" name="packages[{{ $key }}][height]"
                            value="{{ $package['height'] }}">
                        <input type="hidden" name="packages[{{ $key }}][weight]"
                            value="{{ $package['weight'] }}">
                        <input type="hidden" name="packages[{{ $key }}][qty]" value="{{ $package['qty'] }}">
                        <input type="hidden" name="packages[{{ $key }}][value]" value="{{ $package['value'] }}">
                    @endforeach
                    <input type="hidden" name="total_weight" value="{{ $total_weight }}">
                    <input type="hidden" name="total_qty" value="{{ $total_qty }}">
    
                    <a type="button" data-bs-toggle="modal" data-bs-target="#confirmOrderModal"  class="btn btn-warning w-100"> Confirm Order</a>

                    <div id="confirmOrderModal" class="modal fade zoomIn" tabindex="-1" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-centered">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    <div class="mt-2 text-center">
                                        <i class="bi bi-shop display-6"></i>
                                        <div class="mt-4 pt-2 mx-4 mx-sm-5">
                                            <h4>Confirm your order ?</h4>
                                            <p class="text-muted mx-4 mb-0">Are you sure you want to confirm order ?</p>
                                        </div>
                                    </div>
                                    <div class="d-flex gap-2 justify-content-center mt-4 mb-2">
                                        <button type="button" class="btn w-sm btn-ghost-danger" data-bs-dismiss="modal"><i class="bi bi-x-lg align-baseline me-1"></i> Close</button>
                                        <button type="submit" class="btn w-sm btn-success ">Yes, Confirm Order</button>
                                    </div>
                                </div>
                    
                            </div><!-- /.modal-content -->
                        </div><!-- /.modal-dialog -->
                    </div><!-- /.modal -->
                </form>
    
            </div>
        </div>
    </div>
    
@endsection

@push('css')
    <style>
        .bg-lighter {
    --bs-bg-opacity: 1;
    background-color: rgba(75, 70, 92, 0.03) !important;
}
    </style>
@endpush

@push('scripts')
    <script>
        function select_rate(rate) {
            //var selected_rate = $('#select').val;
            $('.pricing-card.active').removeClass('active');
            $('#pricing-' + rate).addClass('active');

            // populate values
            var object_id_ = $('#object_id_' + rate).val();
            var token_id = $('#token_' + rate).val();
            var provider = $('#provider_' + rate).val();
            var name = $('#name_' + rate).val();
            var subtotal = $('#subtotal_' + rate).val();
            var tax = $('#tax_' + rate).val();
            var discount = $('#discount_' + rate).val();
            var total = $('#total_' + rate).val();

            $('#in_object_id').val(object_id_);
            $('#in_token').val(token_id);
            $('#in_provider').val(provider);
            $('#in_service_name').val(name);

            $('#tableName').html(name);
            $('#tableSubtotal').html(subtotal);
            $('#tableTax').html(tax);
            $('#tableDiscount').html(discount);
            $('#tableTotal').html(total);

            scrollToElement('order-summary');

        }

        function scrollToElement(id) {
            const element = document.getElementById(id);
            element.scrollIntoView({
                behavior: 'smooth'
            });
        }
    </script>
@endpush
