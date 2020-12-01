<!DOCTYPE html>
<html>
<head>
	<link rel="stylesheet" type="text/css" href="./assets/css/login.css">
</head>
<body>
	<div>

		<h1>Create new user</h1>
		<form action="btn_event.php" method="get">
			
			<label for="username">Username
				<input class="bar_text" id="username" name="new_user" placeholder="username" required>
			</label>
			
			<label  for="password">Password
				<input class="bar_text" id="password" name="password1" placeholder="password" required>
			</label>

			<label  for="password">Repeat password
				<input class="bar_text" id="password" name="password2" placeholder="password" required>
			</label>

			<div class="btns">
				<input class="btn" type="submit" name="register" value="Send">
			</div>

			<?php
				session_start();
				if ($_SESSION['message']) {
					echo "<p>" . $_SESSION['message'] . "</p>";
				}
			?>

		</form>
	</div>
</body>
</html>