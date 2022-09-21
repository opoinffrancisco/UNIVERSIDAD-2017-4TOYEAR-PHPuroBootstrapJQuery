<?php

	class modAsignar extends persona_equipo {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function guardar(persona_equipo $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO persona_equipo
														(
															`id_persona`, 
															`id_cargo`,
															`id_departamento`,
															`id_equipo`,
															`fecha`,
															`estado` 
														) 
						        				VALUES (
							        				    	:id_persona,
							        				    	:id_cargo,
							        				    	:id_departamento,
							        				    	:id_equipo,
							        				    	now(),
							        				    	:estado 
						        				    	)"
							);
		     	$consulta->bindValue(':id_persona', $data->__GET('id_persona'));
		     	$consulta->bindValue(':id_cargo', $data->__GET('id_cargo'));
		     	$consulta->bindValue(':id_departamento', $data->__GET('id_departamento'));
		     	$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     	$consulta->bindValue(':estado', 1);

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
		public function editarPorEstado2(persona_equipo $data)
		{
			try 
			{
				$id_equipo = $data->__GET('id_equipo');
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"UPDATE persona_equipo SET
											`id_equipo` = :id_equipo,
											`estado` 	= 1
									WHERE id_persona = :id_persona AND id_cargo = :id_cargo AND 
										id_departamento = :id_departamento AND estado = 2 "
							);
		     	$consulta->bindValue(':id_persona', $data->__GET('id_persona'));
		     	$consulta->bindValue(':id_cargo', $data->__GET('id_cargo'));
		     	$consulta->bindValue(':id_departamento', $data->__GET('id_departamento'));
		     	$consulta->bindValue(':id_equipo', $id_equipo);


		     	$consulta->execute();
				$consulta = $this->classConexion->getCerrarSesion();
				//---------------------------------
				// el estado 2 es para controlar, que el responsable aun no ha recibido el equipo,
				// luego que se le aye dañado el anterior
				$consulta2 = $this->classConexion->getConexion()->
							prepare(
									"UPDATE equipo SET
											`estado` 	= 2
									WHERE id = :id_equipo AND estado = 1 "
							);
		     	$consulta2->bindValue(':id_equipo', $id_equipo);


		     	$consulta2->execute();
				$consulta2 = $this->classConexion->getCerrarSesion();


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

	public function consultar($id_persona, $id_cargo,$id_departamento, $id_equipo)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	
										SELECT

											p.id as id_persona,
											p.cedula as cedula,
											CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
											p.correo_electronico,									
											pn_c.id as id_cargo, 
											d.id as id_departamento,
											CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
											e.id as id_equipo,
											e.serial,
											e.serial_bn,
											ccft.nombre as tipo,											
											CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo,
											pe.estado as estado_asignacion
										FROM persona_equipo as pe 
										LEFT JOIN equipo as e ON pe.id_equipo = e.id  
										LEFT JOIN 	cfg_caracteristicas_fisc_eq as cfg_cfe ON e.id_c_fisc_eq = cfg_cfe.id
										LEFT JOIN 	cfg_c_fisc_modelo as cfg_cfm ON  cfg_cfm.id = cfg_cfe.id_modelo_fisc	
										LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = cfg_cfm.id_marca
										LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = cfg_cfe.id_tipo_fisc 
										LEFT JOIN   cfg_pn_cargo as pn_c ON pn_c.id = pe.id_cargo
										LEFT JOIN   cfg_departamento as d ON d.id = pe.id_departamento
										LEFT JOIN   cfg_persona as p ON p.id = pe.id_persona 
										WHERE (pe.estado = 1 OR pe.estado = 2 ) AND pe.id_persona=:id_persona AND pe.id_cargo = :id_cargo AND
										pe.id_departamento = :id_departamento  AND pe.id_equipo = :id_equipo " 
					   				);
				//die(' persona:'.$id_persona.' cargo: '.$id_cargo.' departamento: '.$id_departamento.' equipo: '.$id_equipo);
			   	$consulta->bindValue(':id_persona', $id_persona);					          
			   	$consulta->bindValue(':id_cargo', $id_cargo);	
			   	$consulta->bindValue(':id_departamento', $id_departamento);	
			   	$consulta->bindValue(':id_equipo', $id_equipo);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {

					/***********************************************************************/
					// OBTENIENDO ID DE SOLICITUD
					$id_solicitud_gestion = 0;
					$consultaS = $this->classConexion->getConexion()->
						        prepare(
										" 	SELECT
												id as id_solicitud
											FROM
												solicitud
											WHERE id_persona = :id_persona AND id_cargo = :id_cargo AND id_departamento = :id_departamento AND estado = 1 " 
						   				);
			     	$consultaS->bindValue(':id_persona', $id_persona);
			     	$consultaS->bindValue(':id_cargo', $id_cargo);
			     	$consultaS->bindValue(':id_departamento', $id_departamento);

					$consultaS->execute();
					$rS = $consultaS->fetch(PDO::FETCH_OBJ);
					$consultaS = $this->classConexion->getCerrarSesion();
					if ($rS) {
						$id_solicitud_gestion = $rS->id_solicitud;
					}
					/***********************************************************************/
					$id_persona = $r->id_persona;
					if ($id_persona!=0) {
						$cedula = $r->cedula;
						$nombreApellido = utf8_encode($r->nombreApellido);
						$correo_electronico = $r->correo_electronico;
					}else{
						$cedula = "";
						$nombreApellido = "";
						$correo_electronico = "";						
					};

					$resultados[] = array(
									'id_persona' => $id_persona,
									'cedula' => $cedula,
									'nombreApellido' => utf8_encode($nombreApellido),
									'correo_electronico' => $correo_electronico,
									'id_cargo' => $r->id_cargo,
									'id_departamento' => $r->id_departamento,
									'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
									'id_equipo' => $r->id_equipo,
									'serial' => utf8_encode($r->serial),
									'serial_bn' => utf8_encode($r->serial_bn),
									'tipo' => utf8_encode($r->tipo),
									'marcaymodelo' => utf8_encode($r->marcaymodelo),
									'estado_asignacion' => $r->estado_asignacion,
									'id_solicitud_gestion' => $id_solicitud_gestion,
								);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

	public function desactivarActualControlAsignacion($id_cargo,$id_departamento, $id_equipo, $id_persona)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
														" 	
															UPDATE persona_equipo SET 
															estado 		= :estado,
															observacion = 'SE REALIZO UNA REASIGNACION'
															WHERE ( estado = 1 OR estado = 2 )
															AND id_cargo = :id_cargo 
															AND id_departamento = :id_departamento  
															AND id_equipo = :id_equipo 
															AND id_persona = :id_persona
														" 
					   				);    
			   	
				//die('actuales: '.$id_cargo.' '.$id_departamento.' '.$id_persona.' '.$id_equipo) ;
			   	$consulta->bindValue(':estado', 0);			
				//
				//die('cargo: '.$id_cargo.' departamento: '.$id_departamento.' persona:'.$id_persona.' equipo:'.$id_equipo);


			   	$consulta->bindValue(':id_cargo', $id_cargo);			
			   	$consulta->bindValue(':id_departamento', $id_departamento);						   	
			   	$consulta->bindValue(':id_equipo', $id_equipo);	
			   	$consulta->bindValue(':id_persona', $id_persona);	
			
				if ($consulta->execute()) {
					$consulta = $this->classConexion->getCerrarSesion();
					return 1;
				}else{
					$consulta = $this->classConexion->getCerrarSesion();
					return 0;
				}

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}			

