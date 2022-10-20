<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Page;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Resources\CMSResource;
use App\Enums\GeneralStatus;

class CMSController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(REQUEST $request)
    {
        $request->requestType = 'all';
        $pages = Page::where('status', GeneralStatus::Enabled)->get();
        return CMSResource::collection($pages);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, REQUEST $request)
    {
        $request->requestType ='detail';
        try {            	            
            $page = Page::where('status', GeneralStatus::Enabled)->findOrFail($id);            	
            return new CMSResource($page);	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return response()->json(['message' => $message], 406);          

        } catch (Exception $e) {

            $message = 'Error in fetching size data.';
            return response()->json(['message' => $message], 406);

        }        
    }    
}