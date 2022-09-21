<?php
	class modelo
	{
	    private $id;
	    private $nombre;
	    private $estado;
	    private $id_marca;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	