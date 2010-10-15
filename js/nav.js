var Nav = {
	el: {
		next: $('#navigation #next'),
		previous: $('#navigation #previous')
	},
	
	hide_show: function(){
		var idx = Map.get_current_idx();
		var count = Map.get_markers_count();
		
		if (idx > 0 && idx <= count) {
			this.el.next.show();
			this.el.previous.show();
		} 
	
		if (idx == count) {
			this.el.next.hide();
		}
		
		if (idx == 0) {
			this.el.previous.hide();
		}
	},
	
	enable: function(){
		Nav.el.previous.click(function(){
			Nav.el.next.show();
			
			var idx = Map.get_current_idx();
			
			if (--idx > 0) {
				Map.show_placemark(idx);
			} else {
				Map.show_placemark(idx);
				$(this).hide();
			}
			
			return false;
		});
		
		Nav.el.next.click(function(){
			Nav.el.previous.show();
			
			var idx = Map.get_current_idx();
			var count = Map.get_markers_count();
			
			if (++idx < count) {
				Map.show_placemark(idx);
			} else {
				Map.show_placemark(idx);
				$(this).hide();
			}	
			
			return false;
		});
	}
	
}	