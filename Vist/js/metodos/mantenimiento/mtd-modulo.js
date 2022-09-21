var mtdModulo = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 11; // Tamaño de filas por pagina #paginacion
		var cargaCatalogoAtivo = "";// Para determinar el catalogo activo 
		var atcEnvioEnter=0;
		var controlDatoBitacoraG = "";
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
			var filtro_ = $("#ctlgModulo #buscardorTxt").val();
			
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
				url: configuracion.urlsPublic().mantenimineto.modModulo.modulo.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgModulo #catalogoDatos").html('');				
			        $("#pgnModulo #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgModulo #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgModulo #catalogoDatos").html('');				
		            $("#pgnModulo #pagination").html('');				
					//console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estadoModulo==1) {
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
								var disabledBtnEstado="";
								// nose permite bloquear este
								if (datoItem.id==8 && sessionStorage.getItem('id_perfil-US')!=0) {
									disabledBtnEstado =" disabled='TRUE' ";
									AccionarEstado ="No permitido";
								}

									tr = $('<tr class="row '+ColorEstado+'">');
											tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-8'>" + datoItem.nombre + "</td>");
											var filtroMostrarVentana = 'ventana-modal';
											tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
													  "<div class='btn-group' role='group' style='width: 100%;'>"+
															  "<button type='button' class='btn btn-default' id='btnEditar' "+disabledEditar+" onclick='mtdModulo.consultarPublic("+datoItem.id+"),ventanaModal.mostrarBasicPublico()' style='width: 50%;'>Editar</button>"+
															  '<button type="button" class="btn btn-default" onclick="mtdModulo.cambiarEstadoPublic('+datoItem.id+','+nuevoEstado+',&#39;'+datoItem.nombre+'&#39;)" style="width: 50%;padding: 0px 0px;" '+disabledBtnEstado+'>'+AccionarEstado+'</button>'+
													  "</div>"+
													"</td>");

										tr.append("</tr>");

									$('#ctlgModulo #catalogoDatos').append(tr);

							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdModulo.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdModulo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdModulo.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdModulo.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnModulo #pagination').append(ul);
						});

					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgModulo #catalogoDatos').append(tr);
							//-------------
							if (filtro_!=""){
								$("#ctlgModulo #btnNuevo").prop('disabled', false);
								$("#ctlgModulo #btnNuevo").addClass('imputSusess');
							}else{
								$("#ctlgModulo #btnNuevo").prop('disabled', true);
								$("#ctlgModulo #btnNuevo").removeClass('imputSusess');
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
		var consultar = function(id_departamento_) {

			var accion_ = "consultar";
			
			//console.log("verificando: "+id_departamento_);
			//
	        $.ajax({
				url: configuracion.urlsPublic().mantenimineto.modModulo.modulo.api,
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
					$('#vtnModulo #datoControlId').val(data[0].id);
					var nombre = data[0].nombre;
					controlDatoBitacoraG = nombre;
					$("#vtnModulo #nombreTxt").val(nombre); 
					$("#vtnModulo #descripcionTxt").val(data[0].descripcion); 

					if(data[0].id_modulo_pertenece>0) {

						$('#perteneceCbox').addClass('active');
						$("#perteneceCbox").attr('checked',true);						
						$('.panel-pertenece').collapse('show'); 

						$("#moduloPerteneceListD option[value='"+data[0].id_modulo_pertenece+"']").attr("selected",true);	
					  	$('#moduloPerteneceListD').selectpicker('refresh');						

					} else {

						$('#principalCbox').addClass('active');
						$("#principalCbox").attr('checked',true);						

					}


					if(data[0].func_nuevo==1){
						$("#nuevoCbox").attr('checked',true);
					}else{
						$("#nuevoCbox").attr('checked',false);
					}

					if(data[0].func_editar==1){
						$("#editarCbox").attr('checked',true);
					}else{
						$("#editarCbox").attr('checked',false);
					}

					if(data[0].func_eliminacion_logica==1){
						$("#eliminacionLogCbox").attr('checked',true);
					}else{
						$("#eliminacionLogCbox").attr('checked',false);
					}

					if(data[0].func_generar_reporte==1){
						$("#generarRptCbox").attr('checked',true);
					}else{
						$("#generarRptCbox").attr('checked',false);
					}

					if(data[0].func_generar_reporte_filtrado==1){
						$("#generarRptFltCbox").attr('checked',true);
					}else{
						$("#generarRptFltCbox").attr('checked',false);
					}


					if(data[0].func_permisos_perfil==1){
						$("#permisosPerfilCbox").attr('checked',true);
					}else{
						$("#permisosPerfilCbox").attr('checked',false);
					}

					if(data[0].func_busqueda_avanzada==1){
						$("#busquedaAvanzadaCbox").attr('checked',true);
					}else{
						$("#busquedaAvanzadaCbox").attr('checked',false);
					}

					if(data[0].func_detalles==1){
						$("#detallesCbox").attr('checked',true);
					}else{
						$("#detallesCbox").attr('checked',false);
					}

					if(data[0].func_atender==1){
						$("#atenderCbox").attr('checked',true);
					}else{
						$("#atenderCbox").attr('checked',false);
					}

					if(data[0].func_asignar==1){
						$("#asignarCbox").attr('checked',true);
					}else{
						$("#asignarCbox").attr('checked',false);
					}

					if(data[0].func_programar_tarea==1){
						$("#programarTareaCbox").attr('checked',true);
					}else{
						$("#programarTareaCbox").attr('checked',false);
					}

					if(data[0].func_iniciar_finalizar_tarea==1){
						$("#iniciarFinalizarTareaCbox").attr('checked',true);
					}else{
						$("#iniciarFinalizarTareaCbox").attr('checked',false);
					}

					if(data[0].func_diagnosticar==1){
						$("#diagnosticarCbox").attr('checked',true);
					}else{
						$("#diagnosticarCbox").attr('checked',false);
					}

					if(data[0].func_respuesta_solicitud==1){
						$("#respuestaSoltCbox").attr('checked',true);
					}else{
						$("#respuestaSoltCbox").attr('checked',false);
					}

					if(data[0].func_finalizar_solicitud==1){
						$("#finalizarSoltCbox").attr('checked',true);
					}else{
						$("#finalizarSoltCbox").attr('checked',false);
					}

					if(data[0].func_gestion_equipo_mantenimiento==1){
						$("#gestionEquipoCbox").attr('checked',true);
					}else{
						$("#gestionEquipoCbox").attr('checked',false);
					}
					/*************************************************************/

					if(data[0].func_desincorporar_equipo==1){
						$("#desincorporarEquipoCbox").attr('checked',true);
					}else{
						$("#desincorporarEquipoCbox").attr('checked',false);
					}

					if(data[0].func_desincorporar_periferico==1){
						$("#desincorporarPerifericoCbox").attr('checked',true);
					}else{
						$("#desincorporarPerifericoCbox").attr('checked',false);
					}

					if(data[0].func_desincorporar_componente==1){
						$("#desincorporarComponenteCbox").attr('checked',true);
					}else{
						$("#desincorporarComponenteCbox").attr('checked',false);
					}

					if(data[0].func_cambiar_periferico==1){
						$("#cambiarPerifericoCbox").attr('checked',true);
					}else{
						$("#cambiarPerifericoCbox").attr('checked',false);
					}

					if(data[0].func_cambiar_componente==1){
						$("#cambiarComponenteCbox").attr('checked',true);
					}else{
						$("#cambiarComponenteCbox").attr('checked',false);
					}

					if(data[0].func_cambiar_software==1){
						$("#cambiarSoftwareCbox").attr('checked',true);
					}else{
						$("#cambiarSoftwareCbox").attr('checked',false);
					}

					if(data[0].func_inconformidad_atendida==1){
						$("#inconformidadAtendidaCbox").attr('checked',true);
					}else{
						$("#inconformidadAtendidaCbox").attr('checked',false);
					}

					/*************************************************************/

					nucleo.guardarBitacoraPublic("CONSULTO EL MODULO "+nombre);
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


				//console.log("guardando...");
				if($('#ventana-modal').hasClass('ventana-modal-panel-accionCerrar')){
			        return false;
			    }
				/* Obtener valores de los campos del formulario*/
				
				var accion_ = "guardar";
				//
				var nombre_	= $("#nombreTxt").val(); 
				var descripcion_	= $("#descripcionTxt").val(); 

				var func_nuevo_ = $("#nuevoCbox").is(':checked');
				func_nuevo_ = (func_nuevo_==true)? 1 : 0 ;

				var func_editar_ = $("#editarCbox").is(':checked');
				func_editar_ = (func_editar_==true)? 1 : 0 ;

				var func_eliminacion_logica_ = $("#eliminacionLogCbox").is(':checked');
				func_eliminacion_logica_ = (func_eliminacion_logica_==true)? 1 : 0 ;

				var func_generar_reporte_ = $("#generarRptCbox").is(':checked');
				func_generar_reporte_ = (func_generar_reporte_==true)? 1 : 0 ;

				var func_generar_reporte_filtrado_ = $("#generarRptFltCbox").is(':checked');
				func_generar_reporte_filtrado_ = (func_generar_reporte_filtrado_==true)? 1 : 0 ;

				var func_permisos_perfil_ = $("#permisosPerfilCbox").is(':checked');
				func_permisos_perfil_ = (func_permisos_perfil_==true)? 1 : 0 ;

				var func_busqueda_avanzada_ = $("#busquedaAvanzadaCbox").is(':checked');
				func_busqueda_avanzada_ = (func_busqueda_avanzada_==true)? 1 : 0 ;

				var func_detalles_ = $("#detallesCbox").is(':checked');
				func_detalles_ = (func_detalles_==true)? 1 : 0 ;

				var func_atender_ = $("#atenderCbox").is(':checked');
				func_atender_ = (func_atender_==true)? 1 : 0 ;

				var func_asignar_ = $("#asignarCbox").is(':checked');
				func_asignar_ = (func_asignar_==true)? 1 : 0 ;

				var func_programar_tarea_ = $("#programarTareaCbox").is(':checked');
				func_programar_tarea_ = (func_programar_tarea_==true)? 1 : 0 ;

				var func_iniciar_finalizar_tarea_ = $("#iniciarFinalizarTareaCbox").is(':checked');
				func_iniciar_finalizar_tarea_ = (func_iniciar_finalizar_tarea_==true)? 1 : 0 ;

				var func_diagnosticar_ = $("#diagnosticarCbox").is(':checked');
				func_diagnosticar_ = (func_diagnosticar_==true)? 1 : 0 ;

				var func_respuesta_solicitud_ = $("#respuestaSoltCbox").is(':checked');
				func_respuesta_solicitud_ = (func_respuesta_solicitud_==true)? 1 : 0 ;

				var func_finalizar_solicitud_ = $("#finalizarSoltCbox").is(':checked');
				func_finalizar_solicitud_ = (func_finalizar_solicitud_==true)? 1 : 0 ;

				var func_gestion_equipo_mantenimiento_ = $("#gestionEquipoCbox").is(':checked');
				func_gestion_equipo_mantenimiento_ = (func_gestion_equipo_mantenimiento_==true)? 1 : 0 ;
				/********************************************************************************************************/

				var func_desincorporar_equipo_ = $("#desincorporarEquipoCbox").is(':checked');
				func_desincorporar_equipo_ = (func_desincorporar_equipo_==true)? 1 : 0 ;

				var func_desincorporar_periferico_ = $("#desincorporarPerifericoCbox").is(':checked');
				func_desincorporar_periferico_ = (func_desincorporar_periferico_==true)? 1 : 0 ;

				var func_desincorporar_componente_ = $("#desincorporarComponenteCbox").is(':checked');
				func_desincorporar_componente_ = (func_desincorporar_componente_==true)? 1 : 0 ;

				var func_cambiar_periferico_ = $("#cambiarPerifericoCbox").is(':checked');
				func_cambiar_periferico_ = (func_cambiar_periferico_==true)? 1 : 0 ;

				var func_cambiar_componente_ = $("#cambiarComponenteCbox").is(':checked');
				func_cambiar_componente_ = (func_cambiar_componente_==true)? 1 : 0 ;

				var func_cambiar_software_ = $("#cambiarSoftwareCbox").is(':checked');
				func_cambiar_software_ = (func_cambiar_software_==true)? 1 : 0 ;

				var func_inconformidad_atendida_ = $("#inconformidadAtendidaCbox").is(':checked');
				func_inconformidad_atendida_ = (func_inconformidad_atendida_==true)? 1 : 0 ;

				/********************************************************************************************************/
				// 0 = aa principal
				var moduloPertenece_ = 0;

				if ($('#perteneceCbox').is(':checked')==true){
					moduloPertenece_ = $('#moduloPerteneceListD').val();
					if (moduloPertenece_==0) { 

						$('#divModuloPerteneceListD').popover({
							placement: "right",
							content: "Selecione una opcion",
						});
					  	$('#divModuloPerteneceListD').popover('show');

						return false;
					}else{
						$('#divModuloPerteneceListD').popover('destroy');
					}
				}

				var id_ = $('#vtnModulo #datoControlId').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().mantenimineto.modModulo.modulo.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),	
							id:id_,
							nombre:nombre_,
							descripcion:descripcion_,
							moduloPertenece:moduloPertenece_,
							func_nuevo:func_nuevo_,
							func_editar:func_editar_,
							func_eliminacion_logica:func_eliminacion_logica_,
							func_generar_reporte:func_generar_reporte_,
							func_generar_reporte_filtrado:func_generar_reporte_filtrado_,
							func_permisos_perfil:func_permisos_perfil_,
							func_busqueda_avanzada:func_busqueda_avanzada_,
							func_detalles:func_detalles_,
							func_atender:func_atender_,
							func_asignar:func_asignar_,
							func_programar_tarea:func_programar_tarea_,
							func_iniciar_finalizar_tarea:func_iniciar_finalizar_tarea_,
							func_diagnosticar:func_diagnosticar_,
							func_gestion_equipo_mantenimiento:func_gestion_equipo_mantenimiento_,
							func_respuesta_solicitud:func_respuesta_solicitud_,
							func_finalizar_solicitud:func_finalizar_solicitud_,
							
							func_desincorporar_equipo:func_desincorporar_equipo_,
							func_desincorporar_periferico:func_desincorporar_periferico_,
							func_desincorporar_componente:func_desincorporar_componente_,
							func_cambiar_periferico:func_cambiar_periferico_,
							func_cambiar_componente:func_cambiar_componente_,
							func_cambiar_software:func_cambiar_software_,
							func_inconformidad_atendida:func_inconformidad_atendida_,

						},
	                beforeSend: function () {
	                	$('#vtnModulo #form').css("display", "none");
                        $('#vtnModulo #procesandoDatosDialg').css("display", "block");
				        $("#catalogoDatos").html('');				
				        $("#pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#catalogoDatos').append(tr);
	                },
	                success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {

							if(id_!=""){
								nucleo.guardarBitacoraPublic("EDITO EL MODULO "+controlDatoBitacoraG+" A "+nombre_);
							}else{
								nucleo.guardarBitacoraPublic("GUARDO EL MODULO "+nombre_);								
							}

							nucleo.alertaExitoPublic(result[0].detalles);
							ventanaModal.ocultarPulico('ventana-modal');
							mtdModulo.vaciarCatalogoPublic();
							mtdModulo.cargarCatalogoPublic(paginaActual);
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
				mtdModulo.restablecerFormPublic(); 		        
				return false;
		}
		/* La funcionalidad cambiarEstado: 
			# Uso : Se usa para cambiar el estado 
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var cambiarEstado = function(id_,estado_,nombre_) {
	
				var accion_ = "cambiarEstado";
				//
				var mensaje = "";
				if(estado_==0){
					mensaje = "DESHABILITO ";
				}
				if(estado_==1){
					mensaje = "HABILITO ";
				}				

				$.ajax({
				url: configuracion.urlsPublic().mantenimineto.modModulo.modulo.api,
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
					nucleo.guardarBitacoraPublic(mensaje+" EL MODULO "+nombre_);
					mtdModulo.controlPaginacionPublic(paginaActual);
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
			//console.log("Vaciando catalogo");
			$("#catalogoDatos").html('<img src="Vist/img/cargando2.gif" class="img-cargando">');
		}
		/*
			
		*/
		var restablecerForm = function() {
			//
	        $('#vtnModulo #form')[0].reset();
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

		  	nucleo.cargarListaDespegableListasPublic('moduloPerteneceListD','mtn_modulo','');


			$('#moduloPerteneceListD').popover({
			    html: true, 
				placement: "right",
				content: function() {
			          return $('#procesandoDatosInput').html();
			        }
			});

		  	$('#moduloPerteneceListD').popover('show');

		    setTimeout(function(){ 

				  	$('#moduloPerteneceListD').popover('destroy');
				  	$('#moduloPerteneceListD').selectpicker('refresh');

		    }, 300);

			$('.btn-primary').removeClass('active');
			$('.panel-pertenece').collapse('hide'); 

		}
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			paginaActual = _pagina_;
			mtdModulo.cargarCatalogoPublic(_pagina_);   
		}	
		var activarEnvio = function () {
		
			var idVtn = "#vtnModulo";
			// -> Form Vtn
			$(idVtn+' #form').on('submit', function(e) {
				e.preventDefault();	
				if(nucleo.validadorPublic()==true){						
		        	if(atcEnvioEnter==0){
		        		
		        		//console.log("activa guardar por boton");
		        		guardar();

		        	}else{
		        		atcEnvioEnter=0;
		        	}
		    	}
			});
			//	
			$(idVtn+' input').on('keypress', function(e) {
			    if(e.keyCode==13){
					if(nucleo.validadorPublic()==true){
						//console.log("activa guardar por Enter");
			        	atcEnvioEnter=1;
		        		guardar();
		
					}
			    }
			});
			$(idVtn+' textarea').on('keypress', function(e) {
			    if(e.keyCode==13){
					if(nucleo.validadorPublic()==true){
						//console.log("activa guardar por Enter");
			        	atcEnvioEnter=1;
			        		guardar();
					}
			    }
			});			
			//
		}

	/****************Inicializacion e Intancias de metodos *******************/

		return{
			Iniciar : function() {
				//console.log("Iniciando carga de metodos para Mantenimiento - Modulos");
	

					activarEnvio();


				console.log("Finalizando carga de metodos para Mantenimiento - Modulos");
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado

		}
}();