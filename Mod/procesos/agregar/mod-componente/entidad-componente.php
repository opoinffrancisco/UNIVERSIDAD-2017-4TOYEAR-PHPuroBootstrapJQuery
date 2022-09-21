<?php
	class eq_componente
	{
	    private $id;
	    private $serial;
	    private $serial_bn;
	    private $id_c_fisc_comp;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	