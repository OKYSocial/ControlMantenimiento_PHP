<?php // Este es el controlador para el registro de Marcas y Lineas
     require_once '../Modelos/ListaValores.php';
     require_once '../Controladores/Funciones.php';      
     require_once '../Controladores/Mensajes.php';
   
class ControladorListaValores {
   
    public static function GrabarListaValores()
    {
      $listavalores = new Listavalores ();                
      $listavalores->setListaValores_Id(filter_input(INPUT_POST, 'itCampoClave',FILTER_SANITIZE_NUMBER_INT));     
      $listavalores->setNombre(strtoupper(filter_input(INPUT_POST, 'itNombre', FILTER_SANITIZE_STRING)));
      $listavalores->setDescripcion(filter_input(INPUT_POST, 'itDescripcion',FILTER_SANITIZE_STRING));   
      $listavalores->setTipo(filter_input(INPUT_POST, 'itTipo',FILTER_SANITIZE_STRING));                 
      $controlador = Funciones::CrearControlador();
      $Resultado = $controlador->GuardarListaValores($listavalores, '');
      if ($Resultado == 0)
      {
          $mensaje=NULL;
          header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=R&mensaje=$mensaje");
      }
      elseif ($Resultado == 1)
      {
          $mensaje= Mensaje8;
          header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
      }
      else 
      {
          $mensaje= MensajeErrorBD;
          header("Location: ../Vistas/WebPage_Respuesta.php?respuesta=E&mensaje=$mensaje");
      }
    }
    
}
