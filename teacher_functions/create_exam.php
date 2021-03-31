<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets//css/style.css">
    <title>Profesor - Crear examen</title>
</head>
<body>
<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>

<?php if($_SESSION['user']['rol'] == 'profesor'): ?>
    <!-- CREAR EXAMEN -->
    <div class="bloque">
        <h3>Crear examen</h3>
        <?php 
            require_once '../includes/connection.php';
            $current_uid = $_SESSION['user']['uid'];

            $query = "SELECT * FROM usersubjects WHERE uid = '$current_uid'";
            $result = mysqli_query($db,$query);
            if($result){
                echo "Impartes <b>", mysqli_num_rows($result),"</b> asignaturas. <br><br>";
            } else {
                echo "No impartes ninguna asignatura.";
            }
        ?>
        
        <form action="post_exam.php" method="POST">
                <br>
                <span>Elije una asignatura: </span>
                <select name="subject-selected">
                <?php 
                    require_once 'includes/connection.php';
                    $current_uid = $_SESSION['user']['uid'];

                    $query = "SELECT * from subjects S,usersubjects US where S.subjectid = US.subjectid"; // MEJORAR CONSULTA SQL
                    $result = mysqli_query($db,$query);
                    if($result){
                        for($i=1;$i<=mysqli_num_rows($result);$i++){
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            printf ("<option value=%s>%s</option>", $row["subjectid"], $row["name"]);
                        }
                    }
                ?>
                </select>
                <br><br>
                <label for="question">Elegir cuestiones:</label>
                <br>
                <?php         
                    $query = "SELECT text FROM questions";
                    $result = mysqli_query($db,$query);
                    if($result){
                        for($i=1;$i<=mysqli_num_rows($result);$i++){
                            $row = $result->fetch_array(MYSQLI_ASSOC);
                            printf ("<input type=checkbox name='question$i'> %s</input><br><br>", $row["text"]);
                        }
                    }
                ?>

                <input type="submit" value="Crear examen">
            </form>
    </div>
<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>
</body>
</html>