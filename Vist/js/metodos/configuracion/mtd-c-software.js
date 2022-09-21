var mtdCaracteristicasSoftware = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 11; // Tamaño de filas por pagina #paginacion
		var elementosLista =[];
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
		var cargarCatalogo = function(_pagina_,_filtro1_,_filtro2_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";		
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
				url: configuracion.urlsPublic().modCSoftware.software.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro1:_filtro1_,
						filtro2:_filtro2_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgCaracteristicasSoftware #catalogoDatos").html('');				
			        $("#pgnCaracteristicasSoftware #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgCaracteristicasSoftware #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    		
	            	console.log(JSON.stringify(data));

		            $("#ctlgCaracteristicasSoftware #catalogoDatos").html('');				
		            $("#pgnCaracteristicasSoftware #pagination").html('');				
					//console.log(JSON.stringify(data));
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
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-4'>" + datoItem.NombreVersion + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-4'>" + datoItem.tipo + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdCaracteristicasSoftware.consultarPublic("+datoItem.id+"),ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modCSoftware.software.ventanaModal,1,1)' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdCaracteristicasSoftware.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgCaracteristicasSoftware #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdCaracteristicasSoftware.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdCaracteristicasSoftware.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdCaracteristicasSoftware.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdCaracteristicasSoftware.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnCaracteristicasSoftware #pagination').append(ul);
						});
						$("#ctlgCaracteristicasSoftware #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(29);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgCaracteristicasSoftware #catalogoDatos').append(tr);
							//-------------
							if(_filtro1_!=0 || _filtro2_!=""){

								$("#ctlgCaracteristicasSoftware #btnNuevo").prop('disabled', false);
								$("#ctlgCaracteristicasSoftware #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgCaracteristicasSoftware #btnNuevo").prop('disabled', true);
								$("#ctlgCaracteristicasSoftware #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgCaracteristicasSoftware #btnGenerarReporte").prop('disabled', true);							
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
							* id_c_equipo_ Para realizar consulta
							* cedula_ para realizar consulta
		*/	
		var consultar = function(id_c_equipo_) {

			nucleo.isEdicion=1;
			
			var accion_ = "consultar";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCSoftware.software.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_c_equipo_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					//console.log(JSON.stringify(data));
					//alert(JSON.stringify(data));
					$('#btnGuardar').prop('disabled', false);
					$('#divTipoListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divTipoListD').popover('show');
					$('#divdistribucionListD').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divdistribucionListD').popover('show');			
				    setTimeout(function(){ 
   						//
						$('#vtnCaracteristicasSoftware #datoControlId').val(data[0].id);
						$('#vtnCaracteristicasSoftware #nombreTxt').val(data[0].nombre);
						$('#vtnCaracteristicasSoftware #versionTxt').val(data[0].version);						
      					$("#tipoListD option[value="+data[0].id_tipo+"]").attr("selected",true);					
      					$("#distribucionListD option[value="+data[0].id_distribucion+"]").attr("selected",true);					
					  	//
					  	$('#tipoListD').selectpicker('refresh');
					  	$('#distribucionListD').selectpicker('refresh');
		            	//
				        $('#btnSelectElegido2').attr('style','width:100%;');
				        $('#btnSelectElegido3').attr('style','width:100%;');
		            	//
		            	$('#divTipoListD').popover('destroy');
		            	$('#divdistribucionListD').popover('destroy');
		            	//  	
					    setTimeout(function(){ 

							$('#btnGuardar').prop('disabled', false);
					    }, 400);
				    }, 300);

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
		var cargarLista = function(id_c_software_) {

			var accion_ = "consultarControladoresCSoftware";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCSoftware.software.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_c_software_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					//console.log(JSON.stringify(data));
					//alert(JSON.stringify(data));

					$('#listas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listas').popover('show');					
					$('#vtnCaracteristicasSoftware #vtnCatalogoDatosCSoftware #resultadosGuardados').html('');
					//Obteniendo resultados para lista de controladores
		    		$(data[0].controladores).each(function (index, datoItem) {  				    
						if (datoItem.estadoControlador==1) {
							AccionarEstado	= "Deshabilitar";
							ColorEstado="";
							nuevoEstado=0;
						}else{
							AccionarEstado	= "Habilitar";
							ColorEstado='lista-danger';
							nuevoEstado=1;
						}			    			
						var item =	$('<div  class="row '+ColorEstado+'" style="padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #ddd; border-bottom: 0px solid #ddd;">'+
										'<div  class="col-md-8">'+
							    			'<input type="text" name="Funcion 1" class="lista-control form-control input-sm" id="'+datoItem.id_controlador+'" value="'+datoItem.nombreControlador+'" disabled>'+
							   			'</div>'+
										'<div  class="col-md-4" style="padding: 0px 10px 0px 0px;">'+
											'<button type="button" class="btn btn-default"'+ 
											'onclick="mtdCaracteristicasSoftware.cambiarEstadocontroladorSoftwarePublic('+datoItem.id_controlador+','+datoItem.idcSoftware+','+nuevoEstado+')"'+ 
											'style="width: 100%;padding: 6px px;">'+AccionarEstado+'</button>'+
										'</div>'+ 													
									'</div>'); 													
						$('#vtnCaracteristicasSoftware #vtnCatalogoDatosCSoftware #resultadosGuardados').append(item);

		    		});
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
			$("#vtnCaracteristicasSoftware #form").on("submit", function(e){

				// validar de new los campos
				if(nucleo.validadorPublic()==false){
					e.preventDefault();
					return false;
				}
				/* Obtener valores de los campos del formulario*/

				console.log("guardando...");

				var accion_ = "guardar";
				//
				var nombre_			= $("#nombreTxt").val(); 				
				var version_		= $("#versionTxt").val(); 
				var id_tipo_		= $("#tipoListD").val(); 				
				var id_distribucion_	= $("#distribucionListD").val(); 

				var id_ = $('#vtnCaracteristicasSoftware #datoControlId').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().modCSoftware.software.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),							
							id:id_,
							nombre:nombre_,
							version:version_,
							id_tipo:id_tipo_,
							id_distribucion:id_distribucion_,
						},
	                beforeSend: function () {
	                	$('#vtnCaracteristicasSoftware #form').css("display", "none");
                        $('#vtnCaracteristicasSoftware #procesandoDatosDialg').css("display", "block");
				        $("#ctlgCaracteristicasSoftware #catalogoDatos").html('');				
				        $("#ctlgCaracteristicasSoftware #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgCaracteristicasSoftware #catalogoDatos').append(tr);
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
								mtdCaracteristicasSoftware.vaciarCatalogoPublic();
								mtdCaracteristicasSoftware.cargarCatalogoPublic(paginaActual,"","");
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
		        $('#vtnCaracteristicasSoftware #form')[0].reset();
				e.preventDefault();
				return false;
			});					
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
				url: configuracion.urlsPublic().modCSoftware.software.api,
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
					mtdCaracteristicasSoftware.controlPaginacionPublic(paginaActual);
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
	        $('#vtnCaracteristicasSoftware #form')[0].reset();
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
		  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_logc_tipo','');
		  	nucleo.cargarListaDespegableListasPublic('distribucionListD','cfg_c_logc_distribucion','');

			$('#tipoListD').popover({
			    html: true, 
				placement: "right",
				content: function() {
			          return $('#procesandoDatosInput').html();
			        }
			})
			$('#distribucionListD').popover({
			    html: true, 
				placement: "right",
				content: function() {
			          return $('#procesandoDatosInput').html();
			        }
			});	

        	$('#tipoListD').popover('show');
		  	$('#distribucionListD').popover('show');

		    setTimeout(function(){ 

            	$('#tipoListD').popover('destroy');
			  	$('#distribucionListD').popover('destroy');

			  	$('#tipoListD').selectpicker('refresh');
			  	$('#distribucionListD').selectpicker('refresh');

		        $('#btnSelectElegido0').attr('style','width:100%;');
		        $('#btnSelectElegido1').attr('style','width:100%;');

		    }, 300);


			$(document).ready(function() {

			  	$('#tipoListD').selectpicker('refresh');
			  	$('#distribucionListD').selectpicker('refresh');


			});		
		}

		var inicioItemsCatalogo = function () {

			  	nucleo.cargarListaDespegableListasPublic('btipoListD','cfg_c_logc_tipo','tipo');

				$('#btipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})

            	$('#btipoListD').popover('show');

			    setTimeout(function(){ 

	            	$('#btipoListD').popover('destroy');

				  	$('#btipoListD').selectpicker('refresh');

			        $('#ctlgCaracteristicasSoftware #btnSelectElegido0').attr('style','width:100%;');

			    }, 300);


				$(document).ready(function() {

					$('#btipoListD').on('change',function () {
						var filtro1_ = $('#btipoListD').val();
						var filtro2_ = $('#buscardorTxt').val();
						
						mtdCaracteristicasSoftware.cargarCatalogoPublic(1,filtro1_,filtro2_);	

					});
					$('#buscardorTxt').on('keyup',function (item) {
						var filtro1_ = $('#btipoListD').val();
						var filtro2_ = $('#buscardorTxt').val();
						
						mtdCaracteristicasSoftware.cargarCatalogoPublic(1,filtro1_,filtro2_);	
					});

				  	$('#btipoListD').selectpicker('refresh');

				    $('#ctlgCaracteristicasSoftware #listas .bootstrap-select ').each(function (index, datoItem) {

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
			mtdCaracteristicasSoftware.cargarCatalogoPublic(_pagina_,"","");   
		}	

	/****************Inicializacion e Intancias de metodos *******************/

		return{
			Iniciar : function() {
				console.log("Iniciando carga de metodos de caracteristicas de equipos");
					
					guardar();

				console.log("Finalizando carga de metodos de caracteristicas de equipos");
			},
			inicioItemsCatalogoPublic : inicioItemsCatalogo,
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			cargarListaPublic : cargarLista,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado,
		}
}();