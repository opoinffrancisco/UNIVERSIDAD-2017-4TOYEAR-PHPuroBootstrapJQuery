	var mtdMantenimientoEquipo = function () {

		/***************************Variables globales*************************/

		var paginaActual = 1; // Pagina actual de la #paginacion
		var paginaActualListEq = 1;
		var paginaActualListEqDpt = 1;
		var tamagno_paginas_ = 7; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
		var consulta = false;
		// -> componentes
		var paginaActualCaractCompoEq = 1;
		// -> perifericos
		var paginaActualCaractPerifEq = 1;
		// -> Software 
		var paginaActualCaractSoftListEq = 1;
		// ------- 
		var paginaActualCaractSoftEq = 1;

		/**********************************************************************/


		var get = function() {
			var variables = {
				consulta : consulta,
			};		
			return variables;
		}

		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";

			var filtro_ = $('#buscardorTxt').val();
			var buscardordesde_ = $('#buscardorDesde').val();
			var buscardorhasta_ = $('#buscardorHasta').val();	


			if (buscardordesde_!="" && buscardorhasta_=="") {
				buscardordesde_="";
			}		
			if (buscardordesde_=="" && buscardorhasta_!="") {
				buscardorhasta_="";
			}					
			//
	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_persona:sessionStorage.getItem("id-US"),										
						filtro:filtro_,
						buscardordesde:buscardordesde_,
						buscardorhasta:buscardorhasta_,
						tamagno_paginas:tamagno_paginas_,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgSolicitud #catalogoDatos").html('');				
			        $("#pngSolicitud #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#ctlgSolicitud #catalogoDatos').append(tr);

	            },
	            success:  function (data) {
		    
		            $("#ctlgSolicitud #catalogoDatos").html('');
		            $("#pngSolicitud #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								/***********************************************/
								var estadoMensaje = "";
								var revisarEstado = "";		
								var colorMensaje = "";
								var btnConsultarDetalles = "";
								var btnAtenderSolicitud = "";	
								//
								switch(datoItem.estado)
									{
										case '0':
											colorMensaje = "background: #FFEB3B;";
											estadoMensaje = "EN ESPERA";
											//revisarEstado = 'disabled="TRUE" ';
											btnConsultarDetalles = '<button type="button" class="btn btn-default detallesBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.detallesPublic('+datoItem.id_solicitud+',1)" style="width: 50%;">Detalles</button>';
											btnAtenderSolicitud = '<button type="button" class="btn btn-default atenderBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.consultarPublic(&#39;'+datoItem.asunto+'&#39;,'+datoItem.id_solicitud+','+datoItem.estado+')" style="width: 50%;"  >Atender</button>';
										break;
										case '1':		
											colorMensaje = "background:  rgba(78, 171, 251, 0.68);";										
											estadoMensaje = "ATENDIENDO";
											//revisarEstado = 'onclick="mtdEquipo.consultarEstado('+datoItem.id+')"';											
											btnConsultarDetalles = '<button type="button" class="btn btn-default detallesBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.detallesPublic('+datoItem.id_solicitud+',1)" style="width: 50%;">Detalles</button>';
											btnAtenderSolicitud = '<button type="button" class="btn btn-default atenderBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.consultarPublic(&#39;'+datoItem.asunto+'&#39;,'+datoItem.id_solicitud+','+datoItem.estado+')" style="width: 50%;"  >Atender</button>';											
										break;
										case '2':		  
											colorMensaje = "background: rgba(38, 247, 41, 0.61);";
											estadoMensaje = "ATENDIDO";
											//revisarEstado = 'onclick="mtdEquipo.consultarEstado('+datoItem.id+')"';											
											btnConsultarDetalles = '<button type="button" class="btn btn-default detallesBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.detallesPublic('+datoItem.id_solicitud+',1)" style="width: 100%;">Detalles</button>';
											btnAtenderSolicitud = '';											
										break;																				
										case '3':		
											colorMensaje = "background:  rgba(78, 171, 251, 0.68);border: 1px solid red;color: red; ";
											estadoMensaje = "ATENDIENDO";
											//revisarEstado = 'onclick="mtdEquipo.consultarEstado('+datoItem.id+')"';											
											btnConsultarDetalles = '<button type="button" class="btn btn-default detallesBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.detallesPublic('+datoItem.id_solicitud+',1)" style="width: 50%;">Detalles</button>';
											btnAtenderSolicitud = '<button type="button" class="btn btn-default atenderBtnDiv" id="btnDetalles" onclick="mtdMantenimientoEquipo.consultarPublic(&#39;'+datoItem.asunto+'&#39;,'+datoItem.id_solicitud+','+datoItem.estado+')" style="width: 50%;"  >Atender</button>';											
										break;

									}				
								/***********************************************/
								// Verificar que no sea un persona vinculada con la solicitud:
								// solicitante o responsable con Perfil de usuario TECNICO
								var id_persona_sesion = sessionStorage.getItem('id_persona-US');
								if (id_persona_sesion==datoItem.id_persona || 
									id_persona_sesion==datoItem.id_persona_asignada
								 ) {
									btnAtenderSolicitud='';
								};

								tr = $('<tr class="row " >'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
										'<textarea disabled="true" style="background:transparent; resize:vertical;   margin-top: 0px; margin-bottom: 0px; height: 35px; width: 100%; border: 0px; overflow-y: hidden;">'+
											datoItem.asunto+
										'</textarea>'+									
									'</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+
										'<div style="width: 100%;height: 50%;">'+
											'<div class="row">'+
												'<div class="col-md-3" style="border-bottom: 1px solid #bfbfbf; padding: 0px;">'+
													'S : '+
												'</div>'+
												'<div class="col-md-9" style="border-bottom: 1px solid #bfbfbf;">'+
													datoItem.serial+
												'</div>'+
											'</div>'+
										'</div>'+
										'<div style="width: 100%;height: 50%;">'+
											'<div class="row">'+
												'<div class="col-md-3" style="padding: 0px;">'+
													'B.N. : '+
												'</div>'+
												'<div class="col-md-9">'+
													datoItem.serial_bn+
												'</div>'+
											'</div>'+
										'</div>'+
									'</td>'+						
									'<td style=" padding: 5px; text-align: center;vertical-align:middle; " class="col-md-2">'+
										'<div class="btn-group" role="group" style="width: 100%; '+colorMensaje+'">'+
											estadoMensaje+
										'</div>'+
									'</td>'+									
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-1">'+datoItem.fecha+'</td>'+						
									'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
										'<div class="btn-group" role="group" style="width: 100%;">'+
											btnConsultarDetalles+											
											btnAtenderSolicitud+										
										'</div>'+
									'</td>'+							
								'</tr>');
								$('#ctlgSolicitud #catalogoDatos').append(tr);

							});
							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.paginaControlPublic('+dato.pagAnterior+')" aria-label="Previous">'+
													'<span aria-hidden="true">&laquo;</span>'+					      
												'</a>'+
											'</li>'	
										);
							}
							//paginas
							if (dato.pagActual>=1) {	

								if (dato.total_paginas>1) {
									for (var i=1; i <= dato.total_paginas ; i++) { 

										if(i==dato.pagActual) {
											ul.append(
														"<li class='active'>"+
															"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.paginaControlPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.paginaControlPublic("+i+")' >"+ i +"</a>"+
														"</li>" 
													);
										}
									}
								};
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.paginaControlPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pngSolicitud #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(3);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="6" style="text-align: center;">No hay solicitud de mantenimiento realizada o visible para usted</td>');
							tr.append("</tr>");
							$('#ctlgSolicitud #catalogoDatos').append(tr);							
					}
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}
		/*
			cargar lista de  diagnosticos de la solicitud
		*/
		var cargarListaDiagnosticosSolt = function() {

			// Iniciando variables
			var accion_ = "cargarListaDiagnosticosSolt";

			panelTabs.cambiarModalPulico('procesos/mantenimientoEquipo/catalogos/ctlgGestionMantenimientoEquipo-diagnosticosSolicitud.php', '',datosIdsTabs=['tabObservarDiagnostico','tabObservarRealizado'],'catalogoModalSolicitud');

			var id_solicitud_ = $('#vtnMantenimientoEquipo #datoControlIdSolicitud').val();

		    setTimeout(function(){ 

		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api ,
					type:'POST',	
					data:{	
							accion:accion_,
							id_solicitud:id_solicitud_,					
						},
		            beforeSend: function () {

				        $("#ctlgDiagnosticosSolicitud #catalogoDatos").html('');				
						var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
						$('#ctlgDiagnosticosSolicitud #catalogoDatos').append(tr);

		            },
		            success:  function (data) {
			    
			            $("#ctlgDiagnosticosSolicitud #catalogoDatos").html('');
						console.log(JSON.stringify(data));
		    	        //var cantResultados = Object.keys(data.resultados).length;
		                if (data.controlError==0) {
							$(data).each(function (index, dato) {
								console.log(dato);
			    				$(dato.resultados).each(function (index, datoItem) {                				   

							tr = $('<div style=" text-align: center;vertical-align:middle;padding: 4px;border: 1px solid #ccc;" class="col-md-12">'+
										datoItem.observacion+
									'</div>');
								
									$('#ctlgDiagnosticosSolicitud #catalogoDatos').append(tr);
								});

							});
						}else{
								tr = $('<div style=" text-align: center;vertical-align:middle;padding: 4px;border: 1px solid #ccc;" class="col-md-12"> No se han realizado diagnosticos </div>');
								$('#ctlgDiagnosticosSolicitud #catalogoDatos').append(tr);							
						}
		            },
				    //error:  function(jq,status,message) {
			    	error:  function(error) {
							console.log(JSON.stringify(error));
							alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
				    }	            
				});

			}, 500);
			return false;
		}		
		var cargarListaTareasEquipoSolicitud = function(_pagina_) {

			panelTabs.cambiarModalPulico('procesos/mantenimientoEquipo/catalogos/ctlgGestionMantenimientoEquipo-tareasSolicitud.php','',datosIdsTabs=['tabObservarRealizado','tabObservarDiagnostico'],'catalogoModalSolicitud');

			var accion_ = "cargarListaTareasEquipoSolicitud";
			var id_equipo_ = $("#vtnMantenimientoEquipo #datoControlIdEquipo").val();
			//
		    setTimeout(function(){ 

		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							id_equipo:id_equipo_,	
						},
		            beforeSend: function () {

				        $("#ctlgTareasEquipoSolicitud #catalogoDatos").html('');				
						tr = $('<tr>');
						tr.append('<td colspan="7" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgTareasEquipoSolicitud #catalogoDatos').append(tr);
		            },
		            success:  function (data) {
   				        $("#ctlgTareasEquipoSolicitud #catalogoDatos").html('');				
						console.log(JSON.stringify(data));
		    	        //var cantResultados = Object.keys(data.resultados).length;
		                if (data.controlError==0) {
							$(data).each(function (index, dato) {
							//Obteniendo resultados para catalogo

			    				$(dato.resultados).each(function (index, datoItem) {                				   
			   
			    					var estado = datoItem.estado_uso;							
			    					var estado_de_uso =  "";
			    					var observacion = (datoItem.observacion!=null)? datoItem.observacion :"";
			    					var inicio = (datoItem.inicio!=null)? datoItem.inicio :"";
			    					var final = (datoItem.final!=null)? datoItem.final :"";
			    					var cssTextArea ;
			    					//_________________________

									var  id_tarea_equipo=datoItem.id_tarea_equipo;

			    					//__________________________


			    					if (estado==1) {
			    						estado_de_uso = "INICIADO";
			    						estado = 0;
										var btnAccionEstadoUso =	'	<div class="btn-group iniciarFinalizarTareaBtnDiv" role="group" style="width: 100%;">'+
																	'	<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdMantenimientoEquipo.cambiarEstadoTareaEquipoPublic('+datoItem.id_mantenimiento+','+datoItem.id_tarea_equipo+','+estado+',1);" style="width: 100%;border-radius:  0px 5px 5px 0px  ;">Finalizar</button>'+
																	'	</div>';
										cssTextArea="none";						
			    					} else {
			    						estado = 1;

			    						estado_de_uso = "SIN INICIAR";
										var btnAccionEstadoUso =	'	<div class="btn-group iniciarFinalizarTareaBtnDiv" role="group" style="width: 100%;">'+
																	'		<button type="button" class="btn btn-default" id="btnDetalles" onclick="$(this).attr(&#39;disabled&#39;,true),mtdMantenimientoEquipo.cambiarEstadoTareaEquipoPublic('+datoItem.id_mantenimiento+','+datoItem.id_tarea_equipo+','+estado+',0);" style="width: 100%;border-radius:  0px 5px 5px 0px  ;">Iniciar</button>'+
																	'	</div>';						
										cssTextArea="none";						
			    					}
			    					if (observacion!="") {
			    						estado_de_uso = "FINALIZADO";
										var btnAccionEstadoUso =	'	<div class="btn-group iniciarFinalizarTareaBtnDiv" role="group" style="width: 100%;">'+
																	'		<button type="button" class="btn btn-default" id="btnDetalles" onclick="$(this).attr(&#39;disabled&#39;,true),mtdMantenimientoEquipo.cambiarEstadoTareaEquipoPublic('+datoItem.id_mantenimiento+','+datoItem.id_tarea_equipo+','+estado+',0);" style="width: 100%;border-radius:  0px 5px 5px 0px  ;">Repetir</button>'+
																	'	</div>';			    						
										cssTextArea="vertical";																							
			    					}



		    						var colorDiasProximos = "";
		    						var diasMuestraProximidad=0;
			    					var resultadoCalculoMayorMenor = datoItem.resultadoCalculoMenorQueProximidad;
			    					if (resultadoCalculoMayorMenor==1 || resultadoCalculoMayorMenor==true) {
			    						// Color Amarillo si paso la fecha limite
			    						colorDiasProximos = " background: #FFEB3B; ";
			    						diasMuestraProximidad = datoItem.dias_restantes+' días';
			    					}else{
		    							// Color verdes si falta para llegar a la fecha limite
			    						colorDiasProximos = " background: rgba(38, 247, 41, 0.61); ";
			    						diasMuestraProximidad = datoItem.dias_restantes+' días';		    						
			    					};
		    						// Color rojo si se paso la fecha limite
			    					if (datoItem.control_vencimiento_fecha==1) {
			    						colorDiasProximos = " background: rgba(241, 36, 0, 0.58); ";
			    						diasMuestraProximidad = datoItem.dias_restantes+' días';		    						
			    					};
	
									if (datoItem.tarea_correctiva==1) {
			    						colorDiasProximos = " white ";
			    						diasMuestraProximidad = "NO APLICA";
									};


									tr = $('<tr class="row" >'+

										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+
											datoItem.tarea+
										'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											'<textarea disabled="true" style="background:transparent; resize:'+cssTextArea+';   margin-top: 0px; margin-bottom: 0px; height: 35px; width: 100%; border: 0px; overflow-y: hidden;">'+
												observacion+
											'</textarea>'+
										'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+
										'	<div style="width: 100%;height: 50%;">'+
										'		<div class="row">'+
										'			<div class="col-md-6" style="border-right: 1px solid #bfbfbf;border-bottom: 1px solid #bfbfbf;">'+
										'				INICIAL: '+
										'			</div>'+
										'			<div class="col-md-0" style="border-bottom: 1px solid #bfbfbf;">'+
														inicio+
										'			</div>'+
										'		</div>'+
										'	</div>'+
										'	<div style="width: 100%;height: 50%;">'+
										'		<div class="row">'+
										'			<div class="col-md-6" style="border-right: 1px solid #bfbfbf;">'+
										'				FINAL: '+
										'			</div>'+
										'			<div class="col-md-0">'+
														final+
										'			</div>'+
										'		</div>'+
										'	</div>'+
										'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-1">'+
											'<div class="btn-group" role="group" style="width: 100%; '+colorDiasProximos+'"><b>'+diasMuestraProximidad+'</b></div>'+
										'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-1">'+estado_de_uso+'</td>'+
										'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											btnAccionEstadoUso+
										'</td>');

									tr.append("</tr>");

									$('#ctlgTareasEquipoSolicitud #catalogoDatos').append(tr);
								});
							});
							nucleo.asignarPermisosBotonesPublic(3);	
						}else{
								tr = $('<tr>');
								tr.append('<td colspan="7" style="text-align: center;"> No Hay tareas programadas para el equipo </td>');
								tr.append("</tr>");
								$('#ctlgTareasEquipoSolicitud #catalogoDatos').append(tr);
						}
		            },
			    	error:  function(error) {
						console.log(JSON.stringify(error));	
						alertas.dialogoErrorPublic(error.readyState,error.responseText);						
				    }	            
				});

			}, 500);
	        //
			return false;
		}
		var id_tarea_equipoG=0;
		var id_mantenimientoG=0;
		var _estadoG=0;
		var _observacionG=0;
		/*
			ciambia el estado a Iniciado al darle (Iniciar) a Sin Iniciar(al darle finalizar)
			
			variables globales, definidas arriba de la funcion
		*/
		var cambiarEstadoTareaEquipo = function(id_mantenimiento_, id_tarea_equipo_,_estado_,_observacion_) {
			var accion_ = "cambiarEstadoTareaEquipo";
			var datoAccionado="";
			var id_solicitud_ = $('#datoControlIdSolicitud').val();
			//
			switch(_observacion_) {
				case 0:
		    		datoAccionado = "INICIO";
				break;
			    case 1:
						//----------
						id_tarea_equipoG = id_tarea_equipo_;
						_estadoG = _estado_;
						id_mantenimientoG = id_mantenimiento_;
						//----------
						ventanaModal.cambiaMuestraVentanaModalCapa2Public("procesos/mantenimientoEquipo/ventanasModales/vtnMGestionMantenimientoEquipo-finalizarTarea.php",1,1);				
						$('#vtnFinalizarTarea #observacionTxt').val('');
						return false;
			        break;
			    case 2:
			    		datoAccionado = "FINALIZO";

						id_tarea_equipo_  = id_tarea_equipoG;
						id_mantenimiento_ = id_mantenimientoG;						
						_estado_          = _estadoG ;
						_observacion_ 	  = $('#vtnFinalizarTarea #observacionTxt').val().toUpperCase();
						var observacionControl_ = _observacion_;
						if (observacionControl_.trim()!=""){
							if (_observacion_.length>255) {
								nucleo.alertaErrorPublic("La observación tiene :"+_observacion_.length+" caracteres, máximo 255 ");
								return false;
							}
							if(_observacion_.length<15){
								nucleo.alertaErrorPublic("La observación tiene :"+_observacion_.length+" caracteres, minimo 15 ");
								return false;
							};
						}else{
							nucleo.alertaErrorPublic(" Ingresar observación");
							return false;
						}
			        break;
			    default:
			} 

	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),
						estado_uso:_estado_,
						id_mantenimiento:id_mantenimiento_,
						id_solicitud:id_solicitud_,
						id_tarea_equipo:id_tarea_equipo_,
						observacion:_observacion_,
					},
	            beforeSend: function () {
					$('#vtnFinalizarTarea #form').css("display", "none");
					$('#vtnFinalizarTarea #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (data) {
	            	console.log(JSON.stringify(data));
					mtdMantenimientoEquipo.cargarListaTareasEquipoSolicitudPublic(1);

					var serial_equipo = $('#vtnMantenimientoEquipo #serialEqTxt').val();	
					var detalles_ = "";
					var estadoEjecucion=0;

					if (_observacion_==0) {
						estadoEjecucion = 19;
						detalles_ = datoAccionado+" LA TAREA :'"+data[0].nombreTarea+"' AL EQUIPO CON EL SERIAL :"+serial_equipo;
						nucleo.guardarBitacoraPublic(detalles_);
					}else{
						estadoEjecucion = 20;
						detalles_ = datoAccionado+" LA TAREA :'"+data[0].nombreTarea+"' AL EQUIPO CON EL SERIAL :"+serial_equipo+" - Y OBSERVO QUE :"+_observacion_;
						nucleo.guardarBitacoraPublic(detalles_);
					};									

					/*
						PARAMETROS:
							1 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
							2 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							3 - ID_MANTENIMIENTO 
					*/
					nucleo.guardarPersonaEjecutaTareaPPublic(data[0].nombreTarea,estadoEjecucion,data[0].id_mantenimiento);					
					ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2');
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}	

		/*
			Mostrar edicion o tipico Consultar

		*/
		var detalles = function (id_solicitud_,_tipoCapa_) {

			consulta=true;
			if(_tipoCapa_==1){
				ventanaModal.cambiaMuestraVentanaModalPublic("procesos/solicitud/ventanasModales/vtnMGestionSolicitud.php",1,1);
			}else{
				id_solicitud_ = $('#datoControlIdSolicitud').val();
				ventanaModal.cambiaMuestraVentanaModalCapa2Public("procesos/solicitud/ventanasModales/vtnMGestionSolicitud.php",1,1);
				$('.cerrarSolicitud').attr('onclick', "ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2')");				
			}
			var accion_ = "consultar";
			
			//console.log("verificando: "+id_departamento_);
			//
	        $.ajax({
					url: configuracion.urlsPublic().solicitud.api,
					type:'POST',	
					data:{
							accion:accion_,
							id_solicitud:id_solicitud_, 
							},
	            beforeSend: function () {

					$('#vtnSolicitud #form').css("display", "none");
					$('#vtnSolicitud #procesandoDatosDialg').css("display", "block");
					$('#equiposSolicitanteList').html('');
					$('#pgnEquiposSolicitanteList #pagination').html('');		
	            },
	            success:  function (data) {

	            	$('#btnSolicitar').css('display', 'none');
	            	$('#pestañasEquiposSolicitud').css('display', 'none');

					console.log(JSON.stringify(data));
					setTimeout(function(){ 

						$(data).each(function (index, dato) {
	
		    				$(dato.resultado).each(function (index, datoItem) {   
										/***************************************/
													$('.datos-solicitante').css('display', 'block');
													// DATOS DEL SOLICITANTE
													$('#cedulaTxt').val(datoItem.cedulaPersona);
													$('#nombreApellidoTxt').val(datoItem.nombreApellidoPersona);
													$('#cargoTxt').val(datoItem.cargoPersona);
													$('#departamentoTxt').val(datoItem.departamentoPersona);	
													$('#correoTxt').val(datoItem.correo);	
													if(datoItem.fotoPersona){
														$('#sinImg').css("display","none");
														$('#preViewImg').css("display","block");
														$('#preViewImg').attr("src", datoItem.fotoPersona);
													};

										/***************************************/
						    					//-> Si el solicitantes es la misma persona asginada al equipo -> NO se activa el siguiente panel
												if (datoItem.id_persona_asignada!='') {
							    					$('.datos-persona-asignada').css('display', 'block');
													// DATOS DE LA PERSONA ASIGNADA AL EQUIPO
													$('#cedulaTxtPA').val(datoItem.cedulaPersona_pa);
													$('#nombreApellidoTxtPA').val(datoItem.nombreApellidoPersona_pa);
													$('#cargoTxtPA').val(datoItem.cargoPersona_pa);
													$('#departamentoTxtPA').val(datoItem.departamentoPersona_pa);	
													$('#correoTxtPA').val(datoItem.correo_pa);	
													if(datoItem.fotoPersona_pa){
														$('#sinImgPA').css("display","none");
														$('#preViewImgPA').css("display","block");
														$('#preViewImgPA').attr("src", datoItem.fotoPersona_pa);
													};												

												};

										/***************************************/
		    					$('.abrir-panel-datos').css('display', 'block');
		    					//		    					
		    					$('.datos-solicitante').css('display', 'block');


		    					$('#btnConformidad').data('id_solicitud', datoItem.id_solicitud);
		
												if (datoItem.estado_equipo==1) {

													var btn = $('<div class="lista-equipo-solt list-group-item lista-equipo-solt-SELECT" id=""  style="padding: 2px;">'+
														'<table style="margin:0px;">'+
															'<tr class="row"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo+'</td></tr>'+
															'<tr class="row"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial+'</td></tr>'+
															'<tr class="row"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn+'</td></tr>'+
														'</table>'+
														'</div>');
													$('#equiposSolicitanteList').append(btn);

												}else{
													var btn = $('<div class="list-group-item"  style="padding: 2px; background:#f2dede;">'+
														'<table style="margin:0px;">'+
															'<tr class="row"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo+'</td></tr>'+
															'<tr class="row"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial+'</td></tr>'+
															'<tr class="row"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn+'</td></tr>'+
															'<tr class="row"><td class="col-md-5"><b> Estado : </b></td><td>  DESINCORPORADO  </td></tr>'+
														'</table>'+
														'</div>');
													$('#equiposSolicitanteList').append(btn);

													$('#equipoSolicitudDanado').css('display','block');

													if (datoItem.serial_enuevo!='') {
														var btn2 = $('<div class="list-group-item"  style="padding: 2px; background:blanchedalmond;">'+
															'<table style="margin:0px;">'+
																'<tr class="row"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo_enuevo+'</td></tr>'+
																'<tr class="row"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial_enuevo+'</td></tr>'+
																'<tr class="row"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn_enuevo+'</td></tr>'+
																'<tr class="row"><td class="col-md-5"><b> Estado : </b></td><td> NUEVO EQUIPO ASIGNADO.</td></tr>'+
															'</table>'+
															'</div>');
														$('#equiposSolicitanteList').append(btn2);
													};
												}
												//
												$('#asuntoTxt').val(datoItem.asunto);
												$('#asuntoTxt').attr('disabled', true);
												$('#descripcionTxt').val(datoItem.descripcion);
												$('#descripcionTxt').attr('disabled', true);								
												$('#fechaSolicitado').html('<b> Solicitado el </b> : '+datoItem.fecha);
												//-> Comienzo de atencion
												if (datoItem.fecha_desde!="0000-00-00 00:00:00") {
													$('#atencionSolicitud').html('<b> Atención comenzada el </b> : '+datoItem.fecha_desde);
													$('#atencionSolicitud').css('display' , 'block');
												}
												//-> respuesta
												if (datoItem.id_respuesta>0) {
													$('#mensajeRespuesta #observacionTxt').html('');
													$('#mensajeRespuesta #observacionTxt').html(datoItem.respuestaObservacion);
													$('#respuestaFecha').html('<b> Respondida el </b> : '+datoItem.respuestaFecha);
													$('#mensajeRespuesta').css('display' , 'block');
													//-> conformidad -> si ya hay una respuesta se necesita saber si esta conforme el usuario

													if (datoItem.estado_equipo>0) {
														$('#mensajesConformidad').css('display', 'block');
									    				if (datoItem.conformidades!="") {
									    					var estadoConfor = 0;
									    					var estadoAtencionConfor = 0;
									    					var fechaConformidadAceptada ="";
										    				$(datoItem.conformidades).each(function (index, datoConfor) {   
																if (datoConfor.estado>0) {
																	estadoConfor=1;	
																	fechaConformidadAceptada = datoConfor.fecha;
																}else{
											    					$('#listaConformidades').css('display', 'block');												
											    					var item = $('<div class="row" style="background: rgba(216, 216, 216, 0.63); border: 1px solid #ccc;">'+
																					'<div class="col-md-12">'+
																						'<div class="form-group">'+
																										'<div id="fechaConformidad"><b> Fecha : </b>'+datoConfor.fecha+'</div>'+												
																					   '<textarea type="text" class="form-control" disabled="TRUE" >'+datoConfor.observacion+'</textarea>'+
																						'</div>'+						
																					'</div>'+				
																				'</div>');
																	if (datoConfor.estado_atencion>0) {
																		estadoAtencionConfor=1;	
																	}else{
																		estadoAtencionConfor=0;		
																	}					    					
																	$('#listaConformidades #contenido').append(item);
																}
										    				});
										    				console.log('estadoConfor :'+estadoConfor+' estadoAtencionConfor:'+estadoAtencionConfor);
										    				//-> ya esta conforme el usuario solicitante.?
															if (estadoConfor>0) {
																$('#conformidadOpciones').css('display', 'none');
																$('#btnConformidad').css('display', 'none');																					
																$('#conformidad').html('');
																$('#conformidad').html('¿ El solicitante se encuentra conforme con el servicio reciente ?');																																								
																$('#conformidad').css('display', 'block');													
																$('#conformidadAceptada').html('');	
																$('#conformidadAceptada').html('Si');		
																$('#conformidadAceptada').css('display', 'block');
																$('#fechaConformidadAceptada').html('Aprobó el servicio el: '+fechaConformidadAceptada);													
																$('#fechaConformidadAceptada').css('display', 'block');											
																$('#conformidadAtencion').html('');														
																$('#conformidadAtencion').css('display', 'none');											
															}else{
																// -> fue atendida la actual inconformidad ?
																if (estadoAtencionConfor>0) {																		
																	$('#conformidadAceptada').css('display', 'none');																
																	$('#conformidadAtencion').html('');														
																	$('#conformidadAtencion').html('La ultima inconformidad fue atendida');		
																	$('#conformidadAtencion').css('display', 'block');													
																	$('#conformidadOpciones').css('display', 'none');
																	$('#btnConformidad').css('display', 'none');			
																}else{
																	$('#conformidad').css('display', 'none');													
																	$('#conformidadAceptada').css('display', 'none');														
																	$('#conformidadOpciones').css('display', 'none');
																	$('#btnConformidad').css('display', 'none');														
																	$('#conformidad').html('');														
																	$('#conformidadAtencion').html('');		
																	$('#conformidadAtencion').html('Tecnicos atendiendo actual inconformidad');		
																	$('#conformidadAtencion').css('display', 'block');	
																}					    				
															}
										    			}else{
															$('#mensajesConformidad').css('display', 'none');
										    			}
													}else{
														$('#mensajesConformidad').css('display', 'none');
														if (datoItem.conformidades!="") {
															$('#confirmarEquipoRecibido').css('display', 'block');
										    				$(datoItem.conformidades).each(function (index, datoConfor) {   
																if (datoConfor.estado>0) {
																	$('#confirmarEquipoRecibido #conformidad').text(datoConfor.observacion+', el : '+datoConfor.fecha);
																	$('#confirmarEquipoRecibido #conformidadOpciones').css('display','none');
																	$('#confirmarEquipoRecibido #btnConformidad').css('display','none');																	
																}
										    				});
														}
													}
												}else{
													$('#mensajesConformidad').css('display', 'none');
												}

								consulta = false;

								if (datoItem.estado_solt==2){
									$('#mensajeFinalizacion').css('display', 'block');
									$('#fechaCierre').html('<b>Fecha de cierre de solicitud :</b> '+datoItem.fecha_cierre);									

									if(datoItem.observacion_extra!='') {
										$('#lbObservacionFinal').css('display', 'block');									
										$('#mensajeFinalizacionTxt').css('display', 'block');									
										$('#mensajeFinalizacionTxt').val(datoItem.observacion_extra);
									};
								}
							});
			    		});
	
						$('#vtnSolicitud #form').css("display", "block");
						$('#vtnSolicitud #procesandoDatosDialg').css("display", "none");
					},300);

	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}
		/*
			Mostrar edicion o tipico Consultar

		*/
		var consultar = function (_asunto_,id_solicitud_,_estado_) {

			consulta=true;
			ventanaModal.cambiaMuestraVentanaModalPublic('procesos/mantenimientoEquipo/ventanasModales/vtnMGestionMantenimientoEquipo.php',1,1);
			var accion_ = "consultar";
			if (_estado_==0) {
				_estado_=1;
				mtdMantenimientoEquipo.cambiarEstadoPublic("INICIO ATENCIÓN DE LA SOLICITUD : '"+_asunto_+"'",id_solicitud_,_estado_);
			}				
			//
	        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{
							accion:accion_,
							id_solicitud:id_solicitud_, 
							},
	            beforeSend: function () {

					$('#vtnMantenimientoEquipo #form').css("display", "none");
					$('#vtnMantenimientoEquipo #procesandoDatosDialg').css("display", "block");

	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					$(document).ready(function() {

						$(data).each(function (index, dato) {
		    				$(dato.resultado).each(function (index, datoItem) {   

		    					//setTimeout(function () {
		    						var controlBlock = false;
			    					if (datoItem.estado_equipo==0) {
										$('#btnGestionarEquipo').attr('disabled', true);
										$('#panel-acciones-mantenimiento').css('display', 'none');
										$('#lbMensajeDesincorpora').css('display', 'block');	
										if (datoItem.esverificadoLaasignacion==false) {
											$('#lbMensajeConformidad').html('Se necesita asignar un equipo disponible, al solicitante');	
											$('#lbMensajeConformidad').css('color', 'red');											
											$('#btnRespuesta').attr('disabled', true);
										}else{
											$('#lbMensajeConformidad').html('Se necesita avisar al solicitante, que se le entregara el nuevo equipo asignado');	
											$('#lbMensajeConformidad').css('color', 'green');											
										};														
			    					}
			    					if (datoItem.respuesta!=null) {									
										$('#btnRespuesta').attr('disabled', true);
										$('#lbMensajeRespuesta').css('color', 'red');
										$('#fechaRespuesta').html(' el : '+datoItem.respuestaFecha);
			    						//$('#btnFinalizarMantenimiento').attr('disabled', true);				    				

										controlBlock=false;	

										if (datoItem.estado_equipo>0) {
											if (datoItem.conformidades!="") {
												$('#lbMensajeConformidad').html('');											
							    				$(datoItem.conformidades).each(function (index, datoConfor) {   
													if (datoConfor.estado>0) {
															$('#lbMensajeConformidad').html('Solicitante conforme | ');	
															$('#lbMensajeConformidad').css('color', 'green');
															$('#lbMensajeRespuesta').css('color', 'green');	
								    						//$('#btnFinalizarMantenimiento').attr('disabled', false);				    																									
															controlBlock=true;	
													}else{
														controlBlock=false;
														$('#lbMensajeConformidad').html('Solicitante inconforme | ');
														$('#lbMensajeConformidad').css('color', 'red');
								    					if (datoConfor.estado_atencion==0) {
								    						controlBlock=false;
															$('#btnAtenderConformidad').css('display', 'block');													
															$('#btnAtenderConformidad').data('id_conformidad', datoConfor.id_conformidad);													
															$('#btnAtenderConformidad').data('observacion', datoConfor.observacion);													

														}else{
															controlBlock=true;
															$('#lbMensajeConformidad').html('');
															$('#lbMensajeConformidad').html('Atendida la inconformidad | ');
															$('#lbMensajeConformidad').css('color', 'green');
															$('#lbMensajeRespuesta').css('color', 'green');		
															$('#btnAtenderConformidad').css('display', 'none');
														}					    					
													}
							    				});
							    			}else{
												$('#lbMensajeConformidad').css('color', 'red');	
												$('#btnGestionarEquipo').attr('disabled', true);
												$('#panel-acciones-mantenimiento').css('display', 'none');												
							    			}	
							    		}else{
											$('#lbMensajeConformidad').html('Esperando confirmación de entrega |');	
							    			if (datoItem.conformidades!="") {
												$('#lbMensajeConformidad').html('');											
							    				$(datoItem.conformidades).each(function (index, datoConfor) {   
													if(datoConfor.estado>0) {
														$('#lbMensajeConformidad').html('El equipo asignado ha sido recibido');	
														$('#lbMensajeConformidad').css('color', 'green');
														$('#lbMensajeRespuesta').css('color', 'white');	
							    						//$('#btnFinalizarMantenimiento').attr('disabled', false);				    																									
														controlBlock=true;	
													}
							    				});
							    			}else{
												$('#lbMensajeConformidad').css('color', 'red');	
												$('#btnGestionarEquipo').attr('disabled', true);
												$('#panel-acciones-mantenimiento').css('display', 'none');												
							    			}	
							    		}
			    					}else{
			    						//$('#btnFinalizarMantenimiento').attr('disabled', true);
			    					}
			    					if (controlBlock==true) {
										$('#btnGestionarEquipo').attr('disabled', true);
										$('#panel-acciones-mantenimiento').css('display', 'none');		    									    						
			    					}
			    					$('#fechaSolicitadoDate').val(datoItem.fecha);
			    					$('#fechaAtendiendoDate').val(datoItem.fecha_desde);

			    					$('#datoControlIdSolicitante').val(datoItem.id_persona);
			    					$('#datoControlIdSolicitud').val(datoItem.id_solicitud);
			    					$('#datoControlIdEquipo').val(datoItem.id_equipo);

			    					$('#detallesCortoEquipo').val(datoItem.tipo+' - '+datoItem.marcaymodelo);	    					
			    					$('#serialEqTxt').val(datoItem.serial);
			    					$('#serialBNEqTxt').val(datoItem.serial_bn);
			    				//}, 500);
								consulta = false;
							});
			    		});

					});
					$('#vtnMantenimientoEquipo #form').css("display", "block");
					$('#vtnMantenimientoEquipo #procesandoDatosDialg').css("display", "none");
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}

		/*
			Mostrar edicion o tipico Consultar

		*/
		var consultarPeriferico = function () {

			ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/cambiar/periferico/vtnMGestionEquipoDetalles-cambiarPeriferico.php',1,1);
			//
			var accion_ = "consultarPeriferico";
			var id_periferico_ = $('#btnCambiarPeriferico').data('id_periferico');
	        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{
							accion:accion_,
							id_periferico:id_periferico_, 
							},
	            beforeSend: function () {

					$('#vtnCambiarPeriferico #form').css("display", "none");
					$('#vtnCambiarPeriferico #procesandoDatosDialg').css("display", "block");

	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
	    				$(dato.resultado).each(function (index, datoItem) {   

	    					setTimeout(function () {

								$('#vtnCambiarPeriferico #datoControlIdEquipoCambio').val(datoItem.id_equipo);
								$('#vtnCambiarPeriferico #datoControlIdCambio').val(datoItem.id_periferico);

		    					$('#vtnCambiarPeriferico #tipotxtActual').val(datoItem.tipo);
		    					$('#vtnCambiarPeriferico #marcatxtActual').val(datoItem.marca);
		    					$('#vtnCambiarPeriferico #modelotxtActual').val(datoItem.modelo);
		    					$('#vtnCambiarPeriferico #interfazConexionTxtActual').val(datoItem.interfaz_conexion);
		    					$('#vtnCambiarPeriferico #serialTxtActual').val(datoItem.serial);
		    					$('#vtnCambiarPeriferico #serialBienNacionalTxtActual').val(datoItem.serial_bn);

								$('#vtnCambiarPeriferico #form').css("display", "block");
								$('#vtnCambiarPeriferico #procesandoDatosDialg').css("display", "none");
		    					
	    					}, 500);
						});
		    		});
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}
		var consultarComponente = function () {

			ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/cambiar/componente/vtnMGestionEquipoDetalles-cambiarComponente.php',1,1);
			//
			var accion_ = "consultarComponente";
			var id_componente_ = $('#btnCambiarComponente').data('id_componente');
	        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{
							accion:accion_,
							id_componente:id_componente_, 
							},
	            beforeSend: function () {

					$('#vtnCambiarComponente #form').css("display", "none");
					$('#vtnCambiarComponente #procesandoDatosDialg').css("display", "block");

	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
	    				$(dato.resultado).each(function (index, datoItem) {   

	    					setTimeout(function () {

								$('#vtnCambiarComponente #datoControlIdEquipoCambio').val(datoItem.id_equipo);
								$('#vtnCambiarComponente #datoControlIdCompoCambio').val(datoItem.id_componente);

		    					$('#vtnCambiarComponente #capacidadtxtActual').val(datoItem.capacidad);
		    					$('#vtnCambiarComponente #tipotxtActual').val(datoItem.tipo);
		    					$('#vtnCambiarComponente #marcatxtActual').val(datoItem.marca);
		    					$('#vtnCambiarComponente #modelotxtActual').val(datoItem.modelo);
		    					$('#vtnCambiarComponente #serialTxtActual').val(datoItem.serial);
		    					$('#vtnCambiarComponente #serialBienNacionalTxtActual').val(datoItem.serial_bn);
		    					mtdMantenimientoEquipo.cargarListaCaractInterfacesPublic(datoItem.id_caracteristicas);

								$('#vtnCambiarComponente #form').css("display", "block");
								$('#vtnCambiarComponente #procesandoDatosDialg').css("display", "none");
		    					
	    					}, 500);
						});
		    		});
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}
		var consultarSoftware = function () {

			ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/cambiar/software/vtnMGestionEquipoDetalles-cambiarSoftware.php',1,1);
			//
			var accion_ = "consultarSoftware";
			var id_software_ = $('#btnCambiarSoftware').data('id_software');
			var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();


	        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{
							accion:accion_,
							id_software:id_software_, 
							id_equipo:id_equipo_,
							},
	            beforeSend: function () {

					$('#vtnCambiarSoftware #form').css("display", "none");
					$('#vtnCambiarSoftware #procesandoDatosDialg').css("display", "block");

	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
	    				$(dato.resultado).each(function (index, datoItem) {   

	    					setTimeout(function () {

								$('#vtnCambiarSoftware #datoControlIdEquipoCambio').val(datoItem.id_equipo);
								$('#vtnCambiarSoftware #datoControlIdCambio').val(datoItem.id_software);

		    					$('#vtnCambiarSoftware #nombrextActual').val(datoItem.nombre);
		    					$('#vtnCambiarSoftware #versionxtActual').val(datoItem.version);
		    					$('#vtnCambiarSoftware #tipotxtActual').val(datoItem.tipo);
		    					$('#vtnCambiarSoftware #distribucionTxtActual').val(datoItem.distribucion);

								$('#vtnCambiarSoftware #form').css("display", "block");
								$('#vtnCambiarSoftware #procesandoDatosDialg').css("display", "none");
		    					
	    					}, 500);
						});
		    		});
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}		
		var cargarListaCaractInterfacesUsado = function(id_c_componente_) {

			var accion_ = "consultarInterfacesCComponente";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCComponente.componente.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_c_componente_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					//console.log(JSON.stringify(data));
					//alert(JSON.stringify(data));

					$('#listGestionCaractInterfacesComponUsado').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listGestionCaractInterfacesComponUsado').popover('show');					
					$('#listGestionCaractInterfacesComponUsado').html('');
					//Obteniendo resultados para lista de interfaces
		    		$(data[0].interfaces).each(function (index, datoItem) { 
						if (datoItem.estadoInterfaz==1) {

							var btn = $('<button type="button" class="list-group-item" >'+datoItem.nombreInterfaz+'</button>');
							$('#listGestionCaractInterfacesComponUsado').append(btn);							
						}

		    		});
	            	$('#listGestionCaractInterfacesComponUsado').popover('destroy');



	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
		}
		var cargarListaCaractInterfaces = function(id_c_componente_) {

			var accion_ = "consultarInterfacesCComponente";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCComponente.componente.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_c_componente_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					//console.log(JSON.stringify(data));
					//alert(JSON.stringify(data));

					$('#listGestionCaractInterfacesComponActual').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listGestionCaractInterfacesComponActual').popover('show');					
					$('#listGestionCaractInterfacesComponActual').html('');
					//Obteniendo resultados para lista de interfaces
		    		$(data[0].interfaces).each(function (index, datoItem) { 
						if (datoItem.estadoInterfaz==1) {

							var btn = $('<button type="button" class="list-group-item" >'+datoItem.nombreInterfaz+'</button>');
							$('#listGestionCaractInterfacesComponActual').append(btn);							
						}

		    		});
	            	$('#listGestionCaractInterfacesComponActual').popover('destroy');



	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}			








		var guardarCambioPeriferico = function() {
			

				/* Obtener valores de los campos del formulario*/
					var accion_ = "guardarCambioPeriferico";	
					var yaExiste = false;
					var cantInvalida = false;						
				//
					var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();
					var id_periferico_actual_ = $('#vtnCambiarPeriferico #datoControlIdCambio').val();
					var id_caracteristicas_   = $('#vtnCambiarPeriferico #datoControlIdCaractADD').val();
		
					var observacion_ 		  = $('#vtnCambiarPeriferico #observacionTxt').val().toUpperCase();
					var observacionControl_ = observacion_;

					if (id_caracteristicas_=="") {
						nucleo.alertaErrorPublic("No se han seleccionado las caracteristicas del periferico ");
						return false;
					};
					if ($('#fila1 #input1').val()=="") {
						nucleo.alertaErrorPublic("No se ha ingresado el serial");
						$('#fila1 #input1').removeClass('imputSusess').addClass('imputWarnig');
						return false;
					}

					if (observacionControl_.trim()!=""){
						if (observacion_.length>255) {
							nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, máximo 255 ");
							return false;
						}
						if(observacion_.length<15){
							nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, minimo 15 ");
							return false;
						};
					}else{
						nucleo.alertaErrorPublic("Observación del cambio vacia");
						return false;
					};


				if ($('#listVtnSeriesComponentes .filaInputs').length>0) {
					
					var serial_    = [];
					var serial_bn_ = [];

					var seleccionados=0;
			   		var controlNoGuarda=0;
			   		var serial_periferico_nuevo ="";

					$('#listVtnSeriesComponentes .filaInputs').each(function (index, datoItem){

						var idItem = $(datoItem).attr("id");
						var dato1 = $('#'+idItem+'  #input1').val();
						serial_periferico_nuevo = dato1;
						var dato2 = $('#'+idItem+'  #input2').val();
						
						/*************************************************/						

						//-> validando cantidad de caracteres de seriales 
						if(dato1!=""){
							if (dato1.length>50) {
								nucleo.alertaErrorPublic("Serial '"+dato1+"' del periferico, tiene :"+dato1.length+" caracteres, máximo 50 ");
								cantInvalida = true;
							}
							if(dato1.length<4){
								nucleo.alertaErrorPublic("Serial '"+dato1+"' del periferico, tiene :"+dato1.length+" caracteres, minimo 4 ");
								cantInvalida = true;
							};
						}
						if(dato2!=""){
							if (dato2.length>50) {
								nucleo.alertaErrorPublic("Serial de bien nacional '"+dato2+"' del periferico, tiene :"+dato2.length+" caracteres, máximo 50 ");
								cantInvalida = true;
							}
							if(dato2.length<4){
								nucleo.alertaErrorPublic("Serial de bien nacional '"+dato2+"' del periferico, tiene :"+dato2.length+" caracteres, minimo 4 ");
								cantInvalida = true;
							};				
						};
						//-> verificando existencia
						if (nucleo.verificarExistenciaPublic('eq_periferico','serial','fila1 #input1','fila1 #input1')==true) {
							yaExiste = true;
						}
						if ($('#fila1 #input2').val()!="") {					
							if (nucleo.verificarExistenciaPublic('eq_periferico','serial_bn','fila1 #input2','fila1 #input2')==true) {
								yaExiste = true;
							}
						}
						/*************************************************/				

						if ( dato1!=null || dato1!="" ) {

							serial_.push(dato1);

						}else{
							serial_.push(" ");							
						}

						if(dato2!=null || dato2!="" ) {
	
							serial_bn_.push(dato2);							   			

						}else{
							serial_bn_.push(" ");
						}							

						seleccionados=seleccionados+1;

					});
					if (cantInvalida==true || yaExiste==true) {
						return false;
					};	
					console.log(accion_+'Cantidad: '+serial_.length+' array: Dptos: '+serial_+' -- serial_bn_: '+serial_bn_+' seleccionados: '+seleccionados);
					if (serial_.length<1 || seleccionados==0){
						var serial_=0;
						var serial_bn_=0;
					};

				}else{
					var serial_=0;
					var serial_bn_=0;
				};

				//
		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_equipo:id_equipo_,
							id_periferico_actual:id_periferico_actual_,
							observacion:observacion_,
							id_caracteristicas:id_caracteristicas_,
							seriales:JSON.stringify(serial_),
							seriales_bn:JSON.stringify(serial_bn_),
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');	

							$('#btnDesincorporarPeriferico').attr('disabled', true);																								
							$('#btnCambiarPeriferico').attr('disabled', true);																								
							mtdMantenimientoEquipo.cargarListaPerifericosEquipoPublic(1);
							
							var serial_equipo = $('#vtnProcsEquipoConsulta #serialtxt').val();	
							var serial_periferico_anterior = $('#vtnCambiarPeriferico #serialTxtActual').val();
							var detalles_ = "CAMBIO EL PERIFERICO DEL SERIAL :"+serial_periferico_anterior+" POR UN PERIFERICO DE SERIAL : "+serial_periferico_nuevo+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
							nucleo.guardarBitacoraPublic(detalles_);
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							var id_solicitud_ = $('#datoControlIdSolicitud').val();				
							var detalles_pej_ = " PERIFERICO DE SERIAL :"+serial_periferico_anterior+" POR UN PERIFERICO DE SERIAL : "+serial_periferico_nuevo;							
							

							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,detalles_pej_,7);								

							return true;	                    
						}else{

							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}
		var guardarCambioPerifericoUsado = function() {
			

			/* Obtener valores de los campos del formulario*/
				var accion_ = "guardarCambioPerifericoUsado";		
			//
				var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();
				var id_periferico_actual_ = $('#vtnCambiarPeriferico #datoControlIdCambio').val();
				var id_periferico_usado_ = $('#vtnCambiarPeriferico #datoControlIdUsado').val();
				var observacion_ 		  = $('#vtnCambiarPeriferico #observacionTxt').val().toUpperCase();
				var observacionControl_ = observacion_;

				if (observacionControl_.trim()!=""){
					if (observacion_.length>255) {
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, máximo 255 ");
						return false;
					}
					if(observacion_.length<15){
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, minimo 15 ");
						return false;
					};
				}else{
					nucleo.alertaErrorPublic("Observación del cambio vacia");
					return false;
				};
				//
		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_equipo:id_equipo_,
							id_periferico_actual:id_periferico_actual_,
							id_periferico_usado:id_periferico_usado_,
							observacion:observacion_,
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');	

							$('#btnDesincorporarPeriferico').attr('disabled', true);																								
							$('#btnCambiarPeriferico').attr('disabled', true);																								
							mtdMantenimientoEquipo.cargarListaPerifericosEquipoPublic(1);

							var serial_equipo = $('#vtnProcsEquipoConsulta #serialtxt').val();	
							var serial_periferico_anterior = $('#vtnCambiarPeriferico #serialTxtActual').val();
							var serial_periferico_usado = $('#vtnCambiarPeriferico #serialTxt').val();

							var detalles_ = "CAMBIO EL PERIFERICO DEL SERIAL :"+serial_periferico_anterior+" POR UN PERIFERICO DE SERIAL : "+serial_periferico_usado+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
							nucleo.guardarBitacoraPublic(detalles_);
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							var id_solicitud_ = $('#datoControlIdSolicitud').val();	
							var detalles_pej_ = " PERIFERICO DE SERIAL :"+serial_periferico_anterior+" POR UN PERIFERICO DE SERIAL : "+serial_periferico_usado;							
							
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,detalles_pej_,8);								

							return true;	                    
						}else{

							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}	
		var guardarCambioComponente = function() {
			

			/* Obtener valores de los campos del formulario*/
				var accion_ = "guardarCambioComponente";
				var yaExiste = false;
				var cantInvalida = false;						
			//
				var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();
				var id_componente_actual_ = $('#vtnCambiarComponente #datoControlIdCompoCambio').val();
				var observacion_ 		  = $('#vtnCambiarComponente #observacionTxt').val().toUpperCase();
				var observacionControl_ = observacion_;
				var id_caracteristicas_   = $('#vtnCambiarComponente #datoControlIdCaractADD').val();

				if (id_caracteristicas_=="") {
					nucleo.alertaErrorPublic("No se han seleccionado las caracteristicas del componente");
					return false;
				};

				if ($('#fila1 #input1').val()=="") {
					nucleo.alertaErrorPublic("No se ha ingresado el serial");
					$('#fila1 #input1').removeClass('imputSusess').addClass('imputWarnig');
					return false;
				}

				if (observacionControl_.trim()!=""){
					if (observacion_.length>255) {
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, máximo 255 ");
						return false;
					}
					if(observacion_.length<15){
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, minimo 15 ");
						return false;
					};
				}else{
					nucleo.alertaErrorPublic("Observación del cambio vacia");
					return false;
				};



				if ($('#listVtnSeriesComponentes .filaInputs').length>0) {
					
					var serial_    = [];
					var serial_bn_ = [];

					var seleccionados=0;
			   		var controlNoGuarda=0;
			   		var serial_componente_nuevo ="";

					$('#listVtnSeriesComponentes .filaInputs').each(function (index, datoItem){

						var idItem = $(datoItem).attr("id");
						var dato1 = $('#'+idItem+'  #input1').val();
						serial_componente_nuevo = dato1;
						var dato2 = $('#'+idItem+'  #input2').val();
						
						//-> validando cantidad de caracteres de seriales 
						if(dato1!=""){
							if (dato1.length>50) {
								nucleo.alertaErrorPublic("Serial '"+dato1+"' del componente, tiene :"+dato1.length+" caracteres, máximo 50 ");
								cantInvalida = true;
							}
							if(dato1.length<4){
								nucleo.alertaErrorPublic("Serial '"+dato1+"' del componente, tiene :"+dato1.length+" caracteres, minimo 4 ");
								cantInvalida = true;
							};
						}
						if(dato2!=""){
							if (dato2.length>50) {
								nucleo.alertaErrorPublic("Serial de bien nacional '"+dato2+"' del componente, tiene :"+dato2.length+" caracteres, máximo 50 ");
								cantInvalida = true;
							}
							if(dato2.length<4){
								nucleo.alertaErrorPublic("Serial de bien nacional '"+dato2+"' del componente, tiene :"+dato2.length+" caracteres, minimo 4 ");
								cantInvalida = true;
							};				
						};

						//-> Verificando existencia
						if (nucleo.verificarExistenciaPublic('eq_componente','serial','fila1 #input1','fila1 #input1')==true) {
							yaExiste = true;
						}
						if ($('#fila1 #input2').val()!="") {
							if (nucleo.verificarExistenciaPublic('eq_componente','serial_bn','fila1 #input2','fila1 #input2')==true) {
								yaExiste = true;
							}
						};

						if ( dato1!=null || dato1!="" ) {

							serial_.push(dato1);

						}else{
							serial_.push(" ");							
						}

						if(dato2!=null || dato2!="" ) {
	
							serial_bn_.push(dato2);							   			

						}else{
							serial_bn_.push(" ");
						}							

						seleccionados=seleccionados+1;

					});
					if (cantInvalida==true || yaExiste==true) {
						return false;
					};					
					console.log(accion_+'Cantidad: '+serial_.length+' array: Dptos: '+serial_+' -- serial_bn_: '+serial_bn_+' seleccionados: '+seleccionados);
					if (serial_.length<1 || seleccionados==0){
						var serial_=0;
						var serial_bn_=0;
					};

				}else{
					var serial_=0;
					var serial_bn_=0;
				};

				//
		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_equipo:id_equipo_,
							id_componente_actual:id_componente_actual_,
							observacion:observacion_,
							id_caracteristicas:id_caracteristicas_,
							seriales:JSON.stringify(serial_),
							seriales_bn:JSON.stringify(serial_bn_),
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');	

							$('#btnDesincorporarComponente').attr('disabled', true);																								
							$('#btnCambiarComponente').attr('disabled', true);																								
							mtdMantenimientoEquipo.cargarListaComponentesEquipoPublic(1);

							var serial_equipo = $('#vtnProcsEquipoConsulta #serialtxt').val();	
							var serial_componente_anterior = $('#vtnCambiarComponente #serialTxtActual').val();
							var detalles_ = "CAMBIO EL COMPONENTE DEL SERIAL :"+serial_componente_anterior+" POR UN COMPONENTE DE SERIAL : "+serial_componente_nuevo+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
							nucleo.guardarBitacoraPublic(detalles_);
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							var id_solicitud_ = $('#datoControlIdSolicitud').val();		
							var detalles_pej_ = " COMPONENTE DE SERIAL :"+serial_componente_anterior+" POR UN COMPONENTE DE SERIAL : "+serial_componente_nuevo;
							
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,detalles_pej_,9);
							return true;	                    
						}else{

							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}
		var guardarCambioComponenteUsado = function() {
		

				/* Obtener valores de los campos del formulario*/
				var accion_ = "guardarCambioComponenteUsado";		
				//
				var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();
				var id_componente_actual_ = $('#vtnCambiarComponente #datoControlIdCompoCambio').val();
				var id_componente_usado_ = $('#vtnCambiarComponente #datoControlIdCompoUsado').val();
				var observacion_ 		  = $('#vtnCambiarComponente #observacionTxt').val().toUpperCase();
				var observacionControl_ = observacion_;

				if (observacionControl_.trim()!=""){
					if (observacion_.length>255) {
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, máximo 255 ");
						return false;
					}
					if(observacion_.length<15){
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, minimo 15 ");
						return false;
					};
				}else{
					nucleo.alertaErrorPublic("Observación del cambio vacia");
					return false;
				};
				//
		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_equipo:id_equipo_,
							id_componente_actual:id_componente_actual_,
							id_componente_usado:id_componente_usado_,
							observacion:observacion_,
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');	

							$('#btnDesincorporarComponente').attr('disabled', true);																								
							$('#btnCambiarComponente').attr('disabled', true);																								
							mtdMantenimientoEquipo.cargarListaComponentesEquipoPublic(1);
							
							var serial_equipo = $('#vtnProcsEquipoConsulta #serialtxt').val();	
							var serial_componente_anterior = $('#vtnCambiarComponente #serialTxtActual').val();
							var serial_componente_usado = $('#vtnCambiarComponente #serialTxt').val();
							var detalles_ = "CAMBIO EL COMPONENTE DEL SERIAL :"+serial_componente_anterior+" POR UN COMPONENTE DE SERIAL : "+serial_componente_usado+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
							nucleo.guardarBitacoraPublic(detalles_);
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							var id_solicitud_ = $('#datoControlIdSolicitud').val();	
							var detalles_pej_ = " COMPONENTE DE SERIAL :"+serial_componente_anterior+" POR UN COMPONENTE DE SERIAL : "+serial_componente_usado;
							
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,detalles_pej_,10);
							return true;	                    
						}else{

							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}		
		var guardarCambioSoftware = function() {
			

			/* Obtener valores de los campos del formulario*/
				var accion_ = "guardarCambioSoftware";		
			//
				var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();
				var id_software_actual_   = $('#vtnCambiarSoftware #datoControlIdCambio').val();
				var observacion_ 		  = $('#vtnCambiarSoftware #observacionTxt').val().toUpperCase();
				var observacionControl_ = observacion_;

				if (observacionControl_.trim()!=""){
					if (observacion_.length>255) {
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, máximo 255 ");
						return false;
					}
					if(observacion_.length<15){
						nucleo.alertaErrorPublic("Observación del cambio, tiene :"+observacion_.length+" caracteres, minimo 15 ");
						return false;
					};
				}else{
					nucleo.alertaErrorPublic("Observación del cambio vacia");
					return false;
				};
				var id_software_   = $('#vtnCambiarSoftware #datoControlIdCaractADD').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_equipo:id_equipo_,
							id_software_actual:id_software_actual_,
							observacion:observacion_,
							id_software:id_software_,
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');	

							$('#btnDesincorporarSoftware').attr('disabled', true);																								
							$('#btnCambiarSoftware').attr('disabled', true);																								
							mtdMantenimientoEquipo.cargarListaSoftwareEquipoPublic(1);

							var serial_equipo = $('#vtnProcsEquipoConsulta #serialtxt').val();	
							var nombre_software_anterior = $('#vtnCambiarSoftware #nombrextActual').val();
							var nombre_software_nuevo = $('#vtnCambiarSoftware #nombretxt').val();
							var detalles_ = "CAMBIO EL SOFTWARE :"+nombre_software_anterior+" POR "+nombre_software_nuevo+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
							nucleo.guardarBitacoraPublic(detalles_);
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							var id_solicitud_ = $('#datoControlIdSolicitud').val();											
							var detalles_pej_ = "EL SOFTWARE :"+nombre_software_anterior+" POR "+nombre_software_nuevo;
							
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,detalles_pej_,11);
							return true;	                    
						}else{

							nucleo.alertaDialogoErrorPublic('Error de existencia',result[0].mensaje);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}		
		var desincorporarEquipo = function() {
			var accion_ = "desincorporarEquipo";
			//

			var id_equipo_ 		= $('#vtnProcsEquipoConsulta #datoControlId').val();
			var infoEstado_ = "SE DESINCORPORO EL EQUIPO";
			var observacion_ 	= $('#observacionTxt').val().toUpperCase();
			var observacionControl_ = observacion_;

			if (observacionControl_.trim()!=""){
				if (observacion_.length>255) {
					nucleo.alertaErrorPublic("Observación de la desincopración, tiene :"+observacion_.length+" caracteres, máximo 255 ");
					return false;
				}
				if(observacion_.length<15){
					nucleo.alertaErrorPublic("Observación de la desincopración, tiene :"+observacion_.length+" caracteres, minimo 15 ");
					return false;
				};
			}else{
				nucleo.alertaErrorPublic("Observación de la desincopración esta vacia");
				return false;
			};

	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						infoestado:infoEstado_.toUpperCase(),
						id_equipo:id_equipo_,
						observacion:observacion_,
					},
	            beforeSend: function () {
					$('.ventana-desincorporacion #form').css("display", "none");
					$('.ventana-desincorporacion #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (data) {
					//console.log(JSON.stringify(data));
					ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');			
					ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2');			
					$('#btnGestionarEquipo').attr('disabled', true);
					$('#btnRespuesta').attr('disabled', true);
					$('#panel-acciones-mantenimiento').css('display', 'none');
					$('#lbMensajeDesincorpora').css('display', 'block');
					$('#lbMensajeConformidad').html('Se necesita asignar un equipo disponible, al solicitante');	
					$('#lbMensajeConformidad').css('color', 'red');		
					var serial_edesinc = $('#vtnProcsEquipoConsulta #serialtxt').val();	
					var detalles_ = "DESINCOPORO EL EQUIPO DEL SERIAL :"+serial_edesinc;
					nucleo.guardarBitacoraPublic(detalles_);																			
					var id_solicitud_ = $('#datoControlIdSolicitud').val();
					/*
						PARAMETROS:
							1 - ESTADO MANTENIMIENTO
							2 - TIPO DE MANTENIMIENTO
							3 - ID_TAREA_EQUIPO
							4 - ID_SOLICITUD
							5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
							6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
					*/
					
					nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,'NO-APLICA',4);

	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}
		var desincorporarPerCompSoft = function(_tabla_, _nombreForaneas_ ) {
			var accion_ = "desincorporarPerCompSoft";
			//

			var id_equipo_ 		= $('#vtnProcsEquipoConsulta #datoControlId').val();
			var id_control_		= "";
			var observacion_ 	= $('#observacionTxt').val().toUpperCase();
			var observacionControl_ = observacion_;
			var infoEstado_		= "";
			var infoEstado_pej_ = "";

			if (observacionControl_.trim()!=""){
				if (observacion_.length>255) {
					nucleo.alertaErrorPublic("Observación de la desincopración, tiene :"+observacion_.length+" caracteres, máximo 255 ");
					return false;
				}
				if(observacion_.length<15){
					nucleo.alertaErrorPublic("Observación de la desincopración, tiene :"+observacion_.length+" caracteres, minimo 15 ");
					return false;
				};
			}else{
				nucleo.alertaErrorPublic("Observación de la desincopración esta vacia");
				return false;
			};
			var serial_equipo = $('#vtnProcsEquipoConsulta #serialtxt').val();								
			switch(_nombreForaneas_){
				case 'id_periferico' :
				
					id_control_ = $('#btnDesincorporarPeriferico').data('id_periferico');
					infoEstado_ = "DESINCOPORO EL PERIFERICO DE SERIAL :"+serialPerifericoSeleccionado+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
					infoEstado_pej_ = "PERIFERICO DE SERIAL :"+serialPerifericoSeleccionado;

				break;
				case 'id_componente' :

					id_control_ = $('#btnDesincorporarComponente').data('id_componente');				
					infoEstado_ = "DESINCOPORO EL COMPONENTE DE SERIAL :"+serialComponenteSeleccionado+" AL EQUIPO CON EL SERIAL :"+serial_equipo;
					infoEstado_pej_ = "COMPONENTE DE SERIAL :"+serialComponenteSeleccionado;

				break;
			}
	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						id_equipo:id_equipo_,
						id_control:id_control_,
						observacion:observacion_,
						infoestado:infoEstado_,
						tabla:_tabla_,
						nombreForaneas:_nombreForaneas_,
					},
	            beforeSend: function () {
					$('.ventana-desincorporacion #form').css("display", "none");
					$('.ventana-desincorporacion #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3');	
					var tipo_ejecucion_ = 0;
					switch(_nombreForaneas_){
						case 'id_periferico' :
						
							$('#btnDesincorporarPeriferico').attr('disabled', true);																								
							$('#btnCambiarPeriferico').attr('disabled', true);																																								
							mtdMantenimientoEquipo.cargarListaPerifericosEquipoPublic(1);							
							tipo_ejecucion_ = 5;
						break;
						case 'id_componente' :

							$('#btnDesincorporarComponente').attr('disabled', true);																								
							$('#btnCambiarComponente').attr('disabled', true);																								
							mtdMantenimientoEquipo.cargarListaComponentesEquipoPublic(1);
							tipo_ejecucion_ = 6;
						break;			
					}				
					/*
						PARAMETROS:
							1 - ESTADO MANTENIMIENTO
							2 - TIPO DE MANTENIMIENTO
							3 - ID_TAREA_EQUIPO
							4 - ID_SOLICITUD
							5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
							6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
					*/
					var id_solicitud_ = $('#datoControlIdSolicitud').val();
					
					nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,infoEstado_pej_,tipo_ejecucion_);				
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}








		var consultarCaracteristPeriferico = function(id_/*,_serial_,_serial_bn_*/) {

			var accion_ = "consultar";
			//
	        $.ajax({
				url: configuracion.urlsPublic().periferico.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_,
					},
	            beforeSend: function () {

	            },
	            success:  function (data) {

					//console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
	    				$(dato.resultado).each(function (index, datoItem) {  		    				

							//console.log(JSON.stringify(datoItem));
							var idCaracteristicas = datoItem.id_caracteristicas;

							$('#datoControlIdADDCaractADD').val(idCaracteristicas);
							datoControlIdCaractADD.value=idCaracteristicas;

							$("#vtnCambiarPeriferico #datoControlIdUsado").val(datoItem.id);							
							$("#vtnCambiarPeriferico #serialTxt").val(datoItem.serial);
							$("#vtnCambiarPeriferico #serialBienNacionalTxt").val(datoItem.serial_bn);
							//
							$("#vtnCambiarPeriferico #tipotxt").val(datoItem.tipo);
							$("#vtnCambiarPeriferico #marcatxt").val(datoItem.marca);					
							$("#vtnCambiarPeriferico #modelotxt").val(datoItem.modelo);
							$("#vtnCambiarPeriferico #interfaztxt").val(datoItem.interfaz);					
							$("#vtnCambiarPeriferico #capacidadtxt").val(datoItem.capacidad);	

	    				});		
		    		});

	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));
					alertas.dialogoErrorPublic(error.readyState,error.responseText);
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}	
		var consultarCaracterist = function(id_/*,_serial_,_serial_bn_*/) {

			var accion_ = "consultar";
			//
	        $.ajax({
				url: configuracion.urlsPublic().componente.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_,
					},
	            beforeSend: function () {
	            },
	            success:  function (data) {

					//console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
	    				$(dato.resultado).each(function (index, datoItem) {  		    				

	    					console.log(datoItem);
	    					//console.log("object");
	    					console.log(JSON.stringify(datoItem));
							//console.log("json");
							var idCaracteristicas = datoItem.id_caracteristicas;

							$('#datoControlIdADDCaractADD').val(idCaracteristicas);
							datoControlIdCaractADD.value=idCaracteristicas;

							$("#vtnCambiarComponente #datoControlIdCompoUsado").val(datoItem.id);							
							$("#vtnCambiarComponente #serialTxt").val(datoItem.serial);
							$("#vtnCambiarComponente #serialBienNacionalTxt").val(datoItem.serial_bn);

							$("#vtnCambiarComponente #tipotxt").val(datoItem.tipo);
							$("#vtnCambiarComponente #marcatxt").val(datoItem.marca);					
							$("#vtnCambiarComponente #modelotxt").val(datoItem.modelo);
							//$(" #voltagetxt").val(datoItem.voltage);					
							$("#vtnCambiarComponente #capacidadtxt").val(datoItem.capacidad);	
							cargarListaCaractInterfacesUsado(idCaracteristicas);

	    				});		
		    		});

	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
					console.log(JSON.stringify(error));
					alertas.dialogoErrorPublic(error.readyState,error.responseText);
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	 
			});
			
	        //
			//e.preventDefault();
			return false;
		}	

		/* 	La funcionalidad cargarListaPerifericosDisponibles
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaPerifericosDisponibles = function() {

			// Iniciando variables
			var accion_ = "cargarListaPerifericosDisponibles";
			var filtro_ = $(".panel-vtn-content-datos #buscardorTxt").val();
			var _filtro2_ = $('.panel-vtn-content-datos #btipoListD').val();

	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api ,
				type:'POST',	
				data:{	
						accion:accion_,			
						filtro:filtro_,
						filtro2:_filtro2_,						
					},
	            beforeSend: function () {

			        $("#listGestionPeriferico").html('');				
			        $("#pgnListPeriferico #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#listGestionPeriferico').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#listGestionPeriferico").html('');
		            $("#pgnListPeriferico #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var serial = datoItem.serial;
								var serial_bn = datoItem.serial_bn;
								var btn = $('<button type="button" class="list-group-item" style="font-size: x-small;" onclick="mtdMantenimientoEquipo.consultarCaracteristPerifericoPublic('+datoItem.id_periferico+/*',"'+datoItem.serial+'","'+datoItem.serial_bn+'"*/')"> serial : '+serial+' <br> serial bien nacional : '+serial_bn+' <br> '+datoItem.tipo+'</button>');

								$('#listGestionPeriferico').append(btn);
							});
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay perifericos disponibles </div>');
							tr.append("</div>");
							$('#listGestionPeriferico').append(tr);							
					}
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}

		/* 	La funcionalidad cargarListaComponentesDisponibles
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaComponentesDisponibles = function() {

			// Iniciando variables
			var accion_ = "cargarListaComponentesDisponibles";
			var filtro_ = $(".panel-vtn-content-datos #buscardorTxt").val();
			var _filtro2_ = $('.panel-vtn-content-datos #btipoListD').val();	

	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api ,
				type:'POST',	
				data:{	
						accion:accion_,	
						filtro:filtro_,
						filtro2:_filtro2_,
					},
	            beforeSend: function () {

			        $("#listGestionCaractCompon").html('');				
			        $("#pgnListCaracteristicasComponentes #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#listGestionCaractCompon').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#listGestionCaractCompon").html('');
		            $("#pgnListCaracteristicasComponentes #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var serial = datoItem.serial;
								var serial_bn = datoItem.serial_bn;
								var btn = $('<button type="button" class="list-group-item" style="font-size: x-small;" onclick="mtdMantenimientoEquipo.consultarCaracteristPublic('+datoItem.id_componente+/*',"'+datoItem.serial+'","'+datoItem.serial_bn+'"*/')"> serial : '+serial+' <br> serial bien nacional : '+serial_bn+' <br> '+datoItem.tipo+'</button>');

								$('#listGestionCaractCompon').append(btn);
							});
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay perifericos disponibles </div>');
							tr.append("</div>");
							$('#listGestionCaractCompon').append(tr);							
					}
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}

		/* La funcionalidad guardarAtenderInconformidad: 
			# Uso : Se usa para guardarAtenderInconformidad
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardarAtenderInconformidad = function() {
			
				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardarAtenderInconformidad";

				var id_conformidad_ = $('#vtnMantenimientoEquipo #btnAtenderConformidad').data('id_conformidad');
				//
	 		   $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
					accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),										
						id_conformidad:id_conformidad_,
					},
	                beforeSend: function () {
						$('#vtnMantenimientoEquipo #form').css("display", "none");
						$('#vtnMantenimientoEquipo #procesandoDatosDialg').css("display", "block");
	                },
	                success:  function (result) {
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							$('#lbMensajeConformidad').html('');
							$('#lbMensajeConformidad').html('Atendida la inconformidad');
							$('#lbMensajeConformidad').css('color', 'green');
							$('#lbMensajeRespuesta').css('color', 'green');		
							$('#btnAtenderConformidad').css('display', 'none');
							//		
							$('#vtnMantenimientoEquipo #form').css("display", "block");
							$('#vtnMantenimientoEquipo #procesandoDatosDialg').css("display", "none");
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							var id_solicitud_ = $('#datoControlIdSolicitud').val();
							var observacion = $('#btnAtenderConformidad').data('observacion');													
							nucleo.guardarPersonaEjecutaPublic(observacion,0,2,0,id_solicitud_,'NO-APLICA',14);											
							return true;	              							
						}else{
							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}			
		/* La funcionalidad guardarDiagnosticoSolicitud: 
			# Uso : Se usa para guardarDiagnosticoSolicitud
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardarDiagnosticoSolicitud = function() {
			
			$('#vtnMantenimientoEquipoRealizarDiagnostico #form').on('submit', function(e) {
				e.preventDefault();

				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardarDiagnosticoSolicitud";

				var id_solicitud_ = $('#vtnMantenimientoEquipo #datoControlIdSolicitud').val();
				var observacion_ = $('#vtnMantenimientoEquipoRealizarDiagnostico #observacionTxt').val().toUpperCase();
				if (observacion_=="") {
					nucleo.alertaErrorPublic(" Ingresar observación");
					return false;
				}
				//
	 		   $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
					accion:accion_,
					ip_cliente:sessionStorage.getItem("ip_cliente-US"),
					id_usuario:sessionStorage.getItem("idUsuario-US"),										
					id_solicitud:id_solicitud_,
					observacion:observacion_,
					},
	                beforeSend: function () {
						$('#vtnMantenimientoEquipoRealizarDiagnostico #form').css("display", "none");
						$('#vtnMantenimientoEquipoRealizarDiagnostico #procesandoDatosDialg').css("display", "block");
	                },
	                success:  function (result) {
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2');
							mtdMantenimientoEquipo.cargarListaDiagnosticosSoltPublic();
							$('#vtnMantenimientoEquipoRealizarDiagnostico #form').css("display", "block");
							$('#vtnMantenimientoEquipoRealizarDiagnostico #procesandoDatosDialg').css("display", "none");


							var serial_equipo = $('#vtnMantenimientoEquipo #serialEqTxt').val();	
							var detalles_ = "DIAGNOSTICO AL EQUIPO CON EL SERIAL :"+serial_equipo+" - QUE :"+observacion_;

							nucleo.guardarBitacoraPublic(detalles_);
							var id_solicitud_ = $('#datoControlIdSolicitud').val();
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,'NO-APLICA',2);


							return true;	              							
						}else{
							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
			});
		}
		/* La funcionalidad guardarRespuestaSolicitud: 
			# Uso : Se usa para guardarRespuestaSolicitud
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardarRespuestaSolicitud = function() {
			
				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardarRespuestaSolicitud";

				var id_solicitud_ = $('#vtnMantenimientoEquipo #datoControlIdSolicitud').val();
				var observacion_ = $('#vtnResponder #observacionTxt').val().toUpperCase();
				if (observacion_=="") {
					nucleo.alertaErrorPublic(" Ingresar observación");
					return false;
				}				
				//
	 		   $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
					accion:accion_,
					ip_cliente:sessionStorage.getItem("ip_cliente-US"),
					id_usuario:sessionStorage.getItem("idUsuario-US"),										
					id_solicitud:id_solicitud_,
					observacion:observacion_,
					},
	                beforeSend: function () {
						$('#vtnResponder #form').css("display", "none");
						$('#vtnResponder #procesandoDatosDialg').css("display", "block");
	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							mtdMantenimientoEquipo.cargarCatalogoPublic(paginaActual);
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2');
							ventanaModal.ocultarSinReinicPublic('ventana-modal');
							
							$('#btnGestionarEquipo').attr('disabled', false);
							$('#panel-acciones-mantenimiento').css('display', 'block');
							

							$('#btnRespuesta').attr('disabled', true);
							$('#lbMensajeConformidad').css('color', 'red');	
							$('#lbMensajeRespuesta').css('color', 'red');	
							//		
							$('#vtnResponder #form').css("display", "block");
							$('#vtnResponder #procesandoDatosDialg').css("display", "none");
							var id_solicitud_ = $('#datoControlIdSolicitud').val();
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,'NO-APLICA',12);


							return true;	              							
						}else{
							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}	
		/* La funcionalidad guardarRespuestaSolicitud: 
			# Uso : Se usa para guardarRespuestaSolicitud
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardarFinalizacionSolicitud = function() {
			
				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardarFinalizacionSolicitud";

				var id_solicitud_   = $('#vtnMantenimientoEquipo #datoControlIdSolicitud').val();
	    		var id_solicitante_ = $('#vtnMantenimientoEquipo #datoControlIdSolicitante').val();

				var observacion_ = $('#vtnFinalizarSolicitud #observacionTxt').val().toUpperCase();
				//
	 		   $.ajax({
					url: configuracion.urlsPublic().mantenimiento.api,
					type:'POST',	
					data:{	
					accion:accion_,
					ip_cliente:sessionStorage.getItem("ip_cliente-US"),
					id_usuario:sessionStorage.getItem("idUsuario-US"),										
					id_solicitud:id_solicitud_,
					id_solicitante:id_solicitante_,
					observacion:observacion_,
					ip_responsable_finalizar:sessionStorage.getItem("id-US"),
					},
	                beforeSend: function () {
						$('#vtnResponder #form').css("display", "none");
						$('#vtnResponder #procesandoDatosDialg').css("display", "block");
	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							mtdMantenimientoEquipo.cargarCatalogoPublic(paginaActual);
							ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2');
							ventanaModal.ocultarSinReinicPublic('ventana-modal');														
							//		
							$('#vtnResponder #form').css("display", "block");
							$('#vtnResponder #procesandoDatosDialg').css("display", "none");
							var id_solicitud_ = $('#datoControlIdSolicitud').val();
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							nucleo.guardarPersonaEjecutaPublic(observacion_,0,2,0,id_solicitud_,'NO-APLICA',13);

							return true;	              							
						}else{
							nucleo.alertaDialogoErrorPublic(result[0].mensaje,result[0].detalles);
							return false;
						};	
	                },
			    	error:  function(error) {
   						console.log(JSON.stringify(error));
   						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});
		        //
		        nucleo.reiniciarVariablesGNPublic();
		}				
		/* La funcionalidad cambiarEstado: 
			# Uso : Se usa para cambiar el estado 
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var cambiarEstado = function(infoEstado_,id_,estado_) {
			var accion_ = "cambiarEstado";
			//
	        $.ajax({
				url: configuracion.urlsPublic().mantenimiento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						id:id_,
						infoestado:infoEstado_.toUpperCase(),
						estado:estado_
					},
	            beforeSend: function () {
					$('#vtnMantenimientoEquipo #form').css("display", "none");
					$('#vtnMantenimientoEquipo #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					mtdMantenimientoEquipo.cargarCatalogoPublic(1);
					/*
						PARAMETROS:
							1 - ESTADO MANTENIMIENTO
							2 - TIPO DE MANTENIMIENTO
							3 - ID_TAREA_EQUIPO
							4 - ID_SOLICITUD
							5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
							6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
					*/
					nucleo.guardarPersonaEjecutaPublic(0,0,2,0,id_,infoEstado_,15);					
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}


