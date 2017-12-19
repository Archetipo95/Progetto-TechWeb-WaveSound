<?php

require('connection.php');

function secured_hash($input){    
		$output = password_hash($input,PASSWORD_DEFAULT);
		return $output;
	}

if(isset($_POST['password']) && isset($_POST['psw-repeat']) && isset($_POST['email'])){
    
    $error = false;
    
    //save inputs
    $password = $_POST['password'];
    $passwordConfirm = $_POST['psw-repeat'];
    $email = $_POST['email'];
    
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
			}
        }else{
			echo 'Email already used';
            $error = true;
            $connection->close();
		}
    }else{
        echo 'Use valid email';
		$error = true;
        $connection->close();
	
	    }

	if(!$error){
		
		$pass_hash = secured_hash($password);
    	$insertQuery = "INSERT INTO `my_wavesound`.`user` (`email`, `password`) VALUES ('$email', '$pass_hash');";
    	$result = $connection->query($insertQuery);
		echo 'Data send succesfully to DB. Check your DB';
	} else {
		echo 'Data NOT send to DB';
	}
}

?>
