<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/load_cart.css">
</head>
<body>

<?php

require('classes.php');
require('nav_bar.php');
echo "<div class='container'>";

	echo "<div  class='loaded_cart'>";
		// load cart
		$cart = new Cart();
		$cart->load_cart();
	echo "</div>";
		//session_start();

	echo "<div class='invoice'>";
		// print sub total
		$invoice = new Invoice();
		echo "<h1> Sub-total = $" . $invoice->subtotal(). "</h1>";
?>

<h2>Shipping</h2>
<form action="btn_event.php" method="get">
	<div>
		<input required type="radio" name="radio" value="pickup">Pick up
		<input required type="radio" name="radio" value="ups">	UPS
	</div>
	<input class="btn" type="submit" name="pay" value="Pay">
</form>

<?php
	// message for exceed balance
	if ($_SESSION['message']) {
		echo "<p>" . $_SESSION['message'] . "</p>";
	}

	echo "</div>";
echo "</div>";
?>

</body>
</html>