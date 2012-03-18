$(document).ready(function() {
	var table = $('table.user_list');
	if (table.tablesorter)
		table.tablesorter({	
			sortList: [[0,0]]
		});
});
