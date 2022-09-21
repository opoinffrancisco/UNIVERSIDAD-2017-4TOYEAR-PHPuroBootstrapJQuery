<?php

		require_once '../../Mod/conexion.php';
		include_once "reportes/PDFSIGMANSTEC.php";
		include_once "reportes/exportar_reporte.php";
		require_once '../../vendor/autoload.php';
	  	require_once 'ctrl-encrypt.php';
	  	require_once 'ctrl-ortografia.php';

		/*
			error = 0 : Es EXITO
		*/
		// MalWared

		$ModReportes = new ModReportes();
		$PDFSIGMANSTEC = new PDFSIGMANSTEC();

		$datosR=array();
		$activar=false;
		$plantillaGestionada="";
		//Recordar vaciar datos - ATENTO

		$cfg="";
		if(isset($_POST['cfg']))
		{
			$cfg=$_POST['cfg'];
			//Se declara que esta es una aplicacion que genera un JSON
			//header('Content-type: application/json');//Cuandose use JSON
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			//header("Access-Control-Allow-Origin: *");	

		}
		if(isset($_GET['cfg']))
		{
			$cfg=$_GET['cfg'];
		}


		//$accionNucleo="generarReporte";
		if(isset($cfg))
		{
			switch($cfg)
			{					
				case 'CFG-2COLL':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$resultados = $ModReportes->consulta2Coll($datos->tabla,$datos->dato_1,$datos->campo_1);
							$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
							$PDFSIGMANSTEC->exportar();
						
						}
					}


					
					break;	
/*				case 'CFG-2COLL':

					$tabla=$_GET['t'];
					//$resultados = $ModReportes->consulta2Coll($tabla);
					$resultados = $ModReportes->consulta2Coll($tabla);

					if ($resultados!=0) {
						//$plantillaGestionada = $ModReportes->plantilla2Coll($resultados);
						$PDFSIGMANSTEC->setDatos($cfg,$_GET['m'],$_GET['u'],$resultados);
						$PDFSIGMANSTEC->exportar();
						$activar=true;
					}else{
						//$plantillaGestionada = $ModReportes->plantillaNoDato($_GET['modulo']);
						$activar=true;
					}
						
					break;						
*//*				case 'CFG-3COLL':

					$tabla=$_GET['t'];
					//$resultados = $ModReportes->consulta2Coll($tabla);
					$resultados = $ModReportes->consulta3Coll($tabla,$_GET['coll1'],$_GET['coll2']);

					if ($resultados!=0) {
						//$plantillaGestionada = $ModReportes->plantilla2Coll($resultados);
						$PDFSIGMANSTEC->set3Coll($_GET['coll1'],$_GET['coll2']);
						$PDFSIGMANSTEC->setDatos($cfg,$_GET['m'],$_GET['u'],$resultados);
						$PDFSIGMANSTEC->exportar();
						$activar=true;
					}else{
						//$plantillaGestionada = $ModReportes->plantillaNoDato($_GET['modulo']);
						$activar=true;
					}


					break;
*/
				case 'CFG-3COLL':
					if (isset($_GET['datos'])) {
							$datosEncriptados = $_GET['datos'];
							if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
								$datos = blickyerSIGMANSTEC::get($datosEncriptados);

								$resultados = $ModReportes->consulta3Coll($datos->tabla,$datos->campo_1,$datos->campo_2,
																			$datos->dato_1);
								$PDFSIGMANSTEC->set3Coll(utf8_decode($datos->campo_1), $datos->campo_2) ;
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar();
							}
						}
					break;


				case 'CFG-3COLL-C-EQUIPOS':

						if (isset($_GET['datos'])) {
							$datosEncriptados = $_GET['datos'];
							if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
								$datos = blickyerSIGMANSTEC::get($datosEncriptados);

								$resultados = $ModReportes->ListarRptCEquipos($datos->dato_1,$datos->dato_2);
								print_r($resultados);

								$PDFSIGMANSTEC->set3Coll('TIPO','MARCA Y MODELO');
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar();
							}
						}
					break;					
				case 'CFG-3COLL-C-PERIFERICOS':

						if (isset($_GET['datos'])) {
							$datosEncriptados = $_GET['datos'];
							if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
								$datos = blickyerSIGMANSTEC::get($datosEncriptados);

								$resultados = $ModReportes->ListarRptCPerifericos($datos->dato_1,$datos->dato_2);
								print_r($resultados);

								$PDFSIGMANSTEC->set3Coll('TIPO','MARCA Y MODELO');
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar();
							}
						}
					break;					
				case 'CFG-3COLL-C-COMPONENTES':

						if (isset($_GET['datos'])) {
							$datosEncriptados = $_GET['datos'];
							if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
								$datos = blickyerSIGMANSTEC::get($datosEncriptados);

								$resultados = $ModReportes->ListarRptCComponentes($datos->dato_1,$datos->dato_2);
								print_r($resultados);

								$PDFSIGMANSTEC->set3Coll('TIPO','MARCA Y MODELO');
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar();
							}
						}
					break;					
				case 'CFG-3COLL-SOFTWARE':

						if (isset($_GET['datos'])) {
							$datosEncriptados = $_GET['datos'];
							if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
								$datos = blickyerSIGMANSTEC::get($datosEncriptados);

								$resultados = $ModReportes->ListarRptSoftware($datos->dato_1,$datos->dato_2);
								print_r($resultados);

								$PDFSIGMANSTEC->set3Coll('SOFTWARE','TIPO');
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar();
							}
						}
					break;																				
				case 'CFG-3COLL-1REL':

						if (isset($_GET['datos'])) {
							$datosEncriptados = $_GET['datos'];
							if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
								$datos = blickyerSIGMANSTEC::get($datosEncriptados);

								$resultados = $ModReportes->consulta3Coll1Rel($datos->tabla,$datos->trel,$datos->rel1,
																				$datos->campo_1,$datos->campo_2,$datos->dato_1);

								$PDFSIGMANSTEC->set3Coll($datos->campo_1,$datos->campo_2);
								$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
								$PDFSIGMANSTEC->exportar();
							}
						}	
					
					break;					
