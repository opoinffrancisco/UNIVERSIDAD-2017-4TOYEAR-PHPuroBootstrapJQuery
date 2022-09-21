<?php

	class modModulo extends modulo {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(modulo $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE mtn_modulo SET 
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
		public function editar(modulo $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE mtn_modulo SET 
										id			= :id ,
										nombre      = :nombre, 
										descripcion = :descripcion,
										id_modulo_pertenece = :id_modulo_pertenece,
									   func_nuevo  = :func_nuevo,
									   func_editar = :func_editar,
									   func_eliminacion_logica = :func_eliminacion_logica,
									   func_generar_reporte = :func_generar_reporte,
									   func_generar_reporte_filtrado = :func_generar_reporte_filtrado,
									   func_permisos_perfil = :func_permisos_perfil,
									   func_busqueda_avanzada = :func_busqueda_avanzada,
									   func_detalles = :func_detalles,
									   func_atender = :func_atender,
									   func_asignar = :func_asignar,
									   func_programar_tarea = :func_programar_tarea,
									   func_iniciar_finalizar_tarea = :func_iniciar_finalizar_tarea,
									   func_diagnosticar = :func_diagnosticar,
									   func_gestion_equipo_mantenimiento = :func_gestion_equipo_mantenimiento,
									   func_respuesta_solicitud = :func_respuesta_solicitud,
									   func_finalizar_solicitud = :func_finalizar_solicitud,
/*---*/
										func_desincorporar_equipo = :func_desincorporar_equipo,							
										func_desincorporar_periferico = :func_desincorporar_periferico,						
										func_desincorporar_componente = :func_desincorporar_componente,							
										func_cambiar_periferico = :func_cambiar_periferico,									
										func_cambiar_componente = :func_cambiar_componente,									
										func_cambiar_software = :func_cambiar_software,
										func_inconformidad_atendida = :func_inconformidad_atendida
								    WHERE id = :id "
							);
			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':descripcion', $data->__GET('descripcion'));
		     	$consulta->bindValue(':id_modulo_pertenece', $data->__GET('id_modulo_pertenece'));

		     	$consulta->bindValue(':func_nuevo', $data->__GET('func_nuevo'));
		     	$consulta->bindValue(':func_editar', $data->__GET('func_editar'));
		     	$consulta->bindValue(':func_eliminacion_logica', 
		    							 		$data->__GET('func_eliminacion_logica'));
		     	$consulta->bindValue(':func_generar_reporte',
		     								 $data->__GET('func_generar_reporte'));
		     	$consulta->bindValue(':func_generar_reporte_filtrado',
		    								 	 $data->__GET('func_generar_reporte_filtrado'));
		     	$consulta->bindValue(':func_permisos_perfil', 
		     									$data->__GET('func_permisos_perfil'));
		     	$consulta->bindValue(':func_busqueda_avanzada',
		     								 $data->__GET('func_busqueda_avanzada'));
		     	$consulta->bindValue(':func_detalles', $data->__GET('func_detalles'));
		     	$consulta->bindValue(':func_atender', $data->__GET('func_atender'));
		     	$consulta->bindValue(':func_asignar', $data->__GET('func_asignar'));
		     	$consulta->bindValue(':func_programar_tarea', 
		     									$data->__GET('func_programar_tarea'));
		     	$consulta->bindValue(':func_iniciar_finalizar_tarea',
		     								 $data->__GET('func_iniciar_finalizar_tarea'));
		     	$consulta->bindValue(':func_diagnosticar', $data->__GET('func_diagnosticar'));
		     	$consulta->bindValue(':func_gestion_equipo_mantenimiento', 
		     									$data->__GET('func_gestion_equipo_mantenimiento'));
		     	$consulta->bindValue(':func_respuesta_solicitud', 
		     									$data->__GET('func_respuesta_solicitud'));
		     	$consulta->bindValue(':func_finalizar_solicitud', 
		     									$data->__GET('func_finalizar_solicitud'));

				//--
		     	$consulta->bindValue(':func_desincorporar_equipo', 
		     									$data->__GET('func_desincorporar_equipo'));
		     	$consulta->bindValue(':func_desincorporar_periferico', 
		     									$data->__GET('func_desincorporar_periferico'));
		     	$consulta->bindValue(':func_desincorporar_componente', 
		     									$data->__GET('func_desincorporar_componente'));
		     	$consulta->bindValue(':func_cambiar_periferico', 
		     									$data->__GET('func_cambiar_periferico'));
		     	$consulta->bindValue(':func_cambiar_componente', 
		     									$data->__GET('func_cambiar_componente'));
		     	$consulta->bindValue(':func_cambiar_software', 
		     									$data->__GET('func_cambiar_software'));
		     	$consulta->bindValue(':func_inconformidad_atendida', 
		     									$data->__GET('func_inconformidad_atendida'));



		     	$resultado = $consulta->execute();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardar(modulo $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO mtn_modulo (
															nombre, 
															descripcion, 
															id_modulo_pertenece,
											    func_nuevo,
											    func_editar,
											    func_eliminacion_logica,
											    func_generar_reporte,
											    func_generar_reporte_filtrado,
											    func_permisos_perfil,
											    func_busqueda_avanzada,
											    func_detalles,
											    func_atender,
											    func_asignar,
											    func_programar_tarea,
											    func_iniciar_finalizar_tarea,
											    func_diagnosticar,
											    func_gestion_equipo_mantenimiento,
											    func_respuesta_solicitud,
											    func_finalizar_solicitud,														

												/***/
											    func_desincorporar_equipo,											    
											    func_desincorporar_periferico,											    
											    func_desincorporar_componente,											    
											    func_cambiar_periferico,											    
											    func_cambiar_componente,											    
											    func_cambiar_software,											    
											    func_inconformidad_atendida,

												/****/
															estado
														) 
						        				VALUES (
							        				    	:nombre,
							        				    	:descripcion,		
							        				    	:id_modulo_pertenece,
																				    :func_nuevo,
																				    :func_editar,
																				    :func_eliminacion_logica,
																				    :func_generar_reporte,
																				    :func_generar_reporte_filtrado,
																				    :func_permisos_perfil,
																				    :func_busqueda_avanzada,
																				    :func_detalles,
																				    :func_atender,
																				    :func_asignar,
																				    :func_programar_tarea,
																				    :func_iniciar_finalizar_tarea,
																				    :func_diagnosticar,
																				    :func_gestion_equipo_mantenimiento,
																				    :func_respuesta_solicitud,
																				    :func_finalizar_solicitud,
												/****/
																				    :func_desincorporar_equipo,
																				    :func_desincorporar_periferico,  
																				    :func_desincorporar_componente,  
																				    :func_cambiar_periferico,  
																				    :func_cambiar_componente,  
																				    :func_cambiar_software,					
																				    :func_inconformidad_atendida,

												/***/
							        				    	:estado
						        				    	)"
							);

		     	$consulta->bindValue(':nombre', $data->__GET('nombre'));
		     	$consulta->bindValue(':descripcion', $data->__GET('descripcion'));
		     	$consulta->bindValue(':id_modulo_pertenece', $data->__GET('id_modulo_pertenece'));

		     	$consulta->bindValue(':func_nuevo', $data->__GET('func_nuevo'));
		     	$consulta->bindValue(':func_editar', $data->__GET('func_editar'));
		     	$consulta->bindValue(':func_eliminacion_logica', 
		    							 		$data->__GET('func_eliminacion_logica'));
		     	$consulta->bindValue(':func_generar_reporte',
		     								 $data->__GET('func_generar_reporte'));
		     	$consulta->bindValue(':func_generar_reporte_filtrado',
		    								 	 $data->__GET('func_generar_reporte_filtrado'));
		     	$consulta->bindValue(':func_permisos_perfil', 
		     									$data->__GET('func_permisos_perfil'));
		     	$consulta->bindValue(':func_busqueda_avanzada',
		     								 $data->__GET('func_busqueda_avanzada'));
		     	$consulta->bindValue(':func_detalles', $data->__GET('func_detalles'));
		     	$consulta->bindValue(':func_atender', $data->__GET('func_atender'));
		     	$consulta->bindValue(':func_asignar', $data->__GET('func_asignar'));
		     	$consulta->bindValue(':func_programar_tarea', 
		     									$data->__GET('func_programar_tarea'));
		     	$consulta->bindValue(':func_iniciar_finalizar_tarea',
		     								 $data->__GET('func_iniciar_finalizar_tarea'));
		     	$consulta->bindValue(':func_diagnosticar', $data->__GET('func_diagnosticar'));
		     	$consulta->bindValue(':func_gestion_equipo_mantenimiento', 
		     									$data->__GET('func_gestion_equipo_mantenimiento'));
		     	$consulta->bindValue(':func_respuesta_solicitud', 
		     									$data->__GET('func_respuesta_solicitud'));
		     	$consulta->bindValue(':func_finalizar_solicitud', 
		     									$data->__GET('func_finalizar_solicitud'));
				//--
		     	$consulta->bindValue(':func_desincorporar_equipo', 
		     									$data->__GET('func_desincorporar_equipo'));
		     	$consulta->bindValue(':func_desincorporar_periferico', 
		     									$data->__GET('func_desincorporar_periferico'));
		     	$consulta->bindValue(':func_desincorporar_componente', 
		     									$data->__GET('func_desincorporar_componente'));
		     	$consulta->bindValue(':func_cambiar_periferico', 
		     									$data->__GET('func_cambiar_periferico'));
		     	$consulta->bindValue(':func_cambiar_componente', 
		     									$data->__GET('func_cambiar_componente'));
		     	$consulta->bindValue(':func_cambiar_software', 
		     									$data->__GET('func_cambiar_software'));
		     	$consulta->bindValue(':func_inconformidad_atendida', 
		     									$data->__GET('func_inconformidad_atendida'));



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
			$result = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
											" SELECT 
															id as id,
															nombre as nombre,
															descripcion as descripcion,
											    estado as estadoModulo,
															id_modulo_pertenece,

											    func_nuevo,
											    func_editar,
											    func_eliminacion_logica,
											    func_generar_reporte,
											    func_generar_reporte_filtrado,
											    func_permisos_perfil,
											    func_busqueda_avanzada,
											    func_detalles,
											    func_atender,
											    func_asignar,
											    func_programar_tarea,
											    func_iniciar_finalizar_tarea,
											    func_diagnosticar,
											    func_gestion_equipo_mantenimiento,
											    func_respuesta_solicitud,
											    func_finalizar_solicitud,
												/***/
											    func_desincorporar_equipo,											    
											    func_desincorporar_periferico,											    
											    func_desincorporar_componente,											    
											    func_cambiar_periferico,											    
											    func_cambiar_componente,											    
											    func_cambiar_software,											    
											    func_inconformidad_atendida 
											FROM    mtn_modulo 
											WHERE id = :id "
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					$result[] = array(
								'id' => $r->id,
								'nombre' => $r->nombre,
								'descripcion' => $r->descripcion,
								'estadoModulo' => $r->estadoModulo,
								'id_modulo_pertenece' => $r->id_modulo_pertenece,								


								'func_nuevo' => $r->func_nuevo,
								'func_editar' => $r->func_editar,
								'func_eliminacion_logica' => $r->func_eliminacion_logica,
								'func_generar_reporte' => $r->func_generar_reporte,
								'func_generar_reporte_filtrado' => $r->func_generar_reporte_filtrado,
								'func_permisos_perfil' => $r->func_permisos_perfil,
								'func_busqueda_avanzada' => $r->func_busqueda_avanzada,
								'func_detalles' => $r->func_detalles,
								'func_atender' => $r->func_atender,
								'func_asignar' => $r->func_asignar,
								'func_programar_tarea' => $r->func_programar_tarea,
								'func_iniciar_finalizar_tarea' => $r->func_iniciar_finalizar_tarea,
								'func_diagnosticar' => $r->func_diagnosticar,
								'func_gestion_equipo_mantenimiento' => $r->func_gestion_equipo_mantenimiento,
								'func_respuesta_solicitud' => $r->func_respuesta_solicitud,
								'func_finalizar_solicitud' => $r->func_finalizar_solicitud,
								//--
								'func_desincorporar_equipo' => $r->func_desincorporar_equipo,
								'func_desincorporar_periferico' => $r->func_desincorporar_periferico,
								'func_desincorporar_componente' => $r->func_desincorporar_componente,
								'func_cambiar_periferico' => $r->func_cambiar_periferico,
								'func_cambiar_componente' => $r->func_cambiar_componente,
								'func_cambiar_software' => $r->func_cambiar_software,
								'func_inconformidad_atendida' => $r->func_inconformidad_atendida,


									);		
					return $result;
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
												m.id as id,
												(CASE
												  WHEN mp.id_modulo_pertenece>0 THEN CONCAT(mp_p.nombre, ' - ', mp.nombre, ' - ', m.nombre )         		
												  WHEN m.id_modulo_pertenece>0 AND mp.id_modulo_pertenece=0 THEN CONCAT(mp.nombre, ' - ', m.nombre )     
												  WHEN m.id_modulo_pertenece=0 THEN m.nombre 
											    END) as nombre,
												m.id_modulo_pertenece,
												m.estado as estadoModulo
											FROM mtn_modulo as m
											LEFT JOIN mtn_modulo as mp ON mp.id = m.id_modulo_pertenece
											LEFT JOIN mtn_modulo as mp_p ON mp_p.id = mp.id_modulo_pertenece
											ORDER BY m.id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");



				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													m.id as id,
													(CASE
													  WHEN mp.id_modulo_pertenece>0 THEN CONCAT(mp_p.nombre, ' - ', mp.nombre, ' - ', m.nombre )         		
													  WHEN m.id_modulo_pertenece>0 AND mp.id_modulo_pertenece=0 THEN CONCAT(mp.nombre, ' - ', m.nombre )     
													  WHEN m.id_modulo_pertenece=0 THEN m.nombre 
												    END) as nombre,
													m.id_modulo_pertenece,
													m.estado as estadoModulo
												FROM mtn_modulo as m
												LEFT JOIN mtn_modulo as mp ON mp.id = m.id_modulo_pertenece
												LEFT JOIN mtn_modulo as mp_p ON mp_p.id = mp.id_modulo_pertenece
												WHERE m.nombre LIKE :nombre
												ORDER BY m.id DESC
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
										'estadoModulo' => $r->estadoModulo,
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
								prepare("	 	SELECT COUNT(*) as num_filas FROM mtn_modulo WHERE id LIKE :id ");
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
		public function ListarModulosAsignar(modPerfil $modPerfil , $id_perfil)
		{ 
			$result = array();
			try
			{
				if(empty($filtro)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												m.id as mId, 
												m.nombre as mNombre 
											FROM 
                   							    `mtn_modulo` AS m 
	 										WHERE m.estado = 1 

										");


				} 

				// Gestionando parametros para LIMIT en el SQL
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$id_modulo = $r->mId;
					$resultado_existencia = $modPerfil->verificarModuloAsignado($id_perfil, $id_modulo);
					//die($resultado_existencia.' --  $id_perfil '.$id_perfil.' --  $id_modulo'. $id_modulo);
					if ($resultado_existencia===0) {
						$result[] = array(
											'mId' => $id_modulo,
											'mNombre' => $r->mNombre,
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
   }	
		
?>
