<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/load_cart.css">
</head>
<body>

<?php

require('connection.php');

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
$query = "SELECT * FROM cart";
$result = $mysqli->query($query);
$mysqli->close();


if($result->num_rows){
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		
		echo "<form action='test.php' method='get'>";
			echo "<div class='row'>";
				echo "<input type='text' name='name_product' value='" . $row['name_product'] . "'>";
				echo "<input type='text' name='price' value='" . $row['price'] . "'>";
				echo "<input name='qnt' type='number' value='". $row['quantity'] . "'>";
				echo "<div>". $row['total_price']	."</div>";
				echo "<input type='submit' value='update' name='update'>";
				echo "<input type='submit' value='delete' name='delete'>";
			echo "</div>";
		echo "</form>";
		
	}
}

require('test.php');
$asd = new Total();
echo $subtotal = $asd->subtotal();

?>

<form action="final.php" method="get">
	<input required type="radio" name="radio" value="pickup">pick up
	<input required type="radio" name="radio" value="ups">	ups
	<input type="submit" name="pay" value="pay">
</form>


</body>
</html>