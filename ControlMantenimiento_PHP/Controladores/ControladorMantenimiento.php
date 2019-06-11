<?php // Este es el controlador para programar mantenimientos en los equipos
     require_once '../Modelos/Mantenimiento.php';
     require_once '../Controladores/Funciones.php';   
     require_once '../Controladores/Mensajes.php';
     
class ControladorMantenimiento 
{
   public static function GrabarMantenimiento()
   {           
     $mantenimiento = new Mantenimiento();  
     $mantenimiento->setMantenimiento_id(filter_input(INPUT_POST, 'itCampoClave'), FILTER_SANITIZE_NUMBER_INT); 
     $mantenimiento->setEquipo_Id(filter_input(INPUT_POST, 'slEquipos'), FILTER_SANITIZE_NUMBER_INT);       
     $mantenimiento->setOperario_Id(filter_input(INPUT_POST, 'slOperarios'), FILTER_SANITIZE_STRING);             
     $mantenimiento->setFecha(filter_input(INPUT_POST, 'itFecha', FILTER_SANITIZE_STRING));      
     $mantenimiento->setObservaciones(filter_input(INPUT_POST, 'itObservaciones', FILTER_SANITIZE_STRING));  
     
     $controlador = Funciones::CrearControlador();
     $Resultado=$controlador->GuardarMantenimiento($mantenimiento);
     if ($Resultado== 0)
     {         
          $mensaje=NULL;
          header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=R&mensaje=$mensaje");   
     }
     elseif ($Resultado == 1)
     {
        $mensaje= Mensaje10;         
        header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");   
     }
     else 
     {
         $mensaje= MensajeErrorBD; 
         header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");   
     }   

   }     
 
}


