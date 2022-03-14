jQuery(function($){
    $('#same_billing_shipping').on('click', function(){
        var _this = $(this);
        $('#billing_detail_form :input').prop('required', false);
        if(_this.is(':checked')){
            $('#billing_detail_form').addClass('hide');
        }else{
            $('#billing_detail_form :input').prop('required', true);
            $('#billing_detail_form').removeClass('hide');
        }
    })
})