<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProfileRequest;
use DB;
use Auth;

class ProfileController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $title = 'My Profile';
        return view('dashboard.profile', compact('title'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(ProfileRequest $request)
    {
        
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $user->first_name = $request->first_name;
            $user->last_name = $request->last_name;
            $user->email = $request->email;
            if($request->password){
                $user->password = bcrypt($request->password);
            }
            $user->mobile = $request->mobile;
            $user->save();
            
            DB::commit();
            return redirect()->action('Dashboard\ProfileController@index')->withErrors(['alert-success'=>"Profile updated successfully."]);
        } catch (\Exception $e) {
                      
            DB::rollback();
            return redirect()->action('Dashboard\ProfileController@index')->withErrors(['alert-danger'=>"Failed to update profile."]);
        } 

    }
}
