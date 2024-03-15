<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Address;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Branches;
use App\Models\Cities;
use App\Models\States;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use App\Services\ShippoService;

class AddressController extends Controller

{

    /**
     * Display a listig of the resource.
     *
     * @param null
     * @return Renderable.
     */
    public function list()
    {
        $data['page_title'] = trans_choice('messages.Address', 2);
        return view(get_theme_dir('address/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param Request $request
     * @return  Renderable|\Illuminate\Http\RedirectResponse..
     */
    public function add(Request $request)
    {
        $data['page_title'] = __('messages.Add_Address');

        //add user filter
        if ($request->id) {

            if (Auth()->user()->role > 1) {
                //check if user exist
                $user = Address::where('id', $request->id)->first();
                if ($user) {
                    return view(get_theme_dir('shipment.create', 'dashboard'))->with([
                        'user' => $user,
                        'page_title' => $data['page_title'],
                    ]);
                }
                return view(get_theme_dir('address/create', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                ]);
            }
            return redirect(route('dashboard.address.add'));
        } else {
            return view(get_theme_dir('address/create', 'dashboard'))->with([
                'page_title' => $data['page_title'],
            ]);
        }
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param  Address $id
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function edit($id)
    {
        //Unauthorized access
        if (Auth()->user()->role < 3 && Auth()->user()->id != \App\Models\User::where('id', Address::where('id', $id)->value('owner_id'))->value('id')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission')
            ]);
        }
        $data['page_title'] = __('messages.Edit') . ' ' . $id;
        $address = Address::where('id', $id)->first();
        if ($address) {
            return view(get_theme_dir('address/edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'address' => $address,
                'id' => $address->id
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed')
            ]);
        }
    }

    /**
     * Display DataTable of the specified resource.
     *
     * @param  mixed $type, int $user_id, Request $request
     * @return DataTables.
     */
    public function datatable($type = null, $userid, Request $request)
    {
        if ($request->ajax()) {
            //settings
            $role = Auth()->user()->role;
            $client = Auth()->user()->id;
            $branch = Auth()->user()->branch;

            //moderators/admins
            if ($role >= '4') {
                $addresss = Address::orderByDesc('created_at');
                if ($type == 'user') {
                    $addresss = Address::where('owner_id', $userid)->orderByDesc('created_at');
                }
            }
            //staffs
            if ($role == '3') {
                $addresss = Address::whereRaw("created_by = '$client' OR owner_id = '$client'")->orderByDesc('created_at');
                if ($type == 'user') {
                    $addresss = Address::where('owner_id', $userid)->orderByDesc('created_at');
                }
            }
            //Delivery Agents
            if ($role == '2') {
                $addresss = Address::whereRaw("owner_id = '$client'")->orderByDesc('created_at');
            }
            //customers
            if ($role == '1') {
                $addresss = Address::whereRaw("owner_id = '$client'")->orderByDesc('created_at');
            }

            return DataTables::of($addresss)
                ->addIndexColumn()
                ->addColumn('action', function (Address $address) {
                    $actionBtn = '-';
                    //settings
                    $role = Auth()->user()->role;
                    $client = Auth()->user()->id;
                    $branch = Auth()->user()->branch;
                    if ($role  >= 4 || $client == $address->created_by || $client == $address->owner_id) {
                        $url = route("dashboard.address.edit", ['id' => $address->id]);
                        $url_delete = route("dashboard.address.delete", ['id' => $address->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a>";
                        $actionBtn .= "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
                    }

                    return $actionBtn;
                })
                ->editColumn('address_type', function (Address $address) {
                    if ($address->address_type == 1) {
                        $address_type = '<div class="badges"><span class="badge bg-danger font-12">' . __('messages.Sender') . '</span></div>';
                    }
                    if ($address->address_type == 2) {
                        $address_type = '<div class="badges"><span class="badge bg-success font-12">' . __('messages.Recipient') . '</span></div>';
                    }


                    return $address_type;
                })
                ->editColumn('address', function (Address $address) {
                    $addresses = "<b>{$address->firstname} {$address->lastname}</b><br>";
                    if ($address->area != '') {
                        $addresses .= "{$address->house_no}, ";
                    }
                    $addresses .= "{$address->address},<br>";
                    if ($address->area != '') {
                        $addresses .= get_name($address->area, 'areas') . " - ";
                    }
                    if ($address->city != '') {
                        $addresses .= get_name($address->city, 'cities') . ",<br>";
                    }

                    $addresses .= "" . get_name($address->state, 'states') . ", " . get_name($address->country, 'countries') . "<br>";
                    $addresses .= "{$address->phone}<br>{$address->email}";




                    return $addresses;
                })
                ->editColumn('created_at', function (Address $address) {
                    $created_at = $address->created_at;
                    return $created_at;
                })
                ->rawColumns(['address_type', 'address', 'created_at', 'action'])
                ->make(true);
        }
    }

    /**
     * Store newly created resources in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function create(Request $request, ShippoService $shippoService)
    {
        //validate input fields
        $validate = Validator::make($request->all(), [
            'address_type' => 'required|integer',
            'firstname'  => 'required|max:100',
            'lastname'  => 'required|max:100',
            'address'  => 'required|max:250',
            'area'  => 'nullable',
            'city' => 'nullable',
            'state' => 'required',
            'country'  => 'required',
            'postal'  => 'required',
            'phone'  => 'required',
            'email'  => 'email',
            'house_no' => 'required',
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
        //client
        if (Auth()->user()->role == 1) {
            $client = Auth()->user()->id;
        } else {
            $client = $request->client;
        }

        // validate address data
        // address data
        $state = States::where('id', $request->state)->value('name');
        $city = Cities::where('id', $request->city)->value('name');
        if ($city == '') {
            $city = $state;
        }
        $addressData = [
            'name' => "$request->firstname $request->lastname",
            'street1' => $request->address,
            'city' => $city,
            'state' => $state,
            'zip' => $request->postal,
            'country' => country_code($request->country),
            'phone' => $request->phone,
            'email' => $request->email,
            "validate" => true
        ];

        $addressDataReseult =  $shippoService->createAddress($addressData);
        if(!isset($addressDataReseult["is_complete"])){ 

            $resp = [
                'result' => 'failed',
                'messages' => __('messages.There_Was_Problem'),
            ];
            return response()->json($resp);
        }

        if ($addressDataReseult['is_complete'] !== true) {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Address_Not_Available'),
            ];
            return response()->json($resp);
        }

        $object_id = $addressDataReseult['object_id'];
        // $object_id = '';


        try {
            DB::beginTransaction();
            $create = Address::create([
                'address_type' => $request->address_type,
                'firstname'  => $request->firstname,
                'lastname'  => $request->lastname,
                'address'  => $request->address,
                'house_no'  => $request->house_no,
                'area' => $request->area,
                'city' => $request->city,
                'state' => $request->state,
                'country'  => $request->country,
                'phone' => $request->phone,
                'email' => $request->email,
                'postal' => $request->postal,
                'created_by' => Auth()->user()->id,
                'owner_id' => $client,
                'object_id' => $object_id
            ]);
            if ($create) {
                DB::commit();

                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');

                
                $address = '<div class="col-lg-4 col-sm-6 recipient_box">
                                <div class="form-check card-radio rounded-bottom-0">
                                    <input value="'.$create->id .'" id="shippingAddress'.$create->id .'" name="receiver_info"
                                        type="radio" class="form-check-input" checked="">
                                    <label class="form-check-label" for="shippingAddress'. $create->id .'">
                                        <span
                                            class="mb-3 fw-semibold d-block text-muted text-uppercase">'. trans_choice("messages.To", 1) .'</span>

                                        <span class="fs-md mb-2 d-block fw-medium">'. $create->firstname .' -
                                        '. $create->lastname .'</span>
                                        <span
                                            class="text-muted fw-normal text-wrap mb-1 d-block">'. $create->house_no .', '. $create->address .',
                                            '.get_name($create->city, 'cities') .',
                                            '. get_name($create->state, 'states') .' '. $create->postal .',
                                            '. country_code($create->country) .'</span>
                                        <span class="text-muted fw-normal d-block">'. trans_choice("messages.Phone", 1) .'
                                        '. $create->phone .'</span>
                                    </label>
                                </div>
                               
                            </div>';
                if ($request->address_type == '1') {
                    $address = '<option value="'. $create->id .'" selected>'. $create->firstname .' - '. $create->address .'</option>';
                }
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Created'),
                    'redirect_url' => route('dashboard.address'),
                    'address_data' => $address,
                    'address_type' => $create->address_type
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
     * @return  \Illuminate\Http\Response.
     */
    public function update(Request $request, $id, ShippoService $shippoService)
    {
        //Unauthorized access
        if (Auth()->user()->role < 3 && Auth()->user()->id != \App\Models\User::where('id', Address::where('id', $id)->value('owner_id'))->value('id')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }

        $model = Address::where('id', $id)->get();

        if ($model) {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'address_type' => 'required|integer',
                'firstname'  => 'required|max:100',
                'lastname'  => 'required|max:100',
                'address'  => 'required|max:250',
                'area'  => 'nullable',
                'city' => 'required|max:100',
                'state' => 'required|max:100',
                'country'  => 'required',
                'postal'  => 'required',
                'phone'  => 'required',
                'email'  => 'required|email'
            ]);
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }

            // validate address data
            // address data
            $addressData = [
                'name' => "$request->firstname $request->lastname",
                'street1' => $request->address,
                'city' => Cities::where('id', $request->city)->value('name'),
                'state' => States::where('id', $request->state)->value('name'),
                'zip' => $request->postal,
                'country' => country_code($request->country),
                'phone' => $request->phone,
                'email' => $request->email,
                "validate" => true
            ];

            $addressDataReseult =  $shippoService->createAddress($addressData);

            if(!isset($addressDataReseult["is_complete"])){ 

                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.There_Was_Problem'),
                ];
                return response()->json($resp);
            }
            if ($addressDataReseult['is_complete'] !== true) {
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.Address_Not_Available'),
                ];
                return response()->json($resp);
            }

            $object_id = $addressDataReseult['object_id'];

            try {
                DB::beginTransaction();
                $update = Address::where('id', $id)->update([
                    'address_type' => $request->address_type,
                    'firstname'  => $request->firstname,
                    'lastname'  => $request->lastname,
                    'address'  => $request->address,
                    'house_no'  => $request->house_no,
                    'area' => $request->area,
                    'city' => $request->city,
                    'state' => $request->state,
                    'country'  => $request->country,
                    'phone' => $request->phone,
                    'email' => $request->email,
                    'postal' => $request->postal,
                    'object_id' => $object_id
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
     * @param int $id
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete($id, Request $request)
    {

        //Unauthorized access
        if (Auth()->user()->role < 3 && Auth()->user()->id != \App\Models\User::where('id', Address::where('id', $id)->value('owner_id'))->value('id')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission')
            ]);
        }

        if ($request->confirm == '') {
            $model = Address::where('id', $id)->first();
            $data['page_title'] = trans_choice('messages.Address', 1) . ' >> ' . __('messages.Delete') . ' >> ' . $model->address;
            if ($model) {
                return view(get_theme_dir('address/delete', 'dashboard'))->with([
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

            $delete = Address::where('id', $id)->delete();
            if ($delete) {
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route('dashboard.address'));
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.There_Was_Problem')
                ]);
            }
        }
    }

    /**
     * Show a specified resource from the storage.
     *
     * @param int $id
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function getStates($id = 0)
    {

        // Fetch State by Countryid
        $model['data'] = DB::table('states')
            ->where('country_id', $id)
            ->get();


        if (DB::table('states')->where('country_id', $id)->get()->count() > 0) {
            return response()->json($model);
        } else {
            $emptymodel['data'] = [[
                'id' => '',
                'name' => __('messages.No_Record_Found')
            ]];
            return response()->json($emptymodel);
        }
    }

    /**
     * Show a specified resource from the storage.
     *
     * @param int $id
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function getCity($id = 0)
    {

        // Fetch City by State
        $model['data'] = DB::table('cities')
            ->where('state_id', $id)
            ->get();


        if (DB::table('cities')->where('state_id', $id)->get()->count() > 0) {
            return response()->json($model);
        } else {
            $emptymodel['data'] = [[
                'id' => '',
                'name' => __('messages.No_Record_Found')
            ]];
            return response()->json($emptymodel);
        }
    }

    /**
     * Show a specified resource from the storage.
     *
     * @param int $id
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function getArea($id = 0)
    {

        // Fetch Area by City
        $model['data'] = DB::table('areas')
            ->where('city_id', $id)
            ->get();
        if (DB::table('areas')->where('city_id', $id)->count() > 0) {
            return response()->json($model);
        } else {
            $emptymodel['data'] = [[
                'id' => '',
                'name' => __('messages.No_Record_Found')
            ]];
            return response()->json($emptymodel);
        }
    }
    public function getBranches($id = 0, Request $request)
    {
        if ($request->type == '') {
            // Fetch Branches
            $model['data'] = DB::table('branches')
                ->where('country', $id)
                ->orderBy('name')
                ->get();

            if (DB::table('branches')->where('country', $id)->count() > 0) {
                return response()->json($model);
            } else {
                $emptymodel['data'] = [[
                    'id' => '',
                    'name' => __('messages.No_Record_Found')
                ]];
                return response()->json($emptymodel);
            }
        } else {
            // Fetch Branches
            $branch = Address::where('id', $id)->first();
            $model['data'] = DB::table('branches')
                ->where('state', $branch->state)
                ->orderBy('name')
                ->get();

            if (DB::table('branches')->where('state', $branch->state)->count() > 0) {
                return response()->json($model);
            } else {
                $emptymodel['data'] = [[
                    'id' => '',
                    'name' => __('messages.No_Record_Found')
                ]];
                return response()->json($emptymodel);
            }
        }
    }

    /**
     * Show a specified resource from the storage.
     *
     * @param int $id
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function getAddress($type, $id = 0)
    {
        if ($type == 3) {
            $address_data = '';
            foreach (DB::table('addresses')
            ->whereRaw("address_type = '2' AND owner_id = '$id'")
            ->orderBy('firstname')
            ->get() as $create) {
                $address_data .= '<div class="col-lg-4 col-sm-6 recipient_box">
                                <div class="form-check card-radio rounded-bottom-0">
                                    <input value="'.$create->id .'" id="shippingAddress'.$create->id .'" name="receiver_info"
                                        type="radio" class="form-check-input" checked="">
                                    <label class="form-check-label" for="shippingAddress'. $create->id .'">
                                        <span
                                            class="mb-3 fw-semibold d-block text-muted text-uppercase">'. trans_choice("messages.To", 1) .'</span>

                                        <span class="fs-md mb-2 d-block fw-medium">'. $create->firstname .' -
                                        '. $create->lastname .'</span>
                                        <span
                                            class="text-muted fw-normal text-wrap mb-1 d-block">'. $create->address .',
                                            '.get_name($create->city, 'cities') .',
                                            '. get_name($create->state, 'states') .' '. $create->postal .',
                                            '. country_code($create->country) .'</span>
                                        <span class="text-muted fw-normal d-block">'. trans_choice("messages.Phone", 1) .'
                                        '. $create->phone .'</span>
                                    </label>
                                </div>
                               
                            </div>';
            }

            $resp = [
                'result' => 'success',
                'messages' => __('messages.Created'),
                'redirect_url' => route('dashboard.address'),
                'address_data' => $address_data,
                'address_type' => 2
            ];
            return response()->json($resp);
        }

        // Fetch Branches
        $model['data'] = DB::table('addresses')
            ->whereRaw("address_type = '$type' AND owner_id = '$id'")
            ->orderBy('firstname')
            ->get();

        if (DB::table('addresses')->where('owner_id', $id)->count() > 0) {
            return  response()->json($model);
        } else {
            $emptymodel['data'] = [[
                'id' => '0',
                'name' => __('messages.No_Record_Found')
            ]];
            return response()->json($emptymodel);
        }
    }
}
