<?php
	class ajuste_sistema
	{
	    private $id;
	    private $frecuencia_suspension;
	    private $dias_proximidad_tarea;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	