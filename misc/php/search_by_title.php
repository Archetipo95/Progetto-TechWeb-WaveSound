<?php

	require("connection.php");
	require("tools.php");

	if(isset($_POST['search'])){
		$keyword=$_POST['search'];
		$query = "SELECT  title,genre,upload_date FROM song WHERE title LIKE '%$keyword%' ";
		$result = $connection->prepare($query);
		$result->execute();
		
		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			$title = $row['title'];
			$genre = $row['genre'];
			$upload_date = $row['upload_date'];
			
			echo "<table>";
			echo "<tr><th>Titolo</th>
					  <th>Genre</th>
					  <th>Upload Date</th>
				  </tr>";
			echo "<tr><td>".$title."</td>
					  <td>".$genre."</td>
					  <td>".$upload_date."</td>
				  </tr>";
			echo "</table>";
		}
	}else{
		echo "vuoto";
	}

?>