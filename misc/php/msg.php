<?php

function sendMessage($msg){
	session_start();
	$_SESSION["msg"] = $msg;
	$_SESSION["link"] = $link;

	header("Location:../../msg.html");
}

?>