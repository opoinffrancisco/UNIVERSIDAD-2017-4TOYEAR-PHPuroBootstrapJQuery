<?php

	class modCaracteristicasPerifericos {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(caracteristicasPerifericos $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_caracteristicas_fisc_perif SET 
											estado			= :estado
									    WHERE id = :id "
									);

			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':estado', $data->__GET('estado'));

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function editar(caracteristicasPerifericos $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_caracteristicas_fisc_perif SET 
										id					  = :id,
										id_tipo_fisc          = :id_tipo_fisc, 
										id_modelo_fisc        = :id_modelo_fisc, 
										id_interfaz_fisc      = :id_interfaz_fisc 

								    WHERE id = :id "
							);
			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':id_tipo_fisc', $data->__GET('id_tipo_fisc'));
		     	$consulta->bindValue(':id_modelo_fisc', $data->__GET('id_modelo_fisc'));
		     	$consulta->bindValue(':id_interfaz_fisc', $data->__GET('id_interfaz_fisc'));

		     	$resultado = $consulta->execute();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(caracteristicasPerifericos $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_caracteristicas_fisc_perif (
															id_tipo_fisc, 
															id_modelo_fisc,
															id_interfaz_fisc,
															estado
														) 
						        				VALUES (
															:id_tipo_fisc, 
															:id_modelo_fisc,
															:id_interfaz_fisc,
															:estado
						        				    	)"
							);

		     	$consulta->bindValue(':id_tipo_fisc', $data->__GET('id_tipo_fisc'));
		     	$consulta->bindValue(':id_modelo_fisc', $data->__GET('id_modelo_fisc'));
		     	$consulta->bindValue(':id_interfaz_fisc', $data->__GET('id_interfaz_fisc'));
		     	$consulta->bindValue(':estado', 1);

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return 1;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function consultar($id)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
											" SELECT
												ccfp.id, 
												ccfp.id_tipo_fisc, 
												ccfp.id_modelo_fisc,
												ccfm.id_marca,
												ccfp.id_interfaz_fisc,
												ccfp.estado 
											FROM    cfg_caracteristicas_fisc_perif as ccfp  
											INNER JOIN cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
											WHERE ccfp.id = :id "
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new caracteristicasPerifericos();
					$modelo = new modelo();
					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('id_tipo_fisc', $r->id_tipo_fisc);
					$entidadResultados->__SET('id_modelo_fisc', $modelo);
					$entidadResultados->__GET('id_modelo_fisc')->__SET('id',$r->id_modelo_fisc);
					$entidadResultados->__GET('id_modelo_fisc')->__SET('id_marca', $r->id_marca);
					$entidadResultados->__SET('id_interfaz_fisc', $r->id_interfaz_fisc);
					$entidadResultados->__SET('estado', $r->estado);

					return $entidadResultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	

		
		public function Listar($filtro, $filtro2 ,$empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{


				if(empty($filtro) && empty($filtro2)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												cp.id as id, 
												cfm.nombre as modelo, 
												cfmm.nombre as marca, 
												cft.nombre as tipo, 												
												cp.estado as estado 
											FROM  cfg_caracteristicas_fisc_perif as cp
												LEFT JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
												LEFT JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
											ORDER BY cp.id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");


				}elseif(empty($filtro2) && !empty($filtro)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													cp.id as id, 
													cfm.nombre as modelo, 
													cfmm.nombre as marca, 
													cft.nombre as tipo, 	
													cp.estado as estado 
												FROM    cfg_caracteristicas_fisc_perif as cp 
													INNER JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre 
												ORDER BY cp.id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}elseif(empty($filtro) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													cp.id as id, 
													cfm.nombre as modelo, 
													cfmm.nombre as marca, 
													cft.nombre as tipo, 	
													cp.estado as estado 
												FROM    cfg_caracteristicas_fisc_perif as cp 
													INNER JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cp.id_tipo_fisc = :filtro2 
												ORDER BY cp.id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':filtro2', $filtro2);	
	
				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													cp.id as id, 
													cfm.nombre as modelo, 
													cfmm.nombre as marca, 
													cft.nombre as tipo, 	
													cp.estado as estado 
												FROM    cfg_caracteristicas_fisc_perif as cp 
													INNER JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre AND cp.id_tipo_fisc = :filtro2 
												ORDER BY cp.id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	
			   		$consulta->bindValue(':filtro2', $filtro2);	
	

				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id' => $r->id,
										'modelo' => $r->modelo,
										'marca' => $r->marca,
										'tipo' => $r->tipo,
										'estado' => $r->estado,
									);
				}
				$consulta = $this->classConexion->getCerrarSesion();
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		public function getTotalPaginas($filtro, $filtro2, $getTotalPaginas)
		{
			try
			{


				if(empty($filtro) && empty($filtro2)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 

													COUNT(cp.id) as num_filas 

											FROM  cfg_caracteristicas_fisc_perif as cp
												LEFT JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
												LEFT JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
											ORDER BY cp.id DESC
										");


				}elseif(empty($filtro2) && !empty($filtro)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 

													COUNT(cp.id) as num_filas 

												FROM    cfg_caracteristicas_fisc_perif as cp 
													INNER JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre 
												ORDER BY cp.id DESC 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}elseif(empty($filtro) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 

													COUNT(cp.id) as num_filas 

												FROM    cfg_caracteristicas_fisc_perif as cp 
													INNER JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cp.id_tipo_fisc = :filtro2
												ORDER BY cp.id DESC 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':filtro2', $filtro2);	
	
				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 

													COUNT(cp.id) as num_filas 

												FROM    cfg_caracteristicas_fisc_perif as cp 
													INNER JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre AND cp.id_tipo_fisc = :filtro2
												ORDER BY cp.id DESC 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	
			   		$consulta->bindValue(':filtro2', $filtro2);	
	

				}

			   		$consulta->execute();
					$r = $consulta->fetch(PDO::FETCH_OBJ);

					return 	$r->num_filas;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
   }	
		
?>
