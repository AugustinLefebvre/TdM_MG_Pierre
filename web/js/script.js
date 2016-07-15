// function initMap() 
// {
// 	var depart = {lat:48.85 , lng:2.33};
// 	var arrivee = {lat:50.63 , lng:3.05};
// 	//points intermediaires
// 	var point1 = {lat:24.940118 , lng:76.628300};
// 	var point2 = {lat:27.374368 , lng:86.245533};
// 	var point3 = {lat:26.180418 , lng:94.003167};
// 	var point4 = {lat:20.965811 , lng:98.745324};
// 	var point5 = {lat:19.833449 , lng:100.223097};
// 	var point6 = {lat:15.896061 , lng:102.401830};
// 	var point7 = {lat:13.390615 , lng:99.008552};
// 	var point8 = {lat:8.345122 , lng:99.240829};
// 	//ajouter ici les coord des points a mettre sur la map puis les push dans chkpts
// 	var chkpts = [];
	
// 	chkpts.push(
// 	{location: point1},
// 	{location: point2},
// 	{location: point3},
// 	{location: point4},
// 	{location: point5},
// 	{location: point6},
// 	{location: point7},
// 	{location: point8}
// 	);

// 	var map = new google.maps.Map(document.getElementById('map'), 
// 	{
// 		center: depart,
// 		scrollwheel: false,
// 		zoom: 5

// 	});

// 	var directionsDisplay = new google.maps.DirectionsRenderer
// 	({
// 		map: map
// 	});

// 	// Set destination, origin and travel mode.
// 	var request = {
// 		destination: arrivee,
// 		origin: depart,
// 		waypoints: chkpts,
// 		travelMode: google.maps.TravelMode.WALKING,
// 	};

// 	// Pass the directions request to the directions service.
// 	var directionsService = new google.maps.DirectionsService();
// 	directionsService.route(request, function(response, status) {
// 	if (status == google.maps.DirectionsStatus.OK) {
// 		// Display the route on the map.
// 		directionsDisplay.setDirections(response);
// 		}
// 	});
// }

function initMap()
	{
		map = new google.maps.Map(document.getElementById('map'), {
	  		center: {lat:48.85 , lng:2.33},
	  		scrollwheel: false,
	  		zoom: 4,
	  		mapTypeId: google.maps.MapTypeId.TERRAIN,
		});
		var point1 = new google.maps.LatLng(48.85 , 2.33);
		var point2 = new google.maps.LatLng(48.85 , 8.33);
		
		var points = [];
		
		points.push(
			point1,
			point2

			);
		var marker0 = new google.maps.Marker({
	    	position: points[0],
	    	title: 'départ',
	    	animation: google.maps.Animation.DROP,
	  	});

		var marker1 = new google.maps.Marker({
	    	position: points[1],
	    	title: 'deuxieme point',
	    	animation: google.maps.Animation.DROP,
	  	});

		marker0.setMap(map);
		marker1.setMap(map);
	}