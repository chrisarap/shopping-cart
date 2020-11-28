<?php

require('classes.php');

// variables from login
$username = $_GET['username'];
$password = $_GET['password'];

// buttons cases
if (isset($_GET['create_user'])) {
	$myVar = new Login($username, $password);
	$myVar->create_new_user();
	header('location: login.php');
}

if (isset($_GET['submit_login'])) {
	$myVar = new Login($username, $password);
	$myVar->check_user();
}

?>