<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>

<?php
require('classes.php');
session_start();

echo $_SESSION['subtotal'];
echo $_SESSION['option'];
echo $_SESSION['shipping'];
echo $_SESSION['total'];

?>


<form action="btn_event.php" method="get">
	<input type="submit" name="payment" value="payment">
</form>

<a href='load_cart.php'>back</a>
</body>
</html>
