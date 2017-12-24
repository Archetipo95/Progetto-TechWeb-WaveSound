<?php

require('connection.php');
require('error.php');

/*
**hash password
*/
function securedHash($input){    
		$output = password_hash($input,PASSWORD_DEFAULT);
		return $output;
	}

/*
**Returns true if all form post are present
*/
function checkPost(){
	return (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['psw-repeat']) && isset($_POST['email']));
}

/*
**Given an integer returns true if there are 0 rows from query
*/
function checkPresence($number){
	return ($number===0);
}

/*
**Returns true if password is at least 8 char
*/
function checkPasswordLenght($pass){
	return (strlen($pass) >= 8);
}

/*
**Returns true if password is confirmed
*/
function confirmPassword($pass, $passConfirm){
	return ($pass === $passConfirm);
}

if(checkPost()){
	
    //save inputs
    $password = $_POST['password'];
    $passwordConfirm = $_POST['psw-repeat'];
    $email = $_POST['email'];
	$username = $_POST['username'];
	
	$error = false;
		
	/*check valid email*/
	if(filter_var($email,FILTER_VALIDATE_EMAIL)){
		$emailUsed ="SELECT u_id FROM user WHERE email='$email';";
		$result = $connection->query($emailUsed);
		/*check email already used*/
        if (checkPresence($result->num_rows)){
			/*check username already used*/
			$usernameUsed = "SELECT u_id FROM user WHERE username='$username';";
			$result = $connection->query($usernameUsed);
			if(checkPresence($result->num_rows)){
				/*check password lenght*/
				if(checkPasswordLenght($password)){
					/*check password confirmation*/
					if(!confirmPassword($password,$passwordConfirm)){
						$error = true;
						$connection->close();
						sendError("Different password");
					}
				}else{
					$error = true;
					$connection->close();
					sendError("Password too short");
				}
        	}else{
				$error = true;
				$connection->close();
				sendError("Username alredy used");
			}
    	}else{
            $error = true;
            $connection->close();
			sendError("Email already used");
		}
	}else{
		$error = true;
        $connection->close();
		sendError("Use valid email");
	}
	
	if(!$error){
		
		$pass_hash = securedHash($password);
    	$insertQuery = "INSERT INTO user (`username`,`email`, `password`) VALUES ('$username','$email', '$pass_hash');";
    	$result = $connection->query($insertQuery);
		session_start();
		$_SESSION["username"] = $username;
		header("Location:../misc/errors/account-created.html");
	}
}
?>