<?php // Interface que expone todo lo que el DAL (Capa Acceso Datos) implementa   
     
interface IAccesodatos {
    
public function ObtenerAcceso($Documento, $Clave);
public function ObtenerOperario($DatoBuscar);
public function ObtenerEquipo($DatoBuscar);
public function ObtenerMantenimiento($DatoBuscar);
public function ObtenerListaValores($DatoBuscar);

public function GuardarOperario($operario, $usuario);
public function GuardarCambioClave($claveanterior, $clavenueva, $usuario);
public function GuardarEquipo($equipo, $usuario);
public function GuardarMantenimiento($mantenimiento, $usuario); 
public function GuardarListaValores($listavalores, $usuario);

public function CargarListas($Tabla, $Opcion);
public function ControlProgramacion($Tabla);
public function EliminarRegistro($Tabla, $DatoEliminar);
  
}


