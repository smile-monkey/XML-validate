var file_data = new FormData();
jQuery(document).ready(function($) {
	$('.validation_btn').on('click', function(){
		var apiUrl = ajax_obj.ajax_url + "?action=validation_xml";
		$.ajax({
			url: apiUrl,
			type: "POST",
			data: file_data,
		    headers: {
		        'Content-Type': undefined
		     },
        	processData: false,
      		contentType: false,
			success: function(response){
				//file_data = '';
				$('.validation_result').html(response);
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				//file_data = '';
				
			}
		});
	});
});

function select_file(files) {
	var filename = files[0].name;
	var extension = filename.split('.').pop();
	// if (extension != 'xml' || extension != 'XML'){
	// 	return false;
	// }
	jQuery('.browse-label').html(filename);
  	file_data.append("xml_file", files[0]);
}

function clear_file() {
	file_data = new FormData();
	jQuery('.browse-label').html('');
	jQuery('.validation_result').html('');
}
