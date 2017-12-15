<?php

$dbname = 'my_wavesound';
$dbuser = 'wavesound';
$dbapss = '';
$dbhost = 'localhost';

$connection = new mysqli($dbhost,$dbuser,$dbass,$dbname);

if($connection->connect_errno) {
    echo "Connection failed (".$connection->connect_errno."):".$connection->connect_error;
    exit();
}
else{
    echo "Connection successfull";
}
?>