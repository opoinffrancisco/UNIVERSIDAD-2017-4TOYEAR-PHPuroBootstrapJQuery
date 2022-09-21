<?php

	class modPersona extends persona{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(persona $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_persona SET 
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
		public function editar(persona $data,$sinfoto)
		{
			try 
			{

	
					$SQL="UPDATE cfg_persona SET 
											cedula			= :cedula,
											nombre          = :nombre, 
											apellido        = :apellido,
											correo_electronico = :correo_electronico 
									    WHERE id = :id ";
		

				$consulta = $this->classConexion->getConexion()->prepare($SQL);

			   	$consulta->bindValue(':id', $data->__GET('id'));										
			   	$consulta->bindValue(':cedula', $data->__GET('cedula'));			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':apellido', $data->__GET('apellido'));
		     	$consulta->bindValue(':correo_electronico', $data->__GET('correo_electronico'));
				
				$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				// con fotooo
				if($sinfoto==0){

					$SQL="UPDATE cfg_persona_foto SET 
										formato_foto       = :formato_foto, 
										foto 	        = :foto 										
								    WHERE id_persona = :id_persona ";

					$consulta = $this->classConexion->getConexion()->prepare($SQL);

			   		$consulta->bindValue(':id_persona', $data->__GET('id'));										
			     	$consulta->bindValue(':formato_foto', $data->__GET('formato_foto'));
			     	$consulta->bindValue(':foto',  'data:image/jpeg;base64,'.base64_encode($data->__GET('foto')));				     	
					$consulta->execute();
					$consulta = $this->classConexion->getCerrarSesion();

		     	}
		     	//$consulta->bindValue(':id_departamento', $data->__GET('id_departamento'));


				return $data->__GET('id');

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(persona $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_persona (
															cedula, 
															nombre, 
															apellido,
															correo_electronico,
															estado, 
															id_usuario
														) 
						        				VALUES (
							        						:cedula,
							        				    	:nombre,
							        				    	:apellido,
							        				    	:correo_electronico,
							        				    	:estado,
							        				    	:id_usuario
						        				    	)"
							);

			   	$consulta->bindValue(':cedula', $data->__GET('cedula'));			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':apellido', $data->__GET('apellido'));
		     	$consulta->bindValue(':correo_electronico', $data->__GET('correo_electronico'));
		     	$consulta->bindValue(':estado', 1);
		     	$consulta->bindValue(':id_usuario', $data->__GET('id_usuario'));
		     	//$consulta->bindValue(':id_departamento', $data->__GET('id_departamento'));

		     	$consulta->execute();
		     	$ultimoId=$this->classConexion->getUltimoIdGuardado();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();

				//------------- guardando foto
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_persona_foto (
															formato_foto,
															foto,
															id_persona 
														) 
						        				VALUES (
															:formato_foto,
															:foto, 							        				    	
							        				    	:id_persona 
						        				    	)"
							);

		     	$consulta->bindValue(':formato_foto', $data->__GET('formato_foto'));
		     	$consulta->bindValue(':foto',  'data:image/jpeg;base64,'.base64_encode($data->__GET('foto')));				     	
		     	$consulta->bindValue(':id_persona', $ultimoId);

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();
				//-------------Fin guardando foto



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
											"SELECT 
												p.id as id,																				
												p.cedula as cedula,
												p.nombre as nombre,
												p.apellido as apellido, 
												p.correo_electronico ,   
												f.formato_foto as formato_foto,
												f.foto as foto,    												
											    p.estado as estadoPersona,
											    u.id as id_usuario,
											    u.usuario as usuario,
											    u.contrasena as contrasena,
											    u.id_perfil as id_perfil,											    
											    u.estado as estadoUsuario
											FROM    cfg_persona as p 
												INNER JOIN cfg_pn_usuario as u ON p.id_usuario = u.id
												LEFT JOIN cfg_persona_foto as f ON f.id_persona = p.id 
											WHERE p.id = :id"
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new persona();
					//
					$usuario = new usuario();
					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('cedula', $r->cedula);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('apellido', $r->apellido);
					$entidadResultados->__SET('correo_electronico', $r->correo_electronico);
					$entidadResultados->__SET('formato_foto', $r->formato_foto);
					$entidadResultados->__SET('foto', $r->foto);					
					//$entidadResultados->__SET('id_departamento', $r->id_departamento);					
					$entidadResultados->__SET('estado', $r->estadoPersona);
					$entidadResultados->__SET('id_usuario', $usuario);
					$entidadResultados->__GET('id_usuario')->__SET('id', $r->id_usuario);					
					$entidadResultados->__GET('id_usuario')->__SET('usuario', $r->usuario);
					$entidadResultados->__GET('id_usuario')->__SET('contrasena', $r->contrasena);	
					$entidadResultados->__GET('id_usuario')->__SET('id_perfil', $r->id_perfil);	
					$entidadResultados->__GET('id_usuario')->__SET('estado', $r->estadoUsuario);

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
												p.id as id,
												p.cedula as cedula,
												p.nombre as nombre,
												p.apellido as apellido,    
											    p.estado as estadoPersona,
											    u.id as id_usuario,
											    u.usuario as usuario,
											    u.contrasena as contrasena,
											   	u.id_perfil as id_perfil,	
										    	pf.nombre as nombre_perfil,										    												    
											    u.estado as estadoUsuario
												FROM    cfg_persona as p 
													INNER JOIN cfg_pn_usuario as u ON p.id_usuario = u.id
													INNER JOIN cfg_pn_perfil as pf ON pf.id = u.id_perfil
											ORDER BY id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");



				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													p.id as id,									
													p.cedula as cedula,
													p.nombre as nombre,
													p.apellido as apellido,    
												    p.estado as estadoPersona,
												    u.id as id_usuario,
												    u.usuario as usuario,
												    u.contrasena as contrasena,
											    	u.id_perfil as id_perfil,	
											    	pf.nombre as nombre_perfil,										    												    
												    u.estado as estadoUsuario
												FROM    cfg_persona as p 
													INNER JOIN cfg_pn_usuario as u ON p.id_usuario = u.id
													INNER JOIN cfg_pn_perfil as pf ON pf.id = u.id_perfil
												WHERE p.cedula LIKE :cedula
												ORDER BY id DESC 
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':cedula', '%'.$filtro.'%');	

				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$id_persona = $r->id;
					if($id_persona!=0){
						$result[] = array(
											'id' => $id_persona,						
											'cedula' => $r->cedula,
											'nombre' => utf8_encode($r->nombre),
											'apellido' => utf8_encode($r->apellido),
											'estadoPersona' => $r->estadoPersona, 
											'id_usuario' => $r->id_usuario,
											'usuario' => $r->usuario,
											'contrasena' => $r->contrasena,
											'id_perfil' => $r->id_perfil,
											'nombre_perfil' => $r->nombre_perfil,
											'estadoUsuario' => $r->estadoUsuario, 
										);
					}
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
								prepare("	 	SELECT COUNT(*) as num_filas FROM cfg_persona WHERE cedula LIKE :cedula ");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':cedula', '%'.$filtro.'%');


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
