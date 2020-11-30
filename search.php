<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/search.css">
</head>
<body>

<?php
require('nav_bar.php');
require('classes.php');

// load products
$product = new Product();
$product->print_product();
?>
</body>
</html>

