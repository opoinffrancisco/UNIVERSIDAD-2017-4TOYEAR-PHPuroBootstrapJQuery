	var listas = function() {

	/***************************Variables globales*************************/
		var valorAnteriorSelec=0;// id del select donde se realizo click
	/*********************************************************************/

			var agregarItemInput = function(_idVtnM_,_listVtnCatalogoDatos_,_btnAdd_) {


		  		$('#'+_btnAdd_).attr("disabled", true);
		  		//--------------------------------------------
				var numFila=0;
				var vuelta  = 0;

				$('#'+_idVtnM_+' #'+_listVtnCatalogoDatos_+' .filaInputs' ).each(function (index, datoItem) {
					var cant = $('#'+_idVtnM_+' #'+_listVtnCatalogoDatos_+' .filaInputs').length;

					vuelta=vuelta+1;
//					console.log("vuelta"+vuelta);
//					console.log(cant+"vuelta"+vuelta);
					//

					if(vuelta==1){
						//console.log(numFila);
						var idItem_ = $(datoItem).attr("id");
						numFila = $('#'+idItem_).data('numfila');
						//console.log(numFila);
					}

				});
				numFila=numFila+1;
				//console.log(numFila);

				//SIN LIMITES
				/*
				// limite 49 = 50
				if (numFila < 49 || numFila == 49) {
			  		$('#'+_btnAdd_).attr("disabled", false);
				}*/
				$('#contadorList').val('');
				$('#contadorList').val(numFila);
				var tabla = "'equipo'";
				var columna = "'serial'";
				var nombreCampoTxt = "'fila"+numFila+" #input1'";

				var columnaBn = "'serial_bn'";
				var nombreCampoBNTxt = "'fila"+numFila+" #input2'";

				tr = $('<tr  class="row filaInputs" id="fila'+numFila+'" data-numfila="'+numFila+'" style="padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #ddd; border-bottom: 0px solid #ddd;"  > ');			

				  tds =('<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-5">'+
							'<div class="form-group">'+
							    '<input type="text" class="campo-control form-control" id="input1" placeholder="Introducir serial" '+
							    ' onkeypress="mtdEquipo.obtenerDatoAnteriorPublic('+nombreCampoTxt+')"'+
							    ' onkeyup="mtdEquipo.validarExistenciaYGEstionPublic('+tabla+','+columna+','+nombreCampoTxt+',true)"'+
							    ' onblur="mtdEquipo.validarExistenciaYGEstionPublic('+tabla+','+columna+','+nombreCampoTxt+',true)"'+
								 ' data-cantmax="50" maxlength="50" data-cantmin="4" '+
							    'style="margin-bottom: 0px; border: 1px solid white; box-shadow: unset;">'+
							'</div>'+
						'</td>'+
						'<td style=" padding: 0px; text-align: center;vertical-align:middle;" class="col-md-5">'+														
							'<div class="form-group">'+
							    '<input type="text" class="form-control" id="input2" placeholder="Introducir serial de bien Nacional" '+
							    ' onkeypress="mtdEquipo.obtenerDatoAnteriorPublic('+nombreCampoTxt+')"'+
							    ' onkeyup="mtdEquipo.validarExistenciaYGEstionPublic('+tabla+','+columnaBn+','+nombreCampoBNTxt+',false)"'+
							    ' onblur="mtdEquipo.validarExistenciaYGEstionPublic('+tabla+','+columnaBn+','+nombreCampoBNTxt+',false)"'+							    
								' data-cantmax="50" maxlength="50" data-cantmin="4" '+
								'style="margin-bottom: 0px; border: 1px solid white; box-shadow: unset;">'+
							'</div>'+														
						'</td>'+
						'<td style=" padding: 5px; text-align: center;vertical-align:middle;" class="col-md-2">'+
							'<div class="btn-group" role="group" style="width: 100%;">'+
								'<button type="button" class="btn btn-default" id="btnRemoverItem"  style="width: 100%;"'+
								'onclick="listas.borrarItemInputPublic('+numFila+','+_listVtnCatalogoDatos_+')" '+
								'>x</button>'+
							'</div>'+
						'</td>');

					tr.append(tds);
				tr.append("</tr>");

				$('#'+_idVtnM_+' #'+_listVtnCatalogoDatos_+' #catalogoDatos').after(tr);
			  	$('#'+_btnAdd_).attr("disabled", false);
			}

			var borrarItemInput = function(numFila_,_listVtnCatalogoDatos_) {
				var idItem = $(_listVtnCatalogoDatos_).attr("id");
				$('#'+idItem+' #fila'+numFila_).remove();
				numFila_--;
				$('#contadorList').val('');
				$('#contadorList').val(numFila_);				
			} 

			var agregarItemSelect = function(_idVtnM_,_vtnCatalogoDatos_,_idControlCount_,_btnAdd_,_nombreCampo_,_tabla_,_columna_) {
			  	////////////////////////////////////////////////////////
			  	var llegoLimtie=0;
		  		$('#'+_btnAdd_).attr("disabled", true);
			  	// -> Validando si se desabilita o no el boton de agregar
				$('#'+_idControlCount_).html('');
			  	nucleo.cargarListaDespegablePublic(_idControlCount_,_tabla_);
					setTimeout(function(){ 

					  	var limiteItems = $('#'+_idControlCount_+' option').length;
					  	var itemsGuardados = $('#'+_vtnCatalogoDatos_+' input.lista-control').length;
					  	var itemsGuardar = $('#'+_vtnCatalogoDatos_+' select').length;
					  	var itemsLista=itemsGuardados+itemsGuardar;
					  	var itemAgregando=1;

					  	itemsLista=itemsLista+itemAgregando;
					  	// si el algoritmo dice que al agregar el siguiente llega al limite 
					  	// SE DESABILITA EL BOTON DE AGREGAR
					  	if (limiteItems==itemsLista || limiteItems<itemsLista) {
					  		llegoLimtie=1;
					  	}
					  	////////////////////////////////////////////////////////
						var numFila=0;
						$('#'+_idVtnM_+' #'+_vtnCatalogoDatos_+' select.lista-control' ).each(function (index, datoItem) {
							numFila=0;
							var idItem_ = $(datoItem).attr("id");
							numFila = $('#'+idItem_).data('numerofila');
						});
						numFila=numFila+1;


						var titleList = "";
						if (numFila==1) {

							titleList = $('');

						};

						tr = $('<div  class="row fila'+numFila+'" id="fila'+numFila+'" data-idfila="fila'+numFila+'" style="padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #ddd; border-bottom: 0px solid #ddd;"  > ');			
							td1 = $('<div  class="col-md-8"> ');
				    			td101 = $('<select    id="'+_nombreCampo_+numFila+'" class=" selectpicker lista-control " data-show-subtext="true" data-live-search="true" data-numerofila='+numFila+' data-select="1">'+
										   '</select>'
										 );
									//name="'+_nombreCampo_+' '+numFila+'"  data-numerofila="'+numFila+'"		    			
								td1.append(td101);
							td1.append('</div>');
							tr.append(td1);
							td2 = $('<div  class="col-md-4"  >');
								td202 = $("<button type='button' class='fila-control btn btn-default ' "+
											" onclick='listas.borrarItemSelectPublic("+numFila+","+_vtnCatalogoDatos_+","+_btnAdd_+")' "+
											" style='width: 100%;padding: 6px 12px;' "+
											" id='btnRemoverItem' data-numerofila='"+numFila+"' "+
											" >X</button> ");		
								td2.append(td202);
							td2.append('</div> ');
							tr.append(td1);
							tr.append(td2);
						tr.append("</div>");

						$('#'+_idVtnM_+' #'+_vtnCatalogoDatos_+'').append(titleList);
						$('#'+_idVtnM_+' #'+_vtnCatalogoDatos_+'').append(tr);

						var iditemSelect_ = _nombreCampo_+numFila;

						//refrescar item
					  	nucleo.cargarListaDespegableListasPublic(iditemSelect_,_tabla_,_nombreCampo_);
							$('#'+iditemSelect_).popover({
							    html: true, 
								placement: "right",
								content: function() {
							          return $('#procesandoDatosInput').html();
							        }
							});
							$('#'+iditemSelect_).popover('show');
						    setTimeout(function(){ 
						    	//actualiza el elemento recien agregado
							  	$('#'+iditemSelect_).selectpicker('refresh');
							  	// validad la lista, junto al nuevo elemento agregado
								listas.validarPresenciaListaDatoPublic(_vtnCatalogoDatos_,0,0,0,0);
								// -- SE LE AÑADE FUNCONALIDADES -- AL BOTON del elemento
								$('#fila'+numFila+' .bootstrap-select button').on('click',  function(e){
									valorAnteriorSelec = $('#'+iditemSelect_).val();
									$('#'+iditemSelect_).on('change',function (argument) {
										//id actualmente seleccionado
										//alert(valorAnteriorSelec);
										//nuevo id seleccionado
										//alert($('#'+iditemSelect_).val());
										var nuevaSeleccion_ = $('#'+iditemSelect_).val();

										listas.validarPresenciaListaDatoPublic(_vtnCatalogoDatos_,1,iditemSelect_,valorAnteriorSelec,nuevaSeleccion_);

									    $('#'+_idVtnM_+' #listas .bootstrap-select ').each(function (index, datoItem) {
											//$('#fila'+index+' .bootstrap-select').attr('style','width:100%;');								
									    });
									});

								});

								numFila=0;
								// quita el popover en el que muestra el cargar						
				            	$('#'+iditemSelect_).popover('destroy');

				            	//////////////
							  	if (llegoLimtie==1) {
							  		$('#'+_btnAdd_).attr("disabled", true);
							  	}else{
							  		$('#'+_btnAdd_).attr("disabled", false);
							  		$('#'+_btnAdd_).removeAttr("disabled");
							  	}				            	
						    }, 300);
					}, 300);			
			}

			var agregar2ItemSelect = function(_idVtnM_,_vtnCatalogoDatos_,_idControlCount_,_btnAdd_,_nombreCampo_,_tabla_,_columna_,_nombreCampo2_,_tabla2_,_columna2_) {
			  	////////////////////////////////////////////////////////
			  	var llegoLimtie=0;
		  		$('#'+_btnAdd_).attr("disabled", true);
			  	// -> Validando si se desabilita o no el boton de agregar
				$('#'+_idControlCount_).html('');
			  	nucleo.cargarListaDespegablePublic(_idControlCount_,_tabla_);
					setTimeout(function(){ 

					  	var limiteItems = $('#'+_idControlCount_+' option').length;
					  	var itemsGuardados = $('#'+_vtnCatalogoDatos_+' input.lista-control').length;
					  	var itemsGuardar = $('#'+_vtnCatalogoDatos_+' select.lista-control').length;
					  	var itemsLista=itemsGuardados+itemsGuardar;
					  	var itemAgregando=1;

					  	itemsLista=itemsLista+itemAgregando;
					  	// si el algoritmo dice que al agregar el siguiente llega al limite 
					  	// SE DESABILITA EL BOTON DE AGREGAR
						//console.log('limiteItems : '+limiteItems+' ==  itemsLista:'+itemsLista+'  || limiteItems : '+limiteItems+' < itemsLista '+itemsLista);					  	
					  	if (limiteItems==itemsLista) {
					  		//console.log('limiteItems : '+limiteItems+' ==  itemsLista:'+itemsLista+'  || limiteItems : '+limiteItems+' < itemsLista '+itemsLista);
					  		llegoLimtie=1;
					  	}
					 	if (limiteItems==itemsLista || limiteItems<itemsLista) {
					  		llegoLimtie=1;
					  	}					  	
					  	////////////////////////////////////////////////////////
						var numFila=0;
						$('#'+_idVtnM_+' #'+_vtnCatalogoDatos_+' select.lista-control' ).each(function (index, datoItem) {
							numFila=0;
							var idItem_ = $(datoItem).attr("id");
							numFila = $('#'+idItem_).data('numerofila');
						});
						numFila=numFila+1;

						var titleList = "";
						if (numFila==1) {

							titleList = $('<div class="row" id="titleList">'+
												'<br>'+
												'<hr>'+
												'<div class="col-md-12" style="text-align: center;">'+
													'<b>'+
														'Seleccione un departemento y un cargo : '+
													'</b>'+										
												'</div>'+
												'<br>'+
												'<hr>'+
											'</div>');

						};

						tr = $('<div  class="row fila'+numFila+'" id="fila'+numFila+'" data-idfila="fila'+numFila+'" style="padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #ddd; border-bottom: 0px solid #ddd;"  > ');			
							td0 = $('<div  class="col-md-5"> ');
				    			td001 = $('<select    id="'+_nombreCampo_+numFila+'" class=" selectpicker lista-control " data-tipoCampo="'+_nombreCampo_+'" data-show-subtext="true" data-live-search="true" data-numerofila='+numFila+' data-select="1">'+
										   '</select>'
										 );
									//name="'+_nombreCampo_+' '+numFila+'"  data-numerofila="'+numFila+'"		    			
								td0.append(td001);
							td0.append('</div>');

							td1 = $('<div  class="col-md-5"> ');
				    			td101 = $('<select    id="'+_nombreCampo2_+numFila+'" class=" selectpicker " data-tipoCampo="'+_nombreCampo2_+'" data-show-subtext="true" data-live-search="true" >'+
										   '</select>'
										 );
									//name="'+_nombreCampo_+' '+numFila+'"  data-numerofila="'+numFila+'"		    			
								td1.append(td101);
							td1.append('</div>');


							td2 = $('<div  class="col-md-2"  >');
								td202 = $("<button type='button' class='fila-control btn btn-default ' "+
											" onclick='listas.borrarItemSelectPublic("+numFila+","+_vtnCatalogoDatos_+","+_btnAdd_+")' "+
											" style='width: 100%;padding: 6px 12px;' "+
											" id='btnRemoverItem' data-numerofila='"+numFila+"' "+
											" >X</button> ");		
								td2.append(td202);
							td2.append('</div> ');

							tr.append(td0);
							tr.append(td1);
							tr.append(td2);
						tr.append("</div>");

						$('#'+_idVtnM_+' #'+_vtnCatalogoDatos_+'').append(titleList);
						$('#'+_idVtnM_+' #'+_vtnCatalogoDatos_+'').append(tr);

						var iditemSelect_ = _nombreCampo_+numFila;


						var id2itemSelect_ = _nombreCampo2_+numFila;

						//refrescar item
					  	nucleo.cargarListaDespegableListasPublic(iditemSelect_,_tabla_,_nombreCampo_);
					  	nucleo.cargarListaDespegableListasPublic(id2itemSelect_,_tabla2_,_nombreCampo2_);

							$('#'+iditemSelect_).popover({
							    html: true, 
								placement: "right",
								content: function() {
							          return $('#procesandoDatosInput').html();
							        }
							});
							$('#'+iditemSelect_).popover('show');


							$('#'+id2itemSelect_).popover({
							    html: true, 
								placement: "right",
								content: function() {
							          return $('#procesandoDatosInput').html();
							        }
							});
							$('#'+id2itemSelect_).popover('show');



						    setTimeout(function(){ 
						    	//actualiza el elemento recien agregado
							  	$('#'+iditemSelect_).selectpicker('refresh');
							  	$('#'+id2itemSelect_).selectpicker('refresh');

							  	// validad la lista, junto al nuevo elemento agregado
								listas.validarPresenciaListaDatoPublic(_vtnCatalogoDatos_,0,0,0,0);
								// -- SE LE AÑADE FUNCONALIDADES -- AL BOTON del elemento
								$('#fila'+numFila+' .bootstrap-select button').on('click',  function(e){
									valorAnteriorSelec = $('#'+iditemSelect_).val();
									$('#'+iditemSelect_).on('change',function (argument) {
										//id actualmente seleccionado
										//alert(valorAnteriorSelec);
										//nuevo id seleccionado
										//alert($('#'+iditemSelect_).val());
										var nuevaSeleccion_ = $('#'+iditemSelect_).val();

										listas.validarPresenciaListaDatoPublic(_vtnCatalogoDatos_,1,iditemSelect_,valorAnteriorSelec,nuevaSeleccion_);

									    $('#'+_idVtnM_+' #listas .bootstrap-select ').each(function (index, datoItem) {
											//$('#fila'+index+' .bootstrap-select').attr('style','width:100%;');								
									    });
									});

								});

								numFila=0;
								// quita el popover en el que muestra el cargar						
				            	$('#'+iditemSelect_).popover('destroy');
				            	$('#'+id2itemSelect_).popover('destroy');
	
				            	//////////////
							  	if (llegoLimtie==1) {
							  		$('#'+_btnAdd_).attr("disabled", true);
							  	}else{
							  		$('#'+_btnAdd_).attr("disabled", false);
							  		$('#'+_btnAdd_).removeAttr("disabled");
							  	}				            	
						    }, 300);
					}, 300);			
			}
			var borrarItemSelect = function(numFila_,_vtnCatalogoDatos_,_btnAdd_) {
					var idItem = $(_vtnCatalogoDatos_).attr("id");
					var idBtnAdd = $(_btnAdd_).attr("id");

					setTimeout(function(){ 
						// validad la lista, junto al elemento a eliminar
						var valorBorrarSeleccionado = $("#"+idItem+" #fila"+numFila_+" select option:selected").val();
						//alert(valorBorrarSeleccionado);
						if (valorBorrarSeleccionado!=0){
							$("#"+idItem+" option[value="+valorBorrarSeleccionado+"]").attr("disabled",false);
							$("#"+idItem+" option[value="+valorBorrarSeleccionado+"]").removeAttr("disabled");			
							$("#"+idItem+" select").selectpicker('refresh');
						};
						$('#'+idItem+' #fila'+numFila_).remove();
				  		$('#'+idBtnAdd).attr("disabled", false);
				  		$('#'+idBtnAdd).removeAttr("disabled");

					}, 300);

					var cantItemsList = $('#listas #'+idItem+' div div select.lista-control').length;
					if (cantItemsList <= 1 ) {

						$('#'+idItem+' #titleList').remove();

					}
			} 
			var validarPresenciaListaDato = function(_vtnCatalogoDatos_,_cambioSeleccion_,_idItemSelectClick_,_anteriorSeleccion_,_nuevaSeleccion_) {
				//alert('accion validadoe');
				// hay input en la lista.?
				if ($('#listas #'+_vtnCatalogoDatos_+' div div input.lista-control').length>0) {
					// revisar todos los input de la lista
					$('#listas #'+_vtnCatalogoDatos_+' div div input.lista-control').each(function (index, datoItem){
						//obtener id de input
						var idRevision = $(datoItem).attr('id');
							/////////////////////////////////////////////
							//Se revisan todos los select de la lista
							if ($('#listas #'+_vtnCatalogoDatos_+' div div select.lista-control').length>0){
								$('#listas #'+_vtnCatalogoDatos_+' div div select.lista-control').each(function (index3, datoItemSelect){
							
									//alert('select :'+index3);	
									// se obtiene el ide del select que se revisara
									var idItemSelect = $(datoItemSelect).attr('id');
									// es un cambio de seleccion?
									if (_cambioSeleccion_==1){
										//console.log(_idItemSelectClick_+' != '+idItemSelect);
				      						//};
				      					// si es el item en el que re realiza la accion -> ejecuta el procedimiento
										if (_idItemSelectClick_==idItemSelect) {										
											// si el id anterior es nulo -> no hay que desactivar algo no selecionado
											//if (_anteriorSeleccion_=!null) {
												// se activa la seleccion anterior en todos select
				      							$("#"+idItemSelect+" option[value="+_anteriorSeleccion_+"]").attr("disabled",false);
				      							$("#"+idItemSelect+" option[value="+_anteriorSeleccion_+"]").removeAttr("disabled");
				      						//};
				      					};	
				      					// si es el item en el que re realiza la accion -> no te ejecuta el procedimiento
										if (_idItemSelectClick_!=idItemSelect) {
				      						// se desactiva la nueva seleccion en todos los select
				      						$('#'+idItemSelect+' option[value='+_nuevaSeleccion_+']').attr("disabled",true);				
											//Se refresca el select para poder apreciar cambios
										};
											$('#'+idItemSelect).selectpicker('refresh');

			      					}else{
										// se recorre los elementos option dentro del select de actual ciclo
										$('#listas #'+_vtnCatalogoDatos_+' div div select#'+idItemSelect+' option').each(function (index4, datoItemOption){
											//alert('option :'+index4);	
											//se obtiene el valor del option( el valor del 'value' es el ID de la tabla en revision )
											var adisabled = $(datoItemOption).val();
											//es el elemento que ya esta en la lista.?
											if (idRevision==adisabled){
												//se bloquea 
												$(datoItemOption).attr("disabled",true);
												//Se refresca el select para poder apreciar cambios
												$('#'+idItemSelect).selectpicker('refresh');
											};

										});
									};
								});	
							};	
							/////////////////////////////////////////////
						
					});

				};
				// hay select en la lista.?
				if ($('#listas #'+_vtnCatalogoDatos_+' div div select.lista-control').length>0) {
					// revisar todos los select de la lista
					$('#listas #'+_vtnCatalogoDatos_+' div div select.lista-control').each(function (index, datoItem){
						//obtener id en el select por medio del VALUE
						var idItemRevision = $(datoItem).attr('id');
						var idRevision = $('#'+idItemRevision).val();

							/////////////////////////////////////////////
							//Se revisan todos los select de la lista
							if ($('#listas #'+_vtnCatalogoDatos_+' div div select.lista-control').length>0){						
								$('#listas #'+_vtnCatalogoDatos_+' div div select.lista-control').each(function (index, datoItemSelect){
									// se obtiene el ide del select
									var idItemSelect = $(datoItemSelect).attr('id');
									// es un cambio de seleccion?
									if (_cambioSeleccion_==1){
										//console.log(_idItemSelectClick_+' != '+idItemSelect);
										if (_idItemSelectClick_!=idItemSelect) {


											// se activa la seleccion anterior en todos select
				      						$("#"+idItemSelect+" option[value="+_anteriorSeleccion_+"]").attr("disabled",false);
				      						$("#"+idItemSelect+" option[value="+_anteriorSeleccion_+"]").removeAttr("disabled");
				      						// se desactiva la nueva seleccion en todos los select
				      						$('#'+idItemSelect+' option[value='+_nuevaSeleccion_+']').attr("disabled",true);				
											//Se refresca el select para poder apreciar cambios
											$('#'+idItemSelect).selectpicker('refresh');
										

										};
			      					}else{
										// se recorre los elementos option dentro del select de actual ciclo
										$('#listas #'+_vtnCatalogoDatos_+' div div select#'+idItemSelect+' option').each(function (index4, datoItemOption){
											var seleccionActualSelect = $('#'+idItemSelect).val();	
											//se obtiene el valor del option( el valor del 'value' es el ID de la tabla en revision )
											var adisabled = $(datoItemOption).val();
											//es el elemento que ya esta en la lista.?
											// Y - si no es el select donde esta seleccionado ->  se procede
											if (idRevision==adisabled  && seleccionActualSelect!=adisabled){


												//se bloquea 
												$(datoItemOption).attr("disabled",true);
												//Se refresca el select para poder apreciar cambios
												$('#'+idItemSelect).selectpicker('refresh');
											};

										});
									};
								});
							};		
							/////////////////////////////////////////////


					});

				};

			}








			return{
					Iniciar : function() {

						console.log(" -- Finalizando carga de lista");
					},
					agregarItemInputPublic : agregarItemInput,
					agregarItemSelectPublic : agregarItemSelect,
					agregar2ItemSelectPublic : agregar2ItemSelect,
					borrarItemInputPublic : borrarItemInput,
					borrarItemSelectPublic : borrarItemSelect,
					validarPresenciaListaDatoPublic : validarPresenciaListaDato,

			}

	}(); 