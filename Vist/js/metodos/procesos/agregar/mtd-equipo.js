var mtdEquipo = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var paginaActualCaract = 1;
		var tamagno_paginas_ = 8; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
		var atcBusqdAvanzada= 0;
		var atcBusqdAvanzadaDat= {
				serial: "",
				serial_bn: "",
				tipo: 0,
				modelo: 0,
			};
		var atcPaginacionCtlg = 0;
		// -> componentes
		var paginaActualCaractCompoEq = 1;
		// -> perifericos
		var paginaActualCaractPerifEq = 1;
		// -> Software 
		var paginaActualCaractSoftListEq = 1;
		// ------- 
		var paginaActualCaractSoftEq = 1;
		// -------
		/*CONTROL DE VARIABLES BITACORA*/

		var serial_G = "";

		var serial_bn_G = "";

		//--

		var serial_G_PC = "";

		var serial_bn_G_PC = "";


		/*******************************/

	/******************************** NOTAS *******************************/
	/*
				---
	*/
	/***************************Metodos de funcionalidades******************/	

		var opcionesBusquedaAvanvada = function () {
			atcBusqdAvanzada=1;
			$("#ctlgProcsEquipo #buscardorTxt").val('');
			mtdEquipo.cargarCatalogoPublic(1);
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

				if(filtro_!=""){

					var accion_ = "FiltrarLista";
					atcBusqdAvanzada=0;

					atcBusqdAvanzadaDat.serial		= "";
					atcBusqdAvanzadaDat.serial_bn 	= "";
					atcBusqdAvanzadaDat.tipo		= 0;
					atcBusqdAvanzadaDat.modelo 		= 0;	
				}else if (filtro_=="" && atcBusqdAvanzada==0){

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
												'S :'+
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
										'<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdEquipo.consultar('+datoItem.id+')" style="width: 100%;">'+
											'Detalles'+
											datoBoton+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
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
		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarListaCaracteristicas = function(_pagina_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";
			var filtro_ = $("#vtnProcsEquipo #buscardorTxt").val();
			var _filtro2_ = $('#vtnProcsEquipo #btipoListD').val();
			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCEquipo.equipo.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						filtro2:_filtro2_,
						tamagno_paginas:10,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionCaractEqu").html('');				
			        $("#pgnListCaracteristicasEquipos #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#listGestionCaractEqu').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#listGestionCaractEqu").html('');
		            $("#pgnListCaracteristicasEquipos #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var btn = $('<button type="button" class="list-group-item" onclick="mtdEquipo.consultarCaracteristPublic('+datoItem.id+');">'+datoItem.tipo+' - '+datoItem.marca+' : '+datoItem.modelo+'</button>');

								$('#listGestionCaractEqu').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionCaractPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionCaractPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionCaractPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionCaractPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListCaracteristicasEquipos #pagination').append(ul);
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay resultados para la caracteristicas </div>');
							tr.append("</div>");
							$('#listGestionCaractEqu').append(tr);							
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
		var consultarCaracteristSoft = function(id_) {

			var accion_ = "consultarCaracteristSoft";
			
			//
	        $.ajax({
				url: configuracion.urlsPublic().equipo.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {

					console.log(JSON.stringify(data));
					console.log(JSON.stringify(data.resultado));	
					$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
	    				$(dato.resultado).each(function (index, datoItem) {  		    				

	    					console.log(datoItem);
	    					console.log("object");
	    					console.log(JSON.stringify(datoItem));
							console.log("json");
							$(' #datoControlIdCaractADD').val(datoItem.id);
							
							$(" #nombretxt").val(datoItem.nombre);					
							$(" #versiontxt").val(datoItem.version);
							$(" #tipotxt").val(datoItem.tipo);					
							$(" #distribuciontxt").val(datoItem.distribucion);					


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
		/* 	La funcionalidad lista
	 		# Uso : Se usa para extraer todos los datos relacionados 
			# Parametros :
			# Notas :
		*/
		var cargarListaCaracteristicasSoftware = function(_pagina_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";
			var _filtro2_ = $(".panel-vtn-content-datos #buscardorTxt").val();
			var filtro_ = $('.panel-vtn-content-datos #btipoListD').val();
			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCSoftware.software.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro1:filtro_,
						filtro2:_filtro2_,
						tamagno_paginas:10,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionCaractSoftware").html('');				
			        $("#pgnListCaracteristicasSoftware #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#listGestionCaractSoftware').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#listGestionCaractSoftware").html('');
		            $("#pgnListCaracteristicasSoftware #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var btn = $('<button type="button" class="list-group-item" onclick="mtdEquipo.consultarCaracteristSoftPublic('+datoItem.id+');">'+datoItem.NombreVersion+' - '+datoItem.tipo+'</button>');

								$('#listGestionCaractSoftware').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionSoftEqPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionSoftEqPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionSoftEqPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionSoftEqPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListCaracteristicasSoftware #pagination').append(ul);
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay resultados para la caracteristicas </div>');
							tr.append("</div>");
							$('#listGestionCaractSoftware').append(tr);							
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
						tamagno_paginas:6,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionPerifericos").html('');				
			        $("#pgnListPerifericos #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#listGestionPerifericos').append(tr);

	            },
	            success:  function (data) {
		    
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
										'<tr><td><b> Marca y Modelo : </b></td><td>'+datoItem.marcaymodelo+'</td><td class="col-md-2"><button type="button" id="btnP-Select-'+datoItem.id_periferico+'" class="lista-btnP-actvr btn btn-default  editarBtnDiv" style="padding: 0px 16px;" data-id_periferico="'+datoItem.id_periferico+'" data-serial="'+datoItem.serial+'" data-serial_bn="'+datoItem.serial_bn+'"> >> </button></td></tr>'+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionPerifEqPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionPerifEqPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionPerifEqPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionPerifEqPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListPerifericos #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(6);
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay periferico añadido </div>');
							tr.append("</div>");
							$('#listGestionPerifericos').append(tr);							
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
	        //
			//e.preventDefault();
			return false;
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
						tamagno_paginas:6,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#listGestionComponentes").html('');				
			        $("#pgnListComponentes #pagination").html('');	
					var tr = $('<div colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></div>');
					$('#listGestionComponentes').append(tr);

	            },
	            success:  function (data) {
		    
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
										'<tr><td><b> Marca y Modelo : </b></td><td>'+datoItem.marcaymodelo+'</td><td class="col-md-2"><button type="button" id="btnC-Select-'+datoItem.id_componente+'" class="lista-btnC-actvr btn btn-default editarBtnDiv" style="padding: 0px 16px;" data-id_componente="'+datoItem.id_componente+'" data-serial="'+datoItem.serial+'" data-serial_bn="'+datoItem.serial_bn+'" > >> </button></td></tr>'+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionCompoEqPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionCompoEqPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdEquipo.controlPaginacionCompoEqPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.controlPaginacionCompoEqPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListComponentes #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(6);
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay componente añadido </div>');
							tr.append("</div>");
							$('#listGestionComponentes').append(tr);							
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
		    
		            $("#listGestionSoftware").html('');
		            $("#pgnListSoftware #pagination").html('');
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
							console.log(dato);
							$(dato.resultados).each(function (index, datoItem) {
							//Obteniendo resultados para catalogo
								var btn = $('<button type="button" class="list-group-item" >'+
									'<table>'+
										'<tr><td><b> Nombre : </b></td><td>'+datoItem.NombreVersion+'</td></tr>'+
										'<tr><td><b> Tipo : </b></td><td>'+datoItem.tipo+'</td></tr>'+
										'<tr><td><b> Distribución : </b></td><td>'+datoItem.distribucion+'</td></tr>'+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.paginaActualCaractSoftListEqControlPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdEquipo.paginaActualCaractSoftListEqControlPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdEquipo.paginaActualCaractSoftListEqControlPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdEquipo.paginaActualCaractSoftListEqControlPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListSoftware #pagination').append(ul);
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay Software añadido </div>');
							tr.append("</div>");
							$('#listGestionSoftware').append(tr);							
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

/**************************************************************************************/		
		var consultar = function(id_) {

			if (id_>0) {
				ventanaModal.cambiaMuestraVentanaModalCapaBasePublic(configuracion.urlsPublic().equipo.detallar,1,1)
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
			    					if (datoItem.estado_equipo==0) {
										$('#lbMensajeDesincorpora').css('display', 'block');	
										$('#lbMensajeDesincorpora').css('display', 'block');	
										$('#mensajeTxtDesincorporacion').val(datoItem.observacion);
										$('#mensajeTxtDesincorporacion').css('display', 'block');	
										$('#btnAnadirPeriferico').css('display', 'none');					
										$('#btnAnadirComponente').css('display', 'none');					
										$('#btnAnadirSoftware').css('display', 'none');																									
										$('#btnGuardarSeriales').css('display', 'none');	
										$('#serialtxt').attr('disabled', true);																								
										$('#serialBienNacionaltxt').attr('disabled', true);																																		
			    					}

									var idEquipo = datoItem.id_equipo;
									var id_caracteristicas_ = datoItem.id_caracteristicas;

									$('#vtnProcsEquipoConsulta #datoControlId').val(idEquipo);


									serial_G = datoItem.serial;

									serial_bn_G = datoItem.serial_bn;

									$("#vtnProcsEquipoConsulta #serialtxt").val(serial_G);
									$("#vtnProcsEquipoConsulta #serialBienNacionaltxt").val(serial_bn_G);
									$("#vtnProcsEquipoConsulta #tipotxt").val(datoItem.tipo);
									$("#vtnProcsEquipoConsulta #marcatxt").val(datoItem.marca);					
									$("#vtnProcsEquipoConsulta #modelotxt").val(datoItem.modelo);
									$("#vtnProcsEquipoConsulta #voltagetxt").val(datoItem.voltage);					
									mtdEquipo.cargarListaCaractInterfacesPublic(id_caracteristicas_);
									mtdEquipo.cargarListaPerifericosEquipoPublic(1);
									mtdEquipo.cargarListaComponentesEquipoPublic(1);
									mtdEquipo.cargarListaSoftwareEquipoPublic(1);
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
		var consultarCaracterist = function(id_) {

			var accion_ = "consultarCaractEqu";
			
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
			        console.log("Procesando información...");
	            },
	            success:  function (data) {

					console.log(JSON.stringify(data));
					console.log(JSON.stringify(data.resultado));	
					$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
	    				$(dato.resultado).each(function (index, datoItem) {  		    				

	    					console.log(datoItem);
	    					console.log("object");
	    					console.log(JSON.stringify(datoItem));
							console.log("json");
							$('#vtnProcsEquipo #datoControlIdCaract').val(datoItem.id);
							
							$("#vtnProcsEquipo #tipotxt").val(datoItem.tipo);
							$("#vtnProcsEquipo #marcatxt").val(datoItem.marca);					
							$("#vtnProcsEquipo #modelotxt").val(datoItem.modelo);
							$("#vtnProcsEquipo #voltagetxt").val(datoItem.voltage);					
							mtdEquipo.cargarListaCaractInterfacesPublic(datoItem.id);

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
		var cargarListaCaractInterfaces = function(id_caracteristicas_) {

			var accion_ = "consultarInterfacesCEquipo";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_caracteristicas_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					$('#listGestionCaractInterfacesEqu').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listGestionCaractInterfacesEqu').popover('show');					
					$('#listGestionCaractInterfacesEqu').html('');
					//Obteniendo resultados para lista de interfaces
		    		$(data[0].interfaces).each(function (index, datoItem) { 
						if (datoItem.estadoInterfaz==1) {

							var btn = $('<button type="button" class="list-group-item" >'+datoItem.nombreInterfaz+'</button>');
							$('#listGestionCaractInterfacesEqu').append(btn);
						}		

		    		});
	            	$('#listGestionCaractInterfacesEqu').popover('destroy');


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

/**************************************************************************************/		

		var esMayorSerial = {};
		var esMenorSerial = {};
		var yaExiste = {};
		var yaExisteSBN = {};
		var datoAnterior = {};
		var obtenerDatoAnterior = function (_campoVist_) {
			dato = $('#'+_campoVist_).val();
			datoAnterior[dato] = dato;
			console.log(datoAnterior[dato]);
		}
		var validarExistenciaYGEstion = function (_tabla_,_columna_,_campoVist_,_esSerial_) {

			var yaExisteLocal = false;
			var datoValidar = $('#'+_campoVist_).val();

			if (_esSerial_==true) {
				if (nucleo.verificarExistenciaPublic(_tabla_,_columna_,_campoVist_,_campoVist_)==true) {
					$('#'+_campoVist_).css('border','1px solid #843534');
					yaExiste[_campoVist_.trim()] = true;
				}else{
					validadExistenciaLista(datoValidar,yaExisteLocal,_campoVist_,_esSerial_);
				}
			}else{
				if (nucleo.verificarExistenciaPublic(_tabla_,_columna_,_campoVist_,_campoVist_)==true && datoValidar!="") {
					$('#'+_campoVist_).css('border','1px solid #843534');
					yaExisteSBN[_campoVist_.trim()] = true;
				}else{
					validadExistenciaLista(datoValidar,yaExisteLocal,_campoVist_,_esSerial_);
				}
			}
			

			
		}
		var validadExistenciaLista = function (datoValidar,yaExisteLocal,_campoVist_,_esSerial_) {

				//
					esMayorSerial = {};
					esMenorSerial = {};	
					console.log(esMayorSerial);			
					console.log(esMenorSerial);			
				//

				$('#'+_campoVist_).css('border','1px solid white');
				//
				$('#vtnProcsEquipo #listVtnSeriesEquipos .filaInputs').each(function (index, datoItem){

					var idItem = $(datoItem).attr("id");
					if (_esSerial_==true) {
						var datoFila = $('#'+idItem+' #input1').val();
						if (datoFila.length>50) {
							if (datoFila!="") {
								nucleo.alertaErrorPublic("Serial '"+datoFila+"' tiene :"+datoFila.length+" caracteres, máximo 50 ");
							};
							esMayorSerial[_campoVist_.trim()] =true;
						}else if(datoFila.length<4) {
							if (datoFila!="") {
								nucleo.alertaErrorPublic("Serial '"+datoFila+"' tiene :"+datoFila.length+" caracteres, minimo 4 ");
							}
							esMenorSerial[_campoVist_.trim()] =true;
						}else{


						};
						if (datoValidar==datoFila && _campoVist_!=idItem+' #input1' ) {
							//console.log(_campoVist_+'  :::::::::::::::  '+idItem+' #input1' );
							yaExisteLocal=true;						
						}
					}else{
						var datoFila = $('#'+idItem+' #input2').val();						
						if (datoValidar==datoFila && _campoVist_!=idItem+' #input2' && datoValidar!="") {
							//console.log(_campoVist_+'  :::::::::::::::  '+idItem+' #input2' );
							yaExisteLocal=true;						
						}
					};

				});
					console.log(esMayorSerial);			
					console.log(esMenorSerial);			

				if (_esSerial_==true) {

					if (yaExisteLocal==true) {
						//
						console.log(_campoVist_);
						nucleo.alertaErrorPublic("El serial '"+datoValidar+"' esta duplicado en la lista ");
						$('#'+_campoVist_).css('border','1px solid #843534');						
						yaExiste[_campoVist_.trim()] =true;
					}else{
						$('#'+_campoVist_).css('border','1px solid white');
						yaExiste[_campoVist_.trim()] =false;
					};
					
				}else{

					if (yaExisteLocal==true) {
						//
						console.log(_campoVist_);
						nucleo.alertaErrorPublic("El serial de bien nacional'"+datoValidar+"' esta duplicado en la lista ");
						$('#'+_campoVist_).css('border','1px solid #843534');						
						yaExisteSBN[_campoVist_.trim()] =true;
					}else{
						$('#'+_campoVist_).css('border','1px solid white');
						yaExisteSBN[_campoVist_.trim()] =false;
					};

				};

		}

		/* La funcionalidad Guardar: 
			# Uso : Se usa para guardar y editar
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardar = function() {
			
			$('#vtnProcsEquipo #form').on('submit', function(e) {
				e.preventDefault();
				console.log("guardando...");

				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardar";
				//
				var id_caracteristicas_ = $('#vtnProcsEquipo #datoControlIdCaract').val();
				if (id_caracteristicas_=="" || id_caracteristicas_==0) {
					nucleo.alertaErrorPublic("No se han seleccionado las caracteristicas para los Equipos");
					return false;
				};
				//

				if ($('#vtnProcsEquipo #listVtnSeriesEquipos .filaInputs').length>0) {
					
					var serial_    = [];
					var serial_bn_ = [];

					var seleccionados=0;
					var faltaSERIAL=false;
			   		var controlNoGuarda=0;
					var yaExisteGuardar =false;
					var esMayorSerialLocal = false;
					var esMenorSerialLocal = false;

					$('#vtnProcsEquipo #listVtnSeriesEquipos .filaInputs').each(function (index, datoItem){

						var idItem = $(datoItem).attr("id");
						var dato1 = $('#'+idItem+' #input1').val();
						var dato2 = $('#'+idItem+' #input2').val();
						

						if ( dato1!="" ) {

							serial_.push(dato1);

						}else{
							nucleo.alertaErrorPublic("No se ha agregado el serial de un equipo");
							$('#'+idItem+'  #input1').css('border','1px solid #843534');
							faltaSERIAL = true;
							serial_.push(" ");							
						}

						if( dato2!="" ) {
	
							serial_bn_.push(dato2);							   			

						}else{
							serial_bn_.push(" ");
						}							

						seleccionados=seleccionados+1;

						//--El dato que voy a guardar, ya existe en otro campo.? o en la BD?
						var controlVariableExitencia = idItem+' #input1';
						var controlVariableExitenciaSBN = idItem+' #input2';
						if (yaExiste[controlVariableExitencia]==true) {
							nucleo.alertaErrorPublic("El serial '"+dato1+"' esta duplicado en la lista ");
							yaExisteGuardar=true;
						};
						if (yaExisteSBN[controlVariableExitenciaSBN]==true) {
							nucleo.alertaErrorPublic("El serial de bien nacional '"+dato2+"' esta duplicado en la lista ");
							yaExisteGuardar=true;
						};
						//-> cantidad validad de caracteres en el string						
						if (esMayorSerial[controlVariableExitencia]==true) {
							if (dato1!="") {
								nucleo.alertaErrorPublic("Serial '"+dato1+"' tiene :"+dato1.length+" caracteres, máximo 50 ");
							};
							esMayorSerialLocal = true;							
						}else if(esMenorSerial[controlVariableExitencia]==true) {
							if (dato1!="") {
								nucleo.alertaErrorPublic("Serial '"+dato1+"' tiene :"+dato1.length+" caracteres, minimo 4 ");
							}
							esMenorSerialLocal = true;
						}
						
					});
					//console.log('Cantidad: '+serial_.length+' array: Dptos: '+serial_+' -- serial_bn_: '+serial_bn_+' seleccionados: '+seleccionados);
					if (serial_.length<1 || seleccionados==0 || faltaSERIAL==true || yaExisteGuardar==true || 
						esMayorSerialLocal==true || esMenorSerialLocal==true ){
							return false;
					}else{


						//
				        $.ajax({
							url: configuracion.urlsPublic().equipo.api,
							type:'POST',	
							data:{	
									accion:accion_,
									ip_cliente:sessionStorage.getItem("ip_cliente-US"),
									id_usuario:sessionStorage.getItem("idUsuario-US"),										
									id_caracteristicas:id_caracteristicas_,
									seriales:JSON.stringify(serial_),
									seriales_bn:JSON.stringify(serial_bn_),
								},
			                beforeSend: function () {
			                	$('#vtnProcsEquipo #form').css("display", "none");
		                        $('#vtnProcsEquipo #procesandoDatosDialg').css("display", "block");
						        $("#catalogoDatos").html('');				
						        $("#pagination").html('');	
								tr = $('<tr>');
								tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
								tr.append("</tr>");
								$('#catalogoDatos').append(tr);
			                },
			                success:  function (result) {
								console.log("listo1");
								console.log(JSON.stringify(result));
								if (result[0].controlError==0) {
									nucleo.alertaExitoPublic(result[0].detalles);
									ventanaModal.ocultarPulico('ventana-modal-capa-base');
									mtdEquipo.vaciarCatalogoPublic();
									mtdEquipo.cargarCatalogoPublic(paginaActual);
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


					};

				}else{
					nucleo.alertaErrorPublic("No se ha agregado filas, para gestionar los seriales de equipos");
					return false;
					var serial_=0;
					var serial_bn_=0;
				};


		        //
		        nucleo.reiniciarVariablesGNPublic();
			});
		}
		var añadirPeriferico = function() {
			
			$('#formADD').on('submit', function(e) {
				e.preventDefault();
				console.log("guardando...");

				/* Obtener valores de los campos del formulario*/
				var accion_ = "anadirPeriferico";				
				var yaExiste = false;
				var cantInvalida = false;
				//
				var  idEquipo_ = $('#datoControlId').val();
				var id_caracteristicas_ = $('#datoControlIdCaractADD').val();
				if (id_caracteristicas_=="") {
					nucleo.alertaErrorPublic("No se han seleccionado las caracteristicas del periferico ");
					return false;
				};
				if ($('#fila1 #input1').val()=="") {
					nucleo.alertaErrorPublic("No se ha ingresado el serial");
					$('#fila1 #input1').removeClass('imputSusess').addClass('imputWarnig');
					return false;
				}

				if ($('#listVtnSeriesPerifericos .filaInputs').length>0) {
					
					var serial_    = [];
					var serial_bn_ = [];

					var seleccionados=0;
			   		var controlNoGuarda=0;

					$('#listVtnSeriesPerifericos .filaInputs').each(function (index, datoItem){

						var idItem = $(datoItem).attr("id");
						var dato1 = $('#'+idItem+'  #input1').val();
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
					url: configuracion.urlsPublic().equipo.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							idequipo:idEquipo_,
							id_caracteristicas:id_caracteristicas_,
							seriales:JSON.stringify(serial_),
							seriales_bn:JSON.stringify(serial_bn_),
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							panelTabs.cambiarFormularioPublico(
								configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
						  		'form',
					      		datosIdsTabs=[ 'tabDetalles' ]
							);
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
		var añadirComponente = function() {
			
			$('#formADD').on('submit', function(e) {
				e.preventDefault();
				console.log("guardando...");
				/* Obtener valores de los campos del formulario*/
				var accion_ = "anadirComponente";		
				var yaExiste = false;
				var cantInvalida = false;
				//
				var  idEquipo_ = $('#datoControlId').val();
				var id_caracteristicas_ = $('#datoControlIdCaractADD').val();

				if (id_caracteristicas_=="") {
					nucleo.alertaErrorPublic("No se han seleccionado las caracteristicas del componente");
					return false;
				};

				if ($('#fila1 #input1').val()=="") {
					nucleo.alertaErrorPublic("No se ha ingresado el serial");
					$('#fila1 #input1').removeClass('imputSusess').addClass('imputWarnig');
					return false;
				}

				if ($('#listVtnSeriesComponentes .filaInputs').length>0) {
					
					var serial_    = [];
					var serial_bn_ = [];

					var seleccionados=0;
			   		var controlNoGuarda=0;

					$('#listVtnSeriesComponentes .filaInputs').each(function (index, datoItem){

						var idItem = $(datoItem).attr("id");
						var dato1 = $('#'+idItem+'  #input1').val();
						var dato2 = $('#'+idItem+'  #input2').val();
						/*************************************************/						

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
					if (serial_.length<1 || seleccionados==0 ){
						var serial_=0;
						var serial_bn_=0;
					};
				}else{
					var serial_=0;
					var serial_bn_=0;
				};

				//
		        $.ajax({
					url: configuracion.urlsPublic().equipo.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							idequipo:idEquipo_,
							id_caracteristicas:id_caracteristicas_,
							seriales:JSON.stringify(serial_),
							seriales_bn:JSON.stringify(serial_bn_),
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							panelTabs.cambiarFormularioPublico(
								configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
						  		'form',
					      		datosIdsTabs=[ 'tabDetalles' , 'tabPerifericos' , 'tabComponentes' , 'tabSoftware'  ]
							);
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
		var anadirSoftware = function() {
			
			$('#formADD').on('submit', function(e) {
				e.preventDefault();
				console.log("guardando...");

				/* Obtener valores de los campos del formulario*/
					var accion_ = "anadirSoftware";				
					//
					var idEquipo_ = $('#datoControlId').val();
					var id_caracteristicas_ = $('#datoControlIdCaractADD').val();

				//
		        $.ajax({
					url: configuracion.urlsPublic().equipo.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							idequipo:idEquipo_,
							id_software:id_caracteristicas_,
						},
	                beforeSend: function () {

	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							panelTabs.cambiarFormularioPublico(
								configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
						  		'form',
					      		datosIdsTabs=[ 'tabDetalles' ]
							);
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
			});
		}		

		var editarSerialesEQERIFCOMPP = function (campo_control_) {
			
			var accion_ = "editarSerialesEQERIFCOMPP";
			var id_control_ =  "";
			var serial_ = "";
			var serial_bn_ = "";

			if (campo_control_=="equipo") {
				id_control_ =  $('#vtnProcsEquipoConsulta #datoControlId').val();
				serial_ = $('#vtnProcsEquipoConsulta #serialtxt').val();
				serial_bn_ = $('#vtnProcsEquipoConsulta #serialBienNacionaltxt').val();
				//-> validando cantidad de caracteres de seriales 
				if(serial_!=""){
					if (serial_.length>50) {
						nucleo.alertaErrorPublic("Serial '"+serial_+"' del "+campo_control_+", tiene :"+serial_.length+" caracteres, máximo 50 ");
						return false;
					}
					if(serial_.length<4){
						nucleo.alertaErrorPublic("Serial '"+serial_+"' del "+campo_control_+", tiene :"+serial_.length+" caracteres, minimo 4 ");
						return false;
					};
				}else{
					nucleo.alertaErrorPublic("Serial del "+campo_control_+" vacio");
					return false;
				};
				if(serial_bn_!=""){
					if (serial_bn_.length>50) {
						nucleo.alertaErrorPublic("Serial de bien nacional '"+serial_bn_+"' del "+campo_control_+", tiene :"+serial_bn_.length+" caracteres, máximo 50 ");
						return false;
					}
					if(serial_bn_.length<4){
						nucleo.alertaErrorPublic("Serial de bien nacional '"+serial_bn_+"' del "+campo_control_+", tiene :"+serial_bn_.length+" caracteres, minimo 4 ");
						return false;
					};				
				};
				//-> verificando existencia				
				if (serial_G_PC!=serial_ && nucleo.verificarExistenciaPublic(campo_control_,'serial','vtnProcsEquipoConsulta #serialtxt','vtnProcsEquipoConsulta #serialtxt')==true) {
					return false;
				}
				if (serial_bn_G_PC!=serial_bn_ && nucleo.verificarExistenciaPublic(campo_control_,'serial_bn','vtnProcsEquipoConsulta #serialBienNacionaltxt','vtnProcsEquipoConsulta #serialBienNacionaltxt')==true) {
					return false;
				}
			}else{
				var controlNombre ="";
				switch(campo_control_){
					case 'eq_componente' :
						controlNombre = "componente";
					break;
					case 'eq_periferico' :
						controlNombre = "periferico";
					break;
				}
				id_control_ =  $('#SerialesPERIFCOMP #datoControlIdPC').val();
				serial_ = $('#SerialesPERIFCOMP #serialtxt').val();
				serial_bn_ = $('#SerialesPERIFCOMP #serialBienNacionaltxt').val();
				//-> validando cantidad de caracteres de seriales 
				if(serial_!=""){
					if (serial_.length>50) {
						nucleo.alertaErrorPublic("Serial '"+serial_+"' del "+controlNombre+", tiene :"+serial_.length+" caracteres, máximo 50 ");
						return false;
					}
					if(serial_.length<4){
						nucleo.alertaErrorPublic("Serial '"+serial_+"' del "+controlNombre+", tiene :"+serial_.length+" caracteres, minimo 4 ");
						return false;
					};
				}else{
					nucleo.alertaErrorPublic("Serial del "+controlNombre+" vacio");
					return false;
				};
				if(serial_bn_!=""){
					if (serial_bn_.length>50) {
						nucleo.alertaErrorPublic("Serial de bien nacional '"+serial_bn_+"' del "+controlNombre+", tiene :"+serial_bn_.length+" caracteres, máximo 50 ");
						return false;
					}
					if(serial_bn_.length<4){
						nucleo.alertaErrorPublic("Serial de bien nacional '"+serial_bn_+"' del "+controlNombre+", tiene :"+serial_bn_.length+" caracteres, minimo 4 ");
						return false;
					};				
				};

				if (serial_G_PC!=serial_ && nucleo.verificarExistenciaPublic(campo_control_,'serial','SerialesPERIFCOMP #serialtxt','SerialesPERIFCOMP #serialtxt')==true) {
					return false;
				}
				if (serial_bn_G_PC!=serial_bn_ && nucleo.verificarExistenciaPublic(campo_control_,'serial_bn','SerialesPERIFCOMP #serialBienNacionaltxt','SerialesPERIFCOMP #serialBienNacionaltxt')==true) {
					return false;
				}	
			}
	        $.ajax({
				url: configuracion.urlsPublic().equipo.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),	
						id_control:id_control_,	
						campo_control:campo_control_,								
						serial:serial_,
						serial_bn:serial_bn_,
					},
                beforeSend: function () {

                },
                success:  function (result) {
					console.log("listo1");
					console.log(JSON.stringify(result));
					if (result[0].controlError==0) {
				
						switch(campo_control_){
							case 'equipo':
								nucleo.guardarBitacoraPublic("EDITO LOS SERIALES DE UN EQUIPO - DE : SERIAL "+serial_G+", SERIAL BIEN NACIONAL "+serial_bn_G+" - A : SERIAL "+serial_+", SERIAL BIEN NACIONAL "+serial_bn_);			
								break;
							case 'eq_periferico':
								nucleo.guardarBitacoraPublic("EDITO LOS SERIALES DE UN PERIFERICO - DE : SERIAL "+serial_G_PC+", SERIAL BIEN NACIONAL "+serial_bn_G_PC+" - A : SERIAL "+serial_+", SERIAL BIEN NACIONAL "+serial_bn_+" - DEL EQUIPO CON : SERIAL "+serial_G+", SERIAL BIEN NACIONAL "+serial_bn_G_PC );			
								break;
							case 'eq_componente':
								nucleo.guardarBitacoraPublic("EDITO LOS SERIALES DE UN COMPONENTE - DE : SERIAL "+serial_G_PC+", SERIAL BIEN NACIONAL "+serial_bn_G_PC+" - A : SERIAL "+serial_+", SERIAL BIEN NACIONAL "+serial_bn_+" - DEL EQUIPO CON : SERIAL "+serial_G+", SERIAL BIEN NACIONAL "+serial_bn_G_PC );			
								break;
						}

						nucleo.alertaExitoPublic(result[0].detalles);
						panelTabs.cambiarFormularioPublico(
							configuracion.urlsPublic().equipo.tabsDetallar.detalles, 
					  		'form',
				      		datosIdsTabs=[ 'tabDetalles' , 'tabPerifericos' , 'tabComponentes' , 'tabSoftware'  ]
						);
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
		var varlidarPemiteGuardarSerialesPropios = function (_tabla_,_columna_,_campoVist_,_divCampoVist_) {

			var datoCampo = $('#'+_campoVist_).val();
			switch(_columna_){
				case 'serial' :
					if(nucleo.verificarExistenciaPublic(_tabla_,_columna_,_campoVist_,_divCampoVist_)==true && serial_G_PC==datoCampo){
						$('#'+_campoVist_).removeClass('imputWarnig').addClass('imputSusess');
					}
				break;
				case 'serial_bn' :
					if(nucleo.verificarExistenciaPublic(_tabla_,_columna_,_campoVist_,_divCampoVist_)==true && serial_bn_G_PC==datoCampo){
						$('#'+_campoVist_).removeClass('imputWarnig').addClass('imputSusess');
					}
				break;
			}
		}

		var actListPerif = function () {

			$('.lista-btnP-actvr').on('click',function (item) {
				$('.lista-btnP').removeClass('lista-btnP-select');								
				$('.lista-btnP').css('color', '#000000');
				//
				$('.lista-btnC').removeClass('lista-btnC-select');				
				$('.lista-btnC').css('color', '#000000');
				//				
				var btnId = item.target.id;				
				var id_ = $('#'+btnId).data('id_periferico');
				var serial_ = $('#'+btnId).data('serial');
				var serial_bn_ = $('#'+btnId).data('serial_bn');
				$('#btnP-'+id_).addClass('lista-btnP-select');
				$('#btnP-'+id_).css('color', '#FFFFFF');

				$('#btnGuardarSerialesPERIFCOMP').attr('onclick', "mtdEquipo.editarSerialesEQERIFCOMPPPublic('eq_periferico');");
				$('#SerialesPERIFCOMP').css('display', 'block');
				$('#SerialesPERIFCOMP #datoControlIdPC').val(id_);
				serial_G_PC = serial_;
				serial_bn_G_PC = serial_bn_;
				$('#SerialesPERIFCOMP #serialtxt').val(serial_G_PC);
				$('#SerialesPERIFCOMP #serialBienNacionaltxt').val(serial_bn_G_PC);		

				$('#SerialesPERIFCOMP #serialtxt').attr('onkeyup', "mtdEquipo.varlidarPemiteGuardarSerialesPropiosPublic('eq_periferico','serial','SerialesPERIFCOMP #serialtxt','SerialesPERIFCOMP #serialtxt')");
				$('#SerialesPERIFCOMP #serialBienNacionaltxt').attr('onkeyup', "mtdEquipo.varlidarPemiteGuardarSerialesPropiosPublic('eq_periferico','serial_bn','SerialesPERIFCOMP #serialBienNacionaltxt','SerialesPERIFCOMP #serialBienNacionaltxt')");

				$('#textoEjecutaActual').html('');
				$('#textoEjecutaActual').html('periferico seleccionado');
				//
			});
		}		

		var actListComp = function () {

			$('.lista-btnC-actvr').on('click',function (item) {
				$('.lista-btnP').removeClass('lista-btnP-select');								
				$('.lista-btnP').css('color', '#000000');
				//
				$('.lista-btnC').removeClass('lista-btnC-select');				
				$('.lista-btnC').css('color', '#000000');
				//	
				var btnId = item.target.id;				
				var id_ = $('#'+btnId).data('id_componente');
				var serial_ = $('#'+btnId).data('serial');
				var serial_bn_ = $('#'+btnId).data('serial_bn');				
				$('#btnC-'+id_).addClass('lista-btnC-select');
				$('#btnC-'+id_).css('color', '#FFFFFF');
				//
				$('#btnGuardarSerialesPERIFCOMP').attr('onclick', "mtdEquipo.editarSerialesEQERIFCOMPPPublic('eq_componente');");
				$('#SerialesPERIFCOMP').css('display', 'block');
				$('#SerialesPERIFCOMP #datoControlIdPC').val(id_);
				serial_G_PC = serial_;
				serial_bn_G_PC = serial_bn_;
				$('#SerialesPERIFCOMP #serialtxt').val(serial_G_PC);
				$('#SerialesPERIFCOMP #serialBienNacionaltxt').val(serial_bn_G_PC);	

				$('#SerialesPERIFCOMP #serialtxt').attr('onkeyup', "mtdEquipo.varlidarPemiteGuardarSerialesPropiosPublic('eq_componente','serial','SerialesPERIFCOMP #serialtxt','SerialesPERIFCOMP #serialtxt')");
				$('#SerialesPERIFCOMP #serialBienNacionaltxt').attr('onkeyup', "mtdEquipo.varlidarPemiteGuardarSerialesPropiosPublic('eq_componente','serial_bn','SerialesPERIFCOMP #serialBienNacionaltxt','SerialesPERIFCOMP #serialBienNacionaltxt')");

				$('#textoEjecutaActual').html('');
				$('#textoEjecutaActual').html('componente seleccionado');				
				//
			});

		}				

	/************************************************************************/
	/****************************Metodos de control**************************/		

		/*
		*/
		var vaciarCatalogo = function() {
			console.log("Vaciando catalogo");
			$("#catalogoDatos").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
		}
		/*
		*/
		var restablecerForm = function() {
			//
	        $('#vtnProcsEquipo #form')[0].reset();
			$('#ventana-modal .panel-body .row .form-group .campo-control ').each(function (index, datoItem) {
				var idItem = $(datoItem).attr("id");
				$('#'+idItem).removeClass('imputWarnig');
				$('#'+idItem).removeClass('imputSusess');
			});			
			$('#ventana-modal .panel-body .row .form-group ').each(function (index, datoItem) {
				var idItem = $(datoItem).attr("id");
				$('#'+idItem).removeClass('has-success');
				$('#'+idItem).removeClass('has-error');
			});
		}
		var filtrarSelect = function() {
			$('#marcaListD').on('change', function (item) {
				var id_marca = $('#marcaListD').val();

			  	nucleo.cargarListaDespegableListasAnidadaPublic('modeloListD','cfg_c_fisc_modelo','id_marca',id_marca,'modelo');
				$('#divModeloListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
			  	$('#divModeloListD').popover('show');
 				setTimeout(function(){ 

				  	$('#divModeloListD').popover('destroy');
				  	
				  	$('#modeloListD').selectpicker('refresh');
				  	
			        $('#btnSelectElegido1').attr('style','width:100%;');

			        $('#btnSelectElegido1 button').on('click',function () {
				        //$('#btnSelectElegido'+index).css('width','100px');
			            
			            if($("#btnSelectElegido1 .bs-searchbox input").length > 0 ) { 

			                    $('#btnSelectElegido1 .bs-searchbox input').on('keyup',function () {

			                            if($("#btnSelectElegido1 .no-results").length > 0 ) { 
			                                $("#btnSelectElegido1 .no-results").html('');
			                                var filtro = $('#btnSelectElegido1 .bs-searchbox input').val();
			                                $("#btnSelectElegido1 .no-results").html('No hay resultados para " '+filtro+' " ');
			                            }


			                    });

			            }

			        });

			    }, 300);
			});
		}
		/*
		*/	
		var controlPaginacion = function (_pagina_) {
			if (atcBusqdAvanzada==1) {
				atcPaginacionCtlg = 1;				
			}else{
				atcPaginacionCtlg = 0;
			}
			paginaActual = _pagina_;
			mtdEquipo.cargarCatalogoPublic(_pagina_);   
		}	
			
		var controlPaginacionCaract = function (_pagina_) {
			paginaActualCaract = _pagina_;
			mtdEquipo.cargarListaCaracteristicasPublic(_pagina_);   
		}	
		//
		var controlPaginacionCompoEq = function (_pagina_) {
			paginaActualCaractCompoEq = _pagina_;
			mtdEquipo.cargarListaComponentesEquipoPublic(_pagina_);   
		}	
		var controlPaginacionPerifEq = function (_pagina_) {
			paginaActualCaractPerifEq = _pagina_;
			mtdEquipo.cargarListaPerifericosEquipoPublic(_pagina_);   
		}		
		var paginaActualCaractSoftListEqControl = function (_pagina_) {
			paginaActualCaractSoftListEq = _pagina_;
			mtdEquipo.cargarListaSoftwareEquipoPublic(_pagina_);   
		}				
		//
		var controlPaginacionSoftEq = function (_pagina_) {
			paginaActualCaractSoftEq = _pagina_;
			mtdEquipo.cargarListaCaracteristicasSoftwarePublic(_pagina_);   
		}				
	/****************Inicializacion e Intancias de metodos *******************/

		return{
			Iniciar : function() {
					atcBusqdAvanzada = 0;
					atcPaginacionCtlg = 0;
					mtdEquipo.cargarCatalogoPublic(1);			
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			opcionesBusquedaAvanvadaPublic : opcionesBusquedaAvanvada,
			cargarListaCaracteristicasPublic : cargarListaCaracteristicas,
			cargarListaCaracteristicasSoftwarePublic : cargarListaCaracteristicasSoftware,
			cargarListaComponentesEquipoPublic : cargarListaComponentesEquipo,
			cargarListaPerifericosEquipoPublic : cargarListaPerifericosEquipo,
 			cargarListaSoftwareEquipoPublic : cargarListaSoftwareEquipo,			
			cargarListaCaractInterfacesPublic : cargarListaCaractInterfaces,
			paginaActualCaractSoftListEqControlPublic : paginaActualCaractSoftListEqControl,
			controlPaginacionPublic : controlPaginacion,
			controlPaginacionCaractPublic : controlPaginacionCaract,
			controlPaginacionCompoEqPublic : controlPaginacionCompoEq,
			controlPaginacionPerifEqPublic : controlPaginacionPerifEq,
			controlPaginacionSoftEqPublic : controlPaginacionSoftEq,
			consultar : consultar,
			consultarCaracteristSoftPublic : consultarCaracteristSoft,
			obtenerDatoAnteriorPublic : obtenerDatoAnterior,
			validarExistenciaYGEstionPublic : validarExistenciaYGEstion,
			guardarPublic : guardar,
			añadirComponentePublic : añadirComponente,
			añadirPerifericoPublic : añadirPeriferico,
			anadirSoftwarePublic : anadirSoftware,
			varlidarPemiteGuardarSerialesPropiosPublic : varlidarPemiteGuardarSerialesPropios,
			editarSerialesEQERIFCOMPPPublic : editarSerialesEQERIFCOMPP,
			filtrarSelectPublic :filtrarSelect,
			consultarCaracteristPublic : consultarCaracterist,
		}
}();