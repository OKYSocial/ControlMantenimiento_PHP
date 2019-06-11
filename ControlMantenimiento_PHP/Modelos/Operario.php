<?php // Clase que representa la estructura en BD Operarios

class Operario {
     private $operario_id=0;
     private $documento;
     private $nombres;
     private $apellidos;
     private $telefono;
     private $correo;
     private $clave; // Este atributo no se está utilizando, pues la clave se gestiona en BD y nunca se trae    
     private $perfil;
     private $foto;
     
    public function __construct(){}
    
    public function getOperario_Id()
    {
      return $this->operario_id;
    }
    public function setOperario_Id($operario_id)
    {
        $this->operario_id = $operario_id;
    }
    
    public function getDocumento()
    {
      return $this->documento;
    }
    public function setDocumento($documento)
    {
        $this->documento = $documento;
    }
    
    public function getNombres()
    {
      return $this->nombres;
    }
    public function setNombres($nombres)
    {
        $this->nombres = $nombres;
    }
    
    public function getApellidos()
    {
      return $this->apellidos;
    }
    public function setApellidos($apellidos)
    {
        $this->apellidos = $apellidos;
    }
    
    public function getTelefono()
    {
      return $this->telefono;
    }
    public function setTelefono($telefono)
    {
        $this->telefono = $telefono;
    }

    public function getCorreo()
    {
      return $this->correo;
    }
    public function setCorreo($correo)
    {
        $this->correo = $correo;
    }
    public function getClave()
    {
      return $this->clave;
    }
    public function setClave($clave)
    {
        $this->clave = $clave;
    }

    public function getPerfil()
    {
      return $this->perfil;
    }
    public function setPerfil($perfil)
    {
        $this->perfil = $perfil;
    }
    public function getFoto()
    {
      return $this->foto;
    }
    public function setFoto($foto)
    {
        $this->foto = $foto;
    }
}


