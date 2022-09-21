

		<!-- Panel de Ventana modal-->
		<div id="vtnAccionesPermitidas" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestione las acciones permitidas al perfil
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarSinReinicPublic('ventana-modal-capa2')">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body" style="margin: 0px;padding: 15px 0px 15px 0px;"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">
								<div class="col-md-11 col-md-offset-1 ">
									<p >Perfil : <b id="nombrePerfilTexto">  </b> - Modulo: <b id="nombreModuloTexto">  </b> </p>
								</div>
							</div>

											<div style="border:1px solid #ccc; border-radius:5px;">
													<div class="row">
														<div class="col-md-3 col-md-offset-1 " >
													  		<div class="checkbox" id="nuevoCboxDiv">
															    <label id="1lbl">
															      <input type="checkbox" id="nuevoCbox"> Nuevo
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-0 ">
													  		<div class="checkbox"  id="editarCboxDiv">
															    <label id="2lbl">
															      <input type="checkbox" id="editarCbox"> Editar
															    </label>
													  		</div>
														</div>
														<div class="col-md-5 col-md-offset-0 " >
													  		<div class="checkbox" id="eliminacionLogCboxDiv">
															    <label id="3lbl">
															      <input type="checkbox" id="eliminacionLogCbox"> ( Habilitar / Deshabilitar )
															    </label>
													  		</div>
														</div>
													</div>  	

													<div class="row">
														
														<div class="col-md-3 col-md-offset-1 " >
													  		<div class="checkbox" id="generarRptCboxDiv">
															    <label id="4lbl">
															      <input type="checkbox" id="generarRptCbox"> Generar reporte
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-0 " >
													  		<div class="checkbox" id="generarRptFltCboxDiv">
															    <label id="5lbl">
															      <input type="checkbox" id="generarRptFltCbox"> Generar reporte filtrado
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-0 " >
														  	<div class="checkbox" id="permisosPerfilCboxDiv">
															    <label id="6lbl">
															      <input type="checkbox" id="permisosPerfilCbox"> Permisos de perfil
															    </label>
													  		</div>
														</div>
													</div>  	

													<div class="row">
														
														<div class="col-md-3 col-md-offset-1 " >
													  		<div class="checkbox" id="busquedaAvanzadaCboxDiv">
															    <label id="7lbl">
															      <input type="checkbox" id="busquedaAvanzadaCbox"> Busqueda avanzada
															    </label>
															</div>
														</div>
														<div class="col-md-3 col-md-offset-0 ">
													  		<div class="checkbox"  id="detallesCboxDiv">
															    <label id="8lbl">
															      <input type="checkbox" id="detallesCbox"> Detalles
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-0 " >
													  		<div class="checkbox" id="atenderCboxDiv">
															    <label id="9lbl">
															      <input type="checkbox" id="atenderCbox"> Atender
															    </label>
													  		</div>
														</div>
													</div>  	

													<div class="row">
														<div class="col-md-3 col-md-offset-1 ">
													  		<div class="checkbox"  id="asignarCboxDiv">
															    <label id="10lbl">
															      <input type="checkbox" id="asignarCbox"> Asignar
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-0 ">
													  		<div class="checkbox"  id="diagnosticarCboxDiv">
															    <label id="11lbl">
															      <input type="checkbox" id="diagnosticarCbox"> Diagnosticar
															    </label>
													  		</div>
														</div>
														<div class="col-md-4 col-md-offset-0 " >
													  		<div class="checkbox" id="programarTareaCboxDiv">
															    <label id="12lbl">
															      <input type="checkbox" id="programarTareaCbox"> Programar tarea
															    </label>
													  		</div>
														</div>														
													</div> 

													<div class="row">
														<div class="col-md-3 col-md-offset-1 " >
													  		<div class="checkbox" id="iniciarFinalizarTareaCboxDiv">
															    <label id="13lbl">
															      <input type="checkbox" id="iniciarFinalizarTareaCbox"> Iniciar/Finalizar Tarea 
															    </label>
													  		</div>
														</div>																			
														<div class="col-md-3 col-md-offset-0 ">
													  		<div class="checkbox"  id="respuestaSoltCboxDiv">
															    <label id="14lbl">
															      <input type="checkbox" id="respuestaSoltCbox"> Respuesta de solicitud
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-0 " >
													  		<div class="checkbox" id="finalizarSoltCboxDiv">
															    <label id="15lbl">
															      <input type="checkbox" id="finalizarSoltCbox"> Finalizar solicitud
															    </label>
													  		</div>
														</div>									
													</div>  
													<div class="row">
														
														<div class="col-md-5 col-md-offset-1 " >
													  		<div class="checkbox" id="gestionEquipoCboxDiv">
															    <label id="16lbl">
															      <input type="checkbox" id="gestionEquipoCbox"> Gestion de equipo
															    </label>
												   			</div>
														</div>  

													</div>

													<div class="row">
														<div class="col-md-3 col-md-offset-1 ">
															<div class="checkbox" id="desincorporarEquipoCboxDiv">
															    <label>
															      <input type="checkbox" id="desincorporarEquipoCbox"> Desincorporar equipo  
															    </label>
															</div>
														</div>																			
														<div class="col-md-3 col-md-offset-1 ">
													  		<div class="checkbox" id="desincorporarPerifericoCboxDiv">
															    <label>
															      <input type="checkbox" id="desincorporarPerifericoCbox"> Desincorporar periferico 
															    </label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
															<div class="checkbox" id="desincorporarComponenteCboxDiv">
															    <label>
															      <input type="checkbox" id="desincorporarComponenteCbox"> Desincorporar componente 
															    </label>
															</div>
														</div>									
													</div>  

													<div class="row">
														<div class="col-md-3 col-md-offset-1 ">
													  		<div class="checkbox" id="cambiarPerifericoCboxDiv">
															    <label>
															    	<input type="checkbox" id="cambiarPerifericoCbox"> Cambiar periferico
															    </label>
														  	</div>
														</div>																			
														<div class="col-md-3 col-md-offset-1 ">
														  	<div class="checkbox" id="cambiarComponenteCboxDiv">
															    <label>
															      	<input type="checkbox" id="cambiarComponenteCbox"> Cambiar componente 
														    	</label>
													  		</div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
													  		<div class="checkbox"  id="cambiarSoftwareCboxDiv">
															    <label>
															      <input type="checkbox" id="cambiarSoftwareCbox"> Cambiar software
															    </label>
													  		</div>
														</div>									
													</div>  

													<div class="row">														
														<div class="col-md-5 col-md-offset-1 ">
														  <div class="checkbox" id="inconformidadAtendidaCboxDiv">
															    <label>
															    	<input type="checkbox" id="inconformidadAtendidaCbox"> Inconformidad atendida 
															    </label>
														   </div>
														</div>  
													</div>


											</div>

							</div>  	
							<hr>
							<div class="row">
								<div class="col-md-2 col-md-offset-10">
							  		<button type="button" class="btn btn-default" id="btnGuardarAcciones" 
							  			onclick="mtdPerfil.guardarPermisosAccionesModuloPublic();" 
							  		>Guardar</button>
							  	</div>
						  	</div>
						  	<br>	
					</form>
				<?php 

					include '../../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>



	<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
</script>