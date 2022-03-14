<!-- Modal -->
<div class="modal fade" id="reviewModal" tabindex="-1" role="dialog" aria-labelledby="reviewModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="reviewModalLabel">Product Review : {{$product->pdt_name}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
            <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <form name="product_review_form" id="product_review_form" method="post" action="{{route('front.review.save')}}">                    
            <div class="modal-body">                
                    <div class="row">
                        <div class="col mb-2">
                            <small>Your Name and Email address will not be published. Required fields are marked *.</small>   
                            <input type="hidden" name="product_id" value="{{Crypt::encryptString($product->mcode)}}" />                 
                        </div>  
                    </div>    
                    <div class="row">      
                        <div class="col">
                            <div class="form-group">
                                <label for="review_name">Your Name* :</label>
                                <input type="text" name="review_name" class="form-control" id="review_name" aria-describedby="review_name" placeholder="Enter name" required="required">                        
                            </div>
                            <div class="form-group">
                                <label for="review_rating" style="display:block;">Your Rating* :</label>
                                <div class="rate">
                                    <input type="radio" id="star5" name="review_rating" value="5" checked="checked" />
                                    <label for="star5" title="5 star">5 stars</label>
                                    <input type="radio" id="star4" name="review_rating" value="4" />
                                    <label for="star4" title="4 star">4 stars</label>
                                    <input type="radio" id="star3" name="review_rating" value="3" />
                                    <label for="star3" title="3 star">3 stars</label>
                                    <input type="radio" id="star2" name="review_rating" value="2" />
                                    <label for="star2" title="2 star">2 stars</label>
                                    <input type="radio" id="star1" name="review_rating" value="1" />
                                    <label for="star1" title="1 star">1 star</label>
                                </div>                                    
                            </div>
                        </div>
                        <div class="col">
                            <div class="form-group">
                                <label for="review_email">Your Email* :</label>
                                <input type="email" name="review_email" class="form-control" id="review_email" aria-describedby="emaireview_emaillHelp" placeholder="Enter email" required="required">                        
                            </div>                        
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="product_review">Your Review* :</label>
                        <textarea name="product_review" class="form-control" id="product_review" placeholder="Review" rows=6 required="required"></textarea>
                    </div>                                  
            </div>
            <div class="modal-footer">                
                <button type="submit" name="submit_review_form" id="submit_review_form" class="btn btn-primary btn_xs_small">Submit Review</button>
                <button type="button" class="btn btn-secondary btn_xs_small" data-dismiss="modal">cancel</button>
                <img class="loading hide" src="{{asset('/images/loading.gif')}}" />
            </div>                
        </form>
        </div>
    </div>
</div>