<?php

	class modSoftware extends software{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function verificarExistenciaAnadida($id_equipo, $id_software)
		{
			try 
			{
				$sql = "SELECT 1 FROM `equipo_software` WHERE `id_equipo` = 45 AND `id_software` = 3 AND `estado` = 1";

				$consulta = $this->classConexion->getConexion()
									->prepare("	SELECT 
													1 
												FROM `equipo_software` 
												WHERE `id_equipo` = :id_equipo AND `id_software` = :id_software AND `estado` = 1");				          
			   	$consulta->bindValue(':id_equipo', $id_equipo);			
			   	$consulta->bindValue(':id_software', $id_software);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();	

				if ($r) {
					// ya existe
					return 1;
				}
				//no existe
				return 0;
			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}			
		}
		public function cambiarEstado(software $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE eq_software SET 
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
		public function editar(software $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE eq_software SET 
										id					  = :id,
										nombre        		  = :nombre, 
										version         	  = :version, 
										id_c_logc_tipo        = :id_c_logc_tipo, 
										id_c_logc_distribucion  = :id_c_logc_distribucion 
								    WHERE id = :id "
							);
			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':version', $data->__GET('version'));
		     	$consulta->bindValue(':id_c_logc_tipo', $data->__GET('id_c_logc_tipo'));
		     	$consulta->bindValue(':id_c_logc_distribucion', $data->__GET('id_c_logc_distribucion'));

		     	$resultado = $consulta->execute();

				return $data->__GET('id');

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(software $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO eq_software (
															nombre, 
															version, 
															id_c_logc_tipo, 
															id_c_logc_distribucion,
															estado
														) 
						        				VALUES (
															:nombre, 						        				
															:version, 
															:id_c_logc_tipo, 
															:id_c_logc_distribucion,
															:estado
						        				    	)"
							);

		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':version', $data->__GET('version'));
		     	$consulta->bindValue(':id_c_logc_tipo', $data->__GET('id_c_logc_tipo'));
		     	$consulta->bindValue(':id_c_logc_distribucion', $data->__GET('id_c_logc_distribucion'));
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
											cfeq.nombre, 
											cfeq.version, 
											cfeq.id_c_logc_tipo, 
											cfeq.id_c_logc_distribucion 
										FROM  eq_software as cfeq   
							            WHERE cfeq.id = :id "
								     );
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new software();
					$distribucion = new distribucion();
					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('version', $r->version);
					$entidadResultados->__SET('id_c_logc_tipo', $r->id_c_logc_tipo);
					$entidadResultados->__SET('id_c_logc_distribucion', $distribucion);
					$entidadResultados->__GET('id_c_logc_distribucion')->__SET('id', $r->id_c_logc_distribucion);

					return $entidadResultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}			
		public function Listar($filtro1, $filtro2, $empezardesde, $tamagnopaginas)
		{ 

			$result = array();
			try
			{
				if(empty($filtro1) && empty($filtro2)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												cs.id as id, 
								CONCAT(cs.nombre,  '   ',  cs.version) as NombreVersion,								
												clt.nombre as tipo,
												cld.nombre as distribucion,
												cs.estado as estado 
											FROM  eq_software as cs
												LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id 										
												LEFT JOIN cfg_c_logc_distribucion as cld ON cs.id_c_logc_distribucion = cld.id  
											ORDER BY cs.id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");


				}elseif(empty($filtro2) && !empty($filtro1)) {


					$consulta = $this->classConexion->getConexion()->
								prepare(" 	SELECT 
												cs.id as id, 
								CONCAT(cs.nombre, cs.version) as NombreVersion,								
												clt.nombre as tipo,
												cld.nombre as distribucion,				
												cs.estado as estado 
											FROM  eq_software as cs
												LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id 										
												LEFT JOIN cfg_c_logc_distribucion as cld ON cs.id_c_logc_distribucion = cld.id  
											WHERE clt.id = :filtro1 
											ORDER BY cs.id DESC 
											LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta la consulta
			   		$consulta->bindValue(':filtro1', $filtro1);	


				}elseif(empty($filtro1) && !empty($filtro2)) {

					$SQL = "SELECT 
								cs.id as id, 
								CONCAT(cs.nombre, cs.version) as NombreVersion,								
								clt.nombre as tipo,
								cld.nombre as distribucion,	
								cs.estado as estado 
							FROM  eq_software as cs
								LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id 										
								LEFT JOIN cfg_c_logc_distribucion as cld ON cs.id_c_logc_distribucion = cld.id  
							WHERE  cs.nombre LIKE :filtro2
							ORDER BY cs.id DESC 
							LIMIT :empezardesde , :tamagnopaginas ";

					$consulta = $this->classConexion->getConexion()->prepare($SQL);	
					//se inserta el parametro de busqueda y se ejecuta la consulta
			   		$consulta->bindValue(':filtro2', '%'.$filtro2.'%');	


				} else {

					$SQL = "SELECT 
								cs.id as id, 
								CONCAT(cs.nombre, cs.version) as NombreVersion,								
								clt.nombre as tipo,
								cld.nombre as distribucion,
								cs.estado as estado 
							FROM  eq_software as cs
								LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id 										
								LEFT JOIN cfg_c_logc_distribucion as cld ON cs.id_c_logc_distribucion = cld.id  
							WHERE clt.id = :filtro1 AND  cs.nombre LIKE :filtro2
							ORDER BY cs.id DESC 
							LIMIT :empezardesde , :tamagnopaginas ";

					$consulta = $this->classConexion->getConexion()->prepare($SQL);
					//se inserta el parametro de busqueda y se ejecuta la consulta
			   		$consulta->bindValue(':filtro1', $filtro1);		
			   		$consulta->bindValue(':filtro2', '%'.$filtro2.'%');	

				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id' => $r->id,
										'NombreVersion' => $r->NombreVersion,
										'tipo' => $r->tipo,
										'distribucion' => $r->distribucion,
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
		public function getTotalPaginas($filtro1,$filtro2,$getTotalPaginas)
		{
			try
			{

				if(empty($filtro1) && empty($filtro2)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT COUNT(*) as num_filas 
											FROM eq_software 
										");


				}elseif(empty($filtro2) && !empty($filtro1)) {

					$consulta = $this->classConexion->getConexion()->
								prepare(" 	SELECT COUNT(*) as num_filas 
											FROM eq_software 
											WHERE id_c_logc_tipo = :filtro1
										");
					//se inserta el parametro de busqueda y se ejecuta la consulta
			   		$consulta->bindValue(':filtro1', $filtro1);	

				}elseif(empty($filtro1) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT COUNT(*) as num_filas 
											FROM eq_software 
											WHERE nombre LIKE :filtro2
										");
					//se inserta el parametro de busqueda y se ejecuta la consulta
			   		$consulta->bindValue(':filtro2', '%'.$filtro2.'%');	

				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare(" 	SELECT COUNT(*) as num_filas 
											FROM eq_software 
											WHERE id_c_logc_tipo = :filtro1 AND  nombre LIKE :filtro2
										");
					//se inserta el parametro de busqueda y se ejecuta la consulta
			   		$consulta->bindValue(':filtro1', $filtro1);		
			   		$consulta->bindValue(':filtro2', '%'.$filtro2.'%');	

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
