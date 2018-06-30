<?php
    require('tools.php');
    require('connection.php');
    
    function comment() {
        session_start();
        $userID  = $_SESSION["userID"];
        $comment = sanitize($_POST['yourComment']);
        $song    = $_POST['id_song'];
        $date    = date("Y-m-d H-i-s");
        if ($comment != '')
            insert("INSERT INTO comment (`description`,`u_id`, `id_song`,`date_comment`) VALUES ('$comment','$userID', '$song', '$date');");
        redirect('../../player.html?id_song=' . $song);
    }
    
    function checkVote() {
        session_start();
        $userID = $_SESSION["userID"];
        $song   = $_POST['id_song'];
        return alreadyVoted($userID, $song, 'both');
    }
    
    function updateScore($score, $new) {
        $userID = $_SESSION["userID"];
        $song   = $_POST['id_song'];
        
        if (!$new) {
            $getVote = select("SELECT * FROM likes WHERE u_id='$userID' AND id_song='$song';");
            if (($score == 1 AND $getVote[0][2] == 1) OR ($score == -1 AND $getVote[0][2] == -1)) {
                delete("DELETE FROM likes WHERE u_id='$userID' AND id_song='$song';");
                redirect('../../player.html?id_song=' . $song);
            } else if ($score == 1 AND $getVote[0][2] == -1) {
                update("UPDATE likes SET score = '1' WHERE u_id='$userID' AND id_song='$song';");
                redirect('../../player.html?id_song=' . $song);
            } else if ($score == -1 AND $getVote[0][2] == 1) {
                update("UPDATE likes SET score = '-1' WHERE u_id='$userID' AND id_song='$song';");
                redirect('../../player.html?id_song=' . $song);
            }
        } else {
            insert("INSERT INTO likes (`id_song`,`u_id`, `score`) VALUES ('$song','$userID', '$score');");
            redirect('../../player.html?id_song=' . $song);
        }
    }
    
    function deleteComment() {
        session_start();
        $comm_id = $_POST['idOfComment'];
        $song    = $_POST['id_song'];
        $userID  = $_SESSION["userID"];
        delete("DELETE FROM comment WHERE comm_id=$comm_id;");
        redirect('../../player.html?id_song=' . $song);
    }
    
    function report() {
		session_start();
        $song    = $_POST['id_song'];
        $comm_id = $_POST['idOfComment'];
		$userID  = $_SESSION["userID"];
		$reason = $_POST["reason"];
        $date    = date("Y-m-d");
		openKey();
        insert("INSERT INTO reported_comments (`com_id`, `reason`, `date_report`,`id_reporter`) VALUES ('$comm_id', '$reason', '$date','$userID');");
		closeKey();
        redirect('../../player.html?id_song=' . $song);
        
    }
    
    function downloadPP($id_song) {
        $currentDownload = getDownload($id_song) + 1;
        update("UPDATE song SET download = '$currentDownload' WHERE id_song='$id_song';");
        redirect('../../player.html?id_song=' . $id_song);
    }
    
    function download() {
        $id_song   = $_REQUEST['id_song'];
        
        // Get parameters
        $file = urldecode($_REQUEST["file"]); // Decode URL-encoded string
        $filepath = "../songs/" . $file;
        // Process download
        if(file_exists($filepath)) {
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="'.basename($filepath).'"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filepath));
            flush(); // Flush system output buffer
            readfile($filepath);
        }
        downloadPP($id_song);
    }
    
    if (isset($_POST['comment'])) {
        comment();
    }
    
    if (isset($_POST['like'])) {
        if (checkVote())
            updateScore(1, false);
        else
            updateScore(1, true);
    }
    
    if (isset($_POST['dislike'])) {
        if (checkVote())
            updateScore(-1, false);
        else
            updateScore(-1, true);
    }
    
    if (isset($_POST['delete'])) {
        deleteComment();
    }
    
    if (isset($_POST['report'])) {
        report();
    }
    
    if (isset($_REQUEST["file"])){
        download();
    }
    
?>