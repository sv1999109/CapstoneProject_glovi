<?php

use App\Models\Cities;
use App\Models\Countries;
use App\Models\Messages;
use App\Models\OrderProviders;
use App\Models\Orders;
use App\Models\Shipment;
use App\Models\Packages;
use App\Models\OrderPackages;
use App\Models\ShipmentLog;
use App\Models\ShipmentProviders;
use App\Models\States;
use App\Models\Address;
use App\Models\ExchangeRates;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Dotunj\LaraTwilio\Facades\LaraTwilio;
use Illuminate\Support\Facades\Session;
use App\Services\ShippoService;
#use Shippo;

class Helpers
{
    public static function getTimeZoneList()
    {
        return Cache::rememberForever('timezones_list_collection', function () {
            $timestamp = time();
            foreach (timezone_identifiers_list(\DateTimeZone::ALL) as $key => $value) {
                date_default_timezone_set($value);
                $timezone[$value] = $value . ' (UTC ' . date('P', $timestamp) . ')';
            }
            return collect($timezone)->sortKeys();
        });
    }
    public static function getUserTimeZone()
    {
        return optional(auth()->user())->timezone ?? config('app.timezone');
    }
}
if (!function_exists('get_config')) {
    function get_config($key)
    {
        $cacheKey = "site_{$key}";
        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }
        if ($key !== '') {
            $value = DB::table('site_settings')
                ->where('site_key', $key)
                ->value('value');
            Cache::put($cacheKey, $value, now()->addMinutes(60));
            return $value;
        }
    }
}

if (!function_exists('get_user')) {
    function get_user($key, $user = null)
    {
        if ($key != '') {
            if ($user == '') {
                $user = optional(auth()->user())->id;
            }
            $value = DB::table('users')
                ->whereRaw("id = '$user'")
                ->value($key);
            return $value;
        }
    }
}

if (!function_exists('get_dataBy_id')) {
    function get_dataBy_id($id, $table, $column)
    {
        $query = DB::table($table)
            ->where('id', $id)
            ->value($column);
        if ($query !== '') {
            return $query;
        }
    }
}

if (!function_exists('get_data_db')) {
    function get_data_db($table, $column, $value, $output)
    {
        $query = DB::table($table)
            ->where($column, $value)
            ->value($output);
        if ($query !== '') {
            return $query;
        }
    }
}

if (!function_exists('locale_to_country')) {
    function locale_to_country($locale)
    {
        $var = [
            'en' => 'us',
            'zh' => 'cn',
        ];

        return strtr(strtolower($locale), $var);
    }
}

if (!function_exists('get_content_locale')) {
    function get_content_locale($contents, $locale = null)
    {
        $var_json = json_decode($contents, true);

        if ($locale) {
            if (!empty($var_json[$locale])) {
                $translated_content = $var_json[$locale];

                //is empty? fallback to English
                if (empty($translated_content)) {
                    return $var_json['en'];
                }

                return $translated_content;
            }

            //is empty? fallback to English
            if (!empty($var_json['en'])) {
                return $var_json['en'];
            }
        } else {
            if (!empty($var_json[app()->getLocale()])) {
                $translated_content = $var_json[app()->getLocale()];

                return $translated_content;
            }

            //is empty? fallback to English
            if (!empty($var_json['en'])) {
                return $var_json['en'];
            }
        }
    }
}

if (!function_exists('get_contents_list')) {
    function get_contents_list()
    {
        $list = ['blog', 'faq', 'page', 'partner', 'service'];
        return $list;
    }
}