/************************************************/

		var consultarEquipoGestion = function(id_) {

			if (id_>0) {

				ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().equipo.detallar,1,1);
			}				
			setTimeout(function() {
				
				if (id_==0) {
					id_ = $('#vtnProcsEquipoConsulta #datoControlId').val();
				}
				var accion_ = "consultar";
				
				console.log("verificando: "+id_);
				//
		        $.ajax({
					url: configuracion.urlsPublic().equipo.api,
					type:'POST',	
					data:{	
							accion:accion_,
							id:id_,
						},
		            beforeSend: function () {
						
			        	$('#vtnProcsEquipoConsulta #form').css("display", "none");
			            $('#vtnProcsEquipoConsulta #procesandoDatosDialg').css("display", "block");
		            
		            },
		            success:  function (data) {

		            	setTimeout(function() {

				        	$('#vtnProcsEquipoConsulta #form').css("display", "block");
				        	$('#vtnProcsEquipoConsulta #procesandoDatosDialg').css("display", "none");
							console.log(JSON.stringify(data.resultado));


							$(data).each(function (index, dato) {
								//Obteniendo resultados para catalogo
			    				$(dato.resultado).each(function (index, datoItem) {  		    				

									var idEquipo = datoItem.id_equipo;
									var id_caracteristicas_ = datoItem.id_caracteristicas;

									$('#vtnProcsEquipoConsulta #datoControlId').val(idEquipo);
									
									$("#vtnProcsEquipoConsulta #serialtxt").val(datoItem.serial);
									$("#vtnProcsEquipoConsulta #serialBienNacionaltxt").val(datoItem.serial_bn);
									$("#vtnProcsEquipoConsulta #tipotxt").val(datoItem.tipo);
									$("#vtnProcsEquipoConsulta #marcatxt").val(datoItem.marca);					
									$("#vtnProcsEquipoConsulta #modelotxt").val(datoItem.modelo);
									//
									$('#btnDesincorporarPeriferico').attr('disabled', true);																								
									$('#btnCambiarPeriferico').attr('disabled', true);																																		
									$('#btnDesincorporarComponente').attr('disabled', true);																								
									$('#btnCambiarComponente').attr('disabled', true);																								
									$('#btnDesincorporarSoftware').attr('disabled', true);																								
									$('#btnCambiarSoftware').attr('disabled', true);																								
									//
									mtdEquipo.cargarListaCaractInterfacesPublic(id_caracteristicas_);
									mtdMantenimientoEquipo.cargarListaPerifericosEquipoPublic(1);
									mtdMantenimientoEquipo.cargarListaComponentesEquipoPublic(1);
									mtdMantenimientoEquipo.cargarListaSoftwareEquipoPublic(1);
			    				});		
				    		});



						}, 500);
		            },
				    //error:  function(jq,status,message) {
			    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);
				        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
				    }	 
				});
				
		        //
				//e.preventDefault();
				return false;
			}, 100)
		}

		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaPerifericosEquipo = function(_pagina_) {

			// Iniciando variables
			var accion_ = "cargarListaPerifericosEquipo";
			var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();

			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().equipo.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_equipo:id_equipo_,
						tamagno_paginas:5,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionPerifericos").html('');				
			        $("#pgnListPerifericos #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#listGestionPerifericos').append(tr);

	            },
	            success:  function (data) {
					var activoSinVacio=false;
		    
		            $("#listGestionPerifericos").html('');
		            $("#pgnListPerifericos #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var btn = $('<button type="button" class="lista-btnP list-group-item " id="btnP-'+datoItem.id_periferico+'">'+
									'<table>'+
										'<tr><td><b> Serial : </b></td><td>'+datoItem.serial+'</td></tr>'+
										'<tr><td><b> Serial Bien Nacional: </b></td><td>'+datoItem.serial_bn+'</td></tr>'+
										'<tr><td><b> Tipo : </b></td><td>'+datoItem.tipo+'</td></tr>'+
										'<tr><td><b> Marca y Modelo : </b></td><td>'+datoItem.marcaymodelo+'</td><td class="col-md-2"><button type="button" id="btnP-Select-'+datoItem.id_periferico+'" class="lista-btnP-actvr btn btn-default niDesincorporaCambiaPerifBtnDiv" style="padding: 0px 16px;" data-id_periferico="'+datoItem.id_periferico+'" data-serial="'+datoItem.serial+'" > >> </button></td></tr>'+
									'</table>'+
									'</button>');



								$('#listGestionPerifericos').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.controlPaginacionPerifEqPublic('+dato.pagAnterior+')" aria-label="Previous">'+
													'<span aria-hidden="true">&laquo;</span>'+					      
												'</a>'+
											'</li>'	
										);
							}
							//paginas
							if (dato.pagActual>=1) {	

								if (dato.total_paginas>1) {
									for (var i=1; i <= dato.total_paginas ; i++) { 

										if(i==dato.pagActual) {
											ul.append(
														"<li class='active'>"+
															"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.controlPaginacionPerifEqPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.controlPaginacionPerifEqPublic("+i+")' >"+ i +"</a>"+
														"</li>" 
													);
										}
									}
								};
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.controlPaginacionPerifEqPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListPerifericos #pagination').append(ul);
							activoSinVacio = true;
						});
						nucleo.asignarPermisosBotonesPublic(3);
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay periferico añadido </div>');
							tr.append("</div>");
							$('#listGestionPerifericos').append(tr);						
					}
					if (activoSinVacio==false) {
						$('#btnDesincorporarPeriferico').css('display', 'none');				
						$('#btnCambiarPeriferico').css('display', 'none');				
					}else{
						$('#btnDesincorporarPeriferico').css('display', 'block');				
						$('#btnCambiarPeriferico').css('display', 'block');										
					}
					actListPerif();
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});

		}


		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaComponentesEquipo = function(_pagina_) {

			// Iniciando variables
			var accion_ = "cargarListaComponentesEquipo";
			var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();

			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().equipo.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_equipo:id_equipo_,
						tamagno_paginas:5,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionComponentes").html('');				
			        $("#pgnListComponentes #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#listGestionComponentes').append(tr);

	            },
	            success:  function (data) {
					var activoSinVacio=false;
		            $("#listGestionComponentes").html('');
		            $("#pgnListComponentes #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var btn = $('<button type="button" class="lista-btnC list-group-item " id="btnC-'+datoItem.id_componente+'">'+
									'<table>'+
										'<tr><td><b> Serial : </b></td><td>'+datoItem.serial+'</td></tr>'+
										'<tr><td><b> Serial Bien Nacional: </b></td><td>'+datoItem.serial_bn+'</td></tr>'+
										'<tr><td><b> Tipo : </b></td><td>'+datoItem.tipo+'</td></tr>'+
										'<tr><td><b> Marca y Modelo : </b></td><td>'+datoItem.marcaymodelo+'</td><td class="col-md-2"><button type="button" id="btnC-Select-'+datoItem.id_componente+'" class="lista-btnC-actvr btn btn-default niDesincorporaCambiaCompBtnDiv" style="padding: 0px 16px;" data-id_componente="'+datoItem.id_componente+'" data-serial="'+datoItem.serial+'" > >> </button></td></tr>'+
									'</table>'+
									'</button>');

								$('#listGestionComponentes').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.controlPaginacionCompoEqPublic('+dato.pagAnterior+')" aria-label="Previous">'+
													'<span aria-hidden="true">&laquo;</span>'+					      
												'</a>'+
											'</li>'	
										);
							}
							//paginas
							if (dato.pagActual>=1) {	

								if (dato.total_paginas>1) {
									for (var i=1; i <= dato.total_paginas ; i++) { 

										if(i==dato.pagActual) {
											ul.append(
														"<li class='active'>"+
															"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.controlPaginacionCompoEqPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.controlPaginacionCompoEqPublic("+i+")' >"+ i +"</a>"+
														"</li>" 
													);
										}
									}
								};
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.controlPaginacionCompoEqPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListComponentes #pagination').append(ul);
							activoSinVacio=true;
						});
						nucleo.asignarPermisosBotonesPublic(3);	
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay componente añadido </div>');
							tr.append("</div>");
							$('#listGestionComponentes').append(tr);	
					}
					if (activoSinVacio==false) {
						$('#btnDesincorporarComponente').css('display', 'none');				
						$('#btnCambiarComponente').css('display', 'none');				
					}else{
						$('#btnDesincorporarComponente').css('display', 'block');				
						$('#btnCambiarComponente').css('display', 'block');										
					}	
					actListComp();	
	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}



		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaSoftwareEquipo = function(_pagina_) {

			// Iniciando variables
			var accion_ = "cargarListaSoftwareEquipo";
			var id_equipo_ = $('#vtnProcsEquipoConsulta #datoControlId').val();

			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().equipo.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_equipo:id_equipo_,
						tamagno_paginas:5,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionSoftware").html('');				
			        $("#pgnListSoftware #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#listGestionSoftware').append(tr);

	            },
	            success:  function (data) {
					var activoSinVacio=false;
		            $("#listGestionSoftware").html('');
		            $("#pgnListSoftware #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var btn = $('<button type="button" class="lista-btnS list-group-item " id="btnS-'+datoItem.id_software+'">'+
									'<table>'+
										'<tr><td><b> Nombre : </b></td><td>'+datoItem.NombreVersion+'</td></tr>'+
										'<tr><td><b> Tipo : </b></td><td>'+datoItem.tipo+'</td></tr>'+
										'<tr><td><b> Distribución : </b></td><td>'+datoItem.distribucion+'</td><td class="col-md-2"><button type="button" id="btnS-Select-'+datoItem.id_software+'" class="lista-btnS-actvr btn btn-default cambiarSoftwareListDiv" style="padding: 0px 16px;" data-id_software="'+datoItem.id_software+'" data-nombreversion="'+datoItem.NombreVersion+'" > >> </button></td></tr>'+
									'</table>'+
									'</button>');

								$('#listGestionSoftware').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.controlPaginacionSoftEqPublic('+dato.pagAnterior+')" aria-label="Previous">'+
													'<span aria-hidden="true">&laquo;</span>'+					      
												'</a>'+
											'</li>'	
										);
							}
							//paginas
							if (dato.pagActual>=1) {	

								if (dato.total_paginas>1) {
									for (var i=1; i <= dato.total_paginas ; i++) { 

										if(i==dato.pagActual) {
											ul.append(
														"<li class='active'>"+
															"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.controlPaginacionSoftEqPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdMantenimientoEquipo.controlPaginacionSoftEqPublic("+i+")' >"+ i +"</a>"+
														"</li>" 
													);
										}
									}
								};
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoEquipo.controlPaginacionSoftEqPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListSoftware #pagination').append(ul);
							activoSinVacio=true;
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay Software añadido </div>');
							tr.append("</div>");
							$('#listGestionSoftware').append(tr);
					}
					if (activoSinVacio==false) {
						$('#btnDesincorporarSoftware').css('display', 'none');				
						$('#btnCambiarSoftware').css('display', 'none');				
					}else{
						$('#btnDesincorporarSoftware').css('display', 'block');				
						$('#btnCambiarSoftware').css('display', 'block');										
					}	
					actListSoft();				
					nucleo.asignarPermisosBotonesPublic(3);

	            },
			    //error:  function(jq,status,message) {
		    	error:  function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}


