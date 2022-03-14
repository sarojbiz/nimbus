function ajax_process_forms(_formData, _url, _beforeSend, _callback) {	
	jQuery.ajax({
		url: _url,
		data: _formData,
		type: 'POST',
		datatype: 'JSON',
		beforeSend: _beforeSend,
		success: _callback,
		error: function(request, error){
			alert('The server encountered an error.');
		}
	});
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});