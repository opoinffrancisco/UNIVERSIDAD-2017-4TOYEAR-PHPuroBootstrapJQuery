<?php
		require_once '../../vendor/autoload.php';
 		require_once '../utilidades/ctrl-encrypt.php';
		//include_once "exportar-reportes-procesos.php";
		include_once "exportar.php";
		require_once '../../Mod/conexion.php';
		include_once "../../Mod/reportes/clases-reportes-procesos.php";
		//
		require_once '../../Mod/procesos/tarea-programada/mod-tarea-programada/entidad-tarea-programada.php';
		require_once '../../Mod/procesos/tarea-programada/mod-tarea-programada/mod-tarea-programada.php';
		//----------------
	 	require_once '../../Ctrl/utilidades/ctrl-fechas.php'; 	
	 	require_once '../../Mod/utilidades/mod-bitacora.php';
		//
		$tarea_equipo = new tarea_equipo();
		$modTareaProgramada = new modTareaProgramada();
		//

		$ModReportesProcesos = new ModReportesProcesos();
		$PDFSIGMANSTEC = new PDFSIGMANSTEC();

		$cfg="";
		if(isset($_GET['cfg']))
		{
			$cfg=$_GET['cfg'];
		}
		if(isset($cfg))
		{
			switch($cfg)
			{					
				case 'CFG-TAREAS-CONCURRENTES':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$configuracion = new configuracion();
							$modConfiguracion = new modConfiguracion();				    
							$PDFSIGMANSTEC = new PDFSIGMANSTEC();

							$marca_e 		= (empty($datos->dato_1))?"":$datos->dato_1;
							$modelo_e 		= (empty($datos->dato_2))?"":$datos->dato_2;
							$tipo_e			= (empty($datos->dato_3))?"":$datos->dato_3;
							$fecha_desde 	= (empty($datos->dato_4))?"":$datos->dato_4;
							$fecha_hasta 	= (empty($datos->dato_5))?"":$datos->dato_5;
							$opcionrpt	 	= (empty($datos->dato_6))?"":$datos->dato_6;					
							$_SESSION['opcionrpt'] = $opcionrpt;

							$resultadosDatosFiltros = $ModReportesProcesos->datosTareasConcurrentes(
																				$marca_e,
																				$modelo_e,
																				$tipo_e
																		);
							$resultados = $ModReportesProcesos->ListarReporteAreasConcurrentesTareasCorrectivas(
																				$marca_e,
																				$modelo_e,
																				$tipo_e,
																				$fecha_desde,
																				$fecha_hasta,
																				$opcionrpt
																		);
							$resultadosConfiguracion = $modConfiguracion->consultar(99999);
							//
						 	//Datos de filtros

							$PDFSIGMANSTEC->setDatosCabeceraTC(
											$resultadosDatosFiltros[0]['NOMBRE_MARCA'],
											$resultadosDatosFiltros[0]['NOMBRE_MODELO'],
											$resultadosDatosFiltros[0]['NOMBRE_TIPO'],
											$fecha_desde,
											$fecha_hasta
								);
							$PDFSIGMANSTEC->setDatos(
												$cfg,
												$resultadosConfiguracion->nombre, 
												$datos->tt,
												$datos->u,
												$resultados,
												$resultadosConfiguracion->logo, 
												$resultadosConfiguracion->fecha_actual,
												$fecha_desde,
												$fecha_hasta
											);
							//---
							$img_grafico_1 = $_SESSION[$datos->img_grafico_id_temp];
							
							$PDFSIGMANSTEC->setDatosGraficos(
												$img_grafico_1,
												'',
												''
											);

							$PDFSIGMANSTEC->exportarPDF('areas_concurrentes_tareas_correctivas');
							//$PDFSIGMANSTEC->exportar();



						}
					}

				break;							
				case 'cargarListaDespegable':

						$resultados = $modTareaProgramada->cargarListaDespegableTipo();

						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];

						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar : ",
												'detalles' => "No Hay datos ",												
											);										
						}
						//Se declara que esta es una aplicacion que genera un JSON
						header('Content-type: application/json');//Cuandose use JSON
						//Se abre el acceso a las conexiones que requieran de esta aplicacion
						header("Access-Control-Allow-Origin: *");	

						echo '' . json_encode($datos) . '';							
				break;	
					case 'FiltrarLista':
						$datos= array();							
						// INICIO CAlCULAR VARIABLES
						if (!isset($_GET['filtro_marca']) ||
							!isset($_GET['filtro_modelo']) ||
							!isset($_GET['filtro_tipo']) ||
							!isset($_GET['buscardordesde']) ||
							!isset($_GET['buscardorhasta'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$filtro_marca	=	$_GET['filtro_marca'];
						$filtro_modelo	=	$_GET['filtro_modelo'];		
						$filtro_tipo	=	$_GET['filtro_tipo'];		
						$buscardordesde	=	$_GET['buscardordesde'];
						$buscardorhasta	=	$_GET['buscardorhasta'];

						// -> Control
						$opcionrpt 		=   $_GET['opcionrpt'];
						//

 						$resultados = $modTareaProgramada->ListarReporteAreasConcurrentesTareasCorrectivas($filtro_marca, $filtro_modelo, $filtro_tipo, $buscardordesde, $buscardorhasta, $opcionrpt);
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la id: ",
												'detalles' => "No hay solicitud de mantenimiento realizada",												
											);										
						}
						//Se declara que esta es una aplicacion que genera un JSON
						header('Content-type: application/json');//Cuandose use JSON
						//Se abre el acceso a las conexiones que requieran de esta aplicacion
						header("Access-Control-Allow-Origin: *");	


						echo '' . json_encode($datos) . '';	
					break;			
				default:
					echo "Sin configurar lo que se exportara";
				break;
			}
		}


?>