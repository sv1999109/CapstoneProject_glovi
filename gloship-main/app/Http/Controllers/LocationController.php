<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Address;
use App\Models\Cities;
use App\Models\States;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Areas;
use App\Models\Countries;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class LocationController extends Controller
{
    /**
     * Display a listig of the resource.
     *
     * @param mixed $type
     * @return Renderable.
     */
    public function list($type)
    {
        if ($type == 'countries' || $type == 'country') {
            $type == 'countries';
            $data['page_title'] = trans_choice('messages.Country', 2);
        }
        if ($type == 'states' || $type == 'state') {
            $type == 'states';
            $data['page_title'] = trans_choice('messages.State', 2);
        }
        if ($type == 'cities' || $type == 'city') {
            $type == 'cities';
            $data['page_title'] = trans_choice('messages.City', 2);
        }

        return view(get_theme_dir('locations/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'type' => $type,
        ]);
    }

    /**
     * Display the specified  resource.
     *
     * @param mixed $type, int $id
     * @return Renderable.
     */
    public function view($type, $id)
    {
        if ($type == 'states') {
            $query = get_dataBy_id($id, 'countries', 'name');
            $data['page_title'] = $query . ' ' . trans_choice('messages.State', 1);
        }
        if ($type == 'cities') {
            $query = get_dataBy_id($id, 'states', 'name');
            $data['page_title'] = $query . ' ' . trans_choice('messages.City', 1);
        }

        return view(get_theme_dir('locations/view', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'type' => $type,
            'id' => $id,
        ]);
    }

     /**
     * Show the form for creating a new resources.
     *
     * @param mixed $type
     * @return Renderable.
     */
    public function add($type)
    {
        if ($type == 'countries') {
            $type = 'country';
            $data['page_title'] = __('messages.Add_New') . ' ' . trans_choice('messages.Country', 1);
        }
        if ($type == 'states') {
            $type = 'state';
            $data['page_title'] = __('messages.Add_New') . ' ' . trans_choice('messages.State', 1);
        }
        if ($type == 'cities') {
            $type = 'city';
            $data['page_title'] = __('messages.Add_New') . ' ' . trans_choice('messages.City', 1);
        }

        return view(get_theme_dir('locations/create', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'type' => $type,
        ]);
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param mixed $type, int $id
     * @return Renderable.
     */
    public function edit($type, $id)
    {
        if ($type == 'country') {
            $type = 'country';
            $location = Countries::where('id', $id)->first();
            $data['page_title'] = __('messages.Edit') . ' >> ' . trans_choice('messages.Country', 1) . ' >> ' . $location->name;
        }
        if ($type == 'state') {
            $type = 'state';
            $location = States::where('id', $id)->first();
            $data['page_title'] = __('messages.Edit') . ' >> ' . trans_choice('messages.State', 1) . ' >> ' . $location->name;
        }
        if ($type == 'city') {
            $type = 'city';
            $location = Cities::where('id', $id)->first();
            $data['page_title'] = __('messages.Edit') . ' >> ' . trans_choice('messages.City', 1) . ' >> ' . $location->name;
        }

        if ($location) {
            return view(get_theme_dir('locations/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'model' => $location,
                'type' => $type,
                'id' => $id,
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    /**
     * Display DataTable of the specified resource.
     *
     * @param  mixed $type, int $user_id, Request $request
     * @return DataTables.
     */
    public function datatable($type, Request $request)
    {
        if ($request->ajax()) {
            //filter query request
            if ($type == 'countries') {
                $query = Countries::orderBy('name');
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function (Countries $location) {
                        $actionBtn = '-';
                        //settings
                        $role = Auth()->user()->role;
                        if ($role >= 4) {
                            $url = route('dashboard.location.edit', ['type' => 'country', 'id' => $location->id]);
                            $url_delete = route('dashboard.location.delete', ['type' => 'country', 'id' => $location->id]);
                            $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                            $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                        }

                        return $actionBtn;
                    })
                    ->editColumn('id', function (Countries $location) {
                        $url = route('dashboard.location.view', ['type' => 'states', 'id' => $location->id]);
                        $actionUrl = "<a  href='{$url}'>{$location->id}</a>";
                        return $actionUrl;
                    })
                    ->editColumn('phone_code', function (Countries $location) {
                        return '+' . $location->phone_code;
                    })

                    ->editColumn('status', function (Countries $location) {
                        $status_name = get_status('', $location->status);
                        $status = "<span class='text-success font-12'>{$status_name}</span>";
                        return $status;
                    })
                    ->rawColumns(['id', 'status', 'action'])
                    ->make(true);
            }

            if ($type == 'states') {
                $query = States::orderBy('name');
                if (isset($request->id)) {
                    $query = States::where('country_id', $request->id)->orderBy('name');
                }
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function (States $location) {
                        $actionBtn = '-';
                        //settings
                        $role = Auth()->user()->role;
                        if ($role >= 4) {
                            $url = route('dashboard.location.edit', ['type' => 'state', 'id' => $location->id]);
                            $url_delete = route('dashboard.location.delete', ['type' => 'state', 'id' => $location->id]);
                            $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                            $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                        }

                        return $actionBtn;
                    })
                    ->editColumn('id', function (States $location) {
                        $url = route('dashboard.location.view', ['type' => 'cities', 'id' => $location->id]);
                        $actionUrl = "<a  href='{$url}'>{$location->id}</a>";
                        return $actionUrl;
                    })
                    ->editColumn('status', function (States $location) {
                        $status_name = get_status('', $location->status);
                        $status = "<span class='text-success font-12'>{$status_name}</span>";
                        return $status;
                    })

                    ->editColumn('country_code', function (States $location) {
                        return country_name($location->country_code) . " ($location->country_code)";
                    })
                    ->rawColumns(['id', 'status', 'action'])
                    ->make(true);
            }
            if ($type == 'cities') {
                $query = Cities::orderBy('name');
                if (isset($request->id)) {
                    $query = Cities::where('state_id', $request->id)->orderBy('name');
                }
                return DataTables::of($query)
                    ->addIndexColumn()
                    ->addColumn('action', function (Cities $location) {
                        $actionBtn = '-';
                        //settings
                        $role = Auth()->user()->role;
                        if ($role >= 4) {
                            $url = route('dashboard.location.edit', ['type' => 'city', 'id' => $location->id]);
                            $url_delete = route('dashboard.location.delete', ['type' => 'city', 'id' => $location->id]);
                            $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                            $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                        }

                        return $actionBtn;
                    })
                    ->editColumn('id', function (Cities $location) {
                        $url = route('dashboard.area.view', ['id' => $location->id]);
                        $actionUrl = "<a  href='{$url}'>{$location->id}</a>";
                        return $actionUrl;
                    })

                    ->editColumn('country_code', function (Cities $location) {
                        return country_name($location->country_code) . " ($location->country_code)";
                    })
                    ->editColumn('state_id', function (Cities $location) {
                        $state_name = get_dataBy_id($location->state_id, 'states', 'name');

                        return $state_name;
                    })
                    ->editColumn('status', function (Cities $location) {
                        $status_name = get_status('', $location->status);
                        $status = "<span class='text-success font-12'>{$status_name}</span>";
                        return $status;
                    })
                    ->rawColumns(['id', 'status', 'action'])
                    ->make(true);
            }
        }
    }

     /**
     * Store newly created resources in storage.
     *
     * @param mixed $type, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function create($type, Request $request)
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
        if ($type == 'country') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|unique:countries,name|string',
                'iso2' => 'required|max:2|min:2|unique:countries,iso2|alpha',
                'iso3' => 'nullable|max:3|min:3|unique:countries,iso3|alpha',
                'phone_code' => 'nullable|max:3|integer',
                'region' => 'nullable|max:100|string',
                'subregion' => 'nullable|max:100|string',
                'status' => 'required',
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
                $create = Countries::create([
                    'name' => $request->name,
                    'iso2' => strtoupper($request->iso2),
                    'iso3' => strtoupper($request->iso3),
                    'phone_code' => $request->phone_code,
                    'region' => $request->region,
                    'subregion' => $request->subregion,
                    'status' => $request->status,
                ]);
                if ($create) {
                    DB::commit();
                    Session::flash('form_response', __('messages.Created'));
                    Session::flash('form_response_status', 'success');
                    $resp = [
                        'result' => 'success',
                        'messages' => __('messages.Created'),
                        'redirect_url' => route('dashboard.location.list', ['type' => 'countries']),
                    ];
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

        if ($type == 'state') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'country' => 'required|integer',
                'status' => 'required',
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
                $create = States::create([
                    'name' => $request->name,
                    'country_id' => $request->country,
                    'country_code' => country_code($request->country),
                    'status' => $request->status,
                ]);
                if ($create) {
                    DB::commit();
                    Session::flash('form_response', __('messages.Created'));
                    Session::flash('form_response_status', 'success');
                    $resp = [
                        'result' => 'success',
                        'messages' => __('messages.Created'),
                        'redirect_url' => route('dashboard.location.list', ['type' => 'states']),
                    ];
                } else {
                    DB::rollback();
                    return redirect(url()->previous())->withErrors([
                        'errors' => __('messages.Operation_Failed'),
                    ]);
                }
            } catch (\Throwable $th) {
                DB::rollback();
                throw $th;
            }
        }

        if ($type == 'city') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'country' => 'required|integer',
                'state' => 'required|integer',
                'status' => 'required',
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
                $create = Cities::create([
                    'name' => $request->name,
                    'country_id' => $request->country,
                    'country_code' => country_code($request->country),
                    'state_id' => $request->state,
                    'status' => $request->status,
                ]);
                if ($create) {
                    DB::commit();
                    Session::flash('form_response', __('messages.Created'));
                    Session::flash('form_response_status', 'success');
                    $resp = [
                        'result' => 'success',
                        'messages' => __('messages.Created'),
                        'redirect_url' => route('dashboard.location.list', ['type' => 'cities']),
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
     * @param mixed $type, int $id, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update($type, $id, Request $request)
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

        if ($type == 'country') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'iso2' => 'required|max:2|min:2|alpha',
                'iso3' => 'nullable|max:3|min:3|alpha',
                'phone_code' => 'nullable|integer',
                'region' => 'nullable|max:100|string',
                'subregion' => 'nullable|max:100|string',
                'status' => 'required',
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
                $update = Countries::where('id', $id)->update([
                    'name' => $request->name,
                    'iso2' => strtoupper($request->iso2),
                    'iso3' => strtoupper($request->iso3),
                    'phone_code' => $request->phone_code,
                    'region' => $request->region,
                    'subregion' => $request->subregion,
                    'status' => $request->status,
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

        if ($type == 'state') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'country' => 'required|integer',
                'status' => 'required',
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
                $update = States::where('id', $id)->update([
                    'name' => $request->name,
                    'country_id' => $request->country,
                    'country_code' => country_code($request->country),
                    'status' => $request->status,
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

        if ($type == 'city') {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name' => 'required|max:100|string',
                'country' => 'required|integer',
                'state' => 'required|integer',
                'status' => 'required',
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
                $update = Cities::where('id', $id)->update([
                    'name' => $request->name,
                    'country_id' => $request->country,
                    'country_code' => country_code($request->country),
                    'state_id' => $request->state,
                    'status' => $request->status,
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
     * @param mixed $type, int $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete($type, $id, Request $request)
    {
        ;
        
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        if ($request->confirm == '') {
            if ($type == 'country') {
                $type = 'country';
                $location = Countries::where('id', $id)->first();
                $data['page_title'] = __('messages.Delete') . ' >> ' . trans_choice('messages.Country', 1) . ' >> ' . $location->name;
            }
            if ($type == 'state') {
                $type = 'state';
                $location = States::where('id', $id)->first();
                $data['page_title'] = country_name($location->country_id) . ' >> ' . __('messages.Delete') . ' >> ' . trans_choice('messages.State', 1) . ' >> ' . $location->name;
            }
            if ($type == 'city') {
                $type = 'city';
                $location = Cities::where('id', $id)->first();
                $data['page_title'] = country_name($location->country_id) . ' >> ' . get_dataBy_id($location->state_id, 'states', 'name') . ' >> ' . __('messages.Delete') . ' >> ' . trans_choice('messages.City', 1) . ' >> ' . $location->name;
            }

            if ($location) {
                return view(get_theme_dir('locations/delete', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                    'type' => $type,
                    'location' => $location,
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Request_Failed'),
                ]);
            }
        }

        if ($request->confirm == 1) {
            if ($type == 'country') {
                $type = 'countries';
                //delete data from db
                $delete = Countries::where('id', $id)->delete();
                $state = States::where('country_id', $id)->delete();
                $city = Cities::where('country_id', $id)->delete();
                $area = Areas::where('country_id', $id)->delete();
            }
            if ($type == 'state') {
                $type = 'states';
                //delete data from db
                $delete = States::where('id', $id)->delete();
                $city = Cities::where('state_id', $id)->delete();
                $area = Areas::where('state_id', $id)->delete();
            }
            if ($type == 'city') {
                $type = 'cities';
                //delete data from db
                $delete = Cities::where('id', $id)->delete();
                $area = Areas::where('city_id', $id)->delete();
            }
            if ($delete) {
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route('dashboard.location.list', ['type' => $type]));
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Operation_Failed'),
                ]);
            }
        }
    }
}
