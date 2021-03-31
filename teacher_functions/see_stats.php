<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Ver estadísticas - Profesor</title>

    <script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
		
		<script type="text/javascript"  >
			$(document).ready(function(){
				$("#cbx_subject").change(function () {
					
					$("#cbx_subject option:selected").each(function () {
						subjectid = $(this).val();
						$.post("/practica1/includes/get_results.php", { subjectid: subjectid }, function(data){
							$("#results").html(data);
						});            
					});
				})
			});
		</script>
</head>
<body>
    <!-- Ver estadísticas -->
    <div class="bloque">
        <h3>Ver estadísticas</h3>
        <form id="combo" name="combo" action="" method="POST">
            <?php 
            require_once '../includes/helpers.php';
            require_once '../includes/connection.php';
            $current_uid = $_SESSION['user']['uid'];
            $query = "SELECT S.name, S.subjectid FROM users U, usersubjects US, subjects S WHERE U.uid = '$current_uid' AND US.uid = U.uid AND US.subjectid = S.subjectid";
            $result = mysqli_query($db,$query);
            if(mysqli_num_rows($result) != 0){
                echo "Impartes <b>", mysqli_num_rows($result),"</b> asignaturas. <br><br>";
            ?>

            <!-- Asignatura -->
            <label for="cbx_subject">Elige una asignatura: 
                <select name="cbx_subject" id="cbx_subject" required>
                    <option value="">Selecciona asignatura</option>
                    <?php 
                    while($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['subjectid']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <br>
            <div id="results"></div>
        </form>
        <?php } else {
                    echo "No impartes ninguna asignatura.<br>";
                }
            ?>
        <br>
        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
</body>
</html>