/*				case 'CFG-3COLL-1REL':

					$tabla=		$_GET['t'];
					$tablarel=	$_GET['trel'];
					$rel1=		$_GET['rel1'];
					$coll1=		$_GET['coll1'];
					$coll2=		$_GET['coll2'];

					//$resultados = $ModReportes->consulta2Coll($tabla);
					$resultados = $ModReportes->consulta3Coll1Rel($tabla,$tablarel,$rel1,$coll1,$coll2);

					if ($resultados!=0) {
						$PDFSIGMANSTEC->set3Coll($coll1,$coll2);
						$PDFSIGMANSTEC->setDatos($cfg,$_GET['m'],$_GET['u'],$resultados);
						$PDFSIGMANSTEC->exportar();
						$activar=true;
					}else{
						//$plantillaGestionada = $ModReportes->plantillaNoDato($_GET['modulo']);
						$activar=true;
					}

					break;					
*/				case 'CFG-4COLL':
					break;												
				case 'CFG-5COLL':			
					break;
				case 'CFG-2COLL-CARGOS':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$resultados = $ModReportes->consultaCargos('RESPONSABLE DE DPT.',$datos->dato_1);
							print_r($resultados);
							$PDFSIGMANSTEC->set3Coll('NOMBRE','RESPONSABLE DE DPT.');
							$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
							//
							$PDFSIGMANSTEC->exportar();
						}
					}
					break;						
				case 'CFG-5COLL-M-PERSONAS':

					if (isset($_GET['datos'])) {
						$datosEncriptados = $_GET['datos'];
						if (blickyerSIGMANSTEC::Check($datosEncriptados)) {
							$datos = blickyerSIGMANSTEC::get($datosEncriptados);

							$resultados = $ModReportes->consulta5CollMpersonas('CEDULA','NOMBRE Y APELLIDO','USUARIO','PERFIL',$datos->dato_1);
							print_r($resultados);
							$PDFSIGMANSTEC->set5Coll('CEDULA','NOMBRE Y APELLIDO', 'USUARIO', 'PERFIL');
							$PDFSIGMANSTEC->setDatos($cfg,$datos->tt,$datos->u,$resultados);
							//
							$PDFSIGMANSTEC->exportar();
						}
					}
					break;			
				default:
									echo "Sin configurar lo que se exportara";

					break;
			}
			// activar Generar
			if ($activar==true) {
				//header('Content-type: application/pdf');
				//$ModReportes->generar($plantillaGestionada,$_GET['modulo']);
			}
		}


?>