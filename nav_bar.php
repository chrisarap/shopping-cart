<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/nav_bar.css">
</head>

<?php
	session_start();
	
	require_once('classes.php');
	$cart = new Cart();
	$cart->cart_number_row();

	$user = new User();
	$row = $user->load_user_data();
	
?>

<div class="nav_bar">
	<ul>
		<a href="load_cart.php"><li>My Cart (<?php echo $cart->cart_number_row();?>)</li></a>
		<a href="search.php"><li>Search</li></a>
	</ul>

	<!--
	<form action="btn_event.php" method="get">
		<input type="text" class="bar_text" name="search_bar" placeholder="Search product">
		<input type="submit" class="btn" name="search_btn" value="search">
	</form>
	-->

	<ul>
		<li><?php echo "Welcome @". $_SESSION['username']; ?></li>
		<li><?php echo "$". $row['balance']; ?></li>
		<form method="get" action="btn_event.php"><input class="btn" type="submit" value="Log Out" name="logout"></form>
	</ul>
</div>