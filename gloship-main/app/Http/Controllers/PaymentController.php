<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Cities;
use App\Models\OrderPackages;
use App\Models\OrderProviders;
use App\Models\Orders;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\Shipment;
use App\Models\ShipmentLog;
use App\Models\ShipmentProviders;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Services\ShippoService;
use Omnipay\Omnipay;
use Omnipay\PayPal;
use Omnipay\Stripe;
use Yajra\DataTables\Facades\DataTables;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;
use Illuminate\Support\Facades\Lang;

class PaymentController extends Controller
{
    public function index($id, Request $request)
    {
        $model = Orders::where('invoice_id', $id)->first();

        if ($model) {

            // redirect for cancel order
            if ($model->status == 2) {

                return redirect(route('dashboard.shipments.orders'));
            }

            $mode = get_data_db('payment_methods', 'id', $model->payment_method, 'test_mode');
            $currency = get_data_db('payment_methods', 'id', $model->payment_method, 'currency');
            $amount = convert_currency($model->currency, $currency, $model->shipping_cost);
            $amount = number_format($amount, 2, '.', '');
            $method = strtolower(get_data_db('payment_methods', 'id', $model->payment_method, 'name'));
            $payment_settings = json_decode(
                DB::table('payment_methods')
                    ->where('id', $model->payment_method,)
                    ->value('fields'),
                true
            );

            if ($method == 'paypal' || $method == 'stripe') {

                // begin: PayPal payment
                try {

                    if ($method == 'paypal') {


                        $gateway = Omnipay::create('PayPal_Rest');
                        $gateway->setClientId($payment_settings['Live_Client_Id']);
                        $gateway->setSecret($payment_settings['Live_Client_Secret']);
                        $gateway->setTestMode($mode); //set it to 'false' when go live
                    }

                    if ($method == 'stripe') {

                        //  begin stripe
                        $paymentMethodId = $request->get('paymentMethodId');
                        if (isset($paymentMethodId)) {
                            $gateway = Omnipay::create('Stripe\PaymentIntents');
                            $gateway->initialize([
                                'apiKey' => $payment_settings['Secret_Key']
                            ]);
                            $gateway->setTestMode($mode); //set it to 'false' when go live
                            // Prepare the payment request
                            $request = $gateway->purchase([
                                'confirm' => true,
                                'metadata'  => [
                                    'order_id' => $id,
                                ],
                                'description' => $id,
                                'paymentMethod' => $paymentMethodId,
                                'amount' => ($amount),
                                'currency' => $currency,
                                'returnUrl' => route('payment.status', ['id' => $id, 'mode' => $method, 'response' => 'success']),
                                'cancelUrl' => route('payment.status', ['id' => $id, 'mode' => $method, 'response' => 'cancel'])
                            ]);

                            // Send the payment request
                            $response = $request->send();
                            if ($response->isSuccessful()) {
                                $reference = $response->getPaymentIntentReference();
                                $payment = Payment::where(['payment_id' => $reference, 'invoice_id' => $id])->first();

                                Orders::where('invoice_id', $id)->update([
                                    'payment_status' => 1,
                                ]);

                                if (!$payment) {

                                    // create a transaction

                                    $payment = new Payment;
                                    $payment->payment_id =  $reference;
                                    $payment->invoice_id = $id;
                                    $payment->payer_id = Auth()->user()->id;
                                    $payment->owner_id = $model->owner_id;
                                    $payment->payer_email = get_user('email', $model->owner_id);
                                    $payment->amount = $amount;
                                    $payment->currency = $currency;
                                    $payment->gateway = 'Stripe';
                                    $payment->payment_status = 'approved';
                                    $payment->payment_description = 'automated';
                                    $payment->branch = $model->from_branch;
                                    $payment->save();


                                    // process shipment
                                    $createshipment = $this->create_shipment($model->code);
                                    if ($createshipment['result'] == 'confirmed_already') {

                                        return redirect(route('dashboard.shipments.view', ['id' => $model->code]));
                                    }
                                    if ($createshipment['result'] == 'failed') {

                                        return redirect(route('oops'))->with('message', $createshipment['provider_response']);
                                    }
                                }

                                // Session::flash('form_response', __('messages.Payment_Complete'));
                                // Session::flash('form_response_status', 'success');

                                //redirect to success page
                                return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('success', __('messages.Payment_Complete'));
                            } elseif ($response->isRedirect()) {

                                // Redirect the customer to the payment gateway
                                $response->redirect();
                            } else {
                                // not successful
                                Orders::where('code', $id)->update([
                                    'status' => 2,
                                    'is_approved' => 0,
        
                                ]);
                                
                                //return redirect()->back()->withErrors(['errors' => $response->getMessage()]);
                                return redirect()->back()->withErrors(['errors' => __('messages.Payment_Declined')]);
                            }
                        } else {
                            // process shipment
                            // $createshipment = $this->create_shipment($model->code);
                            // if ($createshipment['result'] == 'confirmed_already') {

                            //     return redirect(route('dashboard.shipments.view', ['id' => $model->code]));
                            // }
                            // if ($createshipment['result'] == 'failed') {

                            //     return redirect(route('oops'))->with('message', $createshipment['provider_response']);
                            // }

                            return  view(get_theme_dir('shipment.invoice.stripe', 'dashboard'))->with([
                                'transaction' => $model,
                                'id' => $id,
                                'page_title' => __('messages.Pay'),
                            ]);
                        }
                        //  end stripe
                    }


                    // Prepare the payment request
                    $request = $gateway->purchase([
                        'amount' => ($amount),
                        'currency' => $currency,
                        'returnUrl' => route('payment.status', ['id' => $id, 'mode' => $method, 'response' => 'success']),
                        'cancelUrl' => route('payment.status', ['id' => $id, 'mode' => $method, 'response' => 'cancel'])
                    ]);

                    // Send the payment request
                    $response = $request->send();
                    if ($response->isRedirect()) {
                        // Redirect the customer to the payment gateway
                        $response->redirect();
                    } else {
                        // not successful
                        return redirect()->back()->withErrors(['errors' => $response->getMessage()]);

                        //return $response->getMessage();
                        //return redirect()->route('payment.status', ['mode' => 'paypal', 'response' => 'error'])->withErrors(['errors' => $response->getMessage()]);
                    }
                } catch (\Exception $e) {
                    return $e->getMessage();
                }
                // end: begin PayPal payment

            } elseif ($method == 'paystack') {

                // paystack payment method coming soon

            } else {
                $data['page_title'] = trans_choice('messages.Pay', 1) . ' ' . trans_choice('messages.Invoice', 1) . ': #' . $model->invoice_id;

                return view(get_theme_dir('shipment.invoice.paydetail', 'dashboard'))->with([
                    'shipment' => $model,
                    'page_title' => $data['page_title'],
                ]);
            }
        } else {

            return redirect(route('oops'))->with('message', __('messages.Request_Failed'));
            // return redirect(url()->previous())->withErrors([
            //     'errors' => __('messages.Request_Failed'),
            // ]);
        }
    }

