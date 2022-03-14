<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Size;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use Illuminate\Validation\Rule;


class SizeController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $sizes = Size::select('size_code','size_name')->get();
        return $this->sendResponse($sizes, 'Sizes retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $size = [];
        $input = $request->all();
        $validator = Validator::make($input, [
            'size_code' => 'required|integer|unique:sizes',
            'size_name' => 'required|unique:sizes'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $size = new Size;
        $size->size_code = $request->size_code;
        $size->size_name = $request->size_name;
        $size->created_by = ($this->loggeduser->id)?$this->loggeduser->id:NULL;
        $size->created_at = now();
        try{
            $result = $size->save();
            if(!$result){
                throw new Exception("Error in creating size.");
            }      
            $size = $size->select('size_code','size_name')->where('size_code', $size->size_code)->get();
            $message = 'Size created successfully.';
            return $this->sendResponse($size, $message);
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($size, $message);          

        } catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($size, $message);
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
        $size = [];     
		try {            	            
            $size= Size::select('size_code','size_name')->findOrFail($id);            	
            $message = 'Size detail.';	
            return $this->sendResponse($size, $message);	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($size, $message);          

        } catch (Exception $e) {

            $message = $e->getMessage();
            return $this->sendError($size, $message);

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
        $size = [];
        try{
            $size = Size::findOrFail($id);             
            $validator = Validator::make($request->all(), [
                'size_name' => ['required', Rule::unique('sizes')->ignore($size->size_name, 'size_name')]
            ]);
             
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());       
            }

            $size->size_name = $request->size_name;
            $size->updated_by = ($this->loggeduser->id)?$this->loggeduser->id:NULL;
            $size->updated_at = now();
            $result = $size->update();
            if(!$result){
                throw new Exception("Error in updating size.");   
            }
            $message = 'Size Updated successfully.';   
            return $this->sendResponse($size, $message); 
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($size, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($size, $message);

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
        $size = [];
        try {
            $size = Size::select('size_code','size_name')->findOrFail($id); 
            $result = $size->delete();
            if(!$result)
            {
                throw new Exception("error in deleting the size.");  
            }    
            $message = 'Size deleted successfully.';            
            return $this->sendResponse($size, $message);
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($size, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($size, $message);

        }
    }
}