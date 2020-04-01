<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use \Illuminate\Http\Request;
use App\Traits\ActivityTraits;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;
    use ActivityTraits;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->username=$this->findUsername();
    }

    public function findUsername()
    {
        $login=request()->input('login');
        $fieldType=filter_var($login,FILTER_VALIDATE_EMAIL)?'email':'username';
        request()->merge([$fieldType=>$login]);
        return $fieldType;
    }

    public function username()
    {
        return $this->username;
    }

    public function authenticated(Request $request, $user)
    {
        $this->logLoginDetails($user);
        if(!$user->verified)
        {
            auth()->logout();
            return back()->with('warning','You need to confirm your account. We have sent you an activation code, please check your email.');
        }
        return redirect()->intended($this->redirectPath());
    }
}