    public function status($id, $method, $response, Request $request)
    {
        $model = Orders::where('invoice_id', $id)->first();
        if (!$model) {
            return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->withErrors([
                'errors' => __('messages.There_Was_Problem')
            ]);
        }

        $mode = get_data_db('payment_methods', 'id', $model->payment_method, 'test_mode');
        $payment_method = get_data_db('payment_methods', 'id', $model->payment_method, 'name');
        //get payment mode db cridentials
        $payment_settings = json_decode(
            DB::table('payment_methods')
                ->where('name', $method)
                ->value('fields'),
            true
        );


        if ($method == 'paypal') {

            // paypal config data
            $gateway = Omnipay::create('PayPal_Rest');
            $gateway->setClientId($payment_settings['Live_Client_Id']);
            $gateway->setSecret($payment_settings['Live_Client_Secret']);
            $gateway->setTestMode($mode);


            if ($response == 'success') {
                if ($request->input('paymentId') && $request->input('PayerID') || $request->input('payment_intent')) {
                    $transaction = $gateway->completePurchase([
                        'payer_id'             => $request->input('PayerID'),
                        'transactionReference' => $request->input('paymentId'),
                    ]);

                    $response = $transaction->send();
                    // die(response()->json($response->getData()));
                    if ($response->isSuccessful()) {
                        // The customer has successfully paid.
                        $arr_body = $response->getData();

                        // Insert transaction data into the database
                        $invoice_paid = $arr_body['transactions'][0]['invoice_number'];
                        $payment = Payment::where(['payment_id' => $arr_body['id'], 'invoice_id' => $invoice_paid])->first();

                        Orders::where('invoice_id', $id)->update([
                            'payment_status' => 1,
                        ]);

                        if (!$payment) {


                            $payment = new Payment;
                            $payment->payment_id = $arr_body['id'];
                            $payment->invoice_id = $invoice_paid;
                            $payment->payer_id = $arr_body['payer']['payer_info']['payer_id'];
                            $payment->owner_id = $model->owner_id;
                            $payment->payer_email = $arr_body['payer']['payer_info']['email'];
                            $payment->amount = $arr_body['transactions'][0]['amount']['total'];
                            $payment->currency = $arr_body['transactions'][0]['amount']['currency'];
                            $payment->gateway = $payment_method;
                            $payment->payment_status = $arr_body['state'];
                            $payment->payment_description = 'automated';
                            $payment->branch = $model->from_branch;
                            $payment->save();
                        }

                        // process shipment
                        $createshipment = $this->create_shipment($model->code);
                        if ($createshipment['result'] == 'confirmed_already') {

                            return redirect(route('dashboard.shipments.view', ['id' => $model->code]));
                        }
                        if ($createshipment['result'] == 'failed') {

                            return redirect(route('oops'))->with('message', $createshipment['provider_response']);
                        }

                        // Session::flash('form_response', __('messages.Payment_Complete'));
                        // Session::flash('form_response_status', 'success');

                        return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('success', __('messages.Payment_Complete'));
                    } else {

                        Orders::where('code', $id)->update([
                            'status' => 2,
                            'is_approved' => 0,

                        ]);
                        //debug response
                        //return $response->getMessage();
                        return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('error', __('messages.Payment_Failed'));
                    }
                } else {

                    Orders::where('code', $id)->update([
                        'status' => 2,
                        'is_approved' => 0,

                    ]);
                    return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('error', __('messages.Payment_Declined'));
                }
            }


            return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('error', __('messages.Payment_Canceled'));
        }
    }


