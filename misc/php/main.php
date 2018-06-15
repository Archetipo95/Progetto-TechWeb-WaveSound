<?php
    require('misc/php/tools.php');
    $query = select("SELECT likes.id_song as canzone,title,genre.name,username,SUM(CASE WHEN score > 0 THEN 1 ELSE 0 END) AS somma,picture FROM likes,song,library,user,genre WHERE likes.id_song=song.id_song AND library.id_song=song.id_song AND library.id_user=user.u_id AND song.genre=genre.id_genre GROUP BY likes.id_song ORDER BY somma DESC LIMIT 5");
    
    if (count($query) > 0) {
        echo '<h2 class="content-title">Trending</h2>';
        echo '<div class="results-container">';
        for ($i = 0; $i < count($query); $i++) {
            $song        = $query[$i][0];
            $title       = $query[$i][1];
            $genre       = $query[$i][2];
            $username    = $query[$i][3];
            $score       = $query[$i][4];
            $pathPicture = $query[$i][5];
            
            printCard($song, $title, $genre, $username, $score, $pathPicture);
            
        }
        echo '</div>';
    }
    
    $query2 = select("SELECT vista_query2.canzone,vista_query2.title,vista_query2.name,vista_query2.username,MAX(vista_query2.somma) AS massimo,vista_query2.picture FROM vista_query2 GROUP BY name ORDER BY massimo DESC LIMIT 5");
    
    if (count($query2) > 0) {
        echo '<h2 class="content-title">Hot Music in Top Genres</h2>';
        echo '<div class="results-container">';
        for ($i = 0; $i < count($query2); $i++) {
            $song        = $query2[$i][0];
            $title       = $query2[$i][1];
            $genre       = $query2[$i][2];
            $username    = $query2[$i][3];
            $score       = $query2[$i][4];
            $pathPicture = $query2[$i][5];
            
            printCard($song, $title, $genre, $username, $score, $pathPicture);
        }
        echo '</div>';
    }
    
    $query3 = select("SELECT likes.id_song as canzone,title,genre.name,username,SUM(CASE WHEN score > 0 THEN 1 ELSE 0 END) AS somma,picture FROM likes,song,library,user,genre WHERE likes.id_song=song.id_song AND library.id_song=song.id_song AND library.id_user=user.u_id AND song.genre=genre.id_genre GROUP BY likes.id_song ORDER BY upload_date DESC LIMIT 5");
    
    if (count($query3) > 0) {
        echo '<h2 class="content-title">New Music</h2>';
        echo '<div class="results-container">';
        for ($i = 0; $i < count($query3); $i++) {
            $song        = $query3[$i][0];
            $title       = $query3[$i][1];
            $genre       = $query3[$i][2];
            $username    = $query3[$i][3];
            $score       = $query3[$i][4];
            $pathPicture = $query3[$i][5];
            
            printCard($song, $title, $genre, $username, $score, $pathPicture);
        }
        echo '</div>';
    }
?>