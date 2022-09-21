<?php
	class usuario
	{
	    private $id;
	    private $usuario;
	    private $contrasena;
	    private $estado;
	    private $id_perfil;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	