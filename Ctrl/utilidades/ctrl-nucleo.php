<?php
		require_once '../../Mod/conexion.php';
		require_once '../../Mod/utilidades/mod-nucleo/entidad-nucleo.php';
		require_once '../../Mod/utilidades/mod-nucleo/mod-nucleo.php';			
		require_once '../../Mod/configuracion/mod-persona/entidad-persona.php';
		require_once '../../Mod/configuracion/mod-usuario/entidad-usuario.php';
		require_once '../../Mod/configuracion/mod-pn-perfil/entidad-pn-perfil.php';
		//--
		require_once '../../Mod/utilidades/mod-bitacora.php';
		//
		require_once '../../Mod/procesos/mantenimiento-equipo/mod-mantenimiento-equipo/entidad-mantenimiento.php';
		require_once '../../Mod/utilidades/mod-persona-ejecuta/entidad-persona-ejecuta.php';
		require_once '../../Mod/utilidades/mod-persona-ejecuta/mod-persona-ejecuta.php';		
		//--
		require_once '../../vendor/autoload.php';
		require_once 'ctrl-autenticacion.php';
	  	require_once 'ctrl-encrypt.php';
		/*
			error = 0 : Es EXITO
		*/
		// MalWared

		$datos = array();
		$datosNucleo = [];
		$nucleo = new nucleo();
		$usuario = new usuario();
		$persona = new persona();		
		$modNucleo = new modNucleo();
		//
		$modBitacora = new modBitacora();		
		//
		$mantenimiento = new mantenimiento();
		$personaEjecuta = new personaEjecuta();		
		$modPersonaEjecuta = new modPersonaEjecuta();
		//
		if(isset($_POST['accionNucleo']))
		{
			$accionNucleo=$_POST['accionNucleo'];
			//Se declara que esta es una aplicacion que genera un JSON
			header('Content-type: application/json');//Cuandose use JSON
			//Se abre el acceso a las conexiones que requieran de esta aplicacion
			header("Access-Control-Allow-Origin: *");	

		}
		if(isset($_GET['accionNucleo']))
		{
			$accionNucleo=$_GET['accionNucleo'];
		}


		//$accionNucleo="generarReporte";
		if(isset($accionNucleo))
		{
			switch($accionNucleo)
			{
				case 'iniciarSesion':
				
						$nombreUsuario = $_POST['usuario'];
						$contrasena =  blickyerSIGMANSTEC::set([
													'contrasena' => $_POST['contrasena'],
											 ]);

						$resultados    = $modNucleo->verificarExistencia('cfg_pn_usuario', 'usuario', $nombreUsuario);
						if($resultados==1){


							$resultadosVIS = $modNucleo->verificarInicioSesion($nombreUsuario, $contrasena);
							if($resultadosVIS==1){	

								$resultadosEstU = $modNucleo->verificarEstadoUsuario($nombreUsuario, $contrasena);							
								if ($resultadosEstU==1) {				   

								$resultadosDatosUmod    = $modNucleo->obtenerDatosUsuario($nombreUsuario);


								$IDUSUARIO = $resultadosDatosUmod->id_usuario->__GET('id');

			
								$resultadosDatosUctrl = [
													   		'id_persona' => $resultadosDatosUmod->id_persona,
													   		'cedula' => $resultadosDatosUmod->cedula,
														    'nombre' => utf8_encode($resultadosDatosUmod->nombre),
														    'apellido' => utf8_encode($resultadosDatosUmod->apellido),
																		'tipo_foto' => $resultadosDatosUmod->formato_foto, // LUEGO ADACTAR DE TIPO A FORMATO
																		//'foto' => $resultadosDatosUmod->foto,													
													   		'estadoPerona' => $resultadosDatosUmod->estado,
													   		'idUsuario' => $IDUSUARIO,
													   		'usuario' => $resultadosDatosUmod->id_usuario->__GET('usuario'),
														    'id_perfil' => $resultadosDatosUmod->id_usuario->__GET('id_perfil')->__GET('id'),												    
														    'nombrePerfil' => $resultadosDatosUmod->id_usuario->__GET('id_perfil')->__GET('nombre'),												    
														    'estadoUsuario' => $resultadosDatosUmod->id_usuario->__GET('estado'),
														];								
								$resultadosPermisosU    = $modNucleo->obtenerPermisosUsuario($nombreUsuario);
								
								///////////////////////////////////////////////////////////
								$token = Auth::SignIn([
														'controlError' => 0,						
														'resultadosDatos' => $resultadosDatosUctrl,
														'resultadosPermisos' => $resultadosPermisosU,
												 ]);
								//////////////////////////////////////////////////////////

								$IP=$_POST['ip_cliente'];
								$modBitacora->guardarOperacion('INICIO DE SESION',$IP,$IDUSUARIO);	

								////////////////////////////////////////////////////////////
								$datosNucleo   = [
													'controlError' => 0,						
													'resultadosDatos' => $resultadosDatosUctrl,
													'resultadosPermisos' => $resultadosPermisosU,
													'token' => $token,
												 ];	

								} else {
									$datosNucleo   = [
														'controlError' => 3,						
														'resultados' => 'Cuenta desactivada',
													 ];	
								}


							}else{
								$datosNucleo   = [
													'controlError' => 2,						
													'resultados' => 'Contraseña Incorrecta',
												 ];	
							}				

									
						}else{
							
							$datosNucleo   = [
												'controlError' => 1,						
												'resultados' => 'Usuario no existe',
											 ];					

						}	
				break;
				case 'continuarSesion':
				
						$nombreUsuario = $_POST['usuario'];
						$contrasena =  blickyerSIGMANSTEC::set([
													'contrasena' => $_POST['contrasena'],
											 ]);

							$resultadosVIS = $modNucleo->verificarInicioSesion($nombreUsuario, $contrasena);
							if($resultadosVIS==1){	

								$resultadosEstU = $modNucleo->verificarEstadoUsuario($nombreUsuario, $contrasena);							
								if ($resultadosEstU==1) {				   

									$datosNucleo   = [
														'controlError' => 0,						
														'resultados' => "Contraseña valida",
													 ];	

								} else {
									$datosNucleo   = [
														'controlError' => 3,						
														'resultados' => 'Cuenta desactivada',
													 ];	
								}


							}else{
								$datosNucleo   = [
													'controlError' => 2,						
													'resultados' => 'Contraseña Incorrecta',
												 ];	
							}											
				break;
				case 'cerrarSesion':

									$IP=$_POST['ip_cliente'];
									$IDUSUARIO=$_POST['id_usuario'];

									$modBitacora->guardarOperacion('CIERRE DE SESION',$IP,$IDUSUARIO);	

									$datosNucleo = array(
												'controlError' => 0,
												'mensaje' => "",
												'detalles' => "",
									);
				break;					
				case 'verificarToken':

					// esta el token.?
					if (isset($_POST['token']) || !empty($token)) {

						$token = $_POST['token'];

						if (Auth::Check($token)==0) {


						$datos = Auth::GetData($token);

						$datosNucleo = [
										'controlError' =>0,						
										'datosSesion' => $datos,
								];	

						}else{

							$datosNucleo = [
											'controlError' =>2,						
											'detalles' => 'La sesion fue iniciada en otro dispositivo',
									];	

						}
					}else{
					
							$datosNucleo = [
										'controlError' => 1,						
										'detalles' => ' Token no detectado ',
								];		

					}

					break;
				case 'verificarExistencia':
				
						$tabla = $_POST['tabla'];
						$filtro =  $_POST['filtro'];
						$columna = $_POST['columna'];
						$id = $_POST['id'];
						if ($id==0) {
							$resultados = $modNucleo->verificarExistencia($tabla, $columna, $filtro);
						}else{
							$resultados = $modNucleo->verificarExistenciaConId($tabla, $columna, $filtro,$id);
						}

						$datosNucleo = [
										'controlError' => 0,						
										'resultados' => $resultados,
										'$filtro' => $filtro,
								];					
				break;	
				case 'verificarExistenciaSelect':
				
						$datos = $_POST['datos'];
						$datos = json_decode($datos, true);

						$id = $_POST['id'];
						if ($id==0) {
							$resultados = $modNucleo->verificarExistenciaSelect($datos);
						}else{
							$resultados = $modNucleo->verificarExistenciaSelectConId($datos, $id);
						}

						$datosNucleo = [
											'controlError' => 0,							
											'resultados' => $resultados,
						];	
				break;						
				case 'cargarListaDespegable':
						if (!isset($_POST['tabla'])  ) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar dato de control ",
												'detalles' => "No se encuentra el dato",												
											);
							break;	
						}	

						$tabla = $_POST['tabla'];

						$resultados = $modNucleo->cargarListar($tabla);

						$datosNucleo = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];

						if ($resultados===0) {
							$datosNucleo = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la tabla : ".$tabla,
												'detalles' => "No Hay datos en la tabla",												
											);										
						}
				break;	
				case 'cargarListaDespegableUtf8Encode':
						if (!isset($_POST['tabla'])  ) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar dato de control ",
												'detalles' => "No se encuentra el dato",												
											);
							break;	
						}	

						$tabla = $_POST['tabla'];

						$resultados = $modNucleo->cargarListarUtf8Encode($tabla);

						$datosNucleo = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];

						if ($resultados===0) {
							$datosNucleo = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la tabla : ".$tabla,
												'detalles' => "No Hay datos en la tabla",												
											);										
						}
				break;	
				case 'cargarListaDespegableAnidada':
						if (!isset($_POST['tabla']) ||
										!isset($_POST['columna']) ||
										!isset($_POST['id_filtro']) ) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}	

						$tabla = $_POST['tabla'];
						$columna = $_POST['columna'];
						$id_filtro = $_POST['id_filtro'];
						$resultados = $modNucleo->cargarListarAnidada($tabla,$columna,$id_filtro);

						$datosNucleo = [	
										'controlError' => 0,						
										'resultados' => $resultados,
								];

						if ($resultados===0) {
							$datosNucleo = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar la tabla : ".$tabla,
												'detalles' => "No Hay datos en la tabla",												
											);										
						}
				break;						
				case 'actualizarContadorSuspension':


									$resultados = $modNucleo->consultarContadorSuspension();
									if ($resultados>0) {
										$datosNucleo[] = array(
																'controlError' => 0,														   		
														  'frecuencia_suspension' => $resultados,
															);				

										}else{
											$datosNucleo[] = array(
																'controlError' => 1,										
															);							
										}
				break;					
				case 'guardarBitacora':
								/**********************GUARDAR***********************/

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$operacion  = utf8_decode($_POST['operacion']);

							 $resultado =	$modBitacora->guardarOperacion($operacion,$IP,$IDUSUARIO);	
								if ($resultado>0) {


								$datosNucleo[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Datos guardados en bitacora correctamente ",												
												);								
								}else{
									$datosNucleo[] = array(
														'controlError' => 1,
														'mensaje' => "Error al Guardar en la bitacora",
														'detalles' => $resultado,												
													);
								}
				break;	
				case 'guardarPersonaEjecuta':
					/**********************GUARDAR***********************/


					$mantenimiento->__SET('estado', 				$_POST['estado']);
					$mantenimiento->__SET('id_tipo_mant', 			$_POST['id_tipo_mant']);
					$mantenimiento->__SET('id_tarea_equipo', 		$_POST['id_tarea_equipo']);
					$mantenimiento->__SET('id_solicitud', 				$_POST['id_solicitud']);
					$mantenimiento->__SET('observacion', 				$_POST['observacion']);
					
					$resultadoId_mantenimiento = $modPersonaEjecuta->guardoMant($mantenimiento);

					if ($resultadoId_mantenimiento>0) {

						$detalles  = utf8_decode($_POST['detalles']);
						$id_persona=$_POST['id_persona'];								
						$id_funcion_persona=$_POST['id_funcion_persona'];		

					 	$resultado =	$modPersonaEjecuta->guardarPersonaEjecuta(
					 												$detalles,
					 												$id_persona,
					 												$id_funcion_persona,
					 												$resultadoId_mantenimiento
					 										);	
						if ($resultado>0) {
							$datosNucleo[] = array(
												'controlError' => 0,
												'mensaje' => "¡Datos Guardados con Exito!",
												'detalles' => " Datos de lo ejecutado por la persona, guardados correctamente ",
											);								
						}else{
							$datosNucleo[] = array(
												'controlError' => 1,
												'mensaje' => "Error al guardar datos de lo ejecutado por la persona",
												'detalles' => $resultado,												
											);
						}
					}else{
						$datosNucleo[] = array(
												'controlError' => 1,
												'mensaje' => "Error al guardar datos en la accion de mantenimiento",
												'detalles' => $resultado,												
						);
					}
				break;
				case 'guardarPersonaEjecutaTareaP':
					/**********************GUARDAR***********************/

					$detalles  = utf8_decode($_POST['detalles']);
					$id_persona=$_POST['id_persona'];								
					$id_funcion_persona=$_POST['id_funcion_persona'];		
					$id_mantenimiento=$_POST['id_mantenimiento'];

				 	$resultado =	$modPersonaEjecuta->guardarPersonaEjecuta(
				 												$detalles,
				 												$id_persona,
				 												$id_funcion_persona,
				 												$id_mantenimiento
				 										);	
					if ($resultado>0) {
						$datosNucleo[] = array(
											'controlError' => 0,
											'mensaje' => "¡Datos Guardados con Exito!",
											'detalles' => " Datos de lo ejecutado por la persona, guardados correctamente ",
										);								
					}else{
						$datosNucleo[] = array(
											'controlError' => 1,
											'mensaje' => "Error al guardar datos de lo ejecutado por la persona",
											'detalles' => $resultado,												
										);
					}
				break;									
				case 'encriptarDatosRPT':
						
						$datos = "";
						if (isset($_POST['cant_datos'])){ 

							switch ($_POST['cant_datos']) {
								case '1':

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'tabla' => $_POST['tabla'],
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'campo_1' => $_POST['campo_1'],
										 ]);							

									break;
								case '2':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],																						
										 ]);	
									}
									

									break;
								case '3':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
 										'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
										 ]);	
									}
														
										break;
								case '4':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
										 ]);	
									}
														
										break;										
							default:	
									break;
							}
						}


						$datosNucleo[] = array(
							'datos' => $datos,												
						);
				break;		
				case 'encriptarDatosRPTyGraficos':
						
						$datos = "";


						if (isset($_POST['cant_datos'])){ 
						
							//----
							$img_grafico_id_temp = $_POST['img_grafico_id_temp'];
							// -> Se guarda la imagen en la variable temporal del cliente
							$_SESSION[$img_grafico_id_temp] = $_POST['img_grafico'];
							//----

							switch ($_POST['cant_datos']) {
								case '1':

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,
											'tabla' => $_POST['tabla'],
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'campo_1' => $_POST['campo_1'],
										 ]);							

									break;
								case '2':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],																						
										 ]);	
									}
									

									break;
								case '3':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
 											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
										 ]);	
									}
														
										break;
								case '4':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
 											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],											
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
										 ]);	
									}
														
										break;										
							default:	
								case '5':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'dato_5' => $_POST['dato_5'],											
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
											'campo_5' => $_POST['campo_5'],
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'dato_5' => $_POST['dato_5'],											
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
											'campo_5' => $_POST['campo_5'],
										 ]);	
									}
														
										break;										
									case '6':

									if ($_POST['cant_datosbd']==1) {

										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datos' => $_POST['cant_datos'],
											'tabla' => $_POST['tabla'],											
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'dato_5' => $_POST['dato_5'],	
											'dato_6' => $_POST['dato_6'],	
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
											'campo_5' => $_POST['campo_5'],
											'campo_6' => $_POST['campo_6'],											
										 ]);							

									} else {
										$datos =  blickyerSIGMANSTEC::set([
											'u' => $_POST['u'],
											'tt' => $_POST['tt'],
											'img_grafico_id_temp' => $img_grafico_id_temp,											
											'cant_datosbd' => $_POST['cant_datosbd'],											
											'tabla' => $_POST['tabla'],
											'trel' => $_POST['trel'],
											'rel1' => $_POST['rel1'],											
											'cant_datos' => $_POST['cant_datos'],
											'dato_1' => $_POST['dato_1'],
											'dato_2' => $_POST['dato_2'],
											'dato_3' => $_POST['dato_3'],
											'dato_4' => $_POST['dato_4'],
											'dato_5' => $_POST['dato_5'],	
											'dato_6' => $_POST['dato_6'],	
											'campo_1' => $_POST['campo_1'],
											'campo_2' => $_POST['campo_2'],											
											'campo_3' => $_POST['campo_3'],
											'campo_4' => $_POST['campo_4'],
											'campo_5' => $_POST['campo_5'],
											'campo_6' => $_POST['campo_6'],											
										 ]);	
									}
														
										break;
							default:	
									break;
							}
						}


						$datosNucleo[] = array(
							'datos' => $datos,												
						);
				break;																		
				default:	
				break;
			}
			echo '' . json_encode($datosNucleo) . '';	
		}
			
?>