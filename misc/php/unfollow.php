<?php
    session_start();
    require('tools.php');
    $follower = $_SESSION["userID"];
    $followed = $_POST["unfollow"];
    delete("DELETE FROM follow WHERE id_follow = '$followed' AND id_user = '$follower'");
    redirect('..\..\user.html?userID='.$_POST["unfollow"]);
?>