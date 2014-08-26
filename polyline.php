<?php

/**
 * This script draws a line of all the points in the dataset provided and plonks it on a Google Map.
 * 
 * There aren't a lot of comments, because it is fairly self-explanitory. If you struggle or spot * any bugs, get in touch!
 *
 * @author noln (Matt Fenlon)
 */

	require_once 'parse_kml_to_js_map_points.php';
	
	$file_temp = file_get_contents("location-history.kml");
	
	$split = explode("<gx:Track>",$file_temp);
	$split = $split[1];
	$split = explode("</gx:Track>",$split);
	$gx_track = trim($split[0]);
	
	$gx_exp = explode("<when>",$gx_track);
	
	$i = 0;
	foreach($gx_exp as $point){
	
		if ($i != 0 && ($i%80==0)){
			$all_points .= process_point_string($point);
		}
	
		$i++;
	}

?>
<!DOCTYPE html>
<html>
  <head>
	<meta name="viewport" content="initial-scale=1.0, user-scalable=no" />
	<style type="text/css">
	  html { height: 100% }
	  body { height: 100%; margin: 0; padding: 0 }
	  #map-canvas { height: 100% }
	</style>
	<script type="text/javascript"
	  src="https://maps.googleapis.com/maps/api/js?sensor=false">
	</script>
	<script type="text/javascript">
	  function initialize() {
		  
		var myLatlng = new google.maps.LatLng(49.261226,-123.113927);	
		  
		var mapOptions = {
		  center: myLatlng,
		  zoom: 2
		};
		var google_map = new google.maps.Map(document.getElementById("map-canvas"),
			mapOptions);
		
		var t = [];
		var x = [];
		var y = [];
		var h = [];
		
		var i = 0;
		for ( item in t ) {
			var m = new google.maps.Marker({
				map:       google_map,
				animation: google.maps.Animation.DROP,
				title:     t[i],
				position:  new google.maps.LatLng(x[i],y[i]),
				html:      h[i]
			});
			
			google.maps.event.addListener(m, 'click', function() {
				info_window.setContent(this.html);
				info_window.open(google_map, this);
			});
			i++;
		}
		
		var flightPlanCoordinates = [
<?php echo $polyline_points; ?>
		];
		
		var flightPath = new google.maps.Polyline({
		  path: flightPlanCoordinates,
		  geodesic: true,
		  strokeColor: '#FF0000',
		  strokeOpacity: 1.0,
		  strokeWeight: 2
		});
		
		flightPath.setMap(google_map);
		
	  }
	  
	  
	  
	  google.maps.event.addDomListener(window, 'load', initialize);
	  
	</script>
  </head>
  <body>
	<div id="map-canvas"/>
  </body>
</html>