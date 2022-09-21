<?php
	class eq_periferico
	{
	    private $id;
	    private $serial;
	    private $serial_bn;
	    private $id_c_fisc_perif;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	