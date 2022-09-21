<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../../Mod/conexion.php';

		//_--------------------

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
	  	require_once '../../../Mod/configuracion/mod-c-software/entidad-c-software.php';
		require_once '../../../Mod/configuracion/mod-c-software/mod-c-software.php';				
		//----------------
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/entidad-solt-respuesta.php';
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/entidad-solt-diagnostico.php';
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/entidad-solicitud.php';
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/mod-solicitud.php';
		//

		require_once '../../../Mod/procesos/mantenimiento-equipo/mod-mantenimiento-equipo/entidad-mantenimiento.php';
		require_once '../../../Mod/procesos/mantenimiento-equipo/mod-mantenimiento-equipo/mod-mantenimiento.php';
		require_once '../../../Mod/procesos/tarea-programada/mod-tarea-programada/entidad-tarea-programada.php';
		require_once '../../../Mod/procesos/tarea-programada/mod-tarea-programada/mod-tarea-programada.php';		
		//----------------

 		require_once '../../utilidades/ctrl-fechas.php'; 	
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

		//
		$solt_respuesta = new solt_respuesta();
		$solt_diagnostico = new solt_diagnostico();
		$solicitud = new solicitud();
		$modSolicitud = new modSolicitud();
		//
		$mantenimiento = new mantenimiento();
		$modMantenimiento = new modMantenimiento();
		//
		$tarea_equipo = new tarea_equipo();
		$modTareaProgramada = new modTareaProgramada();
		//
		$equipo = new equipo();
		$modEquipo = new modEquipo();	

		$eq_componente = new eq_componente();
		$modEqComponente = new modEqComponente();

		$eq_periferico = new eq_periferico();
		$modEqPeriferico = new modEqPeriferico();	

		$equipo_software = new equipo_software(); 			
		$modSoftware = new modSoftware();	
		//		
		$modBitacora = new modBitacora();		

		//Recordar vaciar datos
		if(isset($_POST['accion']))
		{
			$accion=$_POST['accion'];
		}
