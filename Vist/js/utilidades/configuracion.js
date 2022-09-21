var configuracion = function() {

	var controlVariableG1 = "";
	var controlVariableG2 = "";
	var controlVariableG3 = "";	
	/*
		Ejemplos de url:
		############# SIN TABS #############
		catalogo :     configuracion.urlsPublic().modRecurso.recurso.catalogo
		ventana modal :    configuracion.urlsPublic().modRecurso.recurso.ventanaModal
		api :    configuracion.urlsPublic().modRecurso.recurso.api 
		############# CON TABS #############
		catalogo : 	    configuracion.urlsPublic().modPersona.tabs.perfil.catalogo
		ventana modal : 	configuracion.urlsPublic().modPersona.tabs.perfil.ventanaModal
		api : 	 configuracion.urlsPublic().modPersona.tabs.perfil.api
		############# MANTENIMIENTO #############
		catalogo :     configuracion.urlsPublic().mantenimineto.modModulo.modulo.catalogo
		ventana modal :    configuracion.urlsPublic().mantenimineto.modModulo.modulo.ventanaModal
		api :    configuracion.urlsPublic().mantenimineto.modModulo.modulo.api 	

	*/
	var urls = function() {

		var urls = {
			
			solicitud : {
				api : "Ctrl/procesos/solicitud/ctrl-solicitud.php",
			},

			mantenimiento : {
				api : "Ctrl/procesos/mantenimiento-equipo/ctrl-mantenimiento-equipo.php",
			},

			tareaProgramada : {
				api : "Ctrl/procesos/tarea-programada/ctrl-tarea-programada.php",
			},

			asignar : {
				api : "Ctrl/procesos/asignar/ctrl-asignar.php",
			},

			equipo : {
				detallar: "procesos/agregar/equipo/ventanasModales/detallar/vtnMGestionEquipoConsulta.php",
				tabsDetallar : {
					detalles: "procesos/agregar/equipo/ventanasModales/detallar/forms/formCaracteristicasEquipo.php",
					componentes:"procesos/agregar/equipo/ventanasModales/detallar/forms/formComponentesEquipo.php",
					perifericos: "procesos/agregar/equipo/ventanasModales/detallar/forms/formPerifericosEquipo.php",
					software: "procesos/agregar/equipo/ventanasModales/detallar/forms/formSoftwareEquipo.php",
				},
				catalogo : "procesos/agregar/equipo/catalogos/ctlgGestionEquipo.php",
				ventanaModal : "procesos/agregar/equipo/ventanasModales/vtnMGestionEquipo.php",
				api : "Ctrl/procesos/agregar/ctrl-equipo.php"
			},

			componente : {
				catalogo : "procesos/agregar/componente/catalogos/ctlgGestionComponente.php",
				ventanaModal : "procesos/agregar/componente/ventanasModales/vtnMGestionComponente.php",
				api : "Ctrl/procesos/agregar/ctrl-componente.php"
			},

			periferico : {
				catalogo : "procesos/agregar/periferico/catalogos/ctlgGestionPeriferico.php",
				ventanaModal : "procesos/agregar/periferico/ventanasModales/vtnMGestionPeriferico.php",
				api : "Ctrl/procesos/agregar/ctrl-periferico.php"
			},

			software : {
				catalogo : "procesos/agregar/componente/catalogos/ctlgGestionComponente.php",
				ventanaModal : "procesos/agregar/componente/ventanasModales/vtnMGestionComponente.php",
				api : "Ctrl/configuracion/ctrl-componente.php"
			},

			/////////////////////////////////////////////////////////////////////////////////////
			modConfiguracion : {	
					formulario : "configuracion/pagConfiguracion.php",
					api : "Ctrl/configuracion/ctrl-configuracion.php"
			},
			modPersona : {	

				tabs : {
					persona : {
						catalogo : "configuracion/gestionPersona/catalogos/ctlgGestionPersona.php",
						ventanaModal : "configuracion/gestionPersona/ventanasModales/vtnMGestionPersona.php",
						api : "Ctrl/configuracion/ctrl-persona.php"
					},
					perfil : {
						catalogo : "configuracion/gestionPersona/gestionPerfiles/catalogos/ctlgGestionPerfil.php",
						ventanaModal : "configuracion/gestionPersona/gestionPerfiles/ventanasModales/vtnMGestionPerfil.php",
						api : "Ctrl/configuracion/ctrl-pn-perfil.php",
						permisos : {
							ventanaModal : "configuracion/gestionPersona/gestionPerfiles/ventanasModales/vtnMGestionPermisosPerfil.php"
						},

					},			
				},
			},
			modDepartamento : {	
				departamento : {
					catalogo : "configuracion/gestionDepartamentos/catalogos/ctlgGestionDepartamento.php",
					ventanaModal : "configuracion/gestionDepartamentos/ventanasModales/vtnMGestionDepartamento.php",
					api : "Ctrl/configuracion/ctrl-departamento.php"
				},
				cargo : {
					catalogo : "configuracion/gestionDepartamentos/gestionCargos/catalogos/ctlgGestionCargo.php",
					ventanaModal : "configuracion/gestionDepartamentos/gestionCargos/ventanasModales/vtnMGestionCargo.php",
					api : "Ctrl/configuracion/ctrl-pn-cargo.php"
				},
			},				
			modTareas : {

				tabs : {
					tarea : {
						catalogo : "configuracion/gestionTareas/gestionTareas/catalogos/ctlgGestionTarea.php",
						ventanaModal : "configuracion/gestionTareas/gestionTareas/ventanasModales/vtnMGestionTarea.php",
						api : "Ctrl/configuracion/ctrl-tarea.php"
					},		
				},		
			},
			modCPeriferico : {	
				periferico : {
					catalogo : "configuracion/gestionCaracteristicasPeriferico/catalogos/ctlgGestionCaracteristicasPeriferico.php",
					ventanaModal : "configuracion/gestionCaracteristicasPeriferico/ventanasModales/vtnMGestionCaracteristicasPeriferico.php",
					api : "Ctrl/configuracion/ctrl-c-periferico.php"
				},
			},	
			modCComponente : {	
				componente : {
					catalogo : "configuracion/gestionCaracteristicasComponente/catalogos/ctlgGestionCaracteristicasComponente.php",
					ventanaModal : "configuracion/gestionCaracteristicasComponente/ventanasModales/vtnMGestionCaracteristicasComponente.php",
					api : "Ctrl/configuracion/ctrl-c-componente.php"
				},
			},	
			modCSoftware : {	
				software : {
					catalogo : "configuracion/gestionCaracteristicasSoftware/catalogos/ctlgGestionCaracteristicasSoftware.php",
					ventanaModal : "configuracion/gestionCaracteristicasSoftware/ventanasModales/vtnMGestionCaracteristicasSoftware.php",
					api : "Ctrl/configuracion/ctrl-c-software.php"
				},
			},	
			modCEquipo : {	
				equipo : {
					catalogo : "configuracion/gestionCaracteristicasEquipo/catalogos/ctlgGestionCaracteristicasEquipo.php",
					ventanaModal : "configuracion/gestionCaracteristicasEquipo/ventanasModales/vtnMGestionCaracteristicasEquipo.php",
					api : "Ctrl/configuracion/ctrl-c-equipo.php"
				},
			},						
			modCLogica : {

				tabs : {
					tipo : {
						catalogo : "configuracion/gestionConfigCLogica/gestionTipo/catalogos/ctlgGestionTipo.php",
						ventanaModal : "configuracion/gestionConfigCLogica/gestionTipo/ventanasModales/vtnMGestionTipo.php",
						api : "Ctrl/configuracion/ctrl-c-logc-tipo.php"
					},	
					distribucion : {
						catalogo : "configuracion/gestionConfigCLogica/gestionDistribucion/catalogos/ctlgGestionDistribucion.php",
						ventanaModal : "configuracion/gestionConfigCLogica/gestionDistribucion/ventanasModales/vtnMGestionDistribucion.php",
						api : "Ctrl/configuracion/ctrl-c-logc-distribucion.php"
					},
					
				},
			},
			modCFisica : {

				tabs : {
					tipo : {
						catalogo : "configuracion/gestionConfigCFisica/gestionTipo/catalogos/ctlgGestionTipo.php",
						ventanaModal : "configuracion/gestionConfigCFisica/gestionTipo/ventanasModales/vtnMGestionTipo.php",
						api : "Ctrl/configuracion/ctrl-c-fisc-tipo.php"
					},
					modelo : {
						catalogo : "configuracion/gestionConfigCFisica/gestionModelo/catalogos/ctlgGestionModelo.php",
						ventanaModal : "configuracion/gestionConfigCFisica/gestionModelo/ventanasModales/vtnMGestionModelo.php",
						api : "Ctrl/configuracion/ctrl-c-fisc-modelo.php"
					},			
					marca : {
						catalogo : "configuracion/gestionConfigCFisica/gestionMarca/catalogos/ctlgGestionMarca.php",
						ventanaModal : "configuracion/gestionConfigCFisica/gestionMarca/ventanasModales/vtnMGestionMarca.php",
						api : "Ctrl/configuracion/ctrl-c-fisc-marca.php"
					},
					interfaz : {
						catalogo : "configuracion/gestionConfigCFisica/gestionInterfazConexion/catalogos/ctlgGestionInterfazConexion.php",
						ventanaModal : "configuracion/gestionConfigCFisica/gestionInterfazConexion/ventanasModales/vtnMGestionInterfazConexion.php",
						api : "Ctrl/configuracion/ctrl-c-fisc-interfaz-conexion.php"
					},
					umCapacidad : {
						catalogo : "configuracion/gestionConfigCFisica/gestionUnidadMedida/catalogos/ctlgGestionUnidadMedida.php",
						ventanaModal : "configuracion/gestionConfigCFisica/gestionUnidadMedida/ventanasModales/vtnMGestionUnidadMedida.php",
						api : "Ctrl/configuracion/ctrl-c-fisc-unidad-medida.php"
					},	
				},
			},	
			mantenimineto : {
					formulario : "mantenimiento/pagSistema.php",
					api : "Ctrl/mantenimiento/ctrl-ajuste-sistema.php",
					modModulo : {	
						modulo : {
							catalogo : "mantenimiento/gestionModulos/catalogos/ctlgGestionModulo.php",
							ventanaModal : "mantenimiento/gestionModulos/ventanasModales/vtnMGestionModulo.php",
							api : "Ctrl/mantenimiento/ctrl-modulo.php"
						},
					},	
					modBitacora : {	
						bitacora : {
							catalogo : "mantenimiento/gestionBitacora/catalogos/ctlgGestionBitacora.php",
							ventanaModal : "mantenimiento/gestionBitacora/ventanasModales/vtnMGestionBitacora.php",
							api : "Ctrl/mantenimiento/ctrl-bitacora.php"
						},
					},					
			},
			modReporte : {	
					tabs : {
						/*
							Gerenciales
						*/						
						rendimientoServicio : {
							catalogo : "reportes/Gerenciales/rendimientoServicio/catalogos/ctlgGestionRendimientoServicio.php",
							api : "Ctrl/reportes/ctrl-rendimiento.php"
						},
						areasConcurrentesTareasCorrectivas : {							
							api : "Ctrl/reportes/ctrl-areas-concurrentes-tareas-correctivas.php"
						},
						desincorporacionesConcurrentes : {							
							api : "Ctrl/reportes/ctrl-desincorporaciones-concurrentes.php"
						},						
						/*
							Estrategicos
						*/ 
						vencimientoTarea : {
							catalogo : "reportes/Estrategicos/vencimientoTareas/catalogos/ctlgRptVencimientoTareas.php" ,
							api : "Ctrl/reportes/ctrl-vencimiento-tarea.php"

						},
						tareasConcurrentes : {
							api : "Ctrl/reportes/ctrl-tareas-concurrentes.php"
						},						
						/*
							Operativos
						*/						
						actividadesSolicitud : {
							catalogo : "reportes/Operativos/solicitud/catalogos/ctlgGestionSolicitud.php",
							api : "Ctrl/reportes/ctrl-actividades-solicitud.php"
						},
						mantPreventivo : {
							catalogo : "reportes/Estrategicos/mantPreventivo/catalogos/ctlgGestionMantPreventivo.php",
							vM : {
								busquedaAvanzada : "reportes/Estrategicos/mantPreventivo/ventanasModales/vtnMGestionBusquedaAvanzada.php",
							},
							api : "Ctrl/reportes/ctrl-mantenimiento-preventivo.php"
						},																				
					},
			},				
		};		
		return urls;
	}
	var datos = function() {
		
	}	

	var xxxxxxxOtros = function() {
		
	}
	/*gestionar en modulo*/


	/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
	*/	
	var consultar = function() {

		var accion_ = "defaul";
		//
	    $.ajax({
			url: configuracion.urlsPublic().modConfiguracion.api,
			type:'POST',	
			data:{	
					accion:accion_,
				},
	        beforeSend: function () {
            	$('#divConfiguracion #form').css("display", "none");
                $('#divConfiguracion #procesandoDatosDialg').css("display", "block");
	        },
	        success:  function (data) {
        	  	$('#divConfiguracion #form').css("display", "block");
                $('#divConfiguracion #procesandoDatosDialg').css("display", "none");
				//console.log(JSON.stringify(data));
				$('#divConfiguracion #datoControlId').val(data[0].id);
				controlVariableG1 = data[0].nombre;
				$("#divConfiguracion #nombreTxt").val(controlVariableG1); 
				//
				$('#sinImg').css("display","none");
				$('#preViewImg').css("display","block");
				$('#preViewImg').attr("src", data[0].logo);
				//
				$('#fotografia').removeAttr("required");
				//
				//nucleo.activarSuspensionPublic();		
				// 
	        },
		    //error:  function(jq,status,message) {
	    	error:  function(error) {
					console.log(JSON.stringify(error));	
		        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
		    }	 
		});
		
	    //
		//e.preventDefault();
		return false;
	}
	/* La funcionalidad Guardar: 
		# Uso : Se usa para guardar y editar
		# Parametros:
						* Se extraen directamente del formulario con Jquery  
						* accion_: Determina la accion a realizaar con la api
	*/		
	var guardar = function() {
		$("#divConfiguracion #form").on("submit", function(e){

			// validar de new los campos
			if(nucleo.validadorPublic()==false){
				e.preventDefault();
				return false;
			}

			/* Obtener valores de los campos del formulario*/

			//console.log("guardando...");

			var accion_ = "guardar";
			//
			var nombre_	= $("#nombreTxt").val(); 
			//
			var id_ = $('#divConfiguracion #datoControlId').val();
			if (id_==""){
				id_=0;
			};


			var datos = new FormData();
	        var fotografia_ = "";
	        var sinFoto_ = 0;
				if ($('#fotografia').val()=="") {
					sinFoto_ = 1;
					fotografia_ ="Vist/img/cfg_persona_sin-foto.png";
				}else{
				    nucleo.guardarBitacoraPublic("CAMBIO EN LA CONFIGURACIÓN - EL LOGO DE LA INSTITUCIÓN");
		            fotografia_ = $('#fotografia')[0].files[0];
				}
			console.log('GUARDANDO CONFIGURACION : '+sinFoto_);

			var ip_cliente_ = "192.168.1.1";

	        datos.append('accion',accion_);
	        datos.append('id',id_);
	        datos.append('nombre',nombre_);
	        datos.append('ip_cliente',sessionStorage.getItem("ip_cliente-US"));
	        datos.append('id_usuario',sessionStorage.getItem("idUsuario-US"));
	        datos.append('fotografia',fotografia_);
	        datos.append('sinFoto',sinFoto_);

	        $.ajax({
				url: configuracion.urlsPublic().modConfiguracion.api,
				type:'POST',	
	            data:datos,
	            contentType: false,
	            processData: false,
	            beforeSend: function () {
	            	$('#divConfiguracion #form').css("display", "none");
	                $('#divConfiguracion #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (result) {
	            	$('#divConfiguracion #form').css("display", "block");
	                $('#divConfiguracion #procesandoDatosDialg').css("display", "none");
					//console.log(JSON.stringify(result));
					if (result[0].controlError==0) {
						nucleo.alertaExitoPublic(result[0].detalles);
						if (controlVariableG1!=nombre_) {
						    nucleo.guardarBitacoraPublic("EDITO LA CONFIGURACIÓN - NOMBRE DE LA INSTITUCIÓN : DE "+controlVariableG1+" A "+nombre_);    
						}					
 						consultar();
						return true;	                    
					}else{
						nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
						return false;
					};	
	            },
		    	error:  function(error) {
						console.log(JSON.stringify(error));	
			    }
			});
	        //
	        nucleo.reiniciarVariablesGNPublic();
	        //$('#divConfiguracion #form')[0].reset();
			e.preventDefault();
			return false;
		});					
	}

	/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
	*/	
	var consultarAjustesSistema = function() {

		var accion_ = "defaul";
		//
	    $.ajax({
			url: configuracion.urlsPublic().mantenimineto.api,
			type:'POST',	
			data:{	
					accion:accion_,
				},
	        beforeSend: function () {
            	$('#divAjustesSistema #form').css("display", "none");
                $('#divAjustesSistema #procesandoDatosDialg').css("display", "block");
	        },
	        success:  function (data) {
        	  	$('#divAjustesSistema #form').css("display", "block");
                $('#divAjustesSistema #procesandoDatosDialg').css("display", "none");
				console.log(JSON.stringify(data));
				$('#divAjustesSistema #datoControlId').val(data[0].id);
				controlVariableG2 = data[0].frecuencia_suspension;
				$("#divAjustesSistema #frecuenciaSuspencionTxt").val(controlVariableG2); 
				controlVariableG3 = data[0].dias_proximidad_tarea;				
				$("#divAjustesSistema #tiempoProximidadTTxt").val(controlVariableG3); 


				nucleo.activarSuspensionPublic();
				// 
	        },
		    //error:  function(jq,status,message) {
	    	error:  function(error) {
					console.log(JSON.stringify(error));	
		        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
		    }	 
		});
		
	    //
		//e.preventDefault();
		return false;
	}
	/* La funcionalidad Guardar: 
		# Uso : Se usa para guardar y editar
		# Parametros:
						* Se extraen directamente del formulario con Jquery  
						* accion_: Determina la accion a realizaar con la api
	*/		
	var guardarAjustesSistema = function() {
		$("#divAjustesSistema #form").on("submit", function(e){

			// validar de new los campos
			if(nucleo.validadorPublic()==false){
				e.preventDefault();
				return false;
			}

			/* Obtener valores de los campos del formulario*/

			//console.log("guardando...");

			var accion_ = "guardar";
			//
			var frecuencia_suspension_ = $("#frecuenciaSuspencionTxt").val(); 
			if(frecuencia_suspension_<3){
				nucleo.alertaErrorPublic(" Frecuencia: -3 minutos no permitidos ");
				return false;
			}
			if(frecuencia_suspension_>300){
				nucleo.alertaErrorPublic(" Frecuencia: +5 horas no permitidas ");
				return false;
			}			
			var dias_proximidad_tarea_ = $("#divAjustesSistema #tiempoProximidadTTxt").val();
			if(dias_proximidad_tarea_<2){
				nucleo.alertaErrorPublic(" Proximidad: -2 dias no permitidos ");
				return false;
			}
			if(dias_proximidad_tarea_>30){
				nucleo.alertaErrorPublic(" Proximidad: +30 dias no permitidos ");
				return false;
			}	

			//
			var id_ = $('#divAjustesSistema #datoControlId').val();
			if (id_==""){
				id_=0;
			};


			var datos = new FormData();
	        datos.append('accion',accion_);
	        datos.append('id',id_);
	        datos.append('frecuencia_suspension',frecuencia_suspension_);
	        datos.append('dias_proximidad_tarea',dias_proximidad_tarea_);

	        $.ajax({
				url: configuracion.urlsPublic().mantenimineto.api,
				type:'POST',	
	            data:datos,
	            contentType: false,
	            processData: false,
	            beforeSend: function () {
	            	$('#divAjustesSistema #form').css("display", "none");
	                $('#divAjustesSistema #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (result) {
	            	$('#divAjustesSistema #form').css("display", "block");
	                $('#divAjustesSistema #procesandoDatosDialg').css("display", "none");
					//console.log(JSON.stringify(result));
					if (result[0].controlError==0) {
						nucleo.alertaExitoPublic(result[0].detalles);
						if (controlVariableG2!=frecuencia_suspension_) {
						    nucleo.guardarBitacoraPublic("EDITO LA CONFIGURACIÓN - TIEMPO PARA ENTRAR EN ESTADO DE SUSPENSION : DE "+controlVariableG2+" A "+frecuencia_suspension_);    
						}									
						if (controlVariableG3!=dias_proximidad_tarea_) {
						    nucleo.guardarBitacoraPublic("EDITO LA CONFIGURACIÓN - TIEMPO DE PROXIMIDAD PARA AVISAR LAS TAREAS A REALIZAR : DE "+controlVariableG3+"  A "+dias_proximidad_tarea_+" DIAS");    
						}									
						consultarAjustesSistema();
						return true;	                    
					}else{
						nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
						return false;
					};	
	            },
		    	error:  function(error) {
						console.log(JSON.stringify(error));	
			    }
			});
	        //
	        nucleo.reiniciarVariablesGNPublic();
	        //$('#divAjustesSistema #form')[0].reset();
			e.preventDefault();
			return false;
		});					
	}	
	function cargarUrl(input) {
		if (input.files&&input.files[0]) {
			$('#sinImg').css("display","none");
			$('#preViewImg').css("display","block");
		    var reader = new FileReader();
		    reader.onload = function (e) {
		    	$('#preViewImg').attr('src', e.target.result);
		    }		 
		    reader.readAsDataURL(input.files[0]);
		}
	}

	var previsualizarFotografia = function() {
					 
		$(document).on('change','#fotografia',function(){
			if (nucleo.verificarFormatoImagenePublic(this.value)==true) {
				$('#'+this.id).popover('destroy');
			    cargarUrl(this);	
			}else{
				$('#'+this.id).popover({ 
					content: "Error de formato", 
					trigger: "click",
					placement: "bottom"
				});
				$('#'+this.id).popover('show');
			}
		});
		//console.log("carga de previsualizacion de foto");
	}
	var iniciarModulo = function(mod_) {
		switch(mod_){
			case 'c':
				previsualizarFotografia();
				guardar();
				consultar();
			break;
			case 'as':
				guardarAjustesSistema();
				consultarAjustesSistema();
			break;
		}
	}

	/*********************/

	return{
		Iniciar : function() {
			urls();
			datos();
			console.log(" -- Finalizando carga Configuraciones");
		},
		urlsPublic : urls,
		guardarPublic : guardar,
		consultarPublic : consultar,
		iniciarModuloPublic : iniciarModulo,
	} 
}(); 