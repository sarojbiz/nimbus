<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Brand;
use App\Banner;
use App\Product;
use Cart;

class HomeController extends FrontController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $title = 'Home';
        $brands = Brand::where('status', 1)->get();
        $banners = Banner::where('status', 1)->get();
        $featureds = Product::where(array('product_status'=> 1))->inRandomOrder()->limit(10)->get();
        $sellers = Product::where(array('product_status'=> 1))->inRandomOrder()->limit(10)->get();	
        $bests = Product::where(array('product_status'=> 1))->inRandomOrder()->limit(10)->get();	        
        
        return view('home', compact('title'))
            ->withbrands($brands)     
            ->withbanners($banners) 
            ->withfeatureds($featureds)
            ->withsellers($sellers)
            ->withbests($bests);
    }
}