<?php
	class solicitud
	{
	    private $id;
	    private $asunto;
	    private $descripcion;
	    private $fecha;
	    private $fecha_desde;
	    private $fecha_cierre;
	    private $id_persona;
	    private $id_cargo;
	    private $id_departamento;
	    private $id_equipo;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	