<?php
require('classes.php');

// sign up button
if (isset($_GET['signup'])) {
	$user = new User();
	$user->create_new_user($_GET['username'], $_GET['password']);
	header('location: search.php');
}

// log in button
if (isset($_GET['login'])) {	
	$user = new User();
	$user->check_user($_GET['username'], $_GET['password']);
}

// see button
if (isset($_GET['see_product'])) {	
	echo $_GET['productName'];
	session_start();
	$_SESSION['nameProduct'] = $_GET['productName'];
	header('location: product_information.php');
}

?>