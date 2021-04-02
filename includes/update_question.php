<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Modificar pregunta - Profesor</title>
</head>
<body>
    <!-- Modificar pregunta -->
    <div class="bloque">
    <?php 
    require_once '../includes/helpers.php';
    require_once '../includes/connection.php';
    
    $question_id = mysqli_real_escape_string($db,$_POST['cbx_question']);
    $question_text = mysqli_real_escape_string($db, $_POST['new_question']);
    $query = sprintf("UPDATE `questions` SET `text` = '%s' WHERE `questionid`= '%s'", $question_text, $question_id );
    if(!mysqli_query($db,$query)) {
        $error = "Se ha producido un error al modificar el enunciado de la pregunta.";
        return;
    }

    $answers = $_POST['answer'];
    $selected = mysqli_real_escape_string($db, $_POST['selected']);      // Prevención SQL INJECTION
    $error = NULL;
    // echo '<pre>' . var_export($_POST, true) . '</pre>';
    foreach($answers as $answerid => $answer)
    {
        $answer = mysqli_real_escape_string($db,$answer['answer']);
        $selected_field = $selected == $answerid ? 1 : 0;
        // $query = "UPDATE `answers` SET `text`='$answer',`value`='$selected' WHERE `answerid`='$answerid'";
        $query = sprintf("UPDATE `answers` SET `answertext` = '%s',`value` = '%s' WHERE `answerid` = '%s'", $answer, $selected_field, $answerid);
        if(!mysqli_query($db,$query)) {
            $error = "Se ha producido un error al modificar algunas respuestas.";
            return;
        }    
    }

    if($error) {
        echo $error;
    } else {
        echo "Se ha modificado la pregunta.";
    }
    ?>

    <br>
    <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
</body>
</html>


