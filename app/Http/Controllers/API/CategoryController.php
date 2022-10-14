<?php
namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Category;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Resources\CategoryResource;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->paginate(5);
        $request->withchildren = 'withchildren';
        return CategoryResource::collection($categories);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {            	            
            $category= Category::findOrFail($id);  
            $request->withchildren = 'withchildren';
            return new CategoryResource($category);	

        } catch (QueryException $e) {      

            $message = $e->getMessage();
            return response()->json(['message' => $message], 406);

        } catch (Exception $e) {

            $message = 'Error in fetching category data.';  
            return response()->json(['message' => $message], 406);

        }        
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function categoryProducts(Request $request, $id)
    {
        try {            	            
            $category= Category::findOrFail($id);  
            $request->withproducts = 'withproducts';
            return new CategoryResource($category);	

        } catch (QueryException $e) {      

            $message = $e->getMessage();
            return response()->json(['message' => $message], 406);

        } catch (Exception $e) {

            $message = 'Error in fetching category data.';  
            return response()->json(['message' => $message], 406);

        }
    }
}