<?php
/*

BISOGNA RICORDARE TUTTI GLI ERRORI CHE AVVENGNO NELLO SWITCH COSI DA RIMANDARE ALLA PAGINA MSG.HTML CON UN MSG UNICO

*/

	require('connection.php');
	require('msg.php');
	require('tools.php');

$postName = array("username","name","surname","birthday","email","oldPassword");
$toBeChanged = array();
  	
/*
**true at 1st post not empty
*/
function checkPost(){
	global $postName;
	for($i=0;$i<count($postName);$i++){
		if(!empty($_POST[$postName[$i]])){
			return true;
		}
	}
	return false;
}

/*
**find element to change
*/
function toBeChanged(){
	global $postName,$toBeChanged;
	for($i=0;$i<count($postName);$i++){
		if(!empty($_POST[$postName[$i]])){
			array_push($toBeChanged,"$i");
		}
	}
}

if(checkPost()){
	//echo "there is at least 1 post set <br>";
	global $postName,$toBeChanged;
	toBeChanged();
	session_start();
	$userID= $_SESSION["userID"];
	$errors;
	
	for($i=0;$i<count($toBeChanged);$i++){
		switch ($toBeChanged[$i]){
			case 0://username
				$username = $_POST["username"];
				$query ="SELECT u_id FROM user WHERE username='$username';";
				$result = $connection->query($query);
        		if (checkPresence($result->num_rows)){
					$userID= $_SESSION["userID"];
					$queryUser = "UPDATE user SET username = '$username' WHERE u_id = '$userID' ";
					$UserResult = $connection->query($queryUser);
					session_start();
					$_SESSION["username"] = $username;
				}else{
					$errors = $errors . "Username already taken";
				}
				break;
			case 1://name
				$name = $_POST["name"];
				$queryName = "UPDATE user SET name = '$name' WHERE u_id = '$userID' ";
				$NameResult = $connection->query($queryName);
				break;
			 case 2://surname
				$surname = $_POST["surname"];
				$querySurname = "UPDATE user SET surname = '$surname' WHERE u_id = '$userID' ";
				$SurnameResult = $connection->query($querySurname);
				break;
			 case 3://birthday
				$birthday = $_POST["birthday"];
				$queryBirth = "UPDATE user SET birthday = '$birthday' WHERE u_id = '$userID' ";
				$BirthResult = $connection->query($queryBirth);
				break;
			 case 4://email
				$email = $_POST["email"];
				if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					$query ="SELECT u_id FROM user WHERE email='$email';";
					$result = $connection->query($query);
        			if (checkPresence($result->num_rows)){
						$queryMail = "UPDATE user SET email = '$email' WHERE u_id = '$userID' ";
						$MailResult = $connection->query($queryMail);
					}else{
						$errors = $errors . " Email already used";
					}
				}else{
					$errors = $errors . " Email not valid";
				}
				break;
			 case 5://oldpassword
				if(!empty($_POST['newPassword']) && !empty($_POST['newPasswordConfirm'])){
					$oldPassword = $_POST['oldPassword'];
					$newPassword = $_POST['newPassword'];
					$newPasswordConfirm = $_POST['newPasswordConfirm'];
					if(checkPasswordLenght($newPassword) && confirmPassword($newPassword, $newPasswordConfirm)){
						$query = "SELECT password FROM user WHERE u_id = '$userID' ";
						$result = $connection->query($query);
						$row = mysqli_fetch_row($result);
						if(password_verify($oldPassword,$row[0])){
							$hash = securedHash($newPassword);
							$query = "UPDATE user SET password = '$hash' WHERE u_id = '$userID' ";
							$result = $connection->query($query);
						}else{
							$errors = $errors . " Old password is wrong";
						}	
					}else{
						$errors = $errors . " New password too short or different from confirm";
					}
				}else{
					$errors = $errors.+ " New password or confirm empty";
				}
				break;
		}
	}
	if($errors === NULL)
		$errors = "Everything was updated";
	sendMessage("$errors");
}else{
	sendMessage("Nothing to change");
}
?>