<?php

/*
foreach(){
	
}
*/

//print_r($arr);

// https://maps.google.com/locationhistory/b/0/kml?startTime=1408032336000&endTime=1407974400000

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
	
	$rtn = <<< HEREDOC
new google.maps.LatLng($f_geo_lon, $f_geo_lat),

HEREDOC;

	return $rtn;
}

$i = 0;
foreach($gx_exp as $point){
	
	if ($i != 0){
		$polyline_points .= process_point_string($point);
	}
	
	$i++;
}

	$polyline_points = rtrim(trim($polyline_points), ",");

?>