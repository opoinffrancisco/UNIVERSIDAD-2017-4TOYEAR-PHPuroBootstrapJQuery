<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../../Mod/conexion.php';
	 	require_once '../../utilidades/ctrl-fechas.php';
	 	require_once '../../utilidades/ctrl-ortografia.php';
	 	require_once '../../../Mod/utilidades/mod-bitacora.php';
		//----------------
		require_once '../../../Mod/procesos/mantenimiento-equipo/mod-mantenimiento-equipo/entidad-mantenimiento.php';
		require_once '../../../Mod/procesos/tarea-programada/mod-tarea-programada/entidad-tarea-programada.php';
		require_once '../../../Mod/procesos/tarea-programada/mod-tarea-programada/mod-tarea-programada.php';
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
		//----
		$mantenimiento = new mantenimiento();
		$tarea_equipo = new tarea_equipo();
		$modTareaProgramada = new modTareaProgramada();
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

								$id_equipos = json_decode($_POST['id_equipo']);

								$frecuencia = $_POST['frecuencia'];
								// Fecha actual
								$time = time();
								// calculando 
								$proxima_fecha = calculaFecha("days",$frecuencia,false);

								$contando=0;	
								$idsRegistrados=[];											
								if($id_equipos>0){ 
									foreach ($id_equipos as $equipo => $id_equipo) {
										$tarea_equipo = new tarea_equipo(); 			
										$tarea_equipo->__SET('id_tarea', $_POST['id_tarea']);
										$tarea_equipo->__SET('id_equipo', $id_equipo);
										$tarea_equipo->__SET('tiempo_estimado', $_POST['tiempo_estimado']);
										$tarea_equipo->__SET('frecuencia', $_POST['frecuencia']);
										$tarea_equipo->__SET('proxima_fecha', $proxima_fecha);

										$idsRegistrados[]=$modTareaProgramada->guardar($tarea_equipo);
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

									$IP=$_POST['ip_cliente'];
									$IDUSUARIO=$_POST['id_usuario'];								
									$modBitacora->guardarOperacion('PROGRAMO UNA TAREA A '.$contando.' EQUIPO/S',$IP,$IDUSUARIO);	

									$datos[] = array(
														'controlError' => 0,
														'mensaje' => "¡Datos Guardados con Exito!",
														'detalles' => "Tarea programada correctamente ",		
													);								
								}else{
									$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al programar la tarea",
													);
								}
						break;	
						case 'editar':
								
								$id_equipos = json_decode($_POST['id_equipo']);

								$tarea_equipo->__SET('id_tarea', $_POST['id_tarea']);
								$tarea_equipo->__SET('id_equipo', $id_equipos);
								$tarea_equipo->__SET('tiempo_estimado', $_POST['tiempo_estimado']);
								$tarea_equipo->__SET('frecuencia', $_POST['frecuencia']);
				
								$resultado=$modTareaProgramada->editar($tarea_equipo);

								if ($resultado!="") {

									$mantenimiento->__SET('id_tarea_equipo', 			$resultado);
									$modTareaProgramada->calcularProximaFechaSinModificarUltima($mantenimiento);									

									$IP=$_POST['ip_cliente'];
									$IDUSUARIO=$_POST['id_usuario'];								
									$modBitacora->guardarOperacion('EDITO LA PROGRAMACION DE UNA TAREA A UN EQUIPO',$IP,$IDUSUARIO);	

									$datos[] = array(
														'controlError' => 0,
														'mensaje' => "¡Datos Editados con Exito!",
														'detalles' => "Programacion de la tarea editada correctamente ",		
													);								
								}else{
									$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al programar la tarea",
													);
								}
						break;			
						case 'cambiarEstado':

							/*
								0 = Deshabilitado / Desabilitar
								1 = Habilitado / Habilitar
							*/

							$estado=$_POST['estado_uso'];
							$id_tarea_equipo=$_POST['id_tarea_equipo'];
							$observacion = $_POST['observacion'];

							$mensajeEstado="";
							$mensajeEstado2="";
							$mensajeEstado3="";
							
							$tarea_equipo->__SET('id', 			$id_tarea_equipo);
							$tarea_equipo->__SET('estado_uso',  $estado);
							$resultadoUsuario =$modTareaProgramada->cambiarEstado($tarea_equipo);
							$nombreTarea =$modTareaProgramada->obtenerNombreTarea($id_tarea_equipo);
							$serialEquipoTarea =$modTareaProgramada->obtenerSerialEquipoTarea($id_tarea_equipo);

							if ($resultadoUsuario===1) {


								$id_mantenimientoGestion=0;
								
								switch ($estado) {
								    case 2:
								    		// --> SE COLOCA EN STOP 
								    break;
								    case 1:

											$mensajeEstado="INICIO";
											$mensajeEstado2="INICIO";
											$mensajeEstado3="INICIO";
											// 1) // -> SE CREA EL MANTENIMIENTO EJECUTADO POR LA PROGRAMACION DE LA TAREA.
											$mantenimiento->__SET('id_tarea_equipo', 			$id_tarea_equipo);
											$resultadoUsuario =$modTareaProgramada->guardoMant($mantenimiento);

											$id_mantenimientoGestion = $resultadoUsuario;

									  break;
											case 0:

											$mensajeEstado="Finalizo";
											$mensajeEstado2="Finalizo";
											$mensajeEstado3="FINALIZO";
											// 2)// -> SE EDITA EL MANTENIMIENTO EJECUTADO POR LA PROGRAMACION DE LA TAREA. 
											$mantenimiento->__SET('id_tarea_equipo', 			$id_tarea_equipo);
											$mantenimiento->__SET('observacion', 			$observacion);

											$resultadoUsuario =$modTareaProgramada->finalizoMant($mantenimiento);			
											$id_mantenimientoGestion = $resultadoUsuario;

											$modTareaProgramada->calcularProximaFecha($mantenimiento);									
								   break;
								}

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Persona y Usuario ".$mensajeEstado." correctamente ",
													'nombreTarea' => $nombreTarea,
													'serialEquipoTarea'	=> $serialEquipoTarea,
													'id_mantenimiento' => $id_mantenimientoGestion,
												);								
							} else {
								$datos[] = array(
													'controlError' => 4,
													'mensaje' => "Error al ".$mensajeEstado2." el usuario",
													'detalles' => $resultadoUsuario,
													'id_mantenimiento' => $id_mantenimientoGestion,													
												);
							}

							break;										
						case 'consultar':


							$id_tarea_equipo = $_POST['id_tarea_equipo'];

							$resultados = $modTareaProgramada->consultar($id_tarea_equipo);
							if ($resultados!="") {
								$datos[] = array(
												'controlError' => 0,
												'resultado' => $resultados,
												);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay tarea programada para el equipo ",
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id_equipo,
													'detalles' => $resultados,												
												);							
							}
						break;						
						case 'FiltrarListaAvanzada':
							// se usa en el catalogo
							// INICIO CAlCULAR VARIABLES
							if (!isset($_POST['filtro']) || 
								!isset($_POST['serial']) || 
								!isset($_POST['serialBienN']) || 
								!isset($_POST['tipoListD']) || 
								!isset($_POST['modeloListD']) || 
								!isset($_POST['cedulaTxt']) || 
								!isset($_POST['cargoListD']) || 
								!isset($_POST['departamentoListD']) || 
								!isset($_POST['tareaListD']) ) {
							
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al validar campos ",
													'detalles' => "Campos vacios",												
												);
								break;	
							}
							


							$filtro					=   $_POST['filtro'];
							$serial  				=	$_POST['serial'];
							$serialBienN			=	$_POST['serialBienN'];
							$tipoListD				=	$_POST['tipoListD'];
							$modeloListD			=	$_POST['modeloListD'];
							$cedula					=	$_POST['cedulaTxt'];
							$cargoListD				=	$_POST['cargoListD'];
							$departamentoListD		=	$_POST['departamentoListD'];
							$tareaListD				=	$_POST['tareaListD'];

							$tamagno_paginas=$_POST['tamagno_paginas'];
							if ($_POST['pagina']!=1) {							
								$pagina=$_POST['pagina'];
							}else{
								$pagina=1;
							}			
							$empezar_desde=($pagina-1)*$tamagno_paginas;
							$getTotalPaginas=1;
							$num_filas = $modTareaProgramada->getTotalPaginas($filtro, $serial,$serialBienN,$tipoListD,$modeloListD,$cedula,$cargoListD,$departamentoListD, $tareaListD ,$getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
								// FIN CAlCULAR VARIABLES
							$getTotalPaginas=0;
							$resultados = $modTareaProgramada->Listar($filtro, $serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD, $tareaListD, $empezar_desde, $tamagno_paginas);
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
						case 'BusquedaAvanzadaLista':
							// se usa en la ventana modal
							// INICIO CAlCULAR VARIABLES
							if (!isset($_POST['serial']) || 
								!isset($_POST['serialBienN']) || 
								!isset($_POST['tipoListD']) || 
								!isset($_POST['modeloListD']) || 
								!isset($_POST['cedulaTxt']) || 
								!isset($_POST['cargoListD']) || 
								!isset($_POST['departamentoListD']) || 
								!isset($_POST['tareaListD']) ) {
							
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
							$tareaListD				=	$_POST['tareaListD'];

							$tamagno_paginas=$_POST['tamagno_paginas'];
							if ($_POST['pagina']!=1) {							
								$pagina=$_POST['pagina'];
							}else{
								$pagina=1;
							}			
							$empezar_desde=($pagina-1)*$tamagno_paginas;
							$getTotalPaginas=1;
							$num_filas = $modTareaProgramada->getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$cedula,$cargoListD,$departamentoListD, $tareaListD ,$getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
							// FIN CAlCULAR VARIABLES
							$getTotalPaginas=0;
							$resultados = $modTareaProgramada->ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD, $tareaListD, $empezar_desde, $tamagno_paginas);
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
						case 'cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva':

							$tipo_tarea = $_POST['tipo_tarea'];

							$resultados = $modTareaProgramada->cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva($tipo_tarea);

							$datos = [	
											'controlError' => 0,						
											'resultados' => $resultados,
									];

							if ($resultados===0) {
								$datos = array(
													'controlError' => 5,
													'mensaje' => "Error al consultar las tareas",
													'detalles' => "No Hay tareas registradas",												
												);										
							}

						break;	
						default:
						break;
				}


				echo '' . json_encode($datos) . '';	
			}




?>