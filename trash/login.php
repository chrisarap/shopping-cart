<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
</head>
<body>
	<form action="check_login.php" method="get">

		<label for="username">
			login<input class="bar_text" id="username" name="username" placeholder="username">
		</label>
		
		<label  for="password">password
			<input class="bar_text" id="password" name="password" placeholder="password">
		</label>
		<div class="btns">
			<input class="btn" type="submit" name="submit_login" value="log in">
			<input class="btn" type="submit" name="create_user" value="sign up">
		</div>
	</form>
</body>
</html>