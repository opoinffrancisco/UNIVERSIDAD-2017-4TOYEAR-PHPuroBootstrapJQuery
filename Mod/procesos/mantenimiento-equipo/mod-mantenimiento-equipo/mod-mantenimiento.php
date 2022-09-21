<?php

	class modMantenimiento extends mantenimiento{

		private $classConexion;

		public function __CONSTRUCT()
		{
			
			$this->classConexion = new classConexion();		
		} 

		public function guardarDiagnosticoSolicitud(solt_diagnostico $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO solt_diagnostico (
															`observacion`, 
															`id_solt`,
															`fecha` 					
														) 
						        				VALUES (
							        				    	:observacion,
							        				    	:id_solt,
							        				    	now()
						        				    	)"
							);
		     	$consulta->bindValue(':observacion', $data->__GET('observacion'));
		     	$consulta->bindValue(':id_solt', $data->__GET('id_solt'));

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

		public function guardarRespuestaSolicitud(solt_respuesta $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO solt_respuesta (
															`observacion`, 
															`id_solt`,
															`fecha` 					
														) 
						        				VALUES (
							        				    	:observacion,
							        				    	:id_solt,
							        				    	now()
						        				    	)"
							);
		     	$consulta->bindValue(':observacion', utf8_decode($data->__GET('observacion')));
		     	$consulta->bindValue(':id_solt', $data->__GET('id_solt'));

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
		public function guardarFinalizacionSolicitud( $id_solicitud ,$id_solicitante ,$ip_responsable_finalizar, $observacion )
		{
			/*
					LOS DATOS DEL SOLICITANTE Y DEL RESPNSABLE DE FINALIZAR LA SOLICITUD QUEDAN ACA, 
					TEMPORALMENTE SIN USAR -> hasta cuando pase la fase de visita en este 2do trimestre...
			*/
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				//----------------------------------------------------
				$consulta1 = $this->classConexion->getConexion()->
							prepare(
									"SELECT 
										e.id as id_equipo 
									FROM solicitud as s
									INNER JOIN persona_equipo as pe ON (s.id_persona_asignada!='' AND s.id_persona_asignada=pe.id_persona ) 
															  OR (s.id_persona_asignada='' AND s.id_persona=pe.id_persona )
                                    INNER JOIN equipo as e ON e.id = pe.id_equipo                          
									WHERE s.id = :id_solicitud AND s.estado = 1 AND e.estado=2"
							);
		     	$consulta1->bindValue(':id_solicitud', $id_solicitud);
		     	$consulta1->execute();
				$r1 = $consulta1->fetch(PDO::FETCH_OBJ);		     	
				$consulta1 = $this->classConexion->getCerrarSesion();

				if($r1){
					$consulta2 = $this->classConexion->getConexion()->
								prepare(
										"UPDATE equipo SET
												`estado` = 1
										WHERE id = :id_equipo AND estado = 2 "
								);
			     	$consulta2->bindValue(':id_equipo', $r1->id_equipo);
			     	$consulta2->execute();
					$consulta2 = $this->classConexion->getCerrarSesion();
				}
				//----------------------------------------------------
				// TODO LISTO : FINALIZO SOLICITUD
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE  solicitud SET 
											`fecha_cierre` = now(),
											`observacion_extra` = :observacion_extra,
											`estado` = 2			
										WHERE id = :id_solicitud
									");
		     	$consulta->bindValue(':id_solicitud', $id_solicitud);
		     	$consulta->bindValue(':observacion_extra', $observacion);

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return 1 ;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		public function cambiarEstado(solicitud $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE solicitud SET 
											estado			= :estado,
											fecha_desde     = now() 
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

		public function guardarAtenderInconformidad($id_conformidad)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE solt_conformidad SET 
											estado_atencion	= 1 
									    WHERE id = :id "
									);

			   	$consulta->bindValue(':id', $id_conformidad);			

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

/**************************************/

		public function desincorporarEquipo($id_equipo, $observacion)
		{
			try 
			{			   	
				/*******************************************************************************/
				//-> OBTENER DATOs ANTES DE  DESINCORPORAR
				$obtenerActualAsign = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
											`id_persona`, 
											`id_cargo`,
											`id_departamento`,
											`fecha`,
											`estado` 
										FROM persona_equipo 
										WHERE estado =1 AND id_equipo = :id_equipo 	
									");
			   	$obtenerActualAsign->bindValue(':id_equipo',   $id_equipo);		
				$obtenerActualAsign->execute();

				foreach($obtenerActualAsign->fetchAll(PDO::FETCH_OBJ) as $rOAA)
				{
					//-> ASIGNA NUEVO REGISTRO IDENTICO, PERO SIN EL EQUIPO ( PARA MANTENER EL CARGO DE LA PERSONA )
					$asignarSinEquipo = $this->classConexion->getConexion()->
									prepare(
											"INSERT INTO persona_equipo
																(
																	`id_persona`, 
																	`id_cargo`,
																	`id_departamento`,
																	`fecha`,
																	`estado` 
																) 
								        				VALUES (
									        				    	:id_persona,
									        				    	:id_cargo,
									        				    	:id_departamento,
									        				    	now(),
									        				    	2  
								        				    	)"
									);
			     	$asignarSinEquipo->bindValue(':id_persona', $rOAA->id_persona);
			     	$asignarSinEquipo->bindValue(':id_cargo', $rOAA->id_cargo);
			     	$asignarSinEquipo->bindValue(':id_departamento', $rOAA->id_departamento);
				//	$asignarSinEquipo->bindValue(':fecha', $rOAA->fecha);
			     	$asignarSinEquipo->execute();
					$asignarSinEquipo = $this->classConexion->getCerrarSesion();
				}
				$obtenerActualAsign = $this->classConexion->getCerrarSesion();	
				//-> PRECEDE A DESINCORPORAR
				$consulta = $this->classConexion->getConexion()->prepare("UPDATE  persona_equipo SET  
											observacion   		   =  :observacion,
											estado			       =  0,
											fecha_desincorporacion = now()  
									    WHERE estado = 1 AND id_equipo = :id_equipo ");

			   	$consulta->bindValue(':id_equipo',   $id_equipo);			
		     	$consulta->bindValue(':observacion', $observacion);
		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();
				//
				$consultaE = $this->classConexion->getConexion()->
									prepare("UPDATE  equipo SET  
												estado  =  0 
											WHERE id = :id_equipo ");
			   	$consultaE->bindValue(':id_equipo',   $id_equipo);			
		     	$consultaE->execute();
				$consultaE = $this->classConexion->getCerrarSesion();

				/*******************************************************************************/
				//-> se cambian todos los perifericos del equipo - a un estado de espera a ser usado  ( 2 )
				$perifericosActivos = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
											id_periferico
										FROM equipo_periferico 
										WHERE estado =1 AND id_equipo = :id_equipo 	
									");
			   	$perifericosActivos->bindValue(':id_equipo',   $id_equipo);		
				$perifericosActivos->execute();

				foreach($perifericosActivos->fetchAll(PDO::FETCH_OBJ) as $rPA)
				{
					$activarEspera = $this->classConexion->getConexion()->
										prepare("UPDATE `eq_periferico` SET `estado`=2 WHERE id = :id_periferico ");
				   	$activarEspera->bindValue(':id_periferico',   $rPA->id_periferico);			
			     	$activarEspera->execute();
					$activarEspera = $this->classConexion->getCerrarSesion();
				}
				$perifericosActivos = $this->classConexion->getCerrarSesion();				
				//-> se cambian todos los componentes del equipo - a un estado de espera a ser usado  ( 2 )
				$perifericosComponentes = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
											id_componente
										FROM equipo_componente
										WHERE estado =1 AND id_equipo = :id_equipo 	
									");
			   	$perifericosComponentes->bindValue(':id_equipo',   $id_equipo);		
				$perifericosComponentes->execute();
			   		
				foreach($perifericosComponentes->fetchAll(PDO::FETCH_OBJ) as $rCA)
				{
					$activarEspera = $this->classConexion->getConexion()->
										prepare("UPDATE `eq_componente` SET `estado`=2 WHERE id = :id_componente ");
				   	$activarEspera->bindValue(':id_componente',   $rCA->id_componente);			
			     	$activarEspera->execute();
					$activarEspera = $this->classConexion->getCerrarSesion();
				}
				$perifericosComponentes = $this->classConexion->getCerrarSesion();				


				/*******************************************************************************/
				// -> Desincorporacion de la relacion de los perifericos del equipo (los perifericos aun funcionan)
				$consultaDG = $this->classConexion->getConexion()->
									prepare("UPDATE equipo_periferico SET  
												observacion   		   = 'desincorporación de equipo actual',
												estado			       =  0,
												fecha_desincorporacion = now() 
										    WHERE estado = 1  AND id_equipo = :id_equipo ");
			   	$consultaDG->bindValue(':id_equipo',   $id_equipo);			
		     	$consultaDG->execute();
				$consultaDG = $this->classConexion->getCerrarSesion();
				// -> Desincorporacion de la relacion de los componentes del equipo (los componentes aun funcionan)
				$consultaDG = $this->classConexion->getConexion()->
									prepare("UPDATE equipo_componente SET  
												observacion   		   = 'desincorporación de equipo actual',
												estado			       =  0,
												fecha_desincorporacion = now() 
										    WHERE estado = 1  AND id_equipo = :id_equipo ");
			   	$consultaDG->bindValue(':id_equipo',   $id_equipo);			
		     	$consultaDG->execute();
				$consultaDG = $this->classConexion->getCerrarSesion();
				// -> Desincorporacion de la relacion de los software del equipo (los software aun funcionan(limpiando dato en interfacez ))
				$consultaDG = $this->classConexion->getConexion()->
									prepare("UPDATE equipo_software SET  
												observacion   		   = 'desincorporación de equipo actual',
												estado			       =  0,
												fecha_desincorporacion = now() 
										    WHERE estado = 1  AND id_equipo = :id_equipo ");
			   	$consultaDG->bindValue(':id_equipo',   $id_equipo);			
		     	$consultaDG->execute();
				$consultaDG = $this->classConexion->getCerrarSesion();								
				/*******************************************************************************/

				return 1;

			} catch (Exception $e) {
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		public function desincorporarPerCompSoft($id_equipo, $ID_CONTROL, $observacion, $tabla, $nombreForaneas )
		{

			try 
			{
				$SQL = "UPDATE ".$tabla." SET  
											observacion   		   = :observacion,
											estado			       =  0,
											fecha_desincorporacion = now() 
									    WHERE estado = 1 AND ".$nombreForaneas." = 	:id  AND id_equipo = :id_equipo ";


				//		die($SQL);

				$consulta = $this->classConexion->getConexion()->prepare($SQL);

				//		die($id_equipo.' - '.$ID_CONTROL.' - '.$observacion.' - '.$tabla.' - '.$nombreForaneas);

			   	$consulta->bindValue(':id', $ID_CONTROL);			
			   	$consulta->bindValue(':id_equipo', $id_equipo);			
		     	$consulta->bindValue(':observacion', $observacion);
		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				switch ($nombreForaneas) {
					case 'id_periferico':
						$consultaE = $this->classConexion->getConexion()->
											prepare("UPDATE  eq_periferico SET  
														estado  =  0 
													WHERE estado = 1 AND id = :id_periferico ");
					   	$consultaE->bindValue(':id_periferico',   $ID_CONTROL);			
						if ($consultaE->execute()) {
							$consultaE = $this->classConexion->getCerrarSesion();
				     		return 1;
				     	}
						return 0;
						break;
					case 'id_componente':
						$consultaE = $this->classConexion->getConexion()->
											prepare("UPDATE  eq_componente SET  
														estado  =  0 
													WHERE estado = 1 AND id = :id_componente ");
					   	$consultaE->bindValue(':id_componente',   $ID_CONTROL);			
						if ($consultaE->execute()) {
							$consultaE = $this->classConexion->getCerrarSesion();
				     		return 1;
				     	}
						return 0;
						break;	
				}
				return 1;
			} catch (Exception $e) {
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function activarUsoPerfComp($ID_CONTROL, $tabla )
		{
			try 
			{
				$SQL = "UPDATE ".$tabla." SET  
							estado   =  1 
						WHERE id = :id";

				$consulta = $this->classConexion->getConexion()->prepare($SQL);

			   	$consulta->bindValue(':id', $ID_CONTROL);			
				if ($consulta->execute()) {
					$consulta = $this->classConexion->getCerrarSesion();
		     		return 1;
		     	}
				return 0;

			} catch (Exception $e) {
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}		

/**************************************/

		public function consultar($id_solicitud)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	
										SELECT 
											s.id as id_solicitud, 
											s.id_persona, 
											s.asunto,
											s.descripcion,
											s.fecha,
											s.fecha_desde,
											e.id as id_equipo,
											e.serial as serial, 
											e.serial_bn as serial_bn,
											e.estado as estado_equipo,
											ccft.nombre as tipo, 
											CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo,
											r.id as respuesta,
											r.fecha as respuestaFecha  
										FROM `solicitud` as s
										INNER JOIN equipo as e ON e.id = s.id_equipo
										INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	 
										LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 
										LEFT JOIN cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = ccf_eq.id_modelo_fisc	
										LEFT JOIN cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca
										LEFT JOIN solt_respuesta as r ON r.id_solt = s.id 
										WHERE s.id = :id_solicitud "  
					   				);
				//	die(' persona:'.$id_persona.' cargo: '.$id_cargo.' departamento: '.$id_departamento.' equipo: '.$id_equipo);
			   	$consulta->bindValue(':id_solicitud', $id_solicitud);					          		
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();
				//-----------------------------
				$conformidades 	= array();
				$consultarConformidades = $this->classConexion->getConexion()->
							prepare("	
										SELECT 
											c.id as id_conformidad,
											c.observacion,
											c.fecha,
											c.estado,
											c.estado_atencion  
										FROM `solt_conformidad` as c
										INNER JOIN solicitud as s ON s.id = c.id_solt 
										WHERE s.id= :id_solicitud AND c.id = (SELECT MAX(id) FROM solt_conformidad WHERE id_solt = :id_solicitud)
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consultarConformidades->bindValue(':id_solicitud', $id_solicitud);	
				$consultarConformidades->execute();

				foreach($consultarConformidades->fetchAll(PDO::FETCH_OBJ) as $c)
				{
						$conformidades[] = array(
											'id_conformidad' => $c->id_conformidad,
											'observacion' => utf8_encode($c->observacion), 
											'fecha' => $c->fecha, 
											'estado' => $c->estado, 
											'estado_atencion' => $c->estado_atencion, 
										);
				}
				$consultarConformidades = $this->classConexion->getCerrarSesion();
				//-----------------------------

				if ($r) {

					$id_solicitud = $r->id_solicitud;
					$esverificadoLaasignacion=false;
					if ($this->verificarAsignacionEquipoPersonaUbicacion($id_solicitud)==true) {
						$esverificadoLaasignacion=true;
					}
					
					$resultados[] = array(
											'id_solicitud' => $id_solicitud,
											'id_persona' => $r->id_persona,
											'fecha' => $r->fecha,
											'fecha_desde' => $r->fecha_desde,
											'id_equipo' => $r->id_equipo, 
											'estado_equipo' => $r->estado_equipo,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'tipo' => $r->tipo,	
											'marcaymodelo' => $r->marcaymodelo,	
											'respuesta' => $r->respuesta,	
											'respuestaFecha' => $r->respuestaFecha, 
											'conformidades' => $conformidades,	
											'esverificadoLaasignacion' => $esverificadoLaasignacion,
										);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		
		public function verificarAsignacionEquipoPersonaUbicacion($id_solicitud)
			{

				
				$asignaciondActiva = "";
				/*****************/
				// primero se extraen los datos de persona y ubicacion(cargo y departamento)
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	SELECT 
                                         s.id_persona,
										 s.id_cargo,
                                         s.id_departamento,
                                         s.id_persona_asignada,
										 s.id_cargo_pa,
                                         s.id_departamento_pa,
                                         s.fecha_desde,
                                         pe.fecha_desincorporacion 	
										FROM `solicitud` as s
                                        INNER JOIN equipo as e ON e.id = s.id_equipo
                                        INNER JOIN persona_equipo as pe ON pe.id_equipo = e.id 
										WHERE s.id = :id_solicitud AND e.estado=0  AND pe.fecha_desincorporacion!='0000-00-00 00:00:00' "
					   				);

			   	$consulta->bindValue(':id_solicitud', $id_solicitud);					          		
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();


				// segundo : Se realiza la verificacion
				$resultado=false;//posible
				if ($r) {
					//-------------------------------
					//Calculando
						//Si esta vacio, EL SOLICITANTE ES EL MISMO AL QUE SE LE HA ASIGNADO EL EQUIPO
						$datVerificador_id_persona=($r->id_persona_asignada!='') ? $r->id_persona_asignada : $r->id_persona;
						$datVerificador_id_cargo=($r->id_persona_asignada!='') ? $r->id_cargo_pa : $r->id_cargo;
						$datVerificador_id_departamento=($r->id_persona_asignada!='') ? $r->id_departamento_pa : $r->id_departamento;
					//-------------------------------		

					//die(' $datVerificador_id_persona:'. $datVerificador_id_persona.'| $datVerificador_id_cargo:'.$datVerificador_id_cargo.'| $datVerificador_id_departamento:'.$datVerificador_id_departamento.'| fecha_desde:'.$r->fecha_desde.'| fecha_desincorporacion'.$r->fecha_desincorporacion);		
					$consulta2 = $this->classConexion->getConexion()->
						        prepare(
										" 	SELECT 
												pe.id_equipo,
                                       			COUNT(pe.id_equipo) as resultado
											FROM  persona_equipo as pe
											WHERE pe.estado = 1 AND 
											pe.id_persona = :id_persona AND pe.id_cargo = :id_cargo AND
											pe.id_departamento = :id_departamento AND  
											( pe.fecha BETWEEN :fecha_desde AND :fecha_desincorporacion ) " 
						   				);
				   	$consulta2->bindValue(':id_persona', $datVerificador_id_persona);					          		
				   	$consulta2->bindValue(':id_cargo', $datVerificador_id_cargo);					          		
				   	$consulta2->bindValue(':id_departamento', $datVerificador_id_departamento);	
				   	$consulta2->bindValue(':fecha_desde', $r->fecha_desde);					          		
				   	$consulta2->bindValue(':fecha_desincorporacion', $r->fecha_desincorporacion);					   					          		
					$consulta2->execute();
					$r2 = $consulta2->fetch(PDO::FETCH_OBJ);
					$consulta2 = $this->classConexion->getCerrarSesion();

					if ($r2->resultado) {
						if ($r2->id_equipo=='' || $r2->id_equipo==null) {
							// Aun no tiene asignacion del equipo
							$resultado = false;
						} elseif ($r2->id_equipo>0) {
							// Ya tiene asignacion del equipo
							$resultado = true;
						}
					}
				}
				return $resultado;
			}
		
		public function consultarPeriferico($id_periferico)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	
										SELECT 
											e.id as id_equipo,
											p.id as id_periferico,
											p.serial as serial, 
											p.serial_bn as serial_bn,
											ccf_p.id as id_caracteristicas,
											ccft.nombre as tipo, 
											ccfmm.nombre as marca,
											cfg_cfm.nombre as modelo,
											ic.nombre as interfaz_conexion  
										FROM  equipo as e 
										INNER JOIN equipo_periferico as ec ON ec.id_equipo = e.id 
										INNER JOIN eq_periferico as p ON p.id = ec.id_periferico 
										INNER JOIN cfg_caracteristicas_fisc_perif as ccf_p ON ccf_p.id = p.id_c_fisc_perif  
										LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_p.id_tipo_fisc 
										LEFT JOIN cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = ccf_p.id_modelo_fisc	
										LEFT JOIN cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca	
										LEFT JOIN cfg_c_fisc_interfaz_conexion	as ic ON ic.id = ccf_p.id_interfaz_fisc
										WHERE  p.id = :id_periferico "   
					   				);
			//	die(' persona:'.$id_persona.' cargo: '.$id_cargo.' departamento: '.$id_departamento.' equipo: '.$id_equipo);
			   	$consulta->bindValue(':id_periferico', $id_periferico);					          		
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					$resultados[] = array(
											'id_equipo' => $r->id_equipo,
											'id_periferico' => $r->id_periferico,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'id_caracteristicas' => $r->id_caracteristicas,
											'tipo' => $r->tipo,	
											'marca' => $r->marca,	
											'modelo' => $r->modelo,
											'interfaz_conexion' => $r->interfaz_conexion,
 										);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		public function consultarComponente($id_componente)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	
										SELECT 
											e.id as id_equipo,
											comp.id as id_componente,
											comp.serial as serial, 
											comp.serial_bn as serial_bn,
											ccf_comp.id as id_caracteristicas,
											ccft.nombre as tipo, 
											ccfmm.nombre as marca,
											cfg_cfm.nombre as modelo,
											CONCAT( ccf_comp.capacidad,' ', ccfumc.abreviatura ) AS capacidad 
										FROM  equipo as e 
										INNER JOIN equipo_componente as ec ON ec.id_equipo = e.id 
										INNER JOIN eq_componente as comp ON comp.id = ec.id_componente 
										INNER JOIN cfg_caracteristicas_fisc_comp as ccf_comp ON ccf_comp.id = comp.id_c_fisc_comp 
										LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_comp.id_tipo_fisc 
										LEFT JOIN cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = ccf_comp.id_modelo_fisc	
										LEFT JOIN cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca	
										LEFT JOIN cfg_c_fisc_unidad_medida AS ccfumc ON ccfumc.id = ccf_comp.id_umcapacidad_fisc							 
										WHERE  comp.id = :id_componente "   
					   				);
			//	die(' persona:'.$id_persona.' cargo: '.$id_cargo.' departamento: '.$id_departamento.' equipo: '.$id_equipo);
			   	$consulta->bindValue(':id_componente', $id_componente);					          		
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					$resultados[] = array(
											'id_equipo' => $r->id_equipo,
											'id_componente' => $r->id_componente,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'id_caracteristicas' => $r->id_caracteristicas,
											'tipo' => $r->tipo,	
											'marca' => $r->marca,	
											'modelo' => $r->modelo,
											'capacidad' => $r->capacidad,
										);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		public function consultarSoftware($id_software, $id_equipo)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	
										SELECT 
											e.id as id_equipo,
											soft.id as id_software,
											soft.nombre as nombre,
											soft.version as version,
											cclt.nombre as tipo, 
											cclf.nombre as distribucion   
										FROM  equipo as e 
										INNER JOIN equipo_software as es ON es.id_equipo = e.id 
										INNER JOIN eq_software as soft ON soft.id = es.id_software 
										LEFT JOIN cfg_c_logc_tipo as cclt ON cclt.id = soft.id_c_logc_tipo 
										LEFT JOIN cfg_c_logc_distribucion as cclf ON cclf.id = soft.id_c_logc_distribucion 
										WHERE  es.id_software = :id_software AND es.id_equipo = :id_equipo "   
					   				);
			   	$consulta->bindValue(':id_software', $id_software);					          		
			   	$consulta->bindValue(':id_equipo', $id_equipo);					          		

				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					$resultados[] = array(
											'id_equipo' => $r->id_equipo,
											'id_software' => $r->id_software,
											'nombre' => $r->nombre,
											'version' => $r->version,	
											'tipo' => $r->tipo,	
											'distribucion' => $r->distribucion, 
										);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}





/*********************************************************************************************/

		public function cargarListaDiagnosticosSolt($id_solicitud)
		{ 
			$result 	= array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
											observacion,
											fecha
										FROM `solt_diagnostico`
										WHERE `id_solt` = :id_solicitud	
										ORDER BY id DESC
									");
	
		   		$consulta->bindValue(':id_solicitud', $id_solicitud);	
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'observacion' => utf8_encode($r->observacion),
										'fecha'  => $r->fecha,
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

		public function cargarListaTareasEquipoSolicitud($id_equipo)
		{ 
			$result 	= array();
			try{

				$consulta = $this->classConexion->getConexion()->
							prepare("	
										SELECT
											te.id_equipo,	
											te.estado_uso, 
											t.id as id_tarea, 
											t.nombre as tarea,
											t.tarea_correctiva,
											te.id as id_tarea_equipo,
											te.proxima_fecha, 
											MAX(m.id) as id_mantenimiento,
											MAX(s.fecha_desde) as fecha_desde 
										FROM tarea_equipo as te									
										INNER JOIN   cfg_tarea as t ON t.id = te.id_tarea  
										LEFT JOIN mantenimiento as m ON m.id_tarea_equipo = te.id AND m.id_tipo_mant = 2 			RIGHT JOIN solicitud as s ON s.id_equipo = te.id_equipo  
										WHERE te.id_equipo = :id_equipo  
										GROUP BY te.id 
										ORDER BY m.fecha_i DESC

									");
		  $consulta->bindValue(':id_equipo', $id_equipo);	
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
								$id_mantenimiento = $r->id_mantenimiento;
								$fecha_desde      = $r->fecha_desde;
					/*******************************************************************/
								$consultaExtractor = $this->classConexion->getConexion()->
									        prepare(" 	
																		SELECT
																			m.observacion,
																			m.fecha_i as inicio,
																			m.fecha_f as final 
																		FROM mantenimiento as m 
																		WHERE m.id = :id_mantenimiento AND m.fecha_i > :fecha_desde
																");
									//	die(' persona:'.$id_persona.' cargo: '.$id_cargo.' departamento: '.$id_departamento.' equipo: '.$id_equipo);
									 $consultaExtractor->bindValue(':id_mantenimiento', $id_mantenimiento);					          		
									 $consultaExtractor->bindValue(':fecha_desde', $fecha_desde);					          		
										$consultaExtractor->execute();
			//		$rExt = $consultaExtractor->fetch(PDO::FETCH_OBJ);
					/*******************************************************************/
				/*****************/
						$cfg_dias_proximidad_tarea = 0;
						$consultaDPT = $this->classConexion->getConexion()->
							        prepare("SELECT 		
													dias_proximidad_tarea 
												FROM cfg_configuracion  " );

						$consultaDPT->execute();
						$rDPT = $consultaDPT->fetch(PDO::FETCH_OBJ);
						$consultaDPT = $this->classConexion->getCerrarSesion();

						if ($rDPT) {
							$cfg_dias_proximidad_tarea = $rDPT->dias_proximidad_tarea;
						}
						/*****************/
						$proxima_fecha = $r->proxima_fecha;
						$dias_restantes = calcularIntervaloFechas(fechaActual(),$proxima_fecha);
						// Se necesita saber si es menor, para saber si la fecha ya paso.
						$control_vencimiento_fecha = $proxima_fecha<fechaActual();
						$resultadoCalculoMenorQueProximidad = $dias_restantes<$cfg_dias_proximidad_tarea;

						/*****************/




				$rExtControl = 	$consultaExtractor->fetchAll(PDO::FETCH_OBJ);
				if($rExtControl){

												foreach($rExtControl as $rExt)
												{

																	$result[] = array(
																						'id_equipo' => $r->id_equipo,
																						'estado_uso' => $r->estado_uso,
																						'id_tarea' => $r->id_tarea,
																						'tarea' => utf8_encode($r->tarea),
																						'tarea_correctiva' => $r->tarea_correctiva,
																						'id_tarea_equipo' => $r->id_tarea_equipo,
																						'id_mantenimiento' => $id_mantenimiento,	
																						'observacion' => utf8_encode($rExt->observacion),
																						'inicio' => $rExt->inicio,
																						'final' => $rExt->final,
																						'dias_restantes' => $dias_restantes,
																						'resultadoCalculoMenorQueProximidad' => $resultadoCalculoMenorQueProximidad,
																						'control_vencimiento_fecha' => $control_vencimiento_fecha,
																					);
													}
					}else{
																	$result[] = array(
																						'id_equipo' => $r->id_equipo,
																						'estado_uso' => $r->estado_uso,
																						'id_tarea' => $r->id_tarea,
																						'tarea' => utf8_encode($r->tarea),
																						'tarea_correctiva' => $r->tarea_correctiva,																						
																						'id_tarea_equipo' => $r->id_tarea_equipo,
																						'id_mantenimiento' => $id_mantenimiento,	
																						'observacion' => "",
																						'inicio' => "",
																						'final' => "",
																						'dias_restantes' => $dias_restantes,
																						'resultadoCalculoMenorQueProximidad' => $resultadoCalculoMenorQueProximidad,
																						'control_vencimiento_fecha' => $control_vencimiento_fecha,																				
																					);
					}
					$consultaExtractor = $this->classConexion->getCerrarSesion();

				}
				$consulta = $this->classConexion->getCerrarSesion();
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
/***********************************************************************************/

		public function guardoMant(mantenimiento $data)
		{
			$modTareaProgramada = new modTareaProgramada();
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO mantenimiento (
															`fecha_i`,
															`tiempo_estimado_mant`,
															`estado`,
															`id_tipo_mant`,
															`id_tarea_equipo`,
															`id_solicitud`															
														) 
						        				VALUES (
							        				    	now(),
							        				    	:tiempo_estimado_mant,
							        				    	:estado,
							        				    	:id_tipo_mant,
							        				    	:id_tarea_equipo,
							        				    	:id_solicitud
						        				    	)");

		     	$consulta->bindValue(':estado', 1);
		     	$consulta->bindValue(':id_tipo_mant', 2);
		     	$consulta->bindValue(':id_tarea_equipo', $data->__GET('id_tarea_equipo'));
		     	$tiempo_estimado_mant=0;
		     	if ($data->__GET('id_tarea_equipo')>0) {
		     		$tiempo_estimado_mant = $modTareaProgramada->agregarTiempoEstimadoMant($data->__GET('id_tarea_equipo'));
		     	}
		     	$consulta->bindValue(':tiempo_estimado_mant', $tiempo_estimado_mant);

		     	if (!empty($data->__GET('id_solicitud'))) {
			     	$consulta->bindValue(':id_solicitud', $data->__GET('id_solicitud'));
		     	}else{
		     		$consulta->bindValue(':id_solicitud', 0);
		     	}

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
		public function finalizoMant(mantenimiento $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();

				$id_mantenimiento = $data->__GET('id');
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"	UPDATE mantenimiento SET  
										`fecha_f` = now(),
										`observacion`      = :observacion,
										`estado`           = 0    
										WHERE 	id = :id_mantenimiento AND estado = 1 AND id_tipo_mant = 2 
							  		");
		     	$consulta->bindValue(':observacion', utf8_decode($data->__GET('observacion')));		     	
		     	$consulta->bindValue(':id_mantenimiento', $id_mantenimiento);
		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return $id_mantenimiento;
			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}		

/***********************************************************************************/
		/*
			Perifericos disponibles luego de desincorporar un equipo

		*/
		public function cargarListaPerifericosDisponibles($filtro, $filtro2)
		{ 
			$result = array();
			try
			{
				if(empty($filtro) && empty($filtro2)) {
				$consulta = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
											p.id AS id_periferico, 
											ccf_perf.id AS id_caracteristicas,
											p.serial, 
											p.serial_bn, 
											ccft.nombre AS tipo, 
											ccfm.nombre AS modelo, 
											ccfmm.nombre AS marca	
										FROM  eq_periferico as p
										INNER JOIN cfg_caracteristicas_fisc_perif AS ccf_perf ON ccf_perf.id = p.id_c_fisc_perif
										LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccf_perf.id_tipo_fisc
										LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccf_perf.id_modelo_fisc
										LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
										WHERE  p.estado=2						
									");

				}elseif(empty($filtro2) && !empty($filtro)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													p.id AS id_periferico, 
													ccf_perf.id AS id_caracteristicas,
													p.serial, 
													p.serial_bn, 
													ccft.nombre AS tipo, 
													ccfm.nombre AS modelo, 
													ccfmm.nombre AS marca	
												FROM  eq_periferico as p
												INNER JOIN cfg_caracteristicas_fisc_perif AS ccf_perf ON ccf_perf.id = p.id_c_fisc_perif
												LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccf_perf.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccf_perf.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
												WHERE  p.estado=2 AND p.serial LIKE :nombre 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}elseif(empty($filtro) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													p.id AS id_periferico, 
													ccf_perf.id AS id_caracteristicas,
													p.serial, 
													p.serial_bn, 
													ccft.nombre AS tipo, 
													ccfm.nombre AS modelo, 
													ccfmm.nombre AS marca	
												FROM  eq_periferico as p
												INNER JOIN cfg_caracteristicas_fisc_perif AS ccf_perf ON ccf_perf.id = p.id_c_fisc_perif
												LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccf_perf.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccf_perf.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca 
												WHERE  p.estado=2 AND ccf_perf.id_tipo_fisc = :filtro2 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':filtro2', $filtro2);	
	
				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													p.id AS id_periferico, 
													ccf_perf.id AS id_caracteristicas,
													p.serial, 
													p.serial_bn, 
													ccft.nombre AS tipo, 
													ccfm.nombre AS modelo, 
													ccfmm.nombre AS marca	
												FROM  eq_periferico as p
												INNER JOIN cfg_caracteristicas_fisc_perif AS ccf_perf ON ccf_perf.id = p.id_c_fisc_perif
												LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccf_perf.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccf_perf.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
												WHERE  p.estado=2 AND  p.serial LIKE :nombre AND ccf_perf.id_tipo_fisc = :filtro2 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	
			   		$consulta->bindValue(':filtro2', $filtro2);	
	

				}

				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_periferico' => $r->id_periferico,
										'id_caracteristicas' => $r->id_caracteristicas,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'tipo' => $r->tipo,
										'modelo' => $r->modelo,
										'marca' => $r->marca, 
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

		public function cargarListaComponentesDisponibles($filtro, $filtro2)
		{ 
			$result = array();
			try
			{
				if(empty($filtro) && empty($filtro2)) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
											SELECT 
												c.id as id_componente,
												ccf_comp.id as id_caracteristicas,
												c.serial,
												c.serial_bn,
												ccft.nombre as tipo,
												ccfm.nombre as modelo,
												ccfmm.nombre as marca
											FROM eq_componente as c 
											INNER JOIN cfg_caracteristicas_fisc_comp as ccf_comp ON ccf_comp.id = c.id_c_fisc_comp
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccf_comp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccf_comp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
											WHERE c.estado =2

										");


				}elseif(empty($filtro2) && !empty($filtro)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
												c.id as id_componente,
												ccf_comp.id as id_caracteristicas,
												c.serial,
												c.serial_bn,
												ccft.nombre as tipo,
												ccfm.nombre as modelo,
												ccfmm.nombre as marca
											FROM eq_componente as c 
											INNER JOIN cfg_caracteristicas_fisc_comp as ccf_comp ON ccf_comp.id = c.id_c_fisc_comp
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccf_comp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccf_comp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
												WHERE  c.estado=2 AND c.serial LIKE :nombre 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	

				}elseif(empty($filtro) && !empty($filtro2)) {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													c.id as id_componente,
													ccf_comp.id as id_caracteristicas,
													c.serial,
													c.serial_bn,
													ccft.nombre as tipo,
													ccfm.nombre as modelo,
													ccfmm.nombre as marca
												FROM eq_componente as c 
												INNER JOIN cfg_caracteristicas_fisc_comp as ccf_comp ON ccf_comp.id = c.id_c_fisc_comp
												LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccf_comp.id_tipo_fisc 
												LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccf_comp.id_modelo_fisc 
												LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
												WHERE c.estado=2 AND ccf_comp.id_tipo_fisc = :filtro2 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':filtro2', $filtro2);	
	
				} else {

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													c.id as id_componente,
													ccf_comp.id as id_caracteristicas,
													c.serial,
													c.serial_bn,
													ccft.nombre as tipo,
													ccfm.nombre as modelo,
													ccfmm.nombre as marca
												FROM eq_componente as c 
												INNER JOIN cfg_caracteristicas_fisc_comp as ccf_comp ON ccf_comp.id = c.id_c_fisc_comp
												LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccf_comp.id_tipo_fisc 
												LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccf_comp.id_modelo_fisc 
												LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
												WHERE c.estado=2 AND c.serial LIKE :nombre AND ccf_comp.id_tipo_fisc = :filtro2 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':nombre', '%'.$filtro.'%');	
			   		$consulta->bindValue(':filtro2', $filtro2);	
	

				}



				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_componente' => $r->id_componente,
										'id_caracteristicas' => $r->id_caracteristicas,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'tipo' => $r->tipo,
										'modelo' => $r->modelo,
										'marca' => $r->marca, 
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



/********************************************************************************/
		public function Listar($id_persona, $filtro, $buscardordesde, $buscardorhasta, $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE  ";

			$filtro1= false;
			if (!empty($filtro)) {
				$sqlFiltros .= "  ( e.serial LIKE :serialperif OR e.serial_bn LIKE :serial_bnperif  )   ";
				$filtro1=true;
			}
			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				if ($filtro1==true) {
					$sqlFiltros .= " AND ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";						
				}else{
					$sqlFiltros .= " ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
				}

			}


			try
			{

				if(	empty($filtro) && empty($buscardordesde) && 
					empty($buscardorhasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													s.id, 
													s.asunto,
													(CASE 
													  WHEN s.estado=0 THEN s.fecha 
													  WHEN s.estado=1 THEN s.fecha_desde 
													  WHEN s.estado=2 THEN s.fecha_cierre  
													END) as fecha,
													s.id_equipo,
													e.serial, 
													e.serial_bn, 
													s.estado,
													s.id_persona,
													s.id_persona_asignada 
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
												ORDER BY s.estado ASC , s.fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													s.id, 
													s.asunto,
													(CASE 
													  WHEN s.estado=0 THEN s.fecha 
													  WHEN s.estado=1 THEN s.fecha_desde 
													  WHEN s.estado=2 THEN s.fecha_cierre  
													END) as fecha,
													s.id_equipo, 
													e.serial, 
													e.serial_bn, 
													s.estado,
													s.id_persona,
													s.id_persona_asignada  
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
											    	".$sqlFiltros."  
												ORDER BY s.estado ASC , s.fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($filtro)) {
				   		$consulta->bindValue(':serialperif', '%'.$filtro.'%');	
				   		$consulta->bindValue(':serial_bnperif', '%'.$filtro.'%');	
					}
					if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				   		$consulta->bindValue(':buscardordesde', $buscardordesde);	
				   		$consulta->bindValue(':buscardorhasta', $buscardorhasta);	
					}

			   	}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$solt_estado	=	$r->estado;
					$id_solicitud	=	$r->id;
					//
					$id_equipo	=	$r->id_equipo;

					/******************************************/
						$consultaRespuesta = $this->classConexion->getConexion()->
									prepare("		
												SELECT 
													1
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo 
												INNER JOIN solt_respuesta as resp ON resp.id_solt = s.id
												WHERE s.id = :id_solicitud AND s.estado=1
											");

						//se inserta el parametro de busqueda y se ejecuta lac onsulta
				  $consultaRespuesta->bindValue(':id_solicitud', $id_solicitud);

						$result_r = $consultaRespuesta->execute();
						$result_r = $consultaRespuesta->fetch(PDO::FETCH_OBJ);
						
						if ($result_r) {
							//--------
							
							//--------
							$consultaConformidades = $this->classConexion->getConexion()->
										prepare("		
													SELECT 
														confor.estado,
														confor.estado_atencion 
													FROM solicitud AS s
													LEFT JOIN solt_conformidad as confor ON confor.id_solt = s.id
													WHERE s.id = :id_solicitud AND 
														confor.fecha = (SELECT MAX(confor.fecha) FROM solicitud AS s
														LEFT JOIN solt_conformidad as confor ON confor.id_solt = s.id 
														WHERE s.id = :id_solicitud_sub )
													
												");
							$consultaConformidades->bindValue(':id_solicitud', $id_solicitud);
							$consultaConformidades->bindValue(':id_solicitud_sub', $id_solicitud);
							$result_c = $consultaConformidades->execute();
							$result_c = $consultaConformidades->fetch(PDO::FETCH_OBJ);
							
							if ($result_c) {							
								if ($result_c->estado==0 && $result_c->estado_atencion==1) {
									$solt_estado = $r->estado;
								}else{
									$solt_estado = '3';
								}
							}
						}else{
								
							//Gestion de equipo dañado
							//--------------------------------------
								$consultaEquipoDanado_asignacion = $this->classConexion->getConexion()->
											prepare("		
														SELECT 
															e.estado
														FROM solicitud AS s
														INNER JOIN equipo AS e ON e.id = s.id_equipo
														WHERE s.id=:id_solicitud AND s.estado=1 AND e.id = :id_equipo 
													");

								//se inserta el parametro de busqueda y se ejecuta lac onsulta
						  $consultaEquipoDanado_asignacion->bindValue(':id_solicitud', $id_solicitud);
						  $consultaEquipoDanado_asignacion->bindValue(':id_equipo', $id_equipo);

								$result_ed_a = $consultaEquipoDanado_asignacion->execute();
								$result_ed_a = $consultaEquipoDanado_asignacion->fetch(PDO::FETCH_OBJ);
								
								if ($result_ed_a){
									if ($result_ed_a->estado==0) {
										//--------
										$solt_estado = '3';
										//-------
									}
								}
							
								/*******************************************/
						}


			   		
					

					/******************************************/
					$result[] = array(
										'id_solicitud' => $id_solicitud,
										'asunto' => utf8_encode($r->asunto),
										'fecha'  => $r->fecha,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'estado' => $solt_estado,
										'id_persona' => $r->id_persona,
										'id_persona_asignada' => $r->id_persona_asignada,
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

		public function getTotalPaginas($id_persona, $filtro, $buscardordesde, $buscardorhasta,$getTotalPaginas)
		{
			$result 	= array();
			$sqlFiltros = " WHERE  ";

			$filtro1= false;
			if (!empty($filtro)) {
				$sqlFiltros .= "  ( e.serial LIKE :serialperif OR e.serial_bn LIKE :serial_bnperif  )   ";
				$filtro1=true;
			}
			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				if ($filtro1==true) {
					$sqlFiltros .= " AND ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";						
				}else{
					$sqlFiltros .= " ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
				}

			}

			try
			{

				if(	empty($filtro) && empty($buscardordesde) && 
					empty($buscardorhasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													COUNT(s.id) as num_filas 
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													COUNT(s.id) as num_filas  
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
											    	".$sqlFiltros."  
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($filtro)) {
				   		$consulta->bindValue(':serialperif', '%'.$filtro.'%');	
				   		$consulta->bindValue(':serial_bnperif', '%'.$filtro.'%');	
					}
					if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				   		$consulta->bindValue(':buscardordesde', $buscardordesde);	
				   		$consulta->bindValue(':buscardorhasta', $buscardorhasta);	
					}

			   	}

		   		$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);

					return 	$r->num_filas;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	

/**********************************************************************************/			
		public function ListarReporte($id_persona, $filtro, $buscardordesde, $buscardorhasta, $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE s.estado=2 ";

			$filtro1= false;
			if (!empty($filtro)) {
				$sqlFiltros .= " AND ( e.serial LIKE :serialperif OR e.serial_bn LIKE :serial_bnperif  )   ";
				$filtro1=true;
			}
			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				if ($filtro1==true) {
					$sqlFiltros .= " AND ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";						
				}else{
					$sqlFiltros .= " ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
				}

			}


			try
			{

				if(	empty($filtro) && empty($buscardordesde) && 
					empty($buscardorhasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													s.id, 
													s.asunto,
													(CASE 
													  WHEN s.estado=0 THEN s.fecha 
													  WHEN s.estado=1 THEN s.fecha_desde 
													  WHEN s.estado=2 THEN s.fecha_cierre  
													END) as fecha,
													e.serial, 
													e.serial_bn, 
													s.estado,
													s.id_persona,
													s.id_persona_asignada 
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
												WHERE s.estado=2
												ORDER BY s.estado ASC , s.fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													s.id, 
													s.asunto,
													(CASE 
													  WHEN s.estado=0 THEN s.fecha 
													  WHEN s.estado=1 THEN s.fecha_desde 
													  WHEN s.estado=2 THEN s.fecha_cierre  
													END) as fecha,
													e.serial, 
													e.serial_bn, 
													s.estado,
													s.id_persona,
													s.id_persona_asignada  
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
											    	".$sqlFiltros."  
												ORDER BY s.estado ASC , s.fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($filtro)) {
				   		$consulta->bindValue(':serialperif', '%'.$filtro.'%');	
				   		$consulta->bindValue(':serial_bnperif', '%'.$filtro.'%');	
					}
					if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				   		$consulta->bindValue(':buscardordesde', $buscardordesde);	
				   		$consulta->bindValue(':buscardorhasta', $buscardorhasta);	
					}

			   	}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_solicitud' => $r->id,
										'asunto' => utf8_encode($r->asunto),
										'fecha'  => $r->fecha,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'estado' => $r->estado,
										'id_persona' => $r->id_persona,
										'id_persona_asignada' => $r->id_persona_asignada,
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

		public function getTotalPaginasReporte($id_persona, $filtro, $buscardordesde, $buscardorhasta,$getTotalPaginas)
		{ 
			$result 	= array();
			$sqlFiltros = " WHERE s.estado=2 ";

			$filtro1= false;
			if (!empty($filtro)) {
				$sqlFiltros .= " AND ( e.serial LIKE :serialperif OR e.serial_bn LIKE :serial_bnperif  )   ";
				$filtro1=true;
			}
			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				if ($filtro1==true) {
					$sqlFiltros .= " AND ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";						
				}else{
					$sqlFiltros .= " ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
				}

			}

			try
			{

				if(	empty($filtro) && empty($buscardordesde) && 
					empty($buscardorhasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													COUNT(s.id) as num_filas 
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
												WHERE s.estado=2 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													COUNT(s.id) as num_filas  
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
											    	".$sqlFiltros."  
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($filtro)) {
				   		$consulta->bindValue(':serialperif', '%'.$filtro.'%');	
				   		$consulta->bindValue(':serial_bnperif', '%'.$filtro.'%');	
					}
					if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				   		$consulta->bindValue(':buscardordesde', $buscardordesde);	
				   		$consulta->bindValue(':buscardorhasta', $buscardorhasta);	
					}

			   	}

		   		$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);

					return 	$r->num_filas;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
/**********************************************************************************/			

		public function ListarReporteRendimiento($filtro,$fecha_1, $fecha_2)
		{
			$this->classConexion = new classConexion();
			$result = array();

			$sqlFiltros = "";

			if (!empty($filtro)) {
				$sqlFiltros .= " AND p.cedula = :cedula_tecnico ";
			}
			if (!empty($fecha_1) && !empty($fecha_2)) {
				$sqlFiltros .= " AND ( m.fecha_f BETWEEN :buscardordesde AND :buscardorhasta ) ";
			}

			try
			{
				if( empty($filtro) && empty($fecha_1) && empty($fecha_2)) {			
					$SQL = "SELECT
								    m.fecha_f as fecha_finalizo,    
									(CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 					    
                                      	TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado  ELSE 0
								     END)as tardanza,
									t.tarea_correctiva
								FROM tarea_equipo as te
								INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
								INNER JOIN mantenimiento as m ON m.id_tarea_equipo = te.id 
								INNER JOIN persona_ejecuta as pj ON pj.id_mantenimiento = m.id 
								INNER JOIN pnej_funcion_persona as pjfunc ON pjfunc.id = pj.id_funcion_persona
								INNER JOIN cfg_persona as p ON p.id = pj.id_persona 
								WHERE  te.estado_uso = 0 AND pjfunc.id=20 AND (CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 					    
                                      	TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado  ELSE 0
								     END) !=0 
								ORDER BY m.fecha_f DESC ";

					}else{

							$SQL = "SELECT
								    m.fecha_f as fecha_finalizo,    
									(CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 					    
                                      	TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado  ELSE 0
								     END)as tardanza,
									t.tarea_correctiva
								FROM tarea_equipo as te
								INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
								INNER JOIN mantenimiento as m ON m.id_tarea_equipo = te.id 
								INNER JOIN persona_ejecuta as pj ON pj.id_mantenimiento = m.id 
								INNER JOIN pnej_funcion_persona as pjfunc ON pjfunc.id = pj.id_funcion_persona
								INNER JOIN cfg_persona as p ON p.id = pj.id_persona 
								WHERE  te.estado_uso = 0 AND pjfunc.id=20 AND (CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 					    
                                      	TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado  ELSE 0
								     END) !=0 ".$sqlFiltros."  
								ORDER BY m.fecha_f DESC ";
				}								


				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				if (!empty($filtro)) {
			   		$consulta->bindValue(':cedula_tecnico', $filtro);
			  	}
				if (!empty($fecha_1) && !empty($fecha_2)) {
			   		$consulta->bindValue(':buscardordesde', $fecha_1);
			   		$consulta->bindValue(':buscardorhasta', $fecha_2);
				}
				$consulta->execute();



				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$NOMBRE_TIPO_TAREA="TARDANZA_CORRECTIVA";
					if($r->tarea_correctiva==0){
						$NOMBRE_TIPO_TAREA="TARDANZA_PREVENTIVA";
					}

					$result[] = array(
										'FECHA_FINALIZACION' => $r->fecha_finalizo,
										''.$NOMBRE_TIPO_TAREA.'' => $r->tardanza,
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


/**********************************************************************************/			

   }	
		
?>
