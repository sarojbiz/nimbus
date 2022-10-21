<?php

namespace App\Http\Controllers;

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
}