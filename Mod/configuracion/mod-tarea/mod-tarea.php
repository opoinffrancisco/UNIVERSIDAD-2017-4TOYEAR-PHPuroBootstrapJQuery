<?php

	class modTarea extends tarea {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(tarea $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_tarea SET 
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
		public function editar(tarea $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_tarea SET 
										id				 = :id ,
										nombre      	 = :nombre, 
										tarea_correctiva = :tarea_correctiva,
										descripcion		 = :descripcion 
								    WHERE id = :id "
							);
			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':descripcion', $data->__GET('descripcion'));
		     	$consulta->bindValue(':tarea_correctiva', $data->__GET('tarea_correctiva'));

		     	$resultado = $consulta->execute();

				return $data->__GET('id');

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(tarea $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_tarea (
															nombre, 
															descripcion, 
															tarea_correctiva,
															estado
														) 
						        				VALUES (
							        				    	:nombre,
							        				    	:descripcion,	
							        				    	:tarea_correctiva,													 							        				    	
							        				    	:estado
						        				    	)"
							);

		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':descripcion', $data->__GET('descripcion'));
		     	$consulta->bindValue(':tarea_correctiva', $data->__GET('tarea_correctiva'));		     	
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
												id,
												nombre ,
												descripcion,
												tarea_correctiva,
											    estado as estadoTarea
											FROM cfg_tarea 
											WHERE id = :id "
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new tarea();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('descripcion', $r->descripcion);
					$entidadResultados->__SET('tarea_correctiva', $r->tarea_correctiva);
					$entidadResultados->__SET('estado', $r->estadoTarea);

					return $entidadResultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
		public function Listar($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				if(empty($filtro)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												id as id,
												nombre as nombre,
												tarea_correctiva,
											    estado as estadoTarea
											FROM    cfg_tarea 
											ORDER BY id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");



				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													id as id,
													nombre as nombre,
													tarea_correctiva,
												    estado as estadoTarea
												FROM    cfg_tarea 
												WHERE nombre LIKE :nombre
												ORDER BY id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id' => $r->id,
										'nombre' => utf8_encode($r->nombre),
										'tarea_correctiva' => $r->tarea_correctiva,
										'estadoTarea' => $r->estadoTarea,
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
		public function getTotalPaginas($filtro,$getTotalPaginas)
		{
			try
			{
					// hay que validar 2 SQL aca uno por parametro y otro sin
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT COUNT(*) as num_filas FROM cfg_tarea WHERE id LIKE :id ");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id', '%'.$filtro.'%');
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
