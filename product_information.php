<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/product_data.css">
</head>
<body>

<?php

require('classes.php');
session_start();

$query = "SELECT * FROM products where name = '" . $_SESSION['nameProduct'] . "'";
$product = new Product();
$result = $product->resulset($query);

$product->print_selected_product($result);


$rating = new Rating();
$rating->print_rating();




echo '<a href="search.php">back</a>';
?>



</body>
</html>