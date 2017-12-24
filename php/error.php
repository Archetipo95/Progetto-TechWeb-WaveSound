<?php

function sendError($msg){
	session_start();
	$_SESSION["error"] = $msg;
	header("Location:../error.html");
}

?>