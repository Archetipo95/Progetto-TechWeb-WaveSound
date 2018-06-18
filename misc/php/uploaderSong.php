<?php
    require('msg.php');
    
    if (isset($_POST['submit'])) {
        $allowedExts = array(
            "mp3"
        );
        $fileName    = $_FILES['file']['name'];
        $extension   = substr($fileName, strrpos($fileName, '.') + 1); // getting the info about the image to get its extension
        
        if (in_array($extension, $allowedExts)) {
            if ($_FILES["file"]["error"] > 0) {
                sendMessage('Error: ' . $_FILES["file"]["error"]);
            } else {
                if (file_exists("../songs/" . $_FILES["file"]["name"])) {
                    sendMessage('File already exists');
                } else {
                    require('tools.php');
                    session_start();
                    $userID      = $_SESSION["userID"];
                    $title       = $_POST['title'];
                    $genre       = $_POST['genre'];
                    $description = $_POST['title'];
                    $path        = $_FILES["file"]["name"];
                    $date        = date("Y-m-d");
                    $picture     = "default1.png";
                    
                    $query = "INSERT INTO song (`title`,`genre`,`description`,`path`,`upload_date`,`picture`) VALUES ('$title','$genre','$description','$path','$date','$picture');";
                    require('connection.php');
                    $statement = $connection->prepare($query);
                    $statement->execute();
                    
                    $lastID = $connection->lastInsertId();
                    
                    insert("INSERT INTO library (`id_user`,`id_song`) VALUES ('$userID','$lastID');");
                    move_uploaded_file($_FILES["file"]["tmp_name"], "../songs/" . $_FILES["file"]["name"]);
                    sendMessage('File uploaded');
                }
            }
        } else {
            sendMessage('Invalid file');
        }
    }
?>