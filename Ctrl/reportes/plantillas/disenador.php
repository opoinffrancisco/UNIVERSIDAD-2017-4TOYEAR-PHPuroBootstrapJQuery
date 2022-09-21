<?php
	require_once("../../../vendor/autoload.php");
	use Dompdf\Dompdf;
	require_once '../../../Mod/conexion.php';
  	require_once '../../../Mod/configuracion/mod-configuracion/entidad-configuracion.php';
	require_once '../../../Mod/configuracion/mod-configuracion/mod-configuracion.php';		
class PDFSIGMANSTEC
	{
		private $cfgcoll;
		private $logo;
		private $nombre_ente;
		private $titulo;
		private $datos;
		private $usuario;
		private $fecha_actual;		
		//
		private $serial;
		private $serial_bn;
		private $tipo_eq;
		private $marcaymodelo;

		//Introducir los datos que vamos a exportar
		public function setDatos($cfgcoll, $nombre_ente, $titulo, $usuario, $datos, $logo, $fecha_actual){
			$this->cfgcoll= $cfgcoll;
			$this->nombre_ente = $nombre_ente;
			$this->titulo = $titulo;
			$this->usuario = $usuario;
			$this->datos = $datos;
			$this->logo = $logo;
			$this->fecha_actual = $fecha_actual;
		}
		public function setDatosCabeceraMP($serial, $serial_bn, $tipo_eq, $marcaymodelo){
			$this->serial 		= $serial;
			$this->serial_bn 	= $serial_bn;
			$this->tipo_eq 		= $tipo_eq;
			$this->marcaymodelo = $marcaymodelo;
		}
		public function exportar()
		{	
			include_once("rpt-mantenimiento-preventivo.php");
		}
		public function exportarPDF()
		{
			ob_start();

			include_once("rpt-mantenimiento-preventivo.php");

			$template = ob_get_clean();

			$dompdf = new DOMPDF();
			 
			$dompdf->loadHtml($template);
			 
			$dompdf->setPaper('A4', 'portrait');
			 
			$dompdf->render();
			 
			$dompdf->stream("invoice");
			file_put_contents("pdfs/invoice-" . mt_rand(0,99999) . ".pdf",  $dompdf->output());
		}

	}

	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);			

	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);

	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);

	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);

	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);
	$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);				$datos[] = Array( 
	 				'RESPONSABLE' => '22316424',
	 				'TAREA' => 'APLICAR LIMPIADOR DE CONTACTO',
	 				'INICIO' => '2017-09-16 15:44:49',
	 				'FINALIZO' => '2017-09-19 15:44:56',
	 				'DURACCION' => '72 Horas',
	 				'TIEMPO ESTIMADO' => '54 Horas',
	 				'TARDANZA' => '18 horas',
	 				'OBSERVACION' => 'ddddddddddddddddddddddddddddddddddddddddddddd'
			);






	$configuracion = new configuracion();
	$modConfiguracion = new modConfiguracion();				    
	$PDFSIGMANSTEC = new PDFSIGMANSTEC();

 	$resultados = $modConfiguracion->consultar(99999);
 	$imgLogoInstitucion = $resultados->logo;

	$PDFSIGMANSTEC->setDatosCabeceraMP('sssssss','dddddddd','ddddddd','dsdsds');
	$PDFSIGMANSTEC->setDatos('ddd', $resultados->nombre, 'TITULO DEL REPORTE','dsfsfs',$datos,$imgLogoInstitucion);
	$PDFSIGMANSTEC->exportarPDF();
	//$PDFSIGMANSTEC->exportar();

?>