<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Banner;
use Illuminate\Database\QueryException;
use Exception;
use App\Http\Resources\BannerResource;
use App\Enums\GeneralStatus;

class BannerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $banners = Banner::where('status', GeneralStatus::Enabled)->get();
        return BannerResource::collection($banners);
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
            $banner = Banner::where('status', GeneralStatus::Enabled)->findOrFail($id);            	
            return new BannerResource($banner);	

        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return response()->json(['message' => $message], 406);          

        } catch (Exception $e) {

            $message = 'Error in fetching size data.';
            return response()->json(['message' => $message], 406);

        }        
    }    
}