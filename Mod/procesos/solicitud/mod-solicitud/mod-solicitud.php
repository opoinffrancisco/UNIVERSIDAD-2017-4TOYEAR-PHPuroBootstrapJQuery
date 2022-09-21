<?php

	class modSolicitud extends solicitud{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		/***************************************************************************************/
		// INICIO DE GESTIN DE CONSULTA
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
	                                        s.id_persona_asignada,
											 p.cedula as cedulaPersona,
											 CONCAT(p.nombre,' ',p.apellido ) as nombreApellidoPersona,
											 p.correo_electronico as correo,
											 f.formato_foto as formato_fotoPersona,
											 f.foto as fotoPersona,
											 c.nombre as cargoPersona,
											 d.nombre as departamentoPersona,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE p2.cedula END) as cedulaPersona_pa,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE CONCAT(p2.nombre,' ',p2.apellido ) END) as nombreApellidoPersona_pa,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE p2.correo_electronico END) as correo_pa,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE f2.formato_foto END) as formato_fotoPersona_pa,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE f2.foto END) as fotoPersona_pa,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE c2.nombre END) as cargoPersona_pa,
											 (CASE WHEN s.id_persona_asignada='' THEN '' ELSE d2.nombre END) as departamentoPersona_pa,
											 s.asunto,
											 s.descripcion,
											 s.fecha,
											 s.fecha_desde,
											 s.fecha_cierre,
											 s.observacion_extra,
											 s.estado as estado_solt,
											 e.serial as serial, 
											 e.serial_bn as serial_bn,
											 e.estado as estado_equipo,
											 ccft.nombre as tipo,
											 r.id as id_respuesta,
											 r.fecha as respuestaFecha,
											 r.observacion as respuestaObservacion	 	 								  
											FROM `solicitud` as s
											LEFT JOIN solt_respuesta as r ON r.id_solt = s.id 			
	                    					INNER JOIN equipo as e ON e.id = s.id_equipo
											INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	
											LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 
											INNER JOIN cfg_persona as p ON p.id = s.id_persona
											INNER JOIN cfg_persona_foto as f ON f.id_persona = p.id 
											LEFT JOIN cfg_pn_cargo as c ON c.id = s.id_cargo 
											LEFT JOIN cfg_departamento as d ON d.id = s.id_departamento 
											LEFT JOIN cfg_persona as p2 ON p2.id = s.id_persona_asignada
											LEFT JOIN cfg_persona_foto as f2 ON f2.id_persona = p2.id 
											LEFT JOIN cfg_pn_cargo as c2 ON c2.id = s.id_cargo_pa 
											LEFT JOIN cfg_departamento as d2 ON d2.id = s.id_departamento_pa  
											WHERE s.id = :id_solicitud " 
						   				);
				   	$consulta->bindValue(':id_solicitud', $id_solicitud);					          		
					$consulta->execute();
					$r = $consulta->fetch(PDO::FETCH_OBJ);
					$consulta = $this->classConexion->getCerrarSesion();
					
					//------------------------------------------------------------------------------
					$estado_equipo	=	$r->estado_equipo;
				//-------------------------------------------------------------------------------
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
											WHERE s.id= :id_solicitud	
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
				//-------------------------------------------------------------------------------
							$datVerificador_id_persona="";
							$datVerificador_id_cargo="";
							$datVerificador_id_departamento="";
							$fecha_desde="";
							$fecha_desincorporacion="";				
							#
							$serial_enuevo="";
							$serial_bn_enuevo="";
							$tipo_enuevo="";							
							##########################
					$verificacionDesinconporacionEquipoSolicitud = $this->classConexion->getConexion()->
						        prepare("SELECT 
																							1
																						FROM `solicitud` as s 
																						INNER JOIN mantenimiento as m ON m.id_solicitud = s.id
																						INNER JOIN persona_ejecuta as pe ON pe.id_mantenimiento = m.id
																						INNER JOIN pnej_funcion_persona as pnej ON pnej.id = pe.id_funcion_persona
																						WHERE s.id = :id_solicitud AND pnej.id = 4 ");
				 $verificacionDesinconporacionEquipoSolicitud->bindValue(':id_solicitud', $id_solicitud);					          		
					$verificacionDesinconporacionEquipoSolicitud->execute();
					$verificacionDesinconporacionEquipoSolicitud_r = $verificacionDesinconporacionEquipoSolicitud->fetch(PDO::FETCH_OBJ);

					if ($verificacionDesinconporacionEquipoSolicitud_r) {
							//-------------------------------------------------------------------------------


														$consulta4 = $this->classConexion->getConexion()->
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
													   	$consulta4->bindValue(':id_solicitud', $id_solicitud);					          		
														$consulta4->execute();
														$r4 = $consulta4->fetch(PDO::FETCH_OBJ);
														$consulta4 = $this->classConexion->getCerrarSesion();


														//-------------------------------
														//Calculando
		
															if($r4){
																//Si esta vacio, EL SOLICITANTE ES EL MISMO AL QUE SE LE HA ASIGNADO EL EQUIPO
																$datVerificador_id_persona=($r4->id_persona_asignada!='') ? $r4->id_persona_asignada : $r4->id_persona;
																$datVerificador_id_cargo=($r4->id_persona_asignada!='') ? $r4->id_cargo_pa : $r4->id_cargo;
																$datVerificador_id_departamento=($r4->id_persona_asignada!='') ? $r4->id_departamento_pa : $r4->id_departamento;
																$fecha_desde=$r4->fecha_desde;
																$fecha_desincorporacion=$r4->fecha_desincorporacion;												
															}
														//-------------------------------		

														$consulta5 = $this->classConexion->getConexion()->
																        prepare(
																				" 	SELECT 
																						e.serial as serial_enuevo, 
																						e.serial_bn as serial_bn_enuevo,
																						ccft.nombre as tipo_enuevo
																					FROM  persona_equipo as pe
											                    					INNER JOIN equipo as e ON e.id = pe.id_equipo
																					INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	
																					LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 												
																					WHERE /*pe.estado = 1 AND */
																					pe.id_persona = :id_persona AND pe.id_cargo = :id_cargo AND
																					pe.id_departamento = :id_departamento AND  
																					( pe.fecha BETWEEN :fecha_desde AND :fecha_desincorporacion ) " 
																   				);
													   	$consulta5->bindValue(':id_persona', $datVerificador_id_persona);					          		
													   	$consulta5->bindValue(':id_cargo', $datVerificador_id_cargo);					          		
													   	$consulta5->bindValue(':id_departamento', $datVerificador_id_departamento);	
													   	$consulta5->bindValue(':fecha_desde', $fecha_desde);					          		
													   	$consulta5->bindValue(':fecha_desincorporacion', $fecha_desincorporacion);					   					          		
														$consulta5->execute();
														$r5 = $consulta5->fetch(PDO::FETCH_OBJ);
														$consulta5 = $this->classConexion->getCerrarSesion();


														if ($r5) {						
															$serial_enuevo=$r5->serial_enuevo;
															$serial_bn_enuevo=$r5->serial_bn_enuevo;																		
															$tipo_enuevo=$r5->tipo_enuevo;												
														}
							//-------------------------------------------------------------------------------
					}else{

						 if ($estado_equipo==0) {
						 	$estado_equipo=1;
						 }
					}

				//-------------------------------------------------------------------------------
				if ($r) {
					$resultados[] = array(
											'id_solicitud' => $r->id_solicitud,						
											'id_persona' => $r->id_persona,
											'id_persona_asignada' => $r->id_persona_asignada,											
											'cedulaPersona' => $r->cedulaPersona,
											'nombreApellidoPersona' => utf8_encode($r->nombreApellidoPersona),
											'correo' => utf8_encode($r->correo),
											'formato_fotoPersona' => $r->formato_fotoPersona,
											'fotoPersona' => $r->fotoPersona,
											'cargoPersona' => utf8_encode($r->cargoPersona),
											'departamentoPersona' => utf8_encode($r->departamentoPersona),
											'cedulaPersona_pa' => $r->cedulaPersona_pa,
											'nombreApellidoPersona_pa' => utf8_encode($r->nombreApellidoPersona_pa),
											'correo_pa' => utf8_encode($r->correo_pa),
											'formato_fotoPersona_pa' => $r->formato_fotoPersona_pa,
											'fotoPersona_pa' => $r->fotoPersona_pa,
											'cargoPersona_pa' => utf8_encode($r->cargoPersona_pa),
											'departamentoPersona_pa' => utf8_encode($r->departamentoPersona_pa),
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'estado_equipo' => $estado_equipo,




											'tipo' => utf8_encode($r->tipo),

											'serial_enuevo' => $serial_enuevo,
											'serial_bn_enuevo' => $serial_bn_enuevo,
											'tipo_enuevo' => utf8_encode($tipo_enuevo),

											'asunto' => utf8_encode($r->asunto),
											'descripcion' => utf8_encode($r->descripcion),
											'fecha' => utf8_encode($r->fecha),
											'fecha_desde' => $r->fecha_desde,
											'fecha_cierre' => $r->fecha_cierre,
											'observacion_extra' => utf8_encode($r->observacion_extra),
											'estado_solt' => $r->estado_solt,
											'id_respuesta' => $r->id_respuesta,
											'respuestaFecha' =>  utf8_encode($r->respuestaFecha),
											'respuestaObservacion' =>  utf8_encode($r->respuestaObservacion),
											'conformidades' => $conformidades,
										);
					//die(print_r($resultados));
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		// FIN DE GESTIN DE CONSULTA
		/***************************************************************************************/

		public function guardar(solicitud $data)
		{
			$id_persona = $data->__GET('id_persona');
			$id_equipo =  $data->__GET('id_equipo');			
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();

		     	/********************************************************/
						$datosPersonaAsignada = $this->classConexion->getConexion()->
									prepare("	
												SELECT 
													pe.id_persona,
													pe.id_cargo,
		                                            pe.id_departamento
												FROM persona_equipo AS pe 
												WHERE pe.id_equipo = :id_equipo AND pe.estado = 1 
											");
				   		$datosPersonaAsignada->bindValue(':id_equipo', $id_equipo);	
						$datosPersonaAsignada->execute();
						
						$r = $datosPersonaAsignada->fetch(PDO::FETCH_OBJ);
						$datosPersonaAsignada = $this->classConexion->getCerrarSesion();
					//--------------------------------------------------------
						//->Calculando 
						$id_persona_asignada = $r->id_persona;	
						//La persona asignada al equipo, Es el mismo SOLICITANTE
						if ($id_persona_asignada==$id_persona){
							// cuando son la misma persona
							// los datos de la asignacion del equipo, van para el solicitante
							$id_cargo=$r->id_cargo;
							$id_departamento=$r->id_departamento;
							//-> y los datos asignacion, van vacios, ya que solo e trata de una persona.
							$id_persona_asignada="";
							$id_cargo_pa=0;
							$id_departamento_pa=0;

						}else{
							//Como es distinto el solicitante y la persona asignada al equipo
							// Se necesita por separado, los datos de cada uno
							//################################
							// los datos con que se realiza la solicitud (datos de la opcion elegida en el select'En interfaz')
							$id_cargo=$data->__GET('id_cargo');
							$id_departamento=$data->__GET('id_departamento');
							//---
							// Los datos realacionados a la asginacion actual, del equipo.
							$id_cargo_pa=$r->id_cargo;
							$id_departamento_pa=$r->id_departamento;

						}

		     	/********************************************************/
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO solicitud (
															`asunto`, 
															`descripcion`,
															`fecha`,
															`id_persona`,
															`id_cargo`,
															`id_departamento`,
															`id_persona_asignada`,
															`id_cargo_pa`,
															`id_departamento_pa`,
															`id_equipo`					
														) 
						        				VALUES (
							        				    	:asunto,
							        				    	:descripcion,
							        				    	now(),
							        				    	:id_persona,
							        				    	:id_cargo,
							        				    	:id_departamento,
							        				    	:id_persona_asignada,
							        				    	:id_cargo_pa,
							        				    	:id_departamento_pa,
							        				    	:id_equipo
						        				    	)"
							);
		     	$consulta->bindValue(':asunto', utf8_decode( $data->__GET('asunto')));
		     	$consulta->bindValue(':descripcion', utf8_decode( $data->__GET('descripcion')));
		     	$consulta->bindValue(':id_persona', $id_persona);
		     	$consulta->bindValue(':id_cargo', $id_cargo);
		     	$consulta->bindValue(':id_departamento', $id_departamento);

		     	$consulta->bindValue(':id_persona_asignada', $id_persona_asignada);
		     	$consulta->bindValue(':id_cargo_pa', $id_cargo_pa);
		     	$consulta->bindValue(':id_departamento_pa', $id_departamento_pa);

		     	$consulta->bindValue(':id_equipo', $id_equipo);

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
		public function guardarConformidad($id_solicitud, $observacion, $conformidad)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO solt_conformidad (
															`observacion`, 
															`fecha`,
															`id_solt`,
															`estado`
														) 
						        				VALUES (
							        				    	:observacion,
							        				    	now(),
							        				    	:id_solt,
							        				    	:estado
						        				    	)"
							);
		     	$consulta->bindValue(':observacion', utf8_decode($observacion));
		     	$consulta->bindValue(':id_solt', $id_solicitud);
		     	$consulta->bindValue(':estado', $conformidad);

		     	$consulta->execute();
		     	$ultimoId = $this->classConexion->getUltimoIdGuardado();
				$consulta = $this->classConexion->getCerrarSesion();
				//-> CONFIRMANDO ACTIVAR EQUIPO, SI SE ESTA CONFIRMANDO QUE EL EQUIPO FUE RECIBIDO
				$this->activarEquipoConfirmarEntrega($id_solicitud);
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
		public function activarEquipoConfirmarEntrega($id_solicitud)
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
												pe.id_equipo
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

					if ($r2) {
						$consulta3 = $this->classConexion->getConexion()->
									prepare(
											"UPDATE equipo SET
													`estado` 	= 1
											WHERE id=:id_equipo AND estado = 2 "
									);
				     	$consulta3->bindValue(':id_equipo', $r2->id_equipo);

				     	$consulta3->execute();
						$consulta3 = $this->classConexion->getCerrarSesion();
					}
				}
			}
		
