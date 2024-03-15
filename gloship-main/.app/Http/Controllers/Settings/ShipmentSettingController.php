<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Languages;
use App\Models\Settings;
use App\Models\Shipment;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Costs;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class ShipmentSettingController extends Controller
{
    /**
     * Show the specified resource.
     *
     * @return Renderable.
     */
    public function settings(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Shipment_Settings');
        return view(get_theme_dir('shipment.settings', 'dashboard'), $data);
    }

    /**
     * show shipments invoice page.
     *
     * @param null
     * @return Renderable.
     */
    public function invoice_list()
    {
        $data['page_title'] = trans_choice('messages.Invoice', 2);
        return view(get_theme_dir('shipment.invoice.list', 'dashboard'), $data);
    }

     /**
     * Show the specified resource.
     *
     * @param  $id
     * @return Renderable.
     */
    public function invoice_view($id)
    {
        $model = Shipment::where('invoice_id', $id)->first();
        if ($model) {
            $data['page_title'] = __('messages.Tracking') . ': ' . $model->code;
            return view(get_theme_dir('shipment.invoice.view', 'dashboard'))->with([
                'shipment' => $model,
                'page_title' => $data['page_title'],
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    /**
     * Show the specified resource
     *
     * @param  int $id
     * @return Renderable.
     */
    public function invoice_label($id)
    {
        $model = Shipment::where('invoice_id', $id)->first();
        if ($model) {
            $data['page_title'] = __('messages.Tracking') . ': #' . $model->code;
            return view(get_theme_dir('shipment.invoice.label', 'dashboard'))->with([
                'shipment' => $model,
                'page_title' => $data['page_title'],
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param int $id
     * @return Renderable.
     */
    public function invoice_pay($id)
    {
        $model = Shipment::where('invoice_id', $id)->first();
        if ($model) {
            $data['page_title'] = trans_choice('messages.Invoice', 1) . ': ' . $model->invoice_id;
            return view(get_theme_dir('shipment.invoice.pay', 'dashboard'))->with([
                'shipment' => $model,
                'page_title' => $data['page_title'],
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    /**
     * Display a DataTable listing of shipments invoice.
     *
     * @param  mixed $type, int $user_id, Request $request
     * @return DataTables.
     */
    public function invoice_datatable($type = null, $userid, Request $request)
    {
        if ($request->ajax()) {
            //settings
            $role = Auth()->user()->role;
            $client = Auth()->user()->id;
            $branch = Auth()->user()->branch;

            //moderators/admins
            if ($role >= '4') {
                $shipments = Shipment::orderByDesc('created_at');

                //filter by user
                if ($type == 'user') {
                    $shipments = Shipment::where('owner_id', $userid)->orderByDesc('created_at');
                }
            }
            //staffs
            if ($role == '3') {
                $shipments = Shipment::whereRaw("from_branch = '$branch' OR to_branch = '$branch'")->orderByDesc('created_at');

                //filter by user
                if ($type == 'user') {
                    $shipments = Shipment::where('owner_id', $userid)->orderByDesc('created_at');
                }
            }
            //Delivery Agents
            if ($role == '2') {
                $shipments = Shipment::whereRaw("delivery_agent = '$client'")->orderByDesc('created_at');
            }
            //customers
            if ($role == '1') {
                $shipments = Shipment::whereRaw("owner_id = '$client'")->orderByDesc('created_at');
            }

            return DataTables::of($shipments)
                ->addIndexColumn()
                ->addColumn('action', function (Shipment $shipment) {
                    $actionBtn = '-';
                    //user role settings
                    $role = Auth()->user()->role;
                    $client = Auth()->user()->id;
                    $branch = Auth()->user()->branch;

                    $payment_url = '';
                    if ($shipment->payment_status != 1) {
                        //add make payment url
                        $url = route('dashboard.shipments.invoice.pay', ['id' => $shipment->invoice_id]);
                        $payment_url = "<a href='{$url}'>" . get_badge('success', __('messages.Pay_Now')) . "</a>";

                    }
                    return $payment_url;
                })
                ->editColumn('invoice_id', function (Shipment $shipment) {
                    $url = route('dashboard.shipments.invoice', ['id' => $shipment->invoice_id]);
                    $actionurl = "<a target='_blank' href='{$url}'>{$shipment->invoice_id}</a>";
                    return $actionurl;
                })
                ->editColumn('code', function (Shipment $shipment) {
                    $url = route('dashboard.shipments.view', ['id' => $shipment->code]);
                    $actionurl = "<a href='{$url}'>{$shipment->code}</a>";
                    return $actionurl;
                })

                ->editColumn('payment_status', function (Shipment $shipment) {
                    $status_name = $shipment->payment_status == 1 ? get_badge('success', __('messages.Paid')) : get_badge('danger', __('messages.UnPaid'));
                    $status = "<span class='text-dark font-12'>{$status_name}</span>";
                    return $status;
                })

                ->editColumn('owner_id', function (Shipment $shipment) {
                    $user = User::where('id', $shipment->owner_id)->first();
                    $url = route('dashboard.users.view', ['id' => $shipment->owner_id]);
                    if ($user) {
                        $avatar = '<div class="team"> <a href="' . $url . '" class="team-member"> <b>' . $user->username . '</b> </a> </div>';

                        return $avatar;
                    }
                   
                })

                ->editColumn('shipping_cost', function (Shipment $shipment) {
                    $shipping_cost = get_money($shipment->shipping_cost, $shipment->currency, 'symbol', 'localize');
                    return $shipping_cost;
                })

                ->editColumn('created_at', function (Shipment $shipment) {
                    $created_at = \Illuminate\Support\Carbon::parse($shipment->created_at)
                        ->setTimezone(\Helpers::getUserTimeZone())
                        ->format('Y-m-d');
                    return $created_at;
                })
                ->rawColumns(['invoice_id', 'code', 'shipping_cost', 'owner_id', 'payment_status', 'created_at', 'action'])
                ->make(true);
        }
    }

    /**
     * Display a DataTable listing of shipping cost.
     *
     * @param Request $request
     * @return DataTables.
     */
    public function cost_datatable(Request $request)
    {
        if ($request->ajax()) {
            //query
            $costs = Costs::orderByDesc('created_at');

            return DataTables::of($costs)
                ->addIndexColumn()
                ->addColumn('action', function (Costs $area) {
                    $actionBtn = '-';
                    //user role settings
                    $role = Auth()->user()->role;
                    if ($role >= 4) {
                        $url = route('dashboard.shipments.cost.edit', ['id' => $area->id]);
                        $url_delete = route('dashboard.shipments.cost.delete', ['id' => $area->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";

                        $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('origin_country', function (Costs $area) {
                    return get_name($area->origin_state, 'states') . '-' . get_name($area->origin_country, 'countries');
                })
                ->editColumn('destination_country', function (Costs $area) {
                    $destination = trans_choice('messages.Area', 1) . ': ' . get_name($area->destination_area, 'areas') . '<br>';
                    $destination .= trans_choice('messages.City', 1) . ': ' . get_name($area->destination_city, 'cities') . '<br>';
                    $destination .= trans_choice('messages.State', 1) . ': ' . get_name($area->destination_state, 'states') . '<br>';
                    $destination .= trans_choice('messages.Country', 1) . ': ' . get_name($area->destination_country, 'countries');

                    return $destination;
                })
                ->editColumn('weight_to', function (Costs $area) {
                    $weight = $area->weight_from . ' - ' . $area->weight_to . ' ' . __('messages.KG');
                    return $weight;
                })
                ->editColumn('amount', function (Costs $area) {
                    $weight = get_money($area->amount, $area->currency, 'full', 'localize');
                    return $weight;
                })

                ->editColumn('status', function (Costs $area) {
                    $status_name = get_status('', $area->status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($area->status) . " font-12'>{$status_name}</span></div>";
                    return $status;
                })
                ->rawColumns(['origin_country', 'destination_country', 'amount', 'weight_to', 'status', 'action'])
                ->make(true);
        }
    }

    /**
     * Display a listig of the specified resource.
     *
     * @param Request $request
     * @return Renderable.
     */
    public function cost_show(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Shipment_Settings');
        $costs = Costs::all();
        return view(get_theme_dir('shipment/costs/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'costs' => $costs,
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param Request $request
     * @return  Renderable.
     */
    public function cost_add(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        $data['page_title'] = __('messages.Add_Cost');
        return view(get_theme_dir('shipment/costs/create', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse.
     */
    public function cost_create(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        //validate input fields
        $validate = Validator::make($request->all(), [
            'origin_state' => 'required',
            'origin_country' => 'required',
            'destination_area' => 'nullable',
            'destination_city' => 'nullable',
            'destination_state' => 'required',
            'destination_country' => 'required',
            'weight_from' => 'required',
            'weight_to' => 'required',
            'amount' => 'required',
        ]);

        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }

        //convert currency
        $amount = convert_currency(get_currency('code'), get_config('currency_code'), $request->amount);
        $request->merge([
            'amount' => $amount
        ]);
        //no error insert into db
        try {
            DB::beginTransaction();
            $create = Costs::create([
                'origin_state' => $request->origin_state,
                'origin_country' => $request->origin_country,
                'destination_area' => $request->destination_area,
                'destination_city' => $request->destination_city,
                'destination_state' => $request->destination_state,
                'destination_country' => $request->destination_country,
                'weight_from' => $request->weight_from,
                'weight_to' => $request->weight_to,
                'amount' => $request->amount,
                'currency' => get_config('currency_code')

            ]);
            if ($create) {
                DB::commit();

                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Created'),
                    'redirect_url' => route('dashboard.shipments.cost'),
                ];
                return response()->json($resp);
            } else {
                DB::rollback();
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.There_Was_Problem'),
                ];
                return response()->json($resp);
            }
        } catch (\Throwable $th) {
            DB::rollback();
            throw $th;
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  $id, Request $request
     * @return Renderable.
     */
    public function cost_edit($id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $cost = Costs::where('id', $id)->first();
        if ($cost) {
            $data['page_title'] = __('messages.Edit') . ' ' . __('messages.Shipping_Cost') . ' #' . $id;
            return view(get_theme_dir('shipment/costs/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'model' => $cost,
                'id' => $id,
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

     /**
     * Update the specified resource in storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function cost_update($id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        //validate input fields
        $validate = Validator::make($request->all(), [
            'origin_state' => 'required',
            'origin_country' => 'required',
            'destination_area' => 'nullable',
            'destination_city' => 'nullable',
            'destination_state' => 'required',
            'destination_country' => 'required',
            'weight_from' => 'required',
            'weight_to' => 'required',
            'amount' => 'required',
            'status' => 'required|integer',
        ]);

        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }

        //find cost
        $cost = Costs::where('id', $id)->first();
        if ($cost) {
            //convert currency
            $amount = convert_currency(get_currency('code'), $cost->currency, $request->amount);
            $request->merge([
                'amount' => $amount
            ]);

            //no error insert into db
            try {
                DB::beginTransaction();
                $create = Costs::where('id', $id)->update([
                    'origin_state' => $request->origin_state,
                    'origin_country' => $request->origin_country,
                    'destination_area' => $request->destination_area,
                    'destination_city' => $request->destination_city,
                    'destination_state' => $request->destination_state,
                    'destination_country' => $request->destination_country,
                    'weight_from' => $request->weight_from,
                    'weight_to' => $request->weight_to,
                    'amount' => $request->amount,
                    'status' => $request->status
                ]);
                if ($create) {
                    DB::commit();

                    $resp = [
                        'result' => 'success',
                        'messages' => __('messages.Saved'),
                    ];
                    return response()->json($resp);
                } else {
                    DB::rollback();
                    $resp = [
                        'result' => 'failed',
                        'messages' => __('messages.There_Was_Problem'),
                    ];
                    return response()->json($resp);
                }
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
        }

        //not found
        else {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.There_Was_Problem'),
            ];
            return response()->json($resp);
        }
    }

    /**
     * Remove a specified resource from the storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse..
     */
    public function cost_delete($id, Request $request)
    {
         //Unauthorized access - only for admins/moderators
         if (!$request->user()->can('do_moderator')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        if ($request->confirm == '') {
            $model = Costs::where('id', $id)->first();
            if ($model) {
                // get origin
                $origin = __('messages.Origin') . ':<br>';
                $origin .= get_name($model->origin_state, 'states') . '-' . get_name($model->origin_country, 'countries');

                // get destinations
                $destination = '<hr>' . __('messages.Destination') . ':<br>';
                $destination .= __('messages.Area') . ': ' . get_name($model->destination_area, 'areas') . '<br>';
                $destination .= __('messages.City') . ': ' . get_name($model->destination_city, 'cities') . '<br>';
                $destination .= __('messages.State') . ': ' . get_name($model->destination_state, 'states') . '<br>';
                $destination .= __('messages.Country') . ': ' . get_name($model->destination_country, 'countries') . '<hr>';

                // get amount
                $amount = get_money($model->amount, $model->currency, 'full', 'localize');

                // get weight
                $weight = " ({$model->weight_from}  - {$model->weight_to}" . __('messages.KG') . ')';

                // set page data
                $data['page_title'] = __('messages.Delete') . ' >> ' . __('messages.Shipping_Cost') . ' ' . $model->id;
                $data['page_data'] = __('messages.Delete') . ' >> ' . __('messages.Shipping_Cost') . " #{$model->id}" . '<hr>' . $origin . $destination . $amount . $weight;

                // render view
                return view(get_theme_dir('shipment/costs/delete', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                    'page_data' => $data['page_data'],
                    'model' => $model,
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Request_Failed'),
                ]);
            }
        }

        if ($request->confirm == 1) {
            $delete = Costs::where('id', $id)->delete();
            if ($delete) {
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route('dashboard.shipments.cost'));
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.There_Was_Problem'),
                ]);
            }
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function set_cost(Request $request)
    {
         //Unauthorized access - only for admins/moderators
         if (!$request->user()->can('do_moderator')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        //clear cache data
        $clear = new \Symfony\Component\Console\Output\BufferedOutput();
        \Illuminate\Support\Facades\Artisan::call('optimize:clear', [], $clear);

        //validate input fields
        $validate = Validator::make($request->all(), [
            'default_shipping_cost' => 'required',
        ]);
        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }
        //convert currency
        $default_shipping_cost = convert_currency(get_currency('code'), get_config('default_shipping_cost_currency'), $request->default_shipping_cost);
        $request->merge([
            'default_shipping_cost' => $default_shipping_cost
        ]);

        Settings::where('site_key', 'default_shipping_cost')->update([
            'value' => $request->default_shipping_cost
        ]);

        $resp = [
            'result' => 'success',
            'messages' => __('messages.Saved'),
        ];
        return response()->json($resp);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function set_config(Request $request)
    {
        //clear cache data
        $clear = new \Symfony\Component\Console\Output\BufferedOutput();
        \Illuminate\Support\Facades\Artisan::call('optimize:clear', [], $clear);

        //validate input fields
        $validate = Validator::make($request->all(), [
            'default_tracking_prefix' => 'nullable',
            'tracking_prefix' => 'nullable',
            'tax_type' => 'nullable',
        ]);
        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }
        //retrieve post data
        if ($request->additional_cost_type == 'fixed') {
            $additional_cost_amount = convert_currency(get_currency('code'), get_config('additional_cost_currency'), $request->additional_cost_amount);
            $request->merge([
                'additional_cost_amount' => $additional_cost_amount,
            ]);
        }
        if ($request->tax_type == 'fixed') {
            $tax_amount = convert_currency(get_currency('code'), get_config('tax_currency'), $request->tax_amount);
            $request->merge([
                'tax_amount' => $tax_amount,
            ]);
        }
        if ($request->discount_type == 'fixed') {
            $discount_amount = convert_currency(get_currency('code'), get_config('discount_currency'), $request->discount_amount);
            $request->merge([
                'discount_amount' => $discount_amount,
            ]);
        }
        if ($request->tracking_prefix != 'enabled') {
            $request->merge([
                'tracking_prefix' => ''
            ]);
        }

        if ($request->additional_cost != 'enabled') {
            $request->merge([
                'additional_cost' => ''
            ]);
        }
        if ($request->tax != 'enabled') {
            $request->merge([
                'tax' => ''
            ]);
        }
        if ($request->discount != 'enabled') {
            $request->merge([
                'discount' => ''
            ]);
        }

        if ($request->shipment_terms != '') {
            $request->merge([
                'shipment_terms' => json_encode($request->shipment_terms)
            ]);
        }
        foreach ($request->all() as $key => $data) {

            //filter keys
            if ($key == 'example') {
                //do something
                //for future updates
            } else {
                $fields = [
                    'value' => strip_tags($request[$key], ''),
                ];
                Settings::where('site_key', $key)->update($fields);
            }
        }
        $resp = [
            'result' => 'success',
            'messages' => __('messages.Saved'),
        ];
        return response()->json($resp);
    }
}
