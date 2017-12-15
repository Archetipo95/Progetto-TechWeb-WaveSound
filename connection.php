<?php

$connection = new mysqli('https://mysql8.db4free.net/phpMyAdmin/','testo','testoPWD','wavesound');

if($connection->connect_errno) {
    echo "Connection failed (".$connection->connect_errno."):".$connection->connect_error;
    exit();
}
else{
    echo "Connection successfull";
}
?>