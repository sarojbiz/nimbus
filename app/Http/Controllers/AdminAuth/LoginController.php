<?php

namespace App\Http\Controllers\AdminAuth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
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

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/admin';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except('logout');
    }

    public function showLoginForm(){
        return view('adminauth.login');
    }

    /**
     * Log the user out of the application.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function logout(Request $request)
    {
        $this->guard()->logout();

        $request->session()->invalidate();

        return redirect()->route('admin.login');
    }
    
     /**
     * Get the guard to be used during authentication.
     *
     * @return \Illuminate\Contracts\Auth\StatefulGuard
     */
    protected function guard()
    {
        return Auth::guard('admin');
    }

    private function validator(Request $request)
{
    //validation rules.
    $rules = [
        'email'    => 'required|email|exists:users|min:5|max:191',
        'password' => 'required|string|min:4|max:255',
    ];

    //custom validation error messages.
    $messages = [
        'email.exists' => 'Invalid Username and or Password.',
    ];

    //validate the request.
    $request->validate($rules,$messages);
}

public function login(Request $request)
{
    $this->validator($request);
    
    if(Auth::guard('admin')->attempt([
        'email'     => $request->email,
        'password'  => $request->password, 
        'status'    => 1,
        'user_type'   => 1
        ],$request->filled('remember'))){
        //Authentication passed...
        return redirect()
            ->intended(route('admin.dashboard'))
            ->withErrors(['alert-success' => 'Welcome Again']);
    }

    //Authentication failed...
    return $this->loginFailed();
}

    private function loginFailed(){
        return redirect()
            ->back()
            ->withInput()
            ->withErrors(['alert-danger' => 'Invalid Username and or Password.']);
    }
}
