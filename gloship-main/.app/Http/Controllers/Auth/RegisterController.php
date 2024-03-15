<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Mail\Welcome;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Mcamara\LaravelLocalization\Facades\LaravelLocalization;

class RegisterController extends Controller
{
    /*
     * Display register page.
     * 
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        $data['page_title'] = __('messages.Register');
        return view('auth.register', $data);
    }

    /*
     * Handle account registration request
     * 
     * @param RegisterRequest $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        //validate input fields
        $validate = Validator::make($request->all(), [
            'email' => 'required|email|unique:users,email',
            'username' => 'required|alpha_dash|min:3|max:15|unique:users,username',
            'phone' => 'required',
            'firstname' => 'required|string|min:2|max:40',
            'lastname' => 'required|string|min:2|max:40',
            'password' => 'required|min:8',
            'password_confirmation' => 'required|same:password',
            'country' => 'exists:App\Models\Countries,id'
        ]);

        //input has error(s)
        if ($validate->fails()) {
            return redirect(url()->previous())
                ->withErrors($validate)
                ->withInput();
        }
        $timezone = DB::table('timezones')
            ->where('country_id', $request->country)
            ->value('name');
        $currency = \App\Models\Currency::where('country_id', $request->country)->value('code');
        $token = Str::random(64);
        $newuser = User::create([
            'username' => $request->username,
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'phone' => $request->phone,
            'email' => $request->email,
            'password' => $request->password,
            'branch' => $request->branch,
            'country' => $request->country,
            'currency' => $currency,
            'timezone' => $timezone,
            'language' => LaravelLocalization::getCurrentLocale(),
            'token' => $token,
            'role' => 1,
        ]);
        //$newuser = User::create($request->validated());
        $user = User::findOrFail($newuser->id);

        // send welcome email
        if (get_config('email_notification') == 'enabled') {
            
            Mail::mailer(get_config('default_mailer'))->send('email.welcome', ['user' => $user], function ($message) use ($request) {
                $message->to($request->email);
                $message->subject(__('messages.Email_Welcome_Subject'));
            });
        }

        auth()->login($newuser);

        return redirect(route('dashboard.index'))->with('success', "Account successfully registered.");
    }
}
