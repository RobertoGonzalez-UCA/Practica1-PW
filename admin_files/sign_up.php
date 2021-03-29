<?php
    require_once '../includes/connection.php';

    if($_SESSION['user']['rol'] == 'admin'){
        if(isset($_POST)){

            /* mysqli_real_escape..... evita injección SQL */
            $name = isset($_POST['name']) ? mysqli_real_escape_string($db,$_POST['name']) : false;
            $surname = isset($_POST['surname']) ? mysqli_real_escape_string($db,trim($_POST['surname'])) : false;
            $email = isset($_POST['email']) ? mysqli_real_escape_string($db,$_POST['email']) : false;
            $rol = isset($_POST['rol']) ? mysqli_real_escape_string($db,$_POST['rol']) : false;
            $password = isset($_POST['password']) ? mysqli_real_escape_string($db,$_POST['password']) : false;
            $pw = isset($_POST['pw']) ? mysqli_real_escape_string($db,$_POST['pw']) : false;
            $as = isset($_POST['as']) ? mysqli_real_escape_string($db,$_POST['as']) : false;
            $md = isset($_POST['md']) ? mysqli_real_escape_string($db,$_POST['md']) : false;
        
            $subject = array();
        
            if($pw != false){
                array_push($subject,$pw); 
            }
        
            if($as != false){
                array_push($subject,$as); 
            }
        
            if($md != false){
                array_push($subject,$md); 
            }
        
            $errors = array();
        
            // Validar nombre
            if(!empty($name) && !is_numeric($name) && !preg_match("/[0-9]/",$name)){
                $name_validated = true;
            }else{
                $name_validated = false;
                $errors['name'] = "El nombre no es válido";
            }
        
            // Validar apellidos
            if(!empty($surname) && !is_numeric($surname) && !preg_match("/[0-9]/",$surname)){
                $surname_validated = true;
            }else{
                $surname_validated = false;
                $errors['surname'] = "Los apellidos no son válidos";
            }
        
            // Validar email
            if(!empty($email) && filter_var($email, FILTER_VALIDATE_EMAIL)){
                $email_validated = true;
            }else{
                $email_validated = false;
                $errors['email'] = "El email no es válido";
            }
        
            // Validar rol
            if(!empty($rol) && !is_numeric($rol) && !preg_match("/[0-9]/",$rol)){
                $name_validated = true;
            }else{
                $name_validated = false;
                $errors['name'] = "El rol no es válido";
            }
        
            // Validar password
            if(!empty($password)){
                $password_validated = true;
            }else{
                $password_validated = false;
                $errors['password'] = "La contraseña está vacía";
            }
        
            // Validar asignaturas
            if(!empty($subject) && !is_numeric($subject)){
                $subject_validated = true;
            }else{
                $subject_validated = false;
                $errors['subject'] = "Error al seleccionar las asginaturas";
            }
        
            $save_user = false;
        
            if(count($errors) == 0){
                $save_user = true;
        
                $password_segura = password_hash($password,PASSWORD_DEFAULT);
        
                // Comprobar si coincide contraseña original con la cifrada
                //password_verify($password,$password_segura); // Devuelve true
        
                /* Primera Inserción */
                $sql = "INSERT INTO users VALUES(null,'$name','$surname','$email','$password','$rol')";
                $save = mysqli_query($db,$sql);
        
        
                if($save){
                    $_SESSION['completed'] = "El usuario se ha registrado con éxito";
                }else{
                    $_SESSION['errors']['general'] = "Fallo al registrar el usuario...";
                }
        
                
                /* Segunda Inserción */
                $num_subjects_ids = 0;
        
                $subject_uids = array();
                foreach ($subject as $current_subject) {
                       
                    $sql = "SELECT subjectid FROM subjects WHERE name='$current_subject'";
                    $save = mysqli_query($db,$sql);
                    
                    if($save && mysqli_num_rows($save) == 1){
                        array_push($subject_uids, mysqli_fetch_assoc($save));
                        $num_subjects_ids++;
                    }
                }
        
                /* Obtenemos el Id del nuevo usuario creado */
                $sql = "SELECT uid FROM users WHERE email='$email'";
                $save = mysqli_query($db,$sql);
        
                global $current_uid;
                if($save && mysqli_num_rows($save) == 1){
                    $current_uid = mysqli_fetch_assoc($save);
                    $current_uid = $current_uid['uid'];
                }
        
                if($num_subjects_ids == 1){
                    
                    $subject_uid_string = implode("", $subject_uids[0]);
        
                    $sql = "INSERT INTO usersubjects VALUES('$subject_uid_string','$current_uid')";
        
                    $save = mysqli_query($db,$sql);
                }elseif($num_subjects_ids > 1){
                    foreach($subject_uids as $subject_uid){
                        $subject_uid_string = implode("", $subject_uid);
        
                        $sql = "INSERT INTO usersubjects VALUES('$subject_uid_string','$current_uid')";
        
                        $save = mysqli_query($db,$sql);
                    }
                }
        
                if($save){
                    $_SESSION['completed'] = "El usuario se ha registrado con éxito";
                }else{
                    $_SESSION['errors']['general'] = "Fallo al registrar el usuario...";
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