<?php

namespace App\Imports;
use App\Product;
use App\Category;
use App\Brand;
use App\Color;
use App\Size;
use Carbon\Carbon;
use App\InventoryProduct;
use Exception;
use Auth;
use App\Enums\GeneralStatus;
use App\Enums\ProductType;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ProductsImport implements ToModel, WithStartRow
{

    private $baseMCode = 10000;
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function formatData($data)
    {
        return trim( $data );
    }    
    
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        $product = Product::where('pdt_name', $row[0])->first();
        if( !$product ){
            $product = new Product();   
            $product->has_size_color = ($this->formatData(strtolower($row[1])) == 'simple')?false:true;
        }
        $product->pdt_name = $row[0];
        $product->slug = $this->slugit($row[0]);
        $product->pdt_brand = $this->prepareBrand($row[2]);
        $product->category_code = $this->prepareCategory($row[3]);
        $product->is_sale_product = $row[4];
        $product->product_status = $this->prepareStatus($row[5]);
        $product->pdt_short_description = !empty($row[6])?$row[6]:NULL;
        $product->pdt_long_description = !empty($row[7])?$row[7]:NULL;
        $product->ingredients = !empty($row[8])?$row[8]:NULL;
        $product->how_to_us = !empty($row[9])?$row[9]:NULL;
        $product->created_by = Auth::guard('admin')->user()->id;
        //$product->measurement_unit = $row[0];
        $product->save();
        
        $mCode = intval($product->pdt_id + $this->baseMCode);
        $product->mcode = 'M'.$mCode; 
        $product->pdt_code = 'M'.$mCode; 
        $product->save();

        if ($product->simple_product) {

            $inventorySimpleProduct = $product->inventorySimpleProduct; 
            if (!$inventorySimpleProduct) {
                $inventorySimpleProduct = new InventoryProduct();
             }
             $inventorySimpleProduct->regular_price = $row[14];
             $inventorySimpleProduct->sales_price = !empty($row[15])?$row[15]:NULL;
             $inventorySimpleProduct->inventory_sku = $row[12];
             $inventorySimpleProduct->barcode = $row[13];
             $product->inventorySimpleProduct()->save($inventorySimpleProduct);
         }            

        if ($product->variable_product) {
            //add product attributes values
            $color_id = $this->prepareColor($row[10]);
            $size_id = $this->prepareSize($row[11]);

            $inventoryProduct = InventoryProduct::where(['product_id' => $product->pdt_id,
                                                        'size_id' => $size_id,
                                                        'color_id' => $color_id
                                                        ])
                                                        ->first();
            if($inventoryProduct)
            {
                $inventoryProduct->regular_price = $row[14];
                $inventoryProduct->sales_price = !empty($row[15])?$row[15]:NULL;
                $inventoryProduct->inventory_sku = $row[12];
                $inventoryProduct->barcode = $row[13];
                $inventoryProduct->save();
            }else{
                $inventoryProduct = new InventoryProduct();
                $inventoryProduct->product_id = $product->pdt_id;
                $inventoryProduct->size_id = $size_id;
                $inventoryProduct->color_id = $color_id;
                $inventoryProduct->regular_price = $row[14];
                $inventoryProduct->sales_price = !empty($row[15])?$row[15]:NULL;
                $inventoryProduct->inventory_sku = $row[12];
                $inventoryProduct->barcode = $row[13];
                $inventoryProduct->save();
            }
        } 

        return $product;
    }

    /**
    * @param string $status
    *
    * @return int $status
    */
    public function prepareStatus($status)
    {
        if(in_array($status, GeneralStatus::toArray())){
            return ($status == 'Enabled') ? 1 : 0;
        }else{
            return GeneralStatus::Enabled;
        }
    }    

    /**
    * @param string $size_name
    *
    * @return int $size_id
    */
    public function prepareSize($size_name)
    {
        $size_id = Size::where('name', $size_name)->where('status', GeneralStatus::Enabled)->pluck('id')->first();
        if( $size_id ){
            return $size_id;
        }else{
            $size = new Size();
            $size->name = $size_name;
            $size->slug = $this->slugit($size_name);
            $size->status = GeneralStatus::Enabled;
            $size->created_by = Auth::guard('admin')->user()->id;
            $size->save();
            return $size->id;
        }
    }

    /**
    * @param string $color_name
    *
    * @return int $color_id
    */
    public function prepareColor($color_name)
    {
        $color_id = Color::where('name', $color_name)->where('status', GeneralStatus::Enabled)->pluck('id')->first();
        if( $color_id ){
            return $color_id;
        }else{
            $color = new Color();
            $color->name = $color_name;
            $color->slug = $this->slugit($color_name);
            $color->status = GeneralStatus::Enabled;
            $color->created_by = Auth::guard('admin')->user()->id;
            $color->save();
            return $color->id;
        }
    }
    
    /**
    * @param array $category
    *
    * @return int $category_id
    */
    public function prepareCategory($categoryName)
    {
        $category = Category::where('category_name', $categoryName)->where('status', GeneralStatus::Enabled)->pluck('category_id')->first();
        if( $category ){
            return $category;
        }else{
            $category = new Category();
            $category->category_name = $categoryName;
            $category->parent_category_id = 0;
            $category->category_level = 1;
            $category->status = GeneralStatus::Enabled;
            $category->category_slug = $this->slugit($categoryName);
            $category->created_by = Auth::guard('admin')->user()->id;
            $category->save();
            return $category->category_id;
        }
    }
    
    /**
    * @param array $brand
    *
    * @return int $brand_id
    */
    public function prepareBrand($brand_name)
    {
        $brand_id = Brand::where('name', $brand_name)->where('status', GeneralStatus::Enabled)->pluck('id')->first();
        if( $brand_id ){
            return $brand_id;
        }else{
            $brand = new Brand();
            $brand->name = $brand_name;            
            $brand->slug = $this->slugit($brand_name);
            $brand->status = GeneralStatus::Enabled;
            $brand->created_by = Auth::guard('admin')->user()->id;
            $brand->save();
            return $brand->id;
        }
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
     * @return int
     */
    public function startRow(): int
    {
        return 2;
    }
}