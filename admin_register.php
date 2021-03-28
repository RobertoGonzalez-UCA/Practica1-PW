<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="assets//css/style.css">

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
        
        <h4> Registro de usuarios</h4>
        <br>
        <form action="sign_up.php" method="POST">
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
            <input type="text" name="rol" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'rol') : '' ?>

            <label for="password">Contraseña</label>
            <input type="password" name="password" required>
            <?php echo isset($_SESSION['errors']) ? mostrarError($_SESSION['errors'],'password') : '' ?>

            <h4>Asignaturas</h4>
            <input type="radio" name="pw" id="pw" value="pw" />
            <label class="inline" for="pw">  Programación Web</label>
            <br/>

            <input type="radio" name="as" id="as" value="as"  />
            <label class="inline" for="as"> Administración de Servidores</label>
            <br/>

            <input type="radio" name="md" id="md" value="md" />
            <label class="inline" for="md"> Matemática Discreta</label>
            <br/>

            <input type="submit" value="Registrar">
        </form>
        <br>
        <a class="boton boton-naranja" href="user_data.php">Mis datos</a>
        <a class="boton boton-rojo" href="logout.php">Cerrar sesión</a>
        <?php borrarErrores(); ?> 
    </div>
    
<?php else: ?>
    <?php header('Location: index.php'); ?>
<?php endif; ?>
  
</body>
</html>