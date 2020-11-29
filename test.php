<?php

class Test {

	function Test($name_product, $qnt, $price){
		$this->name_product = $name_product;
		$this->qnt = $qnt;
		$this->price = $price;
		$this->total_price = $qnt * $price;
	}


	function updateQuantity(){
		require('connection.php');
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		$query = "UPDATE cart SET quantity = '$this->qnt', total_price='$this->total_price'  
				WHERE name_product = '$this->name_product'";
		$result = $mysqli->query($query);
		$mysqli->close();
		header("location: load_cart.php");
	}

	function delete(){
		require('connection.php');
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		$query = "DELETE FROM cart WHERE name_product = '$this->name_product'";
		$result = $mysqli->query($query);
		$mysqli->close();
		header("location: load_cart.php");
	}
}


class Total {
	function subtotal(){
		require('connection.php');
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		$query = "SELECT total_price FROM cart";
		$result = $mysqli->query($query);
		$mysqli->close();

		$total = 0;
		if ($result->num_rows) {
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				$total += $row['total_price'];
			}	
		}
		return $total;
	}

	function update_total($total){
		require('connection.php');
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		$query = "UPDATE users set count = $total where username='christian.arteaga'";
		$result = $mysqli->query($query);
		$mysqli->close();
	}

	function load() {
		require('connection.php');
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);


		// load data
		$query = "SELECT * from users where username = 'christian.arteaga'";
		$result = $mysqli->query($query);

		// math data
		$row = $result->fetch_array(MYSQLI_ASSOC);
		$count = $row['count'];
		$balance = $row['balance'];
		$total = $balance - $count;

		// update data

		$uptQuery = "UPDATE users 
		SET balance = " . $total . ", prev_balance=". $balance.", count=".$count." WHERE username = 'christian.arteaga' ";
		$result = $mysqli->query($uptQuery);
		$mysqli->close();

		echo "<br>total count " . $count . "<br>prev balance ". $balance . "<br>new balance " . $total;
	}


}

class Rating {

	function updateRating($vote, $name){
		session_start();
		$_SESSION['name'] = $name;
		
		require('connection.php');
		$mysqli = new mysqli($db_host, $db_user, $db_pass, $db_name);
		
		// load data
		$query = "SELECT * FROM products WHERE name = '$name'";
		$result = $mysqli->query($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);

		$average = ($row['rating'] + $vote) / 2;

		// update data
		$query = "UPDATE products SET rating = '$average' WHERE name = '$name'";
		$result = $mysqli->query($query);
		$mysqli->close();

		header("location: product_data.php");
	}

}


if (isset($_GET['update'])) {
	$upd  = new Test($_GET['name_product'], $_GET['qnt'], $_GET['price']);
	$upd->updateQuantity();
}

if (isset($_GET['delete'])) {
	$upd  = new Test($_GET['name_product'], $_GET['qnt'], $_GET['price']);
	$upd->delete();
}


for ($i=1; $i <= 5; $i++) { 
	if (isset($_GET[$i])) {
		$myvar = new Rating();
		$myvar->updateRating($i, $_GET['product']);
	}
}


?>