/**********************************************************************************/		

		public function Listar($id_persona, $filtro, $buscardordesde, $buscardorhasta, $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE s.id_persona = :id_persona  ";

			if (!empty($filtro)) {
				$sqlFiltros .= "  AND ( e.serial LIKE :serialperif OR e.serial_bn LIKE :serial_bnperif  )   ";
			}
			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				$sqlFiltros .= " AND ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
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
													s.fecha, 
													e.serial, 
													e.serial_bn, 
													s.estado
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
												WHERE s.id_persona = :id_persona 
												ORDER BY s.estado ASC , s.fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_persona', $id_persona);	

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT 
													s.id, 
													s.asunto,
													s.fecha, 
													e.serial, 
													e.serial_bn, 
													s.estado
												FROM solicitud AS s
												INNER JOIN equipo AS e ON e.id = s.id_equipo
											    	".$sqlFiltros."  
												ORDER BY s.estado ASC , s.fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_persona', $id_persona);	

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
							$solt_estado = '3';
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
								if ($result_c->estado_atencion!=1 ) {
									$solt_estado = $r->estado;
								}
							}
						}


			   		/*******************************************/

					$result[] = array(
										'id_solicitud' => $id_solicitud,
										'asunto' => utf8_encode($r->asunto),
										'fecha'  => $r->fecha,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'estado' => $solt_estado,
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
			$sqlFiltros = " WHERE s.id_persona = :id_persona  ";

			if (!empty($filtro)) {
				$sqlFiltros .= "  AND ( e.serial LIKE :serialperif OR e.serial_bn LIKE :serial_bnperif  )   ";
			}
			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
					$sqlFiltros .= " AND ( s.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
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
												WHERE s.id_persona = :id_persona 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_persona', $id_persona);	

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
			   		$consulta->bindValue(':id_persona', $id_persona);	

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

		public function cargarListaDepartamentoACargo($id_persona)
		{
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("	
										SELECT 
											CONCAT( c.nombre, ' - ', d.nombre) as cargoydepartamento,
											c.id as id_cargo,
											c.responsable_departamento,
											d.id as id_departamento  
										FROM `persona_equipo` as pe
										INNER JOIN cfg_departamento as d ON d.id = pe.id_departamento
										INNER JOIN cfg_pn_cargo as c ON c.id = pe.id_cargo 
										WHERE pe.estado = 1 AND pe.id_persona = :id_persona AND c.responsable_departamento = 1	
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_persona', $id_persona);	
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_cargo' =>$r->id_cargo,
										'id_departamento' => $r->id_departamento,
										'cargoydepartamento' => utf8_encode($r->cargoydepartamento),
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


		public function ListarEquiposDepartamento($id_departamento, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
										 e.id as id_equipo,
										 e.serial as serial, 
										 e.serial_bn as serial_bn,
										 ccft.nombre as tipo,
										 e.estado as estado_equipo  
										FROM `persona_equipo` as pe
										INNER JOIN equipo as e ON e.id = pe.id_equipo
										INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	
										LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 
										LEFT JOIN cfg_c_fisc_modelo as ccfm ON ccfm.id = ccf_eq.id_modelo_fisc 
										LEFT JOIN cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
										INNER JOIN cfg_departamento as d ON d.id = pe.id_departamento
										INNER JOIN cfg_pn_cargo as c ON c.id = pe.id_cargo 
										WHERE pe.estado = 1 AND pe.id_departamento = :id_departamento 
										ORDER BY e.id DESC 
										LIMIT :empezardesde , :tamagnopaginas 	
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_departamento', $id_departamento);	

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$id_equipo = $r->id_equipo;
					$resultadoEMP = "";// si hay mantenimiento preventivo activo en el equipo
					$resultadoESA = "";// si hay solicitud activa en el equipo
					//$esConfirmadaLaasignacion=1;//Si cuando hay una solicitud en proceso, para confirmar que el equipo fue recibido					
					/************************************************************************/
					// cuantas tareas preventivas tiene activas el equipo
						$consultaEMP = $this->classConexion->getConexion()->
									prepare("	 	SELECT 
														COUNT( m.estado ) AS resultado
													FROM  `mantenimiento` AS m
													INNER JOIN tarea_equipo AS te ON te.id = m.id_tarea_equipo
													INNER JOIN equipo AS e ON e.id = te.id_equipo
													WHERE e.id = :id_equipo AND m.estado =1    
											");
				   		$consultaEMP->bindValue(':id_equipo', $id_equipo);	
				   		$consultaEMP->execute();
						$rEMP = $consultaEMP->fetch(PDO::FETCH_OBJ);
						$consultaEMP = $this->classConexion->getCerrarSesion();

						if ($rEMP) {
							$resultadoEMP = $rEMP->resultado;
						}
					/************************************************************************/
					// TIene una solicitud activada actualmente
						$consultaESA = $this->classConexion->getConexion()->
									prepare("	 	SELECT 
														COUNT(id) as resultado
													FROM `solicitud` 
													WHERE `id_equipo` = :id_equipo AND ( estado = 1 OR estado = 0 )
											");
				   		$consultaESA->bindValue(':id_equipo', $id_equipo);	
				   		$consultaESA->execute();
						$rESA = $consultaESA->fetch(PDO::FETCH_OBJ);
						$consultaESA = $this->classConexion->getCerrarSesion();

						if ($rESA) {
							$resultadoESA = $rESA->resultado;
						}
					/************************************************************************/
/*					// Se daño el equipo anterior, PERO AUN EL NUEVO ESPERA CONFIRMACION DE RECIBIDO DEL SOLICITANTE.
						//Consultando los datos de la solicitud
						// Verificando, que el equipo este confirmado como recibido, por la persona que lo solicito
						$consultaConfirmacion = $this->classConexion->getConexion()->
									prepare("	 	SELECT 
														solt_c.estado as resultadoConfirmacion
													FROM `solicitud` as s
													INNER JOIN equipo as e ON e.id = s.id_equipo AND e.estado = 0
													INNER JOIN persona_equipo as pe ON pe.estado = 1 AND 
													(pe.id_persona = s.id_persona AND pe.id_cargo = s.id_cargo AND pe.id_departamento=s.id_departamento )
													OR (pe.id_persona = s.id_persona_asignada AND pe.id_cargo = s.id_cargo_pa AND pe.id_departamento=s.id_departamento_pa ) 
													LEFT JOIN solt_conformidad as solt_c ON s.id = solt_c.id_solt AND solt_c.estado=1
													WHERE pe.id_equipo = :id_equipo AND s.estado = 1 
											");
				   		$consultaConfirmacion->bindValue(':id_equipo', $id_equipo);	
				   		$consultaConfirmacion->execute();
						$rConfirmacion = $consultaConfirmacion->fetch(PDO::FETCH_OBJ);
						$consultaConfirmacion = $this->classConexion->getCerrarSesion();

						if ($rConfirmacion) {
							$esConfirmadaLaasignacion = $rConfirmacion->resultadoConfirmacion;
						}
						//---
*/
					/************************************************************************/
					$result[] = array(
										'id_equipo' => $id_equipo,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'tipo' => utf8_encode($r->tipo),
										'estado_equipo' => $r->estado_equipo,
										'resultadoEMP' => $resultadoEMP,
										'resultadoESA' => $resultadoESA,	
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
		public function getTotalPaginasEquiposDepartamento($id_departamento,$getTotalPaginas)
		{
			try
			{
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(pe.id_equipo) as num_filas 
												FROM `persona_equipo` as pe
												INNER JOIN equipo as e ON e.id = pe.id_equipo
												INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	
												LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 
												LEFT JOIN cfg_c_fisc_modelo as ccfm ON ccfm.id = ccf_eq.id_modelo_fisc 
												LEFT JOIN cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
												INNER JOIN cfg_departamento as d ON d.id = pe.id_departamento
												INNER JOIN cfg_pn_cargo as c ON c.id = pe.id_cargo 
												WHERE pe.estado = 1 AND pe.id_departamento = :id_departamento    
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_departamento', $id_departamento);	

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

		public function ListarEquiposPersona($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("		
										SELECT 
											e.id as id_equipo,
											e.serial as serial, 
											e.serial_bn as serial_bn,
											ccft.nombre as tipo,
											e.estado as estado_equipo,
											CONCAT( c.nombre ,' - ', d.nombre ) as cargoydepartamento
										FROM  equipo as e 
											INNER JOIN `persona_equipo` as pe ON pe.id_equipo = e.id 
											INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	
											LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 
											INNER JOIN cfg_departamento as d ON d.id = pe.id_departamento
											INNER JOIN cfg_pn_cargo as c ON c.id = pe.id_cargo
										WHERE ( e.estado=1 OR e.estado=2 ) AND pe.estado=1 AND pe.id_persona = :id_persona	 
										ORDER BY e.id DESC 
										LIMIT :empezardesde , :tamagnopaginas 	
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_persona', $filtro);	

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$id_equipo = $r->id_equipo;
					$resultadoEMP = "";// si hay mantenimiento preventivo activo en el equipo
					$resultadoESA = "";// si hay solicitud activa en el equipo
					/************************************************************************/
					// cuantas tareas preventivas tiene activas el equipo
					$consultaEMP = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT( m.estado ) AS resultado
												FROM  `mantenimiento` AS m
												INNER JOIN tarea_equipo AS te ON te.id = m.id_tarea_equipo
												INNER JOIN equipo AS e ON e.id = te.id_equipo
												WHERE e.id = :id_equipo AND m.estado =1    
										");
			   		$consultaEMP->bindValue(':id_equipo', $id_equipo);	
			   		$consultaEMP->execute();
					$rEMP = $consultaEMP->fetch(PDO::FETCH_OBJ);
					$consultaEMP = $this->classConexion->getCerrarSesion();

					if ($rEMP) {
						$resultadoEMP = $rEMP->resultado;
					}
					/************************************************************************/
					// TIene una solicitud activada actualmente
					$consultaESA = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(id) as resultado 
												FROM `solicitud` 
												WHERE `id_equipo` = :id_equipo AND ( estado = 1 OR estado = 0 )
										");
			   		$consultaESA->bindValue(':id_equipo', $id_equipo);	
			   		$consultaESA->execute();
					$rESA = $consultaESA->fetch(PDO::FETCH_OBJ);
					$consultaESA = $this->classConexion->getCerrarSesion();

					if ($rESA) {
						$resultadoESA = $rESA->resultado;
					}
					/************************************************************************/
					$result[] = array(
										'id_equipo' => $id_equipo,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'tipo' => $r->tipo,
										'estado_equipo' => $r->estado_equipo,
										'cargoydepartamento' => utf8_encode($r->cargoydepartamento),
										'resultadoEMP' => $resultadoEMP,
										'resultadoESA' => $resultadoESA,										
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
		public function getTotalPaginasEquiposPersona($filtro,$getTotalPaginas)
		{
			try
			{
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(pe.id_equipo) as num_filas 
												FROM `persona_equipo` as pe
												INNER JOIN equipo as e ON e.id = pe.id_equipo
												INNER JOIN  cfg_caracteristicas_fisc_eq as ccf_eq ON ccf_eq.id = e.id_c_fisc_eq	
												LEFT JOIN cfg_c_fisc_tipo as ccft ON ccft.id = ccf_eq.id_tipo_fisc 
												WHERE pe.estado = 1 AND e.estado=1 AND pe.id_persona = :id_persona	 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_persona', $filtro);	

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
