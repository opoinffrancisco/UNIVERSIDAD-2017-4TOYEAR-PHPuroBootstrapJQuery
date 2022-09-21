<?php
	class  solt_respuesta 
	{
	    private $id;
	    private $observacion;
	    private $id_solt;
	    private $fecha;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	