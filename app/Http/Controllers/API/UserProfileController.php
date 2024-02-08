<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use App\User;
use App\UserAddress;
use App\Enums\UserType;
use Illuminate\Http\Request;
use App\Http\Resources\UserProfileResource;

class UserProfileController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function show()
    {   
        return new UserProfileResource( auth('api')->user() );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $user = User::find(auth('api')->user()->id);
        $user->first_name = $request->first_name;
        $user->last_name = $request->last_name;
        $user->email = $request->email;
        $user->mobile = $request->mobile;
        $user->save();

        //update address
        $address = UserAddress::where('user_id', $user->id)->first();
        if( !$address) {
            $address = new UserAddress();
            $address->user_id = $user->id;
        }
        
        $address->street_address = $request->street_address;
        $address->city = $request->city;
        $address->provience = $request->provience;
        $address->postal_code = $request->postal_code;
        $address->country = 'nepal';
        $address->is_default = 1;
        $address->save();

        return new UserProfileResource($user);
    }
}
