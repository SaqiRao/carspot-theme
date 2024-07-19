    "use strict";
	if(profile_strings.carspot_map_type == 'leafletjs_map')
	{
	 var mymap = L.map('dvMap').setView([profile_strings.default_lat, profile_strings.default_long], 13);
		L.tileLayer('https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png', {
			maxZoom: 18,
			attribution: ''
		}).addTo(mymap);
		var markerz = L.marker([profile_strings.default_lat, profile_strings.default_long],{draggable: true}).addTo(mymap);
		var searchControl 	=	new L.Control.Search({
			url: '//nominatim.openstreetmap.org/search?format=json&q={s}',
			jsonpParam: 'json_callback',
			propertyName: 'display_name',
			propertyLoc: ['lat','lon'],
			marker: markerz,
			autoCollapse: true,
			autoType: true,
			minLength: 2,
		});
		searchControl.on('search:locationfound', function(obj) {
			var lt	=	obj.latlng + '';
			var res = lt.split( "LatLng(" );
			res = res[1].split( ")" );
			res = res[0].split( "," );
			document.getElementById('ad_map_lat').value = res[0];
			document.getElementById('ad_map_long').value = res[1];
		});
		mymap.addControl( searchControl );
		
		markerz.on('dragend', function (e) {
		  document.getElementById('ad_map_lat').value = markerz.getLatLng().lat;
	  document.getElementById('ad_map_long').value = markerz.getLatLng().lng;
	});
	}
