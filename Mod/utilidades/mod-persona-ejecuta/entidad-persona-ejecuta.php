<?php
	class personaEjecuta
	{
	    private $detalles;
	    private $fecha;
	    private $id_persona;
	    private $id_funcion_persona;
	    private $id_mantenimiento;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	