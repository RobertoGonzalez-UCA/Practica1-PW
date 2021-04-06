<?php
    require_once '../includes/connection.php';

    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){

            /* mysqli_real_escape..... evita injección SQL */
            $name = isset($_POST['name']) ? mysqli_real_escape_string($db,$_POST['name']) : false;
            $degree_id = isset($_POST['degree_id']) ? mysqli_real_escape_string($db,trim($_POST['degree_id'])) : false;
            $coordinator_id = isset($_POST['coordinator_id']) ? mysqli_real_escape_string($db,trim($_POST['coordinator_id'])) : false;
            
            $errors = array();
        
            // Validar nombre
            if(!empty($name) && !preg_match("/[0-9]/",$name)){
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
            if(!empty($coordinator_id) && is_numeric($coordinator_id)){
                $coordinator_validated = true;
            }else{
                $coordinator_validated = false;
                $errors['coordinator'] = "El coordinador no es válido";
            }
        
            if(count($errors) == 0){
                $name_without_spaces = str_replace(' ','',$name);
                $sql = "INSERT INTO subjects VALUES(null,'$name_without_spaces','$degree_id','$coordinator_id')";
                $save = mysqli_query($db,$sql) or die('Error en la conexión a la BBDD');
                mysqli_close($db);

        
                if($save){
                    $_SESSION['completed'] = "La asignatura se ha registrado con éxito";
                }else{
                    $_SESSION['errors']['general'] = "Fallo al registrar la asignatura...";
                }
        
            }else{
                $_SESSION['errors'] = $errors;
            }
        }
        header('Location: subject_register.php');
    }else{
        header('Location: ../index.php'); 
    } 
?>