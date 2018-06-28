<?php
    
    require('tools.php');
    require('msg.php');
    
    function deleteAccount() {
        $user = $_POST['user'];
        require('connection.php');
        $query  = "DELETE FROM user WHERE username='$user' ";
        /*
            cosa eliminare
            user
            library
            song
            commenti
            likes
            reported comments
            follow
        */
        $result = $connection->query($query);
        sendMessage("$user account deleted");
    }
    
    function newAdmin() {
        $user = $_POST['user'];
        update("UPDATE user SET user_type = '1' WHERE username = '$user' ");
        sendMessage("$user is admin now");
    }
    
    function takeAdmin() {
        $user = $_POST['user'];
        update("UPDATE user SET user_type = '0' WHERE username = '$user' ");
        sendMessage("$user is no longer admin");
    }
    
    function ignoreComment() {
        $com_id = $_POST['id'];
        delete("DELETE FROM reported_comments WHERE com_id='$com_id'");
        sendMessage("Comment ignored");
    }
    
    function deleteComment() {
        $com_id = $_POST['id'];
        delete("DELETE FROM reported_comments WHERE com_id='$com_id'");
        delete("DELETE FROM comment WHERE comm_id='$com_id' ");
        sendMessage("Comment deleted");
    }
    
    function resetAvatar() {
        session_start();
        $userID = $_SESSION["userID"];
        update("UPDATE user SET avatar = 'default-profile.png' WHERE u_id = '$userID' ");
        $_SESSION["avatar"] = 'default-profile.png';
        header("Location:../../user-settings.html");
    }
    
    if (isset($_POST['deleteAccount'])) {
        deleteAccount();
    }
    
    if (isset($_POST['newAdmin'])) {
        newAdmin();
    }
    
    if (isset($_POST['takeAdmin'])) {
        takeAdmin();
    }
    
    if (isset($_POST['ignoreComment'])) {
        ignoreComment();
    }
    
    if (isset($_POST['deleteComment'])) {
        deleteComment();
    }
    
    if (isset($_POST['resetAvatar'])) {
        resetAvatar();
    }
?>