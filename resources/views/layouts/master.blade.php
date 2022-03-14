<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8" />
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Home') - Misumi Online</title>
    <link href="https://fonts.googleapis.com/css2?family=Open+Sans:ital,wght@0,400;0,700;0,800;1,400&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css"
        integrity="sha384-9aIt2nRpC12Uk9gS9baDl411NQApFmC26EwAOH8WgZl5MYYxFfc+NcPb1dKGj7Sk" crossorigin="anonymous">

    <link href="{{asset('css/main.css')}}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="{{asset('css/owl.carousel.min.css')}}">
    <link rel="stylesheet" href="{{asset('css/niceselect.css')}}">
    <link rel="stylesheet" href="{{asset('css/slicknav.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('css/slick.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/custom.css')}}" />
    <link rel="stylesheet" type="text/css" href="{{asset('css/overwrite.css')}}" />

    <!--[if lt IE 9]>  <script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
    <![endif]-->
    @yield('stylesheets')
    <script>
        (function() {
            var _siteUrl = '{{URL::to('/')}}';
            window.cart_urls = {
                add_item: "{{ route('add_item') }}",
                remove_item: "{{ route('remove_item') }}",
            };
            window.wishlist_urls = {
                add_item: "{{ route('front.wishlist.add') }}",
                remove_item: "{{ route('front.wishlist.remove') }}",
            };
        })();   
    </script>      
</head>

