<?php
    $dbhost     = 'localhost';
    $dbuser     = 'wavesound';
    $dbpassword = '';
    $dbname     = 'my_wavesound';
    
    try {
        $connection = new PDO("mysql:host=$dbhost;dbname=$dbname", $dbuser, $dbpassword);
        $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) {
        echo "Connection failed: " . $e->getMessage();
    }
    
?>