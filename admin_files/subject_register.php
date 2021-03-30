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
    <div id="register" class="bloque">
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
        
        <h4> Registro de asignaturas</h4>
        <br>

        <form action="sign_up_subject.php" method="POST">
            <label for="name">Nombre de la asignatura</label>
            <input type="text" name="name" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'name') : '' ?>

            <label for="degree_id">Elige un Grado</label>
            <?php
                $sql = "SELECT degreeid,name FROM degrees";
                $result = mysqli_query($db,$sql);
    
                if($result && mysqli_num_rows($result) >= 1){
                    
                    $html = "<select style='margin-bottom: 10px;' name='degree_id' required>
                    ";
                    while($degrees = mysqli_fetch_assoc($result)){
                        $degree = $degrees['name'];
                        $degree_id = $degrees['degreeid'];

                        $html .= "<option value='$degree_id'>$degree</option>";
                    }
                    $html .= "</select>
                    ";
                    echo $html;
                }
            ?>

            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'degrees') : '' ?>


            <label for="coordinator_id">Elige un Coordinador</label>
            <?php
                $sql = "SELECT uid,name,surname FROM users WHERE rol = 'profesor'";
                $result = mysqli_query($db,$sql);
 
                if($result && mysqli_num_rows($result) >= 1){
                    
                    $html = "<select style='margin-bottom: 10px;' name='coordinator_id' required>";
                    while($coordinators = mysqli_fetch_assoc($result)){
                        $coordinator_name = $coordinators['name'];
                        $coordinator_surname = $coordinators['surname'];
                        $coordinator_id = $coordinators['uid'];

                        $html .= "<option value='$coordinator_id'>$coordinator_name $coordinator_surname</option>";
                    }
                    $html .= "</select>";
                    echo $html;
                }
            ?> 

            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'degrees') : '' ?>


            <input type="submit" value="Registrar">
        </form>

        <br>

        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
        <a class="boton boton-rojo" href="../logout.php">Cerrar sesión</a>
        <?php borrarErrores(); ?> 
    </div>
    
<?php else: ?>
    <?php header('Location: ../index.php'); ?>
<?php endif; ?>
  
</body>
</html>