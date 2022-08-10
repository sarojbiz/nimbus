<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Size;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Resources\SizeResource;

class SizeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::where('status', 1)->get();
        return SizeResource::collection($sizes);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {            	            
            $size = Size::where('status', 1)->findOrFail($id);            	
            return new SizeResource($size);	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return response()->json(['message' => $message], 406);          

        } catch (Exception $e) {

            $message = 'Error in fetching size data.';
            return response()->json(['message' => $message], 406);

        }        
    }    
}