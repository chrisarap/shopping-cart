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
}


class User extends Connection 
{
	function check_user($username, $password)
	{
		$query = "SELECT * FROM users WHERE username = '$username' && password = '$password'";
		$result = $this->resulset($query);
		$numRow = $result->num_rows;
		
		$this->choose_page($numRow, $username);
	}

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
}

class Product extends Connection
{
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
			session_start();
			while ($row = $result->fetch_array(MYSQLI_ASSOC)) 
			{
				$_SESSION[$row['name']] = $row['name'];

				$img = "<img class='img_block' src='" . $row['images'] . "'>";

				echo "<div class='block_product'>";
					
					echo "$img";
					echo "<div>" . $row['name'] . "</div>";
					echo "<div>$" . $row['price'] . "</div>";
			
					echo "<form method='get' action='button_event.php'>";
						echo "<input  id='hide'  name='test' value='" . $row['name'] . "'>";
						echo "<input type='submit' name='". $row['name'] ."' value='assdasd'>";
					echo "</form>";
				echo "</div>";
			}
			
			
			
			echo "</div>";
		}
	}


}

?>