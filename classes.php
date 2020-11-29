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
						echo "<input type='submit' name='see_product' value='assdasd'>";
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
				echo "<form id='data' action='cart.php' method='get'>";
					echo "<img src = \"$img\" class='img_block'>";

					echo "<div class='form_product'>";
						echo "<h2>".$row['name']."</h2>";
						echo "<h2>$".$row['price']."</h2>";
						
						echo "<div class='label_name'>";
							echo "<div>quantity</div>";
							echo "<input type='number' name='quantity' placeholder='quantity' min='0'>";
						echo "</div>";

						echo "<input type='submit' value='add to cart'>";
					echo "</div>";

				echo "</form>";
			echo "</div>";
			
				

}
	}





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

	function Cart(){
		$this->subtotal = 0;
	}

	function setter($subtotal){
		$this->subtotal = $subtotal;
	}

	function getter(){
		return $this->subtotal;
	}

	function sum_semitotal($id){
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

	function add_shipping($shipping){
		return $this->getter() + $shipping;
	}

	function payment($id, $total, $balance){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "UPDATE users SET balance = $balance - $total WHERE id_user = '$id'";
		$result = $mysqli->query($query);
		$mysqli->close();
	}
}


class Rating extends Connection {

	// rating
	function print_rating()
	{

		echo "<div class='rating'>";
			echo '<form id="ratingg" action="test.php" method="get">';

				echo '<input form="ratingg" type="text" name="product" value="'. $_SESSION['nameProduct'] .'">';
				echo '<input form="ratingg" type="submit" name="1" value="1">';
				echo '<input form="ratingg" type="submit" name="2" value="2">';
				echo '<input form="ratingg" type="submit" name="3" value="3">';
				echo '<input form="ratingg" type="submit" name="4" value="4">';
				echo '<input form="ratingg" type="submit" name="5" value="5">';
			echo '</form>';
		echo "</div>";
	}


}



?>