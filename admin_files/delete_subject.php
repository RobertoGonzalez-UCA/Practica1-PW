<?php
    require_once '../includes/connection.php';
            
    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){
            
            /* mysqli_real_escape..... evita injección SQL */
            $id = isset($_POST['id']) ? mysqli_real_escape_string($db,$_POST['id']) : false;
    
            $errores = array();
    
            // Validar nombre
            if(!empty($id) && is_numeric($id)){
                $id_validado = true;
            }else{
                $id_validado = false;
                $errores['nombre'] = "El id no es válido";
            }
        
            if(count($errores) == 0){
                /* Comprobar si la asignatura a borrar existe en la tabla subjects */
                $sql = "SELECT subjectid FROM subjects WHERE subjectid = '$id'";
                $result = mysqli_query($db,$sql) or die('Error en la conexión a la BBDD');
                $isset_id = mysqli_fetch_assoc($result);

                if(isset($isset_id['subjectid'])){
                     /* Comprobar si la asignatura a borrar existe en la tabla usersubjects*/
                    $sql_2 = "SELECT subjectid FROM usersubjects WHERE subjectid = '$id'";
                    $result_2 = mysqli_query($db,$sql_2) or die('Error en la conexión a la BBDD');
                    $isset_id_2 = mysqli_fetch_assoc($result_2);

                    if(isset($isset_id_2['subjectid'])){
                        /* Borrar usuario de usersubjects */
                        $sql_2 = "DELETE FROM usersubjects WHERE subjectid = " . $isset_id_2['subjectid'];
                        $save = mysqli_query($db,$sql_2) or die('Error en la conexión a la BBDD');

                        
                        if($save){
                            $_SESSION['completed'] = "La asignatura se ha borrado con éxito";
                        }else{
                            $_SESSION['errors']['general'] = "Fallo al borrar la asignatura";
                        }
                    }
                    
                    /* Borrar asignatura de subjects */
                    $sql = "DELETE FROM subjects WHERE subjectid = " . $isset_id['subjectid'];
                    $save = mysqli_query($db,$sql) or die('Error en la conexión a la BBDD');

                    if($save){
                        $_SESSION['completed'] = "La asignatura se ha borrado con éxito";
                    }else{
                        $_SESSION['errors']['general'] = "Fallo al borrar la asignatura";
                    }
                }else{
                    $_SESSION['errors']['general'] = "La asignatura a borrar no existe";  
                }
                mysqli_close($db);
            }else{
                $_SESSION['errors'] = $errores;
            }
        }
        header('Location: subject_modify.php');
    }else{
        header('Location: ../index.php');
    }
?>