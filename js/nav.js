var Nav = {
	el: {
		container: $('#navigation'),
		first: $('#navigation #first'),
		next: $('#navigation #next'),
		previous: $('#navigation #previous'),
		last: $('#navigation #last')
	},
	
	hide: function(){
			this.el.container.hide();
	},
	
	hide_show: function(){
		var idx = Map.get_current_idx();
		var count = Map.get_markers_count();
		
		if (idx > 0 && idx <= count) {
			this.el.next.show();
			this.el.previous.show();
			
			this.el.first.show();
			this.el.last.show();
			
		} 
	
		if (idx == count) {
			this.el.next.hide();
			this.el.last.hide();
		}
		
		if (idx == 0) {
			this.el.first.hide();
			this.el.previous.hide();
			
			this.el.next.show();
			this.el.last.show();
			
		}
		
	},
	
	enable: function(){
		Nav.el.first.click(function(){
			Nav.hide_show();
			
			var count = Map.get_markers_count();
			
			if (count > 0) {
				Map.show_placemark(0);
			};

			return false;
		});
		
		Nav.el.previous.click(function(){
			Nav.hide_show();
			
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
			Nav.hide_show();
			
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
			Nav.hide_show();
			
			var count = Map.get_markers_count();
			
			if (count > 0) {
				Map.show_placemark(count);
			};

			return false;
		});
		
		
	}
	
}	