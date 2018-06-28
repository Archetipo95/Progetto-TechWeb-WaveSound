<?php
session_start();
require('tools.php');


function follow(){
	$follower = $_SESSION["userID"];
	$followed = $_POST["follow"];
	insert("INSERT INTO follow (id_user, id_follow) VALUES ('$follower','$followed')");
	redirect('..\..\user.html?userID='.$_POST["follow"]);
}	

function unfollow(){
    $follower = $_SESSION["userID"];
    $followed = $_POST["unfollow"];
    delete("DELETE FROM follow WHERE id_follow = '$followed' AND id_user = '$follower'");
    redirect('..\..\user.html?userID='.$followed);
}

if (isset($_POST['unfollow'])) {
	unfollow();;
}

if (isset($_POST['follow'])) {
	follow();;
}

?>