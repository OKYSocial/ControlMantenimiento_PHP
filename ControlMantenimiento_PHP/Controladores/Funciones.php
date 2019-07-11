<?php // Esta es una clase transversal, desde donde se instancia el Factory Method y hay algunas validaciones
     require_once '../Controladores/Controlador.php';
     require_once '../Controladores/AccesoDatosFactory.php';
  
class Funciones
{   
   
   public static function CrearControlador()
   {
        $accesodatos = new AccesoDatos();
        $accesodatos = AccesoDatosFactory::ObtenerAccesoDatos($accesodatos);       
        return new Controlador($accesodatos);
    }
    
   public static function Validar_CampoRequerido($cadena)
   {     
     $respuesta = FALSE;  
     if (trim($cadena) == NULL)  // Validar Campo en blanco
     {
        $respuesta = TRUE;
     }
     return $respuesta;
   } 
   
   public static function Validar_Correo($cadena)
   {          
     $respuesta = FALSE;  
     if(!filter_var($cadena, FILTER_VALIDATE_EMAIL))  
     {
        $respuesta = TRUE;
     }
     return $respuesta;
   }
  
   public static function Validar_PrimeraPosicion($cadena)
   {
     $respuesta = FALSE;   
     if(substr($cadena,0,1) ==0)
     {
        $respuesta = TRUE;
     }     
     return $respuesta;
   }
   
   public static function Validar_SoloNumeros($cadena)
   {
     $respuesta = FALSE;  
     if (!preg_match("/^[0-9]+$/", $cadena))
     {
        $respuesta = TRUE;
     }
     return $respuesta;
   }
   
   public static function Validar_Longitud($cadena, $tipo, $valor1, $valor2)
   {
     $respuesta = FALSE;  
     if ($tipo == 'Menor')
     {
        if (strlen($cadena) < $valor1) 
        {
            $respuesta = TRUE;
        }
     }
     elseif ($tipo == 'Mayor') 
     {
        if (strlen($cadena) > $valor1) 
        {
            $respuesta = TRUE;
        }
     }
     else
     {            
        if ((strlen($cadena) !=$valor1) && (strlen($cadena) !=$valor2))
        {
            $respuesta = TRUE;
        }
     }
     
     return $respuesta;
   }
}


