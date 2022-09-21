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
	  	require_once '../../../Mod/configuracion/mod-c-software/entidad-c-software.php';
		require_once '../../../Mod/configuracion/mod-c-software/mod-c-software.php';		
		//
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

		$equipo_software = new equipo_software(); 			
		$modSoftware = new modSoftware();	

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

							$seriales = json_decode($_POST['seriales']);
							$seriales_bn = json_decode($_POST['seriales_bn']);

							$contando=0;	
							$idsRegistrados=[];											
							if($seriales>0){ 
								foreach ($seriales as $serial => $serialVal) {
									$equipo = new equipo(); 			
									$equipo->__SET('serial', $serialVal);
									$equipo->__SET('serial_bn', $seriales_bn[$contando]);
									$equipo->__SET('id_c_fisc_eq', $_POST['id_caracteristicas']);
									$idsRegistrados[]=$modEquipo->guardar($equipo);
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
								$modBitacora->guardarOperacion('AGREGO '.$contando.' EQUIPO/OS',$IP,$IDUSUARIO);	

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
					case 'editarSerialesEQERIFCOMPP':
	
							$id_control = $_POST['id_control'];
							$campo_control = $_POST['campo_control'];

							$serial = $_POST['serial'];
							$serial_bn = $_POST['serial_bn'];

							$resultado = $modEquipo->editarSerialesEQERIFCOMPP($id_control, $campo_control, $serial, $serial_bn );

							if ($resultado>0) {
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
					case 'anadirComponente':
						
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
							$equipo_componente->__SET('id_equipo', $_POST['idequipo']);
							$equipo_componente->__SET('id_componente', $idsRegistrado);
							$idAnadido=$modEquipo->anadirComponente($equipo_componente);
							if ($idAnadido>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('AÑADIO UN COMPONENTE A UN EQUIPO',$IP,$IDUSUARIO);	

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
					break;
					case 'anadirPeriferico':
						
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
							$equipo_periferico->__SET('id_equipo', $_POST['idequipo']);
							$equipo_periferico->__SET('id_periferico', $idsRegistrado);
							$idAnadido=$modEquipo->anadirPeriferico($equipo_periferico);
							if ($idAnadido>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('AÑADIO UN PERIFERICO A UN EQUIPO',$IP,$IDUSUARIO);	

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
					break;
					case 'anadirSoftware':
						

							$equipo_software->__SET('id_equipo', $_POST['idequipo']);
							$equipo_software->__SET('id_software', $_POST['id_software']);
							// verificando existencia en equipo, del nuevo software que se añadira
							$resultado = $modSoftware->verificarExistenciaAnadida($_POST['idequipo'], $_POST['id_software']);
							
							if ($resultado==0) {
								$idAnadido=$modEquipo->anadirSoftware($equipo_software);
								if ($idAnadido>0) {

									$IP=$_POST['ip_cliente'];
									$IDUSUARIO=$_POST['id_usuario'];								
									$modBitacora->guardarOperacion('AÑADIO UN SOFTWARE A UN EQUIPO',$IP,$IDUSUARIO);	

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
												'controlError' => 2,
												'mensaje' => "EL software esta actualmente en uso por el equipo",
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
						if ($estado===0) {
							$mensajeEstado="DESINCORPORO";
						} else {
							$mensajeEstado="INCORPORO";
						}
						$equipo->__SET('id',          $_POST['id']);
						$equipo->__SET('estado',       $estado);						
						$resultadoDepartamentoEstado = $modEquipo->cambiarEstado($equipo);
						if ($resultadoDepartamentoEstado===1) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion($mensajeEstado.' UN EQUIPO',$IP,$IDUSUARIO);	


							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Componente ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado." el componente",
												'detalles' => $resultadoDepartamentoEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modEquipo->consultar($id);
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
					case 'consultarCaractEqu':

						$id=$_POST['id'];						
						$resultados = $modEquipo->consultarCaractEqu($id);
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
					case 'consultarCaracteristSoft':


						$id=$_POST['id'];						
						$resultados = $modEquipo->consultarCaracteristSoft($id);
						if ($resultados!="") {
							$datos[] = array(
											'controlError' => 0,
											'resultado' => $resultados,
											);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No Hay software registrado con la id: ".$id,
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
						$num_filas = $modEquipo->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modEquipo->Listar($filtro, $empezar_desde, $tamagno_paginas);
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
						case 'cargarListaPerifericosEquipo':
						
						// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['id_equipo'])  ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}							
						$id_equipo=$_POST['id_equipo'];
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modEquipo->getTotalPaginasPerifericosEquipo($id_equipo,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modEquipo->cargarListaPerifericosEquipo($id_equipo, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al consultar la id: ".$id_equipo,
												'detalles' => "No Hay periferico añadido",												
											);										
						}

						break;		
						case 'cargarListaComponentesEquipo':
						
						// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['id_equipo'])  ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}	
						$id_equipo=$_POST['id_equipo'];
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modEquipo->getTotalPaginasComponentesEquipo($id_equipo,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modEquipo->cargarListaComponentesEquipo($id_equipo, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al consultar la id: ".$id_equipo,
												'detalles' => "No hay componente añadido",												
											);										
						}

						break;
						case 'cargarListaSoftwareEquipo':
						
						// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['id_equipo'])  ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}						
						$id_equipo=$_POST['id_equipo'];
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modEquipo->getTotalPaginasSoftwareEquipo($id_equipo,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES
						$getTotalPaginas=0;
						$resultados = $modEquipo->cargarListaSoftwareEquipo($id_equipo, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al consultar la id: ".$id_equipo,
												'detalles' => "No hy software añadido",												
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
							$num_filas = $modEquipo->getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$getTotalPaginas);
							$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
							// FIN CAlCULAR VARIABLES

							$getTotalPaginas=0;
							$resultados = $modEquipo->ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $empezar_desde, $tamagno_paginas);
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
													'detalles' => "No hay componente registrado",												
												);										
							}

						break;		

						default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>