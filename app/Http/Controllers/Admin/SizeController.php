<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\SizeRequest;
use Exception;
use Auth;
use App\Size;
use Illuminate\Support\Facades\DB;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::orderBy('id', 'DESC')->get();
        $title = 'Sizes Listing';
        return view('admin.sizes.index', compact('sizes', 'title'));
    }

    /**
     * helper function to slug the category name
     *
     * @return \Illuminate\Http\Response
     */
    public function slugit($str, $replace=array(), $delimiter='-') {
		if ( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		return $clean;
	}    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $title = 'Add New Size';
        return view('admin.sizes.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(SizeRequest $request)
    {
        DB::beginTransaction();

        try {
            $size = new Size();
            $size->name = $request->name;
            $size->slug = $this->slugit($request->name);
            $size->description = $request->description;
            $size->status = $request->status;
            $size->created_by = Auth::guard('admin')->user()->id;
            $size->save();

            DB::commit();
            return redirect()->action('Admin\SizeController@index')->withErrors(['alert-success'=>"Size added successfully."]);
        } catch (\Exception $e) {
                      
            DB::rollback();
            return redirect()->action('Admin\SizeController@index')->withErrors(['alert-danger'=>"Failed to add size."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Size $size)
    {
        try {  

            $title = 'View Size Detail';
            return view('admin.sizes.show', compact('size', 'title'));	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\SizeController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\SizeController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Size $size)
    {
        $title = 'Edit Size';
        return view('admin.sizes.edit', compact('title', 'size'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(SizeRequest $request, Size $size)
    {
        DB::beginTransaction();

        try {           
            $size->name = $request->name;
            $size->slug = $this->slugit($request->name);
            $size->description = $request->description;
            $size->status = $request->status;
            $size->updated_by = Auth::guard('admin')->user()->id;
            $size->save();

            DB::commit();
            return redirect()->action('Admin\SizeController@index')->withErrors(['alert-success'=>"Size updated successfully."]);
        } catch (\Exception $e) {
                     
            DB::rollback();
            return redirect()->action('Admin\SizeController@index')->withErrors(['alert-danger'=>"Failed to update size."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Size $size)
    {
        /*
        if( $size->sizeValues->IsNotEmpty() ) {
            return redirect()->action('Admin\sizeController@index')->withErrors(['alert-danger'=>"size is associated with size values."]);
        }
        */
        
        $size->delete();
        return redirect()->action('Admin\SizeController@index')->withErrors(['alert-success'=>"Size deleted successfully."]);
    }
}
