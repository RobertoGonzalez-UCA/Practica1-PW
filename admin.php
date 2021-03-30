<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets/css/style.css">

    <title>Admin Page</title>
</head>
<body>

<?php require_once 'includes/helpers.php'; ?>
<?php require_once 'includes/connection.php'; ?>

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

        
        <a class="boton boton-verde" href="admin_files/admin_register.php">Registrar usuarios</a>
        <a class="boton boton-celeste" href="admin_files/admin_modify.php">Modificar usuarios</a>
        <a class="boton boton-verde" href="admin_files/subject_register.php">Registrar asignaturas</a>
        <a class="boton boton-celeste" href="admin_files/subject_modify.php">Modificar asignaturas</a>

        <a class="boton boton-rojo" href="logout.php">Cerrar sesión</a>
        <?php borrarAlertas(); ?> 
    </div>
    
<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>
  
</body>
</html>