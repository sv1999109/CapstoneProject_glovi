<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Branches;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class BranchController extends Controller

{
     /**
     * Display a listig of the resource.
     *
     * @param Request $request
     * @return Renderable|\Illuminate\Http\RedirectResponse.
     */
    public function branches(Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = trans_choice('messages.Branch', 2);
        return view(get_theme_dir('branches/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param  Request $request
     * @return  Renderable|\Illuminate\Http\RedirectResponse.
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
        $data['page_title'] = __('messages.Add_Branch');
        return view(get_theme_dir('branches/create', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param  $id, Request $request
     * @return Renderable|\Illuminate\Http\RedirectResponse.
     */
    public function edit($id, Request $request)
    {
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Edit') . ' ' . $id;
        $branches = Branches::where('id', $id)->first();
        if ($branches) {
            return view(get_theme_dir('branches/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'branch' => $branches,
                'id' => $id
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
     * @return DataTables|\Illuminate\Http\JsonResponse.
     */
    public function datatable(Request $request)
    {
        if ($request->ajax()) {
            //settings
            $role = Auth()->user()->role;

            //moderators/admins
            if ($role >= '4') {
                $branches = Branches::orderByDesc('created_at');
            }
            return DataTables::of($branches)
                ->addIndexColumn()
                ->addColumn('action', function (Branches $branches) {
                    $actionBtn = '-';
                    //settings
                    $role = Auth()->user()->role;
                    $client = Auth()->user()->id;
                    $branch = Auth()->user()->branch;
                    //user role settings
                    $role = Auth()->user()->role;
                    
                    if ($role  >= 4) {
                            $url = route("dashboard.branch.edit", ['id' => $branches->id]);
                            $url_delete = route("dashboard.branch.delete", ['id' => $branches->id]);
                            $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                           $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                    }
                    
                    return $actionBtn;
                })
                
                ->editColumn('country', function (Branches $branches) {
                    $country = get_dataBy_id($branches->city, 'cities', 'name') . "-" .get_dataBy_id($branches->state, 'states', 'name') .", ";
                    $country .= country_name($branches->country);
                    
                    return $country;
                })
                ->editColumn('status', function (Branches $branches) {
                    $status_name =  get_status('', $branches->status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($branches->status) . " font-12'>{$status_name }</span></div>";
                    return $status;
                })
                
                ->rawColumns(['status', 'action'])
                ->make(true);
        }
    }
    
     /**
     * Store newly created resources in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse.
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
            'address'  => 'required|max:250',
            'city' => 'required|max:100',
            'state' => 'required|max:50',
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
            $create = Branches::create([
                'name'  => $request->name,
                'address'  => $request->address,
                'city' => $request->city,
                'state' => $request->state,
                'country'  => $request->country,
                'phone' => $request->phone,
                'email' => $request->email,
                'status' => $request->status
            ]);
            if ($create) {
                DB::commit();
                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Created'),
                    'redirect_url' => route('dashboard.branches'),
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
    public function update(Request $request, $id)
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
        $model = Branches::where('id', $id)->get();

        if ($model) {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name'  => 'required|max:200',
                'city' => 'required|max:100|',
                'state' => 'required|max:30',
                'country'  => 'required',
                'status'  => 'integer',
            ]);
            if ($validate->fails()) {
                // return redirect(route('dashboard.branch.edit', ['id' => $id]))
                //     ->withErrors($validate)
                //     ->withInput();
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }

            try {
                DB::beginTransaction();
                $update = Branches::where('id', $id)->update([
                    'name'  => $request->name,
                    'address'  => $request->address,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country'  => $request->country,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'status' => $request->status
                ]);

                if ($update) {
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
     * @param mixed $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
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
        if ($request->confirm == '') {
            $model = Branches::where('id', $id)->first();
            $data['page_title'] = __('messages.Branch'). ' >> ' . __('messages.Delete') . ' >> ' . $model->name;
            if ($model) {
                return view(get_theme_dir('branches/delete', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                    'model' => $model
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Request_Failed')
                ]);
            }
            
        }

        if ($request->confirm == 1) {
            
            $delete = Branches::where('id', $id)->delete();
            if($delete) {
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route("dashboard.branches"));
            }
            else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.There_Was_Problem')
                ]);
            }
        } 

    }
   

    /**
     * Redirect to a specified resource in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function add_link(Request $request)
    {
        $state = urldecode($request->state);
        $country = urldecode($request->country);
         
        //populate fields
        $area = get_name($country, 'countries');
        if ($area) {
            Session::flash('state', $state);
            Session::flash('country', $country);
        }
        
        return redirect(route("dashboard.branch.add"));
    }

    
}
