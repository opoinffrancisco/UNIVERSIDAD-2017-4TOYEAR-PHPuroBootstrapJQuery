<?php

	class modEquipo extends equipo{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function guardar(equipo $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO equipo (
															`serial`, 
															`serial_bn`,
															`id_c_fisc_eq`
														) 
						        				VALUES (
							        				    	:seriall,
							        				    	:serial_bn,
							        				    	:id_c_fisc_eq
						        				    	)"
							);
		     	$consulta->bindValue(':seriall', $data->__GET('serial'));
		     	$consulta->bindValue(':serial_bn', $data->__GET('serial_bn'));
		     	$consulta->bindValue(':id_c_fisc_eq', $data->__GET('id_c_fisc_eq'));

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

		public function editarSerialesEQERIFCOMPP($id_control, $campo_control, $serial, $serial_bn)
		{
			try 
			{
				$SQL="UPDATE  ".$campo_control." SET 
				`serial` = :serial, 
				`serial_bn` = :serial_bn 
				WHERE id = :id_control	";

			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
		     	$consulta->bindValue(':serial', $serial);
		     	$consulta->bindValue(':serial_bn', $serial_bn);
		     	$consulta->bindValue(':id_control', $id_control);
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
		public function anadirComponente(equipo_componente $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO equipo_componente (
															`id_equipo`, 
															`id_componente`,
															`fecha`,
															`estado`
														) 
						        				VALUES (
							        				    	:id_equipo,
							        				    	:id_componente,
							        				    	NOW(),
							        				    	:estado
						        				    	)"
							);
		     	$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     	$consulta->bindValue(':id_componente', $data->__GET('id_componente'));
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
		public function anadirPeriferico(equipo_periferico $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO equipo_periferico (
															`id_equipo`, 
															`id_periferico`,
															`fecha`,
															`estado`
														) 
						        				VALUES (
							        				    	:id_equipo,
							        				    	:id_periferico,
							        				    	NOW(),
							        				    	:estado
						        				    	)"
							);
		     	$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     	$consulta->bindValue(':id_periferico', $data->__GET('id_periferico'));
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
		public function anadirSoftware(equipo_software $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO equipo_software (
															`id_equipo`, 
															`id_software`,
															`fecha`,
															`estado`
														) 
						        				VALUES (
							        				    	:id_equipo,
							        				    	:id_software,
							        				    	NOW(),
							        				    	:estado
						        				    	)"
							);
		     	$consulta->bindValue(':id_equipo', $data->__GET('id_equipo'));
		     	$consulta->bindValue(':id_software', $data->__GET('id_software'));
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
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" 	SELECT 
											eqp.id as id,
											eqp.serial as serial, 
											eqp.serial_bn as serial_bn,
											eqp.id_c_fisc_eq as id_caracteristicas,
											eqp.estado as estado_equipo,
											ccft.nombre as tipo,
											ccfmm.nombre as marca,
											ccfm.nombre as modelo,
											pe.observacion
										FROM equipo as eqp 
										INNER JOIN  cfg_caracteristicas_fisc_eq as ccfe ON ccfe.id = eqp.id_c_fisc_eq  
										LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfe.id_tipo_fisc
										LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfe.id_modelo_fisc
										LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
										LEFT JOIN persona_equipo AS pe ON pe.id_equipo = eqp.id 
										WHERE eqp.id = :id " 
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$resultados[] = array(
									'id_equipo' => $r->id,
									'serial' => $r->serial,
									'serial_bn' => $r->serial_bn,
									'id_caracteristicas' => $r->id_caracteristicas,
									'estado_equipo' => $r->estado_equipo,
									'tipo' => $r->tipo,
									'marca' => $r->marca,
									'modelo' => $r->modelo,
									'observacion' => $r->observacion,
								);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
		public function consultarCaractEqu($id)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" SELECT 
										ccfe.id AS id_caracteristicas, 
										ccft.nombre AS tipo, 
										ccfmm.nombre AS marca, 
										ccfm.nombre AS modelo
									FROM cfg_caracteristicas_fisc_eq AS ccfe
									LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfe.id_tipo_fisc
									LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfe.id_modelo_fisc
									LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
									WHERE ccfe.id = :id " 
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$resultados[] = array(
									'id' => $r->id_caracteristicas,
									'tipo' => $r->tipo,
									'marca' => $r->marca,
									'modelo' => $r->modelo,
								);
					return $resultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
		public function consultarCaracteristSoft($id)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" SELECT 
											cs.id as id, 
											cs.nombre as nombre,	
											cs.version as version,
											clt.nombre as tipo,
											clf.nombre as distribucion,
											cs.estado as estado 
											FROM  eq_software as cs
											LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id 			
											LEFT JOIN cfg_c_logc_distribucion as clf ON cs.id_c_logc_distribucion = clf.id 		
									WHERE cs.id = :id " 
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$resultados[] = array(
									'id' => $r->id,
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
		
		public function Listar($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				if(empty($filtro)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												eqp.id as id,
												eqp.serial as serial, 
												eqp.serial_bn as serial_bn,
												eqp.estado as estado,
												CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
												ccft.nombre as tipo 
											FROM    equipo as eqp
											INNER JOIN  cfg_caracteristicas_fisc_eq as ccfp ON ccfp.id = eqp.id_c_fisc_eq  
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	
											ORDER BY eqp.id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													eqp.id as id,
													eqp.serial as serial, 
													eqp.serial_bn as serial_bn,
													eqp.estado as estado,
													CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
													ccft.nombre as tipo
												FROM    equipo as eqp
												INNER JOIN  cfg_caracteristicas_fisc_eq as ccfp ON ccfp.id = eqp.id_c_fisc_eq  
												LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
												LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
												LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	
												WHERE eqp.serial LIKE :serialperif  OR eqp.serial_bn LIKE :serialperif2
												ORDER BY eqp.id DESC
												LIMIT :empezardesde , :tamagnopaginas 
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':serialperif', '%'.$filtro.'%');	
			   		$consulta->bindValue(':serialperif2', '%'.$filtro.'%');	
				}

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id' => $r->id,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'estado' => $r->estado,
										'marcaymodelo' => $r->marcaymodelo,
										'tipo' => $r->tipo,
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

				if(empty($filtro)) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												COUNT(eqp.id) as num_filas  
											FROM    equipo as eqp 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(eqp.id) as num_filas 
												FROM    equipo as eqp 
												WHERE eqp.serial LIKE :serialperif  OR eqp.serial_bn LIKE :serialperif2
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

////////////////////////////////////////////////////////////////////

	public function ListarBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD, $empezardesde, $tamagnopaginas)
		{ 
			$result 	= array();
			$sqlFiltros = " WHERE ";

			$filtro1 = false;
			$filtro2 = false;
			$filtro3 = false;
			$filtro4 = false;
			if (!empty($serial)) {
				$sqlFiltros .= "  eqp.serial LIKE :serialperif   ";
				//
				$filtro1=true;
			}
			if (!empty($serialBienN)) {
				if ($filtro1==true) {
					$sqlFiltros .= " AND  eqp.serial_bn LIKE :serial_bnperif   ";
				}else{
					$sqlFiltros .= "  eqp.serial_bn LIKE :serial_bnperif   ";
				}
				//
				$filtro2=true;
			}
			if (!empty($tipoListD)) {
				if ($filtro1==true || $filtro2==true) {
					$sqlFiltros .= " AND ccfp.id_tipo_fisc = :tipoperif   ";			
				}else{
					$sqlFiltros .= "  ccfp.id_tipo_fisc = :tipoperif   ";			
				}				
				//
				$filtro3=true;
			}
			if (!empty($modeloListD)) {
				if ($filtro1==true || $filtro2==true || $filtro3==true) {
					$sqlFiltros .= " AND ccfp.id_modelo_fisc = :modeloperif   ";
				}else{
					$sqlFiltros .= "  ccfp.id_modelo_fisc = :modeloperif   ";
				}
				//
				$filtro4=true;
			}


			try
			{
				if(	empty($serial) && empty($serialBienN) && 
					empty($tipoListD) && empty($modeloListD)
				) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												eqp.id as id,
												eqp.serial as serial, 
												eqp.serial_bn as serial_bn,
												eqp.estado as estado,												
												CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
												ccft.nombre as tipo 
											FROM    equipo as eqp
											INNER JOIN  cfg_caracteristicas_fisc_eq as ccfp ON ccfp.id = eqp.id_c_fisc_eq  
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	 
											ORDER BY eqp.id DESC
											LIMIT :empezardesde , :tamagnopaginas 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													eqp.id as id,
													eqp.serial as serial, 
													eqp.serial_bn as serial_bn,
													eqp.estado as estado,
													CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
													ccft.nombre as tipo
												FROM    equipo as eqp
												INNER JOIN  cfg_caracteristicas_fisc_eq as ccfp ON ccfp.id = eqp.id_c_fisc_eq  
												LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
												LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
												LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	
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
					$result[] = array(
										'id' => $r->id,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'estado' => $r->estado,
										'marcaymodelo' => $r->marcaymodelo,
										'tipo' => $r->tipo,
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

	public function getTotalPaginasBusqdAvanzd($serial,$serialBienN,$tipoListD,$modeloListD,$getTotalPaginas)
		{
			$sqlFiltros = " WHERE ";

			$filtro1 = false;
			$filtro2 = false;
			$filtro3 = false;
			$filtro4 = false;

			if (!empty($serial)) {
				$sqlFiltros .= "  eqp.serial LIKE :serialperif   ";
				//
				$filtro1=true;
			}
			if (!empty($serialBienN)) {
				if ($filtro1==true) {
					$sqlFiltros .= " AND  eqp.serial_bn LIKE :serial_bnperif   ";
				}else{
					$sqlFiltros .= "  eqp.serial_bn LIKE :serial_bnperif   ";
				}
				//
				$filtro2=true;
			}
			if (!empty($tipoListD)) {
				if ($filtro2==true || $filtro3==true) {
					$sqlFiltros .= " AND ccfp.id_tipo_fisc = :tipoperif   ";			
				}else{
					$sqlFiltros .= "  ccfp.id_tipo_fisc = :tipoperif   ";			
				}				
				//
				$filtro3=true;
			}
			if (!empty($modeloListD)) {
				if ($filtro1==true || $filtro2==true || $filtro3==true) {
					$sqlFiltros .= " AND ccfp.id_modelo_fisc = :modeloperif   ";
				}else{
					$sqlFiltros .= "  ccfp.id_modelo_fisc = :modeloperif   ";
				}
				//
				$filtro4=true;
			}



			try
			{
				if(	empty($serial) && empty($serialBienN) && 
					empty($tipoListD) && empty($modeloListD)
				) {
			
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
												COUNT(eqp.id) as num_filas  
											FROM    equipo as eqp
											INNER JOIN  cfg_caracteristicas_fisc_eq as ccfp ON ccfp.id = eqp.id_c_fisc_eq  
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(eqp.id) as num_filas  
												FROM    equipo as eqp
												INNER JOIN  cfg_caracteristicas_fisc_eq as ccfp ON ccfp.id = eqp.id_c_fisc_eq  
												LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
												LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
												LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	
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
////////////////////////////////////////////////////////////////////////////////////
	
		public function cargarListaPerifericosEquipo($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("		SELECT 
												id_equipo,
												id_periferico,
												perif.serial as serial, 
												perif.serial_bn as serial_bn,
												ccft.nombre as tipo,
												CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo 
											FROM equipo_periferico AS eqPerif
											INNER JOIN equipo AS e ON e.id = eqPerif.id_equipo
											INNER JOIN eq_periferico AS perif ON perif.id = eqPerif.id_periferico
											INNER JOIN cfg_caracteristicas_fisc_perif AS ccfp ON ccfp.id = perif.id_c_fisc_perif
											LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfp.id_tipo_fisc
											LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfp.id_modelo_fisc
											LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
											WHERE eqPerif.estado =1 AND eqPerif.id_equipo =:id_equipo  
              								ORDER BY ccft.nombre DESC 
											LIMIT :empezardesde , :tamagnopaginas 											
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_equipo', $filtro);	

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_equipo' => $r->id_equipo,
										'id_periferico' => $r->id_periferico,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'tipo' => $r->tipo,
										'marcaymodelo' => $r->marcaymodelo,
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

		public function getTotalPaginasPerifericosEquipo($filtro,$getTotalPaginas)
		{
			try
			{

	
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(id_equipo) as num_filas 
												FROM    equipo_periferico  
												WHERE estado=1 AND id_equipo = :id_equipo  
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_equipo', $filtro);	

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

		public function cargarListaComponentesEquipo($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("		SELECT 
												id_equipo,
												id_componente,
												comp.serial as serial, 
												comp.serial_bn as serial_bn,
												ccft.nombre as tipo,
												CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo 
											FROM    equipo_componente  as eqComp
											INNER JOIN equipo as e ON e.id = eqComp.id_equipo 
											INNER JOIN eq_componente as comp ON comp.id = eqComp.id_componente 
											INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = comp.id_c_fisc_comp  
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 
											WHERE eqComp.estado=1 AND eqComp.id_equipo =:id_equipo  
              								ORDER BY ccft.nombre DESC 
											LIMIT :empezardesde , :tamagnopaginas 											
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_equipo', $filtro);	

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_equipo' => $r->id_equipo,
										'id_componente' => $r->id_componente,
										'serial' => $r->serial,
										'serial_bn' => $r->serial_bn,
										'tipo' => $r->tipo,
										'marcaymodelo' => $r->marcaymodelo,
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

		public function getTotalPaginasComponentesEquipo($filtro,$getTotalPaginas)
		{
			try
			{

	
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(id_equipo) as num_filas 
												FROM    equipo_componente  
												WHERE estado=1 AND  id_equipo = :id_equipo  
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta
			   		$consulta->bindValue(':id_equipo', $filtro);	

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
	
		
		public function cargarListaSoftwareEquipo($filtro, $empezardesde, $tamagnopaginas)
		{ 
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()->
							prepare("		

											SELECT 
												id_equipo,
												id_software,
												CONCAT(cs.nombre,  '   ',  cs.version) as NombreVersion,			
												clt.nombre as tipo,
												clf.nombre as distribucion
											FROM    equipo_software  as eqSoft
											INNER JOIN equipo as e ON e.id = eqSoft.id_equipo 
											INNER JOIN eq_software as cs ON cs.id = eqSoft.id_software
											LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id 				
											LEFT JOIN cfg_c_logc_distribucion as clf ON cs.id_c_logc_distribucion = clf.id
											WHERE eqSoft.estado=1 AND eqSoft.id_equipo =:id_equipo  
              								ORDER BY cs.nombre DESC 
											LIMIT :empezardesde , :tamagnopaginas 	
																				
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_equipo', $filtro);	

				// Gestionando parametros para LIMIT en el SQL
			   	$consulta->bindParam(':empezardesde', intval($empezardesde/*, 10*/), \PDO::PARAM_INT);			
			   	$consulta->bindParam(':tamagnopaginas', intval($tamagnopaginas/*, 10*/), \PDO::PARAM_INT);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'id_equipo' => $r->id_equipo,
										'id_software' => $r->id_software,
										'NombreVersion' => $r->NombreVersion,
										'tipo' => $r->tipo,
										'distribucion' => $r->distribucion,
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

		public function getTotalPaginasSoftwareEquipo($filtro,$getTotalPaginas)
		{
			try
			{	
				$consulta = $this->classConexion->getConexion()->
							prepare("	 	SELECT 
												COUNT(id_equipo) as num_filas 
											FROM    equipo_software  
											WHERE estado=1 AND id_equipo = :id_equipo  
									");
				//se inserta el parametro de busqueda y se ejecuta lac onsulta
		   		$consulta->bindValue(':id_equipo', $filtro);	

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
