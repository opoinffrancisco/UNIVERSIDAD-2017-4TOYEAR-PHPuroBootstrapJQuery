	
	

		<!-- Panel de Ventana modal-->
		<div id="vtnCambiarPeriferico" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar cambio de periferico
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa3')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
					<input type="text" id="datoControlIdEquipoCambio" value="" style="display:none;"></input>
					<input type="text" id="datoControlIdCambio" value="" style="display:none;"></input>
					<input type="text" id="datoControlIdUsado" value="" style="display:none;"></input>
					<div  class="row">

	<form id="formADD" method="POST" ></input>					
					<div  class="row">
						<label> Periferico actual </label>
						<div class="col-md-12">
							<div class="row">
								<div class="col-md-12">

									<div class="row">
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Serial</label>
											    <input type="text" class="form-control input-sm" id="serialTxtActual" disabled="TRUE">
											</div>											
										</div>				
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Serial Bien Nacional</label>
											    <input type="text" class="form-control input-sm" id="serialBienNacionalTxtActual" disabled="TRUE">
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
												<label for="1">Interfaz de conexión</label>
											    <input type="text" class="form-control input-sm" id="interfazConexionTxtActual" disabled="TRUE">
											</div>					
										</div>						
									</div>
									<div class="row">
										<div class="col-md-6">											
											<div class="form-group">
											    <label for="1">Marca</label>
											    <input type="text" class="form-control input-sm" id="marcatxtActual" disabled="TRUE">
											</div>											
										</div>				
										<div class="col-md-6">
											<div class="form-group">
												<label for="1">Modelo</label>
											    <input type="text" class="form-control input-sm" id="modelotxtActual" disabled="TRUE">
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
										 	Se cambiara el periferico actual por uno nuevo o usado
										</b>
									</div>
								</div>				

						<div class="row" style="padding: 0px 15px 0px 15px;" id="panel-acciones-mantenimiento">
							<div class="col-md-12" style="border: 1px solid white;margin-left: 0px;padding: 0px;background: #FFFFFF;">
									<!-- Cabecera de panel para catalogos -->
									<div class="panel-heading" style="padding: 5px 5px  0px 0px;background: #CCC;">
										<ul class="nav nav-tabs nav-justified">
										  	<li role="presentation">
										  		<a href="javascript:;" class="pestana-tab-inactivo" id="tabObservarDiagnostico" 
										  			onclick="panelTabs.cambiarModalPulico('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/cambiar/periferico/nuevo.php','',datosIdsTabs=['tabObservarDiagnostico','tabObservarRealizado'],'catalogoModalSolicitudCambiar');">
										  			Nuevo
										  		</a>
										  	</li>
										  	<li role="presentation" >
											  	<a href="javascript:;" class="pestana-tab-inactivo" id="tabObservarRealizado"
											  	onclick="panelTabs.cambiarModalPulico('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/cambiar/periferico/usado.php','',datosIdsTabs=['tabObservarRealizado','tabObservarDiagnostico'],'catalogoModalSolicitudCambiar');">
										      		Usado
										    	</a>
									      	</li>										  	
										</ul>
									</div> 
									<div id="catalogoModalSolicitudCambiar">
										
									</div>
							</div>							
						</div>



												
				</form>
				<?php 

					include '../../../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>

















