<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">

    <title>Document</title>
</head>
<body>
<?php require_once 'includes/redirection.php'; ?>
<?php require_once 'includes/helpers.php'; ?>
<?php  /*require_once 'includes/cabecera.php';*/ ?>
<?php /*require_once 'includes/lateral.php';*/ ?>

<!-- CAJA PRINCIPAL -->
<div id="principal">
    <h1>Mis datos</h1>
    <!-- REGISTRO -->
    <div id="register" class="bloque">
            <h3>Regístrate</h3>

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

            <form action="update_user.php" method="POST">
                <label for="nombre">Nombre</label>
                <input type="text" name="nombre" value="<?=$_SESSION['user']['name']?>">
                <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'nombre') : '' ?>

                <label for="apellidos">Apellidos</label>
                <input type="text" name="apellidos" value="<?=$_SESSION['user']['surname']?>" required>
                <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'apellidos') : '' ?>

                <label for="email">Email</label>
                <input type="email" name="email" value="<?=$_SESSION['user']['email']?>" required>
                <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'email') : '' ?>

                <input type="submit" value="Actualizar">
            </form>
            <?php borrarErrores(); ?>
        </div>
</div> <!-- fin principal -->

</body>
</html>