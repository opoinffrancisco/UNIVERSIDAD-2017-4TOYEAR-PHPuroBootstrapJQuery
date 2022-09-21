	
	

		<!-- Panel de Ventana modal-->
		<div id="vtnCambiarSoftware" class="panel panel-primary ventana-modal-panel-mediano-sintop panel-vtn-content-datos">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar cambio de software
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
					<input type="text" id="datoControlIdEquipoCambio" value="" style="display:none;"></input>
					<input type="text" id="datoControlIdCambio" value="" style="display:none;"></input>
					<div  class="row">

							<form id="formADD" method="POST" >		

											<div  class="row">
												<label> Software actual </label>
												<div class="col-md-12">
													<div class="row">
														<div class="col-md-12">

															<div class="row">
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="1">Nombre</label>
																	    <input type="text" class="form-control input-sm" id="nombrextActual" disabled="TRUE">
																	</div>											
																</div>				
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="1">Versión</label>
																	    <input type="text" class="form-control input-sm" id="versionxtActual" disabled="TRUE">
																	</div>												
																</div>																					
															</div>

															<div class="row">

																<div class="col-md-6">
																	<div class="form-group">
																		<label for="1">Tipo</label>
																	    <input type="text" class="form-control input-sm" id="tipotxtActual" disabled="TRUE">
																	</div>																						
																</div>	
																<div class="col-md-6">
																	<div class="form-group">
																		<label for="1">Distribucion</label>
																	    <input type="text" class="form-control input-sm" id="distribucionTxtActual" disabled="TRUE">
																	</div>					
																</div>						
															</div>
														</div>								
							
													</div>
																		
												</div>
												
											</div>
							</form>
									
					</div>
					<hr>

								<div class="row">
									<div class="col-md-12" >
										<b>
										 	Se cambiara el software actual :
										</b>
									</div>
								</div>				

						<div class="row" style="padding: 0px 15px 0px 15px;" id="panel-acciones-mantenimiento">
							<div class="col-md-12" style="border: 1px solid white;margin-left: 0px;padding: 0px;background: #FFFFFF;">

								<input type="text" id="datoControlADD" value="" style="display:none;"></input>
								<input type="text" id="datoControlIdADD" value="" style="display:none;"></input>
								<input type="text" id="datoControlIdCaractADD" value="" style="display:none;"></input>					
								<br>
								<div  class="row">
									<div class="col-md-3">							
											<label for="Tipo" style="color:#000;" >Filtrar por nombre :</label>					
										  	<div id="divBuscadorTxt" class="form-group">
												<div class="input-group">
												  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
												  <span class="input-group-addon" id="sizing-addon2" >Buscar</span>
												  <input type="text" maxlength="30" min="1" class="form-control filtro_1" id="buscardorTxt" placeholder="Ingresar nombre" aria-describedby="sizing-addon2"

												  onkeyup="

														mtdEquipo.cargarListaCaracteristicasSoftwarePublic(1);
												  "

												  >
												</div>
											</div>
											<label for="Tipo" >Filtrar por tipo : </label>							  
										  	<div id="divTipoListD" class="form-group">
											    <select  id="btipoListD" class="filtro_2 selectpicker lista-control " data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >								
													<option data-subtext="" value="0">No hay datos</option>								   		
											   	</select>
											</div>	
											<div id="div-btn-admin" class="form-group">
												<a href="javascript:;" onclick="ventanaModal.mostrarPulico('ventana-modal', datosIdsTabs=['scroll','no'])">
												    <button type="button" class="btn btn-default btn-cfg-admin" id="btnNuevo-admin"  style="width: 100%;"
																	onclick="ventanaModal.cambiaMuestraVentanaModalCapaAdminPublic(
																			'vtnProcsEquipoConsulta',
																			'administracion #ventana-modal-cfg',
																			'configuracion/gestionCaracteristicasSoftware/ventanasModales/vtnMGestionCaracteristicasSoftware.php',
																			1
																	)"
												    >
												  		Agregar nuevas caracteristicas
												  	</button>
												</a>
											</div>											
											<b>
												Seleccionar características
											</b>		
											<div id="pgnListCaracteristicasSoftware">
													<div id="pagination">
														
													</div>
											</div>	
											<div id="listGestionCaractSoftware" class="list-group" style="FONT-SIZE: smaller;">
												
												<button type="button" class="list-group-item">MOUSE - CANAIMA - ID3-DSDS</button>

											</div>							
											<div id="pgnListCaracteristicasSoftware">
													<div id="pagination">
														
													</div>
											</div>	
									</div>
									<div class="col-md-9">
										<div class="row">
											<div class="col-md-12">
												<b>
													Detalles de las características
												</b>
									
												<div class="row">
													<div class="col-md-6">											
														<div class="form-group">
														    <label for="1">Nombre : </label>
														    <input type="text" class="form-control" id="nombretxt" disabled="TRUE">
														</div>											
													</div>				
													<div class="col-md-6">
														<div class="form-group">
															<label for="1">Versión : </label>
														    <input type="text" class="form-control" id="versiontxt" disabled="TRUE">
														</div>																						
													</div>																					
												</div>

												<div class="row">
													<div class="col-md-6">
														<div class="form-group">
															<label for="1">Tipo : </label>
														    <input type="text" class="form-control" id="tipotxt" disabled="TRUE">
														</div>											
													</div>				
													<div class="col-md-6">
														<div class="form-group">
															<label for="1">Distribucion : </label>
														    <input type="text" class="form-control" id="distribuciontxt" disabled="TRUE">
														</div>												
													</div>																					
												</div>
											</div>				
											<hr>

											<div class="row">

											    <div class="col-md-12"  style="background-color:#fff">

													<div class="row">
														<div class="col-md-8">
															<b>
															Observacion del porque el cambio :
															</b>
														</div>
													</div>
													<div  class="row">
														<div class="col-md-12">
													
													    	<textarea type="text" name="observación" class="campo-control form-control input-sm textarea" id="observacionTxt" placeholder="Ingresar observación" 
													    		onblur="nucleo.validadorPublic()" 
													  			onkeyup="nucleo.verificarDatosPublic('','','observacionTxt','')"
													  			rows="10" 
													    		data-cantmax="255" maxlength="255" data-cantmin="15" data-vexistencia="0" 
													    		data-solonumero="0" data-sololetra="0" data-sololetrayespacio="0" data-descripcion="1" data-vcorreo="0" required="true" > El software actual esta desactualizado
													  		</textarea>		

														</div>					
													</div>
													<hr>
													<div class="row">
														<div class="col-md-2 col-md-offset-10">
													      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
													  	  	<div id="divDetalles" class="form-group">								
																<a href="javascript:;" onclick="">
																    <button type="button" class="btn btn-default" onclick="mtdMantenimientoEquipo.guardarCambioSoftwarePublic();" >
																    <!-- disabled="false" -->
																  		Guardar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
																  	</button>
																</a>	
															</div>	
														</div>		
													</div>			



												</div>

											</div>																								
										</div>

									</div>
									
								</div>



							</div>							
						</div>



												
				</form>
				<?php 

					include '../../../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>

<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
	mtdEquipo.anadirSoftwarePublic();
	mtdEquipo.cargarListaCaracteristicasSoftwarePublic(1);

  	nucleo.cargarListaDespegableListasPublic('btipoListD','cfg_c_logc_tipo','');

	$('#btipoListD').popover({
	    html: true, 
		placement: "right",
		content: function() {
	          return $('#procesandoDatosInput').html();
	        }
	})

	$('#btipoListD').popover('show');

    setTimeout(function(){ 

    	$('#btipoListD').popover('destroy');

	  	$('#btipoListD').selectpicker('refresh');

        $('#ctlgCaracteristicasPerifericos #btnSelectElegido0').attr('style','width:100%;');

    }, 300);


	$(document).ready(function() {

		$('#btipoListD').on('change',function () {
		
			mtdEquipo.cargarListaCaracteristicasSoftwarePublic(1);

		});

	  	$('#btipoListD').selectpicker('refresh');

	    $('#ctlgCaracteristicasPerifericos #listas .bootstrap-select ').each(function (index, datoItem) {

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



</script>
















