<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/final.css">
</head>
<body>

<?php

require ("classes.php");
require ("nav_bar.php");
$query = "select * from users";

$user = new User($query);
$result = $user->resulset($query);
$row = $result->fetch_array(MYSQLI_ASSOC);

echo "<div class=container>";
	echo "<div>Thanks for Shopping @" . $row['username'] ."</div>";
	echo "<div>-------------------------------------</div>";
	echo "<div>Previous Balance = $" . $row['prev_balance'] ."</div>";
	echo "<div>Purchase Cost = $" . $row['count'] ."</div>";
	echo "<div>-------------------------------------</div>";
	echo "<div>New Balance = $" . $row['balance'] ."</div>";
echo "</div>";

$_SESSION['balance'] = $row['balance'];

// clean cart
$query = "delete from cart";
$cart = new Cart();
$cart->resulset($query);

echo "<a href='search.php'>back</a>";
?>
</body>
</html>