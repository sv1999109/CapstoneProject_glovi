@php
    $bbcode = new ChrisKonnertz\BBCode\BBCode();
    $instruction = $bbcode->render(strip_tags(get_content_locale(get_data_db('payment_methods', 'id', $shipment->payment_method, 'instruction'))));
    $payment_detail = json_decode(
                        DB::table('payment_methods')
                            ->where('id', $shipment->payment_method)
                            ->value('fields'),
                        true,
                    );
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')
    <div class="payment-page">
        <div class="card small-card">
            <div class="card-header">
                <h2 class="card-title">{{ $page_title }}</h2>
            </div>
            <div class="card-body">
                <hr>
                @lang('messages.Amount'):
                <strong>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</strong>
                <hr>
                {{ trans_choice('messages.Payment_Method', 1) }}:
                <strong>{{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}</strong>
                <hr>

                @foreach ($payment_detail as $key => $item)
                    @if ($key != '')
                        {{ __('messages.' . $key) }}:<br>
                         <strong>{{ $item }}</strong>
                        <hr>
                    @endif
                @endforeach
                
                <div class="mb-4">
                    {{ __('messages.Payment_Instruction') }}: <strong>{!! $instruction !!}</strong>
                </div>

                <div class="alert alert-light-warning" role="alert">
                    @lang('messages.Payment_Manual_Receipt')
                </div>
            </div>
        </div>
    </div>
@endsection
