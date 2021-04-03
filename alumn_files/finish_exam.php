<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Alumno - Examen terminado</title>
</head>
<body>
<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>
<?php if($_SESSION['user']['rol'] == 'alumno'): ?>
<?php $query = "SELECT * FROM answers JOIN questions on answers.questionid = questions.questionid WHERE answerid = {$_POST['1']} OR answerid = {$_POST['2']} OR answerid = {$_POST['3']} OR  answerid = {$_POST['4']} OR answerid = {$_POST['5']} OR answerid = {$_POST['6']} OR answerid = {$_POST['7']} OR answerid = {$_POST['8']} OR answerid = {$_POST['9']} OR answerid = {$_POST['10']} "; 
    $result = mysqli_query($db,$query);
    $resultado = 0;
    if($result){
        for($i=1;$i<=mysqli_num_rows($result);$i++){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            $resultado += $row['value'];
            $query2 = "INSERT INTO examanswers (answerid, examid) VALUES ({$row['answerid']}, {$_POST['exam-selected']}) ";
            $result2 = mysqli_query($db,$query2);
            if(!$result2) {
                echo "Error al guardar la respuesta. ";
            }
        }
    } ?>
<!-- FINALIZAR EXAMEN -->
<div class="bloque">
    <h3>Examen finalizado</h3>
    <br>
    <?php
        printf("<span>Tu nota es de %s</span><br>", $resultado) ;
        $query = "UPDATE exams SET estado='DONE', nota = {$resultado} WHERE examid = {$_POST['exam-selected']}" ; 
        if (mysqli_query($db, $query)) {
            echo "Examen finalizado.";
        } else {
            echo "Error updating record: " . mysqli_error($db);
        }
    ?>
    <?php
    $query = "SELECT * FROM examanswers JOIN exams on examanswers.examid = exams.examid JOIN answers on answers.answerid = examanswers.answerid JOIN questions on questions.questionid = answers.questionid WHERE answers.value = 0 AND exams.examid = {$_POST['exam-selected']} ";
    $result = mysqli_query($db,$query);
    if($result){
        for($i=1;$i<=mysqli_num_rows($result);$i++){
            $row = $result->fetch_array(MYSQLI_ASSOC);
            printf("<br><span>Has fallado en la pregunta '%s', tu respuesta ha sido '%s'</span>", $row['text'], $row['answertext']);
            }
    }
    ?>
    <br>
    <a class="boton boton-verde" href="../alumn.php">Volver al menú principal</a>
</div>

<?php else: ?>
    <?php header('Location: ../index.php'); ?>
<?php endif; ?>

</body>
</html>
