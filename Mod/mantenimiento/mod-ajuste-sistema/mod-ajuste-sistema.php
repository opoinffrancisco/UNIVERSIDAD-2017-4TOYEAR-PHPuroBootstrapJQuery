<?php

	class modAjusteSistema extends ajuste_sistema  {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function editar(ajuste_sistema $data)
		{
			try 
				{
				$consulta = $this->classConexion->getConexion()
									->prepare("UPDATE cfg_configuracion SET 
													frecuencia_suspension = :frecuencia_suspension,
													dias_proximidad_tarea = :dias_proximidad_tarea 										
			    								WHERE id = :id ");
			   	$consulta->bindValue(':id', $data->__GET('id'));										
			    $consulta->bindValue(':frecuencia_suspension', $data->__GET('frecuencia_suspension'));    
			    $consulta->bindValue(':dias_proximidad_tarea', $data->__GET('dias_proximidad_tarea'));    

		     	$resultado = $consulta->execute();
				return 1;
			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(ajuste_sistema $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_configuracion (
															frecuencia_suspension,
															dias_proximidad_tarea 
														) 
						        				VALUES (
							        				    	:frecuencia_suspension,
							        				    	:dias_proximidad_tarea 
						        				    	)"
							);

		     	$consulta->bindValue(':frecuencia_suspension', $data->__GET('frecuencia_suspension')); 
			    $consulta->bindValue(':dias_proximidad_tarea', $data->__GET('dias_proximidad_tarea'));  

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
		public function consultar()
		{
			try 
			{
				
				$consulta = $this->classConexion->getConexion()
								->prepare(" SELECT 
												id as id,					
												frecuencia_suspension,
												dias_proximidad_tarea 
											FROM cfg_configuracion  ");
				$consulta->execute();
				//
				$entidadResultados=0;
				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$entidadResultados = new ajuste_sistema();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('frecuencia_suspension', $r->frecuencia_suspension);				
					$entidadResultados->__SET('dias_proximidad_tarea', $r->dias_proximidad_tarea);				
				}					
				
				$consulta = $this->classConexion->getCerrarSesion();					
				return $entidadResultados;
			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
   }	
		
?>
