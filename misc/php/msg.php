<?php

function sendMessage($msg){
	session_start();
	$_SESSION["msg"] = $msg;
	header("Location:../../msg.html");
}

?>