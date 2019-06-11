<?php // DAL: Data Access Layer - Capa Acceso Datos con SQL Server

/* Para SQL Server hay un archivo en pdf donde se indica como descargar la DLL adecuada y todos los
   detalles a tener en cuenta para conectar con Microsoft SQL Server.
   En caso de utilizar este motor, se debe renombrar este archivo como AccesoDatos */

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
     $vecresultado = array(); 
     try 
     {  
        $cn = Conexion::ObtenerConexion();    
        $params = array(                 
                  array($Tabla, SQLSRV_PARAM_IN),  
                  array($DatoBuscar, SQLSRV_PARAM_IN)
                );         
        $callSP = '{CALL SPR_R_BuscarRegistro(?,?)}';
        $stmt=sqlsrv_query($cn, $callSP, $params);        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) )
        {
           array_push($vecresultado, $row);
        }
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close( $cn );
     }
     catch (Exception $ex)
     { 
       sqlsrv_close( $cn );
       echo $ex;     
     }
     return $vecresultado;
  }
  
  public function CargarListas($Tabla, $Opcion)
  {   
    $ListaElementos = array();  
    try
    {        
      $cn = Conexion::ObtenerConexion();     
      $params = array(                 
                array($Tabla, SQLSRV_PARAM_IN),  
                array($Opcion, SQLSRV_PARAM_IN)  
                );  
      $callSP = '{CALL SPR_R_CargarListado(?,?)}';
      $stmt=sqlsrv_query($cn, $callSP, $params);
       // Recorremos el resultado de la consulta y lo almacenamos en el array
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC ) )
          {
            array_push($ListaElementos, $row);           
          }
      sqlsrv_free_stmt( $stmt);
      sqlsrv_close( $cn );
    }    
    catch (Exception $ex)
    { 
      sqlsrv_close( $cn );
      echo $ex;     
    }
    return  $ListaElementos;
  }
   
  public function ControlProgramacion($Tabla)
  { 
    $ListaElementos = array();   
    try
    {
      $cn = Conexion::ObtenerConexion();     
      $params = array(                 
                array($Tabla, SQLSRV_PARAM_IN) 
                );  
      $callSP = '{CALL SPR_R_CargarCombosListas(?)}';
      $stmt=sqlsrv_query($cn, $callSP, $params);
      // Recorremos el resultado de la consulta y lo almacenamos en el array
          while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) )
          {            
            array_push($ListaElementos, $row[2], $row[0], $row[1]);   
          }
      sqlsrv_free_stmt( $stmt);
      sqlsrv_close( $cn );    
    }
    catch (Exception $ex)
    { 
       sqlsrv_close( $cn );
       echo $ex;     
    } 
    return  $ListaElementos;
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
    $operario = new Operario();      
    try
    { 
        $cn = Conexion::ObtenerConexion();    
        $params = array(                 
                  array($Documento, SQLSRV_PARAM_IN),  
                  array($Clave, SQLSRV_PARAM_IN)
                );         
        $callSP = '{CALL SPR_R_ObtenerAcceso(?,?)}';
        $stmt=sqlsrv_query($cn, $callSP, $params);        
        while( $row = sqlsrv_fetch_array( $stmt, SQLSRV_FETCH_NUMERIC) )
        {
           array_push($vecresultado, $row);
        }
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close( $cn );
        if ($vecr!= NULL)
        {
           $operario->setOperario_id($vecresultado[0][0]);          
           $operario->setNombres($vecresultado[0][1]);
           $operario->setApellidos($vecresultado[0][2]);     
           $operario->setPerfil($vecresultado[0][3]);       
           unset($vecr);
        }
        else
        {
            $operario = NULL;
        }
    }
    catch (Exception $ex)
    {
      echo $ex;
    }
    return $operario;
  }
  public function ObtenerOperario($DatoBuscar)
  {  
    $operario = new Operario();
    try
    { 
        $vecr = AccesoDatos::BuscarRegistro('TBL_OPERARIOS', $DatoBuscar);
        if ($vecr!= NULL)
        {
           $operario->setOperario_id($vecr[0][0]); 
           $operario->setDocumento($vecr[0][1]);
           $operario->setNombres($vecr[0][2]);
           $operario->setApellidos($vecr[0][3]);
           $operario->setTelefono($vecr[0][4]);
           $operario->setCorreo($vecr[0][5]);   
           $operario->setFoto($vecr[0][6]);
           unset($vecr);
        }
        else
        {
            $operario = NULL;
        }
    }
    catch (Exception $ex)
    {
      echo $ex;
    }
    return $operario;
  }

  public function GuardarOperario($operario, $usuario)
  {  
      $resultado = -1;
      try 
      {             
        $cn = Conexion::ObtenerConexion();       
        $params = array(                   
                        array($operario->getOperario_id(), SQLSRV_PARAM_IN),  
                        array($operario->getDocumento(), SQLSRV_PARAM_IN),                  
                        array($operario->getNombres(), SQLSRV_PARAM_IN),    
                        array($operario->getApellidos(), SQLSRV_PARAM_IN),   
                        array($operario->getTelefono(), SQLSRV_PARAM_IN),   
                        array($operario->getCorreo(), SQLSRV_PARAM_IN),  
                        array($operario->getFoto(), SQLSRV_PARAM_IN),   
                        array($usuario, SQLSRV_PARAM_IN),   
                        array(&$resultado, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_INT),
                        );  
          $callSP = "{CALL SPR_IU_Operarios(?,?,?,?,?,?,?,?,?)}";
          $stmt=sqlsrv_query($cn, $callSP, $params);
          sqlsrv_next_result($stmt);
          sqlsrv_free_stmt( $stmt);
          sqlsrv_close( $cn );                      
      }
      catch (Exception $ex)
      {
        sqlsrv_close($cn);  
        echo $ex;
      }
      return $resultado;
  }
  
  public function GuardarCambioClave($claveanterior, $clavenueva, $usuario)
  {    
    $resultado = -1;  
    try
    {        
        $cn = Conexion::ObtenerConexion();         
        $params = array(
                        array($usuario, SQLSRV_PARAM_IN),            
                        array($claveanterior, SQLSRV_PARAM_IN),
                        array($clavenueva, SQLSRV_PARAM_IN),                      
                        array(&$resultado, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_INT),
                        );                  
        $callSP = "{CALL SPR_U_CambioClave(?,?,? ?)}";
        $stmt=sqlsrv_query($cn, $callSP, $params);
        sqlsrv_next_result($stmt);
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close( $cn );
    }
    catch (Exception $ex)
    { 
       sqlsrv_close($cn); 
       echo $ex;     
    }        
    return $resultado;
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
    $listavalores = new ListaValores();
    try
    {
      $vecr = AccesoDatos::BuscarRegistro('TBL_LISTAVALORES', $DatoBuscar);
      if ($vecr!= NULL)
      {
        $listavalores->setListaValores_id($vecr[0][0]);
        $listavalores->setNombre($vecr[0][1]);
        $listavalores->setDescripcion($vecr[0][2]);
        $listavalores->setTipo($vecr[0][3]);   
        unset($vecr);
      }
      else
      {
          $listavalores = NULL;
      }
   }
   catch (Exception $ex)
   {
       echo $ex;
   }
   return $listavalores;   
  }

  public function GuardarListaValores($listavalores, $usuario)
  {      
    $resultado = -1;
    try
     {
        $cn = Conexion::ObtenerConexion();        
        $params = array(                   
                        array($listavalores->getListaValores_id(), SQLSRV_PARAM_IN),                  
                        array($listavalores->getNombre(), SQLSRV_PARAM_IN),    
                        array($listavalores->getDescripcion(), SQLSRV_PARAM_IN),   
                        array($listavalores->getTipo(), SQLSRV_PARAM_IN),
                        array($usuario, SQLSRV_PARAM_IN),   
                        array(&$resultado, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_INT),
                        );  
          $callSP = "{CALL SPR_IU_ListaValores(?,?,?,?,?,?)}";
          $stmt=sqlsrv_query($cn, $callSP, $params);
          sqlsrv_next_result($stmt);
          sqlsrv_free_stmt( $stmt);
          sqlsrv_close( $cn );
   }
   catch (Exception $ex)
   {
       sqlsrv_close($cn);
       echo $ex;
   }         
    return $resultado;   
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
    $equipo = new Equipo();  
    try 
    {
      $vecr = AccesoDatos::BuscarRegistro('TBL_EQUIPOS', $DatoBuscar);
      if ($vecr!= NULL)
      {
        $equipo->setEquipo_id($vecr[0][0]);
        $equipo->setNombre_equipo($vecr[0][1]);
        $equipo->setMarca($vecr[0][2]);
        $equipo->setSerie($vecr[0][3]);
        $equipo->setLinea($vecr[0][4]);
        $equipo->setLubricacion($vecr[0][5]);  
        unset($vecr);
      }
      else
      {
          $equipo = NULL;
      }
    }
    catch (Exception $ex)
    {
       echo $ex;
    }
    return $equipo;
  }

  public function GuardarEquipo($equipo, $usuario)
  {  
    $resultado = -1;  
    try
    {          
        $cn = Conexion::ObtenerConexion();       
        $params = array(                   
                        array($equipo->getEquipo_id(), SQLSRV_PARAM_IN),                  
                        array($equipo->getNombre_equipo(), SQLSRV_PARAM_IN),    
                        array($equipo->getMarca(), SQLSRV_PARAM_IN),   
                        array($equipo->getSerie(), SQLSRV_PARAM_IN),
                        array($equipo->getLinea(), SQLSRV_PARAM_IN),
                        array($equipo->getLubricacion(), SQLSRV_PARAM_IN),
                        array($usuario, SQLSRV_PARAM_IN),   
                        array(&$resultado, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_INT),
                        );  
          $callSP = "{CALL SPR_IU_Equipos(?,?,?,?,?,?,?,?)}";
          $stmt=sqlsrv_query($cn, $callSP, $params);
          sqlsrv_next_result($stmt);
          sqlsrv_free_stmt( $stmt);
          sqlsrv_close( $cn );
   }
   catch (Exception $ex)
   {
       sqlsrv_close($cn);
       echo $ex;
   }       
   return $resultado;      
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
    $mantenimiento = new Mantenimiento();
    try
    {      
      $vecr = AccesoDatos::BuscarRegistro('TBL_MANTENIMIENTO', $DatoBuscar);
      if ($vecr!= NULL)
      {
        $mantenimiento->setMantenimiento_id($vecr[0][0]);        
        $mantenimiento->setEquipo_id($vecr[0][1]);
        $mantenimiento->setOperario_id($vecr[0][2]);        
        $mantenimiento->setFecha($vecr[0][3]);
        $mantenimiento->setObservaciones($vecr[0][4]);
        unset($vecr);
      }
      else
      {
          $mantenimiento = NULL;
      }
    }
   catch (Exception $ex)
   {
       echo $ex;
   }
   return $mantenimiento;
  }
  
  public function GuardarMantenimiento($mantenimiento, $usuario)
  {  
    $resultado = -1;  
    try 
     {     
        $cn = Conexion::ObtenerConexion();         
        $params = array(                   
                        array($mantenimiento->getMantenimiento_id(), SQLSRV_PARAM_IN),  
                        array($mantenimiento->getEquipo_id(), SQLSRV_PARAM_IN),                  
                        array($mantenimiento->getOperario_id(), SQLSRV_PARAM_IN),    
                        array($mantenimiento->getFecha(), SQLSRV_PARAM_IN),   
                        array($mantenimiento->getObservaciones(), SQLSRV_PARAM_IN),   
                        array($usuario, SQLSRV_PARAM_IN),   
                        array(&$resultado, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_INT),
                        );  
          $callSP = "{CALL SPR_IU_Mantenimiento(?,?,?,?,?,?,?)}";
          $stmt=sqlsrv_query($cn, $callSP, $params);
          sqlsrv_next_result($stmt);
          sqlsrv_free_stmt( $stmt);
          sqlsrv_close( $cn );
   }
   catch (Exception $ex)
   {
       sqlsrv_close($cn);
       echo $ex;
   }
   return $resultado; 
  }
  
/*
=======================================================================================================
      Fin Operaciones sobre estructura Mantenimiento
=======================================================================================================
*/  
   
  public function EliminarRegistro($Tabla, $DatoEliminar)
  {   
   $resultado = -1;     
   try
   {          
        $cn = Conexion::ObtenerConexion();        
        $params = array(                   
                        array($Tabla, SQLSRV_PARAM_IN),  
                        array($DatoEliminar, SQLSRV_PARAM_IN),  
                        array(&$resultado, SQLSRV_PARAM_OUT, null, SQLSRV_SQLTYPE_INT),
                        );                  
        $callSP = "{CALL SPR_D_Registro(?,?,?)}";
        $stmt=sqlsrv_query($cn, $callSP, $params);
        sqlsrv_next_result($stmt);
        sqlsrv_free_stmt( $stmt);
        sqlsrv_close( $cn );
   }
   catch (Exception $ex)
   {
       sqlsrv_close($cn);
       echo $ex;
   }  
  }
  

     
}




