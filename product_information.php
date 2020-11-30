<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/product_information.css">
</head>
<body>

<?php

require('nav_bar.php');
//require('classes.php');
//session_start();

$query = "SELECT * FROM products where name = '" . $_SESSION['nameProduct'] . "'";
$product = new Product();
$result = $product->resulset($query);

$product->print_selected_product($result);

?>

</body>
</html>