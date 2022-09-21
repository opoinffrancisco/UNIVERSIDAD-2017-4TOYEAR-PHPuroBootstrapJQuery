var mtdAsignar = function () {
	

	/***************************Variables globales*************************/

		var paginaActual = 1; // Pagina actual de la #paginacion
		var paginaActualCaract = 1;
		var tamagno_paginas_ = 9; // Tamaño de filas por pagina #paginacion
		var atcEnvioEnter= 0;
		var atcBusqdAvanzada= 0;
		var atcPaginacionCtlg = 0;
		var atcBusqdAvanzadaDat= {
				serial: "",
				serial_bn: "",
				tipo: 0,
				modelo: 0,
				cedula: "",
				cargo: 0,
				departamento: 0,
			};

	/******************************** NOTAS *******************************/

		var opcionesBusquedaAvanvada = function () {
			atcBusqdAvanzada=1;
			$("#ctlgAsignar #buscardorTxt").val('');
			mtdAsignar.cargarCatalogoPublic(1);
			ventanaModal.ocultarPulico('ventana-modal');	
		}

		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var cargarCatalogo = function(_pagina_) {

			// Iniciando variables
			var filtro_         = $("#ctlgAsignar #buscardorTxt").val();
			var serialTxt_ 		= "";
			var serialBienNTxt_ = "";
			var tipoListD_ 		= "";
			var modeloListD_ 	= "";
			var cedulaTxt_ = "";
			var cargoListD_ 		= "";
			var departamentoListD_ 	= "";


			if (atcPaginacionCtlg==0){

				if(filtro_!=""){

					var accion_ = "FiltrarLista";
					atcBusqdAvanzada=0;

					atcBusqdAvanzadaDat.serial		= "";
					atcBusqdAvanzadaDat.serial_bn 	= "";
					atcBusqdAvanzadaDat.tipo		= 0;
					atcBusqdAvanzadaDat.modelo 		= 0;	
					atcBusqdAvanzadaDat.cedula 	    = "";
					atcBusqdAvanzadaDat.cargo		= 0;
					atcBusqdAvanzadaDat.departamento = 0;	

				}else if (filtro_=="" && atcBusqdAvanzada==0){

					var accion_ = "FiltrarLista";
					atcBusqdAvanzada=0;

					atcBusqdAvanzadaDat.serial		= "";
					atcBusqdAvanzadaDat.serial_bn 	= "";
					atcBusqdAvanzadaDat.tipo		= 0;
					atcBusqdAvanzadaDat.modelo 		= 0;	
					atcBusqdAvanzadaDat.cedula 	    = "";
					atcBusqdAvanzadaDat.cargo		= 0;
					atcBusqdAvanzadaDat.departamento = 0;	

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
					atcBusqdAvanzadaDat.cedula 	    = $("#vtnProcsBusqdAvanzd #form #cedulaTxt").val();;
					atcBusqdAvanzadaDat.cargo	= $("#vtnProcsBusqdAvanzd #form #cargoListD").val();
					if (atcBusqdAvanzadaDat.cargo==0) {
						atcBusqdAvanzadaDat.cargo="";
					}
					atcBusqdAvanzadaDat.departamento 	= $("#vtnProcsBusqdAvanzd #form #departamentoListD").val();
					if (atcBusqdAvanzadaDat.departamento==0) {
						atcBusqdAvanzadaDat.departamento="";
					}

					serialTxt_ 			= atcBusqdAvanzadaDat.serial;
					serialBienNTxt_		= atcBusqdAvanzadaDat.serial_bn;
					tipoListD_ 			= atcBusqdAvanzadaDat.tipo;
					modeloListD_ 		= atcBusqdAvanzadaDat.modelo;
					cedulaTxt_ 			= atcBusqdAvanzadaDat.cedula;
					cargoListD_     	= atcBusqdAvanzadaDat.cargo;
					departamentoListD_  = atcBusqdAvanzadaDat.departamento;			

					if($('#ventana-modal').hasClass('ventana-modal-panel-accionMostrar')==false){
						var accion_ = "FiltrarLista";
					}

				}
			}else{

				var accion_ = "BusquedaAvanzadaLista";
				
				atcPaginacionCtlg=0;
				serialTxt_ 		= atcBusqdAvanzadaDat.serial;
				serialBienNTxt_ = atcBusqdAvanzadaDat.serial_bn;
				tipoListD_ 		= atcBusqdAvanzadaDat.tipo;
				modeloListD_ 	= atcBusqdAvanzadaDat.modelo;
				cedulaTxt_ 		= atcBusqdAvanzadaDat.cedula;
				cargoListD_     = atcBusqdAvanzadaDat.cargo;
				departamentoListD_ = atcBusqdAvanzadaDat.departamento;			

				if($('#ventana-modal').hasClass('ventana-modal-panel-accionMostrar')==false){
					var accion_ = "FiltrarLista";
				}

			}		
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
				url: configuracion.urlsPublic().asignar.api,
				type:'POST',	
				data:{	
						accion:accion_,
						filtro:filtro_,
						serial:serialTxt_,
						serialBienN:serialBienNTxt_,
						tipoListD:tipoListD_, 								
						modeloListD:modeloListD_,		
						cedulaTxt:cedulaTxt_,
						cargoListD:cargoListD_,
						departamentoListD:departamentoListD_,						
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgAsignar #catalogoDatos").html('');				
			        $("#pgnAsignar #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgAsignar #catalogoDatos').append(tr);
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgAsignar #catalogoDatos").html('');				
		            $("#pgnAsignar #pagination").html('');				
					console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
							

								var serial = (datoItem.serial==null)? " ": datoItem.serial;
								var serial_bn = (datoItem.serial_bn==null)? " ": datoItem.serial_bn;
								var barraHmtl = (datoItem.serial==null)? " ": 'style="border-bottom: 1px solid #bfbfbf;"';

								var cedula = (datoItem.cedula=='')? " ": datoItem.cedula;
								var nombreApellido = (datoItem.nombreApellido=='')? " ": '('+datoItem.nombreApellido+')';

								var cargoDepartamento = (datoItem.cargoDepartamento==null)? " ": datoItem.cargoDepartamento;

								// ¡ESTADO DE URGENCIA! : Equipo dañado,Se necesita asignar con prioridad un equipo,
								if (datoItem.estado_asignacion==2) {

									var btnEditar='<button type="button" class="btn btn-default " id="btnDetalles" onclick="mtdAsignar.mostrarEdicionPublic('+datoItem.id_persona+','+datoItem.id_cargo+','+datoItem.id_departamento+','+datoItem.id_equipo+')" style="width: 100%;">Editar</button>';
									var id_persona_sesion_actual = sessionStorage.getItem('id_persona-US');
									if (datoItem.id_persona==id_persona_sesion_actual) {
										btnEditar="";
									};								


									tr = $('<tr class="row" style="background: #FFEB3B;">'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
											'<div style="width: 100%;height: 50%;">'+
												'<div class="row">'+
													'<div class="col-md-2" style="border-bottom: 1px solid #bfbfbf;">'+
														'S:'+
													'</div>'+
													'<div class="col-md-10" '+barraHmtl+' >'+
														'¡ASIGNACIÓN NECESARIA!'+
													'</div>'+
												'</div>'+
											'</div>'+
											'<div style="width: 100%;height: 50%;">'+
												'<div class="row">'+
													'<div class="col-md-2" >'+
														'B.N:'+
													'</div>'+
													'<div class="col-md-10">'+
														'ANTERIOR EQUIPO DAÑADO.'+ 
													'</div>'+
												'</div>'+
											'</div>'+
										'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3"> '+cedula+' <br> '+nombreApellido+'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+cargoDepartamento+'</td>'+
										'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											'<div class="btn-group editarBtnDiv" role="group" style="width: 100%;">'+
												btnEditar+
											'</div>'+
										'</td>')
									tr.append("</tr>");

								}else{
									var btnEditar;
									// Esperando confirmación de entrega
									if (datoItem.estado_equipo==2) {
										btnEditar = 'ESPERANDO CONFIRMACIÓN DE ENTREGA';
									}else{
										btnEditar = '<button type="button" class="btn btn-default " id="btnDetalles" onclick="mtdAsignar.mostrarEdicionPublic('+datoItem.id_persona+','+datoItem.id_cargo+','+datoItem.id_departamento+','+datoItem.id_equipo+')" style="width: 100%;">Editar</button>';
									};
									var id_persona_sesion_actual = sessionStorage.getItem('id_persona-US');
									if (datoItem.id_persona==id_persona_sesion_actual && datoItem.estado_equipo!=2) {
										btnEditar="";
									};


									tr = $('<tr class="row" >'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
											'<div style="width: 100%;height: 50%;">'+
												'<div class="row">'+
													'<div class="col-md-2" style="border-bottom: 1px solid #bfbfbf;">'+
														'S:'+
													'</div>'+
													'<div class="col-md-10" '+barraHmtl+' >'+
														serial+
													'</div>'+
												'</div>'+
											'</div>'+
											'<div style="width: 100%;height: 50%;">'+
												'<div class="row">'+
													'<div class="col-md-2" >'+
														'B.N:'+
													'</div>'+
													'<div class="col-md-10">'+
														serial_bn+ 
													'</div>'+
												'</div>'+
											'</div>'+
										'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3"> '+cedula+' <br> '+nombreApellido+'</td>'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-3">'+cargoDepartamento+'</td>'+
										'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											'<div class="btn-group editarBtnDiv" role="group" style="width: 100%;">'+
												btnEditar+
											'</div>'+
										'</td>')
									tr.append("</tr>");

								};


								$('#ctlgAsignar #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdAsignar.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
																"<a href='JavaScript:;' onclick='mtdAsignar.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
															"</li>"
														); 
														
											}else{
												ul.append(
														    "<li>"+
														     	"<a href='JavaScript:;' onclick='mtdAsignar.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdAsignar.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pgnAsignar #pagination').append(ul);
						});
						nucleo.asignarPermisosBotonesPublic(5);
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgAsignar #catalogoDatos').append(tr);
							//-------------
							if (filtro_!=""){
								$("#ctlgAsignar #btnNuevo").prop('disabled', false);
								$("#ctlgAsignar #btnNuevo").addClass('imputSusess');
							}else{
								$("#ctlgAsignar #btnNuevo").prop('disabled', true);
								$("#ctlgAsignar #btnNuevo").removeClass('imputSusess');
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

	
		/* 	La funcionalidad cargarCatalogo
	 		# Uso : Se usa para extraer todos los datos relacionados con el filtro
			# Parametros :
			# Notas :
		*/
		var ListarBusqdAvanzdPersonasASIG = function(_pagina_) {

			// Iniciando variables
			var cedula_ 		= "";
			var cargo_ 		= "";
			var departamento_ 	= "";


			var accion_ = "ListarBusqdAvanzdPersonasASIG";
			//

			cedula_ = $("#vtnAsignar #form #cedulaTxtCtlgASIG").val();

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
				url: configuracion.urlsPublic().asignar.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						cedula:cedula_,
						cargo:cargo_,		
						departamento:departamento_, 	
						id_usuario_sesion:sessionStorage.getItem("idUsuario-US"),											
						tamagno_paginas:8,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgProcsPersonasASIG #catalogoDatos").html('');				
			        $("#pngProcsPersonasASIG #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgProcsPersonasASIG #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgProcsPersonasASIG #catalogoDatos").html('');				
		            $("#pngProcsPersonasASIG #pagination").html('');				
					//console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   

					tr = $('<tr class="row ">'+
						
								'<td id="cedula" style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-10">'+
									 datoItem.cedula+' <br>'+
									 '('+datoItem.nombreApellido+')'+
								'</td>'+
								'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
									'<div class="checkbox">'+
									    '<label>'+
											'<input type="checkbox" class="persona-asignando" data-idpersona="'+datoItem.id_persona+'" data-cedula="'+datoItem.cedula+'" data-nombreapellido="'+datoItem.nombreApellido+'"   data-correo_electronico="'+datoItem.correo_electronico+'">'+
									    '</label>'+
									'</div>'+													
								'</td>'+							
							'</tr>');
							
								$('#ctlgProcsPersonasASIG #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" style="padding-left: 0px;" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdAsignar.ListarBusqdAvanzdPersonasASIGPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdAsignar.ListarBusqdAvanzdPersonasASIGPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdAsignar.ListarBusqdAvanzdPersonasASIGPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdAsignar.ListarBusqdAvanzdPersonasASIGPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngProcsPersonasASIG #pagination').append(ul);
						});
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgProcsPersonasASIG #catalogoDatos').append(tr);
							//-------------
					/*		if(filtro_!=""){

								$("#ctlgProcsPersonasASIG #btnNuevo").prop('disabled', false);
								$("#ctlgProcsPersonasASIG #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgProcsPersonasASIG #btnNuevo").prop('disabled', true);
								$("#ctlgProcsPersonasASIG #btnNuevo").removeClass('imputSusess');
								
							}
					*/
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
		var ListarBusqdAvanzdCargoDepartamentoASIG = function(_pagina_) {

			// Iniciando variables
			var cargo_ 		= "";
			var departamento_ 	= "";

			var accion_ = "ListarBusqdAvanzdCargoDepartamentoASIG";
			//

			cargo_	= $("#vtnAsignar #form #cargoListD").val();
			if (cargo_==0) {
				cargo_="";
			}
			departamento_ 	= $("#vtnAsignar #form #departamentoListD").val();
			if (departamento_==0) {
				departamento_="";
			}
			
			//
			var mensajeRespDpt = "";
			//
			// control paginacion
			var pagina_ = _pagina_;
			//
	        $.ajax({
				url: configuracion.urlsPublic().asignar.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						cargo:cargo_,		
						departamento:departamento_, 						
						tamagno_paginas:8,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgProcsCargoDepartamentoASIG #catalogoDatos").html('');				
			        $("#pngProcsCargoDepartamentoASIG #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgProcsCargoDepartamentoASIG #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgProcsCargoDepartamentoASIG #catalogoDatos").html('');				
		            $("#pngProcsCargoDepartamentoASIG #pagination").html('');				
					//console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								if (datoItem.responsable_departamento==1) {
									mensajeRespDpt	= "SI";
								}else{
									mensajeRespDpt	= "NO";
								}								

								if (datoItem.tieneAsignacionActiva==true) {

									tr = $('<tr class="row ">'+
					
										'<td id="cargoDepartamento" style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-8">'+														
											datoItem.cargoDepartamento+
										'</td>	'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+														
											mensajeRespDpt+
										'</td>	'+								
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											'<div class="checkbox">'+
											    '<label>'+
													'<input type="checkbox" class="cardodepartamento-asignando" data-id_cargo="'+datoItem.id_cargo+'"   data-id_departamento="'+datoItem.id_departamento+'" data-cargodepartamento="'+datoItem.cargoDepartamento+'" >'+
											    '</label>'+
											'</div>'+													
										'</td>'+							
									'</tr>');

								} else{

									tr = $('<tr class="row danger">'+
					
										'<td id="cargoDepartamento" style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-8">'+														
											datoItem.cargoDepartamento+
										'</td>	'+
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+														
											mensajeRespDpt+
										'</td>	'+								
										'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											'<div class="checkbox">'+
											    '<label style="padding: 0px;">'+
													'Asignado'+
											    '</label>'+
											'</div>'+													
										'</td>'+							
									'</tr>');					
								};

							
								$('#ctlgProcsCargoDepartamentoASIG #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" style="padding-left: 0px;" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngProcsCargoDepartamentoASIG #pagination').append(ul);
						});
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgProcsCargoDepartamentoASIG #catalogoDatos').append(tr);
							//-------------
					/*		if(filtro_!=""){

								$("#ctlgProcsPersonasASIG #btnNuevo").prop('disabled', false);
								$("#ctlgProcsPersonasASIG #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgProcsPersonasASIG #btnNuevo").prop('disabled', true);
								$("#ctlgProcsPersonasASIG #btnNuevo").removeClass('imputSusess');
								
							}
					*/
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
		var ListarBusqdAvanzdEquiposASIG = function(_pagina_) {

			// Iniciando variables
			var serial_ 		= "";
			var serialBN_ 		= "";			
			var modelo_ 		= 0;
			var tipo_ 	= 0;


			var accion_ = "ListarBusqdAvanzdEquiposASIG";
			//

			serial_ = $("#vtnAsignar #form #serialTxt").val();
			serialBN_ = $("#vtnAsignar #form #serialBNTxt").val();
			modelo_	= $("#vtnAsignar #form #modeloListD").val();
			if (modelo_==0) {
				modelo_="";
			}
			tipo_ 	= $("#vtnAsignar #form #tipoListD").val();
			if (tipo_==0) {
				tipo_="";
			}

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
				url: configuracion.urlsPublic().asignar.api ,
				type:'POST',	
				data:{	
						accion:accion_,
						serial:serial_,
						serialBN:serialBN_,
						modelo:modelo_,		
						tipo:tipo_, 						
						tamagno_paginas:8,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgProcsEquiposASIG #catalogoDatos").html('');				
			        $("#pngProcsEquiposASIG #pagination").html('');	
					tr = $('<tr>');
					tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgProcsEquiposASIG #catalogoDatos').append(tr);

			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgProcsEquiposASIG #catalogoDatos").html('');				
		            $("#pngProcsEquiposASIG #pagination").html('');				
				//	console.log(JSON.stringify(data));
	    	        //var cantResultados = Object.keys(data.resultados).length;
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   

		    					if (datoItem.asignaciondActiva==true) {

									tr = $('<tr class="row ">'+						
											'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-6">'+

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
											'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
												datoItem.marcaymodelo+
											'</td>	'+
											'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
											'<div class="btn-group" role="group" style="width: 50%; float:right;">'+
											'<!--'+
												'<button type="button" class="btn btn-default" id="btnDetalles" onclick="ventanaModal.cambiaMuestraVentanaModalCapa2Public("procesos/solicitud/ventanasModales/vtnMGestionEquipoDetalles.php",1,0)" style="width: 100%;">Ver Detalles</button>'+
											'-->'+
											'</div>'+								
												  '<div class="checkbox">'+
												    '<label>'+
												      '<input type="checkbox" class="equipo-asignando" data-idequipo="'+datoItem.id+'" data-serial="'+datoItem.serial+'" data-serial_bn="'+datoItem.serial_bn+'" data-marcaymodelo="'+datoItem.marcaymodelo+'" data-tipo="'+datoItem.tipo+'">'+
												    '</label>'+
												  '</div>'+													
											'</td>'+	
										'</tr>');

		    					}else{

										tr = $('<tr class="row danger">'+						
												'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-6">'+

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
												'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-4">'+
													datoItem.marcaymodelo+
												'</td>	'+
												'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-2">'+
												'<div class="btn-group" role="group" style="width: 50%; float:right;">'+
												'<!--'+
													'<button type="button" class="btn btn-default" id="btnDetalles" onclick="ventanaModal.cambiaMuestraVentanaModalCapa2Public("procesos/solicitud/ventanasModales/vtnMGestionEquipoDetalles.php",1,0)" style="width: 100%;">Ver Detalles</button>'+
												'-->'+
												'</div>'+								
													  '<div class="checkbox">'+
													    '<label>'+
														    'Asignado'+ 
													    '</label>'+
													  '</div>'+													
												'</td>'+	
											'</tr>');		    						

		    					};
								$('#ctlgProcsEquiposASIG #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" style="padding-left: 0px;" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic('+dato.pagAnterior+')" aria-label="Previous">'+
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
															"<a href='JavaScript:;' onclick='mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic("+i+")' >"+ i +"</a>"+
														"</li>"
													); 
													
										}else{
											ul.append(
													    "<li>"+
													     	"<a href='JavaScript:;' onclick='mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic("+i+")' >"+ i +"</a>"+
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
									 			'<a href="JavaScript:;" onclick="mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'	
										);
							}

							$('#pngProcsEquiposASIG #pagination').append(ul);
						});
					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay resultados para la busqueda </td>');
							tr.append("</tr>");
							$('#ctlgProcsEquiposASIG #catalogoDatos').append(tr);
							//-------------
					/*		if(filtro_!=""){

								$("#ctlgProcsPersonasASIG #btnNuevo").prop('disabled', false);
								$("#ctlgProcsPersonasASIG #btnNuevo").addClass('imputSusess');

							}else{

								$("#ctlgProcsPersonasASIG #btnNuevo").prop('disabled', true);
								$("#ctlgProcsPersonasASIG #btnNuevo").removeClass('imputSusess');
								
							}
					*/
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



		var agregarEquipoDeLista = function() {

				var id_equipo_ = "";
				if ($('#vtnAsignar .equipo-asignando:checked').length==0) {

						nucleo.alertaErrorPublic("No se ha realizado una selección");
						return false;
		
				}else if ($('#vtnAsignar .equipo-asignando:checked').length>1) {
		
						nucleo.alertaErrorPublic("Se ha selecionado más de 1");
						return false;

				}else if ($('#vtnAsignar .equipo-asignando:checked').length==1) {
					
					id_equipo_ = $('.equipo-asignando:checked').data('idequipo');
					var serial_ = $('.equipo-asignando:checked').data('serial');					
					var serial_bn_ = $('.equipo-asignando:checked').data('serial_bn');
					var marcaymodelo_ = $('.equipo-asignando:checked').data('marcaymodelo');
					var tipo_ = $('.equipo-asignando:checked').data('tipo');
					$('#idequipoAsTxt').val(id_equipo_);
					$('#serialAsTxt').val(serial_);
					$('#serialBNAsTxt').val(serial_bn_);
					$('#tipoAsTxt').val(tipo_);
					$('#marcaModeloAsTxt').val(marcaymodelo_);

				};

		}
		var agregarCargoDepartamentoDeLista = function() {

				var id_cargo ="";
				var id_departamento = "";
				if ($('#vtnAsignar .cardodepartamento-asignando:checked').length==0) {

						nucleo.alertaErrorPublic("No se ha realizado una selección");
						return false;
		
				}else if ($('#vtnAsignar .cardodepartamento-asignando:checked').length>1) {

						nucleo.alertaErrorPublic("Se ha selecionado más de 1");
						return false;

				}else if ($('#vtnAsignar .cardodepartamento-asignando:checked').length==1) {
					
					id_cargo = $('.cardodepartamento-asignando:checked').data('id_cargo');
					id_departamento = $('.cardodepartamento-asignando:checked').data('id_departamento');
					var cargodepartamento_ = $('.cardodepartamento-asignando:checked').data('cargodepartamento');
					$('#idcargoAsTxt').val(id_cargo);
					$('#iddepartamentoAsTxt').val(id_departamento);
					$('#cargoDepartamentoAsTxt').val(cargodepartamento_);

				};

		}
		var agregarṔersonaDeLista = function() {

				var id_cargo = "";
				if ($('#vtnAsignar .persona-asignando:checked').length==0) {

						nucleo.alertaErrorPublic("No se ha realizado una selección");
						return false;
		
				}else if ($('#vtnAsignar .persona-asignando:checked').length>1) {
		
						nucleo.alertaErrorPublic("Se ha selecionado más de 1");
						return false;

				}else if ($('#vtnAsignar .persona-asignando:checked').length==1) {
					
					id_cargo = $('.persona-asignando:checked').data('id_cargo');
					var idpersona_ = $('.persona-asignando:checked').data('idpersona');
					var cedula_ = $('.persona-asignando:checked').data('cedula');
					var nombreapellido_ = $('.persona-asignando:checked').data('nombreapellido');
					var correo_electronico_ = $('.persona-asignando:checked').data('correo_electronico');
					$('#idpersonaAsTxt').val(idpersona_);
					$('#cedulaAsTxt').val(cedula_);
					$('#nombreApellidoAsTxt').val(nombreapellido_);
					$('#correoElectronicoAsTxt').val(correo_electronico_);

				};

		}

		/*****************************************************************/
		var desvincularEquipo = function () {
			$('#idequipoAsTxt').val('');
			$('#serialAsTxt').val('');
			$('#serialBNAsTxt').val('');
			$('#tipoAsTxt').val('');
			$('#marcaModeloAsTxt').val(''); 
			nucleo.alertaErrorPublic("Presionar 'Guardar' para realizar cambios");
		}
		var desvincularDepartamentoCargo = function () {
			$('#idcargoAsTxt').val('');
			$('#iddepartamentoAsTxt').val('');
			$('#cargoDepartamentoAsTxt').val('');
			nucleo.alertaErrorPublic("Presionar 'Guardar' para realizar cambios");
		}		
		var desvincularPersona = function () {
			$('#idpersonaAsTxt').val('');
			$('#cedulaAsTxt').val('');
			$('#nombreApellidoAsTxt').val('');
			$('#correoElectronicoAsTxt').val('');
			nucleo.alertaErrorPublic("Presionar 'Guardar' para realizar cambios");
		}

		/*****************************************************************/

		/*
			Fintraldo de un select por otro select Marca -> modelo
		*/
		var filtrarSelect = function() {
			$('#marcaListD').on('change', function (item) {
				var id_marca = $('#marcaListD').val();

			  	nucleo.cargarListaDespegableListasAnidadaPublic('modeloListD','cfg_c_fisc_modelo','id_marca',id_marca,'un modelo');
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
			Mostrar edicion o tipico Consultar

		*/
		var mostrarEdicion = function (id_persona_, id_cargo_,id_departamento_, id_equipo_) {

			ventanaModal.cambiaMuestraVentanaModalPublic("procesos/asginarEquipoPersona/ventanasModales/vtnMGestionAsignarEquipoPersona.php",1,1);

			var accion_ = "consultar";
			
			//console.log("verificando: "+id_departamento_);
			//
	        $.ajax({
				url: configuracion.urlsPublic().asignar.api,
				type:'POST',	
				data:{
						accion:accion_,
						id_persona:id_persona_,
						id_cargo:id_cargo_,
						id_departamento:id_departamento_,
						id_equipo:id_equipo_,
					},
	            beforeSend: function () {
					$('#vtnAsignar #form').css("display", "none");
					$('#vtnAsignar #procesandoDatosDialg').css("display", "block");
		
	            },
	            success:  function (data) {

	            	$('#btnGuardarReasignacion').css('display', 'block');
	            	$('#btnGuardarAsignacion').css('display', 'none');

					console.log(JSON.stringify(data));
					$(data).each(function (index, dato) {
	
		    				$(dato.resultado).each(function (index, datoItem) {   

								$('#serialAsTxt').val(datoItem.serial);
								$('#serialBNAsTxt').val(datoItem.serial_bn);
								$('#tipoAsTxt').val(datoItem.tipo);
								$('#marcaModeloAsTxt').val(datoItem.marcaymodelo);

								$('#cargoDepartamentoAsTxt').val(datoItem.cargoDepartamento);

								$('#cedulaAsTxt').val(datoItem.cedula);
								$('#nombreApellidoAsTxt').val(datoItem.nombreApellido);
								$('#correoElectronicoAsTxt').val(datoItem.correo_electronico);
			
								$('#idpersonaAsTxt').val(datoItem.id_persona);			
								$('#idcargoAsTxt').val(datoItem.id_cargo);							
								$('#iddepartamentoAsTxt').val(datoItem.id_departamento);							
								$('#idequipoAsTxt').val(datoItem.id_equipo);					
				
								$('#estadoControlAs').val(datoItem.estado_asignacion);					

								$('#btnGuardarReasignacion').data('id_equipo',datoItem.id_equipo);
								$('#btnGuardarReasignacion').data('id_cargo',datoItem.id_cargo);
								$('#btnGuardarReasignacion').data('id_departamento',datoItem.id_departamento);
								$('#btnGuardarReasignacion').data('id_persona',datoItem.id_persona);
								//
								$('#btnGuardarReasignacion').data('id_solicitud_gestion', datoItem.id_solicitud_gestion);

								mtdAsignar.guardarPublic();

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
		

		/* La funcionalidad Guardar: 
			# Uso : Se usa para guardar y editar
			# Parametros:
			* Se extraen directamente del formulario con Jquery  
			* accion_: Determina la accion a realizaar con la api
		*/		
		var guardar = function() {
			
			var btnGuardar;

			if ($('#btnGuardarReasignacion').is(':hidden')) {
				btnGuardar = "btnGuardarAsignacion";
				console.log("btnGuardarAsignacion");
			}else{
				btnGuardar = "btnGuardarReasignacion";
				console.log("btnGuardarReasignacion");		
			};

			$('#vtnAsignar #form #'+btnGuardar).on('click', function(e) {
				//e.preventDefault();

				/* Obtener valores de los campos del formulario*/
				//
				var id_persona_ = $('#idpersonaAsTxt').val();
				if (id_persona_==null || id_persona_==0) {
					id_persona_="";
				}
				var id_equipo_ = $('#idequipoAsTxt').val();					
				if (id_equipo_==null || id_equipo_==0) {
					id_equipo_="";
				}
				var id_cargo_  =	$('#idcargoAsTxt').val();
				if (id_cargo_==null || id_cargo_==0) {
					id_cargo_="";
				}
				var id_departamento_  =	$('#iddepartamentoAsTxt').val();
				if (id_departamento_==null || id_departamento_==0) {
					id_departamento_="";
				}
				var estado_  =	$('#estadoControlAs').val();
				//
				if ( (id_persona_ == "" && id_equipo_ == ""  && id_cargo_   == ""  &&  id_departamento_ == "") 
					|| (id_persona_ == 0 && id_equipo_ == 0  &&  id_cargo_   == 0 &&  id_departamento_ == 0) ) {
					nucleo.alertaErrorPublic("Formulario vacio");
					return false;
				}else if ( (id_persona_ == "" && id_equipo_ != "" && id_cargo_   == ""   &&  id_departamento_ == "") 
					|| (id_persona_ == 0  && id_equipo_ != 0 && id_cargo_   == 0   &&  id_departamento_ == 0) ){
					nucleo.alertaErrorPublic("Agregar persona y/o ubicación a vincular");
					return false;
				}else if ( (id_persona_ != "" && id_equipo_ == "" && id_cargo_   == ""   &&  id_departamento_ == "") 
					|| (id_persona_ != 0  && id_equipo_ == 0 && id_cargo_   == 0   &&  id_departamento_ == 0) ){
					nucleo.alertaErrorPublic("Agregar equipo y/o úbicación a vincular");
					return false;
				}else if ( (id_persona_ == "" && id_equipo_ == "" && id_cargo_   != ""   &&  id_departamento_ != "") 
					|| (id_persona_ == 0  && id_equipo_ == 0 && id_cargo_   != 0   &&  id_departamento_ != 0) ){
					nucleo.alertaErrorPublic("Agregar equipo y/o persona a vincular");
					return false;
				}												
				//
				if($('#btnGuardarReasignacion').data('id_equipo')!='' || 
					$('#btnGuardarReasignacion').data('id_persona')!='' || 
					$('#btnGuardarReasignacion').data('id_cargo')!='' || 
					$('#btnGuardarReasignacion').data('id_departamento')!='' ) {

					if (estado_==1) {
						var accion_ = "reasignar";
					}else if(estado_==2){
						var accion_ = "editarPorEstado2";						
					};

					var id_personaActual_ = $('#btnGuardarReasignacion').data('id_persona');
					if (id_personaActual_==null || id_personaActual_==0) {
						 id_personaActual_="";
					}
					var id_cargoActual_  =	$('#btnGuardarReasignacion').data('id_cargo');
					if (id_cargoActual_==null || id_cargoActual_==0) {
						 id_cargoActual_="";
					}
					var id_departamentoActual_  =	$('#btnGuardarReasignacion').data('id_departamento');
					if (id_departamentoActual_==null || id_departamentoActual_==0) {
						 id_departamentoActual_="";
					}
					var id_equipoActual_ = $('#btnGuardarReasignacion').data('id_equipo');
					if (id_equipoActual_==null || id_equipoActual_==0) {
						 id_equipoActual_="";
					}
					if (id_persona_ == id_personaActual_ && id_cargo_   == id_cargoActual_ &&
						id_equipo_ == id_equipoActual_  &&  id_departamento_ == id_departamentoActual_) {
							nucleo.alertaErrorPublic("No se han realizado cambios");
							return false;
					}

				} else {

					var accion_ = "guardar";

				}

				//console.log(id_personaActual_+'  '+id_cargoActual_+'   '+id_departamentoActual_+'  '+id_equipoActual_ +'  ---- '+id_persona_+'  '+id_cargo_ +' '+id_departamento_+' '+id_equipo_);
				//
		    $.ajax({
							url: configuracion.urlsPublic().asignar.api,
							type:'POST',	
							data:{	
							accion:accion_,
							ip_cliente:sessionStorage.getItem("ip_cliente-US"),
							id_usuario:sessionStorage.getItem("idUsuario-US"),										
							id_persona:id_persona_,
							id_cargo:id_cargo_,
							id_departamento:id_departamento_,
							id_equipo:id_equipo_,
							id_persona_actual:id_personaActual_,
							id_cargo_actual:id_cargoActual_,
							id_departamento_actual:id_departamentoActual_,
							id_equipo_actual:id_equipoActual_,
						},
	                beforeSend: function () {
																			$('#vtnAsignar #form').css("display", "none");
																			$('#vtnAsignar #procesandoDatosDialg').css("display", "block");
																			$("#catalogoDatos").html('');				
																			$("#pagination").html('');	
																			tr = $('<tr>');
																			tr.append('<td colspan="5" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
																			tr.append("</tr>");
																			$('#catalogoDatos').append(tr);
	                },
	                success:  function (result) {
																		console.log(JSON.stringify(result));
																		if (result[0].controlError==0) {
																						var id_solicitud_gestion	=	$('#btnGuardarReasignacion').data('id_solicitud_gestion');
																						// ASIGNADO  NUEVO EQUIPO A PERSONA EN GETION DE SOLICITUD, A QUIEN SE LE DAÑO EL EQUIPO ANTERIOR
																						if (id_solicitud_gestion!=0) {
																							/*
																								PARAMETROS:
																									1 - ESTADO MANTENIMIENTO
																									2 - TIPO DE MANTENIMIENTO
																									3 - ID_TAREA_EQUIPO
																									4 - ID_SOLICITUD
																									5 - DETALLES DE LA EJECUCIÓN QUE REALIZO LA PERSONA
																									6 - TIPO DE EJECUCIÓN QUE REALIZO LA PERSONA
																							*/
																							var serila_equipo = $('#vtnAsignar #serialAsTxt').val();
																							var detalles_ = " SE ASIGNO EL EQUIPO DE SERIAL :"+serila_equipo;
																							var detalles_save_ = "EQUIPO DE SERIAL :"+serila_equipo;
																							nucleo.guardarPersonaEjecutaPublic(0,0,2,0,id_solicitud_gestion,detalles_save_,18);
																						};
																						nucleo.alertaExitoPublic(result[0].detalles);
																						ventanaModal.ocultarPulico('ventana-modal');
																						$("#catalogoDatos").html('');				
																						$("#pagination").html('');	
																						mtdAsignar.cargarCatalogoPublic(paginaActual);
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
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			if (atcBusqdAvanzada==1) {
				atcPaginacionCtlg = 1;				
			}else{
				atcPaginacionCtlg = 0;
			}
			paginaActual = _pagina_;
			mtdAsignar.cargarCatalogoPublic(_pagina_);   
		}	
			
		var controlPaginacionCaract = function (_pagina_) {
			paginaActualCaract = _pagina_;
			mtdAsignar.cargarListaCaracteristicasPublic(_pagina_);   
		}			
	return{
		Inicio : function () {
			
		},
		guardarPublic : guardar,
		filtrarSelectPublic : filtrarSelect,
		cargarCatalogoPublic : cargarCatalogo,
		opcionesBusquedaAvanvadaPublic : opcionesBusquedaAvanvada,
		controlPaginacionPublic : controlPaginacion,
		mostrarEdicionPublic : mostrarEdicion,
		ListarBusqdAvanzdPersonasASIGPublic : ListarBusqdAvanzdPersonasASIG,
		ListarBusqdAvanzdCargoDepartamentoASIGPublic : ListarBusqdAvanzdCargoDepartamentoASIG,
		ListarBusqdAvanzdEquiposASIGPublic : ListarBusqdAvanzdEquiposASIG,
		agregarEquipoDeListaPublic : agregarEquipoDeLista,
		agregarCargoDepartamentoDeListaPublic : agregarCargoDepartamentoDeLista,
		agregarṔersonaDeListaPublic : agregarṔersonaDeLista,
		desvincularEquipoPublic : desvincularEquipo,
		desvincularDepartamentoCargoPublic : desvincularDepartamentoCargo, 
		desvincularPersonaPublic : desvincularPersona,
	}
}();