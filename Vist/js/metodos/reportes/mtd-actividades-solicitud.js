	var mtdActividadesSolicitud = function () {

		/***************************Variables globales*************************/

		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 6; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
		var consulta = false;

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
				url: 'Ctrl/reportes/ctrl-actividades-solicitud.php',
				type:'GET',	
				data:{	
						cfg:accion_,
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
								var btnGenerarReporte = "";	
								//
								btnConsultarDetalles = '<button type="button" class="btn btn-default detallesBtnDiv" id="btnDetalles" onclick="mtdActividadesSolicitud.detallesPublic('+datoItem.id_solicitud+',1)" style="width: 35%; padding:1px;">Detalles</button>';
								btnGenerarReporte = '<button type="button" class="btn btn-default atenderBtnDiv" id="btnDetalles" onclick="mtdActividadesSolicitud.generarProcesoFiltrarPublic('+datoItem.id_solicitud+')" style="width: 65%; padding:1px;"  >Generar reporte</button>';
								/***********************************************/								
								tr = $('<tr class="row " >'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
										'<textarea disabled="true" style="background:transparent; resize:vertical;   margin-top: 0px; margin-bottom: 0px; height: 35px; width: 100%; border: 0px; overflow-y: hidden;">'+
											datoItem.asunto+
										'</textarea>'+									
									'</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
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
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-1">'+datoItem.fecha+'</td>'+						
									'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-3">'+
										'<div class="btn-group" role="group" style="width: 100%;">'+
											btnConsultarDetalles+											
											btnGenerarReporte+										
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
									 			'<a href="JavaScript:;" onclick="mtdActividadesSolicitud.paginaControlPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdActividadesSolicitud.paginaControlPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdActividadesSolicitud.paginaControlPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdActividadesSolicitud.paginaControlPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
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
			Mostrar edicion o tipico Consultar

		*/
		var detalles = function (id_solicitud_,_tipoCapa_) {

			consulta=true;
			if(_tipoCapa_==1){
				ventanaModal.cambiaMuestraVentanaModalPublic("reportes/Operativos/solicitud/ventanasModales/vtnMGestionSolicitud.php",1,1);
			}else{
				id_solicitud_ = $('#datoControlIdSolicitud').val();
				ventanaModal.cambiaMuestraVentanaModalCapa2Public("reportes/Operativos/solicitud/ventanasModales/vtnMGestionSolicitud.php",1,1);				
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
																						   '<input type="text" class="form-control" disabled="TRUE" value="'+datoConfor.observacion+'">'+
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

		/******************************************************************************************/

		var paginaControl = function (_pagina_) {
			paginaActual = _pagina_;
			mtdActividadesSolicitud.cargarCatalogoPublic(_pagina_);   
		}				
		//

		var generarProcesoFiltrar = function(id_solicitud) {

			//
			var _TITULO_ = "ACTIVIDADES DE LA SOLICITUD";
			//
			var _configuracion_ = "CFG-ACTIVIDADES-SOLICITUD";
			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");        	
			var datos = {
						accionNucleo:"encriptarDatosRPT",
						u 			: 	usuario_,
						cfg 		: 	_configuracion_,
						tt 			:	_TITULO_,
						cant_datosbd: 	1,		
						tabla 		: 	"",
						cant_datos	: 	1,
						dato_1		:	id_solicitud,
						campo_1 	: 	"",			
					};					
			var datosEncrypt = reportes.encriptarDatosRPTPublic(datos);

			var win = window.open(configuracion.urlsPublic().modReporte.tabs.actividadesSolicitud.api+'?cfg='+_configuracion_+'&datos='+datosEncrypt);
			win.focus();
		}
		return{
			Iniciar: function () {

			},
			detallesPublic : detalles,
			paginaControlPublic : paginaControl,
			cargarCatalogoPublic : cargarCatalogo,		
			getP : get,
			generarProcesoFiltrarPublic : generarProcesoFiltrar,
		}
	}();