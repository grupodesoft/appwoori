<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?> 
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->

	<title>404 </title>

	<!-- Google font -->
	<link href="https://fonts.googleapis.com/css?family=Nunito:400,700" rel="stylesheet">

	<!-- Custom stlylesheet -->
	<link type="text/css" rel="stylesheet" href="<?php echo base_url(); ?>/assets/mensaje/css/style.css" /> 

</head>

<body>

	<div id="notfound">
		<div class="notfound">
			<div class="notfound-404"></div>
			<h1><?php echo $heading; ?></h1>
			<h3>Oops! <?php echo $message; ?></h3>
			<!--<p>Sorry but the page you are looking for does not exist, have been removed. name changed or is temporarily unavailable</p>-->
			<a href="javascript:history.back()">Regresar</a>
		</div>
	</div>

</body><!-- This templates was made by Colorlib (https://colorlib.com) -->

</html>
