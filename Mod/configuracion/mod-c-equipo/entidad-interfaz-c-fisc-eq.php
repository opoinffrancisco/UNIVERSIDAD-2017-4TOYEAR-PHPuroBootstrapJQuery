<?php
	class interfazCaracteristicasEquipos
	{
	    private $id_interfaz;
	    private $id_c_fisc_eq;
	    private $estado;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	