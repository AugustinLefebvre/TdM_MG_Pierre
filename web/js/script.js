function initMap()
{
	var markersarray=[];
	var labels = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ123456789';
	var labelIndex = 0;
	map = new google.maps.Map(document.getElementById('map'), {
  		center: {lat:48.85 , lng:2.33},
  		scrollwheel: false,
  		zoom: 2,
  		mapTypeId: google.maps.MapTypeId.TERRAIN,
	});
	

	for (i = 0 ; i < pointstab.length ; i++ )
		{
			var point = {lat: pointstab[i][0], lng: pointstab[i][1]};
			var marker = new google.maps.Marker({
			    position: point,
			    map: map,
			    label: labels[labelIndex++ % labels.length],
			    title: pointstab[i][2]
			});
			markersarray.push(point);
		}

	marker.setMap(map);
	var tripPath = new google.maps.Polyline({
		path: markersarray,
		geodesic: true,
		strokeColor: '#008000',
		strokeOpacity: 0.9,
		strokeWeight: 3
	});

	tripPath.setMap(map);
}