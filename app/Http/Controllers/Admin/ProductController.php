<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\ProductRequest;
use App\Category;
use App\Brand;
use App\Product;
use App\Color;
use App\Size;
use Carbon\Carbon;
use App\InventoryProduct;
use Exception;
use App\Enums\GeneralStatus;
use App\Enums\ProductType;
use Illuminate\Database\QueryException;
use Auth;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\ProductsExport;
use App\Http\Requests\ImportRequest;
use App\Imports\ProductsImport;
use App\Exports\ProductSampleTemplateExport;

class ProductController extends Controller
{
    private $baseMCode = 10000;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::orderBy('pdt_id', 'DESC')->get();
        $title = 'Products Listing';
        return view('admin.products.index', compact('products', 'title'));
    }

    /**
     * helper function to slug the product name
     *
     * @return \Illuminate\Http\Response
     */
    public function slugit($str, $replace=array(), $delimiter='-') {
		if ( !empty($replace) ) {
			$str = str_replace((array)$replace, ' ', $str);
		}
		$clean = iconv('UTF-8', 'ASCII//TRANSLIT', $str);
		$clean = preg_replace("/[^a-zA-Z0-9\/_|+ -]/", '', $clean);
		$clean = strtolower(trim($clean, '-'));
		$clean = preg_replace("/[\/_|+ -]+/", $delimiter, $clean);
		return $clean;
	}

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $product = new Product;
        $product->has_size_color = 0;
        $product->is_sale_product = 0;
        $product->product_status = 1;
        $product->product_type_status = '';
        $product->inventorySimpleProduct = NULL;
        $product->required = '';
        if(old('has_size_color') !== NULL && old('has_size_color') == 0){
            $product->required = 'required="required"';
        }        
        
        $categories = Category::pluck('category_name','category_id');
        $brands = Brand::where('status', GeneralStatus::Enabled)->pluck('name','id');
        $statuses = GeneralStatus::toSelectArray();
        $sizes = Size::where('status', GeneralStatus::Enabled)->pluck('name','id');
        $colors = Color::where('status', GeneralStatus::Enabled)->pluck('name','id');
        $productTypes = ProductType::toSelectArray();
        $title = 'Add New Product';
        return view('admin.products.create', compact('categories', 'brands', 'statuses', 'title', 'sizes', 'colors', 'productTypes', 'product'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ProductRequest $request)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {
            $product = new Product();            
            $product->pdt_name = $request->pdt_name;
            $product->slug = $this->slugit($request->pdt_name);
            $product->pdt_short_description = $request->pdt_short_description;
            $product->pdt_long_description = $request->pdt_long_description;
            $product->ingredients = isset($request->ingredients)?$request->ingredients:NULL;
            $product->how_to_us = isset($request->how_to_us)?$request->how_to_us:NULL;
            $product->category_code = $request->category_code;
            $product->pdt_brand = $request->pdt_brand;
            $product->has_size_color = $request->has_size_color;
            //$product->measurement_unit = $request->measurement_unit;
            $product->is_sale_product = $request->is_sale_product;
            $product->product_status = $request->product_status;
            $product->created_by = Auth::guard('admin')->user()->id;
            $product->save();

            $mCode = intval($product->pdt_id + $this->baseMCode);
            $product->mcode = 'M'.$mCode; 
            $product->pdt_code = 'M'.$mCode; 
            $product->save();
            
            if ($request->hasFile('feature_image')) {                
                $imagePath = $this->uploadProductAsset($product, $request);
                $product->feature_image = $imagePath;
                $product->save();        
            }

            if ($product->simple_product) {

                $inventorySimpleProduct = $product->inventorySimpleProduct; 
                if (!$inventorySimpleProduct) {
                    $inventorySimpleProduct = new InventoryProduct();
                 }
                 $inventorySimpleProduct->regular_price = $request->regular_price;
                 $inventorySimpleProduct->sales_price = isset($request->sales_price)?$request->sales_price:NULL;
                 $inventorySimpleProduct->inventory_sku = $request->inventory_sku;
                 $inventorySimpleProduct->barcode = $request->barcode;
                 $product->inventorySimpleProduct()->save($inventorySimpleProduct);
             }            
 
             if ($product->variable_product) {
                 //add product attributes values
                 if(is_array( $request->get('attribute') ) && !empty( $request->get('attribute') ))
                 foreach( $request->get('attribute') as $attribute ) {
                     $inventoryProduct = InventoryProduct::where(['product_id' => $product->pdt_id,
                                                                  'size_id' => $attribute['size'],
                                                                  'color_id' => $attribute['color']
                                                                  ])
                                                                 ->first();
                     if($inventoryProduct)
                     {
                        $inventoryProduct->regular_price = $attribute['regular_price'];
                        $inventoryProduct->sales_price = $attribute['sales_price'];
                        $inventoryProduct->inventory_sku = $attribute['inventory_sku'];
                        $inventoryProduct->barcode = $attribute['barcode'];
                        $inventoryProduct->save();
                     }else{
                        $inventoryProduct = new InventoryProduct();
                        $inventoryProduct->product_id = $product->pdt_id;
                        $inventoryProduct->size_id = $attribute['size'];
                        $inventoryProduct->color_id = $attribute['color'];
                        $inventoryProduct->regular_price = $attribute['regular_price'];
                        $inventoryProduct->sales_price = $attribute['sales_price'];
                        $inventoryProduct->inventory_sku = $attribute['inventory_sku'];
                        $inventoryProduct->barcode = $attribute['barcode'];
                        $inventoryProduct->save();
                     }
                 }
             }            

            DB::commit();
            return redirect()->action('Admin\ProductController@index')->withErrors(['alert-success'=>"Product added successfully"]);
        } catch (\Exception $e) {
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\ProductController@index')->withErrors(['alert-danger'=>"Failed to add product."]);
        } 
    }

    /**
     * Display the specified resource.
     *
     * @param  string  $identifier
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product)
    {
        try {            	            
            $title = 'View Product Detail';
            return view('admin.products.show', compact('product', 'title'));	
        } catch (QueryException $e) {      

            $message = $e->errorInfo[2];  
            return redirect()->action('Admin\ProductController@index')->withErrors(['alert-danger'=>"$message"]);      

        } catch (Exception $e) {

            $message = $e->getMessage();
            return redirect()->action('Admin\ProductController@index')->withErrors(['alert-danger'=>'Invalid Access.']);

        }    
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product)
    {
        $product->product_type_status = 'disabled="disabled"';
        $categories = Category::pluck('category_name','category_id');
        $brands = Brand::where('status', 1)->pluck('name','id');
        $statuses = GeneralStatus::toSelectArray();
        $sizes = Size::where('status', GeneralStatus::Enabled)->pluck('name','id');
        $colors = Color::where('status', GeneralStatus::Enabled)->pluck('name','id');
        $productTypes = ProductType::toSelectArray();
        $title = 'Edit Product';
        return view('admin.products.edit', compact('categories', 'brands', 'statuses', 'product', 'title', 'sizes', 'colors', 'productTypes'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(ProductRequest $request, Product $product)
    {
        DB::beginTransaction();

        $imagePath = '';

        try {
            $product->pdt_name = $request->pdt_name;
            $product->slug = $this->slugit($request->pdt_name);
            $product->pdt_short_description = $request->pdt_short_description;
            $product->pdt_long_description = $request->pdt_long_description;
            $product->ingredients = isset($request->ingredients)?$request->ingredients:NULL;
            $product->how_to_us = isset($request->how_to_us)?$request->how_to_us:NULL;
            $product->category_code = $request->category_code;
            //$product->has_size_color = $request->has_size_color;
            $product->pdt_brand = $request->pdt_brand;
            //$product->measurement_unit = $request->measurement_unit;
            $product->product_status = $request->product_status;
            $product->is_sale_product = $request->is_sale_product;
            $product->updated_by = Auth::guard('admin')->user()->id;
            $product->save();

            if ($request->hasFile('feature_image')) {                
                $imagePath = $this->uploadProductAsset($product, $request);
                $product->feature_image = $imagePath;
                $product->save();                
            }

            if ($product->simple_product) {

               $inventorySimpleProduct = $product->inventorySimpleProduct; 
               if (!$inventorySimpleProduct) {
                   $inventorySimpleProduct = new InventoryProduct();
                }
                $inventorySimpleProduct->regular_price = $request->regular_price;
                $inventorySimpleProduct->sales_price = isset($request->sales_price)?$request->sales_price:NULL;
                $inventorySimpleProduct->inventory_sku = $request->inventory_sku;
                $inventorySimpleProduct->barcode = $request->barcode;
                $product->inventorySimpleProduct()->save($inventorySimpleProduct);
            }            

            if ($product->variable_product) {
                //add product attributes values
                if(is_array( $request->get('attribute') ) && !empty( $request->get('attribute') ))
                foreach( $request->get('attribute') as $attribute ) {		       
		    $inventoryProduct = InventoryProduct::where(['product_id' => $product->pdt_id,
                                                                 'size_id' => $attribute['size'],
                                                                 'color_id' => $attribute['color']
                                                                 ])
			                                         ->first();
                    if($inventoryProduct)
		    {
			$inventoryProduct->size_id = $attribute['size'];
                        $inventoryProduct->color_id = $attribute['color'];    
                        $inventoryProduct->regular_price = $attribute['regular_price'];
                        $inventoryProduct->sales_price = $attribute['sales_price'];
                        $inventoryProduct->inventory_sku = $attribute['inventory_sku'];
                        $inventoryProduct->barcode = $attribute['barcode'];
                        $inventoryProduct->save();
                    }else{
                        $inventoryProduct = new InventoryProduct();
                        $inventoryProduct->product_id = $product->pdt_id;
                        $inventoryProduct->size_id = $attribute['size'];
                        $inventoryProduct->color_id = $attribute['color'];
                        $inventoryProduct->regular_price = $attribute['regular_price'];
                        $inventoryProduct->sales_price = $attribute['sales_price'];
                        $inventoryProduct->inventory_sku = $attribute['inventory_sku'];
                        $inventoryProduct->barcode = $attribute['barcode'];
                        $inventoryProduct->save();
                    }
                }
            }    

            DB::commit();
            return redirect()->action('Admin\ProductController@index')->withErrors(['alert-success'=>"Product updated successfully"]);
        } catch (\Exception $e) {
            dd( $e->getMessage() );
            if (!empty($imagePath) && file_exists($imagePath)) {			
                File::delete($imagePath);
            }            
            DB::rollback();
            return redirect()->action('Admin\ProductController@index')->withErrors(['alert-danger'=>"Failed to update product."]);
        } 
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product)
    {
        if( $product->feature_image ) {
            $this->removeAsset( $product->feature_image );
        }        
        
        $product->delete();
        return redirect()->action('Admin\ProductController@index')->withErrors(['alert-success'=>"Product deleted successfully."]);
    }

    /**
     * Get the file
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function removeAsset($image)
	{
        $directory = public_path('uploads/categories/');
        $thumbdirectory = public_path('uploads/categories/thumb/');
        $imagePath = $directory . $image;
        $thumbPath = $thumbdirectory . $image;
        
		if (!empty($image) && file_exists($imagePath)) {			
			File::delete($imagePath);
		}				
		if (!empty($image) && file_exists($thumbPath)) {			
			File::delete($thumbPath);
		}				
		return true;
	}

    /**
     * upload the assets
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory)
	{
		if (is_object($data) && !empty($data)) {
			if(!empty($data->$name) && file_exists($directory.$data->$name)){
				$path1 = $directory . $data->$name;
				File::delete($path1);
			}
			if(!empty($data->$name) && file_exists($thumbdirectory.$data->$name)){
				$path2 = $thumbdirectory . $data->$name;
				File::delete($path2);
			}			
		}

		if (!file_exists($directory)) {
			mkdir($directory, 0777, true);
		}
		if (!file_exists($thumbdirectory)) {
			mkdir($thumbdirectory, 0777, true);
		}
		
		$fileName = uniqid() . '.' . $request->file($name)->getClientOriginalExtension();		
		$fileNameDir = $directory . '/' . $fileName;
		$upload = Image::make($request->file($name));
		$upload->resize($resize['full'][0], $resize['full'][1], function ($constraint) {
			$constraint->aspectRatio();
		});
		$upload->save($fileNameDir, 100);

		$fileThumbNameDir = $thumbdirectory . '/' . $fileName;
		$upload->resize($resize['thumb'][0], $resize['thumb'][1], function ($constraint) {
			$constraint->aspectRatio();
		});
		$upload->save($fileThumbNameDir, 100);

		return $fileName;		
    }
    
    /**
     * upload product assets
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function uploadProductAsset($data, REQUEST $request)
	{        
        $resize = ['full' => array(800, null), 'thumb' => array(640, null)];
        $name = 'feature_image';
        $directory = public_path('uploads/products/');
		$thumbdirectory = public_path('uploads/products/thumb/');
        
        $filename = $this->uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory);

		return $filename;		
    }
    
    /**
     * Export to excel
     *
     * @param  \App\Product  $product
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function export()
    {
        $today = Carbon::now()->toDateTimeString();
        return (new productsExport())->download('products_list_'.$today.'.xlsx');
    }

    /**
     * Import products to system from excel
     *
     * @param  NULL
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function import()
    {
        $title = 'Import Product';
        return view('admin.products.import', compact('title'));
    }

    /**
     * Store imported products to system from excel
     *
     * @param  NULL
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function importStore(ImportRequest $request)
    {
        if ($request->hasFile('excel_file')) {  
            $uploadedFileMimeType = $request->file('excel_file')->getMimeType();
            
            $mimes = array('application/excel','application/vnd.ms-excel','application/vnd.msexcel','application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        
            if(in_array($_FILES['excel_file']['type'], $mimes)){
                Excel::import(new ProductsImport, $request->file('excel_file')->store('temp'));
                return redirect()->action('Admin\ProductController@index')->withErrors(['alert-success'=>"Product imported successfully."]);
            } else{
                return redirect()->back()->withErrors(['excel_file' => ['Please upload only Excel format files..']]);
            }
        }
    }
    
    /**
     * downlaod to sample excel template to import bulk
     * image updates for supermarket menu items
     * 
     * @param  NULL
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function getSampleExcel()
    {
        $today = Carbon::now()->toDateTimeString();
        return (new ProductSampleTemplateExport())->download('sample_excel'.$today.'.xlsx');
    } 

    /**
     * Store imported products to system from excel
     *
     * @param  NULL
     * @return Maatwebsite\Excel\Facades\Excel
     */
    public function deleteSingleInventory(Product $product, REQUEST $request)
    {
        if($request->ajax())
        {
            try {
                
                DB::beginTransaction();
                $product->inventoryProducts()->where('id', $request->id)->delete();
                DB::commit();
                return response()->json(['response' => TRUE, 'message' => 'Product inventory removed successfully. '], 200);

            } catch ( \Exception $e ) {
                
                DB::rollback();
                return response()->json(['response' => FALSE, 'message' => $e->getMessage()], 200);
    
            }
        }
        return abort(403); // Access forbidden
    }

}
