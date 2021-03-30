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

            if($rol != "admin"){
                // Recogiendo las asignaturas seleccionadas
                // Validación
                $sql = "SELECT * FROM subjects";
                $result = mysqli_query($db,$sql);
                if($result && mysqli_num_rows($result) > 1){
                    $subjects_id_choosen = array();

                    while($subjects = mysqli_fetch_assoc($result)){
                        $subject = $subjects['name'];
                        $subject_id = $subjects['subjectid'];

                        if(isset($_POST["$subject"])){
                            array_push($subjects_id_choosen,mysqli_real_escape_string($db,$_POST["$subject"]));
                        }
                    }
                }
                if(empty($subjects_id_choosen)){
                    $subject_validated = false;
                    $errors['subject'] = "Error al seleccionar las asginaturas";
                }else{
                    $subject_validated = true;
                }
            }
        
            $errors = array();
        
            // Validar nombre
            if(!empty($name) && !preg_match("/[0-9]/",$name)){
                $name_validated = true;
            }else{
                $name_validated = false;
                $errors['name'] = "El nombre no es válido";
            }
        
            // Validar apellidos
            if(!empty($surname) && !preg_match("/[0-9]/",$surname)){
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
            if(!empty($rol) && !preg_match("/[0-9]/",$rol)){
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
        
            if(count($errors) == 0){
        
                $password_segura = password_hash($password,PASSWORD_DEFAULT);
        
                // Comprobar si coincide contraseña original con la cifrada
                if(password_verify($password,$password_segura)){
                    if($rol != "admin"){

                        /* Primera Inserción */
                        $sql = "INSERT INTO users VALUES(null,'$name','$surname','$email','$password_segura','$rol')";
                        $save = mysqli_query($db,$sql);
                
                
                        if($save){
                            $_SESSION['completed'] = "El usuario se ha registrado con éxito";
                        }else{
                            $_SESSION['errors']['general'] = "Fallo al registrar el usuario...";
                        }
                
                        
                        /* Segunda Inserción */
                        $num_subjects_ids = 0;
                
                        $subject_uids = array();
                        foreach ($subjects_id_choosen as $current_subject) {
                            
                            $sql = "SELECT subjectid FROM subjects WHERE name='$current_subject'";
                            $save = mysqli_query($db,$sql);
    
                            if($save && mysqli_num_rows($save) == 1){
                                array_push($subject_uids, mysqli_fetch_assoc($save));
                                $num_subjects_ids++;
                                $_SESSION['completed'] = "El usuario se ha registrado con éxito";
                            }else{
                                $_SESSION['errors']['general'] = "Fallo al registrar el usuario...";
                                } 
                        }
                        
                
                        /* Obtenemos el Id del nuevo usuario creado */
                        $sql = "SELECT uid FROM users WHERE email='$email'";
                        $save = mysqli_query($db,$sql);

                        global $current_uid;
                        if($save && mysqli_num_rows($save) == 1){
                            $current_uid = mysqli_fetch_assoc($save);
                            $current_uid = $current_uid['uid'];

                            $_SESSION['completed'] = "El usuario se ha registrado con éxito";
                        }else{
                            $_SESSION['errors']['general'] = "Fallo al registrar el usuario...";
                            } 
                    

                
                        if($num_subjects_ids == 1){
                            
                            $subject_uid_string = implode("", $subject_uids[0]);
                
                            $sql = "INSERT INTO usersubjects VALUES('$subject_uid_string','$current_uid')";
                
                            $save = mysqli_query($db,$sql);
                        }elseif($num_subjects_ids > 1){
                            foreach($subject_uids as $subject_uid){
                                $subject_uid_string = implode("", $subject_uid);
                
                                var_dump($subject_uid_string, $subject_uid);

                                $sql = "INSERT INTO usersubjects VALUES('$subject_uid_string','$current_uid')";
    
                                $save = mysqli_query($db,$sql);
                            }
                            die(var_dump($subject_uids));
                        }
                    }else{
                        /* Primera Inserción */
                        $sql = "INSERT INTO users VALUES(null,'$name','$surname','$email','$password','$rol')";
                        $save = mysqli_query($db,$sql);
                
                
                        if($save){
                            $_SESSION['completed'] = "El usuario se ha registrado con éxito";
                        }else{
    
                            $_SESSION['errors']['general'] = "Fallo al registrar el usuario...";
                        } 
                    }
                }
            }else{
                $_SESSION['errors'] = $errors;
            }
        }
        header('Location: admin_register.php');
    }else{
        header('Location: ../index.php'); 
    } 
?>