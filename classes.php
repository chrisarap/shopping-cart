<?php
class Connection 
{
	var $db_host = 'localhost';
	var $db_name = 'abc_hosting';
	var $db_user = 'root';
	var $db_pass = '';

	function resulset($query)
	{
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$result = $mysqli->query($query);
		$mysqli->close();
		return $result;
	}

	function close_session(){
		session_start();
		session_destroy();
		header('location: login.php');
	}
}

class User extends Connection 
{


	// check user login
	function check_user($username, $password)
	{
		$query = "SELECT * FROM users WHERE username = '$username' && password = '$password'";
		$result = $this->resulset($query);
		$numRow = $result->num_rows;
		
		$this->choose_page($numRow, $username);
	}

	// login or reject user
	function choose_page($numRow, $username)
	{
		if ($numRow) {
			session_start();
			$_SESSION['username'] = $username;
			header("location: search.php");
		} else {
			header("location: login.php");
		}
	}	












	function create_new_user(){

		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "INSERT INTO users (username, password, balance) VALUES ('$this->username', '$this->password', 100)";
		$mysqli->query($query);
		$mysqli->close();
	}



	function load_user_data(){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "SELECT * FROM users WHERE username = '$this->username' && password = '$this->password'";
		$result = $mysqli->query($query);
		$mysqli->close();
		return $result->fetch_array(MYSQLI_ASSOC); // return an associative row
	}


}

class Product extends Connection 
{

	//load products and print it
	function print_product()
	{
		// load products data
		$query = "SELECT * FROM products";
		$result = $this->resulset($query);
		$numRow = $result->num_rows;

		// print products
		if ($numRow) 
		{
			echo "<div class='container_products'>";

			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$img = "<img class='img_block' src='" . $row['images'] . "'>";

				echo "<div class='block_product'>";
					
					echo "$img";
					echo "<div>" . $row['name'] . "</div>";
					echo "<div>$" . $row['price'] . "</div>";
			
					echo "<form method='get' action='btn_event.php'>";
						echo "<input hidden type='text' name='productName' value='" . $row['name'] . "'>";
						echo "<input type='submit' name='see_product' value='see'>";
					echo "</form>";
				echo "</div>";
			}
			echo "</div>";
		}
	}




	function print_selected_product($result)
	{
		if($result->num_rows){	
			$row = $result->fetch_array(MYSQLI_ASSOC);

			$img =  $row["images"];

			echo "<div class='container_products'>";
				// form
				echo "<form id='data' action='btn_event.php' method='get'>";
					echo "<img src = \"$img\" class='img_block'>";

					echo "<div class='form_product'>";
						echo "<h2>".$row['name']."</h2>";
						echo "<h2>$".$row['price']."</h2>";
						
						echo "<div class='label_name'>";
							echo "<div>quantity</div>";
							echo "<input required type='number' name='quantity' placeholder='quantity' min='0'>";
						echo "</div>";

						echo "<input type='submit' name='add_to_cart' value='add to cart'>";
					echo "</div>";

				echo "</form>";
			echo "</div>";			

		}
	} // end function print_selected_product





	function load_product_data(){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "SELECT * FROM products WHERE name = '$this->productName'";
		$result = $mysqli->query($query);
		$mysqli->close();
		return $result; // return result set
	}	

	
}


class Cart extends Connection
{

	function Cart()
	{
		$this->subtotal = 0;
	}

	function setter($subtotal)
	{
		$this->subtotal = $subtotal;
	}

	function getter(){
		return $this->subtotal;
	}

	

	function add_shipping($shipping)
	{
		return $this->getter() + $shipping;
	}

	function payment($id, $total, $balance)
	{
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "UPDATE users SET balance = $balance - $total WHERE id_user = '$id'";
		$result = $mysqli->query($query);
		$mysqli->close();
	}









