<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ResponseController extends Controller
{
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
        
		return response()->json($response, 200);
    }


    /**
     * return error response.
     *
     * @return \Illuminate\Http\Response
     */
    public function sendError($error, $errorMessages = [], $code = 200)
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
