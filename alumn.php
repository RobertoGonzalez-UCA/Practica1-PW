<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">
    <title>Panel de control - Alumno</title>
</head>
<body>

<?php require_once 'includes/helpers.php'; ?>
<?php require_once 'includes/connection.php'; ?>

<?php if($_SESSION['user']['rol'] == 'alumno'): ?>
    <!-- MENU -->
    <div class="bloque">
        <h3> Bienvenido, <?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname'] ?> </h3>
        <h3>Menú alumnos</h3>
        <a class="boton boton-verde" href="alumn_files/show_exams.php">Hacer examen</a>
        <a class="boton boton-celeste" href="alumn_files/show_scores.php">Ver calificaciones</a>
        <a class="boton boton-naranja" href="includes/user_data.php">Mis datos</a>
        <a class="boton boton-rojo" href="logout.php">Cerrar sesión</a>
    </div>
    
<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>
    
</body>
</html>