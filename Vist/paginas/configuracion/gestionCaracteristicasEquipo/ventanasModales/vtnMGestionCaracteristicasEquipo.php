	

		<!-- Panel de Ventana modal-->
		<div id="vtnCaracteristicasEquipos" class="panel panel-primary ventana-modal-panel-grande ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar las carácteristicas de equipo
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCaracteristicasEquipos.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div class="row">
						    <div class="col-md-7 col-md-offset-1">
								<h5>
									Carácteristicas fisicas para gestionar el equipo :
								</h5>
							</div>
						</div>
						<div id="listas">													
							<div class="row">
							  <div class="col-md-5 col-md-offset-1">
   							      <label for="recurso">Marca:</label>							  
							  	  	<div id="divMarcaListD" class="form-group">
								    	<select  id="marcaListD" class="select campo-control selectpicker lista-control " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true" 
								    	 >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>				  	
							  </div>
							  <div class="col-md-5 col-md-offset-0">
   							      <label for="recurso">Modelo:</label>							  
							  	  	<div id="divModeloListD" class="form-group">
								    	<select  id="modeloListD" class="select campo-control selectpicker lista-control lista-control-change" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
								    	data-content-popover="divModeloListD"
									    data-tabla-form="cfg_caracteristicas_fisc_eq" 
									    data-tabla-campo="cfg_c_fisc_modelo"
										data-columna-campo="id_modelo_fisc" 	>
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>						  	
							  </div>							  
							</div>
							<div class="row">
								<div class="col-md-5 col-md-offset-1">

									<div class="row">
									  <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;" >
		   							      <label for="recurso">Tipo : </label>							  
									  	  	<div id="divTipoListD" class="form-group">
										    	<select  id="tipoListD" class="select campo-control selectpicker lista-control lista-control-change" data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"   
										    	data-content-popover="divTipoListD"
											    data-tabla-form="cfg_caracteristicas_fisc_eq" 
											    data-tabla-campo="cfg_c_fisc_tipo"
												data-columna-campo="id_tipo_fisc" >								
													<option data-subtext="" value="0">No hay datos</option>								   		
										   		</select>
										  	</div>					  	
									  </div>							  
									</div>	

								</div>
								<div class="col-md-6">
									<div class="col-md-12 col-md-offset-0" style="padding-left: 5px;">
									  	 	<!--
									  	 	<label for="recurso">Interfaz:</label>	
									  	 	<div id="divInterfazListD" class="form-group">
										    	<select  id="interfazListD" class="selectpicker lista-control " data-show-subtext="true" data-live-search="true"  >
										   		</select>
										  	</div>	
										  	-->		
										  	<!--/////////////////////////////////////////////////////////////////////-->


											<div id="listas">
									    
											    <div class="col-md-12" style="padding-left: 0px;padding-right: 0px;">
													<div class="form-group">
												    	<label for="recurso">Interfaces:</label>	
																	<div>
																		<button
																			id="btnAgregarInterfaz" type="button" class="btn btn-default" 
																			style=" width: 60%; margin-left: 20%; margin-right: 20%;"
																			onclick="listas.agregarItemSelectPublic('vtnCaracteristicasEquipos','vtnCatalogoDatosCEquipos','selectCEquiposInterfaz','btnAgregarInterfaz','equipo','cfg_c_fisc_interfaz_conexion','nombre')" >
																			Agregar Interfaz
																		</button>
																	</div>	
																	<br>												    	
														<div class="table table-hover " style="background-color:#fff; overflow-y: auto;height: 300px; ">
															<div id="vtnCatalogoDatosCEquipos" class="catalogo-datos" style=""> 
										 					<!-- Resultados de Datos -->
																<!--Items de Resultados guardados-->
																<div id="resultadosGuardados">
																	
																</div>
																<!--Items No noguardados-->
															</div>
														</div>
														<div>
															<div  class="row"  style="padding-top: 5px; padding-bottom: 5px; border-top: 1px solid #ddd; border-bottom: 0px solid #ddd;"  >
																<div  class="col-md-12">
																	<div id="conteoLimiteItems" style="display:none;">
																		<select id="selectCEquiposInterfaz" ></select>
																	</div>

																</div> 
															</div> 
														</div>  
													</div>
												</div>								
											</div>



											<!--
												NOTA:
														alert(   $('#listas #vtnCatalogoDatosCEquipos div div select#equipo4').val() );												

											-->


											<!--/////////////////////////////////////////////////////////////////////-->
									</div>
								</div>
							</div>												
						</div>					


		  		<button type="submit" id="btnGuardarFloatR" class="btn btn-default" 
					style="position: fixed; z-index: 99; float: right; right: 2%; bottom: 5%;"
		  		>Guardar</button>

	
				</form>
				<?php 

					include '../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
		$(document).ready(function () {
	
			mtdCaracteristicasEquipos.Iniciar();
			
			if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==false) {
				mtdCaracteristicasEquipos.cargarCatalogoPublic(1);	
				nucleo.asignarPermisosBotonesPublic(26);
			}		

		});
				

	$(document).ready(function() {

		//refrescar item
	  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','marca');
	  	//nucleo.cargarListaDespegableListasPublic('modeloListD','cfg_c_fisc_modelo','modelo');
	  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');
	  	nucleo.cargarListaDespegableListasPublic('interfazListD','cfg_c_fisc_interfaz_conexion','interfaz');

		$('#marcaListD').popover({
		    html: true, 
			placement: "right",
			content: function() {
		          return $('#procesandoDatosInput').html();
		        }
		})
		/*
		$('#modeloListD').popover({
		    html: true, 
			placement: "right",
			content: function() {
		          return $('#procesandoDatosInput').html();
		        }
		});
		*/
		$('#tipoListD').popover({
		    html: true, 
			placement: "right",
			content: function() {
		          return $('#procesandoDatosInput').html();
		        }
		});	
		$('#interfazListD').popover({
		    html: true, 
			placement: "right",
			content: function() {
		          return $('#procesandoDatosInput').html();
		        }
		});											

    	$('#marcaListD').popover('show');
	  	$('#modeloListD').popover('show');
	  	$('#tipoListD').popover('show');
	  	$('#interfazListD').popover('show');

	    setTimeout(function(){ 

        	$('#marcaListD').popover('destroy');
		  	//$('#modeloListD').popover('destroy');
		  	$('#tipoListD').popover('destroy');
		  	$('#interfazListD').popover('destroy');

		  	$('#marcaListD').selectpicker('refresh');
		  	//$('#modeloListD').selectpicker('refresh');
		  	$('#tipoListD').selectpicker('refresh');
		  	$('#interfazListD').selectpicker('refresh');

	        $('#btnSelectElegido0').attr('style','width:100%;');
	        $('#btnSelectElegido1').attr('style','width:100%;');
	        $('#btnSelectElegido2').attr('style','width:100%;');
	        $('#btnSelectElegido3').attr('style','width:100%;');


	    }, 300);



	  	$('#marcaListD').selectpicker('refresh');
	  	$('#modeloListD').selectpicker('refresh');
	  	$('#tipoListD').selectpicker('refresh');
	  	$('#interfazListD').selectpicker('refresh');

		nucleo.verificarExistenciaSelectPublic('vtnCaracteristicasEquipos');

	});


</script>
