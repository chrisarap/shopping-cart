<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/load_cart.css">
</head>
<body>

<?php

require('classes.php');

// load cart
$cart = new Cart();
$cart->load_cart();

session_start();

// print sub total
$invoice = new Invoice();
echo $invoice->subtotal();

?>

<form action="btn_event.php" method="get">
	<input required type="radio" name="radio" value="pickup">pick up
	<input required type="radio" name="radio" value="ups">	ups
	<input type="submit" name="pay" value="pay">
</form>


</body>
</html>