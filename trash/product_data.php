<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/product_data.css">
</head>
<body>

<?php

require('connection.php');

session_start();

if ($_GET["name"]) {
	$_SESSION['name'] = $_GET["name"];
}

$_SESSION['name'];

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
$query = "SELECT * FROM products where name = '" . $_SESSION['name'] . "'";
$result = $mysqli->query($query);
$mysqli->close();



if($result->num_rows){	
	$row = $result->fetch_array(MYSQLI_ASSOC);

	$img =  $row["images"];

	echo "<div class='container_products'>";
		echo "<form id='data' action='cart.php' method='get'>";
			echo "<img src = \"$img\" class='img_block'>";

			echo "<div class='form_product'>";
				echo "<h2>".$row['name']."</h2>";
				echo "<h2>$".$row['price']."</h2>";
				
				echo "<div class='label_name'>";
					echo "<div>quantity</div>";
					echo "<input type='number' name='quantity' placeholder='quantity' min='0'>";
				echo "</div>";

				echo "<input type='submit' value='add to cart'>";
			echo "</div>";

		echo "</form>";
	echo "</div>";
	
		// rating
		echo "<div class='rating'>";
			echo '<form id="ratingg" action="test.php" method="get">';

				echo '<input form="ratingg" type="text" name="product" value="'. $_SESSION['name'] .'">';
				echo '<input form="ratingg" type="submit" name="1" value="1">';
				echo '<input form="ratingg" type="submit" name="2" value="2">';
				echo '<input form="ratingg" type="submit" name="3" value="3">';
				echo '<input form="ratingg" type="submit" name="4" value="4">';
				echo '<input form="ratingg" type="submit" name="5" value="5">';
			echo '</form>';
		echo "</div>";

}
echo '<a href="search.php">back</a>';
?>



</body>
</html>