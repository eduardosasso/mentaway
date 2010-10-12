var Util = {
	format_date: function(date) {
		var dt = new Date(date*1000);
		return dt.toLocaleString();
	}		
}	