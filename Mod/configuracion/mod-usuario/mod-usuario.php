<?php

	class modUsuario {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		}
 
		public function cambiarEstado(usuario $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_pn_usuario SET 
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
		public function editar(usuario $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_pn_usuario SET 
														usuario	    = :usuario,
														contrasena  = :contrasena,
														id_perfil   = :id_perfil 
								    WHERE id = :id "
							);
			   	$consulta->bindValue(':usuario', $data->__GET('usuario'));			
	         	$consulta->bindValue(':contrasena', $data->__GET('contrasena'));
	         	$consulta->bindValue(':id_perfil', $data->__GET('id_perfil'));	         	
	         	$consulta->bindValue(':id', $data->__GET('id'));

		     	$resultado = $consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				return $data->__GET('id');

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(usuario $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_pn_usuario (
															usuario,
															contrasena,
															id_perfil,
															estado
														) 
		        								  VALUES (
				        									:usuario, 
				        									:contrasena,
				        									:id_perfil, 
				        									:estado
		        										)"
							);

			   	$consulta->bindValue(':usuario', $data->__GET('usuario'));			
	         	$consulta->bindValue(':contrasena', $data->__GET('contrasena'));
	         	$consulta->bindValue(':id_perfil', $data->__GET('id_perfil'));

	         	$consulta->bindValue(':estado', 1); 

		     	$consulta->execute();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return  $this->classConexion->getUltimoIdGuardado();

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function consultarCambiarPorVerificarsession($id)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
					   					"SELECT 
					   							* 
					   					FROM cfg_pn_usuario 
					   					WHERE id = :id"
					   				);
				          
		   		$consulta->bindValue(':id', $id);

				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new usuario();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('usuario', $r->usuario);
					$entidadResultados->__SET('contrasena', $r->contrasena);

					return $entidadResultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}		
   }		
?>
