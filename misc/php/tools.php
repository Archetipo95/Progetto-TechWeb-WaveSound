<?php

/*
**hash password
*/
function securedHash($input){    
		return password_hash($input,PASSWORD_DEFAULT);
	}

/*
**Given an integer returns true if there are 0 rows from query
*/
function checkPresence($number){
	return ($number===0);
}

/*
**Returns true if password is at least 8 char
*/
function checkPasswordLenght($pass){
	return (strlen($pass) >= 8);
}

/*
**Returns true if password is confirmed
*/
function confirmPassword($pass, $passConfirm){
	return ($pass === $passConfirm);
}

?>