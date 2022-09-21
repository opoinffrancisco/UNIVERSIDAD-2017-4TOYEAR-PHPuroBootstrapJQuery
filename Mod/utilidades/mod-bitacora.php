<?php

	class modBitacora {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function guardarOperacion($operacion, $ip_cliente, $id_usuario)
		{
			try 
			{
//				if($id_usuario!=0){
				    //$this->classConexion->getConexion()->beginTransaction();
					$consulta = $this->classConexion->getConexion()->
								prepare(
										"INSERT INTO bitacora (
																operacion, 
																fecha,
																ip,
																id_usuario 
															) 
							        				VALUES (
								        				    	:operacion,
								        				    	sysdate(3),
								        				    	:ip_cliente,
							        				    		:id_usuario	
							        				    	)"
								);
			     	$consulta->bindValue(':operacion', $operacion);
			     	$consulta->bindValue(':ip_cliente', 	$ip_cliente);
			     	$consulta->bindValue(':id_usuario', 	$id_usuario);

			     	$consulta->execute();
					$consulta = $this->classConexion->getCerrarSesion();

			     	//$this->classConexion->getConexion()->commit();
			     	// Como la Primary Key no es auto-incrementable y numerica Si llega a return devuelve con "1" 
			     	// que la ejecucion fue exitosa
//				}
				return 1;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		public function Listar($usuario, $operacion, $perfil, $buscardordesde, $buscardorhasta, $empezardesde, $tamagnopaginas)
		{ 

			$result 	= array();
			$sqlFiltros = " WHERE ";

			$filtro1 = false;
			$filtro2 = false;
			$filtro3 = false;

			if (!empty($usuario)) {
					$sqlFiltros .= "  u.usuario LIKE :usuario    ";
				$filtro1 = true;
			}

			if (!empty($perfil)) {
				if ($filtro1==false) {
					$sqlFiltros .= "  p.id = :perfil ";
				}else{
					$sqlFiltros .= "  AND  p.id = :perfil  ";
				}
				$filtro2 = true;
			}

			if (!empty($operacion)) {
				if ($filtro1==false && $filtro2==false) {
					$sqlFiltros .= "  b.operacion LIKE :operacion    ";
				}else{
					$sqlFiltros .= "  AND   b.operacion LIKE :operacion    ";
				}
				$filtro3 = true;
			}

			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				if ($filtro1==false && $filtro2==false && $filtro3==false) {
					$sqlFiltros .= "  b.fecha BETWEEN :buscardordesde AND :buscardorhasta "; 
				}else{
					$sqlFiltros .= " AND ( b.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
				}
			}


			try
			{

				if(	empty($usuario) && empty($operacion) && empty($perfil) &&
					 empty($buscardordesde) && empty($buscardorhasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
										prepare("SELECT
													 u.usuario ,p.nombre, b.operacion,b.fecha 
												from bitacora as b
													INNER JOIN cfg_pn_usuario as u ON b.id_usuario = u.id OR b.id_usuario = 0 
													LEFT JOIN cfg_pn_perfil as p ON p.id = u.id_perfil 
											    ORDER BY b.fecha DESC
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		SELECT 
													u.usuario ,p.nombre, b.operacion,b.fecha 
												from bitacora as b
													INNER JOIN cfg_pn_usuario as u ON b.id_usuario = u.id
													INNER JOIN cfg_pn_perfil as p ON p.id = u.id_perfil 
											    	".$sqlFiltros."  													
											    ORDER BY b.fecha DESC
												LIMIT :empezardesde , :tamagnopaginas 	
										");
					//se inserta el parametro de busqueda y se ejecuta lac onsulta

					if (!empty($usuario)) {
				   		$consulta->bindValue(':usuario', '%'.$usuario.'%');	
					}
					if (!empty($perfil)) {
				   		$consulta->bindValue(':perfil', $perfil);	
					}
					if (!empty($operacion)) {
				   		$consulta->bindValue(':operacion', '%'.$operacion.'%');	
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
										'usuario' => utf8_encode($r->usuario),
										'nombre' => utf8_encode($r->nombre),
										'operacion'  => utf8_encode($r->operacion),
										'fecha' => $r->fecha,
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

		public function getTotalPaginas($usuario, $operacion, $perfil, $buscardordesde, $buscardorhasta,$getTotalPaginas)
		{

			$result 	= array();
			$sqlFiltros = " WHERE ";

			$filtro1 = false;
			$filtro2 = false;
			$filtro3 = false;

			if (!empty($usuario)) {
					$sqlFiltros .= "  u.usuario LIKE :usuario    ";
				$filtro1 = true;
			}

			if (!empty($perfil)) {
				if ($filtro1==false) {
					$sqlFiltros .= "  p.id = :perfil ";
				}else{
					$sqlFiltros .= "  AND  p.id = :perfil  ";
				}
				$filtro2 = true;
			}

			if (!empty($operacion)) {
				if ($filtro1==false && $filtro2==false) {
					$sqlFiltros .= "  b.operacion LIKE :operacion    ";
				}else{
					$sqlFiltros .= "  AND   b.operacion LIKE :operacion    ";
				}
				$filtro3 = true;
			}

			if (!empty($buscardordesde) && !empty($buscardorhasta)) {
				if ($filtro1==false && $filtro2==false && $filtro3==false) {
					$sqlFiltros .= "  b.fecha BETWEEN :buscardordesde AND :buscardorhasta "; 
				}else{
					$sqlFiltros .= " AND ( b.fecha BETWEEN :buscardordesde AND :buscardorhasta ) ";			
				}
			}


			try
			{
				if(	empty($usuario) && empty($operacion) && empty($perfil) &&
					 empty($buscardordesde) && empty($buscardorhasta) 
				) {
					$consulta = $this->classConexion->getConexion()->
								prepare("	SELECT 
													COUNT(b.id) as num_filas  
											from bitacora as b
											INNER JOIN cfg_pn_usuario as u ON b.id_usuario = u.id
											INNER JOIN cfg_pn_perfil as p ON p.id = u.id_perfil 
										");
			   	}else{

					$consulta = $this->classConexion->getConexion()->
								prepare("		SELECT 
													COUNT(b.id) as num_filas  
												FROM bitacora as b
												INNER JOIN cfg_pn_usuario as u ON b.id_usuario = u.id
												INNER JOIN cfg_pn_perfil as p ON p.id = u.id_perfil 
											    	".$sqlFiltros."  
										");


					if (!empty($usuario)) {
				   		$consulta->bindValue(':usuario', '%'.$usuario.'%');	
					}
					if (!empty($perfil)) {
				   		$consulta->bindValue(':perfil', $perfil);	
					}
					if (!empty($operacion)) {
				   		$consulta->bindValue(':operacion', '%'.$operacion.'%');	
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

   }	
		
?>
