<?php // Este es el controlador para el registro de Operarios
     require_once '../Modelos/Operario.php';     
     require_once '../Controladores/Mensajes.php';   
     require_once '../Controladores/Funciones.php';
     
class ControladorOperario {
     public static function GrabarOperario($accion, $foto)
     {       
       $operario = new Operario();   
       $operario->setOperario_Id(filter_input(INPUT_POST, 'itCampoClave',FILTER_SANITIZE_NUMBER_INT));        
       $operario->setDocumento(filter_input(INPUT_POST, 'itDocumento',FILTER_SANITIZE_STRING));
       $operario->setNombres(ucwords(strtolower(filter_input(INPUT_POST, 'itNombres',FILTER_SANITIZE_STRING))));
       $operario->setApellidos(ucwords(strtolower(filter_input(INPUT_POST, 'itApellidos',FILTER_SANITIZE_STRING))));        
       $operario->setTelefono(filter_input(INPUT_POST, 'itTelefono',FILTER_SANITIZE_NUMBER_INT));
       $operario->setCorreo(strtolower(filter_input(INPUT_POST, 'itCorreo', FILTER_SANITIZE_EMAIL)));
       $operario->setFoto($foto);
     
       $controlador = Funciones::CrearControlador();       
       $Resultado = $controlador->GuardarOperario($operario, $accion);         
       
       if ($Resultado==0) 
       {
         $mensaje=NULL;  
         header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=R&mensaje=$mensaje");   
       }
       elseif ($Resultado == 1)
       {
            $mensaje= Mensaje26;
            header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");   
       }
       else 
       {
           $mensaje= MensajeErrorBD;
           header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");   
       }     
     }

}



