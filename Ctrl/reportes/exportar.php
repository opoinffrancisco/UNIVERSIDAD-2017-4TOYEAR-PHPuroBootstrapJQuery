<?php
	require_once("../../vendor/autoload.php");
	use Dompdf\Dompdf;
	require_once '../../Mod/conexion.php';
  	require_once '../../Mod/configuracion/mod-configuracion/entidad-configuracion.php';
	require_once '../../Mod/configuracion/mod-configuracion/mod-configuracion.php';		
class PDFSIGMANSTEC
	{
		private $cfgcoll;
		private $logo;
		private $nombre_ente;
		private $titulo;
		private $datos;
		private $usuario;
		private $fecha_actual;		
		// Filtros	
		private $cedula;
		private $fecha_desde;
		private $fecha_hasta;
		//
		private $nombre_tarea;	
		//
		private $funcion;
		private $departamento;
		//
		private $marca_e;
		private $modelo_e;
		private $tipo_e;			
		//
		private $cedula_t;
		private $nombre_apellido_t;
		private $correo_electronico_t;		
		//
		private $serial;
		private $serial_bn;
		private $tipo_eq;
		private $marcaymodelo;
		//
		private $cargoYdpto_responsable_asignado;
		private $ci_responsable_asignado;
		private $cargoYdpto_solicitante;
		private $ci_solicitante;
		//
		private $fecha_cierre;
		private $fecha_atencion;
		private $fecha_solicitud;
		private $descripcion;
		private $asunto;
		//
		private $img_grafico_1;
		private $img_grafico_2;
		private $img_grafico_3;		

		public function setDatosCabeceraDCC($funcion, $departamento, $fecha_desde, $fecha_hasta)
		{
			$this->funcion = $funcion;
			$this->departamento	= $departamento;
			$this->fecha_desde = $fecha_desde;
			$this->fecha_hasta = $fecha_hasta;
		}

		public function setDatosCabeceraTC($marca_e, $modelo_e, $tipo_e, $fecha_desde, $fecha_hasta)
		{
			$this->marca_e = $marca_e;
			$this->modelo_e	= $modelo_e;
			$this->tipo_e 	= $tipo_e;
			$this->fecha_desde = $fecha_desde;
			$this->fecha_hasta = $fecha_hasta;
		}
		public function setDatosEquipo($serial, $serial_bn, $tipo, $marcaymodelo)
		{
			$this->serial = $serial;
			$this->serial_bn 		= $serial_bn;
			$this->tipo 	= $tipo;
			$this->marcaymodelo 		= $marcaymodelo;
		}

		//Introducir los datos que vamos a exportar
		public function setDatos($cfgcoll, $nombre_ente, $titulo, $usuario, $datos, $logo, $fecha_actual,
								 $fecha_desde, $fecha_hasta){
			$this->cfgcoll= $cfgcoll;
			$this->nombre_ente = $nombre_ente;
			$this->titulo = $titulo;
			$this->usuario = $usuario;
			$this->datos = $datos;
			$this->logo = $logo;
			$this->fecha_actual = $fecha_actual;
			//
			$this->fecha_desde = $fecha_desde;
			$this->fecha_hasta = $fecha_hasta;
		}
		public function setDatosGraficos($img_grafico_1, $img_grafico_2, $img_grafico_3){
			$this->img_grafico_1 = $img_grafico_1;
			$this->img_grafico_2 = $img_grafico_2;
			$this->img_grafico_3 = $img_grafico_3;
		}
		public function setDatosCabeceraASTecnico($cedula, $nombre_apellido_t, $correo_electronico_t){
			$this->cedula_t 		= $cedula;
			$this->nombre_apellido_t	= $nombre_apellido_t;
			$this->correo_electronico_t 	= $correo_electronico_t;			
		}
		public function setDatosCabeceraMP($serial, $serial_bn, $tipo_eq, $marcaymodelo){
			$this->serial 		= $serial;
			$this->serial_bn 	= $serial_bn;
			$this->tipo_eq 		= $tipo_eq;
			$this->marcaymodelo = $marcaymodelo;
		}
		public function setDatosCabeceraAS( $asunto, $descripcion, $fecha_solicitud,$fecha_atencion,$fecha_cierre,
											$ci_solicitante,$cargoYdpto_solicitante,
											$ci_responsable_asignado,$cargoYdpto_responsable_asignado,
											$serial_e, $serial_bn_e, $tipo_e, $marcaymodelo_e ){

			$this->asunto 		= $asunto;
			$this->descripcion 	= $descripcion;
			$this->fecha_solicitud 		= $fecha_solicitud;
			$this->fecha_atencion 		= $fecha_atencion;
			$this->fecha_cierre 		= $fecha_cierre;
			//
			$this->ci_solicitante = $ci_solicitante;
			$this->cargoYdpto_solicitante 		= $cargoYdpto_solicitante;
			$this->ci_responsable_asignado 	= $ci_responsable_asignado;
			$this->cargoYdpto_responsable_asignado	= $cargoYdpto_responsable_asignado;
			//
			$this->serial_e = $serial_e;
			$this->serial_bn_e 		= $serial_bn_e;
			$this->tipo_e 	= $tipo_e;
			$this->marcaymodelo_e 		= $marcaymodelo_e;
		}		
		public function exportar()
		{	
			include_once("plantillas/rpt-mantenimiento-preventivo.php");
		}
		public function exportarPDF($rpt)
		{

			ob_start();
			$nombre_tipo_rpt="";
			if ($this->datos) {
				switch ($rpt) {
					case 'mant_prev':
							include_once("plantillas/rpt-mantenimiento-preventivo.php");
							$nombre_tipo_rpt="MantenimientoPreventivo";
						break;
					case 'vencimiento_tarea':
							include_once("plantillas/rpt-vencimiento-tarea.php");
							$nombre_tipo_rpt="VencimeintoTarea";
						break;
					case 'tareas-concurrentes':
							include_once("plantillas/rpt-tareas-concurrentes.php");
							$nombre_tipo_rpt="TareasConcurrentes";
						break;
					case 'actds_solt':
							include_once("plantillas/rpt-actividades-solicitud.php");
							$nombre_tipo_rpt="ActividadesSolicitud";
						break;		
					case 'rendi_servc':
							include_once("plantillas/rpt-rendimiento-servicio.php");
							$nombre_tipo_rpt="RendimientoServicio";
						break;			
					case 'areas_concurrentes_tareas_correctivas':
							include_once("plantillas/rpt-areas-concurrentes-tareas-correctivas.php");
							$nombre_tipo_rpt="AreasConcurrentesTareasCorrectivas";
						break;			
					case 'desincorporaciones_cambios_concurrentes':
							include_once("plantillas/rpt-desincorporaciones-concurrentes.php");
							$nombre_tipo_rpt="DesincorporacionesCambiosConcurrentes";
						break;							
					default:
						break;
				}

				$template = ob_get_clean();

				$dompdf = new DOMPDF();
				 
				$dompdf->loadHtml($template);
				 
				$dompdf->setPaper('A4', 'portrait');
				 
				$dompdf->render();
				 
				$dompdf->stream("SIGMANSTEC-".$nombre_tipo_rpt."-".$this->fecha_actual);
				file_put_contents("pdfs/SIGMANSTEC-".$nombre_tipo_rpt."-".$this->fecha_actual.".pdf",  $dompdf->output());
			}else{
				echo "NO HAY DATOS RELACIONADOS PARA SER EXPORTADOS";
			}

		}
		
	}

	?>