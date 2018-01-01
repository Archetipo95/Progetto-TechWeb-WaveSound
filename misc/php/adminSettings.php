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
?>