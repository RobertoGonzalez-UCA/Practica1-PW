<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Poner examen - Profesor</title>
</head>
<body>
    <!-- Poner examen -->
    <div class="bloque">
    <?php 
    require_once '../includes/helpers.php';
    require_once '../includes/connection.php';
    
    $subjectid = $_POST['cbx_subject'];
    $date = $_POST['exam_date'];
    $today = date("Y-m-d");
    $error = "";

    if($date < $today) {
        $error = "La fecha introducida es inválida.";
    } else {
        $date_insert = str_replace('-', '', $date);
        $query = sprintf("SELECT uid FROM usersubjects WHERE subjectid = '%s'", $subjectid);
        $result = mysqli_query($db,$query);
        while($row = $result->fetch_assoc())
        {
            $uid = $row['uid'];
            $query = "INSERT INTO `exams`(`uid`, `subjectid`, `estado`, `nota`, `date`) VALUES ($uid, $subjectid, 'PENDING', NULL, $date_insert)"; 
            if(!mysqli_query($db,$query)) {
                $error = "Se ha producido un error al poner el examen.";
                return;
            }
        }
    }

    if($error) {
        echo $error;
    } else {
        $query = "SELECT name FROM subjects WHERE subjectid = '$subjectid'";
        $result = mysqli_query($db,$query);
        $row = $result->fetch_assoc();
        echo "Se ha puesto un examen de <b>".$row['name']."</b> a fecha de <b>$date</b>.";
    }
    ?>

    <br>
    <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
</body>
</html>


