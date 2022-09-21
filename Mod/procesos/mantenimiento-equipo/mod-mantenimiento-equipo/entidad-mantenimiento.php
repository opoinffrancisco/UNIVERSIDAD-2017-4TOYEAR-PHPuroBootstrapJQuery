<?php
	class mantenimiento		
	{
		private $id;
	    private $observacion;
	    private $fecha_i;
	    private $fecha_f;
	    private $estado;
	    private $id_tipo_mant;
	    private $id_tarea_equipo;
	    private $id_solicitud;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	