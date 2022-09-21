<?php

	class modInterfazConexion {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(interfazConexion $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_c_fisc_interfaz_conexion SET 
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
		public function editar(interfazConexion $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_c_fisc_interfaz_conexion SET 
										id			= :id ,
										nombre          = :nombre 
								    WHERE id = :id "
							);
			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));

		     	$resultado = $consulta->execute();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(interfazConexion $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_c_fisc_interfaz_conexion (
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
												id as id,
												nombre as nombre,
											    estado as estadoModelo
											FROM    cfg_c_fisc_interfaz_conexion 
											WHERE id = :id "
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new interfazConexion();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('estado', $r->estadoModelo);

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
											    estado as estadoModelo
											FROM    cfg_c_fisc_interfaz_conexion 
											ORDER BY id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");



				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													id as id,
													nombre as nombre,
												    estado as estadoModelo
												FROM    cfg_c_fisc_interfaz_conexion as p 
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
										'nombre' => $r->nombre,
										'estadoModelo' => $r->estadoModelo,
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
								prepare("	 	SELECT COUNT(*) as num_filas FROM cfg_c_fisc_interfaz_conexion WHERE id LIKE :id ");
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
