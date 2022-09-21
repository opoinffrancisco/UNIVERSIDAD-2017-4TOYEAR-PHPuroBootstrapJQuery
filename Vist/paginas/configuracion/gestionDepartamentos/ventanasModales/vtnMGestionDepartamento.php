<div style="overflow-y:auto;">	

		<!-- Panel de Ventana modal-->
		<div id="vtnDepartamento" class="panel panel-primary ventana-modal-panel-expandido ">
			<!-- Cabecera -->
			<div class="panel-heading">
				<h3 class="panel-title">
					Gestione el departamento
					<a href="javascript:;" id="ventana-modal-panel-cerrar" class="ventana-modal-panel-cerrar" style="" 
					onclick="ventanaModal.ocultarPulico('ventana-modal'),mtdDepartamento.restablecerFormPublic()">x</a>
				</h3> 
			</div> 
			<!-- Contenido/Formulario -->
			<div class="panel-body"> 
					<form id="form" method="POST" >
							<input type="text" id="datoControl" value="" style="display:none;"></input>
							<input type="text" id="datoControlId" value="" style="display:none;"></input>
							

							<div class="row">
							  <div class="col-md-6 col-md-offset-3">
   							      <label for="recurso">Nombre:</label>							  
							  	  	<div id="divNombreTxt" class="form-group">
								    	<input type="text" name="nombre" class="campo-clave campo-control form-control input-sm" id="nombreTxt" placeholder="Ingresar nombre" 
								  			onkeypress="nucleo.verificarDatosInputPublic(event,this,'divNombreTxt')"
								  			onkeyup="nucleo.verificarDatosPublic('cfg_departamento','nombre','nombreTxt','divNombreTxt')"
								    		data-cantmax="50" maxlength="50" data-cantmin="4" data-vexistencia="1" 
								    		data-sololetrayespacio="1" required="TRUE">
								  	</div>				  	
							  </div>
							</div>
						    <div class="row" style="display:block;">
								<div id="listas">
						    
								    <div class="col-md-6  col-md-offset-3" >
										<div class="form-group">
									    	<label for="recurso">Asignar cargos:</label>	

														<div>
															<button
																id="btnAgregarCargo" type="button" class="btn btn-default" 
																style=" width: 60%; margin-left: 20%; margin-right: 20%;"
																onclick="listas.agregarItemSelectPublic('vtnDepartamento','vtnCatalogoDatosDCargos','selectCargos','btnAgregarCargo','cargo','cfg_pn_cargo','nombre')" >
																Agregar cargo
															</button>
														</div>	
														<br>


											<div class="table table-hover " style="background-color:#fff; overflow-y: auto;height: 300px; ">
												<div id="vtnCatalogoDatosDCargos" class="catalogo-datos" style=""> 
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
															<select id="selectCargos" ></select>
														</div>

													</div> 
												</div> 
											</div>  
										</div>
									</div>
								</div>
							</div>	
						<hr>
							<div class="row">
								<div class="col-md-2 col-md-offset-10">
							  		<button type="button" id="btnGuardar" class="btn btn-default" >Guardar</button>
							  	</div>
						  	</div>	
					</form>
				<?php 

					include '../../../../secciones/dialogo/procesandoDatos.php';

				?>
			</div>				
		</div>

</div>

<!-- carga de complementos catalogo/ventana modal relacionados // Estos complementos deben de ser los ultimos en cargar-->
<script type="text/javascript">
		$(function () {
			mtdDepartamento.Iniciar();
		});
</script>
