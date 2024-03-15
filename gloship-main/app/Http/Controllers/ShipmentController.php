<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Cities;
use App\Models\OrderProviders;
use App\Models\Orders;
use App\Models\OrderPackages;
use App\Models\Packages;
use App\Models\Payment;
use App\Models\ShipmentProviders;
use App\Models\States;
use App\Services\ShippoService;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Config;
use App\Models\Shipment;
use App\Models\ShipmentLog;
use App\Models\Branches;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Lang;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Item;
use App\Models\Messages;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class ShipmentController extends Controller
{
    /**
     * Display a listig of the resource.
     *
     * @param Request $request
     * @return Renderable
     */
    public function index(Request $request)
    {
        $data['page_title'] = trans_choice('messages.Shipment', 1);
        //$s = $request->s;
        return view(get_theme_dir('shipment.list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            's' => isset($request->s) ? (int)$request->s : ''
        ]);
    }

    /**
     * Display DataTable of the specified  resource.
     *
     * @param $type, int $user_id, Request $request
     * @return DataTables|\Illuminate\Http\JsonResponse..
     */
    public function datatable($type = null, $userid, Request $request)
    {
        if ($request->ajax()) {
            //settings
            $role = Auth()->user()->role;
            $client = Auth()->user()->id;
            $branch = Auth()->user()->branch;
            $filter = $request->s;

            //moderators/admins
            if ($role >= '4') {
                $shipments = Shipment::orderByDesc('created_at');

                //filter by user
                if ($type == 'user') {
                    $shipments = Shipment::where('owner_id', $userid)->orderByDesc('created_at');
                }
                //filter by status
                if ($filter != '') {
                    $shipments = Shipment::where('status', $request->s)->orderByDesc('created_at');
                }
            }
            //staffs
            if ($role == '3') {
                $shipments = Shipment::whereRaw("from_branch = '$branch' OR to_branch = '$branch' OR created_by ='$client'")->orderByDesc('created_at');

                //filter by user
                if ($type == 'user') {
                    $shipments = Shipment::where('owner_id', $userid)->orderByDesc('created_at');
                }
                //filter by status
                if ($request->s != '') {
                    $shipments = Shipment::whereRaw("status = '$request->s'")->orderByDesc('created_at');
                }
            }
            //Delivery Agents
            if ($role == '2') {
                $shipments = Shipment::whereRaw("delivery_agent = '$client'")->orderByDesc('created_at');
                if ($request->s != '') {
                    $shipments = Shipment::whereRaw("status = '$request->s' AND delivery_agent = '$client'")->orderByDesc('created_at');
                }
            }
            //customers
            if ($role == '1') {
                $shipments = Shipment::whereRaw("owner_id = '$client'")->orderByDesc('created_at');
                if ($request->s != '') {
                    $shipments = Shipment::whereRaw("status = '$request->s' AND owner_id = '$client'")->orderByDesc('created_at');
                }
            }

            return DataTables::of($shipments)
                ->addIndexColumn()
                ->addColumn('action', function (Shipment $shipment) {
                    $actionBtn = '-';
                    //user role settings
                    $role = Auth()->user()->role;
                    $client = Auth()->user()->id;
                    $branch = Auth()->user()->branch;
                    if ($role >= 3) {
                        if ($shipment->disabled == '0') {
                            $url = route('dashboard.shipments.edit', ['id' => $shipment->id]);
                            $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                        }
                    }
                    return $actionBtn;
                })
                ->editColumn('code', function (Shipment $shipment) {
                    $url = route('dashboard.shipments.view', ['id' => $shipment->code]);
                    $actionurl = "<a href='{$url}'>{$shipment->code}</a>";
                    return $actionurl;
                })

                ->editColumn('owner_id', function (Shipment $shipment) {
                    $user = User::where('id', $shipment->owner_id)->first();
                    $url = route('dashboard.users.view', ['id' => $shipment->owner_id]);
                    if ($user->avatar) {
                        $avatar = '<div class="team"> <a href="' . $url . '" class="team-member"><b>' . $user->username . '</b> </a> </div> ';
                    } else {
                        $avatar_char1 = substr($user->firstname, 0, 1);
                        $avatar = '<div class="team"> <a href="' . $url . '" class="team-member"> <b>' . $user->username . '</b> </a> </div>';
                    }

                    return $avatar;
                })
                ->editColumn('status', function (Shipment $shipment) {
                    $status_name = get_status('shipments', $shipment->status);
                    $status = "<div class='status'><span class='badge bg-" . get_status_color($shipment->status, 'shipments') . "-subtle text-" . get_status_color($shipment->status, 'shipments') . " font-12'>{$status_name}</span></div>";

                    $payment_status = $shipment->payment_status == '1' ? "<div class='status'><span class='badge bg-primary-subtle text-primary font-6'>" . __('messages.Paid') . "</span></div>" : "<div class='status'><span class='badge bg-danger-subtle text-danger font-6'>" . __('messages.UnPaid') . "</span></div>";

                    return $status . $payment_status;
                })

                ->editColumn('shipping_cost', function (Shipment $shipment) {
                    $shipping_cost = get_money($shipment->shipping_cost, $shipment->currency, 'symbol', 'localize');
                    return $shipping_cost;
                })

                ->editColumn('sender_country', function (Shipment $shipment) {
                    $sender_state = get_name($shipment->sender_state, 'states');
                    $sender_country = country_code($shipment->sender_country);
                    $destination = "$sender_state, $sender_country";
                    return $destination;
                })

                ->editColumn('receiver_country', function (Shipment $shipment) {
                    $receiver_state = get_name($shipment->receiver_state, 'states');
                    $receiver_country = country_code($shipment->receiver_country);
                    $destination = "$receiver_state, $receiver_country";
                    return $destination;
                })

                ->editColumn('created_at', function (Shipment $shipment) {
                    $created_at = Carbon::parse($shipment->created_at)->setTimezone(\Helpers::getUserTimeZone());
                    return $created_at;
                })
                ->rawColumns(['code', 'status', 'shipping_cost', 'owner_id', 'created_at', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param Request $request
     * @return  Renderable|\Illuminate\Http\RedirectResponse.
     */
    public function create(Request $request)
    {
        $data['page_title'] = __('messages.Add_Shipment');

        if (Auth()->user()->role == 1) {
            $user = User::where('id', Auth()->user()->id)->first();
            return view(get_theme_dir('shipment.create', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'user' => $user,
                'data' => $data,
            ]);
        }
        //add user filter
        if ($request->id) {
            if (Auth()->user()->role > 1) {
                //check if user exist
                $user = User::where('id', $request->id)->first();
                if ($user) {
                    return view(get_theme_dir('shipment.create', 'dashboard'))->with([
                        'page_title' => $data['page_title'],
                        'user' => $user,
                        'data' => $data,
                    ]);
                } else {
                    return view(get_theme_dir('shipment.create', 'dashboard'))->with([
                        'page_title' => $data['page_title'],
                        'data' => $data,
                    ]);
                }
            }
            return redirect(route('dashboard.shipments.create'));
        } else {
            return view(get_theme_dir('shipment.create', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'data' => $data,
            ]);
        }
    }

    /**
     * Display the specified  resource.
     *
     * @param $request
     * @return Renderable.
     */
    public function view($request)
    {
        $model = Shipment::where('code', $request)->first();
        if ($model) {
            $data['page_title'] = trans_choice('messages.Shipment', 1) . ': ' . $model->code;
            return view(get_theme_dir('shipment.view', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'shipment' => $model,
                'data' => $data,
            ]);
        } else {
            //error not found
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param  int $id
     * @return Renderable.
     */
    public function edit($id)
    {
        $shipment = Shipment::where('id', $id)->first();
        if ($shipment) {
            $data['page_title'] = __('messages.Editing_Shipment');
            return view(get_theme_dir('shipment.edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'shipment' => $shipment,
                'data' => $data,
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param Request $request
     * @return Renderable.
     */
    public function tracking(Request $request)
    {
        if (isset($request->code)) {
            $shipment = Shipment::where('code', $request->code)->first();
            $logs = ShipmentLog::where('shipment_id', $request->code)
                ->orderBy('id', 'desc')
                ->get();
            $packages = Packages::where('shipment_id', $request->code)
                ->orderBy('id', 'asc')
                ->get();


            if ($shipment) {
                $data['page_title'] = __('messages.Tracking') . " $shipment->code";
                return view(get_theme_dir('contents.tracking'), [
                    'track' => $shipment,
                    'page_title' => $data['page_title'],
                    'logs' => $logs,
                    'packages' => $packages,
                ]);
            }
            $data['error'] = __('messages.Tracking_Number_Error');
            return view(get_theme_dir('contents.tracking'))->with([
                'page_title' => $data['error'],
                'error' =>  $data['error'],
            ]);
        }
        $data['page_title'] = __('messages.Shipment_Tracking');
        return view(get_theme_dir('contents.tracking'))->with([
            'page_title' => $data['page_title']
        ]);
    }

    /**
     * Store newly created resources in storage.
     *
     * @param Request $request
     * return  Illuminate\Http\RedirectResponse.
     */
    public function store(Request $request)
    {
        if ($request->user()->cannot('do_customer')) {
            $error = __('messages.Session_Timeout');

            return redirect(route('dashboard.shipments.create'))->withErrors([$error])
                ->withInput();
        }

        // check if shipment session is has started already.
        if (empty(session("shipment_order"))) {
            $error = __('messages.Session_Timeout');

            return redirect(route('dashboard.shipments.create'))->withErrors([$error])
                ->withInput();
        }
        //retrieve request data

        $code_prefix = isset($request->tracking_code_prefix) ? $request->tracking_code_prefix . '-' : '';
        $code = $code_prefix . $request->tracking_code_number;

        if (Auth()->user()->role == 1) {
            //use default configuration is user is customer
            $prefix = get_config('default_tracking_prefix');
            if (get_config('tracking_prefix') == 'enabled') {
                $code_prefix = isset($prefix) ? $prefix . '-' : '';
                $code = strip_tags($code_prefix . $request->tracking_code_number);
            }
        }
        // validate inputs
        // retrieve order details

        $object_id = session("shipment_order");
        $currency = session("object_currency_" . $request->object_id . "");
        $subtotal = session("object_subtotal_" . $request->object_id . "");
        $tax = session("object_tax_" . $request->object_id . "");
        $discount = session("object_discount_" . $request->object_id . "");
        $cost = session("object_total_" . $request->object_id . "");
        $duration = session("object_duration" . $request->object_id . "");

        if ($object_id == '' || $tax == '' || $currency == '' || $subtotal == '' ||  $cost == '' || $discount == '') {

            $error = __('messages.Session_Timeout');

            return redirect(route('dashboard.shipments.create'))->withErrors([$error])
                ->withInput();
        }

        $validate = Validator::make($request->all(), [
            'tracking_code_number' => 'bail|required|numeric|digits:10',
            'collection_type' => 'required',
            'delivery_type' => 'required',
            'sender_info' => 'required',
            'receiver_info' => 'required',
            'total_weight' => 'required',
            'total_qty' => 'required',
        ]);
        if ($validate->fails()) {

            $error =  __('messages.Invalid_Sender_Address');
            return redirect(route('dashboard.shipments.create'))->withErrors($validate->errors())
                ->withInput();
        }

        //get client
        if (Auth()->user()->role == 1) {
            $client = Auth()->user()->id;
        } else {
            $client = $request->client;
        }
        //get sender address from database
        $sender_address = Address::where('id', $request->sender_info)->first();
        if (!$sender_address) {
            //Invalid Receiver Address

            $error =  __('messages.Invalid_Sender_Address');
            return redirect(route('dashboard.shipments.create'))->withErrors([$error])
                ->withInput();
        }

        //get receiver address from database
        $receiver_address = Address::where('id', $request->receiver_info)->first();
        if (!$receiver_address) {
            //Invalid Receiver Address

            $error =  __('messages.Invalid_Receiver_Address');
            return redirect(route('dashboard.shipments.create'))->withErrors([$error])
                ->withInput();
        }

        try {

            //get shipment cost
            $counts = 0;
            if (!empty($request->packages)) {
                if (isset($request->packages[$counts]['package_description']) && isset($request->packages[$counts]['weight']) && isset($request->packages[$counts]['qty'])) {
                    foreach ($request->packages as $package) {
                        if (empty($package['qty'])) {
                            $package['qty'] = 1;
                        }

                        if (empty($package['weight'])) {
                            $package['weight'] = 1;
                        }

                        // $cost += ($package['qty']) * get_cost($sender_address->id, $receiver_address->id, $package['weight']);
                    }
                }
            } else {
                //no package selected 

                $error =  __('messages.Invalid_Request');
                return redirect(route('dashboard.shipments.create'))->withErrors([$error])
                    ->withInput();
            }

            //shipment status
            $status = 0;



            //store shipment
            
            $shipment = Orders::create([
                'code' => $code,
                'invoice_id' => $request->tracking_code_number,
                'status' => $status,
                'sender_address_id' => $request->sender_info,
                'receiver_address_id' => $request->receiver_info,
                'sender_name' => "$sender_address->firstname $sender_address->lastname",
                'sender_phone' => $sender_address->phone,
                'sender_email' => $sender_address->email,
                'sender_country' => $sender_address->country,
                'sender_state' => $sender_address->state,
                'postal_sender' => $receiver_address->postal,
                'sender_city' => $sender_address->city,
                'sender_address' => "$sender_address->house_no " . $sender_address->address,
                'receiver_phone' => $receiver_address->phone,
                'receiver_email' => $receiver_address->email,
                'receiver_name' => "$receiver_address->firstname $receiver_address->lastname",
                'receiver_address' => "$receiver_address->house_no " . $receiver_address->address,
                'receiver_country' => $receiver_address->country,
                'receiver_state' => $receiver_address->state,
                'receiver_city' => $receiver_address->city,
                'postal_receiver' => $receiver_address->postal,
                'current_location' => $request->current_location,
                'delivery_timeline' => $request->delivery_timeline,
                'subtotal' => $subtotal,
                'shipping_cost' => $cost,
                'tax' => $tax,
                'discount' => $discount,
                'currency' => $currency,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'total_weight' => $request->total_weight,
                'qty' => $request->total_qty,
                'from_area' => $sender_address->area,
                'to_area' => $receiver_address->area,
                'from_branch' => $request->sender_branch,
                'to_branch' => $request->receiver_branch,
                'delivery_type' => $request->delivery_type,
                'collection_type' => $request->collection_type,
                'note' => 0,
                'created_by' => Auth()->user()->id,
                'owner_id' => $client,
            ]);

            if ($shipment) {
                DB::commit();

                //add packages
                $counts = 0;

                if (!empty($request->packages)) {
                    if (isset($request->packages[$counts]['package_description']) && isset($request->packages[$counts]['weight']) && isset($request->packages[$counts]['qty'])) {
                        foreach ($request->packages as $package) {
                            // if (empty($package['qty'])) {
                            //     $package['qty'] = 1;
                            // }

                            // if (empty($package['weight'])) {
                            //     $package['weight'] = 1;
                            // }

                            $package_log = new OrderPackages();
                            $package_log->description = $package['package_description'];
                            $package_log->width = $package['width'];
                            $package_log->height = $package['height'];
                            $package_log->length = $package['length'];

                            $package_log->weight = $package['weight'];
                            $package_log->qty = $package['qty'];
                            $package_log->value = $package['value'];

                            if ($request->service_provider == 1) {
                                $package_log->unit_price = get_cost($sender_address->id, $receiver_address->id, $package['weight']);
                                $package_log->price = $package['qty'] * get_cost($sender_address->id, $receiver_address->id, $package['weight']);
                            } else {
                                $package_log->unit_price = 0;
                                $package_log->price = 0;
                            }

                            $package_log->shipment_id = $code;
                            $package_log->save();
                            // if (!$package_log->save()) {
                            //     throw new \Exception();
                            // }
                        }
                    }
                }

                //add to shipment log
                // $logs = new ShipmentLog();
                // $logs->note = 0;
                // $logs->shipment_id = $code;
                // $logs->save();

                // add the API provider

                $provider = new OrderProviders();
                $provider->shipment_id = $code;
                $provider->object_id = $object_id;
                $provider->name = $request->provider;
                $provider->service_name = $request->service_name;
                $provider->provider = $request->service_provider;
                $provider->token = $request->token;
                $provider->duration = $duration;
                $provider->save();

                // Session::flash('form_response', __('messages.Created'));
                // Session::flash('form_response_status', 'success');
                Session::forget([
                    "shipment_order",
                    "object_subtotal_" . $object_id . "",
                    "object_currency_" . $object_id . "",
                    "object_discount_" . $object_id . "",
                    "object_tax_" . $object_id . "",
                    "object_total_" . $object_id . "",
                    "duration"

                ]);
                //return data
                return redirect(route("dashboard.shipments.invoice.payment.process", ['id' => $shipment->invoice_id]));
                
            } else {
                DB::rollback();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request, $id
     * 
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update(Request $request, $id)
    {
        //restrict access if user not staff
        if ($request->user()->cannot('do_staff')) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.There_Was_Problem'),
                'authorized' => 0,
            ];
            return response()->json($resp);
        }

        $shipment = Shipment::find($id);

        $validate = Validator::make($request->all(), [
            'status' => 'required',
            'shipped_date' => 'nullable',
            'sender_name' => 'nullable',
            'sender_address' => 'required',
            'sender_phone' => 'required|min:5',
            'receiver_phone' => 'required|min:5',
            'receiver_name' => 'required',
            'receiver_address' => 'required',
            'delivery_timeline' => 'nullable',
            'shipping_cost' => 'required',
            'sender_country' => 'nullable',
            'total_weight' => 'required',
            'note' => 'nullable',
            'paid' => 'nullable',
            'current_location' => 'nullable',
            'qty' => 'nullable',
            'new_log' => 'nullable',
        ]);
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }

        $shipment->status = $request->status;

        //convert currency
        $subtotal = convert_currency(get_currency('code'), $shipment->currency, $request->subtotal);
        $tax = convert_currency(get_currency('code'), $shipment->currency, $request->tax);
        $discount = convert_currency(get_currency('code'), $shipment->currency, $request->discount);
        $shipping_cost = convert_currency(get_currency('code'), $shipment->currency, $request->shipping_cost);

        //merge Request
        $request->merge([
            'subtotal' => $subtotal,
            'tax' => $tax,
            'discount' => $discount,
            'shipping_cost' => $shipping_cost,
        ]);

        $shipment->sender_name = $request->sender_name;
        $shipment->sender_phone = $request->sender_phone;
        $shipment->sender_email = $request->sender_email;

        //$shipment->sender_city = $request->sender_city;
        $shipment->sender_address = $request->sender_address;
        $shipment->receiver_phone = $request->receiver_phone;
        $shipment->receiver_email = $request->receiver_email;
        $shipment->receiver_name = $request->receiver_name;
        $shipment->receiver_address = $request->receiver_address;

        // $shipment->receiver_city = $request->receiver_city;
        $shipment->current_location = $request->current_location;
        $shipping_cost = convert_currency(get_currency('code'), $shipment->currency, $request->shipping_cost);

        if ($request->shipped_date != '') {
            $request->merge([
                'shipped_date' => Carbon::parse($request->input('shipped_date'), \Helpers::getUserTimeZone())
                    ->setTimeZone(config('app.timezone'))
                    ->format('Y-m-d H:i:s'),
            ]);
        }
        if ($request->delivery_date != '') {
            $request->merge([
                'delivery_date' => Carbon::parse($request->input('delivery_date'), \Helpers::getUserTimeZone())
                    ->setTimeZone(config('app.timezone'))
                    ->format('Y-m-d H:i:s'),
            ]);
        }

        $shipment->shipped_date = $request->shipped_date;
        $shipment->delivery_date = $request->delivery_date;
        $shipment->delivery_timeline = $request->delivery_timeline;
        $shipment->shipping_cost = $request->shipping_cost;
        $shipment->payment_status = $request->payment_status;
        $shipment->payment_method = $request->payment_method;
        $shipment->payment_type = $request->payment_type;
        $shipment->total_weight = $request->total_weight;

        $shipment->qty = $request->qty;
        $shipment->discount = $request->discount;
        $shipment->tax = $request->tax;
        $shipment->subtotal = $request->subtotal;
        $shipment->package_name = $request->package_name;

        $shipment->from_branch = $request->from_branch;
        $shipment->to_branch = $request->to_branch;
        $shipment->last_updated_by = Auth()->user()->id;
        //$shipment->postal_sender = $request->postal_sender;
        //$shipment->postal_receiver = $request->postal_receiver;

        $shipment->note = json_encode($request->note);

        if ($shipment->save()) {

            // update provider
            ShipmentProviders::where('shipment_id', $shipment->code)->update([
                'shipment_status' =>  $request->status,
            ]);

            if ($request->new_log != '') {
                //save log
                $logs = new ShipmentLog();

                $logs->note = $request->new_log;
                $logs->shipment_id = $shipment->code;
                $logs->save();
                $newlog_message = get_status('shipment-notes', $logs->note);
                $newlog_date = Carbon::parse($logs->created_at, \Helpers::getUserTimeZone())
                    ->setTimeZone(config('app.timezone'))
                    ->format('Y-m-d H:i:s');
            }

            $resp = [
                'result' => 'success',
                'messages' => __('messages.Saved'),
                'id' => $shipment->id,
                'newlog_message' => isset($newlog_message) ? $newlog_message : '',
                'newlog_date' => isset($newlog_date) ? $newlog_date : '',
            ];
            return response()->json($resp);
        }
    }

    /**
     * Update the specified resource log in storage.
     *
     * @param Request $request, int $id
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function updatelog(Request $request, $id)
    {
        //restrict access if user not staff
        if ($request->user()->cannot('do_staff')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission')
            ]);
        }
        $logs = ShipmentLog::find($id);
        $logs->note = $request->edit_log;
        $logs->save();

        Session::flash('form_response', __('messages.Saved'));
        Session::flash('form_response_status', 'success');
        return redirect(url()->previous());
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request, int $id
     * @return  \Illuminate\Http\RedirectResponse.
     */


    public function updatepackage(Request $request, $id)
    {
        //restrict access if user not staff
        if ($request->user()->cannot('do_staff')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission')
            ]);
        }
        $packages = Packages::find($id);
        $currency = Shipment::where('code', $packages->shipment_id)->value('currency');
        $unit_price = convert_currency(get_currency('code'), $currency, $request->unit_price);
        $price = convert_currency(get_currency('code'), $currency, $request->price);
        $value = convert_currency(get_currency('code'), $currency, $request->value);

        //merge Request
        $request->merge([
            'value' => $value,
            'unit_price' => $unit_price,
            'price' => $price
        ]);

        $packages->description = $request->package_description;
        $packages->height = $request->height;
        $packages->width = $request->width;
        $packages->length = $request->length;
        $packages->weight = $request->weight;
        $packages->qty = $request->qty;
        $packages->value = $request->value;
        $packages->unit_price = $request->unit_price;
        $packages->price = $request->price;
        if ($packages->save()) {
            Session::flash('form_response', __('messages.Saved'));
            Session::flash('form_response_status', 'success');
            return redirect(url()->previous());
        }
        return redirect(url()->previous())->with('error',  __('messages.There_Was_Problem'));
    }

    /**
     * Update the specified resource status in storage.
     *
     * @param $id,Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function status($id, Request $request,  ShippoService $shippoService)
    {
        if ($request->payment_method == true) {
            $payment_method = Shipment::find($id);
            $payment_method->payment_method = $request->payment_method;
            $payment_method->save();
            Session::flash('form_response', __('messages.Saved'));
            Session::flash('form_response_status', 'success');
            return redirect(url()->previous());
        }


        //restrict access if user not staff
        if ($request->user()->cannot('do_staff')) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.There_Was_Problem'),
                'authorized' => 0,
            ];
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission')
            ]);
        }
        $status = Shipment::find($id);
        // for rates
        $rate = ShipmentProviders::where('shipment_id', $status->code)->first();

        $status_new = __($request->status);

        if ($status_new == 'approve' && $status->is_approved == 0) {

            if ($rate->provider == 2) {

                $packages = Packages::where('shipment_id', $status->code)->get();
                //  pass packages to json
                $reset_package = '[';
                $count = 0;
                foreach ($packages as $key => $package) {

                    $weight = $package['weight'];
                    $pid =  $status->code  . '-' . $package['id'];
                    $value = $package['value'];
                    $reset_package .= '{"parcelId": "' . $pid  . '", "value": ' . $value  . ', "length": ' . $package['length'] . ', "width": ' . $package['width'] . ', "height": ' . $package['height'] . ', "content": "' . $package['description'] . '", "weight": ' . $weight . ', "quantity" : ' . $package['qty'] . '},';
                }
                $reset_package .= '{}]';

                $new_pacakage = json_decode($reset_package, true);
                // remove the empty array
                unset($new_pacakage[count($new_pacakage) - 1]);
                //die(print_r($new_pacakage));

                $data = [
                    "shipment" => [
                        "pickupAddress" => [
                            'street' => "$status->sender_address",
                            'city' => "" . Cities::where('id', $status->sender_city)->value('name') . "",
                            'zip' => "" . $status->postal_sender . "",
                            'country' => "" . country_code($status->sender_country) . ""
                        ],
                        "deliveryAddress" => [
                            'street' => "$status->receiver_address",
                            'city' => "" . Cities::where('id', $status->receiver_city)->value('name') . "",
                            'zip' => "" . $status->postal_receiver . "",
                            'country' => "" . country_code($status->receiver_country) . "",

                        ],
                        "pickupDate" => "" . Carbon::tomorrow()->format('Y-m-d\TH:i:sP') . "",

                        "pickupContact" => [
                            "name" => "$status->sender_name",
                            "phone" => "$status->sender_phone"
                        ],
                        "deliveryContact" => [
                            'name' => "$status->receiver_name",
                            "phone" => "$status->receiver_phone"
                        ],
                        "addOns" => []
                    ],
                    "parcels" => [
                        "envelopes" => [],
                        "packages" => $new_pacakage
                    ],
                    "paymentMethod" => "credit",
                    "serviceType" => "" . ShipmentProviders::where('shipment_id', $status->code)->value('token') . "",
                    "currencyCode" => "EUR",
                    "insuranceId" => null,
                    "orderContact" => [
                        "email" => "$status->sender_email",
                        "name" => "$status->sender_name",
                        "phone" => "$status->sender_phone",
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

                    ShipmentProviders::where('shipment_id', $status->code)->update([
                        'label' => $transaction['labelLink'],
                        'tracking_number' => $transaction['orderCode'],
                        'tracking_status' => $transaction['status']
                    ]);

                    // die($transaction);
                } else {

                    // die($transaction);
                    $response = "Shipping Provider Transaction failed with messages: ";
                    $message =  $response .  $transaction['title'] . ' ' . $transaction['invalid-params'][0]['reason'];

                    return back()->withErrors([
                        'errors' => $message,
                    ]);
                }
            }
            if ($rate->provider == 3) {


                $transaction  = $shippoService->createTransaction([
                    'rate' => $rate->object_id
                ]);

                // Print the shipping label from label_url
                // Get the tracking number from tracking_number

                if ($transaction['status'] == 'SUCCESS') {

                    ShipmentProviders::where('shipment_id', $status->code)->update([
                        'label' => $transaction['label_url'],
                        'tracking_number' => $transaction['tracking_number'],
                        'tracking_status' => $transaction['tracking_status']
                    ]);

                    // die($transaction);
                } else {

                    // die($transaction);
                    $response = "Transaction failed with messages: ";
                    $message =  $response .  $transaction['messages'][0]['text'];

                    return back()->withErrors([
                        'errors' => $message,
                    ]);
                }
            }

            $status->status = '1';
            $status->is_approved = 1;
            $status->note = 1;
            $status->save();

            //add to shipment log
            $logs = new ShipmentLog();
            $logs->note = 1;
            $logs->shipment_id = $status->code;
            $logs->save();
            // send Notifications
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $subject[$localeCode] =  Lang::get('messages.Note_Created', [], $localeCode) . " - " . $status->code;
                $message[$localeCode] =  Lang::get('messages.Note_Label_Created', [], $localeCode) . " - " . $status->code;
            }
            send_notification('shipment', $id, json_encode($subject), json_encode($message));
            Session::flash('form_response', __('messages.Saved'));
        } elseif ($status_new == 'reject') {
            $status->status = '14';
            $status->note = 14;
            $status->save();

            ShipmentProviders::where('shipment_id', $status->code)->update([
                'shipment_status' =>  14,
                // 'tracking_status' => 14
            ]);

            // add to shipment log
            $logs = new ShipmentLog();
            $logs->note = 14;
            $logs->shipment_id = $status->code;
            $logs->save();

            // send Notifications
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $subject[$localeCode] =  Lang::get('messages.Rejected', [], $localeCode) . " - " . $status->code;
                $message[$localeCode] =  Lang::get('messages.Note_Rejected', [], $localeCode) . " - " . $status->code;
            }
            send_notification('shipment', $id, json_encode($subject), json_encode($message));
        } elseif ($status_new == 'paid') {
            $status->payment_status = '1';
            $status->save();

            //mark as paid
            // Insert transaction data into the database
            $payment = Payment::where('payment_id', $status->invoice_id)->first();


            if (!$payment) {

                $gateway = get_data_db('payment_methods', 'id', $status->payment_method, 'name');

                $payment = new Payment;
                $payment->invoice_id = $status->invoice_id;
                $payment->payment_id = $status->invoice_id;
                $payment->payer_id = Auth()->user()->id;
                $payment->owner_id = Auth()->user()->id;
                $payment->payer_email = get_user('email', $status->owner_id);
                $payment->amount = $status->shipping_cost;
                $payment->currency = $status->currency;
                $payment->gateway = $gateway;
                $payment->payment_status = 'approved';
                $payment->payment_description = 'manual';
                $payment->branch = $status->from_branch;
                $payment->save();
            }

            // send Notifications
            foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                $subject[$localeCode] =  Lang::get('messages.Invoice_Paid', [], $localeCode) . " #" . $status->invoice_id;
                $message[$localeCode] =  Lang::get('messages.Invoice_Paid', [], $localeCode) . " #" . $status->invoice_id;
            }
            send_notification('invoice', $status->id, json_encode($subject), json_encode($message));
            Session::flash('form_response', __('messages.Saved'));
        } elseif ($status_new == 'disable') {
            $status->disabled = '1';
            $status->save();
        } elseif ($status_new == 'enable') {
            $status->disabled = '0';
            $status->save();
        } else {

            //validate status
            if ($status_new == '0' || $status_new < 16) {

                $status->status = $status_new;
                $status->save();

                ShipmentProviders::where('shipment_id', $status->code)->update([
                    'shipment_status' =>  $status_new,
                ]);

                //insert log
                $logs = new ShipmentLog();
                $logs->note = $status_new;
                $logs->shipment_id = $status->code;
                $logs->save();
            }

            Session::flash('form_response', __('messages.Saved'));
            Session::flash('form_response_status', 'success');
        }
        return redirect(url()->previous());
    }

    /**
     * Calculate shipment cost.
     *
     * @param Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function get_rates(Request $request, ShippoService $shippoService)
    {

        $sender_data = '';
        $receiver_data = '';
        if ($request->is_guest_rates == 1) {

            $validate = Validator::make($request->all(), [
                'pickup_country' => 'required',
                'pickup_state' => 'required',
                'pickup_city' => 'required',
                'pickup_address' => 'required',
                'pickup_postal' => 'required',
                'destination_country' => 'required',
                'destination_state' => 'required',
                'destination_city' => 'required',
                'destination_address' => 'required',
                'destination_postal' => 'required',
                'total_weight' => 'required',
                'total_qty' => 'required',
            ]);

            //input has error(s)
            if ($validate->fails()) {

                return redirect(route('quote'))
                    ->withErrors($validate)
                    ->withInput();
            }
            $sender_data  = [
                'id' => 0,
                'firstname' => 'Rate',
                'lastname' => 'User',
                'phone' => get_config('site_phone'),
                'email' => get_config('site_email_support'),
                'address' => $request->pickup_address,
                'city' => $request->pickup_city,
                'state' => $request->pickup_state,
                'country' => $request->pickup_country,
                'postal' => $request->pickup_postal,
                'object_id' => ''
            ];
            $sender_address  = json_decode(json_encode($sender_data));

            $receiver_data  = [
                'id' => 0,
                'firstname' => 'Rate',
                'lastname' => 'User',
                'phone' => get_config('site_phone'),
                'email' => get_config('site_email_support'),
                'address' => $request->destination_address,
                'city' => $request->destination_city,
                'state' => $request->destination_state,
                'country' => $request->destination_country,
                'postal' => $request->destination_postal,
                'object_id' => ''
            ];
            $receiver_address  = json_decode(json_encode($receiver_data));

            // validate addresses
            $addressData = [
                'name' => "Guest User",
                'street1' => $request->pickup_address,
                'city' => get_name($request->pickup_city, 'cities'),
                'state' =>  get_name($request->pickup_state, 'states'),
                'zip' => $request->pickup_postal,
                'country' => country_code($request->country),
                'phone' => $request->phone,
                'email' => $request->email,
                "validate" => true
            ];
            $addressData2 = [
                'name' => "Guest User",
                'street1' => $request->destination_address,
                'city' => get_name($request->destination_city, 'cities'),
                'state' =>  get_name($request->destination_state, 'states'),
                'zip' => $request->destination_postal,
                'country' => country_code($request->country),
                'phone' => $request->phone,
                'email' => $request->email,
                "validate" => true
            ];
    
            $addressDataReseult =  $shippoService->createAddress($addressData);
            $addressDataReseult2 =  $shippoService->createAddress($addressData2);
    
            if(isset($addressDataReseult["is_complete"]) && isset($addressDataReseult2["is_complete"])){
            if ($addressDataReseult['is_complete'] !== true || $addressDataReseult2['is_complete'] !== true) {
               
                return redirect(route('quote'))
                ->withErrors(trans_choice('messages.Address_Not_Available', 1))
                ->withInput();
            }
           }
           else{
            return redirect(route('quote'))
            ->withErrors(trans_choice('messages.There_Was_Problem', 1))
            ->withInput();

           }
        } else {

            $validate = Validator::make($request->all(), [
                'sender_info' => 'required',
                'receiver_info' => 'required',
                'total_weight' => 'required',
                'total_qty' => 'required',
            ]);

            //input has error(s)
            if ($validate->fails()) {

                return redirect(url()->previous())
                    ->withErrors($validate)
                    ->withInput();
            }
            //get sender address from database
            $sender_address = Address::where('id', $request->sender_info)->first();
            if (!$sender_address) {
                //Invalid Receiver Address
                $error = __('messages.Invalid_Sender_Address');
                return redirect(url()->previous())
                    ->withErrors([$error])
                    ->withInput();
            }

            //get receiver address from database
            $receiver_address = Address::where('id', $request->receiver_info)->first();
            if (!$receiver_address) {
                //Invalid Receiver Address
                $error = __('messages.Invalid_Receiver_Address');
                return redirect(url()->previous())

                    ->withErrors([$error])
                    ->withInput();
            }
            
        }


        $collection_type = $request->collection_type;
        $delivery_type = $request->delivery_type;
        $sender_info = $request->sender_info;
        $receiver_info = $request->receiver_info;
        $sender_branch = $request->sender_branch;
        $receiver_branch = $request->receiver_branch;
        $total_weight = $request->total_weight;
        $total_qty = $request->total_qty;
        $packages = $request->packages;
        $new_provider = '0';
        $tracking_code_prefix = $request->tracking_code_prefix;
        $tracking_code_number =  $request->tracking_code_number;
        $client =  $request->client;
        $payment_method = $request->payment_method;

        // if rates provider is shippo, fetch rates from shippo.
        if ($request->service_provider == 3) {

            //  pass packages to json
            $reset_package = '[';
            $count = 0;
            foreach ($packages as $key => $package) {

                $weight = round(convert_unit($package['weight'], 'kg_to_lb'), 4);
                $reset_package .= '{"length": ' . $package['length'] . ', "width": ' . $package['width'] . ', "height": ' . $package['height'] . ', "distance_unit": "in", "weight": ' . $weight . ', "mass_unit" : "lb"},';
            }
            $reset_package .= '{}]';

            $new_pacakage = json_decode($reset_package, true);
            // remove the empty array
            unset($new_pacakage[count($new_pacakage) - 1]);

            // address data
            if ($request->is_guest_rates == 1) { 
                $senderAddressData = '';
                $receiverAddressData = '';
            }
            else {
                $senderAddressData = $sender_address['object_id'];
                $receiverAddressData = $receiver_address['object_id'];
            }
            
            if ($senderAddressData == '') {
                $senderAddressData = [
                    'name' => "$sender_address->firstname $sender_address->lastname",
                    'street_no' => $sender_address->house_no,
                    'street1' => "$sender_address->house_no " .$sender_address->address,
                    'city' => Cities::where('id', $sender_address->city)->value('name'),
                    'state' => States::where('id', $sender_address->state)->value('name'),
                    'zip' => $sender_address->postal,
                    'country' => country_code($sender_address->country),
                    'phone' => $sender_address->phone,
                    'email' => $sender_address->email,
                    "validate" => true
                ];
            }

            
            if ($receiverAddressData == '') {
                $receiverAddressData = [
                    'name' => "$receiver_address->firstname $receiver_address->lastname",
                    'street_no' => $receiver_address->house_no,
                    'street1' => "$receiver_address->house_no " .$receiver_address->address,
                    // 'street1' => $receiver_address->address,
                    'city' => Cities::where('id', $receiver_address->city)->value('name'),
                    'state' => States::where('id', $receiver_address->state)->value('name'),
                    'zip' => $sender_address->postal,
                    'country' => country_code($receiver_address->country),
                    'phone' => $receiver_address->phone,
                    'email' => $receiver_address->email,
                    "validate" => true
                ];
            }

            $shipmentDetails = [
                'address_from' => $senderAddressData,
                'address_to' => $receiverAddressData,
                'parcels' =>  $new_pacakage
            ];



            $shipment = $shippoService->createShipment($shipmentDetails);
           
            // $shipment = json_decode(get_config('testshippo'), true);

            //  die ($shipment);
            if (isset($shipment['rates']) && !empty($shipment['rates'])) {
                $rates = $shipment['rates'];
                $new_provider = '3';
            } else {
                $new_provider = '2';
            }
        }

        // if rates provider is eurosender, fetch rates from eurosender.
        if ($request->service_provider == 2 || $new_provider == 2) {

            //  pass packages to json
            $reset_package = '[';
            $count = 0;
            foreach ($packages as $key => $package) {

                $weight = $package['weight'];
                $pid = $tracking_code_prefix . $tracking_code_prefix . '-' . $key;
                $value = $package['value'];
                $reset_package .= '{"parcelId": "' . $pid  . '", "value": ' . $value  . ', "length": ' . $package['length'] . ', "width": ' . $package['width'] . ', "height": ' . $package['height'] . ', "content": "' . $package['package_description'] . '", "weight": ' . $weight . ', "quantity" : ' . $package['qty'] . '},';
            }
            $reset_package .= '{}]';

            $new_pacakage = json_decode($reset_package, true);
            // remove the empty array
            unset($new_pacakage[count($new_pacakage) - 1]);

            // shipment data

            $data = [
                "shipment" => [
                    "pickupAddress" => [
                        'street' => "$sender_address->house_no $sender_address->address",
                        // 'street' => "$sender_address->address",
                        'city' => "" . Cities::where('id', $sender_address->city)->value('name') . "",
                        'zip' => "" . $sender_address->postal . "",
                        'country' => country_code($sender_address->country)
                    ],
                    "deliveryAddress" => [
                        'street' => "$receiver_address->house_no $receiver_address->address",
                        'city' => "" . Cities::where('id', $sender_address->city)->value('name') . "",
                        'zip' => "" . $sender_address->postal . "",
                        'country' => country_code($sender_address->country)
                        // 'street' => "$sender_address->address",
                        // 'city' => "" . Cities::where('id', $sender_address->city)->value('name') . "",
                        // 'zip' => "" . $sender_address->postal . "",
                        // 'country' => country_code($sender_address->country),

                    ],
                    "pickupDate" => "" . Carbon::tomorrow()->format('Y-m-d\TH:i:sP') . "",

                    "pickupContact" => [
                        "name" => "$sender_address->firstname $sender_address->lastname",
                        "phone" => "$sender_address->phone"
                    ],
                    "deliveryContact" => [
                        'name' => "$receiver_address->firstname $sender_address->lastname",
                        "phone" => "$receiver_address->phone"
                    ],
                    "addOns" => []
                ],
                "parcels" => [
                    "envelopes" => [],
                    "packages" => $new_pacakage
                ],
                "paymentMethod" => "credit",
                "serviceType" => "selection",
                "currencyCode" => "EUR",
                "insuranceId" => null
            ];
            $shipment = eurosender('quotes', $data);

            //  die ($shipment);
            if (isset($shipment['rates']) && !empty($shipment['rates'])) {
                $rates = $shipment['rates'];
                $new_provider = '2';
            } else {
                $new_provider = '1';
            }
        }

        // if rates provider is main site, fetch rates from shipping cost
        if ($request->service_provider == 1 || $new_provider == 1) {

            $new_provider = '1';
            //get system currency
            $currency = get_currency('code');
            //get shipment cost
            $counts = 0;
            $cost = 0;

            // itemize packages
            if (!empty($request->packages)) {
                if (isset($request->packages[$counts]['package_description']) && isset($request->packages[$counts]['weight']) && isset($request->packages[$counts]['qty'])) {
                    foreach ($request->packages as $package) {
                        if (empty($package['qty'])) {
                            $error = __('messages.There_Was_Problem');
                            return redirect(url()->previous())
                                ->withErrors([$error])
                                ->withInput();
                        }

                        if (empty($package['weight'])) {
                            $error = __('messages.There_Was_Problem');
                            return redirect(url()->previous())
                                ->withErrors([$error])
                                ->withInput();
                        }

                        if ($request->is_guest_rates == 1) { 

                            $address_data = ['sender_data' => $sender_data, 'receiver_data' => $receiver_data ];
                            $address_data = json_encode($address_data);
                            // print_r($address_data); exit;
                            $cost += ($package['qty']) * get_cost($sender_address->id, $receiver_address->id, $package['weight'], $address_data);
                        } else {
                            $cost += ($package['qty']) * get_cost($sender_address->id, $receiver_address->id, $package['weight']);
                        }

                        
                    }
                }
            } else {

                //no package selected 
                $error = __('messages.There_Was_Problem');
                return redirect(url()->previous())
                    ->withErrors([$error])
                    ->withInput();
            }


            $rates = [
                [
                    'object_id' => 1,
                    'attributes' => [],
                    'amount' => $cost,
                    'currency' => $currency,
                    'amount_local' => $cost,
                    'currency_local' => $currency,
                    'provider' => 'MAIN',
                    'provider_image_75' => asset(get_contents_admin('logo_dashboard', '', 'all')),
                    'estimated_days' => get_config('main_estimated_days'),
                    'duration_terms' => '',
                    'servicelevel' => [
                        'name' => 'Standard',
                        'token' => 'main_standard',
                        'terms' => '',

                    ]
                ]
            ];
        }

        $options = [
            'provider' => $new_provider,
            'collection_type' => $collection_type,
            'delivery_type' => $delivery_type,
            'sender_info' => $sender_info,
            'receiver_info' => $receiver_info,
            'sender_branch' => $sender_branch,
            'receiver_branch' => $receiver_branch,
            'total_weight' => $request->total_weight,
            'total_qty' => $request->total_qty,
            'tracking_code_prefix' => $tracking_code_prefix,
            'tracking_code_number' => $tracking_code_number,
            'client' => $client,
            'payment_method' => $payment_method,
            'sender_data' => $sender_data, 
            'receiver_data' => $receiver_data 
        ];

        // pass the data to array
        $resp = [
            'result' => 'success',
            'messages' => __('messages.Sucessful'),
            'object_created' => __('messages.Created'),
            'options' =>  $options,
            'packages' => ['packages' => $request->packages],
            'rates' => $rates
        ];


        $response = json_encode($resp);

        if ($request->is_guest_rates == 1) {
            $data['page_title'] = trans_choice('messages.Shipping_Rate', 2);


            return view(get_theme_dir('contents.rates'))->with([
                'page_title' => $data['page_title'],
                'response' => $response,
                'shipping_rates' => $rates
            ]);
        }

        $data['page_title'] = trans_choice('messages.Order', 1);


        return view(get_theme_dir('shipment.forms.rates', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'response' => $response,
            'shipping_rates' => $rates
        ]);
    }

    /**
     * Calculate shipment cost (old).
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function get_cost(Request $request)
    {
        if ($request->user()->cannot('do_customer')) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.There_Was_Problem'),
                'authorized' => 0,
            ];
            return response()->json($resp);
        }

        // validate inputs
        $validate = Validator::make($request->all(), [
            'sender_info' => 'required',
            'receiver_info' => 'required',
            'shipping_cost' => 'nullable',
            'total_weight' => 'required',
            'total_qty' => 'required',
        ]);

        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Fill_Required_Field_First'),
                'errors' => $validate,
            ];
            return response()->json($resp);
        }

        //get sender address from database
        $sender_address = Address::where('id', $request->sender_info)->first();
        if (!$sender_address) {
            //Invalid Receiver Address
            $resp = [
                [
                    'result' => 'failed',
                    'messages' => __('messages.Invalid_Sender_Address'),
                ],
            ];
            return response()->json($resp);
        }

        //get receiver address from database
        $receiver_address = Address::where('id', $request->receiver_info)->first();
        if (!$receiver_address) {
            //Invalid Receiver Address
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Invalid_Receiver_Address'),
            ];
            return response()->json($resp);
        }

        try {
            //get system currency
            $currency = get_currency('code');
            //get shipment cost
            $counts = 0;
            $cost = 0;
            if (!empty($request->packages)) {
                if (isset($request->packages[$counts]['package_description']) && isset($request->packages[$counts]['weight']) && isset($request->packages[$counts]['qty'])) {
                    foreach ($request->packages as $package) {
                        if (empty($package['qty'])) {
                            $package['qty'] = 1;
                        }

                        if (empty($package['weight'])) {
                            $package['weight'] = 1;
                        }

                        $cost += ($package['qty']) * get_cost($sender_address->id, $receiver_address->id, $package['weight']);
                    }
                }
            } else {
                //no package selected 
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.There_Was_Problem'),
                ];
                return response()->json($resp);
            }

            //convert cost
            $cost = convert_currency(get_config('currency_code'), $currency, $cost);
            $subtotal = $cost;
            //calculate tax
            $tax = 0;
            if (get_config('tax') == 'enabled') {
                if (get_config('tax_type') == 'fixed') {
                    $tax = convert_currency(get_config('tax_currency'), $currency, get_config('tax_amount'));
                    $cost = $cost + $tax;
                }

                if (get_config('tax_type') == 'percent') {
                    $tax = $cost % get_config('tax_amount');
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
                    $discount = $cost % get_config('discount_amount');
                    $cost = $cost - $discount;
                }
            }

            //return data
            $resp = [
                'result' => 'success',
                'messages' => __('messages.Sucessful'),
                'cost_total_weight' => $request->total_weight,
                'cost_total_qty' => $request->total_qty,
                'cost_total_subtotal' => get_money($subtotal, $currency, 'full'),
                'cost_total_tax' => '+' . get_money($tax, $currency, 'full'),
                'cost_total_discount' => '-' . get_money($discount, $currency, 'full'),
                'cost_total_cost' => get_money($cost, $currency, 'full'),
            ];
            return response()->json($resp);
        } catch (\Throwable $th) {
            throw $th;
        }
    }

    /**
     * Remove a specified resource from the storage.
     *
     * @param Shipment $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete(Shipment $id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if ($request->user()->cannot('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $id->delete();
        //delete shipment log data
        DB::table('shipment_log')
            ->where('shipment_id', $id->code)
            ->delete();
        //delete shipment package data
        DB::table('shipment_package')
            ->where('shipment_id', $id->code)
            ->delete();

        //delete shipment provider data
        DB::table('shipment_providers')
            ->where('shipment_id', $id->code)
            ->delete();

        Session::flash('form_response', __('messages.Deleted_Success'));
        Session::flash('form_response_status', 'success');
        return redirect(route('dashboard.shipments'));
    }

    /**
     * Remove a specified resource log from the storage.
     *
     * @param ShipmentLog $id, Request $request
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function deletelog(ShipmentLog $id, Request $request)
    {
        //Unauthorized access - only for admins/moderators/staffs
        if ($request->user()->cannot('do_staff')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $id->delete();
        Session::flash('form_response', __('messages.Deleted_Success'));
        Session::flash('form_response_status', 'success');
        return redirect(url()->previous());
    }

    /**
     * Remove a specified resource package from the storage.
     *
     * @param Request $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function deletepackage(Packages $id, Request $request)
    {
        //Unauthorized access - only for admins/moderators/staffs
        if ($request->user()->cannot('do_staff')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $id->delete();
        Session::flash('form_response', __('messages.Deleted_Success'));
        Session::flash('form_response_status', 'success');
        return redirect(url()->previous());
    }

    /**
     * show agent page.
     *
     * @param mixed $id, Request $request
     * @return Renderable
     */
    public function agent_list($id, Request $request)
    {
        $shipment = Shipment::where('id', $id)->firstOrFail();
        $data['page_title'] = trans_choice('messages.Delivery_Agent', 2);

        return view(get_theme_dir('shipment.assign', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'shipment' => $shipment,
            'id' => $id
        ]);
    }

    /**
     * Display DataTable of the specified  resource.
     *
     * @param mixed $country, Request $request 
     * @return DataTables.
     */
    public function agent_datatable($country, Request $request)
    {
        if ($request->ajax()) {
            //settings
            $users = User::whereRaw("country = '$country' AND role = 2 AND status = 1")->orderByDesc('created_at');
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function (User $user) {
                    $actionBtn = '-';
                    //settings

                    $role = Auth()->user()->role;
                    if ($role >= 4) {
                        $shipment = Shipment::where('id', $_GET['shipment'])->first();

                        $url = route('dashboard.shipments.assign.agent', ['id' => $shipment->id,  'agent' => $user->id]);
                        $url_text = trans_choice('messages.Assign', 1);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-plus'></i> $url_text</a>";
                    }

                    return $actionBtn;
                })

                ->editColumn('id', function (User $user) {
                    $url = route('dashboard.users.view', ['id' => $user->id]);
                    $newid = "<a href='{$url}'>{$user->id}</a> ";

                    return $newid;
                })

                ->editColumn('firstname', function (User $user) {
                    $detail = "<b>{$user->firstname} {$user->lastname}</b> <br>{$user->phone}<br>{$user->email}";

                    return $detail;
                })

                ->editColumn('username', function (User $user) {
                    $shipment_id = $_GET['shipment'];
                    $shipment = __('messages.Active') . ': ';
                    $shipment .= Shipment::whereRaw("delivery_agent = '$user->id'")->count();
                    $shipment .= '<br>';
                    $shipment .= __('messages.Delivered') . ': ';
                    $shipment .= Shipment::whereRaw("delivery_agent = '$user->id' AND status = 13")->count();


                    return $shipment;
                })

                ->editColumn('avatar', function (User $user) {
                    if ($user->avatar) {
                        $avatar = '<div class="avatar bg-rgba-primary m-0 me-50"> <img src="' . asset($user->avatar) . '" alt="" srcset=""> <span class="avatar-status bg-' . get_status_color($user->status) . '"></span> </div>';
                    } else {
                        $avatar_char1 = substr($user->firstname, 0, 1);
                        $avatar = '<div class="avatar bg-warning me-3"> <span class="avatar-content">' . $avatar_char1 . '</span> <span class="avatar-status bg-' . get_status_color($user->status) . '"></span> </div>';
                    }

                    return $avatar;
                })

                ->rawColumns(['id', 'avatar', 'firstname', 'username',  'action'])
                ->make(true);
        }
    }

    /**
     * show agent page.
     *
     * @param mixed $id, mixed $agent, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function assign_agent($id, $agent, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if ($request->user()->cannot('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $shipment = Shipment::where('id', $id)->firstOrFail();

        $update = Shipment::where('id', $shipment->id)->update(['delivery_agent' => $agent]);
        if ($update) {

            return redirect(route('dashboard.shipments.view', ['id' => $shipment->code]))->with([
                'form_response' => __('messages.Saved')
            ]);
        }

        return redirect(url()->previous())->withErrors([
            'errors' => __('messages.Request_Failed')
        ]);
    }


    public function create_shipment($id, $shippoService)
    {

        $request = Orders::where('id', $id)->first();

        try {

            // connect  provider
            $status = Orders::where('id', $id)->first();
            $rate = ShipmentProviders::where('shipment_id', $status->code)->first();

            if ($status->is_approved == 0) {

                if ($rate->provider == 2) {

                    $packages = Packages::where('shipment_id', $status->code)->get();
                    //  pass packages to json
                    $reset_package = '[';
                    $count = 0;
                    foreach ($packages as $key => $package) {

                        $weight = $package['weight'];
                        $pid =  $status->code  . '-' . $package['id'];
                        $value = $package['value'];
                        $reset_package .= '{"parcelId": "' . $pid  . '", "value": ' . $value  . ', "length": ' . $package['length'] . ', "width": ' . $package['width'] . ', "height": ' . $package['height'] . ', "content": "' . $package['description'] . '", "weight": ' . $weight . ', "quantity" : ' . $package['qty'] . '},';
                    }
                    $reset_package .= '{}]';

                    $new_pacakage = json_decode($reset_package, true);
                    // remove the empty array
                    unset($new_pacakage[count($new_pacakage) - 1]);
                    //die(print_r($new_pacakage));

                    $data = [
                        "shipment" => [
                            "pickupAddress" => [
                                'street' => "$status->sender_address",
                                'city' => "" . Cities::where('id', $status->sender_city)->value('name') . "",
                                'zip' => "" . $status->postal_sender . "",
                                'country' => "" . country_code($status->sender_country) . ""
                            ],
                            "deliveryAddress" => [
                                'street' => "$status->receiver_address",
                                'city' => "" . Cities::where('id', $status->receiver_city)->value('name') . "",
                                'zip' => "" . $status->postal_receiver . "",
                                'country' => "" . country_code($status->receiver_country) . "",

                            ],
                            "pickupDate" => "" . Carbon::tomorrow()->format('Y-m-d\TH:i:sP') . "",

                            "pickupContact" => [
                                "name" => "$status->sender_name",
                                "phone" => "$status->sender_phone"
                            ],
                            "deliveryContact" => [
                                'name' => "$status->receiver_name",
                                "phone" => "$status->receiver_phone"
                            ],
                            "addOns" => []
                        ],
                        "parcels" => [
                            "envelopes" => [],
                            "packages" => $new_pacakage
                        ],
                        "paymentMethod" => "credit",
                        "serviceType" => "" . ShipmentProviders::where('shipment_id', $status->code)->value('token') . "",
                        "currencyCode" => "EUR",
                        "insuranceId" => null,
                        "orderContact" => [
                            "email" => "$status->sender_email",
                            "name" => "$status->sender_name",
                            "phone" => "$status->sender_phone",
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

                        ShipmentProviders::where('shipment_id', $status->code)->update([
                            'label' => $transaction['labelLink'],
                            'tracking_number' => $transaction['orderCode'],
                            'tracking_status' => $transaction['status']
                        ]);

                        // die($transaction);
                    } else {

                        // die($transaction);
                        $response = "Shipping Provider Transaction failed with messages: ";
                        $message =  $response .  $transaction['title'] . ' ' . $transaction['invalid-params'][0]['reason'];

                        return back()->withErrors([
                            'errors' => $message,
                        ]);
                    }
                }
                if ($rate->provider == 3) {


                    $transaction  = $shippoService->createTransaction([
                        'rate' => $rate->object_id
                    ]);

                    // Print the shipping label from label_url
                    // Get the tracking number from tracking_number

                    if ($transaction['status'] == 'SUCCESS') {

                        ShipmentProviders::where('shipment_id', $status->code)->update([
                            'label' => $transaction['label_url'],
                            'tracking_number' => $transaction['tracking_number'],
                            'tracking_status' => $transaction['tracking_status']
                        ]);

                        // die($transaction);
                    } else {

                        // die($transaction);
                        $response = "Transaction failed with messages: ";
                        $message =  $response .  $transaction['messages'][0]['text'];

                        return back()->withErrors([
                            'errors' => $message,
                        ]);
                    }
                }

                $status->status = '1';
                $status->is_approved = 1;
                $status->note = 1;
                $status->save();
            }

            //no issue with provider
            //store shipment

            $shipment = Orders::create([
                'code' => $request->code,
                'invoice_id' => $request->invoice_id,
                'status' => 1,
                'sender_address_id' => $request->sender_address_id,
                'receiver_address_id' => $request->receiver_address_id,
                'sender_name' => $request->sender_name,
                'sender_phone' => $request->sender_phone,
                'sender_email' => $request->sender_email,
                'sender_country' => $request->sender_country,
                'sender_state' => $request->sender_state,
                'postal_sender' => $request->postal_sender,
                'sender_city' => $request->sender_city,
                'sender_address' => $request->sender_address,
                'receiver_phone' => $request->receiver_phone,
                'receiver_email' => $request->receiver_email,
                'receiver_name' => $request->receiver_name,
                'receiver_address' => $request->receiver_address,
                'receiver_country' => $request->receiver_country,
                'receiver_state' => $request->receiver_state,
                'receiver_city' => $request->receiver_city,
                'postal_receiver' => $request->postal_receiver,
                'current_location' => $request->current_location,
                'delivery_timeline' => $request->delivery_timeline,
                'subtotal' => $request->subtotal,
                'shipping_cost' => $request->shipping_cost,
                'tax' => $request->tax,
                'discount' => $request->discount,
                'currency' => $request->currency,
                'payment_method' => $request->payment_method,
                'payment_status' => $request->payment_status,
                'payment_type' => 1,
                'total_weight' => $request->total_weight,
                'qty' => $request->qty,
                'from_area' => $request->from_area,
                'to_area' => $request->to_area,
                'from_branch' => $request->from_branch,
                'to_branch' => $request->to_branch,
                'delivery_type' => $request->delivery_type,
                'collection_type' => $request->collection_type,
                'note' => 0,
                'created_by' => Auth()->user()->id,
                'owner_id' => $request->owner_id,
            ]);

            if ($shipment) {
                DB::commit();

                foreach (OrderPackages::where('shipment_id', $request->code) as $package) {

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
                $logs->shipment_id = $request->code;
                $logs->save();
                // create the label
                $logs = new ShipmentLog();
                $logs->note = 1;
                $logs->shipment_id = $request->code;
                $logs->save();

                // add the API provider

                foreach (OrderProviders::where('shipment_id', $request->code) as $order_provider) {
                    $provider = new ShipmentProviders();
                    $provider->shipment_id = $order_provider->shipment_id;
                    $provider->object_id = $order_provider->object_id;
                    $provider->name = $order_provider->provider;
                    $provider->service_name = $order_provider->service_name;
                    $provider->provider = $order_provider->provider;
                    $provider->token = $order_provider->token;
                    $provider->duration = $order_provider->duration;
                    $provider->save();
                }
                
                // send Notifications
                foreach (LaravelLocalization::getSupportedLocales() as $localeCode => $properties) {
                    $subject[$localeCode] =  Lang::get('messages.Note_Created', [], $localeCode) . " - " . $status->code;
                    $message[$localeCode] =  Lang::get('messages.Note_Label_Created', [], $localeCode) . " - " . $status->code;
                }
                send_notification('shipment', $id, json_encode($subject), json_encode($message));

                // Session::flash('form_response', __('messages.Created'));
                // Session::flash('form_response_status', 'success');

                //return data
                return redirect(route("dashboard.shipments.view", ['id' => $shipment->code]));
            } else {
                DB::rollback();
            }
        } catch (\Throwable $th) {
            throw $th;
        }
    }
}
