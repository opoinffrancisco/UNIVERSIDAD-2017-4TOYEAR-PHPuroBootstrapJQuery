<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-pn-perfil/entidad-pn-perfil.php';
	  	require_once '../../Mod/configuracion/mod-pn-perfil/entidad-pn-perfil-permiso.php';
		require_once '../../Mod/configuracion/mod-pn-perfil/mod-pn-perfil.php';
	  	require_once '../../Mod/mantenimiento/mod-modulo/entidad-modulo.php';
		require_once '../../Mod/mantenimiento/mod-modulo/mod-modulo.php';		
		//
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
		$perfil = new perfil();
		$perfil_Permiso = new perfil_Permiso();
		$modPerfil = new modPerfil();	
		$modulo = new modulo();
		$modModulo = new modModulo();	
		//
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

						$id=$_POST['id'];
						$resultados = $modPerfil->consultar($id);
						if ($resultados!="" && $id!=0) {
							/***********************EDITAR*************************/
							$perfil->__SET('id',         $resultados->__GET('id'));
							$perfil->__SET('nombre',       $_POST['nombre']);
							
							$resultado = $modPerfil->editar($perfil);
							if ($resultado===1) {

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " perfil editado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al modificar el perfil",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/		
						} elseif($id==0 || $resultados=="") {
							/**********************GUARDAR***********************/
							$perfil->__SET('nombre',       $_POST['nombre']);
							$resultado =$modPerfil->guardar($perfil);
							if ($resultado>0) {

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " perfil Guardado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el perfil",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/	
						}else{
							$datos[] = array(
												'controlError' => 1,
												'mensaje' => "Error al consultar la id: ".$id,
												'detalles' => $resultados,												
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
						$mensajeEstado3="";
						if ($estado<=0) {
							$mensajeEstado="Deshabilitados";
							$mensajeEstado2="Deshabilitar";
							$mensajeEstado3="DESHABILITO";
						} else {
							$mensajeEstado="Habilitados";
							$mensajeEstado2="Habilitar";
							$mensajeEstado3="HABILITO";
						}
						$perfil->__SET('id',          $_POST['id']);
						$perfil->__SET('estado',       $estado);						
						$resultadoModeloEstado = $modPerfil->cambiarEstado($perfil);
						if ($resultadoModeloEstado===1) {

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " perfil ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el perfil",
												'detalles' => $resultadoModeloEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modPerfil->consultar($id);
						if ($resultados!="") {
							$datos[] = array(
											   		'id' => $resultados->__GET('id'),
												    'nombre' => $resultados->__GET('nombre'),
											   		'estadoPerfil' => $resultados->__GET('estado'),
												);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el perfil con la id: ".$id,
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
						$num_filas = $modPerfil->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modPerfil->Listar($filtro, $empezar_desde, $tamagno_paginas);
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
												'detalles' => "No Hay perfil registrada",												
											);										
						}

						break;	
					case 'cargaTotalModulosAsignar':

						$id_perfil  = (isset($_POST['id_perfil']))? $_POST['id_perfil'] : "" ;
						$resultados = $modModulo->ListarModulosAsignar($modPerfil ,$id_perfil);
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar los modulos para el permiso",
												'detalles' => "No Hay modulos en permisos registrada",												
											);										
						}

						break;							
					case 'cargaTotalModulosAsignados':
						$perfil->__SET('id',         (isset($_POST['id_perfil']))? $_POST['id_perfil'] : "" );
						$resultados = $modPerfil->ListarModulosAsignados($perfil);
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar los modulos para el permiso",
												'detalles' => "No Hay modulos en permisos registrada",												
											);										
						}

						break;		
					case 'asignarModulo':
						
						$idPerfil=(isset($_POST['idPerfil']))? $_POST['idPerfil'] : "" ;
						$idModulo=(isset($_POST['idModulo']))? $_POST['idModulo'] : "" ;


						$resultadoVerificacion = $modPerfil->verificarModuloAsignado($idPerfil, $idModulo);
						if ($resultadoVerificacion===0) {
							$perfil->__SET('id',          $idPerfil);
							$modulo->__SET('id',          $idModulo);							
							$resultadoAsignacion = $modPerfil->asignarModulo($perfil, $modulo);
							if ($resultadoAsignacion===1) {

								$datos[] = array(
														'controlError' => 0,
														'mensaje' => "Modulo asignado con Exito!",
														'detalles' => "Modulo asignado correctamente ",												
													);																	
							}else{
								$datos[] = array(
													'controlError' => 4,
													'mensaje' => "Error al asignar el modulo",
													'detalles' => $resultadoAsignacion,												
												);
							}
						}else if($resultadoVerificacion!=""){
							$datos[] = array(
													'controlError' => 4,
													'mensaje' => "Modulo ya asignado",
													'detalles' => "Modulo ya asignado",												
												);						
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al verificar la id: ".$id,
												'detalles' => $resultados,												
											);							
						}

						break;	
					case 'cambiarPermisoModulo':
						/*
							0 = Deshabilitado / Desabilitar
							1 = Habilitado / Habilitar
						*/
						$estado  = (isset($_POST['estado']))? $_POST['estado'] : 1 ;

						$mensajeEstado="";
						$mensajeEstado2="";
						if ($estado==0) {
							$mensajeEstado="Deshabilito";
						}
						if ($estado==1) {
							$mensajeEstado="Habilito";
						}
						$perfil_Permiso->__SET('id',          $_POST['idPermiso']);
						$perfil_Permiso->__SET('permiso_acceso',          $estado);		
												
						$resultadosPermiso = $modPerfil->cambiarPermiso($perfil_Permiso);					
							if ($resultadosPermiso===1) {

								$datos[] = array(
														'controlError' => 0,
														'mensaje' => "Permiso SE ".$mensajeEstado." correctamente",
														'detalles' => "Permiso  SE ".$mensajeEstado." correctamente",												
													);																	
							}else{
								$datos[] = array(
													'controlError' => 4,
													'mensaje' => "Error al cambiar el Permiso",
													'detalles' => $resultadosPermiso,												
												);
							}
							$mensajeEstado="";
						break;
					case 'cambiarPermisosAccionesModulo':

						$id=$_POST['id'];
			
							/***********************EDITAR*************************/
							
							$perfil_Permiso->__SET('id',  $id);

							$perfil_Permiso->__SET('func_nuevo',       $_POST['func_nuevo']);
							$perfil_Permiso->__SET('func_editar',       $_POST['func_editar']);
							$perfil_Permiso->__SET('func_eliminacion_logica',     
									$_POST['func_eliminacion_logica']);
							$perfil_Permiso->__SET('func_generar_reporte',       
									$_POST['func_generar_reporte']);
							$perfil_Permiso->__SET('func_generar_reporte_filtrado',       
									$_POST['func_generar_reporte_filtrado']);
							$perfil_Permiso->__SET('func_permisos_perfil',       
									$_POST['func_permisos_perfil']);
							$perfil_Permiso->__SET('func_busqueda_avanzada',       
									$_POST['func_busqueda_avanzada']);
							$perfil_Permiso->__SET('func_detalles',     $_POST['func_detalles']);
							$perfil_Permiso->__SET('func_atender',     $_POST['func_atender']);
							$perfil_Permiso->__SET('func_asignar',      $_POST['func_asignar']);
							$perfil_Permiso->__SET('func_programar_tarea',       
									$_POST['func_programar_tarea']);
							$perfil_Permiso->__SET('func_iniciar_finalizar_tarea',       
									$_POST['func_iniciar_finalizar_tarea']);
							$perfil_Permiso->__SET('func_diagnosticar',
									$_POST['func_diagnosticar']);
							$perfil_Permiso->__SET('func_gestion_equipo_mantenimiento',       
									$_POST['func_gestion_equipo_mantenimiento']);
							$perfil_Permiso->__SET('func_respuesta_solicitud',      
									$_POST['func_respuesta_solicitud']);
							$perfil_Permiso->__SET('func_finalizar_solicitud',      
									$_POST['func_finalizar_solicitud']);
							//--
							$perfil_Permiso->__SET('func_desincorporar_equipo',      
									$_POST['func_desincorporar_equipo']);
							$perfil_Permiso->__SET('func_desincorporar_periferico',      
									$_POST['func_desincorporar_periferico']);
							$perfil_Permiso->__SET('func_desincorporar_componente',      
									$_POST['func_desincorporar_componente']);													
							$perfil_Permiso->__SET('func_cambiar_periferico',      
									$_POST['func_cambiar_periferico']);
							$perfil_Permiso->__SET('func_cambiar_componente',      
									$_POST['func_cambiar_componente']);
							$perfil_Permiso->__SET('func_cambiar_software',      
									$_POST['func_cambiar_software']);														
							$perfil_Permiso->__SET('func_inconformidad_atendida',      
									$_POST['func_inconformidad_atendida']);							

							$resultado = $modPerfil->cambiarPermisosAccionesModulo($perfil_Permiso);
							if ($resultado===1) {

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " Permisos de usuarios en un modulo editados correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al modificar el los permisos del usuario en un modulo",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/		
						break;
					case 'consultarPermisosAccionesModulo':
						$id=(isset($_POST['id']))? $_POST['id'] : "" ;
						$resultados = $modPerfil->consultarPermisosAccionesModulo($id);
						if ($resultados!="") {
							$datos = $resultados;

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el perfil con la id: ".$id,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id,
													'detalles' => $resultados,												
												);							
							}
						break;
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>