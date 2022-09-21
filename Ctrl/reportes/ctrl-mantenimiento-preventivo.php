<?php

		require_once '../../vendor/autoload.php';
	 	require_once '../utilidades/ctrl-encrypt.php';
		//include_once "exportar-reportes-procesos.php";
		include_once "exportar.php";
		require_once '../../Mod/conexion.php';
		include_once "../../Mod/reportes/clases-reportes-procesos.php";


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
				case 'CFG-MANTENIMIENTO-PREVENTIVO':

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


							$resultados = $ModReportesProcesos->ListarRptMantenimientoPreventivo($datos->dato_1,$datos->dato_2,$datos->dato_3);
						 $resultadosConfiguracion = $modConfiguracion->consultar(99999);

						 //datos actuales del equipo
							$PDFSIGMANSTEC->setDatosCabeceraMP($resultados[0]['SERIAL'],
														$resultados[0]['SERIAL DE BIEN NACIONAL'],
														$resultados[0]['TIPO DE EQUIPO'],
														$resultados[0]['MARCA Y MODELO']);
							$PDFSIGMANSTEC->setDatos(
											$cfg,
												$resultadosConfiguracion->nombre, 
												$datos->tt,
												$datos->u,
												$resultados,
												$resultadosConfiguracion->logo, 
												$resultadosConfiguracion->fecha_actual,
												$datos->dato_2,
												$datos->dato_3
											);
							$PDFSIGMANSTEC->exportarPDF('mant_prev');
							//$PDFSIGMANSTEC->exportar();



						}
					}

				break;							
				default:
					echo "Sin configurar lo que se exportara";
				break;
			}
		}


?>