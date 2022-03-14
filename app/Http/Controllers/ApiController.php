<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use GuzzleHttp\Client;
use GuzzleHttp\Exception\RequestException;
use GuzzleHttp\Exception\ConnectException;

class ApiController extends Controller
{
	protected $endpoint = 'http://imsnepal.com:8080/ImsPosMem/api/';
	protected $atozendpoint = 'http://imsnepal.com:8080/atozcrm/api/';
    protected $companyID = '5e15c6c20d1cfb628b1908a5';

    public function __construct()
	{
				
	}
	
	public function _check_key($key, $array)
	{
		if(is_array($array) && !empty($array))
		{
			return (array_key_exists($key, $array)) ? $array[$key] : NULL;
		}elseif(is_object($array) && !empty($array)){
			return (array_key_exists($key, $array)) ? $array->$key : NULL;
		}else{
			return NULL;
		}		
	}
	
	public function list_error($e)
	{
		echo '<pre>';
		print_r($e->gethandlerContext());
		print_r($e->getMessage());
		print_r($e->getRequest());
		echo '</pre>';	
	}

    /**
     * Store a newly created resource in _call.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function _apicall($_method="GET", $_node=NULL, $_request = array(), $atozept = false)
    {
		$return = array();
		$client = new Client([
			'base_uri' => ($atozept)?$this->atozendpoint:$this->endpoint,
			'timeout'  => 5.0
		]);
		try {
            if($_method == 'GET'){
                $call = $client->request($_method, $_node, ['query' =>  $_request],  
                [
                    'headers' => [
                                 'Content-Type' => 'application/json', 
                                 'Accept' => 'application/json'
                                 ]
                ]);
            }else{
                $call = $client->request($_method, $_node, [
                    'headers' => [
                                 'Content-Type' => 'application/json', 
                                 'Accept' => 'application/json'
                    ],
                    'json' => (object) $_request
                ]);
            }
			if ($call->getStatusCode() == 200) {
                $response = json_decode( $call->getBody(), true);
				$return['code'] = 200;
				$return['status'] = $this->_check_key('status', $response);
				$return['result'] = $this->_check_key('result', $response);
			}
			return $return; 	
		} catch (RequestException $e) {	
		
			//dd($this->list_error($e));
			if($e->hasResponse())
			{
				if ($e->getResponse()->getStatusCode() == 400) {
					$response = json_decode( $e->getResponse()->getBody(), true);
					$return['code'] = 400;
					
					if($this->_check_key('status', $response) == 'error'){					
						$return['status'] = $this->_check_key('status', $response);
						$return['result'] = $this->_check_key('result', $response);
					}				
				}
				
				if ($e->getResponse()->getStatusCode() == 401) {				
					$response = json_decode( $e->getResponse()->getBody(), true);
					$return['code'] = 401;
					
					if($this->_check_key('status', $response) == 'error'){
						$return['status'] = $this->_check_key('status', $response);
						$return['result'] = $this->_check_key('result', $response);
					}				
				}

				if ($e->getResponse()->getStatusCode() == 404) {	
					$return['code'] = 404;
					$return['status'] = 'error';
					$return['result'] = 'Something went wrong, Please try again later.';
				}
				
			}else{

				$return['code'] = 500;
				$return['status'] = 'error';
				$return['result'] = 'Something went wrong, Please try again later.';

			}

			return $return; 
		} catch (ConnectException $e) {
			
			$return['code'] = 500;
			$return['status'] = 'error';
			$return['result'] = $e->getMessage();
			return $return; 
			
		} catch (\Exception $e) {
			echo 'Caught exception: ',  $e->getMessage(), "\n";
		}		
    }
}