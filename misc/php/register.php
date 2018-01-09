<?php
require ('connection.php');

require ('msg.php');

require ('tools.php');

/*
**Returns true if all form post are present
*/

function checkPost()
{
	return (!empty($_POST['username']) && !empty($_POST['password']) && !empty($_POST['psw-repeat']) && !empty($_POST['email']));
}

if (checkPost()) {

	// save inputs

	$password = $_POST['password'];
	$passwordConfirm = $_POST['psw-repeat'];
	$email = $_POST['email'];
	$username = $_POST['username'];
	$error = false;
	/*check valid email*/
	if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
		$emailUsed = "SELECT u_id FROM user WHERE email='$email';";
		$result = $connection->query($emailUsed);
		/*check email already used*/
		if (checkPresence($result->num_rows)) {
			/*check username already used*/
			$usernameUsed = "SELECT u_id FROM user WHERE username='$username';";
			$result = $connection->query($usernameUsed);
			if (checkPresence($result->num_rows)) {
				/*check password lenght*/
				if (checkPasswordLenght($password)) {
					/*check password confirmation*/
					if (!confirmPassword($password, $passwordConfirm)) {
						$error = true;
						$connection->close();
						sendMessage("Different password");
					}
				}
				else {
					$error = true;
					$connection->close();
					sendMessage("Password too short");
				}
			}
			else {
				$error = true;
				$connection->close();
				sendMessage("Username alredy used");
			}
		}
		else {
			$error = true;
			$connection->close();
			sendMessage("Email already used");
		}
	}
	else {
		$error = true;
		$connection->close();
		sendMessage("Use valid email");
	}

	if (!$error) {
		$pass_hash = securedHash($password);
		$insertQuery = "INSERT INTO user (`username`,`email`, `password`) VALUES ('$username','$email', '$pass_hash');";
		$result = $connection->query($insertQuery);
		sendMessage("$username your account was successfully created");
	}
}

?>