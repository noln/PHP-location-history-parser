<?php

$page = <<< HEREDOC
<!doctype html>

<html lang="en">
<head>
	<meta charset="utf-8">

	<title>The HTML5 Herald</title>
	<meta name="description" content="The HTML5 Herald">
	<meta name="author" content="SitePoint">

	<link href='http://fonts.googleapis.com/css?family=Roboto' rel='stylesheet' type='text/css'>
	<link href='http://fonts.googleapis.com/css?family=Roboto+Condensed:400,700' rel='stylesheet' type='text/css'>
	<link rel="stylesheet" href="css/styles.css">

	<!--[if lt IE 9]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
</head>

<body>
	<script src="js/scripts.js"></script>

	<div id="container">

		<div class="whitey">

			<h1>Location History Parser</h1>

			<div class="segger">
				<div>
					To get started, check out the 'Usage' section on main project page on GitHub.
				</div>

				<div>
					<a href="polyline.php">Polyline of all points</a>
				</div>

				<div>
					<a href="markers.php">Markers of (nearly) all points - see the code for what I mean, some are skipped for memory hogging reasons as I developed this with 6 months' worth of data points!...</a>
				</div>

				<div>
					<a href="distances.php">Distance calculation - it sums up the total distance travelled along the path.</a>
				</div>

			</div>

		</div>

	</div>

</body>

</html>
HEREDOC;

echo $page;

?>


