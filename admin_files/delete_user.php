<?php
    require_once '../includes/connection.php';
            
    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){
            
            /* mysqli_real_escape..... evita injección SQL */
            $uid = isset($_POST['uid']) ? mysqli_real_escape_string($db,$_POST['uid']) : false;
    
            $errores = array();
    
            // Validar nombre
            if(!empty($uid) && is_numeric($uid)){
                $uid_validado = true;
            }else{
                $uid_validado = false;
                $errores['nombre'] = "El nombre no es válido";
            }
    
            if(count($errores) == 0){

                /* Comprobar si el usuario a borrar existe en la tabla users*/
                $sql = "SELECT uid, email FROM users WHERE uid = '$uid'";
                $isset_email = mysqli_query($db,$sql);
                $isset_user = mysqli_fetch_assoc($isset_email);

                if(isset($isset_user['uid'])){

                     /* Comprobar si el usuario a borrar existe en la tabla usersubjects*/
                    $sql_2 = "SELECT uid FROM usersubjects WHERE uid = '$uid'";
                    $isset_email_2 = mysqli_query($db,$sql_2);
                    $isset_user_2 = mysqli_fetch_assoc($isset_email);

                    if(isset($isset_user['uid'])){
                        /* Borrar usuario de usersubjects */
                        $sql_2 = "DELETE FROM usersubjects WHERE uid = " . $isset_user['uid'];
                        $save = mysqli_query($db,$sql_2);

                        
                        if($save){
                            $_SESSION['completed'] = "El usuario se ha borrado con éxito";
                        }else{
                            $_SESSION['errors']['general'] = "Fallo al actualizar tus datos";
                        }
                    }
                    
                    /* Borrar usuario de users */
                    $sql = "DELETE FROM users WHERE uid = " . $isset_user['uid'];
                    $save = mysqli_query($db,$sql);

                    if($save){
                        $_SESSION['completed'] = "El usuario se ha borrado con éxito";
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
        header('Location: ../index.php');
    }
?>