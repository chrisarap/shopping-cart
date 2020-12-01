<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/final.css">
</head>
<body>

<?php

require ("classes.php");

//$_SESSION['balance'] = $row['balance'];

require ("nav_bar.php");

$invoice = new Invoice();
$invoice->print_final_invoice();


?>
</body>
</html>