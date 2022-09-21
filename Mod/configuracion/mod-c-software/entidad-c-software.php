<?php
	class software
	{
	    private $id;
	    private $nombre;
	    private $version;
	    private $id_c_logc_tipo;
	    private $id_c_logc_distribucion;
	    private $estado;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	