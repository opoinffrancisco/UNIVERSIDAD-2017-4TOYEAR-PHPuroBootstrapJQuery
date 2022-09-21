<?php
		//require_once 'ctrl-nucleo';	
	
		require_once '../../Mod/conexion.php';
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
		//
		$modBitacora = new modBitacora();		
		
		if(isset($_POST['accion']))
		{
			$accion=$_POST['accion'];
		}	
			if(isset($accion))
			{
				switch($accion)
				{
					case 'FiltrarLista':
						// INICIO CAlCULAR VARIABLES


						if (!isset($_POST['usuario']) || !isset($_POST['operacion']) || !isset($_POST['perfil']) ) {
							
							$datos = array(
												'controlError' => 5,
												'mensaje' => "Error al validar campos ",
												'detalles' => "Campos vacios",												
											);
							break;	
						}
						

						$usuario	=	$_POST['usuario'];
						$operacion	=	$_POST['operacion'];
						$perfil	=	$_POST['perfil'];

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
						$num_filas = $modBitacora->getTotalPaginas($usuario, $operacion, $perfil,$buscardordesde, $buscardorhasta, $getTotalPaginas);
						$total_paginas=ceil($num_filas/$tamagno_paginas);// ejemplo : (4) -> 1,2,3,4
						// FIN CAlCULAR VARIABLES

						$getTotalPaginas=0;
						$resultados = $modBitacora->Listar($usuario, $operacion, $perfil, $buscardordesde, $buscardorhasta, $empezar_desde, $tamagno_paginas);
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