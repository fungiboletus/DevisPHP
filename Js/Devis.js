$(document).ready(function() {
	$('#input_type').change(function() {
		var value = $(this).find(':selected').attr('value');
		$.ajax({
		url: window.location.pathname,
		type: "POST",
		data: {cat: value},
		success: function(html){
			$('#input_subtype').html(html);
		}});
	});
});
