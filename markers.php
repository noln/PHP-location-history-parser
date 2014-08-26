<?php

/**
 * This script creates a marker for every 80th data point; a limit I included when dealing with over 90,000 data points...
 * 
 * There aren't a lot of comments, because it is fairly self-explanitory. If you struggle or spot * any bugs, get in touch!
 *
 * @author noln (Matt Fenlon)
 */

	$file_temp = file_get_contents("location-history.kml");
	
	$split = explode("<gx:Track>",$file_temp);
	$split = $split[1];
	$split = explode("</gx:Track>",$split);
	$gx_track = trim($split[0]);
	
	$gx_exp = explode("<when>",$gx_track);
	
	function process_point_string($strin){
	
		// Get time
		$f_tmp = explode("</when>", $strin);
		$f_time = $f_tmp[0];
	
		// Get geopoint
		$f_tmp = explode("<gx:coord>",$strin);
		$f_tmp = $f_tmp[1];
		$f_tmp = explode("</gx:coord>",$f_tmp);
		$f_geo_dirty = $f_tmp[0] . "<br/>";
		$f_geo_dirty = explode(" ", $f_geo_dirty);
		$f_geo_lat = trim($f_geo_dirty[0]);
		$f_geo_lon = trim($f_geo_dirty[1]);
		//$f_point = $t_tmp[]
	
		$blah = <<< HEREDOC
	<div>
		[$f_time] ($f_geo_lat, $f_geo_lon)
	</div>
HEREDOC;

		$rtn = <<< HEREDOC
		t.push('Location Name X');
		x.push($f_geo_lon);
		y.push($f_geo_lat);
		h.push('<p><strong>Location Name 1</strong><br/>Address 1</p>');


HEREDOC;

	return $rtn;

	}
	
	$i = 0;
	foreach($gx_exp as $point){
	
		// Skips the first data point, and then only every 80th point thereafer. Get rid of the modulus expression if you want every point shown.
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
		
<?php echo $all_points; ?>
		
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
		
	  }
	  
	  
	  
	  google.maps.event.addDomListener(window, 'load', initialize);
	</script>
  </head>
  <body>
	<div id="map-canvas"/>
  </body>
</html>