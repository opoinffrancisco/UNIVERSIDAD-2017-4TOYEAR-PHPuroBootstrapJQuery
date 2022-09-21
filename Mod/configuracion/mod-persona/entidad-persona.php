<?php
	class persona
	{
	    private $id;
	    private $cedula;
	    private $nombre;
	    private $apellido;
	    private $correo_electronico;
	    //private $telefono;	    	    
	    private $formato_foto;
	    private $foto;	  
	    private $estado;
	    private $id_usuario;
	    //private $id_departamento;



	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	