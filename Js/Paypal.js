$(document).ready(function() {
	var table = $('table.paypal_list');
	if (table.tablesorter)
		table.tablesorter({	
			sortList: [[0,0]]
		});
});
