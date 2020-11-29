<!DOCTYPE html>
<html>
<head>

	<link rel="stylesheet" type="text/css" href="./assets/css/search.css">
</head>
<body>
<?php

require('connection.php');

$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
$query = "SELECT * FROM products";
$result = $mysqli->query($query);
$mysqli->close();

if($result->num_rows){	
	echo "<div class='container_products'>";
	while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
		$img =  $row["images"];	

		echo "<div class='block_product'>";
		echo "<a href=product_data.php?name=" .$row["name"] . ">";
		echo "<img src = \"$img\" class='img_block'>";
		echo "<p>" . $row["name"] . "</p>";
		echo "<p>$" . $row["price"] . "</p>";
		echo "</a>";
		echo "</div>";
	}
	echo "</div>";
}
?>
<a href="load_cart.php">my cart</a>

</body>
</html>

