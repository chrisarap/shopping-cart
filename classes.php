<?php
class Connection {
	var $db_host = 'localhost';
	var $db_name = 'abc_hosting';
	var $db_user = 'root';
	var $db_pass = '';
}

class Login extends Connection {

	function Login($username, $password){
		$this->username = $username;
		$this->password = $password;
	}

	function create_new_user(){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "INSERT INTO users (username, password, balance) VALUES ('$this->username', '$this->password', 100)";
		$mysqli->query($query);
		$mysqli->close();
	}

	function check_user(){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "SELECT * FROM users WHERE username = '$this->username' && password = '$this->password'";
		$result = $mysqli->query($query);
		$mysqli->close();
		$this->choose_page($result->num_rows); // sent a row
	}

	function choose_page($row){
		if ($row != 0) {
			session_start();
			$_SESSION['username'] = $this->username;
			$_SESSION['password'] = $this->password;		
			header('location: index.php');
		} else {
			header('location: login.php');
		}
	}

	function load_user_data(){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "SELECT * FROM users WHERE username = '$this->username' && password = '$this->password'";
		$result = $mysqli->query($query);
		$mysqli->close();
		return $result->fetch_array(MYSQLI_ASSOC); // return an associative row
	}
}

class Products extends Connection {
	function Products($productName){
		$this->productName = $productName;
	}

	function load_product_data(){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "SELECT * FROM products WHERE name = '$this->productName'";
		$result = $mysqli->query($query);
		$mysqli->close();
		return $result; // return result set
	}	
}


class Cart extends Connection{

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

	function payment($id, $total, $balance){
		$mysqli = new mysqli($this->db_host, $this->db_user, $this->db_pass, $this->db_name);
		$query = "UPDATE users SET balance = $balance - $total WHERE id_user = '$id'";
		$result = $mysqli->query($query);
		$mysqli->close();
	}
}

?>