<?php
	$loggedUser = $_SESSION["userID"];
	$currentUser = $_GET["userID"];
					
	if($loggedUser != $currentUser){
		$checkfollow = select("SELECT * FROM follow WHERE id_user = '$loggedUser' AND id_follow = '$currentUser'");
		$result = count($checkfollow);
		
		if($result >= 1){
			echo'<form id="unfollow" action="misc/php/follow.php" method="post">
					<div class="submit-follow">
						<button class="unfollow-button" type="submit" value="'.$_GET["userID"].'" name="unfollow" title="Unfollow">Unfollow</button>
                    </div>
                </form>
			';   
			
		}else{
			
			echo'
				<form id="follow" action="misc/php/follow.php" method="post">
					<div class="submit-follow">
						<button id="follow-button" type="submit" value="'.$_GET["userID"].'" name="follow" title="follow">Follow</button>
                    </div>
                </form>
			';
		}
		
	}else{
		$follow = select("SELECT follow.id_follow,user.username,user.avatar FROM user,follow WHERE  follow.id_user='$currentUser' 
							AND follow.id_follow=user.u_id"
						);
		echo'<h3>Following</h3>';
		for($i=0;$i< count($follow);$i++){
			$id = $follow[$i][0];
			$username = $follow[$i][1];
			$avatar = $follow[$i][2];
			printCardFollow($id,$username,$avatar);
		}
	}
?>