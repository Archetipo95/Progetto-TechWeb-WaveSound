<?php
require('connection.php');

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['psw-repeat'])){
   
    $password = $_POST['password'];
    $passwordConfirm = $_POST['psw-repeat'];
    

    if(strlen($_POST['password']) < 3){
		$error[] = 'Password is too short.';
	}
	if(strlen($_POST['psw-repeat']) < 3){
		$error[] = 'Confirm password is too short.';
	}
	if($_POST['password'] != $_POST['psw-repeat']){
		$error[] = 'Passwords do not match.';
    }
    
    $email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    $error[] = 'Please enter a valid email address';
	} else {
        $email = $_POST['email'];
        $stmt = "SELECT email FROM utente WHERE email = '$email'";
        $emailval = mysqli_query($connection, $stmt);
		if(mysqli_num_rows($emailval)>0){
			$error[] = 'Email provided is already in use.';
		}
    }
    
    if(!isset($error)){

        $pass_hash = password_hash($password,PASSWORD_BCRYPT);
        $query = "INSERT INTO utente (email,pass) VALUES ('$email', '$pass_hash')";
        $result = mysqli_query($connection, $query);

        

        if($result){
            echo "User Created Successfully.";
            //send mail
            $to = $_POST['email'];
            $subject = "Registration Confirmation";
            $res = mysqli_query($connection, "SELECT u_id FROM utente WHERE email = '$email'");
            $current_id = mysqli_fetch_array($res);
            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."activate.php?id=" . $current_id;
            $body = "Click this link to activate your account. <a href='" . $actual_link . "'>" . $actual_link . "</a>";
            $mailHeaders = "From: Admin\r\n";
            if(mail($to, $subject, $body, $mailHeaders)) {
                $message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";	
            }
            unset($_POST);
            header('Location: main.html');  
        }else{
            echo "User Registration Failed";
        }
    }
}


?>
