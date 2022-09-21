<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../../Mod/conexion.php';
		//
	  	require_once '../../../Mod/procesos/agregar/mod-equipo/entidad-equipo.php';
	  	require_once '../../../Mod/procesos/agregar/mod-equipo/entidad-equipo-componente.php';
	  	require_once '../../../Mod/procesos/agregar/mod-equipo/entidad-equipo-periferico.php';
	  	require_once '../../../Mod/procesos/agregar/mod-equipo/entidad-equipo-software.php';
		require_once '../../../Mod/procesos/agregar/mod-equipo/mod-equipo.php';
		//
	  	require_once '../../../Mod/procesos/agregar/mod-componente/entidad-componente.php';
		require_once '../../../Mod/procesos/agregar/mod-componente/mod-componente.php';
		//
	  	require_once '../../../Mod/procesos/agregar/mod-periferico/entidad-periferico.php';
		require_once '../../../Mod/procesos/agregar/mod-periferico/mod-periferico.php';
		//
		//----------------

		require_once '../../../Mod/procesos/asignar/mod-asignar/entidad-persona-equipo.php';
		require_once '../../../Mod/procesos/asignar/mod-asignar/mod-asignar.php';

		//----------------
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

		$equipo = new equipo();
		$modEquipo = new modEquipo();	
		$eq_componente = new eq_componente();
		$modEqComponente = new modEqComponente();
		$eq_periferico = new eq_periferico();
		$modEqPeriferico = new modEqPeriferico();	
		//----
		$persona_equipo = new persona_equipo();
		$modAsignar = new modAsignar();
		//
		$modBitacora = new modBitacora();		

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

							$id_persona = (isset($_POST['id_persona']))? $_POST['id_persona'] : "";
							if ($id_persona==null || $id_persona==0) {
								$id_persona="";
							}						
							$id_cargo=(isset($_POST['id_cargo']))? $_POST['id_cargo'] : "";				
							if ($id_cargo==null || $id_cargo==0) {
								$id_cargo="";
							}						
							$id_departamento=(isset($_POST['id_departamento']))? $_POST['id_departamento'] : "";	
							if ($id_departamento==null || $id_departamento==0) {
								$id_departamento="";
							}						

							$id_equipo=(isset($_POST['id_equipo']))? $_POST['id_equipo'] : "";				
							if ($id_equipo==null || $id_equipo==0) {
								$id_equipo="";
							}			
							$persona_equipo->__SET('id_persona', $id_persona);
							$persona_equipo->__SET('id_cargo', $id_cargo);
							$persona_equipo->__SET('id_departamento', $id_departamento);
							$persona_equipo->__SET('id_equipo', $id_equipo);
							$resultado=$modAsignar->guardar($persona_equipo);

							if ($resultado>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('ASIGNO UN EQUIPO A UNA PERSONA',$IP,$IDUSUARIO);	
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Asignado correctamente ",		
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al asignar",
												);
							}							
					break;
					case 'editarPorEstado2':

							$id_persona = (isset($_POST['id_persona']))? $_POST['id_persona'] : "";
							if ($id_persona==null || $id_persona==0) {
								$id_persona="";
							}						
							$id_cargo=(isset($_POST['id_cargo']))? $_POST['id_cargo'] : "";				
							if ($id_cargo==null || $id_cargo==0) {
								$id_cargo="";
							}						
							$id_departamento=(isset($_POST['id_departamento']))? $_POST['id_departamento'] : "";	
							if ($id_departamento==null || $id_departamento==0) {
								$id_departamento="";
							}						

							$id_equipo=(isset($_POST['id_equipo']))? $_POST['id_equipo'] : "";				
							if ($id_equipo==null || $id_equipo==0) {
								$id_equipo="";
							}			
							$persona_equipo->__SET('id_persona', $id_persona);
							$persona_equipo->__SET('id_cargo', $id_cargo);
							$persona_equipo->__SET('id_departamento', $id_departamento);
							$persona_equipo->__SET('id_equipo', $id_equipo);
							$resultado=$modAsignar->editarPorEstado2($persona_equipo);

							if ($resultado>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('ASIGNO UN EQUIPO A UNA PERSONA - A QUIEN SE LE DAÑO EL EQUIPO',$IP,$IDUSUARIO);	
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos editados con exito!",
													'detalles' => " Equipo asignado correctamente ",		
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al editar asignación",
												);
							}	
						
					break;					
					case 'reasignar':

							$id_persona_actual = (isset($_POST['id_persona_actual']))? $_POST['id_persona_actual'] : "";
							if ($id_persona_actual==null || $id_persona_actual==0) {
								$id_persona_actual="";
							}						
							$id_cargo_actual= (isset($_POST['id_cargo_actual']))? $_POST['id_cargo_actual'] : "";				
							if ($id_cargo_actual==null || $id_cargo_actual==0) {
								$id_cargo_actual="";
							}						
							$id_departamento_actual= (isset($_POST['id_departamento_actual']))? $_POST['id_departamento_actual'] : "";	
							if ($id_departamento_actual==null || $id_departamento_actual==0) {
								$id_departamento_actual="";
							}						

							$id_equipo_actual= (isset($_POST['id_equipo_actual']))? $_POST['id_equipo_actual'] : "";				
							if ($id_equipo_actual==null || $id_equipo_actual==0) {
								$id_equipo_actual="";
							}						
							$resultadosDACA = $modAsignar->desactivarActualControlAsignacion($id_cargo_actual,$id_departamento_actual, $id_equipo_actual,$id_persona_actual);
							if ($resultadosDACA==1) {

										$IP=$_POST['ip_cliente'];
										$IDUSUARIO=$_POST['id_usuario'];								
										$modBitacora->guardarOperacion('DESACTIVO LA ACTUAL ASIGNACION DE UN EQUIPO',$IP,$IDUSUARIO);	


											$id_persona = (isset($_POST['id_persona']))? $_POST['id_persona'] : "";
											if ($id_persona==null || $id_persona==0) {
												$id_persona="";
											}						
											$id_cargo=(isset($_POST['id_cargo']))? $_POST['id_cargo'] : "";				
											if ($id_cargo==null || $id_cargo==0) {
												$id_cargo="";
											}						
											$id_departamento=(isset($_POST['id_departamento']))? $_POST['id_departamento'] : "";	
											if ($id_departamento==null || $id_departamento==0) {
												$id_departamento="";
											}						

											$id_equipo=(isset($_POST['id_equipo']))? $_POST['id_equipo'] : "";				
											if ($id_equipo==null || $id_equipo==0) {
												$id_equipo="";
											}			
											$persona_equipo->__SET('id_persona', $id_persona);
											$persona_equipo->__SET('id_cargo', $id_cargo);
											$persona_equipo->__SET('id_departamento', $id_departamento);
											$persona_equipo->__SET('id_equipo', $id_equipo);
											$resultado=$modAsignar->guardar($persona_equipo);

											if ($resultado>0) {

												$IP=$_POST['ip_cliente'];
												$IDUSUARIO=$_POST['id_usuario'];								
												$modBitacora->guardarOperacion('REASIGNO UN EQUIPO A UNA PERSONA',$IP,$IDUSUARIO);	
												$datos[] = array(
																	'controlError' => 0,
																	'mensaje' => "¡Datos Guardados con Exito!",
																	'detalles' => " Reasignado correctamente ",		
																);								
											}else{
												$datos[] = array(
																	'controlError' => 1,
																	'mensaje' => "Error al reasignar",
																);
											}	
									}else{

												$datos[] = array(
																	'controlError' => 1,
																	'mensaje' => "Error al desactivar anterior asignacion",
																);

									}

						break;
					case 'consultar':

						$id_persona = (isset($_POST['id_persona']))? $_POST['id_persona'] : "";
						if ($id_persona==null || $id_persona==0) {
							$id_persona="";
						}						
						$id_cargo=(isset($_POST['id_cargo']))? $_POST['id_cargo'] : "";				
						if ($id_cargo==null || $id_cargo==0) {
							$id_cargo="";
						}						
						$id_departamento=(isset($_POST['id_departamento']))? $_POST['id_departamento'] : "";	
						if ($id_departamento==null || $id_departamento==0) {
							$id_departamento="";
						}						

						$id_equipo=(isset($_POST['id_equipo']))? $_POST['id_equipo'] : "";				
						if ($id_equipo==null || $id_equipo==0) {
							$id_equipo="";
						}		
						$resultados = $modAsignar->consultar($id_persona, $id_cargo,$id_departamento,$id_equipo);
						if ($resultados!="") {
							$datos[] = array(
											'controlError' => 0,
											'resultado' => $resultados,
											);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "La asignación no existe",
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar ",
													'detalles' => $resultados,												
												);							
							}

						break;
					case 'FiltrarLista':
						
						// INICIO CAlCULAR VARIABLES


						$filtro=(isset($_POST['filtro']))? $_POST['filtro'] : "";
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modAsignar->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modAsignar->Listar($filtro, $empezar_desde, $tamagno_paginas);
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
								!isset($_POST['modeloListD']) || 
								!isset($_POST['cedulaTxt']) || 
								!isset($_POST['cargoListD']) || 
								!isset($_POST['departamentoListD']) ) {
							
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al validar campos ",
													'detalles' => "Campos vacios",												
												);
								break;	
							}
							$serial  				=	$_POST['serial'];
							$serialBienN			=	$_POST['serialBienN'];
							$tipoListD				=	$_POST['tipoListD'];
							$modeloListD			=	$_POST['modeloListD'];
							$cedula					=	$_POST['cedulaTxt'];
							$cargoListD				=	$_POST['cargoListD'];
							$departamentoListD		=	$_POST['departamentoListD'];

							$tamagno_paginas=$_POST['tamagno_paginas'];
							if ($_POST['pagina']!=1) {							
								$pagina=$_POST['pagina'];
							}else{
								$pagina=1;
							}			
							$empezar_desde=($pagina-1)*$tamagno_paginas;
							$getTotalPaginas=1;
							$num_filas = $modAsignar->getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$cedula,$cargoListD,$departamentoListD, $getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
									// FIN CAlCULAR VARIABLES

							$getTotalPaginas=0;
							$resultados = $modAsignar->ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD, $empezar_desde, $tamagno_paginas);
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

						case 'ListarBusqdAvanzdPersonasASIG':
							
							// INICIO CAlCULAR VARIABLES
							if (!isset($_POST['cedula']) || 
								!isset($_POST['cargo']) || 
								!isset($_POST['departamento']) ) {
							
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al validar campos ",
													'detalles' => "Campos vacios",												
												);
								break;	
							}
							$cedula  					=	$_POST['cedula'];
							$cargo						=	$_POST['cargo'];
							$departamento				=	$_POST['departamento'];

							$id_usuario_sesion	=	$_POST['id_usuario_sesion'];
							$tamagno_paginas	=	$_POST['tamagno_paginas'];
														
							$pagina = $_POST['pagina'];
							if ($pagina!=1) {							
								$pagina=$pagina;
							}else{
								$pagina=1;
							}			
							$empezar_desde=($pagina-1)*$tamagno_paginas;
							$getTotalPaginas=1;
							$num_filas = $modAsignar->getTotalPaginasBusqdAvanzdPersonasASIG($id_usuario_sesion, $cedula,$getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
								// FIN CAlCULAR VARIABLES

							$getTotalPaginas=0;
							$resultados = $modAsignar->ListarBusqdAvanzdPersonasASIG($id_usuario_sesion, $cedula,$empezar_desde, $tamagno_paginas);
							$pagAnterior=$pagina - 1;
							$pagSiguiente = $pagina +1;
							$datos = [	
											'controlError' => 0,						
											'resultados' => $resultados,
											'pagAnterior' => $pagAnterior,
											'pagSiguiente' => $pagSiguiente,
											'pagActual' => $pagina,
											'total_paginas' => $total_paginas,
											'DetallesBusquedaAvanzada' => "cedula: ".$cedula." - cargo: ".$cargo." - departamento : ".$departamento,
									];

							if ($resultados===0) {
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al consultar la id: ",
													'detalles' => "No Hay persona para asignarle un equipo",												
												);										
							}

						break;			


						case 'ListarBusqdAvanzdCargoDepartamentoASIG':
							
								// INICIO CAlCULAR VARIABLES
							if (
								!isset($_POST['cargo']) || 
								!isset($_POST['departamento']) ) {
							
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al validar campos ",
													'detalles' => "Campos vacios",												
												);
								break;	
							}
							$cargo						=	$_POST['cargo'];
							$departamento				=	$_POST['departamento'];

							$tamagno_paginas= $_POST['tamagno_paginas'];
														
							$pagina = $_POST['pagina'];
							if ($pagina!=1) {							
								$pagina=$pagina;
							}else{
								$pagina=1;
							}			
							$empezar_desde=($pagina-1)*$tamagno_paginas;
							$getTotalPaginas=1;
							$num_filas = $modAsignar->getTotalPaginasBusqdAvanzdCargoDepartamentoASIG($cargo,$departamento,$getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
										// FIN CAlCULAR VARIABLES
							$getTotalPaginas=0;
							$resultados = $modAsignar->ListarBusqdAvanzdCargoDepartamentoASIG($cargo,$departamento, $empezar_desde, $tamagno_paginas);
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
													'detalles' => "No Hay persona para asignarle un equipo",												
												);										
							}

						break;														
						case 'ListarBusqdAvanzdEquiposASIG':
							
							// INICIO CAlCULAR VARIABLES
							if (!isset($_POST['serial']) || 
								!isset($_POST['serialBN']) || 
								!isset($_POST['tipo']) || 
								!isset($_POST['modelo']) ) {
							
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al validar campos ",
													'detalles' => "Campos vacios",												
												);
								break;	
							}
							$serial  					=	$_POST['serial'];
							$serialBienN		=	$_POST['serialBN'];
							$tipoListD				=	$_POST['tipo'];
							$modeloListD		=	$_POST['modelo'];

							$tamagno_paginas=$_POST['tamagno_paginas'];
							if ($_POST['pagina']!=1) {							
								$pagina=$_POST['pagina'];
							}else{
								$pagina=1;
							}			
							$empezar_desde=($pagina-1)*$tamagno_paginas;
							$getTotalPaginas=1;
							$num_filas = $modAsignar->getTotalPaginasBusqdAvanzdEquiposASIG($serial,$serialBienN,$tipoListD,$modeloListD,$getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
							// FIN CAlCULAR VARIABLES

							$getTotalPaginas=0;
							$resultados = $modAsignar->ListarBusqdAvanzdEquiposASIG($serial,$serialBienN,$tipoListD,$modeloListD, $empezar_desde, $tamagno_paginas);
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