if (!function_exists('send_notification')) {
    function send_notification($key, $id, $subject, $message)
    {
        // send Notifications

        if ($key == 'shipment' || $key == 'invoice') {
            $shipment = Shipment::where('id', $id)->first();
            $user = User::where('id', $shipment->owner_id)->first();
            if (!$user) {
                exit();
            }

            $userid = $user->id;
            $user_email = $user->email;
            $user_phone = $user->phone;
            $user_email_notification = $user->email_notification;
            $user_site_notification = $user->site_notification;
            $user_shipment_notification = $user->shipment_notification;
            $user_sms_notification = $user->sms_notification;
            $user_invoice_notification = $user->invoice_notification;
            $email_status = $user->email_status;
            $phone_status = $user->phone_status;
            $user_langauge = $user->user_langauge;

            if ($key == 'shipment') {
                // in-site notification
                if (get_config('shipment_notification') == 'enabled' && $user_shipment_notification == 1) {
                    if (get_config('site_notification') == 'enabled' && $user_site_notification == 1) {
                        Messages::create([
                            'userid' => $user->id,
                            'subject' => $message,
                            'message_type' => 2,
                            'reference_id' => $shipment->code,
                            'sender' => 'System',
                        ]);
                    }

                    //send email notification
                    if (get_config('email_notification') == 'enabled' && $user_email_notification == 1 && $email_status == 1) {
                        $to = $user_email;
                        $subject = get_content_locale($subject, $user_langauge);
                        $message = get_content_locale($message, $user_langauge);

                        Mail::mailer(get_config('default_mailer'))->send('email.shipment', ['id' => $shipment->id, 'message' => $message], function ($mail) use ($subject, $to) {
                            $mail->to($to);
                            $mail->subject($subject);
                        });
                    }

                    //send sms notification
                    if (get_config('sms_notification') == 'enabled' && $user_sms_notification == 1 && $phone_status == 1) {
                        $phone = $user_phone;
                        $message = get_content_locale($message, $user_langauge);
                        LaraTwilio::notify($phone, $message);
                    }
                }
            }

            if ($key == 'invoice') {
                $shipment = Shipment::where('invoice_id', $id)->first();

                if (get_config('invoice_notification') == 'enabled' && $user_invoice_notification == 1) {
                    // in-site notification
                    if (get_config('site_notification') == 'enabled' && $user_site_notification == 1) {
                        Messages::create([
                            'userid' => $userid,
                            'subject' => $message,
                            'message_type' => 3,
                            'reference_id' => $shipment->invoice_id,
                            'sender' => 'System',
                        ]);
                    }

                    //send email notification
                    if (get_config('email_notification') == 'enabled' && $user_email_notification == 1 && $email_status == 1) {
                        $to = $user_email;
                        $subject = get_content_locale($subject, $user_langauge);
                        $message = get_content_locale($message, $user_langauge);

                        Mail::mailer(get_config('default_mailer'))->send('email.invoice', ['id' => $shipment->invoice_id, 'message' => $message], function ($mail) use ($subject, $to) {
                            $mail->to($to);
                            $mail->subject($subject);
                        });
                    }
                }
            }
        }
    }
}
if (!function_exists('get_status')) {
    function get_status($type, $status, $list = null)
    {

        //shipment statuses
        if ($type == 'orders') {
            $status_int = [
                '0' => __('messages.Pending'),
                '1' => __('messages.Approved'),
                '2' => __('messages.Canceled'),
            ];

            if ($list) {
                return $status_int;
            } else {
                return strtr($status, $status_int);
            }
        }
        
        //shipment statuses
        if ($type == 'shipments') {
            $status_int = [
                '0' => __('messages.Pending'),
                '1' => __('messages.Label_Created'),
                '2' => __('messages.Unknown'),
                // '2' => __('messages.Pending_Pickup_Confirmation'),
                '3' => __('messages.Ready_for_shipment'),
                '4' => __('messages.Shipped'),
                '5' => __('messages.Arrives_at'),
                '6' => __('messages.Custom_Clearing'),
                '7' => __('messages.Ready_for_Pickup'),
                '8' => __('messages.Out_for_Delivery'),
                '9' => __('messages.Failed_Delivery_Attempts'),
                '10' => __('messages.Canceled'),
                '11' => __('messages.Shipping_On_Hold'),
                '12' => __('messages.Returned'),
                '13' => __('messages.Delivered'),
                '14' => __('messages.Rejected'),
                // '15' => __('messages.Failure'),
            ];

            if ($list) {
                return $status_int;
            } else {
                return strtr($status, $status_int);
            }
        }

        //shipment notes
        if ($type == 'shipment-notes') {
            $status_int = [
                '0' => __('messages.Note_Pending'),
                '1' => __('messages.Note_Label_Created'),
                '2' => __('messages.Note_Unknown'),
                // '2' => __('messages.Note_Pending_Pickup_Confirmation'),
                '3' => __('messages.Note_Ready_for_shipment'),
                '4' => __('messages.Note_Shipped'),
                '5' => __('messages.Note_Arrives_at'),
                '6' => __('messages.Note_Custom_Clearing'),
                '7' => __('messages.Note_Ready_for_Pickup'),
                '8' => __('messages.Note_Out_for_Delivery'),
                '9' => __('messages.Note_Failed_Delivery_Attempts'),
                '10' => __('messages.Note_Canceled'),
                '11' => __('messages.Note_Shipping_On_Hold'),
                '12' => __('messages.Note_Returned'),
                '13' => __('messages.Note_Delivered'),
                '14' => __('messages.Note_Rejected'),
                // '15' => __('messages.Note_Failure'),
            ];

            if ($list) {
                return $status_int;
            } else {
                return strtr($status, $status_int);
            }
        }

        //Tracking Shippo
        if ($type == 'shippo') {
            $status_int = [
                'PRE_TRANSIT' => 1,
                'UNKNOWN' =>  2,
                'TRANSIT' =>  4,
                'FAILURE' => 9,
                'RETURNED' =>  12,
                'DELIVERED' =>  13,

            ];

            if ($list) {
                return $status_int;
            } else {
                return strtr($status, $status_int);
            }
        }
        //user statuses
        if ($type == 'users') {
            $status_int = [
                '0' => __('-'),
                '1' => __('messages.Active'),
                '2' => __('messages.Inactive'),
                '3' => __('messages.Suspended'),
                '4' => __('messages.Banned'),
            ];

            if ($list) {
                return $status_int;
            } else {
                return strtr($status, $status_int);
            }
        }

        //posts statuses
        if ($type == 'posts') {
            $status_int = [
                '0' => __('-'),
                '1' => trans_choice('messages.Publish', 2),
                '2' => __('messages.Draft'),
            ];

            if ($list) {
                return $status_int;
            } else {
                return strtr($status, $status_int);
            }
        }

        //default statuses
        if ($type == '') {
            $status_int = [
                '0' => __('-'),
                '1' => __('messages.Active'),
                '2' => __('messages.Inactive'),
                '3' => __('messages.Pending'),
                '4' => __('messages.Canceled'),
                '5' => __('messages.Disabled'),
            ];
            return strtr($status, $status_int);
        }
    }
}

