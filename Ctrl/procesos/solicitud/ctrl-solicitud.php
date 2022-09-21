<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../../Mod/conexion.php';
		//----------------

		require_once '../../../Mod/procesos/solicitud/mod-solicitud/entidad-solt-respuesta.php';
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/entidad-solt-diagnostico.php';
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/entidad-solicitud.php';
		require_once '../../../Mod/procesos/solicitud/mod-solicitud/mod-solicitud.php';

		//----------------
	  	require_once '../../../Mod/utilidades/mod-bitacora.php';
	 	require_once '../../utilidades/ctrl-ortografia.php';
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


		$solicitud = new solicitud();
		$modSolicitud = new modSolicitud();
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
					case 'guardar':

							$solicitud->__SET('id_persona', 	 $_POST['id_persona']);
							$solicitud->__SET('id_cargo', 		 $_POST['id_cargo']);
							$solicitud->__SET('id_departamento', $_POST['id_departamento']);
							$solicitud->__SET('id_equipo', 		 $_POST['id_equipo']); 
							$solicitud->__SET('asunto', 		 $_POST['asunto']);
							$solicitud->__SET('descripcion', 	 $_POST['descripcion']);
							$resultado=$modSolicitud->guardar($solicitud);

							if ($resultado>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('REALIZO UNA SOLICITUD',$IP,$IDUSUARIO);	
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Solicitado correctamente ",		
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al solicitar",
												);
							}	
						
					break;
					case 'guardarConformidad':

							$id_solicitud= $_POST['id_solicitud'];
							$observacion= $_POST['observacion'];
							$conformidad= $_POST['conformidad'];
							if($conformidad>0){
								$mensaje="INFORMO QUE ESTA CONFORME CON UNA SOLICITUD";
							}else{
								$mensaje="INFORMO QUE ESTA INCONFORME CON UNA SOLICITUD - ( ".$observacion." ) ";
							}

							$resultado=$modSolicitud->guardarConformidad($id_solicitud, $observacion, $conformidad);

							if ($resultado>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion($mensaje,$IP,$IDUSUARIO);	
								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => $mensaje."correctamente ",		
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "ERROR CUANDO ".$mensaje,
												);
							}	
						
					break;					
					case 'consultar':

						$id_solicitud = $_POST['id_solicitud'];

						$resultados = $modSolicitud->consultar($id_solicitud);
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
					case 'cargarListaDepartamentoACargo':

						if (!isset($_POST['id_persona']) ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}

						$id_persona = $_POST['id_persona'];
						$resultados = $modSolicitud->cargarListaDepartamentoACargo($id_persona);

						$datos = [	
											'controlError' => 0,						
											'resultados' => $resultados,
										];
						if ($resultados==0) {
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al consultar el id : ".$id_persona,
												'detalles' => "No Hay datos en la tabla",												
											);										
						}
					break;							
					case 'cargarListaEquiposDepartamento':
						
// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['id_departamento']) ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$id_departamento	=	$_POST['id_departamento'];

						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modSolicitud->getTotalPaginasEquiposDepartamento($id_departamento, $getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modSolicitud->ListarEquiposDepartamento($id_departamento, $empezar_desde, $tamagno_paginas);
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
												'detalles' => "No hay equipo en el departamento",												
											);										
						}

					break;						
					case 'cargarListaEquiposPersona':
						
// INICIO CAlCULAR VARIABLES
						if (!isset($_POST['id_persona']) ) {
						
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						$id_persona	=	$_POST['id_persona'];

						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modSolicitud->getTotalPaginasEquiposPersona($id_persona, $getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modSolicitud->ListarEquiposPersona($id_persona, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al consultar ",
												'detalles' => "No hay equipo asinado",												
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

						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modSolicitud->getTotalPaginas($id_persona, $filtro, $buscardordesde, $buscardorhasta, $getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modSolicitud->Listar($id_persona, $filtro, $buscardordesde, $buscardorhasta, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al consultar ",
												'detalles' => "No hay solicitud realizada",												
											);										
						}

					break;					
					default:
					break;
				}


				echo '' . json_encode($datos) . '';	
			}


			
?>