var mtdBitacora = function() {
		
	/***************************Variables globales*************************/
		var paginaActual = 1; // Pagina actual de la #paginacion
		var tamagno_paginas_ = 15; // Tamaño de filas por pagina #paginacion
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

			var usuario_ = $('#buscardorUsuarioTxt').val();
			var operacion_ = $('#buscardorOperacionTxt').val();
			var perfil_ = $('#bperfilListD').val();
			var buscardordesde_ = $('#buscardorDesde').val();
			var buscardorhasta_ = $('#buscardorHasta').val();	


			if (buscardordesde_!="" && buscardorhasta_=="") {
				buscardordesde_="";
			}		
			if (buscardordesde_=="" && buscardorhasta_!="") {
				buscardorhasta_="";
			}					
			if (perfil_==0) {
				perfil_="";
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
				url: configuracion.urlsPublic().mantenimineto.modBitacora.bitacora.api,
				type:'POST',	
				data:{	
						accion:accion_,
						usuario:usuario_,
						operacion:operacion_,
						perfil:perfil_,
						buscardordesde:buscardordesde_,
						buscardorhasta:buscardorhasta_,
						tamagno_paginas:tamagno_paginas_,
						pagina:pagina_,					
					},
	            beforeSend: function () {

			        $("#ctlgBitacora #catalogoDatos").html('');				
					tr = $('<tr>');
					tr.append('<td colspan="6" style="text-align: center;"><img src="Vist/img/cargando2.gif" class="img-cargando"></td>');
					tr.append("</tr>");
					$('#ctlgBitacora #catalogoDatos').append(tr);
			        $("#pgnBitacora #pagination").html('');						
			        console.log("Procesando información...");
	            },
	            success:  function (data) {
		    
		            $("#ctlgBitacora #catalogoDatos").html('');				
			        $("#pgnBitacora #pagination").html('');						

					console.log(JSON.stringify(data));
	                if (data.controlError==0) {
						$(data).each(function (index, dato) {
						//Obteniendo resultados para catalogo
		    				$(dato.resultados).each(function (index, datoItem) {                				   
								tr = $('<tr class="row '+ColorEstado+'">');
									tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.usuario + "</td>");
									tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-2'>" + datoItem.nombre + "</td>");
									tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle;' class='col-md-6'>" + datoItem.operacion + "</td>");
									tr.append("<td style=' padding: 0px; text-align: center;vertical-align:middle; padding: 0px;' class='col-md-2'>" + datoItem.fecha + "</td>");
								tr.append("</tr>");
								$('#ctlgBitacora #catalogoDatos').append(tr);
							});

							// --------------------------------Paginacion del catalogo ---------------------------------

						    ul = $('<ul class="pagination pagination-sm" >');
							// pagAnterior
							if (!(dato.pagActual<=1)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdBitacora.controlPaginacionPublic(1)" aria-label="Previous">'+
													'<span aria-hidden="true">&laquo;&laquo;</span>'+					      
												'</a>'+
											'</li>'	
										);
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdBitacora.controlPaginacionPublic('+dato.pagAnterior+')" aria-label="Previous">'+
													'<span aria-hidden="true">&laquo;</span>'+					      
												'</a>'+
											'</li>'	
										);
							}
							//paginas
							var conteoVisibles = 0;
							if (dato.pagActual>=1) {
								if (dato.total_paginas>1) {
									
									for (var i=1; i <= dato.total_paginas ; i++) { 

										var pgnControlActual = 0;
										var pgnControlActualAntes = 0;
										var pgnControlActualLuego = 0;

										pgnControlActual = dato.pagActual;
										pgnControlActualAntes=pgnControlActual-8;

										if (conteoVisibles<15) {

											if (i>pgnControlActualAntes ) {

												conteoVisibles=conteoVisibles+1;

												if(i==dato.pagActual) {
														ul.append(
																	"<li class='active'>"+
																		"<a href='JavaScript:;' onclick='mtdBitacora.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
																	"</li>"
																); 
												}else{
														ul.append(
																    "<li>"+
																     	"<a href='JavaScript:;' onclick='mtdBitacora.controlPaginacionPublic("+i+")' >"+ i +"</a>"+
																	"</li>" 
																);
												}
											};
										};
									}
								}
							}
							//pagSiguiente
							if (!(dato.pagActual>=dato.total_paginas)) {
								ul.append(
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdBitacora.controlPaginacionPublic('+dato.pagSiguiente+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;</span>'+
												'</a>'+
											'</li>'+
											'<li>'+
									 			'<a href="JavaScript:;" onclick="mtdBitacora.controlPaginacionPublic('+dato.total_paginas+')"  aria-label="Next">'+
										        '<span aria-hidden="true">&raquo;&raquo;</span>'+
												'</a>'+
											'</li>'												
										);
							}

							$('#pgnBitacora #pagination').append(ul);							
						});

					}else{
							tr = $('<tr>');
							tr.append('<td colspan="5" style="text-align: center;"> No hay operaciones de usuarios para auditar</td>');
							tr.append("</tr>");
							$('#ctlgBitacora #catalogoDatos').append(tr);
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


	/****************************Metodos de control**************************/		
		/*
			
		*/	
		var controlPaginacion = function (_pagina_) {
			paginaActual = _pagina_;
			mtdBitacora.cargarCatalogoPublic(_pagina_);   
		}	
	/****************Inicializacion e Intancias de metodos *******************/

		return{
			Iniciar : function() {


				console.log("Finalizando carga de metodos para Mantenimiento - Bitacora");
			},
			cargarCatalogoPublic : cargarCatalogo,
			controlPaginacionPublic : controlPaginacion,

		}
}();