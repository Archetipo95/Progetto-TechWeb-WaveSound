<?php
	session_start();
    if(!isset($_SESSION['username'])){
    	header("location:misc/php/logout.php");
    }
?>