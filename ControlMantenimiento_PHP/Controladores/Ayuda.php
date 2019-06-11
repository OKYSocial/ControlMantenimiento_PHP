<?php // Estas líneas son las encargadas de llamar el archivo de ayudas chm o PDF

     $Proces = shell_exec('C:\xampp\htdocs\ControlMantenimiento_php\resources\Ayudas\Ayuda.chm');
     shell_exec('kill '.$Proces);
     header("Location: ../Vistas/WebPage_Menu.php");      

    