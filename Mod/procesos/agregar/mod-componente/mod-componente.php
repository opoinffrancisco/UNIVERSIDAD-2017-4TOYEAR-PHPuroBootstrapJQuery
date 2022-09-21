<?php

	class modEqComponente extends eq_componente{

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function guardar(eq_componente $data)
		{
			try 
			{
			    //$this->classConexion->getConexion()->beginTransaction();
				$consulta = $this->classConexion->getConexion()->
							prepare(
									"INSERT INTO eq_componente (
															`serial`, 
															`serial_bn`,
															`id_c_fisc_comp`
														) 
						        				VALUES (
							        				    	:seriall,
							        				    	:serial_bn,
							        				    	:id_c_fisc_comp
						        				    	)"
							);
		     	$consulta->bindValue(':seriall', $data->__GET('serial'));
		     	$consulta->bindValue(':serial_bn', $data->__GET('serial_bn'));
		     	$consulta->bindValue(':id_c_fisc_comp', $data->__GET('id_c_fisc_comp'));

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
											eqp.id_c_fisc_comp as id_caracteristicas,
											ccft.nombre as tipo,
											ccfmm.nombre as marca,
											ccfm.nombre as modelo,
											CONCAT( ccfc.capacidad,' ', ccfumc.abreviatura ) AS capacidad 
										FROM    eq_componente as eqp 
										INNER JOIN  cfg_caracteristicas_fisc_comp as ccfc ON ccfc.id = eqp.id_c_fisc_comp  
										LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfc.id_tipo_fisc
										LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfc.id_modelo_fisc
										LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
										LEFT JOIN cfg_c_fisc_unidad_medida AS ccfumc ON ccfumc.id = ccfc.id_umcapacidad_fisc							
										WHERE eqp.id = :id " 
					   				);
				          
			   	$consulta->bindValue(':id', $id);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$resultados[] = array(
									'id' => $r->id,
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
		public function consultarCaractPerif($id)
		{
			$resultados = array();			
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
									" SELECT 
										ccfc.id AS id_caracteristicas, 
										ccft.nombre AS tipo, 
										ccfmm.nombre AS marca, 
										ccfm.nombre AS modelo, 
										CONCAT( ccfc.capacidad,  ' ', ccfumc.abreviatura ) AS capacidad
									FROM cfg_caracteristicas_fisc_comp AS ccfc
									LEFT JOIN cfg_c_fisc_tipo AS ccft ON ccft.id = ccfc.id_tipo_fisc
									LEFT JOIN cfg_c_fisc_modelo AS ccfm ON ccfm.id = ccfc.id_modelo_fisc
									LEFT JOIN cfg_c_fisc_mod_marca AS ccfmm ON ccfmm.id = ccfm.id_marca
									LEFT JOIN cfg_c_fisc_unidad_medida AS ccfumc ON ccfumc.id = ccfc.id_umcapacidad_fisc		
									WHERE ccfc.id = :id " 
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
												CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
												ccft.nombre as tipo 
											FROM    eq_componente as eqp
											INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = eqp.id_c_fisc_comp  
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
													CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
													ccft.nombre as tipo
												FROM    eq_componente as eqp
												INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = eqp.id_c_fisc_comp  
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
											FROM    eq_componente as eqp 
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(eqp.id) as num_filas 
												FROM    eq_componente as eqp 
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
												CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
												ccft.nombre as tipo 
											FROM    eq_componente as eqp
											INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = eqp.id_c_fisc_comp  
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
													CONCAT( ccfmm.nombre, ' ', ccfm.nombre ) as marcaymodelo,
													ccft.nombre as tipo
												FROM    eq_componente as eqp
												INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = eqp.id_c_fisc_comp  
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
											FROM    eq_componente as eqp
											INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = eqp.id_c_fisc_comp  
											LEFT JOIN 	cfg_c_fisc_tipo as ccft ON ccft.id = ccfp.id_tipo_fisc 
											LEFT JOIN 	cfg_c_fisc_modelo as ccfm ON ccfm.id = ccfp.id_modelo_fisc 
											LEFT JOIN 	cfg_c_fisc_mod_marca as ccfmm ON ccfmm.id = ccfm.id_marca 	
										");

				} else {
					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													COUNT(eqp.id) as num_filas  
												FROM    eq_componente as eqp
												INNER JOIN  cfg_caracteristicas_fisc_comp as ccfp ON ccfp.id = eqp.id_c_fisc_comp  
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

   }	
		
?>
