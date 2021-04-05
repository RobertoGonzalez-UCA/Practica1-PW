<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Eliminar pregunta - Profesor</title>
</head>
<body>
<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>

    <!-- Eliminar pregunta -->
    <div class="bloque">
    <?php 
    $question_id = mysqli_real_escape_string($db,$_POST['cbx_question']);
    $query = sprintf("DELETE FROM questions WHERE questionid = %s", $question_id);
    if(!mysqli_query($db,$query)) {
        $error = "Se ha producido un error al eliminar la pregunta";
        return;
    } else {
        echo "Se ha eliminado la pregunta.";
    }
    ?>

    <br>
    <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
    <?php mysqli_close($db);?>
</body>
</html>


