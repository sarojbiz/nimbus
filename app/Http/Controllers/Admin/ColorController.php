<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ColorRequest;
use Exception;
use Auth;
use App\Color;
use Illuminate\Support\Facades\DB;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::orderBy('id', 'DESC')->get();
        $title = 'Colors Listing';
        return view('admin.colors.index', compact('colors', 'title'));
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
        $title = 'Add New Color';
        return view('admin.colors.create', compact('title'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ColorRequest $request)
    {
        DB::beginTransaction();

        try {
            $color = new Color();
            $color->name = $request->name;
            $color->slug = $this->slugit($request->name);
            $color->description = $request->description;
            $color->status = $request->status;
            $color->created_by = Auth::guard('admin')->user()->id;
            $color->save();

            DB::commit();
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-success'=>"Color added successfully."]);
        } catch (\Exception $e) {
                      
            DB::rollback();
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-danger'=>"Failed to add color."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Color $color)
    {
        try {  

            $title = 'View Color Detail';
            return view('admin.colors.show', compact('color', 'title'));	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-danger'=>"$message"]);    

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-danger'=>'Invalid Access.']);  

        } 
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Color $color)
    {
        $title = 'Edit Color';
        return view('admin.colors.edit', compact('title', 'color'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ColorRequest $request, Color $color)
    {
        DB::beginTransaction();

        try {           
            $color->name = $request->name;
            $color->slug = $this->slugit($request->name);
            $color->description = $request->description;
            $color->status = $request->status;
            $color->updated_by = Auth::guard('admin')->user()->id;
            $color->save();

            DB::commit();
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-success'=>"Color updated successfully."]);
        } catch (\Exception $e) {
                     
            DB::rollback();
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-danger'=>"Failed to update color."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Color $color)
    {
        /*
        if( $color->colorValues->IsNotEmpty() ) {
            return redirect()->action('Admin\ColorController@index')->withErrors(['alert-danger'=>"color is associated with color values."]);
        }
        */
        
        $color->delete();
        return redirect()->action('Admin\ColorController@index')->withErrors(['alert-success'=>"Color deleted successfully."]);
    }
}