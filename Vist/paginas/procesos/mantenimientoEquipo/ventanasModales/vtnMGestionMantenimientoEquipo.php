	
		<!-- Panel de Ventana modal-->
		<div id="vtnMantenimientoEquipo" class="panel panel-primary ventana-modal-panel-mediano-sintop">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar el mantinimiento
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControlIdSolicitante" value="" style="display:none;"></input>
						<input type="text" id="datoControlIdSolicitud" value="" style="display:none;"></input>
						<input type="text" id="datoControlIdEquipo" value="" style="display:none;"></input>

						
								<div class="row">
									<div class="col-md-4">											
										<div class="form-group">
										    <label for="1">Solicitado en el:</label>
										    <input type="text" class="form-control" id="fechaSolicitadoDate" placeholder="" disabled="TRUE">
										</div>											
									</div>	
									<div class="col-md-4">											
										<div class="form-group">
										    <label for="1">Comienzo de atención en el:</label>
										    <input type="text" class="form-control" id="fechaAtendiendoDate" placeholder="" disabled="TRUE">
										</div>											
									</div>															
									<div class="col-md-4">
								      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
								  	  	<div id="divDetalles" class="form-group">								
											<a href="javascript:;" onclick="mtdMantenimientoEquipo.detallesPublic(0,2);">
											    <button type="button" class="btn btn-default" id="btnNuevo" >
											    <!-- disabled="false" -->
											  		Ver Solicitud<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
											  	</button>
											</a>	
										</div>																							
									</div>																					
								</div>
				
								<hr>
								<div class="row">
									<div class="col-md-12 "  >
										<div class="input-group">
										  <!--<span class="input-group-addon glyphicon glyphicon-search" id="sizing-addon2"></span>-->
										  <span class="input-group-addon" id="sizing-addon2" >Equipo:</span>
										  <input type="text" class="form-control" id="detallesCortoEquipo"  disabled="true"  aria-describedby="sizing-addon2">
										</div>	
									</div>										
								</div>		
								<br>								
								<div class="row">
									<div class="col-md-4">											
										<div class="form-group">
										    <label for="1">Serial :</label>
										    <input type="text" class="form-control" id="serialEqTxt" disabled="TRUE">
										</div>											
									</div>				
									<div class="col-md-4">
										<div class="form-group">
											<label for="1" style="">Serial bien nacional</label>
										 <input type="text" class="form-control" id="serialBNEqTxt" disabled="TRUE">
										</div>																						
									</div>																							
									<div class="col-md-4">
								      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
								  	  	<div id="divDetalles" class="form-group gestionEquipoBtnDiv">								
											<a href="javascript:;" onclick="mtdMantenimientoEquipo.iniciarVtnGestionEquipoPublic()">
											    <button type="button" class="btn btn-default" id="btnGestionarEquipo" >
											    <!-- disabled="false" -->
											  		Gestionar equipo en mantenimiento<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
											  	</button>
											</a>	
										</div>	
										<label id="lbMensajeDesincorpora" style="color: red; display: none;">Equipo actual desincorporado</label>										
									</div>
								</div>
					<hr>
						<div class="row" style="padding: 0px 15px 0px 15px;" id="panel-acciones-mantenimiento">
							<div class="col-md-12" style="border: 1px solid white;margin-left: 0px;padding: 0px;background: hsla(0, 0%, 83%, 0.64);">
									<!-- Cabecera de panel para catalogos -->
									<div class="panel-heading" style="padding: 5px 5px  0px 0px;">
										<ul class="nav nav-tabs nav-justified">
										  	<li role="presentation">
										  		<a href="javascript:;" class="pestana-tab-activo" id="tabObservarDiagnostico" 
										  			onclick="mtdMantenimientoEquipo.cargarListaDiagnosticosSoltPublic();">
										  			Diagnósticos
										  		</a>
										  	</li>
										  	<li role="presentation" >
											  	<a href="javascript:;" class="pestana-tab-activo" id="tabObservarRealizado"
											  	onclick="mtdMantenimientoEquipo.cargarListaTareasEquipoSolicitudPublic();">
										      		Tareas
										    	</a>
									      	</li>										  	
										</ul>
									</div> 
									<div id="catalogoModalSolicitud">
										
									</div>
							</div>							
						</div>
						<div class="row">
							<div class="col-md-11 col-md-offset-0 ">
								<div class="col-md-2">
							      	<label for="recurso" class="inconformidadAtendidaBtnDiv" style="color:#ffffff;">|||||||||||||||||:</label>					
							  	  	<div id="divDetalles" class="form-group inconformidadAtendidaBtnDiv" >								
										<a href="javascript:;"  onclick="">
										    <button type="button" class="btn btn-default" id="btnAtenderConformidad" data-id_conformidad="" data-observacion="" style="display: none;"
										    onclick="mtdMantenimientoEquipo.guardarAtenderInconformidadPublic();">
										    <!-- disabled="false" -->
										  		Inconformidad atendida <!--<span class="glyphicon glyphicon-plus-sign"></span>-->
										  	</button>
										</a>	
									</div>	

								</div>	
								<div class="col-md-7 col-md-offset-1">
									<br>

									<label id="lbMensajeConformidad" style="color: white;padding-top: 2%;">
										En espera de conformidad |
									</label>
									<label id="lbMensajeRespuesta" style="color: white;padding-top: 2%;">
										Respuesta enviada <b id="fechaRespuesta"></b>
									</label>
								</div>
								<div class="col-md-2">
							      	<label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>					
							  	  	<div id="divDetalles" class="form-group respuestaSoltBtnDiv">								
										<a href="javascript:;"  onclick="ventanaModal.cambiaMuestraVentanaModalCapa2Public('procesos/mantenimientoEquipo/ventanasModales/vtnMGestionMantenimientoEquipo-darRespuesta.php',1,1)">
										    <button type="button" class="btn btn-default" id="btnRespuesta" >
										    <!-- disabled="false" -->
										  		Dar respuesta<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
										  	</button>
										</a>	
									</div>	

								</div>	
							</div>		
							<div class="col-md-1 col-md-offset-0">
							 <label for="recurso" style="color:#ffffff;">|||||||||||||||||:</label>							  
					  	<div id="divDetalles" class="form-group finalizarSoltBtnDiv">								
										<a href="javascript:;"onclick="ventanaModal.cambiaMuestraVentanaModalCapa2Public('procesos/mantenimientoEquipo/ventanasModales/vtnMGestionMantenimientoEquipo-finalizarMantenimiento.php',1,1)">
								    <button type="button" class="btn btn-default" id="btnFinalizarMantenimiento"  >
								    <!-- disabled="false" -->
								  		Finalizar<!--<span class="glyphicon glyphicon-plus-sign"></span>-->
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
		nucleo.asignarPermisosBotonesPublic(3);
</script>
