<?php

	class modDepartamento extends departamento{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(departamento $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_departamento SET 
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
		public function editar(departamento $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_departamento SET 
										id			= :id ,
										nombre          = :nombre 
								    WHERE id = :id "
							);
				$id_departamento = $data->__GET('id');							
			   	$consulta->bindValue(':id', $id_departamento);			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));

		     	$resultado = $consulta->execute();

				return $id_departamento;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(departamento $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_departamento (
															nombre, 
															estado
														) 
						        				VALUES (
							        				    	:nombre,
							        				    	:estado
						        				    	)"
							);

		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':estado', 1);

		     	$consulta->execute();
				$ultimoId =$this->classConexion->getUltimoIdGuardado();
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
												id as id,
												nombre as nombre,
											    estado as estadoDepartamento
											FROM    cfg_departamento 
											WHERE id = :id "
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new departamento();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('nombre', utf8_encode($r->nombre));
					$entidadResultados->__SET('estado', utf8_encode($r->estadoDepartamento));

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
											    estado as estadoDepartamento
											FROM    cfg_departamento 
											ORDER BY id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");



				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													id as id,
													nombre as nombre,
												    estado as estadoDepartamento
												FROM    cfg_departamento as p 
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
										'estadoDepartamento' => $r->estadoDepartamento,
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
								prepare("	 	SELECT COUNT(*) as num_filas FROM cfg_departamento WHERE id LIKE :id ");
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


///////////////////////////////////////////////////////////////////////



		public function guardarDepartamentoCargo(departamentoCargo $data)
		{

			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_departamento_cargo (
															id_departamento, 
															id_cargo,
															estado
														) 
						        				VALUES (
															:id_departamento, 
															:id_cargo,
															:estado
						        				    	)"
							);

		     	$consulta->bindValue(':id_departamento', $data->__GET('id_departamento'));
		     	$consulta->bindValue(':id_cargo', $data->__GET('id_cargo'));
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
		public function ListarDepartamentoCargo($id_departamento)
		{ 
			$result = array();
			try
			{
		
				$consulta = $this->classConexion->getConexion()->
							prepare("	SELECT 
											 dc.id_cargo,
										     c.nombre,
										 	 dc.estado,     
											 dc.id_departamento as idDepartamento  
										FROM `cfg_departamento_cargo` as dc 
										INNER JOIN  cfg_departamento as d ON dc.id_departamento =  d.id 
										INNER JOIN  cfg_pn_cargo as c ON dc.id_cargo =  c.id 
										WHERE dc.id_departamento=:id_departamento
									");



				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':id_departamento', $id_departamento);			
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_cargo' => $r->id_cargo,
										'nombre' => $r->nombre,
										'estado' => $r->estado,
										'idDepartamento' => $r->idDepartamento,
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
		public function cambiarEstadoDepartamentoCargo(departamentoCargo $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_departamento_cargo SET 
											estado			= :estado
									    WHERE id_departamento = :id_departamento AND id_cargo = :id_cargo "
									);

			   	$consulta->bindValue(':id_departamento', $data->__GET('id_departamento'));			
			   	$consulta->bindValue(':id_cargo', $data->__GET('id_cargo'));			
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
