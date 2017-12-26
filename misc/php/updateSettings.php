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
**true is at 1st post not empty
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
	
	for($i=0;$i<count($toBeChanged);$i++){
		switch ($toBeChanged[$i]) {
			case 0://username
				$username = $_POST["username"];
				$query ="SELECT u_id FROM user WHERE username='$username';";
				$result = $connection->query($query);
        		if (checkPresence($result->num_rows)){
					session_start();
					//cerca userID e metti al posto di username $username
				}else{
					//user già preso gestire errore....
				}
				break;
			case 1://name
				$name = $_POST["name"];
				session_start();
				//cerca userID e metti al posto di name $name
				break;
			 case 2://surname
				$surname = $_POST["surname"];
				session_start();
				//cerca userID e metti al posto di surname $surnamme
				break;
			 case 3://birthday
				$birthday = $_POST["birthday"];
				session_start();
				//cerca userID e metti al posto di birtday $birthday
				break;
			 case 4://email
				$email = $_POST["email"];
				if(filter_var($email,FILTER_VALIDATE_EMAIL)){
					$query ="SELECT u_id FROM user WHERE email='$email';";
					$result = $connection->query($query);
        			if (checkPresence($result->num_rows)){
						session_start();
						//cerca userID e metti al posto di email &email
					}else{
						//email già presa gestire errore....
					}
				}else{
					//email non valida gestire errore...
				}
				break;
			 case 5://oldpassword
				if(!empty($_POST['newPassword']) && !empty($_POST['newPasswordConfirm'])){
					$oldPassword = $_POST['oldPassword'];
					$newPassword = $_POST['newPassword'];
					$newPasswordConfirm = $_POST['newPasswordConfirm'];
					if(checkPasswordLenght($newPassword) && confirmPassword($newPassword, $newPasswordConfirm)){
						if(/*controllare che oldP sia uguale quella nel DB per motivi di sicurezza*/){
							//fare il cambio di password ....con hash e tutto il resto
						}else{
							//old pass sbagliata
						}
					}else{
						//new pass corta o diversa da confirm gestire...
					}
				}else{
					//campo newPass o newPassConfir VUOTI gestire errore...
				}
				break;
		}
	}	
}else{
	sendMessage("Nothing to change");
}

?>