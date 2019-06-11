<?php // Clase que representa la estructura en BD para control de Mantenimiento

class Mantenimiento {
   private $mantenimiento_id = 0; 
   private $equipo_id;
   private $operario_id;
   private $fecha;
   private $observaciones;
   
   
   public function __construct(){}
   
    function getMantenimiento_id() {
        return $this->mantenimiento_id;
    }

    function setMantenimiento_id($mantenimiento_id) {
        $this->mantenimiento_id = $mantenimiento_id;
    }

    public function getEquipo_Id()
    {
      return $this->equipo_id;
    }
    
    public function setEquipo_id($equipo_id)
    {
        $this->equipo_id = $equipo_id;
    }
    
    public function getOperario_Id()
    {
      return $this->operario_id;
    }
    public function setOperario_Id($operario_id)
    {
        $this->operario_id = $operario_id;
    }
    
    public function getFecha()
    {
      return $this->fecha;
    }
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }
    
     public function getObservaciones()
    {
      return $this->observaciones;
    }
    public function setObservaciones($observaciones)
    {
        $this->observaciones = $observaciones;
    }
    
}


