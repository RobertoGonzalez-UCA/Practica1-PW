<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">
    <title>Login</title>
</head>
<body>
<div id="register" class="bloque">
<h2 style="text-align:center;">Sistema Web para gestión de exámenes online</h2>
</div>
<?php require_once 'includes/connection.php'; ?>
<?php require_once 'includes/helpers.php'; ?>


<!-- LOGIN -->
<!-- ÉXITO LOGIN -->
<?php if(isset($_SESSION['user'])): ?>
        <?php 
            if($_SESSION['user']['rol'] == 'profesor'){
                header('Location: teacher.php');
            }elseif($_SESSION['user']['rol'] == 'alumno'){
                header('Location: alumn.php');
            }elseif($_SESSION['user']['rol'] == 'admin'){
                header('Location: admin.php');
            }
        ?>
<?php else: ?>

    <!-- LOGIN -->
    <div id="login" class="bloque fondo" >
        <h3 style="text-align:center;">Identifícate</h3>
        
        <!-- ERROR LOGIN -->
        <?php if(isset($_SESSION['error_login'])): ?>
            <div class="alerta alerta-error">
                <?= $_SESSION['error_login']; ?> </h3> 
            </div>
        <?php endif; ?>

        <form  action="login.php" method="POST">
            <label style="margin: 0 auto; text-align: center; width: 200px;"for="email">Email</label>
            <input style="max-width: 200px; margin: 0px auto;" type="email" name="email" required>

            <label style="margin: 0 auto; text-align: center; width: 200px;" for="password">Contraseña</label>
            <input style="max-width: 200px;margin: 0px auto;"type="password" name="password" required>

            <input style="margin: 10px auto;" type="submit" value="Entrar">
        </form>
    </div>

    <div class="bloque">
        © 2021 Copyright:
        <br>
        <p>   
            ► Juan Carlos Camacho Carribero
        </p>
        <p>   
            ► Roberto González Álvarez
        </p>
        <p>  
            ► Rafael Rodríguez Calvente 
        </p>    
    </div>

    
<?php endif; ?>

</body>
</html>