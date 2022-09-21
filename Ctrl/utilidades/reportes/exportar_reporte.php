<?php
/**
* 
*/
class ModReportes 
{

	private $classConexion;
	
	function __construct()
	{
		# code...
	}
	

		/*
			Nota: Funciones de consultas a BD con 3 coll
		*/
		public function ListarRptSoftware($filtro1, $filtro2)
		{
			$this->classConexion = new classConexion();
			$result = array();
			echo $filtro1;
			try
			{
				if(	empty($filtro1) && empty($filtro2) ) {
			
					$SQL = "	SELECT 
												cs.id as id, 
												CONCAT(cs.nombre,'  ',cs.version) as SOFTWARE,							
												clt.nombre as TIPO,
												cld.nombre as distribucion,
												cs.estado as estado 
											FROM  eq_software as cs
												LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id
												LEFT JOIN cfg_c_logc_distribucion as cld ON cs.id_c_logc_distribucion = cld.id  
										";

				} else {
							$SQL = "SELECT 
											cs.id as id, 
											CONCAT(cs.nombre,'  ',cs.version) as SOFTWARE,							
											clt.nombre as TIPO,
											cld.nombre as distribucion,
											cs.estado as estado 
										FROM  eq_software as cs
											LEFT JOIN cfg_c_logc_tipo as clt ON cs.id_c_logc_tipo = clt.id
											LEFT JOIN cfg_c_logc_distribucion as cld ON cs.id_c_logc_distribucion = cld.id  
										WHERE clt.id = ".$filtro2." AND  cs.nombre LIKE '%".$filtro1."%'";

				}								
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$estado="HABILITADO";
					if ($r->estado==0) {
						$estado="DESHABILITADO";
					}
					$result[] = array(
										'SOFTWARE' => $r->SOFTWARE,
										'TIPO' => $r->TIPO,
										'estado' => $estado,
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

		/*
			Nota: Funciones de consultas a BD con 3 coll
		*/
		public function ListarRptCComponentes($filtro1, $filtro2)
		{
			$this->classConexion = new classConexion();
			$result = array();
			echo $filtro1;
			try
			{
				if(	empty($filtro1) && empty($filtro2) ) {
			
					$SQL = "				SELECT 
												CONCAT(cfmm.nombre,' ',cfm.nombre) as MARCAyMODELO, 
												cft.nombre as TIPO, 												
												ccomp.estado as estado 
											FROM  cfg_caracteristicas_fisc_comp as ccomp
												LEFT JOIN cfg_c_fisc_tipo as cft ON ccomp.id_tipo_fisc = cft.id 										
												LEFT JOIN cfg_c_fisc_modelo as cfm ON ccomp.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
											ORDER BY ccomp.id DESC 
										";

				} else {
							$SQL = "SELECT 
												CONCAT(cfmm.nombre,' ',cfm.nombre) as MARCAyMODELO, 
												cft.nombre as TIPO, 												
												ccomp.estado as estado 
											FROM  cfg_caracteristicas_fisc_comp as ccomp
												LEFT JOIN cfg_c_fisc_tipo as cft ON ccomp.id_tipo_fisc = cft.id 										
												LEFT JOIN cfg_c_fisc_modelo as cfm ON ccomp.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
										WHERE cft.id = ".$filtro2." AND  cfm.nombre LIKE '%".$filtro1."%'
										ORDER BY ccomp.id DESC ";											
				}								
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$estado="HABILITADO";
					if ($r->estado==0) {
						$estado="DESHABILITADO";
					}
					$result[] = array(
										'MARCA Y MODELO' => $r->MARCAyMODELO,
										'TIPO' => $r->TIPO,
										'estado' => $estado,
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
		/*
			Nota: Funciones de consultas a BD con 3 coll
		*/
		public function ListarRptCPerifericos($filtro1, $filtro2)
		{
			$this->classConexion = new classConexion();
			$result = array();
			echo $filtro1;
			try
			{
				if(	empty($filtro1) && empty($filtro2) ) {
			
					$SQL = "				SELECT 
												cp.id as id, 
												CONCAT(cfmm.nombre,' ',cfm.nombre) as MARCAyMODELO, 
												cft.nombre as TIPO, 												
												cp.estado as estado 
											FROM  cfg_caracteristicas_fisc_perif as cp
												LEFT JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
												LEFT JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
											ORDER BY cp.id DESC
										";

				} else {
							$SQL = "		SELECT 
												cp.id as id, 
												CONCAT(cfmm.nombre,' ',cfm.nombre) as MARCAyMODELO, 
												cft.nombre as TIPO, 												
												cp.estado as estado 
											FROM  cfg_caracteristicas_fisc_perif as cp
												LEFT JOIN cfg_c_fisc_tipo as cft ON cp.id_tipo_fisc = cft.id 										
												LEFT JOIN cfg_c_fisc_modelo as cfm ON cp.id_modelo_fisc = cfm.id 
												LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
											WHERE cft.id = ".$filtro2." AND  cfm.nombre LIKE '%".$filtro1."%'
											ORDER BY cp.id DESC";											
				}								
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$estado="HABILITADO";
					if ($r->estado==0) {
						$estado="DESHABILITADO";
					}
					$result[] = array(
										'MARCA Y MODELO' => $r->MARCAyMODELO,
										'TIPO' => $r->TIPO,
										'estado' => $estado,
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
		/*
			Nota: Funciones de consultas a BD con 3 coll
		*/
		public function ListarRptCEquipos($filtro1, $filtro2)
		{
			$this->classConexion = new classConexion();
			$result = array();
			echo $filtro1;
			try
			{
				if(	empty($filtro1) && empty($filtro2) ) {
			
					$SQL = "SELECT 
								ce.id as id, 
								CONCAT(cfmm.nombre,' ',cfm.nombre) as MARCAyMODELO, 												
								cft.nombre as TIPO, 
								ce.estado as estado 
							FROM  cfg_caracteristicas_fisc_eq as ce
								LEFT JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id
								LEFT JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
								LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
							ORDER BY ce.id DESC";
				} else {
					$SQL = "SELECT 
								ce.id as id, 
								CONCAT(cfmm.nombre,' ',cfm.nombre) as MARCAyMODELO, 												
								cft.nombre as TIPO, 
								ce.estado as estado 
							FROM  cfg_caracteristicas_fisc_eq as ce
								LEFT JOIN cfg_c_fisc_tipo as cft ON ce.id_tipo_fisc = cft.id
								LEFT JOIN cfg_c_fisc_modelo as cfm ON ce.id_modelo_fisc = cfm.id 
								LEFT JOIN cfg_c_fisc_mod_marca as cfmm ON cfm.id_marca = cfmm.id  
							WHERE cft.id = ".$filtro2." AND  cfm.nombre LIKE '%".$filtro1."%' 
							ORDER BY ce.id DESC";
				}								
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$estado="HABILITADO";
					if ($r->estado==0) {
						$estado="DESHABILITADO";
					}
					$result[] = array(
										'MARCA Y MODELO' => $r->MARCAyMODELO,
										'TIPO' => $r->TIPO,
										'estado' => $estado,
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

		/*
			Nota: Funciones de consultas a BD con 3 coll
		*/
		public function consulta5CollMpersonas($coll1, $coll2, $coll3, $coll4, $dato_1)
		{

			$this->classConexion = new classConexion();
			$result = array();
			try
			{		

				if (empty($dato_1)) {
					
					$SQL = "	 				SELECT 
													p.cedula as CEDULA,
													p.nombre as nombre,
													p.apellido as apellido,    
												    p.estado as ESTADO,
												    u.usuario as USUARIO,
											    	pf.nombre as PERFIL,										  		    
												    u.estado as estadoUsuario
													FROM    cfg_persona as p 
														INNER JOIN cfg_pn_usuario as u ON p.id_usuario = u.id 
														INNER JOIN cfg_pn_perfil as pf ON pf.id = u.id_perfil
													WHERE u.id<>0
												ORDER BY cedula ASC 
										";
					$consulta = $this->classConexion->getConexion()->prepare($SQL);

				} else {
					$SQL = "	 				SELECT 
													p.cedula as CEDULA,
													p.nombre as nombre,
													p.apellido as apellido,    
												    p.estado as ESTADO,
												    u.usuario as USUARIO,
											    	pf.nombre as PERFIL,										  		    
												    u.estado as estadoUsuario
												FROM    cfg_persona as p 
														INNER JOIN cfg_pn_usuario as u ON p.id_usuario = u.id
														INNER JOIN cfg_pn_perfil as pf ON pf.id = u.id_perfil
												WHERE p.cedula LIKE :cedula AND u.id<>0
												ORDER BY cedula ASC 
										";
					$consulta = $this->classConexion->getConexion()->prepare($SQL);
			     	$consulta->bindValue(':cedula', '%'.$dato_1.'%');				
				}						
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$estado="HABILITADO";
					if ($r->ESTADO==0) {
						$estado="DESHABILITADO";
					}

					$result[] = array(
										''.$coll1.'' => $r->$coll1,
										''.$coll2.'' => utf8_encode($r->nombre.' '.$r->apellido),
										''.$coll3.'' => $r->$coll3,
										''.$coll4.'' => $r->$coll4,
										'estado' => $estado,
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

		/*
			Nota: Funciones de consultas a BD con 3 coll
		*/
		public function consultaCargos($campo_control, $dato_1)
		{

			$this->classConexion = new classConexion();
			$result = array();
			try
			{		

				if (empty($dato_1)) {
					
					$SQL = "	 				SELECT 
													id as id,
													nombre as nombre,
													responsable_departamento,
												    estado as estado
												FROM    cfg_pn_cargo 
												ORDER BY id DESC 
										";
					$consulta = $this->classConexion->getConexion()->prepare($SQL);

				} else {
					$SQL = "	 				SELECT 
													id as id,
													nombre as nombre,
													responsable_departamento,
												    estado as estado
												FROM    cfg_pn_cargo 
												WHERE nombre LIKE :nombre
												ORDER BY id DESC
										";
					$consulta = $this->classConexion->getConexion()->prepare($SQL);
			     	$consulta->bindValue(':nombre', '%'.$dato_1.'%');				
				}						
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{

					$estado="HABILITADO";
					if ($r->ESTADO==0) {
						$estado="DESHABILITADO";
					}
					$responsable_departamento="SI";
					if ($r->responsable_departamento==0) {
						$responsable_departamento="NO";
					}

					$result[] = array(
										'NOMBRE' => eliminar_tildes($r->nombre),
										''.$campo_control.'' => $responsable_departamento,
										'estado' => $estado,
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

	//////////////////////////////////////////////////////////////	

	/*
		Nota: Funciones de consultas a BD
		1 campo
		1 dato filtrado
	*/
	public function consulta2Coll($tabla,$dato_1,$campo_1)
	{
		$this->classConexion = new classConexion();
		$result = array();
		try
		{	

			if (empty($dato_1)) {
				$SQL = "	 	SELECT 
													*  
												FROM  ".$tabla."
												WHERE id<>0 
												ORDER BY id DESC 
										";
			} else {
				$SQL = "	 	SELECT 
													*  
												FROM  ".$tabla." 
												WHERE ".$campo_1." LIKE '%".$dato_1."%'  AND id<>0 
												ORDER BY id DESC 
										";
			}
			$consulta = $this->classConexion->getConexion()->prepare($SQL);
			$consulta->execute();

			foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$estado="HABILITADO";
				if ($r->estado==0) {
					$estado="DESHABILITADO";
				}
				$result[] = array(
									'nombre' => eliminar_tildes($r->nombre),
									'estado' => $estado,
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
	/*
		Nota: Funciones de consultas a BD con 3 coll
	*/
	public function consulta3Coll($tabla,$coll1,$coll2,$dato_1)
	{
		$this->classConexion = new classConexion();
		$result = array();
		try
		{		
			if (empty($dato_1)) {
				$SQL = "	 	SELECT 
													*  
												FROM  ".$tabla." 
												ORDER BY id DESC 
										";
				$consulta = $this->classConexion->getConexion()->prepare($SQL);

			} else {
				$SQL = "	 	SELECT 
													*  
												FROM  ".$tabla." 
												WHERE ".$coll1." LIKE :".$coll1."
												ORDER BY id DESC 
										";
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
			     $consulta->bindValue(':'.$coll1.'', '%'.$dato_1.'%');				
			}
			
			$consulta->execute();

			foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$estado="HABILITADO";
				if ($r->estado==0) {
					$estado="DESHABILITADO";
				}
				$result[] = array(
									''.$coll1.'' => eliminar_tildes($r->$coll1),
									''.$coll2.'' => eliminar_tildes($r->$coll2),
									'estado' => $estado,
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
	/*
		Nota: Funciones de consultas a BD con 3 coll
	*/
	public function consulta3Coll1Rel($tabla,$tablarel1,$rel1,$coll1,$coll2,$dato_1)
	{
		$this->classConexion = new classConexion();
		$result = array();
		try
		{	
			if (empty($dato_1)) {

				$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													t1.".$coll1.", 
													t2.nombre as ".$coll2.",  
													t1.estado  
												FROM  ".$tabla." as t1
												INNER JOIN ".$tablarel1." as t2 ON t2.id = t1.".$rel1." 
												ORDER BY t1.id DESC 
										");
			} else {
				$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
													t1.".$coll1.", 
													t2.nombre as ".$coll2.",  
													t1.estado  
												FROM  ".$tabla." as t1
												INNER JOIN ".$tablarel1." as t2 ON t2.id = t1.".$rel1." 
												WHERE t1.".$coll1." LIKE :".$coll1."
												ORDER BY t1.id DESC 
										");
			     $consulta->bindValue(':'.$coll1.'', '%'.$dato_1.'%');				
			}
			

			$consulta->execute();

			foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
			{
				$estado="HABILITADO";
				if ($r->estado==0) {
					$estado="DESHABILITADO";
				}
				$result[] = array(
									''.$coll1.'' => eliminar_tildes($r->$coll1),
									''.$coll2.'' => eliminar_tildes($r->$coll2),
									'estado' => $estado,
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


}