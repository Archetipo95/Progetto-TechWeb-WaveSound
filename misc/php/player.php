<?php
	require('tools.php');
	
	function comment(){
		session_start();
		$userID= $_SESSION["userID"];
		$comment = $_POST['yourComment'];
		$song = $_POST['id_song'];
		
		insert("INSERT INTO comment (`description`,`u_id`, `id_song`) VALUES ('$comment','$userID', '$song');");
		header("Location:../../listen.html?id_song=".$song);
	}

	if(isset($_POST['comment'])){
		comment();
	}

?>