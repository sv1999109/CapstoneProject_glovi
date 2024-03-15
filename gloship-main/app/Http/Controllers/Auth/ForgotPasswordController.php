<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;

class ForgotPasswordController extends Controller
{
    /**
     * Show the form to reset password.
     *
    * @param null
     * @return  \Illuminate\Contracts\Support\Renderable.
     */
    public function showForgetPasswordForm()
    {
        $data['page_title'] = __('messages.Reset_Password');

        return view('auth.password_reset')->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Store newly created resources in storage.
     *
     * @param Request $request
     * @return  \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse..
     */
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $token = Str::random(64);

        DB::table('password_resets')->insert([
            'email' => $request->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);

        // send reset password link
        $url = route('reset.password.get', $token); 
        if (get_config('email_notification') == 'enabled') {
            Mail::mailer(get_config('default_mailer'))->send('email.password_reset', ['url' => $url], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject(__('messages.Email_Password_Reset_Subject'));
            });
          
        }
       
        return back()->with('message', __('messages.We_Emailed_Reset_Link'));
    }

    /**
     * Show the form to reset password link.
     *
     * @param mixed $token
     * @return  \Illuminate\Contracts\Support\Renderable.
     */
    public function showResetPasswordForm($token = Null)
    {
        $data['page_title'] = __('messages.New_Password');

        return view('auth.password_new')->with([
            'page_title' => $data['page_title'],
            'token' => $token
        ]);
    }

    /**
     * Update the specified resource in the storage.
     *
     * @param  Request $request
     * @return \Illuminate\Http\JsonResponse|\Illuminate\Http\RedirectResponse..
     */
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
            'password' => 'required|string|min:8|confirmed',
            'password_confirmation' => 'required'
        ]);

        $updatePassword = DB::table('password_resets')
            // ->whereBetween('created_at', [Carbon::now()->startOfDay(), Carbon::now()->subMinute(30)])
            ->where([
                'email' => $request->email,
                'token' => $request->token
            ])
            ->first();

        if (!$updatePassword) {
            return back()->withInput()->withErrors(__('messages.Invalid_Token'));
        }

        $user = User::where('email', $request->email)
            ->update(['password' => Hash::make($request->password)]);

        DB::table('password_resets')->where(['email' => $request->email])->delete();

        return redirect('/login')->with('message', __('messages.Password_Updated'));
    }
}
