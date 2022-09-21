var mtdPerfil = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 11; // Tamaño de filas por pagina #paginacion
		var cargaCatalogoAtivo = "";// Para determinar el catalogo activo 
		var atcEnvioEnter = 0;
		var _idPerfil_ = 0;
		//
		var nombrePerfilTextoG = "";

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
			var filtro_ = $("#ctlgPerfil #buscardorTxt").val();
			
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
			var tipoPerfil ="";			
			//
			// control paginacion
			var pagina_ = _pagina_;
			//

	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgPerfil #catalogoDatos").html('');				
			        $("#pgnPerfil #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgPerfil #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgPerfil #catalogoDatos").html('');				
		            $("#pgnPerfil #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estadoPerfil==1) {
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
								if (datoItem.tipo==1) {
									tipoPerfil = "Unidad de informática";
								}else if(datoItem.tipo==2){
									tipoPerfil = "Servicios Generales";
								}

								tr = $('<tr class="row '+ColorEstado+'">');
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-8'>" + datoItem.nombre + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modPersona.tabs.perfil.ventanaModal,0,0),mtdPerfil.consultarPublic("+datoItem.id+")' style='width: 30%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default permisosPerfilBtnDiv' id='btnPermisos' "+disabledEditar+" onclick='mtdPerfil.iniciarVtnPermisosPublic("+datoItem.id+")' style='width: 35%;'>Permisos</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdPerfil.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+")'  style='width: 35%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgPerfil #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdPerfil.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdPerfil.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdPerfil.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdPerfil.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnPerfil #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(11);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgPerfil #catalogoDatos').append(tr);
							//-------------
							if (filtro_!=""){
								$("#ctlgPerfil #btnNuevo").prop('disabled', false);
								$("#ctlgPerfil #btnNuevo").addClass('imputSusess');
							}else{
								$("#ctlgPerfil #btnNuevo").prop('disabled', true);
								$("#ctlgPerfil #btnNuevo").removeClass('imputSusess');
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
			
			console.log("verificando: "+id_departamento_);
			//
	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
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
					$('#vtnPerfil #datoControlId').val(data[0].id);
					nombrePerfilTextoG = data[0].nombre;
					$("#vtnPerfil #nombreTxt").val(nombrePerfilTextoG); 
					//-> SI NO ES UN CAMBIO DE PERMISOS DEL PERFIL
					if ($('.vtnPerfilPermisos').length<1) 
					{
						nucleo.guardarBitacoraPublic("CONSULTO EL PERFIL : "+nombrePerfilTextoG);												
					};
					
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
				var nombre_		= $("#nombreTxt").val(); 
				var id_ 		= $('#vtnPerfil #datoControlId').val();
				//
		        $.ajax({
					url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),							
							id:id_,
							nombre:nombre_,
						},
	                beforeSend: function () {
	                	$('#vtnPerfil #form').css("display", "none");
                        $('#vtnPerfil #procesandoDatosDialg').css("display", "block");
				        $("#ctlgPerfil #catalogoDatos").html('');				
				        $("#ctlgPerfil #pagination").html('');	
						tr = $('<tr>');
						tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
						tr.append("</tr>");
						$('#ctlgPerfil #catalogoDatos').append(tr);
	                },
	                success:  function (result) {
						console.log("listo1");
						console.log(JSON.stringify(result));
						if (result[0].controlError==0) {

							if(id_!=""){
								nucleo.guardarBitacoraPublic("EDITO EL PERFIL "+nombrePerfilTextoG+" A "+nombre_);
							}else{
								nucleo.guardarBitacoraPublic("GUARDO EL PERFIL "+nombre_);								
							}

							nucleo.alertaExitoPublic(result[0].detalles);
							if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==true) {
								// se comproobo que se abrio como administrador en las vistas de los procesos
								nucleo.controlBtnAdminInProcessPublic();
							}else{							
								ventanaModal.ocultarPulico('ventana-modal');
								mtdPerfil.vaciarCatalogoPublic();
								mtdPerfil.cargarCatalogoPublic(paginaActual);
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
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
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
					mtdPerfil.controlPaginacionPublic(paginaActual);
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}	





	/**************************************************************************************/
	/**************************** Gestionar Permisos del perfil  **************************/
	/**************************************************************************************/		

		/* 	La funcionalidad cargarLista de permisos
	 		# Uso : Se usa para extraer todos los datos relacionados a los permisos del usuario
			# Parametros :
			# Notas :
		*/
		var cargarModulosAsignar = function(id_perfil_) {

			// Iniciando variables
			var accion_ = "cargaTotalModulosAsignar";
			
			var AccionarEstado="";
			var ColorEstado="";
			var disabledEditar="";
			var nuevoEstado ="";
			//

	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id_perfil:id_perfil_,
					},
	            beforeSend: function () {

			        $("#vtnPerfil #vtnCtlgModulos").html('');				
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#vtnPerfil #vtnCtlgModulos').append(tr);

	            },
	            success:  function (data) {
		        	//LIMPIAR CATALOGO - LISTA DE NO ASIGNADOS
		            $("#vtnPerfil #vtnCtlgModulos").html('');		
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					    setTimeout(function(){ 

							$(data).each(function (index, dato) {
							//Obteniendo resultados para catalogo
			    				$(dato.resultados).each(function (index, datoItem) {                				   
									

									row =$('<div class="row" style="background: rgba(0, 0, 0, 0.36);color: white;padding: 0.5%;margin-top: 0.2%;">');	
											row.append('<b class="col-md-9 " style=" font-size: small; padding: inherit;">'+datoItem.mNombre+'</b>');
											var contBtn = $('<div style="col-md-3 ">');
											if (datoItem.mId>1) {
														contBtn.append("<button type='button' class='btn btn-default' "+
															"onclick='mtdPerfil.asignarModuloPublic("+datoItem.mId+",&#39;"+datoItem.mNombre+"&#39;)' style=' padding: 2px 0px; color: #000;background-color: #ffffff;border-color: #f5f5f5;font-size: smaller;border: 0px solid #fff;width: 20%;'>"+
															"Asignar"+
														"</button>");
											};
											contBtn.append('</div>');
										row.append(contBtn);
										row.append('</div>');

									$('#vtnPerfil #vtnCtlgModulos').append(row);
								});

							});
			            	$('#vtnPerfil #vtnCtlgModulos').popover('destroy');							
						}, 600);

					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay modulos disponibles </td>');
							tr.append("</tr>");
							$('#vtnPerfil #vtnCtlgModulos').append(tr);
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
		var asignarModulo = function (_idModulo_,_nombreModulo_) {
			var accion_ = "asignarModulo";
			//
			var idModulo_ = _idModulo_;
			//
			var idPerfil_ = $('#vtnPerfil #datoControlId').val();
			//
	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						idPerfil:idPerfil_,
						idModulo:idModulo_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (result) {
	            	console.log(JSON.stringify(result));

					if (result[0].controlError==0) {

						nucleo.guardarBitacoraPublic(" ASIGNO EL MODULO "+_nombreModulo_+" AL PERFIL: "+nombrePerfilTextoG);

						nucleo.alertaExitoPublic(result[0].detalles);	 
						mtdPerfil.cargarModulosAsignarPublic(idPerfil_);					           	
						mtdPerfil.cargarModulosAsignadosPublic(idPerfil_);
						return true;	                    
					}else{
						nucleo.alertaErrorPublic(result[0].detalles);
						return false;
					};	


	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;			
		}
		/* 	La funcionalidad cargarLista de permisos
	 		# Uso : Se usa para extraer todos los datos relacionados a los permisos del usuario
			# Parametros :
			# Notas :
		*/
		var cargarModulosAsignados = function(_idPerfil_) {

			// Iniciando variables
			var accion_ = "cargaTotalModulosAsignados";
			
	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id_perfil:_idPerfil_, 
					},
	            beforeSend: function () {

			        $("#vtnPerfil #vtnCtlgModulosPermitidos").html('');				
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#vtnPerfil #vtnCtlgModulosPermitidos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {		    
	            	//LIMPIAR CATALOGO LISTA DE ASIGNADOS
		            $("#vtnPerfil #vtnCtlgModulosPermitidos").html('');		
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
 					    setTimeout(function(){ 
							$(data).each(function (index, dato) {
							//Obteniendo resultados para catalogo
			    				$(dato.resultados).each(function (index, datoItem) {                				   
									
									if (datoItem.pmPermiso_acceso==1) {
										menjBoton	= "Deshabilitar";
										accesoBoton = '  ';										
										ColorEstado="";
										nuevoEstado=0;
									}else{
										menjBoton	= "Habilitar";
										accesoBoton = ' disabled="TRUE" ';
										ColorEstado='lista-danger';
										nuevoEstado=1;
									}	
									row =$('<div class="row lista '+ColorEstado+' " id="itemColapsoAsignado'+index+'" >');	
											row.append('<b class="col-md-8 "  style=" font-size: small; padding: inherit;">'+datoItem.mNombre+'</b>');
											if (datoItem.pmId_modulo>1) {
												contBtnAtc = $("<button type='button' class='btn btn-default col-md-2'   "+accesoBoton+
														//" onclick='mtdPerfil.iniciarVtnAccionesPermitidasPublic("+datoItem.pmId_perfil+","+datoItem.pmId_modulo+","+datoItem.mId+")' "+
														" onclick='nucleo.listaColapsePublic(&#39;itemColapsoAsignado"+index+"&#39;,event);'"+
														" style=' padding: 2px 0px; color: #000;background-color: #ffffff;border-color: #f5f5f5;font-size: smaller;border: 0px solid #fff; border-radius: 5px 0px  0px 5px;'>"+

														" Acciones "+
													"</button>"); 
												var id_permisos_perfil_modulo_ = datoItem.pmId;
												contBtn = $("<button type='button' class='btn btn-default col-md-2' "+
														"onclick='mtdPerfil.cambiarPermisoModuloPublic("+datoItem.pmId_perfil+","+id_permisos_perfil_modulo_+","+nuevoEstado+",&#39;"+datoItem.mNombre+"&#39;)' style=' padding: 2px 0px; color: #000;background-color: #ffffff;border-color: #f5f5f5;font-size: smaller;border: 0px solid #fff;border-radius: 0px 5px  5px 0px;border-left: 1px solid #f5f5f5;'>"+
														menjBoton+
													"</button>");
/************************************************************************************************************************/
				var lbCboxNuevo  ="";
				var lbCboxEditar ="";
				var lbCboxEliminacionLog = "";
				var lbCboxGenerarReporte ="";
				var lbCboxGenerarReporteFiltrado = "";
				var lbCboxPermisosPerfil = "";
				var lbCboxBusquedaAvanzada = "";
				var lbCboxDetalles = "";
				var lbCboxAtender = "";
				var lbCboxAsignar = "";
				var lbCboxDiagnosticar = "";
				var lbCboxProgramarTarea = "";
				var lbCboxIniciarFinalizarTarea = "";
				var lbCboxRespuestaSolicitud = "";
				var lbCboxFinalizarSolicitud = "";
				var lbCboxGestionEquipo = "";
				var lbCboxDesincoporarEquipo = "";
				var lbCboxDesincoporarPeriferico = "";
				var lbCboxDesincoporarComponente = "";
				var lbCboxCambiarPeriferico = "";
				var lbCboxCambiarComponente = "";
				var lbCboxCambiarSoftware = "";
				var lbCboxInconformidadAtendida =""

				$.ajax({
					async :false,	
					url: configuracion.urlsPublic().mantenimineto.modModulo.modulo.api,
					type:'POST',	
					data:{
							accion:"consultar",
							id:datoItem.pmId_modulo,
						},
      				 beforeSend: function () {
								//$('#vtnAccionesPermitidas #form').css("display", "none");
								//$('#vtnAccionesPermitidas #procesandoDatosDialg').css("display", "block");
								//$('#btnGuardarAcciones').css('display', 'none');
				       },
				       success:  function (data) {
							//console.log(JSON.stringify(data));

/************************************************************************************************************************/


							var accion_ = "consultarPermisosAccionesModulo";
							//
							$.ajax({
								async :false,	
								url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
								type:'POST',	
								data:{
										accion:accion_,
										id:id_permisos_perfil_modulo_,
									},
								beforeSend: function () {
									console.log("Procesando información de acciones...");
								},
								success:  function (dataPermisosP) {
									//console.log(JSON.stringify(dataPermisosP));


									//checked

									if(data[0].func_nuevo==1){
										var NvalidoCheck = (dataPermisosP[0].func_nuevo==1)?'checked':' ';
										lbCboxNuevo = '<div class="checkbox" id="nuevoCboxDiv">'+
												    '<label id="1lbl">'+
												      '<input type="checkbox" id="nuevoCbox" '+NvalidoCheck+'> Nuevo'+
												    '</label>'+
										  		'</div>';
									}

									if(data[0].func_editar==1){
										var EvalidoCheck = (dataPermisosP[0].func_editar==1)?'checked':'';										
										lbCboxEditar = '<div class="checkbox"  id="editarCboxDiv">'+
														    '<label id="2lbl">'+
														      '<input type="checkbox" id="editarCbox" '+EvalidoCheck+'> Editar'+
														    '</label>'+
												  		'</div>';
									}

									if(data[0].func_eliminacion_logica==1){
										var ElvalidoCheck = (dataPermisosP[0].func_eliminacion_logica==1)?'checked':'';										
										lbCboxEliminacionLog = '<div class="checkbox" id="eliminacionLogCboxDiv">'+
																		    '<label id="3lbl">'+
																		      '<input type="checkbox" id="eliminacionLogCbox" '+ElvalidoCheck+'> ( Habilitar / Deshabilitar )'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_generar_reporte==1){
										var GRvalidoCheck = (dataPermisosP[0].func_generar_reporte==1)?'checked':'';										
										lbCboxGenerarReporte = '<div class="checkbox" id="generarRptCboxDiv">'+
																		    '<label id="4lbl">'+
																		      '<input type="checkbox" id="generarRptCbox" '+GRvalidoCheck+'> Generar reporte'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_generar_reporte_filtrado==1){
										var GEFValidoCheck = (dataPermisosP[0].func_generar_reporte_filtrado==1)?'checked':'';										
										lbCboxGenerarReporteFiltrado = '<div class="checkbox" id="generarRptFltCboxDiv">'+
																		    '<label id="5lbl">'+
																		      '<input type="checkbox" id="generarRptFltCbox" '+GEFValidoCheck+'> Generar reporte filtrado'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_permisos_perfil==1){
										var PPValidoCheck = (dataPermisosP[0].func_permisos_perfil==1)?'checked':'';										
										lbCboxPermisosPerfil = '<div class="checkbox" id="permisosPerfilCboxDiv">'+
																		    '<label id="6lbl">'+
																		      '<input type="checkbox" id="permisosPerfilCbox" '+PPValidoCheck+'> Permisos de perfil'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_busqueda_avanzada==1){
										var BAValidoCheck = (dataPermisosP[0].func_busqueda_avanzada==1)?'checked':'';																				
										lbCboxBusquedaAvanzada = '<div class="checkbox" id="busquedaAvanzadaCboxDiv">'+
																		    '<label id="7lbl">'+
																		      '<input type="checkbox" id="busquedaAvanzadaCbox" '+BAValidoCheck+'> Busqueda avanzada'+
																		    '</label>'+
																		'</div>';
									}

									if(data[0].func_detalles==1){
										var DValidoCheck = (dataPermisosP[0].func_detalles==1)?'checked':'';																														
										lbCboxDetalles = '<div class="checkbox"  id="detallesCboxDiv">'+
																		    '<label id="8lbl">'+
																		      '<input type="checkbox" id="detallesCbox" '+DValidoCheck+'> Detalles'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_atender==1){
										var ATValidoCheck = (dataPermisosP[0].func_atender==1)?'checked':'';																																								
										lbCboxAtender = '<div class="checkbox" id="atenderCboxDiv">'+
																		    '<label id="9lbl">'+
																		      '<input type="checkbox" id="atenderCbox" '+ATValidoCheck+'> Atender'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_asignar==1){
										var ASValidoCheck = (dataPermisosP[0].func_asignar==1)?'checked':'';																																																		
										lbCboxAsignar = '<div class="checkbox"  id="asignarCboxDiv">'+
																		    '<label id="10lbl">'+
																		      '<input type="checkbox" id="asignarCbox" '+ASValidoCheck+'> Asignar'+
																		    '</label>'+
																  		'</div>';

									}

									if(data[0].func_diagnosticar==1){
										var DValidoCheck = (dataPermisosP[0].func_diagnosticar==1)?'checked':'';
										lbCboxDiagnosticar = '<div class="checkbox"  id="diagnosticarCboxDiv">'+
																		    '<label id="11lbl">'+
																		      '<input type="checkbox" id="diagnosticarCbox" '+DValidoCheck+'> Diagnosticar'+
																		    '</label>'+
																  		'</div>';

									}

									if(data[0].func_programar_tarea==1){
										var FTValidoCheck = (dataPermisosP[0].func_programar_tarea==1)?'checked':'';										
										lbCboxProgramarTarea = '<div class="checkbox" id="programarTareaCboxDiv">'+
																		    '<label id="12lbl">'+
																		      '<input type="checkbox" id="programarTareaCbox" '+FTValidoCheck+'> Programar tarea'+
																		    '</label>'+
																  		'</div>';

									}

									if(data[0].func_iniciar_finalizar_tarea==1){
										var IFTValidoCheck = (dataPermisosP[0].func_iniciar_finalizar_tarea==1)?'checked':'';																				
										lbCboxIniciarFinalizarTarea = '<div class="checkbox" id="iniciarFinalizarTareaCboxDiv">'+
																		    '<label id="13lbl">'+
																		      '<input type="checkbox" id="iniciarFinalizarTareaCbox" '+IFTValidoCheck+'> Iniciar/Finalizar Tarea '+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_respuesta_solicitud==1){
										var RSValidoCheck = (dataPermisosP[0].func_respuesta_solicitud==1)?'checked':'';																														
										lbCboxRespuestaSolicitud = '<div class="checkbox"  id="respuestaSoltCboxDiv">'+
																		    '<label id="14lbl">'+
																		      '<input type="checkbox" id="respuestaSoltCbox" '+RSValidoCheck+'> Respuesta de solicitud'+
																		    '</label>'+
																  		'</div>';

									}

									if(data[0].func_finalizar_solicitud==1){
										var FSValidoCheck = (dataPermisosP[0].func_finalizar_solicitud==1)?'checked':'';																																								
										lbCboxFinalizarSolicitud = '<div class="checkbox" id="finalizarSoltCboxDiv">'+
																		    '<label id="15lbl">'+
																		      '<input type="checkbox" id="finalizarSoltCbox" '+FSValidoCheck+'>Finalizar solicitud'+ 
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_gestion_equipo_mantenimiento==1){
										var GEMValidoCheck = (dataPermisosP[0].func_gestion_equipo_mantenimiento==1)?'checked':'';																																																		
										lbCboxGestionEquipo = '<div class="checkbox" id="gestionEquipoCboxDiv">'+
																		    '<label id="16lbl">'+
																		      '<input type="checkbox" id="gestionEquipoCbox" '+GEMValidoCheck+'> Gestion de equipo'+
																		    '</label>'+
															   			'</div>';
									}

									if(data[0].func_desincorporar_equipo==1){
										var DEValidoCheck = (dataPermisosP[0].func_desincorporar_equipo==1)?'checked':'';																																																												
										lbCboxDesincoporarEquipo = '<div class="checkbox" id="desincorporarEquipoCboxDiv"> '+
																		    '<label>'+
																		      '<input type="checkbox" id="desincorporarEquipoCbox" '+DEValidoCheck+'> Desincorporar equipo  '+
																		    '</label>'+
																		'</div>';
									}

									if(data[0].func_desincorporar_periferico==1){
										var DPValidoCheck = (dataPermisosP[0].func_desincorporar_periferico==1)?'checked':'';										
										lbCboxDesincoporarPeriferico = '<div class="checkbox" id="desincorporarPerifericoCboxDiv">'+
																		    '<label>'+
																		      '<input type="checkbox" id="desincorporarPerifericoCbox" '+DPValidoCheck+'> Desincorporar periferico '+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_desincorporar_componente==1){
										var DCValidoCheck = (dataPermisosP[0].func_desincorporar_componente==1)?'checked':'';																				
										lbCboxDesincoporarComponente = '<div class="checkbox" id="desincorporarComponenteCboxDiv">'+
																		    '<label>'+
																		      '<input type="checkbox" id="desincorporarComponenteCbox" '+DCValidoCheck+'>Desincorporar componente '+ 
																		    '</label>'+
																		'</div>';
									}

									if(data[0].func_cambiar_periferico==1){
										var CPValidoCheck = (dataPermisosP[0].func_cambiar_periferico==1)?'checked':'';										
										lbCboxCambiarPeriferico = '<div class="checkbox" id="cambiarPerifericoCboxDiv">'+
																		    '<label>'+
																		    	'<input type="checkbox" id="cambiarPerifericoCbox" '+CPValidoCheck+'> Cambiar periferico'+
																		    '</label>'+
																	  	'</div>';

									}

									if(data[0].func_cambiar_componente==1){
										var CCValidoCheck = (dataPermisosP[0].func_cambiar_componente==1)?'checked':'';										
										lbCboxCambiarComponente = '<div class="checkbox" id="cambiarComponenteCboxDiv">'+
																		    '<label>'+
																		      	'<input type="checkbox" id="cambiarComponenteCbox" '+CCValidoCheck+'> Cambiar componente '+
																	    	'</label>'+
																  		'</div>';
									}

									if(data[0].func_cambiar_software==1){
										var CSValidoCheck = (dataPermisosP[0].func_cambiar_software==1)?'checked':'';																				
										lbCboxCambiarSoftware = '<div class="checkbox"  id="cambiarSoftwareCboxDiv">'+
																		    '<label>'+
																		      '<input type="checkbox" id="cambiarSoftwareCbox" '+CSValidoCheck+'> Cambiar software'+
																		    '</label>'+
																  		'</div>';
									}

									if(data[0].func_inconformidad_atendida==1){
										var IAValidoCheck = (dataPermisosP[0].func_inconformidad_atendida==1)?'checked':'';																														
										lbCboxInconformidadAtendida = '<div class="checkbox" id="inconformidadAtendidaCboxDiv">'+
																		    '<label>'+
																		    	'<input type="checkbox" id="inconformidadAtendidaCbox" '+IAValidoCheck+'>Inconformidad atendida '+ 
																		    '</label>'+
																	   '</div>';
									}



								},
								//error:  function(jq,status,message) {
								error:  function(error) {
									console.log(JSON.stringify(error));	
									alertas.dialogoErrorPublic(error.readyState,error.responseText);						
									//alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
								}	 
							});				

/************************************************************************************************************************/

						

							//mtdPerfil.consultarPermisosAccionesModuloPublic(_idPermiso_);
					},
			    	error:  function(error) {
						console.log(JSON.stringify(error));	
						alertas.dialogoErrorPublic(error.readyState,error.responseText);						
				        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
				    }	 
				});
/**********************************************************************************************************************/








												panelClpseAcciones = 
												$('<div class="itemClose" id="itemClpseLista" >'+
													/*
														lista de permisos
													*/
													'<div style="border:1px solid #ccc; border-radius:5px;">'+
												

														'<div style="border-bottom: 1px solid #ccc;">'+
															'<div class="row">'+
																'<div class="col-md-3 col-md-offset-8 " >'+

																	"<button type='button' class='btn btn-default col-md-2' "+
																		//" onclick='mtdPerfil.iniciarVtnAccionesPermitidasPublic("+datoItem.pmId_perfil+","+datoItem.pmId_modulo+","+datoItem.mId+")' "+
																		" onclick='mtdPerfil.guardarPermisosAccionesModuloPublic(&#39;itemColapsoAsignado"+index+"&#39;,"+datoItem.pmId_perfil+","+datoItem.pmId+");'"+
																		" style='width: 100%;padding: 2px 0px;color: #000;background-color: #ffffff;font-size: smaller;border: 1px solid #ccc;'>"+
																		" Guardar "+
																	"</button>"+

																'</div>'+  
															'</div>'+
														'</div>'+


														'<div class="row">'+
															'<div class="col-md-3 col-md-offset-1 " >'+
																lbCboxNuevo+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 ">'+
														  		lbCboxEditar+
															'</div>'+
															'<div class="col-md-5 col-md-offset-0 " >'+
														  		lbCboxEliminacionLog+
															'</div>'+
														'</div>'+  	

														'<div class="row">'+
															
															'<div class="col-md-3 col-md-offset-1 " >'+
														  		lbCboxGenerarReporte+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 " >'+
														  		lbCboxGenerarReporteFiltrado+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 " >'+
															  	lbCboxPermisosPerfil+
															'</div>'+
														'</div>'+  	

														'<div class="row">'+
															
															'<div class="col-md-3 col-md-offset-1 " >'+
														  		lbCboxBusquedaAvanzada+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 ">'+
														  		lbCboxDetalles+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 " >'+
														  		lbCboxAtender+
															'</div>'+
														'</div>'+  	

														'<div class="row">'+
															'<div class="col-md-3 col-md-offset-1 ">'+
														  		lbCboxAsignar+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 ">'+
														  		lbCboxDiagnosticar+
															'</div>'+
															'<div class="col-md-4 col-md-offset-0 " >'+
														  		lbCboxProgramarTarea+
															'</div>'+														
														'</div>'+ 

														'<div class="row">'+
															'<div class="col-md-3 col-md-offset-1 " >'+
														  		lbCboxIniciarFinalizarTarea+
															'</div>'+																			
															'<div class="col-md-3 col-md-offset-0 ">'+
														  		lbCboxRespuestaSolicitud+
															'</div>'+
															'<div class="col-md-3 col-md-offset-0 " >'+
														  		lbCboxFinalizarSolicitud+
															'</div>'+									
														'</div>'+

														'<div class="row">'+
															'<div class="col-md-5 col-md-offset-1 " >'+
														  		lbCboxGestionEquipo+
															'</div>'+  
														'</div>'+

														'<div class="row">'+
															'<div class="col-md-3 col-md-offset-1 ">'+
																lbCboxDesincoporarEquipo+
															'</div>'+																			
															'<div class="col-md-3 col-md-offset-1 ">'+
														  		lbCboxDesincoporarPeriferico+
															'</div>'+
															'<div class="col-md-3 col-md-offset-1 ">'+
																lbCboxDesincoporarComponente+
															'</div>'+									
														'</div>'+  

														'<div class="row">'+
															'<div class="col-md-3 col-md-offset-1 ">'+
														  		lbCboxCambiarPeriferico+
															'</div>'+																			
															'<div class="col-md-3 col-md-offset-1 ">'+
															  	lbCboxCambiarComponente+
															'</div>'+
															'<div class="col-md-3 col-md-offset-1 ">'+
														  		lbCboxCambiarSoftware+
															'</div>'+									
														'</div>'+  

														'<div class="row">'+														
															'<div class="col-md-5 col-md-offset-1 ">'+
															  lbCboxInconformidadAtendida+
															'</div>'+  
														'</div>'+


													'</div>'+
													/*
														Fin de lista de permisos
													*/
												'</div>');
								


												row.append(contBtnAtc);
												row.append(contBtn);
												row.append(panelClpseAcciones);
											};
										row.append('</div>');



									$('#vtnPerfil #vtnCtlgModulosPermitidos').append(row);
								});

							});	
			            	$('#vtnPerfil #vtnCtlgModulosPermitidos').popover('destroy');
						}, 400);
					}else{
							div = $('<div style="text-align: center;background: rgb(51, 85, 115);width: 100%;font-size: small;font-weight: bold;color: white;">');
							div.append('<b colspan="5" style="text-align: center;width: 100%;"> No hay modulos asignados </b>');
							div.append("</div>");
							$('#vtnPerfil #vtnCtlgModulosPermitidos').append(div);
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
		var cambiarPermisoModulo = function (_idPerfil_,_idPermiso_,_estado_,_nombreModulo_) {
			var accion_ = "cambiarPermisoModulo";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),						
						idPermiso:_idPermiso_,
						estado:_estado_,
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (result) {
	            	console.log(JSON.stringify(result));

					if (result[0].controlError==0) {
						nucleo.alertaExitoPublic(result[0].detalles);	 
						//mtdPerfil.cargarModulosAsignarPublic();					           	
						mtdPerfil.cargarModulosAsignadosPublic(_idPerfil_);			
						if(_estado_==0){
							mensaje = "DESHABILITO ";
						}
						if(_estado_==1){
							mensaje = "HABILITO ";
						}										
						nucleo.guardarBitacoraPublic(mensaje+" EL PERMISO DE ACCESO DEL PERFIL: "+nombrePerfilTextoG+" - AL MODULO : "+_nombreModulo_);

						return true;	                    
					}else{
						nucleo.alertaErrorPublic(result[0].detalles);
						return false;
					};	


	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;					
		}
	/**************************************************************************************/
	/******************************* Fin Permisos del perfil ******************************/
	/**************************************************************************************/		



	/****************************Metodos de control**************************/		

		/**************************************************************************/
		/**************************************************************************/
		/**************************************************************************/				
		/*
			*
			*
			*
		*/
		var iniciarVtnPermisos = function(_idPerfil_) {
			ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modPersona.tabs.perfil.permisos.ventanaModal,1,0);
			mtdPerfil.consultarPublic(_idPerfil_);
			mtdPerfil.cargarModulosAsignarPublic(_idPerfil_);
			mtdPerfil.cargarModulosAsignadosPublic(_idPerfil_);
			nucleo.guardarBitacoraPublic(" CONSULTO LOS PERMISOS DEL PERFIL : "+nombrePerfilTextoG);
		}
		/*
			*
			*
			*
		*/
		var iniciarVtnAccionesPermitidas = function(_idPerfil_,_idModulo_,_idPermiso_) {
			ventanaModal.cambiaMuestraVentanaModalCaa2Public('configuracion/gestionPersona/gestionPerfiles/ventanasModales/vtnMGestionAccionesPermitidas.php',1,0);
			
			var nombre = $("#vtnPerfil #nombreTxt").val(); 

			$('#vtnAccionesPermitidas #nombrePerfilTexto').text(nombre);

				$.ajax({
					async :true,	
					url: configuracion.urlsPublic().mantenimineto.modModulo.modulo.api,
					type:'POST',	
					data:{
							accion:"consultar",
							id:_idModulo_,
						},
      				 beforeSend: function () {
								$('#vtnAccionesPermitidas #form').css("display", "none");
								$('#vtnAccionesPermitidas #procesandoDatosDialg').css("display", "block");
								$('#btnGuardarAcciones').css('display', 'none');
				       },
				       success:  function (data) {
								console.log(JSON.stringify(data));

							$('#vtnAccionesPermitidas #datoControlId').val(_idPermiso_);
							$('#vtnAccionesPermitidas #nombreModuloTexto').text(data[0].nombre);

							if(data[0].func_nuevo==1){
								$("#nuevoCboxDiv").css('display','block');
							}else{
								$("#nuevoCboxDiv").css('display','none');
							}

							if(data[0].func_editar==1){
								$("#editarCboxDiv").css('display','block');
							}else{
								$("#editarCboxDiv").css('display','none');
							}

							if(data[0].func_eliminacion_logica==1){
								$("#eliminacionLogCboxDiv").css('display','block');
							}else{
								$("#eliminacionLogCboxDiv").css('display','none');
							}

							if(data[0].func_generar_reporte==1){
								$("#generarRptCboxDiv").css('display','block');
							}else{
								$("#generarRptCboxDiv").css('display','none');
							}

							if(data[0].func_generar_reporte_filtrado==1){
								$("#generarRptFltCboxDiv").css('display','block');
							}else{
								$("#generarRptFltCboxDiv").css('display','none');
							}


							if(data[0].func_permisos_perfil==1){
								$("#permisosPerfilCboxDiv").css('display','block');
							}else{
								$("#permisosPerfilCboxDiv").css('display','none');
							}

							if(data[0].func_busqueda_avanzada==1){
								$("#busquedaAvanzadaCboxDiv").css('display','block');
							}else{
								$("#busquedaAvanzadaCboxDiv").css('display','none');
							}

							if(data[0].func_detalles==1){
								$("#detallesCboxDiv").css('display','block');
							}else{
								$("#detallesCboxDiv").css('display','none');
							}

							if(data[0].func_atender==1){
								$("#atenderCboxDiv").css('display','block');
							}else{
								$("#atenderCboxDiv").css('display','none');
							}

							if(data[0].func_asignar==1){
								$("#asignarCboxDiv").css('display','block');
							}else{
								$("#asignarCboxDiv").css('display','none');
							}

							if(data[0].func_programar_tarea==1){
								$("#programarTareaCboxDiv").css('display','block');
							}else{
								$("#programarTareaCboxDiv").css('display','none');
							}

							if(data[0].func_iniciar_finalizar_tarea==1){
								$("#iniciarFinalizarTareaCboxDiv").css('display','block');
							}else{
								$("#iniciarFinalizarTareaCboxDiv").css('display','none');
							}

							if(data[0].func_diagnosticar==1){
								$("#diagnosticarCboxDiv").css('display','block');
							}else{
								$("#diagnosticarCboxDiv").css('display','none');
							}

							if(data[0].func_respuesta_solicitud==1){
								$("#respuestaSoltCboxDiv").css('display','block');
							}else{
								$("#respuestaSoltCboxDiv").css('display','none');
							}

							if(data[0].func_finalizar_solicitud==1){
								$("#finalizarSoltCboxDiv").css('display','block');
							}else{
								$("#finalizarSoltCboxDiv").css('display','none');
							}

							if(data[0].func_gestion_equipo_mantenimiento==1){
								$("#gestionEquipoCboxDiv").css('display','block');
							}else{
								$("#gestionEquipoCboxDiv").css('display','none');
							}
							/*************************************************************/

							if(data[0].func_desincorporar_equipo==1){
								$("#desincorporarEquipoCboxDiv").css('display','block');
							}else{
								$("#desincorporarEquipoCboxDiv").css('display','none');
							}

							if(data[0].func_desincorporar_periferico==1){
								$("#desincorporarPerifericoCboxDiv").css('display','block');
							}else{
								$("#desincorporarPerifericoCboxDiv").css('display','none');
							}

							if(data[0].func_desincorporar_componente==1){
								$("#desincorporarComponenteCboxDiv").css('display','block');
							}else{
								$("#desincorporarComponenteCboxDiv").css('display','none');
							}

							if(data[0].func_cambiar_periferico==1){
								$("#cambiarPerifericoCboxDiv").css('display','block');
							}else{
								$("#cambiarPerifericoCboxDiv").css('display','none');
							}

							if(data[0].func_cambiar_componente==1){
								$("#cambiarComponenteCboxDiv").css('display','block');
							}else{
								$("#cambiarComponenteCboxDiv").css('display','none');
							}

							if(data[0].func_cambiar_software==1){
								$("#cambiarSoftwareCboxDiv").css('display','block');
							}else{
								$("#cambiarSoftwareCboxDiv").css('display','none');
							}

							if(data[0].func_inconformidad_atendida==1){
								$("#inconformidadAtendidaCboxDiv").css('display','block');
							}else{
								$("#inconformidadAtendidaCboxDiv").css('display','none');
							}

							mtdPerfil.consultarPermisosAccionesModuloPublic(_idPermiso_);
					},
			    	error:  function(error) {
						console.log(JSON.stringify(error));	
						alertas.dialogoErrorPublic(error.readyState,error.responseText);						
				        //alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
				    }	 
				});
		}		
		/* La funcionalidad consultar: 
			# Uso :  Se usa para extraer todos los datos relacionados
			# Parametros:
							* id_usuario_ Para realizar consulta
							* cedula_ para realizar consulta
			# Notas: 
							* Optimizar con 1 parametro y 1 consulta
		*/	
		var consultarPermisosAccionesModulo = function(id_permisos_) {

							var accion_ = "consultarPermisosAccionesModulo";
							//
							$.ajax({
							url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
							type:'POST',	
							data:{
									accion:accion_,
									id:id_permisos_,
								},
									beforeSend: function () {
										console.log("Procesando información de acciones...");
									},
									success:  function (data) {
										console.log(JSON.stringify(data));

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


								nucleo.guardarBitacoraPublic("INGRESO A GESTIONAR LOS PERMISOS DE LAS ACCIONES EN EL MODULO : "+data[0].modulo+" - DEL PERFIL : "+nombrePerfilTextoG);
							},
								//error:  function(jq,status,message) {
								error:  function(error) {
									console.log(JSON.stringify(error));	
									alertas.dialogoErrorPublic(error.readyState,error.responseText);						
									//alert('A jQuery error has occurred. Status: ' + status + ' - Message: ' + message);
							}	 
						});
								/***********************************************/
								$('#vtnAccionesPermitidas #procesandoDatosDialg').css("display", "none");
								$('#vtnAccionesPermitidas #form').css("display", "block");
								$('#btnGuardarAcciones').css('display', 'block');
								/***********************************************/
						return false;
		}




		/* La funcionalidad guardarPermisosAccionesModulo: 
			# Uso : Se usa para guardar y editar
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var guardarPermisosAccionesModulo = function(id_contenListClpseModulo, id_perfil_, id_permisos_perfil_) {
				//console.log("guardando...");
				if($('#ventana-modal').hasClass('ventana-modal-panel-accionCerrar')){
			        return false;
			    }
				/* Obtener valores de los campos del formulario*/
				
				var accion_ = "cambiarPermisosAccionesModulo";
				//
				var func_nuevo_ = $("#"+id_contenListClpseModulo+" #nuevoCbox").is(':checked');
				func_nuevo_ = (func_nuevo_==true)? 1 : 0 ;

				var func_editar_ = $("#"+id_contenListClpseModulo+ " #editarCbox").is(':checked');
				func_editar_ = (func_editar_==true)? 1 : 0 ;

				var func_eliminacion_logica_ = $("#"+id_contenListClpseModulo+" #eliminacionLogCbox").is(':checked');
				func_eliminacion_logica_ = (func_eliminacion_logica_==true)? 1 : 0 ;

				var func_generar_reporte_ = $("#"+id_contenListClpseModulo+" #generarRptCbox").is(':checked');
				func_generar_reporte_ = (func_generar_reporte_==true)? 1 : 0 ;

				var func_generar_reporte_filtrado_ = $("#"+id_contenListClpseModulo+" #generarRptFltCbox").is(':checked');
				func_generar_reporte_filtrado_ = (func_generar_reporte_filtrado_==true)? 1 : 0 ;

				var func_permisos_perfil_ = $("#"+id_contenListClpseModulo+" #permisosPerfilCbox").is(':checked');
				func_permisos_perfil_ = (func_permisos_perfil_==true)? 1 : 0 ;

				var func_busqueda_avanzada_ = $("#"+id_contenListClpseModulo+" #busquedaAvanzadaCbox").is(':checked');
				func_busqueda_avanzada_ = (func_busqueda_avanzada_==true)? 1 : 0 ;

				var func_detalles_ = $("#"+id_contenListClpseModulo+" #detallesCbox").is(':checked');
				func_detalles_ = (func_detalles_==true)? 1 : 0 ;

				var func_atender_ = $("#"+id_contenListClpseModulo+" #atenderCbox").is(':checked');
				func_atender_ = (func_atender_==true)? 1 : 0 ;

				var func_asignar_ = $("#"+id_contenListClpseModulo+" #asignarCbox").is(':checked');
				func_asignar_ = (func_asignar_==true)? 1 : 0 ;

				var func_programar_tarea_ = $("#"+id_contenListClpseModulo+" #programarTareaCbox").is(':checked');
				func_programar_tarea_ = (func_programar_tarea_==true)? 1 : 0 ;

				var func_iniciar_finalizar_tarea_ = $("#"+id_contenListClpseModulo+" #iniciarFinalizarTareaCbox").is(':checked');
				func_iniciar_finalizar_tarea_ = (func_iniciar_finalizar_tarea_==true)? 1 : 0 ;

				var func_diagnosticar_ = $("#"+id_contenListClpseModulo+" #diagnosticarCbox").is(':checked');
				func_diagnosticar_ = (func_diagnosticar_==true)? 1 : 0 ;

				var func_respuesta_solicitud_ = $("#"+id_contenListClpseModulo+" #respuestaSoltCbox").is(':checked');
				func_respuesta_solicitud_ = (func_respuesta_solicitud_==true)? 1 : 0 ;

				var func_finalizar_solicitud_ = $("#"+id_contenListClpseModulo+" #finalizarSoltCbox").is(':checked');
				func_finalizar_solicitud_ = (func_finalizar_solicitud_==true)? 1 : 0 ;

				var func_gestion_equipo_mantenimiento_ = $("#"+id_contenListClpseModulo+" #gestionEquipoCbox").is(':checked');
				func_gestion_equipo_mantenimiento_ = (func_gestion_equipo_mantenimiento_==true)? 1 : 0 ;
				/********************************************************************************************************/

				var func_desincorporar_equipo_ = $("#"+id_contenListClpseModulo+" #desincorporarEquipoCbox").is(':checked');
				func_desincorporar_equipo_ = (func_desincorporar_equipo_==true)? 1 : 0 ;

				var func_desincorporar_periferico_ = $("#"+id_contenListClpseModulo+" #desincorporarPerifericoCbox").is(':checked');
				func_desincorporar_periferico_ = (func_desincorporar_periferico_==true)? 1 : 0 ;

				var func_desincorporar_componente_ = $("#"+id_contenListClpseModulo+" #desincorporarComponenteCbox").is(':checked');
				func_desincorporar_componente_ = (func_desincorporar_componente_==true)? 1 : 0 ;

				var func_cambiar_periferico_ = $("#"+id_contenListClpseModulo+" #cambiarPerifericoCbox").is(':checked');
				func_cambiar_periferico_ = (func_cambiar_periferico_==true)? 1 : 0 ;

				var func_cambiar_componente_ = $("#"+id_contenListClpseModulo+" #cambiarComponenteCbox").is(':checked');
				func_cambiar_componente_ = (func_cambiar_componente_==true)? 1 : 0 ;

				var func_cambiar_software_ = $("#"+id_contenListClpseModulo+" #cambiarSoftwareCbox").is(':checked');
				func_cambiar_software_ = (func_cambiar_software_==true)? 1 : 0 ;

				var func_inconformidad_atendida_ = $("#"+id_contenListClpseModulo+" #inconformidadAtendidaCbox").is(':checked');
				func_inconformidad_atendida_ = (func_inconformidad_atendida_==true)? 1 : 0 ;

				/********************************************************************************************************/

				//
			    $.ajax({
					url: configuracion.urlsPublic().modPersona.tabs.perfil.api,
					type:'POST',	
					data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),	
							id:id_permisos_perfil_,
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
							//$('#vtnAccionesPermitidas #form').css("display", "none");
							//$('#vtnAccionesPermitidas #procesandoDatosDialg').css("display", "block");
							//$('#btnGuardarAcciones').css('display', 'none');
						},
	  				   success:  function (result) {
						//console.log(JSON.stringify(result));
						if (result[0].controlError==0) {
							nucleo.alertaExitoPublic(result[0].detalles);
							//ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2');
							mtdPerfil.iniciarVtnPermisosPublic(id_perfil_);
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
		/**************************************************************************/
		/**************************************************************************/
		/**************************************************************************/
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
	        $('#vtnPerfil #form')[0].reset();
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
			mtdPerfil.cargarCatalogoPublic(_pagina_);   
		}	
		var activarEscuchador = function () {
		
			var idVtn = "#vtnPerfil";
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
				console.log("Iniciando carga de metodos de perfil del usuario");
	
					mtdPerfil.cargarCatalogoPublic(1);
					activarEscuchador();

				console.log("Finalizando carga de metodos de perfil del usuario ");
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado,
			cargarModulosAsignarPublic : cargarModulosAsignar,
			cargarModulosAsignadosPublic : cargarModulosAsignados,
			iniciarVtnPermisosPublic : iniciarVtnPermisos,
			iniciarVtnAccionesPermitidasPublic : iniciarVtnAccionesPermitidas,
			asignarModuloPublic : asignarModulo,
			cambiarPermisoModuloPublic : cambiarPermisoModulo,
			guardarPermisosAccionesModuloPublic : guardarPermisosAccionesModulo, 
			consultarPermisosAccionesModuloPublic : consultarPermisosAccionesModulo,
		}
}();