<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-c-fisc-modelo/entidad-c-fisc-modelo.php';
	  	require_once '../../Mod/configuracion/mod-c-fisc-marca/entidad-c-fisc-marca.php';		
	  	require_once '../../Mod/configuracion/mod-c-equipo/entidad-interfaz-c-fisc-eq.php';
	  	require_once '../../Mod/configuracion/mod-c-equipo/entidad-c-equipo.php';
		require_once '../../Mod/configuracion/mod-c-equipo/mod-c-equipo.php';
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

		$caracteristicasEquipos = new caracteristicasEquipos();
		$modCaracteristicasEquipos = new modCaracteristicasEquipos();	

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
					$resultados = $modCaracteristicasEquipos->consultar($id);
					if ($resultados!="") {
						/***********************EDITAR*************************/
						$caracteristicasEquipos->__SET('id',         $resultados->__GET('id'));
						$caracteristicasEquipos->__SET('id_tipo_fisc',       $_POST['id_tipo']);
						$caracteristicasEquipos->__SET('id_modelo_fisc',       $_POST['id_modelo']);
						
						$resultado = $modCaracteristicasEquipos->editar($caracteristicasEquipos);

						$interfaces = $_POST['interfaces'];
						$contando=0;	
						$idsRegistrados=[];							
						if($interfaces!=0){ 
							foreach ($interfaces as $interfaz => $id_interfaz) {
								$interfazEquipo = new interfazCaracteristicasEquipos(); 			
								$interfazEquipo->__SET('id_interfaz', $id_interfaz);
								$interfazEquipo->__SET('id_c_fisc_eq', $resultado);
								$idsRegistrados[]=$modCaracteristicasEquipos->guardarInterfazEquipo($interfazEquipo);
								$contando=$contando+1;															
							}		
						}

						if ($resultado>0) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];                                
							$modBitacora->guardarOperacion('EDITO UNA CARACTERISTICAS DE EQUIPO',$IP,$IDUSUARIO);  

							$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡ Datos editados con Exito!",
												'detalles' => " Caracteristicas del equipo  editado correctamente ",
												'depuracion' => [
													'interfaces' => $interfaces,
													'idResultado' => $resultado,
													'ejecutaGuardarIntComp' => $contando,
													'idsRegistrados' => $idsRegistrados,
												],								
											);								
						}else{
							$datos[] = array(
												'controlError' => 3,
												'mensaje' => "Error al modificar el Caracteristicas del equipo ",
												'detalles' => $resultado,												
											);
						}
						break;
						/**********************************************************/		
					}elseif($resultados===0) {
						/**********************GUARDAR***********************/
						$caracteristicasEquipos->__SET('id_tipo_fisc',       $_POST['id_tipo']);
						$caracteristicasEquipos->__SET('id_modelo_fisc',       $_POST['id_modelo']);
						$resultado =$modCaracteristicasEquipos->guardar($caracteristicasEquipos);
						
						if ($resultado>0) {

							$interfaces = $_POST['interfaces'];
							$contando=0;	
							$idsRegistrados=[];							
							if($interfaces!=0){ 
								foreach ($interfaces as $interfaz => $id_interfaz) {
									$interfazEquipo = new interfazCaracteristicasEquipos(); 			
									$interfazEquipo->__SET('id_interfaz', $id_interfaz);
									$interfazEquipo->__SET('id_c_fisc_eq', $resultado);
									$idsRegistrados[]=$modCaracteristicasEquipos->guardarInterfazEquipo($interfazEquipo);
									$contando=$contando+1;															
								}		
							}



							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];                                
							$modBitacora->guardarOperacion('GUARDO UNA CARACTERISTICAS DE EQUIPO',$IP,$IDUSUARIO);  

							$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡Datos Guardados con Exito!",
												'detalles' => " Caracteristicas del equipo  Guardado correctamente ",								
												'resultado' => $resultado,			
											);								
						}else{
							$datos[] = array(
												'controlError' => 1,
												'mensaje' => "Error al Guardar el Caracteristicas del equipo ",
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
					if ($estado<=0) {
						$mensajeEstado="Deshabilitados";
						$mensajeEstado2="Deshabilitar";
						$mensajeEstado3="DESHABILITO";
					} else {
						$mensajeEstado="Habilitados";
						$mensajeEstado2="Habilitar";
						$mensajeEstado3="HABILITO";
					}
					$caracteristicasEquipos->__SET('id',          $_POST['id']);
					$caracteristicasEquipos->__SET('estado',       $estado);						
					$resultadoEstado = $modCaracteristicasEquipos->cambiarEstado($caracteristicasEquipos);
					if ($resultadoEstado===1) {

						$IP=$_POST['ip_cliente'];
						$IDUSUARIO=$_POST['id_usuario'];                                
						$modBitacora->guardarOperacion($mensajeEstado3.' UNA CARACTERISTICAS DE EQUIPO',$IP,$IDUSUARIO);  

						$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡Estado cambiado con Exito!",
												'detalles' => " Caracteristicas del equipo  ".$mensajeEstado." correctamente ",												
											);									
					}else{
						$datos[] = array(
											'controlError' => 4,
											'mensaje' => "Error al ".$mensajeEstado2." el Caracteristicas del equipo ",
											'detalles' => $resultadoEstado,												
										);
					}


					break;
				case 'cambiarEstadoInterfazEquipo':
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
					$interfazCaracteristicasEquipos = new interfazCaracteristicasEquipos();
					$interfazCaracteristicasEquipos->__SET('id_interfaz',          $_POST['id_interfaz']);
					$interfazCaracteristicasEquipos->__SET('id_c_fisc_eq',          $_POST['idCEquipo']);
					$interfazCaracteristicasEquipos->__SET('estado',       $estado);						
					$resultadoEstado = $modCaracteristicasEquipos->cambiarEstadoInterfazEquipo($interfazCaracteristicasEquipos);
					if ($resultadoEstado===1) {

						$IP=$_POST['ip_cliente'];
						$IDUSUARIO=$_POST['id_usuario'];                                
						$modBitacora->guardarOperacion($mensajeEstado3.'UNA INTERFAZ DE CONEXION DE UNA CARACTERISTICAS DE EQUIPO',$IP,$IDUSUARIO);  

						$datos[] = array(
												'controlError' => 0,
												'mensaje' => "¡Estado cambiado con Exito!",
												'detalles' => " Caracteristicas del equipo  ".$mensajeEstado." correctamente ",												
											);									
					}else{
						$datos[] = array(
											'controlError' => 4,
											'mensaje' => "Error al ".$mensajeEstado2." el Caracteristicas del equipo ",
											'detalles' => $resultadoEstado,												
										);
					}

					break;				
				case 'cargarListaDespegableUM':
					$tabla = $_POST['tabla'];
					$resultados = $modCaracteristicasEquipos->cargarListarUM($tabla);

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
					$resultados = $modCaracteristicasEquipos->consultar($id);
					$datosInterfaces = $modCaracteristicasEquipos->ListarInterfacesEquipo($id);

					if ($resultados!="") {
						$datos[] = array(
												'id' => $resultados->__GET('id'),
												'id_tipo' => $resultados->__GET('id_tipo_fisc'),
												'id_modelo' => $resultados->__GET('id_modelo_fisc')->__GET('id'),
												'id_marca' => $resultados->__GET('id_modelo_fisc')->__GET('id_marca')->__GET('id'),
												'interfaces' => $datosInterfaces,
											);				

						} elseif($resultados===0) {
							$datos[] = array(
												'controlError' => 2,
												'mensaje' => "No existe el Caracteristicas del equipo  con la id: ".$id,
											);
						}else{
							$datos[] = array(
												'controlError' => 2,
												'mensaje' => "Error al consultar la id: ".$id,
												'detalles' => $resultados,												
											);							
						}

					break;
				case 'consultarInterfacesCEquipo':

					$id=$_POST['id'];	
					$datosInterfaces = $modCaracteristicasEquipos->ListarInterfacesEquipo($id);

					if ($datosInterfaces!="") {
						$datos[] = array(
											'interfaces' => $datosInterfaces,
										);				

						} elseif($datosInterfaces===0) {
							$datos[] = array(
												'controlError' => 2,
												'mensaje' => "No existen interfaces para las caracteristicas",
											);
						}else{
							$datos[] = array(
												'controlError' => 2,
												'mensaje' => "Error al realizar la busqueda",
												'detalles' => $datosInterfaces,												
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
					$num_filas = $modCaracteristicasEquipos->getTotalPaginas($filtro, $filtro2, $getTotalPaginas);
					$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
					// FIN CAlCULAR VARIABLES

					$getTotalPaginas=0;
					$resultados = $modCaracteristicasEquipos->Listar($filtro, $filtro2, $empezar_desde, $tamagno_paginas);
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
											'detalles' => "No Hay Caracteristicas del equipo  registrada",												
										);										
					}

					break;	
				default:
					break;
			}
			echo '' . json_encode($datos) . '';	
		}


			
?>