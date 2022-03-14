<section id="tabs" class="project-tab">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <nav>
                    <div class="nav nav-tabs" id="nav-tab" role="tablist">
                        @if(isset($product->pdt_long_description)) 
                        <a class="nav-item nav-link active" id="nav-description-tab" data-toggle="tab" href="#nav-description" role="tab" aria-controls="nav-description" aria-selected="true"> <strong> Description </strong></a>
                        @endif
                        @if(isset($product->ingredients)) 
                        <a class="nav-item nav-link" id="nav-ingredients-tab" data-toggle="tab" href="#nav-ingredients" role="tab" aria-controls="nav-ingredients" aria-selected="true"> <strong> Ingredients </strong></a>
                        @endif
                        @if(isset($product->how_to_us)) 
                        <a class="nav-item nav-link" id="nav-how_to_us-tab" data-toggle="tab" href="#nav-how_to_us" role="tab" aria-controls="nav-how_to_us" aria-selected="true"> <strong> How To Use </strong></a>
                        @endif
                        <a class="nav-item nav-link" id="nav-review-tab" data-toggle="tab" href="#nav-review" role="tab" aria-controls="nav-review" aria-selected="false"><strong> Review </strong> </a>
                    </div>
                </nav>
                <div class="tab-content" id="nav-tabContent">
                    @if(isset($product->pdt_long_description)) 
                    <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab">
                        <div class="tab-description-wrap">
                            {!! $product->pdt_long_description !!}
                        </div>
                    </div>
                    @endif
                    @if(isset($product->ingredients)) 
                    <div class="tab-pane fade" id="nav-ingredients" role="tabpanel" aria-labelledby="nav-ingredients-tab">
                        <div class="tab-description-wrap">
                            {!! $product->ingredients !!}
                        </div>
                    </div>
                    @endif
                    @if(isset($product->how_to_us)) 
                    <div class="tab-pane fade" id="nav-how_to_us" role="tabpanel" aria-labelledby="nav-how_to_us-tab">
                        <div class="tab-description-wrap">
                            {!! $product->how_to_us !!}
                        </div>
                    </div>
                    @endif
                    <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab">
                        <div class="tab-review-wrap">
                            <p> Customer Review </p>
                            <div class="row"> 
                                <div class="col-md-2">
                                    <div class="star-line">
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star"> </i>
                                        <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                        <i class="fa fa-star-o"> </i>
                                    </div>
                                        <small>  Based on 5 reviews </small>
                                </div>
                                    
                                    <div class="col-md-5">
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="star-line">
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o"> </i>
                                                    <i class="fa fa-star-o"> </i>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                        <span class="sr-only">50% Complete (danger)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"> 50%</div>
                                                </div>
                                            <div class="row">
                                                <div class="col-md-5">
                                                    <div class="star-line">
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o"> </i>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                        <span class="sr-only">50% Complete (danger)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"> 70%</div>
                                                </div>
                                                <div class="row">
                                                <div class="col-md-5">
                                                    <div class="star-line">
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    
                                                    </div> 
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                        <span class="sr-only">50% Complete (danger)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"> 90%</div>
                                                </div>
                                                <div class="row">
                                                <div class="col-md-5">
                                                    <div class="star-line">
                                                    <i class="fa fa-star"> </i>
                                                    <i class="fa fa-star-half-o" aria-hidden="true"></i>
                                                    <i class="fa fa-star-o"> </i>
                                                    <i class="fa fa-star-o"> </i>
                                                    <i class="fa fa-star-o"> </i>
                                                    </div> 
                                                </div>
                                                <div class="col-md-6"> 
                                                    <div class="progress">
                                                        <div class="progress-bar progress-bar-warning" role="progressbar" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" style="width: 50%">
                                                        <span class="sr-only">50% Complete (danger)</span>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="col-md-1"> 10%</div>
                                                </div>
                                    </div>
                                    </div>
                            </div>
                    </div>                           
                </div>
            </div>
        </div>
    </div>
</section>