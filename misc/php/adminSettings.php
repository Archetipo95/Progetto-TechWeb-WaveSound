<?php

	require('tools.php');

	function deleteAccount(){
		$user=$_POST['user'];
		require('connection.php');
		$query="DELETE FROM user WHERE username='$user' ";
		$result = $connection->query($query);
    	echo "delete account";
	}

	function newAdmin(){
		$user=$_POST['user'];
		update("UPDATE user SET user_type = '1' WHERE username = '$user' ");
    	echo "New Admin";
	}

	function takeAdmin(){
		$user=$_POST['user'];
		update("UPDATE user SET user_type = '0' WHERE username = '$user' ");
    	echo "Take Admin";
	}

	function ignoreComment(){
		$com_id=$_POST['id'];
		delete("DELETE FROM warning_comments WHERE com_id='$com_id'");
		echo "Segnalazione ignorata";
	}
	
	function deleteComment(){
		$com_id=$_POST['id'];
		delete("DELETE FROM warning_comments WHERE com_id='$com_id'");
		delete("DELETE FROM comment WHERE comm_id='$com_id' ");
		echo "Commento eliminato";
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

	if(isset($_POST['ignoreComment'])){
		ignoreComment();
	}

	if(isset($_POST['deleteComment'])){
		deleteComment();
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
