<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\Login\RememberMeExpiration;
use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller
{
    use RememberMeExpiration;

    /*
     * Display login page.
     * 
     * @return Renderable
     */
    public function show()
    {
        
        $data['page_title'] = __('messages.Login');

        return view('auth.login', $data);
    }

    /**
     * Handle account login request
     * 
     * @param LoginRequest $request
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    public function login(LoginRequest $request)
    {
        $credentials = $request->getCredentials();

        if(!Auth::validate($credentials)):
            return redirect(url()->previous())
                ->withErrors(trans('messages.Login_Failed'));
        endif;

        if (\App\Models\User::where('username', $request->username)->value('status') == 2):
           
            //inactive user
            return redirect(url()->previous())->withErrors([
                'errors' => __('messages.There_Was_Problem'),
            ]);
        endif;

        $user = Auth::getProvider()->retrieveByCredentials($credentials);
        $remember = isset($request->remember) ? true : false;
        Auth::login($user, $remember);

        if($remember == true):
            $this->setRememberMeExpiration($user);
        endif;

        return $this->authenticated($request, $user);
    }

      /*
     * Log out account user.
     *
     * @return \Illuminate\Routing\Redirector
     */
    public function logout()
    {
        Session::flush();
        
        Auth::logout();

        return redirect('login');
    }


    /**
     * Handle response after user authenticated
     * 
     * @param Request $request
     * @param Auth $user
     * 
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function authenticated(Request $request, $user) 
    {
        //save last login
        $update = \App\Models\User::where('id', Auth()->user()->id)->update([
            'last_login' => \Illuminate\Support\Carbon::parse(now(), \Helpers::getUserTimeZone())
            ->setTimeZone(config('app.timezone'))
            ->format('Y-m-d H:i:s')
        ]);
        
        return redirect()->to(route('dashboard.index'));
    }
}