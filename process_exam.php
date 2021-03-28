<?php
   $option = isset($_POST['subject-selected']) ? $_POST['subject-selected'] : false;
   if ($option) {
      echo htmlentities($_POST['subject-selected'], ENT_QUOTES, "UTF-8");
   } else {
     echo "task option is required";
     exit; 
   }
?>