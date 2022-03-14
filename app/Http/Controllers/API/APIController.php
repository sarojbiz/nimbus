<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller as Controller;

class APIController extends Controller
{
	public $loggeduser = array();
	
	public function __construct()
	{		
		$this->loggeduser = auth('api')->user();
    }

    public function getRemoteFolder()
    {
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            return public_path('/remote/');
        }else{
            return base_path().'/../html/remote/';
        }
    }
    
    public function getPublicFolder($subfolder)
    {
        if($_SERVER['HTTP_HOST'] == 'localhost'){
            return public_path($subfolder);
        }else{
            return base_path().'/../html/'.$subfolder;
        }
    }

    /**
     * filter and map api data.
     *
     * @return \Illuminate\Http\input
     */
    public function getPostData($modelObj, $postdata, $mode='save')
    {        
        $fillables = $modelObj->getFillable(); 
        if(is_array($fillables) && !empty($fillables))
        {
            foreach($fillables as $fillable)
            {
                if(array_key_exists($fillable, $postdata)){
                    $modelObj->$fillable = $postdata[$fillable];
                }
            }
        }
        if($mode == 'save'){
            $modelObj->created_by = ($this->loggeduser->id)?$this->loggeduser->id:NULL;
            $modelObj->created_at = now();
        }else{
            $modelObj->updated_by = ($this->loggeduser->id)?$this->loggeduser->id:NULL;
            $modelObj->updated_at = now();
        }
        return $modelObj;
    }
    
    /**
     * get single api post data.
     *
     * @return \Illuminate\Http\input
     */
    public function getSinglePostData($key, $postdata)
    {
        $return = NULL;        
        if(array_key_exists($key, $postdata)){
            $return = $postdata[$key];
        }
        return $return;
    }     
	
    /**
     * success response method.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendResponse($data, $message)
    {
    	$response = [
            'success' => true,
            'data'    => $data,
            'message' => $message,
        ];

        //return response()->json($response, 200)->header('Content-Type', 'application/json');
		return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 404)
    {
    	$response = [
            'success' => false,
            'message' => $error,
        ];


        if(!empty($errorMessages)){
            $response['data'] = $errorMessages;
        }


        return response()->json($response, $code);
    }

    /**
     * return validation error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendValidationError($errorMessages = [], $code = 400)
    {
    	$response = [
            'success' => false,
            'message' => 'Validation Error.',
        ];


        if(!empty($errorMessages)){
            $response['errors'] = $errorMessages;
        }


        return response()->json($response, $code);
    }
}