if (!function_exists('get_status_color')) {
    function get_status_color($color, $type = null)
    {
        //default statuses

        $status_int = [
            '0' => 'danger',
            '1' => 'success',
            '2' => 'danger',
            '3' => 'warning',
            '4' => 'danger',
            '5' => 'secondary',
        ];

        if ($type == 'orders') {
            $status_int = [
                '0' => 'warning',
                '1' => 'success',
                '2' => 'danger',
                
            ];
        }

        if ($type == 'shipments') {
            $status_int = [
                '0' => 'warning',
                '1' => 'primary',
                '2' => 'warning',
                '3' => 'secondary',
                '4' => 'primary',
                '5' => 'info',
                '6' => 'info',
                '7' => 'primary',
                '8' => 'primary',
                '9' => 'danger',
                '10' => 'danger',
                '11' => 'warning',
                '12' => 'danger',
                '13' => 'success',
                '14' => 'danger',
            ];
        }
        //str_replace()
        return strtr($color, $status_int);
    }
}

if (!function_exists('get_badge')) {
    function get_badge($color, $status)
    {
        $html = '<div class="status"> <span class="badge bg-' . $color . '-subtle text-' . $color . ' font-12">' . $status . '</span> </div>';
        return $html;
    }
}

if (!function_exists('note_helper')) {
    function note_helper()
    {
        $notes = [
            '0' => 'messages.Note_Pending',
            '1' => 'messages.Note_Label_Created',
            '2' => 'messages.Note_Pending_Pickup_Confirmation',
            '3' => 'messages.Note_Ready_for_shipment',
            '4' => 'messages.Note_Shipped',
            '5' => 'messages.Note_Arrives_at',
            '6' => 'messages.Note_Custom_Clearing',
            '7' => 'messages.Note_Ready_for_Pickup',
            '8' => 'messages.Note_Out_for_Delivery',
            '9' => 'messages.Note_Failed_Delivery_Attempts',
            '10' => 'messages.Note_Canceled',
            '11' => 'messages.Note_Shipping_On_Hold',
            '12' => 'messages.Note_Returned',
            '13' => 'messages.Note_Delivered',
            '14' => 'messages.Note_Rejected',
        ];

        return $notes;
    }
}

if (!function_exists('get_timezone')) {
    function get_timezone($item, $type = null)
    {
        //find by id
        $timezone = DB::table('timezones')
            ->where('id', $item)
            ->first();

        if (
            DB::table('timezones')
            ->where('id', $item)
            ->count() == 0
        ) {
            //find by name
            $timezone = DB::table('timezones')
                ->where('name', $item)
                ->first();
        }
        if ($timezone) {
            if ($type == 'name') {
                return $timezone->name;
            }
            if ($type == 'id') {
                return $timezone->id;
            }
        }
    }
}

if (!function_exists('country_dropdown')) {
    //selected locations would be retrieved from a database or as post data
    function country_dropdown($name, $id = null, $class = null, $selected = null)
    {
        // Getting the array of countries from the database
        $query = DB::table('countries')
            ->where('status', 1)
            ->get();
        $html = "<select name='{$name}' id='{$id}' class='{$class}'>";

        $html .= "<option value=''>Select</option>";

        if ($query) {
            foreach ($query as $key => $item) {
                if ($selected == $item->id) {
                    $selected = 'selected';
                }
                $html .= "<option value='{$item->id}' {$selected}>{$item->name}</option>";
                $selected = null;
            }
        }

        $html .= '</select>';
        return $html;
    }
}

if (!function_exists('country_name')) {
    function country_name($selected_country)
    {
        // Getting the array of countries from the database

        $countries = Countries::where('iso2', $selected_country)->first();

        if (!$countries) {
            //if not found try searching by id
            $countries = Countries::where('id', $selected_country)->first();
        }
        if ($countries) {
            $selected = $countries->name;
            return $selected;
        }
    }
}

