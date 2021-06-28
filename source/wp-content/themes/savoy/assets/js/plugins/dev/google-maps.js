/* Google map */
function initGmap($mapContainer) {
	var data = {
		address: $mapContainer.data('address'),
		mapType: google.maps.MapTypeId.ROADMAP,
		mapStyle: $mapContainer.data('map-style'),
		zoom: $mapContainer.data('zoom'),
        minZoom: $mapContainer.data('min-zoom'),
		zoomControls: $mapContainer.data('zoom-controls'),
		scrollZoom: $mapContainer.data('scroll-zoom'),
		touchDrag: $mapContainer.data('touch-drag'),
		markerIcon: $mapContainer.data('marker-icon')
	},
	
	styles = {
		'clean_flat': [{"elementType":"labels.text","stylers":[{"visibility":"off"}]},{"featureType":"landscape.natural","elementType":"geometry.fill","stylers":[{"color":"#f5f5f2"},{"visibility":"on"}]},{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"transit","stylers":[{"visibility":"off"}]},{"featureType":"poi.attraction","stylers":[{"visibility":"off"}]},{"featureType":"landscape.man_made","elementType":"geometry.fill","stylers":[{"color":"#ffffff"},{"visibility":"on"}]},{"featureType":"poi.business","stylers":[{"visibility":"off"}]},{"featureType":"poi.medical","stylers":[{"visibility":"off"}]},{"featureType":"poi.place_of_worship","stylers":[{"visibility":"off"}]},{"featureType":"poi.school","stylers":[{"visibility":"off"}]},{"featureType":"poi.sports_complex","stylers":[{"visibility":"off"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"color":"#ffffff"},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"visibility":"simplified"},{"color":"#ffffff"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"color":"#ffffff"},{"visibility":"off"}]},{"featureType":"road.highway","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","stylers":[{"color":"#ffffff"}]},{"featureType":"road.local","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.park","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"poi","elementType":"labels.icon","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#71c8d4"}]},{"featureType":"landscape","stylers":[{"color":"#e5e8e7"}]},{"featureType":"poi.park","stylers":[{"color":"#8ba129"}]},{"featureType":"road","stylers":[{"color":"#ffffff"}]},{"featureType":"poi.sports_complex","elementType":"geometry","stylers":[{"color":"#c7c7c7"},{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#a0d3d3"}]},{"featureType":"poi.park","stylers":[{"color":"#91b65d"}]},{"featureType":"poi.park","stylers":[{"gamma":1.51}]},{"featureType":"road.local","stylers":[{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"poi.government","elementType":"geometry","stylers":[{"visibility":"off"}]},{"featureType":"landscape","stylers":[{"visibility":"off"}]},{"featureType":"road","elementType":"labels","stylers":[{"visibility":"off"}]},{"featureType":"road.arterial","elementType":"geometry","stylers":[{"visibility":"simplified"}]},{"featureType":"road.local","stylers":[{"visibility":"simplified"}]},{"featureType":"road"},{"featureType":"road"},{},{"featureType":"road.highway"}],
		
		'grayscale': [{"featureType":"landscape","stylers":[{"saturation":-100},{"lightness":65},{"visibility":"on"}]},{"featureType":"poi","stylers":[{"saturation":-100},{"lightness":51},{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"road.arterial","stylers":[{"saturation":-100},{"lightness":30},{"visibility":"on"}]},{"featureType":"road.local","stylers":[{"saturation":-100},{"lightness":40},{"visibility":"on"}]},{"featureType":"transit","stylers":[{"saturation":-100},{"visibility":"simplified"}]},{"featureType":"administrative.province","stylers":[{"visibility":"off"}]},{"featureType":"water","elementType":"labels","stylers":[{"visibility":"on"},{"lightness":-25},{"saturation":-100}]},{"featureType":"water","elementType":"geometry","stylers":[{"hue":"#ffff00"},{"lightness":-25},{"saturation":-97}]}],
		
		'cooltone_grayscale': [{"featureType":"water","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":-78},{"lightness":67},{"visibility":"simplified"}]},{"featureType":"landscape","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"simplified"}]},{"featureType":"road","elementType":"geometry","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"simplified"}]},{"featureType":"poi","elementType":"all","stylers":[{"hue":"#ffffff"},{"saturation":-100},{"lightness":100},{"visibility":"off"}]},{"featureType":"road.local","elementType":"geometry","stylers":[{"hue":"#e9ebed"},{"saturation":-90},{"lightness":-8},{"visibility":"simplified"}]},{"featureType":"transit","elementType":"all","stylers":[{"hue":"#e9ebed"},{"saturation":10},{"lightness":69},{"visibility":"on"}]},{"featureType":"administrative.locality","elementType":"all","stylers":[{"hue":"#2c2e33"},{"saturation":7},{"lightness":19},{"visibility":"on"}]},{"featureType":"road","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":31},{"visibility":"on"}]},{"featureType":"road.arterial","elementType":"labels","stylers":[{"hue":"#bbc0c4"},{"saturation":-93},{"lightness":-2},{"visibility":"simplified"}]}],
		
		'light_monochrome': [{"stylers":[{"hue":"#ffffff"},{"invert_lightness":false},{"saturation":-100}]}],
		
		'dark_monochrome': [{"stylers":[{"hue":"#222222"},{"invert_lightness":true},{"saturation":-100}]}],
				
		'paper': [{"featureType":"administrative","stylers":[{"visibility":"off"}]},{"featureType":"poi","stylers":[{"visibility":"simplified"}]},{"featureType":"road","stylers":[{"visibility":"simplified"}]},{"featureType":"water","stylers":[{"visibility":"simplified"}]},{"featureType":"transit","stylers":[{"visibility":"simplified"}]},{"featureType":"landscape","stylers":[{"visibility":"simplified"}]},{"featureType":"road.highway","stylers":[{"visibility":"off"}]},{"featureType":"road.local","stylers":[{"visibility":"on"}]},{"featureType":"road.highway","elementType":"geometry","stylers":[{"visibility":"on"}]},{"featureType":"road.arterial","stylers":[{"visibility":"off"}]},{"featureType":"water","stylers":[{"color":"#5f94ff"},{"lightness":26},{"gamma":5.86}]},{},{"featureType":"road.highway","stylers":[{"weight":0.6},{"saturation":-85},{"lightness":61}]},{"featureType":"road"},{},{"featureType":"landscape","stylers":[{"hue":"#0066ff"},{"saturation":74},{"lightness":100}]}],
		
		'countries': [{"featureType":"all","elementType":"all","stylers":[{"visibility":"off"}]},{"featureType": "water","elementType": "all","stylers":[{"visibility":"on"},{"lightness":-100},{"color":"#454545"}]}]}
	
	mapType = $mapContainer.data('map-type'),
	mapStyles = styles[data.mapStyle];
	
	if (mapType == 'roadmap_custom') data.mapType = data.mapStyle;
	else if (mapType == 'satellite') data.mapType = google.maps.MapTypeId.SATELLITE;
    else if (mapType == 'hybrid') data.mapType = google.maps.MapTypeId.HYBRID;
    else if (mapType == 'terrain') data.mapType = google.maps.MapTypeId.TERRAIN;
	
	var geocoder = new google.maps.Geocoder();
	
	geocoder.geocode( { 'address': data.address }, function(results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
			var latLng = results[0].geometry.location,
				mapOptions = {
					minZoom: data.minZoom,
                    zoom: data.zoom,
					center: latLng,
					mapTypeId: data.mapType,
					disableDefaultUI: true,
					//draggable: true,
					draggable: (jQuery('html').hasClass('touch') && data.touchDrag != 1) ? false : true,
					panControl: false,
					zoomControl: data.zoomControls,
					mapTypeControl: false,
					scaleControl: false,
					streetViewControl: false,
					overviewMapControl: false,
					scrollwheel: data.scrollZoom,
					disableDoubleClickZoom: false
				},
				map = new google.maps.Map($mapContainer.get(0), mapOptions),
				styledMapType = new google.maps.StyledMapType(mapStyles, {name: data.mapStyle});
				
			map.mapTypes.set(data.mapStyle, styledMapType);
			
			var marker = new google.maps.Marker({
				animation: google.maps.Animation.DROP,
				icon: data.markerIcon,
				position: latLng,
				map: map
			}),
			to = null;
			
			jQuery(window).resize(function() {
				if (to) clearTimeout(to);
				to = setTimeout(function() { map.setCenter(latLng); }, 200);
			});
		} else {
			console.log('Google Maps: Geocode was not successful for the following reason: ' + status);
		}
	});
};

// Init map
//google.maps.event.addDomListener(window, 'load', initGmap);
jQuery(function() { // Doc ready
	jQuery('.nm-gmap').each(function() { initGmap(jQuery(this)); });
});
