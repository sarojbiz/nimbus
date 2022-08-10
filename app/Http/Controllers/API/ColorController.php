<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Color;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Resources\ColorResource;

class ColorController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::where('status', 1)->get();
        return ColorResource::collection($colors);
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
            $color = Color::where('status', 1)->findOrFail($id);
            return new ColorResource($color);	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return response()->json(['message' => $message], 406);          

        } catch (Exception $e) {

            $message = 'Error in fetching color data.';
            return response()->json(['message' => $message], 406);

        }        
    }
}