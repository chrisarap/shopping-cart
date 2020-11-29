<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/load_cart.css">
</head>
<body>

<?php

require('classes.php');

$cart = new Cart();
$cart->load_cart();



// total mount

//$invoice = new Invoice();
//echo $invoice->subtotal();

?>

<form action="final.php" method="get">
	<input required type="radio" name="radio" value="pickup">pick up
	<input required type="radio" name="radio" value="ups">	ups
	<input type="submit" name="pay" value="pay">
</form>


</body>
</html>