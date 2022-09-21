<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../../Mod/conexion.php';

	  	require_once '../../../Mod/procesos/agregar/mod-periferico/entidad-periferico.php';

		require_once '../../../Mod/procesos/agregar/mod-periferico/mod-periferico.php';

	  	require_once '../../../Mod/utilidades/mod-bitacora.php';

		/*

			error = 0 : Es EXITO
			error = 1 : error al guardar
			error = 2 : error al consultar						
			error = 3 : error al editar						
			error = 4 : error al cambiar Estado						
			error = 5 : error al listar						

		*/
		//Se declara que esta es una aplicacion que genera un JSON
		header('Content-type: application/json');//Cuandose use JSON
		//Se abre el acceso a las conexiones que requieran de esta aplicacion
		header("Access-Control-Allow-Origin: *");	

		$datos= array();

		$eq_periferico = new eq_periferico();
		$modEqPeriferico = new modEqPeriferico();	
		//Recordar vaciar datos
		if(isset($_POST['accion']))
		{
			$accion=$_POST['accion'];
		}
	
			if(isset($accion))
			{
				switch($accion)
				{
					case 'guardar':

							$seriales = json_decode($_POST['seriales']);
							$seriales_bn = json_decode($_POST['seriales_bn']);

							$contando=0;	
							$idsRegistrados=[];											
							if($seriales>0){ 
								foreach ($seriales as $serial => $serialVal) {
									$eq_periferico = new eq_periferico(); 			
									$eq_periferico->__SET('serial', $serialVal);
									$eq_periferico->__SET('serial_bn', $seriales_bn[$contando]);
									$eq_periferico->__SET('id_c_fisc_perif', $_POST['id_caracteristicas']);
									$idsRegistrados[]=$modEqPeriferico->guardar($eq_periferico);
									$contando=$contando+1;							
								}		
							}

							$error=0;
							foreach ($idsRegistrados as $idsRegistrados => $value) {
								
								if ($value==0) {
									$error= $error +1;
								}

							}

							if ($error==0) {
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Perifericos Guardados correctamente ",		
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar un Periferico",					
												);
							}

						break;

					case 'cambiarEstado':
					/*
						0 = Deshabilitado / Desabilitar
						1 = Habilitado / Habilitar
					*/
						$estado=$_POST['estado'];

						$mensajeEstado="";
						$mensajeEstado2="";
						if ($estado===0) {
							$mensajeEstado="Deshabilitados";
							$mensajeEstado2="Deshabilitar";
						} else {
							$mensajeEstado="Habilitados";
							$mensajeEstado2="Habilitar";
						}
						$eq_periferico->__SET('id',          $_POST['id']);
						$eq_periferico->__SET('estado',       $estado);						
						$resultadoDepartamentoEstado = $modEqPeriferico->cambiarEstado($eq_periferico);
						if ($resultadoDepartamentoEstado===1) {
							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Periferico ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el periferico",
												'detalles' => $resultadoDepartamentoEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modEqPeriferico->consultar($id);
						if ($resultados!="") {
							$datos[] = array(
																								'controlError' => 0,
																								'resultado' => $resultados,
																								);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay periferico registrado con la id: ".$id,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id,
													'detalles' => $resultados,												
												);							
							}

						break;
					case 'consultarCaractPerif':

						$id=$_POST['id'];						
						$resultados = $modEqPeriferico->consultarCaractPerif($id);
						if ($resultados!="") {
							$datos[] = array(
																								'controlError' => 0,
																								'resultado' => $resultados,
																								);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay periferico registrado con la id: ".$id,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id,
													'detalles' => $resultados,												
												);							
							}

						break;						
					case 'FiltrarLista':
						
// INICIO CAlCULAR VARIABLES
						$filtro=(isset($_POST['filtro']))? $_POST['filtro'] : "" ;
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modEqPeriferico->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modEqPeriferico->Listar($filtro, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al consultar la id: ".$filtro,
												'detalles' => "No Hay periferico registrado",												
											);										
						}

						break;	
					case 'BusquedaAvanzadaLista':
						
// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['serial']) || 
							!isset($_POST['serialBienN']) || 
							!isset($_POST['tipoListD']) || 
							!isset($_POST['modeloListD']) ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$serial  					=	$_POST['serial'];
						$serialBienN		=	$_POST['serialBienN'];
						$tipoListD				=	$_POST['tipoListD'];
						$modeloListD		=	$_POST['modeloListD'];

						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modEqPeriferico->getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES
						$getTotalPaginas=0;
						$resultados = $modEqPeriferico->ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $empezar_desde, $tamagno_paginas);
						$pagAnterior=$pagina - 1;
						$pagSiguiente = $pagina +1;
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
										'pagAnterior' => $pagAnterior,
										'pagSiguiente' => $pagSiguiente,
										'pagActual' => $pagina,
										'total_paginas' => $total_paginas,
										'DetallesBusquedaAvanzada' => "serial: ".$serial." - Serial bien N: ".$serialBienN." - tipo: ".$tipoListD." - modelo: ".$modeloListD,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la id: ",
												'detalles' => "No Hay periferico registrado",												
											);										
						}

						break;							
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>