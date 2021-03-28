<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">
    <title>Login</title>
</head>
<body>
<div id="register" class="bloque">
<h2>Sistema Web para gestión de exámenes online</h2>
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
<?php endif; ?>

<?php if(!isset($_SESSION['user'])): ?>

    <!-- LOGIN -->
    <div id="login" class="bloque">
        <h3>Identifícate</h3>
        
        <!-- ERROR LOGIN -->
        <?php if(isset($_SESSION['error_login'])): ?>
            <div class="alerta alerta-error">
                <?= $_SESSION['error_login']; ?> </h3> 
            </div>
        <?php endif; ?>

        <form action="login.php" method="POST">
            <label for="email">Email</label>
            <input type="email" name="email" required>

            <label for="password">Contraseña</label>
            <input type="password" name="password" required>

            <input type="submit" value="Enviar">
        </form>
    </div>

    
<?php endif; ?>

</body>
</html>