<?php

require('connection.php');

session_start();

// call product data
$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
$query = "SELECT * FROM products WHERE name='" . $_SESSION['name'] ."'";
$result = $mysqli->query($query);
$mysqli->close();

$row = $result->fetch_array(MYSQLI_ASSOC);

$nameProduct = $row['name'];
$priceProduct = $row['price'];
$quantity = $_GET['quantity'];
$totalPrice = $priceProduct * $quantity;

add_to_cart($nameProduct,$priceProduct,$quantity,$totalPrice);

function add_to_cart($nameProduct,$priceProduct,$quantity,$totalPrice){
	// add information to the cart
	require('connection.php');
	$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
	
	$delQuery = "DELETE FROM cart WHERE name_product = '$nameProduct'";
	$query = "INSERT INTO cart (name_product, price, quantity, total_price) 
	values ('$nameProduct','$priceProduct','$quantity','$totalPrice')";
	
	$resDel =  $mysqli->query($delQuery);
	$result = $mysqli->query($query);
	$mysqli->close();
	header("location:search.php");
}
?>