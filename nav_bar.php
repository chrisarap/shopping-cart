<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/nav_bar.css">
</head>

<?php
	session_start();
?>

<div class="nav_bar">
	<ul>
		<a href="load_cart.php"><li>My Cart</li></a>
		<a href="search.php"><li>Search</li></a>
	</ul>

	<form>
		<input type="text" class="bar_text" name="search_bar" placeholder="Search product">
		<input type="submit" class="btn" name="search_btn" value="search">
	</form>

	<ul>
		<li><?php echo "Welcome @". $_SESSION['username']; ?></li>
		<li><?php echo "$". $_SESSION['balance']; ?></li>
		<a href=""><li>Log Out</li></a>
	</ul>
</div>