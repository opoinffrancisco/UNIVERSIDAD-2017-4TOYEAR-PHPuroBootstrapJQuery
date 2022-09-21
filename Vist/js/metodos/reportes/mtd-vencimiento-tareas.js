var mtdVencimientoTareas = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 12; // Tamaño de filas por pagina #paginacion
		var atcBusqdAvanzada= 0;
		var atcPaginacionCtlg = 0;

		/*******************************/

	/******************************** NOTAS *******************************/
	/*
				---
	*/
	/***************************Metodos de funcionalidades******************/	

		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var filtro_tarea_         = $("#ctlgRtpVT #tareaListD").val();
			var filtro_seria_e_       = $("#ctlgRtpVT #buscardorTxt").val();
			var filtro_desde_         = $("#ctlgRtpVT #fecha_desde").val();
			var filtro_hasta_         = $("#ctlgRtpVT #fecha_hasta").val();
			//
			if (filtro_tarea_==0) {
				filtro_tarea_="";
			};
			console.log(filtro_tarea_);
			console.log(filtro_seria_e_);
			console.log(filtro_desde_);
			console.log(filtro_hasta_);
			//
			var accion_ = "FiltrarLista";				
			//
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
				url: configuracion.urlsPublic().modReporte.tabs.vencimientoTarea.api ,
				type:'GET',	
				data:{	
						cfg:accion_,
						filtro_tarea:filtro_tarea_,
						filtro_seria_e:filtro_seria_e_,
						filtro_desde:filtro_desde_,
						filtro_hasta:filtro_hasta_,		
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgRtpVT #catalogoDatos").html('');				
			        $("#pngRtpVT #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgRtpVT #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgRtpVT #catalogoDatos").html('');				
		            $("#pngRtpVT #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   

	    						var colorDiasProximos = "";
	    						var diasMuestraProximidad=0;
		    					if (datoItem.amarillo==1 && datoItem.rojo==0) {
		    						// Color Amarillo si paso la fecha limite
		    						colorDiasProximos = " background: #FFEB3B; ";
		    						diasMuestraProximidad = datoItem.dias_intervalo+' días por vencer';
		    					}
		    					// Color rojo si se paso la fecha limite
		    					if (datoItem.amarillo==1 && datoItem.rojo==1) {
		    						colorDiasProximos = " background: rgba(241, 36, 0, 0.58); ";
		    						diasMuestraProximidad = datoItem.dias_intervalo+' días vencidos';
		    						if (datoItem.dias_intervalo==0) {
			    						colorDiasProximos = " background: #FFEB3B; ";		    							
			    						diasMuestraProximidad = ' Dia limite ';
		    						};
		    					};



					tr = $('<tr class="row">'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;  " class="col-md-3">'+
									'<div class="btn-group" role="group" style="width: 90%; '+colorDiasProximos+'">'+
										'<b>'+diasMuestraProximidad+'</b>'+
									'</div>'+
								'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-7">'+datoItem.nombre+'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+datoItem.serial+'</td>'+
							'</tr>');						
							$('#ctlgRtpVT #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdVencimientoTareas.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdVencimientoTareas.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdVencimientoTareas.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdVencimientoTareas.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngRtpVT #pagination').append(ul);
						});
						$("#ctlgRtpVT #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(6);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgRtpVT #catalogoDatos').append(tr);
							//-------------
							// sin datos no se generan reportes
							$("#ctlgRtpVT #btnGenerarReporte").prop('disabled', true);							
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
		var controlPaginacion = function (_pagina_) {
			if (atcBusqdAvanzada==1) {
				atcPaginacionCtlg = 1;				
			}else{
				atcPaginacionCtlg = 0;
			}
			paginaActual = _pagina_;
			mtdVencimientoTareas.cargarCatalogoPublic(_pagina_);   
		}	
		var vaciarCatalogo = function() {
				
				$("#catalogoDatos").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
		}			


		/**************** Gestion de reporte *******************/

		var generarProcesoFiltrar = function() {

			//Filtros
			var id_tarea = $('#tareaListD').val();
			var serial_e = $('#buscardorTxt').val();
			var fecha_desde = $('#fecha_desde').val();
			var fecha_hasta = $('#fecha_hasta').val();
			//
			var _TITULO_ = "VENCIMEINTO DE TAREAS";
			var _configuracion_ = "CFG-VENCIMEINTO-TAREA";
			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");        	
			var datos = {
						accionNucleo:"encriptarDatosRPT",
						u 			: 	usuario_,
						cfg 		: 	_configuracion_,
						tt 			:	_TITULO_,
						cant_datosbd: 	1,		
						tabla 		: 	"",
						cant_datos	: 	4,
						dato_1		:	id_tarea,
						dato_2		:	serial_e,
						dato_3		:	fecha_desde,
						dato_4		:	fecha_hasta,
						campo_1 	: 	"",			
						campo_2 	: 	"",			
						campo_3 	: 	"",																
						campo_4 	: 	"",	
					};					
			var datosEncrypt = reportes.encriptarDatosRPTPublic(datos);

			var win = window.open(configuracion.urlsPublic().modReporte.tabs.vencimientoTarea.api+'?cfg='+_configuracion_+'&datos='+datosEncrypt);
			win.focus();
		}

		/*******************************************************/
		/* CONTROL */

		var cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva = function(_idCampo_,tipo_tarea_) {

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
						$('select#'+_idCampo_).append($('<option value="0">Seleccione un tarea</option>'));

						$(result).each(function (index, datoItem) { 
							$(datoItem.resultados).each(function (index, item) {
								//console.log(item);
								var opcion = $('<option id="'+item.id+'" value="'+item.id+'">'+item.nombre+'</option>');
								$('select#'+_idCampo_).append(opcion);
							});
						});
						if (!result) {
							$('select#'+_idCampo_).append($('<option value="0">No hay datos</option>'));							
						};
					}
					}).fail(function (error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);				
						console.log("Ocurrio un error");
				});
		}

		var iniciarPanelTabTareaPreventiva = function () {

		  		cargarListaDespegableUtf8EncodeTareaPreventivaCorrectiva('tareaListD','preventiva');
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



		return{
			Iniciar : function() {
				atcBusqdAvanzada = 0;
				atcPaginacionCtlg = 0;
				iniciarPanelTabTareaPreventiva();
				mtdVencimientoTareas.cargarCatalogoPublic(1);
			},			
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			vaciarCatalogoPublic : vaciarCatalogo,
			//
			generarProcesoFiltrarPublic : generarProcesoFiltrar,
		}
}();