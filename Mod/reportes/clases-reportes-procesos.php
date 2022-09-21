<?php
 	require_once '../utilidades/ctrl-ortografia.php';

/**
* 
*/
class ModReportesProcesos 
{

	private $classConexion;
	
	function __construct()
	{
		# code...
	}
	

		/*
			Nota: Funciones de consultas a BD , lista de rendimiento de los servicios realizados a los equipos
		*/
		public function ListarRptRendimientoServicios($filtro,$fecha_1, $fecha_2)
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
									t.nombre as nombre_tarea,
								    m.fecha_f as fecha_finalizo,    
									(CASE 
									  WHEN TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)!=0 THEN 
								 				CONCAT(TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f),' Horas')
									  WHEN TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f)!=0 THEN 
								      			CONCAT(TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f),' Minutos')
									  WHEN TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f) !=0 THEN 
								                CONCAT(TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f),' Segundos')
									END) as tiempo_duracion,
								    te.tiempo_estimado,
									(CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 					    
                                      	TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado  ELSE 0
								     END)as tardanza,
									t.tarea_correctiva,
									m.observacion 									
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
								ORDER BY m.fecha_f DESC  ";

					}else{

							$SQL = "SELECT
									t.nombre as nombre_tarea,							
								    m.fecha_f as fecha_finalizo, 
									(CASE 
									  WHEN TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)!=0 THEN 
								 				CONCAT(TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f),' Horas')
									  WHEN TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f)!=0 THEN 
								      			CONCAT(TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f),' Minutos')
									  WHEN TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f) !=0 THEN 
								                CONCAT(TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f),' Segundos')
									END) as tiempo_duracion,
								    te.tiempo_estimado,								       
									(CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 					    
                                      	TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado  ELSE 0
								     END)as tardanza,
									t.tarea_correctiva,
									m.observacion 
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
								 ORDER BY m.fecha_f DESC "  ;
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

					$NOMBRE_TIPO_TAREA="CORRECTIVA";
					if($r->tarea_correctiva==0){
						$NOMBRE_TIPO_TAREA="PREVENTIVA";
					}

					$result[] = array(
										'NOMBRE_TIPO_TAREA' => $NOMBRE_TIPO_TAREA,						
										'NOMBRE_TAREA' => $r->nombre_tarea,
										'FECHA_FINALIZACION' => $r->fecha_finalizo,
										'DURACION' => $r->tiempo_duracion,
										'ESTIMACION' => $r->tiempo_estimado,
										'TARDANZA' => $r->tardanza,
										'OBSERVACION' => $r->observacion,
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
			Nota: Funciones de consultas a BD , para obtener los datos principales del tecnico
		*/
		public function datosTecnicoRendimientoServicios($cedula)
		{
			$this->classConexion = new classConexion();
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()
							->prepare("SELECT
										  p.cedula AS cedula,
										  CONCAT(p.nombre,' ',p.apellido) as nombreYapellido,
										  p.correo_electronico 
										FROM
										  cfg_persona AS p
										WHERE
										  p.cedula = :cedula");
		   		$consulta->bindValue(':cedula', $cedula);
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
							$result[] = array(
										'CEDULA' => $r->cedula,
										'NOMBREYAPELLIDO' => $r->nombreYapellido,
										'CORREOELECTRONICO' => $r->correo_electronico,
									);
				}	
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		/*
			Areas concurrentes de tareas correctivas
		*/
		public function ListarReporteAreasConcurrentesTareasCorrectivas($filtro_marca, $filtro_modelo, $filtro_tipo, $fecha_1, $fecha_2,$opcionrpt)
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
									GROUP BY  ".$opcionrpt_dat."
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
							$opcionrpt_dat =  $r->departamento;
							break;
						case 'detallado':
							$opcionrpt_dat =  $r->departamento." - ".$r->tarea;
							break;						
					}
					$result[] = array(
										'PROMEDIO'			=> $r->total_individual.'/'.$r->total.' | '.$r->promedio.'%', 						
										'DEPARTAMEMTO'		=> utf8_encode($opcionrpt_dat), 
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
			Desincorporaciones y cambios concurrentes
		*/		
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
						$control_fecha = " DATE_FORMAT(pej.fecha,'%d-%m-%Y  %h:%s ') as fecha_m, ";
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
                            ORDER BY pej.fecha DESC
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
                            ORDER BY pej.fecha DESC ";
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
										'FECHA_M'			=> $r->fecha_m,
										'CONCURRENCIA'		=> $r->concurrencia,
										'NOMBRE_DEPARTAMENTO'		=> utf8_encode($r->departamento),
										'FUNCION'			=> utf8_encode($r->funcion),
										'OBSERVACION'		=> $r->observacion,
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
			Nota: Funciones de consultas a BD , para obtener los datos principales del tecnico
		*/
		public function datosDesincorporacionesConcurrentes($filtro_funcion,$filtro_departamento)
		{
			$this->classConexion = new classConexion();
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()
							->prepare("SELECT nombre FROM pnej_funcion_persona WHERE id = :filtro_funcion");
				$consulta2 = $this->classConexion->getConexion()
							->prepare("SELECT nombre FROM cfg_departamento WHERE id = :filtro_departamento");

		   		$consulta->bindValue(':filtro_funcion', $filtro_funcion);
		   		$consulta2->bindValue(':filtro_departamento', $filtro_departamento);

				$consulta->execute();
				$consulta2->execute();

				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$r2 = $consulta2->fetch(PDO::FETCH_OBJ);

				$consulta = $this->classConexion->getCerrarSesion();
				$consulta2 = $this->classConexion->getCerrarSesion();

				if ($r || $r2) {
					$funcion 	= (empty($r))?"":$r->nombre;
					$departamento = (empty($r2))?"":$r2->nombre;

							$result[] = array(
										'NOMBRE_FUNCION' 	=> $funcion,
										'NOMBRE_DEPARTAMENTO' => $departamento,
									);
				}	
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}

		/*******************************/
		/*
			Nota: Funciones de consultas a BD , mantenimientos preventivos al equipo
		*/
		public function ListarRptMantenimientoPreventivo($id_equipo,$fecha_1, $fecha_2)
		{
			$this->classConexion = new classConexion();
			$result = array();
			try
			{
				if( empty($fecha_1) && empty($fecha_2) || 
					!empty($fecha_1) && empty($fecha_2) ||
					empty($fecha_1) && !empty($fecha_2)) {			
					$SQL = "	SELECT
									e.serial,
								    e.serial_bn,
								    cft.nombre as tipo_eq,
								    CONCAT(cfmm.nombre,' - ',cfm.nombre) as modelo_marca,
								    p.cedula as cedula_responsable,
								    t.nombre as nombre_tarea,
								    m.fecha_i as inicio,
								    m.fecha_f as finalizo,    
									(CASE 
									  WHEN TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)!=0 THEN 
								 				CONCAT(TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f),' Horas')
									  WHEN TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f)!=0 THEN 
								      			CONCAT(TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f),' Minutos')
									  WHEN TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f) !=0 THEN 
								                CONCAT(TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f),' Segundos')
									END) as tiempo_duracion,
									CONCAT(te.tiempo_estimado,' Horas') as tiempo_estimado,	
									(CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN CONCAT(TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado, ' horas')  ELSE 0
								     END)as tardanza,	
									m.observacion
								FROM equipo as e 
								INNER JOIN cfg_caracteristicas_fisc_eq as c_eq ON c_eq.id = e.id_c_fisc_eq
								INNER JOIN cfg_c_fisc_tipo as cft ON cft.id = c_eq.id_tipo_fisc
								INNER JOIN cfg_c_fisc_modelo as cfm ON cfm.id = c_eq.id_modelo_fisc
								INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfmm.id = cfm.id_marca
								INNER JOIN tarea_equipo as te ON te.id_equipo = e.id
								INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
								INNER JOIN mantenimiento as m ON m.id_tarea_equipo = te.id 
								INNER JOIN persona_ejecuta as pj ON pj.id_mantenimiento = m.id 
								INNER JOIN pnej_funcion_persona as pjfunc ON pjfunc.id = pj.id_funcion_persona
								INNER JOIN cfg_persona as p ON p.id = pj.id_persona 
								WHERE e.id = ".$id_equipo." AND t.tarea_correctiva=0 AND m.id_tipo_mant = 1 AND te.estado_uso = 0 AND pjfunc.id=20
										";

					} elseif (!empty($fecha_1) && !empty($fecha_2)) {

							$SQL = "SELECT
									e.serial,
								    e.serial_bn,
								    cft.nombre as tipo_eq,
								    CONCAT(cfmm.nombre,' - ',cfm.nombre) as modelo_marca,
								    p.cedula as cedula_responsable,
								    t.nombre as nombre_tarea,
								    m.fecha_i as inicio,
								    m.fecha_f as finalizo,    
									(CASE 
									  WHEN TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)!=0 THEN 
								 				CONCAT(TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f),' Horas')
									  WHEN TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f)!=0 THEN 
								      			CONCAT(TIMESTAMPDIFF(MINUTE,m.fecha_i,m.fecha_f),' Minutos')
									  WHEN TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f) !=0 THEN 
								                CONCAT(TIMESTAMPDIFF(SECOND,m.fecha_i,m.fecha_f),' Segundos')
									END) as tiempo_duracion,
									CONCAT(te.tiempo_estimado,' Horas') as tiempo_estimado,	
									(CASE 
								     	WHEN (TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)>te.tiempo_estimado)=1  THEN 		
                                        CONCAT(TIMESTAMPDIFF(HOUR,m.fecha_i,m.fecha_f)-te.tiempo_estimado, ' horas')  ELSE 0
								     END)as tardanza,	
									m.observacion
								FROM equipo as e 
								INNER JOIN cfg_caracteristicas_fisc_eq as c_eq ON c_eq.id = e.id_c_fisc_eq
								INNER JOIN cfg_c_fisc_tipo as cft ON cft.id = c_eq.id_tipo_fisc
								INNER JOIN cfg_c_fisc_modelo as cfm ON cfm.id = c_eq.id_modelo_fisc
								INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfmm.id = cfm.id_marca
								INNER JOIN tarea_equipo as te ON te.id_equipo = e.id
								INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
								INNER JOIN mantenimiento as m ON m.id_tarea_equipo = te.id 
								INNER JOIN persona_ejecuta as pj ON pj.id_mantenimiento = m.id 
								INNER JOIN pnej_funcion_persona as pjfunc ON pjfunc.id = pj.id_funcion_persona
								INNER JOIN cfg_persona as p ON p.id = pj.id_persona 
								WHERE e.id = ".$id_equipo." AND t.tarea_correctiva=0 AND m.id_tipo_mant = 1 AND te.estado_uso = 0 AND pjfunc.id=20 
									  AND m.fecha_i BETWEEN CAST(:fecha_desde_1 AS DATE) AND CAST(:fecha_hasta_1 AS DATE)
									  AND m.fecha_f BETWEEN CAST(:fecha_desde_2 AS DATE) AND CAST(:fecha_hasta_2 AS DATE)";
				}								
				$consulta = $this->classConexion->getConexion()->prepare($SQL);
				if (!empty($fecha_1) && !empty($fecha_2)) {
					//
			   		$consulta->bindValue(':fecha_desde_1', $fecha_1);
			   		$consulta->bindValue(':fecha_hasta_1', $fecha_2);
			   		//
			   		$consulta->bindValue(':fecha_desde_2', $fecha_1);
			   		$consulta->bindValue(':fecha_hasta_2', $fecha_2);
				}
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'SERIAL' => utf8_encode($r->serial),
										'SERIAL DE BIEN NACIONAL' => utf8_encode($r->serial_bn),
										'TIPO DE EQUIPO' => utf8_encode($r->tipo_eq),
										'MARCA Y MODELO' => utf8_encode($r->modelo_marca),
										'RESPONSABLE' => $r->cedula_responsable,
										'TAREA' => utf8_encode($r->nombre_tarea),
										'INICIO' => $r->inicio,
										'FINALIZO' => $r->finalizo,
										'DURACCION' => utf8_encode($r->tiempo_duracion),
										'TIEMPO ESTIMADO' => utf8_encode($r->tiempo_estimado),
										'TARDANZA' => utf8_encode($r->tardanza),
										'OBSERVACION' => utf8_encode($r->observacion),
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
			Vencimiento de tareas
		*/
		public function ListarReporteVencimientoTareas($filtro_tarea, $filtro_seria_e, $filtro_desde, $filtro_hasta)
		{ 
			$this->classConexion = new classConexion();

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
					$SQL = "SELECT
								t.nombre,
							    e.serial,
							    te.proxima_fecha,
							    (SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3) as dias_proximidad_tarea,												    
							    (CASE 
										WHEN 
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3))=1 AND
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=0
										THEN
											CONCAT(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW()),' DÍAS POR VENCER')
										WHEN 
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3))=1 AND
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1
											THEN															
											(CASE
												WHEN TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())=0 
												THEN 
													'DÍA LIMITE'
												ELSE
													CONCAT(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW()),' DÍAS VENCIDOS')
											END)															
							    END) as dias_intervalo
							FROM tarea_equipo as te
							INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
							INNER JOIN equipo as e ON e.id = te.id_equipo
							WHERE e.estado<>0 AND t.tarea_correctiva=0 AND( (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3 ))=1 OR (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1)
							ORDER BY te.proxima_fecha DESC ";
			   	}else{

					$SQL = "SELECT
								t.nombre,
							    e.serial,
							    te.proxima_fecha,
							    (SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3) as dias_proximidad_tarea,												    
							    (CASE 
										WHEN 
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3))=1 AND
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=0
										THEN
											CONCAT(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW()),' DÍAS POR VENCER')
										WHEN 
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3))=1 AND
											(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1
											THEN															
											(CASE
												WHEN TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())=0 
												THEN 
													'DÍA LIMITE'
												ELSE
													CONCAT(TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW()),' DÍAS VENCIDOS')
											END)															
							    END) as dias_intervalo
							FROM tarea_equipo as te
							INNER JOIN cfg_tarea as t ON t.id = te.id_tarea
							INNER JOIN equipo as e ON e.id = te.id_equipo
							WHERE e.estado<>0 AND t.tarea_correctiva=0 AND( (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>-(SELECT dias_proximidad_tarea FROM cfg_configuracion WHERE id=3 ))=1 OR (TIMESTAMPDIFF(DAY,te.proxima_fecha , NOW())>=0)=1)
								".$sqlFiltros."    
							ORDER BY te.proxima_fecha DESC";
			   	}
					$consulta = $this->classConexion->getConexion()->prepare($SQL);
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

				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'NOMBRE' => utf8_encode($r->nombre),
										'SERIAL' => utf8_encode($r->serial),
										'DIAS_INTERVALO' => $r->dias_intervalo,
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
			Nota: Funciones de consultas a BD , lista de rendimiento de los servicios realizados a los equipos
		*/
		public function ListarRptTareasConcurrentes($filtro_marca, $filtro_modelo, $filtro_tipo, $fecha_1, $fecha_2)
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
										'NOMBRE_TAREA'		=> utf8_encode($r->nombre_tarea), 
										'PROMEDIO'			=> $r->total_individual.'/'.$r->total.' | '.$r->promedio.'%', 
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
			Nota: Funciones de consultas a BD , para obtener los datos principales del tecnico
		*/
		public function datosTareasConcurrentes($marca_e,$modelo_e,$tipo_e)
		{
			$this->classConexion = new classConexion();
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()
							->prepare("SELECT nombre FROM cfg_c_fisc_mod_marca WHERE id = :marca_e");
				$consulta2 = $this->classConexion->getConexion()
							->prepare("SELECT nombre FROM cfg_c_fisc_modelo WHERE id = :modelo_e");
				$consulta3 = $this->classConexion->getConexion()
							->prepare("SELECT nombre FROM cfg_c_fisc_tipo WHERE id = :tipo_e");

		   		$consulta->bindValue(':marca_e', $marca_e);
		   		$consulta2->bindValue(':modelo_e', $modelo_e);
		   		$consulta3->bindValue(':tipo_e', $tipo_e);

				$consulta->execute();
				$consulta2->execute();
				$consulta3->execute();

				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$r2 = $consulta2->fetch(PDO::FETCH_OBJ);
				$r3 = $consulta3->fetch(PDO::FETCH_OBJ);

				$consulta = $this->classConexion->getCerrarSesion();
				$consulta2 = $this->classConexion->getCerrarSesion();
				$consulta3 = $this->classConexion->getCerrarSesion();

				if ($r || $r2 || $r3) {
					$marca 	= (empty($r))?"":$r->nombre;
					$modelo = (empty($r2))?"":$r2->nombre;
					$tipo 	= (empty($r3))?"":$r3->nombre;
							$result[] = array(
										'NOMBRE_MARCA' 	=> utf8_encode($marca),
										'NOMBRE_MODELO' => utf8_encode($modelo),
										'NOMBRE_TIPO' 	=> utf8_encode($tipo),
									);
				}	
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		/*******************************/
		/*
			Nota: Funciones de consultas a BD , para obtener los datos principales de la silicitud
		*/
		public function datosGeneralesRptActividadesSolicitud($id_solicitud)
		{
			$this->classConexion = new classConexion();
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()
							->prepare("SELECT
										s.asunto,
									    s.descripcion,
									    s.fecha,
									    s.fecha_desde as fecha_atencion,
									    s.fecha_cierre,
									    p1.cedula as ci_solicitante,
									    CONCAT(c1.nombre,' ',d1.nombre) as cargoYdpto_solicitante,
									    p2.cedula as ci_responsable_asignado,
									    CONCAT(c2.nombre,' ',d2.nombre) as cargoYdpto_responsable_asignado,
									    e.serial,
									    e.serial_bn,
									    cft.nombre as tipo_e,
									    CONCAT(cfmm.nombre,' ',cfm.nombre) as marcaymodelo_e
									FROM solicitud as s 
									INNER JOIN cfg_persona as p1 ON p1.id = s.id_persona
									INNER JOIN cfg_pn_cargo as c1 ON c1.id = s.id_cargo
									INNER JOIN cfg_departamento as d1 ON d1.id = s.id_departamento
									LEFT JOIN cfg_persona as p2 ON p2.id = s.id_persona_asignada
									LEFT JOIN cfg_pn_cargo as c2 ON c2.id = s.id_cargo_pa
									LEFT JOIN cfg_departamento as d2 ON d2.id = s.id_departamento_pa
									INNER JOIN equipo as e ON e.id = s.id_equipo 
									INNER JOIN cfg_caracteristicas_fisc_eq as c_eq ON c_eq.id = e.id_c_fisc_eq
									INNER JOIN cfg_c_fisc_tipo as cft ON cft.id = c_eq.id_tipo_fisc
									INNER JOIN cfg_c_fisc_modelo as cfm ON cfm.id = c_eq.id_modelo_fisc
									INNER JOIN cfg_c_fisc_mod_marca as cfmm ON cfmm.id = cfm.id_marca
									WHERE s.id = :id_solicitud ");
		   		$consulta->bindValue(':id_solicitud', $id_solicitud);
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
							$result[] = array(
										'ASUNTO' => eliminar_tildes($r->asunto),
										'DESCRIPCION' => eliminar_tildes($r->descripcion),
										'FECHA' => $r->fecha,
										'FECHA_ATENCION' => $r->fecha_atencion,
										'FECHA_CIERRE' => $r->fecha_cierre,
										'CI_SOLICITANTE' => $r->ci_solicitante,
										'CARGOYDPTO_SOLICITANTE' => eliminar_tildes($r->cargoYdpto_solicitante),
										'CI_RESPONSABLE_ASIGNADO' => $r->ci_responsable_asignado,
										'CARGOYDPTO_RESPONSABLE_ASIGNADO' => eliminar_tildes($r->cargoYdpto_responsable_asignado),
										'SERIAL_E' => $r->serial,
										'SERIAL_BN_E' => $r->serial_bn,
										'TIPO_E' => eliminar_tildes($r->tipo_e),
										'MARCAYMODELO_E' => eliminar_tildes($r->marcaymodelo_e),
									);
				}	
				return ($result) ? $result : 0 ;
			}
			catch(Exception $e)
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}
		/*
			Nota: Funciones de consultas a BD para listado de actividades de solicitud
		*/
		public function ListarRptActividadesSolicitud($id_solicitud)
		{
			$this->classConexion = new classConexion();
			$result = array();
			try
			{
				$consulta = $this->classConexion->getConexion()
							->prepare("SELECT 
											pej.fecha as FECHA_EJECUCION,
											CONCAT('C.I: ',p.cedula) as RESPONSABLE,
											fpej.id AS ID_FUNCION,
											fpej.nombre AS FUNCION,
											(CASE 
											 	WHEN pej.detalles='0' OR fpej.id=15 
											 	THEN 'NO-APLICA' 
											 	ELSE pej.detalles
											 END) as DETALLES_EJECUCION,
											(CASE 
											 	WHEN m.observacion='0' OR fpej.id=1 
											 	THEN 'NO-APLICA' 
											 	ELSE m.observacion
											 END) as OBSERVACION
										FROM mantenimiento as m 
										INNER JOIN solicitud as s ON s.id = m.id_solicitud 
										LEFT JOIN tarea_equipo as te ON te.id = m.id_tarea_equipo
										LEFT JOIN cfg_tarea as t ON t.id = te.id_tarea 
										INNER JOIN persona_ejecuta as pej ON pej.id_mantenimiento = m.id
										INNER JOIN pnej_funcion_persona as fpej ON fpej.id = pej.id_funcion_persona
										INNER JOIN cfg_persona as p ON p.id = pej.id_persona 
										WHERE m.id_solicitud = :id_solicitud 
										ORDER BY pej.fecha ASC");

		   		$consulta->bindValue(':id_solicitud', $id_solicitud);
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
										'RESPONSABLE' => eliminar_tildes($r->RESPONSABLE),
										'ID_FUNCION' => $r->ID_FUNCION,
										'FUNCION' => eliminar_tildes($r->FUNCION),
										'FECHA_EJECUCION' => $r->FECHA_EJECUCION,									
										'DETALLES_EJECUCION' => eliminar_tildes($r->DETALLES_EJECUCION),
										'OBSERVACION' => eliminar_tildes($r->OBSERVACION),
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