<?php
	require('tools.php');
	
	function comment(){
		session_start();
		$userID= $_SESSION["userID"];
		$comment = $_POST['yourComment'];
		$song = $_POST['id_song'];
		
		if($comment != '')
			insert("INSERT INTO comment (`description`,`u_id`, `id_song`) VALUES ('$comment','$userID', '$song');");
		header("Location:../../listen.html?id_song=".$song);
	}

	if(isset($_POST['comment'])){
		comment();
	}
	
	function checkVote(){
		session_start();
		$userID= $_SESSION["userID"];
		$song = $_POST['id_song'];
		$getVote = select("SELECT * FROM likes WHERE u_id='$userID' AND id_song='$song';");
		if(count($getVote)==1)
			return true;
		else
			return false;
	}

	function updateScore($score, $new){
		$userID= $_SESSION["userID"];
		$song = $_POST['id_song'];
		
		if(!$new){
			$getVote = select("SELECT * FROM likes WHERE u_id='$userID' AND id_song='$song';");
			if(($score==1 AND $getVote[0][2]==1) OR ($score==-1 AND $getVote[0][2]==-1)){
				delete("DELETE FROM likes WHERE u_id='$userID' AND id_song='$song';");
				header("Location:../../listen.html?id_song=".$song);
			}else if($score==1 AND $getVote[0][2]==-1){
				update("UPDATE likes SET score = '1' WHERE u_id='$userID' AND id_song='$song';");
				header("Location:../../listen.html?id_song=".$song);
			}else if($score==-1 AND $getVote[0][2]==1){
				update("UPDATE likes SET score = '-1' WHERE u_id='$userID' AND id_song='$song';");
				header("Location:../../listen.html?id_song=".$song);
			}
		}
		else{
			insert("INSERT INTO likes (`id_song`,`u_id`, `score`) VALUES ('$song','$userID', '$score');");
			header("Location:../../listen.html?id_song=".$song);
		}
	}

	if(isset($_POST['like'])){
		if(checkVote())
			updateScore(1, false);
		else
			updateScore(1, true);
	}

	if(isset($_POST['dislike'])){
		if(checkVote())
			updateScore(-1, false);
		else
			updateScore(-1, true);
	}

//Total numbers of likes
function getLikes($id){
    $sql = "SELEC COUNT(*) FROM likes WHERE id_song = $id AND score = 1";
    $rs = select($sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

//Total dislikes
function getDislikes($id){
    $sql = "SELEC COUNT(*) FROM likes WHERE id_song = $id AND score = -1";
    $rs = select($sql);
    $result = mysqli_fetch_array($rs);
    return $result[0];
}

?>