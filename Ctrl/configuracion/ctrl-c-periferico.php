<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
  		require_once '../../Mod/configuracion/mod-c-fisc-modelo/entidad-c-fisc-modelo.php';
  		require_once '../../Mod/configuracion/mod-c-periferico/entidad-c-periferico.php';
		require_once '../../Mod/configuracion/mod-c-periferico/mod-c-periferico.php';
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

		$caracteristicasPerifericos = new caracteristicasPerifericos();
		$modCaracteristicasPerifericos = new modCaracteristicasPerifericos();	
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
						$resultados = $modCaracteristicasPerifericos->consultar($id);
						if ($resultados!="") {
							/***********************EDITAR*************************/
							$caracteristicasPerifericos->__SET('id',         $resultados->__GET('id'));
							$caracteristicasPerifericos->__SET('id_tipo_fisc',       $_POST['id_tipo']);
							$caracteristicasPerifericos->__SET('id_modelo_fisc',       $_POST['id_modelo']);
							$caracteristicasPerifericos->__SET('id_interfaz_fisc',       $_POST['id_interfaz']);
							$resultado = $modCaracteristicasPerifericos->editar($caracteristicasPerifericos);
							if ($resultado===1) {

			                    $IP=$_POST['ip_cliente'];
			                    $IDUSUARIO=$_POST['id_usuario'];                                
			                    $modBitacora->guardarOperacion('EDITO UNA CARACTERISTICAS DE PERIFERICO',$IP,$IDUSUARIO);

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " Caracteristicas del periferico  editado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al modificar el Caracteristicas del periferico ",
													'detalles' => $resultado,												
												);
							}
							break;
							/**********************************************************/		
						}elseif($resultados===0) {
							/**********************GUARDAR***********************/
							$caracteristicasPerifericos->__SET('id_tipo_fisc',       $_POST['id_tipo']);
							$caracteristicasPerifericos->__SET('id_modelo_fisc',       $_POST['id_modelo']);
							$caracteristicasPerifericos->__SET('id_interfaz_fisc',       $_POST['id_interfaz']);
							$resultado =$modCaracteristicasPerifericos->guardar($caracteristicasPerifericos);
							if ($resultado>0) {

			                    $IP=$_POST['ip_cliente'];
			                    $IDUSUARIO=$_POST['id_usuario'];                                
			                    $modBitacora->guardarOperacion('GUARDO UNA CARACTERISTICAS DE PERIFERICO',$IP,$IDUSUARIO);

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Caracteristicas del periferico  Guardado correctamente ",												
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el Caracteristicas del periferico ",
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
						$caracteristicasPerifericos->__SET('id',          $_POST['id']);
						$caracteristicasPerifericos->__SET('estado',       $estado);						
						$resultadoDepartamentoEstado = $modCaracteristicasPerifericos->cambiarEstado($caracteristicasPerifericos);
						if ($resultadoDepartamentoEstado===1) {

		                    $IP=$_POST['ip_cliente'];
		                    $IDUSUARIO=$_POST['id_usuario'];                                
		                    $modBitacora->guardarOperacion($mensajeEstado3.' UNA CARACTERISTICAS DE PERIFERICO',$IP,$IDUSUARIO);

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Caracteristicas del periferico  ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el Caracteristicas del periferico ",
												'detalles' => $resultadoDepartamentoEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modCaracteristicasPerifericos->consultar($id);
						if ($resultados!="") {
							$datos[] = array(
											   		'id' => $resultados->__GET('id'),
												    'id_tipo' => $resultados->__GET('id_tipo_fisc'),
											   		'id_marca' => $resultados->__GET('id_modelo_fisc')->__GET('id_marca'),
											   		'id_modelo' => $resultados->__GET('id_modelo_fisc')->__GET('id'),
											   		'id_interfaz' => $resultados->__GET('id_interfaz_fisc'),
												);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el Caracteristicas del periferico  con la id: ".$id,
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
					
						$filtro=(isset($_POST['filtro']))? $_POST['filtro'] : "" ;
						$filtro2=(isset($_POST['filtro2']))? $_POST['filtro2'] : "" ;

// INICIO CAlCULAR VARIABLES

						$tamagno_paginas=$_POST['tamagno_paginas'];
						if ($_POST['pagina']!=1) {							
							$pagina=$_POST['pagina'];
						}else{
							$pagina=1;
						}			
						$empezar_desde=($pagina-1)*$tamagno_paginas;
						$getTotalPaginas=1;
						$num_filas = $modCaracteristicasPerifericos->getTotalPaginas($filtro, $filtro2,
							$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modCaracteristicasPerifericos->Listar($filtro, $filtro2, $empezar_desde, $tamagno_paginas);
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
												'detalles' => "No Hay Caracteristicas del periferico  registrada",												
											);										
						}

						break;	
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>