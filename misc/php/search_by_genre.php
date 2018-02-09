<?php

	require("connection.php");

	$genre = $_POST['genre'];
	$sort = $_POST['sort'];
	$period = $_POST['period'];
	$order = $_POST['order'];
	$apice = '"';
	$genre2 = $apice.$genre.$apice;


	if($order == "descending"){
		echo $genre2;
		$query = 'SELECT  title,genre,upload_date,download FROM song WHERE genre='.$genre2.' ORDER BY '.$sort.' DESC ';
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
	}

	if($order == "ascending"){
		echo $genre2;
		$query = 'SELECT title,genre,upload_date,download FROM song WHERE genre='.$genre2.' ORDER BY '.$sort.' ASC ';
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
	}
?>
