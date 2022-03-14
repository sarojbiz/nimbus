<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Validator;
use Auth;
use Hash;
use App\User;
use App\Enums\UserType;

class AuthController extends FrontController
{
    private $memberID = 572098;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
        if (Auth::check()) {
    		return redirect('/');
    	} 
        $title = "Login";
        if($request->isMethod('post')){ 
            $validator = Validator::make($request->all(),[
                //'mobile'    => 'required|regex:/(9)[0-9]{9}/|exists:users,mobile',
                'email'    => 'required|email',
				'password' 	=> 'required|min:4',
            ],[
                'email.exists'   => 'Your Email has been already registered with us.',
                'mobile.unique'  => 'The mobile has been already registered.',
            ]);
            if($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput($request->input());
            } else{
                $remeber = (isset($request->remember)) ? true : false;
                if(Auth::attempt([
                    'email' 	=> $request->email,
                    'password' 	=> $request->password,
                    'user_type' => UserType::Member
                ], $remeber)
                ){	
                    if(Auth::user()->status == 1){
                        return redirect(route('home'))->with(['alert-success' => 'Welcome, '. ucfirst(Auth::user()->first_name)]);
                        /*
                        if( Auth::user()->verify_otp == 0 ) {
                            Auth::logout();
                            $login_url = route('verify.account');
                            return redirect(route('user.login'))->withErrors(['alert-success'=> 'Account not activated yet. Please <a href="'.$login_url.'" style="color:#007bff;" title="Activate Account">active account</a> once using OTP code received in mobile.']);
                        }else{
                            return redirect(route('home'))->with(['alert-success' => 'Welcome, '. ucfirst(Auth::user()->first_name)]);
                        }
                        */
                    }else if(Auth::user()->status == 0){
                        Auth::logout();
                        return redirect()->back()->withErrors(['alert-danger'=> 'Account have been disabled. Please contact administrator.']);
                    }
                }else{
                    return redirect()->back()->withErrors(['alert-danger'=> 'Invalid email and or password.'])->withInput($request->input());
                }
            }
		}else{        
            return view( 'userauth.login', compact('title'));
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
        if (Auth::check()) {
    		return redirect('/');
    	} 
        $title = "Create An Account";
        if($request->isMethod('post')){
			$validator = Validator::make($request->all(),[
                'first_name' 	=> 'required|max:255',
                'last_name' 	=> 'required|max:255',  
                'email'         => 'required|email|max:255|unique:users,email',
                'password' 	    => 'required|min:4',                
	            'agree' 		=> 'required',
            ],[                
                'email.unique'   => 'The email has been already registered.',
                'agree.required' => 'Please agree the terms and condition before proceeding.'
            ]);
            if($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput($request->input());
			} else{
                $user 				= new User();
                $user->member_id 	= NULL;
                $user->first_name 	= $request->first_name;
                $user->last_name 	= $request->last_name;
                $user->email 		= $request->email;                
                $user->password 	= bcrypt($request->password);
                $user->user_type 	= 2; //client
                $user->status 		= 1;
                $user->verify_otp 	= 0;
                if( $user->save() ){
                    $user->member_id = 'M'.($this->memberID + $user->id);
                    $user->save();
                    /*
                    if(request()->getHttpHost() != "localhost"){
                        Mail::to( $user->email )->send(new RegisterMail($user));
                    }
                    $login_url = route('verify.account');
                    return redirect(route('user.register'))->withErrors(['alert-success'=> 'Please <a href="'.$login_url.'" style="color:#007bff;" title="Proceed to OTP verification">verify account</a> once using OTP code received in mobile.']);
                    */
                    if(Auth::attempt([
                        'email' 	=> $request->email,
                        'password' 	=> $request->password,
                        'user_type' => 2
                    ], true)
                    ){
                        return redirect(route('home'))->with(['alert-success' => 'Welcome, '. ucfirst(Auth::user()->first_name)]);                           
                    }else{
                        return redirect()->back()->withErrors(['alert-danger'=> 'Account Created Successfully. Please login to continue.']);
                    }
                }else{
                    return redirect()->back()->withErrors(['alert-danger'=> 'Error in registering new user.'])->withInput($request->input());
                }                
            }
		}else{
            return view( 'userauth.register', compact('title'));
        }
    }

