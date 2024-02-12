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
            'first_name' => 'required|max:255',
            'last_name' => 'max:255',
            'mobile' => 'required|numeric|digits_between:8,10',
            'email' => 'required|email|unique:users',
            'password' => 'required',
            'confirm_password' => 'required|same:password'			
        ];
        $message = [
            'mobile.digits_between' => 'Valid 8 to 10 digit phone number required.'
        ];
        $validator = Validator::make($request->all(), $rules, $message);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }

        $input = $request->all();
        $input['first_name'] = $request->first_name;
        $input['last_name'] = $request->last_name;
        $input['mobile'] = $request->mobile;
        $input['password'] = bcrypt($input['password']);
        $input['status'] = GeneralStatus::Enabled;
        $input['user_type'] = UserType::Member;
        $user = User::create($input);

        $user->referral_code = $user->generateReferralCode();
        $user->member_id = 'M'.($user->id + $this->baseno);
        $user->save();

        $data['token'] =  $user->createToken('authToken')->accessToken;
        $data['name'] =  $user->full_name;

        return $this->sendResponse($data, 'User register successfully.');
    }
}