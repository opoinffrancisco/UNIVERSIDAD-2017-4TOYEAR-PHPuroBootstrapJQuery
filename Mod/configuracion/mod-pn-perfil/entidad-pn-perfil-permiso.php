<?php
	class perfil_Permiso
	{
	    private $id;
	    private $id_perfil;
	    private $id_modulo;
	    private $permiso_acceso;

		private $func_nuevo;
		private $func_editar;	
		private $func_eliminacion_logica;
		private $func_generar_reporte;
		private $func_generar_reporte_filtrado;
		private $func_permisos_perfil;
		private $func_busqueda_avanzada;		
		private $func_detalles;
		private $func_atender;
		private $func_asignar;
		private $func_programar_tarea;
		private $func_iniciar_finalizar_tarea;	
		private $func_diagnosticar;
		private $func_gestion_equipo_mantenimiento;
		private $func_respuesta_solicitud;
		private $func_finalizar_solicitud;	    
		//--
		private $func_desincorporar_equipo;
		private $func_desincorporar_periferico;
		private $func_desincorporar_componente;
		private $func_cambiar_periferico;
		private $func_cambiar_componente;
		private $func_cambiar_software;
		private $func_inconformidad_atendida;

	    public function __GET($campo){ 
	    	return $this->$campo; 
	    }
	    public function __SET($campo, $valor){ 
	    	return $this->$campo = $valor; 
	    }
	}
?>	