<?php // Clase que representa la estructura en BD ListaValores, donde almacenaremos Lineas y Marcas
           

class ListaValores {
     private $listavalores_id = 0;
     private $nombre;
     private $descripcion;
     private $tipo;
     
    public function __construct(){}
    
    public function getListaValores_Id()
    {
      return $this->listavalores_id;
    }
    
    public function setListaValores_Id($listavalores_id)
    {
        $this->listavalores_id = $listavalores_id;
    }
   
    public function getNombre()
    {
      return $this->nombre;
    }
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
    }
    
    public function getDescripcion()
    {
      return $this->descripcion;
    }
    public function setDescripcion($descripcion)
    {
        $this->descripcion = $descripcion;
    }
    
    public function getTipo()
    {
      return $this->tipo;
    }
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }
}


