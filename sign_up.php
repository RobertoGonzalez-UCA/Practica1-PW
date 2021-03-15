<?php
    
    /* mysqli_real_escape..... evita injección SQL */
    if(isset($_POST)){

        require_once 'includes/connection.php';

        $name = isset($_POST['name']) ? mysqli_real_escape_string($db,$_POST['name']) : false;
        $surname = isset($_POST['surname']) ? mysqli_real_escape_string($db,trim($_POST['surname'])) : false;
        $email = isset($_POST['email']) ? mysqli_real_escape_string($db,$_POST['email']) : false;
        $rol = isset($_POST['rol']) ? mysqli_real_escape_string($db,$_POST['rol']) : false;
        $password = isset($_POST['password']) ? mysqli_real_escape_string($db,$_POST['password']) : false;

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

        $save_user = false;

        if(count($errors) == 0){
            $save_user = true;

            $password_segura = password_hash($password,PASSWORD_DEFAULT);

            // Comprobar si coincide contraseña original con la cifrada
            //password_verify($password,$password_segura); // Devuelve true

            $sql = "INSERT INTO users VALUES(null,'$name','$surname','$email','$password_segura','$rol')";
            $save = mysqli_query($db,$sql);


            if($save){
                $_SESSION['completed'] = "El registro se ha completado con éxito";
            }else{
                $_SESSION['errors']['general'] = "Fallo al guardar el usuario...";
            }

        }else{
            $_SESSION['errors'] = $errors;
        }
    }
    header('Location: index.php');
?>