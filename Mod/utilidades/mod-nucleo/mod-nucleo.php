<?php

	class modNucleo {

		private $classConexion;

		public function __CONSTRUCT()
		{
			$this->classConexion = new classConexion();
		} 

		public function verificarInicioSesion($usuario, $contrasena)
		{
			try 
			{
				//Se extructura el sql y luego realizar protocolo de insercion de datos para luego ejecutar
				$sql = "SELECT 1 
						FROM cfg_pn_usuario  
						WHERE usuario = :usuario AND contrasena = :contrasena" ;

				$consulta = $this->classConexion->getConexion()->prepare($sql);

			   	$consulta->bindValue(':usuario', $usuario);							          
			   	$consulta->bindValue(':contrasena', $contrasena);			
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
		public function obtenerDatosUsuario($usuario)
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
											"SELECT 
												p.id as id_persona,																				
												p.cedula as cedula,
												p.nombre as nombre,
												p.apellido as apellido,    
												f.formato_foto as formato_foto,
												f.foto as foto,    												
												p.estado as estadoPersona,
											    u.id as id_usuario,
											    u.usuario as usuario,
											    u.contrasena as contrasena,
											    u.id_perfil as id_perfil,
											    pnp.nombre as nombrePerfil,											    
											    u.estado as estadoUsuario
											FROM    cfg_persona as p 
												INNER JOIN cfg_pn_usuario as u ON p.id_usuario = u.id
												INNER JOIN cfg_pn_perfil as pnp ON u.id_perfil = pnp.id
												LEFT JOIN cfg_persona_foto as f ON f.id_persona = p.id 
											WHERE u.usuario=:usuario;"
					   				);
				          
			   	$consulta->bindValue(':usuario', $usuario);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					
					$entidadResultados = new persona();
					//
					$usuario = new usuario();
					$perfil = new perfil();
					$entidadResultados->__SET('id_persona', $r->id_persona);
					$entidadResultados->__SET('cedula', $r->cedula);
					$entidadResultados->__SET('nombre', $r->nombre);
					$entidadResultados->__SET('apellido', $r->apellido);
					$entidadResultados->__SET('formato_foto', $r->formato_foto);
					$entidadResultados->__SET('foto', base64_encode($r->foto));					
					$entidadResultados->__SET('estado', $r->estadoPersona);
					$entidadResultados->__SET('id_usuario', $usuario);
					$entidadResultados->__GET('id_usuario')->__SET('id', $r->id_usuario);					
					$entidadResultados->__GET('id_usuario')->__SET('usuario', $r->usuario);
					$entidadResultados->__GET('id_usuario')->__SET('contrasena', $r->contrasena);	
					$entidadResultados->__GET('id_usuario')->__SET('id_perfil', $perfil);	
					$entidadResultados->__GET('id_usuario')->__GET('id_perfil')->__SET('id', $r->id_perfil);	
					$entidadResultados->__GET('id_usuario')->__GET('id_perfil')->__SET('nombre', $r->nombrePerfil);	

					//$entidadResultados->__GET('id_usuario')->__SET('estado', $r->estadoUsuario);

					return $entidadResultados;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}			
		}
		public function obtenerPermisosUsuario($usuario)
		{
			$result = array();
			try
			{

				$consulta = $this->classConexion->getConexion()->
							prepare("	SELECT 
											pp.id_modulo,
											pp.permiso_acceso,								
	                                        m.estado as estadoModulo,
	                                        m.id_modulo_pertenece,
											pp.func_nuevo,
											pp.func_editar,
											pp.func_eliminacion_logica,
											pp.func_generar_reporte,
											pp.func_generar_reporte_filtrado,
											pp.func_permisos_perfil,
											pp.func_busqueda_avanzada,
											pp.func_detalles,
											pp.func_atender,
											pp.func_asignar,
											pp.func_programar_tarea,
											pp.func_iniciar_finalizar_tarea,
											pp.func_diagnosticar,
											pp.func_gestion_equipo_mantenimiento,
											pp.func_respuesta_solicitud,
											pp.func_finalizar_solicitud,
											pp.func_desincorporar_equipo,											    
											pp.func_desincorporar_periferico,											    
											pp.func_desincorporar_componente,											    
											pp.func_cambiar_periferico,											    
											pp.func_cambiar_componente,											    
											pp.func_cambiar_software,											    
											pp.func_inconformidad_atendida
										FROM 
											cfg_pn_usuario as u 
											INNER JOIN cfg_pn_perfil as pf ON u.id_perfil = pf.id 
											INNER JOIN cfg_pn_perfil_permiso as pp ON pp.id_perfil = pf.id 
                                            INNER JOIN mtn_modulo as m ON m.id = pp.id_modulo 
										WHERE u.usuario = :usuario 
									");
			   	$consulta->bindValue(':usuario', $usuario);			
				$consulta->execute();

				foreach($consulta->fetchAll(PDO::FETCH_OBJ) as $r)
				{
					$result[] = array(
									'id_modulo' => $r->id_modulo,
									'permiso_acceso' => $r->permiso_acceso,
									'estadoModulo' => $r->estadoModulo, 
									'id_modulo_pertenece' => $r->id_modulo_pertenece,
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
									'func_desincorporar_equipo' => $r->func_desincorporar_equipo,
									'func_desincorporar_periferico' => $r->func_desincorporar_periferico,
									'func_desincorporar_componente' => $r->func_desincorporar_componente,
									'func_cambiar_periferico' => $r->func_cambiar_periferico,
									'func_cambiar_componente' => $r->func_cambiar_componente,
									'func_cambiar_software' => $r->func_cambiar_software,
									'func_inconformidad_atendida' => $r->func_inconformidad_atendida,										
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
		public function verificarEstadoUsuario($usuario, $contrasena)
		{
			try 
			{
				//Se extructura el sql y luego realizar protocolo de insercion de datos para luego ejecutar
				$sql = "SELECT  p.estado as estado
						FROM cfg_pn_usuario as u 
						INNER JOIN cfg_persona as p ON p.id_usuario = u.id
						WHERE u.usuario = :usuario AND u.contrasena = :contrasena";

				$consulta = $this->classConexion->getConexion()->prepare($sql);

			   	$consulta->bindValue(':usuario', $usuario);							          
			   	$consulta->bindValue(':contrasena', $contrasena);			
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				
				return $r->estado;
			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	
		public function verificarExistencia($tabla, $columna, $filtro)
		{
			try 
			{
				//Se extructura el sql y luego realizar protocolo de insercion de datos para luego ejecutar
				$sql = "SELECT 1 FROM ".$tabla." WHERE ".$columna." = :filtro ";

				$consulta = $this->classConexion->getConexion()->prepare($sql);
				          
			   	$consulta->bindValue(':filtro', $filtro);			
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
		public function verificarExistenciaConId($tabla, $columna, $filtro, $id)
		{
			try 
			{
				//Se extructura el sql y luego realizar protocolo de insercion de datos para luego ejecutar
				$sql = "SELECT 1 FROM ".$tabla." WHERE ".$columna." = :filtro AND id != ".$id;

				$consulta = $this->classConexion->getConexion()->prepare($sql);
				          
			   	$consulta->bindValue(':filtro', $filtro);			
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
		public function verificarExistenciaSelect($datos)
		{
			try 
			{

				//Iniciando datos

				$tabla = "";

				$tablasRelacion = "";

				$relaciones = "" ;

				$AND = "";

				//Preparar datos

				if($datos>0){ 
					$count=1;
					foreach ($datos as $clave => $valor) {

						$tabla = $valor['tabla_form'];
						//--> claves foraneas
						$tablasRelacion = $tablasRelacion." INNER JOIN ".$valor['tabla_campo']."
							as tRel".$count." ON tRel".$count.".id = tC.".$valor['columna_campo'] ;
						//--> valor campo foraneas
							if ($count>1) {
								$AND = " AND ";
							}
						$relaciones = $relaciones." ".$AND." tC.".$valor['columna_campo']." = ".$valor['id'];

					    $count=$count+1;
					}		
					$_SESSION['count']=$count;

				}

				// agregar datos a la sentencia 
				$sql = "SELECT 1 
						FROM ".$tabla." as tC ".$tablasRelacion."     
						WHERE   ".$relaciones;

				$consulta = $this->classConexion->getConexion()->prepare($sql);
				          
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
		public function verificarExistenciaSelectConId($datos, $id)
		{
			try 
			{

				//Iniciando datos

				$tabla = "";

				$tablasRelacion = "";

				$relaciones = "" ;

				$_SESSION['count']=0;


				//Preparar datos

				if($datos>0){ 
					$count=1;
					foreach ($datos as $clave => $valor) {

						$tabla = $valor['tabla_form'];
						//--> claves foraneas
						$tablasRelacion = $tablasRelacion." INNER JOIN ".$valor['tabla_campo']."
							as tRel".$count." ON tRel".$count.".id = tC.".$valor['columna_campo'] ;
						//--> valor campo foraneas
						$relaciones = $relaciones." AND tC.".$valor['columna_campo']." = ".$valor['id'];

					    $count=$count+1;
					}		
					$_SESSION['count']=$count;

				}

				// agregar datos a la sentencia 
				$sql = "SELECT 1 
						FROM ".$tabla." as tC ".$tablasRelacion."     
						WHERE tC.id != ".$id." ".$relaciones;

				$consulta = $this->classConexion->getConexion()->prepare($sql);
				          
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
		public function cargarListar($tabla)
		{ 
			$result = array();
			try
			{

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
														* 
												FROM  `".$tabla."`   
												WHERE estado = 1 
										");
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
		public function cargarListarUtf8Encode($tabla)
		{ 
			$result = array();
			try
			{

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
														* 
												FROM  `".$tabla."`   
												WHERE estado = 1 
										");
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
		public function cargarListarAnidada($tabla,$columna,$filtro)
		{ 
			$result = array();
			try
			{

					$consulta = $this->classConexion->getConexion()->
								prepare("	 	SELECT 
														* 
												FROM  `".$tabla."`   
												WHERE estado = 1 AND ".$columna." = :filtro
										");
			   	$consulta->bindValue(':filtro', $filtro);			
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

		public function consultarContadorSuspension()
		{
			try 
			{
				$consulta = $this->classConexion->getConexion()->
					        prepare(
											" SELECT 
												frecuencia_suspension 
											FROM   cfg_configuracion 
											WHERE id = 3 "
					   				);
				$consulta->execute();
				$r = $consulta->fetch(PDO::FETCH_OBJ);
				$consulta = $this->classConexion->getCerrarSesion();

				if ($r) {
					return $r->frecuencia_suspension;
				}
				return 0;

			} catch (Exception $e) 
			{
				return  "¡¡Error!! " .$e->getMessage(). " ! ";
			}
		}	

   }	
		
?>
