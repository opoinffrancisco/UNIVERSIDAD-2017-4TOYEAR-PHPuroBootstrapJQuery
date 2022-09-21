<?php
	class departamentoCargo
	{
	    private $id_cargo;
	    private $id_departamento;
	    private $estado;
    
	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	