if (!function_exists('country_code')) {
    function country_code($selected_country)
    {
        // Getting the array of countries from database

        $countries = Countries::where('name', $selected_country)->first();

        if (!$countries) {
            //if not found try searching by id
            $countries = Countries::where('id', $selected_country)->first();
        }
        if ($countries) {
            $selected = $countries->iso2;
            return $selected;
        }
    }
}

if (!function_exists('country_id')) {
    function country_id($selected_country)
    {
        // Getting the array of countries from database

        $countries = Countries::where('name', $selected_country)->first();

        if (!$countries) {
            //if not found try searching by id
            $countries = Countries::where('iso2', $selected_country)->first();
        }
        if (!empty($countries)) {
            $selected = $countries->id;
            return $selected;
        }
    }
}

if (!function_exists('state_id')) {
    function state_id($selected)
    {
        // Getting id of states from database

        $model = States::where('name', $selected)->first();

        if (!empty($model)) {
            $selected = $model->id;
            return $selected;
        }
    }
}

if (!function_exists('get_name')) {
    function get_name($id, $table)
    {
        // Return to db name
        return DB::table($table)
            ->where('id', $id)
            ->value('name');
    }
}

if (!function_exists('get_currency')) {
    function get_currency($request)
    {
        //Localize currency
        if (get_config('currency_localize') == 'enabled') {
            $code = optional(auth()->user())->currency ? optional(auth()->user())->currency : get_config('currency_code');
            $symbol = \App\Models\Currency::where('code', $code)->value('symbol');
            //request is code format
            if ($request == 'code') {
                return $code;
            }

            //request is symbol format
            if ($request == 'symbol') {
                return $symbol;
            }
        } else {
            //use default currency
            $code = get_config('currency_code');
            $symbol = \App\Models\Currency::where('code', $code)->value('symbol');
            //request is code format
            if ($request == 'code') {
                return $code;
            }

            //request is symbol format
            if ($request == 'symbol') {
                return $symbol;
            }
        }
    }
}

if (!function_exists('get_money')) {
    function get_money($amount, $currency, $request = null, $localize = null)
    {
        //Fetch currencies data
        $symbol = \App\Models\Currency::where('code', $currency)->value('symbol');
        $code = $currency;
        $converted_amount = $amount;
        //Localize currency
        if ($localize) {
            if (get_config('currency_localize') == 'enabled') {
                $code = optional(auth()->user())->currency ? optional(auth()->user())->currency : get_config('currency_code');
                $symbol = \App\Models\Currency::where('code', $code)->value('symbol');
                $converted_amount = convert_currency($currency, $code, $amount);
            }
        }

        if (get_config('currency_localize') != 'enabled') {
            // use default currency
            $code = get_config('currency_code');
            if ($code != '') {
                $symbol = \App\Models\Currency::where('code', $code)->value('symbol');
                $converted_amount = convert_currency($currency, $code, $amount);
            }
        }

        //initalize currency conversion
        if ($converted_amount != '') {
            $amount = $converted_amount;
        } else {
            //revert back
            $code = $currency;
            $symbol = \App\Models\Currency::where('code', $code)->value('symbol');
        }

        //request is full money format
        if ($request == 'full') {
            $format = $symbol . number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $amount)), 2) . ' ' . $code;
            return $format;
        }

        //request is code money format
        if ($request == 'code') {
            $format = number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $amount)), 2) . ' ' . $code;
            return $format;
        }

        //request is code prefix money format
        if ($request == 'code_prefix') {
            $format = $code . ' ' . number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $amount)), 2);
            return $format;
        }

        //request is symbol money format
        if ($request == 'symbol') {
            $format = $symbol . number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $amount)), 2);
            return $format;
        }

        //request is only code money format
        if ($request == 'only_code') {
            $format = $code;
            return $format;
        }

        //request is symbol money format
        if ($request == 'only_symbol') {
            $format = $symbol;
            return $format;
        }

        //request is symbol money format
        if ($request == 'input') {
            $format = number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $amount)), 2);
            $format = trim(str_replace(',', '', $format));
            $format = trim(str_replace(' ', '', $format));
            return $format;
        }

        //request is only amount money format
        if ($request == '') {
            $format = number_format(sprintf('%0.2f', preg_replace('/[^0-9.]/', '', $amount)), 2);
            return $format;
        }
    }
}

if (!function_exists('convert_currency')) {
    function convert_currency($currency, $code, $amount)
    {
        $amount = (float) $amount;
        $currency = strtoupper($currency);
        $code = strtoupper($code);
        $amount = trim(str_replace(',', '', $amount));
        $exchange_from = DB::table('exchange_rates')
            ->where('code', $currency)
            ->first();
        $exchange_to = DB::table('exchange_rates')
            ->where('code', $code)
            ->first();

        if (isset($exchange_from) && isset($exchange_to)) {
            $rate = $exchange_from->exchange_rate;
            $rate2 = $exchange_to->exchange_rate;
            if ($currency == $code) {
                $convert = $amount;
            } elseif ($rate > 0 && $rate2 > 0) {
                $convert = ($amount / $rate) * $rate2;
            } else {
                $convert = '';
            }
        } else {
            $convert = '';
        }

        return $convert;
    }
}

