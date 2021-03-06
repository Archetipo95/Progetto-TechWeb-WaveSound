<?php
    if (isset($_POST['search'])) {
        $keyword = sanitize($_POST['search']);
        $query   = select("SELECT song.id_song,title,username,picture FROM song,library,user WHERE library.id_song=song.id_song AND library.id_user=user.u_id AND title LIKE '%$keyword%' ORDER BY title ASC");
        if (count($query) > 0) {
            echo 'Search results from title:';
            echo '<div class="results-container">';
            for ($i = 0; $i < count($query); $i++) {
                $song        = $query[$i][0];
                $title       = $query[$i][1];
                $username    = $query[$i][2];
                $pathPicture = $query[$i][3];
                printCardSearch($song, $title, $username, $pathPicture);
            }
            echo '</div>';
        }
        $query2 = select("SELECT username,name,surname,avatar,u_id FROM user WHERE username LIKE '%$keyword%' OR name LIKE '%$keyword%' OR surname LIKE '%$keyword%'");
        if (count($query2) > 0) {
            echo 'Search results from autor:';
            echo '<div class="results-container">';
            for ($i = 0; $i < count($query2); $i++) {
                $username = $query2[$i][0];
                $name     = $query2[$i][1];
                $surname  = $query2[$i][2];
                $avatar   = $query2[$i][3];
                $userID   = $query2[$i][4];
                printCardSearchAuthor($username, $name, $surname, $avatar, $userID);
            }
            echo '</div>';
        }
    }
    if (isset($_POST['order'])) {
        $genre = $_POST['genre'];
        $sort  = $_POST['sort'];
        $order = $_POST['order'];
        $query = select("SELECT title,genre.name,upload_date,download,id_song,picture FROM song,genre WHERE song.genre=id_genre AND id_genre='$genre' ORDER BY $sort $order");
        $genre = $query[0][1];
        echo 'Songs in ' . $genre . ' genre sorted by ' . $sort . ' in ' . $order . ' order';
        echo '<div class="results-container">';
        for ($i = 0; $i < count($query); $i++) {
            $title       = $query[$i][0];
            $upload_date = $query[$i][2];
            $download    = $query[$i][3];
            $song        = $query[$i][4];
            $pathPicture = $query[$i][5];
            printCardSearchAdvanced($title, $upload_date, $download, $song, $pathPicture);
        }
        echo '</div>';
    }
?>