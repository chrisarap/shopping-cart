<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="./assets/css/search.css">
</head>
<body>
<?php

require('classes.php');

// load products
$product = new Product();
$product->print_product();

?>
<a href="load_cart.php">my cart</a>

</body>
</html>

