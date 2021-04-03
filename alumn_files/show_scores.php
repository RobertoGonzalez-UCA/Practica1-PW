<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Alumno - Ver examenes</title>
</head>
<body>
<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>
<?php if($_SESSION['user']['rol'] == 'alumno'): ?>
<!-- VER EXAMENES -->
<div class="bloque">
    <h3>Ver calificaciones</h3>
    <?php 
        $current_uid = $_SESSION['user']['uid'];

        $query = "SELECT * FROM exams WHERE uid = '$current_uid' AND estado = 'DONE'";
        $result = mysqli_query($db,$query);
        if(mysqli_num_rows($result) > 0){
            echo "Hay <b>", mysqli_num_rows($result),"</b> calificaciones disponibles. <br><br>";
        } else {
            echo "No hay calificaciones disponibles.";
        }
    ?>
    
    <div>
            <br>
            <?php 
                $current_uid = $_SESSION['user']['uid'];
                $query = "SELECT date, nota, name, examid from exams INNER JOIN subjects ON exams.subjectid=subjects.subjectid where uid = $current_uid AND estado = 'DONE'"; 
                $result = mysqli_query($db,$query);
                if($result){
                    for($i=1;$i<=mysqli_num_rows($result);$i++){
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        printf ("<span>Tu nota en el examen del día %s de la asignatura %s es %s</span><br>", $row["date"], $row["name"], $row["nota"]);
                        $query2 = "SELECT * FROM examanswers JOIN exams on examanswers.examid = exams.examid JOIN answers on answers.answerid = examanswers.answerid JOIN questions on questions.questionid = answers.questionid WHERE answers.value = 0 AND exams.examid = {$row["examid"]} ";
                        $result2 = mysqli_query($db,$query2);
                        if($result2){
                            for($j=1;$j<=mysqli_num_rows($result2);$j++){
                                $row2 = $result2->fetch_array(MYSQLI_ASSOC);
                                printf("<span>Fallaste en la pregunta '%s' del examen del día %s, tu respuesta fue '%s'</span><br>", $row2['text'], $row["date"], $row2['answertext']);
                                }
                            printf("<br>");
                        }
                    }
                }
            ?>
            <br><br>
        </div>
        <a class="boton boton-rojo" href="javascript: history.go(-1)">Volver</a>
</div>

<?php else: ?>
    <?php header('Location: ../index.php'); ?>
<?php endif; ?>

</body>
</html>