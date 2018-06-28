<?php
    
    /*
     **Given an integer returns true if there are 0 rows from query
     */
    function checkPresence($number) {
        return ($number == 0);
    }
    
    /*
     **Returns true if password is at least 4 char ans less than 16
     */
    function checkPasswordLenght($pass) {
        return (strlen($pass) >= 4 && strlen($pass) <= 16);
    }
    
    /*
     **Returns true if password is confirmed
     */
    function confirmPassword($pass, $passConfirm) {
        return ($pass === $passConfirm);
    }
    
    /*
     **
     */
    function select($query) {
        require('connection.php');
        $statement = $connection->prepare($query);
        $statement->execute();
        return $statement->fetchAll(PDO::FETCH_BOTH);
    }
    
    /*
     **
     */
    function update($query) {
        require('connection.php');
        $statement = $connection->prepare($query);
        $statement->execute();
    }
    
    /*
     **
     */
    function insert($query) {
        require('connection.php');
        $statement = $connection->prepare($query);
        $statement->execute();
    }
    
    /*
     **
     */
    function delete($query) {
        require('connection.php');
        $statement = $connection->prepare($query);
        $statement->execute();
    }
    
    /*
     **
     */
    function redirect($url) {
        if (!headers_sent()) {
            header('Location: ' . $url);
            exit;
        } else {
            echo '<script type="text/javascript">';
            echo 'window.location.href="' . $url . '";';
            echo '</script>';
            exit;
        }
    }
    
    /*
     **
     */
    function getLikes($id) {
        $sql = select("SELECT COUNT(*) FROM likes WHERE id_song = '$id' AND score = '1';");
        return $sql[0][0];
    }
    
    function getDislikes($id) {
        $sql = select("SELECT COUNT(*) FROM likes WHERE id_song = '$id' AND score = '-1';");
        return $sql[0][0];
    }
    
    /*
     **
     */
    function alreadyVoted($user, $song, $check) {
        switch ($check) {
            case 'like':
                $getVote = select("SELECT * FROM likes WHERE u_id='$user' AND id_song='$song' AND score='1';");
                return (count($getVote) == 1);
                break;
            case 'dislike':
                $getVote = select("SELECT * FROM likes WHERE u_id='$user' AND id_song='$song' AND score='-1';");
                return (count($getVote) == 1);
                break;
            case 'both':
                $getVote = select("SELECT * FROM likes WHERE u_id='$user' AND id_song='$song';");
                return (count($getVote) == 1);
                break;
        }
    }
    
    /*
     **
     */
    function getDownload($id) {
        $sql = select("SELECT download FROM song WHERE id_song = '$id';");
        return $sql[0][0];
    }
    
    /*
     **
     */
    function cleanInput($input) {
        
        $search = array(
            '@<script[^>]*?>.*?</script>@si', // Strip out javascript
            '@<[\/\!]*?[^<>]*?>@si', // Strip out HTML tags
            '@<style[^>]*?>.*?</style>@siU', // Strip style tags properly
            '@<![\s\S]*?--[ \t\n\r]*>@' // Strip multi-line comments
        );
        
        $output = preg_replace($search, '', $input);
        return $output;
    }
    
    /*
     **
     */
    function sanitize($input) {
        if (is_array($input)) {
            foreach ($input as $var => $val) {
                $output[$var] = sanitize($val);
            }
        } else {
            if (get_magic_quotes_gpc()) {
                $input = stripslashes($input);
            }
            $input  = cleanInput($input);
            $output = $input;
        }
        return $output;
    }
    
    /*
     **
     */
    function printCard($songId, $songTitle, $songGenre, $songAuthor, $songScore, $songPicture) {
        echo '<a href="player.html?id_song=' . $songId . '">';
        echo '<div class="result-card">';
        echo '<img alt="" src="./misc/img/song-covers/' . $songPicture . '" />';
        echo '<div class="result-card-title">' . $songTitle . '</div>';
        echo '<div class="result-card-title-sub">' . $songGenre . '</div>';
        echo '<div class="result-card-title-sub">' . $songAuthor . '</div>';
        echo '<div class="result-card-title-sub">' . $songScore . ' likes</div>';
        echo '</div>';
        echo '</a>';
    }
    
    /*
     **
     */
    function printCardSearch($songId, $songTitle, $songAuthor, $songPicture) {
        echo '<a href="player.html?id_song=' . $songId . '">';
        echo '<div class="result-card">';
        echo '<img alt="" src="./misc/img/song-covers/' . $songPicture . '" />';
        echo '<div class="result-card-title">' . $songTitle . '</div>';
        echo '<div class="result-card-title-sub">' . $songAuthor . '</div>';
        echo '</div>';
        echo '</a>';
    }

    function printCardMain($songId, $songTitle, $songGenre, $songAuthor, $songPicture) {
        //echo '<a href="player.html?id_song=' . $songId . '">';
        echo '<div class="result-card">';
        echo '<img alt="" src="./misc/img/song-covers/' . $songPicture . '" />';
        echo '<div class="result-card-title">' . $songTitle . '</div>';
        echo '<div class="result-card-title-sub">' . $songGenre . '</div>';
        echo '<div class="result-card-title-sub">' . $songAuthor . '</div>';
        echo '</div>';
        //echo '</a>';
    }
    
    function printCardMainScore($songId, $songTitle, $songGenre, $songAuthor, $songScore, $songPicture) {
        //echo '<a href="player.html?id_song=' . $songId . '">';
        echo '<div class="result-card">';
        echo '<img alt="" src="./misc/img/song-covers/' . $songPicture . '" />';
        echo '<div class="result-card-title">' . $songTitle . '</div>';
        echo '<div class="result-card-title-sub">' . $songGenre . '</div>';
        echo '<div class="result-card-title-sub">' . $songAuthor . '</div>';
        echo '<div class="result-card-title-sub">' . $songScore . ' likes</div>';
        echo '</div>';
        //echo '</a>';
    }
?>