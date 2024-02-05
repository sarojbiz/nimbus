<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\User;
use Illuminate\Support\Facades\Auth;
use Validator;
use Exception;
use Illuminate\Validation\Rule;
use App\Enums\UserType;
use App\Enums\GeneralStatus;

class RegisterController extends APIController
{
    private $baseno = 572098;

    /**
     * Register api
     *
     * @return \Illuminate\Http\Response
     */
    public function register(Request $request)
    {
		$rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'			
        ];
        $validator = Validator::make($request->all(), $rules);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['password'] = bcrypt($input['password']);
        $input['status'] = GeneralStatus::Enabled;
        $input['user_type'] = UserType::Member;
        $user = User::create($input);

        $user->referral_code = $user->generateReferralCode();
        $user->member_id = 'M'.($user->id + $this->baseno);
        $user->save();

        $data['token'] =  $user->createToken('authToken')->accessToken;
        $data['name'] =  $user->name;

        return $this->sendResponse($data, 'User register successfully.');
    }
}