<?php

	class modCaracteristicasEquipos extends caracteristicasEquipos{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(caracteristicasEquipos $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_caracteristicas_fisc_eq SET 
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
		public function editar(caracteristicasEquipos $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_caracteristicas_fisc_eq SET 
										id					  = :id,
										id_tipo_fisc          = :id_tipo_fisc, 
										id_modelo_fisc        = :id_modelo_fisc 

								    WHERE id = :id "
							);
			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':id_tipo_fisc', $data->__GET('id_tipo_fisc'));
		     	$consulta->bindValue(':id_modelo_fisc', $data->__GET('id_modelo_fisc'));

		     	$resultado = $consulta->execute();

				return $data->__GET('id');

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(caracteristicasEquipos $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_caracteristicas_fisc_eq (
															id_tipo_fisc, 
															id_modelo_fisc,
															estado
														) 
						        				VALUES (
															:id_tipo_fisc, 
															:id_modelo_fisc,
															:estado
						        				    	)"
							);

		     	$consulta->bindValue(':id_tipo_fisc', $data->__GET('id_tipo_fisc'));
		     	$consulta->bindValue(':id_modelo_fisc', $data->__GET('id_modelo_fisc'));
		     	$consulta->bindValue(':estado', 1);

		     	$consulta->execute();
		     	$ultimoId=$this->classConexion->getUltimoIdGuardado();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return $ultimoId;

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
											cfeq.id, 
											cfeq.id_tipo_fisc, 
											cfeq.id_modelo_fisc,
											cfeq.estado,
                                            cfmm.id_marca  
										FROM  cfg_caracteristicas_fisc_eq as cfeq  
				                        INNER JOIN 	cfg_c_fisc_modelo as cfmm ON  cfmm.id=cfeq.id_modelo_fisc
							            WHERE cfeq.id = :id "
								     );
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new caracteristicasEquipos();
					$modelo = new modelo();
					$marca = new marca();
					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('id_tipo_fisc', $r->id_tipo_fisc);
					$entidadResultados->__SET('id_modelo_fisc', $modelo);
					$entidadResultados->__GET('id_modelo_fisc')->__SET('id', $r->id_modelo_fisc);
					$entidadResultados->__GET('id_modelo_fisc')->__SET('id_marca', $marca);
					$entidadResultados->__GET('id_modelo_fisc')->__GET('id_marca')->__SET('id', $r->id_marca);
					$entidadResultados->__SET('estado', $r->estado);

					return $entidadResultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	

		
		public function Listar($filtro, $filtro2, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
	
				if(empty($filtro) && empty($filtro2)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												ce.id as id, 
												cfm.nombre as modelo, 
												cfmm.nombre as marca, 
												cft.nombre as tipo, 
												ce.estado as estado 
											FROM  cfg_caracteristicas_fisc_eq as ce
												LEFT JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id
												LEFT JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
											ORDER BY ce.id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");


				}elseif(empty($filtro2) && !empty($filtro)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													ce.id as id, 
													cfm.nombre as modelo, 
													cfmm.nombre as marca, 
													cft.nombre as tipo, 	
													ce.estado as estado 
												FROM    cfg_caracteristicas_fisc_eq as ce 
													INNER JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre 
												ORDER BY ce.id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}elseif(empty($filtro) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													ce.id as id, 
													cfm.nombre as modelo, 
													cfmm.nombre as marca, 
													cft.nombre as tipo, 	
													ce.estado as estado 
												FROM    cfg_caracteristicas_fisc_eq as ce 
													INNER JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE  ce.id_tipo_fisc = :filtro2 
												ORDER BY ce.id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':filtro2', $filtro2);	
	
				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													ce.id as id, 
													cfm.nombre as modelo, 
													cfmm.nombre as marca, 
													cft.nombre as tipo, 	
													ce.estado as estado 
												FROM    cfg_caracteristicas_fisc_eq as ce 
													INNER JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre AND ce.id_tipo_fisc = :filtro2 
												ORDER BY ce.id DESC 
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

		public function getTotalPaginas($filtro, $filtro2,$getTotalPaginas)
		{
			try
			{

				if(empty($filtro) && empty($filtro2)) {
					
							$consulta = $this->classConexion->getConexion()->
										prepare("	SELECT 

															COUNT(ce.id) as num_filas 								

													FROM  cfg_caracteristicas_fisc_eq as ce
														LEFT JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
														LEFT JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
														LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
													ORDER BY ce.id DESC
												");


				}elseif(empty($filtro2) && !empty($filtro)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 

													COUNT(ce.id) as num_filas 								

												FROM    cfg_caracteristicas_fisc_eq as ce 
													INNER JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre 
												ORDER BY ce.id DESC 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}elseif(empty($filtro) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													
													COUNT(ce.id) as num_filas 

												FROM    cfg_caracteristicas_fisc_eq as ce 
													INNER JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE  ce.id_tipo_fisc = :filtro2 
												ORDER BY ce.id DESC 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':filtro2', $filtro2);	
	
				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 

													COUNT(ce.id) as num_filas 

												FROM    cfg_caracteristicas_fisc_eq as ce 
													INNER JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id 										
													INNER JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
													INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
												WHERE cfm.nombre LIKE :nombre AND ce.id_tipo_fisc = :filtro2 
												ORDER BY ce.id DESC 
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
///////////////////////////////////////////////////////////////////////////////////////////////
		public function guardarInterfazEquipo(interfazCaracteristicasEquipos $data)
		{

			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_interfaz_caracteristicas_fisicas_eq (
															id_interfaz, 
															id_c_fisc_eq,
															estado
														) 
						        				VALUES (
															:id_interfaz, 
															:id_c_fisc_eq,
															:estado
						        				    	)"
							);

		     	$consulta->bindValue(':id_interfaz', $data->__GET('id_interfaz'));
		     	$consulta->bindValue(':id_c_fisc_eq', $data->__GET('id_c_fisc_eq'));
		     	$consulta->bindValue(':estado', 1);

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return 0;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function cargarListarUM($tabla)
		{ 
			$result = array();
			try
			{

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
														* 
												FROM  `".$tabla."`   
												WHERE estado = 1 
										");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id' => $r->id,						
										'abreviatura' => $r->abreviatura,

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
		public function ListarInterfacesEquipo($idCaracteristicas)
		{ 
			$result = array();
			try
			{
		
				$consulta = $this->classConexion->getConexion()->
							prepare("	SELECT 
											 icfq.id_interfaz,
										     cfi.nombre,
										 	 icfq.estado,     
											 icfq.id_c_fisc_eq as idcEquipos  
										FROM `cfg_interfaz_caracteristicas_fisicas_eq` as icfq 
										INNER JOIN cfg_c_fisc_interfaz_conexion as cfi ON icfq.id_interfaz =  cfi.id 
										WHERE id_c_fisc_eq=:id_c_fisc_eq
									");



				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':id_c_fisc_eq', $idCaracteristicas);			
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_interfaz' => $r->id_interfaz,
										'nombreInterfaz' => $r->nombre,
										'estadoInterfaz' => $r->estado,
										'idcEquipos' => $r->idcEquipos,
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
		public function cambiarEstadoInterfazEquipo(interfazCaracteristicasEquipos $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_interfaz_caracteristicas_fisicas_eq SET 
											estado			= :estado
									    WHERE id_interfaz = :id_interfaz AND id_c_fisc_eq = :id_c_fisc_eq "
									);

			   	$consulta->bindValue(':id_interfaz', $data->__GET('id_interfaz'));			
			   	$consulta->bindValue(':id_c_fisc_eq', $data->__GET('id_c_fisc_eq'));			
		     	$consulta->bindValue(':estado', $data->__GET('estado'));

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
   }	
		
?>
