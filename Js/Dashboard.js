$(document).ready(function() {
		var table = $('table.devis_list');
		if (table.tablesorter)
			table.tablesorter({	
				sortList: [[0,0]]
			});
});
