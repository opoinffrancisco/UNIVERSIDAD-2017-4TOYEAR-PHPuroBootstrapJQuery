	var mtdSolicitud = function () {

		/***************************Variables globales*************************/

		var paginaActual = 1; // Pagina actual de la #paginacion
		var paginaActualListEq = 1;
		var paginaActualListEqDpt = 1;
		var tamagno_paginas_ = 7; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
		var consulta = false;
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
				url: configuracion.urlsPublic().solicitud.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_persona:sessionStorage.getItem("id_persona-US"),										
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

								var estadoMensaje = "";
								var revisarEstado = "";		
								var colorMensaje = "";	
								//
								switch(datoItem.estado)
									{
										case '0':
											estadoMensaje = "EN ESPERA";
											colorMensaje = "background: #FFEB3B;";
											//revisarEstado = 'disabled="TRUE" ';
										break;
										case '1':		
											//estadoMensaje = '<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdEquipo.consultarEstado('+datoItem.id+')" style="width: 100%;">Atendiendo</button>';
											estadoMensaje = "ATENDIENDO";
											colorMensaje = "background:  rgba(78, 171, 251, 0.68);";										
										break;
										case '2':		  
											//estadoMensaje = '<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdEquipo.consultarEstado('+datoItem.id+')" style="width: 100%;">Atendido</button>';
											estadoMensaje = "ATENDIDO";
											colorMensaje = "background:  rgba(38, 247, 41, 0.61);";
										break;																				
										case '3':
											//	Atendiendo - (Actividad en espera)											
											estadoMensaje = "ATENDIENDO";
											colorMensaje = "background:  rgba(78, 171, 251, 0.68);border: 1px solid red;color: red;";
										break;										

									}										

					tr = $('<tr class="row " >'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
									'<textarea disabled="true" style="background:transparent; resize:vertical;   margin-top: 0px; margin-bottom: 0px; height: 35px; width: 100%; border: 0px; overflow-y: hidden;">'+
										datoItem.asunto+
									'</textarea>'+	
								'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+
									'<div style="width: 100%;height: 50%;">'+
										'<div class="row">'+
											'<div class="col-md-2" style="border-bottom: 1px solid #bfbfbf; padding: 0px;">'+
												'S : '+
											'</div>'+
											'<div class="col-md-10" style="border-bottom: 1px solid #bfbfbf;">'+
												datoItem.serial+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div style="width: 100%;height: 50%;">'+
										'<div class="row">'+
											'<div class="col-md-2" style="padding: 0px;" >'+
												'B.N. : '+
											'</div>'+
											'<div class="col-md-10">'+
												datoItem.serial_bn+
											'</div>'+
										'</div>'+
									'</div>'+
								'</td>'+						
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+datoItem.fecha+'</td>'+
								'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
									'<div class="btn-group" role="group" style="width: 100%; '+colorMensaje+'" >'+
										estadoMensaje+
									'</div>'+
								'</td>'+							
								'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-1">'+
									'<div class="btn-group detallesBtnDiv" role="group" style="width: 100%;">'+
										'<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdSolicitud.consultarPublic('+datoItem.id_solicitud+')" style="width: 100%;">Detalles</button>'+
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
									 			'<a href="JavaScript:;" onclick="mtdSolicitud.paginaControlPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdSolicitud.paginaControlPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdSolicitud.paginaControlPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdSolicitud.paginaControlPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pngSolicitud #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(2);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="6" style="text-align: center;"> No hay resultados para la busqueda </td>');
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
			Mostrar edicion o tipico Consultar

		*/
		var consultar = function (id_solicitud_) {

			consulta=true;
			ventanaModal.cambiaMuestraVentanaModalPublic("procesos/solicitud/ventanasModales/vtnMGestionSolicitud.php",1,1);

			var accion_ = "consultar";
			
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
					$(data).each(function (index, dato) {
	
		    				$(dato.resultado).each(function (index, datoItem) {   

		    					$('#btnConformidad').data('id_solicitud', datoItem.id_solicitud);
		

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
						    					$('.abrir-panel-datos').css('display', 'block');
											};
					    					//		    					
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
															$('#conformidad').html('¿ Se encuentra conforme con el servicio reciente ?');																																								
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
																$('#conformidad').html('');
																$('#conformidad').html('¿ Se encuentra conforme con el servicio reciente ?');																																								
																$('#conformidad').css('display', 'block');													
																$('#conformidadOpciones').css('display', 'block');
																$('#btnConformidad').css('display', 'block');			
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
														$('#conformidad').html('');
														$('#conformidad').html('¿ Se encuentra conforme con el servicio reciente ?');																																								
														$('#conformidad').css('display', 'block');	
									    			}
												}else{
													$('#mensajesConformidad').css('display', 'none');
													$('#confirmarEquipoRecibido').css('display', 'block');
													$('#confirmarEquipoRecibido').css('display', 'block');
													$('.chet-2').css('display', 'none');								    				

													if (datoItem.conformidades!="") {
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
		/* La funcionalidad Guardar: 
			# Uso : Se usa para guardar y editar
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardar = function() {
			
				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardar";

				var id_equipo_ = $('#btnSolicitar').data('id_equipo');
				var asunto_ = $('#asuntoTxt').val();
				var descripcion_ = $('#descripcionTxt').val();
				var id_departamento_ = $('#vtnSolicitud #departamentoListD').val();
				var id_cargo_ = $('#vtnSolicitud #departamentoListD :selected').data('idcargo');

				if (id_equipo_=="" || id_equipo_==0 || id_equipo_==null) {
					nucleo.alertaErrorPublic(" Elegir equipo");					
					return false;
				}
				if (asunto_=="") {
					nucleo.alertaErrorPublic(" Ingresar asunto");					
					return false;
				}
				if (descripcion_=="") {
					nucleo.alertaErrorPublic(" Ingresar descripción");
					return false;
				}				
				//
		  	  	$.ajax({
							url: configuracion.urlsPublic().solicitud.api,
							type:'POST',	
							data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_persona:sessionStorage.getItem("id_persona-US"),
							id_departamento:id_departamento_,
							id_cargo:id_cargo_,
							id_equipo:id_equipo_,
							asunto:asunto_.toUpperCase(),
							descripcion:descripcion_.toUpperCase(),
						},
	                beforeSend: function () {
						$('#vtnSolicitud #form').css("display", "none");
						$('#vtnSolicitud #procesandoDatosDialg').css("display", "block");
						$("#catalogoDatos").html('');				
						$("#pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#catalogoDatos').append(tr);
						console.log('procesando guardar');

	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							ventanaModal.ocultarPulico('ventana-modal');
							$("#catalogoDatos").html('');				
							$("#pagination").html('');	
							mtdSolicitud.cargarCatalogoPublic(paginaActual);
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
		var guardarConformidad = function() {
			//
			var accion_ = "guardarConformidad";

			var id_solicitud_   = $('#btnConformidad').data('id_solicitud');
			var observacion_ = $('#mensajesConformidad #observacionTxt').val();

			var mensajesConformidadRecibido="";
			var tipoEjecucionPersona=0;

			var conformidad_ = "";
			if($('#mensajesConformidad').is(":visible")){

				if ($("#mensajesConformidad #noCbox").is(':checked')) {
					conformidad_ =  0 ;
					tipoEjecucionPersona = 17;	//16 -> antes
					mensajesConformidadRecibido = observacion_;					
				}
				if ($("#mensajesConformidad #siCbox").is(':checked')) {
					conformidad_ =  1 ;
					observacion_="";
					tipoEjecucionPersona = 16;	//17 -> antes
				}

			}
			if($('#confirmarEquipoRecibido').is(":visible")){
				if ($("#confirmarEquipoRecibido #siCbox").is(':checked')) {
					conformidad_ =  1 ;
					observacion_=" SE HA RECIBIDO EL NUEVO EQUIPO ASIGNADO ";
					tipoEjecucionPersona = 1;	
					mensajesConformidadRecibido = observacion_;				
				}
			}			
			
			//
		    $.ajax({
					url: configuracion.urlsPublic().solicitud.api,
					type:'POST',	
					data:{	
					accion:accion_,
					ip_cliente:sessionStorage.getItem("ip_cliente-US"),
					id_usuario:sessionStorage.getItem("idUsuario-US"),										
					id_persona:sessionStorage.getItem("id_persona-US"),
					id_solicitud:id_solicitud_,
					observacion:observacion_.toUpperCase(),
					conformidad:conformidad_,
						},
	                beforeSend: function () {
						$('#vtnSolicitud #form').css("display", "none");
						$('#vtnSolicitud #procesandoDatosDialg').css("display", "block");
						$("#catalogoDatos").html('');				
						$("#pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#catalogoDatos').append(tr);
	                },
	                success:  function (result) {
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {							
							/*
								PARAMETROS:
									1 - ESTADO MANTENIMIENTO
									2 - TIPO DE MANTENIMIENTO
									3 - ID_TAREA_EQUIPO
									4 - ID_SOLICITUD
									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
							*/
							nucleo.guardarPersonaEjecutaPublic(mensajesConformidadRecibido,0,2,0,id_solicitud_,'NO-APLICA',tipoEjecucionPersona);
							//
							mtdSolicitud.cargarCatalogoPublic(paginaActual);
							nucleo.alertaExitoPublic(result[0].detalles);
							ventanaModal.ocultarPulico('ventana-modal');
							$("#catalogoDatos").html('');				
							$("#pagination").html('');	

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
		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaEquipoPersona = function(_pagina_) {

			// Iniciando variables
			var accion_ = "cargarListaEquiposPersona";

			//
			var AccionarEstado="";
			var ColorEstado=""; 
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().solicitud.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_persona:sessionStorage.getItem("id_persona-US"),										
						tamagno_paginas:5,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#equiposSolicitanteList").html('');				
			        $("#pgnEquiposSolicitanteList #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#equiposSolicitanteList').append(tr);

	            },
	            success:  function (data) {
		    
		            $("#equiposSolicitanteList").html('');
		            $("#pgnEquiposSolicitanteList #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								// validando si el equipo NO tiene atareas preventivas activadas
								// validando si el equipo NO tiene solicitudes activadas
								if (datoItem.resultadoEMP==0 && datoItem.resultadoESA==0 && datoItem.estado_equipo==1) {
									var btn = $('<div class="lista-equipo-solt list-group-item" id="equipo'+datoItem.id_equipo+'"  style="padding: 2px;">'+
										'<table style="margin:0px; " >'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn+'</td><td></td><td class="col-md-2"><button type="button" id="btn'+datoItem.id_equipo+'" class="lista-equipo-solt-actvr btn btn-default" style="padding: 0px 16px;" data-id_equipo="'+datoItem.id_equipo+'" > >> </button></td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Ubicación : </b></td><td class="col-md-5">'+datoItem.cargoydepartamento+'</td><td></td></tr>'+
										'</table>'+
										'</div>');
								}else{
									var mensajeEstado= "";
									if (datoItem.resultadoEMP>0 &&  datoItem.resultadoESA==0 && datoItem.estado_equipo==1) {
										mensajeEstado= "EQUIPO EN MANTENIMIENTO";
									}else if (datoItem.resultadoESA>0 && datoItem.resultadoEMP==0 && datoItem.estado_equipo==1) {
										mensajeEstado= "PROCESANDO SOLICITUD ACTUAL";
									}else if( datoItem.resultadoESA==0 && datoItem.resultadoEMP==0 && datoItem.estado_equipo==2){
										mensajeEstado= "EN ESPERA DE CONFIRMACIÓN DEL SOLICITANTE, SOBRE LA ENTREGA DEL EQUIPO";
									}
									var btn = $('<div class="list-group-item"  style="padding: 2px; background: blanchedalmond;">'+
										'<table style="margin:0px; ">'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Ubicación : </b></td><td>'+datoItem.cargoydepartamento+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Estado : </b></td><td>'+mensajeEstado+'</td></tr>'+
										'</table>'+
										'</div>');
								}							
								$('#equiposSolicitanteList').append(btn);


							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdSolicitud.paginaActualListEqPControl('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdSolicitud.paginaActualListEqPControl("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdSolicitud.paginaActualListEqPControl("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdSolicitud.paginaActualListEqPControl('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnEquiposSolicitanteList #pagination').append(ul);
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay equipo asignado </div>');
							tr.append("</div>");
							$('#equiposSolicitanteList').append(tr);					
							$('#asuntoTxt').attr('disabled', true);
							$('#descripcionTxt').attr('disabled', true);
							$('#btnSolicitar').attr('disabled', true);								
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
		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaEquiposDepartamento = function(_pagina_) {

			// Iniciando variables
			var accion_ = "cargarListaEquiposDepartamento";
			var id_departamento_ = $('#vtnSolicitud #departamentoListD').val();

			//
			var AccionarEstado="";
			var ColorEstado=""; 
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().solicitud.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						id_persona:sessionStorage.getItem("id_persona-US"),		
						id_departamento:id_departamento_,								
						tamagno_paginas:10,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#equiposResponsabilidadList").html('');				
			        $("#pgnEquiposResponsabilidadList #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#equiposResponsabilidadList').append(tr);

	            },
	            success:  function (data) {
		    
		            $("#equiposResponsabilidadList").html('');
		            $("#pgnEquiposResponsabilidadList #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								// validando si el equipo NO tiene atareas preventivas activadas
								// validando si el equipo NO tiene solicitudes activadas
								if (datoItem.resultadoEMP==0 && datoItem.resultadoESA==0 && datoItem.estado_equipo==1) {

									var btn = $('<div class="lista-equipo-solt list-group-item" id="equipoDpt'+datoItem.id_equipo+'"  style="padding: 2px;">'+
										'<table style="margin:0px; " >'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn+'</td><td></td><td class="col-md-2"><button type="button" id="btnDpt'+datoItem.id_equipo+'" class="lista-equipo-solt-actvr btn btn-default" style="padding: 0px 16px;" data-id_equipo="'+datoItem.id_equipo+'" > >> </button></td></tr>'+
										'</table>'+
										'</div>');

								}else{
									var mensajeEstado= "";
									if (datoItem.resultadoEMP>0 &&  datoItem.resultadoESA==0 && datoItem.estado_equipo==1) {
										mensajeEstado= "EQUIPO EN MANTENIMIENTO";
									}else if (datoItem.resultadoESA>0 && datoItem.resultadoEMP==0 && datoItem.estado_equipo==1) {
										mensajeEstado= "PROCESANDO SOLICITUD ACTUAL";
									}else if( datoItem.resultadoESA==0 && datoItem.resultadoEMP==0 && datoItem.estado_equipo==2){
										mensajeEstado= "EN ESPERA DE CONFIRMACIÓN DEL SOLICITANTE, SOBRE LA ENTREGA DEL EQUIPO";
									}
									var btn = $('<div class="list-group-item"  style="padding: 2px; background: blanchedalmond;">'+
										'<table style="margin:0px; ">'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Tipo : </b></td><td class="col-md-5">'+datoItem.tipo+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial : </b></td><td class="col-md-5">'+datoItem.serial+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Serial de bien nacional : </b></td><td class="col-md-5">'+datoItem.serial_bn+'</td></tr>'+
											'<tr class="row" style="font-size: x-small;"><td class="col-md-5"><b> Estado : </b></td><td>'+mensajeEstado+'</td></tr>'+
										'</table>'+
										'</div>');
								}	
								$('#equiposResponsabilidadList').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdSolicitud.paginaActualListEqPDptControlPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdSolicitud.paginaActualListEqPDptControlPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdSolicitud.paginaActualListEqPDptControlPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdSolicitud.paginaActualListEqPDptControlPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnEquiposResponsabilidadList #pagination').append(ul);
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay equipo en el departamento </div>');
							tr.append("</div>");
							$('#equiposResponsabilidadList').append(tr);				
							$('#asuntoTxt').attr('disabled', true);
							$('#descripcionTxt').attr('disabled', true);
							$('#btnSolicitar').attr('disabled', true);											
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
		var cargarListaDepartamentoACargo = function(_idCampo_,_nombreCampo_) {

			var accion_ ="cargarListaDepartamentoACargo";
	        $.ajax({
				url: configuracion.urlsPublic().solicitud.api,
				type:'POST',
				data:{
						accion:accion_,
						id_persona:sessionStorage.getItem("id_persona-US"),										
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
   					$('#'+_idCampo_).html('');	            	
					var noselect = $('<option data-subtext="" value="0" data-idcargo="0" >Seleccione una opción</option>');
	    			$('#'+_idCampo_).append(noselect);    		
	    			console.log(JSON.stringify(result));
    				$(result).each(function (index, datoItem) { 
    					$(datoItem.resultados).each(function (index, item) {
	    					//console.log(item);
	    					var opcion = $('<option data-subtext="'+/*_nombreCampo_+*/'"  value="'+item.id_departamento+'" data-idcargo="'+item.id_cargo+'" >'+item.cargoydepartamento+'</option>');
	    					$('#'+_idCampo_).append(opcion);
    					});
    				});

	            }
			}).fail(function (error) {
				console.log(JSON.stringify(error));
				alertas.dialogoErrorPublic(error.readyState,error.responseText);				
				console.log("Ocurrio un error");
			});
			//return $('#datoControl').val();
		}	

		/******************************************************************************************/
		var reinicioSelectEquiposDpt = function () {
				setTimeout(function(){ 
					mtdSolicitud.actListEquiposPublic();
					$('#vtnSolicitud #form').css("display", "block");
					$('#vtnSolicitud #procesandoDatosInputDatosDialg').css("display", "none");			
					//	
					mtdSolicitud.cargarListaDepartamentoACargoPublic('departamentoListD','');

					$('#departamentoListD').popover({
						    html: true, 
							placement: "right",
							content: function() {
						          return $('#procesandoDatosInput').html();
						        }
						});						
				  	$('#departamentoListD').popover('show');
				  	setTimeout(function () {
						  	$('#departamentoListD').popover('destroy');
						  	$('#departamentoListD').selectpicker('refresh');
						  	//

							$(document).ready(function() {
							  	$('#departamentoListD').selectpicker('refresh');
							    $('#listas .bootstrap-select ').each(function (index, datoItem) {

							        $(datoItem).attr('id','btnSelectElegido'+index);

							        $('#btnSelectElegido'+index).attr('style','width:100px;');

							        $('#btnSelectElegido'+index+' button').on('click',function () {
								        $('#btnSelectElegido'+index).css('width','100px');
							            
							            if($("#btnSelectElegido"+index+" .bs-searchbox input").length > 0 ) { 

						                    $('#btnSelectElegido'+index+' .bs-searchbox input').on('keyup',function () {

						                            if($("#btnSelectElegido"+index+" .no-results").length > 0 ) { 
						                                $("#btnSelectElegido"+index+" .no-results").html('');
						                                var filtro = $('#btnSelectElegido'+index+' .bs-searchbox input').val();
						                                $("#btnSelectElegido"+index+" .no-results").html('No hay resultados para " '+filtro+' " ');
						                            }
						                    });
							            }

							        });

							    });
						        $('#btnSelectElegido0').attr('style','width:100%;');
						        $('#btnSelectElegido1').attr('style','width:100%;');

							});

				  	}, 500);


				},500);				
		}
		var actListEquipos = function () {
			$('.lista-equipo-solt-actvr').on('click',function (item) {
				$('.lista-equipo-solt').removeClass('lista-equipo-solt-SELECT');				
				//
				var btnEquipo = item.target.id;				
				var id_equipo = $('#'+btnEquipo).data('id_equipo');
				$('#equipo'+id_equipo).addClass('lista-equipo-solt-SELECT');
				$('#btnSolicitar').data('id_equipo', id_equipo);
				$('#asuntoTxt').attr('disabled', false);
				$('#descripcionTxt').attr('disabled', false);
				$('#btnSolicitar').attr('disabled', false);										
				//
			});
		}
		var actListEquiposDpt = function () {
			$('.lista-equipo-solt-actvr').on('click',function (item) {
				$('.lista-equipo-solt').removeClass('lista-equipo-solt-SELECT');				
				//
				var btnEquipo = item.target.id;				
				var id_equipo = $('#'+btnEquipo).data('id_equipo');
				$('#equipoDpt'+id_equipo).addClass('lista-equipo-solt-SELECT');
				$('#btnSolicitar').data('id_equipo', id_equipo);
				$('#asuntoTxt').attr('disabled', false);
				$('#descripcionTxt').attr('disabled', false);
				$('#btnSolicitar').attr('disabled', false);
				//
			});
		}		
		//
		var paginaActualListEqPDptControl = function (_pagina_) {
			paginaActualListEqDpt = _pagina_;
			mtdSolicitud.cargarListaEquiposDepartamentoPublic(_pagina_);   
		}				
		var paginaActualListEqPControl = function (_pagina_) {
			paginaActualListEq = _pagina_;
			mtdSolicitud.cargarListaEquipoPersonaPublic(_pagina_);   
		}				
		var paginaControl = function (_pagina_) {
			paginaActual = _pagina_;
			mtdSolicitud.cargarCatalogoPublic(_pagina_);   
		}						
		//

		return{
			Iniciar: function () {
				if (consulta==false && mtdMantenimientoEquipo.getP().consulta==false) {
					mtdSolicitud.cargarListaEquipoPersonaPublic(1);
					mtdSolicitud.reinicioSelectEquiposDptPublic();		
				}
			},
			reinicioSelectEquiposDptPublic : reinicioSelectEquiposDpt,
			consultarPublic : consultar,
			paginaControlPublic : paginaControl,
			cargarCatalogoPublic : cargarCatalogo,
			guardarPublic : guardar,
			guardarConformidadPublic : guardarConformidad,
			cargarListaEquipoPersonaPublic : cargarListaEquipoPersona,
			paginaActualListEqPControlPublic : paginaActualListEqPControl,
			cargarListaEquiposDepartamentoPublic : cargarListaEquiposDepartamento,
			paginaActualListEqPDptControlPublic : paginaActualListEqPDptControl,
			actListEquiposPublic : actListEquipos,
			actListEquiposDptPublic : actListEquiposDpt,
			cargarListaDepartamentoACargoPublic : cargarListaDepartamentoACargo,

		}
	}();