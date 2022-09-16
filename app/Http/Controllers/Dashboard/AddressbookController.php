<?php

namespace App\Http\Controllers\Dashboard;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AddressbookRequest;
use DB;
use Auth;
use App\UserAddress;
use App\Enums\ProvinceType;
use App\Enums\Countries;

class AddressbookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $proviences = ProvinceType::toSelectArray();
        $countries = Countries::toSelectArray();
        $title = 'Address Book';
        return view('dashboard.addressbook', compact('title', 'proviences', 'countries'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(AddressbookRequest $request)
    {   
        DB::beginTransaction();

        try {
            $user = Auth::user();
            $userAddress = UserAddress::updateOrCreate(
                ['user_id' => $user->id],
                ['street_address' => $request->street_address,
                 'city' => $request->city,
                 'provience' => $request->provience,
                 'postal_code' => $request->postal_code,
                 'country' => $request->country,
                ]
            );
                        
            DB::commit();
            return redirect()->action('Dashboard\AddressbookController@index')->withErrors(['alert-success'=>"Address Book updated successfully."]);
        } catch (\Exception $e) {
                      
            DB::rollback();
            return redirect()->action('Dashboard\AddressbookController@index')->withErrors(['alert-danger'=>"Failed to update Address Book."]);
        } 

    }
}
