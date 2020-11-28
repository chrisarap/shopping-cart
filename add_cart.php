<?php

	require('classes.php');

	session_start();
	$quantity_product = $_GET['order'];

	$user = new Login($_SESSION['username'], $_SESSION['password']);
	$userRow = $user->load_user_data();
	$idCart = $userRow['id_user'];

	$product = new Products($_SESSION['product_name']);
	$result = $product->load_product_data();
	$row = $result->fetch_array(MYSQLI_ASSOC);
	$nameCart = $row['name'];
	$totalCart = $quantity_product / $row['quantity'] *  $row['price'];

	// add query
	$queryCart = "INSERT INTO cart (id_user, name_product, total_price)
		VALUES ('$idCart', '$nameCart', '$totalCart')";

	$delCart= "DELETE FROM cart WHERE name_product = '$nameCart' && id_user = '$idCart'";


	require('connection.php');
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	
	

	if (isset($_GET['add'])) {		
		echo "string";
		$mysqli->query($delCart);
		$mysqli->query($queryCart);
	} 

	if (isset($_GET['delete'])) {	
			$mysqli->query($delCart);
	} 

	header('location: index.php');
?>