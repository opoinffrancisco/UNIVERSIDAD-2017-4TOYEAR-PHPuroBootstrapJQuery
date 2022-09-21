<?php
	class nucleo
	{
	    private $variable1;
	    private $variable2;
	    private $variable3;	    
	    private $variable4;
	    private $variable5;
	    private $variable6;
	    private $variable7;	    
	    private $variable8;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	