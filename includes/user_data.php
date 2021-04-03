<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Actualizar Usuario</title>
</head>
<body>
<?php require_once 'includes/connection.php'; ?>
<?php require_once 'includes/helpers.php'; ?>

<?php if($_SESSION['user']['rol'] == 'admin' || $_SESSION['user']['rol'] == 'alumno' || $_SESSION['user']['rol'] == 'profesor'): ?>

    <!-- CAJA PRINCIPAL -->
    <div id="principal">
        <!-- REGISTRO -->
        <div id="register" class="bloque">
                <h3>Actualiza tus datos</h3>

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

            /* die(var_dump($_SESSION['user'])); */
            $user_id = $_SESSION['user']['uid'];
            $sql = "SELECT * FROM users WHERE uid = $user_id";
            $result = mysqli_query($db,$sql);

            if($result && mysqli_num_rows($result) == 1){
                
                $counter = 1;
                $html = "";
                while($users = mysqli_fetch_assoc($result)){
                    $uid = $users['uid'];
                    $name = $users['name'];
                    $surname = $users['surname'];
                    $email = $users['email'];
                    $pass = $users['pass'];
                    $rol = $users['rol'];
                    $errors = isset($_SESSION['errors']) ? $_SESSION['errors'] : '';
                    $is_admin = $_SESSION['user']['rol'] == 'admin' ? true : false;
                    
                    
                    $html .= "
                        <form action='admin_files/update_user.php' method='POST'>
                            <label for='nombre'>Nombre</label>
                            <input type='text' name='nombre' value='$name'>
                            <?php echo isset($errors) ? mostrarError($errors,'nombre') : '' ?>

                            <label for='apellidos'>Apellidos</label>
                            <input type='text' name='apellidos' value='$surname' required>
                            <?php echo isset($errors) ? mostrarError($errors,'apellidos') : '' ?>

                            <label for='email'>Email</label>
                            <input type='email' name='email' value='$email' required>
                            <?php echo isset($errors) ? mostrarError($errors,'email') : '' ?>

                            <label for='pass'>Contraseña</label>
                            <input type='password' name='pass' value='$pass>' required>
                            <?php echo isset($errors) ? mostrarError($errors,'apellidos') : '' ?>

                            <label for='rol'>Rol</label>
                            <input type='text' name='rol' value='$rol' required>
                            <?php echo isset($errors) ? mostrarError($errors,'rol') : '' ?>

                            <label for='email_not_modify'></label>
                            <input type='hidden' name='email_not_modify' value='$email' required>
       
                            <label for='is_admin'></label>
                            <input type='hidden' name='is_admin' value='$is_admin' required>

                            <input type='submit' value='Actualizar'>
                        </form>

                        <br>";

                     $counter++;
                }
                echo $html;

            }else{
                $_SESSION['error_login'] = 'Login incorrecto....';
            }
                ?>

                
                <br>
                <?php 
                    if($_SESSION['user']['rol'] == 'admin'){
                        $page = 'admin.php';
                    }elseif($_SESSION['user']['rol'] == 'alumno'){
                        $page = 'alumn.php';
                    }elseif($_SESSION['user']['rol'] == 'profesor'){
                        $page = 'teacher.php';
                    }
                ?>
                <a class="boton boton-verde" href='<?="$page"?>'>Volver</a>
                <?php borrarAlertas(); ?>
            </div>
    </div>
<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>

</body>
</html>