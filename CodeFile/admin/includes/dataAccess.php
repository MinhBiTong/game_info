<?php
    $host = "localhost";
    $user = "root";
    $pass = "";
    $db = "playful_games";

    $conn = new mysqli($host, $user, $pass);

    function createDb () {
        global $host;
        global $user;
        global $pass;
        global $db;

        $conn = new mysqli($host, $user, $pass, $db);
        if($conn -> connect_error){
            die("Connection error");
        }else{
            $sql = "CREATE DATABASE IF NOT EXISTS playful_games";
            $result = $conn -> query($sql);
            if($result){
                // echo "Database created successfully";
            }else{
                // echo "Database created failed";
            }
        }
        return $conn;
    };
    $conn = createDb();
    
?>