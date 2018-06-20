<?php
    $userFollow = $_GET["userID"];
    $followers = select("SELECT id_follow FROM follow WHERE id_user = '$userFollow'");
    $numfollowers = count($followers);
?>


