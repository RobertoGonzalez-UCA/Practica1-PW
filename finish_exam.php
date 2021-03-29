<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">
    <title>Alumno - Examen terminado</title>
</head>
<body>
<?php require_once 'includes/helpers.php'; ?><?php require_once 'includes/helpers.php'; ?>
<?php require_once 'includes/connection.php'; ?>
<?php if($_SESSION['user']['rol'] == 'alumno'): ?>
<?php $resultado = $_POST['1'] +  $_POST['2'] +  $_POST['3'] +  $_POST['4'] +  $_POST['5'] +  $_POST['6'] +  $_POST['7'] +  $_POST['8'] +  $_POST['9'] +  $_POST['10']; ?>
<!-- FINALIZAR EXAMEN -->
<div class="bloque">
    <h3>Examen finalizado</h3>
    <br>
    <?php
        printf("<span>Tu nota es de %s</span><br>", $resultado) ;
        $query = "UPDATE exams SET estado='DONE', nota={$resultado} WHERE examid = {$_POST['exam-selected']}" ; 
        if (mysqli_query($db, $query)) {
            echo "Examen finalizado.";
        } else {
            echo "Error updating record: " . mysqli_error($db);
        }
    ?>
    <br>
    <a class="boton boton-verde" href="alumn.php">Volver al menú principal</a>
</div>

<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>

</body>
</html>
