<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-usuario/entidad-usuario.php';
		require_once '../../Mod/configuracion/mod-usuario/mod-usuario.php';		
	  	require_once '../../Mod/configuracion/mod-persona/entidad-persona-departamento.php';
	  	require_once '../../Mod/configuracion/mod-persona/entidad-persona.php';
		require_once '../../Mod/configuracion/mod-persona/mod-persona.php';
		//
	  	require_once '../../Mod/utilidades/mod-bitacora.php';
		require_once '../../vendor/autoload.php';	  	
	  	require_once '../utilidades/ctrl-encrypt.php';
		//
		/*
			error = 0 : Es EXITO
			error = 1 : error al guardar
			error = 2 : error al consultar						
			error = 3 : error al editar						
			error = 4 : error al cambiar Estado						
			error = 5 : error al listar
			error = 6 : ya hay una persona a cargo del departamento					

		*/
		//Se declara que esta es una aplicacion que genera un JSON
		header('Content-type: application/json');//Cuandose use JSON
		//Se abre el acceso a las conexiones que requieran de esta aplicacion
		header("Access-Control-Allow-Origin: *");	

		$datos= array();

		$usuario = new usuario();
		$persona = new persona();
		$modUsuario = new modUsuario();
		$modPersona = new modPersona();	
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

								$resultados = $modPersona->consultar($id);
								if ($resultados!="" && $id!=0) {

									/***********************EDITAR*************************/
									$persona->__SET('id',          $id);							
									$persona->__SET('cedula',      $_POST['cedula']);
									$persona->__SET('nombre',      utf8_decode($_POST['nombre']));
									$persona->__SET('apellido',    utf8_decode($_POST['apellido']));
									$persona->__SET('correo_electronico',    utf8_decode($_POST['correo']));

									if($sinFoto==0){					
										//Con foto
										$persona->__SET('formato_foto',      $_FILES["fotografia"]["type"]);
										$persona->__SET('foto',    file_get_contents($_FILES["fotografia"]["tmp_name"]));
									}
									$persona->__SET('id_usuario',  $usuario);

									$resultado = $modPersona->editar($persona,$sinFoto);


									if ($resultado>0) {

										$persona->__GET('id_usuario')->__SET('id',     $resultados->id_usuario->__GET('id'));
										$persona->__GET('id_usuario')->__SET('usuario',          $_POST['usuario']);
										//Encriptando contraseña
										$contrasena =  blickyerSIGMANSTEC::set([
														'contrasena' => $_POST['contrasena'],
												 ]);
										$persona->__GET('id_usuario')->__SET('contrasena',      $contrasena);
										$persona->__GET('id_usuario')->__SET('id_perfil',       $_POST['perfil']);


										$resultadoUsuario =$modUsuario->editar($persona->__GET('id_usuario'));

										if ($resultadoUsuario>0) {

											$IP=$_POST['ip_cliente'];
											$IDUSUARIO=$_POST['id_usuario'];								
											$modBitacora->guardarOperacion(' EDITO UNA PERSONA',$IP,$IDUSUARIO);	

											$datos[] = array(
																'controlError' => 0,
																'mensaje' => "¡ Datos editados con Exito!",
																'detalles' => " Persona y Usuario editados correctamente ",
															);								
										} else {
											$datos[] = array(
																'controlError' => 3,
																'mensaje' => "Error al modificar el usuario",
																'detalles' => $resultadoUsuario,												
														
															);
										}
									}else{
										$datos[] = array(
															'controlError' => 3,
															'mensaje' => "Error al modificar la persona",
															'detalles' => $resultado,												
														);
									}

									/**********************************************************/		
								} elseif($id==0 || $resultados=="") {
									/**********************GUARDAR***********************/
									$persona->__SET('id_usuario',          $usuario);
									$persona->__GET('id_usuario')->__SET('usuario',          $_POST['usuario']);

									//Encriptando contraseña
									$contrasena =  blickyerSIGMANSTEC::set([
													'contrasena' => $_POST['contrasena'],
											 ]);
									$persona->__GET('id_usuario')->__SET('contrasena',      $contrasena);
									$persona->__GET('id_usuario')->__SET('id_perfil',       $_POST['perfil']);


									$resultadoUsuario =$modUsuario->guardar($persona->__GET('id_usuario'));

									if ($resultadoUsuario>0) {

										if(isset($_FILES["fotografia"]["type"])){
											$type = $_FILES["fotografia"]["type"];
											$tmp_name = file_get_contents($_FILES["fotografia"]["tmp_name"]);
										}else{
											$type="";
											$tmp_name="";
										}
										$persona->__SET('cedula',          		$_POST['cedula']);
										$persona->__SET('nombre',      			utf8_decode($_POST['nombre']));
										$persona->__SET('apellido',    			utf8_decode($_POST['apellido']));
										$persona->__SET('correo_electronico',   utf8_decode($_POST['correo']));	
										$persona->__SET('formato_foto',   		$type);
										$persona->__SET('foto',    				$tmp_name);
										$persona->__SET('id_usuario',           $resultadoUsuario);									
										$resultado = $modPersona->guardar($persona);

										if ($resultado>0) {

											$IP=$_POST['ip_cliente'];
											$IDUSUARIO=$_POST['id_usuario'];								
											$modBitacora->guardarOperacion(' GUARDO UNA PERSONA',$IP,$IDUSUARIO);	

											$datos[] = array(
																'controlError' => 0,
																'mensaje' => "¡Datos Guardados con Exito!",
																'detalles' => " Persona y Usuario Guardados correctamente ",												
															);								
										} else {
											$datos[] = array(
																'controlError' => 1,
																'mensaje' => "Error al Guardar la persona",
																'detalles' => $resultado,												
															);
										}
									}else{
										$datos[] = array(
															'controlError' => 1,
															'mensaje' => "Error al Guardar el usuario",
															'detalles' => $resultadoUsuario,												
														);
									}

									/**********************************************************/	
								}else{
									$datos[] = array(
														'controlError' => 1,
														'mensaje' => "Error al consultar  ",
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
						$persona->__SET('id',          $_POST['id']);
						$persona->__SET('estado',       $estado);						
						$persona->__SET('id_usuario',          $usuario);

						$resultadoPersonaEstado = $modPersona->cambiarEstado($persona);
						if ($resultadoPersonaEstado===1) {

							$persona->__GET('id_usuario')->__SET('id',     $_POST['id_usuario']);
							$persona->__GET('id_usuario')->__SET('estado',          $estado);

							$resultadoUsuario =$modUsuario->cambiarEstado($persona->__GET('id_usuario'));
							if ($resultadoUsuario===1) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion($mensajeEstado3.' UNA PERSONA',$IP,$IDUSUARIO);	

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Persona y Usuario ".$mensajeEstado." correctamente ",												
												);								
							} else {
								$datos[] = array(
													'controlError' => 4,
													'mensaje' => "Error al ".$mensajeEstado2." el usuario",
													'detalles' => $resultadoUsuario,												
												);
							}
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." la persona",
												'detalles' => $resultadoPersonaEstado,												
											);
						}


						break;
					case 'consultar':
						$id=$_POST['id'];

						$resultados = $modPersona->consultar($id);




							if ($resultados!="") {

								$tokenContrasena = $resultados->id_usuario->__GET('contrasena');
								if (blickyerSIGMANSTEC::Check($tokenContrasena)) {
									$contrasena = blickyerSIGMANSTEC::get($tokenContrasena);
			
									$datos[] = array(
													'id' => $resultados->id,
													'cedula' => $resultados->cedula,
													'nombre' => utf8_encode($resultados->nombre),
								/*acomodar el formato */'apellido' => utf8_encode($resultados->apellido),
								/*acomodar el formato */'correo' => utf8_encode($resultados->correo_electronico),													
													'formato_foto' => $resultados->formato_foto,
													'foto' => $resultados->foto,													
													'estadoPerona' => $resultados->estado,
													'idUsuario' => $resultados->id_usuario->__GET('id'),
													'usuario' => $resultados->id_usuario->__GET('usuario'),
													'contrasena' => $contrasena->contrasena,
													'id_perfil' => $resultados->id_usuario->__GET('id_perfil'),					
													'estadoUsuario' => $resultados->id_usuario->__GET('estado'),
													);								
								}else{

									$datos[] = array(
													'id' => $resultados->id,
													'cedula' => $resultados->cedula,
													'nombre' => utf8_encode($resultados->nombre),
								/*acomodar el formato */'apellido' => utf8_encode($resultados->apellido),
								/*acomodar el formato */'correo' => utf8_encode($resultados->correo_electronico),													
													'formato_foto' => $resultados->formato_foto,
													'foto' => $resultados->foto,													
													'estadoPerona' => $resultados->estado,
													'idUsuario' => $resultados->id_usuario->__GET('id'),
													'usuario' => $resultados->id_usuario->__GET('usuario'),
													'contrasena' => '',
													'id_perfil' => $resultados->id_usuario->__GET('id_perfil'),					
													'estadoUsuario' => $resultados->id_usuario->__GET('estado'),
													);										
								}
								
							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe la persona : ",
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la persona",
													'detalles' => $resultados,												
												);							
							}

						break;				
					case 'FiltrarLista':
						
// INICIO CAlCULAR VARIABLES
						$filtro=(isset($_POST['filtro']))? $_POST['filtro'] : "" ;

						$tamagno_paginas=$_POST['tamagno_paginas'];
						//$tamagno_paginas=3;

						if ($_POST['pagina']!=1) {
							
							$pagina=$_POST['pagina'];
						
						}else{
							$pagina=1;
						}			

						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modPersona->getTotalPaginas($filtro,$getTotalPaginas);

						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4

// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modPersona->Listar($filtro, $empezar_desde, $tamagno_paginas);

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
												'mensaje' => "Error al consultar la cedula: ".$filtro,
												'detalles' => "No Hay Persona registrada",												
											);										
						}
						break;	
					default:

						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>