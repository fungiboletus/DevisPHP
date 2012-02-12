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

	$('#input_cp').keyup(function() {
		var value = $(this).attr('value');

		if (value.length >= 2) {
			value = parseInt(value.slice(0,2));

			$('#input_dep option').each(function() {
				if (parseInt($(this).attr('value').slice(0,2)) == value) {
					$(this).attr('selected',true);
					return false; // break
				}
			});
		}
	});
});
