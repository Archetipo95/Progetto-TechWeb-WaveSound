<?php
session_start();
require('tools.php');
$follower = $_SESSION["userID"];
$followed = $_POST["follow"];
insert("INSERT INTO follow (id_user, id_follow) VALUES ('$follower','$followed')");
redirect('..\..\user.html?userID='.$_POST["follow"]);
?>