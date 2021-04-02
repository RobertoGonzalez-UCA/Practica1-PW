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
        
        <h4> Registro de usuarios</h4>
        <br>
        <form action="sign_up_user.php" method="POST">
            <label for="name">Nombre</label>
            <input type="text" name="name" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'name') : '' ?>

            <label for="surname">Apellidos</label>
            <input type="text" name="surname" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'surname') : '' ?>

            <label for="email">Email</label>
            <input type="email" name="email" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'email') : '' ?>

            <label for="rol">Rol</label>

            <select name="rol" id="rol" style="margin-bottom: 10px;" onchange="JSfunction()" required>
                <option value="profesor">Profesor</option>
                <option value="admin">Admin</option>
                <option value="alumno">Alumno</option>
            </select>


            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'rol') : '' ?>

            <label for="password">Contraseña</label>
            <input type="password" name="password" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'password') : '' ?>


            <h4 id="id-subjects">Imparte: </h4>
            <?php
                $sql = "SELECT * FROM subjects";
                $result = mysqli_query($db,$sql);

                if($result && mysqli_num_rows($result) > 1){
                    
                    $html = "<div id='subjects-block'>";
                    while($subjects = mysqli_fetch_assoc($result)){
                        $subject = $subjects['name'];
                        $subject_id = $subjects['subjectid'];


                        $html .= "<input type='radio' name='$subject' id='$subject' value='$subject' />
                        <label class='inline' for='$subject'> $subject</label> <br>";
                    }
                    $html .= "</div>";
                    echo $html;
                }
            ?>
            <br>

            <input type="submit" value="Registrar">
        </form>
        <br>
        <a class="boton boton-verde" href="javascript: history.go(-1)">Volver</a>
        <a class="boton boton-rojo" href="../logout.php">Cerrar sesión</a>
        <?php borrarAlertas(); ?> 
    </div>
    
<?php else: ?>
    <?php header('Location: ../index.php'); ?>
<?php endif; ?>
  
</body>
<script src="../js/admin_register.js"></script>
</html>