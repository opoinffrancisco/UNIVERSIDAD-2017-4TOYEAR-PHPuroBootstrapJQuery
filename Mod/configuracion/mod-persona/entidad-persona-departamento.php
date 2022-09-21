<?php
	class personaDepartamento
	{
	    private $id_persona;
	    private $id_departamento;
	    private $id_cargo;
	    private $responsable_equipo;	    
	    private $estado;	 

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	