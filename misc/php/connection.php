<?php
$dbhost = 'localhost';
$dbuser = 'wavesound';
$dbpassword = '';
$dbname = 'my_wavesound';

try {
    $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
    // set the PDO error mode to exception
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully"; 
    }
catch(PDOException $e)
    {
    echo "Connection failed: " . $e->getMessage();
    }

?>