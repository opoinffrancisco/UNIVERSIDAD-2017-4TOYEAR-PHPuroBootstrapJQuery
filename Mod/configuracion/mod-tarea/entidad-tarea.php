<?php
	class tarea
	{
	    private $id;
	    private $nombre;
	    private $descripcion;
	    private $tarea_correctiva;
	    private $estado;
// tabla puente tarea herramienta
// tabla puente tarea consumible	    
	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	