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
    
    if(filter_var($email,FILTER_VALIDATE_EMAIL)){/*check valid email*/
        $emailAlreadyUsed ="SELECT u_id FROM user WHERE email='$email';";
        $result = $connection->query($emailAlreadyUsed);
        if ($result->num_rows > 0){/*check email already used*/
			echo 'Email already used';
            $error = true;
            $connection->close();
        }
    }else{
        echo 'Use valid email';
		$error = true;
        $connection->close();
    }else if(strlen($password) < 8){/*check password lenght*/
		echo 'Password is too short. Use at least 8 char';
        $error = true;
        $connection->close();
        
	}else if($password != $passwordConfirm){/*check password confirm*/
		echo 'Password check do not match.';
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

$connection->close();

?>