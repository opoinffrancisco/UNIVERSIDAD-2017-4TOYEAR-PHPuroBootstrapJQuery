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
				case 'CFG-ACTIVIDADES-SOLICITUD':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$configuracion = new configuracion();
							$modConfiguracion = new modConfiguracion();				    
							$PDFSIGMANSTEC = new PDFSIGMANSTEC();


							$resultadosCabecera = $ModReportesProcesos->datosGeneralesRptActividadesSolicitud($datos->dato_1);

						//	die(print_r($resultadosCabecera));

							$resultados = $ModReportesProcesos->ListarRptActividadesSolicitud($datos->dato_1);

							$resultadosConfiguracion = $modConfiguracion->consultar(99999);

						 //Datos de la solicitud
							$PDFSIGMANSTEC->setDatosCabeceraAS(
													$resultadosCabecera[0]['ASUNTO'],
													$resultadosCabecera[0]['DESCRIPCION'],
													$resultadosCabecera[0]['FECHA'],
													$resultadosCabecera[0]['FECHA_ATENCION'],
													$resultadosCabecera[0]['FECHA_CIERRE'],
													$resultadosCabecera[0]['CI_SOLICITANTE'],
													$resultadosCabecera[0]['CARGOYDPTO_SOLICITANTE'],
													$resultadosCabecera[0]['CI_RESPONSABLE_ASIGNADO'],
													$resultadosCabecera[0]['CARGOYDPTO_RESPONSABLE_ASIGNADO'],
													$resultadosCabecera[0]['SERIAL_E'],
													$resultadosCabecera[0]['SERIAL_BN_E'],
													$resultadosCabecera[0]['TIPO_E'],
													$resultadosCabecera[0]['MARCAYMODELO_E']
										);

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
							$PDFSIGMANSTEC->exportarPDF('actds_solt');
							//$PDFSIGMANSTEC->exportar();



						}
					}

				break;							
					case 'FiltrarLista':
						$datos= array();							
						// INICIO CAlCULAR VARIABLES
						if (!isset($_GET['id_persona']) ||
							!isset($_GET['filtro']) ||
							!isset($_GET['buscardordesde']) ||
							!isset($_GET['buscardorhasta'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$id_persona	=	$_GET['id_persona'];
						$filtro	=	$_GET['filtro'];
						$buscardordesde	=	$_GET['buscardordesde'];
						$buscardorhasta	=	$_GET['buscardorhasta'];
						//
						$tamagno_paginas=$_GET['tamagno_paginas'];
						if ($_GET['pagina']!=1) {							
							$pagina=$_GET['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modMantenimiento->getTotalPaginasReporte($id_persona, $filtro, $buscardordesde, $buscardorhasta, $getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modMantenimiento->ListarReporte($id_persona, $filtro, $buscardordesde, $buscardorhasta, $empezar_desde, $tamagno_paginas);
						$pagAnterior=$pagina - 1;
						$pagSiguiente = $pagina +1;
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
										'pagAnterior' => $pagAnterior,
										'pagSiguiente' => $pagSiguiente,
										'pagActual' => $pagina,
										'total_paginas' => $total_paginas,
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