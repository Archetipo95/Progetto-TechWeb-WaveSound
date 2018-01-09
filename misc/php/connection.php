<?php
$dbhost = 'localhost';
$dbuser = 'wavesound';
$dbpassword = '';
$dbname = 'my_wavesound';

// Create connection

$connection = mysqli_connect($dbhost, $dbuser, $dbpassword, $dbname);

// Check connection

if ($connection->connect_errno) {
	echo "Connessione fallita (" . $connection->connect_errno . "): " . $connection->connect_error;
	exit();
}

?>