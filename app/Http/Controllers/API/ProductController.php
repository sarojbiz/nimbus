<?php
namespace App\Http\Controllers\API;

use Illuminate\Http\Request;
use App\Http\Controllers\API\APIController as APIController;
use App\Product;
use App\Size;
use App\Color;
use App\Enums\GeneralStatus;
use Illuminate\Support\Facades\Auth; 
use Illuminate\Database\QueryException;
use Validator;
use Exception;
use Illuminate\Validation\Rule;
use Image;
use File;
use URL;


class ProductController extends APIController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //$products = Product::exclude(['created_by','created_at','updated_by','updated_at'])->orderBy('pdt_id', 'ASC')->get();
        $datas = Product::orderBy('pdt_id', 'ASC')->get();
        $products = [];
        if( $datas->IsNotEmpty() ){
            foreach($datas as $data) {
                if( $data->simple_product && $data->inventorySimpleProduct ){
                    $products[] = [
                        'mcode' => $data->mcode,
                        'title' => $data->pdt_name,
                        'slug' => $data->slug,
                        'parent' => optional($data->parent)->category_name,
                        'children' => NULL,
                        'image' => URL::asset('uploads/products/'.$data->feature_image),
                        'type' => $data->has_size_color ? 'Variable product' : 'Simple product',
                        'brand' => optional($data->brand)->name,
                        'sales_product' => $data->is_sales_product ? 'Yes' : 'No',
                        'status' => GeneralStatus::fromValue((int) $data->status)->description,    
                        'size' => Size::where('id', $data->inventorySimpleProduct->size_id)->pluck('name')->first(),
                        'color' => Color::where('id', $data->inventorySimpleProduct->color_id)->pluck('name')->first(),  
                        'inventory_sku' => $data->inventorySimpleProduct->inventory_sku,
                        'barcode' => $data->inventorySimpleProduct->barcode,      
                        'original_price' => round($data->inventorySimpleProduct->regular_price, 2),
                        'price' => round($data->inventorySimpleProduct->sales_price, 2),
                        'discount' => NULL,
                        'unit' => NULL,
                        'quantity' => 100,
                        'tag' => optional($data->parent)->category_name,
                        'description' => $data->short_description
                    ];
                }
                if( $data->variable_product ){
                    foreach( $data->inventoryProducts as $variable ){
                        $products[] = [
                            'mcode' => $data->mcode,
                            'title' => $data->pdt_name,
                            'slug' => $data->slug,
                            'parent' => optional($data->parent)->category_name,
                            'children' => NULL,
                            'image' => URL::asset('uploads/products/'.$data->feature_image),
                            'type' => $data->has_size_color ? 'Variable product' : 'Simple product',
                            'brand' => optional($data->brand)->name,
                            'sales_product' => $data->is_sales_product ? 'Yes' : 'No',
                            'status' => GeneralStatus::fromValue((int) $data->status)->description,    
                            'size' => Size::where('id', $variable->size_id)->pluck('name')->first(),
                            'color' => Color::where('id', $variable->color_id)->pluck('name')->first(),  
                            'inventory_sku' => $variable->inventory_sku,
                            'barcode' => $variable->barcode,      
                            'original_price' => round($variable->regular_price, 2),
                            'price' => round($variable->sales_price, 2),
                            'discount' => NULL,
                            'unit' => NULL,
                            'quantity' => 100,
                            'tag' => optional($data->parent)->category_name,
                            'description' => $data->short_description
                        ];
                    }
                }
            }
        }        
        return $this->sendResponse($products, 'Products retrieved successfully.');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $product = [];
        $input = $request->all();              
        $input['gallery_images'] = json_encode($this->getSinglePostData('gallery_images', $input)); 
        
        $validator = Validator::make($input, [
            'mcode' => 'required|unique:products',
            'pdt_code' => 'required|unique:products',
            'pdt_name' => 'required|unique:products',
            'category_code' => 'integer|exists:categories,category_id',
            'regular_price' => 'numeric',
            'gallery_images' => 'json'
        ],[
            'category_code.exists' => 'Not a valid category'
        ]);

        if($validator->fails()){
            return $this->sendError('Validation Error.', $validator->errors());       
        }
        $product = new Product;        
        $product = $this->getPostData($product, $input, $mode = 'save'); 
        if (isset($input['feature_image']) && !empty($input['feature_image'])) {
            $feature_image = $this->uploadAsset($request, $name = 'feature_image', $resize = array(550, 750));
            $product->feature_image = $feature_image;
        } 
        try{
            $result = $product->save();            
            if(!$result){
                throw new Exception("Error in creating product.");
            }
            $pdt_id = $product->pdt_id;           
            $product->where('pdt_id', $pdt_id)->update(['identifier' => md5($pdt_id.time())]);       
            $product = $product->where('pdt_code', $product->pdt_code)->exclude(['created_by','created_at','updated_by','updated_at'])->first();            
            $message = 'Product created successfully.';            
            //$gallery_images = json_decode($product->gallery_images, true);
            return $this->sendResponse($product, $message);
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($product, $message);          

        } catch (Exception $e) {
            $message = $e->getMessage();
            return $this->sendError($product, $message);
        }
    }


    /**
     * Display the specified resource.
     *
     * @param  string  $mcode
     * @return \Illuminate\Http\Response
     */
    public function show($mcode)
    {
        $product = [];     
		try {            	            
            $product= Product::exclude(['created_by','created_at','updated_by','updated_at'])->where('mcode',$mcode)->firstOrFail();            	
            $message = 'Product detail.';	
            return $this->sendResponse($product, $message);	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return $this->sendError($product, $message);          

        } catch (Exception $e) {

            $message = $e->getMessage();
            return $this->sendError($product, $message);

        }        
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  string  $mcode
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $mcode)
    {   
        $product = [];
        $input = $request->except(['pdt_code']); 
        $gallery_images = $this->getSinglePostData('gallery_images', $input);  
        try{
            $product = Product::exclude(['created_by','created_at','updated_by','updated_at'])->where('mcode',$mcode)->firstOrFail();   
            $validator = Validator::make($input, [
                'mcode' => ['required', Rule::unique('products')->ignore($product->pdt_code, 'pdt_code')],
                'pdt_name' => 'required',
                'category_code' => 'integer',
                'regular_price' => 'numeric',
                'gallery_images' => 'json|sometimes'
            ]);  
            if($validator->fails()){
                return $this->sendValidationError($validator->errors());       
            }    

            $old_feature_image = $product->feature_image;
            $product = $this->getPostData($product, $input, $mode = 'update'); 
            if (isset($input['feature_image']) && !empty($input['feature_image'])) {
                $product->feature_image = $this->uploadAsset($request, $name = 'feature_image', $resize = array(550, 750), $old_feature_image);
            } 
            $id = $product->pdt_id;
            $result = $product->update();
            if(!$result){
                throw new Exception("Error in updating product.");   
            }
            $product= Product::exclude(['pdt_id','created_by','created_at','updated_by','updated_at'])->findOrFail($id); 
            $message = 'Product Updated successfully.';   
            return $this->sendResponse($product, $message); 
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($product, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($product, $message);

        } 		
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  string  $mcode
     * @return \Illuminate\Http\Response
     */
    public function delete($mcode)
    {
        $product = [];
        try {
            $product= Product::exclude(['created_by','created_at','updated_by','updated_at'])->where('mcode',$mcode)->firstOrFail();  
            $id = $product->pdt_id; 
            $result = $product->delete();
            if(!$result)
            {
                throw new Exception("error in deleting the product.");  
            }    
            $message = 'Product deleted successfully.';            
            return $this->sendResponse($product, $message);
        } catch (QueryException $e) {         

            $message = $e->errorInfo[2];            
            return $this->sendError($product, $message);

        } catch (Exception $e) {
            
            $message = $e->getMessage();
            return $this->sendError($product, $message);

        }
    }

    public function uploadAsset($request, $name, $resize, $old = '')
	{
        $valid_exts = ['jpg','jpeg','png','bmp'];
        $remote = $this->getRemoteFolder();
        $remotefilename = $request[$name];
        if(!empty($name) && file_exists($remote.$remotefilename)){
            $remotefilename = $remote.$remotefilename;
            $ext = pathinfo($remotefilename, PATHINFO_EXTENSION);
            if(!in_array($ext, $valid_exts)){
                return NULL;
            }
        }else{
            return NULL;
        }
        
        $directory = $this->getPublicFolder($subfolder = 'uploads/products/');
		if (!file_exists($directory)) {
			@mkdir($directory, 0777, true);
		}		
		
        $fileName = uniqid() . '.' . $ext;
		$fileNameDir = $directory . $fileName;
        $upload = Image::make($remotefilename);
        
		$upload->resize($resize[0], $resize[1], function ($constraint) {
			$constraint->aspectRatio();
		});
		if($upload->save($fileNameDir, 100)){
            if(!empty($old) && file_exists($directory.$old)){
                $path1 = $directory . $old;
                File::delete($path1);
            }
        }
		return $fileName;		
	}
}