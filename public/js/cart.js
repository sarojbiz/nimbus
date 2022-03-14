var mycart;
const Cart = function() {};
Cart.prototype.add = function(_this){
    var _formData = {"productId" : _this.data('productid')},	           
		_url = cart_urls.add_item,
		_beforeSend = function(){},
		_callback = function(response){
            var _mini_cart = '<li><a href="#" data-cartid="{cartid}" class="remove removeFromCart" title="Remove this item"><ion-icon name="close-outline"></ion-icon></a><a class="cart-img" href="{item_url}"><img class="default-img" src="{feature_image}" alt="{cartid}" width="70px"></a><h4><a href="{item_url}">{name}</a></h4><p class="quantity">{quantity}x - {html_format_price}</p></li>';
            for (var key in response.data) {
                if (response.data.hasOwnProperty(key)) {
                    _mini_cart = _mini_cart.replace(new RegExp('{' + key + '}', 'g'), response.data[key]);
                }
            }
            jQuery('#mini-cart').append(_mini_cart);
            mycart.updateMiniCart(response);
            jQuery("html").stop().animate({scrollTop:0}, 800, 'swing', function() {
                alert(response.message);
            });
        };
		ajax_process_forms(_formData, _url, _beforeSend, _callback);	
		return true;
};
Cart.prototype.remove = function(_this){
    var _formData = {"cartId" : _this.data('cartid')},	           
		_url = cart_urls.remove_item,
		_beforeSend = function(){},
		_callback = function(response){
            if(response.success){
                if(_this.parents('tr').length){
                    _this.parents('tr').remove();
                    if(jQuery('#mini-cart').length){
                        jQuery('#mini-cart').find('li.'+_this.data('cartid')).remove();
                    }
                }else if(_this.parents('li').length){
                    _this.parents('li').remove();
                    if(jQuery('#cart_table').length){
                        jQuery('#cart_table').find('tr.'+_this.data('cartid')).remove();
                    }
                }
                mycart.updateMiniCart(response);
            }
            alert(response.message);
        };
		ajax_process_forms(_formData, _url, _beforeSend, _callback);	
		return true;
};
Cart.prototype.updateMiniCart = function(response){
    for (var key in response.data) {
        if (response.data.hasOwnProperty(key)) {
            if(key == 'total'){
                jQuery('.mini_cart_total_amt').html('Rs. ' + response.data['total'].toFixed(2));
            }else if(key == 'totalquantity'){
                jQuery('.mini_cart_total_qty').html(response.data['totalquantity']);
            }
        }
    }
}

jQuery(function($){
    if($('#submit_cart_table').length){
        document.getElementById("submit_cart_table").addEventListener("click", function (e) {
            e.preventDefault();
            document.getElementById("cart_table").submit();
        });
    }
    mycart = new Cart(); 
    $(document).on('click', '.addToCart', function(e){
        e.preventDefault();
        var _this = $(this);
        mycart.add(_this);    
    })
    $(document).on('click', '.removeFromCart', function(e){
        e.preventDefault();
        if(confirm('Are you sure to remove this product?')){
            var _this = $(this);
            mycart.remove(_this);                
        }
    })


})