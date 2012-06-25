$(document).ready(function() {
	var table = $('table.devis_list');
	if (table.tablesorter)
		table.tablesorter({	
			sortList: [[0,0]]
		});
	
	var table = $('table.user_list');
	if (table.tablesorter)
		table.tablesorter({	
			sortList: [[0,0]]
		});

	var gestion_filtres = function() {
		var checkbox = $('#selection_notifs').attr('value');
		console.log(checkbox);

		var url = null;
		if (!checkbox)
		{
			var type = $('#input_type').attr('value');
			var subtype = $('#input_subtype').attr('value');
			var dep = $('#input_dep').attr('value');
			url = $('form[name=selection_categories]').attr('action');
			url = url.replace('-type-', type).replace('-subtype-', subtype).replace('-dep-', dep);
		}
		else
		{
			url = window.location.pathname+'#';
		}

		// Redirection bourrine
		window.location.pathname = url;
	};

	$('#input_type').change(gestion_filtres);
	$('#input_subtype').change(gestion_filtres);
	$('#input_dep').change(gestion_filtres);
	$('#selection_notifs').change(gestion_filtres);
});
