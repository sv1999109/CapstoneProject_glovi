<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use App\Models\Languages;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class LanguageController extends Controller

{

    /**
     * Display a listig of the resource.
     *
     * @param Request $request
     * @return Renderable.
     */
    public function show(Request $request)
    {
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = trans_choice('messages.Language', 2);
        $languages = Languages::all();
        return view(get_theme_dir('settings/language', 'dashboard'))->with([
            'page_title' => $data['page_title'],
            'languages' => $languages
        ]);
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
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        //validate input fields
        $validate = Validator::make($request->all(), [
            'name'  => 'required|max:30',
            'code' => 'alpha|unique:languages|required|max:3|min:2',
            'native' => 'required|max:30|min:4',
            'regional'  => 'nullable',
            'flag_code'  => 'nullable|max:3|min:2',
        ]);
        //input has error(s)
        if ($validate->fails()) {

            Session::flash('modal_open', $request->modal);
            return redirect(url()->previous())->withErrors([
                'errors' => $validate->errors(),
            ]);
        }

        //no error insert into db
        try {
            DB::beginTransaction();
            $create = Languages::create([
                'name'  => $request->name,
                'code' => $request->code,
                'native' => $request->native,
                'regional'  => $request->regional,
                'flag_code'  => $request->flag_code,
                'status' => $request->status
            ]);
            if ($create) {
                DB::commit();

                Session::flash('form_response', __('messages.Created'));
                Session::flash('form_response_status', 'success');
                return redirect(url()->previous());
            } else {
                DB::rollback();
                DB::rollback();
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.There_Was_Problem'),
                ]);
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
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function update(Request $request, $id)
    {
        ;
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $model = Languages::where('id', $id)->get();

        if ($model) {
            //validate input fields
            $validate = Validator::make($request->all(), [
                'name'  => 'required|max:30',
                'code' => 'alpha|required|max:3|min:2',
                'native' => 'required|max:30|min:4',
                'regional'  => 'nullable',
                'flag_code'  => 'nullable|max:3|min:2',
                //'status' => 'required|integer'
            ]);
            if ($validate->fails()) {
                Session::flash('modal_open', $request->modal);
                return redirect(url()->previous())->withErrors([
                    'errors' => $validate->errors(),
                ]);
            }

            //check if language is default
            if ($request->code == get_config('set_locale') && $request->status == 2) {
                //break if status is deactivate
                Session::flash('modal_open', $request->modal);
                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Language_Deactivate_Error'),
                ]);
            }
            try {
                DB::beginTransaction();
                $update = Languages::where('id', $id)->update([
                    'name'  => $request->name,
                    'code' => $request->code,
                    'native' => $request->native,
                    'regional'  => $request->regional,
                    'flag_code'  => $request->flag_code,
                    'status' => $request->status
                ]);

                if ($update) {
                    DB::commit();
                    Session::flash('form_response', __('messages.Saved'));
                    Session::flash('form_response_status', 'success');
                    return redirect(url()->previous());
                } else {

                    DB::rollback();
                    return redirect(url()->previous())->withErrors([
                        'errors' => __('messages.There_Was_Problem'),
                    ]);
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
     * @return  \Illuminate\Http\JsonResponse.
     */
    public function setlocale(Request $request)
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
        $model = Languages::where('code', $request->code)->get();

        if ($model) {

            //update locale
            $update = DB::table('site_settings')->where('site_key', 'set_locale')->update([
                'value' => $request->code
            ]);
            //reset old default locale
            Languages::where('default_locale', 1)->update([
                'default_locale' => 0
            ]);
            //set new default locale
            Languages::where('code', $request->code)->update([
                'default_locale' => 1
            ]);
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

    /**
     * Remove a specified resource from the storage.
     *
     * @param int $id, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function delete(Languages $id, Request $request)
    {
        ;
        //Unauthorized access - only for admins/moderators
        if (!$request->user()->can('do_moderator')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        if ($id) {

            //check if language is default
            if ($id->code == get_config('set_locale')) {

                //break if trying to delete default language

                return redirect(url()->previous())->withErrors([
                    'errors' => __('messages.Language_Default_Error')
                ]);
                //exit;
            }
            $id->delete();


            Session::flash('form_response', __('messages.Deleted_Success'));
            return redirect(route("dashboard.settings.languages"));
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.There_Was_Problem')
            ]);
        }
    }
}
