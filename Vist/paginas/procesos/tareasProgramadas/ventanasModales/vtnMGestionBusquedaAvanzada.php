	

		<!-- Panel de Ventana modal-->
		<div id="vtnProcsBusqdAvanzd" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Seleccionar datos para filtrar
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<div id="listas">													
		
							<div class="row">
								<div class="col-md-6">
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="1">Serial</label>
												    <input type="text" class="form-control input-sm" id="serialTxt" placeholder="Ingresar serial">
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-md-12">
												<div class="form-group">
													<label for="1">Serial bien nacional:</label>
												    <input type="text" class="form-control input-sm" id="serialBienNTxt" placeholder="Ingresar serial bien nacional">
												</div>																						
											</div>																					
										</div>		

										<div class="row">
										  	<div class="col-md-12 col-md-offset-0">
			   							      	<label for="recurso">Tipo de equipo:</label>							  
										  	  	<div id="divTipoListD" class="form-group">
											    	<select  id="tipoListD" class="select campo-control selectpicker lista-control" data-select="1" name="Tipo" data-show-subtext="true" data-live-search="true"  >
														<option data-subtext="" value="0">No hay datos</option>								   		
											   		</select>
											  	</div>						  	
										  	</div>							  
										</div>

										<div class="row">
											  <div class="col-md-12 col-md-offset-0">
				   							      <label for="recurso">Marca:</label>							  
											  	  	<div id="divMarcaListD" class="form-group">
												    	<select  id="marcaListD" class="select campo-control selectpicker lista-control " data-select="1" name="" data-show-subtext="true" data-live-search="true"  >
															<option data-subtext="" value="0">No hay datos</option>								   		
												   		</select>
												  	</div>				  	
											  </div>
										</div>
										<div class="row">	
											  <div class="col-md-12 col-md-offset-0">
				   							      <label for="recurso">Modelo:</label>							  
											  	  	<div id="divModeloListD" class="form-group">
												    	<select  id="modeloListD" class="select campo-control selectpicker lista-control" data-select="1" name="" data-show-subtext="true" data-live-search="true"  >
															<option data-subtext="" value="0">No hay datos</option>								   		
												   		</select>
												  	</div>						  	
											  </div>							  
										</div>
								</div>
								<div class="col-md-6">




							<div class="row">
								<div class="col-md-12">
									<div class="form-group">
										<label for="1">Cédula de persona encargada:</label>
									    <input type="number" class="form-control input-sm" id="cedulaTxt" placeholder="Ingresar cedúla">
									</div>																					
								</div>																												
							</div>

							<div class="row">		
								<div class="col-md-12">
   					      			<label for="recurso">Cargo:</label>							  
							  	  	<div id="divCargoListD" class="form-group">
								    	<select  id="cargoListD" class="select campo-control selectpicker lista-control" data-select="1" name="" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>
								</div>		
							</div>
							<div class="row">			
								<div class="col-md-12">
   							      <label for="recurso">Departamento:</label>							  
							  	  	<div id="divDepartamentoListD" class="form-group">
								    	<select  id="departamentoListD" class="select campo-control selectpicker lista-control" data-select="1" name="" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>																							
								</div>			
							</div>
							<hr>
							<div class="row">			
								<div class="col-md-12">
   							      <label for="recurso">Tareas programas:</label>							  
							  	  	<div id="divTareasProgramadasListD" class="form-group">
								    	<select  id="tareaListD" class="select campo-control selectpicker lista-control" data-select="1" name="" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>																							
								</div>			
							</div>



								</div>								
							</div>								
<!--/////////////////////////////////////////////////////-->


							<div class="row">
								<div class="col-md-2 col-md-offset-10"  >

									<a href="javascript:;" onclick="mtdTareaProgramada.cargarCatalogoPublic(1);">
									    <button type="button" class="btn btn-default" id="btnFiltroBA" >
									  		Filtrar
									  	</button>
									</a> 		

								</div>
							</div>																					
						</div>					
				</form>
				<?php 

					include '../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">

				mtdAsignar.filtrarSelectPublic();
				//refrescar item
			  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','');
			  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','tipo');
			  	nucleo.cargarListaDespegableListasPublic('cargoListD','cfg_pn_cargo','');
			  	nucleo.cargarListaDespegableListasPublic('departamentoListD','cfg_departamento','');
			  	nucleo.cargarListaDespegableListasPublic('tareaListD','cfg_tarea','');

				$('#tareaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#marcaListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				})
				$('#tipoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});	
				$('#cargoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});											
	
				$('#departamentoListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});											

			  	$('#tipoListD').popover('show');	
     			$('#marcaListD').popover('show');
			  	$('#modeloListD').popover('show');
			  	$('#cargoListD').popover('show');
			  	$('#departamentoListD').popover('show');
			  	$('#tareaListD').popover('show');

			    setTimeout(function(){ 

				    $('#tipoListD').popover('destroy');
				    $('#marcaListD').popover('destroy');
				  	$('#cargoListD').popover('destroy');
				  	$('#departamentoListD').popover('destroy');
				  	$('#tareaListD').popover('destroy');

				  	$('#tipoListD').selectpicker('refresh');
				  	$('#marcaListD').selectpicker('refresh');
				  	$('#cargoListD').selectpicker('refresh');
				  	$('#departamentoListD').selectpicker('refresh');
				  	$('#tareaListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');
			        $('#btnSelectElegido4').attr('style','width:100%;');
			        $('#btnSelectElegido5').attr('style','width:100%;');

			    }, 300);


	$(document).ready(function() {

	  	$('#tipoListD').selectpicker('refresh');
	  	$('#marcaListD').selectpicker('refresh');
	  	$('#modeloListD').selectpicker('refresh');
	  	$('#cargoListD').selectpicker('refresh');
	  	$('#departamentoListD').selectpicker('refresh');
	  	$('#tareaListD').selectpicker('refresh');

	});


</script>
