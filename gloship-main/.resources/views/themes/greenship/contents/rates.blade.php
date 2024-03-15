@extends(get_theme_dir('layouts.app'))
@section('content')
    @include(get_theme_dir('layouts.partials.page-heading-empty'))

    <div class="container-xxl py-5">
        <div class="container px-lg-5">
            <div class="section-title position-relative text-center mx-auto mb-5 pb-4 wow fadeInUp" data-wow-delay="0.1s"
                style="max-width: 600px;">
                <h1 class="mb-3"> {{ $page_title }}</h1>
               
            </div>

            <div class="row g-5">
                <div class="col-lg-7">
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
                                    $additional_cost = $cost % get_config('additional_cost_amount');
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
                                    $tax = (get_config('tax_amount') / 100) * $cost;
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
                                    $discount = (get_config('discount_amount') / 100) * $cost;
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
                            $subtotal_full = get_money($subtotal, $currency, 'full', 'localize');
                            $discount_full = get_money($discount, $currency, 'full', 'localize');
                            $tax_full = get_money($tax, $currency, 'full', 'localize');
                            $total_full = get_money($cost, $currency, 'full', 'localize');
                            
                            // selected values
                            if ($count_rates == 1) {
                                $subtotal_1 = get_money($subtotal, $currency, 'full', 'localize');
                                $discount_1 = get_money($discount, $currency, 'full', 'localize');
                                $tax_1 = get_money($tax, $currency, 'full', 'localize');
                                $total_1 = get_money($cost, $currency, 'full', 'localize');
                            }
                            
                        @endphp


                        <div class="pricing-card @if ($count_rates == 1) active @endif"
                            id="pricing-{{ $rate['object_id'] }}">
                            <div class="row">
                                <div class="col-lg-4">
                                    <img class="provider-img" src="{{ $rate['provider_image_75'] }}" alt="">
                                </div>
                                <div class="col-lg-4">
                                    <h2 class="@if ($provider != '3') text-capitalize @endif">
                                        {{ shipping_plan_name($rate['provider']) }} @if ($rate['provider'] != 'Eurosender')
                                            -
                                        @endif {{ shipping_plan_name($rate['servicelevel']['name']) }}
                                    </h2>
                                    <h3 class="fw-bolder">{{ $subtotal_full }}
                                    </h3>
                                    <ul>
                                        <li>
                                            @foreach ($rate['attributes'] as $rate_value)
                                                <span class="badge bg-primary"> {{ $rate_value }}</span>
                                            @endforeach
                                        </li>

                                        @if ($rate['estimated_days'])
                                            <li> {{ trans_choice('messages.Delivery_In', $rate['estimated_days'], ['day' => $rate['estimated_days']]) }}
                                            </li>
                                        @endif

                                    </ul>
                                </div>
                                <div class="col-lg-4 py-lg-3">

                                    <input type="hidden" id="object_id_{{ $rate['object_id'] }}"
                                        value="{{ $rate['object_id'] }}">
                                    <input type="hidden" id="token_{{ $rate['object_id'] }}"
                                        value="{{ $rate['servicelevel']['token'] }}">
                                    <input type="hidden" id="provider_{{ $rate['object_id'] }}"
                                        value="{{ $rate['provider'] }}">

                                    <input type="hidden" id="name_{{ $rate['object_id'] }}"
                                        value="{{ $rate['servicelevel']['name'] }}">
                                    <input type="hidden" id="subtotal_{{ $rate['object_id'] }}"
                                        value="{{ $subtotal_full }}">
                                    <input type="hidden" id="tax_{{ $rate['object_id'] }}" value="{{ $tax_full }}">
                                    <input type="hidden" id="discount_{{ $rate['object_id'] }}"
                                        value="{{ $discount_full }}">

                                    <input type="hidden" id="total_{{ $rate['object_id'] }}" value="{{ $total_full }}">
                                    <div class="radio-input">

                                        <input onclick="select_rate('{{ $rate['object_id'] }}');" type="radio"
                                            name="shipping" id="select-{{ $rate['object_id'] }}"
                                            value="{{ $rate['object_id'] }}"
                                            @if ($count_rates == 1) checked @endif>
                                        <label for="select-{{ $rate['object_id'] }}">@lang('messages.Select_Shipping')</label>
                                    </div>
                                </div>

                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="col-lg-5 px-lg-5">
                    <div class="pricing-cardx card" id="order-summary">
                       
                        <div class="card-header bg-light btn-reveal-trigger d-flex flex-between-center">
                            <h5 class="mb-3">{{ trans_choice('messages.Summary', 1) }}</h5>
                        </div>
                        <div class=" card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <h6>Pick-up </h6>
                                    <p>
                                        {{ $data['options']['sender_data']['address'] }}, 
                                        {{ get_name($data['options']['sender_data']['city'], 'cities') }}, 
                                        {{ country_code($data['options']['sender_data']['country']) }}
                                        {{ $data['options']['sender_data']['postal'] }}
                                    </p>
                                </div>
                                <div class="col-md-6">
                                    <h6>{{ trans_choice('messages.Delivery', 1) }} </h6>
                                    <p>
                                        {{ $data['options']['receiver_data']['address'] }}, 
                                        {{ get_name($data['options']['receiver_data']['city'], 'cities') }},
                                        {{ country_code($data['options']['receiver_data']['country']) }}
                                        {{ $data['options']['receiver_data']['postal'] }}
                                    </p>
                                </div>
        
                                <hr>
        
                            </div>
                            <div>
                                <h6 class="mt-5">{{ trans_choice('messages.Shipping_Option', 1) }} </h6>
                                <table class="table" style="width: 100%;">
                                    <tr>
                                        <th style="vertical-align: top;"><span class="font-bold xtext-capitalize"
                                                id="tableName">{{ shipping_plan_name($rates[0]['servicelevel']['name']) }}</span>
                                        </th>
                                        <td style="vertical-align: top;" class="text-end">
                                            <b>-</b>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;"> {{ count($packages['packages']) }}x
                                            {{ trans_choice('messages.Package', 1) }}</th>
                                        <td style="vertical-align: top;" class="text-end">
                                            <b>{{ $total_weight }} @lang('messages.KG')</b>
                                        </td>
                                    </tr>
                                </table>
        
                            </div>
                            <div class="py-5">
                                <h6 class="mt-5">Estimated cost</h6>
                                <table class="table" style="width: 100%">
                                    <tr>
                                        <th style="vertical-align: top;">{{ __('messages.Subtotal') }}</th>
                                        <td style="vertical-align: top;" class="text-end">
        
                                            <span id="tableSubtotal" class="font-bold text-end">{{ $subtotal_1 }}</span>
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;">{{ __('messages.Tax') }}</th>
                                        <td style="vertical-align: top;" class="text-end"><span class="text-end"> +<span id="tableTax" class="font-bold">{{ $tax_1 }}</span></span>
                                           
                                        </td>
                                    </tr>
                                    <tr>
                                        <th style="vertical-align: top;">{{ __('messages.Discount') }}</th>
                                        <td style="vertical-align: top;"  class="text-end">
                                            <span  class="text-end"> -<span id="tableDiscount" class="font-bold">{{ $discount_1 }}</span></span>
                                           
                                        </td>
                                    </tr>
        
                                    <tr>
                                        <th style="vertical-align: top; ">{{ __('messages.Total') }}</th>
                                        <th style="vertical-align: top; " class="text-end">
                                            <h4 id="tableTotal" class="font-bold text-end">{{ $total_1 }}</h4>
                                        </th>
                                    </tr>
                                </table>
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
        
                        <div class="text-center mt-2">
                            <a href="{{ route('register') }}" class="btn btn-primary w-100">@lang('messages.Get_Started')</a>
                        </div>
                    </form>
        
        
                </div>

            </div>
        </div>
    </div>
