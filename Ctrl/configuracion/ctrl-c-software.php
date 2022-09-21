<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-c-logc-distribucion/entidad-c-logc-distribucion.php';
	  	require_once '../../Mod/configuracion/mod-c-software/entidad-c-software.php';
		require_once '../../Mod/configuracion/mod-c-software/mod-c-software.php';
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

		$software = new software();
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

						$id=$_POST['id'];
						$resultados = $modSoftware->consultar($id);
						if ($resultados!="") {
							/***********************EDITAR*************************/
							$software->__SET('id',         $resultados->__GET('id'));
							$software->__SET('nombre',       $_POST['nombre']);
							$software->__SET('version',       $_POST['version']);
							$software->__SET('id_c_logc_tipo',       $_POST['id_tipo']);
							$software->__SET('id_c_logc_distribucion',       $_POST['id_distribucion']);
							
							$resultado = $modSoftware->editar($software);


							if ($resultado>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('EDITO UN SOFTWARE',$IP,$IDUSUARIO);	

									$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " Software  editado correctamente ",							
													);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al editar el Software ",
													'detalles' => $resultado,												
												);
							}
							break;
							/**********************************************************/		
						}elseif($resultados===0) {
							/**********************GUARDAR***********************/

							$software->__SET('nombre',       $_POST['nombre']);
							$software->__SET('version',       $_POST['version']);							
							$software->__SET('id_c_logc_tipo',       $_POST['id_tipo']);
							$software->__SET('id_c_logc_distribucion',       $_POST['id_distribucion']);
							$resultado =$modSoftware->guardar($software);
							
							if ($resultado>0) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('GUARDO UN SOFTWARE',$IP,$IDUSUARIO);	

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Caracteristicas del Software  Guardado correctamente ",								
													'resultado' => $resultado,			
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el Caracteristicas del Software ",
													'detalles' => $resultado,												
												);
							}
							break;
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
						$software->__SET('id',          $_POST['id']);
						$software->__SET('estado',       $estado);						
						$resultadoEstado = $modSoftware->cambiarEstado($software);
						if ($resultadoEstado===1) {

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion($mensajeEstado3.' UN SOFTWARE',$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Caracteristicas del Software  ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el Caracteristicas del Software ",
												'detalles' => $resultadoEstado,												
											);
						}


						break;
					case 'cargarListaDespegableUM':
						$tabla = $_POST['tabla'];
						$resultados = $modSoftware->cargarListarUM($tabla);

						$datos = [	
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
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modSoftware->consultar($id);

						if ($resultados!="") {
							$datos[] = array(
											   		'id' => $resultados->__GET('id'),
												    'nombre' => $resultados->__GET('nombre'),
												    'version' => $resultados->__GET('version'),
												    'id_tipo' => $resultados->__GET('id_c_logc_tipo'),
											   		'id_distribucion' => $resultados->__GET('id_c_logc_distribucion')->__GET('id'),
												);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el Caracteristicas del Software  con la id: ".$id,
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
						$filtro1=(isset($_POST['filtro1']))? $_POST['filtro1'] : "" ;
						$filtro2=(isset($_POST['filtro2']))? $_POST['filtro2'] : "" ;

						if($filtro1==0){
							$filtro1="";
						}
						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modSoftware->getTotalPaginas($filtro1,$filtro2,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modSoftware->Listar($filtro1, $filtro2, $empezar_desde, $tamagno_paginas);
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
												'mensaje' => "Error al realizar la busqueda",
												'detalles' => "No Hay Caracteristicas del Software  registrada",												
											);										
						}

						break;	
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>