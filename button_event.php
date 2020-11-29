<?php
	// import classes.php
	require('classes.php');

	// login.php / log-in button
	if (isset($_POST['log-in'])) 
	{
		$user = new User();
		$user->check_user($_POST['username'], $_POST['password']);
	}	

echo "this " . $_GET['test'] . " men ";
	
?>