<?php
    require('msg.php');
    require('tools.php');
    
    if (isset($_POST['login']) && isset($_POST['password'])) {
        /*save varialble*/
        $password = $_POST['password'];
        $login    = $_POST['login'];
        
        /*search for username*/
        $statement   = select("SELECT * FROM user WHERE username='$login'");
        $col         = count($statement);
        $resultEmail = 0;
        /*search for email*/
        if (filter_var($login, FILTER_VALIDATE_EMAIL)) {
            $statementEmail = select("SELECT * FROM user WHERE email='$login'");
            $colEmail       = count($statementEmail);
        } else {
            $resultEmail = 0;
        }
        
        /*if user exist in db*/
        if ($col == 1) {
            $row = $statement[0];
            /*check password correctness*/
            if ($password == $row[7]) {
                /*start session and go to main*/
                session_start();
                $_SESSION["userID"]   = $row[0];
                $_SESSION["username"] = $row[1];
                $_SESSION["avatar"]   = $row[8];
                header("Location:../../main.html");
            } else {
                sendMessage("Login Failed");
            }
        }
        
        /*if email exist in db*/
        else if ($colEmail == 1) {
            $row = $statementEmail[0];
            if ($password == $row[7]) {
                /*start session and go to main*/
                session_start();
                $_SESSION["userID"]   = $row[0];
                $_SESSION["username"] = $row[1];
                $_SESSION["avatar"]   = $row[8];
                header("Location:../../main.html");
            } else {
                sendMessage("Login Failed");
            }
        } else {
            sendMessage("Login Failed");
        }
    }
    
?>