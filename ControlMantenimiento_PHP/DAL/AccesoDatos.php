<?php // DAL: Data Access Layer - Capa Acceso Datos con MySQL

require_once '../DAL/Conexion.php';
require_once '../DAL/IAccesodatos.php';

class AccesoDatos implements IAccesodatos {
    
    private $cn = NULL;      // Alias para la Conexion
    private $vecr = array(); // Vector con Resultados
    
/*
=======================================================================================================
      Inicio Metodos de Busqueda
=======================================================================================================
*/
    
 private static function BuscarRegistro($Tabla, $DatoBuscar)
  { // Funcion para buscar un registro especifico             
     try 
     {           
        $cn = Conexion::ObtenerConexion();
        $rs= $cn->query("CALL SPR_R_BuscarRegistro('" . $Tabla . "', '" . $DatoBuscar . "')");
        $vecresultado = array(); // Recorremos el resultado de la consulta y lo almacenamos en el array
        while ($fila = $rs->fetch_row()) {
               array_push($vecresultado, $fila);                
        }
        mysqli_free_result($rs);
        mysqli_close($cn);
        return $vecresultado;
     }
     catch (Exception $ex)
     { 
       mysqli_close($cn);
       echo $ex;     
     }
  }
  
  public function CargarListas($Tabla, $Opcion)
  { 
    $ListaElementos = array();    
    try
    {
      $cn = Conexion::ObtenerConexion();  
      $rs= $cn->query("CALL SPR_R_CargarListado('" . $Tabla . "',  '" . $Opcion . "')");          
      while ($fila = $rs->fetch_row())
      {
         array_push($ListaElementos, $fila);                
      }
      mysqli_free_result ($rs);
      mysqli_close($cn);
      return  $ListaElementos;
    }
    catch (Exception $ex)
    { 
       mysqli_close($cn); 
       echo $ex;     
    }
  }
   
    public function ControlProgramacion($Tabla)
  { 
    $resultado1=null;
    $resultado2=null;     
    $resultado3=null;     
    try
    {
      $cn = Conexion::ObtenerConexion();  
      $RefCAllSp = $cn->prepare('CALL SPR_R_CargarCombosListas(?)');
      $RefCAllSp->bind_param("s", $Tabla);
      $RefCAllSp->execute();      
      $RefCAllSp->bind_result($resultado1, $resultado2, $resultado3); 
      $ListaElementos = array();
      while ($RefCAllSp->fetch())
      {  
           array_push($ListaElementos, $resultado3);  
           array_push($ListaElementos, $resultado1);
           array_push($ListaElementos, $resultado2);
      }
         mysqli_stmt_close ($RefCAllSp);
         mysqli_close($cn);      
         return $ListaElementos;
    }
    catch (Exception $ex)
    { 
       mysqli_close($cn); 
       echo $ex;     
    } 
  }
    
  /*
=======================================================================================================
      Fin Metodos de Busqueda
=======================================================================================================
=======================================================================================================
      Inicio Operaciones sobre estructura Operarios
=======================================================================================================
*/
  public function ObtenerAcceso($Documento, $Clave)
  {
    try
    { 
       $cn = Conexion::ObtenerConexion();
       $rs= $cn->query("CALL SPR_R_ObtenerAcceso('" . $Documento . "', '" . $Clave . "')");
       $vecresultado = array(); // Recorremos el resultado de la consulta y lo almacenamos en el array
       while ($fila = $rs->fetch_row()) {
              array_push($vecresultado, $fila);                
       }
       mysqli_free_result($rs);
       mysqli_close($cn);
       if ($vecresultado!= NULL)
       {
          $operario = new Operario();          
          $operario->setOperario_Id($vecresultado[0][0]);          
          $operario->setNombres($vecresultado[0][1]);
          $operario->setApellidos($vecresultado[0][2]); 
          $operario->setPerfil($vecresultado[0][3]);
          unset($vecresultado);
          return $operario;
       }
       else
       {
         return NULL;
       }
    }
    catch (Exception $ex)
    {
      echo $ex;
    }
  }
  
