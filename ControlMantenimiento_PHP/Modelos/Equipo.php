<?php // Clase que representa la estructura en BD para Equipos

class Equipo {
   private $equipo_id = 0;
   private $nombre_equipo;
   private $marca;
   private $serie;
   private $linea;
   private $lubricacion = 0;
   
   
    public function __construct(){}
    
    function getEquipo_id() {
        return $this->equipo_id;
    }

    function getNombre_equipo() {
        return $this->nombre_equipo;
    }

    function setEquipo_id($equipo_id) {
        $this->equipo_id = $equipo_id;
    }

    function setNombre_equipo($nombre_equipo) {
        $this->nombre_equipo = $nombre_equipo;
    }

    public function getMarca()
    {
      return $this->marca;
    }
    
    public function setMarca($marca)
    {
        $this->marca = $marca;
    }

    public function getSerie()
    {
      return $this->serie;
    }
    
    public function setSerie($serie)
    {
        $this->serie = $serie;
    }
    
    public function getLinea()
    {
      return $this->linea;
    }
    
    public function setLinea($linea)
    {
        $this->linea = $linea;
    }
    
    public function getLubricacion()
    {
      return $this->lubricacion;
    }
    
    public function setLubricacion($lubricacion)
    {
        $this->lubricacion = $lubricacion;
    }
    
}


