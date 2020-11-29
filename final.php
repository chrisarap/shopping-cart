<?php



require ("classes.php");

$query = "select * from users";

$user = new User($query);
$result = $user->resulset($query);
$row = $result->fetch_array(MYSQLI_ASSOC);


echo "thanks for shopping " . $row['username'];

echo "previous balance " . $row['prev_balance'] . "<br>";
echo "invoice " . $row['count'] . "<br>";
echo "new balance " . $row['balance'] . "<br>";


// clean cart
$query = "delete from cart";
$cart = new Cart();
$cart->resulset($query);

echo "<a href='search.php'>back</a>";



?>