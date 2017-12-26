<?php
/*

MOLTE FUNZIONI DI REGISTER.PHP SONO UGUALI BISOGNA ESTRARLE IN UN PHP NUOVO
COSI DA NON DOVER RISCRIVERE TUTTE LE FUNZIONI

BISOGNA RICORDARE TUTTI GLI ERRORI CHE AVVENGNO NELLO SWITCH COSI DA RIMANDARE ALLA PAGINA MSG.HTML CON UN MSG UNICO

BISOGNA USARE UID NELLE SESSIONI

*/

	require('connection.php');
	require('msg.php');

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

/*
**Given an integer returns true if there are 0 rows from query
*/
function checkPresence($number){
	return ($number===0);
}

if(checkPost()){
	//echo "there is at least 1 post set <br>";
	global $postName,$toBeChanged;
	toBeChanged();
	
	for($i=0;$i<count($toBeChanged);$i++){
		switch ($toBeChanged[$i]) {
			case 0://username
				echo "username";
				$username = $_POST["username"];
				//estrai user con questo username
				$query ="SELECT u_id FROM user WHERE username='$username';";
				$result = $connection->query($query);
        		if (checkPresence($result->num_rows)){
					//user disponibile
				}else{
					//user già preso
				}
				break;
			case 1://name
				echo "name";
				$name = $_POST["name"];
				//in base al session U_ID inserisci $name nel DB
				break;
			 case 2://surname
				echo "surname";
				$surname = $_POST["surname"];
				//in base al session U_ID inserisci $surname nel DB
				break;
			 case 3://birthday
				echo "birthday";
				//come per name e surname vedi nome esatto di compleanno....non ricordo
				break;
			 case 4://email
				echo "email";
				$email = $_POST["email"];
				//sarebbe da controllare validità email con funziona di register.php
				$query ="SELECT u_id FROM user WHERE email='$email';";
				$result = $connection->query($query);
        		if (checkPresence($result->num_rows)){
					//email non usata -> disponibile
				}else{
					//email già usata
				}
				break;
			 case 5://oldpassword
				echo "oldpassword";
				//bisogna controllare che ci sia il post di newpassword e newpasswordCofir
				//controllare che newP sia almeno 8 char
				//controllare che newP e newPC siano uguali
				//controllare che oldP sia uguale quella nel DB "motivi di sicurezza"
				//fare il cambio di password ....con hash e tutto il resto
				break;
		}
	}	
}else{
	sendMessage("Nothing to change");
}

?>