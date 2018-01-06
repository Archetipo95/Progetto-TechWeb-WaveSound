<?php

require('connection.php');
require('msg.php');

if(isset($_POST['login']) && isset($_POST['password'])){
		
	/*save varialble*/
	$password = $_POST['password'];
	$login = $_POST['login'];
	
	/*search for username*/
	$getUserUsername = "SELECT * FROM user WHERE username='$login'";
	$result = $connection->query($getUserUsername);
	$resultEmail = 0;
	/*search for email*/
	if(filter_var($login,FILTER_VALIDATE_EMAIL)){
		$getUserEmail = "SELECT * FROM user WHERE email='$login'";
		$resultEmail = $connection->query($getUserEmail);
	}else{
		$resultEmail = 0;
	}
	/*if user exist in db*/
	if($result->num_rows === 1){
		$row = mysqli_fetch_row($result);
		/*
		$row[0] is User ID
		$row[1] is Username
		$row[2] is Name
		$row[3] is Surname
		$row[4] is Bday
		$row[5] is email
		$row[6] is User_Type
		$row[7] is Password
		$row[8] is Avatar
		$row[9] is Id_library
		*/
		/*check password correctness*/
		if(password_verify($password,$row[7])){
			/*start session and go to main*/
			session_start();
			$_SESSION["userID"] = $row[0];
			$_SESSION["username"] = $row[1];
			$_SESSION["avatar"] = $row[8];
			header("Location:../../main.html");
		}else{
			sendMessage("Login Failed");
		}
	}/*if email exist in db*/
	else if($resultEmail === 1){
		$row = mysqli_fetch_row($resultEmail);
		if(password_verify($password,$row[7])){
			/*start session and go to main*/
			session_start();
			$_SESSION["userID"] = $row[0];
			$_SESSION["username"] = $row[1];
			header("Location:../../main.html");
		}else{
			sendMessage("Login Failed");
		}
	}else{
		sendMessage("Login Failed");
	}
}

?>
