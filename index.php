<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
</head>
<body>
	<div>
		<form action="btn_event.php" method="get">
			<label for="username">Login
				<input class="bar_text" id="username" name="username" placeholder="username" value="admin">
			</label>
			
			<label  for="password">Password
				<input class="bar_text" id="password" name="password" placeholder="password" value="12345">
			</label>

			<div class="btns">
				<input class="btn" type="submit" name="login" value="Log In">
				<input class="btn" type="submit" name="signup" value="Sign Up">
			</div>
		</form>
	</div>
</body>
</html>