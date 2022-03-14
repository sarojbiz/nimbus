<?php
namespace App\Http\Controllers\API;


use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Color;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use Illuminate\Validation\Rule;


class ColorController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $colors = Color::select('color_id','color_name')->get();
        return $this->sendResponse($colors, 'Colors retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $color = [];
        $input = $request->all();
        $validator = Validator::make($input, [
            'color_id' => 'required|integer|unique:colors',
            'color_name' => 'required|unique:colors'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $color = new Color;
        $color->color_id = $request->color_id;
        $color->color_name = $request->color_name;
        $color->created_by = ($this->loggeduser->id)?$this->loggeduser->id:NULL;
        $color->created_at = now();
        try{
            $result = $color->save();
            if(!$result){
                throw new Exception("Error in creating color.");
            }      
            $color = $color->select('color_id','color_name')->where('color_id', $color->color_id)->get();
            $message = 'Color created successfully.';
            return $this->sendResponse($color, $message);
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($color, $message);          

        } catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($color, $message);
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
        $color = [];     
		try {            	            
            $color= Color::select('color_id','color_name')->findOrFail($id);            	
            $message = 'Color detail.';	
            return $this->sendResponse($color, $message);	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($color, $message);          

        } catch (Exception $e) {

            $message = $e->getMessage();
            return $this->sendError($color, $message);

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
        $color = [];
        try{
            $color = Color::findOrFail($id);             
            $validator = Validator::make($request->all(), [
                'color_name' => ['required', Rule::unique('colors')->ignore($color->color_id, 'color_id')]
            ]);
             
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());       
            }

            $color->color_name = $request->color_name;
            $color->updated_by = ($this->loggeduser->id)?$this->loggeduser->id:NULL;
            $color->updated_at = now();
            $result = $color->update();
            if(!$result){
                throw new Exception("Error in updating color.");   
            }
            $message = 'Color Updated successfully.';   
            return $this->sendResponse($color, $message); 
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($color, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($color, $message);

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
        $color = [];
        try {
            $color = Color::select('color_id','color_name')->findOrFail($id); 
            $result = $color->delete();
            if(!$result)
            {
                throw new Exception("error in deleting the color.");  
            }    
            $message = 'Color deleted successfully.';            
            return $this->sendResponse($color, $message);
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($color, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($color, $message);

        }
    }
}