//		$accion="ListarBusqdAvanzdPersonasASIG";
			if(isset($accion))
			{
				switch($accion)
				{
					case 'desincorporarEquipo':

						$infoestado = $_POST['infoestado'];
						//
						$id_equipo = $_POST['id_equipo'];
						$observacion = $_POST['observacion'];

						$resultados = $modMantenimiento->desincorporarEquipo($id_equipo, $observacion );
						if ($resultados===1) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion($infoestado,$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => $infoestado." correctamente ",
											);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR AL DESINCORPORAR ",
												'detalles' => $resultados,												
											);
						}
					break;	
					case 'desincorporarPerCompSoft':

						$infoestado = $_POST['infoestado'];
						//
						$id_equipo = $_POST['id_equipo'];
						$ID_CONTROL = $_POST['id_control'];
						$observacion = $_POST['observacion'];
						$tabla = $_POST['tabla'];
						$nombreForaneas = $_POST['nombreForaneas'];

						$resultados = $modMantenimiento->desincorporarPerCompSoft($id_equipo, $ID_CONTROL, $observacion, $tabla, $nombreForaneas );
						if ($resultados===1) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion($infoestado,$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => $infoestado." correctamente ",
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR EN ".$infoestado,
												'detalles' => $resultados,												
											);
						}
					break;			
					case 'guardarDiagnosticoSolicitud':

						$solt_diagnostico->__SET('observacion', utf8_decode($_POST['observacion']));
						$solt_diagnostico->__SET('id_solt', $_POST['id_solicitud']);
						$resultado=$modMantenimiento->guardarDiagnosticoSolicitud($solt_diagnostico);

						if ($resultado>0) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion('REALIZO DIAGNOSTICO EN UNA SOLICITUD ',$IP,$IDUSUARIO);	
							$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡Datos Guardados con Exito!",
												'detalles' => " Diagnostico realizado correctamente ",		
											);								
						}else{
							$datos[] = array(
												'controlError' => 1,
												'mensaje' => "Error al diagnosticar",
											);
						}							
					break;
					case 'guardarRespuestaSolicitud':

						$solt_respuesta->__SET('observacion', $_POST['observacion']);
						$solt_respuesta->__SET('id_solt', $_POST['id_solicitud']);
						$resultado=$modMantenimiento->guardarRespuestaSolicitud($solt_respuesta);

						if ($resultado>0) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion('ENVIO RESPUESTA DE UNA SOLICITUD ',$IP,$IDUSUARIO);	
							$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡Datos Guardados con Exito!",
												'detalles' => " Respuesta realizada correctamente ",		
											);								
						}else{
							$datos[] = array(
												'controlError' => 1,
												'mensaje' => "Error al responder solicitud",
											);
						}							
					break;					
					case 'guardarFinalizacionSolicitud':

						$id_solicitud			  = $_POST['id_solicitud'];
						$id_solicitante			  = $_POST['id_solicitante'];
						$ip_responsable_finalizar = $_POST['ip_responsable_finalizar'];
						$observacion = $_POST['observacion'];
						$resultado=$modMantenimiento->guardarFinalizacionSolicitud( $id_solicitud ,$id_solicitante ,$ip_responsable_finalizar, $observacion );
						
						if ($resultado>0) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion('ENVIO FINALIZACIÓN DE UNA SOLICITUD ',$IP,$IDUSUARIO);	
							$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡Datos Guardados con Exito!",
												'detalles' => " Finalización realizada correctamente ",		
											);								
						}else{
							$datos[] = array(
												'controlError' => 1,
												'mensaje' => "Error al finalizar solicitud",
											);
						}							
					break;										
					case 'guardarCambioComponenteUsado':
						
						$id_equipo = $_POST['id_equipo'];
						$id_componente_actual = $_POST['id_componente_actual'];
						$observacion = $_POST['observacion'];

						$resultados = $modMantenimiento->desincorporarPerCompSoft($id_equipo, $id_componente_actual, $observacion, 'equipo_componente', 'id_componente' );
						if ($resultados===1) {

									$id_componente_usado = $_POST['id_componente_usado'];
									$activado=$modMantenimiento->activarUsoPerfComp($id_componente_usado, 'eq_componente');	
									if ($activado>0) {
				
											$equipo_componente = new equipo_componente(); 			
											$equipo_componente->__SET('id_equipo', $id_equipo);
											$equipo_componente->__SET('id_componente', $id_componente_usado);
											$idAnadido=$modEquipo->anadirComponente($equipo_componente);
											if ($idAnadido>0) {

												//$IP=$_POST['ip_cliente'];
												//$IDUSUARIO=$_POST['id_usuario'];								
												//$modBitacora->guardarOperacion('CAMBIO UN COMPONENTE A UN EQUIPO',$IP,$IDUSUARIO);	

												$datos[] = array(
																'controlError' => 0,
																'mensaje' => "¡Datos añadido con Exito!",
																'detalles' => " Componente añadido correctamente ",		
															);								
											}else{
												$datos[] = array(
																'controlError' => 1,
																'mensaje' => "Error al añadir el Componente",
															);
											}
									}else{
										$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al activar el Componente",
													);
									}				

							}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR AL DESINCORPORAR ",
												'detalles' => $resultados,												
											);
							}
					break;
					case 'guardarCambioComponente':
						
						$id_equipo = $_POST['id_equipo'];
						$id_componente_actual = $_POST['id_componente_actual'];
						$observacion = $_POST['observacion'];

						$resultados = $modMantenimiento->desincorporarPerCompSoft($id_equipo, $id_componente_actual, $observacion, 'equipo_componente', 'id_componente' );
						if ($resultados===1) {

								$seriales = json_decode($_POST['seriales']);
								$seriales_bn = json_decode($_POST['seriales_bn']);

								$contando=0;	
								$idsRegistrado=0;										
								if($seriales>0){ 
									foreach ($seriales as $serial => $serialVal) {
										$eq_componente = new eq_componente(); 			
										$eq_componente->__SET('serial', $serialVal);
										$eq_componente->__SET('serial_bn', $seriales_bn[$contando]);
										$eq_componente->__SET('id_c_fisc_comp', $_POST['id_caracteristicas']);
										$idsRegistrado=$modEqComponente->guardar($eq_componente);
										$contando=$contando+1;							
									}		
								}

								if ($idsRegistrado>0) {

									$equipo_componente = new equipo_componente(); 			
									$equipo_componente->__SET('id_equipo', $id_equipo);
									$equipo_componente->__SET('id_componente', $idsRegistrado);
									$idAnadido=$modEquipo->anadirComponente($equipo_componente);
									if ($idAnadido>0) {

										//$IP=$_POST['ip_cliente'];
										//$IDUSUARIO=$_POST['id_usuario'];								
										//$modBitacora->guardarOperacion('CAMBIO UN COMPONENTE A UN EQUIPO',$IP,$IDUSUARIO);	

										$datos[] = array(
														'controlError' => 0,
														'mensaje' => "¡Datos añadido con Exito!",
														'detalles' => " Componente añadido correctamente ",		
													);								
									}else{
										$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al añadir el Componente",
													);
									}

								}else{
									$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al Guardar el Componente",
													);
								}

							}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR AL DESINCORPORAR ",
												'detalles' => $resultados,												
											);
							}
					break;										
					case 'guardarCambioPerifericoUsado':
						
						$id_equipo = $_POST['id_equipo'];
						$id_periferico_actual = $_POST['id_periferico_actual'];
						$observacion = $_POST['observacion'];

						$resultados = $modMantenimiento->desincorporarPerCompSoft($id_equipo, $id_periferico_actual, $observacion, 'equipo_periferico', 'id_periferico' );
						if ($resultados==1) {


									$id_periferico_usado = $_POST['id_periferico_usado'];
									$activado=$modMantenimiento->activarUsoPerfComp($id_periferico_usado, 'eq_periferico');	
									if ($activado>0) {
									
										$equipo_periferico = new equipo_periferico(); 			
										$equipo_periferico->__SET('id_equipo', $id_equipo);
										$equipo_periferico->__SET('id_periferico', $id_periferico_usado);
										$idAnadido=$modEquipo->anadirPeriferico($equipo_periferico);
										if ($idAnadido>0) {

											//$IP=$_POST['ip_cliente'];
											//$IDUSUARIO=$_POST['id_usuario'];								
											//$modBitacora->guardarOperacion('CAMBIO UN PERIFERICO A UN EQUIPO',$IP,$IDUSUARIO);	

											$datos[] = array(
															'controlError' => 0,
															'mensaje' => "¡Datos añadido con Exito!",
															'detalles' => " Periferico añadido correctamente ",		
														);								
										}else{
											$datos[] = array(
															'controlError' => 1,
															'mensaje' => "Error al añadir el Periferico",
														);
										}
									}else{
										$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al activar el Periferico",
													);
									}
							}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR AL DESINCORPORAR ",
												'detalles' => $resultados,												
											);
							}
					break;
					case 'guardarCambioPeriferico':
						
						$id_equipo = $_POST['id_equipo'];
						$id_periferico_actual = $_POST['id_periferico_actual'];
						$observacion = $_POST['observacion'];

						$resultados = $modMantenimiento->desincorporarPerCompSoft($id_equipo, $id_periferico_actual, $observacion, 'equipo_periferico', 'id_periferico' );
						if ($resultados===1) {

								$seriales = json_decode($_POST['seriales']);
								$seriales_bn = json_decode($_POST['seriales_bn']);

								$contando=0;	
								$idsRegistrado=0;										
								if($seriales>0){ 
									foreach ($seriales as $serial => $serialVal) {
										$eq_periferico = new eq_periferico(); 			
										$eq_periferico->__SET('serial', $serialVal);
										$eq_periferico->__SET('serial_bn', $seriales_bn[$contando]);
										$eq_periferico->__SET('id_c_fisc_perif', $_POST['id_caracteristicas']);
										$idsRegistrado=$modEqPeriferico->guardar($eq_periferico);
										$contando=$contando+1;							
									}		
								}

								if ($idsRegistrado>0) {


									$equipo_periferico = new equipo_periferico(); 			
									$equipo_periferico->__SET('id_equipo', $id_equipo);
									$equipo_periferico->__SET('id_periferico', $idsRegistrado);
									$idAnadido=$modEquipo->anadirPeriferico($equipo_periferico);
									if ($idAnadido>0) {

										//$IP=$_POST['ip_cliente'];
										//$IDUSUARIO=$_POST['id_usuario'];								
										//$modBitacora->guardarOperacion('CAMBIO UN PERIFERICO A UN EQUIPO',$IP,$IDUSUARIO);	

										$datos[] = array(
														'controlError' => 0,
														'mensaje' => "¡Datos añadido con Exito!",
														'detalles' => " Periferico añadido correctamente ",		
													);								
									}else{
										$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al añadir el Periferico",
													);
									}

								}else{
									$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al Guardar el Periferico",
													);
								}

							}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR AL DESINCORPORAR ",
												'detalles' => $resultados,												
											);
							}
					break;										
					case 'guardarCambioSoftware':
						
						$id_equipo = $_POST['id_equipo'];
						$id_software_actual = $_POST['id_software_actual'];
						$observacion = $_POST['observacion'];
						$id_software = $_POST['id_software'];

						// verificando existencia en equipo, del nuevo software que se añadira
						$resultado = $modSoftware->verificarExistenciaAnadida($id_equipo, $id_software);
						
						if ($resultado==0) {
							$resultados = $modMantenimiento->desincorporarPerCompSoft($id_equipo, $id_software_actual, $observacion, 'equipo_software', 'id_software' );
							if ($resultados==1) {

										$equipo_software->__SET('id_equipo', $id_equipo);
										$equipo_software->__SET('id_software', $id_software);
										$idAnadido=$modEquipo->anadirSoftware($equipo_software);
										if ($idAnadido>0) {

											//$IP=$_POST['ip_cliente'];
											//$IDUSUARIO=$_POST['id_usuario'];								
											//$modBitacora->guardarOperacion('CAMBIO UN SOFTWARE A UN EQUIPO',$IP,$IDUSUARIO);	

											$datos[] = array(
															'controlError' => 0,
															'mensaje' => "¡Datos añadido con Exito!",
															'detalles' => " Software añadido correctamente ",		
														);								
										}else{
											$datos[] = array(
															'controlError' => 1,
															'mensaje' => "Error al añadir el Software",
														);
										}
								}else{
								$datos[] = array(
													'controlError' => 4,
													'mensaje' => "ERROR AL DESINCORPORAR ",
													'detalles' => $resultados,												
												);
								}
						}else{
							$datos[] = array(
											'controlError' => 2,
											'mensaje' => "EL software esta actualmente en uso por el equipo",
										);
						}
					break;					
					case 'cambiarEstadoTareaEquipo':

							$estado           =$_POST['estado_uso'];
							$id_tarea_equipo  =$_POST['id_tarea_equipo'];
							$id_mantenimiento = $_POST['id_mantenimiento'];
							$id_solicitud = $_POST['id_solicitud'];
							$observacion 	  = $_POST['observacion'];

							//			die('estado :'.$estado.'  id_tarea_equipo :'.$id_tarea_equipo.' id_mantenimiento :'.$id_mantenimiento.' observacion: '.$observacion);

							$mensajeEstado="";
							$mensajeEstado2="";
							$mensajeEstado3="";
							
							$tarea_equipo->__SET('id', 			$id_tarea_equipo);
							$tarea_equipo->__SET('estado_uso',  $estado);
							$resultadoUsuario =$modTareaProgramada->cambiarEstado($tarea_equipo);
							$nombreTarea =$modTareaProgramada->obtenerNombreTarea($id_tarea_equipo);

							if ($resultadoUsuario==1) {

								$id_mantenimientoGestion=0;

								switch ($estado) {
								    case 2:
								    						// --> SE COLOCA EN STOP 
								    break;
								    case 1:

										$mensajeEstado="INICIO";
										// 1) // -> SE CREA EL MANTENIMIENTO EJECUTADO POR LA PROGRAMACION DE LA TAREA.
										$mantenimiento->__SET('id_tarea_equipo', 			$id_tarea_equipo);
										$mantenimiento->__SET('id_solicitud', 			$id_solicitud);
										$resultadoUsuario = $modMantenimiento->guardoMant($mantenimiento);
										$id_mantenimientoGestion = $resultadoUsuario;
									break;
									case 0:

										$mensajeEstado="FINALIZO";
										// 2)// -> SE EDITA EL MANTENIMIENTO EJECUTADO POR LA PROGRAMACION DE LA TAREA. 
										$mantenimiento->__SET('id', 			$id_mantenimiento);
										$mantenimiento->__SET('id_tarea_equipo', 			$id_tarea_equipo);
										$mantenimiento->__SET('observacion', 			$observacion);

										$resultadoUsuario = $modMantenimiento->finalizoMant($mantenimiento);			
										$id_mantenimientoGestion = $resultadoUsuario;										
										$modTareaProgramada->calcularProximaFecha($mantenimiento);							

									   break;
								}

								//$IP=$_POST['ip_cliente'];
								//$IDUSUARIO=$_POST['id_usuario'];								
								//$modBitacora->guardarOperacion($mensajeEstado.' UNA TAREA CORRECTIVA A UN EQUIPO',$IP,$IDUSUARIO);	
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => $mensajeEstado." correctamente una tarea programada ",
													'nombreTarea' => $nombreTarea,
													'id_mantenimiento' => $id_mantenimientoGestion,													
												);								
							} else {
								$datos[] = array(
													'controlError' => 4,
													'mensaje' => "Error cuando ".$mensajeEstado." una tarea programada",
													'id_mantenimiento' => $id_mantenimientoGestion,													
												);
							}

							break;						
					case 'cambiarEstado':

						$infoestado = $_POST['infoestado'];
						$estado=$_POST['estado'];

						$solicitud->__SET('id',          $_POST['id']);
						$solicitud->__SET('estado',       $estado);	

						$resultados = $modMantenimiento->cambiarEstado($solicitud);
						if ($resultados===1) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion($infoestado,$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => $infoestado." correctamente ",
													'estado' => $estado, 												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR EN ".$infoestado,
												'detalles' => $resultados,												
											);
						}


						break;			

					case 'guardarAtenderInconformidad':

						$id_conformidad=$_POST['id_conformidad'];

						$resultados = $modMantenimiento->guardarAtenderInconformidad($id_conformidad);
						if ($resultados===1) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion('ATENDIO UNA INCONFORMIDAD',$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => "Inconformidad atendida ",	
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "ERROR AL ATENDER INCONFORMIDAD",
												'detalles' => $resultados,												
											);
						}
						break;		
					case 'consultar':

						$id_solicitud = $_POST['id_solicitud'];

						$resultados = $modMantenimiento->consultar($id_solicitud);
						if ($resultados!="") {
							$datos[] = array(
											'controlError' => 0,
											'resultado' => $resultados,
											);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay solicitud con la id: ".$id_solicitud,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id_solicitud,
													'detalles' => $resultados,												
												);							
							}

						break;								
					case 'consultarPeriferico':

						$id_periferico = $_POST['id_periferico'];

						$resultados = $modMantenimiento->consultarPeriferico($id_periferico);

						if ($resultados!="") {

							$datos[] = array(
												'controlError' => 0,
												'resultado' => $resultados,
											);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay periferico con la id: ".$id_periferico,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id_periferico,
													'detalles' => $resultados,												
												);							
							}

						break;														
					case 'consultarComponente':

						$id_componente = $_POST['id_componente'];

						$resultados = $modMantenimiento->consultarComponente($id_componente);

						if ($resultados!="") {

							$resultadosInterfaces = $modMantenimiento->consultarComponente($id_componente);

							$datos[] = array(
												'controlError' => 0,
												'resultado' => $resultados,
												'resultadosInterfaces' => $resultadosInterfaces,
											);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay componente con la id: ".$id_componente,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id_solicitud,
													'detalles' => $resultados,												
												);							
							}

						break;														
					case 'consultarSoftware':

						$id_software = $_POST['id_software'];
						$id_equipo = $_POST['id_equipo'];

						$resultados = $modMantenimiento->consultarSoftware($id_software, $id_equipo);

						if ($resultados!="") {

							$datos[] = array(
												'controlError' => 0,
												'resultado' => $resultados,
											);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay software con la id: ".$id_software,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id_software,
													'detalles' => $resultados,												
												);							
							}

						break;																				
					case 'cargarListaDiagnosticosSolt':
						
						if (!isset($_POST['id_solicitud'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$id_solicitud	=	$_POST['id_solicitud'];
						
						$resultados = $modMantenimiento->cargarListaDiagnosticosSolt($id_solicitud);
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la id: ",
												'detalles' => "No se han realizado diagnosticos",												
											);										
						}
					break;		
					case 'cargarListaTareasEquipoSolicitud':
						if (!isset($_POST['id_equipo'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$id_equipo					=   $_POST['id_equipo'];
						
						$resultados = $modMantenimiento->cargarListaTareasEquipoSolicitud($id_equipo);
						
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la id: ",
												'detalles' => "No Hay tareas programadas para el equipo",												
											);										
						}
					break;						
					case 'FiltrarLista':
							
						// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['id_persona']) ||
							!isset($_POST['filtro']) ||
							!isset($_POST['buscardordesde']) ||
							!isset($_POST['buscardorhasta'])) {

							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$id_persona	=	$_POST['id_persona'];
						$filtro	=	$_POST['filtro'];
						$buscardordesde	=	$_POST['buscardordesde'];
						$buscardorhasta	=	$_POST['buscardorhasta'];
						//
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modMantenimiento->getTotalPaginas($id_persona, $filtro, $buscardordesde, $buscardorhasta, $getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modMantenimiento->Listar($id_persona, $filtro, $buscardordesde, $buscardorhasta, $empezar_desde, $tamagno_paginas);
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

					break;			
					case 'cargarListaPerifericosDisponibles':

						$filtro=(isset($_POST['filtro']))? $_POST['filtro'] : "" ;
						$filtro2=(isset($_POST['filtro2']))? $_POST['filtro2'] : "" ;
						
						$resultados = $modMantenimiento->cargarListaPerifericosDisponibles($filtro, $filtro2);

						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar ",
												'detalles' => "No hay perifericos disponibles",												
											);										
						}

					break;									
					case 'cargarListaComponentesDisponibles':
						
						$filtro=(isset($_POST['filtro']))? $_POST['filtro'] : "" ;
						$filtro2=(isset($_POST['filtro2']))? $_POST['filtro2'] : "" ;

						$resultados = $modMantenimiento->cargarListaComponentesDisponibles($filtro, $filtro2);

						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar",
												'detalles' => "No hay componentes disponibles",												
											);										
						}

					break;										
					default:
					break;
				}


				echo '' . json_encode($datos) . '';	
			}


			
?>