<?php

	class modTareaProgramada extends tarea_equipo {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function obtenerNombreTarea($id_tarea_equipo)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare("SELECT 
					        			t.nombre as nombre
									FROM tarea_equipo as te         
									INNER JOIN  cfg_tarea as t ON t.id = te.id_tarea 
									WHERE te.id = :id_tarea_equipo " );

			   	$consulta->bindValue(':id_tarea_equipo', $id_tarea_equipo);	
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					return utf8_encode($r->nombre); 
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function obtenerSerialEquipoTarea($id_tarea_equipo)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare("SELECT 
					        			e.serial as serial
									FROM tarea_equipo as te         
									INNER JOIN  equipo as e ON e.id = te.id_equipo 
									WHERE te.id = :id_tarea_equipo " );

			   	$consulta->bindValue(':id_tarea_equipo', $id_tarea_equipo);	
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					return utf8_encode($r->serial); 
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function consultar($id_tarea_equipo)
		{

			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare("SELECT
										t.id as id_tarea,   
										t.tarea_correctiva,					        	
										e.id as id_equipo, 
										e.serial, 
										e.serial_bn, 
										cfg_cfm.id as id_modelo, 
										ccfmm.id as id_marca, 
										ccft.id as id_tipo, 
										p.cedula as cedula, 
										pn_c.id as id_cargo,
										d.id as id_departamento, 
										te.tiempo_estimado,
										te.frecuencia,
										te.ultima_fecha,
										te.proxima_fecha  
									FROM persona_equipo as pe 
									LEFT JOIN equipo as e ON pe.id_equipo = e.id  
									LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
									LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
									LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
									LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
									LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento 
									LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
									LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
									LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
									INNER JOIN  tarea_equipo as te ON te.id_equipo = e.id          
									INNER JOIN  cfg_tarea as t ON t.id = te.id_tarea 
									WHERE pe.estado = 1 AND te.id = :id_tarea_equipo " );

			   	$consulta->bindValue(':id_tarea_equipo', $id_tarea_equipo);	
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					$resultados[] = array(
									'id_tarea' => $r->id_tarea, 
									'tarea_correctiva' => $r->tarea_correctiva,
									'id_equipo' => $r->id_equipo,
									'serial' => utf8_encode($r->serial),
									'serial_bn' => utf8_encode($r->serial_bn),						
									'id_modelo' => $r->id_modelo,									
									'id_marca' => $r->id_marca,									
									'id_tipo' => $r->id_tipo,
									'cedula' => $r->cedula,
									'id_cargo' => $r->id_cargo,
									'id_departamento' => $r->id_departamento,
									'tiempo_estimado' => $r->tiempo_estimado,
									'frecuencia' => $r->frecuencia,
									'ultima_fecha' => $r->ultima_fecha,
									'proxima_fecha' => $r->proxima_fecha,
								);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function cambiarEstado(tarea_equipo $data)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
							prepare(
										"UPDATE tarea_equipo SET 
											estado_uso		= :estado_uso
									    WHERE id = :id "
									);

			   	$consulta->bindValue(':id', $data->__GET('id'));			
		     	$consulta->bindValue(':estado_uso', $data->__GET('estado_uso'));

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();

				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function agregarTiempoEstimadoMant($id_tarea_equipo)
		{
			try
			{
				$consultaC = $this->classConexion->getConexion()->
						        prepare(
										" 	SELECT 
												tiempo_estimado
											FROM tarea_equipo 
											WHERE id = :id_tarea_equipo AND estado_uso = 1 " 
						   				);
		     	$consultaC->bindValue(':id_tarea_equipo', $id_tarea_equipo);
				$consultaC->execute();
				$rC = $consultaC->fetch(PDO::FETCH_OBJ);
				$tiempo_estimado=0;
				if ($rC) {
					$tiempo_estimado = $rC->tiempo_estimado;
				}				
				return $tiempo_estimado;

			}catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		public function guardoMant(mantenimiento $data)
		{
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
															`id_tarea_equipo`
														) 
						        				VALUES (
							        				    	now(),
							        				    	:tiempo_estimado_mant,
							        				    	:estado,
							        				    	:id_tipo_mant,
							        				    	:id_tarea_equipo
						        				    	)");

		     	$consulta->bindValue(':estado', 1);
		     	$consulta->bindValue(':id_tipo_mant', 1);
		     	$consulta->bindValue(':id_tarea_equipo', $data->__GET('id_tarea_equipo'));
		     	$tiempo_estimado_mant=0;
		     	if ($data->__GET('id_tarea_equipo')>0) {
		     		$tiempo_estimado_mant = $this->agregarTiempoEstimadoMant($data->__GET('id_tarea_equipo'));
		     	}
		     	$consulta->bindValue(':tiempo_estimado_mant', $tiempo_estimado_mant);

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


				$consultaC = $this->classConexion->getConexion()->
						        prepare(
										" 	SELECT 
												id as id_mantenimiento 
											FROM mantenimiento 
											WHERE id_tarea_equipo = :id_tarea_equipo AND estado = 1 AND id_tipo_mant = 1 " 
						   				);
		     	$consultaC->bindValue(':id_tarea_equipo', $data->__GET('id_tarea_equipo'));
				$consultaC->execute();
				$rC = $consultaC->fetch(PDO::FETCH_OBJ);
				$consultaC = $this->classConexion->getCerrarSesion();

				$id_mantenimiento=0;
				if ($rC) {
					$id_mantenimiento = $rC->id_mantenimiento;
				}


				$consulta = $this->classConexion->getConexion()->
							prepare(
									"	UPDATE mantenimiento SET  
										`fecha_f` = now(),
										`observacion`      = :observacion,
										`estado`           = :estado    
										WHERE 	id_tarea_equipo = :id_tarea_equipo AND estado = 1 AND id_tipo_mant = 1
							  		");
		     	$consulta->bindValue(':observacion', utf8_decode($data->__GET('observacion')));
		     	$consulta->bindValue(':id_tarea_equipo', $data->__GET('id_tarea_equipo'));
		     	$consulta->bindValue(':estado', 0);
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
		public function calcularProximaFecha(mantenimiento $data)
		{
			try 
			{

				$id_tarea_equipo = $data->__GET('id_tarea_equipo');

				$ControlFrecuencia = "";
				/*****************/
				$consultaTE = $this->classConexion->getConexion()->
					        prepare("SELECT
										te.tiempo_estimado,
										te.frecuencia,
										te.ultima_fecha,
										te.proxima_fecha  
									FROM tarea_equipo as te 
									WHERE te.id = :id_tarea_equipo " );

			   	$consultaTE->bindValue(':id_tarea_equipo', $id_tarea_equipo);	
				$consultaTE->execute();
				$r = $consultaTE->fetch(PDO::FETCH_OBJ);
				$consultaTE = $this->classConexion->getCerrarSesion();

				if ($r) {
					$ControlFrecuencia = $r->frecuencia;
				}
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>		
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
				// -> Calculando para las fechas proximas
				$proxima_fecha = calculaFecha("days",$ControlFrecuencia,false);
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>		
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare("UPDATE tarea_equipo SET  
										`ultima_fecha` = now(),    
										`proxima_fecha` = :proxima_fecha  
										WHERE 	id = :id 
							  		");
		     	$consulta->bindValue(':proxima_fecha', $proxima_fecha);
		     	$consulta->bindValue(':id', $id_tarea_equipo);
		     	$consulta->execute();
			
				$consulta = $this->classConexion->getCerrarSesion();

				//die("frecuencia : ".$ControlFrecuencia." proxima_fecha : ".$proxima_fecha." id_tarea_equipo : ".$id_tarea_equipo); 		    
				
		     	//$this->classConexion->getConexion()->commit();
		     	// que la ejecucion fue exitosa
				return true;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
		public function calcularProximaFechaSinModificarUltima(mantenimiento $data)
		{
			try 
			{

				$id_tarea_equipo = $data->__GET('id_tarea_equipo');

				$ControlFrecuencia = "";
				/*****************/
				$consultaTE = $this->classConexion->getConexion()->
					        prepare("SELECT
										te.tiempo_estimado,
										te.frecuencia,
										te.ultima_fecha,
										te.proxima_fecha  
									FROM tarea_equipo as te 
									WHERE te.id = :id_tarea_equipo " );

			   	$consultaTE->bindValue(':id_tarea_equipo', $id_tarea_equipo);	
				$consultaTE->execute();
				$r = $consultaTE->fetch(PDO::FETCH_OBJ);
				$consultaTE = $this->classConexion->getCerrarSesion();

				if ($r) {
					$ControlFrecuencia = $r->frecuencia;
				}
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>		
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
				// -> Calculando para las fechas proximas
				$proxima_fecha = calculaFecha("days",$ControlFrecuencia,false);
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>		
				//->>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>>
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare("UPDATE tarea_equipo SET  
										`proxima_fecha` = :proxima_fecha  
										WHERE 	id = :id 
							  		");
		     	$consulta->bindValue(':proxima_fecha', $proxima_fecha);
		     	$consulta->bindValue(':id', $id_tarea_equipo);
		     	$consulta->execute();
			
				$consulta = $this->classConexion->getCerrarSesion();

				//die("frecuencia : ".$ControlFrecuencia." proxima_fecha : ".$proxima_fecha." id_tarea_equipo : ".$id_tarea_equipo); 		    
				
		     	//$this->classConexion->getConexion()->commit();
		     	// que la ejecucion fue exitosa
				return true;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}						
		public function guardar(tarea_equipo $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO tarea_equipo (
															`id_tarea`, 
															`id_equipo`,
															`tiempo_estimado`,
															`frecuencia`,
															`proxima_fecha`
														) 
						        				VALUES (
							        				    	:id_tarea,
							        				    	:id_equipo,
							        				    	:tiempo_estimado,
							        				    	:frecuencia,
							        				    	:proxima_fecha
						        				    	)"
							);
		     	$consulta->bindValue(':id_tarea', $data->__GET('id_tarea'));
		     	$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     	$consulta->bindValue(':tiempo_estimado', $data->__GET('tiempo_estimado'));
		     	$consulta->bindValue(':frecuencia', $data->__GET('frecuencia'));
		     	$consulta->bindValue(':proxima_fecha', $data->__GET('proxima_fecha'));

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
		public function editar(tarea_equipo $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"	UPDATE tarea_equipo SET  
										`tiempo_estimado` = :tiempo_estimado,
										`frecuencia`      = :frecuencia  
										WHERE id_tarea = :id_tarea AND id_equipo = :id_equipo 
							  		");
		     	$consulta->bindValue(':id_tarea', $data->__GET('id_tarea'));
		     	$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     	$consulta->bindValue(':tiempo_estimado', $data->__GET('tiempo_estimado'));
		     	$consulta->bindValue(':frecuencia', $data->__GET('frecuencia'));

		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();
				/*******************************************************/

					$consulta = $this->classConexion->getConexion()->
						        prepare("SELECT
											id as id_tarea_equipo
										FROM tarea_equipo 
										WHERE id_tarea = :id_tarea AND id_equipo = :id_equipo " );

			     	$consulta->bindValue(':id_tarea', $data->__GET('id_tarea'));
		     		$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     		$consulta->execute();
					$r = $consulta->fetch(PDO::FETCH_OBJ);
					$consulta = $this->classConexion->getCerrarSesion();

					$id_tarea_equipo ="";

					if ($r) {

						$id_tarea_equipo = $r->id_tarea_equipo	;		
					}

				/******************************************************/
		     	//$this->classConexion->getConexion()->commit();
		     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
		     	// que la ejecucion fue exitosa
				return $id_tarea_equipo;

			} catch (Exception $e) 
			{
				//$this->classConexion->getConexion()->rollback();//En Estudio (Hay que activar la transaccion)
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}		

/**************************************CATALOGO PRINCIPAL***************************************/

	public function Listar($filtro, $serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD, $tareaListD, $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE pe.estado = 1  ";
	
			if (!empty($filtro)) {
				$sqlFiltros .= "  AND ( e.serial LIKE :serialeq  OR e.serial_bn LIKE :serialbneq )	 ";
			}
			if (!empty($serial)) {
				$sqlFiltros .= "  AND e.serial LIKE :serialperif   ";
			}
			if (!empty($serialBienN)) {

					$sqlFiltros .= " AND  e.serial_bn LIKE :serial_bnperif   ";
			}
			if (!empty($tipoListD)) {
					$sqlFiltros .= " AND cfg_cfe.id_tipo_fisc = :tipoperif   ";			
			}
			if (!empty($modeloListD)) {
	
				$sqlFiltros .= " AND cfg_cfe.id_modelo_fisc = :modeloperif   ";
			}
			if (!empty($cedula)) {

					$sqlFiltros .= " AND  p.cedula LIKE :cedula   ";
			}
			if (!empty($cargoListD)) {
					$sqlFiltros .= " AND pn_c.id = :cargo   ";			
			}
			if (!empty($departamentoListD)) {
	
				$sqlFiltros .= " AND d.id = :departamento   ";
			}

			if (!empty($tareaListD)) {
	
				$sqlFiltros .= " AND te.id_tarea = :tarea ";
			}

			try
			{
				if(	empty($filtro) && 
					empty($serial) && empty($serialBienN) && 
					empty($tipoListD) && empty($modeloListD) && 
					empty($cedula) && empty($cargoListD) && 
					empty($departamentoListD) && empty($tareaListD) 
				) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												e.estado as estado_equipo,
												te.ultima_fecha,
												te.proxima_fecha, 
												te.estado_uso, 
												t.id as id_tarea, 
												t.nombre as tarea,
												t.tarea_correctiva,
												te.id as id_tarea_equipo   
											FROM persona_equipo as pe 
											LEFT JOIN equipo as e ON pe.id_equipo = e.id  
											LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
											LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
											LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento 
											LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
											LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
											LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
											INNER JOIN   tarea_equipo as te ON te.id_equipo = e.id          
											INNER JOIN   cfg_tarea as t ON t.id = te.id_tarea  
											WHERE pe.estado = 1  
											ORDER BY te.proxima_fecha DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												e.estado as estado_equipo,												
												te.ultima_fecha,
												te.proxima_fecha, 
												te.estado_uso, 
												t.id as id_tarea, 
												t.nombre as tarea,
												t.tarea_correctiva,
												te.id as id_tarea_equipo  												 
											FROM persona_equipo as pe 
											LEFT JOIN equipo as e ON pe.id_equipo = e.id  
											LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
											LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
											LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento 
											LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
											LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
											LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
											INNER JOIN   tarea_equipo as te ON te.id_equipo = e.id          
											INNER JOIN   cfg_tarea as t ON t.id = te.id_tarea 
											   ".$sqlFiltros."       										
											ORDER BY te.proxima_fecha DESC 											
											LIMIT :empezardesde , :tamagnopaginas 
										");

					if (!empty($filtro)) {
				   		$consulta->bindValue(':serialeq', '%'.$filtro.'%');	
				   		$consulta->bindValue(':serialbneq', '%'.$filtro.'%');	
					}
					if (!empty($serial)) {
				   		$consulta->bindValue(':serialperif', '%'.$serial.'%');	
					}
					if (!empty($serialBienN)) {
				   		$consulta->bindValue(':serial_bnperif', '%'.$serialBienN.'%');	
					}
					if (!empty($tipoListD)) {
				   		$consulta->bindValue(':tipoperif', $tipoListD);	
					}
					if (!empty($modeloListD)) {
				   		$consulta->bindValue(':modeloperif', $modeloListD);	
					}
					if (!empty($cedula)) {
				   		$consulta->bindValue(':cedula', '%'.$cedula.'%');	
					}
					if (!empty($cargoListD)) {
				   		$consulta->bindValue(':cargo', $cargoListD);	
					}
					if (!empty($departamentoListD)) {
				   		$consulta->bindValue(':departamento', $departamentoListD);	
					}
					if (!empty($tareaListD)) {
				   		$consulta->bindValue(':tarea', $tareaListD);	
					}

				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$id_equipo = $r->id_equipo;
					$solicitudActiva = "";
					/*****************/
					$consultaSA = $this->classConexion->getConexion()->
						        prepare("SELECT 1 as resultado
						        		FROM `solicitud` 
						        		WHERE id_equipo = :id_equipo AND ( estado = 1 OR estado = 0 )  " );

				   	$consultaSA->bindValue(':id_equipo', $id_equipo);	
					$consultaSA->execute();
					$rSA = $consultaSA->fetch(PDO::FETCH_OBJ);
					$consultaSA = $this->classConexion->getCerrarSesion();

					if ($rSA) {
						$solicitudActiva = $rSA->resultado;
					}
					/*****************/
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


					$result[] = array(
										'id_equipo' => $id_equipo,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'estado_equipo' => $r->estado_equipo,
										'ultima_fecha' => $r->ultima_fecha,
										'proxima_fecha' => $proxima_fecha,
										'dias_restantes' => $dias_restantes,
										'resultadoCalculoMenorQueProximidad' => $resultadoCalculoMenorQueProximidad,
										'control_vencimiento_fecha' => $control_vencimiento_fecha,
										'estado_uso' => $r->estado_uso,
										'id_tarea' => $r->id_tarea,
										'tarea' => utf8_encode($r->tarea),
										'tarea_correctiva' => $r->tarea_correctiva,
										'id_tarea_equipo' => $r->id_tarea_equipo,
										'solicitudActiva' => $solicitudActiva,
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

	public function getTotalPaginas($filtro, $serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD, $tareaListD, $getTotalPaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE pe.estado = 1  ";
	
			if (!empty($filtro)) {
				$sqlFiltros .= "  AND ( e.serial LIKE :serialeq  OR e.serial_bn LIKE :serialbneq )	 ";
			}	
			if (!empty($serial)) {
				$sqlFiltros .= "  AND e.serial LIKE :serialperif   ";
			}
			if (!empty($serialBienN)) {
				$sqlFiltros .= " AND  e.serial_bn LIKE :serial_bnperif   ";
			}
			if (!empty($tipoListD)) {
				$sqlFiltros .= " AND cfg_cfe.id_tipo_fisc = :tipoperif   ";			
			}
			if (!empty($modeloListD)) {
	
				$sqlFiltros .= " AND cfg_cfe.id_modelo_fisc = :modeloperif   ";
			}
			if (!empty($cedula)) {
				$sqlFiltros .= " AND  p.cedula LIKE :cedula   ";
			}
			if (!empty($cargoListD)) {
				$sqlFiltros .= " AND pn_c.id = :cargo   ";			
			}
			if (!empty($departamentoListD)) {
				$sqlFiltros .= " AND d.id = :departamento   ";
			}
			if (!empty($tareaListD)) {	
				$sqlFiltros .= " AND te.id_tarea = :tarea ";
			}

			try
			{
				if(	empty($filtro) && 	
					empty($serial) && empty($serialBienN) && 
					empty($tipoListD) && empty($modeloListD) && 
					empty($cedula) && empty($cargoListD) && 
					empty($departamentoListD) && empty($tareaListD) 
				) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												COUNT(e.id) as num_filas  
											FROM persona_equipo as pe 
											LEFT JOIN equipo as e ON pe.id_equipo = e.id  
											LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
											LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
											LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento 
											LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
											LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
											LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
											INNER JOIN   tarea_equipo as te ON te.id_equipo = e.id          
											INNER JOIN   cfg_tarea as t ON t.id = te.id_tarea 
											WHERE pe.estado = 1 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	
											SELECT 
												COUNT(e.id) as num_filas  
											FROM persona_equipo as pe 
											LEFT JOIN equipo as e ON pe.id_equipo = e.id  
											LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
											LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
											LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento 
											LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
											LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
											LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
											INNER JOIN   tarea_equipo as te ON te.id_equipo = e.id          
											INNER JOIN   cfg_tarea as t ON t.id = te.id_tarea 
											  ".$sqlFiltros."  

										");


					if (!empty($filtro)) {
				   		$consulta->bindValue(':serialeq', '%'.$filtro.'%');	
				   		$consulta->bindValue(':serialbneq', '%'.$filtro.'%');	
					}
					if (!empty($serial)) {
				   		$consulta->bindValue(':serialperif', '%'.$serial.'%');	
					}
					if (!empty($serialBienN)) {
				   		$consulta->bindValue(':serial_bnperif', '%'.$serialBienN.'%');	
					}
					if (!empty($tipoListD)) {
				   		$consulta->bindValue(':tipoperif', $tipoListD);	
					}
					if (!empty($modeloListD)) {
				   		$consulta->bindValue(':modeloperif', $modeloListD);	
					}
					if (!empty($cedula)) {
				   		$consulta->bindValue(':cedula', '%'.$cedula.'%');	
					}
					if (!empty($cargoListD)) {
				   		$consulta->bindValue(':cargo', $cargoListD);	
					}
					if (!empty($departamentoListD)) {
				   		$consulta->bindValue(':departamento', $departamentoListD);	
					}
					if (!empty($tareaListD)) {
				   		$consulta->bindValue(':tarea', $tareaListD);	
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


/**************************************************************************************************/
////////////////////////////////////////////////////////////////////////////////////
	public function ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD, $tareaListD, $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE pe.estado = 1 AND (e.estado = 1 OR e.estado = 2) ";

			if (!empty($serial)) {
				$sqlFiltros .= "  AND e.serial LIKE :serialperif   ";
			}
			if (!empty($serialBienN)) {

					$sqlFiltros .= " AND  e.serial_bn LIKE :serial_bnperif   ";
			}
			if (!empty($tipoListD)) {
					$sqlFiltros .= " AND cfg_cfe.id_tipo_fisc = :tipoperif   ";			
			}
			if (!empty($modeloListD)) {
	
				$sqlFiltros .= " AND cfg_cfe.id_modelo_fisc = :modeloperif   ";
			}
			if (!empty($cedula)) {

					$sqlFiltros .= " AND  p.cedula LIKE :cedula   ";
			}
			if (!empty($cargoListD)) {
					$sqlFiltros .= " AND pn_c.id = :cargo   ";			
			}
			if (!empty($departamentoListD)) {
	
				$sqlFiltros .= " AND d.id = :departamento   ";
			}

			try
			{

				if(	empty($serial) && empty($serialBienN) && 
					empty($tipoListD) && empty($modeloListD) && 
					empty($cedula) && empty($cargoListD) && 
					empty($departamentoListD) 
				) {
			
								$SQL="	SELECT
											DISTINCT e.id,									
											p.cedula as cedula,
											CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
											pn_c.id as id_cargo, 
											d.id as id_departamento,
											CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
											e.id as id_equipo,
											e.serial,
											e.serial_bn,
											ccft.id as id_tipo,
											ccft.nombre as tipo,
											cfg_cfm.id as id_modelo,
											ccfmm.id as id_marca,
											CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo 			
										FROM persona_equipo as pe 
										LEFT JOIN   equipo as e ON pe.id_equipo = e.id  
										LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
										LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
										LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
										LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
										LEFT JOIN   tarea_equipo as te ON te.id_equipo = e.id   
										LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento 
										LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
										LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
										LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
										WHERE pe.estado = 1 AND ( e.estado = 1 OR e.estado = 2 )
										ORDER BY pe.fecha DESC 											
										LIMIT :empezardesde , :tamagnopaginas 
													";
								$consulta = $this->classConexion->getConexion()->prepare($SQL);

				} else {
								$SQL = "	SELECT
												DISTINCT e.id,									
												p.cedula as cedula,
												CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
												pn_c.id as id_cargo, 
												d.id as id_departamento,
												CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												ccft.id as id_tipo,
												ccft.nombre as tipo,
												cfg_cfm.id as id_modelo,
												ccfmm.id as id_marca,
												CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo  			
											FROM persona_equipo as pe 
											LEFT JOIN   equipo as e ON pe.id_equipo = e.id  
											LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
											LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
											LEFT JOIN   tarea_equipo as te ON te.id_equipo = e.id   
											LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento  
											LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
											LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
											LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
											   ".$sqlFiltros."       										 
											ORDER BY pe.fecha DESC 											 
											LIMIT :empezardesde , :tamagnopaginas    
										";
								$consulta = $this->classConexion->getConexion()->prepare($SQL);

								if (!empty($serial)) {
							   		$consulta->bindValue(':serialperif', '%'.$serial.'%');	
								}
								if (!empty($serialBienN)) {
							   		$consulta->bindValue(':serial_bnperif', '%'.$serialBienN.'%');	
								}
								if (!empty($tipoListD)) {
							   		$consulta->bindValue(':tipoperif', $tipoListD);	
								}
								if (!empty($modeloListD)) {
							   		$consulta->bindValue(':modeloperif', $modeloListD);	
								}
								if (!empty($cedula)) {
							   		$consulta->bindValue(':cedula', '%'.$cedula.'%');	
								}
								if (!empty($cargoListD)) {
							   		$consulta->bindValue(':cargo', $cargoListD);	
								}
								if (!empty($departamentoListD)) {
							   		$consulta->bindValue(':departamento', $departamentoListD);	
								}

				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$id_equipo_control = $r->id_equipo;
					$resultado = 0;					
					/*******************************************************/
					$consultaET = $this->classConexion->getConexion()->
						        prepare("SELECT
											COUNT(id) as resultado 
										FROM tarea_equipo 
										WHERE id_tarea = :id_tarea AND id_equipo = :id_equipo 
										");

				   	$consultaET->bindValue(':id_tarea', $tareaListD);	
				   	$consultaET->bindValue(':id_equipo', $id_equipo_control);	
					$consultaET->execute();
					$rET = $consultaET->fetch(PDO::FETCH_OBJ);
					$consultaET = $this->classConexion->getCerrarSesion();

					if ($rET) {
						$resultado = $rET->resultado;
					}
					/*******************************************************/
					if ($resultado==0) {

						$result[] = array(
											'cedula' => $r->cedula,
											'nombreApellido' => utf8_encode($r->nombreApellido),
											'id_equipo' => $id_equipo_control,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'id_tipo' => $r->id_tipo,
											'id_modelo' => $r->id_modelo,
											'id_marca' => $r->id_marca,
											'id_cargo' => $r->id_cargo,	
											'id_departamento' => $r->id_departamento,	
											'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
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

	public function getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$cedula,$cargoListD,$departamentoListD, $tareaListD, $getTotalPaginas)
		{

			$result 	= array();
			$sqlFiltros = " WHERE pe.estado = 1 AND (e.estado = 1 OR e.estado = 2) ";

			if (!empty($serial)) {
				$sqlFiltros .= "  AND e.serial LIKE :serialperif   ";
			}
			if (!empty($serialBienN)) {
				$sqlFiltros .= " AND  e.serial_bn LIKE :serial_bnperif   ";
			}
			if (!empty($tipoListD)) {
				$sqlFiltros .= " AND cfg_cfe.id_tipo_fisc = :tipoperif   ";			
			}
			if (!empty($modeloListD)) {
	
				$sqlFiltros .= " AND cfg_cfe.id_modelo_fisc = :modeloperif   ";
			}
			if (!empty($cedula)) {
				$sqlFiltros .= " AND  p.cedula LIKE :cedula   ";
			}
			if (!empty($cargoListD)) {
				$sqlFiltros .= " AND pn_c.id = :cargo   ";			
			}
			if (!empty($departamentoListD)) {
				$sqlFiltros .= " AND d.id = :departamento   ";
			}

			try
			{
				if(	empty($serial) && empty($serialBienN) && 
					empty($tipoListD) && empty($modeloListD) && 
					empty($cedula) && empty($cargoListD) && 
					empty($departamentoListD)  
				) {
			
					$SQL = "	SELECT 
									DISTINCT e.id,									
									COUNT(e.id) as num_filas  
								FROM persona_equipo as pe 
								LEFT JOIN   equipo as e ON pe.id_equipo = e.id  
								LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
								LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
								LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
								LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
								LEFT JOIN   tarea_equipo as te ON te.id_equipo = e.id   
								LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento  
								LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
								LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
								LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona    
								WHERE pe.estado = 1 AND ( e.estado = 1 OR e.estado = 2 )
										";
					$consulta = $this->classConexion->getConexion()->prepare($SQL);

				} else {
						$SQL = "SELECT 
									DISTINCT e.id,									
									COUNT(e.id) as num_filas  
								FROM persona_equipo as pe 
								LEFT JOIN   equipo as e ON pe.id_equipo = e.id  
								LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
								LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
								LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca 
								LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
								LEFT JOIN   tarea_equipo as te ON te.id_equipo = e.id   
								LEFT JOIN	cfg_departamento_cargo as dc ON dc.id_cargo = pe.id_cargo AND  dc.id_departamento = pe.id_departamento  
								LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo
								LEFT JOIN   cfg_departamento as d ON d.id = dc.id_departamento
								LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona        
								   ".$sqlFiltros;

							$consulta = $this->classConexion->getConexion()->prepare($SQL);

							if (!empty($serial)) {
						   		$consulta->bindValue(':serialperif', '%'.$serial.'%');	
							}
							if (!empty($serialBienN)) {
						   		$consulta->bindValue(':serial_bnperif', '%'.$serialBienN.'%');	
							}
							if (!empty($tipoListD)) {
						   		$consulta->bindValue(':tipoperif', $tipoListD);	
							}
							if (!empty($modeloListD)) {
						   		$consulta->bindValue(':modeloperif', $modeloListD);	
							}
							if (!empty($cedula)) {
						   		$consulta->bindValue(':cedula', '%'.$cedula.'%');	
							}
							if (!empty($cargoListD)) {
						   		$consulta->bindValue(':cargo', $cargoListD);	
							}
							if (!empty($departamentoListD)) {
						   		$consulta->bindValue(':departamento', $departamentoListD);	
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
	

/********************************************************************************/   

	public function cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva($tipo_tarea)
	{ 
		$result = array();
		try
		{

			$SQL="";
			if ($tipo_tarea=='preventiva') {
				$SQL = "	 	SELECT 
										* 
								FROM  cfg_tarea    
								WHERE estado = 1 AND tarea_correctiva=0
								";
			} else {
				//CORRECTIVA
				$SQL = "	 	SELECT 
										* 
								FROM  cfg_tarea  
								WHERE estado = 1 AND tarea_correctiva=1
								";
			}
		
			$consulta = $this->classConexion->getConexion()->prepare($SQL);

			$consulta->execute();

			foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$id = $r->id;
				if ($id!=0) {					
					$result[] = array(
										'id' => $id,						
										'nombre' => utf8_encode($r->nombre),

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


/********************************************************************************/

		public function ListarReporte($filtro_tarea, $filtro_seria_e, $filtro_desde, $filtro_hasta, $empezar_desde, $tamagno_paginas)
		{ 

			$result 	= array();
			$sqlFiltros = "  ";

			if (!empty($filtro_tarea)) {
				$sqlFiltros .= " AND t.id= :tarea ";
			}
			if (!empty($filtro_seria_e)) {
				$sqlFiltros .= " AND  e.serial LIKE :serialperif ";
			}
			if (!empty($filtro_desde) && !empty($filtro_hasta)) {
				$sqlFiltros .= " AND ( te.proxima_fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";						
			}

			try
			{

				if(	empty($filtro_tarea) && empty($filtro_seria_e) &&
					empty($filtro_desde) && empty($filtro_hasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT
													t.nombre,
												    e.serial,
												    te.proxima_fecha,
												    TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW()) as dias_intervalo,
												    (SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3) as dias_proximidad_tarea,
												    (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3)) as amarillo,
												    (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0) as rojo
												FROM tarea_equipo as te
												INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
												INNER JOIN equipo as e ON e.id = te.id_equipo
												WHERE e.estado<>0 AND t.tarea_correctiva=0 AND( (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3 ))=1 OR (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1)
												ORDER BY te.proxima_fecha DESC 
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT
													t.nombre,
												    e.serial,
												    te.proxima_fecha,
												    TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW()) as dias_intervalo,
												    (SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3) as dias_proximidad_tarea,
												    (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3)) as amarillo,
												    (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0) as rojo
												FROM tarea_equipo as te
												INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
												INNER JOIN equipo as e ON e.id = te.id_equipo
												WHERE e.estado<>0 AND t.tarea_correctiva=0 AND( (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3 ))=1 OR (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1)  
													".$sqlFiltros."    
												ORDER BY te.proxima_fecha DESC 
											    LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($filtro_tarea)) {
				   		$consulta->bindValue(':tarea', $filtro_tarea);
					}
					if (!empty($filtro_seria_e)) {
				   		$consulta->bindValue(':serialperif', '%'.$filtro_seria_e.'%');	
					}
					if (!empty($filtro_desde) && !empty($filtro_hasta)) {
				   		$consulta->bindValue(':buscardordesde', $filtro_desde);	
				   		$consulta->bindValue(':buscardorhasta', $filtro_hasta);	
					}

			   	}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezar_desde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagno_paginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'nombre' => utf8_encode($r->nombre),
										'serial' => utf8_encode($r->serial),
										'proxima_fecha'  => utf8_encode($r->proxima_fecha),
										'dias_intervalo' => utf8_encode($r->dias_intervalo),
										'dias_proximidad_tarea' => utf8_encode($r->dias_proximidad_tarea),
										'amarillo' => utf8_encode($r->amarillo),
										'rojo' => utf8_encode($r->rojo),
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

		public function getTotalPaginasReporte($filtro_tarea, $filtro_seria_e, $filtro_desde, $filtro_hasta, $getTotalPaginas)
		{ 

			$result 	= array();
			$sqlFiltros = "  ";

			if (!empty($filtro_tarea)) {
				$sqlFiltros .= " AND t.id= :tarea ";
			}
			if (!empty($filtro_seria_e)) {
				$sqlFiltros .= " AND e.serial LIKE :serialperif  ";
			}
			if (!empty($filtro_desde) && !empty($filtro_hasta)) {
				$sqlFiltros .= " AND ( te.proxima_fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";						
			}

			try
			{

				if(	empty($filtro_tarea) && empty($filtro_seria_e) &&
					empty($filtro_desde) && empty($filtro_hasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT
													COUNT(t.id) as num_filas
												FROM tarea_equipo as te
												INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
												INNER JOIN equipo as e ON e.id = te.id_equipo
												WHERE e.estado<>0 AND t.tarea_correctiva=0 AND( (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3 ))=1 OR (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1)
												ORDER BY te.proxima_fecha DESC
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		
												SELECT
													COUNT(t.id) as num_filas
												FROM tarea_equipo as te
												INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
												INNER JOIN equipo as e ON e.id = te.id_equipo
												WHERE e.estado<>0 AND t.tarea_correctiva=0 AND( (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3 ))=1 OR (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1)
											    	".$sqlFiltros."  
												ORDER BY te.proxima_fecha DESC 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($filtro_tarea)) {
				   		$consulta->bindValue(':tarea', $filtro_tarea);
					}
					if (!empty($filtro_seria_e)) {
				   		$consulta->bindValue(':serialperif', '%'.$filtro_seria_e.'%');	
					}
					if (!empty($filtro_desde) && !empty($filtro_hasta)) {
				   		$consulta->bindValue(':buscardordesde', $filtro_desde);	
				   		$consulta->bindValue(':buscardorhasta', $filtro_hasta);	
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

/********************************************************************************/

		public function ListarReporteTareasConcurrentes($filtro_marca, $filtro_modelo, $filtro_tipo, $fecha_1, $fecha_2)
		{
			$this->classConexion = new classConexion();
			$result = array();

			$sqlFiltros = "";
			$sqlFiltros_1 = "";
			$sqlFiltros_2 = "";

			if (!empty($filtro_marca)) {
				$sqlFiltros .= " AND cfe_mm.id = :filtro_marca ";
				$sqlFiltros_1 .= " AND cfe_mm_2.id = :filtro_marca ";
				$sqlFiltros_2 .= " AND cfe_mm_2.id = :filtro_marca ";
			}
			if (!empty($filtro_modelo)) {
				$sqlFiltros .= " AND cfe_m.id = :filtro_modelo ";
				$sqlFiltros_1 .= " AND cfe_m_2.id = :filtro_modelo ";
				$sqlFiltros_2 .= " AND cfe_m_2.id = :filtro_modelo ";				
			}			
			if (!empty($filtro_tipo)) {
				$sqlFiltros .= " AND cfe_t.id = :filtro_tipo ";
				$sqlFiltros_1 .= " AND cfe_t_2.id = :filtro_tipo ";
				$sqlFiltros_2 .= " AND cfe_t_2.id = :filtro_tipo ";
			}						
			if (!empty($fecha_1) && !empty($fecha_2)) {
				$sqlFiltros .= " AND ( m.fecha_f BETWEEN :buscardordesde AND :buscardorhasta ) ";
				$sqlFiltros_1 .= " AND ( MSUB.fecha_f BETWEEN :buscardordesde AND :buscardorhasta ) ";				
				$sqlFiltros_2 .= " AND ( MSUB_2.fecha_f BETWEEN :buscardordesde AND :buscardorhasta ) ";				
			}

			try
			{
				if( empty($filtro_marca) && empty($filtro_modelo) && empty($filtro_tipo) && empty($fecha_1) && empty($fecha_2)) {			
					$SQL = " SELECT
							  	t.nombre as nombre_tarea,
							  	(SELECT COUNT(TESUB_2.id_tarea) FROM mantenimiento AS MSUB_2 INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo) as total,
							  	(SELECT COUNT(TESUB_2.id_tarea) FROM mantenimiento AS MSUB_2 INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo WHERE  TESUB_2.id_tarea = te.id_tarea) as total_individual,
						        ROUND( (SELECT
						            (
						              COUNT(TESUB.id_tarea)*100/(SELECT
						                    COUNT(TESUB_2.id_tarea)
						                  FROM mantenimiento AS MSUB_2
						                  INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo) 
						            )
						          FROM mantenimiento AS MSUB
						          INNER JOIN tarea_equipo as TESUB ON TESUB.id = MSUB.id_tarea_equipo    
						          WHERE
						            TESUB.id_tarea = te.id_tarea
						        ),0) AS promedio
							FROM mantenimiento AS m
							INNER JOIN tarea_equipo AS te ON te.id = m.id_tarea_equipo
							INNER JOIN cfg_tarea AS t ON t.id = te.id_tarea
							GROUP BY te.id_tarea
						";

					}else{

							$SQL = "SELECT
									  	t.nombre as nombre_tarea,
									  	(SELECT COUNT(TESUB_2.id_tarea) FROM mantenimiento AS MSUB_2 INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo 
												INNER JOIN cfg_tarea AS t_2 ON t_2.id = TESUB_2.id_tarea		
												INNER JOIN equipo as e_2 ON e_2.id = TESUB_2.id_equipo 
												LEFT JOIN cfg_caracteristicas_fisc_eq as cfe_2 ON cfe_2.id = e_2.id_c_fisc_eq 
												LEFT JOIN cfg_c_fisc_tipo as cfe_t_2 ON cfe_t_2.id = cfe_2.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo as cfe_m_2 ON cfe_m_2.id = cfe_2.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm_2 ON cfe_mm_2.id = cfe_m_2.id_marca
									  		WHERE MSUB_2.estado=0 ".$sqlFiltros_2.") as total,
									  	(SELECT COUNT(TESUB_2.id_tarea) FROM mantenimiento AS MSUB_2 INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo 
												INNER JOIN cfg_tarea AS t_2 ON t_2.id = TESUB_2.id_tarea		
												INNER JOIN equipo as e_2 ON e_2.id = TESUB_2.id_equipo 
												LEFT JOIN cfg_caracteristicas_fisc_eq as cfe_2 ON cfe_2.id = e_2.id_c_fisc_eq 
												LEFT JOIN cfg_c_fisc_tipo as cfe_t_2 ON cfe_t_2.id = cfe_2.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo as cfe_m_2 ON cfe_m_2.id = cfe_2.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm_2 ON cfe_mm_2.id = cfe_m_2.id_marca
									  		WHERE  TESUB_2.id_tarea = te.id_tarea ".$sqlFiltros_2.") as total_individual,
								        ROUND( (SELECT
								            (
								              COUNT(TESUB.id_tarea)*100/(SELECT
								                    COUNT(TESUB_2.id_tarea)
								                  FROM mantenimiento AS MSUB_2
								                  INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo
													INNER JOIN cfg_tarea AS t_2 ON t_2.id = TESUB_2.id_tarea		
													INNER JOIN equipo as e_2 ON e_2.id = TESUB_2.id_equipo 
													LEFT JOIN cfg_caracteristicas_fisc_eq as cfe_2 ON cfe_2.id = e_2.id_c_fisc_eq 
													LEFT JOIN cfg_c_fisc_tipo as cfe_t_2 ON cfe_t_2.id = cfe_2.id_tipo_fisc
													LEFT JOIN cfg_c_fisc_modelo as cfe_m_2 ON cfe_m_2.id = cfe_2.id_modelo_fisc
													LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm_2 ON cfe_mm_2.id = cfe_m_2.id_marca
												  WHERE MSUB_2.estado=0 ".$sqlFiltros_2."
								                  ) 
								            )
								          FROM mantenimiento AS MSUB
								          INNER JOIN tarea_equipo as TESUB ON TESUB.id = MSUB.id_tarea_equipo    
										INNER JOIN cfg_tarea AS t_2 ON t_2.id = TESUB.id_tarea		
										INNER JOIN equipo as e_2 ON e_2.id = TESUB.id_equipo 
										LEFT JOIN cfg_caracteristicas_fisc_eq as cfe_2 ON cfe_2.id = e_2.id_c_fisc_eq 
										LEFT JOIN cfg_c_fisc_tipo as cfe_t_2 ON cfe_t_2.id = cfe_2.id_tipo_fisc
										LEFT JOIN cfg_c_fisc_modelo as cfe_m_2 ON cfe_m_2.id = cfe_2.id_modelo_fisc
										LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm_2 ON cfe_mm_2.id = cfe_m_2.id_marca								          
								          WHERE
								            TESUB.id_tarea = te.id_tarea ".$sqlFiltros_1."
								        ),0) AS promedio
									FROM mantenimiento AS m
									INNER JOIN tarea_equipo AS te ON te.id = m.id_tarea_equipo
									INNER JOIN cfg_tarea AS t ON t.id = te.id_tarea		
									INNER JOIN equipo as e ON e.id = te.id_equipo 
									LEFT JOIN cfg_caracteristicas_fisc_eq as cfe ON cfe.id = e.id_c_fisc_eq 
									LEFT JOIN cfg_c_fisc_tipo as cfe_t ON cfe_t.id = cfe.id_tipo_fisc
									LEFT JOIN cfg_c_fisc_modelo as cfe_m ON cfe_m.id = cfe.id_modelo_fisc
									LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm ON cfe_mm.id = cfe_m.id_marca

									WHERE m.estado=0 ".$sqlFiltros."  
									GROUP BY te.id_tarea ";
				}								

				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				
				if (!empty($filtro_marca)) {
			   		$consulta->bindValue(':filtro_marca', $filtro_marca);
			  	}
				if (!empty($filtro_modelo)) {
			   		$consulta->bindValue(':filtro_modelo', $filtro_modelo);
			  	}
				if (!empty($filtro_tipo)) {
			   		$consulta->bindValue(':filtro_tipo', $filtro_tipo);
			  	}			  	
				if (!empty($fecha_1) && !empty($fecha_2)) {
			   		$consulta->bindValue(':buscardordesde', $fecha_1);
			   		$consulta->bindValue(':buscardorhasta', $fecha_2);
				}
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$result[] = array(
										'value'				=> utf8_encode($r->promedio),
										'label'				=> utf8_encode($r->nombre_tarea), 
										'formatted'			=> utf8_encode($r->total_individual.'/'.$r->total.' | '.$r->promedio.'%'), 
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

/**************************/

		public function ListarReporteDesincorporacionesConcurrentes($filtro_funcion, $filtro_departamento, $fecha_1, $fecha_2, $opcionrpt)
		{

			$this->classConexion = new classConexion();
			$result = array();
			$opcionrpt_dat="";
			$control_fecha="";
			// -> Control tipo de reporte
				switch ($opcionrpt) {
					case 'generico':
						$opcionrpt_dat = " fpej.id, DAY(pej.fecha) ";
						$control_fecha = "(CONCAT(DAY(pej.fecha),'-',MONTH(pej.fecha),'-',YEAR(pej.fecha))) as fecha_m,";
						break;
					case 'detallado':
						$opcionrpt_dat = " fpej.id, DAY(pej.fecha), m.id ";
						$control_fecha = " pej.fecha as fecha_m, ";
						break;						
				}
			//
			$sqlFiltros = "";

			if (!empty($filtro_funcion)) {
				$sqlFiltros .= " AND fpej.id = :filtro_funcion ";
			}

			if (!empty($filtro_departamento)) {
				$sqlFiltros .= " AND d.id = :filtro_departamento ";
			}			
			if (!empty($fecha_1) && !empty($fecha_2)) {
				$sqlFiltros .= " AND ( pej.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";
			}

			try
			{
				if( empty($filtro_funcion) && empty($filtro_departamento) && empty($fecha_1) && empty($fecha_2)) {			
					$SQL = " SELECT
								(CONCAT(DAY(pej.fecha),'-',MONTH(pej.fecha),'-',YEAR(pej.fecha))) as fecha,
								".$control_fecha." 
                                COUNT(pej.fecha) as concurrencia,
							    d.nombre as departamento,
							    fpej.nombre as funcion,
							    m.observacion
							FROM  mantenimiento AS m
                            INNER JOIN persona_ejecuta as pej ON pej.id_mantenimiento = m.id
                            INNER JOIN pnej_funcion_persona as fpej ON fpej.id = pej.id_funcion_persona 
							LEFT JOIN solicitud as s ON s.id = m.id_solicitud
							LEFT JOIN cfg_departamento as d ON d.id = s.id_departamento
							LEFT JOIN cfg_departamento as d1 ON d1.id = s.id_departamento_pa
							WHERE ( fpej.id=4 OR fpej.id=5 OR fpej.id=6 OR fpej.id=7 OR fpej.id=8 OR fpej.id=8 OR fpej.id=9 OR fpej.id=10 ) AND m.estado=0					
							GROUP BY ".$opcionrpt_dat."
                            ORDER BY pej.fecha ASC
						";

					}else{

							$SQL = "SELECT
								(CONCAT(DAY(pej.fecha),'-',MONTH(pej.fecha),'-',YEAR(pej.fecha))) as fecha,							
								".$control_fecha." 
                                COUNT(pej.fecha) as concurrencia,
							    d.nombre as departamento,
							    fpej.nombre as funcion,
							    m.observacion
							FROM  mantenimiento AS m
                            INNER JOIN persona_ejecuta as pej ON pej.id_mantenimiento = m.id
                            INNER JOIN pnej_funcion_persona as fpej ON fpej.id = pej.id_funcion_persona 
							LEFT JOIN solicitud as s ON s.id = m.id_solicitud
							LEFT JOIN cfg_departamento as d ON d.id = s.id_departamento
							LEFT JOIN cfg_departamento as d1 ON d1.id = s.id_departamento_pa
							WHERE ( fpej.id=4 OR fpej.id=5 OR fpej.id=6 OR fpej.id=7 OR fpej.id=8 OR fpej.id=8 OR fpej.id=9 OR fpej.id=10 ) AND m.estado=0
							".$sqlFiltros."				
							GROUP BY ".$opcionrpt_dat."
                            ORDER BY pej.fecha ASC ";
				}								

				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				
				if (!empty($filtro_funcion)) {
			   		$consulta->bindValue(':filtro_funcion', $filtro_funcion);
			  	}
				if (!empty($filtro_departamento)) {
			   		$consulta->bindValue(':filtro_departamento', $filtro_departamento);
			  	}
				if (!empty($fecha_1) && !empty($fecha_2)) {
			   		$consulta->bindValue(':buscardordesde', $fecha_1);
			   		$consulta->bindValue(':buscardorhasta', $fecha_2);
				}
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'fecha'				=> $r->fecha,
										'fecha_m'			=> $r->fecha_m,
										'concurrencia'		=> $r->concurrencia,
										'departamento'		=> utf8_encode($r->departamento),
										'funcion'			=> utf8_encode($r->funcion),
										'observacion'		=> $r->observacion,
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


/*************************/

		public function ListarReporteAreasConcurrentesTareasCorrectivas($filtro_marca, $filtro_modelo, $filtro_tipo, $fecha_1, $fecha_2, $opcionrpt)
		{
			$this->classConexion = new classConexion();
			$result = array();
			$opcionrpt_dat="";

			// -> Control tipo de reporte
				switch ($opcionrpt) {
					case 'generico':
						$opcionrpt_dat = " d.id ";
						break;
					case 'detallado':
						$opcionrpt_dat = " t.id, d.id ";
						break;						
				}
			//
			$sqlFiltros = "";
			$sqlFiltros_1 = "";
			$sqlFiltros_2 = "";

			if (!empty($filtro_marca)) {
				$sqlFiltros .= " AND cfe_mm.id = :filtro_marca ";
				$sqlFiltros_2 .= " AND cfe_mm_2.id = :filtro_marca ";
			}
			if (!empty($filtro_modelo)) {
				$sqlFiltros .= " AND cfe_m.id = :filtro_modelo ";
				$sqlFiltros_2 .= " AND cfe_m_2.id = :filtro_modelo ";				
			}			
			if (!empty($filtro_tipo)) {
				$sqlFiltros .= " AND cfe_t.id = :filtro_tipo ";

				$sqlFiltros_2 .= " AND cfe_t_2.id = :filtro_tipo ";
			}						
			if (!empty($fecha_1) && !empty($fecha_2)) {
				$sqlFiltros .= " AND ( m.fecha_f BETWEEN :buscardordesde AND :buscardorhasta ) ";
				$sqlFiltros_2 .= " AND ( MSUB_2.fecha_f BETWEEN :buscardordesde AND :buscardorhasta ) ";				
			}

			try
			{
				if( empty($filtro_marca) && empty($filtro_modelo) && empty($filtro_tipo) && empty($fecha_1) && empty($fecha_2)) {			
					$SQL = " SELECT
								COUNT(d.id) as total_individual,
								(SELECT COUNT(TESUB_2.id_tarea) FROM mantenimiento AS MSUB_2 INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo INNER JOIN cfg_tarea as TSUB_2 ON TSUB_2.id = TESUB_2.id_tarea WHERE TSUB_2.tarea_correctiva=1 AND MSUB_2.estado=0) as total,
							    ROUND( 
							            (
							               COUNT(d.id)*100/(SELECT COUNT(TESUB_2.id_tarea) FROM mantenimiento AS MSUB_2 INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo INNER JOIN cfg_tarea as TSUB_2 ON TSUB_2.id = TESUB_2.id_tarea WHERE TSUB_2.tarea_correctiva=1 AND MSUB_2.estado=0)        
							           ),0) AS promedio,
							    d.nombre as departamento,
							    t.nombre as tarea
							FROM  mantenimiento AS m
							INNER JOIN tarea_equipo AS te ON te.id = m.id_tarea_equipo
							INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
							LEFT JOIN solicitud as s ON s.id = m.id_solicitud
							LEFT JOIN cfg_departamento as d ON d.id = s.id_departamento
							LEFT JOIN cfg_departamento as d1 ON d1.id = s.id_departamento_pa
							WHERE t.tarea_correctiva=1 AND m.estado=0
							GROUP BY  ".$opcionrpt_dat."
							ORDER BY d.id DESC
						";

					}else{

							$SQL = "SELECT
										COUNT(d.id) as total_individual,
										(SELECT COUNT(TESUB_2.id_tarea) 
										FROM mantenimiento AS MSUB_2 
										INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo 
										INNER JOIN cfg_tarea as TSUB_2 ON TSUB_2.id = TESUB_2.id_tarea 
										INNER JOIN equipo as e_2 ON e_2.id = TESUB_2.id_equipo 
										LEFT JOIN cfg_caracteristicas_fisc_eq as cfe_2 ON cfe_2.id = e_2.id_c_fisc_eq 
										LEFT JOIN cfg_c_fisc_tipo as cfe_t_2 ON cfe_t_2.id = cfe_2.id_tipo_fisc
										LEFT JOIN cfg_c_fisc_modelo as cfe_m_2 ON cfe_m_2.id = cfe_2.id_modelo_fisc
										LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm_2 ON cfe_mm_2.id = cfe_m_2.id_marca										
										WHERE TSUB_2.tarea_correctiva=1 AND MSUB_2.estado=0  ".$sqlFiltros_2." ) as total,
									    ROUND(
									            (
									               COUNT(d.id)*100/(SELECT COUNT(TESUB_2.id_tarea) 
				               					FROM mantenimiento AS MSUB_2 
				               					INNER JOIN tarea_equipo as TESUB_2 ON TESUB_2.id = MSUB_2.id_tarea_equipo 
				               					INNER JOIN cfg_tarea as TSUB_2 ON TSUB_2.id = TESUB_2.id_tarea 
												INNER JOIN equipo as e_2 ON e_2.id = TESUB_2.id_equipo 
												LEFT JOIN cfg_caracteristicas_fisc_eq as cfe_2 ON cfe_2.id = e_2.id_c_fisc_eq 
												LEFT JOIN cfg_c_fisc_tipo as cfe_t_2 ON cfe_t_2.id = cfe_2.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo as cfe_m_2 ON cfe_m_2.id = cfe_2.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm_2 ON cfe_mm_2.id = cfe_m_2.id_marca
				               					WHERE TSUB_2.tarea_correctiva=1 AND MSUB_2.estado=0 ".$sqlFiltros_2.")
									           ),0) AS promedio,
									    d.nombre as departamento,
									    t.nombre as tarea 
									FROM  mantenimiento AS m
									INNER JOIN tarea_equipo AS te ON te.id = m.id_tarea_equipo
									INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
									LEFT JOIN solicitud as s ON s.id = m.id_solicitud
									LEFT JOIN cfg_departamento as d ON d.id = s.id_departamento
									LEFT JOIN cfg_departamento as d1 ON d1.id = s.id_departamento_pa									
									INNER JOIN equipo as e ON e.id = te.id_equipo 
									LEFT JOIN cfg_caracteristicas_fisc_eq as cfe ON cfe.id = e.id_c_fisc_eq 
									LEFT JOIN cfg_c_fisc_tipo as cfe_t ON cfe_t.id = cfe.id_tipo_fisc
									LEFT JOIN cfg_c_fisc_modelo as cfe_m ON cfe_m.id = cfe.id_modelo_fisc
									LEFT JOIN cfg_c_fisc_mod_marca as cfe_mm ON cfe_mm.id = cfe_m.id_marca
									WHERE t.tarea_correctiva=1 AND m.estado=0 ".$sqlFiltros."  
									GROUP BY ".$opcionrpt_dat."
									ORDER BY d.id DESC ";
				}								

				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				
				if (!empty($filtro_marca)) {
			   		$consulta->bindValue(':filtro_marca', $filtro_marca);
			  	}
				if (!empty($filtro_modelo)) {
			   		$consulta->bindValue(':filtro_modelo', $filtro_modelo);
			  	}
				if (!empty($filtro_tipo)) {
			   		$consulta->bindValue(':filtro_tipo', $filtro_tipo);
			  	}			  	
				if (!empty($fecha_1) && !empty($fecha_2)) {
			   		$consulta->bindValue(':buscardordesde', $fecha_1);
			   		$consulta->bindValue(':buscardorhasta', $fecha_2);
				}
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					// -> Control tipo de reporte
						switch ($opcionrpt) {
							case 'generico':
					$result[] = array(
										'value'				=> $r->promedio,
										'label'				=> utf8_encode($r->departamento), 
										'formatted'			=> $r->total_individual.'/'.$r->total.' | '.$r->promedio.'%', 
										'tarea'				=> utf8_encode($r->tarea),
									);
							break;
							case 'detallado':
					$result[] = array(
										'value'				=> $r->promedio,
										'label'				=> utf8_encode($r->departamento), 
										'formatted'			=> $r->total_individual.'/'.$r->total.' | '.$r->promedio.'%', 
										'preview'			=> utf8_encode($r->tarea),
									);
							break;
						}
					//					
				}
				$consulta = $this->classConexion->getCerrarSesion();
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}


/**************************/

		public function cargarListaDespegableTipo()
		{ 
			$result = array();
			try
			{

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT DISTINCT 
														cfg_t.* 
												FROM  cfg_caracteristicas_fisc_eq as ce 
												INNER JOIN cfg_c_fisc_tipo as cfg_t ON ce.id_tipo_fisc = cfg_t.id
												WHERE cfg_t.estado = 1 
										");
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$id = $r->id;
					if ($id!=0) {
						$result[] = array(
											'id' => $id,						
											'nombre' => $r->nombre,
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
/********************************************************************************/
   }	
		
?>
