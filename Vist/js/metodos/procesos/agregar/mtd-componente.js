var mtdComponente = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var paginaActualCaract = 1;
		var tamagno_paginas_ = 5; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
		var atcBusqdAvanzada= 0;
		var atcBusqdAvanzadaDat= {
				serial: "",
				serial_bn: "",
				tipo: 0,
				modelo: 0,
			};
		var atcPaginacionCtlg = 0;

	/******************************** NOTAS *******************************/
	/*
				---
	*/
	/***************************Metodos de funcionalidades******************/	

		var opcionesBusquedaAvanvada = function () {
			atcBusqdAvanzada=1;
			$("#ctlgProcsComponente #buscardorTxt").val('');
			mtdComponente.cargarCatalogoPublic(1);
			ventanaModal.ocultarPulico('ventana-modal');	
		}
	
		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var filtro_         = $("#ctlgProcsComponente #buscardorTxt").val();
			var serialTxt_ 		= "";
			var serialBienNTxt_ = "";
			var tipoListD_ 		= "";
			var modeloListD_ 	= "";

			if (atcPaginacionCtlg==0){

				if(filtro_!="" && atcBusqdAvanzada==0){
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

				serialTxt_ 		= atcBusqdAvanzadaDat.serial;
				serialBienNTxt_ = atcBusqdAvanzadaDat.serial_bn;
				tipoListD_ 		= atcBusqdAvanzadaDat.tipo;
				modeloListD_ 	= atcBusqdAvanzadaDat.modelo;
				
				
				atcPaginacionCtlg=0;

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
				url: configuracion.urlsPublic().componente.api ,
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

			        $("#ctlgProcsComponente #catalogoDatos").html('');				
			        $("#pngProcsComponente #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgProcsComponente #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgProcsComponente #catalogoDatos").html('');				
		            $("#pngProcsComponente #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   

					tr = $('<tr class="row ">'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+datoItem.tipo+'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+datoItem.marcaymodelo+'</td>'+
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
								'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
									'<div class="btn-group" role="group" style="width: 100%;">'+
										'<button type="button" class="btn btn-default" id="btnDetalles" onclick="mtdComponente.consultar('+datoItem.id+',1)" style="width: 100%;">Detalles</button>'+
									'</div>'+
								'</td>'+							
							'</tr>');
							
								$('#ctlgProcsComponente #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdComponente.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdComponente.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdComponente.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdComponente.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngProcsComponente #pagination').append(ul);
						});
								$("#ctlgProcsComponente #btnGenerarReporte").prop('disabled', false);

					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgProcsComponente #catalogoDatos').append(tr);
							//-------------
							if(filtro_!=""){

								$("#ctlgProcsComponente #btnNuevo").prop('disabled', false);
								$("#ctlgProcsComponente #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgProcsComponente #btnNuevo").prop('disabled', true);
								$("#ctlgProcsComponente #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgProcsComponente #btnGenerarReporte").prop('disabled', true);							
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
			var filtro_ = $(".panel-vtn-content-datos #buscardorTxt").val();
			var _filtro2_ = $('.panel-vtn-content-datos #btipoListD').val();
			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCComponente.componente.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						filtro2:_filtro2_,
						tamagno_paginas:10,
						pagina:_pagina_,					
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
								var btn = $('<button type="button" class="list-group-item" onclick="mtdComponente.consultarCaracteristPublic('+datoItem.id+');">'+datoItem.tipo+' - '+datoItem.marca+' : '+datoItem.modelo+'</button>');

								$('#listGestionCaractCompon').append(btn);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdComponente.controlPaginacionCaractPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdComponente.controlPaginacionCaractPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdComponente.controlPaginacionCaractPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdComponente.controlPaginacionCaractPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}
							$('#pgnListCaracteristicasComponentes #pagination').append(ul);
						});
					}else{
							tr = $('<div>');
							tr.append('<div style="text-align: center;"> No hay resultados para la caracteristicas </div>');
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


		/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
		*/	
		var consultar = function(id_,_contenedor_) {

			if (_contenedor_==1) {
				ventanaModal.cambiaMuestraVentanaModalPublic("procesos/agregar/componente/ventanasModales/vtnMGestionComponenteConsulta.php",1,1);
			} 
			if (_contenedor_==2){
				ventanaModal.cambiaMuestraVentanaModalCapa2Public("procesos/agregar/equipo/ventanasModales/detallar/forms/componente/formComponentesEquipoExistente-detalles.php",1,1);
			}
			

			var accion_ = "consultar";
			
			console.log("verificando: "+id_);
			//
	        $.ajax({
				url: configuracion.urlsPublic().componente.api,
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
					ventanaModal.mostrarBasicPublico();
						
					$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
	    				$(dato.resultado).each(function (index, datoItem) {  		    			

	    					console.log(datoItem);
	    					console.log(JSON.stringify(datoItem));
							$('#vtnProcsComponenteConsulta #datoControlIdADD').val(datoItem.id);
							
							$("#vtnProcsComponenteConsulta #serialtxt").val(datoItem.serial);
							$("#vtnProcsComponenteConsulta #serialBienNacionaltxt").val(datoItem.serial_bn);
							$("#vtnProcsComponenteConsulta #tipotxt").val(datoItem.tipo);
							$("#vtnProcsComponenteConsulta #marcatxt").val(datoItem.marca);					
							$("#vtnProcsComponenteConsulta #modelotxt").val(datoItem.modelo);
							$("#vtnProcsComponenteConsulta #voltagetxt").val(datoItem.voltage);					
							$("#vtnProcsComponenteConsulta #capacidadtxt").val(datoItem.capacidad);					

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
		var consultarCaracterist = function(id_) {

			var accion_ = "consultarCaractPerif";
			
			console.log("verificando: "+id_);
			//
	        $.ajax({
				url: configuracion.urlsPublic().componente.api,
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
							var idCaracteristicas = datoItem.id;

							$('#datoControlIdADDCaractADD').val(idCaracteristicas);
							datoControlIdCaractADD.value=idCaracteristicas;
							$(" #tipotxt").val(datoItem.tipo);
							$(" #marcatxt").val(datoItem.marca);					
							$(" #modelotxt").val(datoItem.modelo);
							$(" #voltagetxt").val(datoItem.voltage);					
							$(" #capacidadtxt").val(datoItem.capacidad);					
							cargarListaCaractInterfaces(idCaracteristicas);

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
					$('#listGestionCaractInterfacesCompon').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listGestionCaractInterfacesCompon').popover('show');					
					$('#listGestionCaractInterfacesCompon').html('');
					//Obteniendo resultados para lista de interfaces
		    		$(data[0].interfaces).each(function (index, datoItem) { 
						if (datoItem.estadoInterfaz==1) {

							var btn = $('<button type="button" class="list-group-item" >'+datoItem.nombreInterfaz+'</button>');
							$('#listGestionCaractInterfacesCompon').append(btn);
						}		

		    		});
	            	$('#listGestionCaractInterfacesCompon').popover('destroy');


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
			
			$('#vtnProcsComponente #form').on('submit', function(e) {
				e.preventDefault();
				console.log("guardando...");

				/* Obtener valores de los campos del formulario*/
				//
				var accion_ = "guardar";
				//
				var id_caracteristicas_ = $('#vtnProcsComponente #datoControlIdCaractADD').val();
				//

				if ($('#vtnProcsComponente #listVtnSeriesComponentes .filaInputs').length>0) {
					
					var serial_    = [];
					var serial_bn_ = [];

					var seleccionados=0;
			   		var controlNoGuarda=0;

					$('#vtnProcsComponente #listVtnSeriesComponentes .filaInputs').each(function (index, datoItem){

						var idItem = $(datoItem).attr("id");
						var dato1 = $('#'+idItem+'  #input1').val();
						var dato2 = $('#'+idItem+'  #input2').val();
						

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
					console.log('Cantidad: '+serial_.length+' array: Dptos: '+serial_+' -- serial_bn_: '+serial_bn_+' seleccionados: '+seleccionados);
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
					url: configuracion.urlsPublic().componente.api,
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
	                	$('#vtnProcsComponente #form').css("display", "none");
                        $('#vtnProcsComponente #procesandoDatosDialg').css("display", "block");
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
							ventanaModal.ocultarPulico('ventana-modal');
							mtdComponente.vaciarCatalogoPublic();
							mtdComponente.cargarCatalogoPublic(paginaActual);
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
	        $('#vtnProcsComponente #form')[0].reset();
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
			mtdComponente.cargarCatalogoPublic(_pagina_);   
		}	
		var controlPaginacionCaract = function (_pagina_) {
			paginaActualCaract = _pagina_;
			mtdComponente.cargarListaCaracteristicasPublic(_pagina_);   
		}	
	
	/****************Inicializacion e Intancias de metodos *******************/

		return{
			Iniciar : function() {
				console.log("Iniciando carga de metodos de departamento");
					
					atcBusqdAvanzada = 0;
					atcPaginacionCtlg = 0;
					mtdComponente.cargarCatalogoPublic(1);
			
				console.log("Finalizando carga de metodos de departamento");
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			opcionesBusquedaAvanvadaPublic : opcionesBusquedaAvanvada,
			cargarListaCaracteristicasPublic : cargarListaCaracteristicas,
			controlPaginacionPublic : controlPaginacion,
			controlPaginacionCaractPublic : controlPaginacionCaract,
			consultar : consultar,
			guardarPublic : guardar,
			filtrarSelectPublic :filtrarSelect,
			consultarCaracteristPublic : consultarCaracterist,
		}
}();