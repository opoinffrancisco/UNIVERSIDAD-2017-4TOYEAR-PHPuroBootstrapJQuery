<?php
	class equipo_software
	{
	    private $id_equipo;
	    private $id_software;
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