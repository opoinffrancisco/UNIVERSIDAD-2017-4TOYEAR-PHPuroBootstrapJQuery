var mtdTarea = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 11; // Tamaño de filas por pagina #paginacion
		var cargaCatalogoAtivo = "";// Para determinar el catalogo activo 
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
			var filtro_ = $("#ctlgTarea #buscardorTxt").val();
			
			if(filtro_==""){
				cargaCatalogoAtivo ="cargaTotal";
			}else{
				cargaCatalogoAtivo ="cargaFiltro";
			};
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
				url: configuracion.urlsPublic().modTareas.tabs.tarea.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgTarea #catalogoDatos").html('');				
			        $("#pgnTarea #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgTarea #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgTarea #catalogoDatos").html('');				
		            $("#pgnTarea #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estadoTarea==1) {
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
								var mensajeTipoTarea="";
								if (datoItem.tarea_correctiva==0) {
									mensajeTipoTarea = "PREVENTIVO";
								}else{
									mensajeTipoTarea = "CORRECTIVO";
								};

								tr = $('<tr class="row '+ColorEstado+'">');
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-6'>" + datoItem.nombre + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + mensajeTipoTarea + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdTarea.consultarPublic("+datoItem.id+"),ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modTareas.tabs.tarea.ventanaModal,1,1)' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdTarea.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgTarea #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdTarea.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdTarea.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdTarea.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdTarea.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnTarea #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(14);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgTarea #catalogoDatos').append(tr);
							//-------------
							if (filtro_!=""){
								$("#ctlgTarea #btnNuevo").prop('disabled', false);
								$("#ctlgTarea #btnNuevo").addClass('imputSusess');
							}else{
								$("#ctlgTarea #btnNuevo").prop('disabled', true);
								$("#ctlgTarea #btnNuevo").removeClass('imputSusess');
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
		/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
		*/	
		var consultar = function(id_tarea_) {

			var accion_ = "consultar";
			
			console.log("verificando: "+id_tarea_);
			//
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
					$('#vtnTarea #datoControlId').val(data[0].id);
					$("#vtnTarea #nombreTxt").val(data[0].nombre); 
					$("#vtnTarea #descripcionTxt").val(data[0].descripcion); 

					if(data[0].tarea_correctiva>0) {
						$("#tareaCorrectivaCbox").attr('checked',true);						
					} else {
						$("#tareaCorrectivaCbox").attr('checked',false);						
					}					

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

/*				if($('#ventana-modal').hasClass('ventana-modal-panel-accionCerrar')){
			        return false;
			    }
*/				var accion_ = "guardar";

				/* Obtener valores de los campos del formulario*/
				//
				var nombre_	= $("#nombreTxt").val(); 
				var descripcion_	= $("#descripcionTxt").val(); 
				var tarea_correctiva_ = $("#tareaCorrectivaCbox").is(':checked');
				tarea_correctiva_ = (tarea_correctiva_==true)? 1 : 0 ;

				var id_ = $('#vtnTarea #datoControlId').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().modTareas.tabs.tarea.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),							
							id:id_,
							nombre:nombre_,
							descripcion:descripcion_,
							tarea_correctiva:tarea_correctiva_,
						},
	                beforeSend: function () {
	                	$('#vtnTarea #form').css("display", "none");
                        $('#vtnTarea #procesandoDatosDialg').css("display", "block");
				        $("#ctlgTarea #catalogoDatos").html('');				
				        $("#ctlgTarea #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgTarea #catalogoDatos').append(tr);
	                },
	                success:  function (result) {
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==true) {
								// se comproobo que se abrio como administrador en las vistas de los procesos
								nucleo.controlBtnAdminInProcessPublic();
							}else{
								ventanaModal.ocultarPulico('ventana-modal');
								mtdTarea.vaciarCatalogoPublic();
								mtdTarea.cargarCatalogoPublic(paginaActual);
							};
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
				url: configuracion.urlsPublic().modTareas.tabs.tarea.api,
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
					mtdTarea.controlPaginacionPublic(paginaActual);
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));	
						alertas.dialogoErrorPublic(error.readyState,error.responseText);
			    }
			});
			return false;

		}	
////////////////////////////////////////////////////////////////////////////////////

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
	        $('#vtnTarea #form')[0].reset();
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
			mtdTarea.cargarCatalogoPublic(_pagina_);   
		}	

	

		var activarEscuchador = function () {
		
			var idVtn = "#vtnTarea";
			// -> Form Vtn
			$(idVtn+' #form #btnGuardar').on('click', function(e) {
				e.preventDefault();
				if (atcEnvioEnter==0) {	
					if($('#tareaListD').length>0){
						$('#tareaListD').removeClass('campo-control');
					};
					if(nucleo.validadorPublic()==true){						
						if($('#tareaListD').length>0){
							$('#tareaListD').addClass('campo-control');
						};												
		        		guardar();
		    		}
			  	}else{
			  		atcEnvioEnter=0;
			  	}
			});
			//	
			$(idVtn+' input').on('keypress', function(e) {
			    if(e.keyCode==13){
					if($('#tareaListD').length>0){
						$('#tareaListD').removeClass('campo-control');
					};					
					if(nucleo.validadorPublic()==true){
						if($('#tareaListD').length>0){
							$('#tareaListD').addClass('campo-control');
						};						
      						atcEnvioEnter= 1;
			        	guardar();
					}
			    }
			});
			$(idVtn+' textarea').on('keypress', function(e) {
			    if(e.keyCode==13){
					if($('#tareaListD').length>0){
						$('#tareaListD').removeClass('campo-control');
					};					
					if(nucleo.validadorPublic()==true){
						if($('#tareaListD').length>0){
							$('#tareaListD').addClass('campo-control');
						};						
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
				$(document).ready(function () {
					activarEscuchador();
					if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==false) {
						mtdTarea.cargarCatalogoPublic(1);
						nucleo.asignarPermisosBotonesPublic(14);
					}		
					nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - TAREAS - SECCIÓN : TAREAS");		
				});				
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado,

		}
}();