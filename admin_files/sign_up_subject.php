<?php
    require_once '../includes/connection.php';

    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){

            /* mysqli_real_escape..... evita injección SQL */
            $name = isset($_POST['name']) ? mysqli_real_escape_string($db,$_POST['name']) : false;
            $degree_id = isset($_POST['degree_id']) ? mysqli_real_escape_string($db,trim($_POST['degree_id'])) : false;
            /* $coordinator = isset($_POST['coordinator']) ? mysqli_real_escape_string($db,trim($_POST['coordinator'])) : false; */
            
        
            // VALIDACIONES
            $errors = array();
        
            // Validar nombre
            if(!empty($name) && !is_numeric($name) && !preg_match("/[0-9]/",$name)){
                $name_validated = true;
            }else{
                $name_validated = false;
                $errors['name'] = "El nombre no es válido";
            }
        
            // Validar grado_id
            if(!empty($degree_id) && is_numeric($degree_id)){
                $degree_validated = true;
            }else{
                $degree_validated = false;
                $errors['degree_id'] = "El grado no es válido";
            }

            // Validar coordinador
            /* if(!empty($coordinator) && !is_numeric($coordinator) && !preg_match("/[0-9]/",$coordinator)){
                $coordinator_validated = true;
            }else{
                $coordinator_validated = false;
                $errors['coordinator'] = "El coordinador no es válido";
            } */
        
            
        
            $save_user = false;
        
            if(count($errors) == 0){
                $save_user = true;
        
                $password_segura = password_hash($password,PASSWORD_DEFAULT);
        
                // Comprobar si coincide contraseña original con la cifrada
                //password_verify($password,$password_segura); // Devuelve true
                $coordinator_id = 1;
                $sql = "INSERT INTO subjects VALUES(null,'$name','$degree_id','$coordinator_id')";
                $save = mysqli_query($db,$sql);
        
        
                if($save){
                    $_SESSION['completed'] = "La asignatura se ha registrado con éxito";
                }else{
                    $_SESSION['errors']['general'] = "Fallo al registrar la asignatura...";
                }
        
            }else{
                $_SESSION['errors'] = $errors;
            }
        }
        header('Location: ../admin.php');
    }else{
        header('Location: ../index.php'); 
    } 
?>