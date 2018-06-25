<?php

                 if($_GET["userID"]!=$_SESSION["userID"]){
                 $checkfollow = select("SELECT id_follow FROM follow WHERE id_user = '$_SESSION["userID""]' AND id_follow = '$_GET["userID"]'");
                 if(count($checkfollow)==0){
                    echo'
                 <form id="follow-unfollow" action="misc/php/follow.php" method="post">
                    <div class="submit-follow">
                        <button class="follow-button" type="submit" value="'.$_GET["userID"].'" name="follow" title="follow">Follow</butoon>
                    </div>
                </form>
                ';
                }
                else {
                echo '
                     <form id="follow-unfollow" action="misc/php/follow.php" method="post">
                        <div class="submit-follow">
                            <button class="unfollow-button" type="submit" value="'.$_GET["userID"].'" name="follow" title="follow">Follow</butoon>
                    </div>
                </form>
                    
            }
                ?>