/*******************/

		var serialPerifericoSeleccionado = "";
		var actListPerif = function () {

			$('.lista-btnP-actvr').on('click',function (item) {
				$('.lista-btnP').removeClass('lista-btnP-select');				
				$('.lista-btnP').css('color', '#000000');
				//
				var btnId = item.target.id;			
				serialPerifericoSeleccionado = $('#'+btnId).data('serial');					
				var id_ = $('#'+btnId).data('id_periferico');
				$('#btnP-'+id_).addClass('lista-btnP-select');
				$('#btnP-'+id_).css('color', '#FFFFFF');
				$('#btnDesincorporarPeriferico').data('id_periferico', id_);
				$('#btnCambiarPeriferico').data('id_periferico', id_);
				//
				$('#btnDesincorporarPeriferico').attr('disabled', false);																								
				$('#btnCambiarPeriferico').attr('disabled', false);
				//
			});
		}		

		var serialComponenteSeleccionado = "";
		var actListComp = function () {

			$('.lista-btnC-actvr').on('click',function (item) {
				$('.lista-btnC').removeClass('lista-btnC-select');				
				$('.lista-btnC').css('color', '#000000');
				//
				var btnId = item.target.id;				
				var id_ = $('#'+btnId).data('id_componente');
				$('#btnC-'+id_).addClass('lista-btnC-select');
				$('#btnC-'+id_).css('color', '#FFFFFF');
				serialComponenteSeleccionado = $('#'+btnId).data('serial');
				$('#btnDesincorporarComponente').data('id_componente', id_);
				$('#btnCambiarComponente').data('id_componente', id_);
				//
				$('#btnDesincorporarComponente').attr('disabled', false);																								
				$('#btnCambiarComponente').attr('disabled', false);																								
				//
			});
		}		

		var nombreSoftwareSeleccionado = "";
		var actListSoft = function () {
			$('.lista-btnS-actvr').on('click',function (item) {
				$('.lista-btnS').removeClass('lista-btnS-select');				
				$('.lista-btnS').css('color', '#000000');
				//
				var btnId = item.target.id;
				nombreSoftwareSeleccionado = $('#'+btnId).data('nombreversion');
				var id_ = $('#'+btnId).data('id_software');
				$('#btnS-'+id_).addClass('lista-btnS-select');
				$('#btnS-'+id_).css('color', '#FFFFFF');
				$('#btnDesincorporarSoftware').data('id_software', id_);
				$('#btnCambiarSoftware').data('id_software', id_);
				//
				$('#btnDesincorporarSoftware').attr('disabled', false);																								
				$('#btnCambiarSoftware').attr('disabled', false);																								
				//
			});
		}		

