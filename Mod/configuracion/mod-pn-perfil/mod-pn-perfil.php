<?php

	class modPerfil {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function cambiarEstado(perfil $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_pn_perfil SET 
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
		public function editar(perfil $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_pn_perfil SET 
										id				= :id ,
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
		public function guardar(perfil $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO cfg_pn_perfil (
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
		     	$ultimoId = $this->classConexion->getUltimoIdGuardado();		     	
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
											    estado as estadoPerfil
											FROM    cfg_pn_perfil 
											WHERE id = :id "
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new perfil();

					$entidadResultados->__SET('id', $r->id);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('estado', $r->estadoPerfil);

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
											    estado as estadoPerfil
											FROM    cfg_pn_perfil 
											ORDER BY id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");



				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													id as id,
													nombre as nombre,
												    estado as estadoPerfil
												FROM    cfg_pn_perfil as p 
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
					$id_perfil = $r->id;
					if($id_perfil!=0){
						$result[] = array(
											'id' => $id_perfil,
											'nombre' => $r->nombre,
											'estadoPerfil' => $r->estadoPerfil,
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

		public function verificarModuloAsignado($dataP, $dataM)
		{
			try 
				{
					$consulta = $this->classConexion->getConexion()->
						        prepare(
												" SELECT * FROM `cfg_pn_perfil_permiso` WHERE id_perfil = :perfil AND id_modulo = :modulo "
						   				);
					          
			     	$consulta->bindValue(':perfil', $dataP);
			     	$consulta->bindValue(':modulo', $dataM);
					$consulta->execute();
					$r = $consulta->fetch(PDO::FETCH_OBJ);
					$consulta = $this->classConexion->getCerrarSesion();

					if ($r) {
						return 1;
					}
					return 0;
			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}		

		public function asignarModulo(perfil $dataP, modulo $dataM)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO `cfg_pn_perfil_permiso`
									(
										`id_perfil`,
										`id_modulo`,
										`permiso_acceso`
									) VALUES (
										:perfil,
										:modulo,
										:permiso
									);"
							);

		     	$consulta->bindValue(':perfil', $dataP->__GET('id'));
		     	$consulta->bindValue(':modulo', $dataM->__GET('id'));
		     	$consulta->bindValue(':permiso', 1);

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
		public function cambiarPermiso(perfil_Permiso $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE cfg_pn_perfil_permiso SET 
											permiso_acceso			= :permiso
									    WHERE id = :id "
									);

			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':permiso', $data->__GET('permiso_acceso'));

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
		public function cambiarPermisosAccionesModulo(perfil_Permiso $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(

									"UPDATE cfg_pn_perfil_permiso SET 

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
		public function consultarPermisosAccionesModulo($id)
		{
			$result = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
											"SELECT 
                                             	p_am.id_perfil,
												m.nombre as modulo,
											    p_am.func_nuevo,
											    p_am.func_editar,
											    p_am.func_eliminacion_logica,
											    p_am.func_generar_reporte,
											    p_am.func_generar_reporte_filtrado,
											    p_am.func_permisos_perfil,
											    p_am.func_busqueda_avanzada,
											    p_am.func_detalles,
											    p_am.func_atender,
											    p_am.func_asignar,
											    p_am.func_programar_tarea,
											    p_am.func_iniciar_finalizar_tarea,
											    p_am.func_diagnosticar,
											    p_am.func_gestion_equipo_mantenimiento,
											    p_am.func_respuesta_solicitud,
											    p_am.func_finalizar_solicitud, 
												/***/
											    p_am.func_desincorporar_equipo,											    
											    p_am.func_desincorporar_periferico,											    
											    p_am.func_desincorporar_componente,											    
											    p_am.func_cambiar_periferico,											    
											    p_am.func_cambiar_componente,											    
											    p_am.func_cambiar_software,											    
											    p_am.func_inconformidad_atendida 											    
											FROM  cfg_pn_perfil_permiso as p_am 
											INNER JOIN mtn_modulo as m ON m.id = p_am.id_modulo
											WHERE  p_am.id = :id "
					   				);
				          
			 $consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					$result[] = array(
										'modulo' => $r->modulo,
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
		public function ListarModulosAsignados(perfil $dataP)
		{
			$result = array();
			try
			{
	
				$consulta = $this->classConexion->getConexion()->
							prepare("	SELECT 
											m.id as mId, 
											m.nombre as mNombre, 
				                            pn_pp.id as pmId,
				                            pn_pp.id_perfil as pmId_perfil,
				                            pn_pp.id_modulo as pmId_modulo,
				                            pn_pp.permiso_acceso as pmPermiso_acceso                                                
										FROM 
											    `mtn_modulo` AS m 
				                            INNER JOIN `cfg_pn_perfil_permiso` AS pn_pp ON m.id = pn_pp.id_modulo
											WHERE m.estado = 1 AND pn_pp.id_perfil = :perfil 
									");

		     	$consulta->bindValue(':perfil', $dataP->__GET('id'));
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'mId' => $r->mId,
										'mNombre' => $r->mNombre,
										'pmId' => $r->pmId,
										'pmId_perfil' => $r->pmId_perfil,
			                            'pmId_modulo' =>  $r->pmId_modulo,
										'pmPermiso_acceso' => $r->pmPermiso_acceso,										
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
								prepare("	 	SELECT COUNT(*) as num_filas FROM cfg_pn_perfil WHERE id LIKE :id ");
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
