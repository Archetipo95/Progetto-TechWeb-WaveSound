<?php
	
	session_start();
	session_unset();
	session_destroy();

	require('msg.php');
	sendMessage("You have successfully logged out", 1);

?>