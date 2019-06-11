<?php // Este es el Controlador Manager general de todo el sistema. Todo tiene que pasar por esta clase
     session_start();       
     require_once '../DAL/AccesoDatos.php';       
     
 class Controlador  {
    
    protected $iaccesoDatos;
    public $usuario;
        
    public function __construct(IAccesodatos $iaccesoDatos)
    {
        $this->iaccesoDatos=new AccesoDatos();
    }             
    
    private static function ObtenerUsuario()
    { // Obtener usuario Conectado de la sesion
      try
      {
        session_start();
        if(!empty($_SESSION['UsuarioConectado']))
        {
          $user = $_SESSION['UsuarioConectado'];
          return $user;
        } 
        else
        {
          header("Location: ../Vistas/index.php");                 
        }
      }
      catch (Exception $ex)
      {
        echo $ex;
      }
     }
     
    public function ObtenerAcceso($DatoBuscar, $Clave ) 
    {          
        return $this->iaccesoDatos->ObtenerAcceso($DatoBuscar, $Clave);       
    }
    
    public function ObtenerOperario($DatoBuscar)
    {
        return $this->iaccesoDatos->ObtenerOperario($DatoBuscar);
    }
    
    public function ObtenerEquipo($DatoBuscar)
    {
       return $this->iaccesoDatos->ObtenerEquipo($DatoBuscar);
    }   
    
    public function ObtenerMantenimiento($DatoBuscar)
    {
       return $this->iaccesoDatos->ObtenerMantenimiento($DatoBuscar);
    }
    
    public function ObtenerListaValores($DatoBuscar)
    {
       return $this->iaccesoDatos->ObtenerListaValores($DatoBuscar);
    }
                
    public function GuardarCambioClave($claveanterior, $clavenueva)
    {
      $usuario= Controlador::ObtenerUsuario();        
      return $this->iaccesoDatos->GuardarCambioClave($claveanterior, $clavenueva, $usuario);
    }
    
    public function GuardarOperario ($Object)
    {
       $usuario= Controlador::ObtenerUsuario();  
       return $this->iaccesoDatos->GuardarOperario($Object, $usuario); 
    }

    public function GuardarEquipo ($Object)
    {
      $usuario= Controlador::ObtenerUsuario();   
      return $this->iaccesoDatos->GuardarEquipo($Object, $usuario);
    }

    public function GuardarMantenimiento ($Object)
    {
      $usuario= Controlador::ObtenerUsuario(); 
      return $this->iaccesoDatos->GuardarMantenimiento($Object, $usuario);
    }

    public function GuardarListaValores ($Object)
    {
      $usuario= Controlador::ObtenerUsuario(); 
      return $this->iaccesoDatos->GuardarListaValores($Object, $usuario);
    }    
    
    public function CargarListas($Tabla, $Opcion) {
       return $this->iaccesoDatos->CargarListas($Tabla, $Opcion);
    }
    
    public function EliminarRegistro($Tabla, $DatoBuscar){        
        return $this->iaccesoDatos->EliminarRegistro($Tabla, $DatoBuscar);
    }    

    public function ControlProgramacion($Tabla){      
      return $this->iaccesoDatos->ControlProgramacion($Tabla);
    }    
    
}



          