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

class VerificationController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Email Verification Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling email verification for any
    | user that recently registered with the application. Emails may also
    | be re-sent if the user didn't receive the original email message.
    |
    */

    /**
     * Show the form to reset password.
     *
     * @param null
     * @return  \Illuminate\Contracts\Support\Renderable.
     */
    public function verify_page()
    {
        $data['page_title'] = __('messages.Verification');

        return view('auth.verify')->with([
            'page_title' => $data['page_title'],
        ]);
    }

    /**
     * Check verification link.
     *
     * @param mixed $userid, $token
     * @return   \Illuminate\Http\RedirectResponse.
     */
    public function verify($userid, $token)
    {

        $user = User::where([
            'id' => $userid,
            'token' => $token
        ])->first();

        if (!$user) {
            return redirect(route('user.verify'))->withErrors([
                __('messages.Invalid_Token')
            ]);
        }
        User::where('id', $userid)
            ->update(['email_status' => 1]);

        return redirect(route('user.verify'))->with([
            'message' => __('messages.Email_Verified'),
            'verified' => true
        ]);
    }


    /**
     * re-sent if the user didn't receive the original email message.
     *
     * @param mixed $type, Request $request
     * @return  \Illuminate\Http\RedirectResponse.
     */
    public function verify_resend(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users',
        ]);

        $user = User::where([
            'email' => $request->email,
            'email_status' =>  0
        ])->first();

        if (!$user) {
            return redirect(route('user.verify'))->withErrors([
                __('messages.There_Was_Problem')
            ]);
        }
        // check token
        $token = $user->token ? $user->token : Str::random(32);
        User::where('id', $user->id)
            ->update(['token' => $token ]);
        // send verification link
        $url = route('user.verify.link', [
            'userid' => $user->id,
            'token' => $token
        ]);
        if (get_config('email_notification') == 'enabled') {

            Mail::mailer(get_config('default_mailer'))->send('email.email_verification', ['url' => $url], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject(__('messages.Email_Verify_Subject'));
            });
        }
       
        return back()->with('message', __('messages.We_Emailed_Verification_Link'));
    }

}
