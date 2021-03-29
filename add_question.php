<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Añadir pregunta - Profesor</title>
</head>
<body>
<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>

    <!-- Añadir pregunta -->
    <div class="bloque">
        <?php
            require_once '../includes/helpers.php';
            require_once '../includes/connection.php';

            $añadir = $_POST['añadir'];
            if (isset($añadir))
            {
                $subject_selected = $_POST['cbx_subject'];
                $unit_selected = $_POST['cbx_unit'];
                $new_question_text = $_POST['new_question'];
                printf("<p><b>Asignatura:</b> $subject_selected  <b>Tema:</b> $unit_selected    <b>Nueva pregunta:</b> $new_question_text<br><br></p>");
            
                $query = "INSERT INTO `questions` (`text`, `unitid`) VALUES ('$new_question_text', '$unit_selected')";

            if(mysqli_query($db,$query)){
                echo "<p> - La pregunta ha sido añadida!</p>";
            } else {
                echo "<p> - Fallo en la insercción de pregunta!</p>";
            }

            // Buscar questionid de la new_question
            $query = "SELECT `questionid` FROM `questions` WHERE text = '$new_question_text' AND unitid = '$unit_selected'";
            $result = mysqli_query($db,$query);
            $row = mysqli_fetch_assoc($result);
            $question_id = $row['questionid'];
            $chosen_answer = $_POST['answer'];
            $answer1_text = $_POST['answer1_text'];
            $answer2_text = $_POST['answer2_text'];
            $answer3_text = $_POST['answer3_text'];
            
            if($chosen_answer == "answer1") {
                $query = "INSERT INTO `answers`(`text`, `questionid`, `value`) VALUES ('$answer1_text','$question_id','1'),('$answer2_text','$question_id','0'),('$answer3_text','$question_id','0')";
                if(mysqli_query($db,$query)){
                echo "<p> - Las respuestas han sido añadidas!</p>";
                } else {
                echo "<p> - Fallo en la insercción!</p>";
                }
            } elseif($chosen_answer == "answer2") {
                $query = "INSERT INTO `answers`(`text`, `questionid`, `value`) VALUES ('$answer1_text','$question_id','0'),('$answer2_text','$question_id','1'),('$answer3_text','$question_id','0')";
                if(mysqli_query($db,$query)){
                echo "<p> - Las respuestas han sido añadidas!</p>";
                } else {
                echo "<p> - Fallo en la insercción!</p>";
                }
            } elseif($chosen_answer == "answer3") {
                $query = "INSERT INTO `answers`(`text`, `questionid`, `value`) VALUES ('$answer1_text','$question_id','0'),('$answer2_text','$question_id','0'),('$answer3_text','$question_id','1')";
                if(mysqli_query($db,$query)){
                echo "<p> - Las respuestas han sido añadidas!</p>";
                } else {
                echo "<p> - Fallo en la insercción!</p>";
                }
            }
            }
        ?>
        <br>
        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
</body>
</html>