    public function otpVerification(Request $request)
    {
        if (Auth::check()) {
    		return redirect('/');
    	} 
        $title = "Verify Account";
		if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
                'mobile' => 'required|regex:/(9)[0-9]{9}/|exists:users,mobile',
                'passcode'    => 'required|integer|min:4'
			],[
                'mobile.regex' => 'Standard 10 digit mobile number required.',
                'mobile.exists' => 'The mobile has been been registered yet.'
			]);
            if($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput($request->input());
			} else{
                $_request = [];
                $_request['deviceToken'] = time();
                $_request['companyid']   = $this->companyID;
                $_request['otp']         = $request->passcode;
                $_request['mobile']      = $request->mobile;
                $_request['mode']        = 'register';
                //$return = $this->_apicall('POST', 'deviceToken', $_request, $atozept = true);
                $return = $this->_apicall('GET', 'tran', $_request);
                if($return['status'] == 'ok' && $return['code'] == 200){
                    
                    if(!empty($return['result'])){
                        $userData = json_decode($return['result']);
                    }
                    if(is_null($userData)){
                        return redirect()->back()->withErrors(['alert-danger'=> 'Register mobile cound not be verified.'])->withInput($request->input());    
                    }
                    $validOtp = User::where([
                                    'mobile'=> $userData->mob,
                                    'email'=> $userData->email
                                    ])->update([
                                        'member_id'  => $userData->memid,
                                        'password'   => Hash::make( $request->passcode ),
                                        'verify_otp' => 1
                                    ]);
                    if( $validOtp ){
                        /*
                        $user = User::where('member_id', $user->memid)->firstOrFail();
                        $vuser->save();
                        if( request()->getHttpHost() != "localhost" ){
                            //Mail::to($vuser->email)->send(new WelcomeMail( $vuser ));
                        }
                        */
                        return redirect(route('user.login'))->withErrors(['alert-success'=> 'Account verification successful. Please proceed with login.']);
                    }else{
                        return redirect()->back()->withErrors(['alert-danger'=> 'Register mobile cound not be verified.']);
                    }
                }else{
                    return redirect()->back()->withErrors(['alert-danger'=> ucwords($return['result'])])->withInput($request->input());
                }
            }
		}else{
			return view('userauth.otp', compact('title'));	
		}	
	}

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function forgotPassword(Request $request)
    {
        $title = "Forgot Password";
        if($request->isMethod('post')){
            $validator = Validator::make($request->all(),[
				'mobile' => 'required|regex:/(9)[0-9]{9}/|exists:users,mobile'
			],[
                'mobile.regex' => 'Standard 10 digit mobile number required.',
                'mobile.exists' => 'The mobile has been been registered yet.'
			]);
            if($validator->fails()) {
				return redirect()->back()->withErrors($validator)->withInput($request->input());
			} else{
                $_request = ['mobile' => $request->mobile, 'companyid' => $this->companyID, 'otpMode' => 'login'];                
                $return = $this->_apicall('GET', 'tran', $_request);
                if($return['status'] == 'ok'){
		 			return redirect(route('forgot.password'))->withErrors(['alert-success'=> ucwords($return['result'])]);
		 		} else{
		 			return redirect()->back()->withErrors(['alert-danger'=> ucwords($return['result'])])->withInput($request->input());
		 		}
			}
        }else{            
            return view('userauth.password.forgot', compact('title'));
        }
    }

    public function logout(Request $request){
		if(Auth::check()){
			Auth::logout();
		}
		return redirect('/');
	}
}
