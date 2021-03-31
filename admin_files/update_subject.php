<?php
    require_once '../includes/connection.php';
            
    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){
            
            /* mysqli_real_escape..... evita injección SQL */
            $nombre = isset($_POST['nombre']) ? mysqli_real_escape_string($db,$_POST['nombre']) : false;
            $id = isset($_POST['id']) ? mysqli_real_escape_string($db,$_POST['id']) : false;
    
            $errores = array();
    
            // Validar nombre
            if(!empty($nombre) && !is_numeric($nombre)){
                $nombre_validado = true;
            }else{
                $nombre_validado = false;
                $errores['nombre'] = "El nombre no es válido";
            }

            // Validar id
            if(!empty($id) && is_numeric($id)){
                $id_validado = true;
            }else{
                $id_validado = false;
                $errores['id'] = "El id no es válido";
            }

            if(count($errores) == 0){
    
                /* Comprobar si el id de la asignatura existe */
                $sql = "SELECT subjectid FROM subjects WHERE subjectid = '$id'";
                $result = mysqli_query($db,$sql);
                $isset_subject = mysqli_fetch_assoc($result);
    
                if(isset($isset_subject['subjectid'])){
    
                    $nombre_without_spaces = str_replace(' ','',$nombre);
                    /* Actualizar usuarios */
                    $sql = "UPDATE subjects SET " . 
                            "name = '$nombre_without_spaces'  " . 
                            "WHERE subjectid = " . $isset_subject['subjectid'];

                    $guardar = mysqli_query($db,$sql);;
    
                    if($guardar){
                        $_SESSION['completed'] = "La asignatura se ha modificado con éxito";
                    }else{
                        $_SESSION['errors']['general'] = "Fallo al actualizar la asignatura";
                    }
    
                }else{
                    $_SESSION['errors']['general'] = "La asignatura no existe";
                    
                }
            }else{
                $_SESSION['errors'] = $errores;
            }
        }
        header('Location: subject_modify.php');
    }else{
        header('Location: ../index.php');
    }
?>