@php
    use Milon\Barcode\DNS1D;
    $d = new DNS1D();
    $packages = App\Models\Packages::where('shipment_id', $shipment->code)->count();
    
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8" />
    <title>{{ $page_title }}</title>
    <link rel="shortcut icon" type="image/png" href="./favicon.png" />
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

        body {
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
            /* width: 99%; */
            /* overflow: auto; */
            /* bpicklist: 1px solid #aaa; */
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
            height: 100px;
            /* height of container */
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

        .invoice-items {
            font-size: 14px;
            border-top: 1px dashed #ddd;
        }

        .invoice-items td {
            padding: 14px 0;

        }

        @media print {

            .no-print,
            .no-print * {
                display: none !important;
            }
        }
    </style>
</head>

<body>
    <section class="main-pd-wrapper" style="width: 450px; margin: auto">
        <div
            style="
                  text-align: center;
                  margin: auto;
                  line-height: 1.5;
                  font-size: 14px;
                  color: #4a4a4a;
                ">
            <div class="no-print">
                <span style="margin: 0; text-align: left; float: left;"><a href="#"
                        onclick="window.close();">@lang('messages.Close')</a></span>
                <span style="margin: 0; text-align: right; float: right;"><a href="#"
                        onclick="window.print();">@lang('messages.Print')</a></span>
            </div>
            <div style="text-align: center;margin: 0 auto;">
                @if (get_theme_config('site_logo_main') == 'enabled')
                    <img src="{{ asset(get_contents_admin('logo_main', '', 'all')) }}"
                        alt="{{ get_content_locale(get_config('site_name')) }}" width="150px;" height="70px"
                        style="display: block; border: 0px;margin: 0 auto;" />
                @else
                    {{ get_content_locale(get_config('site_name')) }}
                @endif
            </div>


            <p style="font-weight: bold; color: #000; margin-top: 15px; font-size: 14px;">
                {{ get_content_locale(get_config('site_tagline'), LaravelLocalization::getCurrentLocale()) }}
            </p>
            <p style="font-weight: bold; color: #000; margin-top: 15px; font-size: 14px;">
                <i>
                    @lang('messages.Head_Office'): {{ get_config('site_head_office') }}<br>
                    @lang('messages.Phone'): {{ get_config('site_phone') }}<br>
                </i>
            </p>
            <table class="table table-bordered h4-14"
                style="width: 100%; -fs-table-paginate: paginate; margin-top: 15px">
                <thead style="display: table-header-group">
                    <tr
                        style="
                        margin: 0;
                        background: #fcbd021f;
                        padding: 15px;
                        padding-left: 20px;
                        -webkit-print-color-adjust: exact;">
                        <td>
                            <h4 style="margin: 0">@lang('messages.Sender'):</h4>
                            <p>
                                {!! get_address($shipment->sender_address_id, 'no_email') !!}
                            </p>
                        </td>
                        <td>
                            <h4 style="margin: 0">@lang('messages.Recipient'):</h4>
                            <p>
                                {!! get_address($shipment->receiver_address_id, 'no_email') !!}
                            </p>
                        </td>
                    </tr>
                </thead>
            </table>

            <p style="padding-top: 10px">
                <b>Reference:<h3>{{ $shipment->code }}</h3></b>
            </p>
            <hr style="border: 1px dashed rgb(131, 131, 131); margin: 25px auto">
            <p>
                @php
                    
                    echo '<img src="data:image/png;base64,' . $d->getBarcodePNG($shipment->code, 'C128') . '" alt="barcode"   />';
                @endphp
            </p>
        </div>

        <div style="padding-top: 30px;"></div>
        <table style="width: 100%;
              background: #fcbd024f;
              border-radius: 4px;">
            <thead>
                <tr>
                    <th>@lang('messages.Total')</th>
                    <th style="text-align: center;">{{ trans_choice('messages.Item', 1) }} ({{ $shipment->qty }})</th>
                    <th>&nbsp;</th>
                    <th style="text-align: right;">
                        {{ get_money($shipment->shipping_cost, $shipment->currency, 'symbol', 'localize') }}</th>

                </tr>
            </thead>
        </table>

        <table
            style="width: 100%;
              margin-top: 15px;
              border: 1px dashed #00cd00;
              border-radius: 3px;">
            <thead>
                <tr>
                    <td>@lang('messages.Total_Weight_Kg'): </td>
                    <td style="text-align: right;">{{ $shipment->total_weight }}</td>
                </tr>
                <tr>
                    <td>@lang('messages.Shipping_Cost'): </td>
                    <td style="text-align: right;">
                        {{ get_money($shipment->shipping_cost, $shipment->currency, 'symbol', 'localize') }}</td>
                </tr>
            </thead>
        </table>
    </section>
</body>

</html>