@endsection

@push('css')
    <style>
        .pricing-card {
            width: 100%;
            /* border: 1px solid #ccc; */
            padding: 20px;
            background: #fff;
            margin-bottom: 20px;
        }

        html[data-bs-theme="dark"] .pricing-card {
            background: #333;
        }

        .pricing-card.active {

            border: 1px solid #0f7ddc;

        }

        h2 {
            color: #333;
            font-size: 20px;
            margin-bottom: 10px;
        }

        h3 {
            color: #666;
            /* font-size: 16px; */
            margin-bottom: 20px;
        }

        html[data-bs-theme="dark"] h2 {
            font-weight: 600;
            font-size: 20px;
            margin-bottom: 10px;
        }

        ul {
            list-style-type: none;
            margin: 0;
            padding: 0;
        }

        html[data-bs-theme="dark"] ul {
            padding: 0px;
            margin: 0px;
        }


        li {
            margin-bottom: 5px;
        }

        .radio-input input[type="radio"] {
            display: none;
        }

        .radio-input label {
            background-color: #ccc;
            padding: 10px;
            color: #fff;
            cursor: pointer;
        }

        .radio-input input[type="radio"]:checked+label {
            background-color: var(--color-blue);
        }


        .provider-img {
            width: 80px;
            height: auto;
            margin-bottom: 10px;
        }

        @media only screen and (max-width: 768px) {
            .pricing-card {
                display: inline-block;
                /* margin-right: 20px; */
            }
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