if (!function_exists('generate_tracking_no')) {
    function generate_tracking_no()
    {
        $number = mt_rand(1000000000, 9999999999);
        return $number;
    }
}

if (!function_exists('get_cost')) {
    function get_cost($adresss_sender, $adresss_receiver, $weight, $address_data = null)
    {
        //get address data
        $address = Address::where('id', $adresss_sender)->first();

        if ($address) {
            $origin_country = $address->country;
            $origin_state = $address->state;
        } else {
            //reset value
            $origin_country = '';
            $origin_state = '';
        }

        $address2 = Address::where('id', $adresss_receiver)->first();
        if ($address2) {
            $destination_country = $address2->country;
            $destination_state = $address2->state;
            $destination_city = $address2->city;
            $destination_area = $address2->area;
        } else {
            //reset value
            $destination_country = '';
            $destination_state = '';
            $destination_city = '';
            $destination_area = '';
        }
        if (isset($address_data)) {
            $address_data = json_decode($address_data, true);
            $origin_country = $address_data['sender_data']['country'];
            $origin_state = $address_data['sender_data']['state'];
            $destination_country = $address_data['receiver_data']['country'];
            $destination_state = $address_data['receiver_data']['state'];
            $destination_city = $address_data['receiver_data']['city'];
            // $destination_area = '';
        }


        //get areas shipping costs if exist
        //if address has area
        if (isset($destination_area)) {
            //query data
            $cost = DB::table('shipping_cost')
                ->whereRaw("origin_country = '$origin_country' AND origin_state = '$origin_state' AND destination_country = '$destination_country' AND destination_state = '$destination_state' AND destination_city = '$destination_city' AND destination_area = '$destination_area' AND weight_from <='$weight' AND weight_to >='$weight'")
                ->first();

            $cost_amount = isset($cost) ? $cost->amount : '';
            $currency = isset($cost) ? $cost->currency : '';
        }
        //if not, get cost from city
        elseif (isset($destination_city)) {
            //query data
            $cost = DB::table('shipping_cost')
                ->whereRaw("origin_country = '$origin_country' AND origin_state = '$origin_state' AND destination_country = '$destination_country' AND destination_state = '$destination_state' AND destination_city = '$destination_city' AND weight_from <='$weight' AND weight_to >='$weight'")
                ->first();

            $cost_amount = isset($cost) ? $cost->amount : '';
            $currency = isset($cost) ? $cost->currency : '';
        }
        //if not, get cost from state
        else {
            //query data
            $cost = DB::table('shipping_cost')
                ->whereRaw("origin_country = '$origin_country' AND origin_state = '$origin_state' AND destination_country = '$destination_country' AND destination_state = '$destination_state' AND weight_from <='$weight' AND weight_to >='$weight'")
                ->first();

            $cost_amount = isset($cost) ? $cost->amount : '';
            $currency = isset($cost) ? $cost->currency : '';
        }

        if ($cost != '') {
            //convert currency
            $converted_cost = convert_currency($currency, get_config('currency_code'), $cost_amount);
            return $converted_cost;
        } else {
            //retrieve default/global shipping cost
            $cost_amount = get_config('default_shipping_cost');
            $currency = get_config('default_shipping_cost_currency');

            $converted_cost = convert_currency($currency, get_config('currency_code'), $cost_amount);
            return $converted_cost;
        }
    }
}


if (!function_exists('get_exchange_rates')) {
    function get_exchange_rates()
    {
        $access_key = get_config('xrate_key');
        $req_url = 'https://api.exchangerate.host/latest?base=USD&?access_key=' . $access_key . '';
        $url = 'https://api.transferwise.com/v1/rates?source=USD';

        // $data = json_encode($data);

        $headers = array(
            //'Content-Type: application/json',
            // "Shippo-Test-Mode: $mode",
            "Authorization: Bearer $access_key", // Sandbox API key
        );

        $curl = curl_init();
        curl_setopt($curl, CURLOPT_URL, $url);
        // curl_setopt($curl, CURLOPT_POST, true);
        // curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
        curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

        $response_json = curl_exec($curl);
        curl_close($curl);

        // return json_decode($response_json, true);

        if (false !== $response_json) {
            try {
                $response = json_decode($response_json, true);
                //echo print_r($response);

                // if ($response->rate === true) {

                foreach ($response as $key => $value) {
                    $rate = ExchangeRates::where('code', $value['target'])->first();

                    if (is_null($rate)) {
                        echo "<br> 1 " . $value['source'] . "  = " . $value['target'] . "" . $value['rate'] . " ....created<br>";
                        $rate = new ExchangeRates([
                            'code' => $value['target'],
                            'exchange_rate' =>  $value['rate'],
                            'status' => 1,
                        ]);
                        $rate->save();
                    } else {

                        echo "<br> 1 " . $value['source'] . "  = " . $value['target'] . "" . $value['rate'] . " ...updated<br>";
                        $rate->exchange_rate =  $value['rate'];
                        $rate->update();
                    }
                }
                //}
            } catch (Exception $e) {
                // Handle JSON parse error...
            }
        }
    }
}

