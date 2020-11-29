<!DOCTYPE html>
<html>
<head>
	<title>Search</title>
	<link rel="stylesheet" type="text/css" href="./assets/css/search.css">
</head>
<body>

<?php
	// import classes
	require('classes.php');

	// print products
	$product = new Product();
	$product->print_product();
?>


</body>
</html>