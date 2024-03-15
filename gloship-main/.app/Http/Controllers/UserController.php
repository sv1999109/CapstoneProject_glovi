<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use App\Models\Messages;
use App\Models\User;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use App\Models\Branches;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use Dotunj\LaraTwilio\Facades\LaraTwilio;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * Display a listig of the resource.
     *
     * @param mixed $role
     * @return Renderable.
     */
    public function list($role)
    {
        if (Auth()->user()->role < 3) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
        if ($role == 5) {
            $data['page_title'] = trans_choice('messages.Administrator', 2);
        }
        if ($role == 4) {
            $data['page_title'] = trans_choice('messages.Moderator', 2);
        }
        if ($role == 3) {
            $data['page_title'] = trans_choice('messages.Staff', 2);
        }
        if ($role == 2) {
            $data['page_title'] = trans_choice('messages.Delivery_Agent', 2);
        }
        if ($role == 1) {
            $data['page_title'] = trans_choice('messages.Customer', 2);
        }

        return view(get_theme_dir('users/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'user_type' => $role,
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param null
     * @return  Renderable.
     */
    public function add()
    {
        if (Auth()->user()->role < 3) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
        $data['page_title'] = __('messages.Add_User');
        return view(get_theme_dir('users/create', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Display the specified  resource.
     *
     * @param $request
     * @return Renderable.
     */
    public function view($request)
    {
        $model = User::where('id', $request)->first();
        if ($model) {
            if (Auth()->user()->role == 1 && Auth()->user()->id != $model->id) {
                $model = User::where('id', Auth()->user()->id)->first();
            }
            $data['page_title'] = $model->firstname . ' ' . $model->lastname;
            return view(get_theme_dir('users.view', 'dashboard'))->with([
                'user' => $model,
                'page_title' => $data['page_title'],
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
        if (Auth()->user()->role < 3 && Auth()->user()->id != $id) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
        $data['page_title'] = __('messages.Edit') . ' ' . trans_choice('messages.User', 1);
        $user = User::where('id', $id)->first();
        if ($user) {
            return view(get_theme_dir('users.edit', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'user' => $user,
                'id' => $id,
            ]);
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    /**
     * Display DataTable of the specified  resource.
     *
     * @param $type, int $user_id, Request $request
     * @return DataTables.
     */
    public function datatable($usertype, Request $request)
    {
        if ($request->ajax()) {
            //settings
            $role = Auth()->user()->role;
            $client = Auth()->user()->id;
            $branch = Auth()->user()->branch;
            $user_type = $usertype;
            $users = User::where('role', $user_type)->orderByDesc('created_at');
            return DataTables::of($users)
                ->addIndexColumn()
                ->addColumn('action', function (User $user) {
                    $actionBtn = '-';
                    //settings
                    $role = Auth()->user()->role;
                    if ($role >= 3) {
                        $url = route('dashboard.users.edit', ['id' => $user->id]);
                        $url_view = route('dashboard.users.view', ['id' => $user->id]);
                        $url_delete = route('dashboard.users.delete', ['id' => $user->id]);
                        $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                            href='{$url_view}'><i class='fa fa-eye'></i> </a> . <a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url}'><i class='fa fa-edit'></i> </a> <a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> </a>";
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

                ->editColumn('avatar', function (User $user) {
                    if ($user->avatar) {
                        $avatar = '<div class="avatar  avatar-xlx me-3 bg-rgba-primary m-0 me-50"> <img src="' . asset($user->avatar) . '" class="avatar-lg rounded-circle p-1 img-thumbnail" srcset=""></div>';
                    } else {
                        $avatar_char1 = substr($user->firstname, 0, 1);
                        $avatar = '<span class="avatar-sm">
                        <span class="avatar-title bg-light rounded text-body fs-4">
                            <i class="bi bi-person"></i>
                        </span>
                    </span>';
                    }

                    return $avatar;
                })

                ->editColumn('status', function (User $user) {
                    $status_name = get_status('users', $user->status);
                    $status = "<div class='badges'><span class='badge bg-" . get_status_color($user->status) . " font-12'>{$status_name}</span></div>";
                    return $status;
                })
                ->editColumn('role', function (User $user) {
                    $role = $user->role;
                    if ($role == 5) {
                        $user_role = trans_choice('messages.Administrator', 1);
                    }
                    if ($role == 4) {
                        $user_role = trans_choice('messages.Moderator', 1);
                    }
                    if ($role == 3) {
                        $user_role = trans_choice('messages.Staff', 1);
                    }
                    if ($role == 2) {
                        $user_role = trans_choice('messages.Delivery_Agent', 1);
                    }
                    if ($role == 1) {
                        $user_role = trans_choice('messages.Customer', 1);
                    }

                    return $user_role;
                })
                ->rawColumns(['id', 'avatar', 'firstname', 'status', 'action'])
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
        ;
        if ($request->role > Auth()->user()->role) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Request_Failed'),
            ];
            return response()->json($resp);
        }

        //validate input fields
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|alpha_dash|min:3|max:15|unique:users,username',
            'phone' => 'required',
            'firstname' => 'required|string|min:2|max:40',
            'lastname' => 'required|string|min:2|max:40',
            'password' => 'required|min:8',
            'role' => 'required',
            'country' => 'exists:App\Models\Countries,id',
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
            $timezone = DB::table('timezones')
                ->where('country_id', $request->country)
                ->value('name');
            $currency = \App\Models\Currency::where('country_id', $request->country)->value('code');
            
            $password = $request->password;
            $create = User::create([
                'username' => $request->username,
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                'phone' => $request->phone,
                'email' => $request->email,
                'password' => $password,
                'branch' => $request->branch,
                'country' => $request->country,
                'currency' => $currency,
                'timezone' => $timezone,
                'role' => $request->role,
            ]);
            if ($create) {
                DB::commit();

                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                $resp = [
                    'result' => 'success',
                    'messages' => __('messages.Created'),
                    'redirect_url' => route('dashboard.users.view', ['id' => $create->id]),
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
     * @param int $id, $type, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update($id, $type, Request $request)
    {
       
        //Unauthorized access - only admins/moderators can update other users
        if (Auth()->user()->role < 3 && Auth()->user()->id != $id) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Request_Failed'),
            ];
            return response()->json($resp);
        }
        
        $model = DB::table('users')
            ->where('id', $id)
            ->first();
        if ($model) {
            if ($model->username  = 'agent' || $model->username  = 'customer'  || $model->username  = 'admin'  || $model->username  = 'staff' || $model->username  = 'staff2' || $model->username  = 'moderator' ) {
                ;
            }
            if ($type == 'details') {

                //validate input fields
                if (Auth()->user()->role > 3) {
                    $validate = Validator::make($request->all(), [
                        'email' => 'required|email',
                        'username' => 'required|alpha_dash|min:3|max:15',
                        'phone' => 'required',
                        'firstname' => 'required|string|min:2|max:40',
                        'lastname' => 'required|string|min:2|max:40',
                        'status' => 'required',
                        'country' => 'exists:App\Models\Countries,id',
                        'timezone' => 'required',
                    ]);

                    //validate existing data
                    //username change
                    if ($model->username != $request->username) {
                        if (User::where('username', $request->username)->count() > 0) {
                            $resp = [
                                'result' => 'failed',
                                'messages' => __('messages.Username_Already_Exist'),
                            ];
                            return response()->json($resp);
                        }
                    }
                    //email change
                    if ($model->email != $request->email) {
                        if (User::where('email', $request->email)->count() > 0) {
                            $resp = [
                                'result' => 'failed',
                                'messages' => __('messages.Email_Already_Exist'),
                            ];
                            return response()->json($resp);
                        }
                    }
                    $status = $request->status;
                    if ($model->role > Auth()->user()->role) {
                        $resp = [
                            'result' => 'failed',
                            'messages' => __('messages.No_Permission'),
                        ];
                        return response()->json($resp);
                    }
                    //prepare data
                    $update_user = [
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'phone' => $request->phone,
                        'timezone' => $request->timezone,
                        'language' => $request->language,
                        'branch' => $request->branch,
                        'status' => $status,
                        'username' => $request->username,
                        'email' => $request->email,
                        'country' => $request->country,
                    ];
                } else {
                    $validate = Validator::make($request->all(), [
                        'phone' => 'required',
                        'firstname' => 'required|string|min:2|max:40',
                        'lastname' => 'required|string|min:2|max:40',
                        'timezone' => 'required',
                        'language' => 'nullable',
                    ]);

                    //prepare data
                    $update_user = [
                        'firstname' => $request->firstname,
                        'lastname' => $request->lastname,
                        'phone' => $request->phone,
                        'timezone' => $request->timezone,
                        'language' => $request->language,
                    ];
                }

                if ($validate->fails()) {
                    $resp = [
                        'result' => 'errors',
                        'messages' => $validate->errors(),
                    ];
                    return response()->json($resp);
                }

                try {
                    DB::beginTransaction();

                    $update = User::where('id', $id)->update($update_user);

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
                            'messages' => __('messages.Wrong_Old_Password'),
                        ];
                        return response()->json($resp);
                    }
                } catch (\Throwable $th) {
                    DB::rollback();
                    throw $th;
                }
            }

            if ($type == 'password') {
                if (Auth()->user()->role > 3) {
                    //validate input fields
                    $validate = Validator::make($request->all(), [
                        'password' => 'bail|required|min:8',
                        'password_confirmation' => 'bail|required|same:password',
                    ]);
                } else {
                    //validate input fields
                    $validate = Validator::make($request->all(), [
                        'old_password' => 'bail|required',
                        'password' => 'bail|required|min:8',
                        'password_confirmation' => 'bail|required|same:password',
                    ]);
                }

                if ($validate->fails()) {
                    $resp = [
                        'result' => 'errors',
                        'messages' => $validate->errors(),
                    ];
                    return response()->json($resp);
                }

                $password = $request->password;
                $old_password = $request->old_password;

                if (!Hash::check($old_password, Auth()->user()->password)) {
                    // return redirect(url('dashboard.users.edit', ['id' => $id]))
                    // ->withErrors([
                    //     'errors' => __('messages.Wrong_Old_Password')
                    // ]);
                    $resp = [
                        'result' => 'failed',
                        'messages' => __('messages.Wrong_Old_Password'),
                    ];
                    return response()->json($resp);
                }

                try {
                    DB::beginTransaction();
                    $update = User::where('id', $id)->update([
                        'password' => Hash::make($password),
                    ]);

                    if ($update) {
                        DB::commit();
                        $resp = [
                            'result' => 'success',
                            'messages' => __('messages.Saved'),
                        ];
                        return response()->json($resp);
                    } else {
                        
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

            if ($type == 'avatar') {
                if (!empty($request->file('avatar'))) {
                    
                    $validate = Validator::make($request->all(), [
                        'avatar' => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2000',
                    ]);
                    if ($validate->fails()) {
                        $resp = [
                            'result' => 'errors',
                            'messages' => $validate->errors(),
                        ];
                        return response()->json($resp);
                    }

                    $file = $request->file('avatar');
                    $destinationPath = 'uploads/avatar/';
                    $new_name = "user-{$id}" . '.' . $file->getClientOriginalExtension();
                    //Move Uploaded File
                    if ($file->move($destinationPath, $new_name)) {
                        $avatar = $destinationPath . $new_name;
                        $update = User::where('id', $id)->update([
                            'avatar' => $avatar,
                        ]);

                        if ($update) {
                            $resp = [
                                'result' => 'success',
                                'messages' => __('messages.Saved'),
                                'avatar_url' => asset($avatar),
                            ];
                        } else {
                            $resp = [
                                'result' => 'failed',
                                'messages' => __('messages.There_Was_Problem'),
                            ];
                        }

                        return response()->json($resp);
                    } else {
                        $resp = [
                            'result' => 'failed',
                            'messages' => __('messages.There_Was_Problem'),
                        ];
                        return response()->json($resp);
                    }
                }
            }

            if ($type == 'verify') {
                $user = User::where('id', $id)->first();

                if ($request->send_code == 1) {
                    $token = Str::random(32);
                    $update = User::where('id', $id)->update([
                        'token' => $token
                    ]);
                    $email = $user->email;

                    // send link
                    if (get_config('email_notification') == 'enabled') {
                        $url = route('user.verify.link', [
                            'userid' => $user->id,
                            'token' => $token
                        ]);
                        Mail::mailer(get_config('default_mailer'))->send('email.email_verification', ['url' => $url], function ($message) use ($email) {
                            $message->to($email);
                            $message->subject(__('messages.Email_Verify_Subject'));
                        });
                    }
                    $resp = [
                        'result' => 'success',
                        'messages' => __('messages.We_Emailed_Verification_Link')
                    ];
                    return response()->json($resp);
                }

                if ($request->send_code == 2) {
                    $code = rand(100000, 999999);
                    $update = User::where('id', $id)->update([
                        'token' => $code
                    ]);
                    $phone = $user->phone;
                    $message = __('message.Verification_Code_Is') . ': ' . $code;
                    // send code
                    if (get_config('sms_notification') == 'enabled') {
                        LaraTwilio::notify($phone, $message);
                    }
                    $resp = [
                        'result' => 'success',
                        'messages' => __('messages.Saved'),
                    ];
                    return response()->json($resp);
                }

                $validate = Validator::make($request->all(), [
                    'code' => 'required',
                ]);
                if ($validate->fails()) {
                    $resp = [
                        'result' => 'errors',
                        'messages' => $validate->errors(),
                    ];
                    return response()->json($resp);
                }

                if (User::where(['id' => $id, 'token' => $request->code])->first()) {
                    $update = User::where('id', $id)->update([
                        'phone_status' => 1
                    ]);

                    if ($update) {
                        $resp = [
                            'result' => 'success',
                            'messages' => __('messages.Verified'),
                        ];
                    } else {
                        $resp = [
                            'result' => 'failed',
                            'messages' => __('messages.There_Was_Problem'),
                        ];
                    }

                    return response()->json($resp);
                } else {
                    $resp = [
                        'result' => 'failed',
                        'messages' => __('messages.Invalid_Code'),
                    ];
                    return response()->json($resp);
                }
            }
        }
    }

    /**
     * Update the status of specified resource in storage.
     *
     * @param  int $id, mixed $value, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function notice($id, $value, Request $request)
    {
        //Unauthorized access - only admins/moderators can update other users
        if (Auth()->user()->role < 4 && Auth()->user()->id != $id) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.There_Was_Problem'),
            ];
            return response()->json($resp);
        }
        $user = User::find($id);
        $type = __($request->type);

        if ($type == 'email') {
            $user->email_notification = $value;
            $user->save();
        }
        if ($type == 'sms') {
            $user->sms_notification = $value;
            $user->save();
        }
        if ($type == 'site') {
            $user->site_notification = $value;
            $user->save();
        }
        if ($type == 'shipment') {
            $user->shipment_notification = $value;
            $user->save();
        }
        if ($type == 'invoice') {
            $user->invoice_notification = $value;
            $user->save();
        }

        return response()->json(['result' => '1']);
    }

    /**
     * Search the specified resource in storage.
     *
     * @param  Request $request
     * @return  \Illuminate\Http\Response.
     */
    public function search(Request $request)
    {
        //Unauthorized access - only for admins/moderators/staffs
        if (!$request->user()->can('do_staff')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        $data = [];

        if ($request->filled('q')) {
            $data = User::select('firstname', 'lastname', 'id', 'username')
                ->OrWhere(Db::raw("concat(firstname, ' ', lastname, ' ', username)"), 'LIKE', '%' . $request->q . '%')
                ->get();
        }

        return response()->json($data);
    }

    /**
     * Remove a specified resource from the storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete($id, Request $request)
    {
        ;
        //Unauthorized access - only admins/moderators can delete users
        if (Auth()->user()->role < 4) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        //trying to delete supirior
        if (User::where('id', $id)->value('role') > Auth()->user()->role) {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        //render view
        if ($request->confirm == '') {
            $model = User::where('id', $id)->first();
            $data['page_title'] = __('messages.Users') . ' >> ' . __('messages.Delete') . ' >> ' . $model->firstname . ' ' . $model->lastname . ', - ' . $model->username;
            if ($model) {
                return view(get_theme_dir('users/delete', 'dashboard'))->with([
                    'page_title' => $data['page_title'],
                    'model' => $model,
                ]);
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Request_Failed'),
                ]);
            }
        }

        //confirm delete
        if ($request->confirm == 1) {
            $delete = User::where('id', $id)->delete();
            if ($delete) {
                Session::flash('form_response', __('messages.Deleted_Success'));
                return redirect(route('dashboard.users', ['user_type' => 1]));
            } else {
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.There_Was_Problem'),
                ]);
            }
        }
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param null
     * @return  Renderable.
     */
    public function notification($id = null)
    {
        $data['page_title'] = trans_choice('messages.Notification', 2);
        return view(get_theme_dir('users/notice', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Display DataTable of the specified  resource.
     *
     * @param Request $request
     * @return DataTables.
     */
    public function notification_datatable(Request $request)
    {
        if ($request->ajax()) {
            $userid = Auth()->user()->id;
            //query
            $notification = Messages::where('userid', $userid)->orderByDesc('created_at');
            return DataTables::of($notification)
                ->addIndexColumn()
                ->addColumn('action', function (Messages $user) {
                    $actionBtn = '-';
                    //settings
                    $url_delete = route('dashboard.users.notification.delete', ['id' => $user->id]);
                    $url_delete_text = __('messages.Delete');
                    $actionBtn = "<a class='btn btn-sm btn-outline-primary m-1'
                           href='{$url_delete}'><i class='fa fa-trash'></i> {$url_delete_text}</a>";

                    return $actionBtn;
                })

                ->editColumn('id', function (Messages $notification) {
                    Messages::where('id', $notification->id)->update([
                        'status' => 1,
                    ]);
                })

                ->editColumn('subject', function (Messages $notification) {
                    $subject = '<b>' . get_content_locale($notification->subject) . '</b>';

                    if ($notification->url != '') {
                        $url = route('dashboard.users.notification.view', ['id' => $notification->id]);
                        $subject = "<a href='{$url}'>" . get_content_locale($notification->subject) . '</a> ';
                    }
                    if ($notification->message_type == 2 && $notification->reference_id != '') {
                        $url = route('dashboard.shipments.view', ['id' => $notification->reference_id]);
                        $subject = "<a href='{$url}'>" . get_content_locale($notification->subject) . '</a> ';
                    }
                    if ($notification->message_type == 3 && $notification->reference_id != '') {
                        $url = route('dashboard.shipments.invoice.pay', ['id' => $notification->reference_id]);
                        $subject = "<a href='{$url}'>" . get_content_locale($notification->subject) . '</a> ';
                    }

                    return $subject;
                })

                ->editColumn('sender', function (Messages $notification) {
                    $user = User::where('id', $notification->sender)->first();
                    if ($user) {
                        $sender = $user->username;
                    } else {
                        $sender = $notification->sender;
                    }

                    return "<span class='text-blue'>$sender</span>";
                })

                ->editColumn('created_at', function (Messages $notification) {
                    $created_at = Carbon::parse($notification->created_at)->setTimezone(\Helpers::getUserTimeZone());
                    return $created_at->diffForHumans();
                })

                ->rawColumns(['id', 'subject', 'sender', 'action', 'created_at'])
                ->make(true);
        }
    }

    /**
     * Display the specified  resource.
     *
     * @param int $id
     * @return \Illuminate\Http\RedirectResponse.
     */
    public function notification_view($id)
    {
        $model = Messages::where('id', $id)->first();
        if ($model) {
            Messages::where('id', $model->id)->update([
                'status' => 1,
            ]);
            if ($model->url != '') {
                return redirect(url($model->url));
            } elseif ($model->message_type == 2 && $model->reference_id != '') {
                return redirect(route('dashboard.shipments.view', ['id' => $model->reference_id]));
            } elseif ($model->message_type == 3 && $model->reference_id != '') {
                return redirect(route('dashboard.shipments.invoice.pay', ['id' => $model->reference_id]));
            } else {
                return redirect(route('dashboard.users.notification'));
            }
        } else {
            //error not found
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.Request_Failed'),
            ]);
        }
    }

    /**
     * Remove a specified resource from the storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function notification_delete($id, Request $request)
    {
        //Unauthorized access
        if (Auth()->user()->role < 3 && Auth()->user()->id != \App\Models\User::where('id', Messages::where('id', $id)->value('userid'))->value('id')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        $delete = Messages::where('id', $id)->delete();
        if ($delete) {
            Session::flash('form_response', __('messages.Deleted_Success'));
            return redirect(route('dashboard.users.notification'));
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.There_Was_Problem'),
            ]);
        }
    }

    /**
     * Show a specified resource from the storage.
     *
     * @param null
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function notify()
    {
        $userid = Auth()->user()->id;
        $data = Messages::select('id', 'subject', 'url', 'created_at')
            ->whereRaw("message_type > 1 AND userid = '$userid' AND push = '0'")
            ->orderByDesc('created_at')
            ->get();
        foreach ($data as $key => $notice) {
            Messages::where('id', $notice->id)->update([
                'push' => 1,
            ]);
            $notices = '<div
            class="text-reset notification-item d-block dropdown-item position-relative unread-message">
            <div class="d-flex"> <div class="avatar-xs me-3 flex-shrink-0"><span
                        class="avatar-title bg-info-subtle text-info rounded-circle fs-lg">
                        <i class="bx bx-badge-check"></i></span> </div> <div class="flex-grow-1">';
            $notices .= '<a class="stretched-link" href="' . route('dashboard.users.notification.view', ['id' => $notice->id]) . '">';
           
            $notices .= ' <h6 class="mt-0 fs-md mb-2 lh-base">';
            $notices .= \Illuminate\Support\Str::limit(get_content_locale($notice->subject), 50, '...');
            $notices .= '</h6>';
            $notices .= '<p class="mb-0 fs-2xs fw-medium text-uppercase text-muted">
            <span><i class="mdi mdi-clock-outline"></i>';
            $notices .= \Carbon\Carbon::parse($notice->created_at)->diffForHumans();
            $notices .= '</span></p>';
           
            $notices .= '</a>';
            $notices .= '</div></div></div>';
            
        }
        if (isset($notices)) {
            return response()->json([
                'notices' => $notices,
                'notice_count' => DB::table('messages')
                    ->whereRaw("status = 0 AND userid = ' $userid'")
                    ->count(),
            ]);
        }
    }
}
