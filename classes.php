<?php
class Connection 
{
	/*
	private $db_host = 'mysql.zz.com.ve';
	private $db_name = 'chrisar';
	private $db_user = 'dbone';
	private $db_pass = 'Mouse1212';
	*/
	private $db_host = 'localhost';
	private $db_name = 'abc_hosting';
	private $db_user = 'root';
	private $db_pass = '';

	function resulset($query)
	{
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$result = $mysqli->query($query);
		$mysqli->close();
		return $result;
	}

	function close_session()
	{
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
		if ($numRow) 
		{
			$query = "SELECT * FROM users WHERE username = '$username'";
			$result = $this->resulset($query);
			$row = $result->fetch_array(MYSQLI_ASSOC);
			
			session_start();
			$_SESSION['username'] = $username;
			$_SESSION['balance'] = $row['balance'];
			$cart = new Cart();
			$_SESSION['numRow'] = $cart->cart_number_row();
			header("location: search.php");
		} else {
			header("location: login.php");
		}
	}	

	function create_new_user($username, $password){

		$query = "INSERT INTO users (username, password, balance) 
		VALUES ('$username', '$password', 100)";
		$result = $this->resulset($query);

		$this->check_user($username, $password);

	}

	function load_user_data(){
		
		$query = "SELECT * FROM users WHERE username ='". $_SESSION['username'].  "'";
		$result = $this->resulset($query);
		return $result->fetch_array(MYSQLI_ASSOC);
	}

	function return_100(){
		$query = "UPDATE users SET balance = 100";
		$this->resulset($query);
	}



} // end user class

class Rating extends Connection {

	// rating
	function print_rating()
	{

		echo "<div class='rating'>";
			echo '<form id="ratingg" action="btn_event.php" method="get">';

				echo '<input hidden form="ratingg" type="text" name="product" value="'. $_SESSION['nameProduct'] .'">';
				echo '<input class="btn2" form="ratingg" type="submit" name="1" value="1">';
				echo '<input class="btn2" form="ratingg" type="submit" name="2" value="2">';
				echo '<input class="btn2" form="ratingg" type="submit" name="3" value="3">';
				echo '<input class="btn2" form="ratingg" type="submit" name="4" value="4">';
				echo '<input class="btn2" form="ratingg" type="submit" name="5" value="5">';
				$this->show_rating($_SESSION['nameProduct']);
			echo '</form>';
			
		echo "</div>";
	}

	function show_rating($nameProduct){
		$query = "SELECT * FROM products WHERE name = '$nameProduct'";
		$result = $this->resulset($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);
		echo "<div>Rating ". $row['rating']. "</div>";
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
					echo "<div class='product_name'>" . $row['name'] . "</div>";
					echo "<div>$" . $row['price'] . "</div>";
			
					echo "<form method='get' action='btn_event.php'>";
						echo "<input hidden type='text' name='productName' value='" . $row['name'] . "'>";
						echo "<input class='btn' type='submit' name='see_product' value='see'>";
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
			echo "<div class='container'>";
				echo "<div class='container_products'>";
					echo "<img src = \"$img\" class='img_block'>";
					echo "<div>";
						// form
						echo "<form class='product' id='data' action='btn_event.php' method='get'>";
							

							echo "<div class='form_product'>";
								echo "<div class='product_name'>".$row['name']."</div>";
								echo "<div>$".$row['price']."</div>";
								
								echo "<div class='label_name'>";
									echo "<input class='bar_text1' required type='number' name='quantity' placeholder='Quantity' min='0'>";
								echo "</div>";

								echo "<input class='btn1' type='submit' name='add_to_cart' value='add to cart'>";	
							echo "</div>";	

						echo "</form>";
						
						$rating = new Rating();
						$rating->print_rating();
					echo "</div>";
				echo "</div>";	
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
			echo "<table>";
				echo "<tr>";
				echo "<th>Name</th> <th>Price</th> <th>Quantity</th> <th>Total</th> <th>Update</th> <th>Delete</th>";
				echo "<tr>";
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				
				echo "<form action='btn_event.php' method='get'>";
					echo "<tr>";
						echo "<input hidden type='text' name='name_product' value='" . $row['name_product'] . "'>";
					echo "<td>";
						echo "<div>" . $row['name_product'] . "</div>";
					echo "</td>";
						echo "<input hidden type='text' name='price' value='" . $row['price'] . "'>";
					echo "<td>";
						echo "<div>" . $row['price'] . "</div>";
					echo "</td>";
					echo "<td>";
						echo "<input class='bar_text' name='qnt' type='number' value='". $row['quantity'] . "'>";
					echo "</td>";
					echo "<td>";
						echo "<div>". $row['total_price']	."</div>";
					echo "</td>";
					echo "<td>";
						echo "<input class='btn' type='submit' value='update' name='update'>";
					echo "</td>";
					echo "<td>";
						echo "<input class='btn' type='submit' value='delete' name='delete'>";
					echo "</td>";
					echo "</tr>";
				echo "</form>";
				
			}
			echo "</table>";
		}
	}

	function cart_number_row()
	{
		$result = $this->resulset("SELECT * FROM cart");
		return $result->num_rows;

	}
} // end cart class

class Invoice extends Connection
{
	
	function subtotal()
	{
		/*
		$query = "SELECT * FROM cart";
		$result = $this->resulset($query);

		if ($result) 
		{
			$total = 0;
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$total += $row['total_price'];
			}
			return $total;
		}
		*/
		return 11;
	}

	function total($subtotal, $shipping)
	{
		session_start();

		$total = $subtotal + $shipping;
		$username = $_SESSION['username'];
		
		$query = "UPDATE users SET count = '$total'
				WHERE username = '$username'";
		$this->resulset($query);

		return $total;
	}

	function pay(){
		$query =  "SELECT * FROM users";
		$result = $this->resulset($query);
		$row = $result->fetch_array(MYSQLI_ASSOC);

		$balance = $row['balance'];
		$newBalance = $row['balance'] - $row['count'];

		$query = "UPDATE users SET balance = '$newBalance', prev_balance = '$balance'";

		$this->resulset($query);
	}

} // end class total
?>