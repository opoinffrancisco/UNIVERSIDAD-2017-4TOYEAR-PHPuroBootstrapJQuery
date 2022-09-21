<?php
	class tarea_equipo
	{
		private $estado_uso;
	    private $id_tarea;
	    private $id_equipo;
	    private $tiempo_estimado;
	    private $frecuencia;
	    private $ultima_fecha;
	    private $proxima_fecha;
	    private $id;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>						