<body>
    <!--START #header-->
    <header class="header clearfix" id="header">
        <!--START #header_main-->
        <div id="header_main" class="header_main">
            <div class="wrap">
                <div class="row">
                    <div class="col-lg-3 col-md-12 col-12">
                        <div class="mobile_nav"></div>
                        <!-- Logo -->
                        <div class="header-logo">
                            <a href="{{URL::to('/')}}"><img src="{{asset('images/logo-header.png')}}" alt="logo" class="img-logo"></a>
                        </div>
                        <!--/ End Logo -->
                        <!-- Search Form -->
                        <div class="search-top">
                            <div class="top-search"><a href="#0">
                                    <ion-icon name="search-outline"></ion-icon>
                                </a></div>
                            <!-- Search Form -->
                            <div class="search-top">
                                <form class="search-form" autocomplete="off" name="product_search" method="get" action="{{route('search')}}">
                                    <input name="term" class="typeahead" value="<?php echo (isset($_GET['term']) && !empty($_GET['term']))?$_GET['term']:'';?>" placeholder="Search Products Here....." type="search">
                                    <button value="search" type="submit">
                                        <ion-icon name="search-outline"></ion-icon>
                                    </button>
                                </form>
                            </div>
                            <!--/ End Search Form -->
                        </div>
                        <!--/ End Search Form -->
                    </div>

                    <div class="col-lg-5 col-md-12 col-12">
                        <div class="input-group my-3">                        
                            <input type="search" class="form-control typeahead" name="term" class="typeahead" id="inlineFormInputGroupUsername2" value="<?php echo (isset($_GET['term']) && !empty($_GET['term']))?$_GET['term']:'';?>" placeholder="Search Products Here.....">
                            <div class="input-group-prepend" id="triggerSearch">
                                <div class="btn btn-search">
                                    <ion-icon name="search-outline"></ion-icon>
                                </div>
                            </div>                                                            
                        </div>
                    </div>

                    <div class="col-lg-4 col-md-12 col-12">
                        <div class="right-bar">
                            <!-- Search Form -->
                            @if (Route::has('user.login'))
                                <div class="sinlge-bar">                                    
                                    @auth
                                        Welcome, 
                                        <a href="{{ action('Dashboard\DashboardController@index') }}" title="Go To Dashboard">{{ucfirst(Auth::user()->first_name)}}</a>
                                        <a href="{{ route('user.logout') }}" title="Log Out">Logout</a>
                                    @else
                                    <a href="{{route('user.login')}}" class="single-icon">
                                        <img src="{{asset('images/user-nav.svg')}}" width="25px">
                                        <span class="icon_title">Login</span>
                                    </a>
                                    @endauth
                                </div>
                            @endif
                            <div class="sinlge-bar wishlist">
                                <a id="wishlist_link" href="#" class="single-icon">
                                    <ion-icon name="heart-outline"></ion-icon>
                                    <span class="total-count wishlist_total_qty">{{$wishlistTotalQty}}</span>
                                    <span class="icon_title">Wishlist</span>
                                </a>
                                @php
                                $mcodes = app('wishlist')->getContent()->pluck('id')->all();
                                $products = App\Product::whereIn('mcode', $mcodes)->get();
                                @endphp
                                <div class="wishlistings">                                    
                                    @if($products->isNotEmpty())
                                        <ul class="shopping-list" id="mini-wishlist">
                                            @foreach($products as $product)                                            
                                            <li class="{{$product->mcode}}">
                                                <a href="#" data-productid="{{$product->mcode}}" class="remove removeFromWishlist" title="Remove this item">
                                                    <ion-icon name="close-outline"></ion-icon>
                                                </a>
                                                <a class="cart-img" href="{{route('product', $product->slug)}}">
                                                    <img class="default-img" src="{{ $product->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $product->feature_image]) : "" }}" alt="{{$product->pdt_name}}" width="70px">
                                                </a><h4>
                                                <a href="{{route('product', $product->slug)}}">{{$product->pdt_name}}</a></h4>
                                            </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <div class="noitem">Wishlist Empty</div>
                                    @endif
                                    <div class="wishlist_bottom @if($products->isNotEmpty()) show @else hide @endif">
                                        <a href="{{route('front.wishlist.index')}}">View All</a>
                                    </div>
                                </div>
                            </div>
                            <div class="sinlge-bar shopping">
                                <a id="cart_menu" href="#" class="single-icon">
                                    <img src="{{asset('images/cart-nav-black.svg')}}" width="25px">
                                    <span class="total-count mini_cart_total_qty">{{$cartTotalQuantity}}</span></a>
                                <!-- Shopping Item -->
                                <div class="shopping-item">
                                    <div class="dropdown-cart-header">
                                        <span class="mini_cart_total_qty">{{$cartTotalQuantity}}</span><span> Items</span>
                                        <a href="{{route('cart')}}">View Cart</a>
                                    </div>
                                    <ul class="shopping-list" id="mini-cart">                                    
                                        @if(is_object($cartCollection) && !empty($cartCollection))
                                            @foreach($cartCollection as $item)
                                                <li class="{{$item->id}}">
                                                    <a href="#" data-cartid="{{$item->id}}" class="remove removeFromCart" title="Remove this item">
                                                        <ion-icon name="close-outline"></ion-icon>
                                                    </a>
                                                    <a class="cart-img" href="{{route('product', $item->associatedModel->slug)}}">
                                                        <img class="default-img" src="{{ $item->associatedModel->feature_image ? action('UploadController@getFile', ['assetType' => 'product_thumb', 'file_path' => $item->associatedModel->feature_image]) : "" }}" alt="{{$item->name}}" width="70px">                                                        
                                                    </a>
                                                    <h4><a href="{{route('product', $item->associatedModel->slug)}}">{{$item->name}}</a> </h4>
                                                    <p class="quantity">@if($item->attributes->size_name)
                                                        Size : {{$item->attributes->size_name}}
                                                        @endif
                                                        @if($item->attributes->color_name)
                                                        , Color : {{$item->attributes->color_name}}
                                                        @endif
                                                    </p>    
                                                    <p class="quantity">{{$item->quantity}}x - {!! $item->attributes->html_format_price !!}</p>
                                                </li>
                                            @endforeach
                                        @endif
                                    </ul>
                                    <div class="bottom">
                                        <div class="total">
                                            <span>Total</span>
                                            <span class="total-amount mini_cart_total_amt">Rs. {{number_format($cartTotal, 2)}}</span>
                                        </div>
                                        <a href="{{route('checkout')}}" class="btn animate">Checkout</a>
                                    </div>
                                </div>
                                <!--/ End Shopping Item -->
                            </div>
                        </div>
                    </div>
                </div>


            </div>
        </div>
        <!--END #header_main-->

        <!--START #header_bottom-->
        <div id="header_bottom" class="header_bottom">
            <div class="wrap">
                <div class="row">
                    <div class="col-lg-12 col-xs-12 col-12 header_links text-center">
                        <nav class="navbar navbar-expand-md navbar-light">                            
                            <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarText" aria-controls="navbarText" aria-expanded="false" aria-label="Toggle navigation">
                            <span class="navbar-toggler-icon"></span>
                            </button>
                            <div class="collapse navbar-collapse" id="navbarText">
                                <ul class="navbar-nav mx-auto">
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ route('front') }}">Home <span class="sr-only">(current)</span></a>
                                    </li>
                                    @if(is_object($categories) && !empty($categories))
                                        @foreach($categories as $category)
                                            @if( $category->childrenRecursive->IsNotEmpty() ) 
                                            <li class="nav-item dropdown">
                                                <a class="nav-link dropdown-toggle" href="{{route('category.show', $category->category_slug)}}" id="navbarDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                    {{$category->category_name}}
                                                </a>
                                                <div class="dropdown-menu dropdown-submenu" aria-labelledby="navbarDropdown">
                                                    @foreach($category->childrenRecursive as $firstCategory)
                                                        <a class="dropdown-item" href="{{route('category.show', $firstCategory->category_slug)}}">{{$firstCategory->category_name}}</a>
                                                        @if( $firstCategory->childrenRecursive->IsNotEmpty() ) 
                                                        <ul class="dropdown-menu">
                                                            @foreach($firstCategory->childrenRecursive as $secCategory)
                                                                <li class="nav-item">
                                                                    <a class="nav-link" href="{{route('category.show', $secCategory->category_slug)}}">{{$secCategory->category_name}}</a>
                                                                </li>                                                                
                                                            @endforeach
                                                        </ul> 
                                                        @endif
                                                    @endforeach
                                                </div>
                                            </li>
                                            @else 
                                            <li class="nav-item">
                                                <a class="nav-link" href="{{route('category.show', $category->category_slug)}}">{{$category->category_name}}</a>
                                            </li>   
                                            @endif
                                        @endforeach
                                    @endif                                    
                                </ul>
                            </div>    
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <!--END #header_bottom-->
    </header>
    <!--END #header-->

    @yield('content')    
