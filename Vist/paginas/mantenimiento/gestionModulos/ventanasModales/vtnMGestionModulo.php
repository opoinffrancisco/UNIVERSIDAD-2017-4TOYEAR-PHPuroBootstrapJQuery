

		<!-- Panel de Ventana modal-->
		<div id="vtnModulo" class="panel panel-primary ventana-modal-panel-mediano-sintop ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestione el Modulo
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="mtdModulo.restablecerFormPublic(); ventanaModal.ocultarPulico('ventana-modal');">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							<div class="row">

								<div class="col-md-5 ">

									<div class="row">
										<div class="col-md-12 ">
										      <label for="modulo">Nombre:</label>							  
											  	<div id="divNombreTxt" class="form-group">
										    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
										  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"									  			
										  			onkeyup="nucleo.verificarDatosPublic('mtn_modulo','nombre','nombreTxt','divNombreTxt')"
										    		data-cantmax="50" maxlength="50" data-cantmin="4" data-vexistencia="1" 
										    		data-sololetrayespacio="1" required="true" >
										  	</div>				  	
										</div>
									</div>  
									<div class="row">
										<div class="col-md-12 ">
										      <label for="modulo">Descripción:</label>							  
											  	<div id="divDescripcionTxt" class="form-group">
										    	<textarea type="text" name="descripcion" class="campo-control form-control input-sm textarea" id="descripcionTxt" placeholder="Ingresar descripcion" 
										  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divDescripcionTxt')"									  			
										  			rows="4" 
										    		data-cantmax="255" maxlength="255" data-cantmin="15"
										    		data-descripcion="1" required="true" >
										  		</textarea>
										  	</div>				  	
										</div>
									</div>
									
									<div class="row">
										<div class="col-md-12">
												
											      <label for="modulo">Ubicación del modulo en jerarquia del sistema:</label>							  
													<div class="btn-group" data-toggle="buttons">
													  <label class="btn btn-primary"  onclick="$('.panel-pertenece').collapse('hide'); 
																														$('#principalCbox').val(1);$('#perteneceCbox').val(0);	" >
													    <input type="radio" name="options" id="principalCbox" value="0" autocomplete="off"> Principal
													  </label>
													  
													  <label class="btn btn-primary" onclick="$('.panel-pertenece').collapse('show'); 
																			$('#principalCbox').val(0);$('#perteneceCbox').val(1); ">
													    <input type="radio" name="options" id="perteneceCbox" value="1" autocomplete="off" style="background:#f2dede;" > Pertenece
													  </label>


													</div>

												<div class="collapse panel-pertenece" id="collapseExample">
												  <div class="well">


																<label for="Modulos">Modulos:</label>							  
													  	<div id="divModuloPerteneceListD" class="form-group">
												    			<select  id="moduloPerteneceListD" class=" selectpicker" data-select="1" name="Modulos" 	data-show-subtext="true" data-live-search="true"  >
																							<option data-subtext="" value="0">No hay datos</option>								   		
												   				</select>
												 	 	</div>	


												  </div>
												</div>


											</div>
											
										</div>

								</div>
								<div class="col-md-7 ">

											<div class="row">
												<div class="col-md-11 col-md-offset-0 " style="padding-left: 0px;">	
														<b>
																Funcionalidades disponibles :
														</b>
												</div>
											</div>
											<div style="border:1px solid #ccc; border-radius:5px;">
													<div class="row">
														
														<div class="col-md-3 col-md-offset-1 ">
														  <div class="checkbox">
														    <label>
														      <input type="checkbox" id="nuevoCbox"> Nuevo
														    </label>
														  </div>
														</div>
														<div class="col-md-3 col-md-offset-0 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="editarCbox"> Editar
													    </label>
													  </div>
														</div>
														<div class="col-md-5 col-md-offset-0 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="eliminacionLogCbox"> Habilitar / Deshabilitar 
													    </label>
													  </div>
														</div>
													</div>  	

													<div class="row">
														
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="generarRptCbox"> Generar reporte
													    </label>
													  </div>
														</div>
														<div class="col-md-4 col-md-offset-0 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="generarRptFltCbox"> Generar reporte filtrado
													    </label>
													  </div>
														</div>
														<div class="col-md-4 col-md-offset-0 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="permisosPerfilCbox"> Permisos de perfil
													    </label>
													  </div>
														</div>
													</div>  	

													<div class="row">
														
														<div class="col-md-4 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="busquedaAvanzadaCbox"> Busqueda avanzada
													    </label>
													  </div>
														</div>
														<div class="col-md-3 col-md-offset-0 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="detallesCbox"> Detalles
													    </label>
													  </div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="atenderCbox"> Atender
													    </label>
													  </div>
														</div>
													</div>  	

													<div class="row">
														
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="asignarCbox"> Asignar
													    </label>
													  </div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="diagnosticarCbox"> Diagnosticar
													    </label>
													  </div>
														</div>
														<div class="col-md-4 col-md-offset-0 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="programarTareaCbox"> Programar tarea
													    </label>
													  </div>
														</div>														

													</div> 

													<div class="row">
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="iniciarFinalizarTareaCbox"> Iniciar/Finalizar Tarea 
													    </label>
													  </div>
														</div>																			
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="respuestaSoltCbox"> Respuesta de solicitud
													    </label>
													  </div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="finalizarSoltCbox"> Finalizar solicitud
													    </label>
													  </div>
														</div>									
													</div>  

													<div class="row">
														
														<div class="col-md-5 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="gestionEquipoCbox"> Gestion de equipo
													    </label>
												   </div>
														</div>  

													</div>
<!--**************************************************************************************-->

													<div class="row">
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="desincorporarEquipoCbox"> Desincorporar equipo  
													    </label>
													  </div>
														</div>																			
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="desincorporarPerifericoCbox"> Desincorporar periferico 
													    </label>
													  </div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="desincorporarComponenteCbox"> Desincorporar componente 
													    </label>
													  </div>
														</div>									
													</div>  

<!--**************************************************************************-->

													<div class="row">
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="cambiarPerifericoCbox"> Cambiar periferico
													    </label>
													  </div>
														</div>																			
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="cambiarComponenteCbox"> Cambiar componente 
													    </label>
													  </div>
														</div>
														<div class="col-md-3 col-md-offset-1 ">
													  <div class="checkbox">
													    <label>
													      <input type="checkbox" id="cambiarSoftwareCbox"> Cambiar software
													    </label>
													  </div>
														</div>									
													</div>  

													<div class="row">
														
																<div class="col-md-5 col-md-offset-1 ">
															  <div class="checkbox">
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
											<br>
							  		<button type="submit" id="btnGuardar" class="btn btn-default" >Guardar</button>
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
		mtdModulo.Iniciar();
		mtdModulo.cargarCatalogoPublic(1);


			  	nucleo.cargarListaDespegableListasPublic('moduloPerteneceListD','mtn_modulo','');


				$('#moduloPerteneceListD').popover({
				    html: true, 
					placement: "right",
					content: function() {
				          return $('#procesandoDatosInput').html();
				        }
				});

			  	$('#moduloPerteneceListD').popover('show');

			    setTimeout(function(){ 

					  	$('#moduloPerteneceListD').popover('destroy');
					  	$('#moduloPerteneceListD').selectpicker('refresh');

			    }, 300);





</script>
