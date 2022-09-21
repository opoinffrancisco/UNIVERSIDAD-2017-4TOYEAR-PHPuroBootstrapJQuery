<?php

	class modConfiguracion extends configuracion {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function editar(configuracion $data,$sinfoto)
		{
			try 
			{

				$SQL="UPDATE cfg_configuracion SET 
										nombre          = :nombre, 
										formato_logo       = :formato_logo, 
										logo 	        = :logo
								    WHERE id = :id ";
				if ($sinfoto==1) {
					$SQL="UPDATE cfg_configuracion SET 
											nombre          = :nombre 
									  WHERE id = :id ";
			    }				    


				$consulta = $this->classConexion->getConexion()->prepare($SQL);

			   	$consulta->bindValue(':id', $data->__GET('id'));										
		     $consulta->bindValue(':nombre', $data->__GET('nombre'));
							
	        if($sinfoto==0){//con logo
				$consulta->bindValue(':formato_logo', $data->__GET('formato_logo'));
		   		$consulta->bindValue(':logo', 'data:image/jpeg;base64,'.base64_encode($data->__GET('logo')));				     		     	
			}

		     	$resultado = $consulta->execute();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(configuracion $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_configuracion (
															nombre,
															formato_logo,
															logo
														) 
						        				VALUES (
							        				    	:nombre,
															:formato_logo,
															:logo 						        				    	
						        				    	)"
							);

		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':formato_logo', $data->__GET('formato_logo'));
		     	$consulta->bindValue(':logo',  'data:image/jpeg;base64,'.base64_encode($data->__GET('logo')));				     		     	

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
				
				if($id==99999){
					$SQL="					SELECT 
												id as id,					
												nombre as nombre,
												formato_logo as formato_logo,
												logo as logo,
												now() as fecha_actual 
											FROM cfg_configuracion  ";
				}else{
					$SQL="					SELECT 
											id as id,						
											nombre as nombre,
											formato_logo as formato_logo,
											logo as logo,
											now() as fecha_actual
										FROM cfg_configuracion 
										WHERE id = :id ";

				}

				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				if ($id!=99999) { 
			   		$consulta->bindValue(':id', $id);	
			   	}
				$consulta->execute();
				//
				$entidadResultados=0;
				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$entidadResultados = new configuracion();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('formato_logo', $r->formato_logo);
					$entidadResultados->__SET('logo', $r->logo);
					$entidadResultados->__SET('fecha_actual', $r->fecha_actual);

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