  public function ObtenerOperario($DatoBuscar)
  {  
    try
    { 
       $vecr = AccesoDatos::BuscarRegistro('TBL_OPERARIOS', $DatoBuscar);
       if ($vecr!= NULL)
       {
          $operario = new Operario();
          $operario->setOperario_Id($vecr[0][0]);
          $operario->setDocumento($vecr[0][1]);
          $operario->setNombres($vecr[0][2]);
          $operario->setApellidos($vecr[0][3]);
          $operario->setTelefono($vecr[0][4]);
          $operario->setCorreo($vecr[0][5]);   
          $operario->setFoto($vecr[0][6]);
          unset($vecr);
          return $operario;
       }
       else
       {
         return NULL;
       }
    }
    catch (Exception $ex)
    {
      echo $ex;
    }
  }

  public function GuardarOperario($operario, $usuario)
  { 
     try 
     {                   
        $cn = Conexion::ObtenerConexion(); 
        $cn->query("SET @result = 1");
        $cn->query("CALL SPR_IU_Operarios('" . $operario->getOperario_Id() . "',
                                          '" . $operario->getDocumento() . "',
                                          '" . $operario->getNombres() . "', 
                                          '" . $operario->getApellidos() . "', 
                                          '" . $operario->getTelefono() . "', 
                                          '" . $operario->getCorreo() . "',                                         
                                          '" . $operario->getFoto() . "', 
                                          '" . $usuario . "',                                                                          
                                          @result)");

        $res = $cn->query("SELECT @result AS result");
        $row = $res->fetch_assoc();
        mysqli_close($cn);
        return $row['result'];          
     }
     catch (Exception $ex)
     {
        mysqli_close($cn);  
        echo $ex;
     }
  }
  
  public function GuardarCambioClave($claveanterior, $clavenueva, $usuario)
  {   
    try
    {                    
       $cn = Conexion::ObtenerConexion(); 
       $cn->query("SET @result = 1");
       $cn->query("CALL SPR_U_CambioClave('" . $usuario . "', 
                                          '" . $claveanterior . "', 
                                          '" . $clavenueva . "', 
                                          @result)");
       $res = $cn->query("SELECT @result AS result");
       $row = $res->fetch_assoc();
       mysqli_close($cn);
       return $row['result'];        
    }
    catch (Exception $ex)
    { 
       mysqli_close($cn); 
       echo $ex;     
    }
  }

  /*
=======================================================================================================
      Fin Operaciones sobre estructura Operarios
=======================================================================================================
=======================================================================================================
      Inicio Operaciones sobre estructura Lista de Valores
=======================================================================================================
*/

  public function ObtenerListaValores($DatoBuscar)
  {  
    try
    {
       $vecr = AccesoDatos::BuscarRegistro('TBL_LISTAVALORES', $DatoBuscar);
       if ($vecr!= NULL)
       {
         $listavalores = new ListaValores();
         $listavalores->setListaValores_Id($vecr[0][0]);
         $listavalores->setNombre($vecr[0][1]);
         $listavalores->setDescripcion($vecr[0][2]);
         $listavalores->setTipo($vecr[0][3]);   
         unset($vecr);
         return $listavalores;
       }
       else
       {
          return NULL;
       }
   }
   catch (Exception $ex)
   {
       echo $ex;
   }
  }

  public function GuardarListaValores($listavalores, $usuario)
  {          
     try
     {             
        $cn = Conexion::ObtenerConexion(); 
        $cn->query("SET @result = 1");
        $cn->query("CALL SPR_IU_ListaValores('" . $listavalores->getListaValores_Id() . "', 
                                             '" . $listavalores->getNombre() . "', 
                                             '" . $listavalores->getDescripcion() . "', 
                                             '" . $listavalores->getTipo() . "', 
                                             '" . $usuario . "',  
                                             @result)");

        $res = $cn->query("SELECT @result AS result");
        $row = $res->fetch_assoc();
        mysqli_close($cn);
        return $row['result'];
     }
     catch (Exception $ex)
     {
       mysqli_close($cn);
       echo $ex;
     }  
  }
 /*
=======================================================================================================
      Fin Operaciones sobre estructura Lista de Valores
=======================================================================================================
=======================================================================================================
      Inicio Operaciones sobre estructura Equipos y Maquinaria
=======================================================================================================
*/ 
  public function ObtenerEquipo($DatoBuscar)
  { 
    try 
    {
       $vecr = AccesoDatos::BuscarRegistro('TBL_EQUIPOS', $DatoBuscar);
       if ($vecr!= NULL)
       {
         $equipo = new Equipo();
         $equipo->setEquipo_id($vecr[0][0]);
         $equipo->setNombre_equipo($vecr[0][1]);
         $equipo->setMarca($vecr[0][2]);
         $equipo->setSerie($vecr[0][3]);
         $equipo->setLinea($vecr[0][4]);
         $equipo->setLubricacion($vecr[0][5]);  
         unset($vecr);
         return $equipo;
       }
       else
       {
          return NULL;
       }
    }
    catch (Exception $ex)
    {
       echo $ex;
    }
  }

