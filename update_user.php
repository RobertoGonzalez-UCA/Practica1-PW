<?php
    require_once 'includes/connection.php';
            
    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){
            
            /* mysqli_real_escape..... evita injección SQL */
            $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
            $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db,trim($_POST['apellidos'])) : false;
            $email = isset($_POST['email']) ? mysqli_real_escape_string($db,$_POST['email']) : false;
            $email_not_modify = isset($_POST['email_not_modify']) ? mysqli_real_escape_string($db,$_POST['email_not_modify']) : false;

            $password = isset($_POST['pass']) ? mysqli_real_escape_string($db,$_POST['pass']) : false;

            $rol = isset($_POST['rol']) ? mysqli_real_escape_string($db,$_POST['rol']) : false;
    
            $errores = array();
    
            // Validar nombre
            /* neccesary preg_match? */
            if(!empty($nombre) && !is_numeric($nombre) && !preg_match("/[0-9]/",$nombre)){
                $nombre_validado = true;
            }else{
                $nombre_validado = false;
                $errores['nombre'] = "El nombre no es válido";
            }
    
            // Validar apellidos
            if(!empty($apellidos) && !is_numeric($apellidos) && !preg_match("/[0-9]/",$apellidos)){
                $apellidos_validado = true;
            }else{
                $apellidos_validado = false;
                $errores['apellidos'] = "Los apellidos no son válidos";
            }
    
            // Validar email
            if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $email_validado = true;
            }else{
                $email_validado = false;
                $errores['email'] = "El email no es válido";
            }

            // Validar email_not_modify
            if(!empty($email_not_modify) && filter_var($email_not_modify, FILTER_VALIDATE_EMAIL)){
                $email_email_not_modify_validado = true;
            }else{
                $email_not_modify_validado = false;
                $errores['email_not_modify'] = "El email no es válido";
            }

            // Validar rol
            if(!empty($rol) && !is_numeric($rol) && !preg_match("/[0-9]/",$rol)){
                $rol_validado = true;
            }else{
                $rol_validado = false;
                $errores['rol'] = "El rol no es válido";
            }
    
            $guardar_usuario = false;
    
            if(count($errores) == 0){
                $usuario = $_SESSION['user'];
                $guardar_usuario = true;
    
                /* Comprobar si el email ya existe */
                $sql = "SELECT uid, email FROM users WHERE email = '$email_not_modify'";
                $isset_email = mysqli_query($db,$sql);
                $isset_user = mysqli_fetch_assoc($isset_email);
    
                if(isset($isset_user['uid'])){
    
                    /* Actualizar usuarios */
                    $sql = "UPDATE users SET " . 
                            "name = '$nombre',  " . 
                            "surname = '$apellidos',  " .  
                            "email = '$email',  " . 
                            "pass = '$password',  " .
                            "rol = '$rol'  " . 
                            "WHERE uid = " . $isset_user['uid'];
                    $guardar = mysqli_query($db,$sql);
    
                    if($guardar){
                        /* $_SESSION['user']['name'] = $nombre;
                        $_SESSION['user']['surname'] = $apellidos;
                        $_SESSION['user']['email'] = $email; */
                        $_SESSION['completed'] = "Tus datos se han actualizado con éxito";
                    }else{
                        $_SESSION['errors']['general'] = "Fallo al actualizar tus datos";
                    }
    
                }else{
                    $_SESSION['errors']['general'] = "El usuario ya existe";
                    
                }
            }else{
                $_SESSION['errors'] = $errores;
            }
        }
        header('Location: admin_modify.php');
    }else{
        header('Location: index.php');
    }
?>