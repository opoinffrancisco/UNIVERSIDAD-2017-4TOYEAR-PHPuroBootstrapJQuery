<?php
	class configuracion
	{
	    private $id;
	    private $nombre;
	    private $logo;
	    private $formato_logo;
	    private $fecha_actual;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	