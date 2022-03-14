<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use Exception;
use App\Admin;
use App\Enums\UserType;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class AdminController extends Controller
{

    private $admin_id = 572098;

    /**
     * all admin with user_type = 1
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $admins = Admin::where('user_type', UserType::Admin)->orderBy('created_at', 'DESC')->get();
        $title = 'Admin Listing';
        return view('admin.admins.index', compact('admins', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add New Admin';
        $password = Str::random(8);
        return view('admin.admins.create', compact('title', 'password'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AdminRequest $request)
    {
        DB::beginTransaction();

        try {
            $admin = new Admin();
            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->email = $request->email;
            $admin->password = bcrypt($request->password);
            $admin->mobile = $request->mobile;
            $admin->status = $request->status;
            $admin->user_type = UserType::Admin;
            //$member->created_by = Auth::guard('admin')->user()->id;
            $admin->save();

            $admin->member_id = 'M'.($admin->id + $this->admin_id);
            $admin->save();

            DB::commit();
            return redirect()->action('Admin\AdminController@index')->withErrors(['alert-success'=>"Admin created successfully."]);
        } catch (\Exception $e) {
                      
            DB::rollback();
            return redirect()->action('Admin\AdminController@index')->withErrors(['alert-danger'=>"Failed to create admin."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  Admin  $admin
     * @return \Illuminate\Http\Response
     */
    public function show(Admin $admin)
    {
        try {  

            $title = 'View Admin Detail';
            return view('admin.admins.show', compact('admin', 'title'));	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\AdminController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\AdminController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  object  $admin
     * @return \Illuminate\Http\Response
     */
    public function edit(Admin $admin)
    {
        $password = '';
        $title = 'Edit Admin';
        return view('admin.admins.edit', compact('title', 'admin', 'password'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(AdminRequest $request, Admin $admin)
    {
        DB::beginTransaction();

        try { 

            $admin->first_name = $request->first_name;
            $admin->last_name = $request->last_name;
            $admin->email = $request->email;
            if(!empty($request->password)){
                $admin->password = bcrypt($request->password);
            }
            $admin->mobile = $request->mobile;
            $admin->status = $request->status;
            //$member->created_by = Auth::guard('admin')->user()->id;
            $admin->save();

            DB::commit();
            return redirect()->action('Admin\AdminController@index')->withErrors(['alert-success'=>"Admin updated successfully."]);
        } catch (\Exception $e) {
                     
            DB::rollback();
            return redirect()->action('Admin\AdminController@index')->withErrors(['alert-danger'=>"Failed to update admin."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Admin $admin)
    {
        /*
        if( $member->orders->IsNotEmpty() ) {
            return redirect()->action('Admin\MemberController@index')->withErrors(['alert-danger'=>"Please delete all order of selected member."]);
        }
        */

        $admin->delete();
        return redirect()->action('Admin\AdminController@index')->withErrors(['alert-success'=>"Admin deleted successfully."]);
    }
}
