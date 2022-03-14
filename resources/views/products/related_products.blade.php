<section class="related_products section">
    <div class="wrap">
        <!--START #featured-items-->
        <section class="product-area featured-items section">
            <div class="wrap">
                <div class="section_heading">
                    <h2>
                        Related Products
                    </h2>
                </div>
                <!--END .section_heading-->
                <div class="section_entry">

                    <div class="row">

                        @if(is_object($related) && !empty($related))
                            @foreach($related as $rel)

                                <div class="col-lg-2 col-md-4 col-6">
                                    <!-- Start Single Product -->
                                    <div class="single-product">
                                        <div class="product-img">
                                            <a href="{{route('product', $rel->slug)}}">
                                                @php 
                                                $feature_image = (!empty($rel->feature_image) && file_exists('uploads/products/'.$rel->feature_image))?$rel->feature_image:'no-feature-image.png';
                                                @endphp
                                                <img class="default-img" src="{{URL::asset('uploads/products/'.$feature_image)}}" alt="{{$rel->pdt_name}}">
                                                <img class="hover-img" src="{{URL::asset('uploads/products/'.$feature_image)}}" alt="{{$rel->pdt_name}}">
                                                <span class="out-of-stock">Hot</span>
                                            </a>
                                            <div class="button-head">
                                                <div class="product-action">
                                                <a title="Add to Wishlist" href="#" class="addToWishlist" data-productid="{{Crypt::encryptString($rel->mcode)}}">
                                                        <ion-icon name="heart-outline"></ion-icon><span>Add to
                                                            Wishlist</span>
                                                    </a>
                                                </div>
                                                <div class="product-action-2">
                                                    <a title="Add to cart" href="#" class="addToCart" data-productid="{{Crypt::encryptString($rel->mcode)}}">
                                                        <img src="{{asset('images/cart-nav-black.svg')}}" width="14px"> <span>Add</span> 
                                                    </a>        
                                                </div>
                                            </div>
                                        </div>
                                        <div class="product-content">
                                            <h3><a href="{{route('product', $rel->slug)}}">{{$rel->pdt_name}}</a></h3>
                                            <div class="product-price">                                        
                                                {!! $rel->show_price !!}
                                            </div>
                                        </div>
                                    </div>
                                    <!-- End Single Product -->
                                </div>
                            @endforeach
                        @endif

                    </div>

                </div>
                <!--END .section_entry-->
            </div>
        </section>
        <!--END #featured-items-->
    </div>
</section>