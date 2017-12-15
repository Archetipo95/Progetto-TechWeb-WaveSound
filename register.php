<?php
require('connection.php');

if(isset($_POST['email']) && isset($_POST['password']) && isset($_POST['psw-repeat'])){
    
    $error=true;
    
    //pasaggio password
    $password = $_POST['password'];
    $passwordConfirm = $_POST['psw-repeat'];
    
    //controllo password
    if(strlen($_POST['password']) < 3){
		echo 'Password is too short.';
        $error= false;
	}
	if(strlen($_POST['psw-repeat']) < 3){
		echo 'Confirm password is too short.';
        $error= false;
	}
	if($_POST['password'] != $_POST['psw-repeat']){
		echo 'Passwords do not match.';
        $error= false;
    }
    
    //passaggio email
    //$email = htmlspecialchars_decode($_POST['email'], ENT_QUOTES);
    $email = $_POST['email'];
    // controlo validità email
	if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
	    echo 'Please enter a valid email address';
        $error= false;
	} else {
        //$email = $_POST['email'];
        $sql = "SELECT email FROM utente WHERE email= '.$email.' ";
        $result = $connect->query($sql);
        
        if ($result->num_rows > 0) {
            // output data of each row
            while($row = $result->fetch_assoc()) {
                echo "email" . $row["email"]. "<br>";
            }
        } else {
            echo "0 results";
        }
        
        //echo [$email_Result];
		//if(mysqli_num_rows($Result)>0){
		//	echo 'Email provided is already in use.';
        //}
    }
}
    
if($error == true){
    $pass_hash = password_hash($password,PASSWORD_BCRYPT);
    $insertQuery = "INSERT INTO utente (email,pass) VALUES ('$email', '$pass_hash')";
    $insertResult = $connect->query($insertQuery);

        

//        if($result){
//            echo "User Created Successfully.";
//            //send mail
//            $to = $_POST['email'];
//            $subject = "Registration Confirmation";
//            $res = mysqli_query($connection, "SELECT u_id FROM utente WHERE email = '$email'");
//            $current_id = mysqli_fetch_array($res);
//            $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]"."activate.php?id=" . $current_id;
//            $body = "Click this link to activate your account. <a href='" . $actual_link . "'>" . $actual_link . "</a>";
//            $mailHeaders = "From: Admin\r\n";
//            if(mail($to, $subject, $body, $mailHeaders)) {
//                $message = "You have registered and the activation mail is sent to your email. Click the activation link to activate you account.";	
//            }
//            unset($_POST);
//            header('Location: main.html');  
//        }else{
//            echo "User Registration Failed";
//        }
}


?>
