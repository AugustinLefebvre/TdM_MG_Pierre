function initMap() 
{
	var paris = {lat:48.85 , lng:2.33};
	var lille = {lat:50.63 , lng:3.05};
	//points intermediaires
	var orleans = {lat:49.00 , lng:2.70};
	var nantes = {lat:47.20 , lng:-1.55}
	//ajouter ici les coord des points a mettre sur la map puis les push dans chkpts
	var chkpts = [];
	
	chkpts.push(
	{location: orleans},
	{location: nantes}
	);

	var map = new google.maps.Map(document.getElementById('map'), 
	{
		center: paris,
		scrollwheel: false,
		zoom: 5

	});

	var directionsDisplay = new google.maps.DirectionsRenderer
	({
		map: map
	});

	// Set destination, origin and travel mode.
	var request = {
		destination: lille,
		origin: paris,
		waypoints: chkpts,
		travelMode: google.maps.TravelMode.DRIVING,
	};

	// Pass the directions request to the directions service.
	var directionsService = new google.maps.DirectionsService();
	directionsService.route(request, function(response, status) {
	if (status == google.maps.DirectionsStatus.OK) {
		// Display the route on the map.
		directionsDisplay.setDirections(response);
		}
	});
}