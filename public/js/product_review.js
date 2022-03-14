jQuery(function($){
    $('#product_review_form').on('submit', function(e){
        e.preventDefault();
        var _form = $(this),
            _btn_conatiner = _form.find('.modal-footer'),
            _btn = _btn_conatiner.find('.btn_xs_small');
			_data = _form.serializeArray(),
			_url = _form.attr('action'),
			_beforeCb = function(){
                _btn.hide();	
				_btn_conatiner.find('.loading').removeClass('hide');
			},
			_successCb = function(result){
				   _btn.show();	
                   _btn_conatiner.find('.loading').addClass('hide');
                   alert(result.message);
				   if(result.response == 'success'){
                        _form[0].reset();
                        $('#reviewModal').modal('toggle');
				   }
			};
            ajax_process_forms(_data, _url, _beforeCb, _successCb);
    })
})