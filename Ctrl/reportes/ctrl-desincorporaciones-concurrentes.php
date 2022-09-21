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
				case 'CFG-DESINCORPORACIONES-CONCURRENTES':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$configuracion = new configuracion();
							$modConfiguracion = new modConfiguracion();				    
							$PDFSIGMANSTEC = new PDFSIGMANSTEC();

							$filtro_funcion		   = (empty($datos->dato_1))?"":$datos->dato_1;
							$filtro_departamento   = (empty($datos->dato_2))?"":$datos->dato_2;
							$fecha_desde 		   = (empty($datos->dato_3))?"":$datos->dato_3;
							$fecha_hasta 		   = (empty($datos->dato_4))?"":$datos->dato_4;
							$opcionrpt	 		   = (empty($datos->dato_5))?"":$datos->dato_5;					
							$_SESSION['opcionrpt'] = $opcionrpt;

							$resultadosDatosFiltros = $ModReportesProcesos->datosDesincorporacionesConcurrentes(
																				$filtro_funcion,
																				$filtro_departamento
																		);
							$resultados = $ModReportesProcesos->ListarReporteDesincorporacionesConcurrentes(
																				$filtro_funcion,
																				$filtro_departamento,
																				$fecha_desde,
																				$fecha_hasta,
																				$opcionrpt
																		);
							$resultadosConfiguracion = $modConfiguracion->consultar(99999);
							//
						 	//Datos de filtros

							$PDFSIGMANSTEC->setDatosCabeceraDCC(
											$resultadosDatosFiltros[0]['NOMBRE_FUNCION'],
											$resultadosDatosFiltros[0]['NOMBRE_DEPARTAMENTO'],
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
							$_SESSION[$datos->img_grafico_id_temp]="";

							$PDFSIGMANSTEC->exportarPDF('desincorporaciones_cambios_concurrentes');
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
						if (!isset($_GET['filtro_funcion']) ||
							!isset($_GET['filtro_departamento']) ||
							!isset($_GET['buscardordesde']) ||
							!isset($_GET['buscardorhasta'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$filtro_funcion			=	$_GET['filtro_funcion'];
						$filtro_departamento	=	$_GET['filtro_departamento'];		
						$buscardordesde			=	$_GET['buscardordesde'];
						$buscardorhasta			=	$_GET['buscardorhasta'];

						// -> Control
						$opcionrpt				=	$_GET['opcionrpt'];
						//
						$resultados  = "";

 						$resultados = $modTareaProgramada->ListarReporteDesincorporacionesConcurrentes(
 															$filtro_funcion, 
 															$filtro_departamento,
 															$buscardordesde, 
 															$buscardorhasta, 
 															$opcionrpt
 														);
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