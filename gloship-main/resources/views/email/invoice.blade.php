@php
    $shipment = \App\Models\Shipment::where('invoice_id', '4464375985')->first();
@endphp
<!DOCTYPE html>
<html>

<head>
    <title></title>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <style type="text/css">
        @media screen {
            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 400;
                src: local('Lato Regular'), local('Lato-Regular'), url(https://fonts.gstatic.com/s/lato/v11/qIIYRU-oROkIk8vfvxw6QvesZW2xOQ-xsNqO47m55DA.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: normal;
                font-weight: 700;
                src: local('Lato Bold'), local('Lato-Bold'), url(https://fonts.gstatic.com/s/lato/v11/qdgUG4U09HnJwhYI-uK18wLUuEpTyoUstqEm5AMlJo4.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 400;
                src: local('Lato Italic'), local('Lato-Italic'), url(https://fonts.gstatic.com/s/lato/v11/RYyZNoeFgb0l7W3Vu1aSWOvvDin1pK8aKteLpeZ5c0A.woff) format('woff');
            }

            @font-face {
                font-family: 'Lato';
                font-style: italic;
                font-weight: 700;
                src: local('Lato Bold Italic'), local('Lato-BoldItalic'), url(https://fonts.gstatic.com/s/lato/v11/HkF_qI1x_noxlxhrhMQYELO3LdcAZYWl9Si6vvxL-qU.woff) format('woff');
            }
        }

        /* CLIENT-SPECIFIC STYLES */
        body,
        table,
        td,
        a {
            -webkit-text-size-adjust: 100%;
            -ms-text-size-adjust: 100%;
        }

        table,
        td {
            mso-table-lspace: 0pt;
            mso-table-rspace: 0pt;
        }

        img {
            -ms-interpolation-mode: bicubic;
        }

        /* RESET STYLES */
        img {
            border: 0;
            height: auto;
            line-height: 100%;
            outline: none;
            text-decoration: none;
        }

        table {
            border-collapse: collapse !important;
        }

        body {
            height: 100% !important;
            margin: 0 !important;
            padding: 0 !important;
            width: 100% !important;
        }

        /* iOS BLUE LINKS */
        a[x-apple-data-detectors] {
            color: inherit !important;
            text-decoration: none !important;
            font-size: inherit !important;
            font-family: inherit !important;
            font-weight: inherit !important;
            line-height: inherit !important;
        }

        /* MOBILE STYLES */
        @media screen and (max-width:600px) {
            h1 {
                font-size: 32px !important;
                line-height: 32px !important;
            }
        }

        /* ANDROID CENTER FIX */
        div[style*="margin: 16px 0;"] {
            margin: 0 !important;
        }
    </style>
</head>

<body style="background-color: #f4f4f4; margin: 0 !important; padding: 0 !important;">
    <!-- HIDDEN PREHEADER TEXT -->
    <div
        style="display: none; font-size: 1px; color: #fefefe; line-height: 1px; font-family: 'Lato', Helvetica, Arial, sans-serif; max-height: 0px; max-width: 0px; opacity: 0; overflow: hidden;">
        @lang('messages.Email_Invoice_Message')
    </div>
    <table border="0" cellpadding="0" cellspacing="0" width="100%">
        <!-- LOGO -->
        <tr>
            <td bgcolor="#2b8b10" align="center">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td align="center" valign="top" style="padding: 40px 10px 40px 10px;"> </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#2b8b10" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center" valign="top"
                            style="padding: 40px 20px 20px 20px; border-radius: 4px 4px 0px 0px; color: #111111; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 48px; font-weight: 400; letter-spacing: 4px; line-height: 48px;">
                            <h1 style="font-size: 48px; font-weight: 400; margin: 2;">@lang('messages.Email_Invoice_Subject')</h1>

                            @if (get_theme_config('site_logo_main') == 'enabled')
                                <img src="{{ asset(get_contents_admin('logo_main', '', 'all')) }}"
                                    alt="{{ get_content_locale(get_config('site_name')) }}" width="125"
                                    height="120" style="display: block; border: 0px;" />
                            @else
                                {{ get_content_locale(get_config('site_name')) }}
                            @endif
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width:600px;">
                    <tr>
                        <td bgcolor="#ffffff" align="center"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 25px;">
                            <img src="https://img.icons8.com/carbon-copy/100/000000/checked-checkbox.png"
                                width="125" height="120" style="display: block; border: 0px;" /><br>
                            <h2
                                style="font-size: 30px; font-weight: 800; line-height: 36px; color: #333333; margin: 0;">
                                @lang('messages.Email_Thank_You')
                            </h2>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left"
                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding-top: 10px;">
                            <p style="font-size: 16px; font-weight: 400; line-height: 24px; color: #777777; text-align: center">
                                @lang('messages.Email_Invoice_Message')
                                <br>
                                <span> @lang('messages.Tracking_Number'): <b> {{ $shipment->code }}</b></span>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding-top: 20px;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="75%" align="left" bgcolor="#eeeeee"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                       {{ trans_choice('messages.Invoice', 1) }} #
                                    </td>
                                    <td width="25%" align="left" bgcolor="#eeeeee"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px;">
                                        {{ $shipment->invoice_id }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="75%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                        {{ trans_choice('messages.Item', 2) }} ({{ $shipment->qty }})
                                    </td>
                                    <td width="25%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 15px 10px 5px 10px;">
                                        {{ get_money($shipment->subtotal, $shipment->currency, 'symbol', 'localize') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="75%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                        @lang('messages.Tax')
                                    </td>
                                    <td width="25%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                        {{ get_money($shipment->tax, $shipment->currency, 'symbol', 'localize') }}
                                    </td>
                                </tr>
                                <tr>
                                    <td width="75%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                       @lang('messages.Discount')
                                    </td>
                                    <td width="25%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px; padding: 5px 10px;">
                                        {{ get_money($shipment->discount, $shipment->currency, 'symbol', 'localize') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td bgcolor="#ffffff" align="left" style="padding-top: 20px;">
                            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                                <tr>
                                    <td width="75%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                                        @lang('messages.Total')
                                    </td>
                                    <td width="25%" align="left"
                                        style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 800; line-height: 24px; padding: 10px; border-top: 3px solid #eeeeee; border-bottom: 3px solid #eeeeee;">
                                        {{ get_money($shipment->shipping_cost, $shipment->currency, 'symbol', 'localize') }}
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
        <tr>
            <td height="100%" valign="top" width="100%" bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%"
                    style="max-width:600px;">
                    <tr>
                        <td align="center" valign="top" style="font-size:0; padding: 10px;" bgcolor="#ffffff">
                            <div
                                style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">

                                <table align="left" border="0" cellpadding="0" cellspacing="0"
                                    width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top"
                                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                            <p style="font-weight: 800;">Delivery Address</p>
                                            <p>
                                                {{ $shipment->receiver_address }},
                                                <br>
                                                {{ get_name($shipment->to_area, 'areas') }},
                                                {{ get_name($shipment->receiver_city, 'cities') }},
                                                <br>
                                                {{ get_name($shipment->receiver_state, 'states') }},
                                                {{ get_name($shipment->receiver_country, 'countries') }}
                                            </p>

                                        </td>
                                    </tr>
                                </table>
                            </div>
                            <div
                                style="display:inline-block; max-width:50%; min-width:240px; vertical-align:top; width:100%;">
                                <table align="left" border="0" cellpadding="0" cellspacing="0"
                                    width="100%" style="max-width:300px;">
                                    <tr>
                                        <td align="left" valign="top"
                                            style="font-family: Open Sans, Helvetica, Arial, sans-serif; font-size: 16px; font-weight: 400; line-height: 24px;">
                                            <p style="font-weight: 800;">Estimated Delivery Date</p>
                                            <p>{{ \Carbon\Carbon::parse($shipment->delivery_date)->setTimezone(\Helpers::getUserTimeZone())->format('j M, Y') }}</p>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 30px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#2b8b10" align="center"
                            style="padding: 30px 30px 30px 30px; border-radius: 4px 4px 4px 4px; color: #fff; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 18px; font-weight: 400; line-height: 25px;">
                            <h2 style="font-size: 20px; font-weight: 400; color: #fff; margin: 0;">@lang('messages.Email_Need_Any_Help')
                            </h2>
                            <p style="margin: 0;"><a href="mailto:{{ get_config('site_email_support') }}"
                                    target="_blank" style="color: #fff;">@lang('messages.Email_We_Here')</a></p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td bgcolor="#f4f4f4" align="center" style="padding: 0px 10px 0px 10px;">
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px;">
                    <tr>
                        <td bgcolor="#f4f4f4" align="left"
                            style="padding: 0px 30px 30px 30px; color: #666666; font-family: 'Lato', Helvetica, Arial, sans-serif; font-size: 14px; font-weight: 400; line-height: 18px;">
                            <br>
                            <p style="margin: 0;">@lang('messages.Email_Generated')</p>
                            <p style="text-align: center">{{ get_content_locale(get_config('site_copyright')) }}</p>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>

</html>
