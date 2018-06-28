<?php
    session_start();
    if (!isset($_SESSION['userID'])) {
        header("location:misc/php/logout.php");
    }
?>