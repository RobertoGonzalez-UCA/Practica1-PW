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

<?php $nota = 1 ?>
<!-- VER EXAMEN -->
<div class="bloque">
    <h3>Hacer examen</h3>
    <form  action="finish_exam.php" method="POST">
        <?php 
            require_once 'includes/connection.php';
            $current_uid = $_SESSION['user']['uid'];
            $query = "SELECT * FROM questions JOIN units on questions.unitid = units.unitid WHERE units.subjectid =  {$_POST['subject-selected']} ORDER BY RAND ( )  LIMIT 10"; 
            $result = mysqli_query($db,$query);
            if($result){
                for($i=1;$i<=mysqli_num_rows($result);$i++){
                    $row = $result->fetch_array(MYSQLI_ASSOC);
                    printf ("<br><b>%s</b><br><br>", $row["text"]);
                    $query2 = "SELECT * FROM answers INNER JOIN questions on answers.questionid = questions.questionid WHERE questions.questionid = {$row["questionid"]} ";
                    $result2 = mysqli_query($db,$query2);
                    if($result2){
                        for($j=1;$j<=mysqli_num_rows($result2);$j++){
                            $row2 = $result2->fetch_array(MYSQLI_ASSOC);
                            printf ("<label for='%s'><input type='radio' id='answer%s' name='%s' value='%s'> %s</label>", $row2["answerid"], $row2["answerid"], $nota, $row2["value"], $row2["answertext"]);
                        }
                        printf ("<label for='%s'><input type='radio' id='answer%s' name='%s' value='0' checked> Dejar en blanco</label>", $row2["answerid"], $row2["answerid"], $nota);
                        $nota = $nota + 1;
                    }
                }
                printf ("<input type='hidden' id='examen%s' name='exam-selected' value='%s'>", $_POST['exam-selected'], $_POST['exam-selected']);
            }
        ?>
        <br><br>
        <input type="submit" value="Enviar respuestas y terminar">
    </form>
</div>

<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>

</body>
</html>