<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Auth;
use App\User;
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
}
