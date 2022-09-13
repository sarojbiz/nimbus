<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Illuminate\Validation\Rule;

class AuthController extends APIController
{
    /**
     * login api
     *
     * @return \Illuminate\Http\Response
     */
    public function login(Request $request)
    {
		$rules = [
            'username' => 'required|email',
            'password' => 'required',
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors(), 401);       
        }
		
        $credentials = ['email' => $request->username, 'password' => $request->password];
        
		if( Auth::attempt($credentials) ){
			$user = Auth::user();
			$response['token_type'] 	= "Bearer";
	        $response['access_token'] 	=  $user->createToken('authToken')->accessToken;
	        return response()->json( $response, 200 );			
			
		}else{			
			return $this->sendError('The invalid username and or password.', [], 401);      	
		}
		
        return $this->sendResponse($data, 'User register successfully.');
    }
}