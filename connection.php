<?php



$dbname = 'wavesound';
$dbuser = 'testo';
$dbpass = 'testoPWD';
$dbhost = 'https://mysql8.db4free.net/phpMyAdmin';

$connect = mysql_connect($dbhost, $dbuser, $dbpass) or die("Unable to Connect to '$dbhost'");
mysql_select_db($dbname) or die("Could not open the db '$dbname'");


?>
