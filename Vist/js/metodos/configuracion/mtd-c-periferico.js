var mtdCaracteristicasPerifericos = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 11; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
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
		var cargarCatalogo = function(_pagina_,_filtro2_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";
			var filtro_ = $("#ctlgCaracteristicasPerifericos #buscardorTxt").val();
			_filtro2_ = $('#btipoListD').val();
			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCPeriferico.periferico.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						filtro2:_filtro2_,
						tamagno_paginas:tamagno_paginas_,
						pagina:_pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgCaracteristicasPerifericos #catalogoDatos").html('');				
			        $("#pgnCaracteristicasPerifericos #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgCaracteristicasPerifericos #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgCaracteristicasPerifericos #catalogoDatos").html('');				
		            $("#pgnCaracteristicasPerifericos #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estado==1) {
									AccionarEstado	= "Deshabilitar";
									ColorEstado="";
									disabledEditar="";
									nuevoEstado=0;
								}else{
									AccionarEstado	= "Habilitar";
									ColorEstado='danger';
									disabledEditar="disabled";
									nuevoEstado=1;
								}

								tr = $('<tr class="row '+ColorEstado+'">');
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.modelo + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.marca + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-4'>" + datoItem.tipo + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdCaracteristicasPerifericos.consultarPublic("+datoItem.id+"),ventanaModal.mostrarBasicPublico()' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdCaracteristicasPerifericos.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgCaracteristicasPerifericos #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdCaracteristicasPerifericos.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdCaracteristicasPerifericos.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdCaracteristicasPerifericos.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdCaracteristicasPerifericos.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnCaracteristicasPerifericos #pagination').append(ul);
						});
						$("#ctlgCaracteristicasPerifericos #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(27);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgCaracteristicasPerifericos #catalogoDatos').append(tr);
							//-------------
							if(filtro_!="" || _filtro2_!=0){

								$("#ctlgCaracteristicasPerifericos #btnNuevo").prop('disabled', false);
								$("#ctlgCaracteristicasPerifericos #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgCaracteristicasPerifericos #btnNuevo").prop('disabled', true);
								$("#ctlgCaracteristicasPerifericos #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgCaracteristicasPerifericos #btnGenerarReporte").prop('disabled', true);							
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
		var consultar = function(id_c_periferico_) {

			var accion_ = "consultar";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCPeriferico.periferico.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_c_periferico_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					//alert(JSON.stringify(data));
					$('#btnGuardar').prop('disabled', false);
					$('#divMarcaListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divMarcaListD').popover('show');
					$('#divModeloListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divModeloListD').popover('show');
					$('#divTipoListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divTipoListD').popover('show');
					$('#divInterfazListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divInterfazListD').popover('show');

				    setTimeout(function(){ 
   						//
						$('#vtnCaracteristicasPerifericos #datoControlId').val(data[0].id);

   						$("#marcaListD option[value="+data[0].id_marca+"]").attr("selected",true);					
   						$("#tipoListD option[value="+data[0].id_tipo+"]").attr("selected",true);					
   						$("#interfazListD option[value="+ data[0].id_interfaz+"]").attr("selected",true);					
					  	//
					  	$('#marcaListD').selectpicker('refresh');
					  	$('#tipoListD').selectpicker('refresh');
					  	$('#interfazListD').selectpicker('refresh');
		            	//
				        $('#btnSelectElegido0').attr('style','width:100%;');
				        $('#btnSelectElegido2').attr('style','width:100%;');
				        $('#btnSelectElegido3').attr('style','width:100%;');
				        $('#btnSelectElegido4').attr('style','width:100%;');		            	
		            	//
		            	$('#divMarcaListD').popover('destroy');		            	
		            	$('#divTipoListD').popover('destroy');
		            	$('#divInterfazListD').popover('destroy');
					    setTimeout(function(){ 

	      					$("#modeloListD option[value="+data[0].id_modelo+"]").attr("selected",true);										    
						  	$('#modeloListD').selectpicker('refresh');
					        $('#btnSelectElegido1').attr('style','width:100%;');
			            	$('#divModeloListD').popover('destroy');
							$('#btnGuardar').prop('disabled', false);

					    });	

				    }, 400);

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

				console.log("guardando...");
				if($('#ventana-modal').hasClass('ventana-modal-panel-accionCerrar')){
			        return false;
			    }
				/* Obtener valores de los campos del formulario*/

				console.log("guardando...");

				var accion_ = "guardar";
				//
				var id_modelo_	= $("#modeloListD").val(); 
				var id_tipo_	= $("#tipoListD").val(); 
				var id_interfaz_	= $("#interfazListD").val(); 

				var id_ = $('#vtnCaracteristicasPerifericos #datoControlId').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().modCPeriferico.periferico.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),
							id:id_,
							id_modelo:id_modelo_,
							id_tipo:id_tipo_,
							id_interfaz:id_interfaz_,
						},
	                beforeSend: function () {
	                	$('#vtnCaracteristicasPerifericos #form').css("display", "none");
                        $('#vtnCaracteristicasPerifericos #procesandoDatosDialg').css("display", "block");
				        $("#ctlgCaracteristicasPerifericos #catalogoDatos").html('');				
				        $("#ctlgCaracteristicasPerifericos #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgCaracteristicasPerifericos #catalogoDatos').append(tr);
	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==true) {
								// se comproobo que se abrio como administrador en las vistas de los procesos
								nucleo.controlBtnAdminInProcessPublic();
							}else{							
								ventanaModal.ocultarPulico('ventana-modal');
								mtdCaracteristicasPerifericos.vaciarCatalogoPublic();
								mtdCaracteristicasPerifericos.cargarCatalogoPublic(paginaActual,0);
							}
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
				mtdCaracteristicasPerifericos.restablecerFormPublic();
				return false;				
		}
		/* La funcionalidad cambiarEstado: 
			# Uso : Se usa para cambiar el estado 
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var cambiarEstado = function(id_,estado_) {
			var accion_ = "cambiarEstado";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCPeriferico.periferico.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						id:id_,
						estado:estado_
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log("listo");
					mtdCaracteristicasPerifericos.controlPaginacionPublic(paginaActual);
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}	

	/****************************Metodos de control**************************/		


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
		var vaciarCatalogo = function() {
			console.log("Vaciando catalogo");
			$("#catalogoDatos").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
		}
		/*
			
		*/
		var restablecerForm = function() {
			//
	        $('#vtnCaracteristicasPerifericos #form')[0].reset();
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
//refrescar item
			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','marca');
			  	nucleo.cargarListaDespegableListasPublic('modeloListD','cfg_c_fisc_modelo','modelo');
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');
			  	nucleo.cargarListaDespegableListasPublic('interfazListD','cfg_c_fisc_interfaz_conexion','interfaz');

				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
				$('#modeloListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
				$('#tipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	
				$('#interfazListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});											

            	$('#marcaListD').popover('show');
			  	$('#modeloListD').popover('show');
			  	$('#tipoListD').popover('show');
			  	$('#interfazListD').popover('show');

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#modeloListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');
				  	$('#interfazListD').popover('destroy');

				  	$('#marcaListD').selectpicker('refresh');
				  	$('#modeloListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');
				  	$('#interfazListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');
			        $('#btnSelectElegido4').attr('style','width:100%;');


			    }, 300);


	$(document).ready(function() {

	  	$('#marcaListD').selectpicker('refresh');
	  	$('#modeloListD').selectpicker('refresh');
	  	$('#tipoListD').selectpicker('refresh');
	  	$('#interfazListD').selectpicker('refresh');

		$('#marcaListD').on('change',function () {

			//alert($('#marcaListD').val());

		});

	    $('#listas .bootstrap-select ').each(function (index, datoItem) {

	        $(datoItem).attr('id','btnSelectElegido'+index);

//	        $('#btnSelectElegido'+index).attr('style','width:100px;');

	        $('#btnSelectElegido'+index+' button').on('click',function () {
		        //$('#btnSelectElegido'+index).css('width','100px');
	            
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
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			paginaActual = _pagina_;
			mtdCaracteristicasPerifericos.cargarCatalogoPublic(_pagina_,0);   
		}	
		var activarEscuchador = function () {
		
			var idVtn = "#vtnCaracteristicasPerifericos";
			// -> Form Vtn
			$(idVtn+' #form').on('submit', function(e) {
				e.preventDefault();
				if (atcEnvioEnter==0) {	
					if(nucleo.validadorPublic()==true){						
		        		guardar();
		    		}
			  	}else{
			  		atcEnvioEnter=0;
			  	}
			});
			//	
			$(idVtn+' input').on('keypress', function(e) {
			    if(e.keyCode==13){
					if(nucleo.validadorPublic()==true){
      						atcEnvioEnter= 1;
			        	guardar();
					}
			    }
			});
			//
		}
	/****************Inicializacion e Intancias de metodos *******************/

		return{
			Iniciar : function() {
				console.log("Iniciando carga de metodos de caracteristicas de perifericos");
					
					filtrarSelect();
					activarEscuchador();

				console.log("Finalizando carga de metodos de caracteristicas de perifericos");
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado

		}
}();