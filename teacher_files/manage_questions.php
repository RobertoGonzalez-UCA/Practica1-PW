<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets//css/style.css">
    <title>Batería de preguntas - Profesor</title>
</head>
<?php
require_once '../includes/helpers.php';
require_once '../includes/connection.php';
if($_SESSION['user']['rol'] == 'profesor'): ?>
<body>
<!-- MENU -->
<div class="bloque">    
    <h3>Gestor - Batería de preguntas</h3>
    <a class="boton boton-verde" href="create_question.php">Añadir</a>
    <a class="boton boton-naranja" href="modify_question.php">Modificar</a>
    <a class="boton boton-rojo" href="delete_question.php">Eliminar</a>
    <a class="boton boton-celeste" href="../teacher.php">Volver</a>
</div>
<?php else:
    header('Location: ../index.php');
    endif;
    mysqli_close($db);?>
</body>
</html>