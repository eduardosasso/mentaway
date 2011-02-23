//Classe que converte latitude e longitude em pais, estado, cidade. Client Side para bular o rate limit de 2500 do gmap.
var Geo = {
	geocoder: new google.maps.Geocoder(),
	
	update_placemarks: function(){
		//recupera checkins que não tem pais, estado, cidade
		//get_db_view("placemark", "reverse_geo", "", function(data){
			get_db_view("placemark", "reverse_geo", "", function(data){
			idx = 0;
			for (var start = 1; start <= data.total_rows; start++) {
				//espera 1seg a cada iteracao para não receber OVER_QUERY_LIMIT do gmap
				_.delay(function(){
					i_ = idx++;
				
					lat_ = data.rows[i_].value.lat;
					long_ = data.rows[i_].value.long;
					id_ = data.rows[i_].id;
					
					Geo.reverse(id_, lat_, long_);
					
				}, 1000 * start);
			}
		});
	},
	
	reverse: function(id_, lat_, long_) {
		latlng_ = new google.maps.LatLng(
			parseFloat(lat_),
			parseFloat(long_)
		);
		
		this.geocoder.geocode({'latLng': latlng_ }, function(results_, status_){
			if (status_ == google.maps.GeocoderStatus.OK) {
				geo_ = results_[0];
				address_ = Geo.get_location_names(geo_);			
				Geo.save_address(id_, address_);
			}
		});
	},
	
	save_address: function(id_, address_){
		args_ = {
			docid: id_, 
			country: address_.country,
			state: address_.state,
			city: address_.city,
		}

		$.post('/facebook/ajax/save_geo.php', args_);
	},
	
	get_location_names: function(geo_){
		$.each(geo_.address_components, function(index, val) {
			COUNTRY_ = 'country';
			STATE_ = 'administrative_area_level_1';
			CITY_ = 'locality';

			type_ = val.types[0];
			switch(type_) {
			case COUNTRY_:
			  country_ = val.long_name;
			  break;
			case STATE_:
				state_ = val.long_name;
			  break;
			case CITY_:
				city_ = val.long_name;
				break;
			}	
		});
		
		var address_ = {
			country: country_,
			state: state_,
			city: city_
		}
		
		return address_;		
	}
			
}