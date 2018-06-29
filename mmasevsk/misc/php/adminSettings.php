<?php
    
    require('tools.php');
    require('msg.php');
    
    function deleteAccount() {
        $user = $_POST['user'];
        require('connection.php');
		
		$keyOff = "SET FOREIGN_KEY_CHECKS=0";
		$keyOn = "SET FOREIGN_KEY_CHECKS=1";
		
		$IDuser = select("SELECT u_id FROM user WHERE username='$user'");
		echo $IDuser;
		$RSKeyOff = $connection->query($keyOff);
		
		$deleteComm = "DELETE FROM comment WHERE comment.u_id='$IDuser'";
		$resComm = $connection->query($deleteComm);
		$deleteLike = "DELETE FROM likes WHERE likes.u_id='$IDuser'";
		$resLike = $connection->query($deleteLike);
		
		$songs = select("SELECT id_song FROM library WHERE id_user='$IDuser'");
		$deleteLibrary = "DELETE FROM library WHERE library.id_user='$IDuser'";
		$resLibrary = $connection->query($deleteLibrary);
		
		for($i=0;$i<count($songs);$i++){
			$deleteSong = "DELETE FROM song where id_song='$songs[$i]'";
			$resultSong = $connection->query($deleteSong);
		}
		
		$deleteFollow = "DELETE FROM follow WHERE id_user='$IDuser' OR id_follow='$IDuser'";
		$resFollow = $connection->query($deleteFollow);
		
		$deleteRepComment = "DELETE FROM reported_comments WHERE id_reporter='$IDuser'";
		$resRComment = $connection->query($deleteRepComment);
		
		$deleteUSB = "DELETE FROM user_email_banned WHERE admin_id='$Iduser'";
		$resUSB = $connection->query($deleteUSB);
		
        $query  = "DELETE FROM user WHERE u_id='$IDuser'";
		$res = $connection->query($query);
		
		$RSKeyOn = $connection->query($keyOn);
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