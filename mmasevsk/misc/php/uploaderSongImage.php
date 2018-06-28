<?php
    require('checkSession.php');
    
    require('msg.php');
    
    $target_dir    = "../img/song-covers/";
    $temp = explode(".", $_FILES["fileToUpload"]["name"]);
    $name_file = round(microtime(true)) . '.' . end($temp);
    $target_file = $target_dir . $name_file;
    $uploadOk      = 1;
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is a actual image or fake image
    
    if (isset($_POST["submit"])) {
        $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
        if ($check !== false) {
            sendMessage("File is an image - " . $check["mime"] . ".");
            $uploadOk = 1;
        } else {
            sendMessage("File is not an image.");
            $uploadOk = 0;
        }
    }
    
    // Check file size
    
    if ($_FILES["fileToUpload"]["size"] > 500000) {
        sendMessage("Sorry, your file is too large.");
        $uploadOk = 0;
    }
    
    // Allow certain file formats
    
    if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
        sendMessage("Sorry, only JPG, JPEG & PNG files are allowed.");
        $uploadOk = 0;
    }
    
    // Check if $uploadOk is set to 0 by an error
    
    if ($uploadOk == 0) {
        sendMessage("Sorry, your file was not uploaded.");
        
        // if everything is ok, try to upload file
        
    } else {
        
        
        if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
            echo "The file " . basename($_FILES["fileToUpload"]["name"]) . " has been uploaded.";

            require('tools.php');
            
            $id_song = $_POST['id_song'];

            update("UPDATE song SET picture = '$name_file' WHERE id_song = '$id_song' ");
            sendMessage("Your song image was updated");
        } else {
            sendMessage("Sorry, there was an error uploading your file.");
        }
    }
    
?>