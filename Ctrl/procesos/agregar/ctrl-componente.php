<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../../Mod/conexion.php';

	  	require_once '../../../Mod/procesos/agregar/mod-componente/entidad-componente.php';

		require_once '../../../Mod/procesos/agregar/mod-componente/mod-componente.php';

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

		$eq_componente = new eq_componente();
		$modEqComponente = new modEqComponente();	
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
									$eq_componente = new eq_componente(); 			
									$eq_componente->__SET('serial', $serialVal);
									$eq_componente->__SET('serial_bn', $seriales_bn[$contando]);
									$eq_componente->__SET('id_c_fisc_comp', $_POST['id_caracteristicas']);
									$idsRegistrados[]=$modEqComponente->guardar($eq_componente);
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
													'detalles' => " Componentes Guardados correctamente ",		
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el Componente",
												);
							}

						break;

					case 'cambiarEstadoDeUso':
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
						$eq_componente->__SET('id',          $_POST['id']);
						$eq_componente->__SET('estado',       $estado);						
						$resultadoDepartamentoEstado = $modEqComponente->cambiarEstado($eq_componente);
						if ($resultadoDepartamentoEstado===1) {
							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Componente ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el componente",
												'detalles' => $resultadoDepartamentoEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modEqComponente->consultar($id);
						if ($resultados!="") {
							$datos[] = array(
																								'controlError' => 0,
																								'resultado' => $resultados,
																								);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay componente registrado con la id: ".$id,
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
						$resultados = $modEqComponente->consultarCaractPerif($id);
						if ($resultados!="") {
							$datos[] = array(
																								'controlError' => 0,
																								'resultado' => $resultados,
																								);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay componente registrado con la id: ".$id,
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
						$num_filas = $modEqComponente->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modEqComponente->Listar($filtro, $empezar_desde, $tamagno_paginas);
						$pagAnterior=$pagina - 1;
						$pagSiguiente = $pagina +1;
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
										'pagAnterior' => $pagAnterior,
										'pagSiguiente' => $pagSiguiente,
										'pagActual' => $pagina,
										'total_paginas' => $total_paginas,
										'BORRAR_tamanopaginas' => $tamagno_paginas,
										'BORRAR_num_filas' => $num_filas,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la id: ".$filtro,
												'detalles' => "No Hay componente registrado",												
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
						$num_filas = $modEqComponente->getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modEqComponente->ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $empezar_desde, $tamagno_paginas);
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
												'detalles' => "No Hay componente registrado",												
											);										
						}

						break;							
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>