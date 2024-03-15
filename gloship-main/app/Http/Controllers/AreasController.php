<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Areas;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AreasController extends Controller

{

    /**
     * Display a listig of the resource.
     *
     * @param Request $request)
     * @return Renderable.
     */
    public function areas(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] =  trans_choice('messages.Covered_Area', 2);
        return view(get_theme_dir('areas/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'id' => '0'
        ]);
    }

    /**
     * Display a listig of the resource.
     *
     * @param mixed id, Request $request)
     * @return Renderable.
     */
    public function area_view($id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $city = get_dataBy_id($id, 'cities', 'name');
        $data['page_title'] =  trans_choice('messages.Covered_Area', 2) .': '. $city;
        return view(get_theme_dir('areas/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'id' => $id
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param Request $request
     * @return Renderable.
     */
    public function add(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Add_Area');
        return view(get_theme_dir('areas/create', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param  Areas $id, Request $request
     * @return Renderable.
     */
    public function edit(Areas $id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $areas = Areas::find($id)->first();
        if ($areas) {
            $data['page_title'] = __('messages.Edit') . $areas->id;
            return view(get_theme_dir('areas/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'area' => $areas,
                'id' => $areas->id
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    /**
     * Display DataTable of the specified  resource.
     *
     * @param $type, Request $request
     * @return DataTables.
     */
    public function datatable($type, Request $request)
    {
        if ($request->ajax()) {
            //query            
            $areas = Areas::orderByDesc('created_at');
            if ($type > 0) {
                $areas = Areas::where('city_id', $type)->orderByDesc('created_at');
            }



            return DataTables::of($areas)
                ->addIndexColumn()
                ->addColumn('action', function (Areas $area) {
                    $actionBtn = '-';
                    //user role settings
                    $role = Auth()->user()->role;
                    if ($role  >= 4) {
                        $url = route("dashboard.area.edit", ['id' => $area->id]);
                        $url_delete = route("dashboard.area.delete", ['id' => $area->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";

                        $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('city_id', function (Areas $area) {
                    return get_dataBy_id($area->city_id, 'cities', 'name');
                })
                ->editColumn('state_id', function (Areas $area) {
                    return get_dataBy_id($area->state_id, 'states', 'name');
                })
                ->editColumn('country_code', function (Areas $area) {
                    $country = country_name($area->country_code);

                    return $country;
                })
                ->editColumn('status', function (Areas $area) {
                    $status_name =  get_status('', $area->status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($area->status) . " font-12'>{$status_name}</span></div>";
                    return $status;
                })
                ->rawColumns(['country_id', 'status', 'action'])
                ->make(true);
        }
    }

    /**
     * Store newly created resources in storage.
     *
     * @param Request $request
     * @return  Illuminate\Http\Response.
     */
    public function create(Request $request)
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
            'name'  => 'required|max:200',
            'city' => 'required',
            'state' => 'required',
            'country'  => 'required',
            'status'  => 'integer',
        ]);

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
            $create = Areas::create([
                'name'  => $request->name,
                'city_id' => $request->city,
                'state_id' => $request->state,
                'country_id'  => $request->country,
                'country_code'  => country_code($request->country),
                'status' => $request->status
            ]);
            if ($create) {
                DB::commit();
                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Saved'),
                    'redirect_url' => route('dashboard.areas'),
                ];
                return response()->json($resp);
            } else {
                DB::rollback();
                // Session::flash('modal_open', $request->modal);
                // return redirect(url()->previous())->withErrors([
                //     'errors' => __('messages.There_Was_Problem')
                // ]);
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
     * @return  \Illuminate\Http\Response.
     */
    public function update(Request $request, $id)
    {
        //Unauthorized access - only for admins/moderators
        if (Auth()->user()->role < 4) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        $model = Areas::where('id', $id)->get();

        if ($model) {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name'  => 'required|max:200',
                'city' => 'required',
                'state' => 'required',
                'country'  => 'required',
                'status'  => 'integer',
            ]);
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }

            try {
                DB::beginTransaction();
                $update = Areas::where('id', $id)->update([
                    'name'  => $request->name,
                    'city_id' => $request->city,
                    'state_id' => $request->state,
                    'country_id'  => $request->country,
                    'country_code'  => country_code($request->country),
                    'status' => $request->status
                ]);

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
     * Remove a specified resource from the storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\Response.
     */
    public function delete($id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $area  = Areas::where('id', $id)->first();
        if ($request->confirm == '') {
            $data['page_title'] = __('messages.Area') . ' ' . $area->name;

            if ($area->id) {
                return view(get_theme_dir('areas/delete', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                    'area' => $area,
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Request_Failed')
                ]);
            }
        }

        if ($request->confirm == 1) {

            $delete = Areas::where('id', $id)->delete();
            if ($delete) {
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route("dashboard.areas"));
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.There_Was_Problem')
                ]);
            }
        }
    }
}
