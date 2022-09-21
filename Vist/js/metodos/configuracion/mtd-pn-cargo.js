var mtdCargo = function() {
		
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
			var filtro_ = $("#ctlgCargo #buscardorTxt").val();
			
			//
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			var mensajeRespDpt = "";
			//
			// control paginacion
			var pagina_ = _pagina_;
			//
	        $.ajax({
				url: configuracion.urlsPublic().modDepartamento.cargo.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgCargo #catalogoDatos").html('');				
			        $("#pgnCargo #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgCargo #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgCargo #catalogoDatos").html('');				
		            $("#pgnCargo #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estadoCargo==1) {
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
								if (datoItem.responsable_departamento==1) {
									mensajeRespDpt	= "SI";
								}else{
									mensajeRespDpt	= "NO";
								}								

								tr = $('<tr class="row '+ColorEstado+'">');
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-6'>" + datoItem.nombre + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + mensajeRespDpt + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdCargo.consultarPublic("+datoItem.id+")' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdCargo.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgCargo #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdCargo.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdCargo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdCargo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdCargo.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnCargo #pagination').append(ul);
						});
						$("#ctlgCargo #btnGenerarReporte").prop('disabled', false);
						nucleo.asignarPermisosBotonesPublic(13);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgCargo #catalogoDatos').append(tr);
							//-------------
							if(filtro_!=""){

								$("#ctlgCargo #btnNuevo").prop('disabled', false);
								$("#ctlgCargo #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgCargo #btnNuevo").prop('disabled', true);
								$("#ctlgCargo #btnNuevo").removeClass('imputSusess');
								
							}
							// sin datos no se generan reportes
							$("#ctlgCargo #btnGenerarReporte").prop('disabled', true);							
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
				url:configuracion.urlsPublic().modDepartamento.cargo.api ,
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
					$('#vtnCargo #datoControlId').val(data[0].id);
					$("#vtnCargo #nombreTxt").val(data[0].nombre); 

					if(data[0].responsable_departamento>0) {
						$("#responsableCbox").attr('checked',true);						
					} else {
						$("#responsableCbox").attr('checked',false);						
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
		/* La funcionalidad Guardar: 
			# Uso : Se usa para guardar y editar
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardar = function() {

				/* Obtener valores de los campos del formulario*/
				console.log("guardando...");
				if($('#ventana-modal').hasClass('ventana-modal-panel-accionCerrar')){
			        return false;
			    }

				var accion_ = "guardar";
				//
				var nombre_	= $("#nombreTxt").val(); 
				var id_ = $('#vtnCargo #datoControlId').val();
				var responsable_departamento_ = $("#responsableCbox").is(':checked');
				responsable_departamento_ = (responsable_departamento_==true)? 1 : 0 ;
				//
		        $.ajax({
					url:configuracion.urlsPublic().modDepartamento.cargo.api ,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),							
							id:id_,
							nombre:nombre_,
							responsable_departamento:responsable_departamento_,
						},
	                beforeSend: function () {
	                	$('#vtnCargo #form').css("display", "none");
                        $('#vtnCargo #procesandoDatosDialg').css("display", "block");
				        $("#ctlgCargo #catalogoDatos").html('');				
				        $("#ctlgCargo #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgCargo #catalogoDatos').append(tr);
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
								mtdCargo.vaciarCatalogoPublic();
								mtdCargo.cargarCatalogoPublic(paginaActual);
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
					url:configuracion.urlsPublic().modDepartamento.cargo.api ,
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
					mtdCargo.controlPaginacionPublic(paginaActual);
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
	        $('#vtnCargo #form')[0].reset();
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
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			paginaActual = _pagina_;
			mtdCargo.cargarCatalogoPublic(_pagina_);   
		}	
		var activarEscuchador = function () {
		
			var idVtn = "#vtnCargo";
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
				console.log("Iniciando carga de metodos de departamento");
				
					mtdCargo.cargarCatalogoPublic(1);
					activarEscuchador();

				console.log("Finalizando carga de metodos de departamento");
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado

		}
}();