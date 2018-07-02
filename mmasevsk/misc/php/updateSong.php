<?php
    
    require('connection.php');
    require('msg.php');
    require('tools.php');

    if (isset($_POST['default'])) {
        $id_song = $_POST['id_song'];
        $default = 'default'.rand(1,10).'.png';
        update("UPDATE song SET picture = '$default' WHERE id_song = '$id_song' ");
        sendMessage("Image cover reset to default");
    } else if(isset($_POST['delete'])) {
        $id_song = $_POST['id_song'];
		openKey();
        deleteDependenciesSongByIDsong($id_song);
		$deleteSong = "DELETE FROM song where id_song='$id_song'";
		$resultSong = $connection->query($deleteSong);
		closeKey();
        sendMessage("Your song was correctly deleted");
    } 
        else {
        $postName    = array(
            "title",
            "description",
            "genre"
        );
        $toBeChanged = array();
    
        /*
         **true at 1st post not empty
         */
        function checkPost() {
            global $postName;
            for ($i = 0; $i < count($postName); $i++) {
                if (!empty($_POST[$postName[$i]])) {
                    return true;
                }
            }
            return false;
        }
        
        /*
         **find element to change
         */
        function toBeChanged() {
            global $postName, $toBeChanged;
            for ($i = 0; $i < count($postName); $i++) {
                if (!empty($_POST[$postName[$i]])) {
                    array_push($toBeChanged, "$i");
                }
            }
        }
        
        if (checkPost()) {
            global $postName, $toBeChanged;
            toBeChanged();
            session_start();
            $userID = $_SESSION["userID"];
            $id_song = $_POST["id_song"];
            $errors;
            
            for ($i = 0; $i < count($toBeChanged); $i++) {
                switch ($toBeChanged[$i]) {
                    case 0: //title
                        $title = sanitize($_POST["title"]);
                        
                        if ($title != '') {
                            update("UPDATE song SET title = '$title' WHERE id_song = '$id_song' ");
                        } else {
                            $errors = $errors . "Problem with title song";
                        }
                        break;
                    case 1: //description
                        $description = sanitize($_POST["description"]);
                        
                        if ($description != '') {
                            update("UPDATE song SET description = '$description' WHERE id_song = '$id_song' ");
                        } else {
                            $errors = $errors . " Problem with description song";
                        }
                        break;
                    case 2: //surname
                        $genre_id = $_POST["genre"];
                        update("UPDATE song SET genre = '$genre_id' WHERE id_song = '$id_song' ");
                        break;
                }
            }
            if ($errors === NULL)
                $errors = "Everything was updated";
            sendMessage("$errors");
        } else {
            sendMessage("Nothing to change");
        }
    }
?>