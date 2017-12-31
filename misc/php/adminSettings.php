<?php
	function deleteAccount(){
    	echo "delete account";
	}

	function newAdmin(){
    	echo "New Admin";
	}

	if(isset($_POST['deleteAccount'])){
		deleteAccount();
	}

	if(isset($_POST['newAdmin'])){
		newAdmin();
	}
?>