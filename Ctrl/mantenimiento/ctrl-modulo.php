<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/mantenimiento/mod-modulo/entidad-modulo.php';
		require_once '../../Mod/mantenimiento/mod-modulo/mod-modulo.php';
	  	//
	  	require_once '../../Mod/utilidades/mod-bitacora.php';
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
		$modulo = new modulo();
		$modModulo = new modModulo();	
		//Recordar vaciar datos

		//
		$modBitacora = new modBitacora();		
		
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
						$resultados = $modModulo->consultar($id);

						if ($resultados!="") {
							/***********************EDITAR*************************/
							
							$modulo->__SET('id',         $id);

							$modulo->__SET('nombre',       $_POST['nombre']);
							$modulo->__SET('descripcion',       $_POST['descripcion']);
							$modulo->__SET('id_modulo_pertenece',       $_POST['moduloPertenece']);



							$modulo->__SET('func_nuevo',       $_POST['func_nuevo']);
							$modulo->__SET('func_editar',       $_POST['func_editar']);
							$modulo->__SET('func_eliminacion_logica',     
									$_POST['func_eliminacion_logica']);
							$modulo->__SET('func_generar_reporte',       
									$_POST['func_generar_reporte']);
							$modulo->__SET('func_generar_reporte_filtrado',       
									$_POST['func_generar_reporte_filtrado']);
							$modulo->__SET('func_permisos_perfil',       
									$_POST['func_permisos_perfil']);
							$modulo->__SET('func_busqueda_avanzada',       
									$_POST['func_busqueda_avanzada']);
							$modulo->__SET('func_detalles',     $_POST['func_detalles']);
							$modulo->__SET('func_atender',     $_POST['func_atender']);
							$modulo->__SET('func_asignar',      $_POST['func_asignar']);
							$modulo->__SET('func_programar_tarea',       
									$_POST['func_programar_tarea']);
							$modulo->__SET('func_iniciar_finalizar_tarea',       
									$_POST['func_iniciar_finalizar_tarea']);
							$modulo->__SET('func_diagnosticar',
									$_POST['func_diagnosticar']);
							$modulo->__SET('func_gestion_equipo_mantenimiento',       
									$_POST['func_gestion_equipo_mantenimiento']);
							$modulo->__SET('func_respuesta_solicitud',      
									$_POST['func_respuesta_solicitud']);
							$modulo->__SET('func_finalizar_solicitud',      
									$_POST['func_finalizar_solicitud']);
							//--
							$modulo->__SET('func_desincorporar_equipo',      
									$_POST['func_desincorporar_equipo']);
							$modulo->__SET('func_desincorporar_periferico',      
									$_POST['func_desincorporar_periferico']);
							$modulo->__SET('func_desincorporar_componente',      
									$_POST['func_desincorporar_componente']);													
							$modulo->__SET('func_cambiar_periferico',      
									$_POST['func_cambiar_periferico']);
							$modulo->__SET('func_cambiar_componente',      
									$_POST['func_cambiar_componente']);
							$modulo->__SET('func_cambiar_software',      
									$_POST['func_cambiar_software']);														
							$modulo->__SET('func_inconformidad_atendida',      
									$_POST['func_inconformidad_atendida']);

							$resultado = $modModulo->editar($modulo);
							if ($resultado===1) {

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " Modulo editado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al modificar el modulo",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/		
						} elseif($resultados===0) {
							/**********************GUARDAR***********************/
							$modulo->__SET('nombre',       $_POST['nombre']);
							$modulo->__SET('descripcion',       $_POST['descripcion']);
							$modulo->__SET('id_modulo_pertenece',       $_POST['moduloPertenece']);

							$modulo->__SET('func_nuevo',       $_POST['func_nuevo']);
							$modulo->__SET('func_editar',       $_POST['func_editar']);
							$modulo->__SET('func_eliminacion_logica',     
									$_POST['func_eliminacion_logica']);
							$modulo->__SET('func_generar_reporte',       
									$_POST['func_generar_reporte']);
							$modulo->__SET('func_generar_reporte_filtrado',       
									$_POST['func_generar_reporte_filtrado']);
							$modulo->__SET('func_permisos_perfil',       
									$_POST['func_permisos_perfil']);
							$modulo->__SET('func_busqueda_avanzada',       
									$_POST['func_busqueda_avanzada']);
							$modulo->__SET('func_detalles',     $_POST['func_detalles']);
							$modulo->__SET('func_atender',     $_POST['func_atender']);
							$modulo->__SET('func_asignar',      $_POST['func_asignar']);
							$modulo->__SET('func_programar_tarea',       
									$_POST['func_programar_tarea']);
							$modulo->__SET('func_iniciar_finalizar_tarea',       
									$_POST['func_iniciar_finalizar_tarea']);
							$modulo->__SET('func_diagnosticar',
									$_POST['func_diagnosticar']);
							$modulo->__SET('func_gestion_equipo_mantenimiento',       
									$_POST['func_gestion_equipo_mantenimiento']);
							$modulo->__SET('func_respuesta_solicitud',      
									$_POST['func_respuesta_solicitud']);
							$modulo->__SET('func_finalizar_solicitud',      
									$_POST['func_finalizar_solicitud']);
							//--
							$modulo->__SET('func_desincorporar_equipo',      
									$_POST['func_desincorporar_equipo']);
							$modulo->__SET('func_desincorporar_periferico',      
									$_POST['func_desincorporar_periferico']);
							$modulo->__SET('func_desincorporar_componente',      
									$_POST['func_desincorporar_componente']);													
							$modulo->__SET('func_cambiar_periferico',      
									$_POST['func_cambiar_periferico']);
							$modulo->__SET('func_cambiar_componente',      
									$_POST['func_cambiar_componente']);
							$modulo->__SET('func_cambiar_software',      
									$_POST['func_cambiar_software']);														
							$modulo->__SET('func_inconformidad_atendida',      
									$_POST['func_inconformidad_atendida']);


							$resultado =$modModulo->guardar($modulo);
							if ($resultado>0) {

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Modulo Guardado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el modulo",
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
						if ($estado<=0) {
							$mensajeEstado="Deshabilitados";
							$mensajeEstado2="Deshabilitar";
							$mensajeEstado3="DESHABILITO";
						} else {
							$mensajeEstado="Habilitados";
							$mensajeEstado2="Habilitar";
							$mensajeEstado3="HABILITO";
						}
						$modulo->__SET('id',          $_POST['id']);
						$modulo->__SET('estado',       $estado);						
						$resultadoModeloEstado = $modModulo->cambiarEstado($modulo);
						if ($resultadoModeloEstado===1) {

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Modulo ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el modulo",
												'detalles' => $resultadoModeloEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modModulo->consultar($id);
						if ($resultados!="") {
								$datos = $resultados;			
							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el modulo con la id: ".$id,
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
						$num_filas = $modModulo->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modModulo->Listar($filtro, $empezar_desde, $tamagno_paginas);
						$pagAnterior=$pagina - 1;
						$pagSiguiente = $pagina +1;
						$datos = [	
										'controlError' => 0,						
										'resultados' => $resultados,
										'pagAnterior' => $pagAnterior,
										'pagSiguiente' => $pagSiguiente,
										'pagActual' => $pagina,
										'total_paginas' => $total_paginas,
										//'BORRAR_tamanopaginas' => $tamagno_paginas,
										//'BORRAR_num_filas' => $num_filas,
								];
						if ($resultados===0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la id: ".$filtro,
												'detalles' => "No Hay modulo registrado",												
											);										
						}

						break;	
					default:

						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>