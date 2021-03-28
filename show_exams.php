<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">
    <title>Alumno - Ver examenes</title>
</head>
<body>
<?php require_once 'includes/helpers.php'; ?>
<?php require_once 'includes/connection.php'; ?>

<?php if($_SESSION['user']['rol'] == 'alumno'): ?>
<!-- VER EXAMENES -->
<div class="bloque">
    <h3>Ver examenes</h3>
    <?php 
        require_once 'includes/connection.php';
        $current_uid = $_SESSION['user']['uid'];

        $query = "SELECT * FROM exams WHERE uid = '$current_uid' AND estado = 'PENDING'";
        $result = mysqli_query($db,$query);
        if(mysqli_num_rows($result) > 0){
            echo "Hay <b>", mysqli_num_rows($result),"</b> examenes disponibles. <br><br>";
        } else {
            echo "No hay examenes disponibles.";
        }
    ?>
    
    <?php if(mysqli_num_rows($result) > 0): ?>
    <form action="get_exam.php" method="GET">
            <br>
            <span>Elige un examen: </span>
            <select name="subject-selected">
            <?php 
                require_once 'includes/connection.php';
                $current_uid = $_SESSION['user']['uid'];
                $query = "SELECT examid, name from exams INNER JOIN subjects ON exams.subjectid=subjects.subjectid where uid = $current_uid AND estado = 'PENDING'"; 
                $result = mysqli_query($db,$query);
                if($result){
                    for($i=1;$i<=mysqli_num_rows($result);$i++){
                        $row = $result->fetch_array(MYSQLI_ASSOC);
                        printf ("<option value=%s>%s</option>", $row["examid"], $row["name"]);
                    }
                }
            ?>
            </select>
            <br><br>
            <input type="submit" value="Hacer examen">
        </form>
        <?php endif; ?>
        <a class="boton boton-rojo" href="alumn.php">Volver</a>
</div>

<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>

</body>
</html>