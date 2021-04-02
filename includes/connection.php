<?php

// Conexión
    $host = 'localhost';
    $user = 'root';
    $password = '';
    $database = 'gestor_examenes';
    $db = mysqli_connect($host,$user,$password,$database);

    mysqli_query($db, "SET NAMES 'utf8'");


    if(!isset($_SESSION)){
        session_start();
    }

?>