<?php
	class equipo_periferico
	{
	    private $id_equipo;
	    private $id_periferico;
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