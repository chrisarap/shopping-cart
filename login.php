<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
</head>
<body>
	<form action="btn_event.php" method="get">

		<label for="username">login
			<input class="bar_text" id="username" name="username" placeholder="username" value="admin">
		</label>
		
		<label  for="password">password
			<input class="bar_text" id="password" name="password" placeholder="password" value="12345">
		</label>

		<div class="btns">
			<input class="btn" type="submit" name="login" value="log in">
			<input class="btn" type="submit" name="signup" value="sign up">
		</div>
	</form>
</body>
</html>