if (!function_exists('convert_unit')) {
    function convert_unit($value, $format)
    {

        if ($format == 'cm_to_lb') {
            // convert cm to inches
            $inches = $value / 2.54;

            // convert inches to pounds
            $convert = $inches / 0.45359237;
        }

        if ($format == 'kg_to_lb') {

            // convert inches to pounds
            $convert = $value / 2.20462;
        }

        return $convert;
    }
}

if (!function_exists('get_address')) {
    function get_address($id, $format)
    {
        $address = Address::where('id', $id)->first();
        if (!$address) {
            return false;
        }
        if ($format == 'full') {
            $addresses = "{$address->firstname} {$address->lastname},<br>";
            if ($address->area != '') {
                $addresses .= "{$address->house_no} ";
            }
            $addresses .= "{$address->address},<br>";

            if ($address->city != '') {
                $addresses .= get_name($address->city, 'cities') . ", ";
            }
            if ($address->postal != '') {
                $addresses .= $address->postal . ' ';
            }
            $addresses .= "" . get_name($address->state, 'states') . ", " . get_name($address->country, 'countries') . ".<br>";
            $addresses .= "" . chunk_split($address->phone, 3, ' ')  . " {$address->email}";
        }

        if ($format == 'no_contacts') {
            $addresses = "{$address->firstname} {$address->lastname},<br>";
            $addresses .= "{$address->address},<br>";

            if ($address->city != '') {
                $addresses .= get_name($address->city, 'cities') . ", ";
            }
            if ($address->postal != '') {
                $addresses .= $address->postal . ' ';
            }
            $addresses .= "" . get_name($address->state, 'states') . ", " . get_name($address->country, 'countries') . ".";
            //$addresses .= "{$address->phone} {$address->email}";
        }

        if ($format == 'no_email') {
            $addresses = "{$address->firstname} {$address->lastname},<br>";
            $addresses .= "{$address->address},<br>";

            if ($address->city != '') {
                $addresses .= get_name($address->city, 'cities') . ", ";
            }
            if ($address->postal != '') {
                $addresses .= $address->postal . ' ';
            }
            $addresses .= "" . get_name($address->state, 'states') . ", " . get_name($address->country, 'countries') . ".<br>";
            $addresses .= "" . chunk_split($address->phone, 3, ' ')  . "";
        }

        return $addresses;
    }
}

if (!function_exists('shippo')) {
    function shippo($type, array $data, $endpoint = null)
    {
        $api_key = 'shippo_test_3cf13d3fd85b0a6a8647208c2cb5533c760a06c5';
        $api_key = get_config('shippo_key');
        $mode = get_config('shippo_mode');
        if ($type == 'shipment') {
            $url = 'https://api.goshippo.com/shipments/'; // Sandbox API endpoint URL

            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "Shippo-Test-Mode: $mode",
                "Authorization: ShippoToken $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return json_decode($response, true);
        }
        if ($type == 'transaction') {
            $url = 'https://api.goshippo.com/transactions'; // Sandbox API endpoint URL

            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "Shippo-Test-Mode: $mode",
                "Authorization: ShippoToken $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return json_decode($response, true);
        }

        if ($type == 'address') {
            $url = 'https://api.goshippo.com/addresses'; // Sandbox API endpoint URL

            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "Shippo-Test-Mode: $mode",
                "Authorization: ShippoToken $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return json_decode($response, true);
        }

        if ($type == 'status') {
            $url = 'https://api.goshippo.com/tracks/'; // Sandbox API endpoint URL

            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "Shippo-Test-Mode: $mode",
                "Authorization: ShippoToken $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);

            return json_decode($response, true);
        }
    }
}

