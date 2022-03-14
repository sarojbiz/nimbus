<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Barcode;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use Illuminate\Validation\Rule;


class BarcodeController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $barcodes = Barcode::exclude(['created_by','created_at','updated_by','updated_at'])->get();
        return $this->sendResponse($barcodes, 'Barcode retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $barcode = [];
        $input = $request->all();
        $validator = Validator::make($input, [
            'barcode' => 'required|unique:barcodes',
            'pdt_code' => 'required',
            'color_id' => 'required|integer',
            'size_code' => 'required|integer',
            'price' => 'numeric'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $barcode = new Barcode;        
        $barcode = $this->getPostData($barcode, $input, $mode = 'save');                  
        try{
            $result = $barcode->save();            
            if(!$result){
                throw new Exception("Error in creating barcode.");
            }      
            $barcode = $barcode->where('barcode', $barcode->barcode)->exclude(['barcode_id','created_by','created_at','updated_by','updated_at'])->get();            
            $message = 'Barcode created successfully.';
            return $this->sendResponse($barcode, $message);
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($barcode, $message);          

        } catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($barcode, $message);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $barcode = [];     
		try {            	            
            $barcode= Barcode::exclude(['barcode_id','created_by','created_at','updated_by','updated_at'])->where('barcode',$id)->firstOrFail();            	
            $message = 'Barcode detail.';	
            return $this->sendResponse($barcode, $message);	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($barcode, $message);          

        } catch (Exception $e) {

            $message = $e->getMessage();
            return $this->sendError($barcode, $message);

        }        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {   
        $barcode = [];
        $input = $request->except(['barcode']); 
        try{
            $barcode= Barcode::exclude(['created_by','created_at','updated_by','updated_at'])->where('barcode',$id)->firstOrFail();   
            $validator = Validator::make($input, [
                /*'barcode' => ['required', Rule::unique('barcodes')->ignore($barcode->barcode, 'barcode')],*/
                'pdt_code' => 'required',
                'color_id' => 'required|integer',
                'size_code' => 'required|integer',
                'price' => 'numeric'
            ]);                         
             
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());       
            }                  
            $barcode = $this->getPostData($barcode, $input, $mode = 'update'); 
            $id = $barcode->barcode_id;
            $result = $barcode->update();
            if(!$result){
                throw new Exception("Error in updating barcode.");   
            }
            $barcode = Barcode::exclude(['barcode_id','created_by','created_at','updated_by','updated_at'])->findOrFail($id); 
            $message = 'Barcode Updated successfully.';   
            return $this->sendResponse($barcode, $message); 
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($barcode, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($barcode, $message);

        } 		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        $barcode = [];
        try {
            $barcode= Barcode::exclude(['created_by','created_at','updated_by','updated_at'])->where('barcode',$id)->firstOrFail();  
            $id = $barcode->barcode_id; 
            $result = $barcode->delete();
            if(!$result)
            {
                throw new Exception("error in deleting the barcode.");  
            }    
            $message = 'Barcode deleted successfully.';            
            return $this->sendResponse($barcode, $message);
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($barcode, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($barcode, $message);

        }
    }

/**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function price(Request $request)
    {   
        $barcode = [];
        $input = $request->except(['barcode']); 
        try{
            $barcode= Barcode::exclude(['created_by','created_at','updated_by','updated_at'])->where('barcode',$id)->firstOrFail();   
            $validator = Validator::make($input, [
                /*'barcode' => ['required', Rule::unique('barcodes')->ignore($barcode->barcode, 'barcode')],*/
                'pdt_code' => 'required',
                'color_id' => 'required|integer',
                'size_code' => 'required|integer',
                'price' => 'numeric'
            ]);                         
             
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());       
            }                  
            $barcode = $this->getPostData($barcode, $input, $mode = 'update'); 
            $id = $barcode->barcode_id;
            $result = $barcode->update();
            if(!$result){
                throw new Exception("Error in updating barcode.");   
            }
            $barcode = Barcode::exclude(['barcode_id','created_by','created_at','updated_by','updated_at'])->findOrFail($id); 
            $message = 'Barcode Updated successfully.';   
            return $this->sendResponse($barcode, $message); 
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($barcode, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($barcode, $message);

        } 		
    }    
}