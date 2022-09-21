<?php
	class equipo_componente
	{
	    private $id_equipo;
	    private $id_componente;
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