if (!function_exists('get_shipment_status')) {
    function get_shipment_status()
    {
        $shipments =  ShipmentProviders::whereRaw("provider > '1' AND status != '13'")->orderBy('created_at', 'asc')->get();
        foreach ($shipments as $shipment) {

            // shippo
            if ($shipment->provider == 3) {
                $tracking = shippo('status', [
                    'carrier' => strtolower($shipment->name),
                    'tracking_number' => $shipment->tracking_number,
                ]);

                $response = json_decode($tracking, true);

                if (false !== $response) {
                    try {
                        $response = json_decode($response, true);
                        $shipment_id = $shipment->shipment_id;
                        $main_shipment =  Shipment::where('code', $shipment_id)->first();

                        if (isset($tracking['tracking_status']['status']) && $main_shipment) {


                            $status = get_status('shippo', $tracking['tracking_status']['status']);


                            if ($status != $shipment->shipment_status) {


                                $logs = new ShipmentLog();
                                $logs->note = $status;
                                $logs->shipment_id = $shipment->shipment_id;
                                $logs->save();
                                // send Notifications
                                foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                                    $subject[$localeCode] =  Lang::get('messages.Status_Update', [], $localeCode) . " - " . $shipment_id;
                                    $message[$localeCode] =  Lang::get('messages.' . get_status('shipment-notes', $status), [], $localeCode) . " - " . $shipment_id;
                                }
                                send_notification('shipment', $main_shipment->id, json_encode($subject), json_encode($message));
                            }

                            // update statuses
                            Shipment::where('code', $shipment_id)->update([
                                'status' =>  $status,
                                'note' => $status
                            ]);
                            ShipmentProviders::where('shipment_id', $shipment_id)->update([
                                'shipment_status' =>  $status,
                                'tracking_status' => $status
                            ]);
                        }
                    } catch (Exception $e) {
                        // Handle JSON parse error...
                    }
                }
            }
        }
    }
}

if (!function_exists('eurosender')) {
    function eurosender($type, array $data, $endpoint = null)
    {
        $api_key = get_config('eurosender_key');

        if ($type == 'quotes') {
            $url = 'https://api.eurosender.com/v1/quotes'; // Sandbox API endpoint URL

            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "x-api-key: $api_key",
                "Authorization: Bearer $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);
            // die($response);
            $result = json_decode($response, true);

            // Process the result
            if (isset($result['options'])) {
                $quotes = $result['options']['serviceTypes'];

                //  pass packages to json
                $reset_package = '[';

                foreach ($quotes as $quote) {

                    $name = $quote['name'];
                    $edt = $quote['edt'];
                    $totalPrice = $quote['price']['original']['gross'];
                    $currency = $quote['price']['original']['currencyCode'];
                    $reset_package .= '{"object_id": "' . $name . '", "attributes": [], "amount": "' . $totalPrice . '", "currency": "' . $currency . '", "amount_local": "' . $totalPrice . '", "currency_local": "' . $currency . '", "provider": "Eurosender", "provider_image_75": "' . asset(get_contents_admin('logo_dashboard', '', 'all')) . '", "estimated_days": "' . $edt . '", "duration_terms": "", "servicelevel": { "name": "' . $name . '", "token": "' . $name . '", "terms": "" }},';

                    //$service = $quote['service'];
                    //echo "Service: $name, Total Price: $totalPrice $currency (EDT $edt)" . PHP_EOL;
                }

                $reset_package .= '{}]';
                $new_pacakage = json_decode($reset_package, true);
                // remove the empty array
                unset($new_pacakage[count($new_pacakage) - 1]);
                $rates = ['rates' => $new_pacakage];
                return ($rates);
            } else {
                $errorMessage = $response;
                return "Error: $errorMessage" . PHP_EOL;
            }
        }


        if ($type == 'orders') {
            $url = 'https://api.eurosender.com/v1/orders'; // Sandbox API endpoint URL
            if ($endpoint == 'validate_creation') {
                $url = 'https://api.eurosender.com/v1/orders/validate_creation'; // Sandbox API endpoint URL
            }

            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "x-api-key: $api_key",
                "Authorization: Bearer $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);
            //  die($response);
            $result = json_decode($response, true);

            // Process the result
            if (isset($result['orderCode']) && isset($result['status'])) {
                return $result;
            } else {
                $errorMessage = $result['title'];
                return  $result;
            }
        }
    }
}

