	

		<!-- Panel de Ventana modal-->
		<div id="vtnProcsEquipoConsulta" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestionar el equipo 
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
				<form id="form" method="POST" >
						<input type="text" id="datoControlId" value="" style="display:none;"></input>
						<!--***********************************************************************-->
							<br>
							<div  class="row">

								<div class="col-md-12">

									<div class="row">
										<div class="col-md-10">

											<div class="row">
												<div class="col-md-6">
													<div class="form-group">
														<label for="1">Serial:</label>
													    <input type="text" class="form-control input-sm" id="serialtxt" disabled="TRUE">
													</div>											
												</div>				
												<div class="col-md-6">
													<div class="form-group">
														<label for="1">Serial Bien Nacional:</label>
													    <input type="text" class="form-control input-sm" id="serialBienNacionaltxt" disabled="TRUE" >
													</div>												
												</div>	

											</div>	
											<div class="row">

												<div class="col-md-12">
													<div class="form-group">
														<label for="1">Tipo</label>
													    <input type="text" class="form-control input-sm" id="tipotxt" disabled="TRUE">
													</div>																						
												</div>																					
											</div>
										
											<div class="row">
												<div class="col-md-6">											
													<div class="form-group">
													    <label for="1">Marca</label>
													    <input type="text" class="form-control input-sm" id="marcatxt" disabled="TRUE">
													</div>											
												</div>				
												<div class="col-md-6">
													<div class="form-group">
														<label for="1">Modelo</label>
													    <input type="text" class="form-control input-sm" id="modelotxt" disabled="TRUE">
													</div>																						
												</div>																					
											</div>

											<div class="row">
												<div class="col-md-6">
													<div class="form-group desincorporarEquipoBtnDiv">
														<label for="1"></label>
														<button type="button" id="btnGuardarSeriales" class="btn btn-default" 
																style="width: 100%;"
																onclick="ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/desincorporar/vtnMGestionMantenimientoEquipo-desincorporarEquipo.php',1,1)" 
												  		>Desincorporar equipo</button>
													</div>
												</div>																											
											</div>
										</div>				
										<div class="col-md-2">

											<div class="form-group">
												<label for="1">Interfaces de conexión</label>
												<div id="listGestionCaractInterfacesEqu" class="list-group" style="FONT-SIZE: smaller;">
													
												</div>							
											</div>
										</div>	
									</div>
								</div>
								
							</div>
							<hr>
							<div class="row">
								<div class="col-md-4">
									<div class="row" style="margin-bottom: 10px;">
										<div class="col-md-12" style="text-align: center;">
											<b>Periféricos:</b>
										</div>
									</div>								
								</div>
								<div class="col-md-4">
									<div class="row" style="margin-bottom: 10px;">
										<div class="col-md-12" style="text-align: center;">
											<b>Componentes:</b>
										</div>
									</div>	
								</div>
								<div class="col-md-4">
									<div class="row" style="margin-bottom: 10px; ">
										<div class="col-md-12" style="text-align: center;">
											<b>Software:</b>
										</div>
									</div>	
								</div>
							</div>
							<div class="row">
								<div class="col-md-4">
									<button type="button" id="btnDesincorporarPeriferico" data-id_periferico="" disabled="TRUE" class="btn btn-default desincorporarPerifericoBtnDiv" 
									style=" margin-bottom:20px; width:100%;"
									onclick="ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/desincorporar/vtnMGestionMantenimientoEquipo-desincorporarEquipo-periferico.php',1,1)"
									>Desincorporar</button>
									<button type="button" id="btnCambiarPeriferico" data-id_periferico="" disabled="TRUE" class="btn btn-default cambiarPerifericoBtnDiv" 
									style=" margin-bottom:20px; width:100%;"
									onclick="mtdMantenimientoEquipo.consultarPerifericoPublic();"	>Cambiar</button>									
									<div id="pgnListPerifericos" >
										<div id="pagination">
											
										</div>
									</div>	
									<div id="listGestionPerifericos" class="list-group" style="FONT-SIZE: smaller;">

									</div>							
									<div id="pgnListPerifericos">
										<div id="pagination">
											
										</div>
									</div>	
								</div>
								<div class="col-md-4">
									<button type="button" id="btnDesincorporarComponente" data-id_componente="" disabled="TRUE" class="btn btn-default desincorporarComponenteBtnDiv" 
									style=" margin-bottom:20px; width:100%;"
									onclick="ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/desincorporar/vtnMGestionMantenimientoEquipo-desincorporarEquipo-componente.php',1,1)"
									>Desincorporar</button>
									<button type="button" id="btnCambiarComponente" data-id_componente="" disabled="TRUE" class="btn btn-default cambiarComponenteBtnDiv" 
									style=" margin-bottom:20px; width:100%;"
									onclick="mtdMantenimientoEquipo.consultarComponentePublic();">Cambiar</button>	
									<div id="pgnListComponentes" >
										<div id="pagination">
											
										</div>
									</div>	
									<div id="listGestionComponentes" class="list-group" style="FONT-SIZE: smaller;">

									</div>							
									<div id="pgnListComponentes">
										<div id="pagination">
											
										</div>
									</div>							
								</div>
								<div class="col-md-4">
								<!--
									<button type="button" id="btnDesincorporarSoftware" class="btn btn-default" data-id_software="" disabled="TRUE" 
									style=" margin-bottom:20px; width:100%;"
									onclick="ventanaModal.cambiaMuestraVentanaModalCapa3Public('procesos/mantenimientoEquipo/ventanasModales/GestionarEquipo/desincorporar/vtnMGestionMantenimientoEquipo-desincorporarEquipo-software.php',1,1)"
									>Desincorporar</button>
									-->
									<button type="button" id="btnCambiarSoftware" 
									class="btn btn-default cambiarSoftwareBtnDiv" data-id_software="" disabled="TRUE" 
									style=" margin-bottom:20px; width:100%;"
									onclick="mtdMantenimientoEquipo.consultarSoftwarePublic();"	>Cambiar</button>	
									<div id="pgnListSoftware" >
										<div id="pagination">
											
										</div>
									</div>	
									<div id="listGestionSoftware" class="list-group" style="FONT-SIZE: smaller;">

									</div>							
									<div id="pgnListSoftware">
										<div id="pagination">
											
										</div>
									</div>							
								</div>
							</div>
						<!--***********************************************************************-->
				</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>
<script type="text/javascript">
		
	mtdMantenimientoEquipo.consultarEquipoGestionPublic(0);
	mtdMantenimientoEquipo.cargarListaPerifericosEquipoPublic(1);	
	mtdMantenimientoEquipo.cargarListaComponentesEquipoPublic(1);
	mtdMantenimientoEquipo.cargarListaSoftwareEquipoPublic(1);
	nucleo.asignarPermisosBotonesPublic(3);	
</script>
