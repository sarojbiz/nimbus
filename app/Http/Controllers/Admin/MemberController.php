<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\MemberRequest;
use Exception;
use App\Member;
use App\UserAddress;
use App\Enums\UserType;
use App\Enums\GeneralStatus;
use App\Enums\ProvinceType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class MemberController extends Controller
{

    private $member_id = 572098;

    /**
     * all members with user_type = 2
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $members = Member::where('user_type', UserType::Member)->orderBy('id', 'DESC')->get();
        $title = 'Members Listing';
        return view('admin.members.index', compact('members', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add New Member';
        $password = Str::random(8);
        $provinces = ProvinceType::toSelectArray();
        return view('admin.members.create', compact('title', 'password', 'provinces'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(MemberRequest $request)
    {
        DB::beginTransaction();

        try {
            $member = new Member();
            $member->first_name = $request->first_name;
            $member->last_name = $request->last_name;
            $member->email = $request->email;
            $member->password = bcrypt($request->password);
            $member->mobile = $request->mobile;
            $member->status = $request->status ? $request->status : GeneralStatus::Enabled;
            $member->user_type = UserType::Member;
            //$member->created_by = Auth::guard('admin')->user()->id;
            $member->referral_code = $member->generateReferralCode();
            $member->referral_by = $request->referral_by ?: NULL;
            $member->save();

            $member->member_id = 'M'.($member->id + $this->member_id);
            $member->save();

            //save address informations
            $address = new UserAddress();
            $address->street_address = $request->street_address;
            $address->city = $request->city;
            $address->provience = $request->provience;
            $address->postal_code = $request->postal_code;
            $address->country = 'nepal';
            $address->is_default = 1;
            $address->user_id = $member->id;          
            $address->save();

            DB::commit();
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-success'=>"Member created successfully."]);
        } catch (\Exception $e) {

            DB::rollback();
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-danger'=>"Failed to create member."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  Member  $member
     * @return \Illuminate\Http\Response
     */
    public function show(Member $member)
    {
        try {  

            $title = 'View Member Detail';
            return view('admin.members.show', compact('member', 'title'));	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  object  $member
     * @return \Illuminate\Http\Response
     */
    public function edit(Member $member)
    {
        $password = '';
        $title = 'Edit Member';
        $provinces = ProvinceType::toSelectArray();
        return view('admin.members.edit', compact('title', 'member', 'password', 'provinces'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(MemberRequest $request, Member $member)
    {
        DB::beginTransaction();

        try { 

            $member->first_name = $request->first_name;
            $member->last_name = $request->last_name;
            $member->email = $request->email;
            if(!empty($request->password)){
                $member->password = bcrypt($request->password);
            }
            $member->mobile = $request->mobile;
            $member->status = $request->status;
            $member->referral_by = $request->referral_by ?: NULL;
            //$member->created_by = Auth::guard('admin')->user()->id;
            $member->save();

            //update address
            $address = UserAddress::where('user_id', $member->id)->get();
            if( $address->isEmpty()) {
                $address = new UserAddress();
                $address->user_id = $member->id;
            }
            
            $address->street_address = $request->street_address;
            $address->city = $request->city;
            $address->provience = $request->provience;
            $address->postal_code = $request->postal_code;
            $address->country = 'nepal';
            $address->is_default = 1;
            $address->save();

            DB::commit();
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-success'=>"Member updated successfully."]);
        } catch (\Exception $e) {
                     
            DB::rollback();
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-danger'=>"Failed to update member."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Member $member)
    {
        /*
        if( $member->orders->IsNotEmpty() ) {
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-danger'=>"Please delete all order of selected member."]);
        }
        */

        $member->delete();
        return redirect()->action('Admin\MemberController@index')->withErrors(['alert-success'=>"Member deleted successfully."]);
    }
}
