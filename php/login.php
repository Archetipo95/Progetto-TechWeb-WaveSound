<?php

require('connection.php');

if(isset($_POST['email']) && isset($_POST['password'])){
		
	/*save varialble*/
	$password = $_POST['password'];
	$email = $_POST['email'];
	
	/*find out password*/
	$queryPass = "SELECT password FROM user WHERE email='$email'";
	$result = $connection->query($queryPass);
	
	if($result->num_rows == 1){
		$row = mysqli_fetch_row($result);
		
		/*check password if exist in db*/
		if(password_verify($password,$row[0])){
			echo "uguali";
			/*find out username*/
			$queryUser = "SELECT username FROM user WHERE email='$email'";
			$res = $connection->query($queryUser);
			$user = mysqli_fetch_row($res);
			session_start();
			$_SESSION["username"] = $user[0];
		}else{
			header("Location:../misc/errors/login-failed.html");
		}
	}else{
		header("Location:../misc/errors/login-failed.html");
	}
	
	
}

?>