	function add_row_cart($nameProduct, $priceProduct, $quantity, $totalPrice)
	{
		$query = "INSERT INTO cart (name_product, price, quantity, total_price) values ('$nameProduct','$priceProduct','$quantity','$totalPrice')";
		$this->resulset($query);
	}
	function delete_row_cart($nameProduct)
	{
		$query = "DELETE FROM cart WHERE name_product = '$nameProduct'";
		$this->resulset($query);
	}

	function execute_add_to_cart(){
		session_start();

		$query = "SELECT * FROM products WHERE name='" . $_SESSION['nameProduct'] . "'";
		
		// products
		$product = new product();
		$result = $product->resulset($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);

		// variables
		$nameProduct = $row['name'];
		$priceProduct = $row['price'];
		$quantity = $_SESSION['quantity'];
		$totalPrice = $priceProduct * $quantity;

		// cart
		$this->delete_row_cart($nameProduct);
		$this->add_row_cart($nameProduct, $priceProduct, $quantity, $totalPrice);

		header("location: product_information.php");
	}

	function updateQuantity($nameProduct, $quantity, $price){
		$totalPrice = $quantity * $price;

		$query = "UPDATE cart SET quantity = '$quantity', total_price='$totalPrice'  
				WHERE name_product = '$nameProduct'";
		$result = $this->resulset($query);
		header("location: load_cart.php");
	}

	function load_cart()
	{
		$result = $this->resulset("SELECT * FROM cart");

		if($result->num_rows){
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				
				echo "<form action='btn_event.php' method='get'>";
					echo "<div class='row'>";
						echo "<input hidden type='text' name='name_product' value='" . $row['name_product'] . "'>";
						echo "<div>" . $row['name_product'] . "</div>";

						echo "<input hidden type='text' name='price' value='" . $row['price'] . "'>";
						echo "<div>" . $row['price'] . "</div>";

						echo "<input name='qnt' type='number' value='". $row['quantity'] . "'>";
						echo "<div>". $row['total_price']	."</div>";
						echo "<input type='submit' value='update' name='update'>";
						echo "<input type='submit' value='delete' name='delete'>";
					echo "</div>";
				echo "</form>";
				
			}
		}
	}


} // end cart class


class Rating extends Connection {

	// rating
	function print_rating()
	{

		echo "<div class='rating'>";
			echo '<form id="ratingg" action="btn_event.php" method="get">';

				echo '<input hidden form="ratingg" type="text" name="product" value="'. $_SESSION['nameProduct'] .'">';
				echo '<input form="ratingg" type="submit" name="1" value="1">';
				echo '<input form="ratingg" type="submit" name="2" value="2">';
				echo '<input form="ratingg" type="submit" name="3" value="3">';
				echo '<input form="ratingg" type="submit" name="4" value="4">';
				echo '<input form="ratingg" type="submit" name="5" value="5">';
				$this->show_rating($_SESSION['nameProduct']);
			echo '</form>';
			
		echo "</div>";
	}

	function show_rating($nameProduct){
		$query = "SELECT * FROM products WHERE name = '$nameProduct'";
		$result = $this->resulset($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo "<div>". $row['rating']. "</div>";
	}

	function updateRating($vote, $name){
		
		// load data
		$query = "SELECT * FROM products WHERE name = '$name'";
		$result = $this->resulset($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);

		$average = ($row['rating'] + $vote) / 2;

		// update rating
		$updQuery = "UPDATE products SET rating = '$average' WHERE name = '$name'";
		$this->resulset($updQuery);

		header("location: product_information.php");
		
	}


} // end class rating

class Invoice extends Connection
{
	
	function subtotal($id)
	{
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "SELECT * FROM cart WHERE id_user = '$id'";	
		$result = $mysqli->query($query);
		$mysqli->close();

		if ($result) {
			$total = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) {
				echo $row['id_user'] . " " . $row['name_product'] . " " . $row['total_price'] . " <br>";
				$total += $row['total_price'];
			}
			echo "sub-total = $total <br>";
			$this->setter($total);
		}
	}



















	/*
	


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

		*/
} // end class total




?>
