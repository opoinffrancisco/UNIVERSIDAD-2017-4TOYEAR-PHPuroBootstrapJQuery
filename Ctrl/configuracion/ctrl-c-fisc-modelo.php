<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-c-fisc-modelo/entidad-c-fisc-modelo.php';
	  	require_once '../../Mod/configuracion/mod-c-fisc-marca/entidad-c-fisc-marca.php';
		require_once '../../Mod/configuracion/mod-c-fisc-modelo/mod-c-fisc-modelo.php';
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
		$modelo = new modelo();
		$marca = new marca();
		$modModelo = new modModelo();	

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
						$resultados = $modModelo->consultar($id);
						if ($resultados!="") {
							/***********************EDITAR*************************/
							$modelo->__SET('id',         $resultados->__GET('id'));
							$modelo->__SET('nombre',       $_POST['nombre']);
							$modelo->__SET('id_marca',       $marca);
							$modelo->__GET('id_marca')->__SET('id',    $_POST['id_marca']);

							$resultado = $modModelo->editar($modelo);
							if ($resultado===1) {

			                    $IP=$_POST['ip_cliente'];
			                    $IDUSUARIO=$_POST['id_usuario'];                                
			                    $modBitacora->guardarOperacion(' EDITO UNA CARACTERISTICA FISICA - MODELO',$IP,$IDUSUARIO);  

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " modelo del componente editado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al modificar el modelo del componente",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/		
						} elseif($resultados===0) {
							/**********************GUARDAR***********************/
							$modelo->__SET('nombre',       $_POST['nombre']);
							$modelo->__SET('id_marca',       $marca);
							$modelo->__GET('id_marca')->__SET('id',    $_POST['id_marca']);							
							$resultado =$modModelo->guardar($modelo);
							if ($resultado>0) {

			                    $IP=$_POST['ip_cliente'];
			                    $IDUSUARIO=$_POST['id_usuario'];                                
			                    $modBitacora->guardarOperacion(' GUARDO UNA CARACTERISTICA FISICA - MODELO',$IP,$IDUSUARIO);  

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " modelo del componente Guardado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el modelo del componente",
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
						$modelo->__SET('id',          $_POST['id']);
						$modelo->__SET('estado',       $estado);						
						$resultado = $modModelo->cambiarEstado($modelo);
						if ($resultado===1) {

		                    $IP=$_POST['ip_cliente'];
		                    $IDUSUARIO=$_POST['id_usuario'];                                
		                    $modBitacora->guardarOperacion($mensajeEstado3.' UNA CARACTERISTICA FISICA - MODELO',$IP,$IDUSUARIO);  

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " modelo del componente ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el modelo del componente",
												'detalles' => $resultado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modModelo->consultar($id);
						if ($resultados!="") {
							$datos[] = array(
											   		'id' => $resultados->__GET('id'),
												    'nombre' => utf8_encode($resultados->__GET('nombre')),
											   		'estadoModelo' => $resultados->__GET('estado'),
											   		'id_marca' => $resultados->__GET('id_marca')->__GET('id'),
												);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el modelo con la id: ".$id,
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
						$num_filas = $modModelo->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modModelo->Listar($filtro, $empezar_desde, $tamagno_paginas);
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
												'detalles' => "No Hay modelo registrado",												
											);										
						}

						break;	
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>