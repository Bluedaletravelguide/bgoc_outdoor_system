<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Carbon\Carbon;
use Illuminate\Http\Request;

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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    // Login using username or email
    public function username()
    {
        $login_type = request()->input('username_or_email');

        $field = filter_var($login_type, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';

        request()->merge([$field => $login_type]);

        return $field;
    }

    // Save last login time
    protected function authenticated(Request $request, $user)
    {
        $user->last_login_at = Carbon::now();
        $user->save();
    }
}