/************************************************/		
		/******************************************************************************************/

		var paginaControl = function (_pagina_) {
			paginaActual = _pagina_;
			mtdMantenimientoEquipo.cargarCatalogoPublic(_pagina_);   
		}				
		var iniciarVtnGestionEquipo = function () {
			ventanaModal.cambiaMuestraVentanaModalCapa2Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/vtnMGestionEquipoDetalles.php',1,0);
			$('#vtnProcsEquipoConsulta #datoControlId').val($('#vtnMantenimientoEquipo #datoControlIdEquipo').val());
		}		
		//
		var controlPaginacionPerifEq = function (_pagina_) {
			paginaActualCaractPerifEq = _pagina_;
			mtdMantenimientoEquipo.cargarListaPerifericosEquipoPublic(_pagina_);   
			$('#btnDesincorporarPeriferico').data('id_periferico', ' ');
			$('#btnCambiarPeriferico').data('id_periferico', ' ');		
			//
			$('#btnDesincorporarPeriferico').attr('disabled', true);																								
			$('#btnCambiarPeriferico').attr('disabled', true);
			//				
		}				
		var controlPaginacionCompoEq = function (_pagina_) {
			paginaActualCaractCompoEq = _pagina_;
			mtdMantenimientoEquipo.cargarListaComponentesEquipoPublic(_pagina_);   
			$('#btnDesincorporarComponente').data('id_componente', ' ');
			$('#btnCambiarComponente').data('id_componente', ' ');		
			//
			$('#btnDesincorporarComponente').attr('disabled', true);																								
			$('#btnCambiarComponente').attr('disabled', true);																								
			//				
		}	
		var controlPaginacionSoftEq = function (_pagina_) {
			paginaActualCaractSoftEq = _pagina_;
			mtdMantenimientoEquipo.cargarListaSoftwareEquipoPublic(_pagina_); 
			$('#btnDesincorporarSoftware').data('id_software', ' ');
			$('#btnCambiarSoftware').data('id_software', ' ');			
			//
			$('#btnDesincorporarSoftware').attr('disabled', true);																								
			$('#btnCambiarSoftware').attr('disabled', true);																								
			//			  
		}			
		//
		return{
			Iniciar: function () {

			},
			iniciarVtnGestionEquipoPublic : iniciarVtnGestionEquipo,
			detallesPublic : detalles,
			consultarPublic : consultar,
			consultarPerifericoPublic : consultarPeriferico,
			consultarComponentePublic : consultarComponente,
			consultarSoftwarePublic : consultarSoftware,
			consultarCaracteristPerifericoPublic : consultarCaracteristPeriferico,
			consultarCaracteristPublic : consultarCaracterist,
			paginaControlPublic : paginaControl,
			controlPaginacionCompoEqPublic : controlPaginacionCompoEq,
			controlPaginacionPerifEqPublic : controlPaginacionPerifEq,
			controlPaginacionSoftEqPublic : controlPaginacionSoftEq,
			cargarCatalogoPublic : cargarCatalogo,
			cargarListaDiagnosticosSoltPublic : cargarListaDiagnosticosSolt,
			cargarListaTareasEquipoSolicitudPublic : cargarListaTareasEquipoSolicitud,
			cargarListaCaractInterfacesPublic : cargarListaCaractInterfaces,
			cargarListaPerifericosDisponiblesPublic : cargarListaPerifericosDisponibles,
			cargarListaComponentesDisponiblesPublic : cargarListaComponentesDisponibles,
			guardarDiagnosticoSolicitudPublic : guardarDiagnosticoSolicitud,
			guardarRespuestaSolicitudPublic : guardarRespuestaSolicitud,
			guardarFinalizacionSolicitudPublic : guardarFinalizacionSolicitud,
			guardarCambioPerifericoPublic : guardarCambioPeriferico,
			guardarCambioPerifericoUsadoPublic : guardarCambioPerifericoUsado,
			guardarCambioComponentePublic : guardarCambioComponente,
			guardarCambioComponenteUsadoPublic : guardarCambioComponenteUsado,
			guardarCambioSoftwarePublic : guardarCambioSoftware,
			guardarAtenderInconformidadPublic : guardarAtenderInconformidad,
			desincorporarEquipoPublic : desincorporarEquipo,
			desincorporarPerCompSoftPublic : desincorporarPerCompSoft,		
			cambiarEstadoPublic : cambiarEstado,
			cambiarEstadoTareaEquipoPublic : cambiarEstadoTareaEquipo,
			consultarEquipoGestionPublic : consultarEquipoGestion,
			cargarListaComponentesEquipoPublic : cargarListaComponentesEquipo,
			cargarListaPerifericosEquipoPublic : cargarListaPerifericosEquipo,
 			cargarListaSoftwareEquipoPublic : cargarListaSoftwareEquipo,			
			getP : get,
		}
	}();