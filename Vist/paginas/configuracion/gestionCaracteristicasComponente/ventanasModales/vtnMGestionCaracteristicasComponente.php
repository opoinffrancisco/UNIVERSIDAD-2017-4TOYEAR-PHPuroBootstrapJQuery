	

		<!-- Panel de Ventana modal-->
		<div id="vtnCaracteristicasComponentes" class="panel panel-primary ventana-modal-panel-grande  ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar las carácteristicas de componente
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdCaracteristicasComponentes.restablecerFormPublic()">x</a>
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
									Carácteristicas fisicas para gestionar el componente :
								</h5>
							</div>
						</div>
						<div id="listas">													
							<div class="row">
							  <div class="col-md-5 col-md-offset-1">
   							      <label for="recurso">Marca:</label>							  
							  	  	<div id="divMarcaListD" class="form-group">
								    	<select  id="marcaListD" class="select campo-control selectpicker lista-control " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true"  >
											<option data-subtext="" value="0">No hay datos</option>								   		
								   		</select>
								  	</div>				  	
							  </div>
							  <div class="col-md-5 col-md-offset-0">
   							      <label for="recurso">Modelo:</label>							  
							  	  	<div id="divModeloListD" class="form-group">
								    	<select  id="modeloListD" class="select campo-control selectpicker lista-control lista-control-change" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
								    	data-content-popover="divModeloListD"
									    data-tabla-form="cfg_caracteristicas_fisc_comp"
									    data-tabla-campo="cfg_c_fisc_modelo"
										data-columna-campo="id_modelo_fisc">
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
											    data-tabla-form="cfg_caracteristicas_fisc_comp"
											    data-tabla-campo="cfg_c_fisc_tipo"
												data-columna-campo="id_tipo_fisc">								
													<option data-subtext="" value="0">No hay datos</option>								   		
										   		</select>
										  	</div>					  	
									  </div>							  
									</div>	

									<div class="row">
									  <div class="col-md-8" style="padding-left:0px;padding-right: 0px;">
		   							      <label for="recurso">Capacidad:</label>							  
									  	  	<div id="divCapacidadTxt" class="form-group">
										    	<input type="text" name="capacidad" class="form-control input-sm" id="capacidadTxt" placeholder="Ingresar capacidad" 
										  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divCapacidadTxt')"
										    		data-cantmax="255" maxlength="255" data-cantmin="1" 
										    		data-solonumero="1" >
										  	</div>						  	
									  </div>
									  <div class="col-md-4 col-md-offset-0" style="padding-left:15px;padding-right: 0px;">
		   							      <label for="recurso" style="color: #ffffff;">|||||||||||||||</label>							  
											<div id="divUMCapacidadListD" class="form-group">
												<select  id="umcapacidadListD" class="selectpicker lista-control " data-show-subtext="true" data-live-search="true"  >
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
																			onclick="listas.agregarItemSelectPublic('vtnCaracteristicasComponentes','vtnCatalogoDatosCComponentes','selectCComponentesInterfaz','btnAgregarInterfaz','equipo','cfg_c_fisc_interfaz_conexion','nombre')" >
																			Agregar Interfaz
																		</button>
																	</div>	
																	<br>												    	
														<div class="table table-hover " style="background-color:#fff; overflow-y: auto;height: 300px; ">
															<div id="vtnCatalogoDatosCComponentes" class="catalogo-datos" style=""> 
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
																		<select id="selectCComponentesInterfaz" ></select>
																	</div>

																</div> 
															</div> 
														</div>  
													</div>
												</div>								
											</div>



											<!--
												NOTA:
														alert(   $('#listas #vtnCatalogoDatosCComponentes div div select#equipo4').val() );												

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
		mtdCaracteristicasComponentes.Iniciar();
		if ($('#ventana-modal-cfg').hasClass('ventana-modal-panel-accionMostrar')==false) {
			nucleo.asignarPermisosBotonesPublic(28);
		}
</script>
