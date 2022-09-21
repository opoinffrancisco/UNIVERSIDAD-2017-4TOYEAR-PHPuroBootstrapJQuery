var mtdPersona = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 10; // Tamaño de filas por pagina #paginacion
		var cargaCatalogoAtivo = "";// Para determinar el catalogo activo 
		var atcEnvioEnter = 0;
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
			var filtro_ = $("#ctlgPersona #buscardorTxt").val();
				
			if(filtro_==""){

				cargaCatalogoAtivo ="cargaTotal";

			}else{

				if (filtro_.length<6) {
					return false;
				}else if (filtro_.length>8) {
					return false;
				};
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
				url: configuracion.urlsPublic().modPersona.tabs.persona.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgPersona #catalogoDatos").html('');				
			        $("#pgnPersona #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgPersona #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgPersona #catalogoDatos").html('');				
		            $("#pgnPersona #pagination").html('');				
					//console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
					$('#btnNuevo').prop('disabled', true);
					$("#btnNuevo").removeClass('imputSusess');
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.estadoPersona==1) {
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
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-1'>" + datoItem.cedula + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-3'>" + datoItem.nombre + "<br>" + datoItem.apellido + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.usuario + "</td>");
										tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.nombre_perfil + "</td>");
										var filtroMostrarVentana = 'ventana-modal';
										tr.append("<td style=' padding: 2px; text-align: center;vertical-align:middle;' class='col-md-4'>"+
												  "<div class='btn-group' role='group' style='width: 100%;'>"+
														  "<button type='button' class='btn btn-default editarBtnDiv' id='btnEditar' "+disabledEditar+" onclick='mtdPersona.consultarPublic("+datoItem.id+"),ventanaModal.cambiaMuestraVentanaModalPublic(configuracion.urlsPublic().modPersona.tabs.persona.ventanaModal,1,0)' style='width: 50%;'>Editar</button>"+
														  "<button type='button' class='btn btn-default eliminacionLogBtnDiv' onclick='mtdPersona.cambiarEstadoPublic("+datoItem.id+","+nuevoEstado+","+datoItem.id_usuario+")'  style='width: 50%;'>"+AccionarEstado+"</button>"+
												  "</div>"+
												"</td>");

									tr.append("</tr>");

								$('#ctlgPersona #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdPersona.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdPersona.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdPersona.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdPersona.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnPersona #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(10);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="6" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgPersona #catalogoDatos').append(tr);
							//-------------
							if (filtro_!=""){
								$("#ctlgPersona #btnNuevo").prop('disabled', false);
								$("#ctlgPersona #btnNuevo").addClass('imputSusess');
							}else{
								$("#ctlgPersona #btnNuevo").prop('disabled', true);
								$("#ctlgPersona #btnNuevo").removeClass('imputSusess');
							}
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
		var consultar = function(id_persona_) {

			var accion_ = "consultar";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.persona.api,
				type:'POST',	
				data:{	
						accion:accion_,
						id:id_persona_,
					},
	            beforeSend: function () {
		        	$('#vtnPersona #form').css("display", "none");
		            $('#vtnPersona #procesandoDatosDialg').css("display", "block");

	            },
	            success:  function (data) {
					//console.log(JSON.stringify(data));
					//console.log(JSON.stringify(data[0].foto));
					
					
					$('#divPerfilTxt').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#divPerfilTxt').popover('show');
					$('#listas').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#listas').popover('show');
					$('#contentFoto').popover({
					    html: true, 
						placement: "right",
						content: function() {
					          return $('#procesandoDatosInput').html();
					        }
					});
					$('#contentFoto').popover('show');	            	
	            	/////
				    setTimeout(function(){ 
						$("#vtnPersona #perfilListD option[value='"+ data[0].id_perfil+"']").attr("selected",true);	
		            	$('#divPerfilTxt').popover('destroy');
					    setTimeout(function(){ 


					    	setTimeout(function(){ 
								$('#vtnPersona #datoControlId').val(data[0].id);
								$("#vtnPersona #cedulaTxt").val(data[0].cedula); 
								$("#vtnPersona #nombreTxt").val(data[0].nombre); 
								$("#vtnPersona #apellidoTxt").val(data[0].apellido);
								$("#vtnPersona #correoTxt").val(data[0].correo);
								//
								
								if(data[0].foto){
									$('#sinImg').css("display","none");
									$('#preViewImg').css("display","block");
									$('#preViewImg').attr("src", data[0].foto);
								};

								//
								$('#fotografia').removeAttr("required");
								// 
				            	$('#contentFoto').popover('destroy');
				            	//
								$("#vtnPersona #usuarioTxt").val(data[0].usuario); 
								$("#vtnPersona #contrasenaTxt").val(data[0].contrasena); 
								//alert(data[0].contrasena+data[0].usuario);
								//
								//
			                	$('#vtnPersona #form').css("display", "block");
		                        $('#vtnPersona #procesandoDatosDialg').css("display", "none");
								//
							},300);

					
					    }, 300);
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
				var cedula_		= $("#cedulaTxt").val(); 
				var nombre_		= $("#nombreTxt").val(); 
				var apellido_	= $("#apellidoTxt").val(); 
				var correo_		= $("#correoTxt").val(); 
				//

				var perfil_	= $('#perfilListD').val();				
				var usuario_	= $("#usuarioTxt").val(); 
				var contrasena_	= $("#contrasenaTxt").val(); 
				//
				var id_ = $('#vtnPersona #datoControlId').val();
				if (id_==""){
					id_=0;
				};


     			var datos = new FormData();
                var fotografia_ = "";
                var sinFoto_ = 0;
     			if ($('#fotografia').val()=="") {
     				sinFoto_ = 1;
     				fotografia_ ="Vist/img/cfg_persona_sin-foto.png";
     			}else{
	                fotografia_ = $('#fotografia')[0].files[0];
     			}

     			console.log(id_);
     			console.log(":::::"+id_);

                datos.append('accion',accion_);
                datos.append('id',id_);
                datos.append('cedula',cedula_);
                datos.append('nombre',nombre_);
 				datos.append('correo',correo_);
				datos.append('ip_cliente',sessionStorage.getItem("ip_cliente-US"));
				datos.append('id_usuario',sessionStorage.getItem("idUsuario-US"));				
                datos.append('perfil',perfil_);
                datos.append('apellido',apellido_);
                datos.append('fotografia',fotografia_);
                datos.append('sinFoto',sinFoto_);
                datos.append('usuario',usuario_);
                datos.append('contrasena',contrasena_);

		        $.ajax({
					url: configuracion.urlsPublic().modPersona.tabs.persona.api,
					type:'POST',	
                    data:datos,
                    contentType: false,
                    processData: false,
	                beforeSend: function () {
	                	$('#vtnPersona #form').css("display", "none");
                        $('#vtnPersona #procesandoDatosDialg').css("display", "block");
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
							if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==true) {
								// se comproobo que se abrio como administrador en las vistas de los procesos
								nucleo.controlBtnAdminInProcessPublic();
							}else{							
								ventanaModal.ocultarPulico('ventana-modal');
								mtdPersona.vaciarCatalogoPublic();
								mtdPersona.cargarCatalogoPublic(paginaActual);
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
		        nucleo.reiniciarFormularioPublic();		        
				return false;
				
		}
		/* La funcionalidad cambiarEstado: 
			# Uso : Se usa para cambiar el estado 
			# Parametros:
							* Se extraen directamente del formulario con Jquery  
							* accion_: Determina la accion a realizaar con la api
		*/		
		var cambiarEstado = function(_id_,_estado_,_id_usuario_) {
			var accion_ = "cambiarEstado";
			//
	        $.ajax({
				url: configuracion.urlsPublic().modPersona.tabs.persona.api,
				type:'POST',	
				data:{	
						accion:accion_,
						ip_cliente:sessionStorage.getItem("ip_cliente-US"),
						id_usuario:sessionStorage.getItem("idUsuario-US"),
						id:_id_,
						estado:_estado_,
						id_usuario:_id_usuario_
					},
	            beforeSend: function () {
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
					console.log("listo");
					mtdPersona.controlPaginacionPublic(paginaActual);
					return true;
	            },
		    	error: function(error) {
						console.log(JSON.stringify(error));
						alertas.dialogoErrorPublic(error.readyState,error.responseText);	
			    }
			});
			return false;
		}	

		function cargarUrl(input) {
			if (input.files&&input.files[0]) {
				$('#sinImg').css("display","none");
				$('#preViewImg').css("display","block");
			    var reader = new FileReader();
			    reader.onload = function (e) {
			    	$('#preViewImg').attr('src', e.target.result);
			    }		 
			    reader.readAsDataURL(input.files[0]);
			}
		}

		var previsualizarFotografia = function() {
						 
			$(document).on('change','#fotografia',function(){
				if (nucleo.verificarFormatoImagenePublic(this.value)==true) {
					$('#'+this.id).popover('destroy');
				    cargarUrl(this);	
				}else{
					$('#'+this.id).popover({ 
						content: "Error de formato", 
						trigger: "click",
						placement: "bottom"
					});
					$('#'+this.id).popover('show');
				}
			});
			console.log("carga de previsualizacion de foto");
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
	        $('#vtnPersona #form')[0].reset();
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
			//
			$('#sinImg').css("display","block");
			$('#preViewImg').css("display","none");
	        nucleo.reiniciarFormularioPublic();
		
		}
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			paginaActual = _pagina_;
			mtdPersona.cargarCatalogoPublic(_pagina_);   
		}	
		var activarEscuchador = function () {
		
			var idVtn = "#vtnPersona";
			// -> Form Vtn
			$(idVtn+' #form button#btnGuardarFloatR').on('click', function(e) {
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


					previsualizarFotografia();
					nucleo.cargarListaDespegablePublic('perfilListD','cfg_pn_perfil');
					activarEscuchador();
	
					if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==true) {
						// se comproobo que se abrio como administrador en las vistas de los procesos
						nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - PERSONAS - SECCIÓN : PERSONAS - DESDE LA GESTIÓN DE LAS ASIGANACIONES");
					}else{	
						mtdPersona.cargarCatalogoPublic(1);	
						nucleo.asignarPermisosBotonesPublic(10);
						nucleo.guardarBitacoraPublic("INGRESO EN EL MODULO - PERSONAS - SECCIÓN : PERSONAS");
					}


				console.log("Finalizando carga de metodos de departamento");
			},
			vaciarCatalogoPublic : vaciarCatalogo,
			restablecerFormPublic : restablecerForm,
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,
			consultarPublic : consultar,
			cambiarEstadoPublic : cambiarEstado,
		}
}();