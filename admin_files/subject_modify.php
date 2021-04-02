<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../assets/css/style.css">

    <title>Admin Page</title>
</head>
<body>

<?php require_once '../includes/helpers.php'; ?>
<?php require_once '../includes/connection.php'; ?>

<?php if($_SESSION['user']['rol'] == 'admin'): ?>

    <!-- REGISTRO -->
    <div id="register" class="bloque fondo">
    <h3> Bienvenido, <?= $_SESSION['user']['name'] . ' ' . $_SESSION['user']['surname'] ?> </h3>
    <h3>Menú administrador</h3>

        <!-- ÉXITO/ERROR REGISTRO -->
        <?php 
            if(isset($_SESSION['completed'])): ?>
                <div class="alerta alerta-exito">
                    <?=$_SESSION['completed']?>
                </div>
            <?php elseif(isset($_SESSION['errors']['general'])): ?>
                <div class="alerta alerta-error">
                    <?=$_SESSION['errors']['general']?>
                </div>
            <?php endif;
        ?>
        
        <h4> Modificar asignaturas</h4>
        <br>

        <?php
            $sql = "SELECT * FROM subjects";
            $result = mysqli_query($db,$sql);

            if($result && mysqli_num_rows($result) >= 1){
                
                $counter = 1;
                $html = "";
                while($subject = mysqli_fetch_assoc($result)){
                    $id = $subject['subjectid'];
                    $name = $subject['name'];

                    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
                    
                    $html .= "
                        <form action='update_subject.php' method='POST'>
                            <h4>Asignatura nº $counter</h4>
                            <label for='nombre'>Nombre</label>
                            <input style='width: 200px; 
                            type='text' name='nombre' value='$name'>
                            <?php echo isset($errors) ? mostrarError($errors,'nombre') : '' ?>

                            <label for='id'></label>
                            <input type='hidden' name='id' value='$id' required>
                            
                            <input type='submit' value='Actualizar'>
                        
                        </form>

                        <form action='delete_subject.php' method='POST'>
                            <label for='id'></label>
                            <input type='hidden' name='id' value='$id' required>
                            
                            <input type='submit' value='Borrar'>
                        </form>

                        <br>";

                     $counter++;
                }
                $html .= "";
                echo $html;

            }else{
                $_SESSION['error_login'] = 'Login incorrecto....';
            }
        ?>

        <br>
        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
        <a class="boton boton-rojo" href="../logout.php">Cerrar sesión</a>
        <?php borrarAlertas(); ?> 
    </div>
    
<?php else: ?>
    <?php header('Location: ../index.php'); ?>
<?php endif; ?>
  
</body>
</html>