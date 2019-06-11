<?php // DAL: Data Access Layer - Capa Acceso Datos con Oracle

/* Para Oracle es conveniente modificar el formato de fecha a D/M/Y en el calendar y en el formulario de 
   Mantenimiento. 
   Aplicar en la BD este alter: alter session set nls_date_format='DD/MM/YYYY HH24:MI:SS'; 
   donde HH24:MI:SS es opcional.
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
  { // Metodo para buscar un registro especifico 
     $vecresultado = array(); 
     try 
     {          
          $cn = Conexion::ObtenerConexion(); 
          $rs = oci_parse($cn, "call SPR_R_BuscarRegistro('" . $Tabla . "', '" . $DatoBuscar . "', :rc)");
          // Recorremos el resultado de la consulta y lo almacenamos en el array
          $refcur = oci_new_cursor($cn);
          oci_bind_by_name($rs, ':rc', $refcur, -1, OCI_B_CURSOR);
          oci_execute($rs);
          oci_execute($refcur); 
          while($row = oci_fetch_array($refcur, OCI_NUM)) {
                array_push($vecresultado, $row);
          }
          oci_free_statement($refcur); 
          oci_close($cn);
     }
     catch (Exception $ex)
     { 
       oci_close($cn);
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
      $rs = oci_parse($cn, "CALL SPR_R_CargarListado('" . $Tabla . "', '" . $Opcion . "', :rc)");
      $refcur = oci_new_cursor($cn);
      oci_bind_by_name($rs, ':rc', $refcur, -1, OCI_B_CURSOR);
      oci_execute($rs);
      oci_execute($refcur); 
      while($row = oci_fetch_array($refcur, OCI_NUM)) {
            array_push($ListaElementos, $row);        
      }
      oci_free_statement($refcur); 
      oci_close($cn);
    }
    catch (Exception $ex)
    { 
       oci_close($cn); 
       echo $ex;     
    }
    return $ListaElementos;
  }

    
  public function ControlProgramacion($Tabla)
  {     
    $ListaElementos = array();       
    try
    {
      $cn = Conexion::ObtenerConexion();   
      $rs = oci_parse($cn, "CALL SPR_R_CargarCombosListas('" . $Tabla . "', :rc)");
      $refcur = oci_new_cursor($cn);
      oci_bind_by_name($rs, ':rc', $refcur, -1, OCI_B_CURSOR);
      oci_execute($rs);
      oci_execute($refcur);  
       while($row = oci_fetch_array($refcur, OCI_NUM)) {             
             array_push($ListaElementos, $row[2]);
             array_push($ListaElementos, $row[0]);
             array_push($ListaElementos, $row[1]);             
      }
      oci_free_statement($refcur); 
      oci_close($cn); 
    }
    catch (Exception $ex)
    { 
       oci_close($cn); 
       echo $ex;     
    } 
    return $ListaElementos;
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
        $rs = oci_parse($cn, "call SPR_R_ObtenerAcceso('" . $Documento . "', '" . $Clave . "', :rc)");
        $refcur = oci_new_cursor($cn);
        oci_bind_by_name($rs, ':rc', $refcur, -1, OCI_B_CURSOR);
        oci_execute($rs);
        oci_execute($refcur); 
        while($row = oci_fetch_array($refcur, OCI_NUM)) {
                array_push($vecresultado, $row);
        }
        oci_free_statement($refcur); 
        oci_close($cn);
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
        $operario->setFoto(!empty($vecr[0][6])?($vecr[0][6]):NULL);   
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
      $result = -1;
      try 
      {           
        $cn = Conexion::ObtenerConexion(); 
        $stid = oci_parse($cn, "CALL SPR_IU_Operarios( '" . $operario->getOperario_id() . "',
                                                       '" . $operario->getDocumento() . "',
                                                       '" . $operario->getNombres() . "', 
                                                       '" . $operario->getApellidos() . "', 
                                                       '" . $operario->getTelefono() . "', 
                                                       '" . $operario->getCorreo() . "',
                                                       '" . $operario->getFoto() . "', 
                                                       '" . $usuario . "',                                                                          
                                                       :result)");

       oci_bind_by_name($stid, ':result', $result, 2);
       oci_execute($stid);
       oci_free_statement($stid);       
       oci_close($cn);  
      }
      catch (Exception $ex)
      {
        echo $ex;
      }         
     return $result; 
  }
  
  public function GuardarCambioClave($claveanterior, $clavenueva, $usuario)
  {    
    $result = -1;  
    try
    {        
        $cn = Conexion::ObtenerConexion(); 
        $stid = oci_parse($cn, "CALL SPR_U_CambioClave( '" . $usuario . "', '" . $claveanterior . "', '" . $clavenueva . "', :result)");
        oci_bind_by_name($stid, ':result', $result, 2);
        oci_execute($stid);
        oci_free_statement($stid);       
        oci_close($cn);        
    }
    catch (Exception $ex)
    { 
       oci_close($cn); 
       echo $ex;     
    }
    return $result; 
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
        $listavalores->setDescripcion(!empty($vecr[0][2])?($vecr[0][2]):NULL);   
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
     $result = -1; 
     try
     {          
        $cn = Conexion::ObtenerConexion();  
        $stid = oci_parse($cn, "call SPR_IU_ListaValores( '" . $listavalores->getListaValores_id() . "', 
                                                          '" . $listavalores->getNombre() . "', 
                                                          '" . $listavalores->getDescripcion() . "', 
                                                          '" . $listavalores->getTipo() . "', 
                                                          '" . $usuario . "',  
                                                          :result)");
       oci_bind_by_name($stid, ':result', $result, 2);
       oci_execute($stid);
       oci_free_statement($stid);       
       oci_close($cn);  
   }
   catch (Exception $ex)
   {
       oci_close($cn);
       echo $ex;
   }           
   return $result; 
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
    $result = -1;   
    try
    {              
        $cn = Conexion::ObtenerConexion(); 
        $stid = oci_parse($cn, "CALL SPR_IU_Equipos( '" . $equipo->getEquipo_id() . "', 
                                                     '" . $equipo->getNombre_equipo() . "',
                                                     '" . $equipo->getMarca() . "', 
                                                     '" . $equipo->getSerie() . "', 
                                                     '" . $equipo->getLinea() . "',
                                                     '" . $equipo->getLubricacion() . "', 
                                                     '" . $usuario . "',
                                                     :result)");        
        oci_bind_by_name($stid, ':result', $result, 2);
        oci_execute($stid);
        oci_free_statement($stid);       
        oci_close($cn);         
   }
   catch (Exception $ex)
   {
       oci_close($cn);
       echo $ex;
   }
   return $result;
      
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
         $mantenimiento->setObservaciones(!empty($vecr[0][4])?($vecr[0][4]):NULL);           
         unset($vecr);
         return $mantenimiento;
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
    $result = -1;  
     try 
     {              
        $cn = Conexion::ObtenerConexion();  
        $stid = oci_parse($cn, "CALL SPR_IU_Mantenimiento( '" . $mantenimiento->getMantenimiento_id() . "', 
                                                           '" . $mantenimiento->getEquipo_id() . "', 
                                                           '" . $mantenimiento->getOperario_id() . "',
                                                           '" . date_format(new DateTime ($mantenimiento->getFecha()), 'd/m/Y' ) . "',   
                                                           '" . $mantenimiento->getObservaciones() . "', 
                                                           '" . $usuario . "', 
                                                           :result)");
         
        oci_bind_by_name($stid, ':result', $result);
        oci_execute($stid);
        oci_free_statement($stid);       
        oci_close($cn);  
   }
   catch (Exception $ex)
   {
       oci_close($cn);
       echo $ex;
   }        
   return $result;        
  }
  
/*
=======================================================================================================
      Fin Operaciones sobre estructura Mantenimiento
=======================================================================================================
*/  

   
  public function EliminarRegistro($Tabla, $DatoEliminar)
  { 
    $result = -1;  
    try
    {            
       $cn = Conexion::ObtenerConexion();   
       $stid = oci_parse($cn, "CALL SPR_D_Registro( '" . $Tabla . "', '" . $DatoEliminar . "',  :result)");
       oci_bind_by_name($stid, ':result', $result, 2);
       oci_execute($stid);
       oci_free_statement($stid);       
       oci_close($cn);  
    }
    catch (Exception $ex)
    {
        oci_close($cn);
        echo $ex;
    }  
    return $result;  
  }
  
}




