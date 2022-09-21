var mtdMantenimientoPreventivo = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 7; // Tamaño de filas por pagina #paginacion
		var atcBusqdAvanzada= 0;
		var atcBusqdAvanzadaDat= {
				serial: "",
				serial_bn: "",
				tipo: 0,
				modelo: 0,
			};
		var atcPaginacionCtlg = 0;

		/*******************************/

	/******************************** NOTAS *******************************/
	/*
				---
	*/
	/***************************Metodos de funcionalidades******************/	

		var opcionesBusquedaAvanvada = function () {
			atcBusqdAvanzada=1;
			$("#ctlgProcsEquipo #buscardorTxt").val('');
			mtdMantenimientoPreventivo.cargarCatalogoPublic(1);
			ventanaModal.ocultarPulico('ventana-modal-capa-base');	
		}

		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var filtro_         = $("#ctlgProcsEquipo #buscardorTxt").val();
			var serialTxt_ 		= "";
			var serialBienNTxt_ = "";
			var tipoListD_ 		= "";
			var modeloListD_ 	= "";

			if (atcPaginacionCtlg==0){

				if(filtro_!="" || filtro_=="" && atcBusqdAvanzada==0){
					var accion_ = "FiltrarLista";
					atcBusqdAvanzada=0;

					atcBusqdAvanzadaDat.serial		= "";
					atcBusqdAvanzadaDat.serial_bn 	= "";
					atcBusqdAvanzadaDat.tipo		= 0;
					atcBusqdAvanzadaDat.modelo 		= 0;	
				}else{

					var accion_ = "BusquedaAvanzadaLista";
					//

					atcBusqdAvanzadaDat.serial	= $("#vtnProcsBusqdAvanzd #form #serialTxt").val();
					atcBusqdAvanzadaDat.serial_bn = $("#vtnProcsBusqdAvanzd #form #serialBienNTxt").val();
					atcBusqdAvanzadaDat.tipo	= $("#vtnProcsBusqdAvanzd #form #tipoListD").val();
					if (atcBusqdAvanzadaDat.tipo==0) {
						atcBusqdAvanzadaDat.tipo="";
					}
					atcBusqdAvanzadaDat.modelo 	= $("#vtnProcsBusqdAvanzd #form #modeloListD").val();
					if (atcBusqdAvanzadaDat.modelo==0) {
						atcBusqdAvanzadaDat.modelo="";
					}


					serialTxt_ 		= atcBusqdAvanzadaDat.serial;
					serialBienNTxt_ = atcBusqdAvanzadaDat.serial_bn;
					tipoListD_ 		= atcBusqdAvanzadaDat.tipo;
					modeloListD_ 	= atcBusqdAvanzadaDat.modelo;

				}
			}else{
					var accion_ = "BusquedaAvanzadaLista";
				atcPaginacionCtlg=0;
				serialTxt_ 		= atcBusqdAvanzadaDat.serial;
				serialBienNTxt_ = atcBusqdAvanzadaDat.serial_bn;
				tipoListD_ 		= atcBusqdAvanzadaDat.tipo;
				modeloListD_ 	= atcBusqdAvanzadaDat.modelo;

			}				
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
				url: configuracion.urlsPublic().equipo.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						serial:serialTxt_,
						serialBienN:serialBienNTxt_,
						tipoListD:tipoListD_,		
						modeloListD:modeloListD_, 						
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgProcsEquipo #catalogoDatos").html('');				
			        $("#pngProcsEquipo #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgProcsEquipo #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgProcsEquipo #catalogoDatos").html('');				
		            $("#pngProcsEquipo #pagination").html('');				
					//console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
							if (datoItem.estado==1 || datoItem.estado==2) {
									ColorEstado="";
									disabledEditar="";
									nuevoEstado=0;
									datoBoton="";
								}else{
									ColorEstado='danger';
									disabledEditar="disabled";
									nuevoEstado=1;
									datoBoton='<br><span style="font-size:smaller;">de equipo dañado</span>';
								}

					tr = $('<tr class="row '+ColorEstado+' ">'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+datoItem.tipo+'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+datoItem.marcaymodelo+'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
									'<div style="width: 100%;height: 50%;">'+
										'<div class="row">'+
											'<div class="col-md-2" style="border-bottom: 1px solid #bfbfbf;">'+
												'S:'+
											'</div>'+
											'<div class="col-md-10" style="border-bottom: 1px solid #bfbfbf;">'+
												datoItem.serial+
											'</div>'+
										'</div>'+
									'</div>'+
									'<div style="width: 100%;height: 50%;">'+
										'<div class="row">'+
											'<div class="col-md-2" >'+
												'B.N:'+
											'</div>'+
											'<div class="col-md-10">'+
												datoItem.serial_bn+
											'</div>'+
										'</div>'+
									'</div>'+
								'</td>'+						
								'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
									'<div class="btn-group detallesBtnDiv" role="group" style="width: 100%;">'+
										'<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdMantenimientoPreventivo.generarProcesoFiltrarPublic(&#39;MANTENIMIENTOS PREVENTIVOS A UN EQUIPO&#39;,'+datoItem.id+')" style="width: 100%;">'+
											'Generar reporte'+
											/*datoBoton+*/
										'</button>'+
									'</div>'+
								'</td>'+							
							'</tr>');
							


								$('#ctlgProcsEquipo #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoPreventivo.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdMantenimientoPreventivo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdMantenimientoPreventivo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdMantenimientoPreventivo.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngProcsEquipo #pagination').append(ul);
						});
						$("#ctlgProcsEquipo #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(6);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgProcsEquipo #catalogoDatos').append(tr);
							//-------------
							if(filtro_!=""){

								$("#ctlgProcsEquipo #btnNuevo").prop('disabled', false);
								$("#ctlgProcsEquipo #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgProcsEquipo #btnNuevo").prop('disabled', true);
								$("#ctlgProcsEquipo #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgProcsEquipo #btnGenerarReporte").prop('disabled', true);							
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
			mtdMantenimientoPreventivo.cargarCatalogoPublic(_pagina_);   
		}	
		var vaciarCatalogo = function() {
				$("#catalogoDatos").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
		}			


		/**************** Gestion de reporte *******************/

		var generarProcesoFiltrar = function(_TITULO_,id_equipo) {

			//Filtros
			var fecha_desde = $('#fecha_desde').val();
			var fecha_hasta = $('#fecha_hasta').val();
			//
			var _configuracion_ = "CFG-MANTENIMIENTO-PREVENTIVO";
			var usuario_ = sessionStorage.getItem("nombre-US")+' '+sessionStorage.getItem("apellido-US");        	
			var datos = {
						accionNucleo:"encriptarDatosRPT",
						u 			: 	usuario_,
						cfg 		: 	_configuracion_,
						tt 			:	_TITULO_,
						cant_datosbd: 	1,		
						tabla 		: 	"",
						cant_datos	: 	3,
						dato_1		:	id_equipo,
						dato_2		:	fecha_desde,
						dato_3		:	fecha_hasta,
						campo_1 	: 	"",			
						campo_2 	: 	"",			
						campo_3 	: 	"",																
					};					
			var datosEncrypt = reportes.encriptarDatosRPTPublic(datos);

			var win = window.open(configuracion.urlsPublic().modReporte.tabs.mantPreventivo.api+'?cfg='+_configuracion_+'&datos='+datosEncrypt);
			win.focus();
		}


		return{
			Iniciar : function() {
				atcBusqdAvanzada = 0;
				atcPaginacionCtlg = 0;
				mtdMantenimientoPreventivo.cargarCatalogoPublic(1);
			},
			opcionesBusquedaAvanvadaPublic : opcionesBusquedaAvanvada,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			vaciarCatalogoPublic : vaciarCatalogo,
			//
			generarProcesoFiltrarPublic : generarProcesoFiltrar,
		}
}();