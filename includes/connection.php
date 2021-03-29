<?php

// Conexión
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'dbs1576025';
    $db = mysqli_connect($host,$user,$password,$database);

    mysqli_query($db, "SET NAMES 'utf8'");


    if(!isset($_SESSION)){
        session_start();
    }

?>