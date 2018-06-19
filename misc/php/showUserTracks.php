<?php
				require('misc/php/tools.php');
				$user_id = $_SESSION["userID"];
				$getSongs = select("SELECT id_song FROM library WHERE id_user='$user_id'");

				if(count($getSongs)>0){
					for($i=0; $i<count($getSongs); $i++){
						$idsong = $getSongs[$i];
                    }

                  
                   $query = select("SELECT likes.id_song as canzone,title,genre.name,username,SUM(CASE WHEN score > 0 THEN 1 ELSE 0 END) AS somma,picture FROM likes,song,library,user,genre WHERE likes.id_song=song.id_song AND library.id_song=song.id_song AND library.id_user=user.u_id AND song.genre=genre.id_genre AND library.id_user = '$user_id' GROUP BY song.title");
    
                    if (count($query) > 0) {
                   
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
                 }
		          
			     else {
				    echo "You have no songs.<br />";
				    echo 'Use this <a href="upload-song.html">link</a> to upload a new song!';
                 }
            ?>