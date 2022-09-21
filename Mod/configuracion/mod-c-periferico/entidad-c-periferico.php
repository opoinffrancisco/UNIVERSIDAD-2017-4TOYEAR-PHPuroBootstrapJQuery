<?php
	class caracteristicasPerifericos
	{
	    private $id;
	    private $id_tipo_fisc;
	    private $id_modelo_fisc;
	    private $id_interfaz_fisc;
	    private $estado;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	