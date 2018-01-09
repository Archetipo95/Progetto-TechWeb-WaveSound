<?php

	function deleteAccount(){
    	echo "delete account";
	}

	function newAdmin(){
    	echo "New Admin";
	}

	function takeAdmin(){
    	echo "Take Admin";
	}

	if(isset($_POST['deleteAccount'])){
		deleteAccount();
	}

	if(isset($_POST['newAdmin'])){
		newAdmin();
	}

	if(isset($_POST['takeAdmin'])){
		takeAdmin();
	}

	function resetAvatar(){
		require('tools.php');
		session_start();
		$userID= $_SESSION["userID"];
		update("UPDATE user SET avatar = 'default-profile.png' WHERE u_id = '$userID' ");
		header("Location:../../user-settings.html");
	}

	if(isset($_POST['resetAvatar'])){
			resetAvatar();
	}
?>