////////////////////////////////////////////////////////////////////

	public function Listar($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				if(empty($filtro)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("
											SELECT
												p.id as id_persona,
												p.cedula as cedula,
												CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
												p.correo_electronico,									
												pn_c.id as id_cargo, 
												pn_c.nombre as cargo, 											
												d.id as id_departamento,
												CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												ccft.nombre as tipo,											
												CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo,
												pe.estado as estado_asignacion,
												e.estado as estado_equipo 		
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
											WHERE ( pe.estado = 1 OR pe.estado = 2 )
											ORDER BY pe.fecha DESC 										
											LIMIT :empezardesde , :tamagnopaginas 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT
												p.id as id_persona,
												p.cedula as cedula,
												CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
												p.correo_electronico,									
												pn_c.id as id_cargo, 
												pn_c.nombre as cargo, 											
												d.id as id_departamento,
												CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												ccft.nombre as tipo,											
												CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo,
												pe.estado as estado_asignacion,
												e.estado as estado_equipo  			
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
											WHERE (pe.estado = 1 OR pe.estado = 2 ) AND ( e.serial LIKE :serialeq  OR e.serial_bn LIKE :serialbneq )										
											ORDER BY pe.fecha DESC 
											LIMIT :empezardesde , :tamagnopaginas  	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':serialeq', '%'.$filtro.'%');	
			   		$consulta->bindValue(':serialbneq', '%'.$filtro.'%');	
				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$id_persona = $r->id_persona;
					if ($id_persona==0) {
						$result[] = array(
											'id_equipo' => $r->id_equipo,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'id_persona' => null,										
											'cedula' => '',
											'nombreApellido' => utf8_encode(''),
											'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
											'id_cargo' => $r->id_cargo, 
											'id_departamento' => $r->id_departamento, 
											'estado_asignacion' => $r->estado_asignacion,
											'estado_equipo' => $r->estado_equipo,
																						
										);

					}else{

						$result[] = array(
											'id_persona' => $id_persona,
											'id_equipo' => $r->id_equipo,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'cedula' => $r->cedula,
											'nombreApellido' => utf8_encode($r->nombreApellido),
											'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
											'id_cargo' => $r->id_cargo, 
											'id_departamento' => $r->id_departamento, 
											'estado_asignacion' => $r->estado_asignacion,									
											'estado_equipo' => $r->estado_equipo,													
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

				if(empty($filtro)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												COUNT(*) as num_filas
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
											WHERE (pe.estado = 1 OR pe.estado = 2 )
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
							prepare("	 	SELECT 
												COUNT(*) as num_filas
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
											WHERE (pe.estado = 1 OR pe.estado = 2 ) AND ( e.serial LIKE :serialeq  OR e.serial_bn LIKE :serialbneq )
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':serialperif', '%'.$filtro.'%');	
			   		$consulta->bindValue(':serialperif2', '%'.$filtro.'%');

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
	//-------------------
	public function ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $cedula,$cargoListD,$departamentoListD,  $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE (pe.estado = 1 OR pe.estado = 2 )  ";

			$filtro1 = false;
			$filtro2 = false;
			$filtro3 = false;
			$filtro4 = false;
			$filtro5 = false;
			$filtro6 = false;
			$filtro7 = false;			
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
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT
												p.id as id_persona,
												p.cedula as cedula,
												CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
												p.correo_electronico,									
												pn_c.id as id_cargo, 
												pn_c.nombre as cargo, 											
												d.id as id_departamento,
												CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												ccft.nombre as tipo,											
												CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo,
												pe.estado as estado_asignacion ,
												e.estado as estado_equipo 			
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
											WHERE (pe.estado = 1 OR pe.estado = 2 )
											ORDER BY pe.fecha DESC 											
											LIMIT :empezardesde , :tamagnopaginas 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT
												p.id as id_persona,
												p.cedula as cedula,
												CONCAT(p.nombre, ' ',p.apellido) as nombreApellido,	
												p.correo_electronico,									
												pn_c.id as id_cargo, 
												pn_c.nombre as cargo, 											
												d.id as id_departamento,
												CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
												e.id as id_equipo,
												e.serial,
												e.serial_bn,
												ccft.nombre as tipo,											
												CONCAT(ccfmm.nombre,'  ', cfg_cfm.nombre) as marcaymodelo,
												pe.estado as estado_asignacion,
												e.estado as estado_equipo 			
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
											   ".$sqlFiltros."      										
											ORDER BY pe.fecha DESC 											
											LIMIT :empezardesde , :tamagnopaginas 
										");


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
					$id_persona = $r->id_persona;
					if ($id_persona==0) {
						$result[] = array(
											'id_equipo' => $r->id_equipo,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'id_persona' => null,										
											'cedula' => '',
											'nombreApellido' => utf8_encode(''),
											'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
											'id_cargo' => $r->id_cargo, 
											'id_departamento' => $r->id_departamento, 
											'estado_asignacion' => $r->estado_asignacion,	
											'estado_equipo' => $r->estado_equipo,
										);

					}else{

						$result[] = array(
											'id_equipo' => $r->id_equipo,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'id_persona' => $id_persona,										
											'cedula' => $r->cedula,
											'nombreApellido' => utf8_encode($r->nombreApellido),
											'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
											'id_cargo' => $r->id_cargo, 
											'id_departamento' => $r->id_departamento, 
											'estado_asignacion' => $r->estado_asignacion,
											'estado_equipo' => $r->estado_equipo,											
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

	public function getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$cedula,$cargoListD,$departamentoListD, $getTotalPaginas)
		{

			$result 	= array();
			$sqlFiltros = " WHERE ( pe.estado = 1 OR pe.estado = 2 )  ";

			$filtro1 = false;
			$filtro2 = false;
			$filtro3 = false;
			$filtro4 = false;
			$filtro5 = false;
			$filtro6 = false;
			$filtro7 = false;			
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
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												COUNT(*) as num_filas
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
											WHERE ( pe.estado = 1 OR pe.estado = 2 )
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	
											SELECT 
												COUNT(*) as num_filas
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
											  ".$sqlFiltros."  

										");


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
	
////////////////////////////////////////////////////////////////////
		
		public function ListarBusqdAvanzdEquiposASIG($serial,$serialBienN,$tipoListD,$modeloListD, $empezardesde, $tamagnopaginas)
			{ 
				$result 	= array();
				$sqlFiltros = " WHERE eqp.estado = 1 ";

				$filtro1 = false;
				$filtro2 = false;
				$filtro3 = false;
				$filtro4 = false;
				if (!empty($serial)) {
					$sqlFiltros .= " AND  eqp.serial LIKE :serialperif   ";
					//
					$filtro1=true;
				}
				if (!empty($serialBienN)) {
						$sqlFiltros .= " AND  eqp.serial_bn LIKE :serial_bnperif   ";
				}
				if (!empty($tipoListD)) {
						$sqlFiltros .= " AND ccfp.id_tipo_fisc = :tipoperif   ";			
					//
					$filtro3=true;
				}
				if (!empty($modeloListD)) {
						$sqlFiltros .= " AND ccfp.id_modelo_fisc = :modeloperif   ";
					//
					$filtro4=true;
				}


				try
				{
					if(	empty($serial) && empty($serialBienN) && 
						empty($tipoListD) && empty($modeloListD)
					) {
				
						$consulta = $this->classConexion->getConexion()->
									prepare("	
												SELECT  
													DISTINCT eqp.id AS id,
													eqp.serial AS serial, 
													eqp.serial_bn AS serial_bn, 
													CONCAT( ccfmm.nombre,  ' ', ccfm.nombre ) AS marcaymodelo, 
													ccft.nombre AS tipo
												FROM equipo AS eqp
												INNER JOIN cfg_caracteristicas_fisc_eq AS ccfp ON ccfp.id = eqp.id_c_fisc_eq
												LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfp.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfp.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
												WHERE eqp.estado = 1
												ORDER BY eqp.id DESC											
												LIMIT :empezardesde , :tamagnopaginas 
											");

					} else {
						$consulta = $this->classConexion->getConexion()->
									prepare("	 	SELECT  
													DISTINCT eqp.id AS id,
														eqp.serial AS serial, 
														eqp.serial_bn AS serial_bn, 
														CONCAT( ccfmm.nombre,  ' ', ccfm.nombre ) AS marcaymodelo, 
														ccft.nombre AS tipo 
													FROM equipo AS eqp
													INNER JOIN cfg_caracteristicas_fisc_eq AS ccfp ON ccfp.id = eqp.id_c_fisc_eq
													LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfp.id_tipo_fisc
													LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfp.id_modelo_fisc
													LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
													   ".$sqlFiltros."   
													ORDER BY eqp.id DESC	
													LIMIT :empezardesde , :tamagnopaginas 
											");


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

					}

					// Gestionando parametros para LIMIT en el SQL
				   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
				   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
					$consulta->execute();

					foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
					{

						$id_equipo = $r->id;
						$asignaciondActiva = false;
						/*****************/
						if($this->validarExitenciaAsignacionEquipo($id_equipo)==0) {
							$asignaciondActiva = true;
						}
						/*****************/
						$result[] = array(
											'id' => $id_equipo,
											'serial' => $r->serial,
											'serial_bn' => $r->serial_bn,
											'marcaymodelo' => utf8_encode($r->marcaymodelo),
											'tipo' => utf8_encode($r->tipo),
											'asignaciondActiva' => $asignaciondActiva,
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
		public function validarExitenciaAsignacionEquipo($id_equipo)
			{

				$asignaciondActiva = "";
				/*****************/
				$consultaAA = $this->classConexion->getConexion()->
					        prepare("SELECT DISTINCT
										COUNT(*) as resultado 
									FROM  equipo as e 
									INNER JOIN persona_equipo as pe ON pe.id_equipo = e.id
                                    WHERE pe.estado = 1 AND e.estado = 1 
									AND e.id = :id_equipo
									" );
			   	$consultaAA->bindValue(':id_equipo', $id_equipo);	
				$consultaAA->execute();
				$rAA = $consultaAA->fetch(PDO::FETCH_OBJ);
				$consultaAA = $this->classConexion->getCerrarSesion();

				if ($rAA) {
					$asignaciondActiva = $rAA->resultado;
				}
				return $asignaciondActiva;
			}
		public function getTotalPaginasBusqdAvanzdEquiposASIG($serial,$serialBienN,$tipoListD,$modeloListD,$getTotalPaginas)
			{
				$result 	= 0;
				$sqlFiltros = " WHERE eqp.estado = 1 ";

				$filtro1 = false;
				$filtro2 = false;
				$filtro3 = false;
				$filtro4 = false;
				if (!empty($serial)) {
					$sqlFiltros .= " AND  eqp.serial LIKE :serialperif   ";
					//
					$filtro1=true;
				}
				if (!empty($serialBienN)) {
						$sqlFiltros .= " AND  eqp.serial_bn LIKE :serial_bnperif   ";
				}
				if (!empty($tipoListD)) {
						$sqlFiltros .= " AND ccfp.id_tipo_fisc = :tipoperif   ";			
					//
					$filtro3=true;
				}
				if (!empty($modeloListD)) {
						$sqlFiltros .= " AND ccfp.id_modelo_fisc = :modeloperif   ";
					//
					$filtro4=true;
				}
				try
				{
					if(	empty($serial) && empty($serialBienN) && 
						empty($tipoListD) && empty($modeloListD)
					) {
				
						$consulta = $this->classConexion->getConexion()->
									prepare("	
												SELECT  
													COUNT(eqp.id) as num_filas
												FROM equipo AS eqp
												INNER JOIN cfg_caracteristicas_fisc_eq AS ccfp ON ccfp.id = eqp.id_c_fisc_eq
												LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfp.id_tipo_fisc
												LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfp.id_modelo_fisc
												LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
												WHERE eqp.estado = 1
												ORDER BY eqp.id DESC									
											");

					} else {
						$consulta = $this->classConexion->getConexion()->
									prepare("	 	SELECT  
														COUNT(eqp.id) as num_filas
													FROM equipo AS eqp
													INNER JOIN cfg_caracteristicas_fisc_eq AS ccfp ON ccfp.id = eqp.id_c_fisc_eq
													LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfp.id_tipo_fisc
													LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfp.id_modelo_fisc
													LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
													   ".$sqlFiltros."   
													ORDER BY eqp.id DESC	
											");


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

					}

					// Gestionando parametros para LIMIT en el SQL
					$consulta->execute();
					$objeto	= $consulta->fetchAll(PDO::FETCH_OBJ);	
					foreach($objeto as $r)
					{
						$result = $r->num_filas;
					}
					$consulta = $this->classConexion->getCerrarSesion();
					return 	$result;
				}
				catch(Exception $e)
				{
					return  "¡¡Error!! " .$e->getMessage(). " ! ";
				}
			}

	//-------------------

		public function ListarBusqdAvanzdCargoDepartamentoASIG($cargo,$departamento, $empezardesde, $tamagnopaginas)
			{ 
				$result 	= array();
				$sqlFiltros = "WHERE d.estado = 1 AND pn_c.estado = 1 AND dc.estado = 1   ";

				if (!empty($cargo)) {
						$sqlFiltros .= " AND  pn_c.id = :cargo   ";
				}
				if (!empty($departamento)) {
						$sqlFiltros .= " AND d.id = :departamento   ";			
				}

				try
				{
					if(	empty($cargo) && empty($departamento) ) {
				
						$consulta = $this->classConexion->getConexion()->
										prepare("	SELECT DISTINCT
														CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
														pn_c.id as id_cargo,
														pn_c.responsable_departamento,
														d.id as id_departamento 
														FROM  cfg_departamento_cargo as dc 
															INNER JOIN cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo 
															INNER JOIN cfg_departamento as d ON d.id = dc.id_departamento
														WHERE  d.estado = 1 AND pn_c.estado = 1 AND dc.estado=1
													ORDER BY d.nombre DESC
												LIMIT :empezardesde , :tamagnopaginas  
											");
					} else {
						$consulta = $this->classConexion->getConexion()->
									prepare("	 	
												SELECT DISTINCT 
													CONCAT(pn_c.nombre,' - ',d.nombre) as cargoDepartamento,
													pn_c.id as id_cargo,
													pn_c.responsable_departamento,
													d.id as id_departamento 
													FROM  cfg_departamento_cargo as dc 
														INNER JOIN cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo 
														INNER JOIN cfg_departamento as d ON d.id = dc.id_departamento
													   ".$sqlFiltros."    												
												ORDER BY d.nombre DESC
												LIMIT :empezardesde , :tamagnopaginas  

											");

						if (!empty($cargo)) {
					   		$consulta->bindValue(':cargo', $cargo);	
						}
						if (!empty($departamento)) {
					   		$consulta->bindValue(':departamento', $departamento);	
						}

					}

					// Gestionando parametros para LIMIT en el SQL
				   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
				   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
					$consulta->execute();
					$objeto	= $consulta->fetchAll(PDO::FETCH_OBJ);	
					foreach($objeto as $r)
					{
						$id_cargo_fila 		 = $r->id_cargo;
						$id_departamento_fila = $r->id_departamento;

						/*****************/
						$tieneAsignacionActiva=false;
						//evitando que los que ya tienen asignacion activa: vuelvan a aparecer
						if ($this->validarExitenciaAsignacion($id_cargo_fila, $id_departamento_fila)==0) {
							$tieneAsignacionActiva=true;
						}
						$result[] = array(
										'cargoDepartamento' => utf8_encode($r->cargoDepartamento),
										'responsable_departamento' => $r->responsable_departamento,
										'id_cargo' => $id_cargo_fila,
										'id_departamento' => $id_departamento_fila,	
										'tieneAsignacionActiva' => $tieneAsignacionActiva,
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
		public function validarExitenciaAsignacion($id_cargo_fila, $id_departamento_fila)
			{

				
				$asignaciondActiva = "";
				/*****************/
				$consultaAA = $this->classConexion->getConexion()->
					        prepare("SELECT DISTINCT
										COUNT(*) as resultado 
									FROM  cfg_departamento_cargo as dc 
									INNER JOIN cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo 
									INNER JOIN cfg_departamento as d ON d.id = dc.id_departamento
									INNER JOIN persona_equipo as pe ON pe.id_cargo = dc.id_cargo AND pe.id_departamento = dc.id_departamento  
									WHERE pe.estado =1 AND pn_c.estado = 1 AND d.estado = 1 
									AND pe.id_cargo = :id_cargo AND pe.id_departamento = :id_departamento
									" );
			   	$consultaAA->bindValue(':id_cargo', $id_cargo_fila);	
			   	$consultaAA->bindValue(':id_departamento', $id_departamento_fila);	
				$consultaAA->execute();
				$rAA = $consultaAA->fetch(PDO::FETCH_OBJ);
				$consultaAA = $this->classConexion->getCerrarSesion();

				if ($rAA) {
					$asignaciondActiva = $rAA->resultado;
				}
				return $asignaciondActiva;
			}
		public function getTotalPaginasBusqdAvanzdCargoDepartamentoASIG($cargo,$departamento,$getTotalPaginas)
			{
				$result 	= 0;
				$sqlFiltros = "WHERE d.estado = 1 AND pn_c.estado = 1 AND dc.estado = 1   ";

				if (!empty($cargo)) {
						$sqlFiltros .= " AND  pn_c.id = :cargo   ";
				}
				if (!empty($departamento)) {
						$sqlFiltros .= " AND d.id = :departamento   ";			
				}

				try
				{
					if(	empty($cargo) && empty($departamento) ) {
				
						$consulta = $this->classConexion->getConexion()->
									prepare("	SELECT DISTINCT
													COUNT(CONCAT(pn_c.nombre,' - ',d.nombre)) as num_filas
													FROM  cfg_departamento_cargo as dc 
														INNER JOIN cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo 
														INNER JOIN cfg_departamento as d ON d.id = dc.id_departamento
													WHERE  d.estado = 1 AND pn_c.estado = 1 AND dc.estado=1
												ORDER BY d.nombre DESC
											");
					} else {
						$consulta = $this->classConexion->getConexion()->
									prepare("	 	
												SELECT DISTINCT 
													COUNT(CONCAT(pn_c.nombre,' - ',d.nombre)) as num_filas
													FROM  cfg_departamento_cargo as dc 
														INNER JOIN cfg_pn_cargo as pn_c ON pn_c.id = dc.id_cargo 
														INNER JOIN cfg_departamento as d ON d.id = dc.id_departamento
													   ".$sqlFiltros."    												
												ORDER BY d.nombre DESC
											");

						if (!empty($cargo)) {
					   		$consulta->bindValue(':cargo', $cargo);	
						}
						if (!empty($departamento)) {
					   		$consulta->bindValue(':departamento', $departamento);	
						}

					}

					// Gestionando parametros para LIMIT en el SQL
					$consulta->execute();
					$objeto	= $consulta->fetchAll(PDO::FETCH_OBJ);	
					foreach($objeto as $r)
					{
						$result = $r->num_filas;
					}
					$consulta = $this->classConexion->getCerrarSesion();
					return 	$result;
				}
				catch(Exception $e)
				{
					return  "¡¡Error!! " .$e->getMessage(). " ! ";
				}
			}

	//-------------------

		public function ListarBusqdAvanzdPersonasASIG($id_usuario_sesion, $cedula, $empezardesde, $tamagnopaginas)
			{ 
				$result 	= array();
				$sqlFiltros = " WHERE p.estado = 1 AND p.id!=0 AND p.id<>:id_usuario_sesion  ";

				if (!empty($cedula)) {
					$sqlFiltros .= " AND p.cedula LIKE :cedula   ";
				}
				try
				{
					if(	empty($cedula) ) {
				
						$consulta = $this->classConexion->getConexion()->
									prepare("	SELECT 
													p.id as id_persona,
													p.cedula as cedula,
													CONCAT(p.nombre,' ', p.apellido) as nombreApellido,
													p.correo_electronico  
													FROM cfg_persona as p 
													WHERE p.estado = 1  AND p.id!=0 AND p.id<>:id_usuario_sesion  
												ORDER BY p.cedula DESC 
												LIMIT :empezardesde , :tamagnopaginas  
											");

					} else {
						$consulta = $this->classConexion->getConexion()->
									prepare("	 	
												SELECT 
													p.id as id_persona,
													p.cedula as cedula,
													CONCAT(p.nombre,' ', p.apellido) as nombreApellido,
													p.correo_electronico  
													FROM cfg_persona as p 
													   ".$sqlFiltros."  
												ORDER BY p.cedula DESC  
												LIMIT :empezardesde , :tamagnopaginas  

											");

						if (!empty($cedula)) {
					   		$consulta->bindValue(':cedula', '%'.$cedula.'%');	
						}
					}

				   	$consulta->bindParam(':id_usuario_sesion', $id_usuario_sesion);			
					// Gestionando parametros para LIMIT en el SQL
				   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
				   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
					$consulta->execute();
					foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
					{
						$result[] = array(
											'id_persona' => $r->id_persona,
											'cedula' => $r->cedula,
											'nombreApellido' => utf8_encode($r->nombreApellido),
											'correo_electronico' => utf8_encode($r->correo_electronico),
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
		public function getTotalPaginasBusqdAvanzdPersonasASIG($id_usuario_sesion, $cedula,$getTotalPaginas)
			{
				$result 	= array();
				$sqlFiltros = " WHERE p.estado = 1 AND p.id!=0 AND p.id<>:id_usuario_sesion  ";

				if (!empty($cedula)) {
					$sqlFiltros .= " AND p.cedula LIKE :cedula   ";
				}

				try
				{
					if(	empty($cedula)) {
				
						$consulta = $this->classConexion->getConexion()->
									prepare("	SELECT 
													COUNT(p.id) as num_filas 
												FROM cfg_persona as p 
												WHERE  p.estado = 1 AND p.id!=0 AND p.id<>:id_usuario_sesion  
											");

					} else {
						$consulta = $this->classConexion->getConexion()->
									prepare("	 	
												SELECT 
													COUNT(p.id) as num_filas 
												FROM cfg_persona as p 
													   ".$sqlFiltros."    													
											");

						if (!empty($cedula)) {
					   		$consulta->bindValue(':cedula', '%'.$cedula.'%');	
						}

					}
					   	$consulta->bindParam(':id_usuario_sesion', $id_usuario_sesion);			

				   		$consulta->execute();
						$r = $consulta->fetch(PDO::FETCH_OBJ);

						return 	$r->num_filas;
				}
				catch(Exception $e)
				{
					return  "¡¡Error!! " .$e->getMessage(). " ! ";
				}
			}
////////////////////////////////////////////////////////////////////////////////////
   }	
		
?>
