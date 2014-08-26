<?php

/**
 * This script uses the Haversine formula to calculate the distance between each point in a .kml file, and adds them up. The total is output to the browser in a spectacularly unexciting manner. It does the job though.
 * 
 * There aren't a lot of comments, because it is fairly self-explanitory. If you struggle or spot * any bugs, get in touch!
 *
 * This post was very helpful, in fact I took the calculation formula from it and modified it a little. Check it out!
* http://www.nmcmahon.co.uk/getting-the-distance-between-two-locations-using-google-maps-api-and-php/
 *
 * @author noln (Matt Fenlon)
 */

$file_temp = file_get_contents("location-history.kml");

// Cuts the head and tail off the file.
$split = explode("<gx:Track>",$file_temp);
$split = $split[1];
$split = explode("</gx:Track>",$split);
$gx_track = trim($split[0]);

// Explodes each data point into an array for iterative processing.
$gx_exp = explode("<when>",$gx_track);

/**
 * Calculates the "great circle" distance between two points.
 * @param array $start is a two-element array of latitude [0] and longitude [1].
 * @param array $finish is another two-element array of latitude [0] and longitude [1].
 * @return float Distance between the two points in metres.
 */	
function Haversine($start, $finish) {

	// Reset the value to '0' in case function is called repeatedlt (it will be).
	$distance_out_metres = 0;

	$theta = $start[1] - $finish[1]; 
	$distance = 
		(sin(deg2rad($start[0])) * 
		sin(deg2rad($finish[0]))) + 
		(cos(deg2rad($start[0])) * 
			cos(deg2rad($finish[0])) * cos(deg2rad($theta))
		); 
	$distance = acos($distance); 
	$distance = rad2deg($distance); 
	$distance = $distance * 60 * 1.1515; 

	$distance_out = round($distance, 2);	// in miles!
	
	if ($distance_out >= 1) {
		$distance_out_metres = $distance_out*1609.34;
	} else {
		$distance_out_metres = 0;	// to get around odd issue of 0 = 0.1 in api
	}
	
//}
	
	return $distance_out_metres;

}

/**
 * Calculates the great-circle distance between two points, with
 * the Haversine formula.
 * @param float $latitudeFrom Latitude of start point in [deg decimal]
 * @param float $longitudeFrom Longitude of start point in [deg decimal]
 * @param float $latitudeTo Latitude of target point in [deg decimal]
 * @param float $longitudeTo Longitude of target point in [deg decimal]
 * @param float $earthRadius Mean earth radius in [m]
 * @return float Distance between points in [m] (same as earthRadius)
 */
function haversineGreatCircleDistance(
  $latitudeFrom, $longitudeFrom, $latitudeTo, $longitudeTo, $earthRadius = 6371000)
{
  // convert from degrees to radians
  $latFrom = deg2rad($latitudeFrom);
  $lonFrom = deg2rad($longitudeFrom);
  $latTo = deg2rad($latitudeTo);
  $lonTo = deg2rad($longitudeTo);

  $latDelta = $latTo - $latFrom;
  $lonDelta = $lonTo - $lonFrom;

  $angle = 2 * asin(sqrt(pow(sin($latDelta / 2), 2) +
	cos($latFrom) * cos($latTo) * pow(sin($lonDelta / 2), 2)));
  return $angle * $earthRadius;
}

$i = 0;
foreach($gx_exp as $point){
	
	if ($i > 0&&($i%1000)){
	//if ($i <= 10){
		
		if(isset($f_geo)){
		
			$f_geo_lat_prev = $f_geo_lat;
			$f_geo_lon_prev = $f_geo_lon;
					
			unset($f_geo_prev);
			$f_geo_prev = $f_geo;
			
		}
		
		// Get time
		$f_tmp = explode("</when>", $point);
		$f_time = $f_tmp[0];
		
		// Get geopoint
		$f_tmp = explode("<gx:coord>",$point);
		$f_tmp = $f_tmp[1];
		$f_tmp = explode("</gx:coord>",$f_tmp);
		$f_geo_dirty = $f_tmp[0] . "<br/>";
		$f_geo_dirty = explode(" ", $f_geo_dirty);
		$f_geo_lat = trim($f_geo_dirty[0]);
		$f_geo_lon = trim($f_geo_dirty[1]);
		
		unset($f_geo);
		$f_geo[]=$f_geo_lat;
		$f_geo[]=$f_geo_lon;
		
		//print_r($f_geo);
		//print_r($f_geo_prev);
		
		if (isset($f_geo_prev)){
		
			//echo Haversine($f_geo_prev, $f_geo)."\n";
			$distance_between_points = haversineGreatCircleDistance($f_geo_prev[1],$f_geo_prev[0],$f_geo[1],$f_geo[0])."\n";
			
			$total_distance_m += $distance_between_points;
			
			
			$output = <<< HEREDOC
<tr><td>$f_geo_prev[0]</td><td>$f_geo_prev[1]</td><td>$f_geo[0]</td><td>$f_geo[1]</td><td><em>$distance_between_points</em></td></tr>\n
HEREDOC;
		
		}	
		
	}
	
	$i++;
}

	echo round(($total_distance_m/1000),0) . " kilometres<br/>";

	$polyline_points = rtrim(trim($polyline_points), ",");

?>