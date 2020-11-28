<!DOCTYPE html>
<html>
<head>
</head>
<body>
<?php
	// load the user data	
	require('classes.php');

	session_start();

	$user = new Login($_SESSION['username'], $_SESSION['password']);
	$userRow = $user->load_user_data();

	echo "<h1>welcome @" . $_SESSION['username']. "</h1>";
	echo "<h2>your balance: $" . $userRow['balance'] . "</h2>";

	// send to login page if you enter from other navegator
	if (!isset($_SESSION['username'])) {
		header('location: login.php');
	}
?>

<form method="get">
	<input name="name_product">
	<input type="submit" name="search" value="search">
</form>


<?php

	// check search button
	if (isset($_GET['search'])) {
		$_SESSION['product_name'] = $_GET['name_product'];

		$selectedProduct = new Products($_GET['name_product']);
		$result = $selectedProduct->load_product_data();
		
		// search
		if ($result->num_rows) {
			$rowProduct = $result->fetch_array(MYSQLI_ASSOC);

			echo "<form action='add_cart.php' method='get'>";
			echo $rowProduct['quantity'] . " | " . 
				$rowProduct['name'] . " | " . 
				$rowProduct['price'] . " | " . 
				"<input name='order'>" ;
			echo "<input name='add' type='submit' value='add/edit'>";
			echo "<input name='delete' type='submit' value='del'>";
			echo "</form>";
			
		}		
	}
?>

<form method="get">
	<select name='shipping' required>
		<option value="">select shipping</option>
		<option value="pickup">pick up</option>
		<option value="ups">ups</option>
	</select>
	<input type="submit" name="pay" value="pay">
</form>


<?php
	// print my cart
	$myCart = new Cart();
	$myCart->sum_semitotal($userRow['id_user']);

	if (isset($_GET['pay'])) {
		if ($_GET['shipping'] == 'ups') {
			echo "shipping: ups + $5.00<br>";
			echo "total = " . ($myCart->getter() + 5) . "<br>"  ;
			
			$myCart->payment($userRow['id_user'], $myCart->getter() + 5, $userRow['balance']);
			echo $userRow['balance'];
		} else {
			echo "shipping: pick up + $0.00<br>";
			echo "total = " . $myCart->getter() . "<br>"  ;	
		}		
	}
?>

<a href="login.php">back</a>
<a href="close_session.php">close session</a>
</body>
</html>