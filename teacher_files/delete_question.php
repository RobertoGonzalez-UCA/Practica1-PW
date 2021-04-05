<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Eliminar pregunta - Profesor</title>

    <script type="text/javascript" src="../assets/js/jquery-3.1.1.min.js"></script>
		
		<script type="text/javascript"  >
			$(document).ready(function(){
				$("#cbx_subject").change(function () {
					
                    $('#cbx_question').find('option').remove().end().append('<option value=""></option>').val('');
                    $('#answers').find('h3').remove().end();
                    $('#answers').find('div').remove().end();

					$("#cbx_subject option:selected").each(function () {
						subjectid = $(this).val();
						$.post("/practica1/includes/get_units.php", { subjectid: subjectid }, function(data){
							$("#cbx_unit").html(data);
						});            
					});
				})
			});

            $(document).ready(function(){
				$("#cbx_unit").change(function () {
					
					$("#cbx_unit option:selected").each(function () {
						unitid = $(this).val();
						$.post("/practica1/includes/get_questions.php", { unitid: unitid }, function(data){
							$("#cbx_question").html(data);
						});            
					});
				})
			});

            $(document).ready(function(){
				$("#cbx_question").change(function () {
					
					$("#cbx_question option:selected").each(function () {
						questionid = $(this).val();
						$.post("/practica1/includes/get_answers.php", { questionid: questionid }, function(data){
							$("#answers").html(data);
						});            
					});
				})
			});
		</script>
</head>
<?php
require_once '../includes/helpers.php';
require_once '../includes/connection.php';
if($_SESSION['user']['rol'] == 'profesor'): ?>
<body>
    <!-- Eliminar pregunta -->
    <div class="bloque">
    <h3>Eliminar pregunta</h3>
    <form id="combo" name="combo" action="../includes/remove_question.php" method="POST">
            <?php 
            $current_uid = $_SESSION['user']['uid'];
            $query = "SELECT S.name, S.subjectid FROM users U, usersubjects US, subjects S WHERE U.uid = '$current_uid' AND US.uid = U.uid AND US.subjectid = S.subjectid";
            $result = mysqli_query($db,$query);
            if(mysqli_num_rows($result) != 0){
                echo "Impartes <b>", mysqli_num_rows($result),"</b> asignaturas. <br><br>";
            ?>

            <!-- Asignatura, tema y pregunta -->
            <label for="cbx_subject">Elige una asignatura: 
                <select name="cbx_subject" id="cbx_subject" required>
                    <option value="">Selecciona asignatura</option>
                    <?php 
                    $query = "SELECT S.name, S.subjectid FROM users U, usersubjects US, subjects S WHERE U.uid = '$current_uid' AND US.uid = U.uid AND US.subjectid = S.subjectid";
                    $result = mysqli_query($db,$query);
                    while($row = $result->fetch_assoc()) { ?>
                        <option value="<?php echo $row['subjectid']; ?>"><?php echo $row['name']; ?></option>
                    <?php } ?>
                </select>
            </label>
            <label for="cbx_unit">Elige un tema: 
                <select name="cbx_unit" id="cbx_unit" required>
                    <option value="">Selecciona tema</option>
                </select>
            </label>
            <label for="cbx_question">Elige una pregunta: 
                <select name="cbx_question" id="cbx_question" required>
                    <option value="">Selecciona pregunta</option>
                </select>
            </label>
            <br>

            <input type="submit" name="delete" value="Eliminar">
        </form>

        <?php } else
                {
                    echo "No impartes ninguna asignatura.<br>";
                }
        ?>
        <br>
        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
    </div>
    <?php else:
    header('Location: ../index.php');
    endif;
    mysqli_close($db);?>
</body>
</html>