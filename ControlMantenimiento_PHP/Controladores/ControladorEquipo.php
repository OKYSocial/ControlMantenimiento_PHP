<?php // Este es el controlador para el registro de Equipos y Maquinaria
     require_once '../Modelos/Equipo.php';
     require_once '../Controladores/Funciones.php';   
     require_once '../Controladores/Mensajes.php';
     
class ControladorEquipo {
      
    public static function GrabarEquipo()
    {
      $equipo = new Equipo();          
      $equipo->setEquipo_id(filter_input(INPUT_POST, 'itCampoClave', FILTER_SANITIZE_NUMBER_INT));
      $equipo->setNombre_equipo(strtoupper(filter_input(INPUT_POST, 'itNombre', FILTER_SANITIZE_STRING)));
      $equipo->setMarca(filter_input(INPUT_POST,'slMarcas'));      
      $equipo->setSerie(strtoupper(filter_input(INPUT_POST, 'itSerie',FILTER_SANITIZE_STRING)));
      $equipo->setLinea(filter_input(INPUT_POST, 'slLineas')); 
      $Lubricacion = filter_input(INPUT_POST, 'chLubricacion', FILTER_DEFAULT);
      $equipo->setLubricacion(!empty($Lubricacion)?1:0);     
      $controlador = Funciones::CrearControlador();
      $Resultado = $controlador->GuardarEquipo($equipo, '');
      if ($Resultado== 0)
      {
          $mensaje=NULL;
          header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=R&mensaje=$mensaje");
      }
      elseif ($Resultado == 1)
      {
           $mensaje= Mensaje7;
           header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");            
      }
      else 
      {
          $mensaje= MensajeErrorBD; 
          header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
      }     
      
    }
}

