<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Payment;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;

use Omnipay\Omnipay;
use Omnipay\PayPal;
use Omnipay\Stripe;
use Yajra\DataTables\Facades\DataTables;

class PaymentController extends Controller
{
    public function index($id, Request $request)
    {
        $model = Shipment::where('invoice_id', $id)->first();

        if ($model) {

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
                        ;

                        $gateway = Omnipay::create('PayPal_Rest');
                        $gateway->setClientId($payment_settings['Live_Client_Id']);
                        $gateway->setSecret($payment_settings['Live_Client_Secret']);
                        $gateway->setTestMode($mode); //set it to 'false' when go live
                    }

                    if ($method == 'stripe') {
                        ;
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

                                if (!$payment) {

                                    $payment = new Payment;
                                    $payment->payment_id =  $reference;
                                    $payment->invoice_id = $id;
                                    $payment->payer_id = Auth()->user()->id;
                                    $payment->owner_id = Auth()->user()->id;
                                    $payment->payer_email = get_user('email', $model->owner_id);
                                    $payment->amount = $amount;
                                    $payment->currency = $currency;
                                    $payment->gateway = 'Stripe';
                                    $payment->payment_status = 'approved';
                                    $payment->payment_description = 'automated';
                                    $payment->branch = $model->from_branch;
                                    $payment->save();

                                    Shipment::where('invoice_id', $id)->update([
                                        'payment_status' => 1
                                    ]);
                                }

                                Session::flash('form_response', __('messages.Payment_Complete'));
                                Session::flash('form_response_status', 'success');

                                //redirect to success page
                                return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('success', __('messages.Payment_Complete'));
                            } elseif ($response->isRedirect()) {

                                // Redirect the customer to the payment gateway
                                $response->redirect();
                            } else {
                                // not successful
                                //return redirect()->back()->withErrors(['errors' => $response->getMessage()]);
                                return redirect()->back()->withErrors(['errors' => __('messages.Payment_Declined')]);
                            }
                        } else {
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
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    public function status($id, $method, $response, Request $request)
    {
        $model = Shipment::where('invoice_id', $id)->first();
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
                    die(response()->json($response->getData()));
                    if ($response->isSuccessful()) {
                        // The customer has successfully paid.
                        $arr_body = $response->getData();

                        // Insert transaction data into the database
                        $invoice_paid = $arr_body['transactions'][0]['invoice_number'];
                        $payment = Payment::where(['payment_id' => $arr_body['id'], 'invoice_id' => $invoice_paid])->first();

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

                            Shipment::where('invoice_id', $invoice_paid)->update([
                                'payment_status' => 1
                            ]);
                        }

                        Session::flash('form_response', __('messages.Payment_Complete'));
                        Session::flash('form_response_status', 'success');

                        return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('success', __('messages.Payment_Complete'));
                    } else {

                        //debug response
                        //return $response->getMessage();
                        return redirect(route('dashboard.shipments.invoice.pay', ['id' => $id]))->with('error', __('messages.Payment_Failed'));
                    }
                } else {
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
}
