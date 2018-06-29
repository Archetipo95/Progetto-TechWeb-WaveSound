<?php
    
    require('tools.php');
    require('msg.php');
    
    function deleteAccount() {
        $user = $_POST['user'];
        require('connection.php');
		
		$IDuser = select("SELECT u_id FROM user WHERE username='$user'");
		$id = $IDuser[0][0];
	
		$songs = select("SELECT id_song FROM library WHERE id_user='$id'");
		
		deleteDependenciesSong($id);
		
		openKey();

		for($i=0;$i<count($songs);$i++){
			$sn = $songs[$i][0];
			$deleteSong = "DELETE FROM song where id_song='$sn'";
			$resultSong = $connection->query($deleteSong);
		}
		
		closeKey();
		
		deleteDependenciesUser($id);
		
		openKey();
		
        $query  = "DELETE FROM user WHERE u_id='$id'";
		$res = $connection->query($query);
		
		closeKey();
		
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