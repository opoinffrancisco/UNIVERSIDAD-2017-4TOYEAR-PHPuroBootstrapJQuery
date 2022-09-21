<?php

	class modPersonaEjecuta extends personaEjecuta{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		// FIN DE GESTIN DE CONSULTA
		/***************************************************************************************/
		public function guardoMant(mantenimiento $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO mantenimiento (
															`observacion`,
															`fecha_i`,
															`fecha_f`, 
															`estado`,
															`id_tipo_mant`,
															`id_tarea_equipo`,
															`id_solicitud`
														) 
						        				VALUES (
						        							:observacion,
							        				    	now(),
							        				    	now(),
							        				    	:estado,
							        				    	:id_tipo_mant,
							        				    	:id_tarea_equipo,
							        				    	:id_solicitud
						        				    	)");

		     	$consulta->bindValue(':observacion', $data->__GET('observacion'));
		     	$consulta->bindValue(':estado', $data->__GET('estado'));
		     	$consulta->bindValue(':id_tipo_mant', $data->__GET('id_tipo_mant'));
		     	$consulta->bindValue(':id_tarea_equipo', $data->__GET('id_tarea_equipo'));
		     	$consulta->bindValue(':id_solicitud', $data->__GET('id_solicitud'));

		     	$consulta->execute();
		     	$ultimoId = $this->classConexion->getUltimoIdGuardado();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return ($ultimoId>0) ? $ultimoId : 0 ;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardarPersonaEjecuta($detalles,$id_persona,$id_funcion_persona,$id_mantenimiento) {
			try 
			{
				if($id_persona!=0){
				    //$this->classConexion->getConexion()->beginTransaction();
			


					/******************************************/
					$consulta = $this->classConexion->getConexion()->
								prepare(
										"INSERT INTO persona_ejecuta (
																detalles, 
																fecha,
																id_persona,
																id_funcion_persona,
																id_mantenimiento
															) 
							        				VALUES (
								        				    	:detalles,
								        				    	sysdate(3),
								        				    	:id_persona,
							        				    		:id_funcion_persona,
							        				    		:id_mantenimiento	
							        				    	)"
								);
			     	$consulta->bindValue(':detalles', 			$detalles);
			     	$consulta->bindValue(':id_persona', 		$id_persona);
			     	$consulta->bindValue(':id_funcion_persona', $id_funcion_persona);
			     	$consulta->bindValue(':id_mantenimiento', 	$id_mantenimiento);

			     	$consulta->execute();
					$consulta = $this->classConexion->getCerrarSesion();

			     	//$this->classConexion->getConexion()->commit();
			     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
			     	// que la ejecucion fue exitosa
				}
				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
	
   }	
		
?>
