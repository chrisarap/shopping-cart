<?php

require 'test.php';




$myvar = new Total();

$subtotal = $myvar->subtotal();
$shipping = 0.00;

if($_GET['radio'] == 'ups'){
	$shipping = 5.00;
}

$total = $subtotal + $shipping;



echo $subtotal . "<br>";
echo $shipping  . "<br>";
echo $total  . "<br>";

$myvar->update_total($total);


echo '<form action="asd.php" method="get">';
echo '<input type="submit" name="payment" value="payment">';
echo "</form>";


echo "<a href='load_cart.php'>back</a>";

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

</body>
</html>
