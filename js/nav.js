var Nav = {
	el: {
		first: $('#navigation #first'),
		next: $('#navigation #next'),
		previous: $('#navigation #previous'),
		last: $('#navigation #last')
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
		Nav.el.first.click(function(){
			var count = Map.get_markers_count();
			
			if (count > 0) {
				Map.show_placemark(0);
			};

			return false;
		});
		
		Nav.el.previous.click(function(){
			Nav.el.next.show();
			
			var idx = Map.get_current_idx();
			
			if (--idx > 0) {
				Map.show_placemark(idx);
			} else {
				Map.show_placemark(idx);
				$(this).hide();
			}
			//Panel_aux.hide();
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
			//Panel_aux.hide();
			return false;
		});
		
		Nav.el.last.click(function(){
			var count = Map.get_markers_count();
			
			if (count > 0) {
				Map.show_placemark(count - 1);
			};

			return false;
		});
		
		
	}
	
}	