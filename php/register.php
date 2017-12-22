<?php

require('connection.php');

function secured_hash($input){    
		$output = password_hash($input,PASSWORD_DEFAULT);
		return $output;
	}

if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['psw-repeat']) && isset($_POST['email'])){
    
    $error = false;
    
    //save inputs
    $password = $_POST['password'];
    $passwordConfirm = $_POST['psw-repeat'];
    $email = $_POST['email'];
	$username = $_POST['username'];
    
	/*check valid username*/
	$usernameUsed = "SELECT u_id FROM user WHERE username='$username';";
	$resultUser = $connection->query($usernameUsed);
	if($resultUser->num_rows == 0){
		
		/*check valid email*/
    	if(filter_var($email,FILTER_VALIDATE_EMAIL)){
        	$emailAlreadyUsed ="SELECT u_id FROM user WHERE email='$email';";
        	$result = $connection->query($emailAlreadyUsed);
		
			/*check email already used*/
        	if ($result->num_rows == 0){
				/*check password lenght & status*/
				if((strlen($password) < 8) || ($password != $passwordConfirm)){
					echo 'Password not valid';
					$error = true;
					$connection->close();
					header("Location:../misc/errors/invalid-password.html");
				}
        	}else{
				echo 'Email already used';
            	$error = true;
            	$connection->close();
				header("Location:../misc/errors/email-used.html");
			}
    	}else{
        	echo 'Use valid email';
			$error = true;
        	$connection->close();
			header("Location:../misc/errors/invalid-email.html");
		}
	}else{
		echo 'Username alredy used';
		$error = true;
		$connection->close();
		header("Location:../misc/errors/invalid-user.html");
	}
		
	if(!$error){
		
		$pass_hash = secured_hash($password);
    	$insertQuery = "INSERT INTO `my_wavesound`.`user` (`username`,`email`, `password`) VALUES ('$username','$email', '$pass_hash');";
    	$result = $connection->query($insertQuery);
		echo 'Data send succesfully to DB. Check your DB';
		session_start();
		$_SESSION["username"] = $username;
		header("Location:../misc/errors/account-created.php");
		exit();
	} else {
		echo 'Data NOT send to DB';
	}
}
?>
