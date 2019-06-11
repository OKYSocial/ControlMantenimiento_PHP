<?php // Este es el controlador para el cambio de clave de acceso al aplicativo    
     require_once '../Controladores/Funciones.php';
     require_once '../Controladores/Mensajes.php';    
       
class ControladorCambioClave {
    public static function GrabarCambioClave($claveanterior, $clavenueva)
    {         
        $controlador = Funciones::CrearControlador();              
        $Resultado = $controlador->GuardarCambioClave($claveanterior, $clavenueva);
        if ($Resultado == 0)
        { 
            $mensaje=NULL;
            header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=R&mensaje=$mensaje");
        }     
        elseif ($Resultado == 1)
        {
            $mensaje= Mensaje3;
            header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");   
        }
        else 
        {
            $mensaje= MensajeErrorBD;
            header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
        }      
          
    }
}


