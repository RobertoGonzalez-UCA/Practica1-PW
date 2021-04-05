<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">
    <title>Panel de control - Profesor</title>
</head>
<body>
<?php require_once 'includes/helpers.php'; ?>
<?php require_once 'includes/connection.php'; ?>

<!-- MENU -->
<div class="bloque">    
    <h3> Bienvenido, <?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname'] ?> </h3>
    <h3>Menú profesorado</h3>
    <a class="boton boton-verde" href="teacher_files/create_exam.php">Poner examen</a>
    <a class="boton boton-verde" href="teacher_files/see_stats.php">Ver estadísticas</a>
    <a class="boton boton-celeste" href="teacher_files/manage_questions.php">Gestionar preguntas</a>
    <a class="boton boton-naranja" href="includes/user_data.php">Mis datos</a>
    <a class="boton boton-rojo" href="logout.php">Cerrar sesión</a>
</div>
<?php mysqli_close($db);?>
</body>
</html>