    /**
     * show transactions page.
     *
     * @param null
     * @return Renderable.
     */
    public function transactions()
    {
        $data['page_title'] = trans_choice('messages.Transaction', 2);
        return view(get_theme_dir('transactions.list', 'dashboard'), $data);
    }

    /**
     * Display a DataTable listing of transaction.
     *
     * @param Request $request.
     * @return DataTables.
     */
    public function transaction_datatable(Request $request)
    {
        if ($request->ajax()) {
            //settings
            $role = Auth()->user()->role;
            $client = Auth()->user()->id;
            $branch = Auth()->user()->branch;

            //moderators/admins
            if ($role >= '4') {
                $transactions = Payment::orderByDesc('created_at');
            }
            //staffs
            if ($role == '3') {
                $transactions = Payment::whereRaw("branch = '$branch'")->orderByDesc('created_at');
            }

            //customers
            if ($role == '1') {
                $transactions = Payment::whereRaw("owner_id = '$client'")->orderByDesc('created_at');
            }

            return DataTables::of($transactions)
                ->addIndexColumn()
                ->addColumn('action', function (Payment $transaction) {
                    $actionBtn = '-';
                    //user role settings
                    $role = Auth()->user()->role;
                    $actionBtn = '';
                    if ($role >= 4) {
                        $url = route('dashboard.transaction', ['id' => $transaction->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-eye'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('invoice_id', function (Payment $transaction) {
                    $url = route('dashboard.shipments.invoice', ['id' => $transaction->invoice_id]);
                    $actionurl = "<a target='_blank' href='{$url}'>{$transaction->invoice_id}</a>";
                    return $actionurl;
                })

                ->editColumn('payment_status', function (Payment $transaction) {
                    $status =  __('messages.' . $transaction->payment_status);
                    return $status;
                })
                ->editColumn('gateway', function (Payment $transaction) {
                    $status =  __('messages.' . $transaction->gateway);
                    if ($transaction->payment_description == 'manual') {
                        $status .= " (" . __('messages.manual') . ")";
                    }
                    return $status;
                })

                ->editColumn('owner_id', function (Payment $transaction) {
                    $user = User::where('id', $transaction->owner_id)->first();
                    $url = route('dashboard.users.view', ['id' => $transaction->owner_id]);

                    if ($user) {
                        $avatar = '<div class="team"> <a href="' . $url . '" class="team-member"> <b>' . $user->username . '</b> </a> </div>';

                        return $avatar;
                    }
                })

                ->editColumn('amount', function (Payment $transaction) {
                    $amount = get_money($transaction->amount, $transaction->currency, 'symbol', 'localize');
                    return $amount;
                })

                ->editColumn('created_at', function (Payment $transaction) {
                    $created_at = \Illuminate\Support\Carbon::parse($transaction->created_at)
                        ->setTimezone(\Helpers::getUserTimeZone())
                        ->format('Y-m-d');
                    return $created_at;
                })
                ->rawColumns(['invoice_id', 'code', 'amount', 'owner_id', 'payment_status', 'created_at', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param Request $request
     * @return Renderable.
     */
    public function transaction_view($id)
    {
        $model = Payment::where('id', $id)->first();
        if ($model) {
            $data['page_title'] = trans_choice('messages.Transaction_Detail', 1) . ': ' . $id;
            return view(get_theme_dir('transactions.view', 'dashboard'))->with([
                'transaction' => $model,
                'page_title' => $data['page_title'],
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    public function create_shipment($id)
    {

        $order = Orders::where('code', $id)->first();

        if (Shipment::where('code', $id)->count() > 0) {
            // confirmed already
            $provider_response = 'confirmed_already';
            return ([
                'result' => 'confirmed_already',
                'provider_response' => $provider_response
            ]);


            // return redirect(route('dashboard.shipments.view', ['id' => $id]));
        }
        try {

            // connect  provider

            $rate = OrderProviders::where('shipment_id', $order->code)->first();
            // die($rate);
            $packages = OrderPackages::where('shipment_id', $order->code)->get();

            if ($order->is_approved == 0) {

                if ($rate->provider == 1) {
                    $provider_response = 'SUCCESS';
                    Orders::where('code', $id)->update([
                        'payment_status' => 1,
                        'status' => 1,
                        'is_approved' => 1,
                        'note' => 1,
                    ]);
                }
                if ($rate->provider == 2) {


                    //  pass packages to json
                    $reset_package = '[';
                    $count = 0;
                    foreach ($packages as $key => $package) {

                        $weight = $package->weight;
                        $pid =  $order->code  . '-' . $package->id;
                        $value = $package['value'];
                        $reset_package .= '{"parcelId": "' . $pid  . '", "value": ' . $value  . ', "length": ' . $package->length . ', "width": ' . $package->width . ', "height": ' . $package->height . ', "content": "' . $package->description . '", "weight": ' . $weight . ', "quantity" : ' . $package->qty . '},';
                    }
                    $reset_package .= '{}]';

                    $new_pacakage = json_decode($reset_package, true);
                    // remove the empty array
                    unset($new_pacakage[count($new_pacakage) - 1]);
                    //die(print_r($new_pacakage));

                    $data = [
                        "shipment" => [
                            "pickupAddress" => [
                                'street' => "$order->sender_address",
                                'city' => "" . Cities::where('id', $order->sender_city)->value('name') . "",
                                'zip' => "" . $order->postal_sender . "",
                                'country' => "" . country_code($order->sender_country) . ""
                            ],
                            "deliveryAddress" => [
                                'street' => "$order->receiver_address",
                                'city' => "" . Cities::where('id', $order->receiver_city)->value('name') . "",
                                'zip' => "" . $order->postal_receiver . "",
                                'country' => "" . country_code($order->receiver_country) . "",

                            ],
                            "pickupDate" => "" . Carbon::tomorrow()->format('Y-m-d\TH:i:sP') . "",

                            "pickupContact" => [
                                "name" => "$order->sender_name",
                                "phone" => "$order->sender_phone"
                            ],
                            "deliveryContact" => [
                                'name' => "$order->receiver_name",
                                "phone" => "$order->receiver_phone"
                            ],
                            "addOns" => []
                        ],
                        "parcels" => [
                            "envelopes" => [],
                            "packages" => $new_pacakage
                        ],
                        "paymentMethod" => "credit",
                        "serviceType" => "" . ShipmentProviders::where('shipment_id', $order->code)->value('token') . "",
                        "currencyCode" => "EUR",
                        "insuranceId" => null,
                        "orderContact" => [
                            "email" => "$order->sender_email",
                            "name" => "$order->sender_name",
                            "phone" => "$order->sender_phone",
                            "contactMethod" => "email",
                            "contactCustomerType" => null
                        ],
                    ];

                    //return json_encode($data);

                    $transaction  = eurosender('orders', $data, 'validate_creation');
                    // die(print_r($transaction));
                    // exit();
                    // $transaction =[];

                    if (isset($transaction['orderCode']) || isset($transaction['status'])) {

                        ShipmentProviders::where('shipment_id', $order->code)->update([
                            'label' => $transaction['labelLink'],
                            'tracking_number' => $transaction['orderCode'],
                            'tracking_status' => $transaction['status']
                        ]);

                        $provider_response = 'SUCCESS';
                        Orders::where('code', $id)->update([
                            'status' => 1,
                            'is_approved' => 1,
                            'note' => 1,

                        ]);

                        // die($transaction);
                    } else {

                        // die($transaction);
                        $response = "Shipping Provider Transaction failed with messages: ";
                        $message =  $response .  $transaction['title'] . ' ' . $transaction['invalid-params'][0]['reason'];

                        $provider_response = $message;
                        // return back()->withErrors([
                        //     'errors' => $message,
                        // ]);
                    }
                }
                if ($rate->provider == 3) {


                    // $transaction  = $shippoService->createTransaction([
                    //     'rate' => $rate->object_id
                    // ]);

                    $transaction = shippo('transaction', [
                        'rate' => $rate->object_id,
                        'async' => false,
                    ]);

                    // Print the shipping label from label_url
                    // Get the tracking number from tracking_number

                    if ($transaction['status'] == 'SUCCESS') {

                        ShipmentProviders::where('shipment_id', $order->code)->update([
                            'label' => $transaction['label_url'],
                            'tracking_number' => $transaction['tracking_number'],
                            'tracking_status' => $transaction['tracking_status'],
                            'shipment_status' =>  get_status('shippo', $transaction['tracking_status'])
                        ]);
                        $provider_response = 'SUCCESS';
                        Orders::where('code', $id)->update([
                            'status' => 1,
                            'is_approved' => 1,
                            'note' => 1,

                        ]);

                        // die($transaction);
                    } else {

                        Orders::where('code', $id)->update([
                            'status' => 2,
                            'is_approved' => 0,

                        ]);
                        // die($transaction);
                        $response = "Transaction failed with messages: ";
                        $message =  $response .  $transaction['messages'][0]['text'];
                        $provider_response = $message;
                        // return back()->withErrors([
                        //     'errors' => $message,
                        // ]);
                    }
                }
            }

            if ($provider_response != 'SUCCESS') {
                return ([
                    'result' => 'failed',
                    'provider_response' => $provider_response
                ]);
            }
            //no issue with provider
            //store shipment

            $shipment = Shipment::create([
                'code' => $order->code,
                'invoice_id' => $order->invoice_id,
                'status' => 1,
                'sender_address_id' => $order->sender_address_id,
                'receiver_address_id' => $order->receiver_address_id,
                'sender_name' => $order->sender_name,
                'sender_phone' => $order->sender_phone,
                'sender_email' => $order->sender_email,
                'sender_country' => $order->sender_country,
                'sender_state' => $order->sender_state,
                'postal_sender' => $order->postal_sender,
                'sender_city' => $order->sender_city,
                'sender_address' => $order->sender_address,
                'receiver_phone' => $order->receiver_phone,
                'receiver_email' => $order->receiver_email,
                'receiver_name' => $order->receiver_name,
                'receiver_address' => $order->receiver_address,
                'receiver_country' => $order->receiver_country,
                'receiver_state' => $order->receiver_state,
                'receiver_city' => $order->receiver_city,
                'postal_receiver' => $order->postal_receiver,
                'current_location' => $order->current_location,
                'delivery_timeline' => $order->delivery_timeline,
                'subtotal' => $order->subtotal,
                'shipping_cost' => $order->shipping_cost,
                'tax' => $order->tax,
                'discount' => $order->discount,
                'currency' => $order->currency,
                'payment_method' => $order->payment_method,
                'payment_status' => 1,
                'payment_type' => 1,
                'total_weight' => $order->total_weight,
                'qty' => $order->qty,
                'from_area' => $order->from_area,
                'to_area' => $order->to_area,
                'from_branch' => $order->from_branch,
                'to_branch' => $order->to_branch,
                'delivery_type' => $order->delivery_type,
                'collection_type' => $order->collection_type,
                'note' => 0,
                'created_by' => $order->created_by,
                'owner_id' => $order->owner_id
            ]);

            if ($shipment) {
                DB::commit();

                foreach ($packages as $package) {

                    $package_log = new Packages();
                    $package_log->description = $package->description;
                    $package_log->width = $package->width;
                    $package_log->height = $package->height;
                    $package_log->length = $package->length;

                    $package_log->weight = $package->weight;
                    $package_log->qty = $package->qty;
                    $package_log->value = $package->value;

                    $package_log->unit_price = $package->unit_price;
                    $package_log->price = $package->price;

                    $package_log->shipment_id = $package->shipment_id;
                    $package_log->save();
                }


                //add to shipment log
                $logs = new ShipmentLog();
                $logs->note = 0;
                $logs->shipment_id = $order->code;
                $logs->save();
                // create the label
                $logs = new ShipmentLog();
                $logs->note = 1;
                $logs->shipment_id = $order->code;
                $logs->save();

                // add the API provider
                foreach (OrderProviders::where('shipment_id', $order->code)->get() as $order_provider) {
                    $provider = new ShipmentProviders();
                    $provider->shipment_id = $order_provider->shipment_id;
                    $provider->object_id = $order_provider->object_id;
                    $provider->name = $order_provider->name;
                    $provider->service_name = $order_provider->service_name;
                    $provider->provider = $order_provider->provider;
                    $provider->token = $order_provider->token;
                    $provider->duration = $order_provider->duration;
                    $provider->save();
                }

                // send Notifications
                foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    $subject[$localeCode] =  Lang::get('messages.Note_Created', [], $localeCode) . " - " . $order->code;
                    $message[$localeCode] =  Lang::get('messages.Note_Label_Created', [], $localeCode) . " - " . $order->code;
                }
                send_notification('shipment', $shipment->id, json_encode($subject), json_encode($message));

                $provider_response = 'confirmed_already';
                return ([
                    'result' => 'SUCCESS',
                    'provider_response' => $provider_response
                ]);
                // Session::flash('form_response', __('messages.Created'));
                // Session::flash('form_response_status', 'success');

                //return data
                // return redirect(route("dashboard.shipments.view", ['id' => $shipment->code]));
            } else {
                DB::rollback();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
