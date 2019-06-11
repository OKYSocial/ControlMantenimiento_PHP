<?php // Este es el controlador para el Acceso al aplicativo    
     require_once '../Modelos/Operario.php';     
     require_once '../Controladores/Funciones.php';
                  
 class ControladorAcceso
 {
     public static function IngresarSistema($documento, $clave)
     {
      $operario=NULL;     
      if (($documento!= NULL) && ($clave!= NULL)) 
      {                     
         $controlador = Funciones::CrearControlador();                          
         $operario =  $controlador->ObtenerAcceso($documento, $clave ); 
         if ($operario != NULL)
         {  
            $_SESSION['UsuarioConectado'] = $operario->getOperario_Id();      
            $_SESSION['PerfilAcceso'] = $operario->getPerfil();
            $_SESSION['NombreUsuario']  = $operario->getNombres();       
            header("Location: ../Vistas/WebPage_Menu.php");                           
         }         
      }
    }         
       
 }


