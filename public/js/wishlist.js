var mywishlist;
const Wishlist = function() {};
Wishlist.prototype.add = function(_this){
    var _formData = {"productId" : _this.data('productid')},	           
		_url = wishlist_urls.add_item,
		_beforeSend = function(){},
		_callback = function(response){
            if(response.success){
                var _mini_cart = '<li><a href="#" data-productid="{cartid}" class="remove removeFromWishlist" title="Remove this item"><ion-icon name="close-outline"></ion-icon></a><a class="cart-img" href="{item_url}"><img class="default-img" src="{feature_image}" alt="{name}" width="70px"></a><h4><a href="{item_url}">{name}</a></h4></li>';
                for (var key in response.data) {
                    if (response.data.hasOwnProperty(key)) {
                        _mini_cart = _mini_cart.replace(new RegExp('{' + key + '}', 'g'), response.data[key]);
                    }
                }
                if($('#mini-wishlist').length){
                    jQuery('#mini-wishlist').append(_mini_cart);
                }else{
                    var _ulContainer = '<ul class="shopping-list" id="mini-wishlist">'+_mini_cart+'</ul>';
                    jQuery('.wishlistings .wishlist_bottom').before(_ulContainer);
                    jQuery('.wishlistings .noitem').remove();
                    jQuery('.wishlist_bottom').removeClass('hide');
                }
            }
            mywishlist.updateMiniCart(response);
            jQuery("html").stop().animate({scrollTop:0}, 800, 'swing', function() {
                alert(response.message);
            });
        };
		ajax_process_forms(_formData, _url, _beforeSend, _callback);	
		return true;
};
Wishlist.prototype.remove = function(_this){
    var _formData = {"wishid" : _this.data('productid')},	           
		_url = wishlist_urls.remove_item,
		_beforeSend = function(){},
		_callback = function(response){
            if(response.success){
                if(_this.parents('tr').length){
                    _this.parents('tr').remove();
                    if(jQuery('#mini-wishlist').length){
                        jQuery('#mini-wishlist').find('li.'+_this.data('productid')).remove();
                    }
                }else if(_this.parents('li').length){
                    _this.parents('li').remove();
                    if(jQuery('#wishlist_table').length){
                        jQuery('#wishlist_table').find('tr.'+_this.data('productid')).remove();
                    }
                }
                if(jQuery('#mini-wishlist li').length == 0){
                    jQuery('#mini-wishlist').remove();
                    jQuery('.wishlistings .wishlist_bottom').before('<div class="noitem">Wishlist Empty</div>');
                    jQuery('.wishlist_bottom').addClass('hide');
                }
            }
            mywishlist.updateMiniCart(response);
            alert(response.message);
        };
		ajax_process_forms(_formData, _url, _beforeSend, _callback);	
		return true;
};
Wishlist.prototype.updateMiniCart = function(response){
    for (var key in response.data) {
        if (response.data.hasOwnProperty(key)) {
           if(key == 'totalquantity'){
                jQuery('.wishlist_total_qty').html(response.data['totalquantity']);
            }
        }
    }
}
jQuery(function($){
    mywishlist = new Wishlist(); 
    $(document).on('click', '.addToWishlist', function(e){
        e.preventDefault();
        var _this = $(this);
        mywishlist.add(_this);    
    })
    $(document).on('click', '.removeFromWishlist', function(e){
        e.preventDefault();
        if(confirm('Are you sure to remove this product?')){
            var _this = $(this);
            mywishlist.remove(_this);                
        }
    })
})