<?php
// Start the session
session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>

	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<meta name="viewport" content="width=device-width, initial-scale=1.0" />
	<title>WaveSound | Account Created</title>

	<!-- font + fav icon -->
	<link rel="icon" type="image/png" href="../../img/logo.png">
	<link href="https://fonts.googleapis.com/css?family=Roboto" rel="stylesheet">
	<link href="https://fonts.googleapis.com/css?family=Pacifico" rel="stylesheet">

	<!-- style -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css" />

</head>

<body>

	<header>
		<div class="header-container">
			<div class="header-left">
				<a class="img-link" href="../../index.html">
					<div id="logo"></div>
					<div id="brand" class="pacifico italic">WaveSound</div>
				</a>
			</div>
			<div class="header-right">
				<div id="join-us">
					Welcome to our community!
				</div>
			</div>
		</div>
	</header>

	<main class="center">
		<h1>Your account has been created!</h1>
		<?php
			echo "<h1>Username: " . $_SESSION["username"] . "</h1>";
		session_unset();
		session_destroy();
		?>
	</main>

	<footer>
		<div data-include="../include/footer.html"></div>
	</footer>
	
	<script src="../../js/include.js"></script>

</body>

</html>
