<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class UploadController extends Controller
{
    /**
     * Get the file
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function getFile($assetType, $filePath)
    {
		switch($assetType){
			case 'category_thumb':
			$directoryPath = 'uploads/categories/thumb/';
			break;
			case 'category_large':
			$directoryPath = 'uploads/categories/';
			break;
			case 'brand_thumb':
			$directoryPath = 'uploads/brands/thumb/';
			break;
			case 'brand_large':
			$directoryPath = 'uploads/brands/';
			break;		
			case 'product_thumb':
			$directoryPath = 'uploads/products/thumb/';
			break;
			case 'product_large':
			$directoryPath = 'uploads/products/';
			break;
			case 'banner_thumb':
			$directoryPath = 'uploads/banners/thumb/';
			break;
			case 'banner_large':
			$directoryPath = 'uploads/banners/';
			break;		
			case 'page_thumb':
			$directoryPath = 'uploads/pages/thumb/';
			break;
			case 'page_large':
			$directoryPath = 'uploads/pages/';
			break;
			case 'page_banner':
			$directoryPath = 'uploads/pages/banners/';
			break;

		}
        $fullPath = public_path($directoryPath . $filePath);

        if (File::exists($fullPath)) {
            return response()->file($fullPath);
        } else {
            return response()->file(public_path('uploads/no-image.png'));
        }
    }
    
    /**
     * Get the file
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function removeAsset($image)
	{
		$path = public_path('uploads/items/');
		$thumb = public_path('uploads/items/thumb/');
		$imagePath = $path . $image;
		$thumbPath = $thumb . $image;
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
     * upload category assets
     *
     * @param  string  $filePath
     * @return \Illuminate\Http\Response
     */
    public function uploadCategoryAsset($data, REQUEST $request)
	{        
        $resize = ['full' => array(800, null), 'thumb' => array(640, null)];
        $name = 'category_image';
		$directory = public_path('uploads/categories/');
		$thumbdirectory = public_path('uploads/categories/thumb/');
        
        $filename = $this->uploadAsset($request, $name, $resize, $data, $directory, $thumbdirectory);

		return $filename;		
	}
}