	

		<!-- Panel de Ventana modal-->
		<div id="vtnAsignar" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar asignación 
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<input type="text" id="estadoControlAs" value="" style="display:none;"></input>
						<div id="listas">													
							<div class="row">
								<div id="asignacion" class="col-md-6 col-md-offset-0">

									<div class="row">
										<div class="row">
											<h4>
												<b>
													Equipo de asignación : 
												</b>
											</h4>
										</div>
										<input type="text" class="form-control input-sm" id="idequipoAsTxt" placeholder="" disabled="TRUE" style="display: none;">
		
										<div class="col-md-6 col-md-offset-0">
											<div class="form-group">
												<label for="1">Serial:</label>
												<input type="text" class="form-control input-sm" id="serialAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>
										<div class="col-md-6 col-md-offset-0">
											<div class="form-group">
												<label for="1">Serial de Bien Nacional:</label>
												<input type="text" class="form-control input-sm" id="serialBNAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>	

							 		</div>
									<div class="row">
										<div class="col-md-12 col-md-offset-0">
											<div class="form-group">
												<label for="1">Tipo :</label>
												<input type="text" class="form-control input-sm" id="tipoAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>									
							 		</div>
									<div class="row">
										<div class="col-md-12 col-md-offset-0">
											<div class="form-group">
												<label for="1">Marca y modelo :</label>
												<input type="text" class="form-control input-sm" id="marcaModeloAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>	
										<div class="row">
								  			<div class="col-md-12 col-md-offset-0">
										  		<div class="btn-group" role="group" style="width: 100%;">
													<button type="button" class="btn btn-default" id="btnDesvincularEquipo" onclick="mtdAsignar.desvincularEquipoPublic();" style="width: 100%;">Desvincular equipo</button>
												</div>	
								  			</div>
								  		</div>

							 		</div>	
							 		<hr>						 									 		
							 		<!--PARTE DE DEPARTAMENTO Y CARGO-->
							 		
									<div class="row">
										<div class="row">
											<h4>
												<b>
													Ubicación de asignación : 
												</b>
											</h4>
										</div>									
										<input type="text" class="form-control input-sm" id="idcargoAsTxt" placeholder="" disabled="TRUE" style="display: none;">
										<input type="text" class="form-control input-sm" id="iddepartamentoAsTxt" placeholder="" disabled="TRUE" style="display: none;">
										<div class="col-md-12 col-md-offset-0">
											<div class="form-group">
												<label for="1">Cargo y departamento:</label>
												<input type="text" class="form-control input-sm" id="cargoDepartamentoAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>	
										<div class="row">
								  			<div class="col-md-12 col-md-offset-0">
										  		<div class="btn-group" role="group" style="width: 100%;">
													<button type="button" class="btn btn-default" id="btnDesvincularDepartamentoCargo" onclick="mtdAsignar.desvincularDepartamentoCargoPublic();" style="width: 100%;">Desvincular cargo y departamento</button>
												</div>	
								  			</div>
								  		</div>

							 		</div>

							 		<hr>
							 		<!--PARTE DE PERSONA-->

									<div class="row">
										<div class="row">
											<h4>
												<b>
													Persona de asignación : 
												</b>
											</h4>
										</div>									
										<input type="text" class="form-control input-sm" id="idpersonaAsTxt" placeholder="" disabled="TRUE" style="display: none;">
										<div class="col-md-6 col-md-offset-0">
											<div class="form-group">
												<label for="1">Cedula:</label>
												<input type="text" class="form-control input-sm" id="cedulaAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>
									</div>
									<div class="row">
										<div class="col-md-12 col-md-offset-0">
											<div class="form-group">
												<label for="1">Nombre y apellido:</label>
												<input type="text" class="form-control input-sm" id="nombreApellidoAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>										
							 		</div>
									<div class="row">
										<div class="col-md-12 col-md-offset-0">
											<div class="form-group">
												<label for="1">Correo electrónico:</label>
												<input type="text" class="form-control input-sm" id="correoElectronicoAsTxt" placeholder="" disabled="TRUE">
											</div>	
										</div>	
										<div class="row">
								  			<div class="col-md-12 col-md-offset-0">
										  		<div class="btn-group" role="group" style="width: 100%;">
													<button type="button" class="btn btn-default" id="btnDesvincularPersona" onclick="mtdAsignar.desvincularPersonaPublic();" style="width: 100%;">Desvincular persona</button>
												</div>	
								  			</div>
								  		</div>

							 		</div>

							</div>
							<div id="panel-tabs-agregar" class="col-md-6 col-md-offset-0" style="border-radius: 5px;    border: 1px solid #ccc;  padding: 5px;">

							  <!-- Nav tabs -->
							  <ul class="nav nav-tabs" role="tablist">
							    <li role="presentation" class="active" id="tab-equipo">
							    	<a href="#equipo" aria-controls="equipo" role="tab" data-toggle="tab"
							    		onclick="mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic(1);">
							    		Equipo
							    	</a>
							    </li>
							    <li role="presentation" id="tab-cargodepartamento">
							    	<a href="#cargoDepartamento" aria-controls="cargoDepartamento" role="tab" data-toggle="tab"
							    		onclick="mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic(1);">
							    		Cargo y departamento
							    	</a>
							    </li>
							    <li role="presentation" id="tab-persona">
							    	<a href="#persona" aria-controls="persona" role="tab" data-toggle="tab"
							    		onclick="mtdAsignar.ListarBusqdAvanzdPersonasASIGPublic(1);">
							    		Persona
							    	</a>
							    </li>
							  </ul>

							    <div class="tab-content">
							    <!--PRIMER PANEL TAB-->

							    	 <div role="tabpanel" class="tab-pane active" id="equipo">

		   									<div class="row">
												<div class="col-md-6 col-md-offset-0">
				   									<div class="form-group">
																	<label for="1">Serial</label>
													    <input type="text" class="form-control" id="serialTxt" placeholder="Ingresar serial"
													    onkeyup="mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic(1);">
																</div>	
															</div>
												<div class="col-md-6 col-md-offset-0">														
																<div class="form-group">
																	<label for="1">Serial bien nacional:</label>
																 <input type="text" class="form-control" id="serialBNTxt" placeholder="Ingresar serial bien nacional" onkeyup="mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic(1);">
																</div>	
												</div>
											</div>		

											<div class="row">
												<div class="col-md-6 col-md-offset-0">																											
					   							   <label for="recurso">Marca:</label>							  
												  	  		<div id="divMarcaListD" class="form-group">
													    		<select  id="marcaListD" class="select  selectpicker lista-control " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true"
																				<option data-subtext="" value="0">No hay datos</option>								   		
													   			</select>
													  				</div>
											  	</div>
												<div class="col-md-6 col-md-offset-0">																											

						   							      <label for="recurso">Modelo:</label>							  
													  	  	<div id="divModeloListD" class="form-group">
														    	<select  id="modeloListD" class="select  selectpicker lista-control" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
														    	onchange="	mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic(1);" >
																	<option data-subtext="" value="0">No hay datos</option>								   		
														   		</select>
														  	</div>		
											  	</div>		
										  	</div>		
										  	<div class="row">
												<div class="col-md-12 col-md-offset-0">																											

						   							      <label for="recurso">Tipo:</label>							  
													  	  	<div id="divTipoListD" class="form-group">
														    	<select  id="tipoListD" class="select  selectpicker lista-control" data-select="1" name="" data-show-subtext="true" data-live-search="true"  
														    	onchange="	mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic(1);" >
																	<option data-subtext="" value="0">No hay datos</option>								   		
														   		</select>
														  	</div>
												</div>								  		
										  	</div>  	
										  	<hr>
									  		<div class="row">
									  			<div class="col-md-4 col-md-offset-8">
											  		<div class="btn-group" role="group" style="width: 100%;">
														<button type="button" class="btn btn-default" id="btnAgregarEquipo" onclick="mtdAsignar.agregarEquipoDeListaPublic();" style="width: 100%;">agregar</button>
													</div>	
									  			</div>
									  		</div>
											<br>			

											<div class="catalogo">
												<table id="ctlgProcsEquiposASIG" class="table table-bordered table-hover ">
												 <thead>
												  <tr  class="row">
												   <th  class="col-md-6">Serial y Serial Bien Nacional </th>
												   <th  class="col-md-4">Marca y Modelo</th> 
												   <th  class="col-md-2">Opciones</th> 
												  </tr> 
												 </thead> 
												 <tbody id="catalogoDatos" class="catalogo-datos"> 
								 					<!-- Resultados de Datos -->
																																					 					
								 					<!-- Img de Carga de Datos -->
												  </tbody> 
												</table>
											</div>
											<!-- paginacion de catalogo / footer-->	
											<div id="pngProcsEquiposASIG" style="position: relative;bottom: 0;width: 100%;height: 14%;">
												<hr>
												<nav id="pagination" aria-label="Page navigation" class="paginacion">


												</nav>
											</div> 	
									</div>
									<!--SEGUNDO PANEL TAB-->
									<div role="tabpanel" class="tab-pane" id="cargoDepartamento" >
										<div id="div-btn-admin" class="form-group">
											<a href="javascript:;" onclick="ventanaModal.mostrarPulico('ventana-modal', datosIdsTabs=['scroll','no'])">
											    <button type="button" class="btn btn-default btn-cfg-admin" id="btnNuevo-admin"  style="width: 100%;"
																onclick="ventanaModal.cambiaMuestraVentanaModalCapaAdminPublic(
																		'vtnAsignar',
																		'administracion #ventana-modal-cfg',
																		'configuracion/gestionDepartamentos/ventanasModales/vtnMGestionDepartamento.php',
																		1
																)"
											    >
											  		Agregar nuevo cargo y departamento
											  	</button>
											</a>
										</div>										
		   								<label for="recurso">Cargo:</label>							  
									  	<div id="divCargoListD" class="form-group">
								    		<select  id="cargoListD" class="select  selectpicker lista-control" data-select="1" name="Cargo" data-show-subtext="true" data-live-search="true" 
								    		 onchange="mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic(1);" >
												<option data-subtext="" value="0">No hay datos</option>			
								   			</select>
										</div>	
		   								<label for="recurso">Departamento:</label>							  
									  	<div id="divDepartamentoListD" class="form-group">
								    		<select  id="departamentoListD" class="select selectpicker lista-control" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
								    		 onchange="mtdAsignar.ListarBusqdAvanzdCargoDepartamentoASIGPublic(1);">
												<option data-subtext="" value="0">No hay datos</option>
								   			</select>
										</div>	
									  	<hr>
								  		<div class="row">
								  			<div class="col-md-4 col-md-offset-8">
										  		<div class="btn-group" role="group" style="width: 100%;">
													<button type="button" class="btn btn-default" id="btnAgregarEquipo" onclick="mtdAsignar.agregarCargoDepartamentoDeListaPublic();" style="width: 100%;">agregar</button>
												</div>	
								  			</div>
								  		</div>
										<br>			

										<div class="catalogo">
											<table id="ctlgProcsCargoDepartamentoASIG" class="table table-bordered table-hover ">
											 <thead>
											  <tr  class="row">
											   <th  class="col-md-8">Cargo y Departamento</th> 
											   <th  class="col-md-2">Responsable de departamento</th> 
											   <th  class="col-md-2">Opciones</th> 
											  </tr> 
											 </thead> 
											 <tbody id="catalogoDatos" class="catalogo-datos"> 
							 					<!-- Resultados de Datos -->
																																					 					
							 					<!-- Img de Carga de Datos -->
											  </tbody> 
											</table>
										</div>
										<!-- paginacion de catalogo / footer-->	
										<div id="pngProcsCargoDepartamentoASIG" style="position: relative;bottom: 0;width: 100%;height: 14%;">
											<hr>
											<nav id="pagination" aria-label="Page navigation" class="paginacion">


											</nav>
										</div> 

									</div>
									<!--TERCER PANEL TAB-->
									<div role="tabpanel" class="tab-pane" id="persona" >
										
						  				<div id="div-btn-admin" class="form-group">
											<a href="javascript:;" onclick="ventanaModal.mostrarPulico('ventana-modal', datosIdsTabs=['scroll','no'])">
											    <button type="button" class="btn btn-default btn-cfg-admin" id="btnNuevo-admin"  style="width: 100%;"
																onclick="ventanaModal.cambiaMuestraVentanaModalCapaAdminPublic(
																		'vtnAsignar',
																		'administracion #ventana-modal-cfg',
																		'configuracion/gestionPersona/ventanasModales/vtnMGestionPersona.php',
																		1
																)"
											    >
											  		Agregar nueva persona
											  	</button>
											</a>
										</div>
										<div class="form-group">
											<label for="1">Cédula de persona encargada:</label>
											<input type="text" class="form-control" id="cedulaTxtCtlgASIG" placeholder="Introdusca una cedula"
											onkeyup="mtdAsignar.ListarBusqdAvanzdPersonasASIGPublic(1);">
										</div>	
									  	<hr>
								  		<div class="row">
								  			<div class="col-md-4 col-md-offset-8">
										  		<div class="btn-group" role="group" style="width: 100%;">
													<button type="button" class="btn btn-default" id="btnAgregarEquipo" onclick="mtdAsignar.agregarṔersonaDeListaPublic();" style="width: 100%;">agregar</button>
												</div>	
								  			</div>
								  		</div>
										<br>			

										<div class="catalogo">
											<table id="ctlgProcsPersonasASIG" class="table table-bordered table-hover ">
											 <thead>
											  <tr  class="row">
											   <th  class="col-md-10">Datos básicos</th>
											   <th  class="col-md-2">Opciones</th> 
											  </tr> 
											 </thead> 
											 <tbody id="catalogoDatos" class="catalogo-datos"> 
							 					<!-- Resultados de Datos -->
																																					 					
							 					<!-- Img de Carga de Datos -->
											  </tbody> 
											</table>
										</div>
										<!-- paginacion de catalogo / footer-->	
										<div id="pngProcsPersonasASIG" style="position: relative;bottom: 0;width: 100%;height: 14%;">
											<hr>
											<nav id="pagination" aria-label="Page navigation" class="paginacion">


											</nav>
										</div> 
										
									</div>									
									<!--FIN DE PANEL DE TABS-->								
								 </div>
							  </div>							  
							</div>												
						</div>					
					<hr>
						<div class="row" style="margin-bottom: 10px;">

							<div class="col-md-2 col-md-offset-10">
								<div class="btn-group" role="group" style="width: 100%;">
									
									<button type="button" class="btn btn-default" id="btnGuardarReasignacion" onclick="" style="width: 100%; display: none;" 
									data-id_equipo="" data-id_cargo="" data-id_departamento="" data-id_persona="" data-id_solicitud_gestion="" 
 									>Guardar</button>

									<button type="button" class="btn btn-default" id="btnGuardarAsignacion" onclick="" style="width: 100%;" 
 									>Guardar</button>
								</div>	
								<br>									
						
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
	$(document).ready(function() {
		mtdAsignar.guardarPublic();
		mtdAsignar.filtrarSelectPublic();

		mtdAsignar.ListarBusqdAvanzdEquiposASIGPublic(1);


		//refrescar item's
	  	nucleo.cargarListaDespegableListasPublic('marcaListD','cfg_c_fisc_mod_marca','');
	  	nucleo.cargarListaDespegableListasPublic('tipoListD','cfg_c_fisc_tipo','');
	  	nucleo.cargarListaDespegableListasPublic('departamentoListD','cfg_departamento','');
	  	nucleo.cargarListaDespegableListasPublic('cargoListD','cfg_pn_cargo','');

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
		$('#departamentoListD').popover({
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
     	$('#marcaListD').popover('show');
			  	$('#modeloListD').popover('show');
			  	$('#departamentoListD').popover('show');
			  	$('#cargoListD').popover('show');
			  	$('#tipoListD').popover('show');

			    setTimeout(function(){ 

	            	$('#marcaListD').popover('destroy');
				  	$('#departamentoListD').popover('destroy');
				  	$('#cargoListD').popover('destroy');
				  	$('#tipoListD').popover('destroy');


				  	$('#marcaListD').selectpicker('refresh');
				  	$('#departamentoListD').selectpicker('refresh');
				  	$('#cargoListD').selectpicker('refresh');
				  	$('#tipoListD').selectpicker('refresh');

			        $('#btnSelectElegido0').attr('style','width:100%;');
			        $('#btnSelectElegido1').attr('style','width:100%;');
			        $('#btnSelectElegido2').attr('style','width:100%;');
			        $('#btnSelectElegido3').attr('style','width:100%;');
			        $('#btnSelectElegido4').attr('style','width:100%;');
			        $('#btnSelectElegido5').attr('style','width:100%;');

			    }, 300);



	  	$('#marcaListD').selectpicker('refresh');
	  	$('#modeloListD').selectpicker('refresh');
	  	$('#departamentoListD').selectpicker('refresh');
	  	$('#cargoListD').selectpicker('refresh');
	  	$('#tipoListD').selectpicker('refresh');



	    $('#listas .bootstrap-select ').each(function (index, datoItem) {

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
	nucleo.controlAccessBtnAdminPublic();

</script>
