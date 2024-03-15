@php
    //fetch packages
    if (isset($shipment)) {
        $packages = App\Models\Packages::where('shipment_id', $shipment->code)
            ->orderBy('id', 'asc')
            ->get();
    }
@endphp
@extends(get_theme_dir('layouts.app', 'dashboard'))
@section('content')

    @push('css')
    <style>
      * {
        box-sizing: border-box;
      }

      .table-bordered td,
      .table-bordered th {
        border: 1px solid #ddd;
        padding: 10px;
        word-break: break-all;
      }

      #bodyw {
        font-family: Arial, Helvetica, sans-serif;
        margin: 0;
        padding: 0;
        font-size: 16px;
      }
      .h4-14 h4 {
        font-size: 12px;
        margin-top: 0;
        margin-bottom: 5px;
      }
      .img {
        margin-left: "auto";
        margin-top: "auto";
        height: 30px;
      }
      pre,
      p {
        
        padding: 0;
        margin: 0;
      }
      table {
        font-family: arial, sans-serif;
        width: 100%;
        border-collapse: collapse;
        padding: 1px;
      }
      .hm-p p {
        text-align: left;
        padding: 1px;
        padding: 5px 4px;
      }
      td,
      th {
        text-align: left;
        padding: 8px 6px;
      }
      .table-b td,
      .table-b th {
        border: 1px solid #ddd;
      }
      th {
        /* background-color: #ddd; */
      }
      .hm-p td,
      .hm-p th {
        padding: 3px 0px;
      }
      .cropped {
        float: right;
        margin-bottom: 20px;
        height: 100px; /* height of container */
        overflow: hidden;
      }
      .cropped img {
        width: 400px;
        margin: 8px 0px 0px 80px;
      }
      .main-pd-wrapper {
        box-shadow: 0 0 10px #ddd;
        background-color: #fff;
        border-radius: 10px;
        padding: 15px;
      }
      .table-bordered td,
      .table-bordered th {
        border: 1px solid #ddd;
        padding: 10px;
        font-size: 14px;
      }
      .noborder td {
        border: 0;
    }

    .sign {
        margin-top: 0px;
        width: 100%;
        float: center;
    }
    .sign td {
        text-align: center;
    }
    .sign td.sign-head {
        text-align: center;
    }

    .sign td textarea {
        width: 100%;
        height: 25px;
        text-align: center;
    }
    @media print
	{
		.no-print, .no-print *
		{
			display: none !important;
		}
	}

    </style>
    @endpush
    
  </head>
  <div id="body">
    <div class="main-pd-wrapper" style="max-width: 1000px; margin: auto">
      <div style="display: table-header-group">
        <div class="no-print">
            <span style="margin: 0; text-align: left; float: left;"><a  href="#" onclick="window.close();">@lang('messages.Close')</a></span>
            <span style="margin: 0; text-align: right; float: right;"><a  href="#" class="btn btn-sm btn-primary" onclick="window.print();">@lang('messages.Print')</a></span>
        </div>
        <h4 style="text-align: center; margin: 0">
          <b>{{ trans_choice('messages.Invoice', 1) . ': #' .  $shipment->invoice_id }}</b>
        </h4>

        <table style="width: 100%; table-layout: fixed">
          <tr>
            <td
              style="border-left: 1px solid #ddd; border-right: 1px solid #ddd">
              <div
                style="
                  text-align: center;
                  margin: auto;
                  line-height: 1.5;
                  font-size: 14px;
                  color: #4a4a4a;
                ">
                 @if (get_theme_config('site_logo_main') == 'enabled')
                     <img src="{{ asset(get_contents_admin('logo_main', '', 'all')) }}" alt="{{ get_content_locale(get_config('site_name')) }}" style="max-height: 90px;">
                  @else
                     {{ get_content_locale(get_config('site_name')) }}
                  @endif

                <p style="font-weight: bold; margin-top: 15px">
                    @lang('messages.Head_Office'): {{ get_config('site_head_office') }}
                </p>
                <p style="font-weight: bold">
                   @lang('messages.Phone'):
                  <a href="tel:018001236477" style="color: #00bb07">{{ get_config('site_phone') }}</a>
                </p>
                <p style="font-weight: bold">
                    @lang('messages.Email'):
                    <a href="tel:018001236477" style="color: #00bb07">{{ get_config('site_email_support') }}</a>
                  </p>
              </div>
            </td>
            <td align="right"
                style="text-align: right;padding-left: 50px;line-height: 1.5; color: #323232;">
              <div>
                <h4 style="margin-top: 5px; margin-bottom: 5px">
                  @lang('messages.Bill_To')
                </h4>
                
                <p style="font-size: 14px">
                    {{ $shipment->sender_name }}:
                    {{ $shipment->sender_address }}, {{ get_name($shipment->sender_city, 'cities') }},<br />
                    {{ get_name($shipment->sender_state, 'states') }}, {{ get_name($shipment->sender_country, 'countries') }}
                  <br />
                  Tel:
                  <a href="tel:{{ $shipment->sender_phone }}" style="color: #00bb07">{{ $shipment->sender_phone }}</a> 
                  <br />
                    Email:
                  <a href="tel:{{ $shipment->sender_phone }}" style="color: #00bb07">{{ $shipment->sender_email }}</a> 
                </p>
              </div>
            </td>
          </tr>
        </table>
      </div>
      <table
        class="table table-bordered h4-14"
        style="width: 100%; -fs-table-paginate: paginate; margin-top: 15px">
        <thead style="display: table-header-group">
          <tr
            style="
              margin: 0;
              background: #fcbd021f;
              padding: 15px;
              padding-left: 20px;
              -webkit-print-color-adjust: exact;
            ">
            
            <td>
              <p>@lang('messages.Invoice_No'):- {{ $shipment->invoice_id }}</p>
              <p style="margin: 5px 0">@lang('messages.Invoice_Generated'):- {{\Illuminate\Support\Carbon::parse($shipment->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d H:i:s')}}</p>
            </td>
            <td>
                <h3>
                  {{ trans_choice('messages.Shipment', 1) }}<span
                    style="
                      font-weight: 300;
                      font-size: 85%;
                      color: #626262;
                      margin-left: 5px;
                    ">{{ $shipment->code }}</span
                  >
                  <p
                    style="
                      font-weight: 300;
                      font-size: 85%;
                      color: #626262;
                      margin-top: 7px;
                    ">
                    @lang('messages.Shipping_Date'):
                    <span style="color: #00bb07">{{ $shipment->shipped_date }}</span
                    ><br />
                  </p>
                  <p
                    style="
                      font-weight: 300;
                      font-size: 85%;
                      color: #626262;
                      margin-top: 7px;
                    ">
                    @lang('messages.Delivery_Date') (@lang('messages.Estimated')):
                    <span style="color: #00bb07">{{ $shipment->delivery_date }}</span
                    ><br />
                  </p>
                </h3>
              </td>
            <td>
              <h4 style="margin: 0">Ship To:</h4>
              <p>
                {{ $shipment->receiver_name }}:
                    {{ $shipment->receiver_address }}, {{ get_name($shipment->receiver_city, 'cities') }},
                    {{ get_name($shipment->receiver_state, 'states') }}, {{ get_name($shipment->receiver_country, 'countries') }}
                  <br />
                  Tel:
                  <a href="tel:{{ $shipment->receiver_phone }}" style="color: #00bb07">{{ $shipment->receiver_phone }}</a> 
                  <br />
                    Email:
                  <a href="tel:{{ $shipment->receiver_phone }}" style="color: #00bb07">{{ $shipment->receiver_email }}</a> 
              </p>
            </td>
          </tr>
        </thead>
      </table>
      <table
        class="table table-bordered h4-14"
        style="width: 100%; -fs-table-paginate: paginate; margin-top: 15px">
        <thead>
            <tr>
                <th class="text-right  text-muted text-uppercase">@lang('#')</th>
                <th style="width: 50%" class="pl-0 font-weight-bold text-muted text-uppercase">
                    @lang('messages.Description')</th>
                <th class="text-right  text-muted text-uppercase">@lang('messages.Weight_Kg')</th>
                <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Quantity')</th>
                {{-- <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Unit_Price')</th>
                <th class="pr-0 text-right  text-muted text-uppercase">@lang('messages.Total')</th> --}}
            </tr>
        </thead>
        <tbody>
            @php
                $sn = 0;
            @endphp
            @foreach ($packages as $package)
            @php
                $sn++;
            @endphp
            <tr class="font-weight-boldest">
                <td> {{ $sn }}</td>
                <td style="width: 50%"><strong> {{ $package->description }}</strong></td>
                <td> {{ $package->weight }}</td>
                <td> {{ $package->qty }}</td>
                {{-- <td> {{ get_money($package->unit_price, $shipment->currency, 'symbol', 'localize') }}</td>
                <td> {{ get_money($package->price, $shipment->currency, 'symbol', 'localize') }}</td> --}}
            </tr>
        @endforeach
        </tbody>
        <tfoot></tfoot>
      </table>

      <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
        <tr>
          <th style="vertical-align: top">{{ __('messages.Subtotal') }}</th>
          <td style="vertical-align: top; color: #000">
            <b> {{ get_money($shipment->subtotal, $shipment->currency, 'full', 'localize') }}</b>
          </td>
        </tr>
        <tr>
          <th style="vertical-align: top">{{ __('messages.Tax') }}</th>
          <td style="vertical-align: top">
            <b>+{{ get_money($shipment->tax, $shipment->currency, 'full', 'localize') }}</b>
          </td>
        </tr>
        <tr>
          <th style="vertical-align: top">{{ __('messages.Discount') }}</th>
          <td style="vertical-align: top">
            <b>-{{ get_money($shipment->discount, $shipment->currency, 'full', 'localize') }}</b>
          </td>
        </tr>

        <tr>
          <th style="vertical-align: top">{{ __('messages.Total') }}</th>
          <td style="vertical-align: top; color: #000">
            <b>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</b>
          </td>
        </tr>
      </table>

      <table class="hm-p table-bordered" style="width: 100%; margin-top: 30px">
        <tr>
          <th style="width: 40%">
            <p>{{ trans_choice('messages.Payment_Method', 1) }}:</p>
            <p>@lang('messages.Payment_Type'):</p>
            <p>@lang('messages.Invoice_Status'):</p>
          </th>
          <td style="width: 60%; border-right: none">
            <p style="text-align: right">{{ __('messages.' . get_data_db('payment_methods', 'id', $shipment->payment_method, 'name')) }}</p>
            <p style="text-align: right"> {{ $shipment->payment_type == '1' ? __('messages.PrePaid') : __('messages.PostPaid') }}</p>
            <p style="text-align: right"><b>{{ $shipment->payment_status == '1' ? __('messages.Paid') : __('messages.UnPaid') }}</b></p>
          </td>
          <td colspan="5" style="border-left: none"></td>
        </tr>
        <tr style="background: #fcbd02">
          <th>Total Order Value</th>
          <td style="width: 70px; text-align: right; border-right: none">
            <b>{{ get_money($shipment->shipping_cost, $shipment->currency, 'full', 'localize') }}</b>
          </td>
          <td colspan="5" style="border-left: none"></td>
        </tr>
      </table>

      <table style="width: 100%" cellspacing="0" cellspadding="0" border="0">
        <tr>
            <td>
                <p style="padding-bottom: 30px; padding-top: 10px">{!! nl2br(get_content_locale(get_config('shipment_terms'), LaravelLocalization::getCurrentLocale())) !!}</p>
            </td>
        </tr>
      </table>

      <table class="sign">
        <tbody>
            <tr class="noborder">
            <td align="center" style="width: 50%">
                <hr>
            </td>
            <td align="center" style="width: 50%; text-align: center">
                <hr>
            </td>
        </tr>
        <tr class="noborder">
            <td align="center" style="width: 50%">COMPANY SIGNATURE</td>
            <td align="center" style="width: 50%">RECEIVER SIGNATURE</td>
        </tr>
    </tbody>
    <tr>
        <td> </td>
        <td>
          <h4 style="margin: 0; text-align: right" class="no-print">
              <a href="#" class="btn btn-sm btn-primary" onclick="window.print();">@lang('messages.Print')</a>
          </h4>
        </td>
      </tr></table>
    </div>
   @endsection
