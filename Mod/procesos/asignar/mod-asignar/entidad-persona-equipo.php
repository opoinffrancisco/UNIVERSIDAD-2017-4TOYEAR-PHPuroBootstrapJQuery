<?php
	class persona_equipo
	{
	    private $id_persona;
	    private $id_cargo;
	    private $id_departamento;
	    private $id_equipo;
	    private $fecha;
	    private $estado;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	