  public function GuardarEquipo($equipo, $usuario)
  { 
    try
    {
        $cn = Conexion::ObtenerConexion();
        $cn->query("SET @result = 1");
        $cn->query("CALL SPR_IU_Equipos('" . $equipo->getEquipo_id() . "', 
                                        '" . $equipo->getNombre_equipo() . "',
                                        '" . $equipo->getMarca() . "', 
                                        '" . $equipo->getSerie() . "', 
                                        '" . $equipo->getLinea() . "', 
                                        '" . $equipo->getLubricacion() . "', 
                                        '" . $usuario . "',
                                        @result)");

        $res = $cn->query("SELECT @result AS result");
        $row = $res->fetch_assoc();
        mysqli_close($cn);
        return $row['result'];
   }
   catch (Exception $ex)
   {
       mysqli_close($cn);
       echo $ex;
   }
      
  }
/*
=======================================================================================================
      Fin Operaciones sobre estructura Equipos y Maquinaria
=======================================================================================================
=======================================================================================================
      Inicio Operaciones sobre estructura Mantenimiento
=======================================================================================================
*/  
 
  public function ObtenerMantenimiento($DatoBuscar)
  {  
    try
    {      
       $vecr = AccesoDatos::BuscarRegistro('TBL_MANTENIMIENTO', $DatoBuscar);
       if ($vecr!= NULL)
       {
         $mantenimiento = new Mantenimiento();         
         $mantenimiento->setMantenimiento_Id($vecr[0][0]);
         $mantenimiento->setEquipo_Id($vecr[0][1]);
         $mantenimiento->setOperario_Id($vecr[0][2]);        
         $mantenimiento->setFecha($vecr[0][3]);
         $mantenimiento->setObservaciones($vecr[0][4]);
         unset($vecr);
         return $mantenimiento;
       }
       else
       {
          return NULL;
       }
    }
   catch (Exception $ex)
   {
       echo $ex;
   }
  }
  
  public function GuardarMantenimiento($mantenimiento, $usuario)
  {  
     try 
     {        
        $cn = Conexion::ObtenerConexion();     
        $cn->query("SET @result = 1");
        $cn->query("CALL SPR_IU_Mantenimiento('" . $mantenimiento->getMantenimiento_Id() . "', 
                                              '" . $mantenimiento->getEquipo_Id() . "', 
                                              '" . $mantenimiento->getOperario_Id() . "',
                                              '" . $mantenimiento->getFecha() . "', 
                                              '" . $mantenimiento->getObservaciones() . "', 
                                              '" . $usuario . "', 
                                              @result)");

        $res = $cn->query("SELECT @result AS result");
        $row = $res->fetch_assoc();
        mysqli_close($cn);
        return $row['result'];
   }
   catch (Exception $ex)
   {
       mysqli_close($cn);
       echo $ex;
   }      
  }
  
/*
=======================================================================================================
      Fin Operaciones sobre estructura Mantenimiento
=======================================================================================================
*/  
   
  public function EliminarRegistro($Tabla, $DatoEliminar)
  {
   try
   {   
      $cn = Conexion::ObtenerConexion();    
      $cn->query("SET @result = 1");
      $cn->query("CALL SPR_D_Registro('" . $Tabla . "', '" . $DatoEliminar . "',  @result)");
   
      $res = $cn->query("SELECT @result AS result");
      $row = $res->fetch_assoc();
      mysqli_close($cn);
      return $row['result'];
   }
   catch (Exception $ex)
   {
      mysqli_close($cn);
      echo $ex;
   }  
  }
  
     
}




