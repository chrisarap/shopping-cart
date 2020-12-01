<?php
require('classes.php');

// create new user
if (isset($_GET['register'])) 
{

	if ($_GET['password1']  !== $_GET['password2']) {
		session_start();
		$_SESSION['message'] = "The password are different";
		header("location: register.php");
	} else if ($_GET['password1']  === $_GET['password2']) {
		$user = new User();
		$user->exist_user(strtolower($_GET['new_user']), $_GET['password1']);
	}
}

// sign up button
if (isset($_GET['signup'])) 
{
	session_start();
	$_SESSION['message'] = "";
	header('location: register.php');
}

// log in button
if (isset($_GET['login'])) 
{
	$user = new User();
	$user->check_user(strtolower($_GET['username']), $_GET['password']);
}

// see button
if (isset($_GET['see_product'])) 
{	
	echo $_GET['productName'];
	session_start();
	$_SESSION['nameProduct'] = $_GET['productName'];
	header('location: product_information.php');
}

// quantity button
if (isset($_GET['add_to_cart'])) 
{
	session_start();
	$_SESSION['quantity'] = $_GET['quantity'];
	
	$cart = new Cart();
	$_SESSION['numRow'] = $cart->cart_number_row();
	$cart->execute_add_to_cart();

}

// rating buttons
for ($i=1; $i <= 5; $i++) 
{ 
	if (isset($_GET[$i])) 
	{

		session_start();

		$rating = new Rating();
		//$rating->updateRating($i, $_SESSION['nameProduct']);
		$rating->add_vote_json($_SESSION['username'], $_SESSION['nameProduct'], $i);

	}
}

// update button
if (isset($_GET['update'])) 
{
	$cart = new Cart();	
	session_start();
	$_SESSION['numRow'] = $cart->cart_number_row();
	$cart->updateQuantity($_GET['name_product'], $_GET['qnt'], $_GET['price']);
}

// delete button
if (isset($_GET['delete'])) 
{
	$cart = new Cart();	
	session_start();
	$_SESSION['numRow'] = $cart->cart_number_row();
	$cart->delete_row_cart($_GET['name_product']);
	header("location: load_cart.php");
}

// payment
if (isset($_GET['pay'])) 
{
	$invoice = new Invoice();
	
	session_start();
	$_SESSION['subtotal'] = $invoice->subtotal();

	if ($_GET['radio'] == 'ups') 
	{
		$_SESSION['shipping'] = 5;
	} else {
		$_SESSION['shipping'] = 0;
	}
	
	$_SESSION['total'] = $invoice->total($invoice->subtotal(), $_SESSION['shipping']);
		
	header("location: subfinal.php");
}

// final payment
if (isset($_GET['payment'])) 
{
	session_start();
	$invoice = new Invoice();
	$invoice->pay();
	
	$cart = new Cart();	
	$_SESSION['numRow'] = $cart->cart_number_row();
	
	// clean cart
		$query = "DELETE from cart where id_user ='" . $_SESSION['id_user'] ."'";
		$cart = new Cart();
		$cart->resulset($query);
		$cart->cart_number_row();

	header("location: final.php");
}

if (isset($_GET['logout'])) 
{
	$user = new User();
	$user->return_100();

	$connection = new Connection();
	$connection->close_session();
}

?>
