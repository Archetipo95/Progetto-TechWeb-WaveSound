<?php
	require('tools.php');
	
	function comment(){
		session_start();
		$userID= $_SESSION["userID"];
		$comment = $_POST['yourComment'];
		$song = $_POST['id_song'];
		
		if($comment != '')
			insert("INSERT INTO comment (`description`,`u_id`, `id_song`) VALUES ('$comment','$userID', '$song');");
		redirect('../../listen.html?id_song='.$song);
	}

	if(isset($_POST['comment'])){
		comment();
	}
	
	function checkVote(){
		session_start();
		$userID= $_SESSION["userID"];
		$song = $_POST['id_song'];
		return alreadyVoted($userID,$song,'both');
	}

	function updateScore($score, $new){
		$userID= $_SESSION["userID"];
		$song = $_POST['id_song'];
		
		if(!$new){
			$getVote = select("SELECT * FROM likes WHERE u_id='$userID' AND id_song='$song';");
			if(($score==1 AND $getVote[0][2]==1) OR ($score==-1 AND $getVote[0][2]==-1)){
				delete("DELETE FROM likes WHERE u_id='$userID' AND id_song='$song';");
		redirect('../../listen.html?id_song='.$song);
			}else if($score==1 AND $getVote[0][2]==-1){
				update("UPDATE likes SET score = '1' WHERE u_id='$userID' AND id_song='$song';");
		redirect('../../listen.html?id_song='.$song);
			}else if($score==-1 AND $getVote[0][2]==1){
				update("UPDATE likes SET score = '-1' WHERE u_id='$userID' AND id_song='$song';");
		redirect('../../listen.html?id_song='.$song);
			}
		}
		else{
			insert("INSERT INTO likes (`id_song`,`u_id`, `score`) VALUES ('$song','$userID', '$score');");
		redirect('../../listen.html?id_song='.$song);
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

function deleteComment(){
	session_start();
	$comm_id = $_POST['idOfComment'];
	$song = $_POST['id_song'];
	$userID= $_SESSION["userID"];
	delete("DELETE FROM comment WHERE comm_id=$comm_id;");
	redirect('../../listen.html?id_song='.$song);
}

if(isset($_POST['delete'])){
		deleteComment();
	}

function report(){
	$song = $_POST['id_song'];
	$comm_id = $_POST['idOfComment'];
	$date = date("Y-m-d");
	insert("INSERT INTO warning_comments (`com_id`, `reason`, `date_warning`) VALUES ('$comm_id', 'reason', '$date');");
	redirect('../../listen.html?id_song='.$song);
	
}

if(isset($_POST['report'])){
		report();
	}

?>