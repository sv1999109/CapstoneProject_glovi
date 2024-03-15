<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Currency;
use App\Models\ExchangeRates;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class CurrencyController extends Controller

{

    /**
     * Display listing of the resource.
     * 
     * @param null
     * @return Renderable.
     */
    public function list()
    {
        $data['page_title'] = trans_choice('messages.Currency', 1);

        return view(get_theme_dir('settings/currencies/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],

        ]);
    }

    /**
     * Display DataTable listing of the specified resource.
     * 
     * @param Request $request
     * @return DataTables.
     */
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            $currencies = Currency::all();

            return DataTables::of($currencies)
                ->addIndexColumn()
                ->addColumn('action', function (Currency $cur) {
                    $actionBtn = '-';

                    $role = Auth()->user()->role;
                    if ($role  >= 4) {
                        $url = route("dashboard.currency.edit", ['type' => 'currency', 'id' => $cur->id]);
                        // $url_delete = route("dashboard.currency.delete", ['id' => $cur->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";

                        // $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                        //    href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('exchange_rate', function (Currency $cur) {
                    return number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $cur->exchange_rate)), 2);
                })
                ->editColumn('country_id', function (Currency $cur) {
                    return country_name($cur->country_id);
                })
                ->editColumn('status', function (Currency $cur) {
                    $status_name =  get_status('', $cur->status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($cur->status) . " font-12'>{$status_name}</span></div>";
                    return $status;
                })


                ->editColumn('created_at', function (Currency $cur) {
                    $created_at = \Illuminate\Support\Carbon::parse($cur->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d');
                    return $created_at;
                })
                ->rawColumns(['status', 'code', 'exchange_rate', 'country_id', 'created_at', 'action'])
                ->make(true);
        }
    }

    /**
     * Display DataTable listing of the specified resource.
     * 
     * @param Request $request
     * @return DataTables.
     */
    public function exchange_rates_datatable(Request $request)
    {
        if ($request->ajax()) {
            $currencies = ExchangeRates::orderBy('id', 'asc');
            return DataTables::of($currencies)
                ->addIndexColumn()
                ->addColumn('action', function (ExchangeRates $cur) {
                    $actionBtn = '-';

                    $role = Auth()->user()->role;
                    if ($role  >= 4) {
                        $url = route("dashboard.currency.edit", ['type' => 'rates', 'id' => $cur->id]);
                        // $url_delete = route("dashboard.currency.delete", ['id' => $cur->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('exchange_rate', function (ExchangeRates $cur) {
                    return number_format(sprintf('%0.2f', preg_replace("/[^0-9.]/", "", $cur->exchange_rate)), 2);
                })

                ->editColumn('status', function (ExchangeRates $cur) {
                    $status_name =  get_status('', $cur->status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($cur->status) . " font-12'>{$status_name}</span></div>";
                    return $status;
                })


                ->editColumn('created_at', function (ExchangeRates $cur) {
                    $created_at = \Illuminate\Support\Carbon::parse($cur->created_at)->setTimezone(\Helpers::getUserTimeZone())->format('Y-m-d');
                    return $created_at;
                })
                ->rawColumns(['status', 'code', 'exchange_rate', 'created_at', 'action'])
                ->make(true);
        }
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param mixed $type, Request $request
     * @return  Renderable.
     */
    public function add($type, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Add') . ' ' .  trans_choice('messages.Currency', 1);
        if ($type == 'rates') {
            $data['page_title'] = __('messages.Add') . ' ' .  trans_choice('messages.Exchange_Rate', 1);
        }
        return view(get_theme_dir('settings/currencies/add', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'type' => $type,
        ]);
    }
    /**
     * Show the form for editing a specified resource.
     *
     * @param mixed $type,int $id, Request $request
     * @return Renderable.
     */
    public function edit($type, $id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Edit') . ' ' .  trans_choice('messages.Currency', 1);
        $currency = Currency::where('id', $id)->first();
        if ($type == 'rates') {
            $data['page_title'] = __('messages.Update') . ' ' .  trans_choice('messages.Exchange_Rate', 1);
            $currency = ExchangeRates::where('id', $id)->first();
        }
        if ($currency) {
            return view(get_theme_dir('settings/currencies/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'model' => $currency,
                'type' => $type,
                'id' => $id
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    /**
     * Store newly created resources in storage.
     *
     * @param mixed $type,  Request $request
     * @return \Illuminate\Http\JsonResponse.
     */
    public function create($type, Request $request)
    {
        ;
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }

        if ($type == 'currency') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'country'  => 'required|unique:currencies,country_id',
                'name' => 'required|max:100',
                'code' => 'required|max:4|alpha',
                'symbol' => 'required|max:4',
                'status'  => 'required|integer'
            ]);
        }

        if ($type == 'rates') {
            
            //validate input fields
            $validate = Validator::make($request->all(), [
                'currency'  => 'required|unique:exchange_rates,code',
                'exchange_rate' => 'required',
                'status'  => 'required|integer'
            ]);
        }
        //input has error(s)
        if ($validate->fails()) {
            $resp = [
                'result' => 'errors',
                'messages' => $validate->errors(),
            ];
            return response()->json($resp);
        }

        //no error insert into db
        try {
            DB::beginTransaction();
            if ($type == 'currency') {
                $create = Currency::create([
                    'name'  => $request->name,
                    'code'  => $request->code,
                    'country_id'  => $request->country_id,
                    'symbol'  => $request->symbol,
                    'status' => $request->status
                ]);
            }
            if ($type == 'rates') {
                $create = ExchangeRates::create([
                    'code'  => $request->currency,
                    'exchange_rate'  => $request->exchange_rate,
                    'status' => $request->status
                ]);
            }

            if ($create) {
                DB::commit();

                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Created'),
                    'redirect_url' => route('dashboard.currencies'),
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
     * Update the specified resource in storage.
     *
     * @param Request $request, $id
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update($type, $id, Request $request)
    {
        ;
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        $model = DB::table('currencies')->where('id', $id)->get();

        if ($model) {
            if ($type == 'currency') {
                //validate input fields
                $validate = Validator::make($request->all(), [
                    'name' => 'required|max:100',
                    'code' => 'required|max:4|alpha',
                    'symbol' => 'required|max:4',
                    'status'  => 'required|integer'
                ]);
            }

            if ($type == 'rates') {
                //validate input fields
                $validate = Validator::make($request->all(), [
                    'exchange_rate' => 'required',
                    'status'  => 'required|integer'
                ]);
            }
            //input has error(s)
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }

            //check if currency is default
            if ($request->code == get_config('currency_code') && $request->status == 2) {
                //break if status is deactivate
                $resp = [
                    'result' => 'errors',
                    'messages' => "An error has occured! You cannot deactivate your default currency",
                ];
                return response()->json($resp);
                
            }
            try {
                DB::beginTransaction();
                if ($type == 'currency') {
                    $update = Currency::where('id', $id)->update([
                        'name'  => $request->name,
                        'code'  => $request->code,
                        'symbol'  => $request->symbol,
                        'status' => $request->status
                    ]);
                }
                if ($type == 'rates') {
                    $update = ExchangeRates::where('id', $id)->update([
                        'exchange_rate'  => $request->exchange_rate,
                        'status' => $request->status
                    ]);
                }

                if ($update) {
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse.
     */
    public function setcurrency(Request $request)
    {
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        $model = Currency::where('code', $request->code)->first();

        if ($model) {
            $localize = $request->currency_localize;
            $exchange_rate = DB::table('exchange_rates')->where('code', $model->code)->first();
            if (isset($exchange_rate)) {
                //update currency code
                $update =  Settings::where('site_key', 'currency_code')->update([
                    'value' => $request->code
                ]);
                //update currency localization
                $updete2 =  Settings::where('site_key', 'currency_localize')->update([
                    'value' => $localize
                ]);
                //reset old default locale
                Currency::where('is_default', 1)->update([
                    'is_default' => 0
                ]);
                //set new default locale
                Currency::where('code', $request->code)->update([
                    'is_default' => 1
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.No_Exchange_Found')
                ]);
            }
        }

        if ($update) {
            $clear = new \Symfony\Component\Console\Output\BufferedOutput();
            \Illuminate\Support\Facades\Artisan::call('optimize:clear', array(), $clear);

            Session::flash('form_response', __('messages.Saved'));
            return redirect(url()->previous());
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.There_Was_Problem')
            ]);
        }
    }

    /**
     *  delete currency.
     *
     * @param Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete(Currency $id)
    {
        ;

        if ($id) {

            //check if currency is default
            if ($id->code == get_config('set_locale')) {

                //break if trying to delete default currency

                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Currency_Cannot_Delete')
                ]);
                //exit;
            }
            $id->delete();


            Session::flash('form_response', __('messages.Deleted_Success'));
            return redirect(route("dashboard.settings.currencys"));
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.There_Was_Problem')
            ]);
        }
    }
}
