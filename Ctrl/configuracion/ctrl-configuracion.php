<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-configuracion/entidad-configuracion.php';
		require_once '../../Mod/configuracion/mod-configuracion/mod-configuracion.php';		
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
		$configuracion = new configuracion();
		$modConfiguracion = new modConfiguracion();	
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
						
						$formatoValido = 0;
						$archivoCargado = 0;
						$sinFoto=$_POST['sinFoto'];
						if ($sinFoto==0) {
							if (is_uploaded_file($_FILES["fotografia"]["tmp_name"])) {
								$archivoCargado=1;
							}
						    if (
						    	$_FILES["fotografia"]["type"]=="image/jpeg"  || 
						    	$_FILES["fotografia"]["type"]=="image/pjpeg" || 
						    	$_FILES["fotografia"]["type"]=="image/png"	
						        )
						    {
								$formatoValido = 1;
						    }
						} 


						if ($archivoCargado==1 || $sinFoto==1)
						{
						    if (
						    	$formatoValido==1 || 
						    	$sinFoto==1
						    	)
						    {

								$id=$_POST['id'];

								$resultados = $modConfiguracion->consultar($id);
								if ($resultados!="") {

									/***********************EDITAR*************************/
									$configuracion->__SET('id',          $id);							
									$configuracion->__SET('nombre',      $_POST['nombre']);
									if($sinFoto==0){					
										//Con logo
										$configuracion->__SET('formato_logo',      $_FILES["fotografia"]["type"]);
										$configuracion->__SET('logo',    file_get_contents($_FILES["fotografia"]["tmp_name"]));
									}

									$resultado = $modConfiguracion->editar($configuracion,$sinFoto);

									if ($resultado===1) {

										$IP=$_POST['ip_cliente'];
										$IDUSUARIO=$_POST['id_usuario'];								
										$datos[] = array(
															'controlError' => 0,
															'mensaje' => "¡ Datos editados con Exito!",
															'detalles' => " configuracion editada correctamente ",												
														);								
									}else{
										$datos[] = array(
															'controlError' => 3,
															'mensaje' => "Error al editar la configuracion",
															'detalles' => $resultado,												
														);
									}

									/**********************************************************/		
								} elseif($resultados===0) {
									/**********************GUARDAR***********************/

									$configuracion->__SET('nombre',       $_POST['nombre']);
									$configuracion->__SET('formato_logo',      $_FILES["fotografia"]["type"]);
									$configuracion->__SET('logo',    file_get_contents($_FILES["fotografia"]["tmp_name"]));

									$resultado = $modConfiguracion->guardar($configuracion);

									if ($resultado===1) {

										$IP=$_POST['ip_cliente'];
										$IDUSUARIO=$_POST['id_usuario'];								
										$datos[] = array(
															'controlError' => 0,
															'mensaje' => "¡Datos Guardados con Exito!",
															'detalles' => " configuracion Guardada correctamente ",												
														);								
									} else {
										$datos[] = array(
															'controlError' => 1,
															'mensaje' => "Error al Guardar la configuracion",
															'detalles' => $resultado,												
														);
									}
									/**********************************************************/	
								}else{
									$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al consultar la configuracion",
														'detalles' => $resultados,												
													);							
								}
							}else{
								$datos[] = array(
													'controlError' => 6,
													'mensaje' => "Formato de archivo no valido",
													'detalles' => "Formato de archivo no es permitido",												
												);								
							}	
						}else{
								$datos[] = array(
													'controlError' => 6,
													'mensaje' => "Fotografia no subida",
													'detalles' => "Error al subir fotografia a los archivos temporales",												
												);
						}       


						break;
					default:
						$sinid=99999;
						$resultados = $modConfiguracion->consultar($sinid);
						if ($resultados!="") {
							$datos[] = array(
										   		'id' => $resultados->id,
											    'nombre' => utf8_encode($resultados->nombre),
												'formato_logo' => $resultados->formato_logo,
												'logo' => $resultados->logo 												
											);								
							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe configuracion ",
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la configuracion",
													'detalles' => $resultados,												
												);							
							}

						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>