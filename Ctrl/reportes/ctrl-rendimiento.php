<?php
		require_once '../../vendor/autoload.php';
 	require_once '../utilidades/ctrl-encrypt.php';
		//include_once "exportar-reportes-procesos.php";
		include_once "exportar.php";
		require_once '../../Mod/conexion.php';
		include_once "../../Mod/reportes/clases-reportes-procesos.php";
		//
		require_once '../../Mod/procesos/mantenimiento-equipo/mod-mantenimiento-equipo/entidad-mantenimiento.php';
		require_once '../../Mod/procesos/mantenimiento-equipo/mod-mantenimiento-equipo/mod-mantenimiento.php';
		//----------------
	 	require_once '../../Ctrl/utilidades/ctrl-fechas.php'; 	
	 	require_once '../../Mod/utilidades/mod-bitacora.php';
		//
		$mantenimiento = new mantenimiento();
		$modMantenimiento = new modMantenimiento();
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
				case 'CFG-RENDIMIENTO-SERVICIOS':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$configuracion = new configuracion();
							$modConfiguracion = new modConfiguracion();				    
							$PDFSIGMANSTEC = new PDFSIGMANSTEC();


							$resultadosDatosTecnico = $ModReportesProcesos->datosTecnicoRendimientoServicios($datos->dato_1);
							$resultados = $ModReportesProcesos->ListarRptRendimientoServicios(
																				$datos->dato_1,
																				$datos->dato_2,
																				$datos->dato_3
																		);

							$resultadosConfiguracion = $modConfiguracion->consultar(99999);

						 //Datos del TEcnico
							if (empty($datos->dato_1)) {
									$PDFSIGMANSTEC->setDatosCabeceraASTecnico(
													"",
													"",
													""
										);
							} else {
									$PDFSIGMANSTEC->setDatosCabeceraASTecnico(
													$resultadosDatosTecnico[0]['CEDULA'],
													$resultadosDatosTecnico[0]['NOMBREYAPELLIDO'],
													$resultadosDatosTecnico[0]['CORREOELECTRONICO']
										);
							}
							

							//
							$PDFSIGMANSTEC->setDatos(
											$cfg,
												$resultadosConfiguracion->nombre, 
												$datos->tt,
												$datos->u,
												$resultados,
												$resultadosConfiguracion->logo, 
												$resultadosConfiguracion->fecha_actual,
												'',
												''
											);
							//---
							$img_grafico_1 = $_SESSION[$datos->img_grafico_id_temp];

							
							$PDFSIGMANSTEC->setDatosGraficos(
												$img_grafico_1,
												'',
												''
											);
							$PDFSIGMANSTEC->exportarPDF('rendi_servc');
							//$PDFSIGMANSTEC->exportar();



						}
					}

				break;							
					case 'FiltrarLista':
						$datos= array();							
						// INICIO CAlCULAR VARIABLES
						if (!isset($_GET['filtro']) ||
							!isset($_GET['buscardordesde']) ||
							!isset($_GET['buscardorhasta'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$filtro	=	$_GET['filtro'];
						$buscardordesde	=	$_GET['buscardordesde'];
						$buscardorhasta	=	$_GET['buscardorhasta'];

						$resultados = $modMantenimiento->ListarReporteRendimiento($filtro, $buscardordesde, $buscardorhasta);
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