<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
	  	require_once '../../Mod/configuracion/mod-departamento/entidad-departamento.php';
	  	require_once '../../Mod/configuracion/mod-departamento/entidad-departamento-cargo.php';
		require_once '../../Mod/configuracion/mod-departamento/mod-departamento.php';
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
		$datoObjetoA = array(
							'controlError' => 6,
							'mensaje' => " ! Campos vacios ¡ ",
							'detalles' => " Los campos estan vacios ",		
						);

		$departamento = new departamento();
		$modDepartamento = new modDepartamento();	

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
						$resultados = $modDepartamento->consultar($id);
						if ($resultados!="") {
							/***********************EDITAR*************************/
							$departamento->__SET('id',         $resultados->__GET('id'));
							$departamento->__SET('nombre',       utf8_decode($_POST['nombre']));
							$resultado = $modDepartamento->editar($departamento);
							if ($resultado>0) {

								$cargos = $_POST['cargos'];
								$contando=0;	
								$idsRegistradosH=[];			

								if($cargos>0){ 
									foreach ($cargos as $cargo => $id_cargo) {

										$departamentoCargo = new departamentoCargo(); 			
										$departamentoCargo->__SET('id_departamento', $resultado);
										$departamentoCargo->__SET('id_cargo', $id_cargo);
										$idsRegistradosH[]=$modDepartamento->guardarDepartamentoCargo($departamentoCargo);
										$contando=$contando+1;							
									}		
								}


								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('EDITO UN DEPARTAMENTO',$IP,$IDUSUARIO);	

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡ Datos editados con Exito!",
													'detalles' => " Departamento editado correctamente ",
												);								
							}else{
								$datos[] = array(
													'controlError' => 3,
													'mensaje' => "Error al modificar el departamento",
													'detalles' => $resultado,												
												);
							}
							/**********************************************************/		
						} elseif($resultados===0) {
							/**********************GUARDAR***********************/
							$departamento->__SET('nombre',       utf8_decode($_POST['nombre']));
							$resultado =$modDepartamento->guardar($departamento);
							if ($resultado>0) {
								
								$cargos = $_POST['cargos'];
								$contando=0;	
								$idsRegistradosH=[];	
				
								if($cargos>0){ 
									foreach ($cargos as $cargo => $id_cargo) {

										$departamentoCargo = new departamentoCargo(); 			
										$departamentoCargo->__SET('id_departamento', $resultado);
										$departamentoCargo->__SET('id_cargo', $id_cargo);
										$modDepartamento->guardarDepartamentoCargo($departamentoCargo);
										$contando=$contando+1;							
									}		
								}

								$IP=$_POST['ip_cliente'];
								$IDUSUARIO=$_POST['id_usuario'];								
								$modBitacora->guardarOperacion('GUARDO UN DEPARTAMENTO',$IP,$IDUSUARIO);	

								$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Datos Guardados con Exito!",
													'detalles' => " Departamento Guardado correctamente ",
												);								
							}else{
								$datos[] = array(
													'controlError' => 1,
													'mensaje' => "Error al Guardar el departamento",
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
						$departamento->__SET('id',          $_POST['id']);
						$departamento->__SET('estado',       $estado);						
						$resultadoDepartamentoEstado = $modDepartamento->cambiarEstado($departamento);
						if ($resultadoDepartamentoEstado===1) {

							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion($mensajeEstado3.' UN DEPARTAMENTO',$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Departamento ".$mensajeEstado." correctamente ",
													'estado' => $estado, 												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el departamento",
												'detalles' => $resultadoDepartamentoEstado,												
											);
						}


						break;
					case 'consultar':

						$id=$_POST['id'];						
						$resultados = $modDepartamento->consultar($id);
						if ($resultados!="") {
							$datos[] = array(
											   		'id' => $resultados->__GET('id'),
												    'nombre' => $resultados->__GET('nombre'),
											   		'estadoDepartamento' => $resultados->__GET('estado'),
												);				

							} elseif($resultados===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el departamento con la id: ".$id,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id,
													'detalles' => $resultados,												
												);							
							}

						break;
					case 'consultarDepartamentoCargo':

						$id=$_POST['id'];						
						$cargos = $modDepartamento->ListarDepartamentoCargo($id);

						if ($cargos!="") {
							$datos[] = array(
												'cargos' => $cargos,
											);				

							} elseif($cargos===0) {
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "No existe el tarea con la id: ".$id,
												);
							}else{
								$datos[] = array(
													'controlError' => 2,
													'mensaje' => "Error al consultar la id: ".$id,
													'detalles' => $cargos,												
												);							
							}

						break;			
					case 'cambiarEstadoDepartamentoCargo':
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
						$departamentoCargo = new departamentoCargo();
						$departamentoCargo->__SET('id_cargo',          $_POST['id_cargo']);
						$departamentoCargo->__SET('id_departamento',   $_POST['id_departamento']);
						$departamentoCargo->__SET('estado',       $estado);						
						$resultadoEstado = $modDepartamento->cambiarEstadoDepartamentoCargo($departamentoCargo);
						if ($resultadoEstado===1) {


							$IP=$_POST['ip_cliente'];
							$IDUSUARIO=$_POST['id_usuario'];								
							$modBitacora->guardarOperacion($mensajeEstado3.' UN CARGO PARA UNA DEPARTAMENTO',$IP,$IDUSUARIO);	

							$datos[] = array(
													'controlError' => 0,
													'mensaje' => "¡Estado cambiado con Exito!",
													'detalles' => " Cargo del departamento  ".$mensajeEstado." correctamente ",												
												);									
						}else{
							$datos[] = array(
												'controlError' => 4,
												'mensaje' => "Error al ".$mensajeEstado2." el cargo del departamento ",
												'detalles' => $resultadoEstado,												
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
						$num_filas = $modDepartamento->getTotalPaginas($filtro,$getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modDepartamento->Listar($filtro, $empezar_desde, $tamagno_paginas);
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
												'detalles' => "No Hay Departamento registrada",												
											);										
						}

						break;	
					default:
						break;
				}
				echo '' . json_encode($datos) . '';	
			}


			
?>