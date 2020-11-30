<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/final.css">
</head>
<body>

<?php
require('nav_bar.php');
//require('classes.php');
//session_start();

echo "<div class='container'>";
	echo "<div>SUB-TOTAL = $" . $_SESSION['subtotal'] . "</div>";
	echo "<div>SHIPPING = $" . $_SESSION['shipping']  . ".00</div>";
	echo "<div>-------------------------------------</div>";
	echo "<div>TOTAL = $" . $_SESSION['total'] . "</div>";

?>

<form action="btn_event.php" method="get">
	<input class="btn" type="submit" name="payment" value="Pay">
</form>
<?php
echo "</div>";
?>

</body>
</html>
