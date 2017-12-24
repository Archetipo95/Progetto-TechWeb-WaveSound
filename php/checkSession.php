<?php
	session_start();
    if(!isset($_SESSION['username'])){
    	header("location:index.html");
    }else{
		header("location:logout.php");
	}
?>