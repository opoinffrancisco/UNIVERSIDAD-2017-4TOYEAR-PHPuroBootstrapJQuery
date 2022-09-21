var mtdCaracteristicasEquipos = function() {
		
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
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";
			var filtro_ = $("#ctlgCaracteristicasEquipos #buscardorTxt").val();
			var filtro2_ = $('#btipoListD').val();
			
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
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						filtro2:filtro2_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgCaracteristicasEquipos #catalogoDatos").html('');				
			        $("#pgnCaracteristicasEquipos #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgCaracteristicasEquipos #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgCaracteristicasEquipos #catalogoDatos").html('');				
		            $("#pgnCaracteristicasEquipos #pagination").html('');				
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
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.modelo + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.marca + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-4'>" + datoItem.tipo + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdCaracteristicasEquipos.consultarPublic("+datoItem.id+"),ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modCEquipo.equipo.ventanaModal,1,1)' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdCaracteristicasEquipos.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgCaracteristicasEquipos #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdCaracteristicasEquipos.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdCaracteristicasEquipos.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdCaracteristicasEquipos.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdCaracteristicasEquipos.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnCaracteristicasEquipos #pagination').append(ul);
						});
						$("#ctlgCaracteristicasEquipos #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(26);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgCaracteristicasEquipos #catalogoDatos').append(tr);
							//-------------
							if(filtro_!="" || filtro2_ !=0 ){

								$("#ctlgCaracteristicasEquipos #btnNuevo").prop('disabled', false);
								$("#ctlgCaracteristicasEquipos #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgCaracteristicasEquipos #btnNuevo").prop('disabled', true);
								$("#ctlgCaracteristicasEquipos #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgCaracteristicasEquipos #btnGenerarReporte").prop('disabled', true);							
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
		var cargarListaDespegableListasUN = function(_idCampo_,_tabla_,_nombreCampo_) {
			var accion_ ="cargarListaDespegableUM";
	        $.ajax({
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
				type:'POST',
				data:{
						accion:accion_,
						tabla:_tabla_,
					},
	            beforeSend: function () {
	            // cargando
	            },
	            success:  function (result) {
   					$('#'+_idCampo_).html('');	            	
					var noselect = $('<option data-subtext="" value="0" >Seleccione una opción</option>');
	    			$('#'+_idCampo_).append(noselect);    		
    				$(result).each(function (index, datoItem) { 
    					$(datoItem.resultados).each(function (index, item) {
	    					//console.log(item);
	    					var opcion = $('<option data-subtext="'+_nombreCampo_+'"  value="'+item.id+'" >'+item.abreviatura+'</option>');
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
		/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
		*/	
		var consultar = function(id_c_equipo_) {

			var accion_ = "consultar";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
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

					$('#listas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listas').popover('show');					
				    setTimeout(function(){ 
   						//
						$('#vtnCaracteristicasEquipos #datoControlId').val(data[0].id);
					  	nucleo.cargarListaDespegableListasAnidadaPublic('modeloListD','cfg_c_fisc_modelo','id_marca',data[0].id_marca,'');
		            	/////
					    setTimeout(function(){ 
   						    setTimeout(function(){ 
		      					$("#marcaListD option[value="+data[0].id_marca+"]").attr("selected",true);					
		   						$("#tipoListD option[value="+data[0].id_tipo+"]").attr("selected",true);					
							  	//
							  	$('#marcaListD').selectpicker('refresh');
							  	$('#tipoListD').selectpicker('refresh');
				            	//
						        $('#btnSelectElegido0').attr('style','width:100%;');
						        $('#btnSelectElegido2').attr('style','width:100%;');
						        $('#btnSelectElegido3').attr('style','width:100%;');
				            	//
				            	$('#divMarcaListD').popover('destroy');
				            	$('#divTipoListD').popover('destroy');
				            	
	      						$("#modeloListD option[value="+data[0].id_modelo+"]").attr("selected",true);					
						  		$('#modeloListD').selectpicker('refresh');
					        	$('#btnSelectElegido1').attr('style','width:100%;');
			            		$('#divModeloListD').popover('destroy');
			            	}, 200);
							$('#vtnCaracteristicasEquipos #vtnCatalogoDatosCEquipos #resultadosGuardados').html('');
							//Obteniendo resultados para lista de interfaces
				    		$(data[0].interfaces).each(function (index, datoItem) {  				    
								if (datoItem.estadoInterfaz==1) {
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
									    			'<input type="text" name="Funcion 1" class="lista-control form-control input-sm" id="'+datoItem.id_interfaz+'" value="'+datoItem.nombreInterfaz+'" disabled>'+
									   			'</div>'+
												'<div  class="col-md-4" style="padding: 0px 10px 0px 0px;">'+
													'<button type="button" class="btn btn-default"'+ 
													'onclick="mtdCaracteristicasEquipos.cambiarEstadoInterfazEquipoPublic('+datoItem.id_interfaz+','+datoItem.idcEquipos+','+nuevoEstado+')"'+ 
													'style="width: 100%;padding: 6px px;">'+AccionarEstado+'</button>'+
												'</div>'+ 													
											'</div>'); 													
								$('#vtnCaracteristicasEquipos #vtnCatalogoDatosCEquipos #resultadosGuardados').append(item);

				    		});
			            	$('#listas').popover('destroy');
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
		var cargarLista = function(id_c_equipo_) {

			var accion_ = "consultarInterfacesCEquipo";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
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

					$('#listas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listas').popover('show');					
					$('#vtnCaracteristicasEquipos #vtnCatalogoDatosCEquipos #resultadosGuardados').html('');
					//Obteniendo resultados para lista de interfaces
		    		$(data[0].interfaces).each(function (index, datoItem) { 
						if (datoItem.estadoInterfaz==1) {
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
							    			'<input type="text" name="iterfaz" class="lista-control form-control input-sm" id="'+datoItem.id_interfaz+'" value="'+datoItem.nombreInterfaz+'" disabled>'+
							   			'</div>'+
										'<div  class="col-md-4" style="padding: 0px 10px 0px 0px;">'+
											'<button type="button" class="btn btn-default"'+ 
											'onclick="mtdCaracteristicasEquipos.cambiarEstadoInterfazEquipoPublic('+datoItem.id_interfaz+','+datoItem.idcEquipos+','+nuevoEstado+')"'+ 
											'style="width: 100%;padding: 6px px;">'+AccionarEstado+'</button>'+
										'</div>'+ 													
									'</div>'); 													
						$('#vtnCaracteristicasEquipos #vtnCatalogoDatosCEquipos #resultadosGuardados').append(item);

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

				if ($('#listas #vtnCatalogoDatosCEquipos div div select').length>0) {
					var interfaces_=[];
					$('#listas #vtnCatalogoDatosCEquipos div div select').each(function (index, datoItem){
						var idInterfaz = $(datoItem).val();
						//alert(idInterfaz);
						if (idInterfaz!=null) {
							//alert(idInterfaz);
							interfaces_.push(idInterfaz);
						};
					});
					if (interfaces_.length<1){
						var interfaces_=0;
					};
				}else{
					var interfaces_=0;
				};

				var id_ = $('#vtnCaracteristicasEquipos #datoControlId').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().modCEquipo.equipo.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),							
							id:id_,
							id_modelo:id_modelo_,
							id_tipo:id_tipo_,
							interfaces:interfaces_,
						},
	                beforeSend: function () {
	                	$('#vtnCaracteristicasEquipos #form').css("display", "none");
                        $('#vtnCaracteristicasEquipos #procesandoDatosDialg').css("display", "block");
				        $("#ctlgCaracteristicasComponentes #catalogoDatos").html('');				
				        $("#ctlgCaracteristicasComponentes #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgCaracteristicasComponentes #catalogoDatos').append(tr);
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
								mtdCaracteristicasEquipos.vaciarCatalogoPublic();
								mtdCaracteristicasEquipos.cargarCatalogoPublic(paginaActual);
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
				mtdCaracteristicasEquipos.restablecerFormPublic();
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
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
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
					mtdCaracteristicasEquipos.controlPaginacionPublic(paginaActual);
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}	

		var cambiarEstadoInterfazEquipo = function(id_interfaz_,idCEquipo_,estado_) {
			var accion_ = "cambiarEstadoInterfazEquipo";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modCEquipo.equipo.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						id_interfaz:id_interfaz_,
						idCEquipo:idCEquipo_,
						estado:estado_
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log("listo");
					mtdCaracteristicasEquipos.cargarListaPublic(idCEquipo_);
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

			  	nucleo.cargarListaDespegableListasAnidadaPublic('modeloListD','cfg_c_fisc_modelo','id_marca',id_marca,'');
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
	        $('#vtnCaracteristicasEquipos #form')[0].reset();
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
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');
			  	nucleo.cargarListaDespegableListasPublic('interfazListD','cfg_c_fisc_interfaz_conexion','interfaz');

				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
/*				$('#modeloListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});
*/
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
			  	//$('#modeloListD').popover('show');
			  	$('#tipoListD').popover('show');
			  	$('#interfazListD').popover('show');				  	

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	//$('#modeloListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');

				  	$('#marcaListD').selectpicker('refresh');
				  	//$('#modeloListD').selectpicker('refresh');
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
			mtdCaracteristicasEquipos.cargarCatalogoPublic(_pagina_);   
		}	

		var activarEscuchador = function () {
		
			var idVtn = "#vtnCaracteristicasEquipos";
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
				filtrarSelect();
				activarEscuchador();
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			cargarListaPublic : cargarLista,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado,
			cambiarEstadoInterfazEquipoPublic : cambiarEstadoInterfazEquipo,
			cargarListaDespegableListasUNPublic : cargarListaDespegableListasUN,

		}
}();