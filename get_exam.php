<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">
    <title>Alumno - Hacer examen</title>
</head>
<body>
<?php require_once 'includes/helpers.php'; ?><?php require_once 'includes/helpers.php'; ?>
<?php require_once 'includes/connection.php'; ?>
<?php if($_SESSION['user']['rol'] == 'alumno'): ?>
<!-- VER EXAMEN -->
<div class="bloque">
    <h3>Hacer examen</h3>
    <?php 
        require_once 'includes/connection.php';
        $current_uid = $_SESSION['user']['uid'];

        $query = "SELECT * FROM exams INNER JOIN examquestions on exams.examid = examquestions.examid INNER JOIN questions on questions.questionid = examquestions.questionid WHERE exams.examid = 2";
        $result = mysqli_query($db,$query);
        if($result){
            for($i=1;$i<=mysqli_num_rows($result);$i++){
                $row = $result->fetch_array(MYSQLI_ASSOC);
                printf ("<span>PREGUNTA DEL EXAMEN %s ES %s</span><br>", $row["examid"], $row["text"]);
                $query2 = "SELECT * FROM answers INNER JOIN questions on answers.questionid = questions.questionid WHERE questions.questionid = {$row["questionid"]} ";
                $result2 = mysqli_query($db,$query2);
                if($result2){
                    for($j=1;$j<=mysqli_num_rows($result2);$j++){
                        $row2 = $result2->fetch_array(MYSQLI_ASSOC);
                        printf ("<span>%s</span><br>", $row2["answertext"]);
                    }
                }
            }
        }
    ?>
    
        <a class="boton boton-rojo" href="alumn.php">Volver</a>
</div>

<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>

</body>
</html>