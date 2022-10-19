/**
 *
 * You can write your JS code here, DO NOT touch the default style file
 * because it will make it harder for you to update.
 *
 */

"use strict";

function ajax_process_callbacks(_data, _url, _beforeCb, _successCb) {
    jQuery.ajax({
        url: _url,
        data: _data,
        type: 'POST',
        datatype: 'JSON',
        beforeSend: _beforeCb,
		success: _successCb,
		error: function(request, error){
			alert('The server encountered an error.');
		}
    });
}

jQuery(function($){
    $('.basic-single').select2();
})