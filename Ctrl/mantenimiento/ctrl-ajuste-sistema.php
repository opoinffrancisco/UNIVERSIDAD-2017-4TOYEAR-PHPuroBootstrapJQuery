<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/mantenimiento/mod-ajuste-sistema/entidad-ajuste-sistema.php';
		require_once '../../Mod/mantenimiento/mod-ajuste-sistema/mod-ajuste-sistema.php';		
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
		$ajuste_sistema = new ajuste_sistema();
		$modAjusteSistema = new modAjusteSistema();	
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


						$id=$_POST['id'];

						$resultados = $modAjusteSistema->consultar($id);
						if ($resultados!="") {

							/***********************EDITAR*************************/
							$ajuste_sistema->__SET('id',          $id);					
							$ajuste_sistema->__SET('frecuencia_suspension', $_POST['frecuencia_suspension']);							
							$ajuste_sistema->__SET('dias_proximidad_tarea', $_POST['dias_proximidad_tarea']);							
						
							$resultado = $modAjusteSistema->editar($ajuste_sistema);

							if ($resultado>0) {
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " ajuste de sistema editada correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al editar el ajuste de sistema",
													'detalles' => $resultado,												
												);
							}

							/**********************************************************/		
						} elseif($resultados===0) {
							/**********************GUARDAR***********************/

							$ajuste_sistema->__SET('frecuencia_suspension', $_POST['frecuencia_suspension']);							
							$ajuste_sistema->__SET('dias_proximidad_tarea', $_POST['dias_proximidad_tarea']);							

							$resultado = $modAjusteSistema->guardar($ajuste_sistema);

							if ($resultado>0) {
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " ajuste de sistema Guardada correctamente ",												
												);								
							} else {
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el ajuste de sistema",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/	
						}else{
							$datos[] = array(
												'controlError' => 1,
												'mensaje' => "Error al consultar el ajuste de sistema",
												'detalles' => $resultados,												
											);							
						}
				

						break;
					default:
						$resultados = $modAjusteSistema->consultar();

						if ($resultados!="") {

							$datos[] = array(
										   		'id' => $resultados->id,
										   		'frecuencia_suspension' => $resultados->frecuencia_suspension,
										   		'dias_proximidad_tarea' => $resultados->dias_proximidad_tarea,										   		
											);								
							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe ajuste de sistema ",
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar el ajuste de sistema",
													'detalles' => $resultados,												
												);							
							}

						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>