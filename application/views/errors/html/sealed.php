<?php
defined('BASEPATH') OR exit('No direct script access allowed');
?><!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8">
<title>System Has been Seized</title>
<style type="text/css">

body {
	background-color: #0078c7;
	margin: 20px;
	font: 13px/20px normal Helvetica, Arial, sans-serif;
	color: #fff;
}

a {
	color: #f4f4f4;
	background-color: transparent;
	font-weight: normal;
}

h1 {
	color: #fff;
	background-color: transparent;
	font-size: 30px;
	line-height: 40px;
	font-weight: normal;
	margin: 0 0 14px 0;
	padding: 0px 15px 10px 15px;
	text-shadow : 0 0 12px #000;
}

#container {
	margin: 10px;
	color: #fff;
	text-align: center;
}

h2 {
	color: #BDC3C7;
	text-shadow: 0 0 10px #333;
	font-size: 80px;
	margin: 30px auto;
	margin-bottom: 50px;
}
</style>
<link href="<?php echo base_url('css/font-awesome.min.css'); ?>" rel="stylesheet">
</head>
<body>
	<div id="container">
		<a href="http://skyq.in/" target="_blank"><img src="<?php echo base_url('img/logo_white.png'); ?>" border="0" /></a>
		<h2><i class="fa fa-lock"></i></h2>
		<h1><?php echo $heading; ?></h1>
		<?php echo $message; ?>
	</div>
</body>
</html>