<!--START #footer-->
<footer id="footer" class="footer sec">
        <div class="wrap">
            <div class="row">
                <div class="footer_menu_item  col-lg-3 col-md-3 col-12">
                    <div class="footer_menu_item_title">
                        <h4>Customer Care
                        </h4>
                    </div>
                    <!--.footer_menu_item_title ends-->
                    <div class="footer_menu_item_entry">
                        <ul>
                            <li>
                                <a href="#">My Account</a>
                            </li>
                            <li>
                                <a href="#">Track your Order</a>
                            </li>
                            <li>
                                <a href="#">Customer Service</a>
                            </li>
                            <li>
                                <a href="#">Returns/Exchange</a>
                            </li>
                            <li>
                                <a href="#">FAQs</a>
                            </li>
                            <li>
                                <a href="#">Product Support</a>
                            </li>
                        </ul>
                    </div>
                    <!--.footer_menu_item_entry ends-->
                </div>
                <!--.footer_menu_item ends-->

                <div class="footer_menu_item  col-lg-3 col-md-3 col-12">
                    <div class="footer_menu_item_title">
                        <h4>Company</h4>
                    </div>
                    <!--.footer_menu_item_title ends-->
                    <div class="footer_menu_item_entry">
                        <ul>
                            <li>
                                <a href="#">About</a>
                            </li>
                            <li>
                                <a href="#">Contact</a>
                            </li>
                            <li>
                                <a href="#">Wishlist</a>
                            </li>
                            <li>
                                <a href="#">Compare</a>
                            </li>
                            <li>
                                <a href="#">FAQ</a>
                            </li>
                            <li>
                                <a href="#">Store Directory</a>
                            </li>
                        </ul>
                    </div>
                    <!--.footer_menu_item_entry ends-->
                </div>
                <!--.footer_menu_item ends-->

                <div class="footer_menu_item col-lg-3 col-md-3 col-12">
                    <div class="footer_menu_item_title">
                        <h4>Find It Fast
                        </h4>
                    </div>
                    <!--.footer_menu_item_title ends-->
                    <div class="footer_menu_item_entry">
                        <ul>
                            <li>
                                <a href="">Grocery</a>
                            </li>
                            <li>
                                <a href="">Kitchenware</a>
                            </li>
                            <li>
                                <a href="">Sports</a>
                            </li>
                            <li>
                                <a href="">Gadgets</a>
                            </li>
                            <li>
                                <a href="">Toys</a>
                            </li>
                        </ul>
                    </div>
                    <!--.footer_menu_item_entry ends-->
                </div>

                <!--.footer_menu_item ends-->
                    <div class="footer_intro col-lg-3 col-md-3 col-12"> 
                   
                      <div class="footer_menu_item_title">
                        <h4>Connect with us
                        </h4>
                    </div>
                    <!--.footer_menu_item_entry ends-->

                   <div class="footer_social">
                        <div class="default-social">

                            <ul>
                                <li class="">
                                    <a class="facebook" href="#">
                                        <ion-icon name="logo-facebook"></ion-icon>
                                         Facebook
                                    </a>
                                </li>
                                <li class="">
                                    <a class="twitter" href="#">
                                        <ion-icon name="logo-twitter"></ion-icon>
                                        Twitter
                                    </a>
                                </li>
                                <li class="">
                                    <a class="instagram" href="#">
                                        <ion-icon name="logo-instagram"></ion-icon>
                                        Instagram
                                    </a>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
            <div class="footer_copy text-center">
                <p>
                    copyright &copy; 2020 Misumi Cosmetics.
                </p>

            </div>

        </div>
    </footer>
    <!--END #footer-->
    

    <!-- Bootstrap Bundle -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"
        integrity="sha256-9/aliU8dGd2tb6OSsuzixeV4y/faTqgFtohetphbbj0=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo"
        crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/js/bootstrap.min.js"
        integrity="sha384-OgVRvuATP1z7JjHLkuOU7Xw704+h835Lr+6QL9UvYjZE3Ipu6Tp75j7Bh/kR0JKI"
        crossorigin="anonymous"></script>
    <!-- Bootstrap Bundle ends -->

    <!-- ionicons js-->
    <script src="https://unpkg.com/ionicons@5.0.0/dist/ionicons.js"></script>
    <script src="{{asset('js/slicknav.min.js')}}"></script>
    <script src="{{asset('js/owl.carousel.min.js')}}"></script>
    <script src="{{asset('js/nicesellect.js')}}"></script>
    <script type="text/javascript" src="{{asset('js/slick.min.js')}}"></script>
    <script src="{{asset('js/custom.js')}}"></script>
    <script src="{{asset('js/core.js')}}"></script>
    <script src="{{asset('js/cart.js')}}"></script>
    <script src="{{asset('js/wishlist.js')}}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-3-typeahead/4.0.1/bootstrap3-typeahead.min.js"></script>
    <script type="text/javascript">
    var path = "{{ route('autocomplete') }}";
    jQuery('input.typeahead').typeahead({
        source:  function (query, process) {
        return $.get(path, { query: query }, function (data) {
                return process(data);
            });
        }
    });
    jQuery(function($){
        $('#triggerSearch').on('click', function(e){
            e.preventDefault();
            var _term = $('#inlineFormInputGroupUsername2').val();
            if( _term.length !== 0) {
                var _field = '<input type="hidden" name="term" value="'+_term+'"/>';
                $('<form method="get" action="{{route('search')}}">'+_field+'</form>').appendTo('body').submit();    
            }
        })
    })
    </script>
    @yield('scripts')
</body>
</html>