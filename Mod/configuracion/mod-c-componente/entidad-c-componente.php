<?php
	class caracteristicasComponentes
	{
	    private $id;
	    private $id_tipo_fisc;
	    private $id_modelo_fisc;
	    private $id_umcapacidad_fisc;
	    private $capacidad;
	    private $estado;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	