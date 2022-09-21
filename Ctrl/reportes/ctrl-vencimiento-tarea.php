<?php

		require_once '../../vendor/autoload.php';
 		require_once '../utilidades/ctrl-encrypt.php';
		//include_once "exportar-reportes-procesos.php";
		include_once "exportar.php";
		require_once '../../Mod/conexion.php';
		include_once "../../Mod/reportes/clases-reportes-procesos.php";
		//
		require_once '../../Mod/configuracion/mod-tarea/entidad-tarea.php';
		require_once '../../Mod/configuracion/mod-tarea/mod-tarea.php';
		require_once '../../Mod/procesos/tarea-programada/mod-tarea-programada/entidad-tarea-programada.php';
		require_once '../../Mod/procesos/tarea-programada/mod-tarea-programada/mod-tarea-programada.php';


		$modTareaProgramada = new modTareaProgramada();
		
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
				case 'CFG-VENCIMEINTO-TAREA':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);
							/*
								$PDFSIGMANSTEC->setDatosCabeceraMP($resultados[0]['SERIAL'],
								$resultados[0]['SERIAL DE BIEN NACIONAL'],
								$resultados[0]['TIPO DE EQUIPO'],
								$resultados[0]['MARCA Y MODELO']);
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar('mant_prev');
							*/
							$configuracion = new configuracion();
							$modConfiguracion = new modConfiguracion();				    
							$PDFSIGMANSTEC = new PDFSIGMANSTEC();

						
							$resultados = $ModReportesProcesos->ListarReporteVencimientoTareas(
								$datos->dato_1,$datos->dato_2,$datos->dato_3,$datos->dato_4
							);
							$resultadosConfiguracion = $modConfiguracion->consultar(99999);
							$PDFSIGMANSTEC->setDatos(
											$cfg,
												$resultadosConfiguracion->nombre, 
												$datos->tt,
												$datos->u,
												$resultados,
												$resultadosConfiguracion->logo, 
												$resultadosConfiguracion->fecha_actual,
												$datos->dato_3,
												$datos->dato_4
											);
							$PDFSIGMANSTEC->exportarPDF('vencimiento_tarea');
							//$PDFSIGMANSTEC->exportar();



						}
					}

				break;							
				case 'FiltrarLista':
					$datos= array();							
					// INICIO CAlCULAR VARIABLES
					if (!isset($_GET['filtro_tarea']) ||
						!isset($_GET['filtro_seria_e']) ||
						!isset($_GET['filtro_desde']) ||
						!isset($_GET['filtro_hasta'])) {

						$datos = array(
											'controlError' => 5,
											'mensaje' => "Error al validar campos ",
											'detalles' => "Campos vacios",												
										);
						break;	
					}
					$filtro_tarea	=	$_GET['filtro_tarea'];
					$filtro_seria_e	=	$_GET['filtro_seria_e'];
					$filtro_desde	=	$_GET['filtro_desde'];
					$filtro_hasta	=	$_GET['filtro_hasta'];
					//
					$tamagno_paginas=$_GET['tamagno_paginas'];
					if ($_GET['pagina']!=1) {							
						$pagina=$_GET['pagina'];
					}else{
						$pagina=1;
					}			
					$empezar_desde=($pagina-1)*$tamagno_paginas;
					$getTotalPaginas=1;
					$num_filas = $modTareaProgramada->getTotalPaginasReporte($filtro_tarea, $filtro_seria_e, $filtro_desde, $filtro_hasta, $getTotalPaginas);
					$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
					// FIN CAlCULAR VARIABLES

					$getTotalPaginas=0;
					$resultados = $modTareaProgramada->ListarReporte($filtro_tarea, $filtro_seria_e, $filtro_desde, $filtro_hasta, $empezar_desde, $tamagno_paginas);
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