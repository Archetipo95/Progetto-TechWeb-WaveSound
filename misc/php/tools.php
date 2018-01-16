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
**Returns true if password is at least 4 char ans less than 16
*/
function checkPasswordLenght($pass){
	return (strlen($pass) >= 4 && strlen($pass) <= 16);
}

/*
**Returns true if password is confirmed
*/
function confirmPassword($pass, $passConfirm){
	return ($pass === $passConfirm);
}

function select($query){
	require ('connection.php');
	$result = $connection->exec($query);
	return $result;
}

function update($query){
	require ('connection.php');
	$result = $connection->exec($query);
}

function insert($query){
	require ('connection.php');
	$result = $connection->exec($query);
}

function delete($query){
	require('connection.php');
	$result= $connection->exec($query);
}

?>