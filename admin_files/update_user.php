<?php
    require_once '../includes/connection.php';
            
    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){
            
            /* mysqli_real_escape..... evita injección SQL */
            $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
            $apellidos = isset($_POST['apellidos']) ? mysqli_real_escape_string($db,trim($_POST['apellidos'])) : false;
            $email = isset($_POST['email']) ? mysqli_real_escape_string($db,$_POST['email']) : false;
            $email_not_modify = isset($_POST['email_not_modify']) ? mysqli_real_escape_string($db,$_POST['email_not_modify']) : false;
            $rol = isset($_POST['rol']) ? mysqli_real_escape_string($db,$_POST['rol']) : false;
    
            $errores = array();
    
            // Validar nombre
            if(!empty($nombre) && !preg_match("/[0-9]/",$nombre)){
                $nombre_validado = true;
            }else{
                $nombre_validado = false;
                $errores['nombre'] = "El nombre no es válido";
            }
    
            // Validar apellidos
            if(!empty($apellidos) && !preg_match("/[0-9]/",$apellidos)){
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
            if(!empty($rol) && !preg_match("/[0-9]/",$rol)){
                $rol_validado = true;
            }else{
                $rol_validado = false;
                $errores['rol'] = "El rol no es válido";
            }
        
            if(count($errores) == 0){
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
                            "rol = '$rol'  " . 
                            "WHERE uid = " . $isset_user['uid'];
                    $save = mysqli_query($db,$sql);
    
                    if($save){
                        $_SESSION['completed'] = "El usuario se ha modificado con éxito";
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
        header('Location: ../user_data.php');
    }else{
        header('Location: ../index.php');
    }
?>