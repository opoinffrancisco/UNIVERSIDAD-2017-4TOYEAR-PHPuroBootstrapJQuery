	var mtdTareaProgramada = function() {
		/* VARIABLES */
		var paginaActual = 1; // Pagina actual de la #paginacion
		var paginaActualTP = 1;
		var tamagno_paginas_ = 6; // Tamaño de filas por pagina #paginacion


		/* FUNCIONES */




		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarCatalogo = function(_pagina_) {


			var accion_ = "FiltrarListaAvanzada";

			var filtro_  = $("#ctlgTareaProgramada #buscardorTxt").val();

			var serialTxt_= "";
			var serialBienNTxt_= "";
			var tipoListD_= "";
			var modeloListD_= "";
			var cedulaTxt_= "";
			var cargoListD_= "";
			var departamentoListD_= "";
			var tareaListD_= "";


			if($('#ventana-modal').hasClass('ventana-modal-panel-accionMostrar')==true){
					// Iniciando variables
					//
					serialTxt_ 		= $("#vtnProcsBusqdAvanzd  #serialTxt").val();
					serialBienNTxt_ = $("#vtnProcsBusqdAvanzd  #serialBienNTxt").val();
					tipoListD_	= $("#vtnProcsBusqdAvanzd  #tipoListD").val();
					if (tipoListD_==0) {
						tipoListD_="";
					}			
					modeloListD_ 	= $("#vtnProcsBusqdAvanzd  #modeloListD").val();
					if (modeloListD_==0) {
						modeloListD_="";
					}
					cedulaTxt_ = $("#vtnProcsBusqdAvanzd  #cedulaTxt").val();

					cargoListD_	= $("#vtnProcsBusqdAvanzd  #cargoListD").val();
					if (cargoListD_==0) {
						cargoListD_="";
					}
					departamentoListD_ 	= $("#vtnProcsBusqdAvanzd  #departamentoListD").val();
					if (departamentoListD_==0) {
						departamentoListD_="";
					}
						/*********************************/
					tareaListD_	= $("#vtnProcsBusqdAvanzd  #tareaListD").val();
					if (tareaListD_==0) {
						tareaListD_="";
					}
						/*********************************/
					ventanaModal.ocultarPulico('ventana-modal');	

			}
			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
			// control paginacion
			var pagina_ = _pagina_;
			//
	        $.ajax({
				url: configuracion.urlsPublic().tareaProgramada.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						serial:serialTxt_,
						serialBienN:serialBienNTxt_,
						tipoListD:tipoListD_, 								
						modeloListD:modeloListD_,		
						cedulaTxt:cedulaTxt_,
						cargoListD:cargoListD_,
						departamentoListD:departamentoListD_,	
						tareaListD:tareaListD_,					
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgTareaProgramada #catalogoDatos").html('');				
			        $("#pgnTareaProgramada #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="7" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgTareaProgramada #catalogoDatos').append(tr);
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgTareaProgramada #catalogoDatos").html('');				
		            $("#pgnTareaProgramada #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
		   
		    					var estado = datoItem.estado_uso;							
		    					var estado_de_uso =  "";
		    					//
			    					var estado_btn_iniciado = "";
		    					//
		    					if (estado==1) {
			    					estado_btn_iniciado = " disabled='TRUE' ";
		    						estado_de_uso = "INICIADO";
		    						estado = 0;
									var btnAccionEstadoUso =	'	<div class="btn-group" role="group" style="width: 50%;">'+
																'	<button type="button"  class="btn btn-default iniciarFinalizarTareaBtnDiv" id="btnDetalles" onclick="mtdTareaProgramada.cambiarEstadoPublic('+datoItem.id_tarea_equipo+','+estado+',1);" style="width: 100%;border-radius:  0px 5px 5px 0px  ;">Finalizar</button>'+
																'	</div>';						
		    					} else {
		    						estado = 1;
		    						estado_de_uso = "SIN INICIAR";
									var btnAccionEstadoUso =	'	<div class="btn-group" role="group" style="width: 50%;">'+
																'		<button type="button" class="btn btn-default iniciarFinalizarTareaBtnDiv" id="btnIniciarTareaCtlg" onclick="$(this).attr(&#39;disabled&#39;,true),mtdTareaProgramada.cambiarEstadoPublic('+datoItem.id_tarea_equipo+','+estado+',0);" style="width: 100%;border-radius:  0px 5px 5px 0px  ;">Iniciar</button>'+
																'	</div>';						
		    					}
		    					var fontLetra = "";
		    					if (datoItem.solicitudActiva==1) {
		    						btnAccionEstadoUso = "<div style='width: 50%; float: right; display: block;'>EQUIPO EN MANTENIMIENTO</div>";
		    						fontLetra = "font-size: xx-small;";
		    					}
		    					if (datoItem.estado_equipo==2) {
		    						btnAccionEstadoUso = "<div style='width: 50%; float: right; display: block;'>ESPERANDO CONFIRMACIÓN DE ENTREGA</div>";
		    						fontLetra = "font-size: xx-small;";	
		    					};


	    						var colorDiasProximos = "";
	    						var diasMuestraProximidad=0;
		    					var resultadoCalculoMayorMenor = datoItem.resultadoCalculoMenorQueProximidad;
		    					if (resultadoCalculoMayorMenor==1 || resultadoCalculoMayorMenor==true) {
		    						// Color Amarillo si paso la fecha limite
		    						colorDiasProximos = " background: #FFEB3B; ";
		    						diasMuestraProximidad = datoItem.dias_restantes+'  días';
		    					}else{
	    							// Color verdes si falta para llegar a la fecha limite
		    						colorDiasProximos = " background: rgba(38, 247, 41, 0.61); ";
		    						diasMuestraProximidad = datoItem.dias_restantes+'  días';		    						
		    					};
	    						// Color rojo si se paso la fecha limite
		    					if (datoItem.control_vencimiento_fecha==1) {
		    						colorDiasProximos = " background: rgba(241, 36, 0, 0.58); ";
		    						diasMuestraProximidad = datoItem.dias_restantes+'  días';		    						
		    					};

		    					var proxima_fecha___ =	'	<div style="width: 100%;height: 50%;">'+
									'		<div class="row">'+
									'			<div class="col-md-6" style="border-right: 1px solid #bfbfbf;">'+
									'				Proxima: '+
									'			</div>'+
									'			<div class="col-md-0">'+
													datoItem.proxima_fecha+
									'			</div>'+
									'		</div>'+
									'	</div>';
								if (datoItem.tarea_correctiva==1) {
		    						colorDiasProximos = " white ";
		    						diasMuestraProximidad = "NO APLICA";
		    						proxima_fecha___ = "";
		    						btnAccionEstadoUso = "<div style='width: 50%; float: right; display: block;'>USO PARA MANTENIMIENTO CORRECTIVO</div>";
		    						fontLetra = "font-size: xx-small;";
								};

								tr = $('<tr class="row" >'+

									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">S : '+datoItem.serial+' <br>  B.N : '+datoItem.serial_bn+'</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+
										'<textarea disabled="true" style="background:transparent; resize:vertical;   margin-top: 0px; margin-bottom: 0px; height: 35px; width: 100%; border: 0px; overflow-y: hidden;">'+
											datoItem.tarea+
										'</textarea>'+											
									'</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
									'	<div style="width: 100%;height: 50%;">'+
									'		<div class="row">'+
									'			<div class="col-md-6" style="border-right: 1px solid #bfbfbf;border-bottom: 1px solid #bfbfbf;">'+
									'				Ultima: '+
									'			</div>'+
									'			<div class="col-md-0" style="border-bottom: 1px solid #bfbfbf;">'+
													datoItem.ultima_fecha+
									'			</div>'+
									'		</div>'+
									'	</div>'+
										proxima_fecha___+
									'</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;  " class="col-md-1"><div class="btn-group" role="group" style="width: 100%; '+colorDiasProximos+'"><b>'+diasMuestraProximidad+'</b></div></td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-1">'+estado_de_uso+'</td>'+
									'<td style=" padding: 5px; text-align: center;vertical-align:middle; '+fontLetra+'" class="col-md-3">'+
									'	<div class="btn-group editarBtnDiv" role="group" style="width: 50%;float: left;">'+
									'		<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdTareaProgramada.consultarPublic('+datoItem.id_tarea_equipo+');" style="width: 100%;border-radius: 5px 0px 0px  5px;" '+estado_btn_iniciado+'>Editar</button>'+
									'	</div>'+
										btnAccionEstadoUso+
									'</td>');

								tr.append("</tr>");

								$('#ctlgTareaProgramada #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdTareaProgramada.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdTareaProgramada.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdTareaProgramada.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>" 
														);
											}
									}
								}
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdTareaProgramada.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnTareaProgramada #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(4);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="7" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgTareaProgramada #catalogoDatos').append(tr);
							//-------------
							if (filtro_!=""){
								$("#ctlgTareaProgramada #btnNuevo").prop('disabled', false);
								$("#ctlgTareaProgramada #btnNuevo").addClass('imputSusess');
							}else{
								$("#ctlgTareaProgramada #btnNuevo").prop('disabled', true);
								$("#ctlgTareaProgramada #btnNuevo").removeClass('imputSusess');
							}
					}
	            },
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}


		var id_tarea_equipoG=0;
		var _estadoG=0;
		var _observacionG=0;
		/*
			ciambia el estado a Iniciado al darle (Iniciar) a Sin Iniciar(al darle finalizar)
			
			variables globales, definidas arriba de la funcion
		*/
		var cambiarEstado = function(id_tarea_equipo_,_estado_,_observacion_) {
			var accion_ = "cambiarEstado";
			var datoAccionado = "";
			//
			switch(_observacion_) {
				case 0:
						datoAccionado="INICIO";
				break;
			    case 1:
						//----------
						id_tarea_equipoG = id_tarea_equipo_;
						_estadoG = _estado_;
						//----------
						ventanaModal.cambiaMuestraVentanaModalCapa2Public("procesos/tareasProgramadas/ventanasModales/vtnMGestionTareasProgramadas-FinalizarTarea.php",1,1);				
						$('#vtnFinalizarTarea #observacionTxt').val('');
						return false;
			        break;
			    case 2:
						datoAccionado="FINALIZO";

						id_tarea_equipo_ = id_tarea_equipoG;
						_estado_= _estadoG ;
						_observacion_ = $('#vtnFinalizarTarea #observacionTxt').val();
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
				url: configuracion.urlsPublic().tareaProgramada.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),
						estado_uso:_estado_,
						id_tarea_equipo:id_tarea_equipo_,
						observacion:_observacion_,
					},
	            beforeSend: function () {
					$('#vtnFinalizarTarea #form').css("display", "none");
					$('#vtnFinalizarTarea #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					var detalles_ = "";
					var estadoEjecucion=0;
					if (_observacion_==0) { 
						estadoEjecucion = 19;
						detalles_ = datoAccionado+" LA TAREA :'"+data[0].nombreTarea+"' AL EQUIPO CON EL SERIAL :"+data[0].serialEquipoTarea;
						nucleo.guardarBitacoraPublic(detalles_);
					}else{
						estadoEjecucion = 20;
						detalles_ = datoAccionado+" LA TAREA :'"+data[0].nombreTarea+"' AL EQUIPO CON EL SERIAL :"+data[0].serialEquipoTarea+" - Y OBSERVO QUE :"+_observacion_;
						nucleo.guardarBitacoraPublic(detalles_);
					};						

					/*
						PARAMETROS:
							1 - ESTADO MANTENIMIENTO
							2 - TIPO DE MANTENIMIENTO
							3 - ID_TAREA_EQUIPO
							4 - ID_SOLICITUD
							5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
							6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
					*/
					nucleo.guardarPersonaEjecutaTareaPPublic(detalles_,estadoEjecucion,data[0].id_mantenimiento);

					ventanaModal.ocultarPulico('ventana-modal-capa2');
					mtdTareaProgramada.controlPaginacionPublic(paginaActual);
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
+			Mostrar edicion o tipico Consultar

		*/
		var consultar = function (id_tarea_equipo_) {

			ventanaModal.cambiaMuestraVentanaModalPublic("procesos/tareasProgramadas/ventanasModales/vtnMGestionTareasProgramadas.php",1,1)
			mtdTareaProgramada.iniciarPanelTabEquiposPublic();				
			var accion_ = "consultar";
			
			//
	        $.ajax({
				url: configuracion.urlsPublic().tareaProgramada.api,
				type:'POST',	
				data:{
						accion:accion_,
						id_tarea_equipo:id_tarea_equipo_,
					},
	            beforeSend: function () {
					$('#vtnTareasProgramadas #form').css("display", "none");
					$('#vtnTareasProgramadas #procesandoDatosDialg').css("display", "block");
	            },
	            success:  function (data) {

					console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
	
		    				$(dato.resultado).each(function (index, datoItem) {   
										mtdTareaProgramada.iniciarPanelTabTareaPreventivaCorrectivosPublic();
	
								$('#tabs_tareasPC').css('display', 'none');
								$('#btnGuardarProgramacion').data('guardar_editar', 1);
								$('#catalogoVtnTP').html('');								  				

		    					setTimeout(function() {

		    						var id_marca = datoItem.id_marca;

									//------------------------------------
									$('#vtnTareasProgramadas #serialTxt').val(datoItem.serial);
									$('#vtnTareasProgramadas #serialBienNTxt').val(datoItem.serial_bn);
									$("#vtnTareasProgramadas #marcaListD option[value="+id_marca+"]").attr("selected",true);
									nucleo.cargarListaDespegableListasAnidadaPublic('modeloListD','cfg_c_fisc_modelo','id_marca',id_marca,''); 
									$("#vtnTareasProgramadas #tipoListD option[value="+datoItem.id_tipo+"]").attr("selected",true);
									//------------------------------------
									$('#vtnTareasProgramadas #cedulaTxt').val(datoItem.cedula);
			   						$("#vtnTareasProgramadas #cargoListD option[value="+datoItem.id_cargo+"]").attr("selected",true);
			   						$("#vtnTareasProgramadas #departamentoListD option[value="+datoItem.id_departamento+"]").attr("selected",true);		   								   								   						
									//------------------------------------
									$('#tiempoEstimadoTxt').val(datoItem.tiempo_estimado);
									$('#frecuenciaTxt').val(datoItem.frecuencia);
									$('#ultimaFechaTxt').val(datoItem.ultima_fecha);
									$('#proximaFechaTxt').val(datoItem.proxima_fecha); 
									//------------------------------------
									var id_tarea = datoItem.id_tarea;
			   						$("#vtnTareasProgramadas #tareaListD option[value="+id_tarea+"]").attr("selected",true);
									mtdTareaProgramada.consultarTareaPublic(id_tarea);

									if (datoItem.tarea_correctiva==1) {
										$('#tipoTareaCorrectiva').css('display', 'block');											
										$('#tipoTareaPreventiva').css('display', 'none');
										$('#vtnTareasProgramadas .divFrecuencia').css('display', 'none');
										$('#vtnTareasProgramadas .divFrecuencia').addClass('sin-frecuencia');																				
									} else{
										$('#tipoTareaCorrectiva').css('display', 'none');											
										$('#tipoTareaPreventiva').css('display', 'block');
										$('#vtnTareasProgramadas .divFrecuencia').css('display', 'block');
										$('#vtnTareasProgramadas .divFrecuencia').removeClass('sin-frecuencia');										
									};




									//------------------------------------		
									$('#btnGuardarProgramacion').data('id_equipo',datoItem.id_equipo);
									$('#btnGuardarProgramacion').data('id_tarea',datoItem.id_tarea);
									//------------------------------------
								  	$('#marcaListD').selectpicker('refresh');
								  	$('#tipoListD').selectpicker('refresh');
								  	$('#cargoListD').selectpicker('refresh');
								  	$('#departamentoListD').selectpicker('refresh');
								  	$('#tareaListD').selectpicker('refresh'); 

				   					setTimeout(function () {
								  		$('#modeloListD').selectpicker('refresh');
								  		setTimeout(function () {								  			
				   							$("#vtnTareasProgramadas #modeloListD option[value="+datoItem.id_modelo+"]").attr("selected",true);
								  			setTimeout(function () {
								  				$('#modeloListD').selectpicker('refresh');
								  				//
												$('#vtnTareasProgramadas #serialTxt').attr('disabled', true);												
												$('#vtnTareasProgramadas #serialBienNTxt').attr('disabled', true);
						   						$("#vtnTareasProgramadas #marcaListD ").attr("disabled",true);
						   						$("#vtnTareasProgramadas #modeloListD ").attr("disabled",true);
						   						$("#vtnTareasProgramadas #tipoListD ").attr("disabled",true);
						   						$("#vtnTareasProgramadas #cedulaTxt ").attr("disabled",true);
						   						$("#vtnTareasProgramadas #cargoListD ").attr("disabled",true);
						   						$("#vtnTareasProgramadas #departamentoListD ").attr("disabled",true);
						   						$("#vtnTareasProgramadas #tareaListD ").attr("disabled",true);				
						   						
								  			},500);
								  		}, 500);
				   					});

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
		
		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var busquedaAvanvadaTP = function(_pagina_) {

			var accion_ = "BusquedaAvanzadaLista";

			// Iniciando variables
			var serialTxt_ 		= $("#vtnTareasProgramadas  #serialTxt").val();
			var serialBienNTxt_ = $("#vtnTareasProgramadas  #serialBienNTxt").val();
			var tipoListD_	= $("#vtnTareasProgramadas  #tipoListD").val();
			if (tipoListD_==0) {
				tipoListD_="";
			}			
			var modeloListD_ 	= $("#vtnTareasProgramadas  #modeloListD").val();
			if (modeloListD_==0) {
				modeloListD_="";
			}
			var cedulaTxt_ = $("#vtnTareasProgramadas  #cedulaTxt").val();

			var cargoListD_	= $("#vtnTareasProgramadas  #cargoListD").val();
			if (cargoListD_==0) {
				cargoListD_="";
			}
			var departamentoListD_ 	= $("#vtnTareasProgramadas  #departamentoListD").val();
			if (departamentoListD_==0) {
				departamentoListD_="";
			}
				/*********************************/
				var tareaListD_	= "";
				if ($('#tab-tPreventivas').hasClass('active')) {
					tareaListD_	= $("#vtnTareasProgramadas  #tareaListD").val();		
				} else{
					tareaListD_	= $("#vtnTareasProgramadas  #tareaListDCorrectivas").val();		
				};

			

			/*
				if (tareaListD_==0) {
					tareaListD_="";
				}

			*/
				/*********************************/

			//console.log(  cedulaTxt_+' ---- '+cargoListD_+' ---- '+departamentoListD_);

			// control paginacion
			var pagina_ = _pagina_;
			//
	        $.ajax({
				url: configuracion.urlsPublic().tareaProgramada.api,
				type:'POST',	
				data:{	
						accion:accion_,
						serial:serialTxt_,
						serialBienN:serialBienNTxt_,
						tipoListD:tipoListD_, 								
						modeloListD:modeloListD_,		
						cedulaTxt:cedulaTxt_,
						cargoListD:cargoListD_,
						departamentoListD:departamentoListD_,
						tareaListD:tareaListD_,						
						tamagno_paginas:2000,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgVTNProcsTP #catalogoDatos").html('');				
			        $("#pngVTNProcsTP #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgVTNProcsTP #catalogoDatos').append(tr);
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgVTNProcsTP #catalogoDatos").html('');				
		            $("#pngVTNProcsTP #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
							
								tr = $('<tr class="row fila-equipo" id="equipo'+datoItem.id_equipo+'"  data-id_equipo="'+datoItem.id_equipo+'" >'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
										'<div style="width: 100%;height: 50%;">'+
											'<div class="row">'+
												'<div class="col-md-2" style="border-right: 1px solid #bfbfbf;border-bottom: 1px solid #bfbfbf;">'+
													'S'+
												'</div>'+
												'<div class="col-md-10" style="border-bottom: 1px solid #bfbfbf;">'+
													datoItem.serial+
												'</div>'+
											'</div>'+
										'</div>'+
										'<div style="width: 100%;height: 50%;">'+
											'<div class="row">'+
												'<div class="col-md-2" style="border-right: 1px solid #bfbfbf;">'+
													'B.N.'+
												'</div>'+
												'<div class="col-md-10">'+
													datoItem.serial_bn+
												'</div>'+
											'</div>'+
										'</div>'+
									'</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4"> '+datoItem.cedula+' <br> ('+datoItem.nombreApellido+')</td>'+
									'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+datoItem.cargoDepartamento+'</td>');
								tr.append("</tr>");

								$('#ctlgVTNProcsTP #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdTareaProgramada.controlPaginacionTPPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdTareaProgramada.controlPaginacionTPPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdTareaProgramada.controlPaginacionTPPublic("+i+")' >"+ i +"</a>"+
															"</li>" 
														);
											}
									}
								}
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdTareaProgramada.controlPaginacionTPPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngVTNProcsTP #pagination').append(ul);

						});
						$('#btnGuardarProgramacion').attr('disabled', false);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgVTNProcsTP #catalogoDatos').append(tr);
							$('#btnGuardarProgramacion').attr('disabled', true);
					}
	            },
		    	error:  function(error) {
					console.log(JSON.stringify(error));	
					alertas.dialogoErrorPublic(error.readyState,error.responseText);						
			    }	            
			});
	        //
			//e.preventDefault();
			return false;
		}
		/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
		*/	
		var consultarTarea = function(id_tarea_) {

			var accion_ = "consultar";

	        $.ajax({
				url: configuracion.urlsPublic().modTareas.tabs.tarea.api,
				type:'POST',	
				data:{
						accion:accion_,
						id:id_tarea_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));

					$('#listas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listas').popover('show');
	            	/////
					$("#vtnTareasProgramadas #nombreTareaTxt").val(data[0].nombre); 
					$("#vtnTareasProgramadas #descripcionTareaTxt").val(data[0].descripcion); 
	            	$('#listas').popover('destroy');


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
			
			$('#vtnTareasProgramadas #form').on('submit', function(e) {
				e.preventDefault();
				/* Obtener valores de los campos del formulario*/
				//

				var tiempo_estimado_ = $('#tiempoEstimadoTxt').val();
				var frecuencia_ = $('#frecuenciaTxt').val();
				if (tiempo_estimado_=="") {
					nucleo.alertaErrorPublic(" Ingresar tiempo estimado");					
					return false;
				}
				if($('.divFrecuencia').hasClass('sin-frecuencia')==false){
					if (frecuencia_=="") {
						nucleo.alertaErrorPublic(" Ingresar frecuencia");
						return false;
					}				
				}else{
					frecuencia_=0;
				}
				$('#vtnTareasProgramadas #btnGuardarProgramacion').attr('disabled', true);
				// obteniendo IDs				
				if ($('#btnGuardarProgramacion').data('guardar_editar')>0) {

					var accion_ = "editar";

					var id_tarea_  = $('#btnGuardarProgramacion').data('id_tarea');
					var id_equipo_ = $('#btnGuardarProgramacion').data('id_equipo');

				} else {

					var accion_ = "guardar";

					var id_tarea_	= "";
					if ($('#tab-tPreventivas').hasClass('active')) {
						id_tarea_	= $("#vtnTareasProgramadas  #tareaListD").val();		
					} else{
						id_tarea_	= $("#vtnTareasProgramadas  #tareaListDCorrectivas").val();		
					};

					if ($('#vtnTareasProgramadas .fila-equipo').length>0) {
						
						var id_equipo_ = [];

						var seleccionados=0;
				   		var controlNoGuarda=0;

						$('#vtnTareasProgramadas .fila-equipo').each(function (index, datoItem){

							var idItem = $(datoItem).attr("id");
							var id_equipo = $('#'+idItem).data('id_equipo');

							if ( id_equipo!=null || id_equipo!="" ) {

								id_equipo_.push(id_equipo);

							}
							seleccionados=seleccionados+1;

						});
						console.log('Cantidad: '+id_equipo_.length+' array: equipos: '+id_equipo_+'  seleccionados: '+seleccionados);
						if (id_equipo_.length<1 || seleccionados==0){
							var id_equipo_=0;
						};

					}else{
						var id_equipo_=0;
						nucleo.alertaErrorPublic("No hay equipo en la lista");
						return false;
					};

				}
				//
		    $.ajax({
					url: configuracion.urlsPublic().tareaProgramada.api,
					type:'POST',	
					data:{	
					accion:accion_,
					ip_cliente:sessionStorage.getItem("ip_cliente-US"),
					id_usuario:sessionStorage.getItem("idUsuario-US"),	
					id_equipo:JSON.stringify(id_equipo_),
					id_tarea:id_tarea_,	
					tiempo_estimado:tiempo_estimado_,	
					frecuencia:frecuencia_,						

						},
	                beforeSend: function () {
						$('#vtnAsignar #form').css("display", "none");
						$('#vtnAsignar #procesandoDatosDialg').css("display", "block");
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
							$('#vtnTareasProgramadas #btnGuardarProgramacion').attr('disabled', false);
							nucleo.alertaExitoPublic(result[0].detalles);
							ventanaModal.ocultarPulico('ventana-modal');
							$("#catalogoDatos").html('');				
							$("#pagination").html('');	
							mtdTareaProgramada.cargarCatalogoPublic(paginaActual);
							return true;	                    
						}else{
							$('#vtnTareasProgramadas #btnGuardarProgramacion').attr('disabled', false);
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

		/* CONTROL */

		var cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva = function(_idCampo_,tipo_tarea_) {

				switch(tipo_tarea_){
					case 'correctiva':
						$('#vtnTareasProgramadas .divFrecuencia').css('display', 'none');
						$('#vtnTareasProgramadas .divFrecuencia').addClass('sin-frecuencia');										
					break;
					case 'preventiva' :
						$('#vtnTareasProgramadas .divFrecuencia').css('display', 'block');
						$('#vtnTareasProgramadas .divFrecuencia').removeClass('sin-frecuencia');
					break;
				}
				var accion_ ="cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva";
				$.ajax({
					url: configuracion.urlsPublic().tareaProgramada.api,
					type:'POST',
					data:{
						accion:accion_,
						tipo_tarea:tipo_tarea_,
					},
					beforeSend: function () {
					// cargando
					},
					success:  function (result) {
						console.log(JSON.stringify(result));
						$('select#'+_idCampo_).html('');	            	
						$(result).each(function (index, datoItem) { 
							$(datoItem.resultados).each(function (index, item) {
								//console.log(item);
								var opcion = $('<option id="'+item.id+'" value="'+item.id+'">'+item.nombre+'</option>');
								$('select#'+_idCampo_).append(opcion);
							});
						});
					}
					}).fail(function (error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);				
						console.log("Ocurrio un error");
				});
		}


		var iniciarPanelTabEquipos = function () {

				mtdAsignar.filtrarSelectPublic();


			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','');
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','');
			  	nucleo.cargarListaDespegableListasPublic('departamentoListD','cfg_departamento','');
			  	nucleo.cargarListaDespegableListasPublic('cargoListD','cfg_pn_cargo','');

				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#tipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	
				$('#departamentoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});											
					$('#cargoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});						
	 
		     	$('#marcaListD').popover('show');
			  	$('#modeloListD').popover('show');
			  	$('#departamentoListD').popover('show');
			  	$('#cargoListD').popover('show');
			  	$('#tipoListD').popover('show');

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#departamentoListD').popover('destroy');
				  	$('#cargoListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');


				  	$('#marcaListD').selectpicker('refresh');
				  	$('#departamentoListD').selectpicker('refresh');
				  	$('#cargoListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');
			        $('#btnSelectElegido4').attr('style','width:100%;');
			        $('#btnSelectElegido5').attr('style','width:100%;');

			    }, 600);


				$(document).ready(function() {

				  	$('#marcaListD').selectpicker('refresh');
				  	$('#modeloListD').selectpicker('refresh');
				  	$('#departamentoListD').selectpicker('refresh');
				  	$('#cargoListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');



				    $('#listas .bootstrap-select ').each(function (index, datoItem) {

				        $(datoItem).attr('id','btnSelectElegido'+index);


				        $('#btnSelectElegido'+index+' button').on('click',function () {
				            
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

				});
		}
		var iniciarPanelTabTareaPreventivaCorrectivos = function () {

		  	nucleo.cargarListaDespegableUtf8EncodePublic('tareaListD','cfg_tarea');
					$('#tareaListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					})
		        	$('#tareaListD').popover('show');

					  	$('#tareaListD').selectpicker('refresh');

					    $('#listas .bootstrap-select ').each(function (index, datoItem) {

					        $(datoItem).attr('id','btnSelectElegido0');


					        $('#btnSelectElegido0 button').on('click',function () {
					            
					            if($("#btnSelectElegido0 .bs-searchbox input").length > 0 ) { 

					                    $('#btnSelectElegido0 .bs-searchbox input').on('keyup',function () {

					                            if($("#btnSelectElegido0 .no-results").length > 0 ) { 
					                                $("#btnSelectElegido0 .no-results").html('');
					                                var filtro = $('#btnSelectElegido0 .bs-searchbox input').val();
					                                $("#btnSelectElegido0 .no-results").html('No hay resultados para " '+filtro+' " ');
					                            }


					                    });

					            }

					        });
					     	setTimeout(function () {

						        $('#tareaListD').popover('destroy');

							  	$('#tareaListD').selectpicker('refresh');

						        $('#btnSelectElegido0').attr('style','width:100%;');
						        $('#tPreventivas #btnSelectElegido0').attr('onclick',"mtdTareaProgramada.consultarTareaPublic($('#tareaListD').val())");

						    }, 600);
					    });

					    $('#tareaListD').on('change',function() {
											mtdTareaProgramada.consultarTareaPublic($('#tareaListD').val());
					    });
		}
		var iniciarPanelTabTareaPreventiva = function () {

		  	mtdTareaProgramada.cargarListaDespegableUtf8EncodeTareaPreventivaCorrectivaPublic('tareaListD','preventiva');
					$('#tareaListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					})
		        	$('#tareaListD').popover('show');

					  	$('#tareaListD').selectpicker('refresh');

					    $('#listas .bootstrap-select ').each(function (index, datoItem) {

					        $(datoItem).attr('id','btnSelectElegido0');


					        $('#btnSelectElegido0 button').on('click',function () {
					            
					            if($("#btnSelectElegido0 .bs-searchbox input").length > 0 ) { 

					                    $('#btnSelectElegido0 .bs-searchbox input').on('keyup',function () {

					                            if($("#btnSelectElegido0 .no-results").length > 0 ) { 
					                                $("#btnSelectElegido0 .no-results").html('');
					                                var filtro = $('#btnSelectElegido0 .bs-searchbox input').val();
					                                $("#btnSelectElegido0 .no-results").html('No hay resultados para " '+filtro+' " ');
					                            }


					                    });

					            }

					        });
					     	setTimeout(function () {

						        $('#tareaListD').popover('destroy');

							  	$('#tareaListD').selectpicker('refresh');

						        $('#btnSelectElegido0').attr('style','width:100%;');
						        $('#tPreventivas #btnSelectElegido0').attr('onclick',"mtdTareaProgramada.consultarTareaPublic($('#tareaListD').val())");

						    }, 600);
					    });

					    $('#tareaListD').on('change',function() {
							mtdTareaProgramada.consultarTareaPublic($('#tareaListD').val());
					    });
		}
		var iniciarPanelTabTareaCorrectiva = function () {

		  	mtdTareaProgramada.cargarListaDespegableUtf8EncodeTareaPreventivaCorrectivaPublic('tareaListDCorrectivas','correctiva');
					$('#tareaListDCorrectivas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					})
		        	$('#tareaListDCorrectivas').popover('show');

					  	$('#tareaListDCorrectivas').selectpicker('refresh');

					    $('#listas .bootstrap-select ').each(function (index, datoItem) {

					        $(datoItem).attr('id','btnSelectElegido1');


					        $('#tCorrectivas #btnSelectElegido1 button').on('click',function () {
					            
					            if($("#tCorrectivas #btnSelectElegido1 .bs-searchbox input").length > 0 ) { 

					                    $('#tCorrectivas #btnSelectElegido1 .bs-searchbox input').on('keyup',function () {

					                            if($("#tCorrectivas #btnSelectElegido1 .no-results").length > 0 ) { 
					                                $("#tCorrectivas #btnSelectElegido1 .no-results").html('');
					                                var filtro = $('#tCorrectivas #btnSelectElegido1 .bs-searchbox input').val();
					                                $("#tCorrectivas #btnSelectElegido1 .no-results").html('No hay resultados para " '+filtro+' " ');
					                            }


					                    });

					            }

					        });
					     	setTimeout(function () {

						        $('#tareaListDCorrectivas').popover('destroy');

							  	$('#tareaListDCorrectivas').selectpicker('refresh');

						        $('#tCorrectivas #btnSelectElegido1').attr('style','width:100%;');
						        $('#tCorrectivas #btnSelectElegido1').attr('onclick',"mtdTareaProgramada.consultarTareaPublic($('#tareaListDCorrectivas').val())");
																	        
						    }, 600);
					    });

					    $('#tareaListDCorrectivas').on('change',function() {
											mtdTareaProgramada.consultarTareaPublic($('#tareaListDCorrectivas').val());
					    });
  
		}


		var controlPaginacionTP = function (_pagina_) {
			paginaActualTP = _pagina_;
			mtdTareaProgramada.busquedaAvanvadaTPPublic(_pagina_);   
		}	
		var controlPaginacion = function (_pagina_) {

			paginaActual = _pagina_;
			mtdTareaProgramada.cargarCatalogoPublic(_pagina_);   
		}	

		return{
			Iniciar :function () {
				mtdTareaProgramada.cargarCatalogoPublic(1);
				mtdTareaProgramada.guardarPublic();
				mtdTareaProgramada.iniciarPanelTabTareaPreventivaPublic();
				mtdTareaProgramada.iniciarPanelTabEquiposPublic();				
			},
			cargarListaDespegableUtf8EncodeTareaPreventivaCorrectivaPublic : cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva,
			iniciarPanelTabTareaPreventivaCorrectivosPublic : iniciarPanelTabTareaPreventivaCorrectivos,
			iniciarPanelTabTareaPreventivaPublic : iniciarPanelTabTareaPreventiva,
			iniciarPanelTabTareaCorrectivaPublic : iniciarPanelTabTareaCorrectiva,
			iniciarPanelTabEquiposPublic : iniciarPanelTabEquipos,
			consultarTareaPublic : consultarTarea,
			consultarPublic : consultar,
			busquedaAvanvadaTPPublic : busquedaAvanvadaTP,
			controlPaginacionTPPublic : controlPaginacionTP,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			guardarPublic : guardar,
			cambiarEstadoPublic : cambiarEstado,
		}
	}();
