<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Item;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use ZipArchive;

class ThemeController extends Controller
{
    
    /**
     * Display a listig of the resource.
     *
     * @param mixed $Request $request
     * @return \Illuminate\Contracts\Support\Renderable.
     */
    public function list(Request $request)
    {
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = trans_choice('messages.Theme', 2);
        return view(get_theme_dir('settings/themes/list', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for creating a new resources.
     *
     * @param Request $request
     * @return  \Illuminate\Contracts\Support\Renderable.
     */
    public function add(Request $request)
    {
         
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] =  trans_choice('messages.Add', 1) . '/' .   trans_choice('messages.Update', 1) . ' ' .  trans_choice('messages.Theme', 1);
        return view(get_theme_dir('settings/themes/add', 'dashboard'))->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Show the form for editing a specified resource.
     *
     * @param  mixed $section, Request $request
     * @return Renderable.
     */
    public function theme_options($section = null, Request $request)
    {
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }
        $data['page_title'] = trans_choice('messages.Theme', 2);
        $theme_options = DB::table('themes')
            ->where('slug', get_config('site_theme'))
            ->value('theme_options');

        if ($theme_options) {
            return view(get_theme_dir('settings/themes/options', 'dashboard'))->with([
                'page_title' => $data['page_title'],
                'theme_options' => $theme_options,
                'section' => __($section),
            ]);
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
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            $resp = [
                'result' => 'failed',
                'messages' => __('messages.No_Permission'),
            ];
            return response()->json($resp);
        }
        if (!empty($request->file('theme_blade')) && !empty($request->file('theme_asset')) && !empty($request->file('theme_db'))) {
            $validate = Validator::make($request->all(), [
                'theme_blade' => 'required|file|mimes:zip|max:5000',
                'theme_asset' => 'required|file|mimes:zip|max:10000',
            ]);
            if ($validate->fails()) {
                $resp = [
                    'result' => 'errors',
                    'messages' => $validate->errors(),
                ];
                return response()->json($resp);
            }

            $theme_file = $request->file('theme_blade');
            $theme_asset = $request->file('theme_asset');
            $theme_db = $request->file('theme_db');
            //theme db validate
            if ($theme_db->getClientOriginalExtension() != 'sql') {
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.Invalid_Theme_Format'),
                ];
                return response()->json($resp);
            }

            $zip = new ZipArchive();
            $status = $zip->open($theme_file->getRealPath());
            if ($status !== true) {
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.Invalid_Theme_Format'),
                ];
                return response()->json($resp);
            }

            //extract theme blade files
            $themefile_destinationPath = ('resources/views/themes/');
            $zip->extractTo($themefile_destinationPath);
            $zip->close();

            //extract theme asset files
            $zip2 = new ZipArchive();
            $status2 = $zip2->open($theme_asset->getRealPath());
            if ($status2 !== true) {
                $resp = [
                    'result' => 'failed',
                    'messages' => __('messages.Invalid_Theme_Format'),
                ];
                return response()->json($resp);
            }
            $themeasset_destinationPath = ('assets/themes/');
            $zip2->extractTo($themeasset_destinationPath);
            $zip2->close();
            //import theme db file
            DB::unprepared(file_get_contents($theme_db));

            //clear cache data
            $clear = new \Symfony\Component\Console\Output\BufferedOutput();
            \Illuminate\Support\Facades\Artisan::call('optimize:clear', [], $clear);

            $resp = [
                'result' => 'success',
                'messages' => __('messages.Saved'),
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
     * Update the specified resource in storage.
     *
     * @param  mixed $section, Request $request
     * @return \Illuminate\Http\JsonResponse.
     */
    public function theme_option_update($section, Request $request)
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

        if ($request->display == '') {
            DB::table('theme_settings')
                ->where('config_key', $section)
                ->update(['value' => 'disable']);
        }
        foreach ($request->all() as $key => $data) {
            // if ($key == '_token' || $key == '_method') {
            // }
            // else
            if ($key == 'display') {

                $fields = [
                    'value' => 'enabled',
                ];

                DB::table('theme_settings')
                    ->where('config_key', $section)
                    ->update($fields);
            } else {
                // if (  DB::table('theme_settings')->where('config_key', $section)->count() == 0) {

                //     \App\Models\Tickets::create([
                //         'config_key' => $section,
                //         'theme' => get_config('site_theme'),
                //         'value' => 'enabled'
                //     ]);
                // }
                $content = $request[$key];
                if ($section == 'homepage') {
                    $content = json_encode($request[$key]);
                }

                if ($section == 'site_logo_main' || $section == 'site_logo_dashboard') {
                    if (!empty($request->file($key))) {
                        $validate = Validator::make($request->all(), [
                            $key => 'required|image|mimes:jpg,png,jpeg,gif,svg,webp|max:2000',
                        ]);
                        if ($validate->fails()) {
                            $resp = [
                                'result' => 'errors',
                                'messages' => $validate->errors(),
                            ];
                            return response()->json($resp);
                        }
                        $file = $request->file($key);

                        $destinationPath = 'assets/img/';
                        $new_name = "{$key}." . $file->getClientOriginalExtension();

                        //Move Uploaded File
                        if ($file->move($destinationPath, $new_name)) {
                            $content = $destinationPath . $new_name;
                        }
                    }
                }

                $fields = [
                    'contents' => $content,
                ];
                DB::table('theme_contents')
                    ->where('config_key', $key)
                    ->update($fields);
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
     * @param  mixed $section, Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse.
     */
    public function theme_activate($slug, Request $request)
    {
        ;
        //Unauthorized access - only for admins
        if (!$request->user()->can('do_admin')) {
            //access denied
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.No_Permission'),
            ]);
        }

        if (get_config('site_theme') == $slug) {
            Session::flash('form_response', __('messages.Saved'));
            Session::flash('form_response_status', 'success');
            return redirect(url()->previous());
        }

        $model = DB::table('themes')
            ->where('slug', $slug)
            ->get();

        if ($model) {
            //clear cache data
            $clear = new \Symfony\Component\Console\Output\BufferedOutput();
            \Illuminate\Support\Facades\Artisan::call('optimize:clear', [], $clear);
            //update site default theme
            DB::table('site_settings')
                ->where('site_key', 'site_theme')
                ->update([
                    'value' => $slug,
                ]);
            //reset old default theme
            DB::table('themes')
                ->where('status', 1)
                ->update([
                    'status' => 2,
                ]);
            //set new default theme
            DB::table('themes')
                ->where('slug', $slug)
                ->update([
                    'status' => 1,
                ]);
            DB::commit();
            Session::flash('form_response', __('messages.Activated'));
            Session::flash('form_response_status', 'success');
            return redirect(url()->previous());
        } else {
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.There_Was_Problem'),
            ]);
        }
    }
}
