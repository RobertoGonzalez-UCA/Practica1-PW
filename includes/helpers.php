<?php

    function mostrarError($errores,$campo){
        if(isset($errores[$campo]) && !empty($campo)){
            $alerta = "<div class='alerta alerta-error'>" . $errores[$campo] . '</div>';
            return $alerta;
        }
    }

    function borrarErrores(){
        $borrado = false;

        if(isset($_SESSION['errors'])){
            $_SESSION['errors'] = null;
            unset($_SESSION['errors']);
            $borrado = true;
        }

        if(isset($_SESSION['completed'])){
            $_SESSION['completed'] = null;
            unset($_SESSION['completed']);
            $borrado = true;
        }
    }  
?>