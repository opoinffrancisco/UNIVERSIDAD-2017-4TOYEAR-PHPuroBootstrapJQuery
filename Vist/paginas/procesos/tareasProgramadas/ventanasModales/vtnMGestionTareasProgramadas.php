	

		<!-- Panel de Ventana modal-->
		<div id="vtnTareasProgramadas" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestione la programación de la tarea del equipo
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControl" value="" style="display:none;"></input>
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
					 
						<div class="row">
							
							<div class="col-md-5">

					   <div id="listas" class="listas"  style="border-radius: 5px;    border: 1px solid #ccc;  padding: 5px;">
									
						<div class="row">
						<div class="col-md-12">
						<h4>
						<b>
						Tarea : ( Paso 1 )
						</b>
						</h4>
						</div>	
						</div>	
						<div class="row">
							<div class="col-md-12 col-md-offset-0">
							<label for="recurso">Seleccionar tarea:
							<br> (actualizara la lista de equipos 'que no tengan la tarea')
							</label>							  
							<div id="div-btn-admin" class="form-group">
								<a href="javascript:;" >
								    <button type="button" class="btn btn-default btn-cfg-admin" id="btnNuevo-admin"  style="width: 100%;"
													onclick="ventanaModal.cambiaMuestraVentanaModalCapaAdminPublic(
															'vtnTareasProgramadas',
															'administracion #ventana-modal-cfg',
															'configuracion/gestionTareas/gestionTareas/ventanasModales/vtnMGestionTarea.php',
															1
													)"
								    >
								  		Agregar nueva tarea
								  	</button>
								</a>
							</div>

							  <!-- Nav tabs -->
							  <ul class="nav nav-pills nav-justified" role="tablist" id="tabs_tareasPC">
							    <li role="presentation" class="active" id="tab-tPreventivas">
							    	<a href="#tPreventivas" aria-controls="tPreventivas" role="tab" data-toggle="tab"
							    		onclick="mtdTareaProgramada.iniciarPanelTabTareaPreventivaPublic();">
							    		Preventivas
							    	</a>
							    </li>
							    <li role="presentation" id="tab-tCorrectivas">
							    	<a href="#tCorrectivas" aria-controls="tCorrectivas" role="tab" data-toggle="tab"
							    		onclick="mtdTareaProgramada.iniciarPanelTabTareaCorrectivaPublic();">
							    		Correctivas
							    	</a>
							    </li>
							  </ul>
							  <div id="divTareaListD" class="form-group" style=" margin-top: 5px; border-radius: 5px; border: 1px solid #ccc; padding: 10px;">
								    <div class="tab-content">
								    <!--PRIMER PANEL TAB-->
								    	<div role="tabpanel" class="tab-pane active" id="tPreventivas">
											<div id="tipoTareaPreventiva"><b>USO:</b> mantenimientos preventivos y correctivos</div>											
											<div id="tipoTareaCorrectiva"  style="display:none;"><b>USO:</b> mantenimientos correctivos</div>											
											<select  id="tareaListD" class="select campo-control selectpicker lista-control " data-select="1" name="Tarea" data-show-subtext="true" data-live-search="true" 
											onchange="mtdTareaProgramada.busquedaAvanvadaTPPublic(1);">
												<option data-subtext="" value="0">No hay datos</option>		
											</select>

										</div>							    	
										<div role="tabpanel" class="tab-pane" id="tCorrectivas">
											<b>USO:</b> mantenimientos correctivos
											<select  id="tareaListDCorrectivas" class="select campo-control selectpicker lista-control " data-select="1" name="Tarea" data-show-subtext="true" data-live-search="true" 
											onchange="mtdTareaProgramada.busquedaAvanvadaTPPublic(1);"

												<option data-subtext="" value="0">No hay datos</option>		
											</select>

										</div>
								    </div>
								</div>				  	
							</div>
						</div>

						<div class="row" style="display: none;">
						<div class="col-md-12 ">
						<label for="modulo">Nombre:</label>							  
						<div id="divNombreTxt" class="form-group">
						<input type="text" name="nombre" class="form-control input-sm" id="nombreTareaTxt" placeholder="Nombre" 
						disabled="TRUE" required="true" >
						</div>				  	
						</div>
						</div>  
						<div class="row">
						<div class="col-md-12 ">
						<label for="modulo">Descripción:</label>							  
						<div id="divDescripcionTxt" class="form-group">
						<textarea type="text" name="descripcion" class="form-control input-sm textarea" id="descripcionTareaTxt" placeholder="Descripcion" rows="3" disabled="TRUE"	>
						</textarea>
						</div>				  	
						</div>
						</div> 

			    		</div>
							 <br>
									<div style="border-radius: 5px;    border: 1px solid #ccc;  padding: 5px;">
								 
										<div class="row">
										<div class="col-md-12">
										<h4>
										<b>
										Programación de la tarea :  ( Paso 2 )
										</b>
										</h4>
										</div>	
										</div>	
										<div class="row">
										<div class="col-md-6 "  >
										<b>
										Tiempo estimado de duración:
										</b>
										</div>
										<div class="col-md-6 divFrecuencia"  >
										<b>
										Frecuencia de repetición:
										</b>
										</div>															
										</div>	
										<div class="row">
										<div class="col-md-6 "  >
										<div class="input-group">
										<!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
										<span class="input-group-addon" id="sizing-addon2" >Horas </span>
										<input type="number" maxlength="3" min="1" class="form-control input-sm" id="tiempoEstimadoTxt" onkeyup="" placeholder="" value=""  aria-describedby="sizing-addon2"
											onblur="

													if($('#tiempoEstimadoTxt').val().length>3 || $('#tiempoEstimadoTxt').val().length<1){
														if($('#tiempoEstimadoTxt').val().length>3){
															nucleo.alertaErrorPublic('El tiempo estimado tiene :'+$('#tiempoEstimadoTxt').val().length+' caracteres, máximo 3 ');
															$('#btnGuardar').attr('disabled', true);
															$('#tiempoEstimadoTxt').addClass('imputWarnig');																												
														}
														if($('#tiempoEstimadoTxt').val().length<1){
															nucleo.alertaErrorPublic('El tiempo estimado tiene :'+$('#tiempoEstimadoTxt').val().length+' caracteres, minimo 1 ');
															$('#btnGuardar').attr('disabled', true);
															$('#tiempoEstimadoTxt').addClass('imputWarnig');																												
														}
													}else{
														$('#btnGuardar').attr('disabled', false);
														$('#tiempoEstimadoTxt').removeClass('imputWarnig');													
													}

											" 
											onkeypress="
												if($('#tiempoEstimadoTxt').val().length>3 || $('#tiempoEstimadoTxt').val().length<1){
													if($('#tiempoEstimadoTxt').val().length>3){
														$('#btnGuardar').attr('disabled', true);
														$('#tiempoEstimadoTxt').addClass('imputWarnig');														
													}
													if($('#tiempoEstimadoTxt').val().length<1){
														$('#btnGuardar').attr('disabled', true);
														$('#tiempoEstimadoTxt').addClass('imputWarnig');														
													}
												}else{
													$('#btnGuardar').attr('disabled', false);
													$('#tiempoEstimadoTxt').removeClass('imputWarnig');													
												}
												nucleo.verificarDatosInputPublic(event,this,'');												
											" 
											data-solonumero="1"
										>
										</div>	
										</div>			
										<div class="col-md-6 divFrecuencia"  >
										<div class="input-group " >
										<!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
										<span class="input-group-addon" id="sizing-addon2" >Dias</span>
										<input type="number" maxlength="3" min="1" class="form-control input-sm" id="frecuenciaTxt" onkeyup="" placeholder="" value=""  aria-describedby="sizing-addon2"
											onblur="
												if($('.divFrecuencia').hasClass('sin-frecuencia')==false){

													if($('#frecuenciaTxt').val().length>3 || $('#frecuenciaTxt').val().length<1){
														if($('#frecuenciaTxt').val().length>3){
															nucleo.alertaErrorPublic('La frecuencia tiene :'+$('#frecuenciaTxt').val().length+' caracteres, máximo 3 ');
															$('#btnGuardar').attr('disabled', true);
															$('#frecuenciaTxt').addClass('imputWarnig');
														}

														if($('#frecuenciaTxt').val().length<1){
															nucleo.alertaErrorPublic('La frecuencia tiene :'+$('#frecuenciaTxt').val().length+' caracteres, minimo 1 ');
															$('#btnGuardar').attr('disabled', true);
															$('#frecuenciaTxt').addClass('imputWarnig');
														}
													}else{
														$('#btnGuardar').attr('disabled', false);
														$('#frecuenciaTxt').removeClass('imputWarnig');
													}
												}
											" 
											onkeypress="
												if($('.divFrecuencia').hasClass('sin-frecuencia')==false){

													if($('#frecuenciaTxt').val().length>3 || $('#frecuenciaTxt').val().length<1){
														if($('#frecuenciaTxt').val().length>3){
															$('#btnGuardar').attr('disabled', true);
															$('#frecuenciaTxt').addClass('imputWarnig');
														}
														if($('#frecuenciaTxt').val().length<1){
															$('#btnGuardar').attr('disabled', true);
															$('#frecuenciaTxt').addClass('imputWarnig');
														}
													}else{
														$('#btnGuardar').attr('disabled', false);
														$('#frecuenciaTxt').removeClass('imputWarnig');
													}
													nucleo.verificarDatosInputPublic(event,this,'');												
												}
											" 
											data-solonumero="1"
										>
										</div>	
										</div>		


										</div>	
										<br>
										<div class="row">
										<div class="col-md-12 "  >
										<div class="input-group">
										<!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
										<span class="input-group-addon" id="sizing-addon2" >Ultima Fecha</span>
										<input type="text" maxlength="30" min="6" class="form-control input-sm" id="ultimaFechaTxt" onkeyup="" placeholder="" value=""  aria-describedby="sizing-addon2" disabled="TRUE">
										</div>	
										</div>		
										</div>
										<br>
										<div class="row">					
										<div class="col-md-12 "  >
										<div class="input-group">
										<!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
										<span class="input-group-addon" id="sizing-addon2" >Próxima Fecha</span>
										<input type="text" maxlength="30" min="6" class="form-control input-sm" id="proximaFechaTxt" onkeyup="" placeholder="" value=""  aria-describedby="sizing-addon2" disabled="TRUE">
										</div>	
										</div>									    	    	
										</div>	
										<br>										   
									</div>


							</div>	
							<div id="panel-tabs-agregar" class="col-md-7 col-md-offset-0" style="border-radius: 5px;    border: 1px solid #ccc;  padding: 5px;">
											<div class="row">
											<div class="col-md-12">
											<h4>
												<b>
													Equipo/s :  ( Paso 3 )
												</b> 
											</h4>
											</div>	
											</div>	
											<div class="row">
											<div class="col-md-6 col-md-offset-0">
											<div class="form-group">
											<label for="1">Serial</label>
											<input type="text" class="form-control input-sm" id="serialTxt" placeholder="Ingresar serial"
											onkeyup="mtdTareaProgramada.busquedaAvanvadaTPPublic(1);">
											</div>	
											</div>
											<div class="col-md-6 col-md-offset-0">														
											<div class="form-group">
											<label for="1">Serial bien nacional:</label>
											<input type="text" class="form-control input-sm" id="serialBienNTxt" placeholder="Ingresar serial bien nacional" onkeyup="mtdTareaProgramada.busquedaAvanvadaTPPublic(1);">
											</div>	
											</div>
											</div>		
											<div class="row">
												<div class="col-md-6 col-md-offset-0">																											
													<label for="recurso">Marca:</label>							  
													<div id="divMarcaListD" class="form-group">
														<select  id="marcaListD" class="select  selectpicker  " data-select="1" name="Marca" data-show-subtext="true" data-live-search="true">
															<option data-subtext="" value="0">No hay datos</option>								   		
														</select>
													</div>
												</div>
												<div class="col-md-6 col-md-offset-0">																											
													<label for="recurso">Modelo:</label>							  
													<div id="divModeloListD" class="form-group">
														<select  id="modeloListD" class="select  selectpicker " data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
														onchange="	mtdTareaProgramada.busquedaAvanvadaTPPublic(1);" >
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
											onchange="	mtdTareaProgramada.busquedaAvanvadaTPPublic(1);" >
											<option data-subtext="" value="0">No hay datos</option>								   		
											</select>
											</div>
											</div>								  		
											</div> 
											<div class="row">
											<div class="col-md-6 col-md-offset-0">
											<div class="form-group">
											<label for="1">Cédula</label>
											<input type="text" class="form-control input-sm" id="cedulaTxt" placeholder="Ingresar cedula"
											onkeyup="mtdTareaProgramada.busquedaAvanvadaTPPublic(1);">
											</div>	
											</div>
											<div class="col-md-6 col-md-offset-0">														
											<label for="recurso">Cargo:</label>							  
											<div id="divCargoListD" class="form-group">
											<select  id="cargoListD" class="select  selectpicker lista-control" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
											onchange="	mtdTareaProgramada.busquedaAvanvadaTPPublic(1);" >
											<option data-subtext="" value="0">No hay datos</option>								   		
											</select>
											</div>		
											</div>
											</div>		
											<div class="row">
											<div class="col-md-12 col-md-offset-0">														
											<label for="recurso">Departamento:</label>							  
											<div id="divDepartamentoListD" class="form-group">
											<select  id="departamentoListD" class="select  selectpicker lista-control" data-select="1" name="Modelo" data-show-subtext="true" data-live-search="true"  
											onchange="	mtdTareaProgramada.busquedaAvanvadaTPPublic(1);" >
											<option data-subtext="" value="0">No hay datos</option>								   		
											</select>
											</div>		
											</div>
											</div>

											<div id="catalogoVtnTP"> 
											<hr>
											<div class="row">

											<div class="col-md-12">
												<h5>
													<b>
													Se le realizará la programación de la tarea, a los equipos que esten en la lista:
													</b>
												</h5>
											</div>	
											</div>										  	
											<div class="catalogo">

											<table id="ctlgVTNProcsTP" class="table table-bordered table-hover table-striped">
											<thead>
											<tr  class="row">
											<th  class="col-md-4">Serial y serial bien nacional del equipo</th>
											<th  class="col-md-4">Responsable</th> 
											<th  class="col-md-4">Ubicación</th> 
											</tr> 
											</thead> 
											<tbody id="catalogoDatos" class="catalogo-datos" style="font-size: small;"> 
											<!-- Resultados de Datos -->

											<tr>
											<td colspan="5" style="text-align: center;">  Filtrar búsqueda de equipos para la programación </td>
											</tr>
											<!-- Img de Carga de Datos -->
											</tbody> 
											</table>
											</div>
											<!-- paginacion de catalogo / footer-->	
											<div id="pngVTNProcsTP" style="position: relative;bottom: 0;width: 100%;height: 14%;">
											<hr>
											<nav id="pagination" aria-label="Page navigation" class="paginacion">
											</nav>
											</div> 
											</div>

									</div>
			
						<hr>
							<br>
							<br>	    					    					
		
						<div class="row" style="margin-bottom: 10px;">
							<div class="col-md-2 col-md-offset-10">
							<br>	    					    					
								<div class="btn-group" role="group" style="width: 100%;">

									<button type="submit" class="btn btn-default" id="btnGuardarProgramacion" onclick="" style="width: 100%;"  data-guardar_editar="0" data-id_equipo="" data-id_tarea=""  
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
	mtdTareaProgramada.Iniciar();
	nucleo.controlAccessBtnAdminPublic();
/**********************************************/


$(document).ready(function() {
	$('#btnGuardar').attr('disabled', true);
});

</script>
