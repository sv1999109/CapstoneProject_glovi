<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Settings;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class SettingsController extends Controller
{
    /**
     * Show specified the resource.
     *
     * @param $type, Request $request
     * @return \Illuminate\Contracts\Support\Renderable.
     */
    public function index($type, Request $request)
    {
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        if ($type == 'system') {
            $data['page_title'] = __('messages.System_Info');
            return view(get_theme_dir('settings/info', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'type' => __($type),
            ]);
        } 
        elseif ($type == 'update') {
            $data['page_title'] = __('messages.Update_System');
            return view(get_theme_dir('settings/update', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'type' => __($type),
            ]);
        } else {
            $data['page_title'] = trans_choice('messages.Setting', 2);
            return view(get_theme_dir('settings/general', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'type' => __($type),
            ]);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update(Request $request)
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

        //clear cache data
        $clear = new \Symfony\Component\Console\Output\BufferedOutput();
        \Illuminate\Support\Facades\Artisan::call('optimize:clear', [], $clear);

        //validate input fields
        $validate = $request->validate([
            'site_name' => 'array',
            'site_tagline' => 'required',
            'site_description' => 'nullable',
            'site_announcement' => 'nullable',
            'site_copyright' => 'nullable',
            'site_email_support' => 'nullable',
            'site_phone' => 'nullable',
            'site_head_office' => 'nullable',
            'site_live_chat_embed' => 'nullable',
            'set_locale' => 'nullable',
            'telegram_link' => 'nullable',
            'instagram_link' => 'nullable',
            'facebook_link' => 'nullable',
            'twitter_link' => 'nullable',
            'youtube_link' => 'nullable',
            'whatsapp_link' => 'nullable',
        ]);

        //default for unchecked/disabled fields
        if ($request->page == 'general') {
            if ($request->site_notification == '') {
                Settings::where('site_key', 'site_notification')->update(['value' => 'disable']);
            }
            if ($request->sms_notification == '') {
                Settings::where('site_key', 'sms_notification')->update(['value' => 'disable']);
            }
            if ($request->email_notification == '') {
                Settings::where('site_key', 'email_notification')->update(['value' => 'disable']);
            }
            if ($request->invoice_notification == '') {
                Settings::where('site_key', 'invoice_notification')->update(['value' => 'disable']);
            }
            if ($request->shipment_notification == '') {
                Settings::where('site_key', 'shipment_notification')->update(['value' => 'disable']);
            }
            if ($request->account_notification == '') {
                Settings::where('site_key', 'account_notification')->update(['value' => 'disable']);
            }
            //pass response
            $resp = [
                'result' => 'success',
                'messages' => __('messages.Saved'),
            ];
        }

        foreach ($request->all() as $key => $data) {
            if ($key == 'site_name' || $key == 'site_tagline' || $key == 'site_description' || $key == 'site_announcement' || $key == 'site_copyright') {
                $fields = [
                    'value' => json_encode($request[$key]),
                ];

                Settings::where('site_key', $key)->update($fields);
            } else {

                $fields = [
                    'value' => $request[$key],
                ];
                Settings::where('site_key', $key)->update($fields);
            }
        }

        //pass response
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
    public function update_system(Request $request)
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
        if (!empty($request->file('update_file'))) {
            $validate = Validator::make($request->all(), [
                'update_file' => 'required|file|mimes:zip|max:30000',
            ]);
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }

            $file = $request->file('update_file');
            $zip = new ZipArchive();
            $status = $zip->open($file->getRealPath());
            if ($status !== true) {
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.Invalid_Theme_Format'),
                ];
                return response()->json($resp);
            }

            //extract update files
            $destinationPath = base_path('/');
            
            if ($zip->locateName('updates/database.sql')) {
                 //import  db file
                 $database = ('updates/database.sql');
                 
            }
            $zip->extractTo($destinationPath);
            $zip->close();
            if (isset( $database )) {
                DB::unprepared(file_get_contents($database));
            }

            $resp = [
                'result' => 'success',
                'messages' => __('messages.Updated'),
                'redirect_url' => route('dashboard.settings.themes')
            ];
            return response()->json($resp);
        } else {
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.Fill_Required_Field_First'),
            ];
            return response()->json($resp);
        }
    }

    /**
     * Show the specified resource.
     *
     * @param Request $request
     * @return \Illuminate\Contracts\Support\Renderable.
     */
    public function payment_method(Request $request)
    {
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = __('messages.Payment_Method');
        return view(get_theme_dir('settings/payment', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function update_payment_method($id, Request $request)
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
        //disabled method
        if (empty($request->status)) {
            DB::table('payment_methods')
                ->where('id', $id)
                ->update([
                    'status' => 0,
                ]);
            $resp = [
                'result' => 'success',
                'messages' => __('messages.Saved'),
            ];
            return response()->json($resp);
        }
        //translation instruction
        $request->merge([
            'instruction' => json_encode($request->instruction),
        ]);

        //For Paypal
        if ($request->type == 'paypal') {
            //Validate inputs
            if ($request->status == 1) {
                $validate = Validator::make($request->all(), [
                    'Live_Client_Id' => 'required',
                    'Live_Client_Secret' => 'required',
                    'currency' => 'required',
                ]);
                if ($validate->fails()) {
                    $resp = [
                        'result' => 'errors',
                        'messages' => $validate->errors(),
                    ];
                    return response()->json($resp);
                }
            }

            $buildquery = [
                'Live_Client_Id' => $request->Live_Client_Id,
                'Live_Client_Secret' => $request->Live_Client_Secret,
            ];
            $fields = [
                'fields' => json_encode($buildquery),
                'instruction' => $request->instruction,
                'currency' => $request->currency,
                'test_mode' => $request->test_mode,
                'status' => $request->status,
            ];
        }
        //For Stripe
        elseif ($request->type == 'stripe') {
            //Validate inputs
            if ($request->status == 1) {
                $validate = Validator::make($request->all(), [
                    'Public_Key' => 'required',
                    'Secret_Key' => 'required',
                    'currency' => 'required',
                    'test_mode' => 'required',
                ]);
                if ($validate->fails()) {
                    $resp = [
                        'result' => 'errors',
                        'messages' => $validate->errors(),
                    ];
                    return response()->json($resp);
                }
            }

            $buildquery = [
                'Public_Key' => $request->Public_Key,
                'Secret_Key' => $request->Secret_Key,
            ];
            $fields = [
                'fields' => json_encode($buildquery),
                'instruction' => $request->instruction,
                'currency' => $request->currency,
                'test_mode' => $request->test_mode,
                'status' => $request->status,
            ];
        }

        //For Bank Transfer
        elseif ($request->type == 'bank_transfer') {
            //Validate inputs
            if ($request->status == 1) {
                $validate = Validator::make($request->all(), [
                    'Bank_Account_Details' => 'required',
                    'currency' => 'required',
                ]);
                if ($validate->fails()) {
                    $resp = [
                        'result' => 'errors',
                        'messages' => $validate->errors(),
                    ];
                    return response()->json($resp);
                }
            }

            $buildquery = [
                'Bank_Account_Details' => $request->Bank_Account_Details,
            ];
            $fields = [
                'fields' => json_encode($buildquery),
                'instruction' => $request->instruction,
                'currency' => $request->currency,
                'test_mode' => $request->test_mode,
                'status' => $request->status,
            ];
        }
        //For Others
        else {

            $buildquery = [];
            $fields = [
                'fields' => json_encode($buildquery),
                'instruction' => $request->instruction,
                'currency' => $request->currency,
                'status' => $request->status,
            ];
        }

        //update
        if (isset($fields)) {
            $update = DB::table('payment_methods')
                ->where('id', $id)
                ->update($fields);
            if ($update) {
                //pass response
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
        }
    }
}
