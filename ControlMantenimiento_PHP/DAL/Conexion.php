<?php // Clase que nos devuelve la conexion con el proveedor que se desee

class Conexion {
 
 public static function ObtenerConexion()
 {
    $server   = "localhost";
    $username = "root";
    $password = "";
    $database = "ControlMantenimientoDB"; 
    
    try
    {    
       $Conexion = new mysqli($server, $username, $password, $database);
       if (mysqli_connect_errno()){
        /*                  
          ==================================================================================
                               Conectar con SQL Server  
          ==================================================================================
           $serverName = "NombrePC\SQLEXPRESS";
           $connectionInfo=array( "Database"=>"controlmantenimientodb");                
           $Conexion = sqlsrv_connect( $serverName, $connectionInfo);
           if( !$Conexion ) {
        
          ==================================================================================
                               Conectar con ORACLE  
          ==================================================================================
          Si se desea efectuar la conexión con Oracle, debes reemplazar las dos lineas anteriores
          por las siguientes:
         
          $Conexion = oci_connect('CONTROLMANTENIMIENTODB', 'XXXX', 'localhost/XE');
          if (!$Conexion) {
         
          Y por supuesto reemplazar el DAL por el correspondiente a Oracle
          Además de quitar el ; del archivo PHP.ini para habilitar las conexiones hacia Oracle
          Ojo buscar y quitar el ; del comienzo de la siguiente línea en el PHP.ini
          ; extension=php_oci8_11g.dll  ; Use with Oracle 11gR2 Instant Client         
          ==================================================================================
        */
          
            die("No se puede conectar a la base de datos:");
        }
        else 
        {
           return($Conexion);
        }         
    }
    catch (Exception $ex)
    { 
       echo $ex;     
    }
 }

}


