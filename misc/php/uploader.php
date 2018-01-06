<?php

require('checkSession.php');
require('msg.php');


$target_dir = "../img/users/";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        sendMessage("File is an image - " . $check["mime"] . ".");
        $uploadOk = 1;
    } else {
        sendMessage("File is not an image.");
        $uploadOk = 0;
    }
}
// Check if file already exists
if (file_exists($target_file)) {
    sendMessage("Sorry, file already exists.");
    $uploadOk = 0;
}
// Check file size
if ($_FILES["fileToUpload"]["size"] > 500000) {
    sendMessage("Sorry, your file is too large.");
    $uploadOk = 0;
}
// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg") {
    sendMessage("Sorry, only JPG, JPEG & PNG files are allowed.");
    $uploadOk = 0;
}
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    sendMessage("Sorry, your file was not uploaded.");
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $target_file)) {
        echo "The file ". basename( $_FILES["fileToUpload"]["name"]). " has been uploaded.";
		$_SESSION["avatar"] = basename( $_FILES["fileToUpload"]["name"]);
		/*aggiornare db*/
		require('connection.php');
		$avatar = $_SESSION["avatar"];
		$userID = $_SESSION["userID"];
		$updateAvatar = "UPDATE user SET avatar = '$avatar' WHERE u_id = '$userID' ";
		$result = $connection->query($updateAvatar);
		sendMessage("Your avatar image was updated");
    } else {
        sendMessage("Sorry, there was an error uploading your file.");
    }
}
?>