if (!function_exists('eurosender2')) {
    function eurosender2($type)
    {
        $api_key = '830b6017-d3c3-4cea-952e-e15ab408e4fc';

        if ($type == 'quotes') {
            $url = 'https://api.eurosender.com/v1/quotes'; // Sandbox API endpoint URL

            $data = [
                "shipment" => [
                    "pickupAddress" => [
                        "country" => "DE",
                        "zip" => "10178",
                        "city" => "Berlin",
                        "cityId" => null,
                        "street" => "Karl-Liebknecht-Str. 25",
                        "additionalInfo" => null,
                        "region" => null,
                        "regionId" => null,
                        "customFields" => [
                            //[
                            //"local_phone_requiredX" => "203 129 2884",
                            //]
                        ]
                    ],
                    "deliveryAddress" => [
                        "country" => "DE",
                        "zip" => "10178",
                        "city" => "Berlin",
                        "cityId" => null,
                        "street" => "Karl-Liebknecht-Str. 25",
                        "additionalInfo" => null,
                        "region" => null,
                        "regionId" => null,
                        "customFields" => [
                            // ["name" => 'remote_area', 'value' => 12344]
                        ]
                    ],
                    "pickupDate" => "2023-08-21T08:55:41+02:00",

                    "pickupContact" => [
                        "name" => "Eurosender SARL",
                        "phone" => "+442031292884"
                    ],
                    "deliveryContact" => [
                        "name" => "Eurosender SARL",
                        "phone" => "+442031292884"
                    ],
                    "addOns" => []
                ],
                "parcels" => [
                    "envelopes" => [],
                    "packages" => [
                        [
                            "parcelId" => "F00034",
                            "width" => 15,
                            "height" => 15,
                            "length" => 15,
                            "weight" => 1,
                            "content" => "string",
                            "value" => 150,
                            "quantity" => 1
                        ]
                    ]
                ],
                "paymentMethod" => "credit",
                "serviceType" => "selection",
                "currencyCode" => "EUR",
                "insuranceId" => null
            ];



            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "x-api-key: $api_key",
                "Authorization: Bearer $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);
            die($response);
            $result = json_decode($response, true);

            // Process the result
            if ($result['status'] == 'OK') {
                $quotes = $result['quotes'];
                foreach ($quotes as $quote) {
                    $totalPrice = $quote['total_price'];
                    $service = $quote['service'];
                    echo "Service: $service, Total Price: $totalPrice" . PHP_EOL;
                }
            } else {
                $errorMessage = $result['message'];
                echo "Error: $errorMessage" . PHP_EOL;
            }
        }


        if ($type == 'orders') {
            $url = 'https://sandbox-api.eurosender.com/v1/orders'; // Sandbox API endpoint URL

            $data = [
                "shipment" => [
                    "pickupAddress" => [
                        "country" => "DE",
                        "zip" => "10178",
                        "city" => "Berlin",
                        "cityId" => null,
                        "street" => "Karl-Liebknecht-Str. 25",
                        "additionalInfo" => null,
                        "region" => null,
                        "regionId" => null,
                        "customFields" => [
                            //[
                            //"local_phone_requiredX" => "203 129 2884",
                            //]
                        ]
                    ],
                    "deliveryAddress" => [
                        "country" => "DE",
                        "zip" => "10178",
                        "city" => "Berlin",
                        "cityId" => null,
                        "street" => "Karl-Liebknecht-Str. 25",
                        "additionalInfo" => null,
                        "region" => null,
                        "regionId" => null,
                        "customFields" => [
                            // ["name" => 'remote_area', 'value' => 12344]
                        ]
                    ],
                    "pickupDate" => "2023-08-11T08:55:41+02:00",

                    "pickupContact" => [
                        "name" => "Eurosender SARL",
                        "phone" => "+442031292884"
                    ],
                    "deliveryContact" => [
                        "name" => "Eurosender SARL",
                        "phone" => "+442031292884"
                    ],
                    "addOns" => []
                ],
                "parcels" => [
                    "envelopes" => [],
                    "packages" => [
                        [
                            "parcelId" => "A00001",
                            "quantity" => 1,
                            "width" => 14,
                            "height" => 14,
                            "length" => 15,
                            "weight" => 2,
                            "content" => "books",
                            "value" => 150
                        ]
                    ],
                    "pallets" => []
                ],
                "paymentMethod" => "credit",
                "serviceType" => "selection",
                "currencyCode" => "EUR",
                "insuranceId" => null,
                "orderContact" => [
                    "email" => "user@example.com",
                    "name" => "John Doe",
                    "phone" => "+442031292884",
                    "contactMethod" => "email",
                    "contactCustomerType" => null
                ]
            ];



            $data = json_encode($data);

            $headers = array(
                'Content-Type: application/json',
                "x-api-key: $api_key",
                "Authorization: Bearer $api_key", // Sandbox API key
            );

            $curl = curl_init();
            curl_setopt($curl, CURLOPT_URL, $url);
            curl_setopt($curl, CURLOPT_POST, true);
            curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
            curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
            curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

            $response = curl_exec($curl);
            curl_close($curl);
            // die($response);
            $result = json_decode($response, true);

            // Process the result
            if ($result['orderCode'] != 'OK') {
                $quotes = $result['quotes'];
                foreach ($quotes as $quote) {
                    $totalPrice = $quote['total_price'];
                    $service = $quote['service'];
                    echo "Service: $service, Total Price: $totalPrice" . PHP_EOL;
                }
            } else {
                $errorMessage = $result['message'];
                echo "Error: $errorMessage" . PHP_EOL;
            }
        }
    }
}

if (!function_exists('plan_name')) {
    function shipping_plan_name($type)
    {
        $type = ($type);

        $replace = str_ireplace(['Eurosender', '_'], ['', ' '],  $type);
        return $replace;
    }
}


