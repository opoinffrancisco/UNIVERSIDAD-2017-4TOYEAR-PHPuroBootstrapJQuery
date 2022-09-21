var mtdDepartamento = function() {
		
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
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var accion_ = "FiltrarLista";
			var filtro_ = $("#ctlgDepartamento #buscardorTxt").val();
			
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
				url: configuracion.urlsPublic().modDepartamento.departamento.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgDepartamento #catalogoDatos").html('');				
			        $("#pgnDepartamento #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgDepartamento #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgDepartamento #catalogoDatos").html('');				
		            $("#pgnDepartamento #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estadoDepartamento==1) {
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
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-8'>" + datoItem.nombre + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdDepartamento.consultarPublic("+datoItem.id+")' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdDepartamento.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgDepartamento #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdDepartamento.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdDepartamento.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdDepartamento.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdDepartamento.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnDepartamento #pagination').append(ul);
						});
						$("#ctlgDepartamento #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(12);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgDepartamento #catalogoDatos').append(tr);
							//-------------
							if(filtro_!=""){

								$("#ctlgDepartamento #btnNuevo").prop('disabled', false);
								$("#ctlgDepartamento #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgDepartamento #btnNuevo").prop('disabled', true);
								$("#ctlgDepartamento #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgDepartamento #btnGenerarReporte").prop('disabled', true);							
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
		var consultar = function(id_departamento_) {


			var accion_ = "consultar";
			
			console.log("verificando: "+id_departamento_);
			//
	        $.ajax({
				url: configuracion.urlsPublic().modDepartamento.departamento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_departamento_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					ventanaModal.mostrarBasicPublico();
					$('#vtnDepartamento #datoControlId').val(data[0].id);
					$("#vtnDepartamento #nombreTxt").val(data[0].nombre); 
					mtdDepartamento.cargarListaDCargosPublic(id_departamento_);
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
				//
				var accion_ = "guardar";
				//
				var nombre_	= $("#nombreTxt").val(); 
				var id_ = $('#vtnDepartamento #datoControlId').val();
				var cargos_=[];
				var Cseleccionados=0;
					
				if ($('#listas #vtnCatalogoDatosDCargos div div select').length>0) {

					$('#listas #vtnCatalogoDatosDCargos div div select').each(function (index, datoItem){
						var cargo = $(datoItem).val();
						//alert(herramienta);
						if (cargo!=null) {
							//alert(herramienta);
							cargos_.push(cargo);
							Cseleccionados=Cseleccionados+1;
						};
					});
					//alert('Cantidad: '+cargos_.length+' array: '+cargos_+' seleccionados: '+Cseleccionados);
					if (cargos_.length<1 || Cseleccionados==0){
						var cargos_=0;
					};
				}else{
					var cargos_=0;
				};				
				//
		        $.ajax({
					url: configuracion.urlsPublic().modDepartamento.departamento.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),			
							id:id_,
							nombre:nombre_,
							cargos:cargos_,
						},
	                beforeSend: function () {
	                	$('#vtnDepartamento #form').css("display", "none");
                        $('#vtnDepartamento #procesandoDatosDialg').css("display", "block");
				        $("#ctlgDepartamento #catalogoDatos").html('');				
				        $("#ctlgDepartamento #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgDepartamento #catalogoDatos').append(tr);
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
								mtdDepartamento.vaciarCatalogoPublic();
								mtdDepartamento.cargarCatalogoPublic(paginaActual);
						        restablecerForm();
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
						url: configuracion.urlsPublic().modDepartamento.departamento.api,
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
						console.log(JSON.stringify(data));
						mtdDepartamento.controlPaginacionPublic(paginaActual);
						return true;
		            },
			    	error: function(error) {
							console.log(JSON.stringify(error));
							alertas.dialogoErrorPublic(error.readyState,error.responseText);	
				    }
				});

			return false;
		}	
/*****************************************************************************/
		var cargarListaDCargos = function(id_departamento_) {

			var accion_ = "consultarDepartamentoCargo";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modDepartamento.departamento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_departamento_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log(JSON.stringify(data));
					//alert(JSON.stringify(data));

					$('#listas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listas').popover('show');					
					$('#vtnDepartamento #vtnCatalogoDatosDCargos #resultadosGuardados').html('');
					//Obteniendo resultados para lista de interfaces
		    		$(data[0].cargos).each(function (index, datoItem) {  				    
						if (datoItem.estado==1) {
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
							    			'<input type="text" name="Funcion 1" class="lista-control form-control input-sm" id="'+datoItem.id_cargo+'" value="'+datoItem.nombre+'" disabled>'+
							   			'</div>'+
										'<div  class="col-md-4" style="padding: 0px 10px 0px 0px;">'+
											'<button type="button" class="btn btn-default"'+ 
											'onclick="mtdDepartamento.cambiarEstadoDepartamentoCargoPublic('+datoItem.id_cargo+','+datoItem.idDepartamento+','+nuevoEstado+')"'+ 
											'style="width: 100%;padding: 6px px;">'+AccionarEstado+'</button>'+
										'</div>'+ 													
									'</div>'); 													
						$('#vtnDepartamento #vtnCatalogoDatosDCargos #resultadosGuardados').append(item);

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
		var cambiarEstadoDepartamentoCargo = function(id_cargo_,id_departamento_,estado_) {
			var accion_ = "cambiarEstadoDepartamentoCargo";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modDepartamento.departamento.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						id_cargo:id_cargo_,
						id_departamento:id_departamento_,
						estado:estado_
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log("listo");
					mtdDepartamento.cargarListaDCargosPublic(id_departamento_);
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
	        $('#vtnDepartamento #form')[0].reset();
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
			panelTabs.cambiarVentanaModalPublic(configuracion.urlsPublic().modDepartamento.departamento.ventanaModal);
		}
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			paginaActual = _pagina_;
			mtdDepartamento.cargarCatalogoPublic(_pagina_);   
		}	

		var activarEscuchador = function () {
		
			var idVtn = "#vtnDepartamento";
			// -> Form Vtn
			$(idVtn+' #form #btnGuardar').on('click', function(e) {
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
				activarEscuchador();
				nucleo.cargarListaDespegablePublic('selectCargos','cfg_pn_cargo');
				if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==false) {
					nucleo.asignarPermisosBotonesPublic(12);					
				}
				nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO DE CONFIGURACIÓN - DEPARTAMENTOS - SECCIÓN : DEPARTAMENTOS"); 						
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			cargarListaDCargosPublic : cargarListaDCargos,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado,
			cambiarEstadoDepartamentoCargoPublic : cambiarEstadoDepartamentoCargo,
		}
}();